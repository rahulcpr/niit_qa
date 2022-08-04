<?php

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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Ajax\AddCssCommand;
use Drupal\node\Entity\Node;
use Drupal\Core\Database\Database;

/**
 * Contribute form.
 */
class SelfpacedEmbedLeadForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  protected $requestACallBack_form;
  protected $login_form;
  protected $country_code;
  protected $default_key;
  protected $default_key_country_name;
  
  public function getFormId() {
    return 'selfpaced_lead_form_id'; 
  }

  public function __construct() {
    $service = \Drupal::service('sso_user.user');
    $response = $service->getCountryAPI();
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
  public function buildForm(array $form, FormStateInterface $form_state, $node_id = NULL) {
    $config = \Drupal::config('ms_ajax_form_example.settings'); 
    $node = \Drupal\node\Entity\Node::load($node_id);
    $camp = '';
    $course_code = '';
    $prfrd_cntr = '';
    $userMobileNo = '';
    $userMail = '';
    $userName = '';
    $batchIdWith = [];
    $batchIdWith['batchId'] = '';
    $template_type = '';
    $content_type = '';
    $field_term_condition_file = '';
    if($node->hasField('field_term_condition_file')){
      if(!empty($node->get('field_term_condition_file')->getValue()[0]['target_id'])){
        $field_term_condition_file = (\Drupal\file\Entity\File::load($node->get('field_term_condition_file')->getValue()[0]['target_id']))->url();
      }
    }
    
    if($node->hasField('field_campaign_code')){
      if(!empty($node->get('field_campaign_code')->getValue()[0]['value'])){
        $camp = $node->get('field_campaign_code')->getValue()[0]['value'];
        $course_code = $node->get('field_course_code')->getValue()[0]['value'];
      }
    }
    if($node->hasField('field_center_list')){
      if(!empty($node->get('field_center_list')->getValue()[0]['value'])){
        $prfrd_cntr = $node->get('field_center_list')->getValue()[0]['value'];
      }
    }

    if($node->hasField('field_select_template')){
                if(!empty($node->get('field_select_template')->getValue()[0]['value'])){
                  $template_type=$node->get('field_select_template')->getValue()[0]['value'];
            }
      }
     if($node->getType()){
                
                  $content_type = $node->getType(); 
            
      }
    if($node->hasField('field_delivery_mode_code')){
      if(!empty($node->get('field_delivery_mode_code')->getValue()[0]['value'])){
        $course_delivery_mode_code = $node->get('field_delivery_mode_code')->getValue()[0]['value'];
      }
    }
    if($node->hasField('field_course_code')){
      if(!empty($node->get('field_course_code')->getValue()[0]['value'])){
        $course_code = $node->get('field_course_code')->getValue()[0]['value'];
      }
    }
    if($node->hasField('field_use_utm_cookie_parameters')){
      if(!empty($node->get('field_use_utm_cookie_parameters')->getValue()[0]['value'])){
        $utmFieldCheck =$node->get('field_use_utm_cookie_parameters')->getValue()[0]['value'];
      }
    }
    //$course_code = $node->get('field_course_code')->getValue()[0]['value'];
    $batchIdWith = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($course_delivery_mode_code,$course_code);
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    if(!empty($user->get('field_communication_emailid')->value)){
      $userMail = $user->get('field_communication_emailid')->value;
    }
    else{
      $userMail = $user->get('mail')->value;
    }
    $userName = $user->get('field_user_name')->value;
    $userMobileNo = $user->get('field_mobile_number')->value;    

    $form['web_container'] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'main-container',
            'class' => 'sso-user-register-form',
        ],
    ];  
    $form['web_container']['title'] = array(
      '#type' => 'markup',
      '#markup' => '<h2 class="checkEligibTitle pl-3">Register Now</h2>',
      '#allowed_tags' => ['h2', 'span'],
    );
    $form['web_container']['node_id'] = array(
        HASH_TYPE => 'hidden',
        '#value' => $node_id,
    ); 
    $form['web_container']['utmFieldCheck'] = array(
      '#type' => 'hidden',
      '#value' => $utmFieldCheck,
    );
    $form['web_container']['node_batchId'] = array(
        HASH_TYPE => 'hidden',
        '#value' => $batchIdWith['batchId'],
    ); 
    $form['web_container']['template_type'] = array(
        HASH_TYPE => 'hidden',
        '#value' => $template_type,
    );
     $form['web_container']['content_type'] = array(
        HASH_TYPE => 'hidden',
        '#value' => $content_type,
    ); 
    
    $form['web_container']['prfrd_cntr'] = [
        HASH_TYPE => 'hidden',
        '#value' => $prfrd_cntr,
      ];
      if(!empty($userName)) {
        $form['web_container']['your_name'] = array(
          HASH_TYPE => TEXTFIELD,
         // HASH_REQUIRED => TRUE,
          HASH_PLACEHOLDER => t('Full name'),
          HASH_ATTRIBUTES => array('class' => array('form-control'), 'id' => 'edit-your_name--2' , 'readonly' => 'readonly'),
          HASH_PREFIX=>'<div class="col-md-12 form-group">',
          HASH_SUFFIX=>'<div class="error-msg your-name-error"></div></div>',
          '#title' => t('Your name'),
          '#maxlength' => 30,
          '#default_value' => $userName,
        );     
      }else{
        $form['web_container']['your_name'] = array(
          HASH_TYPE => TEXTFIELD,
         // HASH_REQUIRED => TRUE,
          HASH_PLACEHOLDER => t('Full name'),
          HASH_ATTRIBUTES => array('class' => array('form-control'), 'id' => 'edit-your_name--2'),
          HASH_PREFIX=>'<div class="col-md-12 form-group">',
          HASH_SUFFIX=>'<div class="error-msg your-name-error"></div></div>',
          '#title' => t('Your name'),
          '#maxlength' => 30,
          // '#default_value' => $userName,
        );
      }
      /**********************************************
      /********* Email Field Set ******* Start ******
      /*********************************************/
       
      $EnableEmailOTP = $config->get('EnableEmailOTP');
      if(!empty($EnableEmailOTP) && $EnableEmailOTP == 1){
        $emailOtpMsgSec = '<div class="col-md-12 regotp_msg"></div>';
      }else{
        $mobileOtpMsgSec = '<div class="col-md-12 regotp_msg"></div>';
      }
      if(!empty($EnableEmailOTP) && $EnableEmailOTP == 1){
        if(!empty($userMail)){
          $form['web_container']['email'] = array(
            HASH_TYPE => TEXTFIELD,
            // HASH_REQUIRED => TRUE,
            HASH_PLACEHOLDER => t('Email ID'),
            HASH_ATTRIBUTES => array('class' => array('form-control'),'id' => 'edit-email--3' ,'readonly' => 'readonly'),
            HASH_PREFIX=>'<div class="col-md-12 form-group">',
            HASH_SUFFIX=>'<div class="error-msg your-email-error"></div></div>',
            '#title' => t('Email'),
            '#maxlength' => 40,
            '#default_value' =>  $userMail,
          );
        }else{
          $form['web_container']['email'] = array(
            HASH_TYPE => TEXTFIELD,
            HASH_PLACEHOLDER => t('Email ID'),
            HASH_ATTRIBUTES => array('class' => array('form-control mb-3')),
            HASH_PREFIX=>'<div class="col-md-12 form-group emailotpfield">',
            HASH_SUFFIX=>'<div class="error-msg your-email-error"></div>
                            <div class="register_otp-check"><span>Generate OTP</span></div>
                            <div class="otp-loader">
                              <div class="ajax-progress ajax-progress-throbber">
                                <div class="throbber">&nbsp;</div>
                                <div class="message">Please wait...</div>
                              </div>
                            </div>
                          </div>',
            '#title' => t('Email'),
            '#maxlength' => 40,
          );
          $form['web_container']['EnableEmailOTP_Check'] = array(
            HASH_TYPE => 'hidden',
            '#value' => $EnableEmailOTP,
            HASH_ATTRIBUTES => array('class' => array('EnableEmailOTP_Check')),
            HASH_SUFFIX => $emailOtpMsgSec
          );
           
          $form['web_container']['registerotp'] = array(
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
        }
        
      }else{
        $form['web_container']['email'] = array(
            HASH_TYPE => TEXTFIELD,
            // HASH_REQUIRED => TRUE,
            HASH_PLACEHOLDER => t('Email ID'),
            HASH_ATTRIBUTES => array('class' => array('form-control'),'id' => 'edit-email--3'),
            HASH_PREFIX=>'<div class="col-md-12 form-group">',
            HASH_SUFFIX=>'<div class="error-msg your-email-error"></div></div>',
            '#title' => t('Email'),
            '#maxlength' => 40,
            '#default_value' =>  $userMail,
          );
      }
      
      /**********************************************
      /********** Email Field Set ******* End *******
      /*********************************************/
    /*************************************************************************/
    $form['web_container'][UPDATECODE] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'country-code-updator-1',
        ],
        // HASH_PREFIX => '<div class="col-md-12 label-data">'.t('Mobile Number').'</div>',
        HASH_SUFFIX => $mobileOtpMsgSec
    ];
    $form['web_container'][UPDATECODE]['country'] = array(
        HASH_TYPE => 'select',
        HASH_OPTIONS => $this->country_code,
        HASH_AJAX => array(
            CALLBACK => [$this,'SetOptionCallback'],
            'wrapper' => 'country-code-updator-cvalue',
            EVENT => 'change',
            'effect' => 'fade',
        ), 
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-2 col-sm-2 col-xs-3 form-group countrySec">',
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
      $form['web_container'][UPDATECODE][CVALUE] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'country-code-updator-cvalue-1',
        ],
      ];
      $form['web_container'][UPDATECODE][CVALUE]['countrycode'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key,
        HASH_PLACEHOLDER => t('Country Code'),
        HASH_ATTRIBUTES => array('class' => array('form-control'),  'readonly' => 'readonly'),
        HASH_PREFIX=>'<div class="col-md-2 col-sm-2 col-xs-3 form-group country-code">',
        HASH_SUFFIX=>'</div>',
      );

      $form['web_container'][UPDATECODE][CVALUE]['countrycode_name'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key_country_name,
        HASH_PREFIX=>'<div class="countrycode_name">',
        HASH_SUFFIX=>'</div>',
      );

      $form['web_container'][UPDATECODE][CVALUE]['isd_name'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key_isd_name,
        HASH_PREFIX=>'<div class="isd_name">',
        HASH_SUFFIX=>'</div>',
      );
 
    $disableMobileOTP = $config->get('DisableMobileOTP');

    if(!empty($userMobileNo) || (!empty($disableMobileOTP) && $disableMobileOTP == 1)){
      if(!empty($user) && !empty($userMobileNo)){
        $form['web_container'][UPDATECODE]['mobileno'] = array(
          HASH_TYPE => 'number',
          // HASH_REQUIRED => TRUE,
          HASH_PLACEHOLDER => t('Mobile Number'),
          HASH_ATTRIBUTES => array('class' => array('form-control mobile-numbr'), 'id' => 'edit-mobileno--2', 'readonly' => 'readonly'),
          HASH_PREFIX=>'<div class="col-md-9 col-sm-9 col-xs-8 form-group pr-0 pl-1 mobilenoSec">',
          HASH_SUFFIX=>'<div class="error-msg your-mobile-error"></div></div>',
          '#default_value' => $userMobileNo,
        );
      }else{
        $form['web_container'][UPDATECODE]['mobileno'] = array(
          HASH_TYPE => 'number',
          // HASH_REQUIRED => TRUE,
          HASH_PLACEHOLDER => t('Mobile Number'),
          HASH_ATTRIBUTES => array('class' => array('form-control mobile-numbr'), 'id' => 'edit-mobileno--2'),
          HASH_PREFIX=>'<div class="col-md-9 col-sm-9 col-xs-8 form-group pr-0 pl-1 mobilenoSec">',
          HASH_SUFFIX=>'<div class="error-msg your-mobile-error"></div></div>',
          '#default_value' => $userMobileNo,
        );
      }
      
    }else{
      $form['web_container'][UPDATECODE]['mobileno'] = array(
        HASH_TYPE => 'number',
        // HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Mobile Number'),
        HASH_ATTRIBUTES => array('class' => array('form-control mobile-numbr'), 'id' => 'edit-mobileno--2'),
        HASH_PREFIX=>'<div class="col-md-9 col-sm-9 col-xs-8 form-group pr-0 pl-1 mobilenoSec">',
        HASH_SUFFIX=>'<div class="error-msg your-mobile-error"></div></div>
                      <div class="register_otp-check"><span>Generate OTP</span></div>
                      <div class="otp-loader"><div class="ajax-progress ajax-progress-throbber">
                        <div class="throbber">&nbsp;</div><div class="message">Please wait...</div>
                      </div>',
        // '#default_value' => $userMobileNo,
      );
      $form['web_container']['registerotp'] = array(
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
    }
    $form['web_container']['intrstd_prgrm'] = [
      HASH_TYPE => 'select', 
      HASH_TITLE => t('Which Course are you Interested in?'),
      '#default_value' => array(''),
      HASH_REQUIRED => TRUE,
      // HASH_PLACEHOLDER => t('Which Course are you Interested in?'),
      HASH_OPTIONS => [
      '' => t('Which Course are you Interested in?'),
      'POS51&&ST001' => $this->t('Product and Software Engineering (Job Assured*)'),
      'D123F&&ST001' => $this->t('Data Science/Machine Learning (Job Assured*)'),
      'VSRMP&&AX001' => $this->t('Banking Career with Axis Bank (Job Assured*)'),
      'PSRB&&11961' => $this->t('Banking Career with ICICI Bank (Job Assured*)'),
      'FSDMP&&ST001' => $this->t('Digital Marketing (Job Assured*)'),
      'PGPCC&&ST001' => $this->t('Cloud Computing (Job Assured*)'),
      'PGPCS&&ST001' => $this->t('Cyber Security (Job Assured*)'),
      'PGPAG&&11961' => $this->t('Accounting and Finance (Job Assistance)'),
      ],
      HASH_ATTRIBUTES => array('class' => array('form-control'), 'id' => 'edit-intrstd_prgrm--1'),
      HASH_PREFIX=>'<div class="col-md-12 form-group">',
      HASH_SUFFIX=>'<div class="error-msg your-intrstd-program-error"></div></div>',
      
      ];
    
    
      // echo '<pre>';
      $opt_query = db_select('camp_ms_form_field_data','f_data');
      $opt_query->leftjoin('camp_ms_form__field_option_fc','opt_fc','f_data.id=opt_fc.entity_id');
      $opt_query->fields('opt_fc',array('field_option_fc_value'));
      $opt_query->fields('f_data',array('title'));
      $opt_query->condition('f_data.type','select_options');
      $opt_query->condition('opt_fc.entity_id', 9);
      $opt_values = $opt_query->execute()->fetchAll();
      foreach($opt_values as $fc_data){
          $opt_default = $fc_data->title;
          $fc_ids[$fc_data->field_option_fc_value] = $fc_data->field_option_fc_value;
      }
      $options = array();
      if(!empty($fc_ids)){
          $opt_query = db_select('field_collection_item__field_opt_label','f_label');
          $opt_query->leftjoin('field_collection_item__field_option_index','f_index','f_label.entity_id=f_index.entity_id');
          $opt_query->fields('f_label',array('field_opt_label_value'));
          $opt_query->fields('f_index',array('field_option_index_value'));
          $opt_query->condition('f_label.bundle','field_option_fc');
          $opt_query->condition('f_label.entity_id',$fc_ids,'IN');
          $opt_values = $opt_query->execute()->fetchAll();
          foreach ($opt_values as $key => $value) {
            if($value->field_option_index_value >= 4 && $value->field_option_index_value <= 9){
              $new_key = $value->field_option_index_value.'@@@@'.$value->field_opt_label_value;
              $options[$new_key]= $value->field_opt_label_value;
            }
          }
      }
      krsort($options);
      /*$default_option = array("" => "Currently Pursuing");
      $form['web_container']['currently_pursuing'] = array(
        HASH_TYPE => 'select',
        HASH_PLACEHOLDER => t('Currently Pursuing'),
        HASH_OPTIONS => array_merge($default_option, $options),
        HASH_ATTRIBUTES => array('class' => array('form-control'), 'id' => 'edit-currently-pursuing'),
        HASH_PREFIX=>'<div class="col-md-12 form-group currently_pursuing_cls">',
        HASH_SUFFIX=>'<div class="error-msg your-pursuing-error"></div></div>',
        '#validated' => True,    
      );*/
      /*************************************************************************/
    

    $form['web_container']['course_code'] = array(
      HASH_TYPE => 'hidden',
      '#value' => $course_code,
    );
    $form['web_container']['campaign_code'] = array(
      HASH_TYPE => 'hidden',
      '#value' => $camp,
    );
    if(!empty($userMobileNo) || (!empty($disableMobileOTP) && $disableMobileOTP == 1)){
      $form['web_container']['mob_reg'] = array(
        HASH_TYPE => 'hidden',
        '#value' => '1',
      );
    }else{
      $form['web_container']['mob_reg'] = array(
        HASH_TYPE => 'hidden',
        '#value' => '',
     );
    }
    if(!empty($userMail) || (empty($EnableEmailOTP) && $EnableEmailOTP != 1)){
      $form['web_container']['email_reg'] = array(
        HASH_TYPE => 'hidden',
        '#value' => '1',
      );
    }else{
      $form['web_container']['email_reg'] = array(
        HASH_TYPE => 'hidden',
        '#value' => '',
     );
    }
    
    $options_kink = [
      'attributes' => [
        'class' => ['term-policy'],
        'target' => 'blank'],
    ];
    $t_link = Link::fromTextAndUrl(t('Privacy Policy'), Url::fromUri('internal:/node/2', $options_kink))->toString();
    $t_link->setGeneratedLink('<a href="https://privacy.niit.com/prospective_customer.html" target="blank">Privacy Policy</a>');
    if(!empty($field_term_condition_file)){
      $tnCFileLink = '<a href="'.$field_term_condition_file.'" target="blank">Terms and Conditions</a>, ';
    }else{
      $tnCFileLink = '';
    }
    $form['web_container']['term_policy'] = [
        HASH_TYPE  => 'checkbox',
        HASH_PREFIX => '<div class="col-md-12 user-term-policy">',
        HASH_SUFFIX => '<span class="check-label-data">I agree to ' .$tnCFileLink.''.$t_link.' & overriding DNC/NDNC request for Call/SMS</span></div>',
    
      ];
    $form['web_container']['submit'] = array(
        HASH_TYPE => SUBMIT,
        HASH_VALUE => t('Register'),
        HASH_PREFIX => '<p></p><div class = "submit-query-form-button submit-login-btn register-sub">',
        HASH_SUFFIX=> '</div>',
        HASH_ATTRIBUTES => array('class' => array('subscription-submit btn btn-block btn-primary')),
        HASH_AJAX => array(
            CALLBACK => [$this,'SubmitAjaxEmbedCallBackFunction'],
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

  public function SubmitAjaxEmbedCallBackFunction(array &$form, FormStateInterface $form_state, $form_id) {
    $ajax_response = new AjaxResponse();
    $flag_submit=1; 
    $form_data=array();
    $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
    $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
    $ajax_response->addCommand(new InvokeCommand('.form-number', 'removeClass',['error']));

    $form_data['NAME']=$form_state->getValue('your_name');
    $form_data[EMAIL_ID] = preg_replace('/\s+/', '', $form_state->getValue('email'));
    $mobile_str= str_replace(' ', '', $form_state->getValue('mobileno'));
    $mobile_str= str_replace('-', '',$mobile_str);
    $form_data['MOBILENO']=$mobile_str;
    $form_data['CountryCode'] =  preg_replace("/[^0-9]/", "", $form_state->getValue('countrycode'));
    $form_data['CountryName'] =  $form_state->getValue('countrycode_name');
    $form_data['enqry_crsspndnc_cntry'] =  $form_state->getValue('isd_name');
    $form_data['interestedProgram'] =  $form_state->getValue('intrstd_prgrm');
    $mob_verified =  $form_state->getUserInput()['mob_reg'];
    $email_verified =  $form_state->getUserInput()['email_reg'];



    $UserService=\Drupal::service('sso_user.user');
    /**validate form data */
    $validate_name =  $UserService->FormRegexValidation("/^([a-zA-Z' ]+)$/", $form_data['NAME']);
    $validate_email = $UserService->FormRegexValidation("/^([A-Za-z0-9\+_\-]+)(\.[A-Za-z0-9\+_\-]+)*@([A-Za-z0-9\-]+\.)+[A-Za-z0-9]{2,6}$/", $form_data[EMAIL_ID]);
    $validate_mobile = $UserService->FormRegexValidation("/^[0-9]{10}$/", $form_data['MOBILENO']);



    if(empty($form_state->getValue('your_name'))){
      $flag_submit=0;
      $ajax_response->addCommand(new AfterCommand('#edit-your_name--2', '<div class="unplanErrorClass">Field can not be empty.</div>'));
      $ajax_response->addCommand(new InvokeCommand('#edit-your_name--2', 'addClass',['error']));
    }
    else{
      if(!$validate_name){
          $flag_submit=0;
          $ajax_response->addCommand(new AfterCommand('#edit-your_name--2', '<div class="unplanErrorClass">Invalid user name</div>'));
          $ajax_response->addCommand(new InvokeCommand('#edit-your_name--2', 'addClass',['error']));
      }
    }

    if(empty($form_state->getValue('email'))){
      $flag_submit=0;
      $ajax_response->addCommand(new AfterCommand('#edit-email--3', '<div class="unplanErrorClass">Field can not be empty.</div>'));
      $ajax_response->addCommand(new InvokeCommand('#edit-email--3', 'addClass',['error']));
    }
    else{
      if(!filter_var($form_data[EMAIL_ID], FILTER_VALIDATE_EMAIL)){
        $ajax_response->addCommand(new AfterCommand('#edit-email--3', '<div class="unplanErrorClass">Invalid email address</div>'));
        $ajax_response->addCommand(new InvokeCommand('#edit-email--3', 'addClass',['error']));
        $flag_submit=0;
      }else{
        if($email_verified != 1){
          $ajax_response->addCommand(new AfterCommand('#edit-email--3', '<div class="unplanErrorClass">Please Verify Email Id</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-email--3', 'addClass',['error']));
            $flag_submit=0;
        }
      }
    }
    
    if(empty($form_state->getValue('mobileno'))){
      $flag_submit=0;
      $ajax_response->addCommand(new AfterCommand('#edit-mobileno--2', '<div class="unplanErrorClass">Field can not be empty.</div>'));
      $ajax_response->addCommand(new InvokeCommand('#edit-mobileno--2', 'addClass',['error']));
    }
    else{
      if(!$validate_mobile && $form_data['CountryCode'] == 91){
          $ajax_response->addCommand(new AfterCommand('#edit-mobileno--2', '<div class="unplanErrorClass">Invalid Mobile Number</div>'));
          $ajax_response->addCommand(new InvokeCommand('#edit-mobileno--2', 'addClass',['error']));
          $flag_submit=0;
      }
      else{
        if($mob_verified != 1){
          $ajax_response->addCommand(new AfterCommand('#edit-mobileno--2', '<div class="unplanErrorClass">Please Verify Mobile Number</div>'));
              $ajax_response->addCommand(new InvokeCommand('#edit-mobileno--2', 'addClass',['error']));
              $flag_submit=0;
        }
      }
      $mob_count = strlen($mobile_str);
      if($mob_count > 12){
        $ajax_response->addCommand(new AfterCommand('#edit-mobileno--2', '<div class="unplanErrorClass">Invalid Mobile Number</div>'));
        $ajax_response->addCommand(new InvokeCommand('#edit-mobileno--2', 'addClass',['error']));
        $flag_submit=0;

      }
    }
    if(empty($form_state->getValue('intrstd_prgrm'))){
      $flag_submit=0;
      $ajax_response->addCommand(new AfterCommand('#edit-intrstd_prgrm--1', '<div class="unplanErrorClass">Please select one course from list.</div>'));
      $ajax_response->addCommand(new InvokeCommand('#edit-intrstd_prgrm--1', 'addClass',['error']));
    }
    /*if(empty($form_state->getValue('currently_pursuing'))){
      $flag_submit=0;
      $ajax_response->addCommand(new AfterCommand('#edit-currently-pursuing', '<div class="unplanErrorClass">Field can not be empty.</div>'));
      $ajax_response->addCommand(new InvokeCommand('#edit-currently-pursuing', 'addClass',['error']));
    }*/
    if($flag_submit == 1){
      $name = $form_state->getValue('your_name');
      $email = $form_state->getValue('email');
      $mobile = $form_state->getValue('mobileno');
      if(!empty($form_state->getValue('node_batchId'))){
        $node_batchId = $form_state->getValue('node_batchId');
      }else{
        $node_batchId = $_REQUEST['node_batchId'];
      }
      if(!empty($form_state->getValue('template_type'))){
        $template_type = $form_state->getValue('template_type');
      }else{
        $template_type = $_REQUEST['template_type'];
      }
      if(!empty($form_state->getValue('content_type'))){
        $content_type = $form_state->getValue('content_type');
      }else{
        $content_type = $_REQUEST['content_type'];
      }

      $currently_pursuing = explode('@@@@', $form_state->getValue('currently_pursuing'));

      if($currently_pursuing[0] >= 1 && $currently_pursuing[0] <= 4){
        $prize_category = 'Graduates';
      }else if($currently_pursuing[0] >= 5 && $currently_pursuing[0] <= 9){
        $prize_category = 'College students';
      }else{
        $prize_category = '';
      }
      $course_code_array = explode("&&", $form_state->getValue('intrstd_prgrm'));
          $course_code = $course_code_array[0];
          
          
          
        if(!empty($course_code_array[1])){
          $values['prfrd_cntr'] = $course_code_array[1];
        }else{
          $values['prfrd_cntr'] = $form_state->getValue('prfrd_cntr');
        }	
      
      if(!empty($form_state->getValue('prfrd_cntr'))){
        $prfrdCenterData = $form_state->getValue('prfrd_cntr');
        $prfrd_value = explode('_', $prfrdCenterData);
        $values['prfrd_cntr'] = $prfrd_value[0];
        $values['prfrd_cntr_name'] = str_replace($prfrd_value[0]."_","", $prfrdCenterData);
      }else{
        $prfrdCenterData = $_REQUEST['prfrd_cntr'];
        $prfrd_value = explode('_', $prfrdCenterData);
        $values['prfrd_cntr'] = $prfrd_value[0];
        $values['prfrd_cntr_name'] = str_replace($prfrd_value[0]."_","", $prfrdCenterData);
      }


      // $cityData = $form_state->getValue('enqry_crsspndnc_city');
      // $state = $form_state->getValue('enqry_crsspndnc_state');
      // $prfrdCenterData = $form_state->getValue('prfrd_cntr');
      if(!empty($form_state->getValue('node_id'))){
        $node_id = $form_state->getValue('node_id');
      }else{
        $node_id = $_REQUEST['node_id'];
      }

        /**GDPR API callback function  start*/
          $request_time = \Drupal::time()->getCurrentTime();
          $formdata = array(
            'uid' => $mobile.'_'.$request_time,
            'enqry_f_nm' => $name,
            'enqry_crsspndnc_eml' => $email,
            'time' => $request_time,
          );
          $GDPR_Id = multistep_user_consentapi($formdata);
          /**GDPR API callback function  end*/
          $values['GDPR_CONSENTID'] = $GDPR_Id;
          $values['enqry_f_nm'] = $name;
          $values['enqry_crsspndnc_eml'] = $email;
          $values['enqry_crsspndnc_mbl'] = $mobile;
          $values['crrntlydoing'] = $currently_pursuing[1];
          $values['prize_category'] = $prize_category;
          $values['intrstd_prgrm'] = $course_code;

          // $values['enqry_Crrspndnc_PhnStdCd'] = $CountryCode;
          // $values['enqry_prmnnt_cntry'] = $form_state->getValue('countrycode_name');
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
		  
          $values['utm_source'] = $_REQUEST['course_code'];

		  if(!empty($form_state->getValue('campaign_code'))){
              $campaign_code = $form_state->getValue('campaign_code');
            }else{
              $campaign_code = $_REQUEST['campaign_code'];
            }
            if(!empty($form_state->getValue('course_code'))){
              $course_code = $form_state->getValue('course_code');
            }else{
              $course_code = $_REQUEST['course_code'];
            }
		  
          $API2 = array(
            'leaduniqueid' => $mobile.'_'.$request_time,
            'GDPR_CONSENTID' => $GDPR_Id,
            'source' => $campaign_code,
            'intrstd_prgrm' => $course_code,
            'leadformstg' => '',
            'enqry_crsspndnc_cntry' => $form_state->getValue('isd_name'),
            'enqry_Crrspndnc_PhnStdCd' => $CountryCode,
            'enqry_prmnnt_cntry' => $form_state->getValue('countrycode_name'),
            'enqry_Prmnnt_PhnStdCd' => $CountryCode,
          );
          $data = array_merge($API2, $values);  
          multistep_postapidate('I', $data);


          $dataArray = [
              'lead_unique_id'      => $mobile.'_'.$request_time,
              'name'                => $name,
              'mobile_number'       => $mobile,
              'email_id'            => $email,
              'campaign_code'       => $campaign_code,
              'course_code'         => $course_code,
              'currently_pursuing'  => $currently_pursuing[1],
              'prize_category'         => $prize_category,
          ];

          $database = \Drupal::database();
          $insert_query = $database->insert('custom_capture_leads_cms_table')->fields($dataArray)->execute();
          /*****************************************/
          // $current_id = '';
          $CUSTOMER_ID = '';
          $newaccount = '';
          if (\Drupal::currentUser()->isAnonymous()) {
              $create_account = automatic_registration($data);
              if(!empty($create_account)){
                 $CUSTOMER_ID = $create_account['CUSTOMER_ID'];
                 $newaccount = $create_account['newaccount'];
              }
          }else{
            $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
            $CUSTOMER_ID = $user->get('field_customer_id')->value;
            $newaccount = 'true';
          }
          if(empty(\Drupal::currentUser()->id())){
            $check_user = user_load_by_mail($email);
            \Drupal::service('session')->migrate();
            \Drupal::service('session')->set('uid', $check_user->id());
            \Drupal::moduleHandler()->invokeAll('user_login', array($check_user));
          }

          /*****************************************/
          $apiUrl = $_ENV['DOMAIN_TRAINING_COM'].'NIITDigitalPlatformAPI/api/Enrollment/GenrerateEnrollmentForEvent';
          // $apiUrl = 'https://qa.training.com/NIITDigitalPlatformAPI/api/Enrollment/GenrerateEnrollmentForEvent';
          $postData = '{
                          "centercode":"'.$values['prfrd_cntr'].'",
                          "CUSTOMERID":"'.$CUSTOMER_ID.'",
                          "FIRSTNAME":"'.$name.'",
                          "LASTNAME":"",
                          "EMAILID":"'.$email.'",
                          "MOBILENO":"'.$mobile.'",
                          "BATCHCODE":"'.$node_batchId.'",
                          "COURSECODE":"'.$course_code.'"
                    }';
          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$postData,
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json'
            ),
          ));

          $response = curl_exec($curl);
          curl_close($curl);
          $enrollmentPostApi = json_decode($response);


           /*$node = \Drupal::routeMatch()->getParameter('node');
    
            if ($node instanceof \Drupal\node\NodeInterface) {
              // You can get nid and anything else you need from the node object.
              $nid = $node->id();
              //$node = \Drupal\node\Entity\Node::load($node->id());

              if($node->hasField('field_select_template')){
                if(!empty($node->get('field_select_template')->getValue()[0]['value'])){
                  $template_type=$node->get('field_select_template')->getValue()[0]['value'];
                }
              }
            }*/

          /*****************************************/
          //  $getEnrollmentData = json_decode(file_get_contents('https://qa.training.com/NIITDigitalPlatformAPI/api/digital/enrollment/v1/customer/'.$CUSTOMER_ID.'/program/'.$course_code));
          $getEnrollmentData = json_decode(file_get_contents($_ENV['DOMAIN_TRAINING_COM'].'NIITDigitalPlatformAPI/api/digital/enrollment/v1/customer/'.$CUSTOMER_ID.'/program/'.$course_code));
        
          if($content_type == 'courses'){
            if($template_type == 'course_stackathon'){
              $btnText = 'Access Your Challenge';
              $btnTextmsg = 'Stackathon Coding Challenge';
            }else if($template_type == 'course_selfpaced'){
              $btnText = 'Access Your Course';
              $btnTextmsg = 'course';
            }else{
              $btnText = 'Access Your Course';
              $btnTextmsg = 'course';
            }
          }else if($content_type == 'self_paced_landing_page'){
            $btnText = 'Access Your Course';
            $btnTextmsg = 'course';
          }else{
            $btnText = 'Access Your Course';
            $btnTextmsg = 'course';
          }
          if(!empty($getEnrollmentData->Data) && $getEnrollmentData->TotalRecords > 0){
            $selfpacedLeadForm = '<h3>Congratulations! </h3><p>You have registered for the '.$btnTextmsg.'. Further details will mailed to you shortly.</p><div class="new_mutlistep_apply_btn"><a href="javascript:void(0);" class="clsOpenMyBatchesLink SelfpacedEmbedLeadForm" user_cid="'.$CUSTOMER_ID.'"><span class="btn btn-primary btnApply ml-5">'.$btnText.'</span></a></div>';
          }else{
            $selfpacedLeadForm = '<p>Thank you for showing your interest. We are experiencing some difficulties in registering you for the '.$btnTextmsg.'. Please try again or try after some time.</p>';
          }
          
          /*****************************************/

          $msg = '<div class="col-md-12">
          <div class="congratulation_screen mb-5">
            <img src="'.$_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india/themes/custom/nexus/assets/images/Group-3710.png">
            '.$selfpacedLeadForm.'
          </div>
          </div>
          <div style="display:none">
          Enrollment Msg: '.$enrollmentPostApi->Message.'<br>
          Get Enrollment Check Msg: '.$getEnrollmentData->Message.'<br>
          Data: '.$postData.'
          </div>';
          // $ajax_response->addCommand(new HtmlCommand('#main-container', $msg));
          $ajax_response->addCommand(new HtmlCommand('.selfpaced-lead-form-id', $msg));
    }   




    return $ajax_response;
        
  }
  
}