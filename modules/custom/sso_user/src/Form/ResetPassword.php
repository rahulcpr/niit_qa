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

/**
 * Contribute form.
 */
class ResetPassword extends FormBase {
  /**
   * {@inheritdoc}
   */
  protected $resetpassword_form;
  
  public function getFormId() {
	  return 'sso_user_resetpassword_form';	
  }
  public function __construct() {
    $this->resetpassword_form = 'ResetPasswordForm';
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
    $UserService = \Drupal::service(SSO_USER_USER);
    $token = \Drupal::request()->get('token');
    $response = $UserService->DecriptPassword($token);
    
    if($response){
        $form[SSO_CONTAINER]['user'] = array(
            HASH_TYPE => TEXTFIELD,
            HASH_REQUIRED => TRUE,
            HASH_PLACEHOLDER => t('Email ID'),
            HASH_ATTRIBUTES => array('readonly' => 'readonly'),
            HASHDEFAULT_VALUE =>$response,
            HASH_PREFIX=>'<p></p>',
            HASH_SUFFIX=>'',
        );
        $form[SSO_CONTAINER][PASS1] = array(
            HASH_TYPE => PASSWORD,
            HASH_REQUIRED => TRUE,
            HASH_PLACEHOLDER => t('New Password'),
            HASH_PREFIX=>'<p></p>',
            HASH_SUFFIX=>'',
        );
        $form[SSO_CONTAINER][PASS2] = array(
            HASH_TYPE => PASSWORD,
            HASH_REQUIRED => TRUE,
            HASH_PLACEHOLDER => t('Confirm Password'),
            HASH_PREFIX=>'<p></p>',
            HASH_SUFFIX=>'',
        );
        $form[SSO_CONTAINER]['submit'] = array(
            HASH_TYPE => SUBMIT,
            HASH_VALUE => t('Submit'),
            HASH_PREFIX => '<p></p><div class = "submit-query-form-button"><div class ="">',
            HASH_SUFFIX=>'</div></div>',
            HASH_ATTRIBUTES => array('class' => array('subscription-submit')),
            HASH_AJAX => array(
                CALLBACK => [$this,'AjaxCallBackResetPassword'],
                EVENT => 'click',
                PROGRESS => array(
                    TYPE => 'throbber',
                    MESSAGE => 'Please Wait...',
                ),
            ), 
        );
    }else{
        $form['sso-container'][HASH_SUFFIX] = 'Please contact site administrator';
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
  public function AjaxCallBackResetPassword(array &$form, FormStateInterface $form_state,$form_id) {

        $ajax_response = new AjaxResponse();
        $UserService = \Drupal::service(SSO_USER_USER);
        $comment_html='';
        $flag_submit=1;
        $user_data=array();
        $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
        $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
        if(empty($form_state->getValue(PASS1))){
            $ajax_response->addCommand(new AfterCommand(HASH_EDIT_PASS1, '<div class="unplanErrorClass">Field can not be empty</div>'));
            $flag_submit=0;
        }else{
            if(empty($form_state->getValue(PASS2))){
                $ajax_response->addCommand(new AfterCommand('#edit-pass2', '<div class="unplanErrorClass">Field can not be empty</div>'));
                $flag_submit=0;
            }else{
                $validate_password=$UserService->ValidatePassword($form_state->getValue(PASS1));
                if(!$validate_password){
                    $str_msg="Password should have length of min 8 and max 30 characters. 
                    It should contain alteast One Uppercase, Lowercase, Number and Special character. 
                    It should contain '!', '@', '#', '$', '%', '^, '&' characters.";
                    $ajax_response->addCommand(new AfterCommand(HASH_EDIT_PASS1, '<div class="unplanErrorClass">'.$str_msg.'</div>'));
                    $ajax_response->addCommand(new InvokeCommand(HASH_EDIT_PASS1, ADDCLASS,['error']));
                    $ajax_response->addCommand(new InvokeCommand(HASH_EDIT_PASS2, ADDCLASS,['error']));
                    $flag_submit=0;
                }else{
                    if($form_state->getValue(PASS1) == $form_state->getValue(PASS2)){
                        $flag_submit = 1;
                    }else{
                        $ajax_response->addCommand(new AfterCommand(HASH_EDIT_PASS2, '<div class="unplanErrorClass">Password not match</div>'));
                        $ajax_response->addCommand(new InvokeCommand(HASH_EDIT_PASS1, ADDCLASS,['error']));
                        $ajax_response->addCommand(new InvokeCommand(HASH_EDIT_PASS2, ADDCLASS,['error']));
                        $flag_submit=0;
                    }
                }
            }
        }
        
        if($flag_submit == 1){
            $ajax_response->addCommand(new HtmlCommand('#sso-user-reset-password-form','Your Password updated'));
        }
         
        return $ajax_response;
        
    }
  
}
?>
