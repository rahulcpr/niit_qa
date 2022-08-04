<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Drupal\user\Entity\User;


class TermsAndCondition extends ControllerBase { 
     
    public function TermAndCondition() {
    	$base_url = (isset($_ENV['DRUPAL_PROTOCOL_DOMAIN']) && !is_null($_ENV['DRUPAL_PROTOCOL_DOMAIN'] )) ? $_ENV['DRUPAL_PROTOCOL_DOMAIN']."/india/" : \Drupal::urlGenerator()->generateFromRoute('<front>', [], ['absolute' => TRUE]);
    	$path_to_theme = $base_url.'/'.\Drupal::theme()->getActiveTheme()->getPath();
        $coursecd = $_GET['code'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://learnqa.training.com/GSMStaffAPI/api/TermCondition/GetCourseContent",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "contenttype: HTML",
            "coursecode: $coursecd",
            "postman-token: 98f73594-1570-c9f4-0201-cc65806cf04e"
          ),
        ));
         
        $tncDataArray = curl_exec($curl);
        $tncdata = json_decode($tncDataArray);
        $err = curl_error($curl);
        
        curl_close($curl);

        
        //echo '<pre>'; print_r($tncdata->DataResult->Table[0]->Content); die('fgbbbbbbbbbbbbbbb');
    	return [
            '#title' => 'T&C Page',
            '#theme' => 'terms_n_condition_page',
            '#tncDataArray' => $tncdata->DataResult->Table[0]->Content,
            '#path_to_theme' => $path_to_theme,
            '#page_num' => 1,
        ];
    }
    
}