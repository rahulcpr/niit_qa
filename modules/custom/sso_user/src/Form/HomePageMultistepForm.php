<?php

namespace Drupal\sso_user\Form; 

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;

// use Drupal\Core\Mail\MailManagerInterface;
// use Drupal\Component\Utility\SafeMarkup;
// use Drupal\Component\Utility\Html;

use Drupal\Core\Routing\TrustedRedirectResponse;


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
class HomePageMultistepForm extends FormBase {


  public function getFormId() {
    return 'HomePageMultistepFormFormIdnew';
    $form['#attached']['library'][] = array('system', 'jquery.form');
    $form['#attached']['library'][] = array('system', 'drupal.ajax');
  }


  public function buildForm(array $form, FormStateInterface $form_state) {
    $current_user = \Drupal::currentUser();
    $roles = $current_user->getRoles();
    $user = User::load(\Drupal::currentUser()->id());
    // $userRoles = $user->getRoles();
    $currentUserid = $user->id();
    if(isset($currentUserid)){
      $userName = $user->get('field_user_name')->value;
      $userMobileNo = $user->get('field_mobile_number')->value;
      if(!empty($user->get('field_communication_emailid')->value)){
        $userEmailId = $user->get('field_communication_emailid')->value;
      }
      else{
        $userEmailId = $user->get('mail')->value;
      }
    }  
      /*$bundle='course';
      $query = \Drupal::entityQuery('node');
      $query->condition('status', 1);
      $query->condition('field_show_on_hp_form', 1);
      $query->condition('type', $bundle);
      $entity_ids = $query->execute();

      foreach ($entity_ids as $nid) {
          $node = \Drupal\node\Entity\Node::load($nid);
          
         $cartarray[] = array('Title' => $node->field_title_for_hp_page->value, 'Campaign' => $node->field_campaign_code->value, 'Centerlist' => $node->field_center_list->value);
           
      }*/
      //print $node->field_title_for_hp_page->value;
       //print_r($cartarray);
       /*echo $cartarray[0][Title];
        echo $cartarray[0][Campaign];
         echo $cartarray[0][Centerlist];  
        die("Helllooo");*/
      
      // $num1 = count($entity_ids); die("Hellooo");


      
        $form['style_sheet'] = array(
        '#type' => 'markup',
        '#markup' => '<style>.news-letter-show-form{display: block;} .news-letter-hide-form{display: none;}</style>',
      '#allowed_tags' => ['style'],
       );

      $form['multi_step_homepage_form']['#prefix'] = '<div class="open_leadForm open_leadForm_mobile" id="first-form">
          <form action="">
          <div class="form-page">
            <h4>Get your dream job, now.</h4>
            <p class="ErrorClassmobile"></p>
              <div class="form_grp_inputs">';
      $form['multi_step_homepage_form']['#suffix'] = '</div>                  
                                               
            </div>
            
            <p class="form_privayText">By logging in, you agree to <a href="https://privacy.niit.com/prospective_customer.html" target="_blank">Privacy Policy</a></p> </form></div>';    

      if(!empty($userMobileNo)){ 
        $form['multi_step_homepage_form']['enqry_crsspndnc_mbl'] = array(
          '#type' => 'number',
          '#title' => t('Mobile Number'),
          '#required' => TRUE,
          '#attributes' => [
              'placeholder' => t('Enter your mobile number.'), 
              'class' => ['form-control', 'mr-4', 'enqry_crsspndnc_mbl', 'enqry_crsspndnc_mbl_loggin'],
              'readonly' => 'readonly'
            ],
           '#default_value' => isset($userMobileNo) ? $userMobileNo : NULL, 
        );
       }
       else{
        $form['multi_step_homepage_form']['enqry_crsspndnc_mbl'] = array(
          '#type' => 'number',
          '#title' => t('Mobile Number'),
          '#required' => TRUE,
          '#attributes' => [
              'placeholder' => t('Enter your mobile number.'), 
              'class' => ['form-control', 'mr-4', 'enqry_crsspndnc_mbl']
            ]
        );    
       } 
        $form['multi_step_homepage_form']['register_otp-check'] = array(
          '#type' => 'submit',
          '#value' => $this->t('Go'),
          '#button_type' => 'primary',
          '#attributes' => ['class' => ['btn', 'btn-main', 'btn-default', 'form-control', 'register_otp_check_hp']],
          '#ajax' => array(
                  'callback' => [$this,'AjaxCallBackThirdStep'],
                  'event' => 'click',
                  'progress' => array(
                      'type' => 'throbber',
                      'message' => 'Please Wait...',
                  ),
              ), 
        );


        $form['homepage_otp_form']['#prefix'] = '<div class="open_leadForm open_leadForm_otp homepageformhide" id="second-form">
                <form action=""><div class="form-page">
                  <h4>Verify your number</h4>
                    <h5 class="edit_mobNum"></h5>
                    <p class="otp_verification_hp"></p>
                    <div class="form_grp_inputs">';
          $form['homepage_otp_form']['#suffix'] = '</div>
                    <ul class="list-unstyled form_resend_otp">
                      <li data-nav="prev" class="register_otp_check_hp">Resend OTP</li>
                    </ul>                               
                </div></form></div>';
                
          $form['homepage_otp_form']['user_otp_new'] = array(
          '#type' => 'number',
          '#title' => t('OTP'),
          '#required' => TRUE,
          '#attributes' => [
              'placeholder' => t('Enter OTP'), 
              'class' => ['form-control', 'registerotp-val']
            ]
        );
         $form['homepage_otp_form']['previous_btn'] = array(
          '#type' => 'button',
          '#value' => $this->t('Change Number'),
          '#button_type' => 'primary',
          '#attributes' => ['class' => ['btn', 'btn-default', 'edit_homepage_number']],
          '#ajax' => array(
                  'callback' => [$this,'AjaxCallFirstStep'],
                  'event' => 'click',
                  'progress' => array(
                      'type' => 'throbber',
                      'message' => 'Please Wait...',
                  ),
              ), 
          );
        $form['homepage_otp_form']['submit'] = array(
          '#type' => 'submit',
          '#value' => $this->t('Verify'),
          '#button_type' => 'primary',
          '#attributes' => ['class' => ['btn', 'btn-main', 'btn-default', 'form-control', 'verify-register-otp-hp']],
          '#ajax' => array(
                  'callback' => [$this,'AjaxCallBackThirdStep'],
                  'event' => 'click',
                  'progress' => array(
                      'type' => 'throbber',
                      'message' => 'Please Wait...',
                  ),
              ), 
        );  


        $form['third_email_form']['#prefix'] = '<div class="open_leadForm open_leadForm_name homepageformhide" id="third-form">
                <form action=""><div class="form-page"><h4>Now tell us about yourself</h4>
                <h5 class="edit_mobNum Changnumbrcls"></h5>
                <p class="ErrorClassname"></p>
                <p class="ErrorClassemail"></p>
            ';
          $form['third_email_form']['#suffix'] = '
                <p class="name_email_msag">We do not share your private information</p></div></form></div>';      
        if(!empty($userName)){
          $form['third_email_form']['enqry_f_nm'] = array(
          '#type' => 'textfield',
          '#title' => t(''),
          '#required' => TRUE,
          '#attributes' => [
              'placeholder' => t('Your Name'), 
              'class' => ['form-control', 'mr-4'],
              'readonly' => 'readonly'
            ],
           '#default_value' => isset($userName) ? $userName : NULL, 
        );
        } 
        else{
          $form['third_email_form']['enqry_f_nm'] = array(
          '#type' => 'textfield',
          '#title' => t(''),
          '#required' => TRUE,
          '#attributes' => [
              'placeholder' => t('Your Name'), 
              'class' => ['form-control', 'mr-4']
            ]
        );
        }
        if(!empty($userEmailId)){ 
          $form['third_email_form']['enqry_crsspndnc_eml'] = array(
          '#type' => 'email',
          '#title' => t(''),
          '#required' => TRUE,
          '#attributes' => [
              'placeholder' => t('Your Email'), 
              'class' => ['form-control', 'mr-4'],
              'readonly' => 'readonly'
            ],
          '#default_value' => isset($userEmailId) ? $userEmailId : NULL,  
        );
        }
        else{
          $form['third_email_form']['enqry_crsspndnc_eml'] = array(
          '#type' => 'email',
          '#title' => t(''),
          '#required' => TRUE,
          '#attributes' => [
              'placeholder' => t('Your Email'), 
              'class' => ['form-control', 'mr-4']
            ] 
        );
        }  
        $form['third_email_form']['prfrd_cntr'] = [
        HASH_TYPE => 'hidden',
        HASH_PREFIX=>'<div class="col-md-12">',
        HASH_SUFFIX=>'</div>',
        '#value' => "ST001",
       ];
        $form['third_email_form']['submit'] = array(
          '#type' => 'submit',
          HASH_PREFIX=>'<div class="col-md-12 text-right pr-0">',
          HASH_SUFFIX=>'</div>',
          '#value' => $this->t('Next'),
          '#button_type' => 'primary',
          '#attributes' => ['class' => ['btn', 'btn-main', 'btn-main-hpg']],
          '#ajax' => array(
                  'callback' => [$this,'AjaxCallBackFourthStep'],
                  'event' => 'click',
                  'progress' => array(
                      'type' => 'throbber',
                      'message' => 'Please Wait...',
                  ),
              ), 
        );
      

      $form['fourth_course_form']['#prefix'] = '<div class="open_leadForm open_leadForm_name homepageformhide" id="fourth-form">
                <form action=""><div class="form-page"><h4 class="fouthstepname"></h4>
                    <p class="whtprgrmclr">What program interests you?</p>
                    <p class="fourthsteperror"></p>';
          $form['fourth_course_form']['#suffix'] = '         
                </div></form></div>';
          $form['fourth_course_form']['user_course_new'] = array(
          '#type' => 'select',
          '#title' => t(''),
          '#required' => TRUE,
          '#options' => [
          '' => t('Which Course are you Interested in?'),
        'POS51&&ST001&&2924' => $this->t('Product and Software Engineering (Job Assured*)'),
        'D123F&&ST001&&3059' => $this->t('Data Science/Machine Learning (Job Assured*)'),
        'VSRMP&&AX001&&3059' => $this->t('Banking Career with Axis Bank (Job Assured*)'),
        'PSRB&&11961&&2924' => $this->t('Banking Career with ICICI Bank (Job Assured*)'),
        'FSDMP&&ST001&&3059' => $this->t('Digital Marketing (Job Assured*)'),
        'PGPCC&&ST001&&2924' => $this->t('Cloud Computing (Job Assured*)'),
        'PGPCS&&ST001&&3059' => $this->t('Cyber Security (Job Assured*)'),
        'PGPAG&&11961&&2924' => $this->t('Accounting and Finance (Job Assistance)'),
        ],
          '#attributes' => [
              'placeholder' => t('Your Course'), 
              'class' => ['form-control', 'mr-4']
            ]
        );
        $form['fourth_course_form']['submit'] = array(
          '#type' => 'submit',
          '#value' => $this->t('Done'),
          '#button_type' => 'primary',
          HASH_PREFIX=>'<div class="col-md-12 text-right pr-0">',
          HASH_SUFFIX=>'</div>',
          '#attributes' => ['class' => ['btn', 'btn-main', 'btn-main-hpg', 'btn-main-hpg-course']],
          '#ajax' => array(
                  'callback' => [$this,'AjaxCallBackFifththStep'],
                  'event' => 'click',
                  'progress' => array(
                      'type' => 'throbber',
                      'message' => 'Please Wait...',
                  ),
              ), 
        );
        

        $form['fifth_step_form']['#prefix'] = '<div class="open_leadForm open_leadForm_name homepageformhide" id="fifth-form">
                <form action=""><div class="form-page">
                   <h4 class="mb-0 pb-0 fifth_step_name"></h4>
                    <h5 class="fifth_step_coursename"></h5>
                    <ul class="list-unstyled form_lists">
                      <li class="fifth-form-first-li">
                           
                      </li>
                      <li class="fifth-form-second-li">
                           
                      </li>
                      <li class="fifth-form-third-li">
                          
                      </li>';
          $form['fifth_step_form']['#suffix'] = '
                </ul>
                    <div class="fifth-form-href"></div> 
                </div></form></div>';
          /*$form['fifth_step_form']['enqry_f_nm'] = array(
          '#type' => 'textfield',
          '#title' => t(''),
          '#required' => TRUE,
          '#attributes' => [
              'placeholder' => t('Your Name'), 
              'class' => ['form-control', 'mr-4']
            ]
        );*/
          /*$form['fifth_step_form']['enqry_crsspndnc_eml'] = array(
          '#type' => 'email',
          '#title' => t(''),
          '#required' => TRUE,
          '#attributes' => [
              'placeholder' => t('Your Email'), 
              'class' => ['form-control', 'mr-4']
            ]
        );*/
        $form['fifth_step_form']['prfrd_cntr'] = [
        HASH_TYPE => 'hidden',
        HASH_PREFIX=>'<div class="col-md-12">',
        HASH_SUFFIX=>'</div>',
        '#value' => "ST001",
       ];



    return $form;
  }
  
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // check email valid
    }
    public function submitForm(array &$form, FormStateInterface $form_state) {
 
    
  } 



