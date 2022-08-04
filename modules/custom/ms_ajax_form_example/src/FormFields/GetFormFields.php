<?php

namespace Drupal\ms_ajax_form_example\FormFields;
use Drupal\ms_ajax_form_example\FormFields\DefaultEventData;
/**
 * Class StepOne.
 *
 * @package Drupal\ms_ajax_form_example\FormFields
 */
class GetFormFields{
  
  public function StepOneFormField($event,$camp,$intent,$screen_level){
    
    $field_items=array();
    $field_values = array();

    $database = \Drupal::database();
    $check_journey = $database->query("SELECT * FROM {camp_ms_form__field_campaign_code} WHERE field_campaign_code_value ='$camp' and bundle = 'camp_code_master' ");
    $result = $check_journey->fetchAll();
    if(!empty($result)){
      $field_query=  db_select('camp_ms_form','ms');
      /**event and camp refrence join with event master and camp master*/
      $field_query->leftjoin('camp_ms_form__field_event','event','ms.id=event.entity_id');
      $field_query->leftjoin('camp_ms_form__field_campaign_reference','cmp_ref','event.entity_id=cmp_ref.entity_id');
      $field_query->leftjoin('camp_ms_form__field_event_code','event_code','event.field_event_target_id=event_code.entity_id');
      $field_query->leftjoin('camp_ms_form__field_campaign_code','campaign_code','cmp_ref.field_campaign_reference_target_id=campaign_code.entity_id');

        /**intent code and intent refrence */
     // $field_query->leftjoin('camp_ms_form__field_intent','intent','event.entity_id=intent.entity_id');
     // $field_query->leftjoin('camp_ms_form__field_intent_code','intent_master','intent.field_intent_target_id=intent_master.entity_id');

      /**screen refrence load entity with target id*/
      $field_query->leftjoin('camp_ms_form__field_screen_number','screen','event.entity_id=screen.entity_id');
      $field_query->leftjoin('camp_ms_form__field_screen_level','screen_level','screen_level.entity_id=screen.field_screen_number_target_id');
      
      /**profile journey field */
      $field_query->leftjoin('camp_ms_form__field_caption_text','caption_text','event.entity_id=caption_text.entity_id');
      $field_query->leftjoin('camp_ms_form__field__seq_number','fld_seq','event.entity_id=fld_seq.entity_id');
          
      /**get field form field master */
      $field_query->leftjoin('camp_ms_form__field_form_field_reference','field_ref','event.entity_id=field_ref.entity_id');
      $field_query->leftjoin('camp_ms_form__field_form_item_id','item_id','field_ref.field_form_field_reference_target_id=item_id.entity_id');
      $field_query->leftjoin('camp_ms_form__field_input_type','item_type','item_id.entity_id=item_type.entity_id');
      $field_query->leftjoin('camp_ms_form__field_select_options','s_opt','item_id.entity_id=s_opt.entity_id');
      $field_query->leftjoin('camp_ms_form__field_number_minlength','min','item_id.entity_id=min.entity_id');
      $field_query->leftjoin('camp_ms_form__field_number_maxlength','max','item_id.entity_id=max.entity_id');
      $field_query->leftjoin('camp_ms_form__field_required','req','item_id.entity_id=req.entity_id');


      $field_query->fields('screen',array('field_screen_number_target_id'));
      $field_query->fields('screen_level',array('field_screen_level_value'));
      $field_query->fields('item_id',array('field_form_item_id_value'));
      $field_query->fields('item_type',array('field_input_type_value'));
      $field_query->fields('min',array('field_number_minlength_value'));
      $field_query->fields('max',array('field_number_maxlength_value'));
      $field_query->fields('s_opt',array('field_select_options_target_id'));
      $field_query->fields('caption_text',array('field_caption_text_value'));
      $field_query->fields('req',array('field_required_value'));

      $field_query->condition('event_code.field_event_code_value',$event);
      $field_query->condition('campaign_code.field_campaign_code_value',$camp);
    //  $field_query->condition('intent_master.field_intent_code_value',$intent);
      $field_query->condition('screen_level.field_screen_level_value',$screen_level);

      $field_query->orderBy('fld_seq.field__seq_number_value','ASC');
      $field_values=$field_query->execute()->fetchAll();

    }
    $sid='sid';
    if(count($field_values) == 0 || count($field_values) < 1 ){
      $field_values = DefaultEventData::GetDefaultFieldQuery($event,'NIITCOM',0, $screen_level);
      $camp='NIITCOM';
    }
    
    foreach($field_values as $key => $data){
      if($sid =='sid'){
        $field_items['screen']['id'] =$data->field_screen_number_target_id;
      }
      $sid='';
      if($data->field_input_type_value == 'select' || $data->field_input_type_value == 'checkboxes' || $data->field_input_type_value == 'radios' || $data->field_input_type_value == 'tab_radio'){
        $field_option=array();
        $fc_ids=array();
        // if($data->field_caption_text_value == 'City' || $data->field_form_item_id_value == 'enqry_crsspndnc_city'){
        //   $city_query=db_select('camp_ms_form_field_data','f_data');
        //       $city_query->leftjoin('camp_ms_form__field_city_code','c_code','f_data.id=c_code.entity_id');
        //       $city_query->fields('f_data',array('title','id'));
        //       $city_query->fields('c_code',array('field_city_code_value'));
        //       $city_query->condition('f_data.type','city_master');
        //       $city_query->orderBy('f_data.title','ASC');
        //       $city_values=$city_query->execute()->fetchAll();
        //       $field_option[''] = 'City';
        //       foreach($city_values as $opt){
        //         $field_option[$opt->field_city_code_value]=$opt->title;
        //       }
              
        // }else
        if(!empty($data->field_select_options_target_id)){
          /**
           * Get option value from field collection
           * 
           * @get field collection entity id */
          
          /***
           * 
           * 
           * 
           * 
           * 
           */
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
                // if($data->field_form_item_id_value == 'prfrd_cntr'){
                //   $prfrd_key = $opt->field_option_index_value.'_'.$opt->field_opt_label_value;
                //   $field_option[$prfrd_key]=$opt->field_opt_label_value;
                // }else{
                  if($data->field_input_type_value == 'tab_radio'){
                    $field_option[$opt->field_option_index_value]=$opt->field_opt_label_value;
                  }
                  else{
                    $field_option[$opt->field_opt_label_value]=$opt->field_opt_label_value;
                  }
                  
              //  }
              }
            }

          /**
           * 
           * 
           * 
           * 
           * 
           */
          
        }
        
        $field_items['field'][$key] =[
          'field_id' => $data->field_form_item_id_value,
          'type' => $data->field_input_type_value,
          'caption' =>$data->field_caption_text_value,
          'options' => $field_option,
          'require' => $data->field_required_value,
        ];  
      }
      else if($data->field_input_type_value == 'google_place'){
        $field_items['field'][$key] =[
          'field_id' => $data->field_form_item_id_value,
          'type' => 'google_place',
          'caption' =>$data->field_caption_text_value,
          'require' => $data->field_required_value,
        ];
      } 
      else if($data->field_input_type_value == 'textfield'){
        $field_items['field'][$key] =[
          'field_id' => $data->field_form_item_id_value,
          'type' => $data->field_input_type_value,
          'caption' =>$data->field_caption_text_value,
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
          'caption' =>$data->field_caption_text_value,
          'minlength' => $minlength,
          'maxlength' => $maxlength,
          'require' => $data->field_required_value,
        ];
      }
      else if($data->field_input_type_value == 'date'){
        $field_items['field'][$key] =[
          'field_id' => $data->field_form_item_id_value,
          'type' => $data->field_input_type_value,
          'caption' =>$data->field_caption_text_value,
          'require' => $data->field_required_value,
        ];
      }
      // if($key == 2){  
      //   $database = \Drupal::database();
      //   $check_intent = $database->query("SELECT * FROM {camp_ms_form__field_is_intent_applicable} as i INNER JOIN {camp_ms_form__field_campaign_code} as c ON i.entity_id=c.entity_id WHERE i.bundle = 'camp_code_master' and  i.field_is_intent_applicable_value=1 and c.field_campaign_code_value='$camp'")->fetchAll();
      //   if(!empty($check_intent)){
      //     $field_option=array();
      //     $intent_query=db_select('camp_ms_form_field_data','f_data');
      //       $intent_query->leftjoin('camp_ms_form__field_intent_code','i_code','f_data.id=i_code.entity_id');
      //       $intent_query->leftjoin('camp_ms_form__field_cmp_reference','camp','i_code.entity_id=camp.entity_id');
      //       $intent_query->leftjoin('camp_ms_form__field_campaign_code','cmp_id','camp.field_cmp_reference_target_id=cmp_id.entity_id');
      //       $intent_query->fields('f_data',array('title','id'));
      //       $intent_query->fields('i_code',array('field_intent_code_value'));
      //       $intent_query->condition('f_data.type','intent_master');
      //       $intent_query->condition('cmp_id.field_campaign_code_value',$camp);
      //       $intent_query->condition('i_code.field_intent_code_value',0,'!=');
      //       $intent_query->orderBy('f_data.title','ASC');
      //       $intent_values=$intent_query->execute()->fetchAll();
      //       $field_option[''] = 'Looking For...';
      //       foreach($intent_values as $opt){
      //         $field_option[$opt->field_intent_code_value]=$opt->title;
      //       }

          
      //     $field_items['field']['intent'] =[
      //       'field_id' => 'get_form',
      //       'type' => 'select',
      //       'caption' =>'Intent',
      //       'options' => $field_option,
      //     ];
      //   }
      // }
      $field_option=array();
    }/**end main query foreach loop */
    // die;

    return $field_items;
  }
  public function StepNextFormField($event,$camp,$intent,$screen_level){
    
    $field_items=array();
    $field_values = array();

    $database = \Drupal::database();
    $check_journey = $database->query("SELECT * FROM {camp_ms_form__field_campaign_code} WHERE field_campaign_code_value ='$camp' and bundle = 'camp_code_master' ");
    $result = $check_journey->fetchAll();
    if(!empty($result)){
      $field_query=  db_select('camp_ms_form','ms');
      /**event and camp refrence join with event master and camp master*/
      $field_query->leftjoin('camp_ms_form__field_event','event','ms.id=event.entity_id');
      $field_query->leftjoin('camp_ms_form__field_campaign_reference','cmp_ref','event.entity_id=cmp_ref.entity_id');
      $field_query->leftjoin('camp_ms_form__field_event_code','event_code','event.field_event_target_id=event_code.entity_id');
      $field_query->leftjoin('camp_ms_form__field_campaign_code','campaign_code','cmp_ref.field_campaign_reference_target_id=campaign_code.entity_id');

        /**intent code and intent refrence */
     // $field_query->leftjoin('camp_ms_form__field_intent','intent','event.entity_id=intent.entity_id');
     // $field_query->leftjoin('camp_ms_form__field_intent_code','intent_master','intent.field_intent_target_id=intent_master.entity_id');

      /**screen refrence load entity with target id*/
      $field_query->leftjoin('camp_ms_form__field_screen_number','screen','event.entity_id=screen.entity_id');
      $field_query->leftjoin('camp_ms_form__field_screen_level','screen_level','screen_level.entity_id=screen.field_screen_number_target_id');
      
      /**profile journey field */
      $field_query->leftjoin('camp_ms_form__field_caption_text','caption_text','event.entity_id=caption_text.entity_id');
      $field_query->leftjoin('camp_ms_form__field__seq_number','fld_seq','event.entity_id=fld_seq.entity_id');
          
      /**get field form field master */
      $field_query->leftjoin('camp_ms_form__field_form_field_reference','field_ref','event.entity_id=field_ref.entity_id');
      $field_query->leftjoin('camp_ms_form__field_form_item_id','item_id','field_ref.field_form_field_reference_target_id=item_id.entity_id');
      $field_query->leftjoin('camp_ms_form__field_input_type','item_type','item_id.entity_id=item_type.entity_id');
      $field_query->leftjoin('camp_ms_form__field_select_options','s_opt','item_id.entity_id=s_opt.entity_id');
      $field_query->leftjoin('camp_ms_form__field_number_minlength','min','item_id.entity_id=min.entity_id');
      $field_query->leftjoin('camp_ms_form__field_number_maxlength','max','item_id.entity_id=max.entity_id');
      $field_query->leftjoin('camp_ms_form__field_required','req','item_id.entity_id=req.entity_id');


      $field_query->fields('screen',array('field_screen_number_target_id'));
      $field_query->fields('screen_level',array('field_screen_level_value'));
      $field_query->fields('item_id',array('field_form_item_id_value'));
      $field_query->fields('item_type',array('field_input_type_value'));
      $field_query->fields('min',array('field_number_minlength_value'));
      $field_query->fields('max',array('field_number_maxlength_value'));
      $field_query->fields('s_opt',array('field_select_options_target_id'));
      $field_query->fields('caption_text',array('field_caption_text_value'));
      $field_query->fields('req',array('field_required_value'));

      $field_query->condition('event_code.field_event_code_value',$event);
      $field_query->condition('campaign_code.field_campaign_code_value',$camp);
     // $field_query->condition('intent_master.field_intent_code_value',$intent);
      $field_query->condition('screen_level.field_screen_level_value',$screen_level);

      $field_query->orderBy('fld_seq.field__seq_number_value','ASC');
      $field_values=$field_query->execute()->fetchAll();
    }
    if(count($field_values) == 0 || count($field_values) < 1 ){
      $field_values = DefaultEventData::GetDefaultFieldQuery($event,'NIITCOM',$intent,$screen_level);
    }
    $sid ='sid';
    foreach($field_values as $key => $data){
      if($sid =='sid'){
        $field_items['screen']['id'] =$data->field_screen_number_target_id;
      }
      $sid='';
      if($data->field_input_type_value == 'select' || $data->field_input_type_value == 'checkboxes' || $data->field_input_type_value == 'radios' || $data->field_input_type_value == 'tab_radio'){
        
          /**
           * Get option value from field collection
           * 
           * @get field collection entity id */
          
          /***
           * 
           * 
           * 
           * 
           * 
           */
        
          
          $field_option=array();
          $fc_ids=array();
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
                // if($data->field_form_item_id_value == 'prfrd_cntr'){
                //   $field_option[$opt->field_option_index_value]=$opt->field_opt_label_value;
                // }else{
                  $field_option[$opt->field_opt_label_value]=$opt->field_opt_label_value;
               // }
              }
            }

          /**
           * 
           * 
           * 
           * 
           * 
           */
          
        
        
        $field_items['field'][$key] =[
          'field_id' => $data->field_form_item_id_value,
          'type' => $data->field_input_type_value,
          'caption' =>$data->field_caption_text_value,
          'options' => $field_option,
          'require' => $data->field_required_value,
        ];  
      }
      else if($data->field_input_type_value == 'google_place'){
        $field_items['field'][$key] =[
          'field_id' => $data->field_form_item_id_value,
          'type' => 'google_place',
          'caption' =>$data->field_caption_text_value,
          'require' => $data->field_required_value,
        ];
      } 
      else if($data->field_input_type_value == 'textfield' ){
        $field_items['field'][$key] =[
          'field_id' => $data->field_form_item_id_value,
          'type' => $data->field_input_type_value,
          'caption' =>$data->field_caption_text_value,
          'require' => $data->field_required_value,
        ];
      }
      else if($data->field_input_type_value == 'number'  || $data->field_input_type_value == 'marks_percentage'){
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
          'caption' =>$data->field_caption_text_value,
          'minlength' => $minlength,
          'maxlength' => $maxlength,
          'require' => $data->field_required_value,
        ];
      }else if($data->field_input_type_value == 'date'){
        $field_items['field'][$key] =[
          'field_id' => $data->field_form_item_id_value,
          'type' => $data->field_input_type_value,
          'caption' =>$data->field_caption_text_value,
          'require' => $data->field_required_value,
        ];
      }
    }/**end main query foreach loop */
    return $field_items;
  }
}
