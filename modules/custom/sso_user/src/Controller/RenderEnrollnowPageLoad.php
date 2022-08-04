<?php
namespace Drupal\sso_user\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Ajax\InvokeCommand; 
use Drupal\Core\Ajax\AppendCommand;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node; 
use Drupal\user\Entity\User;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormState;
use Drupal\taxonomy\Entity\Term;    
use Drupal\file\Entity\File;
/**
 * Defines EligibleMobileOTP class.
 */
class RenderEnrollnowPageLoad extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */

  public function EnrollnowFormUsingAjax($node_id) {
	  
	 $template_type = '';
	$variables['modular_enrollnow'] = "";
	$node = Node::load($node_id);
	$template_type = $node->field_select_template->value;
	   if($template_type == 'course_wipro'){
      $template_type = 'course_nokia';
    }
	  $url = '';
        if($node->hasField('field_proceed_button_link')){
          if(!empty($node->get('field_proceed_button_link')->getValue()[0]['value'])){
            $url=$node->get('field_proceed_button_link')->getValue()[0]['value'];
          }
        }
		
		
    if($template_type == 'course_new_modular' || $template_type == 'course_nokia'){
          $node_id = $node->id();
          $courseNodeData = Node::load($node_id);

          $course_delivery_mode_code = !empty($courseNodeData->field_delivery_mode_code->value)?$courseNodeData->field_delivery_mode_code->value:'';
          $course_code = !empty($courseNodeData->field_course_code->value)?$courseNodeData->field_course_code->value:'';
          $batchIdWith = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($course_delivery_mode_code,$course_code);
          $firstbatchdetails = $batchIdWith['courseBatchDetail'][0];

          $campaignCode = $node->get('field_campaign_code')->getValue()[0]['value'];

          //echo '<pre>'; print_r($firstbatchdetails); die();

          $maincoursebatchfee = $batchIdWith['CenterBatchFee'];
          $batchStartTime = $firstbatchdetails['BatchDD'].' '.$firstbatchdetails['BatchMM'];
          $batchTimings = $firstbatchdetails['batchTimings'];

          $variables['maincoursebasefeecheck'] = $variables['maincoursebasefee'] = '';
          if(!empty($batchIdWith['centerBaseFee'])){
          	$variables['maincoursebasefeecheck'] = $batchIdWith['centerBaseFee'];
            $variables['maincoursebasefee'] = courseFeeNumberToCurrencyConvert($batchIdWith['centerBaseFee']);
          }

          $variables['maincoursebatchfee'] = courseFeeNumberToCurrencyConvert($maincoursebatchfee);
          $variables['CoursebatchStartTime'] = $batchStartTime;
          $variables['CoursebatchTimings'] = $batchTimings;

          $variables['requestACallBackFormBtnMob'] = '<a class="career-btnrequest" data-toggle="modal" data-target="#RequestACallBackForm"><i class="fa fa-phone"></i> Call back</a>'; 
          $variables['requestACallBackFormBtn'] = '<a data-toggle="modal" data-target="#RequestACallBackForm"><u>Talk to our expert</u></a>';

          $variables['stillquery_connectwithus'] = '<span class="btn btn-primary btnApply" data-toggle="modal" data-target="#RequestACallBackForm">Connect with us</span>'; 

          $requestACallBackForm = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\TalkToOurExpertForm', $node_id);
          $requestACallBackFormModal ='<div id="RequestACallBackForm" class="modal fade" role="dialog">
          <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content msg-succ">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><center>Talk To Our Expert</center></h4>
                  
                </div>
                <div class="modal-body">
                    '.render($requestACallBackForm).'
                </div>
              </div>
            </div>
          </div>';

          $variables['requestACallBackForm'] = $requestACallBackFormModal;
 
          $site_current_url = "https://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

          //Login user start
          if(!empty(\Drupal::currentUser()->id())){

            $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
            $currentUserid = $user->id();
            if(!empty($user->get('field_communication_emailid')->value)){
              $userMail = $user->get('field_communication_emailid')->value;
            }
            else{
              $userMail = $user->get('mail')->value;
            }
            $userName = $user->get('field_user_name')->value;
            $userCustomerId = $user->get('field_customer_id')->value;
            $userMobileNo = $user->get('field_mobile_number')->value;

            $formdata = [
            	"CustomerID" => $userCustomerId,
    			    "CourseCode" => $firstbatchdetails['courseCode'],
    			    "BatchID" => $firstbatchdetails['batchID'],
    			    "Centercode" => $firstbatchdetails['SRC_ICD'],
    			    "Fee_Pttrn_Code" => $firstbatchdetails['patternCode'],
    			    "Fee_Value" => $firstbatchdetails['batchFees'],
            ];

            $token = Enrollment_SaveUserProductInfo($formdata);

            if(!empty($token)){
              $continue_btn_form = '<form id="" name="form" method="post" action="'.$url.'" >
                <input type="hidden" name="pCourseCode" value="'.$firstbatchdetails['courseCode'].'">
                <input type="hidden" name="pModalId" value="'.$firstbatchdetails['batchType'].'">
                <input type="hidden" name="pcollectionPlanId" value="'.$firstbatchdetails['patternCode'].'">
                <input type="hidden" name="pbatchId" value="'.$firstbatchdetails['batchID'].'">
                <input type="hidden" name="pSrcId" value="'.$firstbatchdetails['SRC_ICD'].'">
                <input type="hidden" name="pDstId" value="'.$firstbatchdetails['DST_ICD'].'">
                <input type="hidden" name="pisUserLoggedIn" value="N">
                <input type="hidden" name="pBatchTimings" value="'.$firstbatchdetails['batchTimings'].'">
                <input type="hidden" name="pBatchStartDate" value="'.$firstbatchdetails['batchStartDate'].'">
                <input type="hidden" name="pBatchEndDate" value="'.$firstbatchdetails['batchEndDate'].'">
                <input type="hidden" name="pFee" value="'.$firstbatchdetails['batchFees'].'">
                <input type="hidden" name="CourseId" value="'.$firstbatchdetails['courseID'].'">
                <input type="hidden" name="CourseVersion" value="1">
                <input type="hidden" name="CategoryName" value="Digital Marketing">
                <input type="hidden" name="SeoUrl" value="web-apps-development-courses-online/web-apps-development-using-node-js">
                <input type="hidden" name="pcheckEnroll" value="ENROLL">
                <input type="hidden" name="bthcurrencyCode" value="'.$firstbatchdetails['currencyCode'].'">
                <input type="hidden" name="bthSymbolType" value="'.$firstbatchdetails['SymbolType'].'">
                <input type="hidden" name="bthSymbolValue" value="'.$firstbatchdetails['SymbolValue'].'">
                <input type="hidden" name="Minimum_Denomination" value="'.$firstbatchdetails['Minimum_Denomination'].'">
                <input type="hidden" name="Minimum_Denomination_Value" value="'.$firstbatchdetails['Minimum_Denomination_Value'].'">
                <input type="hidden" name="IsTax_IncludeIN_Collection" value="'.$firstbatchdetails['IsTax_IncludeIN_Collection'].'">
                <input type="hidden" name="SourcePlatformName" value="NIITCOM">
                <input type="hidden" name="RequestName" value="Enrollment">
                <input type="hidden" name="eventdata" value="">
                <input type="hidden" name="NIITCourseURL" value="'.$site_current_url.'">
                <input type="hidden" name="Token" value="'.$token.'" id="ecomtoken_modular">
                <input type="hidden" name="CustomerID" value="'.$userCustomerId.'" id="CustomerId_modular">
                <input type="hidden" name="Campaign_Code" value="'.$campaignCode.'" tabindex="0">
                <input type="hidden" name="Course_Type" value="'.$course_delivery_mode_code.'" tabindex="0">
                <input type="submit" value="Enroll Now" class="btn btn-primary btnApply enroll-modular con-moduler-enrollnow">
                </form>';

              $variables['modular_enrollnow'] = '<span class="btn btn-primary btnApply" onclick="EnrollSubmitPreForm()">Enroll Now</span><div class="not_display_continue">'.$continue_btn_form.'</div>';

            }
            else{
              $variables['modular_enrollnow'] = '<span class="btn btn-primary btnApply" disabled>Enroll Now</span>';

            }

            if($template_type == 'course_nokia'){

              $finalResult = application_form_status($campaignCode, $course_code, $currentUserid, 'current_user');
              $final_json_send = '';
              if($finalResult['applctn_opn'] == 'Y'){
                $final_json = (array) $finalResult['json_data'];
                $update_data = array(
                  'source' => 'NIITCOM',
                  'CustomerId' => $userCustomerId,
                  'RequestedURL'=> '',
                  'NewSignup' => 'true',
                  'TYPE' => 'I',
                  'orgid' => 1,
                  'CourseId' => $firstbatchdetails['courseID'],
                  'BatchId' => $firstbatchdetails['batchID'],
                  'enroll_link' => $url,
                  'enqry_crsspndnc_eml' => $userMail,
                  'create_application' => 1,
                  'campaign' => $campaignCode,
                );
                $new_json = array_merge($final_json, $update_data);
                $final_json_send = create_application($new_json);

                $variables['nokia_enrollnow'] = '<span class="btn btn-primary btnApply" onclick="EnrollSubmitPreForm()">Enroll Now</span><div class="not_display_continue"><form id="" name="form" method="post" action="'.$url.'" class="nokiaEnrollnow">
                <input type="hidden" name="eventdata" value="">
                <input type="hidden" name="token" value="'.$final_json_send.'" tabindex="0" id="ecomtoken_modular">
                <input type="submit" value="Enroll Now" class="btn btn-primary btnApply enroll-modular con-moduler-enrollnow">
                </form></div>';    
              }
              else{

                $variables['nokia_enrollnow'] = '<span class="btn btn-primary btnApply" onclick="leadtokencreate('.$currentUserid.', '.$node_id.')">Enroll Now</span><div class="not_display_continue"><form id="" name="form" method="post" action="'.$url.'" class="nokiaEnrollnow">
                <input type="hidden" name="eventdata" value="">
                <input type="hidden" name="token" value="'.$final_json_send.'" tabindex="0" id="ecomtoken_modular">
                <input type="submit" value="Enroll Now" class="btn btn-primary btnApply enroll-modular con-moduler-enrollnow">
                </form></div>';    

              }

              

            }    

          }
          // Login user end
          else{

            if(!empty($firstbatchdetails['batchFees'])){

              $continue_btn_form = '<form id="" name="form" method="post" action="'.$url.'" >
                <input type="hidden" name="pCourseCode" value="'.$firstbatchdetails['courseCode'].'">
                <input type="hidden" name="pModalId" value="'.$firstbatchdetails['batchType'].'">
                <input type="hidden" name="pcollectionPlanId" value="'.$firstbatchdetails['patternCode'].'">
                <input type="hidden" name="pbatchId" value="'.$firstbatchdetails['batchID'].'">
                <input type="hidden" name="pSrcId" value="'.$firstbatchdetails['SRC_ICD'].'">
                <input type="hidden" name="pDstId" value="'.$firstbatchdetails['DST_ICD'].'">
                <input type="hidden" name="pisUserLoggedIn" value="N">
                <input type="hidden" name="pBatchTimings" value="'.$firstbatchdetails['batchTimings'].'">
                <input type="hidden" name="pBatchStartDate" value="'.$firstbatchdetails['batchStartDate'].'">
                <input type="hidden" name="pBatchEndDate" value="'.$firstbatchdetails['batchEndDate'].'">
                <input type="hidden" name="pFee" value="'.$firstbatchdetails['batchFees'].'">
                <input type="hidden" name="CourseId" value="'.$firstbatchdetails['courseID'].'">
                <input type="hidden" name="CourseVersion" value="1">
                <input type="hidden" name="CategoryName" value="Digital Marketing">
                <input type="hidden" name="SeoUrl" value="web-apps-development-courses-online/web-apps-development-using-node-js">
                <input type="hidden" name="pcheckEnroll" value="ENROLL">
                <input type="hidden" name="bthcurrencyCode" value="'.$firstbatchdetails['currencyCode'].'">
                <input type="hidden" name="bthSymbolType" value="'.$firstbatchdetails['SymbolType'].'">
                <input type="hidden" name="bthSymbolValue" value="'.$firstbatchdetails['SymbolValue'].'">
                <input type="hidden" name="Minimum_Denomination" value="'.$firstbatchdetails['Minimum_Denomination'].'">
                <input type="hidden" name="Minimum_Denomination_Value" value="'.$firstbatchdetails['Minimum_Denomination_Value'].'">
                <input type="hidden" name="IsTax_IncludeIN_Collection" value="'.$firstbatchdetails['IsTax_IncludeIN_Collection'].'">
                <input type="hidden" name="SourcePlatformName" value="NIITCOM">
                <input type="hidden" name="RequestName" value="Enrollment">
                <input type="hidden" name="eventdata" value="">
                <input type="hidden" name="NIITCourseURL" value="'.$site_current_url.'">
                <input type="hidden" name="CustomerID" value="" id="CustomerId_modular">
                <input type="hidden" name="Token" value="" id="ecomtoken_modular">
                <input type="hidden" name="Campaign_Code" value="'.$campaignCode.'" tabindex="0">
                <input type="hidden" name="Course_Type" value="'.$course_delivery_mode_code.'" tabindex="0">
                <input type="submit" value="Enroll Now" class="con-moduler-enrollnow">
                </form>';

              $user_login_form_btn = '<span class="btn btn-primary btnApply" onclick="modularpage_check()">Enroll Now</span><div class="not_display_continue">'.$continue_btn_form.'</div>';
              $variables['modular_enrollnow']=$user_login_form_btn; 

              $variables['nokia_enrollnow'] = '<span class="btn btn-primary btnApply" onclick="modularpage_check()">Enroll Now</span><div class="not_display_continue"><form id="" name="form" method="post" action="'.$url.'" class="nokiaEnrollnow">
              <input type="hidden" name="eventdata" value="">
              <input type="hidden" name="token" value="" tabindex="0" id="ecomtoken_modular">
              <input type="submit" value="Enroll Now" class="btn btn-primary btnApply enroll-modular con-moduler-enrollnow">
              </form></div>';  

            }
            else{
              $variables['modular_enrollnow'] = '<span class="btn btn-primary btnApply" disabled>Enroll Now</span>';

              $variables['nokia_enrollnow'] = '<span class="btn btn-primary btnApply" disabled>Enroll Now</span>';

            }
            
          }

        }


  $form = $variables['modular_enrollnow'];
  //$form =\Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm');
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('.enrollnow-div', $form));
    return $ajax_response;
  }
  
  
  public function EnrollnowFormUsingAjaxNokia($node_id) {
	  
	 $template_type = '';
	$variables['modular_enrollnow'] = "";
	$node = Node::load($node_id);
	$template_type = $node->field_select_template->value;
	 if($template_type == 'course_wipro'){
      $template_type = 'course_nokia';
    }
	  $url = '';
        if($node->hasField('field_proceed_button_link')){
          if(!empty($node->get('field_proceed_button_link')->getValue()[0]['value'])){
            $url=$node->get('field_proceed_button_link')->getValue()[0]['value'];
          }
        }
		
		
    if($template_type == 'course_new_modular' || $template_type == 'course_nokia'){
          $node_id = $node->id();
          $courseNodeData = Node::load($node_id);

          $course_delivery_mode_code = !empty($courseNodeData->field_delivery_mode_code->value)?$courseNodeData->field_delivery_mode_code->value:'';
          $course_code = !empty($courseNodeData->field_course_code->value)?$courseNodeData->field_course_code->value:'';
          $batchIdWith = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($course_delivery_mode_code,$course_code);
          $firstbatchdetails = $batchIdWith['courseBatchDetail'][0];

          $campaignCode = $node->get('field_campaign_code')->getValue()[0]['value'];

          //echo '<pre>'; print_r($firstbatchdetails); die();

          $maincoursebatchfee = $batchIdWith['CenterBatchFee'];
          $batchStartTime = $firstbatchdetails['BatchDD'].' '.$firstbatchdetails['BatchMM'];
          $batchTimings = $firstbatchdetails['batchTimings'];

          $variables['maincoursebasefeecheck'] = $variables['maincoursebasefee'] = '';
          if(!empty($batchIdWith['centerBaseFee'])){
          	$variables['maincoursebasefeecheck'] = $batchIdWith['centerBaseFee'];
            $variables['maincoursebasefee'] = courseFeeNumberToCurrencyConvert($batchIdWith['centerBaseFee']);
          }

          $variables['maincoursebatchfee'] = courseFeeNumberToCurrencyConvert($maincoursebatchfee);
          $variables['CoursebatchStartTime'] = $batchStartTime;
          $variables['CoursebatchTimings'] = $batchTimings;

          $variables['requestACallBackFormBtnMob'] = '<a class="career-btnrequest" data-toggle="modal" data-target="#RequestACallBackForm"><i class="fa fa-phone"></i> Call back</a>'; 
          $variables['requestACallBackFormBtn'] = '<a data-toggle="modal" data-target="#RequestACallBackForm"><u>Talk to our expert</u></a>';

          $variables['stillquery_connectwithus'] = '<span class="btn btn-primary btnApply" data-toggle="modal" data-target="#RequestACallBackForm">Connect with us</span>'; 

          $requestACallBackForm = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\TalkToOurExpertForm', $node_id);
          $requestACallBackFormModal ='<div id="RequestACallBackForm" class="modal fade" role="dialog">
          <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content msg-succ">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><center>Talk To Our Expert</center></h4>
                  
                </div>
                <div class="modal-body">
                    '.render($requestACallBackForm).'
                </div>
              </div>
            </div>
          </div>';

          $variables['requestACallBackForm'] = $requestACallBackFormModal;
 
          $site_current_url = "https://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

          //Login user start
          if(!empty(\Drupal::currentUser()->id())){

            $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
            $currentUserid = $user->id();
            if(!empty($user->get('field_communication_emailid')->value)){
              $userMail = $user->get('field_communication_emailid')->value;
            }
            else{
              $userMail = $user->get('mail')->value;
            }
            $userName = $user->get('field_user_name')->value;
            $userCustomerId = $user->get('field_customer_id')->value;
            $userMobileNo = $user->get('field_mobile_number')->value;

            $formdata = [
            	"CustomerID" => $userCustomerId,
    			    "CourseCode" => $firstbatchdetails['courseCode'],
    			    "BatchID" => $firstbatchdetails['batchID'],
    			    "Centercode" => $firstbatchdetails['SRC_ICD'],
    			    "Fee_Pttrn_Code" => $firstbatchdetails['patternCode'],
    			    "Fee_Value" => $firstbatchdetails['batchFees'],
            ];

            $token = Enrollment_SaveUserProductInfo($formdata);

            if(!empty($token)){
              $continue_btn_form = '<form id="" name="form" method="post" action="'.$url.'" >
                <input type="hidden" name="pCourseCode" value="'.$firstbatchdetails['courseCode'].'">
                <input type="hidden" name="pModalId" value="'.$firstbatchdetails['batchType'].'">
                <input type="hidden" name="pcollectionPlanId" value="'.$firstbatchdetails['patternCode'].'">
                <input type="hidden" name="pbatchId" value="'.$firstbatchdetails['batchID'].'">
                <input type="hidden" name="pSrcId" value="'.$firstbatchdetails['SRC_ICD'].'">
                <input type="hidden" name="pDstId" value="'.$firstbatchdetails['DST_ICD'].'">
                <input type="hidden" name="pisUserLoggedIn" value="N">
                <input type="hidden" name="pBatchTimings" value="'.$firstbatchdetails['batchTimings'].'">
                <input type="hidden" name="pBatchStartDate" value="'.$firstbatchdetails['batchStartDate'].'">
                <input type="hidden" name="pBatchEndDate" value="'.$firstbatchdetails['batchEndDate'].'">
                <input type="hidden" name="pFee" value="'.$firstbatchdetails['batchFees'].'">
                <input type="hidden" name="CourseId" value="'.$firstbatchdetails['courseID'].'">
                <input type="hidden" name="CourseVersion" value="1">
                <input type="hidden" name="CategoryName" value="Digital Marketing">
                <input type="hidden" name="SeoUrl" value="web-apps-development-courses-online/web-apps-development-using-node-js">
                <input type="hidden" name="pcheckEnroll" value="ENROLL">
                <input type="hidden" name="bthcurrencyCode" value="'.$firstbatchdetails['currencyCode'].'">
                <input type="hidden" name="bthSymbolType" value="'.$firstbatchdetails['SymbolType'].'">
                <input type="hidden" name="bthSymbolValue" value="'.$firstbatchdetails['SymbolValue'].'">
                <input type="hidden" name="Minimum_Denomination" value="'.$firstbatchdetails['Minimum_Denomination'].'">
                <input type="hidden" name="Minimum_Denomination_Value" value="'.$firstbatchdetails['Minimum_Denomination_Value'].'">
                <input type="hidden" name="IsTax_IncludeIN_Collection" value="'.$firstbatchdetails['IsTax_IncludeIN_Collection'].'">
                <input type="hidden" name="SourcePlatformName" value="NIITCOM">
                <input type="hidden" name="RequestName" value="Enrollment">
                <input type="hidden" name="eventdata" value="">
                <input type="hidden" name="NIITCourseURL" value="'.$site_current_url.'">
                <input type="hidden" name="Token" value="'.$token.'" id="ecomtoken_modular">
                <input type="hidden" name="CustomerID" value="'.$userCustomerId.'" id="CustomerId_modular">
                <input type="hidden" name="Campaign_Code" value="'.$campaignCode.'" tabindex="0">
                <input type="hidden" name="Course_Type" value="'.$course_delivery_mode_code.'" tabindex="0">
                <input type="submit" value="Enroll Now" class="btn btn-primary btnApply enroll-modular con-moduler-enrollnow">
                </form>';

              $variables['modular_enrollnow'] = '<span class="btn btn-primary btnApply" onclick="EnrollSubmitPreForm()">Enroll Now</span><div class="not_display_continue">'.$continue_btn_form.'</div>';

            }
            else{
              $variables['modular_enrollnow'] = '<span class="btn btn-primary btnApply" disabled>Enroll Now</span>';

            }

            if($template_type == 'course_nokia'){

              $finalResult = application_form_status($campaignCode, $course_code, $currentUserid, 'current_user');
              $final_json_send = '';
              if($finalResult['applctn_opn'] == 'Y'){
                $final_json = (array) $finalResult['json_data'];
                $update_data = array(
                  'source' => 'NIITCOM',
                  'CustomerId' => $userCustomerId,
                  'RequestedURL'=> '',
                  'NewSignup' => 'true',
                  'TYPE' => 'I',
                  'orgid' => 1,
                  'CourseId' => $firstbatchdetails['courseID'],
                  'BatchId' => $firstbatchdetails['batchID'],
                  'enroll_link' => $url,
                  'enqry_crsspndnc_eml' => $userMail,
                  'create_application' => 1,
                  'campaign' => $campaignCode,
                );
                $new_json = array_merge($final_json, $update_data);
                $final_json_send = create_application($new_json);

                $variables['nokia_enrollnow'] = '<span class="btn btn-primary btnApply" onclick="EnrollSubmitPreForm()">Enroll Now</span><div class="not_display_continue"><form id="" name="form" method="post" action="'.$url.'" class="nokiaEnrollnow">
                <input type="hidden" name="eventdata" value="">
                <input type="hidden" name="token" value="'.$final_json_send.'" tabindex="0" id="ecomtoken_modular">
                <input type="submit" value="Enroll Now" class="btn btn-primary btnApply enroll-modular con-moduler-enrollnow">
                </form></div>';    
              }
              else{

                $variables['nokia_enrollnow'] = '<span class="btn btn-primary btnApply" onclick="leadtokencreate('.$currentUserid.', '.$node_id.')">Enroll Now</span><div class="not_display_continue"><form id="" name="form" method="post" action="'.$url.'" class="nokiaEnrollnow">
                <input type="hidden" name="eventdata" value="">
                <input type="hidden" name="token" value="'.$final_json_send.'" tabindex="0" id="ecomtoken_modular">
                <input type="submit" value="Enroll Now" class="btn btn-primary btnApply enroll-modular con-moduler-enrollnow">
                </form></div>';    

              }

              

            }    

          }
          // Login user end
          else{

            if(!empty($firstbatchdetails['batchFees'])){

              $continue_btn_form = '<form id="" name="form" method="post" action="'.$url.'" >
                <input type="hidden" name="pCourseCode" value="'.$firstbatchdetails['courseCode'].'">
                <input type="hidden" name="pModalId" value="'.$firstbatchdetails['batchType'].'">
                <input type="hidden" name="pcollectionPlanId" value="'.$firstbatchdetails['patternCode'].'">
                <input type="hidden" name="pbatchId" value="'.$firstbatchdetails['batchID'].'">
                <input type="hidden" name="pSrcId" value="'.$firstbatchdetails['SRC_ICD'].'">
                <input type="hidden" name="pDstId" value="'.$firstbatchdetails['DST_ICD'].'">
                <input type="hidden" name="pisUserLoggedIn" value="N">
                <input type="hidden" name="pBatchTimings" value="'.$firstbatchdetails['batchTimings'].'">
                <input type="hidden" name="pBatchStartDate" value="'.$firstbatchdetails['batchStartDate'].'">
                <input type="hidden" name="pBatchEndDate" value="'.$firstbatchdetails['batchEndDate'].'">
                <input type="hidden" name="pFee" value="'.$firstbatchdetails['batchFees'].'">
                <input type="hidden" name="CourseId" value="'.$firstbatchdetails['courseID'].'">
                <input type="hidden" name="CourseVersion" value="1">
                <input type="hidden" name="CategoryName" value="Digital Marketing">
                <input type="hidden" name="SeoUrl" value="web-apps-development-courses-online/web-apps-development-using-node-js">
                <input type="hidden" name="pcheckEnroll" value="ENROLL">
                <input type="hidden" name="bthcurrencyCode" value="'.$firstbatchdetails['currencyCode'].'">
                <input type="hidden" name="bthSymbolType" value="'.$firstbatchdetails['SymbolType'].'">
                <input type="hidden" name="bthSymbolValue" value="'.$firstbatchdetails['SymbolValue'].'">
                <input type="hidden" name="Minimum_Denomination" value="'.$firstbatchdetails['Minimum_Denomination'].'">
                <input type="hidden" name="Minimum_Denomination_Value" value="'.$firstbatchdetails['Minimum_Denomination_Value'].'">
                <input type="hidden" name="IsTax_IncludeIN_Collection" value="'.$firstbatchdetails['IsTax_IncludeIN_Collection'].'">
                <input type="hidden" name="SourcePlatformName" value="NIITCOM">
                <input type="hidden" name="RequestName" value="Enrollment">
                <input type="hidden" name="eventdata" value="">
                <input type="hidden" name="NIITCourseURL" value="'.$site_current_url.'">
                <input type="hidden" name="CustomerID" value="" id="CustomerId_modular">
                <input type="hidden" name="Token" value="" id="ecomtoken_modular">
                <input type="hidden" name="Campaign_Code" value="'.$campaignCode.'" tabindex="0">
                <input type="hidden" name="Course_Type" value="'.$course_delivery_mode_code.'" tabindex="0">
                <input type="submit" value="Enroll Now" class="con-moduler-enrollnow">
                </form>';

              $user_login_form_btn = '<span class="btn btn-primary btnApply" onclick="modularpage_check()">Enroll Now</span><div class="not_display_continue">'.$continue_btn_form.'</div>';
              $variables['modular_enrollnow']=$user_login_form_btn; 

              $variables['nokia_enrollnow'] = '<span class="btn btn-primary btnApply" onclick="modularpage_check()">Enroll Now</span><div class="not_display_continue"><form id="" name="form" method="post" action="'.$url.'" class="nokiaEnrollnow">
              <input type="hidden" name="eventdata" value="">
              <input type="hidden" name="token" value="" tabindex="0" id="ecomtoken_modular">
              <input type="submit" value="Enroll Now" class="btn btn-primary btnApply enroll-modular con-moduler-enrollnow">
              </form></div>'; 

              /** code for wipro page start **/
              if($node->field_select_template->value == 'course_wipro'){
                $variables['nokia_enrollnow'] = '
                <div class="wiproPageSuperSetSec mb-3">
                  <div class="input-group">
                    <input type="text" class="form-control wiproPageSuperSetbox" placeholder="Superset Id (provided by Wipro)" title="Superset Id (provided by Wipro)">
                    <span class="input-group-btn">
                      <button class="btn btn-success wiproPageVerifyBtn" type="button">Verify</button>
                    </span>
                  </div>
                  <div class="superset_id_msg"></div>
                </div>
                <div class="wiproPageSuperSetEnrollBtn"><span class="btn btn-primary btnApply" disabled>Enroll Now</span></div>
                <div class="not_display_continue"><form id="" name="form" method="post" action="'.$url.'" class="nokiaEnrollnow">
              <input type="hidden" name="eventdata" value="">
              <input type="hidden" name="token" value="" tabindex="0" id="ecomtoken_modular">
              <input type="submit" value="Enroll Now" class="btn btn-primary btnApply enroll-modular con-moduler-enrollnow">
              </form></div>';  
              }
              /** code for wipro page end **/

            }
            else{
              $variables['modular_enrollnow'] = '<span class="btn btn-primary btnApply" disabled>Enroll Now</span>';

              $variables['nokia_enrollnow'] = '<span class="btn btn-primary btnApply" disabled>Enroll Now</span>';

            }
            
          }

        }


  $form = $variables['nokia_enrollnow'];
  //$form =\Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm');
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('.enrollnow-div-nokia', $form));
    return $ajax_response;
  }
  
    
}





  

