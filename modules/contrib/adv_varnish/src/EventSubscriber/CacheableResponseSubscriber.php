<?php

namespace Drupal\adv_varnish\EventSubscriber;

use Drupal\adv_varnish\RequestHandler;
use Drupal\adv_varnish\CacheManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\adv_varnish\RequestHandlerInterface;
use Drupal\Core\Cache\CacheableResponseInterface;
use Drupal\Core\PageCache\RequestPolicyInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\PageCache\ResponsePolicyInterface;
use Drupal\Core\Cache\Context\CacheContextsManager;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Drupal\Core\EventSubscriber\FinishResponseSubscriber;

/**
 * Event subscriber class.
 */
class CacheableResponseSubscriber extends FinishResponseSubscriber {

  /**
   * A config factory for retrieving required config objects.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $advVarnishConfig;

  /**
   * Varnish request handler.
   *
   * @var \Drupal\adv_varnish\RequestHandlerInterface
   */
  protected $requestHandler;

  /**
   * The adv_varnish cookie manager.
   *
   * @var \Drupal\adv_varnish\CacheManagerInterface|\Drupal\Core\Cache\CacheTagsInvalidatorInterface
   */
  protected $cacheManager;

  /**
   * User account interface.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $account;

  /**
   * Whether to send cacheability headers for debugging purposes.
   *
   * @var bool
   */
  protected $debugCacheabilityHeaders;

  /**
   * Constructs a FinishResponseSubscriber object.
   *
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager object for retrieving the correct language code.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   A config factory for retrieving required config objects.
   * @param \Drupal\Core\PageCache\RequestPolicyInterface $request_policy
   *   A policy rule determining the cacheability of a request.
   * @param \Drupal\Core\PageCache\ResponsePolicyInterface $response_policy
   *   A policy rule determining the cacheability of a response.
   * @param \Drupal\Core\Cache\Context\CacheContextsManager $cache_contexts_manager
   *   The cache contexts manager service.
   * @param \Drupal\adv_varnish\RequestHandlerInterface $request_handler
   *   Varnish request handler.
   * @param \Drupal\adv_varnish\CacheManagerInterface $cache_manager
   *   Cache manager.
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The current account.
   * @param bool $http_response_debug_cacheability_headers
   *   (optional) Whether to send cacheability headers for debugging purposes.
   */
  public function __construct(LanguageManagerInterface $language_manager,
                              ConfigFactoryInterface $config_factory,
                              RequestPolicyInterface $request_policy,
                              ResponsePolicyInterface $response_policy,
                              CacheContextsManager $cache_contexts_manager,
                              RequestHandlerInterface $request_handler,
                              CacheManagerInterface $cache_manager,
                              AccountProxyInterface $account,
                              $http_response_debug_cacheability_headers = FALSE) {
    parent::__construct($language_manager,
      $config_factory,
      $request_policy,
      $response_policy,
      $cache_contexts_manager,
      $http_response_debug_cacheability_headers);
    $this->advVarnishConfig = $config_factory->get('adv_varnish.cache_settings');
    $this->cacheManager = $cache_manager;
    $this->requestHandler = $request_handler;
    $this->account = $account;
  }

  /**
   * Response event handler.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   Process Response.
   */
  public function onRespond(FilterResponseEvent $event) {
    if (!$event->isMasterRequest()) {
      return;
    }

    /** @var \Symfony\Component\HttpFoundation\Request $request */
    $request = $event->getRequest();
    /** @var \Symfony\Component\HttpFoundation\Response $response */
    $response = $event->getResponse();

    // We need to clear User blocks on POST submissions,
    // as it can update relevant user info.
    $this->cacheManager->purgeUserBlocks();

    // Set the Content-language header.
    $response->headers->set('Content-language', $this->languageManager->getCurrentLanguage()->getId());

    $is_cacheable = $this->cacheManager->cachingEnabled();

    // Add headers necessary to specify whether the response should be cached by
    // proxies and/or the browser.
    if ($is_cacheable && $response instanceof CacheableResponseInterface && $this->advVarnishConfig->get('available.enable_cache')) {
      // Set Cacheable response.
      $this->setResponseCacheable($response, $request);
      $this->requestHandler->handleResponseEvent($event);
    }
    else {
      // If either the policy forbids caching or the sites configuration does
      // not allow to add a max-age directive, then enforce a Cache-Control
      // header declaring the response as not cacheable.
      $this->setResponseNotCacheable($response, $request);
      $response->headers->set('X-Pass-Varnish', 'YES', FALSE);
      $response->headers->set(RequestHandler::HEADER_ADV_VARNISH_STATUS, 'Cache-disabled', FALSE);
    }
  }

}
