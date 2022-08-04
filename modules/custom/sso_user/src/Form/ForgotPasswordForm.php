<?php
/**
 * @file
 * Contains \Drupal\sso_form\Form.
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

/**
 * Contribute form.
 */
class ForgotPasswordForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  protected $forgotPassword_form;
  
  public function getFormId() {
	  return 'sso_user_forgotpassword_form';	
  }
  public function __construct() {
    $this->forgotPassword_form = 'ForgotPasswordForm';
   
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
      '#markup' => '<div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4 class="modal-title">Reset your Password</h4>
                    </div>',
      '#allowed_tags' => ['div', 'h4', 'strong', 'button']
    ];    
    $form[SSO_CONTAINER]['forgotpassword'] = array(
        HASH_TYPE => TEXTFIELD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Email ID / Student ID'),
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',
        '#title' => t('Email ID / Student ID'),
    );
    $form[SSO_CONTAINER]['submit'] = array(
        HASH_TYPE => SUBMIT,
        HASH_VALUE => t('Submit'),
        HASH_PREFIX => '<p></p><div class = "submit-query-form-button"><div class ="">',
        HASH_SUFFIX=>'</div></div>',
        HASH_ATTRIBUTES => array('class' => array('subscription-submit btn btn-block btn-primary')),
        HASH_AJAX => array(
            CALLBACK => [$this,'AjaxCallBackForgotPassword'],
            EVENT => 'click',
            PROGRESS => array(
                TYPE => 'throbber',
                MESSAGE => 'Please Wait...',
            ),
        ), 
    );
    $form[SSO_CONTAINER]['signin_back'] = array(
      '#type' => 'markup',
      '#markup' => '<div class="back-to-login">< Back to Sign In</div>',
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
  public function AjaxCallBackForgotPassword(array &$form, FormStateInterface $form_state,$form_id) {

        $ajax_response = new AjaxResponse();
        $UserService = \Drupal::service('sso_user.user');
        $flag_submit=1;
        $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
        $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
        
        if(empty($form_state->getValue('forgotpassword'))){
            $ajax_response->addCommand(new AfterCommand('#edit-forgotpassword', '<div class="unplanErrorClass">Field can not be empty</div>'));
            $ajax_response->addCommand(new InvokeCommand('#edit-forgotpassword', 'addClass',['error']));
            $flag_submit=0;
        }else{
            $validate_email= $UserService->FormRegexValidation(
                "/^([A-Za-z0-9\+_\-]+)(\.[A-Za-z0-9\+_\-]+)*@([A-Za-z0-9\-]+\.)+[A-Za-z0-9]{2,6}$/",
                $form_state->getValue('forgotpassword'));//arg1=pattren,arg2=value
            $validate_studentid= $UserService->FormRegexValidation(
                "/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/",
                $form_state->getValue('forgotpassword'));
            
            if(!$validate_email && !$validate_studentid){
                $ajax_response->addCommand(new AfterCommand('#edit-forgotpassword', '<div class="unplanErrorClass">Invalid email id or student id</div>'));
                $ajax_response->addCommand(new InvokeCommand('#edit-forgotpassword', 'addClass',['error']));
                $flag_submit=0;
            }
        }
        
        if($flag_submit == 1){
            $host = \Drupal::request()->getSchemeAndHttpHost();
            $response = $UserService->EncripPassword($form_state->getValue('forgotpassword'));
            $form_data['EmailId'] = $form_state->getValue('forgotpassword');
            $form_data['RESETURL'] = $host."/user/reset-password?token=".$response;
            $form_data['ActivationUrl'] = "User/forgot-password.aspx";
            $form_data['ActivationType'] = "FP";
            $form_data['ServerIP'] = $_SERVER['SERVER_ADDR'];
            $form_data['ClientIP'] = $_SERVER['SERVER_ADDR'];;
            $form_data['RequestFrom'] = "NIIT";
            $form_data['OrgId'] = 1;
            $form_data['Type'] = '';

            $response = $UserService->forgotPasswordAPI(json_encode($form_data));
            $response=json_decode($response);
            if($response->ErrorYN == N){
                $ajax_response->addCommand(new HtmlCommand('#sso-user-forgotpassword-form','<div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4 class="modal-title">Reset your Password</h4>
                    </div><div class="forgotpassword-success alert alert-success">Forgot password link sent to <strong>'.$form_state->getValue('forgotpassword').'</strong></div><div class="back-to-login">< Back to Sign In</div>'));
                $ajax_response->addCommand(new InvokeCommand(NULL, 'closeModal', ['']));
            }else{
                $ajax_response->addCommand(new HtmlCommand('#edit-forgotpassword',$response->Message));
                $ajax_response->addCommand(new InvokeCommand(NULL, 'closeModal', ['']));
            }
            
        }
        return $ajax_response;
    }
  
}
?>
