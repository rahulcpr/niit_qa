<?php

/**
 * @file
 * Contains Drupal\ms_ajax_form_example\Form\ModuleConfigurationForm.
 */

namespace Drupal\ms_ajax_form_example\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ModuleConfigurationForm.
 *
 * @package Drupal\ms_ajax_form_example\Form
 */
class ModuleConfigurationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ms_ajax_form_example.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'msajax_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ms_ajax_form_example.settings');
    $form['global_setting'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Global Setting'),
    );
    $form['global_setting']['otp_status'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('OTP Enable'),
      '#default_value' => $config->get('otp_status'),
    );
    $form['global_setting']['niit_custom_login'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('NIIT Custom Login'),
      '#default_value' => $config->get('niit_custom_login'),
    );
    $form['global_setting']['CaptureLeadsInCMS'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Capture Leads In CMS'),
      '#default_value' => $config->get('CaptureLeadsInCMS'),
    );
    $form['stackathon_page_setting'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Stackathon Page Setting'),
    );
    $form['stackathon_page_setting']['DisableMobileOTP'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Disable Mobile OTP'),
      '#default_value' => $config->get('DisableMobileOTP'),
    );
    $form['stackathon_page_setting']['EnableEmailOTP'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Email OTP'),
      '#default_value' => $config->get('EnableEmailOTP'),
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('ms_ajax_form_example.settings')
      ->set('otp_status', $form_state->getValue('otp_status'))
      ->set('niit_custom_login', $form_state->getValue('niit_custom_login'))
      ->set('CaptureLeadsInCMS', $form_state->getValue('CaptureLeadsInCMS'))
      ->set('DisableMobileOTP', $form_state->getValue('DisableMobileOTP'))
      ->set('EnableEmailOTP', $form_state->getValue('EnableEmailOTP'))
      ->save();
  }

}