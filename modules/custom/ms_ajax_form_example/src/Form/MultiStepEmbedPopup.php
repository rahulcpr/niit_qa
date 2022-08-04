<?php

namespace Drupal\ms_ajax_form_example\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\ms_ajax_form_example\Manager\StepManager;
use Drupal\ms_ajax_form_example\Step\StepsEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provides multi step ajax example form.
 *
 * @package Drupal\ms_ajax_form_example\Form
 */
class MultiStepEmbedPopup extends FormBase {
  use StringTranslationTrait;

  /**
   * Step Id.
   *
   * @var \Drupal\ms_ajax_form_example\Step\StepsEnum
   */
  protected $stepId;
  
  protected $currentStepId;

  protected $StepOneData;
  protected $StepTwoData;
  protected $StepScreenId;

  /**
   * Multi steps of the form.
   *
   * @var \Drupal\ms_ajax_form_example\Step\StepInterface
   */
  protected $step;

  /**
   * Step manager instance.
   *
   * @var \Drupal\ms_ajax_form_example\Manager\StepManager
   */
  protected $stepManager;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    $this->stepId = StepsEnum::STEP_ONE;
    if(isset($_SESSION['form_step']) && $_SESSION['form_step'] == 2){
       $this->stepId = StepsEnum::STEP_TWO;
    }
    elseif(isset($_SESSION['form_step']) && $_SESSION['form_step'] == 3){
       $this->stepId = StepsEnum::STEP_FINALIZE;
    }
    $this->stepManager = new StepManager();
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ms_ajax_form_embed_popup';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $status_data = NULL, $nid = NULL) {

    // Get step from step manager.
    if(!empty($status_data) && $status_data['current_step'] == 2){
      $status_data_json = json_encode($status_data['finalResult']['json_data']);

      $form['status_data'] = [
        '#type' => 'textarea',
        '#default_value' => $status_data_json,
      ];
    }
    $this->step = $this->stepManager->getStep($this->stepId);
    
