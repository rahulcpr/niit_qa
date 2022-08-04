<?php
/**
 * @file providing the service that for master Data.
*/

namespace  Drupal\custom_campaign\Services;
	use Drupal\Core\Database\Database;
	use Drupal\user\Entity\User;
	use Drupal\file\Entity\File;
    use Drupal\node\Entity\Node;
    use Drupal\taxonomy\Entity\Term;
    use Drupal\Core\Url;

class NiitKCService {
	public function __construct() {

	}

	/**
	 * @return: $fieldData as an array
	 */
	public function generateJWTToken($apiType) {
		$exp_timestamp = time() + 60*60; // now + 1 hour
       //build the headers
        $headers = [
        	'alg'=>'HS256',
        	'typ'=>'JWT'
        ];
        $headers_encoded = rtrim(strtr(base64_encode(json_encode($headers)), '+/', '-_'), '=');
        // $headers_encoded = base64url_encode(json_encode($headers));

        //build the payload
        $current_user = \Drupal::currentUser();
    	$roles = $current_user->getRoles();
    	if (in_array('niit', $roles)) {
	        $user = User::load($current_user->id());
	        $userName = $user->get('field_user_name')->value;
	        $userEmpId = $user->get('field_customer_id')->value;
	    }
		elseif (in_array('administrator', $roles)) {
			$user = User::load($current_user->id());
	        $userName = $user->get('field_user_name')->value;
	        $userEmpId = $user->getEmail();
	    }
	    else{
	    	$userName = 'Guest';
	    	$cookieAll = explode('.', $_COOKIE['_ga']);
    		$gaCookie = $cookieAll[2].'.'.$cookieAll[3];

    		$userEmpId = $gaCookie;
	    }
        $payload = [
        	'empid'=> $userEmpId,
        	'iss'=> 'NIIT',
        	'empname'=> $userName,
        	'language'=> 'en_US',
        	'exp' => $exp_timestamp
        ];
        // $payload_encoded = base64url_encode(json_encode($payload));
        $payload_encoded = rtrim(strtr(base64_encode(json_encode($payload)), '+/', '-_'), '=');

        //build the signature
        if($apiType == 'Get'){
        	$key = '45456#$%?67UP(J,PSfP';
        }else if($apiType == 'Post'){
        	$key = '1lsbmExiHa7G-Eh4jk4QeekFBISfF0FKP';
        }else{
        	$key = '';
		}

		//Checking Cache for exsting token with User specific key.
		if($apiType == 'Get'){
			$cid = 'KMS:GetToken:'.$userEmpId;
		}else if($apiType == 'Post'){
			$cid = 'KMS:PostToken:'.$userEmpId;
		}

       if ($item = \Drupal::cache()->get($cid)) {
			$cacheData = $item->data;
			if($cacheData['exp'] > (time() + 120))
			{
				return  (object) $cacheData['data'];
			}
		}

        $signature = hash_hmac('SHA256',"$headers_encoded.$payload_encoded",$key,true);
        // $signature_encoded = base64url_encode($signature);
        $signature_encoded = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        //build  the token
        $token = "$headers_encoded.$payload_encoded.$signature_encoded";
        $fieldDataSetArray = [
                    'module' => 'generate_token',
                    'sso' => $token,
                ];
        if($apiType == 'Get'){
			$data = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($fieldDataSetArray);
			if($data->status == 1 || $data->status == "1")
			{
				$cacheObject = [
					'data' => $data,
					'exp' => $exp_timestamp
				];
				\Drupal::cache()->set($cid, $cacheObject);
			}
        }else if($apiType == 'Post'){
			$data = \Drupal::service('custom_campaign.niit_kc_services')->generateSSOForPostAPI($fieldDataSetArray);
			if($data->status == 1 || $data->status == "1")
			{
				$cacheObject = [
					'data' => $data,
					'exp' => $exp_timestamp
				];
				\Drupal::cache()->set($cid, $cacheObject);
			}
        }else{
        	$data = '';
		}
		return $data;
	}

