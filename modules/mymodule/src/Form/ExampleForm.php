<?php
namespace Drupal\mymodule\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ExampleForm extends FormBase
{
    public function getFormId()
    {
        // Unique ID of the form.
        return 'api_example_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['name'] = array(
            '#type' => 'textfield',
            '#size' => 30,
            '#required' => TRUE,
            '#placeholder' => t('Name'),
            '#attributes' => array('class' => array('form-control txtbx')),
//'#required_error' => t('Enter the valid email address.'),
//'#element_validate' => array('example_form_validate_required_form_element_validate')
        );


        $form['phone'] = array(
            '#type' => 'textfield',
            '#size' => 30,
            '#required' => TRUE,
            '#placeholder' => t('Mobile Number'),
            '#attributes' => array('class' => array('form-control txtbx')),
//'#required_error' => t('Enter the valid email address.'),
//'#element_validate' => array('example_form_validate_required_form_element_validate')

        );

        $form['email'] = array(
            '#type' => 'textfield',
            '#size' => 30,
            '#required' => TRUE,
            '#placeholder' => t('Email'),
            '#attributes' => array('class' => array('form-control txtbx')),
//'#required_error' => t('Enter the valid email address.'),
//'#element_validate' => array('example_form_validate_required_form_element_validate'),

        );
        $form['checkbox'] = array(
            '#type' => 'checkbox',
            '#size' => 30,
            '#required' => TRUE,
            '#placeholder' => t('privacy term'),
            '#prefix' => "<div class=\"publish_checkbox\"",
            '#suffix' => "</div>",
            '#title' => t('Please tick this box to indicate that you understand that your personal data will be used in accordance with the <a target="_blank" href="https://ppm.niit.com/consent-form/prospective_customer.html" style="color: white;">Privacy Policy</a> here. *'),
//'#required_error' => t('Enter the valid email address.'),
//'#element_validate' => array('example_form_validate_required_form_element_validate'),

        );


        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Submit'),
            '#attributes' => array('class' => array('btn')),
        );

        return $form;
    }


    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        print_r($form_state);
        echo "VALIDATE FORM";
        if ($form_state->getValue('name') == '') {
            $form_state->setErrorByName('name', t('Please Enter Your Name'));
        }

        if ($form_state->getValue('phone') == '') {
            $form_state->setErrorByName('phone', t('Please Enter Phone Number'));
        }


        if (strlen($form_state->getValue('phone')) < 10) {
            $form_state->setErrorByName('phone', $this->t('The phone number is too short..'));
        }

        if ($form_state->getValue('email') == '') {
            $form_state->setErrorByName('email', t('Enter a  valid email'));
        }


        if (!filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL)) {
            //$emailErr = "Invalid email format";
            $form_state->setErrorByName('email', t('Enter a  valid email'));
        }

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $name = $form_state->getValue('name');
        $phone = $form_state->getValue('phone');
        $email = $form_state->getValue('email');


        $data = array(
            'Name' => $name,
            'PhoneNo' => $phone,
            'EmailID' => $email,
            'State' => 'Delhi',
            'City' => 'Delhi',
            'Center' => '00201',
            'CampaignCode' => 'NIITCOM'
        );
        $data_json = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://ppmqa.niit.com/DrupalAPI/api/Drupal/PostDataSchoolEnt",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data_json,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "enabled: true",
                "postman-token: aaf30fc9-1a70-14ae-32e2-e802d635f1cc",
                "token: a4P4M9fF3pIgd4Vso3Iqaa3qDPRTcptquTV6eKODNtcS1bUe4+6QDQ=="
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);


        if ($response) {
            drupal_set_message($this->t('Form Submitted Successfully'), 'status', true);
        } else {
            drupal_set_message($this->t('Error, Please try again later.'), 'status', TRUE);
        }


    }


}


?>
