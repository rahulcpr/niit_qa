<?php

namespace Drupal\webp_image;

use Drupal\image\Entity\ImageStyle;


/**
 * extend Drupal's Twig_Extension class
 */
class customTwigExtension extends \Twig_Extension {

  /**
   * {@inheritdoc}
   * Let Drupal know the name of your extension
   * must be unique name, string
   */
  public function getName() {
    return 'webp_image.customtwigextension';
  }


  /**
   * {@inheritdoc}
   * Return your custom twig function to Drupal
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('webp_image_get', [$this, 'webp_image_get']),
    ];
  }



  /**
   * Returns $_GET query parameter
   *
   * @param string $name
   *   name of the query parameter
   *
   * @return string
   *   value of the query parameter name
   */
  public function webp_image_get($imageURLoriginal) {
    //$wpfilename = ImageStyle::load('home_slider')->buildUrl($imageURLoriginal);
          $webpImage = \Drupal::service('webp.webp')->getWebpSrcset($imageURLoriginal);
         
            return $webpImage;
        
          
  }


}