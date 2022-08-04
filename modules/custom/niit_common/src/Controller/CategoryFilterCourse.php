<?php

namespace Drupal\niit_common\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Defines CategoryFilterCourse class.
 */
class CategoryFilterCourse extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */

  public function CourseFilterData($Iama, $Looking, $Studying, $Nid) {
    ///print_r($Iama);
    //print_r($Looking);
    //print_r($Studying);
  
    //die('hello');
    if($Iama == 'Iama'){
      $Iama = '';
    }
    if($Looking == 'Looking'){
      $Looking = '';
    }
    if($Studying == 'Studying'){
      $Studying = '';
    }
    
    $data = NiitCourseCategoryDetails($Iama, $Looking, $Studying, $Nid);

    $return = ['data' => $data];
    
    return new JsonResponse($return);
}

}