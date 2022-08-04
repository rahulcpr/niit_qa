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
class RequestACallBackForm extends FormBase { 
  /**
   * {@inheritdoc}
   */
  protected $requestACallBack_form;
  protected $login_form;
  protected $country_code;
  protected $default_key;
  protected $default_key_country_name;
  
  public function getFormId() {
    return 'RequestACallBackForm_form'; 
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
    $form['web_container']['title'] = array(
      '#type' => 'markup',
      '#markup' => '<h5>Request a callback</h5>',
      '#allowed_tags' => ['h5'],
    );
    $form['web_container']['enqry_f_nm'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Name'),
        HASH_ATTRIBUTES => array('class' => array('edit-enqry-f-nm', 'floating-item-input')),
        HASH_PREFIX=>'<div class="form-rows"><div class="floating-item">',
        HASH_SUFFIX=>'</div></div>',
        '#title' => t('Name'),
        // '#default_value' => $userName,
    );
    $form['web_container']['enqry_crsspndnc_mbl'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Mobile Number'),
        HASH_ATTRIBUTES => array('class' => array('edit-enqry-crsspndnc-mbl', 'only-numeric-value', 'floating-item-input')),
		'#size' => 10,
		'#maxlength' => 10,
        HASH_PREFIX=>'<div class="form-rows"><div class="floating-item">',
        HASH_SUFFIX=>'</div></div>',
        '#title' => t('Mobile Number'),
        // '#default_value' => $userMobileNo,
    );
    $form['web_container']['enqry_crsspndnc_eml'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Email'),
        HASH_ATTRIBUTES => array('class' => array('edit-enqry-crsspndnc-eml', 'floating-item-input')),
        HASH_PREFIX=>'<div class="form-rows"><div class="floating-item">',
        HASH_SUFFIX=>'</div></div>',
        '#title' => t('Email'),
        // '#default_value' => $userMail,
    );
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
      HASH_ATTRIBUTES => array('class' => array('edit-intrstd_prgrm', 'floating-item-input')),
      HASH_PREFIX=>'<div class="form-rows"><div class="floating-item">',
      HASH_SUFFIX=>'</div></div>',
      // '#title' => t('Which Course are you Interested in?'),
      ];
	   $form['web_container']['prfrd_cntr'] = [
        HASH_TYPE => 'hidden',
		    HASH_PREFIX=>'<div class="col-md-12">',
        HASH_SUFFIX=>'</div>',
        '#value' => "ZZZZZ",
      ];
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
      HASH_PREFIX=>'<div class="form-rows new-hp-page-wrapper"><div class="floating-item">',
      HASH_SUFFIX=>'<div class="description">Please tick this box to indicate that you understand that your personal data will be used in accordance with the ' .$t_link.' here *</div></div></div>',

    ];
    $form['web_container']['submit'] = array(
        HASH_TYPE => SUBMIT,
        HASH_VALUE => t('Submit'),
        HASH_PREFIX=>'<div class="form-rows"><div class="floating-item">',
        HASH_SUFFIX=>'</div></div>',
        HASH_ATTRIBUTES => array('class' => array('homepage_submit_btn bttn button button--primary  form-submit')),
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
        if(empty($form_state->getValue('intrstd_prgrm'))){
          $ajax_response->addCommand(new AfterCommand('.edit-intrstd_prgrm', '<div class="unplanErrorClass">Please select one course from list.</div>'));
          $ajax_response->addCommand(new InvokeCommand('.edit-intrstd_prgrm', 'addClass',['error']));
          $flag_submit=0;
        }
        
        if($flag_submit == 1){
           $request_time = \Drupal::time()->getCurrentTime();
           $leaduniqueid = $form_state->getValue('enqry_crsspndnc_mbl').'_'.$request_time;

          $name = $form_state->getValue('enqry_f_nm');
          $email = $form_state->getValue('enqry_crsspndnc_eml');
          $mobile = $form_state->getValue('enqry_crsspndnc_mbl');

          $course_code_array = explode("&&", $form_state->getValue('intrstd_prgrm'));
          $course_code = $course_code_array[0];
          

          $campaign_code = "NIITCOM";
          
        if(!empty($course_code_array[1])){
          $values['prfrd_cntr'] = $course_code_array[1];
        }else{
          $values['prfrd_cntr'] = $form_state->getValue('prfrd_cntr');
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
          $values['intrstd_prgrm'] = $course_code;
          if(!empty($_COOKIE['UTMParams'])){
            $utm_data_array = json_decode($_COOKIE['UTMParams']);
                if($utm_data_array->utmApplcbl == 'Y'){
                    foreach ($utm_data_array->utm_params as $key => $value) {
                       $values[$key] = $value;
                    }
                }
          }

          $useragent=$_SERVER['HTTP_USER_AGENT'];
            if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
              
              $values['utm_source'] = 'Homepage';
              $values['utm_medium'] = 'FloatingButton';
            }else{
              $values['utm_source'] = 'Homepage';
              $values['utm_medium'] = 'Banner';
            }
            
          // setcookie('UTMParams', json_encode($utm_data), time() + (2592000 * 3), '/');
          
          
          $API2 = array(
            'leaduniqueid' => $mobile.'_'.$request_time,
            'GDPR_CONSENTID' => $GDPR_Id,
            'source' => $campaign_code,
            // 'intrstd_prgrm' => $course_code,
            'leadformstg' => 'HomePage',
         //   'enqry_crsspndnc_cntry' => $form_state->getValue('isd_name'),
         //   'enqry_Crrspndnc_PhnStdCd' => $CountryCode,
         //   'enqry_prmnnt_cntry' => $form_state->getValue('countrycode_name'),
          //  'enqry_Prmnnt_PhnStdCd' => $CountryCode,
          );
          $data = array_merge($API2, $values);  
          multistep_postapidate('I', $data);


          // $dataArray = [
          //     'lead_unique_id'    => $leaduniqueid,
          //     'name'              => $name,
          //     'mobile_number'     => $mobile,
          //     'email_id'          => $email,
          //     'campaign_code'     => $campaign_code,
          //     'course_code'       => $course_code,
          // ];
          // $database = \Drupal::database();
          // $insert_query = $database->insert('custom_capture_leads_cms_table')->fields($dataArray)->execute();
          $msg = '
          <div class="col-md-12">
          <div class="thank-you-msg">
			<p class="thank-you-icon"><img src="'.$_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india/themes/custom/nexus/assets/images/thank-you-msg.jpg"></p>
			<p class="thank-you-txt">
            <strong>Thank you</strong> for sharing your details. Our representative will reach out you for further details.
			</p>
          </div>
          </div>';
          // $ajax_response->addCommand(new HtmlCommand('#main-container', $msg));
          $ajax_response->addCommand(new HtmlCommand('.requestacallbackform-form', $msg));
          
        }
         
        return $ajax_response;
        
    }
  
}

