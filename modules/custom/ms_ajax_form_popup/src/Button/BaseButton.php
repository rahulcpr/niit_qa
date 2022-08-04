<?php

namespace Drupal\ms_ajax_form_popup\Button;

/**
 * Class BaseButton.
 *
 * @package Drupal\ms_ajax_form_popup\Button
 */
abstract class BaseButton implements ButtonInterface {

  /**
   * {@inheritdoc}
   */
  public function ajaxify() {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getSubmitHandler() {
    return FALSE;
  }

}
