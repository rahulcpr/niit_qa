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
class NewsLetterSubscribe extends FormBase {


	public function getFormId() {
		return 'NewsLetterSubscribeFormId';
	}

	public function buildForm(array $form, FormStateInterface $form_state) {
		$current_user = \Drupal::currentUser();
    	$roles = $current_user->getRoles();
    	$queryOutput = [];

    	if (in_array('niit', $roles)) {
	        $mail = $current_user->getEmail();

	        $query = \Drupal::entityQuery('node');
            $query->condition('type', 'newsletter_subscribe');
            $query->condition('title', $mail);
            $query->condition('status', 1);
            $queryOutput = $query->execute();

	    }
	    if(empty($queryOutput)){
            	$form['style_sheet'] = array(
			      	'#type' => 'markup',
			      	'#markup' => '<style>.news-letter-show-form{display: block;} .news-letter-hide-form{display: none;}</style>',
			     	'#allowed_tags' => ['style'],
			    );

		        $form['main_email_form']['#prefix'] = '<div id="first-form" class="news-letter-show-form">
		        		<div class="row msg-course news-letter-main">
		                    <div class="col-sm-12 newsletter-text newsletter-image">
		                    <h4>Get our Technology Newsletter</h4>
		                        <p class="newsletter-p">Lorem Ipsum Dolor Sit Amet. This is sample text. Lorem Ipsum. Lorem Ipsum Dolor Sit Amet. Lorem Ipsum Dolor Sit Amet.</p>
		                        <div class="input-group mb-3">
		                        <div class="unplanErrorClass"></div>';
		    	$form['main_email_form']['#suffix'] = '</div>
		                        <div class="tnc"> 
		                            <label>You can unsubscribe at any time. By signing up you are agreeing to our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.</label>
		                        </div>
		                        </div>
		                	</div>
		                </div>';    

				$form['main_email_form']['user_email_new'] = array(
					'#type' => 'email',
					'#title' => t('Email Id'),
					'#required' => TRUE,
					'#default_value' => ($mail) ? $mail : '',
					'#attributes' => [
							'placeholder' => t('Enter your e-mail address'), 
							'class' => ['form-control', 'mr-4']
						]
				);
				$form['main_email_form']['submit'] = array(
					'#type' => 'submit',
					'#value' => $this->t('Subscribe'),
					'#button_type' => 'primary',
					'#attributes' => ['class' => ['btn', 'btn-main']],
					'#ajax' => array(
			            'callback' => [$this,'AjaxCallBackNewsLetterSubscribe'],
			            'event' => 'click',
			            'progress' => array(
			                'type' => 'throbber',
			                'message' => 'Please Wait...',
			            ),
			        ), 
				);


				$form['second_email_form']['#prefix'] = '<div id="second-form" class="news-letter-hide-form">
						<div class="row msg-course">
		                    <div class="col-sm-12 newsletter-text">
		                        <h4><i class="far fa-check-circle"></i> Thank you for subscribe newsletter.</h4>';
		    	$form['second_email_form']['#suffix'] = '</div>
		    				</div>
		                </div>';
            }
		  

		return $form;
	}
	
	public function validateForm(array &$form, FormStateInterface $form_state) {
		// check email valid
    }
    public function submitForm(array &$form, FormStateInterface $form_state) {
 
		
	} 

	public function AjaxCallBackNewsLetterSubscribe(array &$form, FormStateInterface $form_state,$form_id) {
		$ajax_response = new AjaxResponse();
		$ajax_response->addCommand(new InvokeCommand('.form-text', 'removeClass',['error']));
		$field = $form_state->getValues();
		$checkFormValid = 1;
		// $user_email = $field['user_email_new'];
		if(empty($form_state->getValue('user_email_new'))){
            $ajax_response->addCommand(new HtmlCommand('.unplanErrorClass','Field can not be empty'));
            $ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            $checkFormValid = 0;
        }else{
          if(!filter_var($form_state->getValue('user_email_new'), FILTER_VALIDATE_EMAIL)){
            $ajax_response->addCommand(new HtmlCommand('.unplanErrorClass','Invalid email address'));

            $ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            $checkFormValid = 0;
          }
        }
		if($checkFormValid == 1){
			$userEmpId = '';
			$query = \Drupal::entityQuery('node');
            $query->condition('type', 'newsletter_subscribe');
            $query->condition('title', $form_state->getValue('user_email_new'));
            $query->condition('status', 1);
            $queryOutput = $query->execute();
            if(!empty($queryOutput)){
            	$ajax_response->addCommand(new HtmlCommand('.unplanErrorClass','Your email id is already subscribe.'));
        		$ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));
            }else{
            	$userData = user_load_by_mail($form_state->getValue('user_email_new'));
            	if(!empty($userData)){
            		$userEmpId = $userData->get('field_customer_id')->value;
            	}
            	$node = Node::create(['type' => 'newsletter_subscribe']);
			   	$node->set('title', $form_state->getValue('user_email_new'));
			  	$node->set('field_customer_id', $userEmpId);
			  	$node->status = 1;
				$node->enforceIsNew();
				$node->save();
				$ajax_response->addCommand(new InvokeCommand('#first-form', 'removeClass',['news-letter-show-form']));
	           	$ajax_response->addCommand(new InvokeCommand('#first-form', 'addClass',['news-letter-hide-form']));
	           	$ajax_response->addCommand(new InvokeCommand('#second-form', 'removeClass',['news-letter-hide-form']));
	           	$ajax_response->addCommand(new InvokeCommand('#second-form', 'addClass',['news-letter-show-form']));
            }
	           
        }
        return $ajax_response;
	}


}



















