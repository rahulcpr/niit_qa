<?php

namespace Drupal\niit_common\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;
use Drupal\Component\Render\FormattableMarkup;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;


class StackathonForSelfpaced extends ControllerBase {    

    public function ControllerFormBase() {

        $requestField = \Drupal::request()->request;
        $node_id = $requestField->get('nodeid');

        $node = Node::load($node_id);
        $camp = '';
        $course_code = '';
        $prfrd_cntr = '';
        $template_type = '';
        $content_type = '';
        if($node->hasField('field_campaign_code')){
          if(!empty($node->get('field_campaign_code')->getValue()[0]['value'])){
            $camp = $node->get('field_campaign_code')->getValue()[0]['value'];
            $course_code = $node->get('field_course_code')->getValue()[0]['value'];
          }
        }
        if($node->hasField('field_center_list')){
          if(!empty($node->get('field_center_list')->getValue()[0]['value'])){
            $prfrd_cntr = $node->get('field_center_list')->getValue()[0]['value'];
          }
        }
        if($node->hasField('field_select_template')){
                if(!empty($node->get('field_select_template')->getValue()[0]['value'])){
                  $template_type=$node->get('field_select_template')->getValue()[0]['value'];
            }
        }
        if($node->getType()){
                
                  $content_type = $node->getType(); 
            
        }
        $course_delivery_mode_code = $node->get('field_delivery_mode_code')->getValue()[0]['value'];
        $course_code = $node->get('field_course_code')->getValue()[0]['value'];
        $batchIdWith = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($course_delivery_mode_code,$course_code);
        $node_data = [];
        $node_data['node_id'] = $node_id;
        $node_data['campaign_code'] = $camp;
        $node_data['course_code'] = $course_code;
        $node_data['center_name'] = $prfrd_cntr;
        $node_data['template_type'] = $template_type;
        $node_data['batchId'] = $batchIdWith['batchId'];
        $node_data['content_type'] = $content_type;

        $output = ['data' => $node_data, 'status' => 1];

        return new JsonResponse($output);



    }


}