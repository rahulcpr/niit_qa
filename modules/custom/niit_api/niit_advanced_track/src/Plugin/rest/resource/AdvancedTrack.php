<?php

namespace Drupal\niit_advanced_track\Plugin\rest\resource;

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
 *   id = "advanced_track",
 *   label = @Translation("Advanced Track Block"),
 *   uri_paths = {
 *     "canonical" = "/get/api/advanced_track/{node_id}"
 *   }
 * )
 */
class AdvancedTrack extends ResourceBase {

  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
  public function get($node_id = NULL) {
  
    $output = array();
	$data = array();
	
	if(is_numeric($node_id)){
			//$node_id = base64_decode($node_id); // 1 ---  MQ==
			
      $data_tid  = Node::load($node_id)->field_course_->target_id;
	  
	  $query = \Drupal::entityQuery('node')
        ->condition('type', 'course')
        ->condition('field_course_', $data_tid)
		->condition('status', 1)
        ->condition('field_select_template', 'course_selfpaced', 'NOT IN' )
		->sort('changed' , 'DESC')
		->range(0,5);
		
	  $result = $query->execute();
		
	  $pagetemp = \Drupal::entityManager()->getStorage('node')->loadMultiple($result);
	  $j=0;
	  foreach($pagetemp as $key => $value){ 
		  if($pagetemp){
			if($value->get('field_course_newly_star_rating')->value <= 5 && !empty($value->get('field_course_newly_star_rating')->value)){
				$starval = $value->get('field_course_newly_star_rating')->value.'/5';
				$course_type = 'Popular';
			}elseif($value->get('field_course_newly_star_rating')->value > 0 && !empty($value->get('field_course_newly_star_rating')->value)){
				$starval = $value->get('field_course_newly_star_rating')->value.'/5';
				$course_type = 'Trending';
			}else{
														
				$starval = '0/5';
				$course_type = '';
			}
			if(is_null($value->get('field_course_video_review')->getValue()[0]['input'])){
				$vlink =  '';
			}else{
				$vlink = $value->get(field_course_video_review)->getValue()[0]['input'];
			}
			if($value->get('field_course_type_icon')->getValue()[0]['target_id']){
				$ctype_icon = $value->get('field_course_type_icon')->getValue()[0]['target_id'];
				$file1 = File::load($ctype_icon);
				$courseicon = $file1->url();
			}else{
				$courseicon = '';
			}
				
			$data[$j] = [
						'nodeid' => $value->id(),
						'title' => $value->title->value,
						'descrption' => $value->get('field_course_summary')->value,
						'intro_videos' => $vlink,
						'star' => $starval,
						'course_type' => $course_type,
						'course_image' => file_create_url($value->get('field_course_image')->entity->getFileUri('url')),
						'course_duration' => $value->get('field_course_duration')->value,
						'course_icon' => $courseicon,
						'select_template' => $value->get('field_select_template')->value,	
						'changed_on' => $value->changed->value,
			];
				
		  }
		  $j++;			
	  }
	  $output['status'] = "200";
	  $output['message'] = 'data found';
	  $output['data'] = $data;
	}else{
	  $output["status"] = "200";
      $output["message"] = "No data found";
      $output["data"] = [];
    }	
    return new ResourceResponse($output);			
  }
		
}