public function AjaxCallFirstStep(array &$form, FormStateInterface $form_state,$form_id) {
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
    $field = $form_state->getValues();

         $ajax_response->addCommand(new InvokeCommand('#second-form', 'addClass',['homepageformhide']));
         $ajax_response->addCommand(new InvokeCommand('#third-form', 'addClass',['homepageformhide']));
         $ajax_response->addCommand(new InvokeCommand('#first-form', 'removeClass',['homepageformhide']));
         $ajax_response->addCommand(new HtmlCommand('.edit_mobNum', $field[enqry_crsspndnc_mbl]));
         $ajax_response->addCommand(new HtmlCommand('.ErrorClassmobile',''));    
        
        return $ajax_response;
  }




  public function AjaxCallSecondStep(array &$form, FormStateInterface $form_state,$form_id) {
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
    $field = $form_state->getValues();
    //print_r($field[enqry_crsspndnc_mbl]); die("Helloo");
    $checkFormValid = 1;
    // $user_email = $field['user_email_new'];
    if(empty($form_state->getValue('enqry_crsspndnc_mbl'))){
            $ajax_response->addCommand(new HtmlCommand('.ErrorClassmobile','Field can not be empty'));
            //$ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            $checkFormValid = 0;
        }
    if(!preg_match('/^[6-9][0-9]{9}$/', $form_state->getValue('enqry_crsspndnc_mbl'))){
            $ajax_response->addCommand(new HtmlCommand('.ErrorClassmobile','Enter Correct Mobile No.'));
            //$ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            $checkFormValid = 0;
          }    
                  
                 
    if($checkFormValid == 1){
         $ajax_response->addCommand(new InvokeCommand('#first-form', 'addClass',['homepageformhide']));
         $ajax_response->addCommand(new InvokeCommand('#second-form', 'removeClass',['homepageformhide']));
         $ajax_response->addCommand(new HtmlCommand('.edit_mobNum', $field[enqry_crsspndnc_mbl]));
         $ajax_response->addCommand(new InvokeCommand('.edit_mobNum', 'addClass',['edit_mobNumb']));    
        }
        return $ajax_response;
  }


  public function AjaxCallBackThirdStep(array &$form, FormStateInterface $form_state,$form_id) {
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
    $field = $form_state->getValues();
    $checkFormValid = 1;
    // $user_email = $field['user_email_new'];
   /* if(empty($form_state->getValue('user_mobile_new'))){
            $ajax_response->addCommand(new HtmlCommand('.ErrorClassmobile','Field can not be empty'));
            $ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            $checkFormValid = 0;
        }*//*else{
          if(!filter_var($form_state->getValue('user_mobile_new'), FILTER_VALIDATE_EMAIL)){
            $ajax_response->addCommand(new HtmlCommand('.unplanErrorClass','Invalid email address'));

            $ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            $checkFormValid = 0;
          }
        }*/
      
     /*if(empty($form_state->getValue('otp_check_status_hp'))){
            $ajax_response->addCommand(new HtmlCommand('.otp_verification_hp','Enter a valid OTP'));
            $checkFormValid = 0;
        }  */

    if(empty($form_state->getValue('enqry_crsspndnc_mbl'))){
            $ajax_response->addCommand(new HtmlCommand('.ErrorClassmobile','Field can not be empty'));
            //$ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            $checkFormValid = 0;
        }
    if(!preg_match('/^[6-9][0-9]{9}$/', $form_state->getValue('enqry_crsspndnc_mbl'))){
            $ajax_response->addCommand(new HtmlCommand('.ErrorClassmobile','Enter Correct Mobile No.'));
            //$ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            $checkFormValid = 0;
          }               
                 
    if($checkFormValid == 1){
         $ajax_response->addCommand(new InvokeCommand('#first-form', 'addClass',['homepageformhide']));
         $ajax_response->addCommand(new InvokeCommand('#third-form', 'removeClass',['homepageformhide']));
         $ajax_response->addCommand(new HtmlCommand('.edit_mobNum', $field[enqry_crsspndnc_mbl].' <span class="Changnumbrclstxt">Change no.<span>'));   
        }
        return $ajax_response;
  }

   public function AjaxCallBackFourthStep(array &$form, FormStateInterface $form_state,$form_id) {
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
    $field = $form_state->getValues();
    $ajax_response->addCommand(new HtmlCommand('.fouthstepname', 'Hi '.$field[enqry_f_nm]));
    $ajax_response->addCommand(new HtmlCommand('.ErrorClassemail',''));
    $ajax_response->addCommand(new HtmlCommand('.ErrorClassname',''));
    //print_r($field[enqry_f_nm]); print_r($field[enqry_crsspndnc_eml]); print_r($field[enqry_crsspndnc_mbl]); die("Hellool");
    $checkFormValid = 1;
    // $user_email = $field['user_email_new'];
    if(empty($form_state->getValue('enqry_crsspndnc_eml'))){
            $ajax_response->addCommand(new HtmlCommand('.ErrorClassemail','Email Field can not be empty'));
            //$ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            $checkFormValid = 0;
        }else{
          if(!filter_var($form_state->getValue('enqry_crsspndnc_eml'), FILTER_VALIDATE_EMAIL)){
            $ajax_response->addCommand(new HtmlCommand('.ErrorClassemail','Invalid email address'));

            //$ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            $checkFormValid = 0;
          }
        }
     $current_user = \Drupal::currentUser()->id();
     $email = $form_state->getValue('enqry_crsspndnc_eml');
     $name =$form_state->getValue('enqry_f_nm');
     $mobile =$form_state->getValue('enqry_crsspndnc_mbl');

     $check_useremail = check_useremail($email);
      if($check_useremail == 1){
        $ajax_response->addCommand(new HtmlCommand('.ErrorClassemail','Email Already Registered <b><a class="ErrorClasssignin" href="/india/moLogin">  Sign In</a></b>'));
        //$ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
        $checkFormValid = 0;
      }
       

     if(empty($form_state->getValue('enqry_f_nm'))){
            $ajax_response->addCommand(new HtmlCommand('.ErrorClassname','Name Field can not be empty'));
            //$ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            $checkFormValid = 0;
        }

     if(!preg_match('/^([a-zA-Z` ]+)$/', $form_state->getValue('enqry_f_nm'))){
            $ajax_response->addCommand(new HtmlCommand('.ErrorClassname','Enter Correct Name'));
            $checkFormValid = 0;
          }      
                  
                 
    if($checkFormValid == 1){
         $ajax_response->addCommand(new InvokeCommand('#third-form', 'addClass',['homepageformhide']));
         $ajax_response->addCommand(new InvokeCommand('#fourth-form', 'removeClass',['homepageformhide']));
         //$ajax_response->addCommand(new HtmlCommand('.edit_mobNum','Field can not be empty'));     

       }   

     return $ajax_response;
  }

  
  public function AjaxCallBackFifththStep(array &$form, FormStateInterface $form_state,$form_id) {
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
    $field = $form_state->getValues();
    $checkFormValid = 1;
    $current_user = \Drupal::currentUser()->id();
    $email = $form_state->getValue('enqry_crsspndnc_eml');
    $name =$form_state->getValue('enqry_f_nm');
    $mobile =$form_state->getValue('enqry_crsspndnc_mbl');
    $CountryCode = '91';
    $CountryName = 'India';
    
    $inputvalue = $form_state->getValue('user_course_new');
    $separateval = explode("&&",$inputvalue);
    $nid = $separateval[2];
    
   
    $node = \Drupal\node\Entity\Node::load($nid);
    $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$nid);
    $itemli0 = $node->field_min_ctc->value;
    $itemli1 = $node->field_course_modules->value;
    $itemli2 = $node->field_enroll_no->value;
    $itemli4 = $node->field_alumni_name->value;
    $course_name = $node->title->value;
    $campaign_code = 'NIITCOM';
    $course_code = $separateval[0];
    $prfrd_cntr = $separateval[1];

    /*print $node->title->value; print_r($alias);POS51&&ST001&&2924
          print $node->field_course_short_description[0]->value;
          print $node->field_course_short_description[1]->value;

    print_r($form_state->getValue('user_course_new')); die("Hellooo");*/

    if(empty($form_state->getValue('user_course_new'))){
            
            $checkFormValid = 0;
            $ajax_response->addCommand(new HtmlCommand('.fourthsteperror','Field can not be empty'));
       }    
      
      if($checkFormValid == 1){
         $ajax_response->addCommand(new InvokeCommand('#fourth-form', 'addClass',['homepageformhide']));
         $ajax_response->addCommand(new InvokeCommand('#fifth-form', 'removeClass',['homepageformhide']));
         $ajax_response->addCommand(new HtmlCommand('.fifth_step_name', 'Good Choice '.$field[enqry_f_nm]));
         $ajax_response->addCommand(new HtmlCommand('.fifth_step_coursename', $course_name));
         if(!empty($itemli0)){
         $ajax_response->addCommand(new HtmlCommand('.fifth-form-first-li','<img src="/india/themes/custom/nexus/assets/images/list1.png" class="img-responsive"> <h5>'.''. $itemli0.''.'</h5><span data-toggle="tooltip" title="T&C apply. Refer to program page"><i class="fa fa-info-circle"></i></span>'));
          }
        if(!empty($itemli1)){
         $ajax_response->addCommand(new HtmlCommand('.fifth-form-second-li','<img src="/india/themes/custom/nexus/assets/images/list1.png" class="img-responsive"> <h5 >'.''. $itemli1.''.'</h5>'));
         }
         if(!empty($itemli12)){
         $ajax_response->addCommand(new HtmlCommand('.fifth-form-third-li', '<img src="/india/themes/custom/nexus/assets/images/list1.png" class="img-responsive"> <h5>'.''.$itemli2.$itemli4.''.'</h5>'));
         }
         $ajax_response->addCommand(new HtmlCommand('.fifth-form-href', '<a href="/india'.$alias.'" class="btn btn-main btn-default form-control btn-explr-yroptn"> Explore the Program <i class="fa fa-angle-right pl-3"></i></a>'));
          
         $stepdata=$form_state->getValues();
    
         $current_id = '';
          $CUSTOMER_ID = '';
          $newaccount = '';
          if (\Drupal::currentUser()->isAnonymous()) {
              $create_account = automatic_registration_hp($stepdata);
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
             'source' => $campaign_code,
             'applicationid' => '',
             'CustomerId' => $CUSTOMER_ID,
             'RequestedURL'=> '',
             'NewSignup' => $newaccount,
             'orgid' => 1
           ];

           /**GDPR API callback function  start*/
          $request_time = \Drupal::time()->getCurrentTime();
          $formdata = array(
            'uid' => $mobile.'_'.$request_time,
            'enqry_f_nm' => $name,
            'enqry_crsspndnc_eml' => $email,
            'time' => $request_time,
          );
          $GDPR_Id = multistep_user_consentapi($formdata);
          //print_r($GDPR_Id); die("Yiiii");
          /**GDPR API callback function  end*/
          $values['GDPR_CONSENTID'] = $GDPR_Id;
          $values['enqry_f_nm'] = $name;
          $values['enqry_crsspndnc_eml'] = $email;
          $values['enqry_crsspndnc_mbl'] = $mobile;
          $values['utm_source'] = 'Homepage';
          $values['utm_medium'] = 'Banner';
          $values['intrstd_prgrm'] = $course_code;
          $values['prfrd_cntr'] = $prfrd_cntr;
          // $values['enqry_Crrspndnc_PhnStdCd'] = $CountryCode;
          // $values['enqry_prmnnt_cntry'] = $form_state->getValue('countrycode_name');
          /*if($form_state->getValue('utmFieldCheck') == 1){
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
          $values['utm_source'] = $_REQUEST['course_code'];*/
      
       /* if(!empty($form_state->getValue('campaign_code'))){
              $campaign_code = $form_state->getValue('campaign_code');
            }else{
              $campaign_code = $_REQUEST['campaign_code'];
            }
            if(!empty($form_state->getValue('course_code'))){
              $course_code = $form_state->getValue('course_code');
            }else{
              $course_code = $_REQUEST['course_code'];
            }*/
      
          $API2 = array(
            'leaduniqueid' => $mobile.'_'.$request_time,
            'GDPR_CONSENTID' => $GDPR_Id,
            'source' => $campaign_code,
            //'intrstd_prgrm' => $course_code,
            'leadformstg' => 'HomePage',
            //'enqry_Crrspndnc_PhnStdCd' => $CountryCode,
            //'enqry_prmnnt_cntry' => $CountryName,
            //'enqry_Prmnnt_PhnStdCd' => $CountryCode,
          );
          $data = array_merge($API2, $values);
          //print_r($data); die("Helllooooo");  
          multistep_postapidate('I', $data);


          //$final_formdata = $TwoStepData;
          $final_formdata = array_merge($values, $extra_data);
          //print_r($final_formdata); die('mentall');
          $_SESSION['final_formdata'] = $final_formdata;    
      }  
        return $ajax_response;
  }

}