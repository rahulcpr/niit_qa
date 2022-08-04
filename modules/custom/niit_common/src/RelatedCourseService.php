<?php
/**
* @file providing the service that will give you details about the course'.
*
*/
namespace  Drupal\niit_common;

class RelatedCourseService {
 /**
 * Get reated course details 
 * @param array $related_course_ids
 */ 

public function niit_related_courses_info($related_course_ids) {

    $result = array();
    $nodes =  \Drupal\node\Entity\Node::loadMultiple($related_course_ids);
    foreach ($nodes as $key => $node_detail) {
        if(is_object($node_detail)){
            $nid = $node_detail->id();
            $node_alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$nid);
            $course_code = !empty($node_detail->field_course_code->value)?$node_detail->field_course_code->value:'';
            $course_delivery_mode_code = !empty($node_detail->field_delivery_mode_code->value)?$node_detail->field_delivery_mode_code->value:'';
            $course_star_rating_value = !empty($node_detail->field_course_newly_star_rating->value)?$node_detail->field_course_newly_star_rating->value:'';

            $course_select_template = !empty($node_detail->field_select_template->value)?$node_detail->field_select_template->value:'';
            $course_api_fee = '';
            $course_api_base_fee = '';
            $batchAvailable = '';
            $course_batch_id = '';
            $courseId = '';
            if(!empty($course_code) && !empty($course_delivery_mode_code)) {
                $course_fee_details = self::get_course_fee_and_details($course_delivery_mode_code,$course_code);
                $batchAvailable = (!empty($course_fee_details['batchStartTime'][0]) && isset($course_fee_details['batchStartTime'][0]))?date('d M',strtotime($course_fee_details['batchStartTime'][0])):'';
                $course_api_fee = $course_fee_details['CenterBatchFee'];
                $course_api_base_fee = $course_fee_details['centerBaseFee'];
                $course_batch_id = $course_fee_details['batchId'];
                $courseId = $course_fee_details['courseBatchDetail'][0]['courseID'];
            }
            $course_image = $node_detail->get('field_course_image')->getvalue();
            if(!empty($course_image)) {
                $course_image_details = file_load($course_image[0]['target_id']);
                $course_image = file_create_url($course_image_details->uri->value);
            }
            $course_proceed_button_link = !empty($node_detail->field_proceed_button_link->value)?$node_detail->field_proceed_button_link->value:'';
            $course_enroll_now_link = !empty($node_detail->field_enroll_now_link->value)?$node_detail->field_enroll_now_link->value:'';
            $campaign_code = !empty($node_detail->field_campaign_code->value) ? $node_detail->field_campaign_code->value : 'NIITCOM';

            $result[] = array(
            'course_id' => $key,
            'courseId' => $courseId,
            'course_batch_id' => $course_batch_id,
            'course_title' => $node_detail->title->value,
            'course_short_desc' => $node_detail->field_course_search_description->value,
            // 'course_duration' => $node_detail->field_duration_in_hours->value, // this use in pre-prode
            'course_duration' => $node_detail->field_course_duration->value,
            'course_total_review' => $node_detail->field_total_reviews->value,
            'course_type' => $node_detail->field_course_type->value,
            'course_cms_fee' => $node_detail->field_course_fee->value,
            'course_api_fee' => $course_api_fee,
            'course_api_base_fee' => $course_api_base_fee,
            'course_rating' => $node_detail->field_course_rating->value,
            'course_code' => $course_code,
            'course_delivery_mode_code' => $course_delivery_mode_code,
            'course_enrollment_open' => $node_detail->field_enrollment_open->value,
            'course_image' => $course_image,
            'course_proceed_button_link' => $course_proceed_button_link,
            'course_enroll_now_link' => $course_enroll_now_link,
            'course_star_rating_value' => $course_star_rating_value,
            'batchAvailable' => $batchAvailable,
            'course_select_template' => $course_select_template,
            'campaign_code' => $campaign_code,
            'node_alias' => $node_alias,
            );

        }
        
        /* Get the course fee from API's */ 
    }

    return $result;
}

/**
 * Get the Course fee/Detail by using API's
 * @param $CourseType as $course_delivery_mode_code
 * @param $CourseCode
 */

