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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Ajax\AddCssCommand;
use Drupal\node\Entity\Node;

/**
 * Contribute form.
 */
class SimpleAjaxLeadForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  protected $requestACallBack_form;
  protected $country_code;
  protected $default_key;
  protected $default_key_country_name;
  
  public function getFormId() {
    return 'simplelead__form'; 
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
    $this->requestACallBack_form = 'SimpleLeadForm';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $node_id = NULL) {
    $node = \Drupal\node\Entity\Node::load($node_id);
    $camp = '';
    $course_code = '';
    if($node->hasField('field_campaign_code')){
      if(!empty($node->get('field_campaign_code')->getValue()[0]['value'])){
        $camp = $node->get('field_campaign_code')->getValue()[0]['value'];
        $course_code = $node->get('field_course_code')->getValue()[0]['value'];
      }
    }

    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $userMail = $user->get('mail')->value;
    $userName = $user->get('field_user_name')->value;
    $userMobileNo = $user->get('field_mobile_number')->value;    

    $form['web_container'] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'main-container',
        ],
    ];  
    $form['web_container']['node_id'] = array(
        HASH_TYPE => hidden,
        HASH_PREFIX=>'<div class="col-md-12 node-webniar">',
        HASH_SUFFIX=>'</div>',
        '#value' => $node_id,
    );   
    $form['web_container']['enqry_f_nm'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Name'),
        HASH_ATTRIBUTES => array('class' => array('form-control'), 'id' => 'edit-enqry-f-nm'),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Name'),
        '#default_value' => $userName,
    );
    $form['web_container']['enqry_crsspndnc_eml'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Email'),
        HASH_ATTRIBUTES => array('class' => array('form-control'), 'id' => 'edit-enqry-crsspndnc-eml'),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Email'),
        '#default_value' => $userMail,
    );

    $form['web_container']['mobile_markup'] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'mobile-code-updator',
        ],
    ];
    $form['web_container']['mobile_markup']['country'] = array(
        HASH_TYPE => 'select',
        HASH_OPTIONS => $this->country_code,
        HASH_AJAX => array(
            CALLBACK => [$this,'SetOptionCallback'],
            'wrapper' => 'country-code-updator-cval',
            EVENT => 'change',
            'effect' => 'fade',
        ), 
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-3 col-sm-3 col-xs-3 pr-0 form-group">',
        HASH_SUFFIX=>'</div>',
        '#default_value' =>  $this->default_country_code,
            
    );
    if($form_state->isRebuilding()){
         $country_array = explode('@', $form_state->getValue('country'));
        $this->default_key = $country_array[0];
        $this->default_key_country_name = $country_array[1];
        $this->default_key_isd_name = $country_array[2];
      }
      $form['web_container']['mobile_markup']['cval'] = [
        HASH_TYPE => CONTAINER,
        HASH_ATTRIBUTES => [
            'id' => 'country-code-updator-cval',
        ],
    ];
      $form['web_container']['mobile_markup']['cval']['countrycode'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key,
        HASH_PLACEHOLDER => t('Country Code'),
        HASH_ATTRIBUTES => array('class' => array('form-control'),  'readonly' => 'readonly'),
        HASH_PREFIX=>'<div class="col-md-2 col-sm-2 col-xs-3 pl-0 pr-0 form-group country-code">',
        HASH_SUFFIX=>'</div>',
      );

      $form['web_container']['mobile_markup']['cval']['countrycode_name'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key_country_name,
        HASH_PREFIX=>'<div class="countrycode_name">',
        HASH_SUFFIX=>'</div>',
      );

      $form['web_container']['mobile_markup']['cval']['isd_name'] = array(
        HASH_TYPE => TEXTFIELD,
        '#value' => $this->default_key_isd_name,
        HASH_PREFIX=>'<div class="isd_name">',
        HASH_SUFFIX=>'</div>',
      );
    
    $form['web_container']['mobile_markup']['enqry_crsspndnc_mbl'] = array(
        HASH_TYPE => 'number',
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Mobile Number'),
        HASH_ATTRIBUTES => array('class' => array('form-control mobile-numbr'), 'id' => 'edit-enqry-crsspndnc-mbl'),
        HASH_PREFIX=>'<div class="col-md-7 col-sm-7 col-xs-6 pl-0 form-group">',
        HASH_SUFFIX=>'</div>',
        '#default_value' => $userMobileNo,
    );
    $form['web_container']['course_code'] = array(
      '#type' => 'hidden',
      '#value' => $course_code,
    );
    $form['web_container']['source'] = array(
      '#type' => 'hidden',
      '#value' => $camp,
    );
    $form['prfrd_cntr'] = [
        '#type' => 'hidden',
        '#value' => 'ooooo_NIIT',
    ];
    // if($camp == 'NMN5G'){
    //   $form['prfrd_cntr'] = [
    //     '#type' => 'hidden',
    //     '#value' => 'ooooo_NIIT',
    //   ];
    // }
    // else{
    //   $options = get_preferred_center_per_camp($camp);
    //   // $options = ksort($options);
    //   // print_r($options);
    //   $form['web_container']['prfrd_cntr'] = [
    //     HASH_TYPE => 'select',
    //     HASH_REQUIRED => TRUE,
    //     HASH_TITLE => t('Nearest Center'),
    //     HASH_OPTIONS => $options,
    //     '#attributes' => ['class' => ['form-control']],
    //     HASH_PREFIX => '<div class="col-md-12 form-group ms-ajax-form-example">',
    //     HASH_SUFFIX => '</div>',
    //   ];
    // }
    
    $options_kink = [
      'attributes' => [
        'class' => ['term-policy'],
        'target' => 'blank'],
    ];
    $t_link = Link::fromTextAndUrl(t('Privacy Policy'), Url::fromUri('internal:/node/2', $options_kink))->toString();
    $t_link->setGeneratedLink('<a href="https://privacy.niit.com/prospective_customer.html" target="blank">Privacy Policy</a>');
    
    $form['web_container']['term_policy'] = [
      HASH_TYPE          => 'checkbox',
      // HASH_TITLE         => 'I understand the '.$t_link,
      HASH_REQUIRED      => TRUE,
      HASHDEFAULT_VALUE => TRUE,
      HASH_PREFIX => '<div class="col-md-12 form-group checkbox-term-modular check-disab">',
      HASH_SUFFIX => '<span class="suffix-privacy">I agree to' .$t_link.' & overriding DNC/NDNC request for Call/SMS</span></div>',

    ];
    $form['web_container']['submit'] = array(
        HASH_TYPE => SUBMIT,
        HASH_VALUE => t('Continue'),
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
    return $form['web_container']['mobile_markup']['cval'];
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
        }
        
        if($flag_submit == 1){
          $name = $form_state->getValue('enqry_f_nm');
          $email = $form_state->getValue('enqry_crsspndnc_eml');
          $mobile = $form_state->getValue('enqry_crsspndnc_mbl');
          $prfrdCenterData = $form_state->getValue('prfrd_cntr');
          $node_id = $form_state->getValue('node_id');

          if($prfrdCenterData){
            $prfrd_value = explode('_', $prfrdCenterData);
            $values['prfrd_cntr'] = $prfrd_value[0];
            $values['prfrd_cntr_name'] = str_replace($prfrd_value[0]."_","", $prfrdCenterData);
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

          if(!empty($_COOKIE['UTMParams'])){
            $utm_data_array = json_decode($_COOKIE['UTMParams']);
                if($utm_data_array->utmApplcbl == 'Y'){
                    foreach ($utm_data_array->utm_params as $key => $value) {
                       $values[$key] = $value;
                    }
                }
          }

          $API2 = array(
            'leaduniqueid' => $mobile.'_'.$request_time,
            'GDPR_CONSENTID' => $GDPR_Id,
            'source' => $form_state->getValue('source'),
            'intrstd_prgrm' => $form_state->getValue('course_code'),
            'leadformstg' => 'NokiaLead',
            'enqry_crsspndnc_cntry' => $form_state->getValue('isd_name'),
            'enqry_Crrspndnc_PhnStdCd' => $CountryCode,
            'enqry_prmnnt_cntry' => $form_state->getValue('countrycode_name'),
            'enqry_Prmnnt_PhnStdCd' => $CountryCode,
          );
          $data = array_merge($API2, $values);  
          multistep_postapidate('I', $data);
          
          $msg = 'Thank you,<br> we will connect with you soon.';
          $ajax_response->addCommand(new HtmlCommand('.stackRouteNewBanner .priceBoxModular','<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            <div class="talk-sucees-popup"><div class="top-img-talk"><img src="/india/themes/custom/nexus/assets/images/confirm-popup.png" class="img-responsive"></div>
            <div class="webinar-success data-talk">'.$msg.'</div></div>'));
          $ajax_response->addCommand(new InvokeCommand(NULL, 'leadTest', ['']));
        }
         
        return $ajax_response;
        
    }
  
}

