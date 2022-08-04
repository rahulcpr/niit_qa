<?php
namespace Drupal\sso_user\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Ajax\InvokeCommand; 
use Drupal\Core\Ajax\AppendCommand;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node; 
use Drupal\user\Entity\User;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormState;
use Drupal\taxonomy\Entity\Term;    
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;

/**
 * Defines EligibleMobileOTP class.
 */
class RenderBroucherPage extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */

  public function BroucherPage($node_id) {
	  
	  $node1 = '';
	  $node1 = Node::load($node_id);
$fid = $node1->field_course_brochure->target_id;
$file = File::load($fid);
 
$url = $file->url();
//print_r($url);die('123');

	$uid = \Drupal::currentUser()->id();
  if ($uid > 0){ 
  
  $variables['broucher']='<a class="btn brochureDwnloadBtn brochureDwnloadBtnlogin" target="_blank" href="'.$url.'" download>
                  <div class="download-btn">
                    <div class="btn__circle">
                     <svg width="50" height="50">
                        <circle r="15" cx="22" cy="20" class="download" stroke-width="10"></circle>

                        <circle class="bar" stroke-width="5" r="18" cx="22" cy="20" fill="transparent" stroke="red" stroke-dasharray="565.48" stroke-dashoffset="565.48"></circle>
                    </svg>
                    </div>

                    <div class="btn__arrow btn--icon"><i class="fa fa-arrow-down" aria-hidden="true"></i></div>
                    <div class="btn__stop btn--icon"><i class="fa fa-pause" aria-hidden="true"></i></div>
                    <div class="btn__done btn--icon"><i class="fa fa-check" aria-hidden="true"></i></div>
                  </div>
                   <span class="brochuretxt">Brochure</span></a>';
	
                  
                 
                
	} else { 

         //$variables['broucher']='<span class="btn brochureDwnloadBtn" data-toggle="modal" data-target="#user_account_modal_form" download><i class="fa fa-arrow-down"></i> Brochure</span>';
         $variables['broucher']='<button class="brochure" data-toggle="modal" data-target="#user_account_modal_form" download>Download Brochure <i class="fa fa-download"></i></button>';		 

                  
  }   
	  
    $form = $variables['broucher']; 
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('.broucherpdf', $form));
    return $ajax_response;
  }
  
    
}





  

