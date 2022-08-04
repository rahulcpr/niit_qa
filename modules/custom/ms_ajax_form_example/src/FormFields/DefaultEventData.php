<?php

namespace Drupal\ms_ajax_form_example\FormFields;


/**
 * Class StepOne.
 *
 * @package Drupal\ms_ajax_form_example\FormFields
 */
class DefaultEventData{
  
  public function GetDefaultFieldQuery($event,$camp,$intent,$screen_level){
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
        $field_query->leftjoin('camp_ms_form__field_intent','intent','event.entity_id=intent.entity_id');
        $field_query->leftjoin('camp_ms_form__field_intent_code','intent_master','intent.field_intent_target_id=intent_master.entity_id');

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
        $field_query->condition('intent_master.field_intent_code_value',$intent);
        $field_query->condition('screen_level.field_screen_level_value',$screen_level);

        $field_query->orderBy('fld_seq.field__seq_number_value','ASC');
        $field_values=$field_query->execute()->fetchAll();
    }

    return $field_values;
  }
}