public function get_course_fee_and_details($CourseType,$CourseCode) {
    ## Generate Token For batchdetail api 
    //$TrainingTokenApiURL  = $_ENV['TrainingTokenApiURL'];
     $TrainingTokenApiURL  = 'https://qa.training.com/niitdigitalplatformAPI/api/JWTtoken/GenerateToken';
    //$TrainingKeyAPIKey = $_ENV['TrainingKeyAPIKey'];
     $TrainingKeyAPIKey = '401b09eab3c013d4ca54922bb802bec8fd5318192b0a75f201d8b3727429090fb337591abd3e44453b954555b7a0812e1081c39b740293f765eae731f5a65ed1';
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $TrainingTokenApiURL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "key: ".$TrainingKeyAPIKey
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        $variables['apiToken'] = "";
    } 
    else {
        $res_array = json_decode($response); 
        if(array_key_exists('token', $res_array) && !is_null($res_array->token)){
            $variables['apiToken'] = $res_array->token;     
        }
        else{
            $variables['apiToken'] = "";  
        }
    }
    # Get batch, seat availability and fee detail of course
    //$TrainingCourseBatchApiURL = $_ENV['TrainingCourseBatchApiURL'];
      $TrainingCourseBatchApiURL = "https://qa.training.com/niitdigitalplatformAPI/api/CourseBatcheswrapper/";
    //$TrainingCourseBatchApiURL = $_ENV['TrainingCourseBatchApiURL'];
     $TrainingCourseBatchApiURL = "https://qa.training.com/niitdigitalplatformAPI/api/CourseBatcheswrapper/";
    $nodecurl = curl_init();
      curl_setopt_array($nodecurl, array(
      CURLOPT_URL => $TrainingCourseBatchApiURL,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "CourseType: ".$CourseType,
        // "batchId: ",
        "cache-control: no-cache",
        "centerCode: ",
        "country: ",
        "courseCode: ".$CourseCode,
        "currency: INR",
        "token: ".$variables['apiToken'],
        //"zoneName: "
      ),
    ));
    # Batch fee of center 
    $CenterBatchFee = array();
    $centerBaseFee = array();
    $node_response = curl_exec($nodecurl);
    $variables['courseBatchDetailRes'] = $node_response;
    $node_err = curl_error($nodecurl);
    curl_close($nodecurl);
    if ($node_err) {
    // echo "cURL Error #:" . $node_err;
    } 
    else {
        $courseBatchDetail = array();
        $node_response_array =  json_decode($node_response);
        $centerCode = array();
        $batchStartTime = array();
        foreach($node_response_array as $_node_response_array){
            foreach($_node_response_array as $value){       
                $centerCode[] = $value->SRC_ICD; 
                $batchStartTime[] = $value->TimeZoneShortBatchStartDateUTC;     
                $courseBatchDetail[] = array(
                    'batchID'=>$value->batchID,
                    'courseID'=>$value->courseID,
                    'batchType'=>$value->batchType,
                    'batchStartDate'=>$value->batchStartDate,
                    'batchEndDate'=>$value->batchEndDate,
                    'batchFees'=>$value->batchFees,
                    'baseFees'=>$value->baseFees,
                    'currencyCode'=>$value->currencyCode,
                    'courseCode'=>$value->courseCode,
                    'isInstallmentAvailable'=>$value->isInstallmentAvailable,
                    'IS_Batch_Available'=>$value->IS_Batch_Available,
                    'Batch_UnAvailableMeessge'=>$value->Batch_UnAvailableMeessge,
                    'batchTimings'=>$value->batchTimings,
                    'patternCode'=>$value->patternCode,
                    'SRC_ICD'=>$value->SRC_ICD,
                    'DST_ICD'=>$value->DST_ICD,
                    'SymbolType'=>$value->SymbolType,
                    'SymbolValue'=>$value->SymbolValue,
                    'Minimum_Denomination'=>$value->Minimum_Denomination,
                    'Minimum_Denomination_Value'=>$value->Minimum_Denomination_Value,
                    'IsTax_IncludeIN_Collection'=>$value->IsTax_IncludeIN_Collection,
                    'TimeZoneShortBatchStartDateUTC'=>$value->TimeZoneShortBatchStartDateUTC,
                    'BatchDD'=>$value->BatchDD,
                    'BatchMM'=>$value->BatchMM,
                    'BatchYY'=>$value->BatchYY,
                    'BatchEndDD'=>$value->BatchEndDD,
                    'BatchEndMM'=>$value->BatchEndMM,
                    'WeekType'=>$value->WeekType,
                    'batchFacultyDetails'=>$value->batchFacultyDetails,
                    'LocationCity'=>$value->LocationCity

                ); 
                $CenterBatchFee[] =  $value->batchFees;
                $centerBaseFee[] = $value->baseFees;
            }
        }
        $centerCode = array_unique($centerCode);
        $CenterBatchFee = array_unique($CenterBatchFee);
        $centerBaseFee = array_unique($centerBaseFee);
        sort($centerBaseFee);
        sort($CenterBatchFee);
        sort($batchStartTime);
        $variables['CenterBatchFee'] = max($CenterBatchFee);
        $variables['centerBaseFee'] = max($centerBaseFee);
        $courseBatchDetail = array_unique($courseBatchDetail, SORT_REGULAR);
        $variables['courseBatchDetail']=$courseBatchDetail;
        $variables['batchStartTime'] = array_unique($batchStartTime);
        $variables['centerCode']=$centerCode;
        $batchIdWithDate = array();
        $CenterBatchId = array();
        $batchId = array();

        # create batch id object start time wise
        foreach($centerCode as $_centerCode){
            foreach( $courseBatchDetail as $_courseBatchDetail ){
                if($_centerCode == $_courseBatchDetail['SRC_ICD']){
                    $batchIdWithDate[$_courseBatchDetail['SRC_ICD']][$_courseBatchDetail['TimeZoneShortBatchStartDateUTC']][]=$_courseBatchDetail['batchID'];
                    $CenterBatchId[$_courseBatchDetail['SRC_ICD']][] = $_courseBatchDetail['batchID'];
                    $batchId[] = $_courseBatchDetail['batchID'];
                }
            }
        }
        $variables['batchIdWithDate']=$batchIdWithDate;
        $variables['CenterBatchId']=$CenterBatchId;
        $variables['batchId']=implode(',', $batchId);
    }
    return $variables;
}
/* End: */ 

// -----------------------------------------------------

