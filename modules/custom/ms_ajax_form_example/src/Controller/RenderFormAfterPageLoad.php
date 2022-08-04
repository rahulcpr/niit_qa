<?php
namespace Drupal\ms_ajax_form_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;

use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Url;
use \Symfony\Component\HttpFoundation\Response;

use Drupal\Core\Ajax\InvokeCommand; 

use Drupal\Core\Ajax\AppendCommand;



use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node; 
use Drupal\user\Entity\User;
/**
 * Defines EligibleMobileOTP class.
 */
class RenderFormAfterPageLoad extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */

  public function MultistepFormUsingAjax($nid) {
  
    // preprocess code start here
	//function ms_ajax_form_example_preprocess_page(&$variables) {

    //$node = \Drupal::routeMatch()->getParameter('node');
    //if ($node instanceof \Drupal\node\NodeInterface) {
	//$node = \Drupal\node\Entity\Node::load($node->id());
	$argnid = "";
	$argnid = $nid;
	if(!empty($argnid)){
    $node = \Drupal\node\Entity\Node::load($nid);
	} else {
	die('node id not found');
	}
    $nid = $node->id();
    $ContentTypeName = $node->bundle();
    $template_type = '';
    if($ContentTypeName == 'course'){
      $template_type = $node->field_select_template->value; 
      if($template_type == 'course_new_stack_route' || $template_type == 'course_stackathon' || $template_type == 'course_campaign_page_template' || $template_type == 'course_new_landing_page' || $template_type == 'course_program2022_page_template' || $template_type == 'course_icici_2022_template' || $template_type == 'course_landing2022_page_template'){
          $template_type = 'course_stack_route_ilt';
      }
    }
    elseif($ContentTypeName == 'course_landing_page'){
      $template_type = $node->field_select_course_landing_type->value; 
    }

    
    $create_application = '';
    if($node->hasField('field_is_application_process')){
      if(!empty($node->get('field_is_application_process')->getValue()[0]['value'])){
        $create_application=$node->get('field_is_application_process')->getValue()[0]['value'];
      }
    }

    $ga_cookie = '';
    if(!empty($_COOKIE['_ga'])){
      $cookie_all = explode('.', $_COOKIE['_ga']);
      $ga_cookie = $cookie_all[2].'.'.$cookie_all[3];
    }

    

    if($template_type == 'course_icici' || $template_type == 'course_stack_route_ilt' || $template_type == 'course_career' || $template_type == 'course_axis'|| $template_type == 'course_stack_route'){ 
     // if(!empty($create_application) && $create_application == 1){
      // start
      unset($_SESSION['form_step']);

      $campaignCode = $node->get('field_campaign_code')->getValue()[0]['value']; 
      $courseCode = $node->get('field_course_code')->getValue()[0]['value'];
      $CourseType = $node->get('field_delivery_mode_code')->getValue()[0]['value'];

      $url = '';
      if($node->hasField('field_proceed_button_link')){
        if(!empty($node->get('field_proceed_button_link')->getValue()[0]['value'])){
          $url=$node->get('field_proceed_button_link')->getValue()[0]['value'];
        }
      }

      //  $time = time();
      // \Drupal::logger('checked')->notice($time);

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

        // \Drupal::logger('check_loadtime')->notice('Before call application status');
        $finalResult = application_form_status($campaignCode, $courseCode, $currentUserid, 'current_user');
        // \Drupal::logger('check_loadtime')->notice('After call application status');
        if($finalResult['check_eligibility'] == 'Y'){

          if(!empty($create_application) && $create_application == 1){
            $course_id= '';
            $course_batch_id = '';
            $mainCoursedetails = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($CourseType , $courseCode);
            if(!empty($mainCoursedetails['courseBatchDetail'][0])){
              $course_id = $mainCoursedetails['courseBatchDetail'][0]['courseID'];
              $course_batch_id = $mainCoursedetails['courseBatchDetail'][0]['batchID'];
            }

            $final_json = (array) $finalResult['json_data'];
            $leadusername = $final_json['enqry_f_nm'];
           // $CUSTOMER_ID = $finalResult['CUSTOMER_ID'];
            $update_data = array(
              'source' => 'NIITCOM',
              'CustomerId' => $userCustomerId,
              'RequestedURL'=> '',
              'NewSignup' => 'true',
              'TYPE' => 'U',
              'orgid' => 1,
              'CourseId' => $course_id,
              'BatchId' => $course_batch_id,
              'enqry_crsspndnc_eml' => $userMail,
            );
            $new_json = array_merge($final_json, $update_data);
            $final_json_send = create_application($new_json);

          $continue_btn_form = '';
          $continue_msg = 'You are eligible for the program. Our program advisor will call you shortly.';
          if($finalResult['applctn_opn'] == 'Y'){
            $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
            $readUrl = "";
            if(!empty($reffer_array)){
              $query_string = explode('&', $reffer_array[1]);
              foreach($query_string as $val){
                if(strtolower($val) == 'read=y'){
                  $readUrl = "Y";
                }
              }
            }
            if ($readUrl == 'Y') {
              $autoRedirectScript = '<script>countiuneYourApplicationEventData();</script>';
            }else{
              $autoRedirectScript = '<script>countiuneYourApplicationEventDataForRedirectApplication();</script>';
            }  
            $continue_btn_form = '<form id="ContinueYourApplicationFormId" name="form" method="post" action="'.$url.'" class="ContinueYourApplicationForm">
            <input type="hidden" name="eventdata" value="">
            <input type="hidden" name="token" value="'.$final_json_send.'" tabindex="0">
            <input type="submit" value="Continue Your Application" class="btn btn-primary continue-btn">
            </form><div class="hideScript">
            '.$autoRedirectScript.'
            </div>';
            $continue_msg = 'You are eligible to apply for the programme.';
          }

            $continue_btn = '<div class="after_login_result check_eligibility_display embed-data">
                              <div class="continue-data">
                               <div class="col-md-12 emb-img">
                                <img src= "/india/themes/custom/nexus/assets/images/confirm-popup.png" class="img-responsive">
                               </div>       
                              <div class="col-md-12 emb-data">
                               <div class="congrats">Congratulations</div>
                                <div class="lead-name">'.$leadusername.'</div>
                                  <div class="lead-des">'.$continue_msg.'</div>
                                  <div class="continue-form">'.$continue_btn_form.'</div>
                              </div>
                            </div>
                            </div>';

            $variables['multistep_page_block_form']=$continue_btn;

            /* mob embded */
            $variables['mob_multistep_page_block_form']=$continue_btn;

            // Handle Yes condition

            $variables['mutlistep_apply_btn'] = '<div class="page-embed-form last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_request_call_btn'] = '<div class="page-embed-form req-last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_check_eligibility_btn'] = '<div class="page-embed-form last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_connectus_btn'] = '<div class="page-embed-form connect-last-signup">'.$continue_btn_form.'</div>';

          }
          else{

            $final_json = (array) $finalResult['json_data'];
            $leadusername = $final_json['enqry_f_nm'];

            $continue_btn_form = '';
            $continue_msg = 'You are eligible for the program. Our program advisor will call you shortly.';

            $continue_btn = '<div class="after_login_result check_eligibility_display embed-data">
                              <div class="row continue-data">
                               <div class="col-md-12 emb-img">
                                <img src= "/india/themes/custom/nexus/assets/images/confirm-popup.png" class="img-responsive">
                               </div>       
                              <div class=col-md-12 emb-data">
                               <div class="congrats">Congratulations</div>
                                <div class="lead-name">'.$leadusername.'</div>
                                  <div class="lead-des">'.$continue_msg.'</div>
                                  <div class="continue-form">'.$continue_btn_form.'</div>
                              </div>
                            </div>
                            </div>';

            $variables['multistep_page_block_form']=$continue_btn;

            /* mob embded */
            $variables['mob_multistep_page_block_form']=$continue_btn;


            $variables['mutlistep_apply_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Apply Now</span>';

            $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall grey-btn disabled" title="Our career advisor will connect"><i class="fa fa-phone"></i> Request a call back</button>';

            $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Check Eligibility</span>';

            $variables['mutlistep_connectus_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Connect with us</span>';

          }

        }
        elseif($finalResult['check_eligibility'] == 'N'){
           \Drupal::logger('checked1')->notice($time);
          $_SESSION['prev_three_display'] = 1;
          $status_data = [
            'current_step' => 2,
            'finalResult' => $finalResult,
          ];
          $_SESSION['form_step'] = 3;
          $_SESSION['finalResult'] = $finalResult;

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                //$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            }

          // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);

          $variables['multistep_page_block_form'] = $multistep_form;

          /* mob embded */
          $variables['mob_multistep_page_block_form'] = $multistep_form;


          $variables['mutlistep_apply_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Apply Now</span>';

          $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall grey-btn disabled"  title="You are not eligible for this program"><i class="fa fa-phone"></i> Request a call back</button>';

          $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Check Eligibility</span>';

          $variables['mutlistep_connectus_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Connect with us</span>';
        }
        else{
          unset($_SESSION['options']);
          $status_data = array();
          if(!empty($finalResult['leadformstg']) && $finalResult['leadformstg'] == '1a'){
            $_SESSION['form_step'] = 2;
            $status_data = [
              'current_step' => 2,
              'finalResult' => $finalResult,
            ];
          }

        $config = \Drupal::config('ms_ajax_form_example.settings');  
        $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
        if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
            $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
        }else{
			$showSimpleLeadForm = "";
			if($node->hasField('field_show_simple_lead_form')){
				if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
					$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
				}
			}
			if($showSimpleLeadForm == 1){
				$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
			}else{
				$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
			} 
            // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
        }
        // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);

          $variables['multistep_page_block_form']=$multistep_form;

          /* mob embded */

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }


          // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
          $variables['mob_multistep_page_block_form']=$multistep_form_emded;

          /**get in touch now */
          $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
            $get_in_touch_html='
            <div id="ms_ajax_popup_page_embed_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($embed_get_in_touch_form).'
                  </div>
                </div>
              </div>
            </div>';

          $variables['mob_multistep_page_embed_form']=$embed_get_in_touch_form;

          $variables['multistep_page_embed_form']=$get_in_touch_html;
          $variables['multistep_page_embed_form_btn'] =
              '<span class="cust-btnEnrolNow"><button type="button" 
              class="btn btn-danger career-btnEnrolNow" 
              data-toggle="modal" 
              data-target="#ms_ajax_popup_page_embed_Modal">Get In Touch</button></span>';


          /**enguire now */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data);
            }
              // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data);
              $enquire_now_html='
              <div id="ms_ajax_popup_page_enquire_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($enquire_now_form).'
                    </div>
                  </div>
                </div>
              </div>';
            
            $variables['multistep_popup_page_enquire_form']=$enquire_now_html;

            /**request a call back */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data, $nid);
				} 
                // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data);
            }
            // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data);
              $request_call_html='
              <div id="ms_ajax_popup_page_request_callback_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($request_callback_form).'
                    </div>
                  </div>
                </div>
              </div>';
              
              $variables['multistep_popup_page_callback_form']=$request_call_html;

              $variables['mutlistep_apply_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Apply Now</span>';

              $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall" onclick="popupicici_popup()"><i class="fa fa-phone"></i> Request a call back</button>';

              $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Check Eligibility</span>';

              $variables['mutlistep_connectus_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Connect with us</span>';
        }
      }
        
        else{
          unset($_SESSION['options']);
            $status_data = array();

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            }

            // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            $variables['multistep_page_block_form']=$multistep_form;

            /* mob embded */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }
            // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            $variables['mob_multistep_page_block_form']=$multistep_form_emded;

            /**get in touch now */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }
            // $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
              $get_in_touch_html='
              <div id="ms_ajax_popup_page_embed_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($embed_get_in_touch_form).'
                    </div>
                  </div>
                </div>
              </div>';

            $variables['mob_multistep_page_embed_form']=$embed_get_in_touch_form;

          $variables['multistep_page_embed_form']=$get_in_touch_html;
          $variables['multistep_page_embed_form_btn'] =
                '<span class="cust-btnEnrolNow"><button type="button" 
                class="btn btn-danger career-btnEnrolNow" 
                data-toggle="modal" 
                data-target="#ms_ajax_popup_page_embed_Modal">Get In Touch</button></span>';

           /**enguire now */
           $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data, $nid);
				} 
				// $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm');
            }
            // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm');
            $enquire_now_html='
            <div id="ms_ajax_popup_page_enquire_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($enquire_now_form).'
                  </div>
                </div>
              </div>
            </div>';
          
          $variables['multistep_popup_page_enquire_form']=$enquire_now_html;

          /**request a call back */
           $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data, $nid);
				} 
                // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm');
            }
          // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm');
            $request_call_html='
            <div id="ms_ajax_popup_page_request_callback_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($request_callback_form).'
                  </div>
                </div>
              </div>
            </div>';
            
            $variables['multistep_popup_page_callback_form']=$request_call_html;

            $variables['mutlistep_apply_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Apply Now</span>';

            $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall" onclick="popupicici_popup()"><i class="fa fa-phone"></i> Request a call back</button>';

            $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Check Eligibility</span>';

            $variables['mutlistep_connectus_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Connect with us</span>';
        }
        // End
    }
  //} commented dynamic node end
