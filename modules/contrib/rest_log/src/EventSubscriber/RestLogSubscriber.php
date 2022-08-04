<?php

namespace Drupal\rest_log\EventSubscriber;

use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\rest\ResourceResponse;
use Drupal\rest_log\Entity\RestLog;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Logs all rest responses/exceptions.
 */
class RestLogSubscriber implements EventSubscriberInterface {

  use StringTranslationTrait;

  /**
   * The exception if exists.
   *
   * @var \Throwable|null
   */
  protected $throwable;

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * Creates rest_log event subscriber.
   */
  public function __construct(CurrentRouteMatch $current_route_match) {
    $this->currentRouteMatch = $current_route_match;
  }

  /**
   * Check if requested path must be logged.
   *
   * @return bool
   *   True if request is REST.
   */
  protected function isRestPage(): bool {
    $route = $this->currentRouteMatch->getRouteObject();
    return $route && $route->hasDefault('_rest_resource_config');
  }

  /**
   * Log the REST response.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent|\Symfony\Component\HttpKernel\Event\ResponseEvent $event
   *   The response event.
   *
   * @return void
   */
  public function logResponse($event): void {
    if (!$this->isRestPage()) {
      return;
    }
    $request = $event->getRequest();
    $response = $event->getResponse();
    $headers = $request->headers->all();
    // Clean up headers which always an array.
    foreach ($headers as $headerKey => $header) {
      if (is_array($header) && count($header) === 1) {
        $headers[$headerKey] = $header[0];
      }
      // Remove authorization header since it's potential security issue.
      if (in_array(strtolower($headerKey), [
        'authorization',
        'php-auth-user',
        'php-auth-pw',
        'PHP_AUTH_PW',
        '_password',
      ])) {
        $headers[$headerKey] = '******';
      }
    }

    $responseBody = json_decode($response->getContent(), TRUE);
    if ($this->throwable) {
      $responseBody['Exception'] = $this->throwable->getMessage();
    }

    $responseLog = array_filter([
      'request_header' => print_r($headers, 1),
      'request_method' => $request->getMethod(),
      'request_payload' => $request->getContent(),
      'response_status' => $response->getStatusCode(),
      'response_body' => json_encode($responseBody),
      'request_uri' => $request->getUri(),
      'request_cookie' => !empty($request->cookies->all()) ? print_r($request->cookies->all(), 1) : '',
    ]);

    try {
      RestLog::create($responseLog)->save();
    }
    catch (EntityStorageException $exception) {
      watchdog_exception('rest_log', $exception);
    }
  }

  /**
   * On rest exception log the event and return clear message.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent|\Symfony\Component\HttpKernel\Event\ExceptionEvent $event
   *   The exception event.
   *
   * @return void
   */
  public function onException($event): void {
    if (!$this->isRestPage()) {
      return;
    }
    $this->throwable = $event->getThrowable();
    $errorResponse = [
      'status' => 'error',
      'message' => $this->t('System error, please contact the administrator'),
    ];
    $response = new ResourceResponse($errorResponse);
    $event->setResponse($response);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [];
    $events[KernelEvents::RESPONSE][] = ['logResponse'];
    $events[KernelEvents::EXCEPTION][] = ['onException', -254];
    return $events;
  }

}
