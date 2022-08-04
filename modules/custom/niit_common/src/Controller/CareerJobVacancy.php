<?php

namespace Drupal\niit_common\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Defines CareerJobVacancy class.
 */
class CareerJobVacancy extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */

  public function CareerJobVacancyInfo($CountryKey, $Categoryid, $Keyword, $jobtype) {
    /*print_r($CountryKey);
    print_r($Categoryid);
    print_r($Keyword);
    print_r($jobtype);
    die('hello');*/
    if($Keyword == 'Keyword'){
      $Keyword = '';
    }
    if($CountryKey == 'CountryKey'){
      $CountryKey = '';
    }
    if($Categoryid == 'Categoryid'){
      $Categoryid = '';
    }
    if($jobtype == 'jobtype'){
      $jobtype = '';
    }
    $data = NiitRecruitmentVacancyDetails($CountryKey, $Categoryid, $Keyword, $jobtype);

    $return = ['data' => $data];
    
    return new JsonResponse($return);
}


  public function CenterInfodetails() {
   $requestField = \Drupal::request()->request;
    $courseTypeId = $requestField->get('courseTypeId');
    $cityCode = $requestField->get('cityCode');
    if($cityCode == ''){
      $cityCode = 'all';
    }
    // print_r($courseTypeId); print_r($cityCode); 

    $data = NiitGetCenterInformationcourse($courseTypeId, $cityCode);
    //print_r($data); die();
   //$data = "DATAIS HERE";

    $return = ['data' => $data];
    //var_dump($return);
    return new JsonResponse($return);
  }
}