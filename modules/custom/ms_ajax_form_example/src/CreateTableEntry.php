<?php

namespace Drupal\ms_ajax_form_example;


use Drupal\node\Entity\Node;

class CreateTableEntry {

  public static function CallbackApi($a, &$context){
    $message = 'Create Entry...';
    $results = array();

    $formFieldData = \Drupal::service('niit_multistep_form.niit_get_form_field')->campperstepAllFormFields($a);
    
    if(!empty($formFieldData)){
      $database = \Drupal::database();
      $selectQuery = $database->select('custom_multistep_form_table', 's')
              ->condition('campaign_code', $formFieldData['camp'])
              ->condition('event_name', $formFieldData['event'])
              ->condition('screen_level',  $formFieldData['screen_level'])
              ->condition('intent', $formFieldData['intent'])
              ->fields('s');
      $fieldData = $selectQuery->execute()->fetchAssoc();

      if(!empty($fieldData)){
        $dataArray = [
              'screen_id'         => $formFieldData['screen']['id'],
              'fields_data'       => json_encode($formFieldData),
          ];
          $database = \Drupal::database();
          $query = $database->update('custom_multistep_form_table')->fields($dataArray)
              ->condition('campaign_code', $formFieldData['camp'])
                ->condition('event_name', $formFieldData['event'])
                ->condition('screen_level',  $formFieldData['screen_level'])
                ->condition('intent', $formFieldData['intent'])->execute();

        $results[] = $formFieldData['camp'].' Update Fields';
      }else{
        $dataArray = [
              'campaign_code'     => $formFieldData['camp'],
              'event_name'        => $formFieldData['event'],
              'screen_level'      => $formFieldData['screen_level'],
              'intent'          => $formFieldData['intent'],
              'screen_id'         => $formFieldData['screen']['id'],
              'fields_data'       => json_encode($formFieldData),
          ];
          $database = \Drupal::database();
        $insert_query = $database->insert('custom_multistep_form_table')->fields($dataArray)->execute();
        $results[] = $formFieldData['camp'].' Insert Fields';
      }
    }
    $context['message'] = $message;
    $context['results'] = $results;
  }

  function CreateTableEntryFinishedCallback($success, $results, $operations) {
    // The 'success' parameter means no fatal PHP errors were detected. All
    // other error management should be handled using 'results'.
    if ($success) {
      foreach($results as $val){
          $message = \Drupal::translation()->formatPlural(count($results), $val, '');
      }
    }
    else {
      $message = t('Finished with an error.');
    }
    drupal_set_message($message);
  }
}