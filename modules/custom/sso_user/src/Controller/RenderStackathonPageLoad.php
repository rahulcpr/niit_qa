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
/**
 * Defines EligibleMobileOTP class.
 */
class RenderStackathonPageLoad extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function StackathonEmbedFormUsingAjax($node_id) {
    // $node_id = 2900;
    $template_type = '';
$vars['StackathonLeadForm'] = "";
$node = Node::load($node_id);
// $node_type = $node->getType();
$template_type = $node->field_select_template->value;
    
$selfpacedLeadForm = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\SelfpacedEmbedLeadForm', $node_id);
    $vars['SelfpacedEmbedLeadForm'] = '<div id="SelfPacedEmbed">'.render($selfpacedLeadForm).'</div>';

    $vars['timeinterval'] = date('h:i A', $start_time) .' - '. date('h:i A', $end_time);

            $vars['getEventsData'] = '';

            $cid = 'KMS:GetEventsData';
            if ($cacheitem = \Drupal::cache()->get($cid)) {

                $cacheData = $cacheitem->data;
                $vars['getEventsData'] =  (array) $cacheData['getEventsData'];
                
            }
            else{

                $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
                if($tokenArray->status == 1){
                    $token = $tokenArray->data->token;
                    $eventsDataFields = [
                                'module' => 'content_data_by_field',
                                'field' => 'cgrp',
                                'val' => 'Event',
                                'order_by' => 'order_by',
                                'token' => $token
                            ];
                    $vars['getEventsData'] = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($eventsDataFields);

                    $cacheObject = [
                        'getEventsData' => $vars['getEventsData'],
                    ];
                    \Drupal::cache()->set($cid, $cacheObject);

                }

           }

