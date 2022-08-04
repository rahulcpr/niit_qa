<?php

namespace Drupal\sso_user\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomRedirects implements EventSubscriberInterface {

  public function checkForRedirection(GetResponseEvent $event) {

    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
    $path_array = explode('/', $uri_parts[0]);
  //   if(array_key_exists(2, $path_array) && $path_array[2] == 'search' && array_key_exists(3, $path_array) && $path_array[3] == 'content' && empty($_SERVER['HTTP_REFERER'])){
  //     $response = new RedirectResponse('/india/', 301);
  //     $event->setResponse($response);
  //   }elseif(array_key_exists(2, $path_array) && $path_array[2] == 'search' && array_key_exists(3, $path_array) && $path_array[3] == 'content' && !empty($_SERVER['HTTP_REFERER'])){
  //     $domain = $_ENV['DRUPAL_PROTOCOL_DOMAIN'];
  //     //$domain = 'http://niit.test/';

  //     $url1 = parse_url($_SERVER['HTTP_REFERER']);
  //     $url2 = parse_url($domain);

  //     if ($url1['scheme'] == $url2['scheme'] && $url1['host'] == $url2['host']){
        
  //     }
  //     else{
  //       $response = new RedirectResponse('/india/', 301);
  //       $event->setResponse($response);

  //     }
  //   }elseif(array_key_exists(2, $path_array) && (($path_array[2] == 'dataLayer_Event_Session_destroy') || ($path_array[2] == 'google_tag_event_datalayer_url') ) && !empty($_SERVER['HTTP_REFERER']) ){
  //     $domain = $_ENV['DRUPAL_PROTOCOL_DOMAIN'];
  //     //$domain = 'http://niit.test/';

  //     $url1 = parse_url($_SERVER['HTTP_REFERER']);
  //     $url2 = parse_url($domain);

  //     if ($url1['scheme'] == $url2['scheme'] && $url1['host'] == $url2['host']){
        
  //     }
  //     else{
  //       $response = new RedirectResponse('/india/', 301);
  //       $event->setResponse($response);

  //     }
  //   }elseif(array_key_exists(2, $path_array) && (($path_array[2] == 'dataLayer_Event_Session_destroy') || ($path_array[2] == 'google_tag_event_datalayer_url') ) && empty($_SERVER['HTTP_REFERER']) ){
  //     $response = new RedirectResponse('/india/', 301);
  //     $event->setResponse($response);

  //   }
  
    
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // 'checkForRedirection' is the name of our function
    $events[KernelEvents::REQUEST][] = array('checkForRedirection');
    return $events;
  }

}