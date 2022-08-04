<?php
/**
 * @file
 * Contains \Drupal\sso_user\Form\AssessentForm.
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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Ajax\AddCssCommand;
use Drupal\node\Entity\Node;

/**
 * Contribute form.
 */
class AssessentForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  protected $assessemt_form;
  protected $country_code;
  protected $default_key;
  protected $default_key_country_name;
  
  public function getFormId() {
    return 'sso_user_assessemt_form'; 
  }
  public function __construct() {
    $service = \Drupal::service('sso_user.user');
    $response=$service->getCountryAPI();
    $this->country_code = $response;
    reset($response);
    $this->default_country_code = '+91@India@IN';
    if(\Drupal::currentUser()->id() > 0){
      $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
      $userMail = $user->get('mail')->value;

      $userdetils = userdetails_getbyemail($userMail);
      $cntry_cd = $userdetils->Country_Code;
      $phonestd = $userdetils->CountryCode;
      $cntry_name = $userdetils->CountryName;
      if(!empty($phonestd)){
        $this->default_country_code = '+'.$phonestd.'@'.$cntry_name.'@'.$cntry_cd;
      }
    }
    $country_key_data = explode('@', $this->default_country_code);
    $this->default_key = $country_key_data[0];
    $this->default_key_country_name = $country_key_data[1];
    $this->default_key_isd_name = $country_key_data[2];
    $this->assessemt_form = 'AssessentForm';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $userMail = $user->get('mail')->value;
    $userName = $user->get('field_user_name')->value;
    $userMobileNo = $user->get('field_mobile_number')->value;  

    $node = \Drupal::routeMatch()->getParameter('node');
    
    $campaignCode = 'NIITCOM';
    $course_code = 'NIITCOM';
    $course_id = 0;
    $course_batch_id = 0;
    if ($node instanceof \Drupal\node\NodeInterface) {
      $campaignCode = $node->get('field_campaign_code')->getValue()[0]['value'];
      $assestCode = $node->get('field_activity_code')->getValue()[0]['value'];

      $deliverymode_code = $node->get('field_delivery_mode_code')->getValue()[0]['value'];
      $course_code = $node->get('field_course_code')->getValue()[0]['value'];
      $batchIdWith = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($deliverymode_code,$course_code);
      $mainCoursedetails = $batchIdWith['courseBatchDetail'][0];

      if(!empty($mainCoursedetails['courseBatchDetail'][0])){
        $course_id = $mainCoursedetails['courseBatchDetail'][0]['courseID'];
        $course_batch_id = $mainCoursedetails['courseBatchDetail'][0]['batchID'];
      }

    }

    

    $current_doing_array = [
      '' => 'What are you currently doing?',
      'Working Professional' => 'Working Professional',
      'Post Graduate' => 'Post Graduate',
      'Pursuing Post Graduation' => 'Pursuing Post Graduation',
      'Completed Graduation' => 'Completed Graduation',
      'Given Final Year Graduation Exams Awaiting Result' => 'Given Final Year Graduation Exams Awaiting Result',
      '4th Year of Graduation' => '4th Year of Graduation',
      '3rd Year of Graduation' => '3rd Year of Graduation',
      '2nd Year of Graduation' => '2nd Year of Graduation',
      '1st Year of Graduation' => '1st Year of Graduation',
      'Diploma Holder' => 'Diploma Holder',
      'Given Class XII Exams Awaiting Result' => 'Given Class XII Exams Awaiting Result',
      'Completed XII' => 'Completed XII',
      'Class I-XI' => 'Class I-XI',
    ]; 

    $stream_array = [
      '' => 'Stream of Education?',
      'Engineering: Computer Science/IT' => 'Engineering: Computer Science/IT',
      'Engineering: Electrical/ Electronics and Communication' => 'Engineering: Electrical/ Electronics and Communication',
      'Engineering: Mechanical' => 'Engineering: Mechanical',
      'Engineering: Other Streams' => 'Engineering: Other Streams',
      'Commerce' => 'Commerce',
      'Commerce + CA/ICWAI/Other Certifications' => 'Commerce + CA/ICWAI/Other Certifications',
      'Science: IT/Computer Application' => 'Science: IT/Computer Application',
      'Science: Other Streams' => 'Science: Other Streams',
      'Arts' => 'Arts',
      'Management: BBA' => 'Management: BBA',
      'Management: MBA (Marketing)' => 'Management: MBA (Marketing)',
      'Management: MBA' => 'Management: MBA',
      'Diploma: IT/Computers' => 'Diploma: IT/Computers',
      'Diploma: Other Streams' => 'Diploma: Other Streams',
      'School - Under Class-X' => 'School - Under Class-X',
    ];

    $form['assessemt_container'] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'main-container',
        ],
    ]; 
    $form['assessemt_container']['header_markup'] = array(
        HASH_TYPE => 'markup',
        '#markup' => '<h2 class="take-title">Give your details</h2>
                     <p>Various versions have evolved over the years</p>',
        '#allowed_tags' => ['div', 'h2', 'p']
    );   
    if(!empty($userName)){
      $form['assessemt_container']['enqry_f_nm'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_PLACEHOLDER => t('Name'),
        HASH_ATTRIBUTES => array('class' => array('form-control'), 'readonly' => 'readonly'),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Name'),
        '#default_value' => $userName,
      );
    }
    else{
      $form['assessemt_container']['enqry_f_nm'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_PLACEHOLDER => t('Name'),
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Name'),
      );
    }
    if(!empty($userMail)){
      $form['assessemt_container']['enqry_crsspndnc_eml'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_PLACEHOLDER => t('Email'),
        HASH_ATTRIBUTES => array('class' => array('form-control'), 'readonly' => 'readonly'),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Email'),
        '#default_value' => $userMail,
      );
    }
    else{
      $form['assessemt_container']['enqry_crsspndnc_eml'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_PLACEHOLDER => t('Email'),
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Email'),
      );
    }
    $form['assessemt_container']['mobile_markup'] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'assessemt-mobile-code-updator',
        ],
    ];
    if(!empty($userMobileNo)){
      $form['assessemt_container']['mobile_markup']['country'] = array(
        HASH_TYPE => 'select',
        HASH_OPTIONS => $this->country_code,
        HASH_AJAX => array(
            CALLBACK => [$this,'SetOptionCallback'],
            'wrapper' => 'country-code-updator-assessemt',
            EVENT => 'change',
            'effect' => 'fade',
        ), 
        HASH_ATTRIBUTES => array('class' => array('form-control'), 'disabled' => 'disabled'),
        HASH_PREFIX=>'<div class="col-md-3 col-sm-3 col-xs-3 pr-0 form-group">',
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
      $form['assessemt_container']['mobile_markup']['cval'] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'country-code-updator-assessemt',
        ],
      ];
      $form['assessemt_container']['mobile_markup']['cval']['countrycode'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key,
        HASH_PLACEHOLDER => t('Country Code'),
        HASH_ATTRIBUTES => array('class' => array('form-control'),  'readonly' => 'readonly'),
        HASH_PREFIX=>'<div class="col-md-2 col-sm-2 col-xs-3 pl-0 pr-0 form-group country-code">',
        HASH_SUFFIX=>'</div>',
      );

      $form['assessemt_container']['mobile_markup']['cval']['countrycode_name'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key_country_name,
        HASH_PREFIX=>'<div class="countrycode_name">',
        HASH_SUFFIX=>'</div>',
      );

      $form['assessemt_container']['mobile_markup']['cval']['isd_name'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key_isd_name,
        HASH_PREFIX=>'<div class="isd_name">',
        HASH_SUFFIX=>'</div>',
      );
      
      $form['assessemt_container']['mobile_markup']['enqry_crsspndnc_mbl'] = array(
        HASH_TYPE => 'number',
        HASH_PLACEHOLDER => t('Mobile Number'),
        HASH_ATTRIBUTES => array('class' => array('form-control mobile-numbr'), 'readonly' => 'readonly'),
        HASH_PREFIX=>'<div class="col-md-7 col-sm-7 col-xs-6 pl-0 form-group">',
        HASH_SUFFIX=>'</div>',
        '#default_value' => $userMobileNo,
      );
    }
    else{

      $form['assessemt_container']['mobile_markup']['country'] = array(
        HASH_TYPE => 'select',
        HASH_OPTIONS => $this->country_code,
        HASH_AJAX => array(
            CALLBACK => [$this,'SetOptionCallback'],
            'wrapper' => 'country-code-updator-assessemt',
            EVENT => 'change',
            'effect' => 'fade',
        ), 
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-3 col-sm-3 col-xs-3 pr-0 form-group">',
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
      $form['assessemt_container']['mobile_markup']['cval'] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'country-code-updator-assessemt',
        ],
      ];
      $form['assessemt_container']['mobile_markup']['cval']['countrycode'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key,
        HASH_PLACEHOLDER => t('Country Code'),
        HASH_ATTRIBUTES => array('class' => array('form-control'),  'readonly' => 'readonly'),
        HASH_PREFIX=>'<div class="col-md-2 col-sm-2 col-xs-3 pl-0 pr-0 form-group country-code">',
        HASH_SUFFIX=>'</div>',
      );

      $form['assessemt_container']['mobile_markup']['cval']['countrycode_name'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key_country_name,
        HASH_PREFIX=>'<div class="countrycode_name">',
        HASH_SUFFIX=>'</div>',
      );

      $form['assessemt_container']['mobile_markup']['cval']['isd_name'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key_isd_name,
        HASH_PREFIX=>'<div class="isd_name">',
        HASH_SUFFIX=>'</div>',
      );
      
      $form['assessemt_container']['mobile_markup']['enqry_crsspndnc_mbl'] = array(
        HASH_TYPE => 'number',
        HASH_PLACEHOLDER => t('Mobile Number'),
        HASH_ATTRIBUTES => array('class' => array('form-control mobile-numbr')),
        HASH_PREFIX=>'<div class="col-md-7 col-sm-7 col-xs-6 pl-0 form-group">',
        HASH_SUFFIX=>'</div>',
      );

    }

    $form['assessemt_container']['enqry_crsspndnc_city'] = [
        HASH_TYPE => TEXTFIELD,
        HASH_TITLE => t('City'),
        HASH_PLACEHOLDER => t("City (Type min 3 characters)"),
        '#attributes' => ['class' => ['form-control'], 'id' => 'google-place-field-ms_desktop'],
        HASH_PREFIX => '<div class="col-md-12 form-group google-place-field">',
        HASH_SUFFIX => '</div>',
    ];
    $form['assessemt_container']['enqry_crsspndnc_state'] = [
        HASH_TYPE => TEXTFIELD,
        HASH_PREFIX => '<div class="col-md-12 form-group state-data ms-ajax-form-example">',
        HASH_SUFFIX => '</div>',
    ];
    $form['assessemt_container']['crrntlydoing']= array(
        HASH_TYPE => 'select',
        HASH_OPTIONS => $current_doing_array,
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',          
    );
    $form['assessemt_container']['strmofedu']= array(
        HASH_TYPE => 'select',
        HASH_OPTIONS => $stream_array,
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',          
    );
    $form['assessemt_container']['AssessmentType'] = [
      '#type' => 'hidden',
      '#value' => 'PT',
    ];
    $form['assessemt_container']['prfrd_cntr'] = [
      '#type' => 'hidden',
      '#value' => '11072_NIIT',
    ];
    $form['assessemt_container']['course_code'] = array(
      '#type' => 'hidden',
      '#value' => $course_code,
    );
    $form['assessemt_container']['source'] = array(
      '#type' => 'hidden',
      '#value' => $campaignCode,
    ); 
    $form['assessemt_container']['campaign'] = array(
      '#type' => 'hidden',
      '#value' => $campaignCode,
    );   
    $form['assessemt_container']['AssessmentCode'] = [
      '#type' => 'hidden',
      '#value' => $assestCode,
    ];
    $form['assessemt_container']['CourseId'] = [
      '#type' => 'hidden',
      '#value' => $course_id,
    ];
    $form['assessemt_container']['BatchCode'] = [
      '#type' => 'hidden',
      '#value' => $course_batch_id,
    ];
    $options_kink = [
      'attributes' => [
        'class' => ['term-policy'],
        'target' => 'blank'],
    ];
    $t_link = Link::fromTextAndUrl(t('Privacy Policy'), Url::fromUri('internal:/node/2', $options_kink))->toString();
    $t_link->setGeneratedLink('<a href="https://privacy.niit.com/prospective_customer.html" target="blank">Privacy Policy</a>');
    
    $form['assessemt_container']['term_policy'] = [
      HASH_TYPE          => 'checkbox',
      HASHDEFAULT_VALUE => TRUE,
      HASH_PREFIX => '<div class="col-md-12 form-group checkbox-term-modular check-disab">',
      HASH_SUFFIX => '<span class="suffix-privacy">I agree to ' .$t_link.' & overriding DNC/NDNC request for Call/SMS</span></div>',

    ];
    $form['assessemt_container']['submit'] = array(
        HASH_TYPE => SUBMIT,
        HASH_VALUE => t('Take Test'),
        HASH_PREFIX => '<div class = "submit-query-form-button submit-web-btn">',
        HASH_SUFFIX=> '</div>',
        HASH_ATTRIBUTES => array('class' => array('subscription-submit btn btn-block btn-primary')),
        HASH_AJAX => array(
            CALLBACK => [$this,'AjaxCallBackTalkToOurExpert'],
            EVENT => 'click',
            PROGRESS => array(
                TYPE => 'throbber',
                MESSAGE => 'Please Wait...',
            ),
        ), 
    ); 
    $form['assessemt_container']['response_markup'] = array(
        HASH_TYPE => 'markup',
        '#markup' => '<div class="ajax-response"></div>',
        '#allowed_tags' => ['div']
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
  public function SetOptionCallback(array &$form, FormStateInterface $form_state,$form_id){
    return $form['assessemt_container']['mobile_markup']['cval'];
  }
  public function AjaxCallBackTalkToOurExpert(array &$form, FormStateInterface $form_state,$form_id) {

        $ajax_response = new AjaxResponse();
        $flag_submit=1;
        $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
        $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
        $ajax_response->addCommand(new InvokeCommand('.form-number', 'removeClass',['error']));
        $ajax_response->addCommand(new InvokeCommand('.form-select', 'removeClass',['error']));

        $UserService=\Drupal::service('sso_user.user');
        $validate_mobile=$UserService->FormRegexValidation("/^[0-9]{10}$/", $form_state->getValue('enqry_crsspndnc_mbl') );

        $CountryCode =  preg_replace("/[^0-9]/", "", $form_state->getValue('countrycode'));

        if(empty($form_state->getValue('enqry_f_nm'))){
            $ajax_response->addCommand(new AfterCommand('#edit-enqry-f-nm', '<div class="unplanErrorClass">Field can not be empty.</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-enqry-f-nm', 'addClass',['error']));
            $flag_submit=0;
        }
        if(empty($form_state->getValue('enqry_crsspndnc_eml'))){
            $ajax_response->addCommand(new AfterCommand('#edit-enqry-crsspndnc-eml', '<div class="unplanErrorClass">Field can not be empty</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-enqry-crsspndnc-eml', 'addClass',['error']));
            $flag_submit=0;
        }
        else{
          if(!filter_var($form_state->getValue('enqry_crsspndnc_eml'), FILTER_VALIDATE_EMAIL)){
            $ajax_response->addCommand(new AfterCommand('#edit-enqry-crsspndnc-eml', '<div class="unplanErrorClass">Invalid email address</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-enqry-crsspndnc-eml', 'addClass',['error']));
            $flag_submit=0;
          }
          else{
            $check_useremail = check_useremail($form_state->getValue('enqry_crsspndnc_eml'));
            if($check_useremail == 1 && \Drupal::currentUser()->isAnonymous() ){ 
              $ajax_response->addCommand(new InvokeCommand(NULL, 'assessentloginpoup', ['']));
              $ajax_response->addCommand(new AfterCommand('#edit-enqry-crsspndnc-eml', '<div class="unplanErrorClass">Already Registered. Please Login</div>'));
              $ajax_response->addCommand(new InvokeCommand('#edit-enqry-crsspndnc-eml', 'addClass',['error']));
              $flag_submit=0;
            }
          }
        }
        if(empty($form_state->getValue('enqry_crsspndnc_mbl'))){
            $ajax_response->addCommand(new AfterCommand('#edit-enqry-crsspndnc-mbl', '<div class="unplanErrorClass">Field can not be empty.</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-enqry-crsspndnc-mbl', 'addClass',['error']));
            $flag_submit=0;
        }
        else{
          if(!$validate_mobile && $CountryCode == 91 ){
            $ajax_response->addCommand(new AfterCommand('#edit-enqry-crsspndnc-mbl', '<div class="unplanErrorClass">Invalid Mobile Number</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-enqry-crsspndnc-mbl', 'addClass',['error']));
            $flag_submit=0;
          }

          $mob_count = strlen($form_state->getValue('enqry_crsspndnc_mbl'));
          if($mob_count > 12 && $CountryCode != 91){
            $ajax_response->addCommand(new AfterCommand('#edit-enqry-crsspndnc-mbl', '<div class="unplanErrorClass">Invalid Mobile Number</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-enqry-crsspndnc-mbl', 'addClass',['error']));
            $flag_submit=0;
          }
        }
        if(empty($form_state->getValue('enqry_crsspndnc_city'))){
            $ajax_response->addCommand(new AfterCommand('#google-place-field-ms_desktop', '<div class="unplanErrorClass">Field can not be empty.</div>'));
            $ajax_response->addCommand(new InvokeCommand('#google-place-field-ms_desktop', 'addClass',['error']));
            $flag_submit=0;
        }
        if(empty($form_state->getValue('prfrd_cntr'))){
            $ajax_response->addCommand(new AfterCommand('#edit-prfrd-cntr', '<div class="unplanErrorClass">Field can not be empty.</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-prfrd-cntr', 'addClass',['error']));
            $flag_submit=0;
        }
        if(empty($form_state->getValue('crrntlydoing'))){
            $ajax_response->addCommand(new AfterCommand('#edit-crrntlydoing', '<div class="unplanErrorClass">Field can not be empty.</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-crrntlydoing', 'addClass',['error']));
            $flag_submit=0;
        }
        if(empty($form_state->getValue('strmofedu'))){
            $ajax_response->addCommand(new AfterCommand('#edit-strmofedu', '<div class="unplanErrorClass">Field can not be empty.</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-strmofedu', 'addClass',['error']));
            $flag_submit=0;
        }
        
        if($flag_submit == 1){
          $name = $form_state->getValue('enqry_f_nm');
          $email = $form_state->getValue('enqry_crsspndnc_eml');
          $mobile = $form_state->getValue('enqry_crsspndnc_mbl');
          $cityData = $form_state->getValue('enqry_crsspndnc_city');
          $state = $form_state->getValue('enqry_crsspndnc_state');
          $prfrdCenterData = $form_state->getValue('prfrd_cntr');

          if($prfrdCenterData){
            $prfrd_value = explode('_', $prfrdCenterData);
            $values['prfrd_cntr'] = $prfrd_value[0];
            $values['prfrd_cntr_name'] = str_replace($prfrd_value[0]."_","", $prfrdCenterData);
          }
          if($cityData){
            $city_array = explode(", ", $cityData);
            $values['enqry_crsspndnc_city'] = $city_array[0];
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
          $values['enqry_crsspndnc_state'] = $state;
          $values['crrntlydoing'] = $form_state->getValue('crrntlydoing');
          $values['strmofedu'] = $form_state->getValue('strmofedu');

          $API2 = array(
            'leaduniqueid' => $mobile.'_'.$request_time,
            'GDPR_CONSENTID' => $GDPR_Id,
            'source' => $form_state->getValue('source'),
            'intrstd_prgrm' => $form_state->getValue('course_code'),
            'leadformstg' => 'assessment',
            'enqry_crsspndnc_cntry' => $form_state->getValue('isd_name'),
            'enqry_Crrspndnc_PhnStdCd' => $CountryCode,
            'enqry_prmnnt_cntry' => $form_state->getValue('countrycode_name'),
            'enqry_Prmnnt_PhnStdCd' => $CountryCode,
            'campaign' => $form_state->getValue('campaign'),
            'AssessmentType' => $form_state->getValue('AssessmentType'),
            'AssessmentCode' => $form_state->getValue('AssessmentCode'),
            'CourseId' => $form_state->getValue('CourseId'),
            'BatchCode' => $form_state->getValue('BatchCode'),

          );
          $data = array_merge($API2, $values);  
          multistep_postapidate('I', $data);

          $current_id = '';
          $CUSTOMER_ID = '';
          $newaccount = '';
          if (\Drupal::currentUser()->isAnonymous()) {
              $create_account = automatic_registration($data);
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

          $new_json = array_merge($data, $extra_data);  
          $final_json_send = create_application($new_json);

       //   echo '<pre>'; print_r($new_json); print_r($final_json_send); die();

          $ajax_response->addCommand(new InvokeCommand(NULL, 'assessmentTest', [$final_json_send]));

        }
         
        return $ajax_response;
        
    }
  
}