           if($node_type == 'course'){
            $course_template_type = $node->field_select_template->value;
            switch ($course_template_type) {
                case 'course_modular':
                    $suggestions[] = 'page__'.$course_template_type.'_led'; // veriable call career_imageVideo_div
                break;
                case 'course_new_modular': 
                    $suggestions[] = 'page__course_new_modular';
                break;
                case 'course_online_ilt':
                    $suggestions[] = 'page__'.$course_template_type.'_course'; // veriable call career_imageVideo_div
                break;
                case 'course_career':
                    $suggestions[] = 'page__'.$course_template_type.'_course';
                break;
                case 'course_stack_route_ilt':
                    $suggestions[] = 'page__'.$course_template_type.'_course';
                break;
                case 'course_online_self':
                    $suggestions[] = 'page__'.$course_template_type.'_course'; // veriable call career_imageVideo_div
                break;
                case 'course_icici':
                    $suggestions[] = 'page__'.$course_template_type.'_course';
                break;
                case 'course_axis':
                    $suggestions[] = 'page__'.$course_template_type;
                break;
                case 'course_nokia':
                    $suggestions[] = 'page__'.$course_template_type;
                break;
                case 'course_wipro':
                    $suggestions[] = 'page__course_nokia';
                    $course_template_type = 'course_nokia';
                break;
                case 'course_new_stack_route':
                    $vars['course_page_type']='course_new_stack_route';
                    $suggestions[] = 'page__course_new_stack_route';
                    $course_template_type = 'course_stack_route_ilt';
                    $course_template_type_new ='course_new_stack_route';
                break;
                case 'course_stackathon':
                    $vars['course_page_type']='course_stackathon';
                    $suggestions[] = 'page__course_new_stack_route';
                    $course_template_type = 'course_stack_route_ilt';
                    $course_template_type_new ='course_new_stack_route';
                break;
                case 'course_selfpaced':
                    $vars['course_page_type']='course_selfpaced';
                    $suggestions[] = 'page__course_self_paced';
                    $course_template_type = 'course_stack_route_ilt';
                    $course_template_type_new ='course_self_paced';
                break;
                case 'course_campaign_page_template':
                    $vars['course_page_type']='course_campaign_page_template';
                    $suggestions[] = 'page__course_campaign_page_template';
                    $course_template_type = 'course_stack_route_ilt';
                    $course_template_type_new ='course_campaign_page_template';
                break;
                case 'course_program2022_page_template':
                    $vars['course_page_type']='course_program2022_page_template';
                    $suggestions[] = 'page__course_program2022_page_template';
                    $course_template_type = 'course_stack_route_ilt';
                    $course_template_type_new ='course_program2022_page_template';
                break;
                default:
                    //$suggestions[] = 'page__default_course';
                break;
            }

            $path_to_theme = $base_url.'/'.\Drupal::theme()->getActiveTheme()->getPath();
            $current_path = \Drupal::request()->getRequestUri();
            /* Preparing the varibales for templates */
            $vars['related_courses'] =  views_embed_view('related_courses', 'related_course');				
            $vars['path_to_theme'] = $path_to_theme;
            $vars['course_post_title'] = $node->title->value;
            $vars['course_post_short_desc'] = $node->field_course_summary->value;
            $vars['course_field_why_niit_content'] = $node->field_why_niit_content->value;
            $vars['course_post_id'] = $node->id();
            $vars['course_details'] = $node->field_course_details->value;
            $vars['course_eligibility'] = $node->field_course_eligibility->value;
            $vars['course_image_desc'] = $node->field_testimonial_desc_moduler->value;
            $vars['course_video_desc'] = $node->field_testimonial_video_desc->value;
            $vars['main_course_code'] = (!empty($node->field_course_code->value))?$node->field_course_code->value:'';
            $vars['courseCMSFee'] = '<del class="discountPriceSelf"><i class="fa fa-rupee"></i>  '.$node->field_course_fee->value.'</del>/- ';
            $vars['courseFeeInformation'] = (!empty($node->field_fee_information->value))?'<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="'.$node->field_fee_information->value.'"></i>':'';
            $vars['courseFAQTitle'] = (!empty($node->field_faq_title->value))?$node->field_faq_title->value:'';
            
            $courseType = $node->field_delivery_mode_code->value;
            $courseCode = $node->field_course_code->value;
            $EnrollNowLink = $node->field_enroll_now_link->value;
            $emitextprodpage = $node->field_no_cost_emi_text->value;

            if($node->field_select_template->value == 'course_stackathon'){
                $generateEnrollNowAndAccessBtn = \Drupal::service('niit_common.twig.TwigExtension')->generateEnrollNowAndAccessBtn($node->id(), $courseCode, 'Access Your Challenge', 'Participate Now', 'DetailPage');
                $vars['SelfpacedEmbedLeadForm'] = $generateEnrollNowAndAccessBtn['selfpacedEmbedLeadForm'];
                
            }else if($node->field_select_template->value == 'course_selfpaced'){
                $generateEnrollNowAndAccessBtn = \Drupal::service('niit_common.twig.TwigExtension')->generateEnrollNowAndAccessBtn($node->id(), $courseCode, 'Access Your Course', 'Enroll Now', 'DetailPage');
                $vars['SelfpacedEmbedLeadForm'] = $generateEnrollNowAndAccessBtn['selfpacedEmbedLeadForm'];
                
            }else{
                $vars['SelfpacedEmbedLeadForm'] = "";
                
            }
            
        
        if($course_template_type_new == 'course_self_paced'){    
            if(!empty($node->field_start_date->date)){
                $start_time = $node->field_start_date->date->getTimestamp();
            }
            if(!empty($node->field_enad_date->date)){
                $end_time = $node->field_enad_date->date->getTimestamp();
            }

            $vars['timeinterval'] = date('h:i A', $start_time) .' - '. date('h:i A', $end_time);

            $vars['getEventsData'] = '';

            $cid = 'KMS:GetEventsData';
            if ($cacheitem = \Drupal::cache()->get($cid)) {

                $cacheData = $cacheitem->data;
                $vars['getEventsData'] =  (array) $cacheData['getEventsData'];
                
            }
            else{

                $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
                if($tokenArray->status == 1){
                    $token = $tokenArray->data->token;
                    $eventsDataFields = [
                                'module' => 'content_data_by_field',
                                'field' => 'cgrp',
                                'val' => 'Event',
                                'order_by' => 'order_by',
                                'token' => $token
                            ];
                    $vars['getEventsData'] = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($eventsDataFields);

                    $cacheObject = [
                        'getEventsData' => $vars['getEventsData'],
                    ];
                    \Drupal::cache()->set($cid, $cacheObject);

                }

            }

         }
    }

    

