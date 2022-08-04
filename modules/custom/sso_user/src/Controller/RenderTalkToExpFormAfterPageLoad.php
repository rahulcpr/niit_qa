<?php
namespace Drupal\sso_user\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;

use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Url;
use \Symfony\Component\HttpFoundation\Response;

use Drupal\Core\Ajax\InvokeCommand; 

use Drupal\Core\Ajax\AppendCommand;



use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node; 
use Drupal\user\Entity\User;
/**
 * Defines EligibleMobileOTP class.
 */
class RenderTalkToExpFormAfterPageLoad extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */

  public function TalktoExpertFormUsingAjax() {
	//$node_id = $node->id();
        //$node = Node::load($node_id);
	//print_r($node);
	// print "/////////////////////////";
	//print $node->bundle();
	//die('kkk');
  	$requestACallBackForm = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\RequestACallBackForm');
    $variables['requestACallBackForm'] = render($requestACallBackForm); 

    $form = $variables['requestACallBackForm'];
    //$form =\Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm');
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('.expert-div', $form));
    return $ajax_response;
  }
  
  
  public function TalktoExperPop($node_id) {
    
	$template_type = '';
	$variables['requestACallBackForm'] = "";
	$node = Node::load($node_id);
	$template_type = $node->field_select_template->value; 
  if($template_type == 'course_wipro'){
    $template_type = 'course_nokia';
  }
    if($template_type == 'course_modular'){
          $node_id = $node->id();

          $variables['requestACallBackFormBtnMob'] = '<a class="career-btnrequest" data-toggle="modal" data-target="#RequestACallBackForm"><i class="fa fa-phone"></i> Call back</a>'; 
          $variables['requestACallBackFormBtn'] = '<a class="btn btn-primary" data-toggle="modal" data-target="#RequestACallBackForm"><i class="fa fa-phone"></i> Talk to our expert</a>';


          $requestACallBackForm = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\TalkToOurExpertForm', $node_id);
          $requestACallBackFormModal ='<div id="RequestACallBackForm" class="modal fade" role="dialog">
          <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content msg-succ">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><center>Talk To Our Expert</center></h4>
                  
                </div>
                <div class="modal-body">
                    '.render($requestACallBackForm).'
                </div>
              </div>
            </div>
          </div>';

          $variables['requestACallBackForm'] = $requestACallBackFormModal;

        }
		
		if($template_type == 'course_new_modular' || $template_type == 'course_nokia' || $template_type == 'course_stackathon'){
		$variables['requestACallBackFormBtnMob'] = '<a class="career-btnrequest" data-toggle="modal" data-target="#RequestACallBackForm"><i class="fa fa-phone"></i> Call back</a>'; 
          $variables['requestACallBackFormBtn'] = '<a data-toggle="modal" data-target="#RequestACallBackForm"><u>Talk to our expert</u></a>';

          $variables['stillquery_connectwithus'] = '<span class="btn btn-primary btnApply" data-toggle="modal" data-target="#RequestACallBackForm">Connect with us</span>'; 

          $requestACallBackForm = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\TalkToOurExpertForm', $node_id);
          $requestACallBackFormModal ='<div id="RequestACallBackForm" class="modal fade" role="dialog">
          <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content msg-succ">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><center>Talk To Our Expert</center></h4>
                  
                </div>
                <div class="modal-body">
                    '.render($requestACallBackForm).'
                </div>
              </div>
            </div>
          </div>';

          $variables['requestACallBackForm'] = $requestACallBackFormModal;	
    }		
    $form = $variables['requestACallBackForm'];
    //$form =\Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm');
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('#talk-to-expert-form', $form));
    return $ajax_response;		
  }
  
  public function SimpleLeadFormUsingAjax($node_id) {
    
	$template_type = '';
	$variables['requestACallBackForm1'] = "";
	$node = Node::load($node_id);
	$template_type = $node->field_select_template->value; 
  if($template_type == 'course_wipro'){
    $template_type = 'course_nokia';
  }
	
    if($node->bundle() == 'course_landing_page'){
        $template_type = $node->field_select_course_landing_type->value; 
        if($template_type == 'course_nokia'){
          $node_id = $node->id();
          $requestACallBackForm1 = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\SimpleAjaxLeadForm', $node_id);
          $variables['requestACallBackForm1'] = $requestACallBackForm1;
        }
    }
	
	$form = $variables['requestACallBackForm1'];
    //$form =\Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm');
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('#simple-lead-form', $form));
    return $ajax_response;
  }
  
  public function MobileSimpleLeadFormUsingAjax($node_id) {
    
	$template_type = '';
	$variables['requestACallBackForm1'] = "";
	$node = Node::load($node_id);
	$template_type = $node->field_select_template->value; 
  if($template_type == 'course_wipro'){
    $template_type = 'course_nokia';
  }
	
    if($node->bundle() == 'course_landing_page'){
        $template_type = $node->field_select_course_landing_type->value; 
        if($template_type == 'course_nokia'){
          $node_id = $node->id();
          $requestACallBackForm1 = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\SimpleAjaxLeadForm', $node_id);
          $variables['requestACallBackForm1'] = $requestACallBackForm1;
        }
    }
	
	$form = $variables['requestACallBackForm1'];
    //$form =\Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm');
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('#mobile-simple-lead-form', $form));
    return $ajax_response;
  }
    
}

  

