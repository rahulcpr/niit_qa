<?php

namespace Drupal\ms_ajax_form_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Defines EligibleMobileOTPVerify class.
 */
class EligibleMobileOTPVerify extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */

  public function CallbackApi() {

    $result = Check_EligibleMobileOTPVerify($_POST);

    $data = 0;
    if($result->Message == 'Success'){
      $data = 1;
    }
    elseif($result->Message == 'OTPEXP'){
      $data = 2;
    }

    $return = ['data' => $data];
    
    return new JsonResponse($return);
  }

}