<?php

namespace Drupal\ms_ajax_form_popup\Validator;

/**
 * Interface ValidatorInterface.
 *
 * @package Drupal\ms_ajax_form_popup\Validator
 */
interface ValidatorInterface {

  /**
   * Returns bool indicating if validation is ok.
   */
  public function validates($value);

  /**
   * Returns error message.
   */
  public function getErrorMessage();

}