public function GetBatchesUsingLocation() {

	# Generate token Code
	# call api for generating of token
	if(isset($_COOKIE["userLocation"]) && !empty($_COOKIE["userLocation"])){
	    $userLocation = json_decode($_COOKIE["userLocation"]);
	    $variables['userCityName'] =  $userLocation->userCityName; // City Name
	    $variables['userLatitude'] = $userLocation->userLatitude; // Get latitude
	    $variables['userLongitude'] = $userLocation->userLongitude; // Get longitude
		
	    
	}
	else{
		$MaxMindUserName = $_ENV['MaxMindUserName'];
		// $MaxMindUserName = '74904';
		$MaxMindPassword  = $_ENV['MaxMindPassword'];
		// $MaxMindPassword  = 'j54wO9s7jgF5';
		$userIps = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
		$userIp = $userIps[0];
		$locationCurl = curl_init();
		curl_setopt_array($locationCurl, array(
		CURLOPT_URL => "https://geoip.maxmind.com/geoip/v2.1/city/".$userIp,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/vnd.maxmind.com-city+json; charset=UTF-8; version=2.1",
		    "Authorization: Basic ". base64_encode($MaxMindUserName.":".$MaxMindPassword)
		  ),
		));

		$location_rep = curl_exec($locationCurl);
		$location_err = curl_error($locationCurl);
		curl_close($locationCurl);
    	if ($location_err) {
    	    $variables['userCityName'] =  "New Delhi";
    	    $variables['userLatitude'] = "28.6139"; // Get latitude
    	    $variables['userLongitude'] = "77.2090"; // Get longitude
    	    $userLocation = array('userCityName'=>$variables['userCityName'], 'userLatitude'=>$variables['userLatitude'], 'userLongitude'=>$variables['userLongitude']);
    	 	setcookie('userLocation', json_encode($userLocation), time()+3600); 
    	}else {
    	     $location_rep_arr = json_decode($location_rep);
    	     $location_city = $location_rep_arr->city->names; // Get city name array
    	     $variables['userCityName'] =  !empty($location_city->en)? $location_city->en : "New Delhi";
    	     $locationlatlng = $location_rep_arr->location; // get location object
    	     $variables['userLatitude'] = !empty($locationlatlng->latitude) ? $locationlatlng->latitude : "28.6139"; ; // Get latitude
    	     $variables['userLongitude'] = !empty($locationlatlng->longitude) ? $locationlatlng->longitude : "77.2090" ; // Get longitude
    	     // Create array of user location such as city, latitude and longitude
    	     $userLocation = array('userCityName'=>$variables['userCityName'], 'userLatitude'=>$variables['userLatitude'], 'userLongitude'=>$variables['userLongitude']);
    	     setcookie('userLocation', json_encode($userLocation), time()+3600); 
    	 }
	}
 	// get city name in english    
	$title_array = array();
	$query = \Drupal::database()->select('node', 'n');
	$query->fields('n', ['nid']);
	$query->condition('n.type', 'center_');
	$nids = $query->execute()->fetchAll();
	# get node detail with using node id 
	$niit_center_information = array();
	// $niit_center_city = array();
	$total_center_information = array();
    $delhi_area = array('New Delhi','Noida','Faridabad','Gurgaon','Ghaziabad');
	foreach($nids as $val){
	$node_detail = \Drupal::entityManager()->getStorage('node')->load($val->nid);
	$niit_center_city = $node_detail->get('field_center_city')->value;
		// $niit_center_city[] = Node::load($val->nid)->get('field_center_city')->value;  
		if(($niit_center_city == $variables['userCityName']) || ($variables['userCityName']== 'Delhi' && in_array($niit_center_city, $delhi_area )) ){
			$centerName = $node_detail->get('title')->value;
			$centerLatitude = $node_detail->get('field_center_latitude')->value;
			$centerLongitude = $node_detail->get('field_center_longitude')->value;
			$centerLocation = $node_detail->get('field_center_location')->value;
			$centerCity = $node_detail->get('field_center_city')->value;
			$centerCode = $node_detail->get('field_center_code')->value;
            $centerPhone = $node_detail->get('field_center_phone')->value;
            $centerUSPfaculty = $node_detail->get('field_usp_faculty')->value;
            $centerUSPinfra = $node_detail->get('field_usp_infrastructure')->value;
            $centerUSPtrust = $node_detail->get('field_usp_trust')->value;
			$distance = self::CourseBatchesdistanceCalculation($variables['userLatitude'], $variables['userLongitude'], $centerLatitude, $centerLongitude, $unit = 'km', $decimals = 2); 
			$niit_center_information[] = array(
		        'centerId'=> $val->nid,   
		        'centerName'=>$centerName, 
				'centerLatitude'=>$centerLatitude,
				'centerLongitude'=>$centerLongitude,
				'centerLocation'=>$centerLocation,
				'centerCity'=>$centerCity,
				'centerCode'=>$centerCode, 
				'distance'=> $distance, 
                'centerPhone'=> $centerPhone,                         
                'centerUSPfaculty'=> $centerUSPfaculty,                         
                'centerUSPinfra'=> $centerUSPinfra,                         
                'centerUSPtrust'=> $centerUSPtrust,                         
		        );
			}
	}
	

	# sort city by distance
	usort($niit_center_information, function($a, $b) {
	    return $a['distance'] <=> $b['distance'];
	}); 
	# Set into Variables array 
	$variables['cityCenterList'] = $niit_center_information;

	return $variables;
}
# Course Faculty data
public function CourseBatchFacultyData($facultyArray, $k){
    if(!empty($facultyArray)){
        $batchFacultyDetailsCount = count($facultyArray);
        if($batchFacultyDetailsCount == 1){
            if($k == 1){
                $batchFacultyDetailsDiv .= '<div class="col-md-10 col-md-offset-1 instructorSec" id="instructorSec-'.$k.'">';
            }else{
                $batchFacultyDetailsDiv .= '<div class="col-md-10 col-md-offset-1 instructorSec" id="instructorSec-'.$k.'" style="display:none;">';
            }
            foreach ($facultyArray as $batchFacultyData) {
                $batchFacultyDetailsDiv .= '<h3 class="instructorTitle">'.$batchFacultyData->FacultyTypeText.'</h3>
                                        <div class="textTestimonial">         
                                            <p class="guestImg"><img src="'.$batchFacultyData->FacultyPic.'" class="img-responsive img-circle" style="width: 80px;"></p>
                                            <p class="guestName">'.$batchFacultyData->FacultyName.'</p>         
                                            <p class="guestDesignation">'.$batchFacultyData->FacultyDesignation.'</p>
                                            <p class="guestDescriptionss">'.$batchFacultyData->FacultyProfile.'</p>
                                        </div>';
            }
            $batchFacultyDetailsDiv .= '</div>';
        }else if($batchFacultyDetailsCount == 2){
            if($k == 1){
                $batchFacultyDetailsDiv .= '<div id="instructorSec-'.$k.'" class="instructorSec">';
            }else{
                $batchFacultyDetailsDiv .= '<div id="instructorSec-'.$k.'" class="instructorSec" style="display:none;">';
            }
            foreach ($facultyArray as $batchFacultyData) {
                $batchFacultyDetailsDiv .= '<div class="col-md-6">
                                              <h3 class="instructorTitle">'.$batchFacultyData->FacultyTypeText.'</h3>
                                              <div class="textTestimonial">         
                                                  <p class="guestImg"><img src="'.$batchFacultyData->FacultyPic.'" class="img-responsive img-circle" style="width: 80px;"></p>
                                                  <p class="guestName">'.$batchFacultyData->FacultyName.'</p>         
                                                  <p class="guestDesignation">'.$batchFacultyData->FacultyDesignation.'</p>
                                                  <p class="guestDescriptionss">'.$batchFacultyData->FacultyProfile.'</p>
                                              </div>
                                            </div>';
            }
            $batchFacultyDetailsDiv .= '</div>';
        }else{
            //
        }
    }else{
        if($k == 1){
            $batchFacultyDetailsDiv .= '<div class="col-md-10 col-md-offset-1 instructorSec" id="instructorSec-'.$k.'"> <div class="alert alert-info facultyMsg">** No Faculty Available.</div></div>';
        }else{
            $batchFacultyDetailsDiv .= '<div class="col-md-10 col-md-offset-1 instructorSec" id="instructorSec-'.$k.'" style="display:none;"><div class="alert alert-info facultyMsg"> ** No Faculty Available.</div></div>';
        }
    }
    return $batchFacultyDetailsDiv;
}
public function CourseBatchPaymentMethod($src_icd, $course_id, $course_code, $batchId){
    //$TrainingTokenApiURL  = $_ENV['TrainingTokenApiURL'];
     $TrainingTokenApiURL  = 'https://qa.training.com/niitdigitalplatformAPI/api/JWTtoken/GenerateToken';
    //$TrainingKeyAPIKey = $_ENV['TrainingKeyAPIKey'];
     $TrainingKeyAPIKey = '401b09eab3c013d4ca54922bb802bec8fd5318192b0a75f201d8b3727429090fb337591abd3e44453b954555b7a0812e1081c39b740293f765eae731f5a65ed1';
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $TrainingTokenApiURL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "key: ".$TrainingKeyAPIKey
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        $variables['apiToken'] = "";
    } 
    else {
        $res_array = json_decode($response); 
        if(array_key_exists('token', $res_array) && !is_null($res_array->token)){
            $variables['apiToken'] = $res_array->token;     
        }
        else{
            $variables['apiToken'] = "";  
        }
    }
    # Get batch, seat availability and fee detail of course
    $TrainingCourseBatchApiURL = $_ENV['TrainingCourseInstallmentApiURL'];
    // $TrainingCourseBatchApiURL = "https://qa.training.com/niitdigitalplatformAPI/api/CourseBatches/GetBatchCollectionPlanDetails";
    $TrainingCourseBatchApiURL = $_ENV['TrainingCourseInstallmentApiURL'];
    // $TrainingCourseBatchApiURL = "https://qa.training.com/niitdigitalplatformAPI/api/CourseBatches/GetBatchCollectionPlanDetails";
    $nodecurl = curl_init();
      curl_setopt_array($nodecurl, array(
      CURLOPT_URL => $TrainingCourseBatchApiURL,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "src_icd: ".$src_icd,
        "course_id: ".$course_id,
        "course_code: ".$course_code,
        "batch_id: ".$batchId,
        "currency: ",
        "collection_type: INSTALLMENT",
        "token: ".$variables['apiToken'],
        //"zoneName: "
      ),
    ));
    # Batch fee of center 
    $CenterBatchFee = array();
    $centerBaseFee = array();
    $node_response = curl_exec($nodecurl);
    $variables['courseBatchDetailRes'] = $node_response;
    $node_err = curl_error($nodecurl);
    curl_close($nodecurl);
    if ($node_err) {
    // echo "cURL Error #:" . $node_err;
    } 
    else {
        $node_response_array =  json_decode($node_response);
        $installmentData = $node_response_array->BatchCollectionPlanDetails;
    }
    return $installmentData;
}

