<?php
/**
 * @file
 * Contains \Drupal\amazing_forms\Form\ContributeForm.
 */

namespace Drupal\sso_user\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Ajax;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AfterCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Ajax\UpdateBuildIdCommand;

/**
 * Contribute form.
 */
class AjaxForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  
  protected $country_code;

  public function getFormId() {

	  return 'sso_user_AjaxForm_form';	
  }
  public function __construct() {
    $this->country_code = 0;
   
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form['sso-container'] = [
        HASH_TYPE => 'container',
        '#attributes' => [
        'id' => 'main-container',
        ],
    ];    
    $form['sso-container']['country'] = array(
        HASH_TYPE => 'select',
        HASH_OPTIONS => array(91 => 'INDIA', 01 => 'USA',33 => 'XYZ'),
        HASH_PREFIX=>'<p></p><p></p>',
        HASH_SUFFIX=>'',
        '#ajax' => array(
            'callback' => [$this,'SetOptionCallback'],
            'wrapper' => 'sso-container',
            'event' => 'change',
            'effect' => 'fade',
            ), 
            
      );
      if($form_state->isRebuilding()){
        $this->country_code=$form_state->getValue('country');
      }
      $form['sso-code'] = [
        HASH_TYPE => 'container',
        '#attributes' => [
        'id' => 'sso-container',
        ],
    ];
        $form['sso-code']['countrycode'] = array(
            HASH_TYPE => TEXTFIELD,
            // HASH_REQUIRED => TRUE,
            '#value' => $this->country_code,
            '#attributes' => array('readonly' => 'readonly'),
            HASH_PLACEHOLDER => t('Country Code'),
            HASH_PREFIX=>'<p></p><p></p>',
            HASH_SUFFIX=>'',
        );
       
    
        $form['sso-submit'] = [
            HASH_TYPE => 'container',
            '#attributes' => [
            'id' => 'sso-submit',
            ],
        ];
    $form['sso-submit']['submit'] = array(
        HASH_TYPE => 'submit',
        HASH_VALUE => t('Register'),
        HASH_PREFIX => '<div class = "submit-query-form-button"><div class ="">',
        HASH_SUFFIX=>'</div></div>',
        '#attributes' => array('class' => array('subscription-submit')),
        '#ajax' => array(
            'callback' => [$this,'SubmitAjaxCallBack'],
            'event' => 'click',
            'wrapper' => 'main-container',
            'progress' => array(
                'type' => 'throbber',
                'message' => 'Please Wait...',
            ),
        ), 
    );
           return $form;
}
public function SetOptionCallback(array &$form, FormStateInterface $form_state,$form_id){
    
    
    // $form_state->setRebuild(TRUE);
    return $form['sso-code'];
    
    
  }
   /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
	  
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // $this->country_code= 12;
    // $form['sso-container']['countrycode']['#value']=22;
    // $form_state->setRebuild(TRUE);
  }
  public function _CountryCode(){
      $options=array(91 => 'INDIA', 01 => 'USA');
      return $options;
  }
 
  public function SubmitAjaxCallBack(array &$form, FormStateInterface $form_state,$form_id) {

    // $this->country_code= 12;
    // $form_state->setRebuild(TRUE);
    $ajax_response = new AjaxResponse();
    
    $ajax_response->addCommand(new HtmlCommand('#sso-user-ajaxform-form','Your Password updated'));
    return $ajax_response;
        
    }
}
?>
