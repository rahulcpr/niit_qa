<?php

namespace Drupal\ms_ajax_form_popup\Button;

use Drupal\ms_ajax_form_popup\Step\StepsEnum;

/**
 * Class StepThreeFinishButton.
 *
 * @package Drupal\ms_ajax_form_popup\Button
 */
class StepThreeFinishButton extends BaseButton {

  /**
   * {@inheritdoc}
   */
  public function getKey() {
    return 'finish';
  }

  /**
   * {@inheritdoc}
   */
  public function build($s_id) {
    // $default_caption='default caption';
    // $button_query=  db_select('camp_ms_form__field_submit_button_caption','button');
    // $button_query->fields('button',array('field_submit_button_caption_value'));
    // $button_query->condition('button.entity_id',$s_id);
    // $field_values=$button_query->execute()->fetchCol();
    // if(!empty($field_values)){
    //   $default_caption=$field_values[0];
    // }
    return [
      '#type' => 'submit',
      '#value' => t('Finish!'),
      '#goto_step' => StepsEnum::STEP_FINALIZE,
      // '#submit_handler' => 'submitValues',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getSubmitHandler() {
    return 'submitIntake';
  }

}
