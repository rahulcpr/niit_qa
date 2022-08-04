<?php

if(isset($_REQUEST['ref']) && ( ($_REQUEST['ref']=='school') || ($_REQUEST['ref']=='enterprises')) )
{
	
 if (isset($_REQUEST['ref']) && ( ($_REQUEST['ref']=='school')))
	$category = 'School';
else if (isset($_REQUEST['ref']) && ( ($_REQUEST['ref']=='enterprises')))
	$category = 'Enterprise';
 
  $data = array(
    'Name'=> $_POST["name"],
    'PhoneNo'=> $_POST["phone"],
    'EmailID'=> $_POST["email"],
    'CompanyName'=> $_POST["company"],
    'Query'=> $_POST["query"],
	'Category'=>$category  
    );
    $data_json = json_encode($data);
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => ($_ENV['LEAD_API_SCHOOL_ENT'] ?? "https://ppmqa.niit.com/DrupalAPI/api/Drupal/PostDataSchoolEnt"),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $data_json,
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "enabled: true",
        "postman-token: " . ($_ENV['LEAD_API_SCHOOL_ENT_POSTMAN_TOKEN'] ?? "a4P4M9fF3pIgd4Vso3Iqaa3qDPRTcptquTV6eKODNtcS1bUe4+6QDQ=="),
         "Token: " . ($_ENV['LEAD_API_SCHOOL_ENT_TOKEN'] ?? "a4P4M9fF3pIgd4Vso3Iqaa3qDPRTcptquTV6eKODNtcS1bUe4+6QDQ==")
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    $res_data = array(
        'response' => $response,
        'error' => $err
    );

    curl_close($curl);
    header('Content-Type: application/json');
    echo json_encode($res_data);

}
else {
 
$data = array(
    'Name'=> $_POST["name"],
    'PhoneNo'=> $_POST["phone"],
    'EmailID'=> $_POST["email"],
    'State'=> $_POST["state"],
    'City'=> $_POST["city"],
    'Center' => "",
	'CampaignCode'=> 'NIITCOM'
    );
    $data_json = json_encode($data);
    
    $curl = curl_init();
	
    curl_setopt_array($curl, array(
      CURLOPT_URL => ($_ENV['LEAD_API_DEFAULT'] ?? "https://ppmqa.niit.com/DrupalAPI/api/Drupal/PostData"),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $data_json,
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "enabled: true",
         "postman-token: " . ($_ENV['LEAD_API_DEFAULT_POSTMAN_TOKEN'] ?? "a4P4M9fF3pIgd4Vso3Iqaa3qDPRTcptquTV6eKODNtcS1bUe4+6QDQ=="),
         "Token: " . ($_ENV['LEAD_API_DEFAULT_TOKEN'] ?? "a4P4M9fF3pIgd4Vso3Iqaa3qDPRTcptquTV6eKODNtcS1bUe4+6QDQ==")
      ),
    ));
	
	
	
	

    $response = curl_exec($curl);
    $err = curl_error($curl);

	
    $res_data = array(
        'response' => $response,
        'error' => $err
    );

    curl_close($curl);
    header('Content-Type: application/json');
    echo json_encode($res_data);
	
	
  }
?>
