<?php 
// Return list of all centers
function getCenterList(){
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.niit.com/india/list-center?_format=json",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
$centerList = json_decode($response);
$centerInformation = array();
foreach($centerList as $_centerList){
	
$centerInformation[] = array(
                            'centerId'=> $_centerList->nid[0]->value,   
                            'centerName'=>$_centerList->title[0]->value, 
                             'centerLatitude'=>$_centerList->field_center_latitude[0]->value,
                             'centerLongitude'=>$_centerList->field_center_longitude[0]->value,
                             'centerLocation'=>$_centerList->field_center_location[0]->value,
                             'centerCity'=>$_centerList->field_center_city[0]->value,
                             'centerCode'=>$_centerList->field_center_code[0]->value,  
                            );

}

return $centerInformation;
}

}
# Return Data searched by city

function searchByCity($data, $cityName, $latitude, $longitude, $dcity){
 $filteredCenter = array();
 foreach($data as $_data){
 # Expolde cityname by comma
 
 $cityNameList = explode(',', $cityName);
 foreach($cityNameList as $val){
  if($_data['centerCity'] == $val){
  if($dcity == "Delhi-NCR"){
  $latitude = "28.6139"; 
  $longitude = "77.2090"; 	
  }else{	  
  $latlng =  getCityLatLng($val);
  $latitude = $latlng['latitude']; 
  $longitude = $latlng['longitude'];
  }  
  $distance = distanceCalculation($latitude, $longitude, $_data['centerLatitude'], $_data['centerLongitude'], $unit = 'km', $decimals = 2); 	 
  $filteredCenter[] = array(
                    'centerId'=> $_data['centerId'],   
                    'centerName'=>$_data['centerName'], 
                     'centerLatitude'=>$_data['centerLatitude'],
                     'centerLongitude'=>$_data['centerLongitude'],
                     'centerLocation'=>$_data['centerLocation'],
                     'centerCity'=>$_data['centerCity'],
                     'centerCode'=>$_data['centerCode'], 
					 'distance'=>$distance,	
                    );	
	}
 }	

 }
  # Sort center by distance
  
    usort($filteredCenter, function($a, $b) {
        return $a['distance'] <=> $b['distance'];
    });
    return $filteredCenter;
}

// Find distance between two latitude and longitude
 
function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
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

# Get Latitude and longitude by city name

# city wise latitude and longitude

