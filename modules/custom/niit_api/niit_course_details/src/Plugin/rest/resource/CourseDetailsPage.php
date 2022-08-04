<?php

namespace Drupal\niit_course_details\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;
//use Drupal\Core\Url;
//use Drupal\Core\Link;

/**
 * Provides a Node Information
 *
 * @RestResource(
 *   id = "niit_course_details",
 *   label = @Translation("Course Details Page"),
 *   uri_paths = {
 *     "canonical" = "/get/api/niit_course_details/{node_id}"
 *   }
 * )
 */
class CourseDetailsPage extends ResourceBase {

  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
  public function get($node_id = NULL) {
  
    $output = array();
	$data = array();
	$question = array();
	
	if(is_numeric($node_id)){
			//$node_id = base64_decode($node_id); // 1 ---  MQ==
			
      $node = Node::load($node_id);
	    if($node->getType() == 'course'){
		
	      $data['nid'] =  $node->id();
		  //$shareUrl = $node->toUrl()->setAbsolute()->toString();
		  $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$node->id());

		  $data['shareurl'] = $GLOBALS['base_url'].''.$alias;
		  $data['title'] =   $node->getTitle();
		  $data['type'] =   $node->getType();
	      $banner_fid = $node->get('field_mobile_banner_image')->getValue()[0]['target_id'];
		  if(is_numeric($banner_fid)){
		    $file = File::load($banner_fid);
            $data['banner'] = $file->url();
		  }else{
		    $data['banner'] = '';
		  }
		 
		  if(is_null($node->get('field_course_newly_star_rating')->getValue()[0]['value'])){
		    $data['star'] = '0/5';
		  }else{
		    $data['star'] = $node->get('field_course_newly_star_rating')->getValue()[0]['value'].'/5';
		  }
		  $data['delivery_mode'] = $node->get('field_mode_of_delivery')->getValue()[0]['value'];
		  $data['delivery_mode_icon'] = '';
		  
		  $data['course_type'] = $node->get('field_course_type')->getValue()[0]['value'];
		  $ctype_icon = $node->get('field_course_type_icon')->getValue()[0]['target_id'];
		  if(is_numeric($ctype_icon)){
		    $file1 = File::load($ctype_icon);
		    $data['course_type_icon'] = $file1->url();
		  }else{
		    $data['course_type_icon'] = '';
		  }
		  
		  $data['course_duration'] = $node->get('field_course_duration')->getValue()[0]['value'];
		  $cduricon = $node->get('field_course_duration_icon')->getValue()[0]['target_id'];
		  if(is_numeric($cduricon)){
		    $file2 = File::load($cduricon);
		    $data['course_duration_icon'] = $file2->url();
		  }else{
		    $data['course_duration_icon'] = '';
		  }
		  $data['course_module'] = $node->get('field_course_modules')->getValue()[0]['value'];
		  $modicon = $node->get('field_course_module_icon')->getValue()[0]['target_id'];
		  if(is_numeric($modicon)){
		    $file3 = File::load($modicon);
		    $data['course_module_icon'] = $file3->url();
		  }else{
		    $data['course_module_icon'] = '';
		  }
		  
		  $data['rated'] = $node->get('field_rated_text')->getValue()[0]['value'];
		  $ricon = $node->get('field_rated_icon')->getValue()[0]['target_id'];
		  if(is_numeric($ricon)){
		    $file4 = File::load($ricon);
		    $data['rated_icon'] = $file4->url();
		  }else{
		    $data['rated_icon'] = '';
		  }
		  foreach($node->get('field_course_module_faq')->getValue() as $key => $prog_val){
            $question[] = ['question' => $prog_val['question'],'answer' => $prog_val['answer']];		  
		  }
		  $data['program'] = $question;
		  
		  foreach($node->get('field_course_details_tools')->getValue() as $key => $val){	  
			$tools[] = $val['title'];
		  }
		  if(is_null($tools)){
		    $data['tools_covered'] = [];
		  }else{
		    $data['tools_covered'] = $tools;
		  }
  
		  $output['message'] = 'data found';
		  $output['data'] = $data;
		  $output['status'] = "200";
		  
	    }else{
		
	    $output['message'] = 'Wrong Data Type';
		$output['data'] = $data;
		$output['status'] = "200";
		
		}
		
	}else{
	  
	  $output['message'] = 'Wrong Input';
      $output['data'] = $data;	  
	  $output['status'] = "400";
	  
	}
		
    return new ResourceResponse($output);			
  }
		
}