// Courses page Installment PLan
public function CourseInstallmentPlanAPI($batchData){
	$installmentData = array();
	$INSTALLMENTARRAY = array();

    $batchType = $batchData['batchType'];
    $SRC_ICD = $batchData['SRC_ICD'];
    $courseCode = $batchData['courseCode'];

	// $TrainingTokenApiURL = 'https://qa.training.com/NIITDigitalPlatformAPI/api/Modular/CourseCollectionSummary/CourseCode/';
    $TrainingTokenApiURL = $_ENV['CourseCollectionPLANID'];

	$url = $TrainingTokenApiURL.$courseCode.'?CurrencyCode=INR&ModalID='.$batchType.'&CenterCode='.$SRC_ICD;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "OrgId: 1",
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
    // echo "cURL Error #:" . $node_err;
    } 
    else {
        $response_array =  json_decode($response);
        foreach($response_array->courseCollectionPlanSummary as $val){
        	if($val->COLLECTIONTYPE == 'INSTALLMENT'){
                $INSTALLMENTARRAY[$val->COLLECTION_PLAN_ID] = $val->COLLECTION_PLAN_ID; 
        	}
        }
    }

    if(!empty($INSTALLMENTARRAY)){
    	foreach($INSTALLMENTARRAY as $value){

    	//	$ApiURL = 'https://qa.training.com/NIITDigitalPlatformAPI/api/Modular/CourseCollectionDetails/CourseCode/';
		    $ApiURL = $_ENV['CourseCollectionSummarypercourse'];

			$new_url = $ApiURL.$courseCode.'/ModalID/'.$batchType.'/CollectionPlanID/'.$value.'/CenterCode/'.$SRC_ICD;

		    $curl = curl_init();
		    curl_setopt_array($curl, array(
		    CURLOPT_URL => $new_url,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => "",
		    CURLOPT_MAXREDIRS => 10,
		    CURLOPT_TIMEOUT => 30,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => "GET",
		    ));
		    $response = curl_exec($curl);
		    $err = curl_error($curl);
		    curl_close($curl);
		    if ($err) {
		    // echo "cURL Error #:" . $node_err;
		    } 
		    else {
		        $response_array =  json_decode($response);
		        $installmentData[] = $response_array->courseCollectionPlanDetails;
		    }
		}
	}

    return $installmentData;
}

