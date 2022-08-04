<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;


class LeadencryptJoinWebnier extends ControllerBase {    
    public function ControllerPage() {

        $node_id = $_POST['node_id'];
        $lead_encrypt = $_POST['lead_encrypt'];
        $lead_cd = $_POST['lead_cd'];
        $link_start_time = '';
        $start_datetime = '';  
        $camp_code = 'NIITCOM';
	    $node = Node::load($node_id);
        if($node->bundle() == 'webinar'){

	        if(!empty($node->field_link_open_date->date)){
	           $link_start_time = $node->field_link_open_date->date->getTimestamp();
	        }
	        if(!empty($node->field_start_date->date)){
                $start_datetime = $node->field_start_date->date->getTimestamp();
            }
	        $camp_code = $node->field_campaign_code->value;
	        $category = $node->field_webinar_category->value; 

	        $webinar_dt = date('Y-m-d', $start_datetime);
	    	$webinar_tm = date('H:i', $start_datetime);

	        if($category == 'recorded'){
	        	$time = time();
	        	$webinar_dt = date('Y-m-d', $time);
        	    $webinar_tm = date('H:i', $time);
	        }
	        

	    	$formdata = array(
		        "lead_encrypt" => $lead_encrypt,
			    "lead_cd" => $lead_cd,
			    "cmpgn_cd" => $camp_code,
			    "page_url" => $_SERVER['HTTP_REFERER'],
			    "engagement_type" => 'webinar',
			    "webinar_dt" => $webinar_dt,
			    "webinar_tm" => $webinar_tm,
			    "call_type" => 'join',
			    "mbl_no" => $mobile,
		    );

		    SaveWebinarEngagementDetails($formdata);

	    }
    	
        
      $data = 1;  

      $return = ['data' => $data];
    
      return new JsonResponse($return);
    }
}