<?php

namespace Drupal\ms_ajax_form_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Defines EligibleMobileOTP class.
 */
class EligibleMobileOTP extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */

  public function CallbackApi() {
    if($_POST['enableEmailOTP_Check'] == 1){
      $result = Check_EligibleMobileOTP($_POST);
      $data = 1;
    }else{
      $result = Check_EligibleMobileOTP($_POST);
      $rs = json_encode($result);
      $rs1 = '';

      $data = 0;
      if($result->ErrorYN == 'N'){

        if(isset($_POST['register']) && $_POST['register'] == 1 ){
           $data = 1;
        }
        else{
          $text = ' is the One Time Password(OTP) generated.';
          $UserServices = \Drupal::service('sso_user.user');
          $response = $UserServices->SendOTPSMSAPI($result, $text);
          
          $response = json_decode($response);
          $rs1 = $response;
          if($response->ErrorYN == 'N'){
             $data = 1;
          }
        }  
      }
    }
    


    $return = ['data' => $data];
    
    return new JsonResponse($return);
  }

}