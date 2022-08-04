<?php
/**
 * @file
 * Contains \Drupal\amazing_forms\Form\ContributeForm.
 */

namespace Drupal\sso_user\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Ajax;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AfterCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Ajax\UpdateBuildIdCommand;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Ajax\AddCssCommand;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\node\Entity\Node;

/**
 * Contribute form.
 */
class UserRegisterForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  protected $login_form;
  protected $country_code;
  protected $default_key;
  protected $default_key_country_name;

  public function getFormId() {

	  return 'sso_user_register_form';	
  }
  public function __construct() {
    $service = \Drupal::service('sso_user.user');
    $response=$service->getCountryAPI();
    $this->country_code = $response;
    $this->login_form = 'UserRegister';
    reset($response);
    $this->default_country_code = '+91@India@IN';
    $country_key_data = explode('@', $this->default_country_code);
    $this->default_key = $country_key_data[0];
    $this->default_key_country_name = $country_key_data[1];
    $this->default_key_isd_name = $country_key_data[2];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $pagetype = NULL) {

    $form[SSO_CONTAINER_TOP] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'main-container-top',
        ],
    ];
    $form[SSO_CONTAINER_TOP]['current_path'] = array(
        HASH_TYPE => 'hidden',
        //'#value' => $_SERVER['REQUEST_URI'],
		'#value' => $_SERVER['HTTP_REFERER'],
    );
    $form[SSO_CONTAINER_TOP]['click_by_modular'] = array(
        HASH_TYPE => 'hidden',
        '#prefix' => '<div class="click_by_modular">',
        '#suffix' => '</div>',
    );
    $form[SSO_CONTAINER_TOP]['pagetype'] = array(
        HASH_TYPE => 'hidden',
        '#value' => $pagetype,
    );
    $form[SSO_CONTAINER_TOP]['mob_reg'] = array(
        HASH_TYPE => 'hidden',
        '#value' => '',
    );
    $urlPath = explode('india', $_SERVER['HTTP_REFERER']);
    // $urlPath = explode('niit.test', $_SERVER['HTTP_REFERER']);
    $path = \Drupal::service('path.alias_manager')->getPathByAlias($urlPath[1]);
    if(preg_match('/node\/(\d+)/', $path, $matches)) {
      // $node = \Drupal\node\Entity\Node::load($matches[1]);
      $form[SSO_CONTAINER_TOP]['node_id'] = array(
          HASH_TYPE => 'hidden',
          HASH_ATTRIBUTES => array('id' => 'edit-node-id'),
          '#value' => $matches[1],
      );
    }
    // $node = \Drupal::routeMatch()->getParameter('node');
    // if ($node instanceof \Drupal\node\NodeInterface) {
    //   if($node->bundle() == 'course'){
    //     $node_id = $node->id();
    //     $form[SSO_CONTAINER_TOP]['node_id'] = array(
    //         HASH_TYPE => 'hidden',
    //         '#value' => $node_id,
    //     );
    //   }
    // }
    $form[SSO_CONTAINER_TOP]['header_markup'] = [
      '#type' => 'markup',
      '#markup' => '<div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4 class="modal-title">Lets Get Started</h4>
                      <p class="modalSubTitle">Sign up to continue.</p>
                    </div>',
      '#allowed_tags' => ['div', 'h4', 'strong', 'button']
    ];  
    $form[SSO_CONTAINER_TOP]['your_name'] = array(
      HASH_TYPE => TEXTFIELD,
     // HASH_REQUIRED => TRUE,
      HASH_PLACEHOLDER => t('Full name'),
      HASH_ATTRIBUTES => array('class' => array('form-control'), 'id' => 'edit-your-name'),
      HASH_PREFIX=>'<div class="col-md-12 form-group">',
      HASH_SUFFIX=>'<div class="error-msg your-name-error"></div></div>',
      '#title' => t('Your name'),
      '#maxlength' => 30,
  );     
    $form[SSO_CONTAINER_TOP]['email'] = array(
        HASH_TYPE => TEXTFIELD,
        // HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Email ID'),
        HASH_ATTRIBUTES => array('class' => array('form-control'), 'id' => 'edit-email'),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'<div class="error-msg your-email-error"></div></div>',
        '#title' => t('Email'),
        '#maxlength' => 40,
    );
    // $form[SSO_CONTAINER_TOP]['password'] = array(
    //     HASH_TYPE => PASSWORD,
    //     // HASH_REQUIRED => TRUE,
    //     HASH_PLACEHOLDER => t('Password'),
    //     HASH_ATTRIBUTES => array('class' => array('form-control')),
    //     HASH_PREFIX=>'<div class="password-field-custom col-md-12 form-group" id="password-field-custom">',
    //     HASH_SUFFIX =>'<span class="hide-password"><i class="fa fa-eye" aria-hidden="true"></i></span></div>',
    //     '#title' => t('Password'),
    // );
    $form[SSO_CONTAINER_TOP][UPDATECODE] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'country-code-updator',
        ],
        HASH_PREFIX => '<div class="col-md-12 label-data">'.t('Mobile Number').'</div>',
        HASH_SUFFIX => '<div class="col-md-12 regotp_msg"></div>'
    ];
    $form[SSO_CONTAINER_TOP][UPDATECODE]['country'] = array(
        HASH_TYPE => 'select',
        HASH_OPTIONS => $this->country_code,
        HASH_AJAX => array(
            CALLBACK => [$this,'SetOptionCallback'],
            'wrapper' => 'country-code-updator-cvalue',
            EVENT => 'change',
            'effect' => 'fade',
        ), 
        HASH_ATTRIBUTES => array('class' => array('form-control'), 'id' => 'edit-country'),
        HASH_PREFIX=>'<div class="col-md-2 col-sm-2 col-xs-3 form-group">',
        HASH_SUFFIX=>'</div>',
        '#validated' => True,
        '#default_value' =>  $this->default_country_code,
            
    );
    if($form_state->isRebuilding()){
         $country_array = explode('@', $form_state->getValue('country'));
        $this->default_key = $country_array[0];
        $this->default_key_country_name = $country_array[1];
        $this->default_key_isd_name = $country_array[2];
      }
      $form[SSO_CONTAINER_TOP][UPDATECODE][CVALUE] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'country-code-updator-cvalue',
        ],
    ];
      $form[SSO_CONTAINER_TOP][UPDATECODE][CVALUE]['countrycode'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key,
        HASH_PLACEHOLDER => t('Country Code'),
        HASH_ATTRIBUTES => array('class' => array('form-control'),  'readonly' => 'readonly'),
        HASH_PREFIX=>'<div class="col-md-2 col-sm-2 col-xs-3 form-group country-code">',
        HASH_SUFFIX=>'</div>',
      );

      $form[SSO_CONTAINER_TOP][UPDATECODE][CVALUE]['countrycode_name'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key_country_name,
        HASH_PREFIX=>'<div class="countrycode_name">',
        HASH_SUFFIX=>'</div>',
      );

      $form[SSO_CONTAINER_TOP][UPDATECODE][CVALUE]['isd_name'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key_isd_name,
        HASH_PREFIX=>'<div class="isd_name">',
        HASH_SUFFIX=>'</div>',
      );
    
    $form[SSO_CONTAINER_TOP][UPDATECODE]['mobileno'] = array(
        HASH_TYPE => 'number',
        // HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Mobile Number'),
        HASH_ATTRIBUTES => array('class' => array('form-control mobile-numbr'), 'id' => 'edit-mobileno'),
        HASH_PREFIX=>'<div class="col-md-8 col-sm-8 col-xs-6 form-group">',
        HASH_SUFFIX=>'<div class="error-msg your-mobile-error"></div></div>
                      <div class="register_otp-check"><span>Generate OTP</span></div>
                      <div class="otp-loader"><div class="ajax-progress ajax-progress-throbber">
                        <div class="throbber">&nbsp;</div><div class="message">Please wait...</div>
                      </div>',
    );
    $form[SSO_CONTAINER_TOP]['registerotp'] = array(
        HASH_TYPE => 'number',
        // HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Enter OTP'),
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group otp-register">',
        HASH_SUFFIX=>'<span class="verify-register-otp">Verify</span>
                        <div class="verify-loader"><div class="ajax-progress ajax-progress-throbber">
                          <div class="throbber">&nbsp;</div><div class="message">Please wait...</div>
                        </div></div>
                      <div class="error-msg your-otp-error"></div></div>',
        '#title' => t('OTP'),
    );
    $form[SSO_CONTAINER_TOP][SSO_CONTAINER_BOTTOM] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'main-container-bottom',
        ],
    ];
    $options_kink = [
        'attributes' => [
          'class' => ['term-policy'],
          'target' => 'blank'],
      ];
      $t_link = Link::fromTextAndUrl(t('Privacy Policy'), Url::fromUri('internal:/node/2', $options_kink))->toString();
      $t_link->setGeneratedLink('<a href="https://privacy.niit.com/prospective_customer.html" target="blank" rel="nofollow">Privacy Policy</a>');
      $form[SSO_CONTAINER_TOP][SSO_CONTAINER_BOTTOM]['term_policy'] = [
        HASH_TYPE  => 'checkbox',
        HASH_PREFIX => '<div class="col-md-12 user-term-policy">',
        HASH_SUFFIX => '<span class="check-label-data">I agree to ' .$t_link.' & overriding DNC/NDNC request for Call/SMS</span></div>',
    
      ];
      $form[SSO_CONTAINER_TOP][SSO_CONTAINER_BOTTOM]['submit'] = array(
        HASH_TYPE => SUBMIT,
        HASH_VALUE => t('Register'),
        HASH_PREFIX => '<p></p><div class = "submit-query-form-button submit-login-btn register-sub">',
        HASH_SUFFIX=>'</div>',
        HASH_ATTRIBUTES => array('class' => array('subscription-submit btn btn-block btn-primary')),
        HASH_AJAX => array(
            CALLBACK => [$this,'UserRegisterAjaxCallBack'],
            EVENT => 'click',
            PROGRESS => array(
                TYPE => 'throbber',
                MESSAGE => 'Please Wait...',
            ),
        ), 
      );

      $config = \Drupal::config('ms_ajax_form_example.settings');  
      $niit_custom_login = $config->get('niit_custom_login');
      if(!empty($niit_custom_login) && $niit_custom_login == 1){    
        $form[SSO_CONTAINER_TOP]['signup_markup'] = array(
          '#type' => 'markup',
          '#markup' => '<p class="text-center signin-pt-1"><b> Have an account? <a class="signin-user" href="#login" data-toggle="tab">Sign In</a></b></p>',
          '#allowed_tags' => ['p', 'b', 'a']
        );
      }
      else{
        $form[SSO_CONTAINER_TOP]['signup_markup'] = array(
          '#type' => 'markup',
          '#markup' => '<p class="text-center signin-pt-1"><b> Have an account? <a class="signin-user" href="/india/moLogin">Sign In</a></b></p>',
          '#allowed_tags' => ['p', 'b', 'a']
        );
      }
           return $form;
}
   /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
	  
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
  }
  public function SetOptionCallback(array &$form, FormStateInterface $form_state,$form_id){
    return $form[SSO_CONTAINER_TOP][UPDATECODE][CVALUE];
  }
  public function UserRegisterAjaxCallBack(array &$form, FormStateInterface $form_state,$form_id) {

    $ajax_response = new AjaxResponse();
    $flag_submit=1;
    $form_data=array();
    $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
    $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
    $ajax_response->addCommand(new InvokeCommand('.form-number', 'removeClass',['error']));
    // $ajax_response->addCommand(new InvokeCommand('.password-field-custom', 'removeClass',['pass-error']));
    // $ajax_response->addCommand(new InvokeCommand('.password-field-custom', 'removeClass',['pass-error-single']));
    $form_data['NAME']=$form_state->getValue('your_name');
    $form_data[EMAIL_ID] = preg_replace('/\s+/', '', $form_state->getValue('email'));
    $mobile_str= str_replace(' ', '', $form_state->getValue('mobileno'));
    $mobile_str= str_replace('-', '',$mobile_str);
    $form_data['MOBILENO']=$mobile_str;
    $form_data['CountryCode'] =  preg_replace("/[^0-9]/", "", $form_state->getValue('countrycode'));
    $form_data['CountryName'] =  $form_state->getValue('countrycode_name');
    $form_data['enqry_crsspndnc_cntry'] =  $form_state->getValue('isd_name');
    // $form_data['PASSWORD']=$form_state->getValue('password');
    $form_data['PASSWORD'] = custom_randomPassword();
    $form_data['ORG_ID']=API_ORG_ID;
    $form_data['ORG_NAME']=API_ORG_NAME;
    $form_data['ServerIP']=$_SERVER['SERVER_ADDR'];
    $form_data['ClientIP']=$_SERVER['SERVER_ADDR'];
    $form_data['SendPasswordRequestLink']='Y';
    $form_data["RequestFrom"] = "NIITCOM";
    $click_by_modular =  $form_state->getUserInput()['click_by_modular'];
    $pagetype =  $form_state->getUserInput()['pagetype'];
    $mob_verified =  $form_state->getUserInput()['mob_reg'];

   // echo '<pre>'; print_r()l die();
    
    $UserService=\Drupal::service('sso_user.user');
    /**validate form data */
    $validate_name=  $UserService->FormRegexValidation(
        "/^([a-zA-Z' ]+)$/",
        $form_data['NAME']);//arg1=pattren,arg2=value
    $validate_email= $UserService->FormRegexValidation(
        "/^([A-Za-z0-9\+_\-]+)(\.[A-Za-z0-9\+_\-]+)*@([A-Za-z0-9\-]+\.)+[A-Za-z0-9]{2,6}$/",
        $form_data[EMAIL_ID]);//arg1=pattren,arg2=value
    $validate_mobile=$UserService->FormRegexValidation(
        "/^[0-9]{10}$/",
        $form_data['MOBILENO']);
    // $validate_password=$UserService->ValidatePassword($form_data['PASSWORD']);
        /**
         * 
         */
    if(empty($form_state->getValue('your_name'))){
      $flag_submit=0;
      $ajax_response->addCommand(new AfterCommand('#edit-your-name', '<div class="unplanErrorClass">Field can not be empty.</div>'));
      $ajax_response->addCommand(new InvokeCommand('#edit-your-name', 'addClass',['error']));
    }
    else{
      if(!$validate_name){
          $flag_submit=0;
          $ajax_response->addCommand(new AfterCommand('#edit-your-name', '<div class="unplanErrorClass">Invalid user name</div>'));
          $ajax_response->addCommand(new InvokeCommand('#edit-your-name', 'addClass',['error']));
      }
    }

    if(empty($form_state->getValue('email'))){
      $flag_submit=0;
      $ajax_response->addCommand(new AfterCommand('#edit-email', '<div class="unplanErrorClass">Field can not be empty.</div>'));
      $ajax_response->addCommand(new InvokeCommand('#edit-email', 'addClass',['error']));
    }
    else{
      if(!filter_var($form_data[EMAIL_ID], FILTER_VALIDATE_EMAIL)){
        $ajax_response->addCommand(new AfterCommand('#edit-email', '<div class="unplanErrorClass">Invalid email address</div>'));
        $ajax_response->addCommand(new InvokeCommand('#edit-email', 'addClass',['error']));
        $flag_submit=0;
      }
    }
    
    if(empty($form_state->getValue('mobileno'))){
      $flag_submit=0;
      $ajax_response->addCommand(new AfterCommand('#edit-mobileno', '<div class="unplanErrorClass">Field can not be empty.</div>'));
      $ajax_response->addCommand(new InvokeCommand('#edit-mobileno', 'addClass',['error']));
    }
    else{
      if(!$validate_mobile && $form_data['CountryCode'] == 91){
          $ajax_response->addCommand(new AfterCommand('#edit-mobileno', '<div class="unplanErrorClass">Invalid Mobile Number</div>'));
          $ajax_response->addCommand(new InvokeCommand('#edit-mobileno', 'addClass',['error']));
          $flag_submit=0;
      }
      else{
    		if($mob_verified != 1){
    			$ajax_response->addCommand(new AfterCommand('#edit-mobileno', '<div class="unplanErrorClass">Please Verify Mobile Number</div>'));
              $ajax_response->addCommand(new InvokeCommand('#edit-mobileno', 'addClass',['error']));
              $flag_submit=0;
    		}
      }
//echo '<pre>'; print_r(strlen($mobile_str)); die();
      $mob_count = strlen($mobile_str);
      if($mob_count > 12){
        $ajax_response->addCommand(new AfterCommand('#edit-mobileno', '<div class="unplanErrorClass">Invalid Mobile Number</div>'));
        $ajax_response->addCommand(new InvokeCommand('#edit-mobileno', 'addClass',['error']));
        $flag_submit=0;

      }
    }

    // if($click_by_modular != 1){
    //   if(empty($form_state->getValue('password'))){
    //     $flag_submit=0;
    //     $ajax_response->addCommand(new AfterCommand('#edit-password', '<div class="unplanErrorClass">Field can not be empty.</div>'));
    //     $ajax_response->addCommand(new InvokeCommand('#edit-password', 'addClass',['error']));
    //     $ajax_response->addCommand(new InvokeCommand('#password-field-custom', 'addClass',['pass-error-single']));
    //   }
    //   else{
    //     if(!$validate_password){
    //         $str_msg="Password should have length of min 8 and max 30 characters. 
    //         It should contain alteast One Uppercase, Lowercase, Number and Special character. 
    //         It should contain '!', '@', '#', '$', '%', '^, '&' characters.";
    //         $ajax_response->addCommand(new AfterCommand('#edit-password', '<div class="unplanErrorClass">'.$str_msg.'</div>'));
    //         $ajax_response->addCommand(new InvokeCommand('#edit-password', 'addClass',['error']));
    //         $ajax_response->addCommand(new InvokeCommand('#password-field-custom', 'addClass',['pass-error']));
    //         $flag_submit=0;
    //     }
    //   }
    // }
    // else{
    //     $form_data['PASSWORD'] = custom_randomPassword();
    // }

    if($flag_submit == 1){
        $response=$UserService->UserRegisterAPI($form_data);
        $user_info=json_decode($response);
        if(empty($user_info->ERROR_MSG)){ 
            $uid=$UserService->RegisterNewUser($response,$form_data['PASSWORD'], $form_data[EMAIL_ID]);
            $userCustomerId = $user_info->CUSTOMER_ID;
            // echo '<pre>'; print_r($uid); die();
            if($uid){
              $account_links=$UserService->GetUserAccountLinks($uid);

              $current_path =  $form_state->getUserInput()['current_path'];
              
              if($click_by_modular == 1){

                $node_id = $form_state->getUserInput()['node_id'];
                $courseNodeData = Node::load($node_id);

                $course_delivery_mode_code = !empty($courseNodeData->field_delivery_mode_code->value)?$courseNodeData->field_delivery_mode_code->value:'';
                $course_code = !empty($courseNodeData->field_course_code->value)?$courseNodeData->field_course_code->value:'';
                $camp_code = !empty($courseNodeData->field_campaign_code->value)?$courseNodeData->field_campaign_code->value:'';
                $batchIdWith = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($course_delivery_mode_code,$course_code);
                $firstbatchdetails = $batchIdWith['courseBatchDetail'][0];

                if($courseNodeData->bundle() == 'course'){
                  $template_type = $courseNodeData->field_select_template->value; 
                  if($template_type == 'course_wipro'){
                    $template_type = 'course_nokia';
                  }
                  // $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
                  $utm_values = [];
                  if(!empty($_COOKIE['UTMParams'])){
                    $utm_data_array = json_decode($_COOKIE['UTMParams']);
                        if($utm_data_array->utmApplcbl == 'Y'){
                            foreach ($utm_data_array->utm_params as $key => $value) {
                               $utm_values[$key] = $value;
                            }
                        }
                  }
                  // if(!empty($reffer_array[1])){
                  //   $query_string = explode('&', $reffer_array[1]);
                  //   foreach($query_string as $val){
                  //   $check_val = substr($val, 0, 11); 
                  //     if(substr_compare($check_val ,"utm_siteid=",0) == 0){
                  //       $utm_values['SiteID'] = substr($val, 11);
                  //     }
                  //     if(substr_compare($check_val ,"utm_source=",0) == 0){
                  //       $utm_values['utm_source'] = substr($val, 11);
                  //     }
                  //     if(substr_compare(substr($val, 0, 13) ,"utm_campaign=",0) == 0){
                  //       $utm_values['utm_campaign'] = substr($val, 13);
                  //     }
                  //     if(substr_compare($check_val ,"utm_medium=",0) == 0){
                  //       $utm_values['utm_medium'] = substr($val, 11);
                  //     }
                  //     if(substr_compare(substr($val, 0, 9) ,"utm_term=",0) == 0){
                  //       $utm_values['utm_term'] = substr($val, 9);
                  //     }
                  //     if(substr_compare(substr($val, 0, 12) ,"utm_content=",0) == 0){
                  //       $utm_values['utm_content'] = substr($val, 12);
                  //     }
                  //   }
                  // }

                  if($template_type == 'course_nokia'){ 

                    $request_time = \Drupal::time()->getCurrentTime();

                    $user_id = \Drupal::currentUser()->id();
                    $user = \Drupal\user\Entity\User::load($user_id);
                    $userName = $user->get('field_user_name')->value;
                    $userMobileNo = $user->get('field_mobile_number')->value;

                    $finalResult = application_form_status($camp_code, $course_code, $user_id, 'current_user');
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
                        'enqry_crsspndnc_eml' => $form_data[EMAIL_ID],
                        'create_application' => 1,
                        'campaign' => $camp_code,
                      );
                      $new_json = array_merge($final_json, $update_data);
                      $final_json_send = create_application($new_json);
                    }
                    else{

                      $formdata_ID = array(
                        'uid' => $form_data['MOBILENO'].'_'.$request_time,
                        'enqry_f_nm' => $form_data['NAME'],
                        'enqry_crsspndnc_eml' => $form_data[EMAIL_ID],
                        'time' => $request_time,
                      );
                      $id = multistep_user_consentapi($formdata_ID);

                      $leaddata = array();
                      $leaddata = array(
                        "orgntr_cd" => "NIIT",
                        'source' => $camp_code,
                        'orgid' => 1,
                        'enqry_f_nm' => $form_data['NAME'],
                        'enqry_crsspndnc_mbl' => $form_data['MOBILENO'],
                        'enqry_crsspndnc_eml' => $form_data[EMAIL_ID],
                        'prfrd_cntr' => "ooooo",
                        'prfrd_cntr_name' => 'NIIT',
                        "intrstd_prgrm" => $course_code,
                        'GDPR_CONSENTID' => $id,
                        'enroll_link' => $url,
                        'leaduniqueid' => $form_data['MOBILENO'].'_'.$request_time,
                        'campaign' => $camp_code,
                        'enqry_crsspndnc_cntry' => $form_data['enqry_crsspndnc_cntry'],
                        'enqry_crrspndnc_phnstdcd' => $form_data['CountryCode'],
                        'enqry_prmnnt_cntry' => $form_data['CountryName'],
                        'enqry_prmnnt_phnstdcd' => $form_data['CountryCode'],
                        'leadformstg' => 'Started',
                      );
                      $leaddata = array_merge($leaddata, $utm_values);
                      multistep_postapidate('I',$leaddata);
                      $update_data = array(
                        'source' => 'NIITCOM',
                        'CustomerId' => $userCustomerId,
                        'RequestedURL'=> '',
                        'NewSignup' => 'true',
                        'TYPE' => 'I',
                        'CourseId' => $firstbatchdetails['courseID'],
                        'BatchId' => $firstbatchdetails['batchID'],
                        'enroll_link' => $url,
                        'create_application' => 1,
                      );
                      $new_json = array_merge($leaddata, $update_data);
                      $final_json_send = create_application($new_json);

                    }

                  //  $ajax_response->addCommand(new HtmlCommand('#user_account_modal_form',' '));
                    $ajax_response->addCommand(new InvokeCommand(NULL, 'modularlogin', [$final_json_send]));
                    $ajax_response->addCommand(new InvokeCommand(NULL, 'loginregister_modular', ['Register']));
                    $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['close popup']));

                  }
                  else{

                    $formdata = [
                      "CustomerID" => $userCustomerId,
                      "CourseCode" => $firstbatchdetails['courseCode'],
                      "BatchID" => $firstbatchdetails['batchID'],
                      "Centercode" => $firstbatchdetails['SRC_ICD'],
                      "Fee_Pttrn_Code" => $firstbatchdetails['patternCode'],
                      "Fee_Value" => $firstbatchdetails['batchFees'],
                    ];

                    $token = Enrollment_SaveUserProductInfo($formdata);

                    // Lead Start
                    $request_time = \Drupal::time()->getCurrentTime();
                    $formdata_ID = array(
                      'uid' => $form_data['MOBILENO'].'_'.$request_time,
                      'enqry_f_nm' => $form_data['NAME'],
                      'enqry_crsspndnc_eml' => $form_data[EMAIL_ID],
                      'time' => $request_time,
                    );
                    $id = multistep_user_consentapi($formdata_ID);
                    $values['GDPR_CONSENTID']=$id;
                    $values['enqry_f_nm'] = $form_data['NAME'];
                    $values['enqry_crsspndnc_eml'] = $form_data[EMAIL_ID];
                    $values['enqry_crsspndnc_mbl'] = $form_data['MOBILENO'];

                    $API2=array(
                      'leaduniqueid' => $form_state->getValue('enqry_crsspndnc_mbl').'_'.$request_time,
                      'GDPR_CONSENTID' => $id,
                      'source' =>  $camp_code,   
                      'prfrd_cntr' => "ZZZZZ",
                      'enqry_crsspndnc_cntry' => $form_data['enqry_crsspndnc_cntry'],
                      'enqry_crrspndnc_phnstdcd' => $form_data['CountryCode'],
                      'enqry_prmnnt_cntry' => $form_data['CountryName'],
                      'enqry_prmnnt_phnstdcd' => $form_data['CountryCode'],
                      'leadformstg' => 'Started',
                      'intrstd_prgrm' => $course_code,                                                                          
                    );

                    $data = array_merge($API2,$values);   
                    $data = array_merge($data, $utm_values);
                    multistep_postapidate('I', $data);
                    // Lead End

                    $data_form = json_encode(array_merge($firstbatchdetails, ['CustomerID' => $userCustomerId]));

                  //  $ajax_response->addCommand(new HtmlCommand('#user_account_modal_form',' '));

                    if(!empty($token)){
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'customerlogin', [$data_form]));
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'modularlogin', [$token]));
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'loginregister_modular', ['Register']));
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['close popup']));
                    }
                    else{
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['close popup']));
                    }

                  }
                }
                else{

                  $ajax_response->addCommand(new RedirectCommand($current_path));
                  $CssString = '<style>.sso-user-register-form .subscription-submit{opacity: 0.7 !important; cursor: not-allowed !important; }</style>';
                  $ajax_response->addCommand(new AddCssCommand($CssString));
               //   $ajax_response->addCommand(new HtmlCommand('#user_account_modal_form',$account_links['update_password_form']));
                  $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['close popup']));

                }  
                  
              }
              else{

                if($pagetype == 'KC'){

                  $request_time = \Drupal::time()->getCurrentTime();
                  $formdata_ID = array(
                    'uid' => $form_data['MOBILENO'].'_'.$request_time,
                    'enqry_f_nm' => $form_data['NAME'],
                    'enqry_crsspndnc_eml' => $form_data[EMAIL_ID],
                    'time' => $request_time,
                  );
                  $id = multistep_user_consentapi($formdata_ID);

                  $camp_code = 'NIITKC';

                  $leaddata = array();
                  $leaddata = array(
                    "orgntr_cd" => "NIIT",
                    'source' => $camp_code,
                    'orgid' => 1,
                    'enqry_f_nm' => $form_data['NAME'],
                    'enqry_crsspndnc_mbl' => $form_data['MOBILENO'],
                    'enqry_crsspndnc_eml' => $form_data[EMAIL_ID],
                    'prfrd_cntr' => "ZZZZZ",
                    'prfrd_cntr_name' => 'NIIT',
                    'GDPR_CONSENTID' => $id,
                    'leaduniqueid' => $form_data['MOBILENO'].'_'.$request_time,
                    'campaign' => $camp_code,
                    'enqry_crsspndnc_cntry' => $form_data['enqry_crsspndnc_cntry'],
                    'enqry_crrspndnc_phnstdcd' => $form_data['CountryCode'],
                    'enqry_prmnnt_cntry' => $form_data['CountryName'],
                    'enqry_prmnnt_phnstdcd' => $form_data['CountryCode'],
                  );

                  multistep_postapidate('I',$leaddata);

                }

                $ajax_response->addCommand(new RedirectCommand($current_path));

                $CssString = '<style>.sso-user-register-form .subscription-submit{opacity: 0.7 !important; cursor: not-allowed !important; }</style>';
                $ajax_response->addCommand(new AddCssCommand($CssString));
                // $ajax_response->addCommand(new HtmlCommand('#user-main-container-header',$account_links['html']));
              //  $ajax_response->addCommand(new HtmlCommand('#user_account_modal_form',$account_links['update_password_form']));
                $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['close popup']));
              }
            }
            else{
              $ajax_response->addCommand(new AfterCommand('#edit-email', '<div class="unplanErrorClass">Invalid Email</div>'));
              $ajax_response->addCommand(new InvokeCommand('#edit-email', 'addClass',['error']));
            }
        }else{
            if($user_info->ERROR_MSG == 'MSG-EMAIL ID ALREADY REGISTERED WITH US'){
                $ajax_response->addCommand(new AfterCommand('#edit-email', '<div class="unplanErrorClass">EMAIL ID ALREADY REGISTERED WITH US</div>'));
                $ajax_response->addCommand(new InvokeCommand('#edit-email', 'addClass',['error']));
                $ajax_response->addCommand(new AfterCommand('#edit-email--2', '<div class="unplanErrorClass">EMAIL ID ALREADY REGISTERED WITH US</div>'));
                $ajax_response->addCommand(new InvokeCommand('#edit-email--2', 'addClass',['error']));
            }else{
                $ajax_response->addCommand(new AfterCommand('#edit-password', '<div class="unplanErrorClass">'.$user_info->ERROR_MSG.'</div>'));
                $ajax_response->addCommand(new InvokeCommand('#edit-password', 'addClass',['error']));
            }
        }
    }
    // GA Click Event code Start
    if($click_by_modular == 1){
        $ga_event_type = 'EnrollmentPopUP_Enrollment';
    }else{
        if($pagetype == 'KC'){
            $ga_event_type = 'Registration';
        } else {
            $ga_event_type = 'RegisterPopUp_Enrollment';
        }
    }
    $ga_script_content = '<div class="ga-script-div"><script>ga_signIn_signUp_event("Register", "'.$ga_event_type.'", "'.$mobile_str.'");</script></div>';
    $ajax_response->addCommand(new AfterCommand('#edit-email', $ga_script_content));
    // GA Click Event code End
    return $ajax_response;
        
    }
}

