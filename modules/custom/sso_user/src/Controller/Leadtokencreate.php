<?php

namespace Drupal\sso_user\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;

/**
 * Defines Leadtokencreate class.
 */
class Leadtokencreate extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */

  public function ControllerPage() {

    $currentUserid = $_POST['uid'];
    $user = \Drupal\user\Entity\User::load($currentUserid);
    if(!empty($user->get('field_communication_emailid')->value)){
      $userMail = $user->get('field_communication_emailid')->value;
    }
    else{
      $userMail = $user->get('mail')->value;
    }
    $userName = $user->get('field_user_name')->value;
    $userCustomerId = $user->get('field_customer_id')->value;
    $userMobileNo = $user->get('field_mobile_number')->value;

    $userdetils = userdetails_getbyemail($userMail);

    $node_id = $_POST['nid'];
    $courseNodeData = Node::load($node_id);
    $course_delivery_mode_code = !empty($courseNodeData->field_delivery_mode_code->value)?$courseNodeData->field_delivery_mode_code->value:'';
    $course_code = !empty($courseNodeData->field_course_code->value)?$courseNodeData->field_course_code->value:'';
    $batchIdWith = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($course_delivery_mode_code,$course_code);
    $firstbatchdetails = $batchIdWith['courseBatchDetail'][0];

    $campaignCode = $courseNodeData->get('field_campaign_code')->getValue()[0]['value'];

    $request_time = \Drupal::time()->getCurrentTime();

    $formdata_ID = array(
      'uid' => $userMobileNo.'_'.$request_time,
      'enqry_f_nm' => $userName,
      'enqry_crsspndnc_eml' => $userMail,
      'time' => $request_time,
    );
    $id = multistep_user_consentapi($formdata_ID);

    $leaddata = array();
    $leaddata = array(
      "orgntr_cd" => "NIIT",
      'source' => $campaignCode,
      'orgid' => 1,
      'enqry_f_nm' => $userName,
      'enqry_crsspndnc_mbl' => $userMobileNo,
      'enqry_crsspndnc_eml' => $userMail,
      'prfrd_cntr' => "ooooo",
      'prfrd_cntr_name' => 'NIIT',
      "intrstd_prgrm" => $course_code,
      'GDPR_CONSENTID' => $id,
      'enroll_link' => $url,
      'leaduniqueid' => $userMobileNo.'_'.$request_time,
      'campaign' => $campaignCode,
      'enqry_crsspndnc_cntry' => $userdetils->Country_Code,
      'enqry_crrspndnc_phnstdcd' => $userdetils->CountryCode,
      'enqry_prmnnt_cntry' => $userdetils->CountryName,
      'enqry_prmnnt_phnstdcd' => $userdetils->CountryCode,
      'leadformstg' => 'Started',
    );

    multistep_postapidate('I',$leaddata);
    $update_data = array(
      'source' => 'NIITCOM',
      'CustomerId' => $userCustomerId,
      'RequestedURL'=> '',
      'NewSignup' => 'true',
      'TYPE' => 'I',
      'CourseId' => $firstbatchdetails['courseID'],
      'BatchId' => $firstbatchdetails['batchID'],
      'create_application' => 1,
    );
    $new_json = array_merge($leaddata, $update_data);
    $final_json_send = create_application($new_json);

    $return = ['data' => $final_json_send];
    
    return new JsonResponse($return);
  }

}