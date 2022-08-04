<?php

namespace Drupal\ms_ajax_form_popup\Step;

use Drupal\ms_ajax_form_popup\Button\StepThreeFinishButton;
use Drupal\ms_ajax_form_popup\Button\StepThreePreviousButton;
use Drupal\ms_ajax_form_popup\Validator\ValidatorRegex;
use Drupal\ms_ajax_form_popup\Validator\ValidatorRequired;


/**
 * Class StepThree.
 *
 * @package Drupal\ms_ajax_form_popup\Step
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
  /**
   * @import form left side image
   */
 
  /**
   * {@inheritdoc}
   */
  public function buildStepFormElements($event) {
    
    // $form['linkedin'] = [
    //   '#type' => 'textfield',
    //   '#title' => t('What is your LinkedIn URL?'),
    //   '#default_value' => isset($this->getValues()['linkedin']) ? $this->getValues()['linkedin'] : NULL,
    //   '#required' => FALSE,
    // ];
    if(isset($_SESSION["get_form"])){
      $form['api_value'] = [
        HASH_TYPE => TEXTFIELD,
        HASH_TITLE => t('API Value'),
        HASH_DEFAULT_VALUE => (isset($_SESSION["get_form"])) ? $_SESSION["get_form"]:'',
        HASH_ATTRIBUTES => array('readonly' => 'readonly')
      ];
    }
    $form['field_wrapper'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'form-field-wrapper',
      ],
    ];
    $form['field_wrapper'] += $this->DefaultFields();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldNames() {
    return [
      'linkedin',
      'api_value'
    ];
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