    $form = $vars['SelfpacedEmbedLeadForm'];
    // $form = 'Sachin Kumar';
    //$form =\Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm');
      $ajax_response = new AjaxResponse();
      $ajax_response->addCommand(new AppendCommand('.self-paced-embed-div', $form));
      return $ajax_response;
}

  public function StackathonFormUsingAjax($node_id) {
	  
	 $template_type = '';
	$vars['StackathonLeadForm'] = "";
	$node = Node::load($node_id);
	$node_type = $node->getType();
	$template_type = $node->field_select_template->value;
	//print_r($node_type);
	//print_r($template_type);
	//die('123');
	
	           if($node_type == 'self_paced_landing_page'){
                $path_to_theme = $base_url.'/'.\Drupal::theme()->getActiveTheme()->getPath();
                $vars['path_to_theme'] = $path_to_theme;
                $suggestions[] = 'page__selfpacedlanding';

                if(!empty($node->field_start_date->date)){
                    $start_time = $node->field_start_date->date->getTimestamp();
                }
                if(!empty($node->field_enad_date->date)){
                    $end_time = $node->field_enad_date->date->getTimestamp();
                }

                $stackathonLeadForm = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\StackathonLeadForm', $node->id());
                        $vars['StackathonLeadForm'] = '<div id="StackathonLeadForm" class="modal fade leadLightBox StackathonLeadFormCls" role="dialog">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>  
                                  <div class="modal-body p-0">
                                     '.render($stackathonLeadForm).'
                                  </div>
                                </div>
                              </div>
                            </div>';
                $vars['timeinterval'] = date('h:i A', $start_time) .' - '. date('h:i A', $end_time);

                $vars['getEventsData'] = '';

                $cid = 'KMS:GetEventsData';
                if ($cacheitem = \Drupal::cache()->get($cid)) {

                    $cacheData = $cacheitem->data;
                    $vars['getEventsData'] =  (array) $cacheData['getEventsData'];
                    
                }
                else{

                    $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
                    if($tokenArray->status == 1){
                        $token = $tokenArray->data->token;
                        $eventsDataFields = [
                                    'module' => 'content_data_by_field',
                                    'field' => 'cgrp',
                                    'val' => 'Event',
                                    'order_by' => 'order_by',
                                    'token' => $token
                                ];
                        $vars['getEventsData'] = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($eventsDataFields);

                        $cacheObject = [
                            'getEventsData' => $vars['getEventsData'],
                        ];
                        \Drupal::cache()->set($cid, $cacheObject);

                    }

               }
                
            }
			
			if($node_type == 'course'){
                $course_template_type = $node->field_select_template->value;
                switch ($course_template_type) {
                    case 'course_modular':
                        $suggestions[] = 'page__'.$course_template_type.'_led'; // veriable call career_imageVideo_div
                    break;
                    case 'course_new_modular': 
                        $suggestions[] = 'page__course_new_modular';
                    break;
                    case 'course_online_ilt':
                        $suggestions[] = 'page__'.$course_template_type.'_course'; // veriable call career_imageVideo_div
                    break;
                    case 'course_career':
                        $suggestions[] = 'page__'.$course_template_type.'_course';
                    break;
                    case 'course_stack_route_ilt':
                        $suggestions[] = 'page__'.$course_template_type.'_course';
                    break;
                    case 'course_online_self':
                        $suggestions[] = 'page__'.$course_template_type.'_course'; // veriable call career_imageVideo_div
                    break;
                    case 'course_icici':
                        $suggestions[] = 'page__'.$course_template_type.'_course';
                    break;
                    case 'course_axis':
                        $suggestions[] = 'page__'.$course_template_type;
                    break;
                    case 'course_nokia':
                        $suggestions[] = 'page__'.$course_template_type;
                    break;
                    case 'course_wipro':
                        $suggestions[] = 'page__course_nokia';
                        $course_template_type = 'course_nokia';
                    break;
                    case 'course_new_stack_route':
                        $vars['course_page_type']='course_new_stack_route';
                        $suggestions[] = 'page__course_new_stack_route';
                        $course_template_type = 'course_stack_route_ilt';
                        $course_template_type_new ='course_new_stack_route';
                    break;
                    case 'course_stackathon':
                        $vars['course_page_type']='course_stackathon';
                        $suggestions[] = 'page__course_new_stack_route';
                        $course_template_type = 'course_stack_route_ilt';
                        $course_template_type_new ='course_new_stack_route';
                    break;
                    case 'course_selfpaced':
                        $vars['course_page_type']='course_selfpaced';
                        $suggestions[] = 'page__course_self_paced';
                        $course_template_type = 'course_stack_route_ilt';
                        $course_template_type_new ='course_self_paced';
                    break;
                    case 'course_campaign_page_template':
                        $vars['course_page_type']='course_campaign_page_template';
                        $suggestions[] = 'page__course_campaign_page_template';
                        $course_template_type = 'course_stack_route_ilt';
                        $course_template_type_new ='course_campaign_page_template';
                    break;
                    case 'course_program2022_page_template':
                        $vars['course_page_type']='course_program2022_page_template';
                        $suggestions[] = 'page__course_program2022_page_template';
                        $course_template_type = 'course_stack_route_ilt';
                        $course_template_type_new ='course_program2022_page_template';
                    break;
                    default:
					    //$suggestions[] = 'page__default_course';
                    break;
                }
    
                $path_to_theme = $base_url.'/'.\Drupal::theme()->getActiveTheme()->getPath();
                $current_path = \Drupal::request()->getRequestUri();
                /* Preparing the varibales for templates */
                $vars['related_courses'] =  views_embed_view('related_courses', 'related_course');				
                $vars['path_to_theme'] = $path_to_theme;
                $vars['course_post_title'] = $node->title->value;
                $vars['course_post_short_desc'] = $node->field_course_summary->value;
                $vars['course_field_why_niit_content'] = $node->field_why_niit_content->value;
                $vars['course_post_id'] = $node->id();
                $vars['course_details'] = $node->field_course_details->value;
                $vars['course_eligibility'] = $node->field_course_eligibility->value;
                $vars['course_image_desc'] = $node->field_testimonial_desc_moduler->value;
                $vars['course_video_desc'] = $node->field_testimonial_video_desc->value;
                $vars['main_course_code'] = (!empty($node->field_course_code->value))?$node->field_course_code->value:'';
                $vars['courseCMSFee'] = '<del class="discountPriceSelf"><i class="fa fa-rupee"></i>  '.$node->field_course_fee->value.'</del>/- ';
                $vars['courseFeeInformation'] = (!empty($node->field_fee_information->value))?'<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="'.$node->field_fee_information->value.'"></i>':'';
                $vars['courseFAQTitle'] = (!empty($node->field_faq_title->value))?$node->field_faq_title->value:'';
                
                $courseType = $node->field_delivery_mode_code->value;
                $courseCode = $node->field_course_code->value;
                $EnrollNowLink = $node->field_enroll_now_link->value;
                $emitextprodpage = $node->field_no_cost_emi_text->value;

                if($node->field_select_template->value == 'course_stackathon'){
                    $generateEnrollNowAndAccessBtn = \Drupal::service('niit_common.twig.TwigExtension')->generateEnrollNowAndAccessBtn($node->id(), $courseCode, 'Access Your Challenge', 'Participate Now', 'DetailPage');
                    $vars['StackathonLeadForm'] = $generateEnrollNowAndAccessBtn['stackathonLeadForm'];
                    $vars['StackathonLeadFormBtn'] = $generateEnrollNowAndAccessBtn['stackathonLeadFormBtn'];
                }else if($node->field_select_template->value == 'course_selfpaced'){
                    $generateEnrollNowAndAccessBtn = \Drupal::service('niit_common.twig.TwigExtension')->generateEnrollNowAndAccessBtn($node->id(), $courseCode, 'Access Your Course', 'Enroll Now', 'DetailPage');
                    $vars['StackathonLeadForm'] = $generateEnrollNowAndAccessBtn['stackathonLeadForm'];
                    $vars['StackathonLeadFormBtn'] = $generateEnrollNowAndAccessBtn['stackathonLeadFormBtn'];
                }else if($node->field_select_template->value == 'course_new_stack_route'){
                    $tid1 = $node->get('field_lead_magnet_widget')->getValue()[0]['target_id'];
                    $node1 = \Drupal\node\Entity\Node::load($tid1);
                    $node2 = $node1->get('field_course_link')->getValue()[0]['target_id'];
                    $node4 = \Drupal\node\Entity\Node::load($node2);
                    $coursecd = $node4->get('field_course_code')->getValue()[0]['value'];
                    $generateEnrollNowAndAccessBtn = \Drupal::service('niit_common.twig.TwigExtension')->generateEnrollNowAndAccessBtn($node2, $coursecd, 'Access Your Course', 'Start Learning', 'DetailPage');
                    $vars['StackathonLeadForm'] = $generateEnrollNowAndAccessBtn['stackathonLeadForm'];
                    $vars['StackathonLeadFormBtn'] = $generateEnrollNowAndAccessBtn['stackathonLeadFormBtn'];
                }
                else{
                    $vars['StackathonLeadForm'] = "";
                    $vars['StackathonLeadFormBtn'] = "";
                }
                
            
            if($course_template_type_new == 'course_self_paced'){    
                if(!empty($node->field_start_date->date)){
                    $start_time = $node->field_start_date->date->getTimestamp();
                }
                if(!empty($node->field_enad_date->date)){
                    $end_time = $node->field_enad_date->date->getTimestamp();
                }

                $vars['timeinterval'] = date('h:i A', $start_time) .' - '. date('h:i A', $end_time);

                $vars['getEventsData'] = '';

                $cid = 'KMS:GetEventsData';
                if ($cacheitem = \Drupal::cache()->get($cid)) {

                    $cacheData = $cacheitem->data;
                    $vars['getEventsData'] =  (array) $cacheData['getEventsData'];
                    
                }
                else{

                    $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
                    if($tokenArray->status == 1){
                        $token = $tokenArray->data->token;
                        $eventsDataFields = [
                                    'module' => 'content_data_by_field',
                                    'field' => 'cgrp',
                                    'val' => 'Event',
                                    'order_by' => 'order_by',
                                    'token' => $token
                                ];
                        $vars['getEventsData'] = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($eventsDataFields);

                        $cacheObject = [
                            'getEventsData' => $vars['getEventsData'],
                        ];
                        \Drupal::cache()->set($cid, $cacheObject);

                    }

                }

             }

			}

  $form = $vars['StackathonLeadForm'];
  //$form =\Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm');
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('.Self-stackathon-div', $form));
    return $ajax_response;
  }
  
  public function StackathonLeadButtonAjax($node_id) {
	  
	 $template_type = '';
	$vars['StackathonLeadForm'] = "";
	$node = Node::load($node_id);
	$node_type = $node->getType();
	$template_type = $node->field_select_template->value;
	//print_r($node_type);
	//print_r($template_type);
	//die('123');
	
	           if($node_type == 'self_paced_landing_page'){
                $path_to_theme = $base_url.'/'.\Drupal::theme()->getActiveTheme()->getPath();
                $vars['path_to_theme'] = $path_to_theme;
                $suggestions[] = 'page__selfpacedlanding';

                if(!empty($node->field_start_date->date)){
                    $start_time = $node->field_start_date->date->getTimestamp();
                }
                if(!empty($node->field_enad_date->date)){
                    $end_time = $node->field_enad_date->date->getTimestamp();
                }

                $stackathonLeadForm = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\StackathonLeadForm', $node->id());
                        $vars['StackathonLeadForm'] = '<div id="StackathonLeadForm" class="modal fade leadLightBox StackathonLeadFormCls" role="dialog">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <button type="button" class="close leadCusCloseBtn" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>  
                                  <div class="modal-body p-0">
                                     '.render($stackathonLeadForm).'
                                  </div>
                                </div>
                              </div>
                            </div>';
                $vars['timeinterval'] = date('h:i A', $start_time) .' - '. date('h:i A', $end_time);

                $vars['getEventsData'] = '';

                $cid = 'KMS:GetEventsData';
                if ($cacheitem = \Drupal::cache()->get($cid)) {

                    $cacheData = $cacheitem->data;
                    $vars['getEventsData'] =  (array) $cacheData['getEventsData'];
                    
                }
                else{

                    $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
                    if($tokenArray->status == 1){
                        $token = $tokenArray->data->token;
                        $eventsDataFields = [
                                    'module' => 'content_data_by_field',
                                    'field' => 'cgrp',
                                    'val' => 'Event',
                                    'order_by' => 'order_by',
                                    'token' => $token
                                ];
                        $vars['getEventsData'] = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($eventsDataFields);

                        $cacheObject = [
                            'getEventsData' => $vars['getEventsData'],
                        ];
                        \Drupal::cache()->set($cid, $cacheObject);

                    }

               }
                
            }
			
			if($node_type == 'course'){
                $course_template_type = $node->field_select_template->value;
                switch ($course_template_type) {
                    case 'course_modular':
                        $suggestions[] = 'page__'.$course_template_type.'_led'; // veriable call career_imageVideo_div
                    break;
                    case 'course_new_modular': 
                        $suggestions[] = 'page__course_new_modular';
                    break;
                    case 'course_online_ilt':
                        $suggestions[] = 'page__'.$course_template_type.'_course'; // veriable call career_imageVideo_div
                    break;
                    case 'course_career':
                        $suggestions[] = 'page__'.$course_template_type.'_course';
                    break;
                    case 'course_stack_route_ilt':
                        $suggestions[] = 'page__'.$course_template_type.'_course';
                    break;
                    case 'course_online_self':
                        $suggestions[] = 'page__'.$course_template_type.'_course'; // veriable call career_imageVideo_div
                    break;
                    case 'course_icici':
                        $suggestions[] = 'page__'.$course_template_type.'_course';
                    break;
                    case 'course_axis':
                        $suggestions[] = 'page__'.$course_template_type;
                    break;
                    case 'course_nokia':
                        $suggestions[] = 'page__'.$course_template_type;
                    break;
                    case 'course_wipro':
                        $suggestions[] = 'page__course_nokia';
                        $course_template_type = 'course_nokia';
                    break;
                    case 'course_new_stack_route':
                        $vars['course_page_type']='course_new_stack_route';
                        $suggestions[] = 'page__course_new_stack_route';
                        $course_template_type = 'course_stack_route_ilt';
                        $course_template_type_new ='course_new_stack_route';
                    break;
                    case 'course_stackathon':
                        $vars['course_page_type']='course_stackathon';
                        $suggestions[] = 'page__course_new_stack_route';
                        $course_template_type = 'course_stack_route_ilt';
                        $course_template_type_new ='course_new_stack_route';
                    break;
                    case 'course_selfpaced':
                        $vars['course_page_type']='course_selfpaced';
                        $suggestions[] = 'page__course_self_paced';
                        $course_template_type = 'course_stack_route_ilt';
                        $course_template_type_new ='course_self_paced';
                    break;
                    case 'course_program2022_page_template':
                        $vars['course_page_type']='course_program2022_page_template';
                        $suggestions[] = 'page__course_program2022_page_template';
                        $course_template_type = 'course_stack_route_ilt';
                        $course_template_type_new ='course_program2022_page_template';
                    break;
                    default:
					    //$suggestions[] = 'page__default_course';
                    break;
                }
    
                $path_to_theme = $base_url.'/'.\Drupal::theme()->getActiveTheme()->getPath();
                $current_path = \Drupal::request()->getRequestUri();
                /* Preparing the varibales for templates */
                $vars['related_courses'] =  views_embed_view('related_courses', 'related_course');				
                $vars['path_to_theme'] = $path_to_theme;
                $vars['course_post_title'] = $node->title->value;
                $vars['course_post_short_desc'] = $node->field_course_summary->value;
                $vars['course_field_why_niit_content'] = $node->field_why_niit_content->value;
                $vars['course_post_id'] = $node->id();
                $vars['course_details'] = $node->field_course_details->value;
                $vars['course_eligibility'] = $node->field_course_eligibility->value;
                $vars['course_image_desc'] = $node->field_testimonial_desc_moduler->value;
                $vars['course_video_desc'] = $node->field_testimonial_video_desc->value;
                $vars['main_course_code'] = (!empty($node->field_course_code->value))?$node->field_course_code->value:'';
                $vars['courseCMSFee'] = '<del class="discountPriceSelf"><i class="fa fa-rupee"></i>  '.$node->field_course_fee->value.'</del>/- ';
                $vars['courseFeeInformation'] = (!empty($node->field_fee_information->value))?'<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="'.$node->field_fee_information->value.'"></i>':'';
                $vars['courseFAQTitle'] = (!empty($node->field_faq_title->value))?$node->field_faq_title->value:'';
                
                $courseType = $node->field_delivery_mode_code->value;
                $courseCode = $node->field_course_code->value;
                $EnrollNowLink = $node->field_enroll_now_link->value;
                $emitextprodpage = $node->field_no_cost_emi_text->value;

                if($node->field_select_template->value == 'course_stackathon'){
                    $generateEnrollNowAndAccessBtn = \Drupal::service('niit_common.twig.TwigExtension')->generateEnrollNowAndAccessBtn($node->id(), $courseCode, 'Access Your Challenge', 'Participate Now', 'DetailPage');
                    $vars['StackathonLeadForm'] = $generateEnrollNowAndAccessBtn['stackathonLeadForm'];
                    $vars['StackathonLeadFormBtn'] = $generateEnrollNowAndAccessBtn['stackathonLeadFormBtn'];
                }else if($node->field_select_template->value == 'course_selfpaced'){
                    $generateEnrollNowAndAccessBtn = \Drupal::service('niit_common.twig.TwigExtension')->generateEnrollNowAndAccessBtn($node->id(), $courseCode, 'Access Your Course', 'Enroll Now', 'DetailPage');
                    $vars['StackathonLeadForm'] = $generateEnrollNowAndAccessBtn['stackathonLeadForm'];
                    $vars['StackathonLeadFormBtn'] = $generateEnrollNowAndAccessBtn['stackathonLeadFormBtn'];
                }else if($node->field_select_template->value == 'course_new_stack_route'){
                    $tid1 = $node->get('field_lead_magnet_widget')->getValue()[0]['target_id'];
                    $node1 = \Drupal\node\Entity\Node::load($tid1);
                    $node2 = $node1->get('field_course_link')->getValue()[0]['target_id'];
                    $node4 = \Drupal\node\Entity\Node::load($node2);
                    $coursecd = $node4->get('field_course_code')->getValue()[0]['value'];
                    $generateEnrollNowAndAccessBtn = \Drupal::service('niit_common.twig.TwigExtension')->generateEnrollNowAndAccessBtn($node2, $coursecd, 'Access Your Course', 'Start Learning', 'DetailPage');
                    $vars['StackathonLeadForm'] = $generateEnrollNowAndAccessBtn['stackathonLeadForm'];
                    $vars['StackathonLeadFormBtn'] = $generateEnrollNowAndAccessBtn['stackathonLeadFormBtn'];
                }
                else{
                    $vars['StackathonLeadForm'] = "";
                    $vars['StackathonLeadFormBtn'] = "";
                }
                
            
            if($course_template_type_new == 'course_self_paced'){    
                if(!empty($node->field_start_date->date)){
                    $start_time = $node->field_start_date->date->getTimestamp();
                }
                if(!empty($node->field_enad_date->date)){
                    $end_time = $node->field_enad_date->date->getTimestamp();
                }

                $vars['timeinterval'] = date('h:i A', $start_time) .' - '. date('h:i A', $end_time);

                $vars['getEventsData'] = '';

                $cid = 'KMS:GetEventsData';
                if ($cacheitem = \Drupal::cache()->get($cid)) {

                    $cacheData = $cacheitem->data;
                    $vars['getEventsData'] =  (array) $cacheData['getEventsData'];
                    
                }
                else{

                    $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
                    if($tokenArray->status == 1){
                        $token = $tokenArray->data->token;
                        $eventsDataFields = [
                                    'module' => 'content_data_by_field',
                                    'field' => 'cgrp',
                                    'val' => 'Event',
                                    'order_by' => 'order_by',
                                    'token' => $token
                                ];
                        $vars['getEventsData'] = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($eventsDataFields);

                        $cacheObject = [
                            'getEventsData' => $vars['getEventsData'],
                        ];
                        \Drupal::cache()->set($cid, $cacheObject);

                    }

                }

             }

			}

  $form = $vars['StackathonLeadFormBtn'];
  //$form =\Drupal::formBuilder()->getForm('Drupal\ms_ajax_form_example\Form\MultiStepExampleForm');
    $ajax_response = new AjaxResponse();
    $ajax_response->addCommand(new AppendCommand('.Stackathon-Lead-Form-div', $form));
    return $ajax_response;
  }
    
}





  

