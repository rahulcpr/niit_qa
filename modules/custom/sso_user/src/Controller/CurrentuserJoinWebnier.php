<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;


class CurrentuserJoinWebnier extends ControllerBase {    
    public function ControllerPage() {

      $node_id =$_POST['node_id'];

      $uid = \Drupal::currentUser()->id();
      if($uid > 0){
      	$user=\Drupal\user\Entity\User::load($uid);
      	if(!empty($user->get('field_communication_emailid')->value)){
          $email = $user->get('field_communication_emailid')->value;
        }
        else{
          $email = $user->get('mail')->value;
        }
	    $mobile = $user->get('field_mobile_number')->value;
	    $name = $user->get('field_user_name')->value;

        $link_start_time = '';
        $start_datetime = '';
        $camp_code = 'NIITCOM';
        $actvty_cd = '';
        $category = '';
	    $node = Node::load($node_id);
        if($node->bundle() == 'webinar'){

	        if(!empty($node->field_link_open_date->date)){
	           $link_start_time = $node->field_link_open_date->date->getTimestamp();
	        }
	        if(!empty($node->field_start_date->date)){
                $start_datetime = $node->field_start_date->date->getTimestamp();
            }
	        $camp_code = $node->field_campaign_code->value;
	        $actvty_cd = $node->field_activity_code->value;
	        $category = $node->field_webinar_category->value; 

	    }

        $time = time();  
        $check_time = $time - 12600;
        $leadformstg = 'join';
        if($link_start_time > $check_time){
           $leadformstg = 'register';
        }

        if($category == 'recorded'){
        	$leadformstg = 'join';
        }

        $ld_cd = '';
	    $cmpgn_cd = '';
	    $getleadresponse = array();
	    $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
	    if(!empty($reffer_array[1])){
	    	$query_array = explode('&', $reffer_array[1]);
	        $ld_cd = str_replace("ld_cd=","", $query_array[0]);
	        $cmpgn_cd = str_replace("cmpgn_cd=","", $query_array[1]);
	        
	    }

        if(!empty($ld_cd) && !empty($cmpgn_cd)){
            $getleadresponse = Getwebniarlead_details( $ld_cd, $cmpgn_cd );
        }

        if($cmpgn_cd == $camp_code && !empty($getleadresponse)){
        	$webinar_dt = date('Y-m-d', $start_datetime);
        	$webinar_tm = date('H:i', $start_datetime);
        	if($category == 'recorded'){
        		$webinar_dt = date('Y-m-d', $time);
        	    $webinar_tm = date('H:i', $time);
        	}

        	$formdata = array(
		        "lead_encrypt" => $ld_cd,
			    "lead_cd" => $getleadresponse['lead_cd'],
			    "cmpgn_cd" => $camp_code,
			    "page_url" => $_SERVER['HTTP_REFERER'],
			    "engagement_type" => 'webinar',
			    "webinar_dt" => $webinar_dt,
			    "webinar_tm" => $webinar_tm,
			    "call_type" => $leadformstg,
			    "mbl_no" => $mobile,
		    );

		    SaveWebinarEngagementDetails($formdata);

        }
        else{
    	  $request_time = \Drupal::time()->getCurrentTime();
	      $formdata = array(
	        'uid' => $mobile.'_'.$request_time,
	        'enqry_f_nm' => $name,
	        'enqry_crsspndnc_eml' => $email,
	        'time' => $request_time,
	      );
	      $id = multistep_user_consentapi($formdata);
	      $values['GDPR_CONSENTID']=$id;
	      $values['enqry_f_nm'] = $name;
	      $values['enqry_crsspndnc_eml'] = $email;
	      $values['enqry_crsspndnc_mbl'] = $mobile;

          $change_time = $start_datetime + 12600;
          $webinar_dt = date('Y-m-d H:i:s', $change_time);
          if($category == 'recorded'){
        		$webinar_dt = date('Y-m-d H:i:s', $request_time);
          }

	      $API2=array(
	        'leaduniqueid' => $mobile.'_'.$request_time,
	        'GDPR_CONSENTID' => $id,
	        'source' =>  $camp_code,   
	        'prfrd_cntr' => "ZZZZZ",  
	        'leadformstg' => $leadformstg,  
	        'job_fair_dt' => $webinar_dt,
	        'actvty_cd' =>  $actvty_cd,                                                                     
	      );

	      $data = array_merge($API2,$values);  //echo '<pre>'; print_r($data); die();
	      multistep_postapidate('I', $data);

        }

      }
        
      $data = 1;  

      $return = ['data' => $data];
    
      return new JsonResponse($return);
    }
}