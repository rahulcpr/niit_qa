<?php

namespace Drupal\ms_ajax_form_example\Step;

use Drupal\ms_ajax_form_example\Button\StepTwoNextButton;
use Drupal\ms_ajax_form_example\Button\StepTwoPreviousButton;
use Drupal\ms_ajax_form_example\Validator\ValidatorRequired;
use Drupal\ms_ajax_form_example\Validator\ValidatorRegex;
use Drupal\ms_ajax_form_example\FormFields\GetFormFields;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class StepTwo.
 *
 * @package Drupal\ms_ajax_form_example\Step
 */
class StepTwo extends BaseStep {

  /**
   * {@inheritdoc}
   */
  protected $StepTwokey;

  protected function setStep() {
    return StepsEnum::STEP_TWO;
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
      // new StepTwoPreviousButton(),
      new StepTwoNextButton(),
    ];
  }
    
  public function GetStepMessage($screen_id){
    $html='default msg';
    if($screen_id != ''){
        $field_query=  db_select('camp_ms_form__field_submission_message','msg');
        $field_query->fields('msg',array('field_submission_message_value'));
        $field_query->condition('msg.entity_id',$screen_id);
        $field_values=$field_query->execute()->fetchCol();
        // $html='<h4 class="embedTitleSecnd">Hey '.$_SESSION['step_message'].'</h4>';
        // $html.='<h4 class="SubEmbedTitleSecnd">'.$field_values[0].'</h4>';

        $html = 
                  '<div class="row alert alert-warning alert-dismissible" id="scroll-form">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <div class="col-md-12 col-xs-12 EmbedFormMsg MsgScrollScript">
                  <strong>Thankyou!</strong> For showing interest in our program.
                  </div>
                </div>';
        unset($_SESSION['step_message']);
    }
    return $html;
  }
  /**
   * {@inheritdoc}
   */
  
  public function buildStepFormElements($form_name, $nid = NULL) {
    
    $intent=0;
    $event='Get_In_TCH';
    $camp='NIITCOM';
    $course_code='NIITCOM';
    $screen_level=2;
    $step_title = 'Get in <span>touch with us</span>';
    $create_application = 0;
    $enroll_link = '';
    $isAppliedCenter = 0;
    $centerListData = '';
    $course_id = 0;
    $course_batch_id = 0;
    $CourseType = '';

    //$node = \Drupal::routeMatch()->getParameter('node');
    
    
    /*if ($node instanceof \Drupal\node\NodeInterface) {
      // You can get nid and anything else you need from the node object.
      // $nid = $node->id();

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
	
    $argnid = "";
	$argnid = $nid;
	if(!empty($argnid)){
	$node = \Drupal\node\Entity\Node::load($nid);
	} else {
	die('node id not found');
	}      
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
     // }

     // if($node->hasField('field_delivery_mode_code')){
        if(!empty($node->field_delivery_mode_code->value)){
		  $CourseType=$node->field_delivery_mode_code->value;
        }
      //}

      $mainCoursedetails = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($CourseType , $course_code);
      if(!empty($mainCoursedetails['courseBatchDetail'][0])){
        $course_id = $mainCoursedetails['courseBatchDetail'][0]['courseID'];
        $course_batch_id = $mainCoursedetails['courseBatchDetail'][0]['batchID'];
      }


    if(isset($_SESSION["get_form"])){
      $intent=$_SESSION["get_form"];
    }

    $form_field_item =array();   
    //$form_field_item_data= GetFormFields::StepNextFormField($event,$camp,$intent,$screen_level);


    $form_field_item_data = \Drupal::service('niit_multistep_form.niit_get_form_field')->getMultiStepFormFieldData($event,$camp,$intent,$screen_level);
    $label_value = $form_field_item_data['field_label_option'];
    if ($label_value == "hide_label") {
      $label_hide_class = "formfield_label_hide_class";
    }

    // echo '<pre>call';print_r($form_field_item_data['screen']['id']); die;
    if(isset($_SESSION['screen_id'])){
 
      $form_field_item['completed'] = [
        '#markup' => '',
        HASH_PREFIX =>$this->GetStepMessage($_SESSION['screen_id']),
      ];
      $form_field_item['title_script'] = array(
        '#type' => 'markup',
        '#markup' => '<script>jQuery(".ms-ajax-form-example .alert-dismissible").delay(3200).fadeOut(300);

        checkEligibilityFormEventAll("ContinueForm");
        ga_signIn_signUp_event("LeadSubmitted", "CourseOverview_Enrollment");
        jQuery("html, body").animate({scrollTop: jQuery(".MsgScrollScript").offset().top -100}, 500);
		</script>',
        '#allowed_tags' => ['script'],
      );
    }  

    $form_field_item['title'] = array(
      '#type' => 'markup',
      '#markup' => '<h2 class="checkEligibTitle pl-3 mt-0">'.$step_title.'</h2>',
      '#allowed_tags' => ['h2', 'span'],
    );
    $form_field_item['create_application'] = array(
      '#type' => 'hidden',
      '#value' => $create_application,
    );
    $form_field_item['enroll_link'] = array(
      '#type' => 'hidden',
      '#value' => $enroll_link,
    );
    $form_field_item['isAppliedCenter'] = array(
      '#type' => 'hidden',
      '#value' => $isAppliedCenter,
    );
    $form_field_item['centerListData'] = array(
      '#type' => 'hidden',
      '#value' => $centerListData,
    );
    $form_field_item['campaign'] = array(
      '#type' => 'hidden',
      '#value' => $camp,
    );
    $form_field_item['CourseId'] = array(
      '#type' => 'hidden',
      '#value' => $course_id,
    );
    $form_field_item['BatchId'] = array(
      '#type' => 'hidden',
      '#value' => $course_batch_id,
    );
    $form_field_item['CourseType'] = array(
      '#type' => 'hidden',
      '#value' => $CourseType,
    );

    $user_id = \Drupal::currentUser()->id();
        if(!empty($user_id) && $user_id > 0){

        $user = \Drupal\user\Entity\User::load($user_id);
        $userMail = $user->get('mail')->value;
        $userCustomerId = $user->get('field_customer_id')->value;
        $userMobileNo = $user->get('field_mobile_number')->value;

        $data = myapplication_prefilled_data($userMobileNo);
        //print_r($data); die('hello');

        foreach ($data as $key => $value) {
              $camp_code = $value->campaign;
              $course_code = $value->intrstd_prgrm;
              $userperclasstwelve = $value->perclasstwelve;
              $userperclassten = $value->perclassten;
              $usercrrntlpursue = $value->crrntlydoing;
              $userstrmofedu = $value->strmofedu;
              $userperclassgrad = $value->perclassgrad;
              $userttlwrkexp = $value->ttl_wrk_exp;
              $userdobrth = $value->enqry_dob;
              list($expyears, $expmonthsdec) = explode('.', $userttlwrkexp);
              $expmonths = round($expmonthsdec * 0.12);
              $app_data = '';
              if(!empty($applicationid)){
                  $app_data = '<h6><i>Application id : '.$applicationid.'</i></h6>';
              }
          }
     }



    $field_name=array();
    $field_name['CourseId']='CourseId';
    $field_name['BatchId']='BatchId';
    $field_name['campaign']='campaign';
    $field_name['create_application']='create_application';
    $field_name['enroll_link']='enroll_link';
    $field_name['isAppliedCenter']='isAppliedCenter';
    $field_name['centerListData']='centerListData';
    $field_name['CourseType']='CourseType';
    $class_count = count($form_field_item_data['field']);
    $form_field_item[HASH_PREFIX] = '<div class = "embedFormFieldCount'.$class_count.'">';

    foreach($form_field_item_data['field'] as $value){
      $field_id_name = $value['field_id'];
      $session_field_value = '';
      //$session_field_value =  isset($_SESSION['finalResult']['json_data']->$field_id_name) ? $_SESSION['finalResult']['json_data']->$field_id_name : NULL;
      $require=false;
      $field_name[$value['field_id']]=$value['field_id'];
      if($value['require'] ==1 ){$require = TRUE;}
      if($value['type'] == 'textfield'){
        
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => TEXTFIELD,
          //HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          HASH_PLACEHOLDER => t($value['caption']),
          '#attributes' => ['class' => ['form-control']],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
        ];
      }
      else if($value['type'] == 'google_place'){
        $form[$value['field_id']] = [
          HASH_TYPE => TEXTFIELD,
          //HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          HASH_PLACEHOLDER => t($value['caption']),
          '#attributes' => ['class' => ['form-control'], 'id' => 'google-place-field'],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 google-place-field">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
        ];
      }
      else if($value['type'] == 'number' && $value['field_id'] == 'enqry_crsspndnc_mbl'){
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => $value['type'],
          HASH_TITLE => t($value['caption']),
          //HASH_REQUIRED => TRUE,
          '#size' => 10,
          '#min' => $value['minlength'],
          '#max' => $value['maxlength'],
          HASH_PLACEHOLDER => t($value['caption']),
          '#attributes' => ['class' => ['form-control']],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
        ];
      }
      else if($value['type'] == 'number' && $value['field_id'] == 'ttl_wrk_exp' && !empty($userttlwrkexp)){
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => $value['type'],
         //HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          // '#size' => 10,
          '#min' => $value['minlength'],
          '#max' => $value['maxlength'],
          HASH_PLACEHOLDER => t($value['caption']),
          '#attributes' => ['class' => ['form-control']],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($expyears) ? $expyears : NULL,
        ];
      }
      else if($value['type'] == 'number' && $value['field_id'] != 'enqry_crsspndnc_mbl'){
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => $value['type'],
         //HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          // '#size' => 10,
          '#min' => $value['minlength'],
          '#max' => $value['maxlength'],
          HASH_PLACEHOLDER => t($value['caption']),
          '#attributes' => ['class' => ['form-control']],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
        ];
      }
      else if($value['type'] == 'select'){
      if($value['field_id'] == 'strmofedu' && !empty($userstrmofedu)){  
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => $value['type'],
         // HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control']],
          '#empty_value' => t($value['caption']),
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($userstrmofedu) ? $userstrmofedu : NULL,
        ];
       }
       else if($value['field_id'] == 'crrntlydoing' && !empty($usercrrntlpursue)){
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => $value['type'],
         // HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control']],
          '#empty_value' => t($value['caption']),
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($usercrrntlpursue) ? $usercrrntlpursue : NULL,
        ];
       }
       else{
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => $value['type'],
         // HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control']],
          '#empty_value' => t($value['caption']),
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
        ];
      }
      }
      /*else if($value['type'] == 'select'){
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => $value['type'],
         // HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control']],
          '#empty_value' => t($value['caption']),
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
        ];
      }*/else if($value['type'] == 'radios'){
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => $value['type'],
          HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control-radio-check']],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
        ];
      }else if($value['type'] == 'checkboxes'){
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => 'checkboxes',
         // HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control-radio-check']],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
        ];
      }else if($value['type'] == 'date' && !empty($userdobrth)){
        $break_date = '';
        if(!empty($session_field_value)){
           $break_date_array = explode('T', $session_field_value);
           $break_date = $break_date_array[0];
        }   
        $form_field_item[$value['field_id']] = [       
          HASH_TYPE => TEXTFIELD,
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
          HASH_DEFAULT_VALUE => isset($userdobrth) ? $userdobrth : NULL,
        ];
      }
      else if($value['type'] == 'date'){
      	$break_date = '';
      	if(!empty($session_field_value)){
           $break_date_array = explode('T', $session_field_value);
           $break_date = $break_date_array[0];
      	} 	
        $form_field_item[$value['field_id']] = [       
          HASH_TYPE => TEXTFIELD,
          HASH_TITLE => t($value['caption']),
          //HASH_REQUIRED => $require,
          HASH_PLACEHOLDER => t("Date of Birth"),
          '#attributes' => [
            'class' => ['form-control customdate'],
            'id' => 'customdatepicker date',
            'onfocusout' => "(this.type = 'text')",
            'onfocus' => "(this.type = 'date')",
			'min'=> '1960-01-01', 
            'max'=> '2170-01-01'
          ],
          HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 custom-label-hide">',
          HASH_SUFFIX => '</div>',
         // '#min' =>  "1960-01-01",
         // '#max' => date('Y-m-d'),
          HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $break_date,
        ];
      }
      else if($value['type'] == 'marks_percentage'){
        if($value['field_id'] == 'perclassgrad' && !empty($userperclassgrad)){
          $form_field_item[$value['field_id']] = [
            HASH_TYPE => 'textfield',
            //HASH_REQUIRED => $require,
            HASH_TITLE => t($value['caption']).'<small class="formgradTooltip">
                            <i class="fa fa-info-circle"></i>
                            <small class="gradTooltip">Enter Graduate Percentage as of date of all completed years</small>
                          </small>',
            // '#size' => 10,
            HASH_PLACEHOLDER => t("% in UG/Diploma - e.g. 55%"),
            '#attributes' => ['class' => ['form-control'], 'onkeypress' => "return onlyDouble(event);",  'minlength' => '2'],
            HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
            HASH_SUFFIX => '</div>',
            HASH_DEFAULT_VALUE => isset($userperclassgrad) ? $userperclassgrad : NULL,
          ];
        }
        else if($value['field_id'] == 'perclassgrad'){
          $form_field_item[$value['field_id']] = [
            HASH_TYPE => 'textfield',
            //HASH_REQUIRED => $require,
            HASH_TITLE => t($value['caption']).'<small class="formgradTooltip">
                            <i class="fa fa-info-circle"></i>
                            <small class="gradTooltip">Enter Graduate Percentage as of date of all completed years</small>
                          </small>',
            // '#size' => 10,
            HASH_PLACEHOLDER => t("% in UG/Diploma - e.g. 55%"),
            '#attributes' => ['class' => ['form-control'], 'onkeypress' => "return onlyDouble(event);",  'minlength' => '2'],
            HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0">',
            HASH_SUFFIX => '</div>',
            HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
          ];
        }
        else if($value['field_id'] == 'perclasstwelve' && !empty($userperclasstwelve)){
          $form_field_item[$value['field_id']] = [
            HASH_TYPE => 'textfield',
            //HASH_REQUIRED => $require,
            HASH_TITLE => t($value['caption']),
            // '#size' => 10,
            HASH_PLACEHOLDER => t("Percentage in 12th - e.g. 75%"),
            '#attributes' => ['class' => ['form-control formcontrolnew'], 'onkeypress' => "return onlyDouble(event);",  'minlength' => '2', 'disable-refocus' => 'true'],
            HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 sampleee">',
            HASH_SUFFIX => '</div>',
            HASH_DEFAULT_VALUE => isset($userperclasstwelve) ? $userperclasstwelve : NULL,
          ];
        }
        else if($value['field_id'] == 'perclasstwelve'){
          $form_field_item[$value['field_id']] = [
            HASH_TYPE => 'textfield',
            //HASH_REQUIRED => $require,
            HASH_TITLE => t($value['caption']),
            // '#size' => 10,
            HASH_PLACEHOLDER => t("Percentage in 12th - e.g. 75%"),
            '#attributes' => ['class' => ['form-control formcontrolneww'], 'onkeypress' => "return onlyDouble(event);",  'minlength' => '2', 'disable-refocus' => 'true'],
            HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 sampleee">',
            HASH_SUFFIX => '</div>',
            HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
          ];
        }else if($value['field_id'] == 'perclassten' && !empty($userperclassten)){
          $form_field_item[$value['field_id']] = [
            HASH_TYPE => 'textfield',
            //HASH_REQUIRED => $require,
            HASH_TITLE => t($value['caption']),
            // '#size' => 10,
            HASH_PLACEHOLDER => t($value['caption']),
            '#attributes' => ['class' => ['form-control formcontrolnew'], 'onkeypress' => "return onlyDouble(event);",  'minlength' => '2', 'disable-refocus' => 'true'],
            HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 sampleee">',
            HASH_SUFFIX => '</div>',
            HASH_DEFAULT_VALUE => isset($userperclassten) ? $userperclassten : NULL,
          ];
        }
        else if($value['field_id'] == 'perclassten'){
          $form_field_item[$value['field_id']] = [
            HASH_TYPE => 'textfield',
            //HASH_REQUIRED => $require,
            HASH_TITLE => t($value['caption']),
            // '#size' => 10,
            HASH_PLACEHOLDER => t("Percentage in 10th - e.g. 65%"),
            '#attributes' => ['class' => ['form-control formcontrolneww'], 'onkeypress' => "return onlyDouble(event);",  'minlength' => '2', 'disable-refocus' => 'true'],
            HASH_PREFIX => '<div class="col-md-12 '.$label_hide_class.' leadLightBox-pl0 sampleee">',
            HASH_SUFFIX => '</div>',
            HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : $session_field_value,
          ];
        }
      }
	 else if($value['type'] == 'advance_work_experience'){
        if($value['field_id'] == 'adv_ttl_wrk_exp'){
			/*******************/
			 $form_field_item['adv_work_exp']['adv_work_exp_year'] = [
				HASH_TYPE => 'select',
				HASH_REQUIRED => $require,
				//HASH_REQUIRED_ERROR =>t('Please enter Work Experience (Years - Months)'),
				//HASH_TITLE => 'Year',
				// '#size' => 10,
				//HASH_PLACEHOLDER =>'Work Experinces',
				HASH_OPTIONS => [
					//'' => 'Year(s)',
					'0' => '0',
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				  ],
				'#attributes' => ['class' => ['form-control']],
				HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0 embbed-form-label">Total Experience</div><div class="col-md-6 leadLightBox-pl0">',
				HASH_SUFFIX => '</div>',
				HASH_DEFAULT_VALUE => isset($expyears) ? $expyears : NULL,
			  ];
			  $form_field_item['adv_work_exp']['adv_work_exp_month'] = [
				HASH_TYPE => 'select',
				HASH_REQUIRED => $require,
				//HASH_REQUIRED_ERROR =>t('Please enter Work Experience (Years - Months)'),
				//HASH_TITLE => 'Month',
				// '#size' => 10,
				//HASH_PLACEHOLDER =>'Work Experinces',
				HASH_OPTIONS => [
					//'' => 'Month(s)',
					'0' => '0',
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '7',
					'8' => '8',
					'9' => '9',
					'10' => '10',
					'11' => '11',
				  ],
				'#attributes' => ['class' => ['form-control']],
				HASH_PREFIX => '<div class="col-md-6 leadLightBox-pl0">',
				HASH_SUFFIX => '</div>',
				HASH_DEFAULT_VALUE => isset($expmonths) ? $expmonths : NULL,
			  ];
			/*******************/
		}
	  }
    else if($value['type'] == 'advanced_date'){
        if($value['field_id'] == 'adv_dob_nw'){
      /*******************/
       $form_field_item['adv_dob_date']['adv_dob_date_day'] = [
        HASH_TYPE => 'select',
        HASH_REQUIRED => $require,
        HASH_OPTIONS => [
          '' => 'Day',
          '1' => '1',
          '2' => '2',
          '3' => '3',
          '4' => '4',
          '5' => '5',
          '6' => '6',
          '7' => '7',
          '8' => '8',
          '9' => '9',
          '10' => '10',
          '11' => '11',
          '12' => '12',
          '13' => '13',
          '14' => '14',
          '15' => '15',
          '16' => '16',
          '17' => '17',
          '18' => '18',
          '19' => '19',
          '20' => '20',
          '21' => '21',
          '22' => '22',
          '23' => '23',
          '24' => '24',
          '25' => '25',
          '26' => '26',
          '27' => '27',
          '28' => '28',
          '29' => '29',
          '30' => '30',
          '31' => '31',
          ],
        '#attributes' => ['class' => ['form-control']],
        HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0 embbed-form-label">Date Of Birth</div><div class="col-md-4 leadLightBox-pl0">',
        HASH_SUFFIX => '</div>',
        ];
        $form_field_item['adv_dob_date']['adv_dob_date_month'] = [
        HASH_TYPE => 'select',
        HASH_REQUIRED => $require,
        HASH_OPTIONS => [
          '' => 'Month',
          '1' => 'Jan',
          '2' => 'Feb',
          '3' => 'Mar',
          '4' => 'Apr',
          '5' => 'May',
          '6' => 'June',
          '7' => 'July',
          '8' => 'Aug',
          '9' => 'Sept',
          '10' => 'Oct',
          '11' => 'Nov',
          '12' => 'Dec',
          ],
        '#attributes' => ['class' => ['form-control']],
        HASH_PREFIX => '<div class="col-md-4 leadLightBox-pl0 pr-0 pl-0">',
        HASH_SUFFIX => '</div>',        
        ];
        $form_field_item['adv_dob_date']['adv_dob_date_year'] = [
        HASH_TYPE => 'select',
        HASH_REQUIRED => $require,
        HASH_OPTIONS => [
          '' => 'Year',
          '1970' => '1970',
          '1971' => '1971',
          '1972' => '1972',
          '1973' => '1973',
          '1974' => '1974',
          '1975' => '1975',
          '1976' => '1976',
          '1977' => '1977',
          '1978' => '1978',
          '1979' => '1979',
          '1980' => '1980',
          '1981' => '1981',
          '1982' => '1982',
          '1983' => '1983',
          '1984' => '1984',
          '1985' => '1985',
          '1986' => '1986',
          '1987' => '1987',
          '1988' => '1988',
          '1989' => '1989',
          '1990' => '1990',
          '1991' => '1991',
          '1992' => '1992',
          '1993' => '1993',
          '1994' => '1994',
          '1995' => '1995',
          '1996' => '1996',
          '1997' => '1997',
          '1998' => '1998',
          '1999' => '1999',
          '2000' => '2000',
          '2001' => '2001',
          '2002' => '2002',
          '2003' => '2003',
          '2004' => '2004',
          '2005' => '2005',
          '2006' => '2006',
          '2007' => '2007',
          '2008' => '2008',
          '2009' => '2009',
          '2010' => '2010',
          ],
        '#attributes' => ['class' => ['form-control']],
        HASH_PREFIX => '<div class="col-md-4 leadLightBox-pl0">',
        HASH_SUFFIX => '</div>',
        ];
      /*******************/
    }
    }
    
  }
  $form_field_item[HASH_SUFFIX] = '</div>';
  $this->StepTwokey=$field_name;
    $return_value['f_field']= $form_field_item;
    // $return_value['message']=$this->GetStepMessage($form_field_item_data['screen']['id']);
    $return_value['screen_id']=$form_field_item_data['screen']['id'];
    $return_value['header_msg']='<h5><b>Please fill this fields</b></h5><hr>';
    return $return_value;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldNames() {
    return $this->StepTwokey;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldsValidators() {
    return [
      
      // 'interests' => [
      //    new ValidatorRequired("It would be a lot easier for me if you could fill out some of your interests."),
      // ],
    ];
  }

}
