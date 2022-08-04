<?php

namespace Drupal\ms_ajax_form_popup\Validator;

/**
 * Class ValidatorRequired.
 *
 * @package Drupal\ms_ajax_form_popup\Validator
 */
class ValidatorRequired extends BaseValidator {

  /**
   * {@inheritdoc}
   */
  public function validates($value) {
    return is_array($value) ? !empty(array_filter($value)) : !empty($value);
  }

}
