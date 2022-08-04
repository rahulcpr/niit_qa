<?php

namespace Drupal\ms_ajax_form_popup\Button;

use Drupal\ms_ajax_form_popup\Step\StepsEnum;

/**
 * Class StepThreePreviousButton.
 *
 * @package Drupal\ms_ajax_form_popup\Button
 */
class StepThreePreviousButton extends BaseButton {

  /**
   * {@inheritdoc}
   */
  public function getKey() {
    return 'previous';
  }

  /**
   * {@inheritdoc}
   */
  public function build($s_id) {

    // return [
    //   '#type' => 'submit',
    //   '#value' => t('Previous'),
    //   '#goto_step' => $_SESSION["last_step"],
    //   '#skip_validation' => TRUE,
    // ];

     if($_SESSION['prev_three_display'] == 1){
      return [
        '#type' => 'submit',
        '#value' => t('Previous'),
        '#goto_step' => StepsEnum::STEP_TWO,
        //'#goto_step' => $_SESSION["last_step"],
        '#attributes' => ['class' => ['edit_btn_ms']],
        '#skip_validation' => TRUE,
      ];
    }
  }

}
