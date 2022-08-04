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
class MultiStepExampleForm extends FormBase {
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
    return 'ms_ajax_form_example';
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
    
    $form['wrapper-messages'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'messages-wrapper',
      ],
    ];

    $form['wrapper'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'form-wrapper',
      ],
    ];

    $form['#token'] = FALSE;
    
    $form_name = 'ms_desktop';
    $gen_field=$this->step->buildStepFormElements($form_name,$nid);
    
    // Attach step form elements.
    $form['wrapper'] += $gen_field['f_field'];
    $this->StepScreenId=$gen_field['screen_id'];
    // Attach buttons.
    $form['wrapper']['actions']['#type'] = 'actions';
    $buttons = $this->step->getButtons();
    foreach ($buttons as $button) {
      /** @var \Drupal\ms_ajax_form_example\Button\ButtonInterface $button */
      $form['wrapper']['actions'][$button->getKey()] = $button->build($gen_field['screen_id']);

      if ($button->ajaxify()) {
        // Add ajax to button.
        $form['wrapper']['actions'][$button->getKey()]['#ajax'] = [
          'callback' => [$this, 'loadStep'],
          'wrapper' => 'form-wrapper',
          'effect' => 'fade',
        ];
      }

      $callable = [$this, $button->getSubmitHandler()];
      if ($button->getSubmitHandler() && is_callable($callable)) {
        // Attach submit handler to button, so we can execute it later on..
        $form['wrapper']['actions'][$button->getKey()]['#submit_handler'] = $button->getSubmitHandler();
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
      $response->addCommand(new HtmlCommand('#messages-wrapper', $messages));
    }
    else {
      // Remove messages.
      $response->addCommand(new HtmlCommand('#messages-wrapper', ''));
    }

    // Update Form.
    $response->addCommand(new HtmlCommand('#form-wrapper',
      $form['wrapper']));

    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $triggering_element = $form_state->getTriggeringElement();
	 if($this->stepId > 1){
		
		  unset($form['wrapper']['completed']);
	 }
    // Only validate if validation doesn't have to be skipped.
    // For example on "previous" button.//
    $current_user = \Drupal::currentUser()->id();
    if($this->stepId == 1 && $current_user < 1){
      $email = $form_state->getValue('enqry_crsspndnc_eml');
      $check_useremail = check_useremail($email);
      if($check_useremail == 1){
        $form['wrapper']['openloginpopup']['#value'] = 1;
        $form_state->setErrorByName('openloginpopup', 'Already Registered');
      }
      else{
        $form['wrapper']['openloginpopup']['#value'] = '';
      }
    }


   
    if ($form_state->hasValue('enqry_crsspndnc_city')) {  
      if(!empty($form_state->getValue('enqry_crsspndnc_city'))){
        $check_value_state = $form_state->getValue('enqry_crsspndnc_state');

        if (empty($form_state->getValue('enqry_crsspndnc_state'))) {
         $form_state->setErrorByName('enqry_crsspndnc_state', 'Please select a valid city');    
       }
      }
    }


    if ($form_state->hasValue('enqry_dob')) {  
     
        if (empty($form_state->getValue('enqry_dob'))) {
         $form_state->setErrorByName('enqry_dob', 'Please enter Date of birth');    
       }
      
    } 
   
    if ($form_state->hasValue('adv_dob_date_day') && $form_state->hasValue('adv_dob_date_month') && $form_state->hasValue('adv_dob_date_year'))
    {

        if(empty($form_state->getValue('adv_dob_date_day')) && empty($form_state->getValue('adv_dob_date_month')) && empty($form_state->getValue('adv_dob_date_year')))
        {
                  
                 $form_state->setErrorByName('adv_dob_date_day', 'Please enter "Day" of your DOB');
                 $form_state->setErrorByName('adv_dob_date_month', 'Please enter "Month" of your DOB');
                 $form_state->setErrorByName('adv_dob_date_year', 'Please enter "Year" of your DOB');  
          
        }
    }

    if ($form_state->hasValue('perclassten')) {  
     
        if (empty($form_state->getValue('perclassten'))) {
         $form_state->setErrorByName('perclassten', 'Please enter your 10th marks');    
       }
      
    } 

    if ($form_state->hasValue('perclasstwelve')) {  
     
        if (empty($form_state->getValue('perclasstwelve'))) {
         $form_state->setErrorByName('perclasstwelve', 'Please enter your 12th marks');    
       }
      
    } 

    if ($form_state->hasValue('crrntlydoing')) {  
     
        if (empty($form_state->getValue('crrntlydoing'))) {
         $form_state->setErrorByName('crrntlydoing', 'Please enter your Academic Status');    
       }
      
    }

    if ($form_state->hasValue('strmofedu')) {  
     
        if (empty($form_state->getValue('strmofedu'))) {
         $form_state->setErrorByName('strmofedu', 'Please enter your UG Status');    
       }
      
    }
	
	if ($form_state->hasValue('adv_work_exp_year') && $form_state->hasValue('adv_work_exp_month'))
		{
		//if(empty($form_state->getValue('adv_work_exp_year')) && empty($form_state->getValue('adv_work_exp_month')))
		if(($form_state->getValue('adv_work_exp_year')) == '' && ($form_state->getValue('adv_work_exp_month')) == '')
		{							
             $form_state->setErrorByName('adv_work_exp_year', 'Please enter your Total Experience(Years)');
             $form_state->setErrorByName('adv_work_exp_month', 'Please enter your Total Experience(Months)'); 			
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
    //session_start();
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
	   if ($name == 'adv_ttl_wrk_exp')
		{
			$values['adv_work_exp_year'] = $form_state->getValue('adv_work_exp_year');
			$values['adv_work_exp_month'] = $form_state->getValue('adv_work_exp_month');
		}
       if ($name == 'adv_dob_nw')
        {
          $values['adv_dob_date_day'] = $form_state->getValue('adv_dob_date_day');
          $values['adv_dob_date_month'] = $form_state->getValue('adv_dob_date_month');
          $values['adv_dob_date_year'] = $form_state->getValue('adv_dob_date_year');
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

        if(empty($values['prfrd_cntr']) && empty($values['prfrd_cntr_name'])){
         $prfrd_data =  $form_state->getValue('centerListData');
         $prfrd_value = explode('_', $prfrd_data);
         $values['prfrd_cntr'] = $prfrd_value[0];
         $values['prfrd_cntr_name'] = str_replace($prfrd_value[0]."_","", $prfrd_data);
         $_SESSION['formStudentPrfrdCntr'] = $prfrd_value[0];
         $_SESSION['formStudentPrfrdCntrName'] = str_replace($prfrd_value[0]."_","", $prfrd_data);
       }

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
            if(!empty($form_state->getValue('enqry_usr_language'))){
              $values['enqry_usr_language'] = $form_state->getValue('enqry_usr_language'); 
            } else {
              $values['enqry_usr_language'] = 'English';
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
				    $processed = FALSE;
		$ERROR_MESSAGE = '';
		$email = $formdata['enqry_crsspndnc_eml'];
		$referenId = $formdata['uid'];
		$mobile_number = $form_state->getValue('enqry_crsspndnc_mbl');
		$coursecode = $form_state->getValue('intrstd_prgrm');
		$whatsapp = $form_state->getValue('enqry_whatsapp_checkbox');
		if($whatsapp == 1){$whatsapp ='IN';}
		else if($whatsapp == 0){$whatsapp ='OUT';}

		if($whatsapp == 'IN' || $whatsapp == 'OUT'){

		$headers = array(
			  "content-type: application/json"
			);
		$data_array = array(
			"EmailID"=> $email,
			"CustomerId"=>"",
			"MobileNo"=>$mobile_number,
			"ReferenceId"=>$referenId,
			"URL"=>$_SERVER['HTTP_REFERER'],
			//"URL"=>$current_path,
			"Coursecode"=>$coursecode,
			"OrgId"=>"1",
			"ClientIP"=>$_SERVER['SERVER_ADDR'],
			"ServerIP"=>$_SERVER['SERVER_ADDR'],
			"UniqueID"=>$referenId,
			"Opt_In_Out"=>$whatsapp,
			"Source"=>"1A",    
			"Type"=>"SUBMIT"
		);

	// ************* Call WhatsApp API:
	$data_json = json_encode($data_array);
	
	$url = $_ENV['WhatsAppAPIURL'];
	//print_r($data_json);die;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);// set post data to true
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
	$data_response = json_decode($response);
	
	curl_close($ch);
    $result[] = '';
	if($data_response->ErrorYN == 'N'){
       $result[] = $data_response->Message;
	}	
	
	
}
          $stepdata=array_merge($API2,$values,$result);
		  
          $current_id = '';
          $CUSTOMER_ID = '';
          $newaccount = '';
          if (\Drupal::currentUser()->isAnonymous()) {
              $create_account = automatic_registration_1a($stepdata);
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
            //'source' => 'NIITCOM',
            'applicationid' => '',
            'CustomerId' => $CUSTOMER_ID,
            'RequestedURL'=> '',
            'NewSignup' => $newaccount,
            'orgid' => 1
          ];
	
	        $this->StepOneData=array_merge($stepdata,$extra_data);
            multistep_postapidate('I',$this->StepOneData);
			
			//drupal_set_message(print_r($this->StepOneData, true));
			
			//$this->StepOneData=array_merge($API2,$values,$result);
           // multistep_postapidate('I',$this->StepOneData);
		  
		  
      }else if($this->currentStepId == 2){
        unset($_SESSION['options']);
        $_SESSION['form_step'] = 0;
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
		
        if(array_key_exists("ttl_wrk_exp",$this->StepTwoData))
        {}
        else if(array_key_exists("adv_work_exp_year",$this->StepTwoData))
        {
	    $this->StepTwoData['ttl_wrk_exp'] = round(floatval($this->StepTwoData['adv_work_exp_year']) + (floatval($this->StepTwoData['adv_work_exp_month'])/12),2);
        }	

        if(array_key_exists("enqry_dob",$this->StepTwoData))
        {}
         else if(array_key_exists("adv_dob_date_day",$this->StepTwoData))
        {
           $this->StepTwoData['enqry_dob'] = $this->StepTwoData['adv_dob_date_month'].'-'.$this->StepTwoData['adv_dob_date_day'].'-'.$this->StepTwoData['adv_dob_date_year'];
        }
        
        $TwoStepData=array_merge($this->StepOneData,$this->StepTwoData);
        $TwoStepDatalead = $this->StepTwoData;
        
        $this->stepId = 6;
        
        $create_application = $TwoStepData['create_application'];
        $_SESSION['create_application'] = $create_application;
      //  if($create_application == 1){

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
           // $TwoStepDatalead['leadformstg'] = '1b';
            multistep_postapidate('U',$TwoStepData);
           // multistep_postapidate('U',$TwoStepDatalead);
          }
          
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
		   
          //$final_formdata = $TwoStepData;
          $final_formdata = array_merge($TwoStepData, $extra_data);
          $_SESSION['web_popup'] = 1;
          $_SESSION['final_formdata'] = $final_formdata;

      //  }
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