    $form['embed-wrapper-messages'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'embed-messages-wrapper',
      ],
    ];

    $form['embed-wrapper'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'embed-form-wrapper',
      ],
    ];

    $form['#token'] = FALSE;

    $form_name = 'ms_embed';
    $gen_field=$this->step->buildStepFormElements($form_name,$nid);
    
    // Attach step form elements.
    $form['embed-wrapper'] += $gen_field['f_field'];
    $this->StepScreenId=$gen_field['screen_id'];
    // Attach buttons.
    $form['embed-wrapper']['actions']['#type'] = 'actions';
    $buttons = $this->step->getButtons();
    foreach ($buttons as $button) {
      /** @var \Drupal\ms_ajax_form_example\Button\ButtonInterface $button */
      $form['embed-wrapper']['actions'][$button->getKey()] = $button->build($gen_field['screen_id']);

      if ($button->ajaxify()) {
        // Add ajax to button.
        $form['embed-wrapper']['actions'][$button->getKey()]['#ajax'] = [
          'callback' => [$this, 'loadStep'],
          'wrapper' => 'embed-form-wrapper',
          'effect' => 'fade',
        ];
      }

      $callable = [$this, $button->getSubmitHandler()];
      if ($button->getSubmitHandler() && is_callable($callable)) {
        // Attach submit handler to button, so we can execute it later on..
        $form['embed-wrapper']['actions'][$button->getKey()]['#submit_handler'] = $button->getSubmitHandler();
      }
    }

    return $form;

  }

  /**
   * Ajax callback to load new step.
   *
   * @param array $form
   *   Form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state interface.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Ajax response.
   */
  public function loadStep(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    $messages = drupal_get_messages();
    if (!empty($messages)) {
      // Form did not validate, get messages and render them.
      $messages = [
        '#theme' => 'status_messages',
        '#message_list' => $messages,
        '#status_headings' => [
          'status' => $this->t('Status message'),
          'error' => $this->t('Error message'),
          'warning' => $this->t('Warning message'),
        ],
      ];
      $response->addCommand(new HtmlCommand('#embed-messages-wrapper', $messages));
    }
    else {
      // Remove messages.
      $response->addCommand(new HtmlCommand('#embed-messages-wrapper', ''));
    }

    // Update Form.
    $response->addCommand(new HtmlCommand('#embed-form-wrapper',
      $form['embed-wrapper']));

    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $triggering_element = $form_state->getTriggeringElement();
    // Only validate if validation doesn't have to be skipped.
    // For example on "previous" button.//

    $current_user = \Drupal::currentUser()->id();
    if($this->stepId == 1 && $current_user < 1){
      $email = $form_state->getValue('enqry_crsspndnc_eml');
      $check_useremail = check_useremail($email);
      if($check_useremail == 1){
        $form['embed-wrapper']['openloginpopup']['#value'] = 1;
        $form_state->setErrorByName('openloginpopup', 'Already Registered');
      }
      else{
        $form['embed-wrapper']['openloginpopup']['#value'] = '';
      }
    }

    if ($form_state->hasValue('enqry_dob')) {
      if(!empty($form_state->getValue('enqry_dob'))){
        $check_value = $form_state->getValue('enqry_dob');
        $strtotime = strtotime($check_value);
        $now = strtotime("now");
        if($strtotime > $now){
         $form_state->setErrorByName('enqry_dob', 'Date of birth cannot be a future date.');
        }
        $data_array = explode('-', date('Y-m-d', $strtotime));
        if($data_array[0] < 1960){
         $form_state->setErrorByName('enqry_dob', 'Date of birth is invalid.');
        }
      }
    }


    if ($form_state->hasValue('perclassten')) {
      if(!empty($form_state->getValue('perclassten'))){
        $check_value = $form_state->getValue('perclassten');
        if(is_numeric($check_value)){
          if($check_value < 11 || $check_value > 100){
           $form_state->setErrorByName('perclassten', 'Percentage range between 11 to 100');
          }
        }
        else{
          $form_state->setErrorByName('perclassten', 'Allow only numbers in 10th percentage');
        }
      }
    }

    if ($form_state->hasValue('perclasstwelve')) {
      if(!empty($form_state->getValue('perclasstwelve'))){
        $check_value = $form_state->getValue('perclasstwelve');
        if(is_numeric($check_value)){
          if($check_value < 11 || $check_value > 100){
           $form_state->setErrorByName('perclasstwelve', 'Percentage range between 11 to 100');
          }
        }
        else{
          $form_state->setErrorByName('perclasstwelve', 'Allow only numbers in 12th percentage');
        }
      }
    }

    if ($form_state->hasValue('crrntlydoing')) {
      if(!empty($form_state->getValue('crrntlydoing'))){
        $check_value = $form_state->getValue('crrntlydoing');
        if($check_value == 'Completed Graduation' || $check_value == 'Post Graduate' || $check_value == 'Working Professional' || $check_value == 'Pursuing Post Graduation' || $check_value == '3rd Year of Graduation' || $check_value == '4th Year of Graduation' || $check_value == 'Given Final Year Graduation Exams Awaiting Result'){
          if(empty($form_state->getValue('perclassgrad'))){
             $form_state->setErrorByName('perclassgrad', 'Graduation percentage field is required.');
          }
        }
      }
    }

    if ($form_state->hasValue('perclassgrad')) {
      if(!empty($form_state->getValue('perclassgrad'))){
        $check_value = $form_state->getValue('perclassgrad');
        if(is_numeric($check_value)){
          if($check_value < 11 || $check_value > 100){
           $form_state->setErrorByName('perclassgrad', 'Percentage range between 11 to 100');
          }
        }
        else{
           $form_state->setErrorByName('perclassgrad', 'Allow only numbers in graduation percentage');
        }
      }
    }

    if (empty($triggering_element['#skip_validation']) && $fields_validators = $this->step->getFieldsValidators()) {
      // Validate fields.
      foreach ($fields_validators as $field => $validators) {
        // Validate all validators for field.
        $field_value = $form_state->getValue($field);
        foreach ($validators as $validator) {
          if (!$validator->validates($field_value)) {
            $form_state->setErrorByName($field, $validator->getErrorMessage());
          }
        }
      }

    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
   
    // Save filled values to step. So we can use them as default_value later on.
    session_start();
    $values = [];
    $form_data=[];
    $this->currentStepId=$this->stepId;
    foreach ($this->step->getFieldNames() as $name) {
       if($name != 'enqry_crsspndnc_city' || $name != 'prfrd_cntr'){
         $values[$name] = $form_state->getValue($name);
       }
       if($name == 'prfrd_cntr'){
         $prfrd_data =  $form_state->getValue($name);
         $prfrd_value = explode('_', $prfrd_data);
         $values['prfrd_cntr'] = $prfrd_value[0];
         $values['prfrd_cntr_name'] = str_replace($prfrd_value[0]."_","", $prfrd_data);
         $_SESSION['formStudentPrfrdCntr'] = $prfrd_value[0];
         $_SESSION['formStudentPrfrdCntrName'] = str_replace($prfrd_value[0]."_","", $prfrd_data);
       }
       if($name == 'enqry_crsspndnc_city'){
        $city_array = explode(", ", $form_state->getValue($name));
        $values[$name] = $city_array[0];
        $_SESSION['formStudentCity'] = $city_array[0];
       }
    }
    if(!empty($form_state->getValue('enqry_crsspndnc_state'))){
      $values['enqry_crsspndnc_state'] = $form_state->getValue('enqry_crsspndnc_state');
      $_SESSION['formStudentState'] = $form_state->getValue('enqry_crsspndnc_state');
    } 
    if(!empty($form_state->getValue('enqry_crsspndnc_mbl'))){
      $_SESSION['formStudentMobile'] = md5($form_state->getValue('enqry_crsspndnc_mbl'));
    }
   
    $this->step->setValues($values);
    // Add step to manager.
    $this->stepManager->addStep($this->step);
    // Set step to navigate to.
    $triggering_element = $form_state->getTriggeringElement();
    if($triggering_element['#value'] == 'Previous'){
      $this->stepId = $triggering_element['#goto_step'];
    }else if($triggering_element['#value'] == 'Finish!'){
      $_SESSION["form_submit"]='submited successfully';
      $this->stepId = 6;
    }else{
      if($this->currentStepId == 1){
        $_SESSION['finalResult'] = '';
        $_SESSION['check_eligibility'] = '';
        unset($_SESSION['finalResult']);
        unset($_SESSION['check_eligibility']);
        $_SESSION['prev_three_display'] = '';
        unset($_SESSION['prev_three_display']);
        $this->stepId = 2;
        $_SESSION["get_form"] = $form_state->getValue('get_form');
        $_SESSION["last_step"] = $this->currentStepId;
        $_SESSION['step_message'] = $form_state->getValue('enqry_f_nm');
        $_SESSION['screen_id'] = $this->StepScreenId;
        
        /**API callback function */
        $request_time = \Drupal::time()->getCurrentTime();
        $_SESSION['time']=$request_time;
          $formdata = array(
            'uid' => $form_state->getValue('enqry_crsspndnc_mbl').'_'.$request_time,
            'enqry_f_nm' => $form_state->getValue('enqry_f_nm'),
            'enqry_crsspndnc_eml' => $form_state->getValue('enqry_crsspndnc_eml'),
            'time' => $request_time,
            );
            $id = multistep_user_consentapi($formdata);
            $values['GDPR_CONSENTID']=$id;

            if(!empty($formdata['uid'])){
                $_SESSION['formStudentLeadId'] = $formdata['uid'];
            }

            /**get intent name */
            $intent_value = '';
            if(!empty($form_state->getValue('get_form'))){
                $intent_query=db_select('camp_ms_form_field_data','f_data');
                $intent_query->leftjoin('camp_ms_form__field_intent_code','i_code','f_data.id=i_code.entity_id');
                $intent_query->fields('f_data',array('title'));
                $intent_query->condition('f_data.type','intent_master');
                $intent_query->condition('i_code.field_intent_code_value',$form_state->getValue('get_form'));
                $intent_name=$intent_query->execute()->fetchCol();
                $intent_value = $intent_name[0];
            }
            
            $API2=array(
              'leaduniqueid' => $form_state->getValue('enqry_crsspndnc_mbl').'_'.$request_time,
              'GDPR_CONSENTID' => $id,
              'Intent' => $intent_value,
              'orgid' => 1
            );

            if(!empty($form_state->getValue('enqry_dob'))){
                $enq_date = strtotime($form_state->getValue('enqry_dob'));
                $values['enqry_dob'] = date('Y-m-d', $enq_date);
                $_SESSION['formStudentDOB'] = date('Y-m-d', $enq_date);
            }
            $values['eligibleflg'] = '';
            $values['leadformstg'] = '1a';
            if($form_state->getValue('utmFieldCheck') == 1){
                if(!empty($_COOKIE['UTMParams'])){
                $utm_data_array = json_decode($_COOKIE['UTMParams']);
                if($utm_data_array->utmApplcbl == 'Y'){
                  foreach ($utm_data_array->utm_params as $key => $value) {
                     $values[$key] = $value;
                  }
                }
              }
            }else{
              $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
              if(!empty($reffer_array[1])){
                $query_string = explode('&', $reffer_array[1]);
                foreach($query_string as $val){
                  $data = explode("=", $val);
                  if($data[0] == 'utm_siteid'){
                    $values['SiteID'] = $data[1];
                  }else{
                    $values[$data[0]] = $data[1];
                  }
                }
              }
            }
            // $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
            // if(!empty($reffer_array[1])){
            //   $query_string = explode('&', $reffer_array[1]);
            //   foreach($query_string as $val){
            //   $check_val = substr($val, 0, 11); 
            //     if(substr_compare($check_val ,"utm_siteid=",0) == 0){
            //       $values['SiteID'] = substr($val, 11);
            //     }
            //     if(substr_compare($check_val ,"utm_source=",0) == 0){
            //       $values['utm_source'] = substr($val, 11);
            //     }
            //     if(substr_compare(substr($val, 0, 13) ,"utm_campaign=",0) == 0){
            //       $values['utm_campaign'] = substr($val, 13);
            //     }
            //     if(substr_compare($check_val ,"utm_medium=",0) == 0){
            //       $values['utm_medium'] = substr($val, 11);
            //     }
            //     if(substr_compare(substr($val, 0, 9) ,"utm_term=",0) == 0){
            //       $values['utm_term'] = substr($val, 9);
            //     }
            //     if(substr_compare(substr($val, 0, 12) ,"utm_content=",0) == 0){
            //       $values['utm_content'] = substr($val, 12);
            //     }
            //   }
            // }
            $this->StepOneData=array_merge($API2,$values);
            multistep_postapidate('I',$this->StepOneData);
      }else if($this->currentStepId == 2){
        unset($_SESSION['options']);
        unset($_SESSION['form_step']);
        if(!empty($form_state->getValue('enqry_dob'))){
            $enq_date = strtotime($form_state->getValue('enqry_dob'));
            $values['enqry_dob'] = date('Y-m-d', $enq_date);
            $_SESSION['formStudentDOB'] = date('Y-m-d', $enq_date);
        }

        if(!empty($form_state->getValue('status_data'))){
          $this->StepOneData = (array) json_decode($form_state->getValue('status_data'));

          $consentapi_formdata = array(
            'uid' => $this->StepOneData['leaduniqueid'],
            'enqry_f_nm' => $this->StepOneData['enqry_f_nm'],
            'enqry_crsspndnc_eml' => $this->StepOneData['enqry_crsspndnc_eml'],
            'time' => $request_time,
          );
          $GDPR_CONSENTID_id = multistep_user_consentapi($consentapi_formdata);
          $this->StepOneData['GDPR_CONSENTID']=$GDPR_CONSENTID_id;
        }
   
        $this->StepTwoData = $values;
        $_SESSION['screen_id'] = $this->StepScreenId;
        $_SESSION["last_step"] = $this->currentStepId;
        $TwoStepData=array_merge($this->StepOneData,$this->StepTwoData);
        
        $this->stepId = 6;
        // $_SESSION['step_message'] = $form_state->getValue('enqry_f_nm');
        
        $create_application = $TwoStepData['create_application'];
        $_SESSION['create_application'] = $create_application;
       // if($create_application == 1){

          //Check eligibility
          $check_eligibility = check_eligibility($TwoStepData);
          if(!empty($check_eligibility)){
            $_SESSION['check_eligibility'] = $check_eligibility;
            if($check_eligibility['IsEligible'] == 1){
              $TwoStepData['eligibleflg'] = 'Y';
              $_SESSION['prev_three_display'] = 0;
            }
            elseif($check_eligibility['IsEligible'] == 0){
              $TwoStepData['eligibleflg'] = 'N';
              $_SESSION['prev_three_display'] = 1;
            }
            else{
               die();
            }
            $TwoStepData['leadformstg'] = '1b';
            multistep_postapidate('U',$TwoStepData);
          }
          
        //  echo'<pre>'; print_r($check_eligibility);
          $current_id = '';
          $CUSTOMER_ID = '';
          $newaccount = '';
          if (\Drupal::currentUser()->isAnonymous()) {
              $create_account = automatic_registration($TwoStepData);
              if(!empty($create_account)){
                 $CUSTOMER_ID = $create_account['CUSTOMER_ID'];
                 $newaccount = $create_account['newaccount'];
              }
          }
          else{
            $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
            $CUSTOMER_ID = $user->get('field_customer_id')->value;
            $newaccount = 'true';
          }
          
          $extra_data = [
            'source' => 'NIITCOM',
            'applicationid' => '',
            'CustomerId' => $CUSTOMER_ID,
            'RequestedURL'=> '',
            'NewSignup' => $newaccount,
            'orgid' => 1
          ];
          $final_formdata = array_merge($TwoStepData, $extra_data);
          $_SESSION['final_formdata'] = $final_formdata;

        // }
        // else{
        //   multistep_postapidate('U',$TwoStepData);
        // }
      }
    }
    // $this->stepId = $triggering_element['#goto_step'];
    

    // If an extra submit handler is set, execute it.
    // We already tested if it is callable before.
    if (isset($triggering_element['#submit_handler'])) {
      $this->{$triggering_element['#submit_handler']}($form, $form_state);
    }
    
    $form_state->setRebuild(TRUE);
  }

  /**
   * Submit handler for last step of form.
   *
   * @param array $form
   *   Form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state interface.
   */
  public function submitValues(array &$form, FormStateInterface $form_state) {
    // echo 'call submit form handler';die;
    // Submit all values to DB or do whatever you want on submit.
  }

}
