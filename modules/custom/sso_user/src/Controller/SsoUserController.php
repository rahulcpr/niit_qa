<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Drupal\user\Entity\User;


class SsoUserController extends ControllerBase {    
    public function ControllerPage() {
        $output='';
        $loader = \Drupal::service('domain.negotiator');
        $current_domain = $loader->getActiveDomain();
        return array(
            '#type' => 'markup',
            '#markup' => t($output),
            );
    }
    public function MyCourseLinkGenerateRadioBtnClick(){
    	$requestField = \Drupal::request()->request;
	    $user_cid = $requestField->get('user_cid');
	    $user_email = $requestField->get('user_email');
	    $user_name = $requestField->get('user_name');
        $lnkVer = explode("@@", $requestField->get('lnkVer'));

    	$generateUserData = myCourseGenerateUserEncryptedData($user_cid);
	    if($generateUserData->ErrorYN == 'N'){
	        if(!empty($generateUserData->Message)){
	            
          		
                /**************************************************/
                if(!empty($lnkVer[0]) && $lnkVer[0] == "Y"){
                    if(!empty($lnkVer[1]) && $lnkVer[1] == "V1"){
                        $token = myProgrammeGenerateJWTToken($user_cid);
                        // $linkUrl = 'https://iv17-niit-digital.niit-mts.com/educate/niit-digital/login/sso.jsp?token='.$token;
                        $linkUrl = $_ENV['lms_niit_digital'].'/educate/niit-digital/login/sso.jsp?token='.$token;
                    }else if(!empty($lnkVer[1]) && $lnkVer[1] == "V2"){
                        $token = myProgrammeGenerateJWTToken($user_cid);
                        // $linkUrl = 'https://iv17-niit-digital.niit-mts.com/educate/niit-digital/login/sso2.jsp?token='.$token;
                        $linkUrl = $_ENV['lms_niit_digital'].'/educate/niit-digital/login/sso2.jsp?token='.$token;
                    }else{
                        $generateToken = myCourseGenerateJWTToken($user_name, $user_email, $generateUserData->Message);
                        $linkUrl = $_ENV['DOMAIN_TRAINING_COM'].'Dashboard/DigitalDashboard.aspx?token='.$generateToken->token;
                        // $linkUrl = 'https://qa.training.com/Dashboard/DigitalDashboard.aspx?token='.$generateToken->token;
                    }
                }else if(!empty($lnkVer[0]) && $lnkVer[0] == "N"){
                    // if(!empty($lnkVer[1]) && $lnkVer[1] == "V1"){
                    //     $token = myProgrammeGenerateJWTToken($user_cid);
                    //     // $linkUrl = 'https://iv17-niit-digital.niit-mts.com/educate/niit-digital/login/sso.jsp?token='.$token;
                    //     $linkUrl = $_ENV['lms_niit_digital'].'/educate/niit-digital/login/sso.jsp?token='.$token;
                    // }else if(!empty($lnkVer[1]) && $lnkVer[1] == "V2"){
                    //     $token = myProgrammeGenerateJWTToken($user_cid);
                    //     // $linkUrl = 'https://iv17-niit-digital.niit-mts.com/educate/niit-digital/login/sso2.jsp?token='.$token;
                    //     $linkUrl = $_ENV['lms_niit_digital'].'/educate/niit-digital/login/sso2.jsp?token='.$token;
                    // }else{
                        $generateToken = myCourseGenerateJWTToken($user_name, $user_email, $generateUserData->Message);
                        $linkUrl = $_ENV['DOMAIN_TRAINING_COM'].'Dashboard/DigitalDashboard.aspx?token='.$generateToken->token;
                        // $linkUrl = 'https://qa.training.com/Dashboard/DigitalDashboard.aspx?token='.$generateToken->token;
                    // }
                }else{
                    $generateToken = myCourseGenerateJWTToken($user_name, $user_email, $generateUserData->Message);
                    $linkUrl = $_ENV['DOMAIN_TRAINING_COM'].'Dashboard/DigitalDashboard.aspx?token='.$generateToken->token;
                    // $linkUrl = 'https://qa.training.com/Dashboard/DigitalDashboard.aspx?token='.$generateToken->token;
                }
                /**************************************************/

                // $linkUrl = $_ENV['DOMAIN_TRAINING_COM'].'Dashboard/DigitalDashboard.aspx?token='.$generateToken->token;
	            // $linkUrl = 'https://qa.training.com/Dashboard/DigitalDashboard.aspx?token='.$generateToken->token;

	        }
	    }
    	$return = ['data' => $linkUrl];
    	return new JsonResponse($return);
    }

