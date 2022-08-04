<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;


class UPDownvote extends ControllerBase {    

    public function ControllerPage($node_id, $feedback) {    	

        $output = 0;
        if(!empty($node_id)){

            $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Post');
            if($tokenArray->status == 1){
                $token = $tokenArray->data->token;
                $urlDataSetArray = [
                    'module' => 'feedback',
                    'token' => $token
                ];

                $fieldDataSetArray = [
                   'vId' => $node_id,
                   'feedback' => $feedback,
                ];

                $contentCreateAPI = \Drupal::service('custom_campaign.niit_kc_services')->KMSSaveVote($urlDataSetArray, $fieldDataSetArray);

                if($contentCreateAPI->status == 1){
                   $output = 1; 
                }
                
            }

        }

        return new JsonResponse($output);

    }


}