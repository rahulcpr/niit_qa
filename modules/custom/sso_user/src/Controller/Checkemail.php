<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;


class Checkemail extends ControllerBase {    
    public function ControllerPage() {

        $output = 1;
        $email = $_POST['newemail'];
        if(!empty($email)){
        	$check_useremail = check_useremail($email);
	    	if($check_useremail == 1 && \Drupal::currentUser()->isAnonymous()){
	           $output = 0;
	    	}
        }
        else{
        	$output = 0;
        }

      $return = ['data' => $output ];
    
      return new JsonResponse($return);
    }
}