	public function GetAPICallMethod($fieldDataSetArray) {
		foreach ($fieldDataSetArray as $key => $value) {
			$output .= $key.'='.$value.'&';
		}
		$url_data = rtrim($output, '&');
		//$main_url = 'https://niit-kms-stg.niit-mts.com/api/webapi2?'.$url_data;
		$main_url = $_ENV['NIIT_KMS_API_MAP'].'api/webapi2?'.$url_data;
        $url_data_content = json_decode(file_get_contents($main_url));
	    return $url_data_content;
	}
	public function GetAPICommentMethod($fieldDataSetArray) {
		foreach ($fieldDataSetArray as $key => $value) {
			$output .= $key.'='.$value.'&';
		}
		$url_data = rtrim($output, '&');
		//$main_url = 'https://niit-kms-stg.niit-mts.com/api/webservices?'.$url_data;
		$main_url = $_ENV['NIIT_KMS_API_MAP'].'api/webservices?'.$url_data;
        $url_data_content = json_decode(file_get_contents($main_url));
	    return $url_data_content;
	}
	public function generateSSOForPostAPI($fieldDataSetArray) {
		foreach ($fieldDataSetArray as $key => $value) {
			$output .= $key.'='.$value.'&';
		}
		$url_data = rtrim($output, '&');
		// $main_url = 'https://niit-kms-stg.niit-mts.com/api/webservices.php?'.$url_data;
		$main_url = $_ENV['NIIT_KMS_API_MAP'].'api/webservices.php?'.$url_data;
        $url_data_content = json_decode(file_get_contents($main_url));
	    return $url_data_content;
	}

	public function KMSCreateContentAPI($urlDataSetArray, $fieldDataSetArray) {
		$curl = curl_init();
		foreach ($urlDataSetArray as $key => $value) {
			$output .= $key.'='.$value.'&';
		}
		$url_data = rtrim($output, '&');



		// $main_url = 'https://niitkms.training.com/api/webservices.php?'.$url_data;
		$main_url = $_ENV['NIIT_KMS_API_MAP'].'api/webservices.php?'.$url_data;

		$headers = array(
	    	"content-type: application/json"
	    );

	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $main_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldDataSetArray );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close($ch);

