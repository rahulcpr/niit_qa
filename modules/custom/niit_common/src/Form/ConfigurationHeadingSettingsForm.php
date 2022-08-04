<?php

namespace Drupal\niit_common\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Configuration Heading settings for this site.
 */
class ConfigurationHeadingSettingsForm extends ConfigFormBase {
    /** @var string Config settings */
  const SETTINGS = 'niit_common.settings';

  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'niit_common_admin_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['related_blog'] = [
      '#type' => 'textfield',
      '#title' => $this->t('RELATED BLOGS'),
      '#default_value' => $config->get('related_blog'),
    ];  

    $form['suggested_programms'] = [
      '#type' => 'textfield',
      '#title' => $this->t('SUGGESTED PROGRAMMS'),
      '#default_value' => $config->get('suggested_programms'),
    ];  

    $form['placement_heading_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placement Heading Title'),
      '#default_value' => $config->get('placement_heading_title'),
    ];  

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
      // Retrieve the configuration
       $this->configFactory->getEditable(static::SETTINGS)
      // Set the submitted configuration setting
      ->set('related_blog', $form_state->getValue('related_blog'))
      // You can set multiple configurations at once by making
      // multiple calls to set()
      ->set('suggested_programms', $form_state->getValue('suggested_programms'))
      ->set('placement_heading_title', $form_state->getValue('placement_heading_title'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}