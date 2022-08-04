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
class UpdatePassword extends FormBase {
  /**
   * {@inheritdoc}
   */
  protected $updatepassword_form;
  const HASH_EDIT_OLDPASS = '#edit-oldpass';
  const HASH_EDIT_NEWPASS = '#edit-newpass';

  public function getFormId() {

	  return 'sso_user_update_password_form';	
  }
  public function __construct() {
    $this->updatepassword_form = 'UpdatePasswordForm';
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
    $form[SSO_CONTAINER]['oldpass'] = array(
        HASH_TYPE => PASSWORD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Old Password'),
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',
    );
    $str_msg="Password should have length of min 8 and max 30 characters. 
                It should contain alteast One Uppercase, Lowercase, Number and Special character. 
                It should contain '!', '@', '#', '$', '%', '^, '&' characters.";
    $form[SSO_CONTAINER]['newpass'] = array(
        HASH_TYPE => PASSWORD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('New Password'),
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',
    );
    $form[SSO_CONTAINER]['confpass'] = array(
        HASH_TYPE => PASSWORD,
        HASH_REQUIRED => TRUE,
        HASH_PLACEHOLDER => t('Confirm Password'),
        HASH_ATTRIBUTES => array('class' => array('form-control')),
        HASH_PREFIX=>'<div class="col-md-12 form-group">',
        HASH_SUFFIX=>'</div>',
    );
    $form[SSO_CONTAINER]['submit'] = array(
        HASH_TYPE => SUBMIT,
        HASH_VALUE => t('Submit'),
        HASH_PREFIX => '<div class = "submit-query-form-button"><div class ="">',
        HASH_SUFFIX=>'</div></div>',
        HASH_ATTRIBUTES => array('class' => array('subscription-submit btn btn-block btn-primary')),
        HASH_AJAX => array(
            CALLBACK => [$this,'AjaxCallBackUpdatePassword'],
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
  public function AjaxCallBackUpdatePassword(array &$form, FormStateInterface $form_state,$form_id) {

        $ajax_response = new AjaxResponse();
        $UserService = \Drupal::service('sso_user.user');
        $flag_submit=1;
        $user_data=array();
        $ajax_response->addCommand(new RemoveCommand('.unplanErrorClass'));
        $ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',[ERROR]));
        if(empty($form_state->getValue('oldpass'))){
            $ajax_response->addCommand(new AfterCommand(HASH_EDIT_OLDPASS, '<div class="unplanErrorClass">Please Enter Old Password</div>'));
            $flag_submit=0;
        }else{
            if(empty($form_state->getValue('newpass'))){
                $ajax_response->addCommand(new AfterCommand(HASH_EDIT_NEWPASS, '<div class="unplanErrorClass">Please Enter New Password</div>'));
                $flag_submit=0;
            }else{
                $validate_password=$UserService->ValidatePassword($form_state->getValue('newpass'));
                if(!$validate_password){
                    $str_msg="Password should have length of min 8 and max 30 characters. 
                    It should contain alteast One Uppercase, Lowercase, Number and Special character. 
                    It should contain '!', '@', '#', '$', '%', '^, '&' characters.";
                    $ajax_response->addCommand(new AfterCommand(HASH_EDIT_NEWPASS, '<div class="unplanErrorClass">'.$str_msg.'</div>'));
                    $ajax_response->addCommand(new InvokeCommand(HASH_EDIT_NEWPASS, ADDCLASS,[ERROR]));
                    $ajax_response->addCommand(new InvokeCommand('#edit-confpass', ADDCLASS,[ERROR]));
                    $flag_submit=0;
                }else{
                    if($form_state->getValue('newpass') == $form_state->getValue('confpass')){
                        $flag_submit = 1;
                    }else{
                        $ajax_response->addCommand(new AfterCommand(HASH_EDIT_NEWPASS, '<div class="unplanErrorClass">Password not match</div>'));
                        $ajax_response->addCommand(new InvokeCommand(HASH_EDIT_NEWPASS, ADDCLASS,[ERROR]));
                        $ajax_response->addCommand(new InvokeCommand('#edit-confpass', ADDCLASS,[ERROR]));
                        $flag_submit=0;
                    }
                }
            }
        }
        if($flag_submit == 1){
            $user_data=array();
            $uid=\Drupal::currentUser()->id();
            $user=\Drupal\user\Entity\User::load($uid);
            
            $user_data['OldPass'] = $form_state->getValue('oldpass');
            $user_data['NewPass'] = $form_state->getValue('newpass');
            $user_data['EmailID'] = $user->getEmail();
            $user_data['UserID'] = $user->get('field_customer_id')->getValue()[0]['value'];
            

            $config = \Drupal::config('ms_ajax_form_example.settings');  
            $niit_custom_login = $config->get('niit_custom_login');
            if(!empty($niit_custom_login) && $niit_custom_login == 1){ 
            
                $user_data=json_encode($user_data);
                $response = $UserService->UpdatePasswordAPI($user_data);
                $response=json_decode($response);
                if($response->ErrorYN == 'N'){
                    $UserService->UpdateUserPassword($uid,$user_data['NewPass']);
                    $msg = '<div class="updatepassword-success alert alert-success">Your Password updated</div>';
                    $ajax_response->addCommand(new HtmlCommand('#sso-user-update-password-form', $msg));
                    $ajax_response->addCommand(new InvokeCommand(NULL, 'closeModal', ['']));
                }else if($response->ErrorYN == 'Y' && $response->Message == 'MSG-NO'){
                    $ajax_response->addCommand(new AfterCommand(HASH_EDIT_OLDPASS, '<div class="unplanErrorClass">Your current password is incorrect</div>'));
                }else{
                    $ajax_response->addCommand(new AfterCommand(HASH_EDIT_OLDPASS, '<div class="unplanErrorClass">An error while changing the password</div>'));
                }
            }else{

                /**************************************************
                ** Change password using keyclock script - Start **
                **************************************************/
                $username = $user->getUsername();
                $currentPwd = $user_data['OldPass'];
                $newPwd = $user_data['NewPass'];
                $checkOldPwd = $UserService->keyClockCheckOldpasswoedAPI($username, $currentPwd);
                if($checkOldPwd == 'Valid current password'){
                    $clientAccessToken = $UserService->keyClockGenerateClientAccessToken();
                    if(isset($clientAccessToken->access_token) && !empty($clientAccessToken->access_token)){
                        $resetPwdIdgenerate = $UserService->keyClockresetPasswordIdGenerate($username, $clientAccessToken->access_token);
                        if(!empty($resetPwdIdgenerate[0]->id)){
                            $resetPwd = $UserService->keyClockresetPasswordAPI($newPwd, $clientAccessToken->access_token, $resetPwdIdgenerate[0]->id);
                            print($resetPwd);
                            if(empty($resetPwd)){
                                $msg = '<div class="updatepassword-success alert alert-success">Your Password updated</div>';
                                $ajax_response->addCommand(new HtmlCommand('#sso-user-update-password-form', $msg));
                                $ajax_response->addCommand(new InvokeCommand(NULL, 'closeModal', ['']));
                            }else{
                                $ajax_response->addCommand(new AfterCommand(HASH_EDIT_OLDPASS, '<div class="unplanErrorClass">An error while changing the password</div>'));
                            }
                        }else{
                            $ajax_response->addCommand(new AfterCommand(HASH_EDIT_OLDPASS, '<div class="unplanErrorClass">An error while changing the password</div>'));
                        }
                    }else{
                        $ajax_response->addCommand(new AfterCommand(HASH_EDIT_OLDPASS, '<div class="unplanErrorClass">An error while changing the password</div>'));
                    }
                }else if($checkOldPwd == 'Invalid current password'){
                    $ajax_response->addCommand(new AfterCommand(HASH_EDIT_OLDPASS, '<div class="unplanErrorClass">Your current password is incorrect</div>'));
                }else{
                    $ajax_response->addCommand(new AfterCommand(HASH_EDIT_OLDPASS, '<div class="unplanErrorClass">An error while changing the password</div>'));
                }
                
                /************************************************
                ** Change password using keyclock script - End **
                ************************************************/
            }

        }
        return $ajax_response;
        
    }
  
}
