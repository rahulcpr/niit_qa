<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\user\Entity\User;
use Drupal\Core\Ajax;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Ajax\UpdateBuildIdCommand;
use Drupal\Core\Ajax\AfterCommand;
use Drupal\Core\Ajax\RemoveCommand;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use Drupal\Core\Ajax\AddCssCommand;
use Drupal\node\Entity\Node;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Path\AliasManager;


class homepageleadformfirststepclass extends ControllerBase {  
  
    public function homepageleadformfnctnfirst() {
    $requestField = \Drupal::request()->request;
    $data = $requestField->get('results');
    $formData = (array) json_decode($data);
    //print_r($formData[0]);
    //$checkFormValid = 1;

    if(empty($formData[0])){
           /* $ajax_response->addCommand(new HtmlCommand('.ErrorClassmobile','Field can not be empty'));
            $ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));*/
            $formData[0] = '';
            //print_r('err1');
        }
    if(!preg_match('/^[6-9][0-9]{9}$/', $formData[0])){
            /*$ajax_response->addCommand(new HtmlCommand('.ErrorClassmobile','Enter Correct Mobile No.'));
            $ajax_response->addCommand(new InvokeCommand('#edit-user-email-new', 'addClass',['error']));*/
            $formData[0] = '';
             //print_r('err2');
          }
     
   
        $return = ['data' => $formData[0]];
        return new JsonResponse($return);
    
  }
  public function homepageleadformfnctnsecond() {
    $requestField = \Drupal::request()->request;
    $data = $requestField->get('results');
    $data1 = $requestField->get('results1');
    $data2 = $requestField->get('results2');
    $formData = (array) json_decode($data);
    $formData1 = (array) json_decode($data1);
    $formData2 = (array) json_decode($data2);
    //print_r($formData2[0]);
    //$checkFormValid = 1;

    if(empty($formData[0])){

            $formData[0] = '';
        }
    if(!preg_match('/^[a-zA-Z ]{3,30}$/', $formData[0])){
            
            $formData[0] = '';
        }

    if(empty($formData1[0])){

            $formData[0] = '';
        }
    if(!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $formData1[0])){
            
            $formData1[0] = '';
        } 

    $current_user = \Drupal::currentUser()->id();
    $check_useremail = check_useremail($formData1[0]);
    //print_r($check_useremail);
      if($check_useremail == 1){
        $msg = 'already registered';
        $formData1[0] = '';
      }

    /*$stepdata= array("enqry_f_nm"=>$formData[0], "enqry_crsspndnc_eml"=>$formData1[0], "enqry_crsspndnc_mbl"=>$formData2[0]); 

    $current_id = '';
      $CUSTOMER_ID = '';
      $newaccount = '';
    if (\Drupal::currentUser()->isAnonymous()) {
        $create_account = automatic_registration_hp($stepdata);
        if(!empty($create_account)){
           $CUSTOMER_ID = $create_account['CUSTOMER_ID'];
           $newaccount = $create_account['newaccount'];
        }
    }
    else{
      $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
      $CUSTOMER_ID = $user->get('field_customer_id')->value;
      $newaccount = 'true';
      //print_r($CUSTOMER_ID);
    }*/      


    //print_r($current_user);