function getCityLatLng($city){
$citylatitudeLongitude = array("Agartala"=>array(),
    "Agra"=>array("latitude"=>"27.167641", "longitude"=>"78.035873"),
    "Ahmedabad"=>array("latitude"=>"23.014509", "longitude"=>"72.591759"),
    "Allahabad"=>array("latitude"=>"25.443920", "longitude"=>"81.825027"),
    "Ambala"=>array("latitude"=>"30.338430", "longitude"=>"30.338430"),
    "Amritsar"=>array("latitude"=>"31.633980", "longitude"=>"74.872261"),
    "Aurangabad"=>array("latitude"=>"19.899290", "longitude"=>"75.319489"),
    "Barasat"=>array("latitude"=>"22.780821", "longitude"=>"88.642258"),
    "Barbil"=>array("latitude"=>"22.111500", "longitude"=>"85.385498"),
    "Bari Brahmna"=>array("latitude"=>"26.645800", "longitude"=>"77.611500"),
    "Barrakpore"=>array("latitude"=>"22.966200", "longitude"=>"88.389360"),
    "Belgaum"=>array("latitude"=>"15.852760", "longitude"=>"74.511124"),
    "Bellary"=>array("latitude"=>"15.144150", "longitude"=>"76.927391"),
    "Bengaluru"=>array("latitude"=>"12.971599", "longitude"=>"77.594566"),
    "Betul"=>array("latitude"=>"21.896999", "longitude"=>"77.906502"),
    "Bhilai"=>array("latitude"=>"21.182659", "longitude"=>"81.379669"),
    "Bhilwara"=>array("latitude"=>"25.344931", "longitude"=>"74.631264"),
    "Bhopal"=>array("latitude"=>"23.259933", "longitude"=>"77.412613"),
    "Bhubaneswar"=>array("latitude"=>"20.272610", "longitude"=>"85.833122"),
    "Bhuj"=>array("latitude"=>"23.265671", "longitude"=>"23.265671"),
    "Calicut"=>array("latitude"=>"11.259090", "longitude"=>"75.781998"),
    "Chandigarh"=>array("latitude"=>"30.733315", "longitude"=>"76.779419"),
    "Chengalpattu"=>array("latitude"=>"12.700920", "longitude"=>"80.066040"),
    "Chennai"=>array("latitude"=>"13.082680", "longitude"=>"80.270721"),
    "Coimbatore"=>array("latitude"=>"11.016010", "longitude"=>"76.970306"),
    "Cuttack"=>array("latitude"=>"20.465700", "longitude"=>"85.900192"),
    "Danapur"=>array("latitude"=>"25.604030", "longitude"=>"84.985390"),
    "Darbhanga"=>array("latitude"=>"26.156349", "longitude"=>"85.894318"),
    "Dehradun"=>array("latitude"=>"30.316496", "longitude"=>"78.032188"),
    "Dharamshala"=>array("latitude"=>"32.219044", "longitude"=>"76.323402"),
    "Dimapur"=>array("latitude"=>"26.007469", "longitude"=>"93.328598"),
    "Dindigul"=>array("latitude"=>"10.363260", "longitude"=>"77.982491"),
    "Diphu"=>array("latitude"=>"25.837601", "longitude"=>"93.438499"),
    "Dist. Raigad"=>array("latitude"=>"19.196650", "longitude"=>"72.970870"),
    "Eluru"=>array("latitude"=>"16.718200", "longitude"=>"81.119500"),
    "Faridabad"=>array("latitude"=>"28.4027657", "longitude"=>"77.1789857"),
    "Ghaziabad"=>array("latitude"=>"28.6998822", "longitude"=>"77.2549398"),
    "Ghumarwin"=>array("latitude"=>"31.4482844", "longitude"=>"76.6622278"),
    "Gonda"=>array("latitude"=>"27.1437004", "longitude"=>"81.9188038"),
    "Gorakhpur"=>array("latitude"=>"26.7638512", "longitude"=>"83.3338705"),
    "Gurgaon"=>array("latitude"=>"28.4231878", "longitude"=>"76.8496932"),
    "Guwahati"=>array("latitude"=>"26.1432891", "longitude"=>"91.5627941"),
    "Gwalior"=>array("latitude"=>"26.214396", "longitude"=>"78.1208586"),
    "Haldia"=>array("latitude"=>"22.0620318", "longitude"=>"88.0236768"),
    "Haldwani"=>array("latitude"=>"29.2135639", "longitude"=>"79.5006499"),
    "Hamirpur"=>array("latitude"=>"31.6908433", "longitude"=>"76.5010211"),
    "Hyderabad"=>array("latitude"=>"17.4128084", "longitude"=>"78.1278383"),
    "Indore"=>array("latitude"=>"22.7242284", "longitude"=>"75.7237608"),
    "Jabalpur"=>array("latitude"=>"23.1758374", "longitude"=>"79.8987117"),
    "Jaipur"=>array("latitude"=>"26.8854479", "longitude"=>"75.6504691"),
    "Jammu"=>array("latitude"=>"31.2408547", "longitude"=>"77.0336518"),
    "Jodhpur"=>array("latitude"=>"26.2704897", "longitude"=>"72.9605021"),
    "Kakinada"=>array("latitude"=>"16.9769334", "longitude"=>"82.1771914"),
    "Kannur"=>array("latitude"=>"11.8666858", "longitude"=>"75.3523532"),
    "Kanpur"=>array("latitude"=>"26.4474128", "longitude"=>"780.198294"),
    "Karimganj"=>array("latitude"=>"27.3146769", "longitude"=>"78.9977903"),
    "Karur"=>array("latitude"=>"10.9652339", "longitude"=>"78.0329378"),
    "Kolkata"=>array("latitude"=>"22.6763858", "longitude"=>"88.0495232"),
    "Kumardhubi"=>array("latitude"=>"22.2608109", "longitude"=>"86.8064976"),
    "Kumbakonam"=>array("latitude"=>"10.9622546", "longitude"=>"79.333047"),
    "Lucknow"=>array("latitude"=>"26.8489293", "longitude"=>"80.802424"),
    "Madurai"=>array("latitude"=>"9.9178076", "longitude"=>"78.0527823"),
    "Mahaboobnagar"=>array("latitude"=>"16.7471237", "longitude"=>"77.9803768"),
    "Mangalore"=>array("latitude"=>"12.9231502", "longitude"=>"74.7820231"),
    "Mathura"=>array("latitude"=>"27.4745091", "longitude"=>"77.6141135"),
    "Meerut"=>array("latitude"=>"28.9874899", "longitude"=>"77.5588718"),
    "Morena"=>array("latitude"=>"26.4908878", "longitude"=>"77.9573645"),
    "Mumbai"=>array("latitude"=>"19.0826881", "longitude"=>"72.6009794"),
    "Mysore"=>array("latitude"=>"12.3108046", "longitude"=>"76.5656484"),
    "Nagaon"=>array("latitude"=>"26.3456269", "longitude"=>"92.6542166"),
    "Nagapattinam"=>array("latitude"=>"10.7796643", "longitude"=>"79.7894409"),
    "Nagercoil"=>array("latitude"=>"8.1713886", "longitude"=>"77.3800125"),
    "Nagpur"=>array("latitude"=>"21.1613484", "longitude"=>"78.9324209"),
    "New Delhi"=>array("latitude"=>"28.6139", "longitude"=>"28.6139"),
    "Noida"=>array("latitude"=>"28.5169834", "longitude"=>"77.2580414"),
    "Padrauna"=>array("latitude"=>"26.8993525", "longitude"=>"83.9591824"),
    "Palakkad"=>array("latitude"=>"10.7882494", "longitude"=>"76.6188875"),
    "Palampur"=>array("latitude"=>"32.0925193", "longitude"=>"76.4427821"),
    "Panjim"=>array("latitude"=>"15.4832775", "longitude"=>"73.8034995"),
    "Patiala"=>array("latitude"=>"30.3467846", "longitude"=>"76.3390128"),
    "Patna"=>array("latitude"=>"25.6081756", "longitude"=>"85.0730018"),
    "Pondicherry"=>array("latitude"=>"25.6081756", "longitude"=>"85.0730018"),
    "Pune"=>array("latitude"=>"25.6081756", "longitude"=>"85.0730018"),
    "Raipur"=>array("latitude"=>"25.6081756", "longitude"=>"85.0730018"),
    "Rajamundhry"=>array("latitude"=>"25.6081756", "longitude"=>"85.0730018"),
    "Ramnagar"=>array("latitude"=>"18.4409636", "longitude"=>"79.0942271"),
    "Rampur"=>array("latitude"=>"18.4081138", "longitude"=>"79.1220717"),
    "Ranchi"=>array("latitude"=>"23.3434577", "longitude"=>"85.1812372"),
    "Rohtak"=>array("latitude"=>"28.8896682", "longitude"=>"76.5462939"),
    "Rourkela"=>array("latitude"=>"22.2134008", "longitude"=>"84.7541109"),
    "Salem"=>array("latitude"=>"11.6538948", "longitude"=>"78.0680931"),
    "Samba"=>array("latitude"=>"32.5475293", "longitude"=>"75.0741252"),
    "Sarkaghat"=>array("latitude"=>"31.6998552", "longitude"=>"76.7266463"),
    "Shillong"=>array("latitude"=>"25.5902692", "longitude"=>"91.822396"),
    "Shimla"=>array("latitude"=>"31.0782882", "longitude"=>"77.1240015"),
    "Shimoga"=>array("latitude"=>"13.9323656", "longitude"=>"75.4946737"),
    "Silchar"=>array("latitude"=>"24.8282455", "longitude"=>"92.7486198"),
    "Siliguri"=>array("latitude"=>"26.719414", "longitude"=>"88.3612313"),
    "Solan"=>array("latitude"=>"30.9018052", "longitude"=>"77.0812662"),
    "Srinagar"=>array("latitude"=>"30.2280022", "longitude"=>"78.7544302"),
    "Sultanpur"=>array("latitude"=>"29.1603935", "longitude"=>"79.0527052"),
    "Sunam"=>array("latitude"=>"30.1234887", "longitude"=>"75.7766539"),
    "Surat"=>array("latitude"=>"21.1594627", "longitude"=>"72.682207"),
    "Thanjavur"=>array("latitude"=>"10.7529807", "longitude"=>"79.061408"),
    "Thiruvallur"=>array("latitude"=>"13.2470996", "longitude"=>"79.2598879"),
    "Tirupati"=>array("latitude"=>"13.6278095", "longitude"=>"79.3547595"),
    "Trichur"=>array("latitude"=>"10.5115487", "longitude"=>"76.1532091"),
    "Trichy"=>array("latitude"=>"10.8160054", "longitude"=>"78.6189866"),
    "Udaipur"=>array("latitude"=>"24.6084261", "longitude"=>"73.6370173"),
    "Udhampur"=>array("latitude"=>"32.9158516", "longitude"=>"75.1337831"),
    "Vadodara"=>array("latitude"=>"22.3223601", "longitude"=>"73.0329971"),
    "Vadodra"=>array("latitude"=>"22.3223601", "longitude"=>"73.0329971"), 
    "Varanasi"=>array("latitude"=>"25.3209013", "longitude"=>"82.9210678"),
    "Vellore"=>array("latitude"=>"12.8996062", "longitude"=>"78.9782526"),
    "Vijayawada"=>array("latitude"=>"16.5103177", "longitude"=>"80.5744199"),
    "Visakhapatnam"=>array("latitude"=>"17.7391275", "longitude"=>"82.9823841"),
    "Vishakhapatnam"=>array("latitude"=>"17.7391275", "longitude"=>"82.9823841"),
);	
$latlng = $citylatitudeLongitude[$city];	
return $latlng;
}

?>