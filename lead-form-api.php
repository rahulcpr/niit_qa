<?php
   $data = array(
    'Name'=> $_POST["name"],
    'PhoneNo'=> $_POST["phone"],
    'EmailID'=> $_POST["email"],
    'State1'=> $_POST["state"],
    'City'=> $_POST["city"],
    'Center'=> '00201',
    'CampaignCode'=> 'NIITCOM'
    );
    $data_json = json_encode($data);
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $_ENV['LEAD_API_SCHOOL_ENT'] || "https://ppmqa.niit.com/DrupalAPI/api/Drupal/PostDataSchoolEnt",
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
        "postman-token: " . ($_ENV['LEAD_API_SCHOOL_ENT_POSTMAN_TOKEN'] || "aaf30fc9-1a70-14ae-32e2-e802d635f1cc"),
         "token: " . ($_ENV['LEAD_API_SCHOOL_ENT_TOKEN'] || "aaf30fc9-1a70-14ae-32e2-e802d635f1cc")
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
	
	echo $url;
	echo 'resposne:';
	echo $res_data;
    echo json_encode($res_data);
?>