    /*$check_useremail = check_useremail($formData1);
    print_r($check_useremail);
      if($check_useremail == 1){
        $formData1[0] = '';
      }*/       
     
   
        $return = ['data' => $formData[0], 'data1' => $formData1[0], 'msg' => $msg];
        return new JsonResponse($return);
    
  }


  public function homepageleadformfnctnthird() {
    $requestField = \Drupal::request()->request;
    $data = $requestField->get('results');
    $data1 = $requestField->get('results1');
    $data2 = $requestField->get('results2');
    $data4 = $requestField->get('results4');
    $data5 = $requestField->get('results5');
    $formData = (array) json_decode($data);
    $formData1 = (array) json_decode($data1);
    $formData2 = (array) json_decode($data2);
    $formData4 = (array) json_decode($data4);
    $formData5 = (array) json_decode($data5);
    $CountryCode = '91';
    $CountryName = 'India';
    //print_r($formData1[0]);
    //$checkFormValid = 1;

    $separateval = explode("&&",$formData[0]);
    $nid = $separateval[2];
    $course_code = $separateval[0];
    $prfrd_cntr = $separateval[1];
    //print_r($nid);

    $userload = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    if(empty($formData1[0])){
        $formData1[0] = $userload->get('field_user_name')->value;
    }

    if(empty($formData2[0])){
       if(!empty($userload->get('field_communication_emailid')->value)){
        $formData2[0] = $userload->get('field_communication_emailid')->value;
      }
      else{
        $formData2[0] = $userload->get('mail')->value;
      }
    }

    if(empty($formData4[0])){
        $formData4[0] = $userload->get('field_mobile_number')->value;
    }

   
    //if (!empty($nid)) {
    $stepdata= array("enqry_f_nm"=>$formData1[0], "enqry_crsspndnc_eml"=>$formData2[0], "enqry_crsspndnc_mbl"=>$formData4[0]); 

    $current_id = '';
      $CUSTOMER_ID = '';
      $newaccount = '';
    if (\Drupal::currentUser()->isAnonymous()) {
        $create_account = automatic_registration_hp($stepdata);
        if(!empty($create_account)){
           $CUSTOMER_ID = $create_account['CUSTOMER_ID'];
           $newaccount = $create_account['newaccount'];
        }
        /*print_r($create_account);
        print_r('Hello');*/
    }
    else{
      $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
      $CUSTOMER_ID = $user->get('field_customer_id')->value;
      $newaccount = 'true';
      //print_r($CUSTOMER_ID);
    }



    
    $alias1 = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$nid);
    $alias = '/india'.$alias1;
    
    if(!empty($nid)){
    $node =\Drupal\node\Entity\Node::load($nid);
    //print_r($node_data);
    $itemli0 = $node->field_min_ctc->value;
    $itemli1 = $node->field_course_modules->value;
    $itemli2 = $node->field_enroll_no->value;
    $itemli4 = $node->field_alumni_name->value;
    $course_name = $node->title->value;
    } 
    $campaign_code = 'NIITCOM';
    $current_user = \Drupal::currentUser()->id();
    
    //print_r($formData[0]); print_r($course_name);
    //}

    $extra_data = [
             'source' => $campaign_code,
             'applicationid' => '',
             'CustomerId' => $CUSTOMER_ID,
             'RequestedURL'=> '',
             'NewSignup' => $newaccount,
             'orgid' => 1
           ];



    $request_time = \Drupal::time()->getCurrentTime();
          $formdata = array(
            'uid' => $formData4[0].'_'.$request_time,
            'enqry_f_nm' => $formData1[0],
            'enqry_crsspndnc_eml' => $formData2[0],
            'time' => $request_time,
          );
      //print_r($formdata); die('Hello');    
    
      $GDPR_Id = multistep_user_consentapi($formdata);
      //print_r($GDPR_Id); die("Yiiii");
      /**GDPR API callback function  end*/
      $values['GDPR_CONSENTID'] = $GDPR_Id;
      $values['enqry_f_nm'] = $formData1[0];
      $values['enqry_crsspndnc_eml'] = $formData2[0];
      $values['enqry_crsspndnc_mbl'] = $formData4[0];
      //$values['utm_source'] = 'Homepage';
      //$values['utm_medium'] = 'Banner';
      $values['intrstd_prgrm'] = $course_code;
      $values['prfrd_cntr'] = $prfrd_cntr; 
      //print_r($values); die('Hello');
      $API2 = array(
            'leaduniqueid' => $formData4[0].'_'.$request_time,
            'GDPR_CONSENTID' => $GDPR_Id,
            'source' => $campaign_code,
            //'intrstd_prgrm' => $course_code,
            'leadformstg' => 'HomePage',
            //'enqry_Crrspndnc_PhnStdCd' => $CountryCode,
            //'enqry_prmnnt_cntry' => $CountryName,
            //'enqry_Prmnnt_PhnStdCd' => $CountryCode,
          );

      $processed = FALSE;
        $ERROR_MESSAGE = '';
        $email = $formData2[0];
        $referenId = $formdata['uid'];
        $mobile_number = $formData4[0];
        //$coursecode = $form_state->getValue('intrstd_prgrm');
        $whatsapp = $formData5[0];
        if($whatsapp == 1){$whatsapp ='IN';}
        else if($whatsapp == 0){$whatsapp ='OUT';}

        if($whatsapp == 'IN' || $whatsapp == 'OUT'){

        $headers = array(
              "content-type: application/json"
            );
        $data_array = array(
            "EmailID"=> $email,
            "CustomerId"=>"",
            "MobileNo"=>$mobile_number,
            "ReferenceId"=>$referenId,
            "URL"=>$_SERVER['HTTP_REFERER'],
            //"URL"=>$current_path,
            "Coursecode"=>$course_code,
            "OrgId"=>"1",
            "ClientIP"=>$_SERVER['SERVER_ADDR'],
            "ServerIP"=>$_SERVER['SERVER_ADDR'],
            "UniqueID"=>$referenId,
            "Opt_In_Out"=>$whatsapp,
            "Source"=>"NIITCOM",    
            "Type"=>"SUBMIT"
        );
        //print_r($data_array); die('Hello');
    // ************* Call WhatsApp API:
    $data_json = json_encode($data_array);
    
    //$url = $_ENV['WhatsAppAPIURL'];
    $url = 'https://ccdev.niiteducation.com/CRMCallcenterAPI/api/CallCenter/SaveWhatsAppOptinData';
    //print_r($data_json);die;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);// set post data to true
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $data_response = json_decode($response);
    
    curl_close($ch);
    $result[] = '';
    if($data_response->ErrorYN == 'N'){
       $result[] = $data_response->Message;
        }   
        
        
    }
    //print_r($formData5[0]); die('Hello');
          $data = array_merge($API2, $values,$result);
          //print_r($data); die("Helllooooo");  
          multistep_postapidate('I', $data);

    if(empty($separateval[0])){

            $separateval[0] = '';
        }
   
     
   
        $return = ['data' => $separateval[0], 'coursename' => $course_name, 'item0' => $itemli0, 'item1' => $itemli1, 'item2' => $itemli2, 'path' => $alias, 'name' => $formData1[0]] ;
        return new JsonResponse($return);
    
  }
  


}  