# Course Page Installment Fee Model PopUp Section
public function CoursePageInstallmentFeeModelPopUp($paymentInstallmentData, $batchData, $nodeID, $k){
    $node_detail = \Drupal::entityManager()->getStorage('node')->load($nodeID);
    $coursePageTemplateMain = $node_detail->field_select_template->value;
    $batchDataOutputPriceModal .= '
        <div class="modal fade payment-optionsPopup" id="myModal'.$k.'" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header paymentOptionHeader">
                        <button type="button" class="close paymentModalClosebtn" data-dismiss="modal">&times;</button> 
                        <h4 class="modal-title"><strong>Payment Options</strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 leadLightBox-pl0 leadLightBox-pr0">
                                <ul class="nav nav-pills">';
    if(!empty($batchData['batchFees'])){
        $batchDataOutputPriceModal .=  '<li class="active"><a data-toggle="pill" href="#home'.$k.'">FULL PAYMENT</a></li>';
    }
    if(!empty($paymentInstallmentData)){
        $batchDataOutputPriceModal .=  '<li><a data-toggle="pill" href="#menu'.$k.'">INSTALLMENT</a></li>';
    }

    $batchDataOutputPriceModal .= '</ul>
                            </div>
                            <div class="col-md-9 paddingLeft-0">
                                <div class="tab-content">';
    if(!empty($batchData['batchFees'])){
        $batchDataOutputPriceModal .= '<div id="home'.$k.'" class="tab-pane fade in active popUpBodyHead">
                                        <p class="priceSection">
                                            <b>Fee :</b> <span class="pricePaymentOpsn"><i class="fa fa-rupee"></i> '.courseFeeNumberToCurrencyConvert($batchData['batchFees']).' </span><br>
                                            <small class="popUpInstallment">( Excluding GST @ 18% )</small>
                                        </p>
                                    </div>';
    }
    if(!empty($paymentInstallmentData)){
        $batchDataOutputPriceModal .= '<div id="menu'.$k.'" class="courseplan tab-pane fade popUpBodyHead">';
                                        foreach ($paymentInstallmentData as $key => $val) {
            $batchDataOutputPriceModal .= '<div class="row">
                                            <div class="col-md-12 col-xs-12">';
                                            if(count($paymentInstallmentData) > 1){
                                                $plan_no = $key + 1;
                                               $batchDataOutputPriceModal .= '<div class="Plan_Deta">Plan '.$plan_no.'</div>';
                                            }
                if($coursePageTemplateMain =='course_icici') {                           
                $batchDataOutputPriceModal .= '<table style="width: 100%;">
                                                    <tr><th>Month</th><th>Installment Amount</th></tr>';
                                                    $total = 0;
                                                    foreach ($val as $paymentInstallment) {
                                                        if($paymentInstallment->INSTALLMENT_TYPE == 'Monthly'){
                                                            $total += $paymentInstallment->COURSE_FEE;
                                                            $batchDataOutputPriceModal .= ' <tr><td>'.$paymentInstallment->INSTALLMENT_NUMBER.'</td><td><i class="fa fa-rupee"></i> '.courseFeeNumberToCurrencyConvertnew($paymentInstallment->COURSE_FEE).'</td></tr>';

                                                        }
                                                    }
                    $batchDataOutputPriceModal .= '<tr><th>Total</th><th><i class="fa fa-rupee"></i> '.courseFeeNumberToCurrencyConvertnew($total).'</th></tr>';
                }else{
                  $batchDataOutputPriceModal .= '<table style="width: 100%;">
                                                    <tr><th>Month</th><th>Installment Amount</th></tr>';
                                                    $total = 0;
                                                    foreach ($val as $paymentInstallment) {
                                                        if($paymentInstallment->INSTALLMENT_TYPE == 'Monthly'){
                                                            $total += $paymentInstallment->COURSE_FEE;
                                                            $batchDataOutputPriceModal .= ' <tr><td>'.$paymentInstallment->INSTALLMENT_NUMBER.'</td><td><i class="fa fa-rupee"></i> '.courseFeeNumberToCurrencyConvert($paymentInstallment->COURSE_FEE).'</td></tr>';

                                                        }
                                                    }
                    $batchDataOutputPriceModal .= '<tr><th>Total</th><th><i class="fa fa-rupee"></i> '.courseFeeNumberToCurrencyConvert($total).'</th></tr>';  
                }
                $batchDataOutputPriceModal .= '</table>
                                            </div>
                                        </div>';
                                        }  
            $batchDataOutputPriceModal .= '</div>';

    }
        
    $batchDataOutputPriceModal .= '</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    return $batchDataOutputPriceModal;
}
/**Course fee details function created by ajeet */
public function coursePageAndFeeDetail($node_detail){
    if(is_object($node_detail)){
        $nid = $node_detail->id();
        $node_alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$nid);
        $course_code = !empty($node_detail->field_course_code->value)?$node_detail->field_course_code->value:'';
        $course_delivery_mode_code = !empty($node_detail->field_delivery_mode_code->value)?$node_detail->field_delivery_mode_code->value:'';
        $course_star_rating_value = !empty($node_detail->field_course_newly_star_rating->value)?$node_detail->field_course_newly_star_rating->value:'';

        $course_select_template = !empty($node_detail->field_select_template->value)?$node_detail->field_select_template->value:'';
        $course_api_fee = '';
        $course_api_base_fee = '';
        $batchAvailable = '';
        $course_batch_id = '';
        $courseId = '';
        $apiToken = '';
        $courseBatchDetailRes = '';
        $CenterBatchFee = '';
        $centerBaseFee = '';
        $courseBatchDetail = '';
        $batchStartTime = '';
        $centerCode = '';
        $batchIdWithDate = '';
        $CenterBatchId = '';
        if(!empty($course_code) && !empty($course_delivery_mode_code)) {
            $course_fee_details = self::get_course_fee_and_details($course_delivery_mode_code,$course_code);
            $batchAvailable = (!empty($course_fee_details['batchStartTime'][0]) && isset($course_fee_details['batchStartTime'][0]))?date('d M',strtotime($course_fee_details['batchStartTime'][0])):'';
            $course_api_fee = $course_fee_details['CenterBatchFee'];
            $course_api_base_fee = $course_fee_details['centerBaseFee'];
            $course_batch_id = $course_fee_details['batchId'];
            $courseId = $course_fee_details['courseBatchDetail'][0]['courseID'];

            $apiToken = $course_fee_details['apiToken'];
            $courseBatchDetailRes = $course_fee_details['courseBatchDetailRes'];
            $CenterBatchFee = $course_fee_details['CenterBatchFee'];
            $centerBaseFee = $course_fee_details['centerBaseFee'];
            $courseBatchDetail = $course_fee_details['courseBatchDetail'];
            $batchStartTime = $course_fee_details['batchStartTime'];
            $centerCode = $course_fee_details['centerCode'];
            $batchIdWithDate = $course_fee_details['batchIdWithDate'];
            $CenterBatchId = $course_fee_details['CenterBatchId'];
        }
        $course_image = $node_detail->get('field_course_image')->getvalue();
        if(!empty($course_image)) {
            $course_image_details = file_load($course_image[0]['target_id']);
            $course_image = file_create_url($course_image_details->uri->value);
        }
        $course_proceed_button_link = !empty($node_detail->field_proceed_button_link->value)?$node_detail->field_proceed_button_link->value:'';
        $course_enroll_now_link = !empty($node_detail->field_enroll_now_link->value)?$node_detail->field_enroll_now_link->value:'';
        $campaign_code = !empty($node_detail->field_campaign_code->value) ? $node_detail->field_campaign_code->value : 'NIITCOM';

        $result[] = array(
        'course_id' => $nid,
        'courseId' => $courseId,
        'course_batch_id' => $course_batch_id,
        'course_title' => $node_detail->title->value,
        'course_short_desc' => $node_detail->field_course_search_description->value,
        'course_duration' => $node_detail->field_duration_in_hours->value,
        'course_total_review' => $node_detail->field_total_reviews->value,
        'course_type' => $node_detail->field_course_type->value,
        'course_cms_fee' => $node_detail->field_course_fee->value,
        'course_api_fee' => $course_api_fee,
        'course_api_base_fee' => $course_api_base_fee,
        'course_rating' => $node_detail->field_course_rating->value,
        'course_code' => $course_code,
        'course_delivery_mode_code' => $course_delivery_mode_code,
        'course_enrollment_open' => $node_detail->field_enrollment_open->value,
        'course_image' => $course_image,
        'course_proceed_button_link' => $course_proceed_button_link,
        'course_enroll_now_link' => $course_enroll_now_link,
        'course_star_rating_value' => $course_star_rating_value,
        'batchAvailable' => $batchAvailable,
        'course_select_template' => $course_select_template,
        'campaign_code' => $campaign_code,
        'node_alias' => $node_alias,

        'apiToken' => $apiToken,
        'courseBatchDetailRes' => $courseBatchDetailRes,
        'CenterBatchFee' => $CenterBatchFee,
        'centerBaseFee' => $centerBaseFee,
        'courseBatchDetail' => $courseBatchDetail,
        'batchStartTime' => $batchStartTime,
        'centerCode' => $centerCode,
        'batchIdWithDate' => $batchIdWithDate,
        'CenterBatchId' => $CenterBatchId,
        );

    }
    return $result;
}