//} comment preprocess function end

	// preprocess code end here
	
	$form = $variables['multistep_page_block_form'];
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('#multi-div', $form));
    return $ajax_response;
  }
  /*** Multistep form popup start here
  */
  
    public function PopMultistepFormUsingAjax($nid) {
  
    // preprocess code start here
	//function ms_ajax_form_example_preprocess_page(&$variables) {

    //$node = \Drupal::routeMatch()->getParameter('node');
    //if ($node instanceof \Drupal\node\NodeInterface) {
	//$node = \Drupal\node\Entity\Node::load($node->id());
    $argnid = "";
	$argnid = $nid;
	if(!empty($argnid)){
    $node = \Drupal\node\Entity\Node::load($nid);
	} else {
	die('node id not found');
	}
    $nid = $node->id();
    $ContentTypeName = $node->bundle();
    $template_type = '';
    if($ContentTypeName == 'course'){
      $template_type = $node->field_select_template->value; 
      if($template_type == 'course_new_stack_route' || $template_type == 'course_stackathon' || $template_type == 'course_campaign_page_template' || $template_type == 'course_new_landing_page' || $template_type == 'course_program2022_page_template' || $template_type == 'course_icici_2022_template' || $template_type == 'course_landing2022_page_template'){
          $template_type = 'course_stack_route_ilt';
      }
    }
    elseif($ContentTypeName == 'course_landing_page'){
      $template_type = $node->field_select_course_landing_type->value; 
    }

    
    $create_application = '';
    if($node->hasField('field_is_application_process')){
      if(!empty($node->get('field_is_application_process')->getValue()[0]['value'])){
        $create_application=$node->get('field_is_application_process')->getValue()[0]['value'];
      }
    }

    $ga_cookie = '';
    if(!empty($_COOKIE['_ga'])){
      $cookie_all = explode('.', $_COOKIE['_ga']);
      $ga_cookie = $cookie_all[2].'.'.$cookie_all[3];
    }

    

    if($template_type == 'course_icici' || $template_type == 'course_stack_route_ilt' || $template_type == 'course_career' || $template_type == 'course_axis'|| $template_type == 'course_stack_route'){ 
     // if(!empty($create_application) && $create_application == 1){
      // start
      unset($_SESSION['form_step']);

      $campaignCode = $node->get('field_campaign_code')->getValue()[0]['value']; 
      $courseCode = $node->get('field_course_code')->getValue()[0]['value'];
      $CourseType = $node->get('field_delivery_mode_code')->getValue()[0]['value'];

      $url = '';
      if($node->hasField('field_proceed_button_link')){
        if(!empty($node->get('field_proceed_button_link')->getValue()[0]['value'])){
          $url=$node->get('field_proceed_button_link')->getValue()[0]['value'];
        }
      }

      //  $time = time();
      // \Drupal::logger('checked')->notice($time);

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

        // \Drupal::logger('check_loadtime')->notice('Before call application status');
        $finalResult = application_form_status($campaignCode, $courseCode, $currentUserid, 'current_user');
        // \Drupal::logger('check_loadtime')->notice('After call application status');
        if($finalResult['check_eligibility'] == 'Y'){

          if(!empty($create_application) && $create_application == 1){
            $course_id= '';
            $course_batch_id = '';
            $mainCoursedetails = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($CourseType , $courseCode);
            if(!empty($mainCoursedetails['courseBatchDetail'][0])){
              $course_id = $mainCoursedetails['courseBatchDetail'][0]['courseID'];
              $course_batch_id = $mainCoursedetails['courseBatchDetail'][0]['batchID'];
            }

            $final_json = (array) $finalResult['json_data'];
            $leadusername = $final_json['enqry_f_nm'];
           // $CUSTOMER_ID = $finalResult['CUSTOMER_ID'];
            $update_data = array(
              'source' => 'NIITCOM',
              'CustomerId' => $userCustomerId,
              'RequestedURL'=> '',
              'NewSignup' => 'true',
              'TYPE' => 'U',
              'orgid' => 1,
              'CourseId' => $course_id,
              'BatchId' => $course_batch_id,
              'enqry_crsspndnc_eml' => $userMail,
            );
            $new_json = array_merge($final_json, $update_data);
            $final_json_send = create_application($new_json);

          $continue_btn_form = '';
          $continue_msg = 'You are eligible for the program. Our program advisor will call you shortly.';
          if($finalResult['applctn_opn'] == 'Y'){
      		  $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
            $readUrl = "";
            if(!empty($reffer_array)){
              $query_string = explode('&', $reffer_array[1]);
              foreach($query_string as $val){
                if(strtolower($val) == 'read=y'){
                  $readUrl = "Y";
                }
              }
            }
            if ($readUrl == 'Y') {
              $autoRedirectScript = '<script>countiuneYourApplicationEventData();</script>';
            }else{
              $autoRedirectScript = '<script>countiuneYourApplicationEventDataForRedirectApplication();</script>';
            }
            $continue_btn_form = '<form id="ContinueYourApplicationFormId" name="form" method="post" action="'.$url.'" class="ContinueYourApplicationForm">
            <input type="hidden" name="eventdata" value="">
            <input type="hidden" name="token" value="'.$final_json_send.'" tabindex="0">
            <input type="submit" value="Continue Your Application" class="btn btn-primary continue-btn">
            </form><div class="hideScript">
            '.$autoRedirectScript.'
            </div>';
            $continue_msg = 'You are eligible to apply for the programme.';
          }

            $continue_btn = '<div class="after_login_result check_eligibility_display embed-data">
                              <div class="continue-data">
                               <div class="col-md-12 emb-img">
                                <img src= "/india/themes/custom/nexus/assets/images/confirm-popup.png" class="img-responsive">
                               </div>       
                              <div class="col-md-12 emb-data">
                               <div class="congrats">Congratulations</div>
                                <div class="lead-name">'.$leadusername.'</div>
                                  <div class="lead-des">'.$continue_msg.'</div>
                                  <div class="continue-form">'.$continue_btn_form.'</div>
                              </div>
                            </div>
                            </div>';

            $variables['multistep_page_block_form']=$continue_btn;

            /* mob embded */
            $variables['mob_multistep_page_block_form']=$continue_btn;

            // Handle Yes condition

            $variables['mutlistep_apply_btn'] = '<div class="page-embed-form last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_request_call_btn'] = '<div class="page-embed-form req-last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_check_eligibility_btn'] = '<div class="page-embed-form last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_connectus_btn'] = '<div class="page-embed-form connect-last-signup">'.$continue_btn_form.'</div>';
            
            $variables['multistep_popup_page_enquire_form'] = '
              <div id="ms_ajax_popup_page_enquire_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.$continue_btn.'
                    </div>
                  </div>
                </div>
              </div>';

          }
          else{

            $final_json = (array) $finalResult['json_data'];
            $leadusername = $final_json['enqry_f_nm'];

            $continue_btn_form = '';
            $continue_msg = 'You are eligible for the program. Our program advisor will call you shortly.';

            $continue_btn = '<div class="after_login_result check_eligibility_display embed-data">
                              <div class="row continue-data">
                               <div class="col-md-12 emb-img">
                                <img src= "/india/themes/custom/nexus/assets/images/confirm-popup.png" class="img-responsive">
                               </div>       
                              <div class=col-md-12 emb-data">
                               <div class="congrats">Congratulations</div>
                                <div class="lead-name">'.$leadusername.'</div>
                                  <div class="lead-des">'.$continue_msg.'</div>
                                  <div class="continue-form">'.$continue_btn_form.'</div>
                              </div>
                            </div>
                            </div>';

            $variables['multistep_page_block_form']=$continue_btn;

            /* mob embded */
            $variables['mob_multistep_page_block_form']=$continue_btn;


            $variables['mutlistep_apply_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Apply Now</span>';

            $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall grey-btn disabled" title="Our career advisor will connect"><i class="fa fa-phone"></i> Request a call back</button>';

            $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Check Eligibility</span>';

            $variables['mutlistep_connectus_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Connect with us</span>';

            $variables['multistep_popup_page_enquire_form'] = '
              <div id="ms_ajax_popup_page_enquire_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.$continue_btn.'
                    </div>
                  </div>
                </div>
              </div>';
          }

        }
        elseif($finalResult['check_eligibility'] == 'N'){
           \Drupal::logger('checked1')->notice($time);
          $_SESSION['prev_three_display'] = 1;
          $status_data = [
            'current_step' => 2,
            'finalResult' => $finalResult,
          ];
          $_SESSION['form_step'] = 3;
          $_SESSION['finalResult'] = $finalResult;

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                //$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            }

          // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);

          $variables['multistep_page_block_form'] = $multistep_form;

          /* mob embded */
          $variables['mob_multistep_page_block_form'] = $multistep_form;


          $variables['mutlistep_apply_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Apply Now</span>';

          $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall grey-btn disabled"  title="You are not eligible for this program"><i class="fa fa-phone"></i> Request a call back</button>';

          $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Check Eligibility</span>';

          $variables['mutlistep_connectus_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Connect with us</span>';
          
          $variables['multistep_popup_page_enquire_form'] = '
              <div id="ms_ajax_popup_page_enquire_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($multistep_form).'
                    </div>
                  </div>
                </div>
              </div>';
        }
        else{
          unset($_SESSION['options']);
          $status_data = array();
          if(!empty($finalResult['leadformstg']) && $finalResult['leadformstg'] == '1a'){
            $_SESSION['form_step'] = 2;
            $status_data = [
              'current_step' => 2,
              'finalResult' => $finalResult,
            ];
          }

        $config = \Drupal::config('ms_ajax_form_example.settings');  
        $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
        if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
            $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
        }else{
			$showSimpleLeadForm = "";
			if($node->hasField('field_show_simple_lead_form')){
				if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
					$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
				}
			}
			if($showSimpleLeadForm == 1){
				$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
			}else{
				$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
			} 
            // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
        }
        // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);

          $variables['multistep_page_block_form']=$multistep_form;

          /* mob embded */

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }


          // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
          $variables['mob_multistep_page_block_form']=$multistep_form_emded;

          /**get in touch now */
          $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
            $get_in_touch_html='
            <div id="ms_ajax_popup_page_embed_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($embed_get_in_touch_form).'
                  </div>
                </div>
              </div>
            </div>';

          $variables['mob_multistep_page_embed_form']=$embed_get_in_touch_form;

          $variables['multistep_page_embed_form']=$get_in_touch_html;
          $variables['multistep_page_embed_form_btn'] =
              '<span class="cust-btnEnrolNow"><button type="button" 
              class="btn btn-danger career-btnEnrolNow" 
              data-toggle="modal" 
              data-target="#ms_ajax_popup_page_embed_Modal">Get In Touch</button></span>';


          /**enguire now */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data);
            }
              // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data);
              $enquire_now_html='
              <div id="ms_ajax_popup_page_enquire_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($enquire_now_form).'
                    </div>
                  </div>
                </div>
              </div>';
            
            $variables['multistep_popup_page_enquire_form']=$enquire_now_html;

            /**request a call back */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data, $nid);
				} 
                // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data);
            }
            // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data);
              $request_call_html='
              <div id="ms_ajax_popup_page_request_callback_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($request_callback_form).'
                    </div>
                  </div>
                </div>
              </div>';
              
              $variables['multistep_popup_page_callback_form']=$request_call_html;

              $variables['mutlistep_apply_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Apply Now7</span>';

              $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall" onclick="popupicici_popup()"><i class="fa fa-phone"></i> Request a call back</button>';

              $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Check Eligibility</span>';

              $variables['mutlistep_connectus_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Connect with us</span>';
        }
      }
        
        else{
          unset($_SESSION['options']);
            $status_data = array();

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            }

            // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            $variables['multistep_page_block_form']=$multistep_form;

            /* mob embded */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }
            // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            $variables['mob_multistep_page_block_form']=$multistep_form_emded;

            /**get in touch now */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }
            // $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
              $get_in_touch_html='
              <div id="ms_ajax_popup_page_embed_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($embed_get_in_touch_form).'
                    </div>
                  </div>
                </div>
              </div>';

            $variables['mob_multistep_page_embed_form']=$embed_get_in_touch_form;

          $variables['multistep_page_embed_form']=$get_in_touch_html;
          $variables['multistep_page_embed_form_btn'] =
                '<span class="cust-btnEnrolNow"><button type="button" 
                class="btn btn-danger career-btnEnrolNow" 
                data-toggle="modal" 
                data-target="#ms_ajax_popup_page_embed_Modal">Get In Touch</button></span>';

           /**enguire now */
           $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data, $nid);
				} 
				// $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm');
            }
            // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm');
            $enquire_now_html='
            <div id="ms_ajax_popup_page_enquire_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($enquire_now_form).'
                  </div>
                </div>
              </div>
            </div>';
          // calling popup gauri
          $variables['multistep_popup_page_enquire_form']=$enquire_now_html;

          /**request a call back */
           $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data, $nid);
				} 
                // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm');
            }
          // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm');
            $request_call_html='
            <div id="ms_ajax_popup_page_request_callback_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($request_callback_form).'
                  </div>
                </div>
              </div>
            </div>';
            
            $variables['multistep_popup_page_callback_form']=$request_call_html;

            $variables['mutlistep_apply_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Apply Now8</span>';

            $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall" onclick="popupicici_popup()"><i class="fa fa-phone"></i> Request a call back</button>';

            $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Check Eligibility</span>';

            $variables['mutlistep_connectus_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Connect with us</span>';
        }
        // End
    }
  //} commented dynamic node end
