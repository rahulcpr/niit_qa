<?php

  namespace Drupal\niit_multistep_form;

    use Drupal\node\Entity\Node;
    use Drupal\taxonomy\Entity\Term;
    use Drupal\views\Plugin\views\query\QueryPluginBase;
    use Drupal\Core\Url;
    use Drupal\user\Entity\User;
    

 
/**
 * extend Drupal's Twig_Extension class
 */
class FormTwigExtension extends \Twig_Extension {

  /**
   * {@inheritdoc}
   * Let Drupal know the name of your extension
   * must be unique name, string
   */
  public function getName() {
    return 'FormTwigExtension_block';
  }


  /**
   * {@inheritdoc}
   * Return your custom twig function to Drupal
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('generate_multistep_form', [$this, 'generate_multistep_form'], ['is_safe' => ['html']]),
      new \Twig_SimpleFunction('getCourseFeeAndBatchDetails', [$this, 'getCourseFeeAndBatchDetails'], ['is_safe' => ['html']]),
    ];
  }



  /**
   * Returns $_GET query parameter
   *
   * @param string $name
   *   name of the query parameter
   *
   * @return string
   *   value of the query parameter name
   */

  public function generate_multistep_form($nodeData, $step) {
    $getFormService = \Drupal::service('niit_multistep_form.niit_get_form_field');

    $formFields = $getFormService->getMultiStepFormFieldData($nodeData['event'], $nodeData['campaignCode'], 0, $step); 
    
 
    // $formFieldJsonTwo = $getFormService->getMultiStepFormFieldData($nodeData['event'], $nodeData['campaignCode'], 0, 2); 
    // if($step == 1){
      // echo '<pre>';
      // print_r($formFields);
      // echo '</pre>';
    // }
    

    $output = $formFields['field'];
    return !empty( $output ) ? $output : '';
  }
  public function getCourseFeeAndBatchDetails($CourseType, $course_code) {

    $coursedetails = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($CourseType , $course_code);
    // echo '<pre>';
    // print_r($coursedetails['courseBatchDetail'][0]);
    // echo '</pre>';

    $output = $coursedetails['courseBatchDetail'][0];
    return !empty( $output ) ? $output : '';
  }




}