# Course Installment Model PopUp Section
public function courseBatchFeeInstallmentModelPopUp($batchData, $nodeID, $k, $full_fees){
    $node_detail = \Drupal::entityManager()->getStorage('node')->load($nodeID);
    $coursePageTemplateMain = $node_detail->field_select_template->value;
    if($coursePageTemplateMain =='course_new_stack_route' || $coursePageTemplateMain =='course_campaign_page_template' || $coursePageTemplateMain =='course_program2022_page_template'){
    $batchDataOutputPriceModal .= '
        <div class="modal fade payment-optionsPopup payment-optionsPopup_new" id="myModal'.$k.'" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header paymentOptionHeader">
                        <button type="button" class="close paymentModalClosebtn" data-dismiss="modal">&times;</button> 
                        <h4 class="modal-title"><strong>Payment Options</strong></h4>
                    </div>
                    <div class="modal-body paymentOptionBody paymentOptionBodynew">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                ';
     }
     else{
        $batchDataOutputPriceModal .= '
        <div class="modal fade payment-optionsPopup" id="myModal'.$k.'" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header paymentOptionHeader">
                        <button type="button" class="close paymentModalClosebtn" data-dismiss="modal">&times;</button> 
                        <h4 class="modal-title"><strong>Payment Options</strong></h4>
                    </div>
                    <div class="modal-body paymentOptionBody">
                        <div class="row">
                            <div class="col-md-3 leadLightBox-pl0 leadLightBox-pr0">
                                <ul class="nav nav-pills">';
     }                           
    
    if($coursePageTemplateMain =='course_stack_route_ilt' || $coursePageTemplateMain == 'course_career'){
        if(!empty($node_detail->field_payment_plan_upfront->value)){
            $batchDataOutputPriceModal .=  '<li class="active"><a data-toggle="pill" href="#upfront'.$k.'">Upfront Payment</a></li>';
        } 
    }
    elseif($coursePageTemplateMain =='course_axis'){
        if(!empty($node_detail->field_payment_plan_upfront->value)){
            $batchDataOutputPriceModal .=  '<li class="active"><a data-toggle="pill" href="#upfront'.$k.'">FULL PAYMENT</a></li>';
        } 
    }
     elseif($coursePageTemplateMain =='course_new_stack_route' || $coursePageTemplateMain =='course_campaign_page_template' || $coursePageTemplateMain =='course_program2022_page_template'){
        if(!empty($node_detail->field_payment_plan_upfront->value)){
            $batchDataOutputPriceModal .=  '<div class="panel panel-default panel-defaul-new">
                <div class="panel-heading" role="tab" id="stack_headingOne">
                  <h4 class="panel-title"><a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#stack_collapseOne" aria-expanded="true" aria-controls="stack_collapseOne">Payment Upfront</a>
                  </h4>
                </div>
                   <div id="stack_collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="stack_headingOne">
              <div class="panel-body">'.$node_detail->field_payment_plan_upfront->value.'</div>
    </div>
  </div>';
        } 
    }
    else{
        if(!empty($full_fees)){
            $batchDataOutputPriceModal .=  '<li class="active"><a data-toggle="pill" href="#home'.$k.'">Full Fee Payment Plans</a></li>';
        }
        if(!empty($node_detail->field_payment_plan_upfront->value)){
           if($coursePageTemplateMain =='course_stack_route_ilt' || $coursePageTemplateMain == 'course_career'){ 
            $batchDataOutputPriceModal .=  '<li><a data-toggle="pill" href="#upfront'.$k.'">Upfront Payment</a></li>';}
           if($coursePageTemplateMain =='course_axis'){ 
            $batchDataOutputPriceModal .=  '<li><a data-toggle="pill" href="#upfront'.$k.'">FULL PAYMENT</a></li>';} 
        } 
    }   




    // <<<< merge end 
    if($coursePageTemplateMain =='course_stack_route_ilt' || $coursePageTemplateMain == 'course_career')
    {                   
        if(!empty($node_detail->field_payment_plans_no_cost_emi->value)){
            $batchDataOutputPriceModal .=  '<li><a data-toggle="pill" href="#menu'.$k.'">No Cost EMI Plans</a></li>';
        }
        if(!empty($node_detail->field_payment_plans_emi->value)){
            $batchDataOutputPriceModal .=  '<li><a data-toggle="pill" href="#sec'.$k.'">EMI Plans</a></li>';
        }
        if(!empty($node_detail->field_payment_plans_emi_plan_wit->value)){
            $batchDataOutputPriceModal .=  '<li><a data-toggle="pill" href="#sec1'.$k.'">EMI Plan With Moratorium</a></li>';
        }

    }

    if($coursePageTemplateMain =='course_axis'){                   
        if(!empty($node_detail->field_payment_plans_no_cost_emi->value)){
            $batchDataOutputPriceModal .=  '<li><a data-toggle="pill" href="#menu'.$k.'">INSTALLMENT</a></li>';
        }
        if(!empty($node_detail->field_payment_plans_emi->value)){
            $batchDataOutputPriceModal .=  '<li><a data-toggle="pill" href="#sec'.$k.'">LOAN</a></li>';
        }

    }

    if($coursePageTemplateMain =='course_new_stack_route' || $coursePageTemplateMain =='course_campaign_page_template' || $coursePageTemplateMain =='course_program2022_page_template'){

        if(!empty($node_detail->field_payment_plans_no_cost_emi->value)){
            $batchDataOutputPriceModal .=  '<div class="panel panel-default panel-defaul-new">
            <div class="panel-heading" role="tab" id="stack_headingTwo">
              <h4 class="panel-title"><a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#stack_collapseTwo" aria-expanded="true" aria-controls="stack_collapseTwo">No Cost EMI Plans</a>
              </h4>
            </div>
               <div id="stack_collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="stack_headingTwo">
          <div class="panel-body">'.$node_detail->field_payment_plans_no_cost_emi->value.'</div>
    </div>
  </div>';
        }
        if(!empty($node_detail->field_payment_plans_emi->value)){
            $batchDataOutputPriceModal .=  '<div class="panel panel-default panel-defaul-new">
    <div class="panel-heading" role="tab" id="stack_headingThree">
      <h4 class="panel-title"><a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#stack_collapseThree" aria-expanded="true" aria-controls="stack_collapseThree">EMI Plans</a>
      </h4>
    </div>
           <div id="stack_collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="stack_headingThree">
      <div class="panel-body">'.$node_detail->field_payment_plans_emi->value.'</div>
    </div>
  </div>';
        }
        if(!empty($node_detail->field_payment_plans_emi_plan_wit->value)){
            $batchDataOutputPriceModal .=  '<div class="panel panel-default panel-defaul-new">
    <div class="panel-heading" role="tab" id="stack_headingFour">
      <h4 class="panel-title"><a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#stack_collapseFour" aria-expanded="true" aria-controls="stack_collapseFour">EMI Plan With Moratorium</a>
      </h4>
    </div>
           <div id="stack_collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="stack_headingFour">
      <div class="panel-body">'.$node_detail->field_payment_plans_emi_plan_wit->value.' </div>
    </div>
 </div>
 
 ';
        }

    $batchDataOutputPriceModal .= '<div class="aply_now_button_copy_1">
            <div class="col-md-5 col-xs-6 mt-3 new_mutlistep_apply_btn new_stackroute_apply_btn new_stackroute_apply_btn_fcopy">
                <span class="btn btn-primary btnApply" onclick="popupicici_popup()">Apply Now</span>
            </div>
        </div>
         ';
    }
    
    $batchDataOutputPriceModal .= '</ul>
                            </div>
                            <div class="col-md-9 paddingLeft-0">
                                <div class="tab-content">';
    // <<<< pre-prode
    // if(!empty($batchData['batchFees'])){
    //     $batchDataOutputPriceModal .= '<div id="home'.$k.'" class="tab-pane fade in active popUpBodyHead">
    //                                     '.$node_detail->field_full_payment_content->value.'
    //                                     <p class="priceSection">
    //                                         <b>Fee :</b> <span class="pricePaymentOpsn"><i class="fa fa-rupee"></i> '.courseFeeNumberToCurrencyConvert($batchData['batchFees']).' </span><br>
    //                                         <small class="popUpInstallment">( Excluding GST @ 18% )</small>
    //                                     </p>
    //                                 </div>';
    // }
    // <<<< production
    if($coursePageTemplateMain =='course_stack_route_ilt' || $coursePageTemplateMain == 'course_axis' || $coursePageTemplateMain == 'course_career')
    {
        if(!empty($node_detail->field_payment_plan_upfront->value)){
        $batchDataOutputPriceModal .= '<div id="upfront'.$k.'" class="tab-pane fade in active popUpBodyHead">
                                        <p class="row">
                                            <div class="col-md-12 col-xs-12">
                                               '.$node_detail->field_payment_plan_upfront->value.' 
                                            </div>
                                        </p>
                                    </div>';
        }

    }
     if($coursePageTemplateMain == 'course_new_stack_route' || $coursePageTemplateMain =='course_campaign_page_template' || $coursePageTemplateMain =='course_program2022_page_template'){
        if(!empty($node_detail->field_payment_plan_upfront->value)){
        $batchDataOutputPriceModal .= '';
        }

    }
    else{
        if(!empty($node_detail->field_payment_plan_upfront->value)){
        $batchDataOutputPriceModal .= '<div id="upfront'.$k.'" class="tab-pane fade popUpBodyHead">
                                        <p class="row">
                                            <div class="col-md-12 col-xs-12">
                                               '.$node_detail->field_payment_plan_upfront->value.' 
                                            </div>
                                        </p>
                                    </div>';
        }
        elseif(!empty($full_fees)){
            $batchDataOutputPriceModal .= '<div id="home'.$k.'" class="tab-pane fade in active popUpBodyHead">
                                            '.$node_detail->field_full_payment_content->value.'
                                            <p class="priceSection">
                                                <b>Fee :</b> <span class="pricePaymentOpsn"><i class="fa fa-rupee"></i> '.courseFeeNumberToCurrencyConvert($full_fees).' </span><br>
                                                <small class="popUpInstallment">( Excluding GST @ 18% )</small>
                                            </p>
                                        </div>';
        }
        
    }
    // <<<<<<< end merge
        if(!empty($node_detail->field_payment_plans_no_cost_emi->value)){
        $batchDataOutputPriceModal .= '<div id="menu'.$k.'" class="tab-pane fade popUpBodyHead">
                                        <p class="row">
                                            <div class="col-md-12 col-xs-12">
                                               '.$node_detail->field_payment_plans_no_cost_emi->value.' 
                                            </div>
                                        </p>
                                    </div>';
        }
        if(!empty($node_detail->field_payment_plans_emi->value)){
            $batchDataOutputPriceModal .= '<div id="sec'.$k.'" class="tab-pane fade popUpBodyHead">
                                        <p class="row">
                                            <div class="col-md-12 col-xs-12">
                                               '.$node_detail->field_payment_plans_emi->value.' 
                                            </div>
                                        </p>
                                    </div>';
        }
        if(!empty($node_detail->field_payment_plans_emi_plan_wit->value)){
            $batchDataOutputPriceModal .= '<div id="sec1'.$k.'" class="tab-pane fade myCustoAccordian popUpBodyHead">
                                        <p class="row">
                                            <div class="col-md-12 col-xs-12">
                                               '.$node_detail->field_payment_plans_emi_plan_wit->value.' 
                                            </div>
                                        </p>
                                    </div>';
    }
    
    $batchDataOutputPriceModal .= '</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    return $batchDataOutputPriceModal;
}




# This function is written for getting of distance between two points   
public function CourseBatchesdistanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
    // Calculate the distance in degrees
    $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
    // Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
    switch($unit) {
        case 'km':
            $distance = ($degrees * 111.13384); // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
            break;
        case 'mi':
            $distance = $degrees * 69.05482; // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
            break;
        case 'nmi':
            $distance =  $degrees * 59.97662; // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
    }
    return round($distance, $decimals);
}

}