//} comment preprocess function end

	// preprocess code end here
	$form = $variables['multistep_popup_page_enquire_form'];
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('#popmulti-div', $form));
    return $ajax_response;
  }
  
  /*** Multistep popup end here
  */
  
  public function generateMultistepFormUsingAjax() {
	 
    //$node = \Drupal::routeMatch()->getParameter('node');
		//if ($node instanceof \Drupal\node\NodeInterface) {
		//$nid = $node->id();
		//}     
	$node1 = 3344;
	$form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node1);
	$ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('#my-div', $form));
    return $ajax_response;
  
  }
  
  public function MultistepApplyBtnAjax($nid) {
  
    // preprocess code start here
	//function ms_ajax_form_example_preprocess_page(&$variables) {

    //$node = \Drupal::routeMatch()->getParameter('node');
    //if ($node instanceof \Drupal\node\NodeInterface) {
	//$node = \Drupal\node\Entity\Node::load($node->id());
    $argnid = "";
	$argnid = $nid;
	if(!empty($argnid)){
    $node = \Drupal\node\Entity\Node::load($nid);
	} else {
	die('node id not found');
	}
    $nid = $node->id();
    $ContentTypeName = $node->bundle();
    $template_type = '';
    if($ContentTypeName == 'course'){
      $template_type = $node->field_select_template->value; 
      if($template_type == 'course_new_stack_route' || $template_type == 'course_stackathon' || $template_type == 'course_campaign_page_template' || $template_type == 'course_program2022_page_template'){
          $template_type = 'course_stack_route_ilt';
      }
    }
    elseif($ContentTypeName == 'course_landing_page'){
      $template_type = $node->field_select_course_landing_type->value; 
    }

    
    $create_application = '';
    if($node->hasField('field_is_application_process')){
      if(!empty($node->get('field_is_application_process')->getValue()[0]['value'])){
        $create_application=$node->get('field_is_application_process')->getValue()[0]['value'];
      }
    }

    $ga_cookie = '';
    if(!empty($_COOKIE['_ga'])){
      $cookie_all = explode('.', $_COOKIE['_ga']);
      $ga_cookie = $cookie_all[2].'.'.$cookie_all[3];
    }

    

    if($template_type == 'course_icici' || $template_type == 'course_stack_route_ilt' || $template_type == 'course_career' || $template_type == 'course_axis'|| $template_type == 'course_stack_route'){ 
     // if(!empty($create_application) && $create_application == 1){
      // start
      unset($_SESSION['form_step']);

      $campaignCode = $node->get('field_campaign_code')->getValue()[0]['value']; 
      $courseCode = $node->get('field_course_code')->getValue()[0]['value'];
      $CourseType = $node->get('field_delivery_mode_code')->getValue()[0]['value'];

      $url = '';
      if($node->hasField('field_proceed_button_link')){
        if(!empty($node->get('field_proceed_button_link')->getValue()[0]['value'])){
          $url=$node->get('field_proceed_button_link')->getValue()[0]['value'];
        }
      }

      //  $time = time();
      // \Drupal::logger('checked')->notice($time);

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

        // \Drupal::logger('check_loadtime')->notice('Before call application status');
        $finalResult = application_form_status($campaignCode, $courseCode, $currentUserid, 'current_user');
        // \Drupal::logger('check_loadtime')->notice('After call application status');
        if($finalResult['check_eligibility'] == 'Y'){

          if(!empty($create_application) && $create_application == 1){
            $course_id= '';
            $course_batch_id = '';
            $mainCoursedetails = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($CourseType , $courseCode);
            if(!empty($mainCoursedetails['courseBatchDetail'][0])){
              $course_id = $mainCoursedetails['courseBatchDetail'][0]['courseID'];
              $course_batch_id = $mainCoursedetails['courseBatchDetail'][0]['batchID'];
            }

            $final_json = (array) $finalResult['json_data'];
            $leadusername = $final_json['enqry_f_nm'];
           // $CUSTOMER_ID = $finalResult['CUSTOMER_ID'];
            $update_data = array(
              'source' => 'NIITCOM',
              'CustomerId' => $userCustomerId,
              'RequestedURL'=> '',
              'NewSignup' => 'true',
              'TYPE' => 'U',
              'orgid' => 1,
              'CourseId' => $course_id,
              'BatchId' => $course_batch_id,
              'enqry_crsspndnc_eml' => $userMail,
            );
            $new_json = array_merge($final_json, $update_data);
            $final_json_send = create_application($new_json);

          $continue_btn_form = '';
          $continue_msg = 'You are eligible for the program. Our program advisor will call you shortly.';
          if($finalResult['applctn_opn'] == 'Y'){
      		  $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
            $readUrl = "";
            if(!empty($reffer_array)){
              $query_string = explode('&', $reffer_array[1]);
              foreach($query_string as $val){
                if(strtolower($val) == 'read=y'){
                  $readUrl = "Y";
                }
              }
            }
            if ($readUrl == 'Y') {
              $autoRedirectScript = '<script>countiuneYourApplicationEventData();</script>';
            }else{
              $autoRedirectScript = '<script>countiuneYourApplicationEventDataForRedirectApplication();</script>';
            }
            $continue_btn_form = '<form id="ContinueYourApplicationFormId" name="form" method="post" action="'.$url.'" class="ContinueYourApplicationForm">
            <input type="hidden" name="eventdata" value="">
            <input type="hidden" name="token" value="'.$final_json_send.'" tabindex="0">
            <input type="submit" value="Continue Your Application" class="btn btn-primary continue-btn">
            </form><div class="hideScript">
            '.$autoRedirectScript.'
            </div>';
            $continue_msg = 'You are eligible to apply for the programme.';
          }

            $continue_btn = '<div class="after_login_result check_eligibility_display embed-data">
                              <div class="continue-data">
                               <div class="col-md-12 emb-img">
                                <img src= "/india/themes/custom/nexus/assets/images/confirm-popup.png" class="img-responsive">
                               </div>       
                              <div class="col-md-12 emb-data">
                               <div class="congrats">Congratulations</div>
                                <div class="lead-name">'.$leadusername.'</div>
                                  <div class="lead-des">'.$continue_msg.'</div>
                                  <div class="continue-form">'.$continue_btn_form.'</div>
                              </div>
                            </div>
                            </div>';

            $variables['multistep_page_block_form']=$continue_btn;

            /* mob embded */
            $variables['mob_multistep_page_block_form']=$continue_btn;

            // Handle Yes condition

            $variables['mutlistep_apply_btn'] = '<div class="page-embed-form last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_request_call_btn'] = '<div class="page-embed-form req-last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_check_eligibility_btn'] = '<div class="page-embed-form last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_connectus_btn'] = '<div class="page-embed-form connect-last-signup">'.$continue_btn_form.'</div>';

          }
          else{

            $final_json = (array) $finalResult['json_data'];
            $leadusername = $final_json['enqry_f_nm'];

            $continue_btn_form = '';
            $continue_msg = 'You are eligible for the program. Our program advisor will call you shortly.';

            $continue_btn = '<div class="after_login_result check_eligibility_display embed-data">
                              <div class="row continue-data">
                               <div class="col-md-12 emb-img">
                                <img src= "/india/themes/custom/nexus/assets/images/confirm-popup.png" class="img-responsive">
                               </div>       
                              <div class=col-md-12 emb-data">
                               <div class="congrats">Congratulations</div>
                                <div class="lead-name">'.$leadusername.'</div>
                                  <div class="lead-des">'.$continue_msg.'</div>
                                  <div class="continue-form">'.$continue_btn_form.'</div>
                              </div>
                            </div>
                            </div>';

            $variables['multistep_page_block_form']=$continue_btn;

            /* mob embded */
            $variables['mob_multistep_page_block_form']=$continue_btn;


            $variables['mutlistep_apply_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Apply Now</span>';

            $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall grey-btn disabled" title="Our career advisor will connect"><i class="fa fa-phone"></i> Request a call back</button>';

            $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Check Eligibility</span>';

            $variables['mutlistep_connectus_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Connect with us</span>';

          }

        }
        elseif($finalResult['check_eligibility'] == 'N'){
           \Drupal::logger('checked1')->notice($time);
          $_SESSION['prev_three_display'] = 1;
          $status_data = [
            'current_step' => 2,
            'finalResult' => $finalResult,
          ];
          $_SESSION['form_step'] = 3;
          $_SESSION['finalResult'] = $finalResult;

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                //$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            }

          // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);

          $variables['multistep_page_block_form'] = $multistep_form;

          /* mob embded */
          $variables['mob_multistep_page_block_form'] = $multistep_form;


          $variables['mutlistep_apply_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Apply Now</span>';

          $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall grey-btn disabled"  title="You are not eligible for this program"><i class="fa fa-phone"></i> Request a call back</button>';

          $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Check Eligibility</span>';

          $variables['mutlistep_connectus_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Connect with us</span>';
        }
        else{
          unset($_SESSION['options']);
          $status_data = array();
          if(!empty($finalResult['leadformstg']) && $finalResult['leadformstg'] == '1a'){
            $_SESSION['form_step'] = 2;
            $status_data = [
              'current_step' => 2,
              'finalResult' => $finalResult,
            ];
          }

        $config = \Drupal::config('ms_ajax_form_example.settings');  
        $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
        if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
            $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
        }else{
			$showSimpleLeadForm = "";
			if($node->hasField('field_show_simple_lead_form')){
				if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
					$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
				}
			}
			if($showSimpleLeadForm == 1){
				$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
			}else{
				$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
			} 
            // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
        }
        // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);

          $variables['multistep_page_block_form']=$multistep_form;

          /* mob embded */

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }


          // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
          $variables['mob_multistep_page_block_form']=$multistep_form_emded;

          /**get in touch now */
          $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
            $get_in_touch_html='
            <div id="ms_ajax_popup_page_embed_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($embed_get_in_touch_form).'
                  </div>
                </div>
              </div>
            </div>';

          $variables['mob_multistep_page_embed_form']=$embed_get_in_touch_form;

          $variables['multistep_page_embed_form']=$get_in_touch_html;
          $variables['multistep_page_embed_form_btn'] =
              '<span class="cust-btnEnrolNow"><button type="button" 
              class="btn btn-danger career-btnEnrolNow" 
              data-toggle="modal" 
              data-target="#ms_ajax_popup_page_embed_Modal">Get In Touch</button></span>';


          /**enguire now */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data);
            }
              // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data);
              $enquire_now_html='
              <div id="ms_ajax_popup_page_enquire_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($enquire_now_form).'
                    </div>
                  </div>
                </div>
              </div>';
            
            $variables['multistep_popup_page_enquire_form']=$enquire_now_html;

            /**request a call back */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data, $nid);
				} 
                // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data);
            }
            // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data);
              $request_call_html='
              <div id="ms_ajax_popup_page_request_callback_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($request_callback_form).'
                    </div>
                  </div>
                </div>
              </div>';
              
              $variables['multistep_popup_page_callback_form']=$request_call_html;

              $variables['mutlistep_apply_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Apply Now7</span>';

              $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall" onclick="popupicici_popup()"><i class="fa fa-phone"></i> Request a call back</button>';

              $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Check Eligibility</span>';

              $variables['mutlistep_connectus_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Connect with us</span>';
        }
      }
        
        else{
          unset($_SESSION['options']);
            $status_data = array();

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            }

            // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            $variables['multistep_page_block_form']=$multistep_form;

            /* mob embded */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }
            // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            $variables['mob_multistep_page_block_form']=$multistep_form_emded;

            /**get in touch now */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }
            // $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
              $get_in_touch_html='
              <div id="ms_ajax_popup_page_embed_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($embed_get_in_touch_form).'
                    </div>
                  </div>
                </div>
              </div>';

            $variables['mob_multistep_page_embed_form']=$embed_get_in_touch_form;

          $variables['multistep_page_embed_form']=$get_in_touch_html;
          $variables['multistep_page_embed_form_btn'] =
                '<span class="cust-btnEnrolNow"><button type="button" 
                class="btn btn-danger career-btnEnrolNow" 
                data-toggle="modal" 
                data-target="#ms_ajax_popup_page_embed_Modal">Get In Touch</button></span>';

           /**enguire now */
           $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data, $nid);
				} 
				// $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm');
            }
            // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm');
            $enquire_now_html='
            <div id="ms_ajax_popup_page_enquire_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($enquire_now_form).'
                  </div>
                </div>
              </div>
            </div>';
          // calling popup gauri
          $variables['multistep_popup_page_enquire_form']=$enquire_now_html;

          /**request a call back */
           $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data, $nid);
				} 
                // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm');
            }
          // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm');
            $request_call_html='
            <div id="ms_ajax_popup_page_request_callback_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($request_callback_form).'
                  </div>
                </div>
              </div>
            </div>';
            
            $variables['multistep_popup_page_callback_form']=$request_call_html;

            $variables['mutlistep_apply_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Apply Now8</span>';

            $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall" onclick="popupicici_popup()"><i class="fa fa-phone"></i> Request a call back</button>';

            $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Check Eligibility</span>';

            $variables['mutlistep_connectus_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Connect with us</span>';
        }
        // End
    }
  //} commented dynamic node end
