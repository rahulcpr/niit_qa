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
class JoinWebinarForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  protected $joinwebinar_form;
  
  public function getFormId() {
    return 'sso_user_joinwebinar_form'; 
  }
  public function __construct() {
    $this->joinwebinar_form = 'JoinWebinarForm';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $node_id = NULL) {
    
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
    $form['web_container']['lead_cd'] = array(
        HASH_TYPE => hidden,
        HASH_PREFIX=>'<div class="col-md-12 node-webniar">',
        HASH_SUFFIX=>'</div>',
    ); 
    $form['web_container']['mobile_display'] = array(
        HASH_TYPE => hidden,
        HASH_PREFIX=>'<div class="col-md-12 node-webniar">',
        HASH_SUFFIX=>'</div>',
    );   
    $form['web_container']['lead_encrypt'] = array(
        HASH_TYPE => hidden,
        HASH_PREFIX=>'<div class="col-md-12 node-webniar">',
        HASH_SUFFIX=>'</div>',
    );   
    $form['web_container']['enqry_f_nm'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Name'),
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group web-name">',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Name'),
    );
    $form['web_container']['enqry_crsspndnc_eml'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Email'),
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group web-mail">',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Email'),
    );
    $form['web_container']['enqry_crsspndnc_mbl'] = array(
        HASH_TYPE => 'number',
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Mobile Number'),
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Mobile Number'),
    );
    $form['web_container']['submit'] = array(
        HASH_TYPE => SUBMIT,
        HASH_VALUE => t('Continue'),
        HASH_PREFIX => '<div class = "submit-query-form-button submit-web-btn">',
        HASH_SUFFIX=> '</div>',
        HASH_ATTRIBUTES => array('class' => array('subscription-submit btn btn-block btn-primary')),
        HASH_AJAX => array(
            CALLBACK => [$this,'AjaxCallBackJoinWebnier'],
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
  public function AjaxCallBackJoinWebnier(array &$form, FormStateInterface $form_state,$form_id) {

        $ajax_response = new AjaxResponse();
        $flag_submit=1;
        $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
        $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
        $ajax_response->addCommand(new InvokeCommand('.form-number', 'removeClass',['error']));

        $mobile_display = $form_state->getValue('mobile_display');

        if($mobile_display == 1){

        }
        else{
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

        }
  
        if(empty($form_state->getValue('enqry_crsspndnc_mbl'))){
            $ajax_response->addCommand(new AfterCommand('#edit-enqry-crsspndnc-mbl', '<div class="unplanErrorClass">Field can not be empty.</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-enqry-crsspndnc-mbl', 'addClass',['error']));
            $flag_submit=0;
        }
        else{
          if(!preg_match('/^[0-9]{10}+$/', $form_state->getValue('enqry_crsspndnc_mbl'))){
            $ajax_response->addCommand(new AfterCommand('#edit-enqry-crsspndnc-mbl', '<div class="unplanErrorClass">Invalid Mobile Number</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-enqry-crsspndnc-mbl', 'addClass',['error']));
            $flag_submit=0;
          }
        }

        
        if($flag_submit == 1){

          if($mobile_display == 1){
            $mobile = $form_state->getValue('enqry_crsspndnc_mbl');
            $node_id = $form_state->getValue('node_id');

            $link_start_time = '';
            $start_datetime = '';
            $camp_code = 'NIITCOM';
            $category = '';
            $node = Node::load($node_id);
            if($node->bundle() == 'webinar'){
              if(!empty($node->field_link_open_date->date)){
                 $link_start_time = $node->field_link_open_date->date->getTimestamp();
              }
              if(!empty($node->field_start_date->date)){
                 $start_datetime = $node->field_start_date->date->getTimestamp();
              }
              $camp_code = $node->field_campaign_code->value;
              $category = $node->field_webinar_category->value; 
            }

            $time = time();  
            $check_time = $time - 12600;
            $leadformstg = 'join';
            $msg = 'Thank you, you will be redirected to the webinar in a separate tab (Allow pop-up if not redirected automatically)';
            if($link_start_time > $check_time){
              $leadformstg = 'register';
              $msg = 'Thank you, you have successfully registered for the webinar';
            }

            $webinar_dt = date('Y-m-d', $start_datetime);
            $webinar_tm = date('H:i', $start_datetime);
            if($category == 'recorded'){
              $webinar_dt = date('Y-m-d', $time);
              $webinar_tm = date('H:i', $time);
              $msg = 'Thank you, you will be redirected to the programme in a separate tab (Allow pop-up if not redirected automatically)';
              $leadformstg = 'join';
            }

            $formdata = array(
              "lead_encrypt" => '',
              "lead_cd" => '',
              "cmpgn_cd" => $camp_code,
              "page_url" => $_SERVER['HTTP_REFERER'],
              "engagement_type" => 'webinar',
              "webinar_dt" => $webinar_dt,
              "webinar_tm" => $webinar_tm,
              "call_type" => $leadformstg,
              "mbl_no" => $mobile,
            );

            SaveWebinarEngagementDetails($formdata);

            $ajax_response->addCommand(new HtmlCommand('.modal-content.msg-succ','<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button><div class="webinar-success alert alert-success">'.$msg.'</div>'));
            $ajax_response->addCommand(new InvokeCommand(NULL, 'webTest', ['']));

          }
          else{
            $name = $form_state->getValue('enqry_f_nm');
            $email = $form_state->getValue('enqry_crsspndnc_eml');
            $mobile = $form_state->getValue('enqry_crsspndnc_mbl');
            $node_id = $form_state->getValue('node_id');
            $lead_cd = $form_state->getValue('lead_cd');
            $lead_encrypt = $form_state->getValue('lead_encrypt');

            $link_start_time = '';
            $start_datetime = '';
            $camp_code = 'NIITCOM';
            $actvty_cd = '';
            $category = '';
            $node = Node::load($node_id);
            if($node->bundle() == 'webinar'){
              if(!empty($node->field_link_open_date->date)){
                 $link_start_time = $node->field_link_open_date->date->getTimestamp();
              }
              if(!empty($node->field_start_date->date)){
                 $start_datetime = $node->field_start_date->date->getTimestamp();
              }
              $actvty_cd = $node->field_activity_code->value;
              $camp_code = $node->field_campaign_code->value;
              $category = $node->field_webinar_category->value; 
            }

            $time = time();  
            $check_time = $time - 12600;
            $leadformstg = 'join';
            $msg = 'Thank you, you will be redirected to the webinar in a separate tab (Allow pop-up if not redirected automatically)';
            if($link_start_time > $check_time){
              $leadformstg = 'register';
              $msg = 'Thank you, you have successfully registered for the webinar';
            }

            if(!empty($lead_cd)){

              $webinar_dt = date('Y-m-d', $start_datetime);
              $webinar_tm = date('H:i', $start_datetime);

              if($category == 'recorded'){
                $webinar_dt = date('Y-m-d', $time);
                $webinar_tm = date('H:i', $time);
                $msg = 'Thank you, you will be redirected to the programme in a separate tab (Allow pop-up if not redirected automatically)';
                $leadformstg = 'join';
              }

              $formdata = array(
                "lead_encrypt" => $lead_encrypt,
                "lead_cd" => $lead_cd,
                "cmpgn_cd" => $camp_code,
                "page_url" => $_SERVER['HTTP_REFERER'],
                "engagement_type" => 'webinar',
                "webinar_dt" => $webinar_dt,
                "webinar_tm" => $webinar_tm,
                "call_type" => $leadformstg,
                "mbl_no" => $mobile,
              );

              SaveWebinarEngagementDetails($formdata);

            }
            else{
              $request_time = \Drupal::time()->getCurrentTime();
              $formdata = array(
                'uid' => $mobile.'_'.$request_time,
                'enqry_f_nm' => $form_state->getValue('enqry_f_nm'),
                'enqry_crsspndnc_eml' => $form_state->getValue('enqry_crsspndnc_eml'),
                'time' => $request_time,
              );
              $id = multistep_user_consentapi($formdata);
              $values['GDPR_CONSENTID']=$id;
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
              
              $change_time = $start_datetime + 12600;
              $webinar_dt = date('Y-m-d H:i:s', $change_time);
              if($category == 'recorded'){
                $webinar_dt = date('Y-m-d H:i:s', $request_time);
                $msg = 'Thank you, you will be redirected to the programme in a separate tab (Allow pop-up if not redirected automatically)';
                $leadformstg = 'join';
              }

              $API2=array(
                'leaduniqueid' => $form_state->getValue('enqry_crsspndnc_mbl').'_'.$request_time,
                'GDPR_CONSENTID' => $id,
                'source' =>  $camp_code,   
                'prfrd_cntr' => "ZZZZZ",    
                'leadformstg' => $leadformstg,
                'job_fair_dt' => $webinar_dt,    
                'actvty_cd' =>  $actvty_cd,                                                                   
              );

              $data = array_merge($API2,$values);   
              multistep_postapidate('I', $data);
            }

            

            $ajax_response->addCommand(new HtmlCommand('.modal-content.msg-succ','<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button><div class="webinar-success alert alert-success">'.$msg.'</div>'));
            $ajax_response->addCommand(new InvokeCommand(NULL, 'webTest', ['']));

          }
          
        }
         
        return $ajax_response;
        
    }
  
}
?>
