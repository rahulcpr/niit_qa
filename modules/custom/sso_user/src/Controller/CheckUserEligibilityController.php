<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Drupal\user\Entity\User;
use Drupal\Core\Url; 
use Drupal\Core\Path\AliasManager;
use Drupal\Core\Session\AccountInterface;


class CheckUserEligibilityController extends ControllerBase { 
	/*******************************************
    ** New Search Page Eligibility Check Code **
    ********************************************/   
    public function EligibilitySearchPage() {
		$requestField = \Drupal::request()->request;
	    $courseCode = $requestField->get('courseCode');
    	
		$current_user = \Drupal::currentUser(); 
        if($current_user->id() > 0){ 
            $user = User::load($current_user->id()); 
			
        } 
		$uid = \Drupal::currentUser()->id();
		
        $roles = $current_user->getRoles();
		$user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id()); 
        $userMail = $user->get('mail')->value;
		$userMobileNo = $user->get('field_mobile_number')->value;
		
		
		
	// $current_id = \Drupal::currentUser()->id();
	// if($current_id == 0 || empty($current_id)){
    //   $current_id = 0;
	//   print_r($current_id);
	// }
	
	// $crs_cd = $formdata['intrstd_prgrm'];
	// $mbl_no = $formdata['enqry_crsspndnc_mbl'];
	// $email_id = $formdata['enqry_crsspndnc_eml'];

	// print_r($email_id);
	
    // $data_array = array();
	// foreach($formdata as $key => $val){
      // $data_array[] = [
      		// 'Profile_code' => $key,
      		// 'Profile_value' => $val
      // ];
	// }

    // $data_json = json_encode($data_array);

	
	
    $processed = FALSE;
	$ERROR_MESSAGE = 'Test';
	$headers = array(
    	"content-type: application/json",
    	"MBL_NO: $userMobileNo",
    	"CRS_CD : $courseCode",
	    "EMAIL_ID: $userMail",
	    'Content-Length: 0',
    );
	//$url = "https://ccstg.niiteducation.com/CRMCallcenterAPI/api/CallCenter/GetCustomerEligibilitydetails";
    $url = $_ENV['EligibilityAPIURL'];

    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	curl_close($ch);
	
    $data_response = json_decode($response);
	//print_r($data_response); die;

    $eligibilityStatus = '';
	$pCode = "";
	$msg = "";
	// if($current_user->id() == 1) {
	if($data_response->ErrorYN == 'N') {
	   foreach($data_response->dataSet->Table as $resultData) {
	       if($resultData->enqry_crsspndnc_mbl == $userMobileNo && $resultData->enqry_crsspndnc_eml == $userMail) {
			   if($resultData->eligibleflg == "Y"){
				$eligibilityStatus = '<p class="program eligibiltSucess"> <i class="fa fa-check-circle" aria-hidden="true"></i> You are eligible for this program.</p>';
			   }elseif($resultData->eligibleflg == "N"){
				$eligibilityStatus = '<p class="program eligibiltFail"> <i class="fa fa-frown-o" aria-hidden="true"></i>
 				 You are not eligible for this program.</p>';

			   }
	           
	           $pCode = $resultData->intrstd_prgrm;

	       }
	   }    
	}
	// }	
	else {
	    $msg = $data_response->Message;
	}
	//print_r([ 'data' => $data, 'method' => 'GET', 'status'=> 200]);die;
		return new JsonResponse([ 'eligibilityStatus' => $eligibilityStatus, 'pCode' => $pCode, 'msg' => $msg ]);	
	}
    
}  


