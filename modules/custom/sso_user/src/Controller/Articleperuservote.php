<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;


class Articleperuservote extends ControllerBase {    

    public function ControllerPage($node_id) {    	

        $output = 0;
        if(!empty($node_id)){

            $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
            $token = $tokenArray->data->token;
            $authorDataFields = [
                    'module' => 'content_data_by_id',
                    'vid' => $node_id,
                    'token' => $token
                ];
            $result = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($authorDataFields);
            if(!empty($result->data[0]->fdbck)){
                if($result->data[0]->fdbck == 1){
                    $output = 1;
                }
                elseif($result->data[0]->fdbck == 0){
                    $output = 2;
                    print_r($result->data[0]);
                }
            }
        }

        return new JsonResponse($output);

    }


}