		\Drupal::messenger()->addStatus($response);
	    return $response;
	}
	public function KMSSearchContentAPIforEvents($urlDataSetArray, $fieldDataSetArray) {
		$curl = curl_init();
		foreach ($urlDataSetArray as $key => $value) {
			$output .= $key.'='.$value.'&';
		}
		$url_data = rtrim($output, '&');

		// $main_url = 'https://niit-kms-stg.niit-mts.com/api/webapi2?'.$url_data;
		$main_url = $_ENV['NIIT_KMS_API_MAP'].'api/webapi2?'.$url_data;
		$headers = array(
	    	"content-type: application/json"
	    );

	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $main_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldDataSetArray );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close($ch);

	    return  json_decode($response);
	}

	public function KMSSaveVote($urlDataSetArray, $fieldDataSetArray) {
		$curl = curl_init();
		foreach ($urlDataSetArray as $key => $value) {
			$output .= $key.'='.$value.'&';
		}
		$url_data = rtrim($output, '&');

		foreach ($fieldDataSetArray as $key => $value) {
			$output1 .= $key.'='.$value.'&';
		}
		$url_data1 = rtrim($output1, '&');

		// $main_url = 'https://niit-kms-stg.niit-mts.com/api/webapi2?'.$url_data;
		$main_url = $_ENV['NIIT_KMS_API_MAP'].'api/webapi2?'.$url_data;

		$headers = array(
	    	"content-type: application/x-www-form-urlencoded"
	    );

	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $main_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $url_data1 );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close($ch);
	    return json_decode($response);

	}



	public function HomePageKCData() {
		// $cid = 'HomePage:GetKCData';
  //       if ($cacheitem = \Drupal::cache()->get($cid)) {
  //           $cacheData = $cacheitem->data;
  //           $output =  (array) $cacheData['getKCArray'];
  //       }
  //       else{
            $KCQuery = \Drupal::entityQuery('node');
            $KCQuery->condition('type', 'blog_post');
            $KCQuery->condition('field_show_on_home_page', 1);
            $KCQuery->condition('status', 1);
            $KCQuery->sort('created' , 'DESC');
            $KCQuery->range(0, 9);
            $KCNodeIds = $KCQuery->execute();
            $KCData = [];
            $i = 0;
            foreach ($KCNodeIds as $KCNodeId) {
                $nodeData = Node::load($KCNodeId);
                $node_alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$KCNodeId);
                // $host_url = \Drupal::request()->getSchemeAndHttpHost();
                $KCData[$i]['nid'] = $KCNodeId;
                $KCData[$i]['node_url'] = $_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india'.$node_alias;
                // $KCData[$i]['node_url'] = $host_url.''.$node_alias;

                $KCData[$i]['title'] = $nodeData->title->value;
                if(!empty($nodeData->field_testimonial_large_image->getValue()[0]['target_id'])){
                	// $KCData[$i]['image'] = (\Drupal\file\Entity\File::load($nodeData->field_testimonial_large_image->getValue()[0]['target_id']))->url();
					$KCData[$i]['image'] = $nodeData->field_testimonial_large_image->entity->getFileUri();
                }else{
                	$KCData[$i]['image'] = "";
                }
               
                $KCData[$i]['duration'] =  $nodeData->field_duration->getValue()[0]['value'];
                $KCData[$i]['category'] =  $nodeData->field_categories->getValue()[0]['target_id'];
				if(!empty($nodeData->field_categories->getValue()[0]['target_id'])){
					$term = Term::load($nodeData->field_categories->getValue()[0]['target_id']);
	                $KCData[$i]['category_name']  = $term->get('name')->value;
				}else{
					$KCData[$i]['category_name']  = '';
				}


                $aliasManager = \Drupal::service('path.alias_manager');
                $term_url = $aliasManager->getAliasByPath('/taxonomy/term/'.$nodeData->field_categories->getValue()[0]['target_id']);
                $KCData[$i]['category_url'] = $_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india'.$term_url;
                // $KCData[$i]['category_url'] = $host_url.''.$term_url;
                $i++;
            }
            $output = $KCData;
        //     $cacheObject = [
        //         'getKCArray' => $vars['getKCArray'],
        //     ];
        //     \Drupal::cache()->set($cid, $cacheObject);
        // }
	    return $output;
	}
	public function globalFuctionForGetUTMPerameterAndSetCookie() {
		$output = [];
		$cookieUTMParams = json_decode($_COOKIE['UTMParams']);
		if(empty($_COOKIE['UTMParams'])){
			unset($_COOKIE['UTMParams']);
			$reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
	        if(!empty($reffer_array[1])){
	        	$output['utmApplcbl'] = 'Y';

	        	$output['utm_params']['utm_source'] = '';
	        	$output['utm_params']['utm_medium'] = '';
	        	$output['utm_params']['utm_campaign'] = '';
	        	$output['utm_params']['utm_content'] = '';
	        	$output['utm_params']['utm_term'] = '';

				$query_string = explode('&', $reffer_array[1]);
				foreach($query_string as $val){
					$data = explode("=", $val);
					if($data[0] == 'utm_source'){
						$output['utm_params'][$data[0]] = $data[1];
					}else if($data[0] == 'utm_medium'){
						$output['utm_params'][$data[0]] = $data[1];
					}else if($data[0] == 'utm_campaign'){
						$output['utm_params'][$data[0]] = $data[1];
					}else if($data[0] == 'utm_content'){
						$output['utm_params'][$data[0]] = $data[1];
					}else if($data[0] == 'utm_term'){
						$output['utm_params'][$data[0]] = $data[1];
					}else if($data[0] == 'utm_siteid'){
						$output['utm_params']['SiteID'] = $data[1];
					}else{
						$output['utm_params'][$data[0]] = (!empty($data[1]))?$data[1]:'';
					}
					
				}
			}else{
				$output['utmApplcbl'] = 'N';
			}
			setcookie('UTMParams', json_encode($output), time() + (2592000 * 3), '/');
		}
		
	    return $output;

	}
	// public function fuctionForPostUTMPerameter() {
	// 	$output = [];
	// 	if(!empty($_COOKIE['UTMParams'])){
	// 		$utm_data_array = json_decode($_COOKIE['UTMParams']);
	//         if($utm_data_array->utmApplcbl == 'Y'){
	//             foreach ($utm_data_array->utm_params as $key => $value) {
	//                $output[$key] = $value;
	//             }
	//         }
	// 	}
	//     return $output;

	// }

}
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
