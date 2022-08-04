<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\user\Entity\User;
use Drupal\Core\Ajax\OpenModalDialogCommand;

use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;



//
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\RedirectCommand;
use \Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Ajax\InvokeCommand; 
use Symfony\Component\HttpFoundation\Request;
//

class RegisterUserInfo extends ControllerBase {  
  
    public function BeforeRegisterUserInfo() {
	
      // Code start
	  $variables['user_modal_form'] = '';
	  $variables['user_application_myModal'] = '';
	  
	  $uid = \Drupal::currentUser()->id();
      if ($uid > 0) {
 
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $userName = $user->get('field_user_name')->value;
    $updatepassword_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\UpdatePassword');
    $updatepassword_form_modal='<div id="update_password_modal_form" class="user-form-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Update Password</h4>
          </div>
          <div class="modal-body">
              '.render($updatepassword_form).'
          </div>
        </div>
      </div>
    </div>';
        $variables['user_modal_form']=$updatepassword_form_modal;

      } else {

    // login register popup
    $login_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\UserLoginForm');
    $register_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\UserRegisterForm');
    $forgot_password_form = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\ForgotPasswordForm');

    $form_modal_html='
    <div id="exTab1" class="form-container">	
      <div class="tab-content clearfix">
        <div class="tab-pane active" id="login">
          '.render($login_form).'
        </div>
        <div class="tab-pane" id="register">
          '.render($register_form).'
        </div>
      </div>
    </div>';
    $modal_login_form='
    <div id="user_account_modal_form" class="user-form-modal modal fade" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal"></button>  
          <div class="modal-body">
              '.$form_modal_html.'
          </div>
        </div>
      </div>
    </div></div>
    <div id="forgot_password_modal_form" class="user-form-modal modal fade" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal">&times;</button>  
          <div class="modal-body">
              '.render($forgot_password_form).'
          </div>
        </div>
      </div>
    </div>';

        $variables['user_modal_form']=$modal_login_form;

      }
	  // Code end
	  
		$userdata = $variables['user_modal_form'];
		$ajax_response = new AjaxResponse();
		$ajax_response->addCommand(new AppendCommand('#beforelogin-regform', $userdata));
		return $ajax_response;
    
      //return new JsonResponse($return);
    }

    
	
	public function ContinueApplicationPop() {
	
	  $variables['complete_app_btn'] = '<button type="type" class="btn btn-primary com-app" data-toggle="modal" data-target="#user_account_modal_form">Complete Application</button>';
	  if(!empty(\Drupal::currentUser()->id())){
		$variables['complete_app_btn'] = '';
	  }
	
	  $userdata = $variables['complete_app_btn'];
	  $ajax_response = new AjaxResponse();
	  $ajax_response->addCommand(new AppendCommand('#continue-reg-pop', $userdata));
	  return $ajax_response;
	}
}