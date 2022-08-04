<?php
namespace Drupal\mymodule\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CounselorForm extends FormBase {
  public function getFormId() {
    // Unique ID of the form.
    return 'counselor_example_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

/*<div class="form-group formgroup">
 <input class="form-control txtbx" name="" type="text" placeholder="Name">$form['name'] = array(
*/

$form['enquiry_name'] = array(
'#type' => 'textfield',
'#size' => 30,
'#placeholder' => t('Name'),
'#attributes' => array('class' => array('form-control txtbx')),
'#prefix' => '<div class="form-group formgroup">',
 '#suffix' => '</div>',
 );



$form['enquiry_phone'] = array(
'#type' => 'textfield',
'#size' => 30,
'#placeholder' => t('Mobile Number'),
'#attributes' => array('class' => array('form-control txtbx')),
 '#prefix' => '<div class="form-group formgroup">',
 '#suffix' => '</div>',

);

$form['enquiry_email'] = array(
'#type' => 'textfield',
'#size' => 30,
'#required' => TRUE,
'#attributes' => array('class' => array('form-control txtbx')),
'#placeholder' => t('Email'),
 '#prefix' => '<div class="form-group formgroup">',
 '#suffix' => '</div>',
);

$form['submit'] = array(
'#type' => 'submit',
'#value' => t('Submit'),
'#attributes' => array('class' => array('btn')),
'#prefix' => '<div class="form-group formgroup">',
'#suffix' => '</div>',

);

return $form;
}




/**
* {@inheritdoc}
*/
public function validateForm(array &$form, FormStateInterface $form_state) {
if ($form_state->getValue('enquiry_name') == '' ) {
$form_state->setErrorByName('enquiry_name', t('Please Enter Your Name'));
}

if ($form_state->getValue('enquiry_phone') == '' ) {
$form_state->setErrorByName('enquiry_phone', t('Please Enter Phone Number'));
}


if (strlen($form_state->getValue('enquiry_phone')) < 10) {
      $form_state->setErrorByName('enquiry_phone', $this->t('The phone number is too short..'));
    }

if ($form_state->getValue('enquiry_email') == '' ) {
$form_state->setErrorByName('enquiry_email', t('Enter a  valid email'));
}


if (!filter_var($form_state->getValue('enquiry_email'), FILTER_VALIDATE_EMAIL)) {
  //$emailErr = "Invalid email format";
  $form_state->setErrorByName('enquiry_email', t('Enter a  valid email'));
}

}

/**
* {@inheritdoc}
*/
public function submitForm(array &$form, FormStateInterface $form_state) {

$name =  $form_state->getValue('enquiry_name');
$phone = $form_state->getValue('enquiry_phone');
$email = $form_state->getValue('enquiry_email');



drupal_set_message($this->t('Your phone number is @number', ['@number' => $form_state->getValue('enquiry_phone')]));
	
	
$message = t('Your information has been successfully submitted.');

drupal_set_message(t('Here is our translated string without any links.'), 'status');
// Message with external link.
drupal_set_message(t('Here is an external link to <a href="http://google.com">Google.</a>'), 'status');

drupal_set_message($message,'status');


$data = array(
'name'=>$name,
'phone'=>$phone,
'email'=> $email,
'State'=> 'test',
'City'=> 'test',
'Center'=> '00201',
'CampaignCode'=> 'NIITCOM'
);
$data_json = json_encode($data);

/*echo "<pre>";
print_r($data_json);
echo "</pre>";
*/


 
//URL: https://ppmqa.niit.com/DrupalAPI/api/Drupal/PostData
 
/*{ 
'Name': 'Vikrant Charan',
'EmailID': 'vikrant.chara@gmail.com',
'PhoneNo': '9865006597',
'State': 'Delhi',
'City': 'Delhi',
'Center': '00201',
'CampaignCode': 'NIITCOM'
*/
 

	$url = 'https://ppmqa.niit.com/DrupalAPI/api/Drupal/PostData';
	//https://indigoconsulting.in/niit/info.php';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response  = curl_exec($ch);
	curl_close($ch);
	
	
	}
	
	
	
	
	
/*	function example_form_validate_required_form_element_validate($element, &$form_state) {
  // Set a custom validation error on the #required element.
  if (!empty($element['#required_is_empty'])) {
    form_error($element, $element['#required_error']);
  }
}*/

}



//views-col col-1

?>