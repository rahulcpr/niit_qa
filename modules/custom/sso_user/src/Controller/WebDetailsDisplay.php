<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;


class WebDetailsDisplay extends ControllerBase {    
    public function ControllerPage($node_id) {

    	$output = '';
        $node = Node::load($node_id);
        if($node->bundle() == 'webinar'){
        	$node_id = $node->id();

	        $start_time = '';
	        $link_start_time = '';
	        $link_close_time = '';
	        $lead_cd = '';
        	$enqry_nm = '';
        	$enqry_crsspndnc_eml = '';
        	$enqry_crsspndnc_mbl = '';
        	$mobile_display = '';
	        if(!empty($node->field_start_date->date)){
	           $start_time = $node->field_start_date->date->getTimestamp();
	        }
	        if(!empty($node->field_link_open_date->date)){
	           $link_start_time = $node->field_link_open_date->date->getTimestamp();
	        }
	        if(!empty($node->field_link_close_date->date)){
	           $link_close_time = $node->field_link_close_date->date->getTimestamp();
	        }

	        $category = $node->field_webinar_category->value; 

	        $check_data = '<span class="auto_js_refresh_web" startdata='.$link_start_time.' enddata='.$link_close_time.' category='.$category.'></span>';

	        if($category == 'recorded'){

	        	$uid = \Drupal::currentUser()->id();
		        if ($uid > 0) {
		        	$output = $check_data.'<div class="btn btn-default join-web reload-web btn-block" id="login-user-webinar" node_id='.$node_id.'>Join Webinar</div><div class="ajax-response"></div>';
		        }
		        else{ 

		        	$ld_cd = '';
				    $cmpgn_cd = '';
				    $getleadresponse = array();
				    $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
				    if(!empty($reffer_array[1])){
				    	$query_array = explode('&', $reffer_array[1]);
				        $ld_cd = str_replace("ld_cd=","", $query_array[0]);
				        $cmpgn_cd = str_replace("cmpgn_cd=","", $query_array[1]);
				    }

				    $camp_code = $node->field_campaign_code->value;

			        if(!empty($ld_cd) && !empty($cmpgn_cd) && $cmpgn_cd == $camp_code){
			            $getleadresponse = Getwebniarlead_details( $ld_cd, $cmpgn_cd );
			            if(!empty($getleadresponse)){
			            	$lead_cd = $getleadresponse['lead_cd'];
			            	$enqry_nm = $getleadresponse['enqry_nm'];
			            	$enqry_crsspndnc_eml = $getleadresponse['enqry_crsspndnc_eml'];
			            	$enqry_crsspndnc_mbl = $getleadresponse['enqry_crsspndnc_mbl'];

			            	$output = $check_data.'<div class="btn btn-default join-web reload-web btn-block" id="leadencrypt_joinwebniar" node_id='.$node_id.' lead_encrypt='.$ld_cd.' lead_cd='.$lead_cd.'>Join Webinar</div><div class="ajax-response"></div>';
			            }
			            else{
			            	if($link_start_time > $check_time){
			            		
			            	}
			            	else{
			            		$mobile_display = 1;
			            	}
			            	$output = $check_data.'<button type="type" class="btn btn-default join-web reload-web btn-block" data-toggle="modal" data-target="#join_webniar_modal_form">Join Webinar</button>';    
			            }
			        }
			        else{
			        	if($link_start_time > $check_time){
		            		
		            	}
		            	else{
		            		$mobile_display = 1;
		            	}
			        	$output = $check_data.'<button type="type" class="btn btn-default join-web reload-web btn-block" data-toggle="modal" data-target="#join_webniar_modal_form">Join Webinar</button>';    
			        }

		        }

	        }
	        else{

	            $time = time();  
		        $check_time = $time - 12600; 

		        $check_data = '';
		        if($check_time <= $link_close_time){
		        	$check_data = '<span class="auto_js_refresh_web" startdata='.$link_start_time.' enddata='.$link_close_time.' category='.$category.'></span><div class="web-start"><p class="date-t"><span>Date : </span>'.date('d-m-Y', $start_time).'</p><p class="date-tim"><span>Time : </span>'.date('h:i A', $start_time).'</span></div>';

		          $join_title = 'Join Webinar';
		          if($link_start_time > $check_time){
		            $join_title = 'Register';
		          }

		        	$uid = \Drupal::currentUser()->id();
			        if ($uid > 0) {
			        	$output = $check_data.'<div class="btn btn-default join-web reload-web btn-block" id="login-user-webinar" node_id='.$node_id.'>'.$join_title.'</div><div class="ajax-response"></div>';
			        }
			        else{ 

			        	$ld_cd = '';
					    $cmpgn_cd = '';
					    $getleadresponse = array();
					    $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
					    if(!empty($reffer_array[1])){
					    	$query_array = explode('&', $reffer_array[1]);
					        $ld_cd = str_replace("ld_cd=","", $query_array[0]);
					        $cmpgn_cd = str_replace("cmpgn_cd=","", $query_array[1]);
					    }

					    $camp_code = $node->field_campaign_code->value;
					    //print_r($query_array); die('jj');

				        if(!empty($ld_cd) && !empty($cmpgn_cd) && $cmpgn_cd == $camp_code){
				            $getleadresponse = Getwebniarlead_details( $ld_cd, $cmpgn_cd );
				            if(!empty($getleadresponse)){
				            	$lead_cd = $getleadresponse['lead_cd'];
				            	$enqry_nm = $getleadresponse['enqry_nm'];
				            	$enqry_crsspndnc_eml = $getleadresponse['enqry_crsspndnc_eml'];
				            	$enqry_crsspndnc_mbl = $getleadresponse['enqry_crsspndnc_mbl'];

				            	if($link_start_time > $check_time){
				            		$output = $check_data.'<button type="type" class="btn btn-default join-web reload-web btn-block" data-toggle="modal" data-target="#join_webniar_modal_form">'.$join_title.'</button>';
				            	}
				            	else{
				            		$output = $check_data.'<div class="btn btn-default join-web reload-web btn-block" id="leadencrypt_joinwebniar" node_id='.$node_id.' lead_encrypt='.$ld_cd.' lead_cd='.$lead_cd.'>'.$join_title.'</div><div class="ajax-response"></div>';
				            	}
				            }
				            else{
				            	if($link_start_time > $check_time){
				            		
				            	}
				            	else{
				            		$mobile_display = 1;
				            	}
				            	$output = $check_data.'<button type="type" class="btn btn-default join-web reload-web btn-block" data-toggle="modal" data-target="#join_webniar_modal_form">'.$join_title.'</button>';    
				            }
				        }
				        else{
				        	if($link_start_time > $check_time){
			            		
			            	}
			            	else{
			            		$mobile_display = 1;
			            	}
				        	$output = $check_data.'<button type="type" class="btn btn-default join-web reload-web btn-block" data-toggle="modal" data-target="#join_webniar_modal_form">'.$join_title.'</button>';    
				        }

			        }
		        }
		        else{
		          $output = '<div class="btn btn-default join-web-opacity btn-block">Registration Closed</div>';
		        }

	        }
	        
        }

      $return = ['data' => $output, 'lead_encrypt' => $ld_cd, 'lead_cd' => $lead_cd, 'enqry_nm' => $enqry_nm, 'enqry_crsspndnc_eml' => $enqry_crsspndnc_eml, 'enqry_crsspndnc_mbl' => $enqry_crsspndnc_mbl, 'mobile_display' => $mobile_display ];
    
      return new JsonResponse($return);
    }
}