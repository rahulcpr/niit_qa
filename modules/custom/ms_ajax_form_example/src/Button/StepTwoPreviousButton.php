<?php

namespace Drupal\ms_ajax_form_example\Button;

use Drupal\ms_ajax_form_example\Step\StepsEnum;

/**
 * Class StepTwoPreviousButton.
 *
 * @package Drupal\ms_ajax_form_example\Button
 */
class StepTwoPreviousButton extends BaseButton {

  /**
   * {@inheritdoc}
   */
  public function getKey() {
    return 'previous';
  }

  /**
   * {@inheritdoc}
   */
  public function build($eid) {
    return [
      '#type' => 'submit',
      '#value' => t('Previous'),
      '#goto_step' => $_SESSION["last_step"],
      '#skip_validation' => TRUE,
    ];
  }

}
