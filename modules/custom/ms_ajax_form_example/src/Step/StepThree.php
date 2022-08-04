<?php
namespace Drupal\ms_ajax_form_example\Step;

use Drupal\ms_ajax_form_example\Button\StepThreeFinishButton;
use Drupal\ms_ajax_form_example\Button\StepThreePreviousButton;
use Drupal\ms_ajax_form_example\Validator\ValidatorRegex;
use Drupal\ms_ajax_form_example\Validator\ValidatorRequired;
use Drupal\ms_ajax_form_example\FormFields;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class StepThree.
 *
 * @package Drupal\ms_ajax_form_example\Step
 */
class StepThree extends BaseStep {

  /**
   * {@inheritdoc}
   */
  protected function setStep() {
    return StepsEnum::STEP_THREE;
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
      // new StepThreePreviousButton(),
      new StepThreeFinishButton(),
    ];
  }
    
  public function GetStepMessage($screen_id){
    $html='default msg';
    if($screen_id != ''){
        $field_query=  db_select('camp_ms_form__field_submission_message','msg');
        $field_query->fields('msg',array('field_submission_message_value'));
        $field_query->condition('msg.entity_id',$screen_id);
        $field_values=$field_query->execute()->fetchCol();
        $html='<h4>Hey '.$_SESSION['step_message'].'</h4>';
        $html.='<h4>'.$field_values[0].'</h4>';
        session_unset(step_message);
    }
    return $html;
  }  
  /**
   * {@inheritdoc}
   */
  public function buildStepFormElements($form_name) {
    $intent=0;
    $event='Get_In_TCH';
    $camp='NIITCOM';
    $course_code='NIITCOM';

    $node = \Drupal::routeMatch()->getParameter('node');
    
    
    if ($node instanceof \Drupal\node\NodeInterface) {
      // You can get nid and anything else you need from the node object.
      // $nid = $node->id();
      if($node->hasField('field_course_code')){
        $course_code=$node->get('field_course_code')->getValue()[0]['value'];
      }
      if($node->hasField('field_campaign_code')){
        $camp=$node->get('field_campaign_code')->getValue()[0]['value'];
      }
    }
    if(isset($_SESSION["get_form"])){
      $intent=$_SESSION["get_form"];
    }
    $form_field_item =array();
    
    $form_field_item_data= GetFormFields::StepNextFormField($event,$camp,$intent);

    // echo '<pre>call';print_r($form_field_item_data['screen']['id']); die;
    if(isset($_SESSION['screen_id'])){
 
      $form_field_item['completed'] = [
        '#markup' => '',
        HASH_PREFIX =>$this->GetStepMessage($_SESSION['screen_id']),
      ];
    }
    $field_name=array();
    foreach($form_field_item_data['field'] as $value){
      $require=false;
      $field_name[$value['field_id']]=$value['field_id'];
      if($value['require'] ==1 ){$require = TRUE;}
      if($value['type'] == 'textfield' && $value['field_id'] == 'enqry_crsspndnc_mbl'){
        $form[$value['field_id']] = [
          HASH_TYPE => TEXTFIELD,
          HASH_REQUIRED => TRUE,
          // HASH_TITLE => t($value['caption']),
          '#maxlength' => 10,
          HASH_PLACEHOLDER => t($value['caption']),
          '#attributes' => ['class' => ['form-control']],
          HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          // HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
        ];
      }if($value['type'] == 'textfield' && $value['field_id'] != 'enqry_crsspndnc_mbl'){
        $form[$value['field_id']] = [
          HASH_TYPE => TEXTFIELD,
          HASH_REQUIRED => TRUE,
          // HASH_TITLE => t($value['caption']),
          HASH_PLACEHOLDER => t($value['caption']),
          '#attributes' => ['class' => ['form-control']],
          HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          // HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
        ];
      }
      else if($value['type'] == 'select'){
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => $value['type'],
          HASH_REQUIRED => $require,
          // HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control']],
          '#empty_value' => t($value['caption']),
          HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          // HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
        ];
      }else if($value['type'] == 'radios'){
        $form[$value['field_id']] = [
          HASH_TYPE => $value['type'],
          HASH_REQUIRED => $require,
          HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control']],
          HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
        ];
      }else if($value['type'] == 'checkboxes'){
        $form[$value['field_id']] = [
          HASH_TYPE => 'checkboxes',
          HASH_REQUIRED => $require,
          // HASH_TITLE => t($value['caption']),
          HASH_OPTIONS => $value['options'],
          '#attributes' => ['class' => ['form-control']],
          HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
        ];
      }else if($value['type'] == 'date'){
        $form_field_item[$value['field_id']] = [
          HASH_TYPE => DATEFIELD,
          HASH_REQUIRED => $require,
          // HASH_TITLE => t($value['caption']),
          HASH_PLACEHOLDER => t($value['caption']),
          '#attributes' => ['class' => ['form-control']],
          HASH_PREFIX => '<div class="col-md-12 leadLightBox-pl0">',
          HASH_SUFFIX => '</div>',
          // HASH_DEFAULT_VALUE => isset($this->getValues()[$value['field_id']]) ? $this->getValues()[$value['field_id']] : NULL,
        ];
      }
    
  }
  $this->StepTwokey=$field_name;
    $return_value['f_field']=$form_field_item;
    // $return_value['message']=$this->GetStepMessage($form_field_item_data['screen']['id']);
    $return_value['screen_id']=$form_field_item_data['screen']['id'];
    $return_value['header_msg']='<h5><b>Please fill this fields</b></h5><hr>';
    return $return_value;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldNames() {
    return $field_name;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldsValidators() {
    return [
      'linkedin' => [
        // new ValidatorRequired("Tell me where I can find your LinkedIn please."),
        // new ValidatorRegex(t("I don't think this is a valid LinkedIn URL..."), '/(ftp|http|https):\/\/(.*)linkedin(.*)/'),
      ],
    ];
  }

}
