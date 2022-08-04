<?php
/**
 * @file
 * Contains \Drupal\article\Plugin\Block\XaiBlock.
 */
namespace Drupal\ms_ajax_form_example\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides my custom block.
 *
 * @Block(
 *   id = "MultistepFrom Block",
 *   admin_label = @Translation("MultistepFrom Block"),
 *   category = @Translation("Blocks")
 * )
 */


class MultistepFromBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    
      
    $output='';
    $block_form = \Drupal::formBuilder()->getForm('\Drupal\ms_ajax_form_example\Form\MultiStepExampleForm');
    $output.='<div class="block-from-container">';
        $output.=render($block_form);
    $output.='</div>';
      
    return array(
        '#markup' => $output,

    );
    
  }
  
}
