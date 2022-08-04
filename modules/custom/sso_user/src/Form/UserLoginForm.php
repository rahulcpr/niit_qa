<?php
/**
 * @file
 * Contains \Drupal\amazing_forms\Form\ContributeForm.
 */

namespace Drupal\sso_user\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Ajax;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Ajax\UpdateBuildIdCommand;
use Drupal\Core\Ajax\AfterCommand;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use Drupal\Core\Ajax\AddCssCommand;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\node\Entity\Node;

/**
 * Contribute form.
 */
class UserLoginForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  protected $login_form;

  public function getFormId() {

	  return 'sso_user_login_form';	
  }
  public function __construct() {
    $this->login_form = 'UserLogin';
   
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form[SSO_CONTAINER] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'main-container',
        ],
    ]; 
    $form[SSO_CONTAINER]['header_markup'] = [
      '#type' => 'markup',
      '#markup' => '<div class="regsiter-first-block"><div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4 class="modal-title">Lets Get Started</h4>
                      <p class="modalSubTitle">Sign in to continue.</p>
                    </div>',
      '#allowed_tags' => ['div', 'h4', 'strong', 'button']
    ]; 
    $config = \Drupal::config('ms_ajax_form_example.settings');  
    $niit_custom_login = $config->get('niit_custom_login');
    if(!empty($niit_custom_login) && $niit_custom_login == 1){    
      $form[SSO_CONTAINER]['user'] = array(
          HASH_TYPE => TEXTFIELD,
          // HASH_REQUIRED => TRUE,
          HASH_PLACEHOLDER => t('Email/Student ID'),
          HASH_ATTRIBUTES => array('class' => array('form-control')),
          HASH_PREFIX=>'<div class="col-md-12 form-group">',
          HASH_SUFFIX=>'</div>',
          '#title' => t('Email/Student ID'),
          '#maxlength' => 40,
      );
      // $forgotpassword_btn =
      //       '<span class="forgot_password_modal_form popup-btn login">Forgot Password?</span>';
      $form[SSO_CONTAINER]['pass'] = array(
          HASH_TYPE => PASSWORD,
          HASH_PLACEHOLDER => t('Password'),
          HASH_ATTRIBUTES => array('class' => array('form-control')),
          HASH_PREFIX=>'<div class="password-field-custom col-md-12 form-group signIn_show_form_field" id="password-field-login">',
          HASH_SUFFIX =>'<span class="hide-password"><i class="fa fa-eye" aria-hidden="true"></i></span></div>',
          '#title' => t('Password'),
          '#maxlength' => 25,
      );
      $form[SSO_CONTAINER]['current_path'] = array(
          HASH_TYPE => 'hidden',
          '#value' => $_SERVER['REQUEST_URI'],
      );
      $form[SSO_CONTAINER]['click_by_modular'] = array(
          HASH_TYPE => 'hidden',
          '#prefix' => '<div class="click_by_modular">',
          '#suffix' => '</div>',
      );

      $node = \Drupal::routeMatch()->getParameter('node');
      if ($node instanceof \Drupal\node\NodeInterface) {
        if($node->bundle() == 'course'){
          $node_id = $node->id();
          $form[SSO_CONTAINER]['node_id'] = array(
              HASH_TYPE => 'hidden',
              '#value' => $node_id,
          );
        }
      }

      $form[SSO_CONTAINER]['customerId'] = array(
          HASH_TYPE => 'textfield',
          HASH_ATTRIBUTES => array('id' => array('customerId-value')),
      );

      $form[SSO_CONTAINER]['forget_markup'] = array(
        '#type' => 'markup',
        '#markup' => '<div class="col-md-12 pr-0 signIn-reset-pwd signIn_show_form_field"><small class="float-right forgot_password_modal_form popup-btn login"><a href="#"><b>Reset Password?</b></a></small></div>'
      );

      $form[SSO_CONTAINER]['submit'] = array(
          HASH_TYPE => SUBMIT,
          HASH_VALUE => t('Login'),
          HASH_PREFIX => '<div class="mb-4 btn-signup"><div class = "col-md-12 mb-4 login_with_pwd_btn signIn_show_form_field">',
          HASH_SUFFIX=> '</div>',
          HASH_ATTRIBUTES => array('class' => array('subscription-submit btn btn-block btn-primary btn-login')),
          HASH_AJAX => array(
              CALLBACK => [$this,'AjaxCallBackLogin'],
              EVENT => 'click',
              PROGRESS => array(
                  TYPE => 'throbber',
                  MESSAGE => 'Please Wait...',
              ),
          ), 
      );

      $form[SSO_CONTAINER]['send_otp'] = array(
          HASH_TYPE => SUBMIT,
          HASH_VALUE => t('Login with OTP'),
          HASH_PREFIX => '<div class = "col-md-12 mb-4 signIn_hide_form_field login_with_otp_btn">',
          HASH_SUFFIX=>'</div></div>',
          HASH_ATTRIBUTES => array('class' => array('btn btn-block btn-primary btn-login')),
          HASH_AJAX => array(
              CALLBACK => [$this,'AjaxCallBackLoginOTPsend'],
              EVENT => 'click',
              PROGRESS => array(
                  TYPE => 'throbber',
                  MESSAGE => 'Please Wait...',
              ),
          ), 
      );

       $form[SSO_CONTAINER]['login_with_otp_link'] = array(
        '#type' => 'markup',
        '#markup' => '<div class="col-md-12 mb-3 pr-0 signInFormLoginWOTPLink signIn_show_form_field">
                      <a href="#" class="login_with_otp_link_cls">Login with OTP</a>
                    </div>',
        '#allowed_tags' => ['a', 'div']
      );
      $form[SSO_CONTAINER]['login_with_pwd_link'] = array(
        '#type' => 'markup',
        '#markup' => '<div class="col-md-12 mb-3 pr-0 signInFormLoginWPwdLink signIn_hide_form_field">
                        <a href="#" class="login_with_pwd_link_cls">Login with Password</a>
                      </div>',
        '#allowed_tags' => ['a', 'div']
      );
    }
    else{
      $form[SSO_CONTAINER]['signin_keyclock'] = array(
        '#type' => 'markup',
        '#markup' => '<p class="text-center signin-pt-1"><b><a href="/india/moLogin">Sign IN</a></b></p>',
        '#allowed_tags' => ['p', 'b', 'a', 'div']
      );
    }

    $form[SSO_CONTAINER]['signin_markup'] = array(
      '#type' => 'markup',
      '#markup' => '<p class="text-center signin-pt-1"><b> Are you a new user? <a href="#register" data-toggle="tab">Sign Up</a></b></p></div>',
      '#allowed_tags' => ['p', 'b', 'a', 'div']
    );

    $form[SSO_CONTAINER]['second-step_markup'] = array(
      '#type' => 'markup',
      '#markup' => '<div class="reg-second-step"><p class="text-center change-reg"><span id="otp-send-msg"></span><span id="change-emailotp">Change</span></p>',
      '#allowed_tags' => ['p', 'span', 'div']
    );

    $form[SSO_CONTAINER]['otp'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_PREFIX => '<div class = "col-md-12 form-group">',
        HASH_SUFFIX=>'</div>', 
        HASH_PLACEHOLDER => t('OTP'),
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        '#title' => t('Enter OTP'),
    );

    $form[SSO_CONTAINER]['otp_continue'] = array(
        HASH_TYPE => SUBMIT,
        HASH_VALUE => t('Verify'),
        HASH_PREFIX => '<div class = "otp-continue submit-login-btn">',
        HASH_SUFFIX=>'</div>',
        HASH_ATTRIBUTES => array('class' => array('btn btn-block btn-primary btn-login')),
        HASH_AJAX => array(
            CALLBACK => [$this,'AjaxCallBackLoginwithOTP'],
            EVENT => 'click',
            PROGRESS => array(
                TYPE => 'throbber',
                MESSAGE => 'Please Wait...',
            ),
        ), 
    );

    $form[SSO_CONTAINER]['resend_otp'] = array(
        HASH_TYPE => SUBMIT,
        HASH_VALUE => t('Resend OTP'),
        HASH_PREFIX => '<div class="res_text"><span>Not received your code? </span><span class="resend-otp-btn">',
        HASH_SUFFIX=>'</span></div></div>',
        //HASH_ATTRIBUTES => array('class' => array('resend-otp-btn')),
        HASH_AJAX => array(
            CALLBACK => [$this,'AjaxResendOTPsend'],
            EVENT => 'click',
            PROGRESS => array(
                TYPE => 'throbber',
                MESSAGE => 'Please Wait...',
            ),
        ), 
    );

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
  public function AjaxCallBackLogin(array &$form, FormStateInterface $form_state,$form_id) {

        $ajax_response = new AjaxResponse();
        $flag_submit=1;
        $account_links['html']='';
        $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
        $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
        $ajax_response->addCommand(new InvokeCommand('.password-field-custom', 'removeClass',['pass-error-login']));
        $email = preg_replace('/\s+/', '', $form_state->getValue('user'));
        $pass  = preg_replace('/\s+/', '', $form_state->getValue('pass'));
        if(empty($form_state->getValue('user'))){
            $ajax_response->addCommand(new AfterCommand('#edit-user', '<div class="unplanErrorClass">Field can not be empty.</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-user', 'addClass',['error']));
            $flag_submit=0;
        }
        if(empty($form_state->getValue('pass'))){
            $ajax_response->addCommand(new AfterCommand('#edit-pass', '<div class="unplanErrorClass">Field can not be empty</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-pass', 'addClass',['error']));
            $ajax_response->addCommand(new InvokeCommand('#password-field-login', 'addClass',['pass-error-login']));
            $flag_submit=0;
        }
        if($flag_submit == 1){
            $login_data['EMAILID'] = $email;
            $login_data['PASSWORD'] = $pass;
            $UserService = \Drupal::service('sso_user.user');
            $response = $UserService->userLoginAPI($login_data);
            $user_info = json_decode($response);
          //  echo '<pre>'; print_r($user_info); die();
            $userCustomerId = '';
            if($user_info->CUSTOMER_ID > 0 ){
              $userCustomerId = $user_info->CUSTOMER_ID;
              $uid = $UserService->CheckUserExists($user_info->CUSTOMER_ID);

              $user_id = $uid;
              $user = \Drupal\user\Entity\User::load($user_id);
              $userName = $user->get('field_user_name')->value;
              $userMobileNo = $user->get('field_mobile_number')->value;

              if($uid > 0 ){
                  $account_links=$UserService->GetUserAccountLinks($uid);

                  if($username != $user_info->NAME){
                    $user->set('field_user_name', $user_info->NAME);
                  }
                  if($userMobileNo != $user_info->MOBILENO){
                    $user->set('field_mobile_number', $user_info->MOBILENO);
                  }
                  if($user_info->USER_TYPE == "ENROLL"){
                    $user->set('field_student_status', 'Enrolled');
                  }else{
                    $user->set('field_student_status', '');
                  }
                  $user->set('field_communication_emailid',$user_info->EMAILID);
                  $user->set('field_customer_id', $user_info->CUSTOMER_ID);
                  $user->save();

              }else{ // echo '<pre>'; print_r($user_info); die();
                  $new_user=$UserService->RegisterNewUser($response, 'default', $email);
                  if($new_user){
                      $account_links=$UserService->GetUserAccountLinks($new_user);
                  }
              }

              $CssString = '<style>.sso-user-login-form .subscription-submit{opacity: 0.7 !important; cursor: not-allowed !important; }</style>';
              $ajax_response->addCommand(new AddCssCommand($CssString));

              $current_path =  $form_state->getUserInput()['current_path'];
              $click_by_modular =  $form_state->getUserInput()['click_by_modular'];
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

                      $userdetils = userdetails_getbyemail($email);

                      $formdata = array(
                        'uid' => $userMobileNo.'_'.$request_time,
                        'enqry_f_nm' => $userName,
                        'enqry_crsspndnc_eml' => $email,
                        'time' => $request_time,
                      );
                      $id = multistep_user_consentapi($formdata);

                      $leaddata = array();
                      $leaddata = array(
                        "orgntr_cd" => "NIIT",
                        'source' => $camp_code,
                        'orgid' => 1,
                        'enqry_f_nm' => $userName,
                        'enqry_crsspndnc_mbl' => $userMobileNo,
                        'enqry_crsspndnc_eml' => $email,
                        'prfrd_cntr' => "ooooo",
                        'prfrd_cntr_name' => 'NIIT',
                        "intrstd_prgrm" => $course_code,
                        'GDPR_CONSENTID' => $id,
                        'enroll_link' => $url,
                        'leaduniqueid' => $userMobileNo.'_'.$request_time,
                        'campaign' => $camp_code,
                        'enqry_crsspndnc_cntry' => $userdetils->Country_Code,
                        'enqry_crrspndnc_phnstdcd' => $userdetils->CountryCode,
                        'enqry_prmnnt_cntry' => $userdetils->CountryName,
                        'enqry_prmnnt_phnstdcd' => $userdetils->CountryCode,
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
                    $ajax_response->addCommand(new InvokeCommand(NULL, 'loginregister_modular', ['Login']));
                    $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['']));

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
                    $data_form = json_encode(array_merge($firstbatchdetails, ['CustomerID' => $userCustomerId]));

                 //   $ajax_response->addCommand(new HtmlCommand('#user_account_modal_form',' '));

                    if(!empty($token)){
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'customerlogin', [$data_form]));
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'modularlogin', [$token]));
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'loginregister_modular', ['Login']));
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['']));
                    }
                    else{
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['']));
                    }

                  }
                }
                else{

                  $ajax_response->addCommand(new RedirectCommand($current_path));
                //  $ajax_response->addCommand(new HtmlCommand('#user_account_modal_form',' '));
                  $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['']));

                }            
                
              }
              else{
                $ajax_response->addCommand(new RedirectCommand($current_path));
               // $ajax_response->addCommand(new HtmlCommand('#user_account_modal_form',' '));
                $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['']));
              }
               
            }else{
              $ajax_response->addCommand(new InvokeCommand('#edit-user', 'addClass',['error']));
              $ajax_response->addCommand(new InvokeCommand('#edit-pass', 'addClass',['error']));
              $ajax_response->addCommand(new AfterCommand('#edit-pass', '<div class="unplanErrorClass">Invalid user and password</div>'));
              $ajax_response->addCommand(new InvokeCommand('#password-field-login', 'addClass',['pass-error-login']));
            }
        }
        // GA Click Event code Start
        if($click_by_modular == 1){
          $ga_event_type = 'EnrollmentPopUP_Enrollment';
        }else{
          $ga_event_type = 'SignInPopUp_Enrollment';
        }
        $ga_script_content = '<div class="ga-script-div"><script>ga_signIn_signUp_event("Login", "'.$ga_event_type.'");</script></div>';
        $ajax_response->addCommand(new AfterCommand('#edit-pass', $ga_script_content));
        // GA Click Event code End

        return $ajax_response;
        
    }

    // Login OTP send
    public function AjaxCallBackLoginOTPsend(array &$form, FormStateInterface $form_state,$form_id) {

        $ajax_response = new AjaxResponse();
        $flag_submit=1;
        $account_links['html']='';
        $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
        $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
        $ajax_response->addCommand(new InvokeCommand('.password-field-custom', 'removeClass',['pass-error-login']));
        $email = preg_replace('/\s+/', '', $form_state->getValue('user'));
        if(empty($form_state->getValue('user'))){
            $ajax_response->addCommand(new AfterCommand('#edit-user', '<div class="unplanErrorClass">Field can not be empty</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-user', 'addClass',['error']));
            $flag_submit=0;
        }
        if($flag_submit == 1){
            $login_data['EMAILID'] = $email;
            $UserService = \Drupal::service('sso_user.user');
            $response = $UserService->AjaxCallBackLoginOTPsendAPI($login_data);
            $user_info = json_decode($response);
            if($user_info->Message == 'Success' ){
              $customerId = $user_info->CustomerId;
              $MobileNo = $user_info->MobileNo;
              $emailnew = $user_info->EmailID;
              

              $em   = explode("@",$emailnew);
              $name_email = implode(array_slice($em, 0, count($em)-1), '@');
              $len  = floor(strlen($name_email));
              $star_email = substr($name_email,0, 3) . str_repeat('*', ($len-3)) . "@" . end($em); 

              $send_otp_msg = 'OTP has been sent to your Email id '.$star_email.'.OTP will be valid for 5 minutes';

              if($MobileNo != 'NA'){

                $text = ' is the One Time Password(OTP) generated for SignIn';
                $UserServices = \Drupal::service('sso_user.user');
                $sms_response = $UserServices->SendOTPSMSAPI($user_info, $text);

                $mob_len = floor(strlen($MobileNo));
                $star_mob =  substr($MobileNo,0, 2) . str_repeat('*', ($mob_len-4)) . substr($MobileNo, -2, 2);

               $send_otp_msg = 'OTP has been sent to your registered mobile no '.$star_mob.' and Email id '.$star_email.'.OTP will be valid for 5 minutes';

              }

              $ajax_response->addCommand(new HtmlCommand('#otp-send-msg',$send_otp_msg));
              $ajax_response->addCommand(new InvokeCommand('#customerId-value','val',[$customerId]));
              $ajax_response->addCommand(new InvokeCommand(NULL, 'otpsectiondisplay', []));
            }else{
                $ajax_response->addCommand(new \Drupal\Core\Ajax\AfterCommand('#edit-user', '<div class="unplanErrorClass">Invalid user</div>'));
                $ajax_response->addCommand(new InvokeCommand('#edit-user', 'addClass',['error']));
            }
        }
        // GA Click Event code Start
        if($click_by_modular == 1){
          $ga_event_type = 'EnrollmentPopUP_Enrollment';
        }else{
          $ga_event_type = 'SignInPopUp_Enrollment';
        }
        $ga_script_content = '<div class="ga-script-div"><script>ga_signIn_signUp_event("LoginWithOTP", "'.$ga_event_type.'");</script></div>';
        $ajax_response->addCommand(new AfterCommand('#edit-pass', $ga_script_content));
        // GA Click Event code End

       
        return $ajax_response;
        
    }

    // Resend OTP send
    public function AjaxResendOTPsend(array &$form, FormStateInterface $form_state,$form_id) {

        $ajax_response = new AjaxResponse();
        $flag_submit=1;
        $account_links['html']='';
        $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
        $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
        $ajax_response->addCommand(new InvokeCommand('.password-field-custom', 'removeClass',['pass-error-login']));
        $email = preg_replace('/\s+/', '', $form_state->getValue('user'));
        if(empty($form_state->getValue('user'))){
            $ajax_response->addCommand(new AfterCommand('#edit-user', '<div class="unplanErrorClass">Field can not be empty</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-user', 'addClass',['error']));
            $flag_submit=0;
        }
        if($flag_submit == 1){
            $login_data['EMAILID'] = $email;
            $UserService = \Drupal::service('sso_user.user');
            $response = $UserService->AjaxCallBackLoginOTPsendAPI($login_data);
            $user_info = json_decode($response);
            if($user_info->Message == 'Success' ){
              $customerId = $user_info->CustomerId;
              $MobileNo = $user_info->MobileNo;
              $emailnew = $user_info->EmailID;

              $em   = explode("@",$emailnew);
              $name_email = implode(array_slice($em, 0, count($em)-1), '@');
              $len  = floor(strlen($name_email));
              $star_email = substr($name_email,0, 3) . str_repeat('*', ($len-3)) . "@" . end($em); 

              $send_otp_msg = 'OTP has been sent to your Email id '.$star_email.'.OTP will be valid for 5 minutes';

              if($MobileNo != 'NA'){

                $UserServices = \Drupal::service('sso_user.user');
                $text = ' is the One Time Password(OTP) generated for SignIn';
                $sms_response = $UserServices->SendOTPSMSAPI($user_info, $text);

                $mob_len = floor(strlen($MobileNo));
                $star_mob =  substr($MobileNo,0, 2) . str_repeat('*', ($mob_len-4)) . substr($MobileNo, -2, 2);

                $send_otp_msg = 'OTP has been resent to your registered mobile no '.$star_mob.' and Email id '.$star_email.'.OTP will be valid for 5 minutes.';

              }

              $ajax_response->addCommand(new HtmlCommand('#otp-send-msg',$send_otp_msg));
              $ajax_response->addCommand(new InvokeCommand('#customerId-value','val',[$customerId]));

            }else{
                $ajax_response->addCommand(new \Drupal\Core\Ajax\AfterCommand('#edit-user', '<div class="unplanErrorClass">Invalid user</div>'));
                $ajax_response->addCommand(new InvokeCommand('#edit-user', 'addClass',['error']));
            }
        }
        // GA Click Event code Start
        if($click_by_modular == 1){
          $ga_event_type = 'EnrollmentPopUP_Enrollment';
        }else{
          $ga_event_type = 'SignInPopUp_Enrollment';
        }
        $ga_script_content = '<div class="ga-script-div"><script>ga_signIn_signUp_event("ResendOTP", "'.$ga_event_type.'");</script></div>';
        $ajax_response->addCommand(new AfterCommand('#otp-send-msg', $ga_script_content));
        // GA Click Event code End

        return $ajax_response;
        
    }

    // Login OTP submit
    public function AjaxCallBackLoginwithOTP(array &$form, FormStateInterface $form_state,$form_id) {

        $ajax_response = new AjaxResponse();
        $flag_submit=1;
        $account_links['html']='';
        $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
        $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
        $ajax_response->addCommand(new InvokeCommand('.password-field-custom', 'removeClass',['pass-error-login']));
        $email = preg_replace('/\s+/', '', $form_state->getValue('user'));
        $otp  = preg_replace('/\s+/', '', $form_state->getValue('otp'));
        $customerId = $form_state->getValue('customerId');
        if(empty($form_state->getValue('user'))){
            $ajax_response->addCommand(new AfterCommand('#edit-user', '<div class="unplanErrorClass">Field can not be empty</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-user', 'addClass',['error']));
            $flag_submit=0;
        }
        if(empty($form_state->getValue('otp'))){
            $ajax_response->addCommand(new AfterCommand('#edit-otp', '<div class="unplanErrorClass">Field can not be empty</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-otp', 'addClass',['error']));
            $flag_submit=0;
        }
        if($flag_submit == 1){
            $login_data['EMAILID'] = $email;
            $login_data['OTP'] = $otp;
            $login_data['customerId'] = $customerId;
            $UserService = \Drupal::service('sso_user.user');
            $response = $UserService->AjaxCallBackLoginwithotpAPI($login_data);
            $user_info = json_decode($response);
            $userCustomerId = '';
             if(empty($user_info->ERROR_MSG)){
              $userCustomerId = $user_info->CUSTOMER_ID;
              $uid = $UserService->CheckUserExists($user_info->CustomerId);

              $user_id = $uid;
              $user = \Drupal\user\Entity\User::load($user_id);
              $userName = $user->get('field_user_name')->value;
              $userMobileNo = $user->get('field_mobile_number')->value;

              if($uid > 0 ){
                  $account_links=$UserService->GetUserAccountLinks($uid);

                  if($username != $user_info->NAME){
                    $user->set('field_user_name', $user_info->NAME);
                  }
                  if($userMobileNo != $user_info->MOBILENO){
                    $user->set('field_mobile_number', $user_info->MOBILENO);
                  }
                  $user->set('field_customer_id', $user_info->CUSTOMER_ID);
                  $user->save();

              }else{
                  $new_user=$UserService->RegisterNewUser($response,'default', $email);
                  if($new_user){
                      $account_links=$UserService->GetUserAccountLinks($new_user);
                  }
              }
              $CssString = '<style>.sso-user-login-form .subscription-submit{opacity: 0.7 !important; cursor: not-allowed !important; }</style>';
              $ajax_response->addCommand(new AddCssCommand($CssString));

              $current_path =  $form_state->getUserInput()['current_path'];
              $click_by_modular =  $form_state->getUserInput()['click_by_modular'];
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

                      $userdetils = userdetails_getbyemail($email);

                      $formdata = array(
                        'uid' => $userMobileNo.'_'.$request_time,
                        'enqry_f_nm' => $userName,
                        'enqry_crsspndnc_eml' => $email,
                        'time' => $request_time,
                      );
                      $id = multistep_user_consentapi($formdata);

                      $leaddata = array();
                      $leaddata = array(
                        "orgntr_cd" => "NIIT",
                        'source' => $camp_code,
                        'orgid' => 1,
                        'enqry_f_nm' => $userName,
                        'enqry_crsspndnc_mbl' => $userMobileNo,
                        'enqry_crsspndnc_eml' => $email,
                        'prfrd_cntr' => "ooooo",
                        'prfrd_cntr_name' => 'NIIT',
                        "intrstd_prgrm" => $course_code,
                        'GDPR_CONSENTID' => $id,
                        'enroll_link' => $url,
                        'leaduniqueid' => $userMobileNo.'_'.$request_time,
                        'campaign' => $camp_code,
                        'enqry_crsspndnc_cntry' => $userdetils->Country_Code,
                        'enqry_crrspndnc_phnstdcd' => $userdetils->CountryCode,
                        'enqry_prmnnt_cntry' => $userdetils->CountryName,
                        'enqry_prmnnt_phnstdcd' => $userdetils->CountryCode,
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

                 //   $ajax_response->addCommand(new HtmlCommand('#user_account_modal_form',' '));
                    $ajax_response->addCommand(new InvokeCommand(NULL, 'modularlogin', [$final_json_send]));
                    $ajax_response->addCommand(new InvokeCommand(NULL, 'loginregister_modular', ['Login']));
                    $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['']));

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
                    $data_form = json_encode(array_merge($firstbatchdetails, ['CustomerID' => $userCustomerId]));

                  //  $ajax_response->addCommand(new HtmlCommand('#user_account_modal_form',' '));

                    if(!empty($token)){
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'customerlogin', [$data_form]));
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'modularlogin', [$token]));
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'loginregister_modular', ['Login']));
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['']));
                    }
                    else{
                      $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['']));
                    }

                  }
                }
                else{

                  $ajax_response->addCommand(new RedirectCommand($current_path));
               //   $ajax_response->addCommand(new HtmlCommand('#user_account_modal_form',' '));
                  $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['']));

                }                 
              }
              else{
                $ajax_response->addCommand(new RedirectCommand($current_path));
            //    $ajax_response->addCommand(new HtmlCommand('#user_account_modal_form',' '));
                $ajax_response->addCommand(new InvokeCommand(NULL, 'myTest', ['']));
              }

            }
            else if(strtoupper($user_info->ERROR_MSG) ==  'OTPEXP' ){
            	$ajax_response->addCommand(new \Drupal\Core\Ajax\AfterCommand('#edit-otp', '<div class="unplanErrorClass">Your OTP is expired.</div>'));
              $ajax_response->addCommand(new InvokeCommand('#edit-otp', 'addClass',['error']));
            }
            else if(strtoupper($user_info->ERROR_MSG) ==  'OTPINVALID' ){
            	$ajax_response->addCommand(new \Drupal\Core\Ajax\AfterCommand('#edit-otp', '<div class="unplanErrorClass">Please enter the correct OTP.</div>'));
              $ajax_response->addCommand(new InvokeCommand('#edit-otp', 'addClass',['error']));
            }
            else{
                $ajax_response->addCommand(new \Drupal\Core\Ajax\AfterCommand('#edit-user', '<div class="unplanErrorClass">Invalid User</div>'));
                 $ajax_response->addCommand(new InvokeCommand('#edit-user', 'addClass',['error']));
            }
        }

        // GA Click Event code Start
        if($click_by_modular == 1){
          $ga_event_type = 'EnrollmentPopUP_Enrollment';
        }else{
          $ga_event_type = 'SignInPopUp_Enrollment';
        }
        $ga_script_content = '<div class="ga-script-div"><script>ga_signIn_signUp_event("Verify", "'.$ga_event_type.'");</script></div>';
        $ajax_response->addCommand(new AfterCommand('#edit-otp', $ga_script_content));
        // GA Click Event code End

        return $ajax_response;
        
    }
  
}