//} comment preprocess function end

	// preprocess code end here
	
	$form = $variables['mutlistep_apply_btn'];
	//$form = 'kkk';
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('#multi-apply-btn-div', $form));
    return $ajax_response;
  }
  
   public function MultistepFormSecondUsingAjax($nid) {
  
    // preprocess code start here
	//function ms_ajax_form_example_preprocess_page(&$variables) {

    //$node = \Drupal::routeMatch()->getParameter('node');
    //if ($node instanceof \Drupal\node\NodeInterface) {
	//$node = \Drupal\node\Entity\Node::load($node->id());
	$argnid = "";
	$argnid = $nid;
	if(!empty($argnid)){
    $node = \Drupal\node\Entity\Node::load($nid);
	} else {
	die('node id not found');
	}
    $nid = $node->id();
    $ContentTypeName = $node->bundle();
    $template_type = '';
    if($ContentTypeName == 'course'){
      $template_type = $node->field_select_template->value; 
      if($template_type == 'course_new_stack_route' || $template_type == 'course_stackathon' || $template_type == 'course_campaign_page_template' || $template_type == 'course_new_landing_page' || $template_type == 'course_program2022_page_template' || $template_type == 'course_icici_2022_template' || $template_type == 'course_landing2022_page_template'){
          $template_type = 'course_stack_route_ilt';
      }
    }
    elseif($ContentTypeName == 'course_landing_page'){
      $template_type = $node->field_select_course_landing_type->value; 
    }

    
    $create_application = '';
    if($node->hasField('field_is_application_process')){
      if(!empty($node->get('field_is_application_process')->getValue()[0]['value'])){
        $create_application=$node->get('field_is_application_process')->getValue()[0]['value'];
      }
    }

    $ga_cookie = '';
    if(!empty($_COOKIE['_ga'])){
      $cookie_all = explode('.', $_COOKIE['_ga']);
      $ga_cookie = $cookie_all[2].'.'.$cookie_all[3];
    }

    

    if($template_type == 'course_icici' || $template_type == 'course_stack_route_ilt' || $template_type == 'course_career' || $template_type == 'course_axis'|| $template_type == 'course_stack_route'){ 
     // if(!empty($create_application) && $create_application == 1){
      // start
      unset($_SESSION['form_step']);

      $campaignCode = $node->get('field_campaign_code')->getValue()[0]['value']; 
      $courseCode = $node->get('field_course_code')->getValue()[0]['value'];
      $CourseType = $node->get('field_delivery_mode_code')->getValue()[0]['value'];

      $url = '';
      if($node->hasField('field_proceed_button_link')){
        if(!empty($node->get('field_proceed_button_link')->getValue()[0]['value'])){
          $url=$node->get('field_proceed_button_link')->getValue()[0]['value'];
        }
      }

      //  $time = time();
      // \Drupal::logger('checked')->notice($time);

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

        // \Drupal::logger('check_loadtime')->notice('Before call application status');
        $finalResult = application_form_status($campaignCode, $courseCode, $currentUserid, 'current_user');
        // \Drupal::logger('check_loadtime')->notice('After call application status');
        if($finalResult['check_eligibility'] == 'Y'){

          if(!empty($create_application) && $create_application == 1){
            $course_id= '';
            $course_batch_id = '';
            $mainCoursedetails = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($CourseType , $courseCode);
            if(!empty($mainCoursedetails['courseBatchDetail'][0])){
              $course_id = $mainCoursedetails['courseBatchDetail'][0]['courseID'];
              $course_batch_id = $mainCoursedetails['courseBatchDetail'][0]['batchID'];
            }

            $final_json = (array) $finalResult['json_data'];
            $leadusername = $final_json['enqry_f_nm'];
           // $CUSTOMER_ID = $finalResult['CUSTOMER_ID'];
            $update_data = array(
              'source' => 'NIITCOM',
              'CustomerId' => $userCustomerId,
              'RequestedURL'=> '',
              'NewSignup' => 'true',
              'TYPE' => 'U',
              'orgid' => 1,
              'CourseId' => $course_id,
              'BatchId' => $course_batch_id,
              'enqry_crsspndnc_eml' => $userMail,
            );
            $new_json = array_merge($final_json, $update_data);
            $final_json_send = create_application($new_json);

          $continue_btn_form = '';
          $continue_msg = 'You are eligible for the program. Our program advisor will call you shortly.';
          if($finalResult['applctn_opn'] == 'Y'){
            $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
            $readUrl = "";
            if(!empty($reffer_array)){
              $query_string = explode('&', $reffer_array[1]);
              foreach($query_string as $val){
                if(strtolower($val) == 'read=y'){
                  $readUrl = "Y";
                }
              }
            }
            if ($readUrl == 'Y') {
              $autoRedirectScript = '<script>countiuneYourApplicationEventData();</script>';
            }else{
              $autoRedirectScript = '<script>countiuneYourApplicationEventDataForRedirectApplication();</script>';
            }  
            $continue_btn_form = '<form id="ContinueYourApplicationFormId" name="form" method="post" action="'.$url.'" class="ContinueYourApplicationForm">
            <input type="hidden" name="eventdata" value="">
            <input type="hidden" name="token" value="'.$final_json_send.'" tabindex="0">
            <input type="submit" value="Continue Your Application" class="btn btn-primary continue-btn">
            </form><div class="hideScript">
            '.$autoRedirectScript.'
            </div>';
            $continue_msg = 'You are eligible to apply for the programme.';
          }

            $continue_btn = '<div class="after_login_result check_eligibility_display embed-data">
                              <div class="continue-data">
                               <div class="col-md-12 emb-img">
                                <img src= "/india/themes/custom/nexus/assets/images/confirm-popup.png" class="img-responsive">
                               </div>       
                              <div class="col-md-12 emb-data">
                               <div class="congrats">Congratulations</div>
                                <div class="lead-name">'.$leadusername.'</div>
                                  <div class="lead-des">'.$continue_msg.'</div>
                                  <div class="continue-form">'.$continue_btn_form.'</div>
                              </div>
                            </div>
                            </div>';

            $variables['multistep_page_block_form']=$continue_btn;

            /* mob embded */
            $variables['mob_multistep_page_block_form']=$continue_btn;

            // Handle Yes condition

            $variables['mutlistep_apply_btn'] = '<div class="page-embed-form last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_request_call_btn'] = '<div class="page-embed-form req-last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_check_eligibility_btn'] = '<div class="page-embed-form last-signup">'.$continue_btn_form.'</div>';

            $variables['mutlistep_connectus_btn'] = '<div class="page-embed-form connect-last-signup">'.$continue_btn_form.'</div>';

          }
          else{

            $final_json = (array) $finalResult['json_data'];
            $leadusername = $final_json['enqry_f_nm'];

            $continue_btn_form = '';
            $continue_msg = 'You are eligible for the program. Our program advisor will call you shortly.';

            $continue_btn = '<div class="after_login_result check_eligibility_display embed-data">
                              <div class="row continue-data">
                               <div class="col-md-12 emb-img">
                                <img src= "/india/themes/custom/nexus/assets/images/confirm-popup.png" class="img-responsive">
                               </div>       
                              <div class=col-md-12 emb-data">
                               <div class="congrats">Congratulations</div>
                                <div class="lead-name">'.$leadusername.'</div>
                                  <div class="lead-des">'.$continue_msg.'</div>
                                  <div class="continue-form">'.$continue_btn_form.'</div>
                              </div>
                            </div>
                            </div>';

            $variables['multistep_page_block_form']=$continue_btn;

            /* mob embded */
            $variables['mob_multistep_page_block_form']=$continue_btn;


            $variables['mutlistep_apply_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Apply Now</span>';

            $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall grey-btn disabled" title="Our career advisor will connect"><i class="fa fa-phone"></i> Request a call back</button>';

            $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Check Eligibility</span>';

            $variables['mutlistep_connectus_btn'] = '<span class="btn btnApply grey-btn disabled" title="Our career advisor will connect">Connect with us</span>';

          }

        }
        elseif($finalResult['check_eligibility'] == 'N'){
           \Drupal::logger('checked1')->notice($time);
          $_SESSION['prev_three_display'] = 1;
          $status_data = [
            'current_step' => 2,
            'finalResult' => $finalResult,
          ];
          $_SESSION['form_step'] = 3;
          $_SESSION['finalResult'] = $finalResult;

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                //$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            }

          // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);

          $variables['multistep_page_block_form'] = $multistep_form;

          /* mob embded */
          $variables['mob_multistep_page_block_form'] = $multistep_form;


          $variables['mutlistep_apply_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Apply Now</span>';

          $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall grey-btn disabled"  title="You are not eligible for this program"><i class="fa fa-phone"></i> Request a call back</button>';

          $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Check Eligibility</span>';

          $variables['mutlistep_connectus_btn'] = '<span class="btn btnApply grey-btn disabled" title="You are not eligible for this program">Connect with us</span>';
        }
        else{
          unset($_SESSION['options']);
          $status_data = array();
          if(!empty($finalResult['leadformstg']) && $finalResult['leadformstg'] == '1a'){
            $_SESSION['form_step'] = 2;
            $status_data = [
              'current_step' => 2,
              'finalResult' => $finalResult,
            ];
          }

        $config = \Drupal::config('ms_ajax_form_example.settings');  
        $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
        if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
            $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
        }else{
			$showSimpleLeadForm = "";
			if($node->hasField('field_show_simple_lead_form')){
				if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
					$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
				}
			}
			if($showSimpleLeadForm == 1){
				$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
			}else{
				$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
			} 
            // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
        }
        // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);

          $variables['multistep_page_block_form']=$multistep_form;

          /* mob embded */

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }


          // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
          $variables['mob_multistep_page_block_form']=$multistep_form_emded;

          /**get in touch now */
          $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
            $get_in_touch_html='
            <div id="ms_ajax_popup_page_embed_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($embed_get_in_touch_form).'
                  </div>
                </div>
              </div>
            </div>';

          $variables['mob_multistep_page_embed_form']=$embed_get_in_touch_form;

          $variables['multistep_page_embed_form']=$get_in_touch_html;
          $variables['multistep_page_embed_form_btn'] =
              '<span class="cust-btnEnrolNow"><button type="button" 
              class="btn btn-danger career-btnEnrolNow" 
              data-toggle="modal" 
              data-target="#ms_ajax_popup_page_embed_Modal">Get In Touch</button></span>';


          /**enguire now */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data);
            }
              // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data);
              $enquire_now_html='
              <div id="ms_ajax_popup_page_enquire_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($enquire_now_form).'
                    </div>
                  </div>
                </div>
              </div>';
            
            $variables['multistep_popup_page_enquire_form']=$enquire_now_html;

            /**request a call back */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data, $nid);
				} 
                // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data);
            }
            // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data);
              $request_call_html='
              <div id="ms_ajax_popup_page_request_callback_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($request_callback_form).'
                    </div>
                  </div>
                </div>
              </div>';
              
              $variables['multistep_popup_page_callback_form']=$request_call_html;

              $variables['mutlistep_apply_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Apply Now</span>';

              $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall" onclick="popupicici_popup()"><i class="fa fa-phone"></i> Request a call back</button>';

              $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Check Eligibility</span>';

              $variables['mutlistep_connectus_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Connect with us</span>';
        }
      }
        
        else{
          unset($_SESSION['options']);
            $status_data = array();

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data, $nid);
				} 
                // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            }

            // $multistep_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm', $status_data);
            $variables['multistep_page_block_form']=$multistep_form;

            /* mob embded */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }
            // $multistep_form_emded = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            $variables['mob_multistep_page_block_form']=$multistep_form_emded;

            /**get in touch now */
            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data, $nid);
				} 
                // $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
            }
            // $embed_get_in_touch_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepEmbedPopup', $status_data);
              $get_in_touch_html='
              <div id="ms_ajax_popup_page_embed_Modal" class="modal fade leadLightBox" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                    <div class="modal-body">
                        '.render($embed_get_in_touch_form).'
                    </div>
                  </div>
                </div>
              </div>';

            $variables['mob_multistep_page_embed_form']=$embed_get_in_touch_form;

          $variables['multistep_page_embed_form']=$get_in_touch_html;
          $variables['multistep_page_embed_form_btn'] =
                '<span class="cust-btnEnrolNow"><button type="button" 
                class="btn btn-danger career-btnEnrolNow" 
                data-toggle="modal" 
                data-target="#ms_ajax_popup_page_embed_Modal">Get In Touch</button></span>';

           /**enguire now */
           $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm', $status_data, $nid);
				} 
				// $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm');
            }
            // $enquire_now_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\MultiStepExampleForm');
            $enquire_now_html='
            <div id="ms_ajax_popup_page_enquire_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($enquire_now_form).'
                  </div>
                </div>
              </div>
            </div>';
          
          $variables['multistep_popup_page_enquire_form']=$enquire_now_html;

          /**request a call back */
           $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_captureLeadsInCMS = $config->get('CaptureLeadsInCMS');
            if(!empty($niit_captureLeadsInCMS) && $niit_captureLeadsInCMS == 1){ 
                $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
            }else{
				$showSimpleLeadForm = "";
				if($node->hasField('field_show_simple_lead_form')){
					if(!empty($node->get('field_show_simple_lead_form')->getValue()[0]['value'])){
						$showSimpleLeadForm = $node->get('field_show_simple_lead_form')->getValue()[0]['value'];
					}
				}
				if($showSimpleLeadForm == 1){
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\CaptureLeadsInCMSForm', $node->id());
				}else{
					$request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm', $status_data, $nid);
				} 
                // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm');
            }
          // $request_callback_form = \Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_popup\Form\RequestCallBackForm');
            $request_call_html='
            <div id="ms_ajax_popup_page_request_callback_Modal" class="modal fade leadLightBox" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal">&times;</button>  
                  <div class="modal-body">
                      '.render($request_callback_form).'
                  </div>
                </div>
              </div>
            </div>';
            
            $variables['multistep_popup_page_callback_form']=$request_call_html;

            $variables['mutlistep_apply_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Apply Now</span>';

            $variables['mutlistep_request_call_btn'] = '<button class="btn btnReqCall" onclick="popupicici_popup()"><i class="fa fa-phone"></i> Request a call back</button>';

            $variables['mutlistep_check_eligibility_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Check Eligibility</span>';

            $variables['mutlistep_connectus_btn'] = '<span class="btn btn-primary btnApply" onclick="popupicici_popup()">Connect with us</span>';
        }
        // End
    }
  //} commented dynamic node end
//} comment preprocess function end

	// preprocess code end here
	
	$form = $variables['multistep_page_block_form'];
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('.multi-div', $form));
    return $ajax_response;
  }
  /*** Multistep form Second end here
  */

}


