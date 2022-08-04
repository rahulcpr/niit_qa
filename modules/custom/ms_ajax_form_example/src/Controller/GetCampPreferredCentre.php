<?php

namespace Drupal\ms_ajax_form_example\Controller; 

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class GetCampPreferredCentre extends ControllerBase {    
    public function CallbackApi(Request $request) {
       
        $requestField = \Drupal::request()->request;
        $city = $requestField->get('city');
        $state = $requestField->get('state');
        $campaignCode = $requestField->get('campaignCode');
        $coursecode = $requestField->get('coursecode');

        $locations = array();
        $finalDataArray = get_center_data_using_city_state($campaignCode, $coursecode, $city, $state);
        if($finalDataArray->ErrorYN == 'N'){
            if(!empty($finalDataArray->dataSet)){
                foreach ($finalDataArray->dataSet->Table as $key => $value) {
                    $centerValue = $value->cntr_cd.'_'.$value->cntr_nm;
                    $locations[$centerValue] = $value->cntr_nm;
                }
            }
        }

        $count = 0;
        if(!empty($locations) && count($locations) == 1 ){

        }
        else if(!empty($locations) && count($locations) > 1 ){
           $count = 1;
        }
        else{
          $locations['11961_NIIT Central Customer Care'] = 'NIIT Central Customer Care';
          //$locations['11961_NIIT Digital'] = 'NIIT Digital';
        }

        session_start();
        $_SESSION['options'] = $locations;


        $return = ['data' => $locations, 'count' => $count ];    
        return new JsonResponse($return);

    }
}

