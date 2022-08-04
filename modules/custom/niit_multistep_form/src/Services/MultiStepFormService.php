<?php
/**
 * @file providing the service that for master Data.
*/

namespace  Drupal\niit_multistep_form\Services;
use Drupal\Core\Database\Database;

class MultiStepFormService {
	public function __construct() {
		
	}

	/**
	 * @return: $fieldData as an array
	 */
	public function getMultiStepFormFieldData($event, $campCode, $intent, $screenLevel) {
		$database = \Drupal::database();
		$selectQuery = $database->select('custom_multistep_form_table', 's')
	            ->condition('campaign_code', $campCode)
	            ->condition('event_name', $event)
	            ->condition('screen_level', $screenLevel)
	            ->condition('intent', $intent)
	            ->fields('s');
	    $fieldsDataArr = $selectQuery->execute()->fetchAssoc();
	    $fieldData = json_decode($fieldsDataArr['fields_data'], true);
		return $fieldData;		
	}

	public function campperstepAllFormFields($a){

		$event = $a['event'];
	    $camp = $a['campCode'];
	    $intent = $a['intent'];
	    $screenLevel = $a['screenLevel'];
	    $field_id = $a['field_id'];
	    $intent_id = $a['intent_id'];
	    // $camplabel = $a['label_value'];
	    $field_label_option = $a['field_label_option'];
    
	    $field_items=array();
	    $field_values = array();
        foreach($field_id as $v){
            $database = \Drupal::database();
		    $field_query = $database->query("SELECT * FROM {camp_ms_form__field_form_item_id} as i INNER JOIN {camp_ms_form__field_input_type} as t ON i.entity_id=t.entity_id INNER JOIN {camp_ms_form__field_caption} as c ON i.entity_id=c.entity_id LEFT JOIN {camp_ms_form__field_select_options} as s ON i.entity_id=s.entity_id LEFT JOIN {camp_ms_form__field_number_minlength} as min ON i.entity_id=min.entity_id LEFT JOIN {camp_ms_form__field_number_maxlength} as max ON i.entity_id=max.entity_id LEFT JOIN {camp_ms_form__field_required} as r ON i.entity_id=r.entity_id where i.bundle='campaign_form_fields' and i.entity_id='$v' ");
		    $field_values[]=$field_query->fetchObject();
        }
	    
	    foreach($field_values as $key => $data){
	    	$field_items['camp'] = $camp;
	    	$field_items['event'] = $event;
	    	$field_items['screen_level'] = $screenLevel;
	    	$field_items['intent'] = $intent;
	        $field_items['screen']['id'] =$intent_id;
	        $field_items['label_value'] = $camplabel;
	        $field_items['field_label_option'] = $field_label_option;

	      if($data->field_input_type_value == 'select' || $data->field_input_type_value == 'checkboxes' || $data->field_input_type_value == 'radios' || $data->field_input_type_value == 'tab_radio'){
	        $field_option=array();
	        $fc_ids=array();

	        if(!empty($data->field_select_options_target_id)){

	          $opt_query=db_select('camp_ms_form_field_data','f_data');
	            $opt_query->leftjoin('camp_ms_form__field_option_fc','opt_fc','f_data.id=opt_fc.entity_id');
	            $opt_query->fields('opt_fc',array('field_option_fc_value'));
	            $opt_query->fields('f_data',array('title'));
	            $opt_query->condition('f_data.type','select_options');
	            $opt_query->condition('opt_fc.entity_id',$data->field_select_options_target_id);
	            $opt_values=$opt_query->execute()->fetchAll();
	            foreach($opt_values as $fc_data){
	              $opt_default=$fc_data->title;
	              $fc_ids[$fc_data->field_option_fc_value]=$fc_data->field_option_fc_value;
	            }
	            if($data->field_input_type_value == 'select'){
	              $field_option[''] = $opt_default;
	            }
	            if(!empty($fc_ids)){
	              $opt_query=db_select('field_collection_item__field_opt_label','f_label');
	              $opt_query->leftjoin('field_collection_item__field_option_index','f_index','f_label.entity_id=f_index.entity_id');
	              $opt_query->fields('f_label',array('field_opt_label_value'));
	              $opt_query->fields('f_index',array('field_option_index_value'));
	              $opt_query->condition('f_label.bundle','field_option_fc');
	              $opt_query->condition('f_label.entity_id',$fc_ids,'IN');
	              $opt_values=$opt_query->execute()->fetchAll();
	              $new_option = array();
	              foreach($opt_values as $sort){
	                $new_option[$sort->field_option_index_value] = $sort;
	              }
	              ksort($new_option);
	              foreach($new_option as $opt){
	                  if($data->field_input_type_value == 'tab_radio'){
	                    $field_option[$opt->field_option_index_value]=$opt->field_opt_label_value;
	                  }
	                  else{
	                    $field_option[$opt->field_opt_label_value]=$opt->field_opt_label_value;
	                  }
	              }
	            }
	          
	        }
	        
	        $field_items['field'][$key] =[
	          'field_id' => $data->field_form_item_id_value,
	          'type' => $data->field_input_type_value,
	          'caption' =>$data->field_caption_value,
	          'options' => $field_option,
	          'require' => $data->field_required_value,
	        ];  
	      }
	      else if($data->field_input_type_value == 'google_place'){
	        $field_items['field'][$key] =[
	          'field_id' => $data->field_form_item_id_value,
	          'type' => 'google_place',
	          'caption' =>$data->field_caption_value,
	          'require' => $data->field_required_value,
	        ];
	      } 
	      else if($data->field_input_type_value == 'textfield'){
	        $field_items['field'][$key] =[
	          'field_id' => $data->field_form_item_id_value,
	          'type' => $data->field_input_type_value,
	          'caption' =>$data->field_caption_value,
	          'require' => $data->field_required_value,
	        ];
	      }else if($data->field_input_type_value == 'number' || $data->field_input_type_value == 'marks_percentage'){
	        $minlength = 0;
	        if(!empty($data->field_number_minlength_value)){
	          $minlength = $data->field_number_minlength_value;
	        }
	        $maxlength = 100;
	        if(!empty($data->field_number_maxlength_value)){
	          $maxlength = $data->field_number_maxlength_value;
	        }
	        $field_items['field'][$key] =[
	          'field_id' => $data->field_form_item_id_value,
	          'type' => $data->field_input_type_value,
	          'caption' =>$data->field_caption_value,
	          'minlength' => $minlength,
	          'maxlength' => $maxlength,
	          'require' => $data->field_required_value,
	        ];
	      }
	      else if($data->field_input_type_value == 'date'){
	        $field_items['field'][$key] =[
	          'field_id' => $data->field_form_item_id_value,
	          'type' => $data->field_input_type_value,
	          'caption' =>$data->field_caption_value,
	          'require' => $data->field_required_value,
	        ];
	      }
		   else if($data->field_input_type_value == 'advance_work_experience'){
	        $field_items['field'][$key] =[
	          'field_id' => $data->field_form_item_id_value,
	          'type' => $data->field_input_type_value,
	          'caption' =>$data->field_caption_value,
	          'require' => $data->field_required_value,
	        ];
	      }
	      else if($data->field_input_type_value == 'advanced_date'){
	        $field_items['field'][$key] =[
	          'field_id' => $data->field_form_item_id_value,
	          'type' => $data->field_input_type_value,
	          'caption' =>$data->field_caption_value,
	          'require' => $data->field_required_value,
	        ];
	      }
		  else if($data->field_input_type_value == 'whatsapp_checkbox'){
	        $field_items['field'][$key] =[
	          'field_id' => $data->field_form_item_id_value,
	          'type' => $data->field_input_type_value,
	          'caption' =>$data->field_caption_value,
	          'require' => $data->field_required_value,
	        ];
	      }
		  else if($data->field_input_type_value == 'user_language'){
	        $field_items['field'][$key] =[
	          'field_id' => $data->field_form_item_id_value,
	          'type' => $data->field_input_type_value,
	          'caption' =>$data->field_caption_value,
	          'require' => $data->field_required_value,
	        ];
	      }
		  else if($data->field_input_type_value == 'free_trial_check'){
	        $field_items['field'][$key] =[
	          'field_id' => $data->field_form_item_id_value,
	          'type' => $data->field_input_type_value,
	          'caption' =>$data->field_caption_value,
	          'require' => $data->field_required_value,
	        ];
	      }
	      $field_option=array();
	    }

	    return $field_items;
	}


}