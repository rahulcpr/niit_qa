<?php

namespace Drupal\ms_ajax_form_example\Button;

use Drupal\ms_ajax_form_example\Step\StepsEnum;

/**
 * Class StepOneNextButton.
 *
 * @package Drupal\ms_ajax_form_example\Button
 */
class StepOneNextButton extends BaseButton {

  /**
   * {@inheritdoc}
   */
  public function getKey() {
    return 'next';
  }

  /**
   * {@inheritdoc}
   */
  public function build($eid) {
    $default_caption='NEXT';
    $button_query=  db_select('camp_ms_form__field_submit_button_caption','button');
    $button_query->fields('button',array('field_submit_button_caption_value'));
    $button_query->condition('button.entity_id',$eid);
    $field_values=$button_query->execute()->fetchCol();
    if(!empty($field_values)){
      $default_caption=$field_values[0];
    }
    
    return [
      '#type' => 'submit',
      '#value' => t($default_caption),
      '#goto_step' => StepsEnum::STEP_TWO,
      '#attributes' => ['class' => ['leadLightBoxSubBtn step-one-dis']],
       HASH_PREFIX => '<div class="steps_btn leadLightBox-pl0 embed-popup-btn">',
       HASH_SUFFIX => '</div><div class="col-md-12 text-center whatsapp"><small class="suffix-privacy-policy">By clicking submit, you agree to our <a href="https://privacy.niit.com/prospective_customer.html" target="blank" rel="nofollow">Privacy Policy</a> & overriding DNC/NDNC request for Call/SMS</small></div>',	
    ];
  }

}
