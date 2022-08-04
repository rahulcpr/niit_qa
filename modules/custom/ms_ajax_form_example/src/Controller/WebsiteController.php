<?php

namespace Drupal\ms_ajax_form_example\Controller; 
use Drupal\Core\Controller\ControllerBase;


class WebsiteController extends ControllerBase {    
    public function CallbackApi() {
        $camp_query=db_select('camp_ms_form_field_data','f_data');
            $camp_query->leftjoin('camp_ms_form__field_campaign_code','cmp_id','f_data.id=cmp_id.entity_id');
            $camp_query->fields('f_data',array('id'));
            $camp_query->condition('f_data.type','camp_code_master');
            $camp_query->condition('cmp_id.field_campaign_code_value','NIITCOM');
            $intent_values=$camp_query->execute()->fetchCol();
            // print_r($intent_values[0]); die;

        $intent_query=db_select('camp_ms_form_field_data','f_data');
        $intent_query->leftjoin('camp_ms_form__field_intent_code','i_code','f_data.id=i_code.entity_id');
        $intent_query->leftjoin('camp_ms_form__field_cmp_reference','camp','i_code.entity_id=camp.entity_id');
        $intent_query->leftjoin('camp_ms_form__field_campaign_code','cmp_id','camp.field_cmp_reference_target_id=cmp_id.entity_id');
        $intent_query->fields('f_data',array('title','id'));
        $intent_query->fields('i_code',array('field_intent_code_value'));
        $intent_query->condition('f_data.type','intent_master');
        $intent_query->condition('cmp_id.field_campaign_code_value','NIITCOM');
        $intent_query->condition('i_code.field_intent_code_value',0,'!=');
        $intent_query->orderBy('f_data.title','ASC');
        $intent_values=$intent_query->execute()->fetchAll();
        $field_option[''] = 'Looking For...';
        foreach($intent_values as $opt){
          $field_option[$opt->field_intent_code_value]=$opt->title;
        }

print_r($field_option); die;
        
        
        return array(
            '#type' => 'markup',
            '#markup' => 'output',
            );
    }
}

