<?php

namespace Drupal\ms_ajax_form_popup\Step;

use Drupal\ms_ajax_form_popup\Button\StepOneNextButton;
use Drupal\ms_ajax_form_popup\Validator\ValidatorRequired;
use Drupal\ms_ajax_form_popup\FormFields\GetFormFields;
use Drupal\ms_ajax_form_example\Validator\ValidatorRegex;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\user\Entity\User;
use Drupal\node\Entity\Node;

/**
 * Class StepOne.
 *
 * @package Drupal\ms_ajax_form_popup\Step
 */
class StepOne extends BaseStep {

  /**
   * {@inheritdoc}
   */
  protected $field_key;
  protected function setStep() {
    return StepsEnum::STEP_ONE;
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    
    return [
      new StepOneNextButton(),
    ];
  }
  public function BuildFormLeftSidebar($s_id){
    $base_url = \Drupal::request()->getSchemeAndHttpHost();
    $screen_img='';
    $screen_query=  db_select('camp_ms_form','ms');
    $screen_query->leftjoin('camp_ms_form__field_screen_image','s_img','ms.id=s_img.entity_id');
    $screen_query->fields('s_img',array('field_screen_image_target_id','field_screen_image_alt'));
    $screen_query->condition('s_img.entity_id',$s_id);
    $screen_query->range(0, 1);  
    $query_data=$screen_query->execute()->fetchAll();
    $img_src = '';
    foreach($query_data as $value){
      if(!empty($value->field_screen_image_target_id)){
        $form_image =  \Drupal\file\Entity\File::load($value->field_screen_image_target_id);
        $img_src=file_create_url($form_image->getFileUri());
      }
    }
  
    $left_html='';
    $left_html.='<p><img src="/india/themes/custom/nexus/assets/images/NIIT_logomobile.png" class="img-responsive"></p>';
    $left_html.='<img src="'.$img_src.'" class="img-responsive">';

    return $left_html;
  }

