<?php

/**
 * @file
 * Contains \Drupal\niit_common\EventSubscriber\AddHTTPHeaders.
 */

namespace Drupal\niit_common\EventSubscriber;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Provides AddHTTPHeaders.
 */
class AddHTTPHeaders implements EventSubscriberInterface {
  /**
   * Sets extra HTTP headers.
   */
  public function onRespond(FilterResponseEvent $event) {
    if (!$event->isMasterRequest()) {
      return;
    }
    $response = $event->getResponse();

    $response->headers->set('Strict-Transport-Security', 'max-age=31536000');
    $response->headers->set('X-XSS-Protection', '1; mode=block');
    $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
    // $response->headers->set('Feature-Policy', 'geolocation *; midi *; notifications *; push *; sync-xhr *; microphone *; camera *; magnetometer *; gyroscope *; speaker *; vibrate *; fullscreen *; payment *;');
    // $response->headers->set('Server', '');
    // $response->headers->set('X-Powered-By', '');
    
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = ['onRespond', 1000];
    return $events;
  }

}

