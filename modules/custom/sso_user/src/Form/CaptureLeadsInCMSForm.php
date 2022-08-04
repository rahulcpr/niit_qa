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
use Drupal\Core\Database\Database;

/**
 * Contribute form.
 */
class CaptureLeadsInCMSForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  protected $requestACallBack_form;
  protected $login_form;
  protected $country_code;
  protected $default_key;
  protected $default_key_country_name;
  
  public function getFormId() {
    return 'captureleadsincms_form'; 
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $node_id = NULL) {
    $node = \Drupal\node\Entity\Node::load($node_id);
    $camp = '';
    $course_code = '';
	$prfrd_cntr = '';
    if($node->hasField('field_campaign_code')){
      if(!empty($node->get('field_campaign_code')->getValue()[0]['value'])){
        $camp = $node->get('field_campaign_code')->getValue()[0]['value'];
        $course_code = $node->get('field_course_code')->getValue()[0]['value'];
      }
    }
    if($node->hasField('field_profiler_form_title')){
      if(!empty($node->get('field_profiler_form_title')->getValue()[0]['value'])){
        $step_title=$node->get('field_profiler_form_title')->getValue()[0]['value'];
      }
    }
	
	if($node->hasField('field_center_list')){
      if(!empty($node->get('field_center_list')->getValue()[0]['value'])){
        $prfrd_cntr = $node->get('field_center_list')->getValue()[0]['value'];
      }
    }
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
        ],
    ];  
    $form['web_container']['title'] = array(
      '#type' => 'markup',
      '#markup' => '<h2 class="checkEligibTitle pl-3">'.$step_title.'</h2>',
      '#allowed_tags' => ['h2', 'span'],
    );
    $form['web_container']['node_id'] = array(
        HASH_TYPE => 'hidden',
        HASH_PREFIX=>'<div class="col-md-12">',
        HASH_SUFFIX=>'</div>',
        '#value' => $node_id,
    );  
    $form['web_container']['step_title'] = array(
        HASH_TYPE => 'hidden',
        HASH_PREFIX=>'<div class="col-md-12">',
        HASH_SUFFIX=>'</div>',
        '#value' => $step_title,
    );   

    $form['web_container']['enqry_f_nm'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Name'),
        HASH_ATTRIBUTES => array('class' => array('form-control', 'edit-enqry-f-nm')),
        HASH_PREFIX=>'<div class="col-md-12 form-group"><div class="control-label">Name <span class="required">*</span></div>',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Name'),
        '#default_value' => $userName,
    );
    $form['web_container']['enqry_crsspndnc_mbl'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Mobile Number'),
        HASH_ATTRIBUTES => array('class' => array('form-control', 'edit-enqry-crsspndnc-mbl', 'only-numeric-value')),
		'#size' => 10,
		'#maxlength' => 10,
        HASH_PREFIX=>'<div class="col-md-12 form-group"><div class="control-label">Mobile Number <span class="required">*</span></div>',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Mobile Number'),
        '#default_value' => $userMobileNo,
    );
    $form['web_container']['enqry_crsspndnc_eml'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Email'),
        HASH_ATTRIBUTES => array('class' => array('form-control', 'edit-enqry-crsspndnc-eml')),
        HASH_PREFIX=>'<div class="col-md-12 form-group"><div class="control-label">Email <span class="required">*</span></div>',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Email'),
        '#default_value' => $userMail,
    );

    $form['web_container']['course_code'] = array(
      '#type' => 'hidden',
       HASH_PREFIX=>'<div class="col-md-12">',
        HASH_SUFFIX=>'</div>',
      '#value' => $course_code,
    );
	$form['web_container']['prfrd_cntr'] = [
        HASH_TYPE => 'hidden',
		HASH_PREFIX=>'<div class="col-md-12">',
        HASH_SUFFIX=>'</div>',
        '#value' => $prfrd_cntr,
      ];
    $form['web_container']['campaign_code'] = array(
      '#type' => 'hidden',
       HASH_PREFIX=>'<div class="col-md-12">',
        HASH_SUFFIX=>'</div>',
      '#value' => $camp,
    );
   
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
      HASH_SUFFIX => '<span class="suffix-privacy">I agree to ' .$t_link.' & overriding DNC/NDNC request for Call/SMS</span></div>',

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

  public function AjaxCallBackTalkToOurExpert(array &$form, FormStateInterface $form_state,$form_id) {

        $ajax_response = new AjaxResponse();
        $flag_submit=1;
        $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
        $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
        $ajax_response->addCommand(new InvokeCommand('.form-number', 'removeClass',['error']));
        $ajax_response->addCommand(new InvokeCommand('.form-select', 'removeClass',['error']));

        if(empty($form_state->getValue('enqry_f_nm'))){
            $ajax_response->addCommand(new AfterCommand('.edit-enqry-f-nm', '<div class="unplanErrorClass">Name field can not be empty.</div>'));
            $ajax_response->addCommand(new InvokeCommand('.edit-enqry-f-nm', 'addClass',['error']));
            $flag_submit=0;
        }
        if(empty($form_state->getValue('enqry_crsspndnc_mbl'))){
            $ajax_response->addCommand(new AfterCommand('.edit-enqry-crsspndnc-mbl', '<div class="unplanErrorClass">Mobile Number field can not be empty.</div>'));
            $ajax_response->addCommand(new InvokeCommand('.edit-enqry-crsspndnc-mbl', 'addClass',['error']));
            $flag_submit=0;
        }else{
          if(!preg_match('/^[0-9]{10}+$/', $form_state->getValue('enqry_crsspndnc_mbl'))){
            $ajax_response->addCommand(new AfterCommand('#edit-enqry-crsspndnc-mbl', '<div class="unplanErrorClass">Invalid Mobile Number</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-enqry-crsspndnc-mbl', 'addClass',['error']));
            $flag_submit=0;
          }
        }
        if(empty($form_state->getValue('enqry_crsspndnc_eml'))){
            $ajax_response->addCommand(new AfterCommand('.edit-enqry-crsspndnc-eml', '<div class="unplanErrorClass">Email field can not be empty.</div>'));
            $ajax_response->addCommand(new InvokeCommand('.edit-enqry-crsspndnc-eml', 'addClass',['error']));
            $flag_submit=0;
        } else{
          if(!filter_var($form_state->getValue('enqry_crsspndnc_eml'), FILTER_VALIDATE_EMAIL)){
            $ajax_response->addCommand(new AfterCommand('.edit-enqry-crsspndnc-eml', '<div class="unplanErrorClass">Invalid email address</div>'));
            $ajax_response->addCommand(new InvokeCommand('.edit-enqry-crsspndnc-eml', 'addClass',['error']));
            $flag_submit=0;
          }
        }
        
        if($flag_submit == 1){
           $request_time = \Drupal::time()->getCurrentTime();
           $leaduniqueid = $form_state->getValue('enqry_crsspndnc_mbl').'_'.$request_time;

          $name = $form_state->getValue('enqry_f_nm');
          $email = $form_state->getValue('enqry_crsspndnc_eml');
          $mobile = $form_state->getValue('enqry_crsspndnc_mbl');
          $course_code = $form_state->getValue('course_code');
          $campaign_code = $form_state->getValue('campaign_code');
          

			$node_id = $form_state->getValue('node_id');
			$prfrdCenterData = $form_state->getValue('prfrd_cntr');
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
          // $values['crrntlydoing'] = $currently_pursuing[1];
          // $values['prize_category'] = $prize_category;
          // $values['enqry_Crrspndnc_PhnStdCd'] = $CountryCode;
          // $values['enqry_prmnnt_cntry'] = $form_state->getValue('countrycode_name');
          if(!empty($_COOKIE['UTMParams'])){
            $utm_data_array = json_decode($_COOKIE['UTMParams']);
                if($utm_data_array->utmApplcbl == 'Y'){
                    foreach ($utm_data_array->utm_params as $key => $value) {
                       $values[$key] = $value;
                    }
                }
          }
			// $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
   //          if(!empty($reffer_array[1])){
			// 	$query_string = explode('&', $reffer_array[1]);
			// 	foreach($query_string as $val){
			// 	$data = explode("=", $val);
			// 		$values[strtolower($data[0])] = $data[1];
			// 	}
			// }
   //        $API2 = array(
            'leaduniqueid' => $mobile.'_'.$request_time,
            'GDPR_CONSENTID' => $GDPR_Id,
            'source' => $campaign_code,
            'intrstd_prgrm' => $course_code,
            'leadformstg' => 'Lead',
         //   'enqry_crsspndnc_cntry' => $form_state->getValue('isd_name'),
         //   'enqry_Crrspndnc_PhnStdCd' => $CountryCode,
         //   'enqry_prmnnt_cntry' => $form_state->getValue('countrycode_name'),
          //  'enqry_Prmnnt_PhnStdCd' => $CountryCode,
          );
          $data = array_merge($API2, $values);  
          multistep_postapidate('I', $data);


          $dataArray = [
              'lead_unique_id'    => $leaduniqueid,
              'name'              => $name,
              'mobile_number'     => $mobile,
              'email_id'          => $email,
              'campaign_code'     => $campaign_code,
              'course_code'       => $course_code,
          ];
          $database = \Drupal::database();
          $insert_query = $database->insert('custom_capture_leads_cms_table')->fields($dataArray)->execute();
          $msg = '
          <div class="col-md-12">
          <div class="thank-you-msg">
			<p class="thank-you-icon"><i class="fa fa-check-circle fa-2x"></i></p>
			<p class="thank-you-txt">
            <strong>Thank you</strong> for sharing your details. Our representative will reach out you for further details.
			</p>
          </div>
          </div>';
          // $ajax_response->addCommand(new HtmlCommand('#main-container', $msg));
          $ajax_response->addCommand(new HtmlCommand('.captureleadsincms-form', $msg));
          
        }
         
        return $ajax_response;
        
    }
  
}