  /**
   * {@inheritdoc}
   */
  public function buildStepFormElements($event, $nid = NULL) {
    $intent=0;
    $event_code=$event;
    $camp='NIITCOM';
    $course_code='NIITCOM';
    $screen_level = 1;
    $create_application = 0;
	  $enroll_link = '';
    $isAppliedCenter = 0;
    $centerListData = '';
    $course_id = 0;
    $course_batch_id = 0;
    $CourseType = '';


    $userName ="";
    $userMobileNo ="";
    $userEmailId ="";
    $user = User::load(\Drupal::currentUser()->id());
    // $userRoles = $user->getRoles();
    $currentUserid = $user->id();
    if(isset($currentUserid)){
      $userName = $user->get('field_user_name')->value;
      $userMobileNo = $user->get('field_mobile_number')->value;
      if(!empty($user->get('field_communication_emailid')->value)){
        $userEmailId = $user->get('field_communication_emailid')->value;
      }
      else{
        $userEmailId = $user->get('mail')->value;
      }
    }


    /*$node = \Drupal::routeMatch()->getParameter('node');
    
    if ($node instanceof \Drupal\node\NodeInterface) {
      // You can get nid and anything else you need from the node object.
      $nid = $node->id();
      $node = \Drupal\node\Entity\Node::load($node->id());
      
      if($node->hasField('field_course_code')){
        if(!empty($node->get('field_course_code')->getValue()[0]['value'])){
          $course_code=$node->get('field_course_code')->getValue()[0]['value'];
        }
      }
      if($node->hasField('field_campaign_code')){
        if(!empty($node->get('field_campaign_code')->getValue()[0]['value'])){
          $camp=$node->get('field_campaign_code')->getValue()[0]['value'];
        }
      }

      if($node->hasField('field_use_utm_cookie_parameters')){
        if(!empty($node->get('field_use_utm_cookie_parameters')->getValue()[0]['value'])){
          $utmFieldCheck =$node->get('field_use_utm_cookie_parameters')->getValue()[0]['value'];
        }
      }

      if($node->hasField('field_is_application_process')){
        if(!empty($node->get('field_is_application_process')->getValue()[0]['value'])){
          $create_application=$node->get('field_is_application_process')->getValue()[0]['value'];
        }
      }

      if($node->hasField('field_profiler_form_title')){
        if(!empty($node->get('field_profiler_form_title')->getValue()[0]['value'])){
          $step_title=$node->get('field_profiler_form_title')->getValue()[0]['value'];
        }
      }
	  
  	  if($node->hasField('field_proceed_button_link')){
    		if(!empty($node->get('field_proceed_button_link')->getValue()[0]['value'])){
    		  $enroll_link=$node->get('field_proceed_button_link')->getValue()[0]['value'];
    		}
  	  }
      # get node Is applied center code enable
      if($node->hasField('field_is_applied_center_code')){
        if(!empty($node->get('field_is_applied_center_code')->getValue()[0]['value'])){
          $isAppliedCenter = $node->get('field_is_applied_center_code')->getValue()[0]['value'];
        }
      }
      # get node center list data with comma
      if($node->hasField('field_center_list')){
        if(!empty($node->get('field_center_list')->getValue()[0]['value'])){
          $centerListData = $node->get('field_center_list')->getValue()[0]['value'];
        }
      }

      if($node->hasField('field_delivery_mode_code')){
        if(!empty($node->get('field_delivery_mode_code')->getValue()[0]['value'])){
          $CourseType = $node->get('field_delivery_mode_code')->getValue()[0]['value'];
        }
      }

      $mainCoursedetails = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($CourseType , $course_code);
      if(!empty($mainCoursedetails['courseBatchDetail'][0])){
        $course_id = $mainCoursedetails['courseBatchDetail'][0]['courseID'];
        $course_batch_id = $mainCoursedetails['courseBatchDetail'][0]['batchID'];
      }

    }*/
	
	$node = \Drupal\node\Entity\Node::load($nid);
	
	//if($node->hasField('field_course_code')){
        if(!empty($node->field_course_code->value)){
          $course_code=$node->field_course_code->value;
		  
        }
		
      //}
      //if($node->hasField('field_campaign_code')){
        if(!empty($node->field_campaign_code->value)){
           $camp=$node->field_campaign_code->value;
        }
      //}
	  
	  //if($node->hasField('field_use_utm_cookie_parameters')){
        //if(!empty($node->get('field_use_utm_cookie_parameters')->getValue()[0]['value'])){
          //$utmFieldCheck =$node->get('field_use_utm_cookie_parameters')->getValue()[0]['value'];
        //}
		if(!empty($node->field_use_utm_cookie_parameters->value)){
		  $utmFieldCheck=$node->field_use_utm_cookie_parameters->value;
        }
      //}

      //if($node->hasField('field_is_application_process')){
        if(!empty($node->field_is_application_process->value)){
		  $create_application=$node->field_is_application_process->value;
        }
      //}

      //if($node->hasField('field_profiler_form_title')){
        if(!empty($node->field_profiler_form_title->value)){
          
		  $step_title=$node->field_profiler_form_title->value;
        }
      //}
  	  //if($node->hasField('field_proceed_button_link')){
    		if(!empty($node->field_proceed_button_link->value)){
			  $enroll_link=$node->field_proceed_button_link->value;
    		}
  	  //}
      # get node Is applied center code enable
      //if($node->hasField('field_is_applied_center_code')){
        if(!empty($node->field_is_applied_center_code->value)){
		  $isAppliedCenter=$node->field_is_applied_center_code->value;
        }
      //}
      # get node center list data with comma
      //if($node->hasField('field_center_list')){
        if(!empty($node->field_center_list->value)){
		  $centerListData=$node->field_center_list->value;
        }
      //}

      //if($node->hasField('field_delivery_mode_code')){
        if(!empty($node->field_delivery_mode_code->value)){
		  $CourseType=$node->field_delivery_mode_code->value;
        }
      //}

      $mainCoursedetails = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($CourseType , $course_code);
      if(!empty($mainCoursedetails['courseBatchDetail'][0])){
        $course_id = $mainCoursedetails['courseBatchDetail'][0]['courseID'];
        $course_batch_id = $mainCoursedetails['courseBatchDetail'][0]['batchID'];
      }
      
    //$form_field_item= GetFormFields::StepOneFormField($event_code,$camp,$intent,$screen_level);
    $form_field_item = \Drupal::service('niit_multistep_form.niit_get_form_field')->getMultiStepFormFieldData($event_code,$camp,$intent,$screen_level);
    $label_value = $form_field_item['field_label_option'];
    if ($label_value == "hide_label") {
      $label_hide_class = "formfield_label_hide_class";
    }
    $form =array();
    $field_name=array();
    $form['title'] = array(
      '#type' => 'markup',
      '#markup' => '<h2 class="checkEligibTitle pl-3">'.$step_title.'</h2>',
      '#allowed_tags' => ['h2', 'span'],
    );
    $form['create_application'] = array(
      '#type' => 'hidden',
      '#value' => $create_application,
    );
    $form['intrstd_prgrm'] = array(
      '#type' => 'hidden',
      '#value' => $course_code,
    );
    $form['CourseType'] = array(
      '#type' => 'hidden',
      '#value' => $CourseType,
    );
    $form['source'] = array(
      '#type' => 'hidden',
      '#value' => $camp,
    );
	  $form['enroll_link'] = array(
      '#type' => 'hidden',
      '#value' => $enroll_link,
    );
    $form['isAppliedCenter'] = array(
      '#type' => 'hidden',
      '#value' => $isAppliedCenter,
    );
    $form['centerListData'] = array(
      '#type' => 'hidden',
      '#value' => $centerListData,
    );
    $form['campaign'] = array(
      '#type' => 'hidden',
      '#value' => $camp,
    );
    $form['CourseId'] = array(
      '#type' => 'hidden',
      '#value' => $course_id,
    );
    $form['BatchId'] = array(
      '#type' => 'hidden',
      '#value' => $course_batch_id,
    );
    $form['utmFieldCheck'] = array(
      '#type' => 'hidden',
      '#value' => $utmFieldCheck,
    );
    $form['openloginpopup'] = array(
      '#type' => 'hidden',
      '#attributes' => ['id' => [$event.'openloginpopup']],
    );
    $form['openloginpopup_script'] = array(
        '#type' => 'markup',
        '#markup' => '<script>
          openloginpopup_script("'.$event.'");
        </script>',
        '#allowed_tags' => ['script'],
    );
    $field_name['CourseId']='CourseId';
    $field_name['BatchId']='BatchId';
    $field_name['campaign']='campaign';
    $field_name['intrstd_prgrm']='intrstd_prgrm';
    $field_name['source']='source';
    $field_name['create_application']='create_application';
	  $field_name['enroll_link']='enroll_link';
    $field_name['isAppliedCenter']='isAppliedCenter';
    $field_name['centerListData']='centerListData';
    $field_name['CourseType']='CourseType';
    if(is_array($form_field_item['field'])){
    foreach($form_field_item['field'] as $value){
      $require=false;
      if($value['require'] ==1 ){$require = TRUE;}
      
      $field_name[$value['field_id']]=$value['field_id'];
      if($value['type'] == 'textfield'){
        if($value['field_id'] == 'enqry_f_nm' && !empty($userName)){
          $form[$value['field_id']] = [
            HASH_TYPE => TEXTFIELD,
            //HASH_REQUIRED => TRUE,
            HASH_TITLE => t($value['caption']),
            HASH_PLACEHOLDER => t($value['caption']),
            '#attributes' => ['class' => ['form-control'], 'readonly' => 'readonly'],
            HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
            HASH_SUFFIX => '</div>',
            HASH_DEFAULT_VALUE => isset($userName) ? $userName : NULL,
            // HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
          ];
        }else if($value['field_id'] == 'enqry_crsspndnc_eml' && !empty($userEmailId)){
          $form[$value['field_id']] = [
            HASH_TYPE => TEXTFIELD,
            //HASH_REQUIRED => TRUE,
            HASH_TITLE => t($value['caption']),
            HASH_PLACEHOLDER => t($value['caption']),
            '#attributes' => ['class' => ['form-control'], 'readonly' => 'readonly'],
            HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
            HASH_SUFFIX => '<span class="usernm_new">*This will be the username for your NIIT account.</span></div>',
            HASH_DEFAULT_VALUE => isset($userEmailId) ? $userEmailId : NULL,
            // HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
          ];
        }else if($value['field_id'] == 'enqry_crsspndnc_eml'){
          $form[$value['field_id']] = [
            HASH_TYPE => TEXTFIELD,
            //HASH_REQUIRED => TRUE,
            HASH_TITLE => t($value['caption']),
            HASH_PLACEHOLDER => t($value['caption']),
            '#attributes' => ['class' => ['form-control'], 'autocomplete' => 'something'],
            HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0 '.$label_hide_class.' custom-label-hide">',
            HASH_SUFFIX => '<span class="usernm_new">*This will be the username for your NIIT account.</span></div>',
            // HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
          ];
        }else{
          $form[$value['field_id']] = [
            HASH_TYPE => TEXTFIELD,
            //HASH_REQUIRED => TRUE,
            HASH_TITLE => t($value['caption']),
            HASH_PLACEHOLDER => t($value['caption']),
            '#attributes' => ['class' => ['form-control'], 'autocomplete' => 'something-new1'],
            HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
            HASH_SUFFIX => '</div>',
            // HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
          ];
        }
      }
      else if($value['type'] == 'google_place'){
		  $id = 'google-place-field-'.$event;
        $form[$value['field_id']] = [
          HASH_TYPE => TEXTFIELD,
          HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          HASH_PLACEHOLDER => t("City (Type min 3 characters)"),
          '#attributes' => ['class' => ['form-control'], 'id' => $id, 'autocomplete' => 'something-G'],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 google-place-field">',
          HASH_SUFFIX => '</div>',
          //HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
        ];
         $form['enqry_crsspndnc_state'] = [
          HASH_TYPE => TEXTFIELD,
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' state-data">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($this->getValues()['enqry_crsspndnc_state']) ? $this->getValues()['enqry_crsspndnc_state'] : NULL,
        ];
      }
      else if($value['type'] == 'number' && $value['field_id'] == 'enqry_crsspndnc_mbl'){
        if($value['field_id'] == 'enqry_crsspndnc_mbl' && !empty($userMobileNo)){
          $form[$value['field_id']] = [
            HASH_TYPE => $value['type'],
            //HASH_REQUIRED => TRUE,
            HASH_TITLE => t($value['caption']),
            '#size' => 10,
            '#min' => $value['minlength'],
            '#max' => $value['maxlength'],
            HASH_PLACEHOLDER => t($value['caption']),
          //  '#attributes' => ['class' => ['form-control']],
            '#attributes' => ['class' => ['form-control'], 'readonly' => 'readonly'],
            HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
            HASH_SUFFIX => '</div>',
            HASH_DEFAULT_VALUE => isset($userMobileNo) ? $userMobileNo : NULL,
          ];

          $form['mob_verified'] = [
            HASH_TYPE => 'hidden',
            '#attributes' => ['id' => [$form_name.'mob_verified']],
            '#value' => 1,
          ];
          
        }else{
          $config = \Drupal::config('ms_ajax_form_example.settings');  
          $otp_status = $config->get('otp_status');
          if(!empty($otp_status) && $otp_status == 1){

            $form[$value['field_id']] = [
              HASH_TYPE => $value['type'],
              HASH_REQUIRED => TRUE,
              HASH_TITLE => t($value['caption']),
              '#size' => 10,
              '#min' => $value['minlength'],
              '#max' => $value['maxlength'],
              HASH_PLACEHOLDER => t($value['caption']),
              '#attributes' => ['class' => ['form-control'], 'autocomplete' => 'something-M'],
              HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide mob-otp-verify">',
            //  HASH_SUFFIX => '</div>',
              HASH_SUFFIX => '<span class="dis-otp-field">Get OTP</span>
                                  <div class="otp-loader"><div class="ajax-progress ajax-progress-throbber">
                                    <div class="throbber">&nbsp;</div><div class="message">Please wait...</div>
                                  </div></div>
                              </div>',
            ];

            $form['varify_otp'] = [
              HASH_TYPE => 'textfield',
              HASH_TITLE => 'Enter the OTP below',
              '#size' => 6,
              HASH_PLACEHOLDER => t('Enter OTP'),
              '#attributes' => ['class' => ['form-control']],
              HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0 '.$label_hide_class.' otp-verify"><div class="otp-send-msg"></div>',
              HASH_SUFFIX => '<span class="check-otp-display">Verify</span>
                                  <div class="verify-loader"><div class="ajax-progress ajax-progress-throbber">
                                    <div class="throbber">&nbsp;</div><div class="message">Please wait...</div>
                                  </div></div>
                              </div>',
            ];

            $form['mob_verified'] = [
              HASH_TYPE => 'hidden',
              '#attributes' => ['id' => [$event.'mob_verified']],
            ];

          }
          else{
            $form[$value['field_id']] = [
              HASH_TYPE => $value['type'],
              //HASH_REQUIRED => TRUE,
              HASH_TITLE => t($value['caption']),
              '#size' => 10,
              '#min' => $value['minlength'],
              '#max' => $value['maxlength'],
              HASH_PLACEHOLDER => t($value['caption']),
              '#attributes' => ['class' => ['form-control'], 'autocomplete' => 'something-new'],
              HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
              HASH_SUFFIX => '</div>',
            ];

            $form['mob_verified'] = [
              HASH_TYPE => 'hidden',
              '#attributes' => ['id' => [$event.'mob_verified']],
              '#value' => 1,
            ];
          }
          
        }
        
      }
      else if($value['type'] == 'number' && $value['field_id'] != 'enqry_crsspndnc_mbl'){
        $form[$value['field_id']] = [
          HASH_TYPE => $value['type'],
          HASH_REQUIRED => TRUE,
          HASH_TITLE => t($value['caption']),
          // '#size' => 10,
          '#min' => $value['minlength'],
          '#max' => $value['maxlength'],
          HASH_PLACEHOLDER => t($value['caption']),
          '#attributes' => ['class' => ['form-control']],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
          HASH_SUFFIX => '</div>',
          
        ];
      }
      else if($value['type'] == 'select' && $value['field_id'] == 'prfrd_cntr'){
        if($camp == 'NIITSTCK' || $camp == 'BTCSTCK' || $camp == 'FPJ21' || $camp == 'PFSSE' || $camp == 'SESTR' || $camp == 'GADEV' || $camp == 'GMDEV' || $camp == 'D123F' || $camp == 'D123P' || $camp == 'DS23P' || $camp == 'DS1PT' || $camp == 'DS1FT' || $camp == 'FPITS' || $camp == 'PGPCC' || $camp == 'APCCD' || $camp == 'APCSO' || $camp == 'PGSTRT' || $camp == 'PFSSP'){
          $form['prfrd_cntr'] = [
            '#type' => 'hidden',
            '#value' => 'ST001_Stack',
            '#attributes' => ['class' => ['Preferred-field']],
          ];
        }
        elseif($camp == 'NCABP' || $camp == 'AXISL' || $camp == 'FSDBP' || $camp == 'INDSN' || $camp == 'VSRMP' || $camp == 'FABDP'){
          $form['prfrd_cntr'] = [
            '#type' => 'hidden',
            '#value' => 'AX001_NIIT Institute Of Finance Banking And Insurance Training Limited',
            '#attributes' => ['class' => ['Preferred-field']],
          ];
        }
        elseif($camp == 'SUTHR'){
          $form['prfrd_cntr'] = [
            '#type' => 'hidden',
            '#value' => 'BB001_NIIT Institute Of Finance Banking And Insurance Training',
            '#attributes' => ['class' => ['Preferred-field']],
          ];
        }
        elseif($camp == 'ICICISO'){
          $form['prfrd_cntr'] = [
            '#type' => 'hidden',
            '#value' => '11961_NIIT Institute Of Finance Banking And Insurance Training Limited',
            '#attributes' => ['class' => ['Preferred-field']],
          ];
        }
        else{
          $options = get_preferred_center_per_camp($camp);
          if(!empty($_SESSION['options'])){
             $options = $_SESSION['options'];
             ksort($options);
          }

          $options['11961_NIIT Central Customer Care'] = 'NIIT Central Customer Care';
          //$options['11961_NIIT Digital'] = 'NIIT Digital';


          $form['display_center'] = [
            '#type' => 'hidden',
            '#attributes' => ['class' => ['display_center']],
          ];

          $form['prfrd_cntr'] = [
            HASH_TYPE => 'select',
            HASH_REQUIRED => TRUE,
            HASH_TITLE => t('Preferred Support Location').'<small class="formgradTooltip">
                            <i class="fa fa-info-circle"></i>
                            <small class="gradTooltip">Online or In-Person</small>
                          </small>',
            HASH_OPTIONS => $options,
            '#attributes' => ['class' => ['form-control', 'Preferred-field']],
            HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0 '.$label_hide_class.' custom-label-hide prfrd-cntr-step">',
            HASH_SUFFIX => '</div>',
            // '#empty_value' => t($value['caption']),
          //  HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
          ];
        }
      }
      else if($value['type'] == 'select' && $value['field_id'] != 'prfrd_cntr'){
        $form[$value['field_id']] = [
          HASH_TYPE => $value['type'],
          HASH_REQUIRED => TRUE,
          HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control']],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
          HASH_SUFFIX => '</div>',
          '#empty_value' => t($value['caption']),
          // HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
        ];
      }
      // else if($value['type'] == 'select'){
      //   $form[$value['field_id']] = [
      //     HASH_TYPE => $value['type'],
      //     HASH_REQUIRED => TRUE,
      //     HASH_TITLE => t($value['caption']),
      //     HASH_OPTIONS => $value['options'],
      //     '#attributes' => ['class' => ['form-control']],
      //     HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0 custom-label-hide">',
      //     HASH_SUFFIX => '</div>',
      //     '#empty_value' => t($value['caption']),
      //     // HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
      //   ];
      // }
      else if($value['type'] == 'radios'){
        $form[$value['field_id']] = [
          HASH_TYPE => $value['type'],
          HASH_REQUIRED => TRUE,
          HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control-radio-check']],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
        ];
      }else if($value['type'] == 'checkboxes'){
        $form[$value['field_id']] = [
          HASH_TYPE => 'checkboxes',
          HASH_REQUIRED => TRUE,
          HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control-radio-check']],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
        ];
      }else if($value['type'] == 'date'){
        $form[$value['field_id']] = [
          HASH_TYPE => TEXTFIELD,
          HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          //HASH_REQUIRED => $require,
          HASH_PLACEHOLDER => t("Date of Birth"),
          '#attributes' => [
            'class' => ['form-control customdate'],
            'id' => 'customdatepicker date',
            'onfocusout' => "(this.type = 'text')",
            'onfocus' => "(this.type = 'date')"
          ],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
          HASH_SUFFIX => '</div>',
          '#min' =>  "1960-01-01",
          '#max' => date('Y-m-d'),
        ];
      }
      /*****************Language Field *******************/
      else if($value['type'] == 'user_language'){
        if($value['field_id'] == 'enqry_usr_language'){
        $form[$value['field_id']] = [
        HASH_TYPE => 'select',
        // HASH_REQUIRED => $require,
        HASH_TITLE => t($value['caption']),
        HASH_PLACEHOLDER => t($value['caption']),
        HASH_OPTIONS => [
          '' => 'Preferred Language',
          'English' => 'English',
          'Bengali' => 'Bengali',
          'Gujarati' => 'Gujarati',
          'Marathi' => 'Marathi',
          'Tamil' => 'Tamil',
          'Telugu' => 'Telugu',
          'Malayalam' => 'Malayalam',
          ],
        '#attributes' => ['class' => ['form-control']],
        HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0 '.$label_hide_class.' custom-label-hide">',
          HASH_SUFFIX => '</div>',
        //HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
        ];
      }
    }
  /*****************Language Field end *******************/

  /*****************Free Trial hidden field start *******************/
      
     
else if($value['type'] == 'free_trial_check'){
  if($value['field_id'] == 'enqry_free_trial_check'){
  $form[$value['field_id']] = [
  HASH_TYPE => 'hidden',
  //HASHDEFAULT_VALUE => FALSE,
  HASH_TITLE => t($value['caption']),
  HASH_PLACEHOLDER => t($value['caption']),
  HASH_DEFAULT_VALUE => $_GET['key'],
  '#attributes' => ['class' => ['form-control']],
  HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0 '.$label_hide_class.' custom-label-hide">',
    HASH_SUFFIX => '</div>',
  //HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
  ];
}
}
 /*****************Free Trial hidden field end *******************/
	  else if($value['type'] == 'whatsapp_checkbox'){
		$whtapp_link ='<img alt="whatsapp" src="/india/themes/custom/nexus/assets/images/WhatsApp_icon1.png">';
        if($value['field_id'] == 'enqry_whatsapp_checkbox'){
			/*******************/
          $form[$value['field_id']] = [
          HASH_TYPE => 'checkbox',
          //HASH_REQUIRED => TRUE,
         // HASH_TITLE => t($value['caption']),
		  HASHDEFAULT_VALUE => TRUE,
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control-radio-check']],
          HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0"><div class="checkbox whatsapp">',
          HASH_SUFFIX => '<span class="suffix-privacy">I agree to receive updates on '.$whtapp_link.' WhatsApp</span></div></div>',
        ];
			/*******************/
		}
	  }
      else if($value['type'] == 'tab_radio'){
        $default_value = NULL;
        $options = $value['options'];
        if($value['field_id'] == 'enqry_sex'){
          $options = array('M' => 'Male', 'F' => 'Female', 'O' => 'Other');   
          $default_value = 'M';     
        }
        $form[$value['field_id']] = [
          HASH_TYPE => 'radios',
          HASH_REQUIRED => TRUE,
          HASH_OPTIONS => $options,
          '#attributes' => ['class' => ['form-control-radio-check']],
          HASH_PREFIX => '<div class="btn-group '.$label_hide_class.' btn-group-justified col-md-12 leadLightBox-pl0 tab-radio-btn">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $default_value,
        ];
      }
      else if($value['type'] == 'marks_percentage'){
        $form[$value['field_id']] = [
          HASH_TYPE => 'textfield',
          HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          // '#size' => 10,
          HASH_PLACEHOLDER => t($value['caption']),
          '#attributes' => ['class' => ['form-control'], 'onkeypress' => "return onlyDouble(event);",  'minlength' => '2'],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          
        ];
      }
    }
  }

  $this->field_key=$field_name;

  $options_kink = [
    'attributes' => [
      'class' => ['term-policy'],
      'target' => 'blank'],
  ];
  $t_link = Link::fromTextAndUrl(t('Privacy Policy'), Url::fromUri('internal:/node/2', $options_kink))->toString();
  $t_link->setGeneratedLink('<a href="https://privacy.niit.com/prospective_customer.html" target="blank" rel="nofollow">Privacy Policy</a>');
  
  $form['term_policy'] = [
    HASH_TYPE          => 'checkbox',
  //  HASH_TITLE         => 'I understand the '.$t_link,
    HASH_REQUIRED      => TRUE,
    HASHDEFAULT_VALUE => TRUE,
    HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0 check-disab"><div class="checkbox">',
    HASH_SUFFIX => '<span class="suffix-privacy">I agree to ' .$t_link.' & overriding DNC/NDNC request for Call/SMS</span></div></div>',
    
  ];
/**genrate left screen html */
/**left screen html empty */


  $left_html=$this->BuildFormLeftSidebar($form_field_item['screen']['id']);
  $return_value['f_field']=$form;
  $return_value['screen_id']=$form_field_item['screen']['id'];
  $return_value['left_html']=$left_html;
  // $return_value['header_msg']='<h5><b>'.$step_title.'</b></h5>';

    return $return_value;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldNames() {
    return $this->field_key;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldsValidators() {
    return [
      'enqry_f_nm' => [
        new ValidatorRegex(t("Please enter your name"), '/^(?!\s*$).+/'),
        new ValidatorRegex(t("Please enter valid name"),"/^[a-zA-Z ]*$/"),
      ],
      'enqry_crsspndnc_mbl' => [
        new ValidatorRegex(t("Please enter your 10-digit mobile number"), '/^(?!\s*$).+/'),
        new ValidatorRegex(t("Please enter valid mobile Number"), '/^[0-9]{10}$/'),
      ],
      'enqry_crsspndnc_eml' => [
        new ValidatorRegex(t("Please enter your email address"), '/^(?!\s*$).+/'),
        new ValidatorRegex(t("Please enter valid email address"), 
          '/^([A-Za-z0-9\+_\-]+)(\.[A-Za-z0-9\+_\-]+)*@([A-Za-z0-9\-]+\.)+[A-Za-z0-9]{2,6}$/'),
      ],
    ];
  }

}