    public function MyBatchesLinkGenerateClick(){
        $requestField = \Drupal::request()->request;
        // $user_cid = $requestField->get('user_cid');
        $pageNodeId = $requestField->get('pageNodeId');

        $uid = \Drupal::currentUser()->id();
        if($uid > 0){
            $user = \Drupal\user\Entity\User::load($uid);
            $user_role = $user->get('field_custom_roles')->value;
            $user_cid = $user->get('field_customer_id')->value;
        }

        $node = Node::load($pageNodeId);
        $template_type = '';
        
        
        if($node->hasField('field_select_template')){
                if(!empty($node->get('field_select_template')->getValue()[0]['value'])){
                  $template_type=$node->get('field_select_template')->getValue()[0]['value'];
            }
        }

        // $exp_timestamp = time() + 60*60; // now + 1 hour
        $exp_timestamp = time() + 60; 

        $headers = [
            'alg'=>'HS256',
            'typ'=>'JWT'
        ];
        $headers_encoded = rtrim(strtr(base64_encode(json_encode($headers)), '+/', '-_'), '=');
        // $domain = explode('//', 'https://iv17-niit-digital.niit-mts.com');
        $domain = explode('//', $_ENV['lms_niit_digital']);
        $payload = [
            'ruid'=> $user_cid, 
            'domain'=> $domain[1],
            'exp' => $exp_timestamp
        ];

        $payload_encoded = rtrim(strtr(base64_encode(json_encode($payload)), '+/', '-_'), '=');


        // $key = '6161#6WDfP$#%qPjyMKMPJKJK12523$#!BSF45';
        $key = $_ENV['lms_niit_digital_secret'];

        $signature = hash_hmac('SHA256',"$headers_encoded.$payload_encoded",$key,true);
        // $signature_encoded = base64url_encode($signature);
        $signature_encoded = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        //build  the token
        $token = "$headers_encoded.$payload_encoded.$signature_encoded";
        

        if($template_type == 'course_selfpaced' || $template_type == 'course_new_stack_route'){
         //$linkUrl = 'https://iv17-niit-digital.niit-mts.com/educate/niit-digital/login/sso2.jsp?token='.$token;
           $linkUrl = $_ENV['lms_niit_digital'].'/educate/niit-digital/login/sso2.jsp?token='.$token;
        }else{
            if($uid > 0){
                $user_custom_role_array = explode(',', $user_role);
                if(in_array("MENTOR", $user_custom_role_array) && in_array("MENTORNEW", $user_custom_role_array)){
                    // $linkUrl = 'https://iv17-niit-digital.niit-mts.com/educate/niit-digital/login/sso2.jsp?token='.$token;
                    $linkUrl = $_ENV['lms_niit_digital'].'/educate/niit-digital/login/sso2.jsp?token='.$token;
                }else if(in_array("MENTOR", $user_custom_role_array) && !in_array("MENTORNEW", $user_custom_role_array)){
                    // $linkUrl = 'https://iv17-niit-digital.niit-mts.com/educate/niit-digital/login/sso.jsp?token='.$token;
                    $linkUrl = $_ENV['lms_niit_digital'].'/educate/niit-digital/login/sso.jsp?token='.$token;
                }else if(!in_array("MENTOR", $user_custom_role_array) && in_array("MENTORNEW", $user_custom_role_array)){
                    // $linkUrl = 'https://iv17-niit-digital.niit-mts.com/educate/niit-digital/login/sso2.jsp?token='.$token;
                    $linkUrl = $_ENV['lms_niit_digital'].'/educate/niit-digital/login/sso2.jsp?token='.$token;
                }else if(in_array("TRIAL_USER", $user_custom_role_array)){
                    // $linkUrl = 'https://iv17-niit-digital.niit-mts.com/educate/niit-digital/login/sso2.jsp?token='.$token;
                    $linkUrl = $_ENV['lms_niit_digital'].'/educate/niit-digital/login/sso2.jsp?token='.$token;
                }else{
                    // $linkUrl = 'https://iv17-niit-digital.niit-mts.com/educate/niit-digital/login/sso.jsp?token='.$token;
                    $linkUrl = $_ENV['lms_niit_digital'].'/educate/niit-digital/login/sso.jsp?token='.$token;
                }
            }
        }

        
        $return = ['data' => $linkUrl];
        return new JsonResponse($return);
    }


}