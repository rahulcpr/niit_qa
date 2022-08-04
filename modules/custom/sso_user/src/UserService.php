<?php
namespace Drupal\sso_user;
use Drupal\Core\Session\AccountProxy;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Get current user 
 */
class UserService{
    private $currentUser;

    public function __construct(AccountProxy $currentUser){
        $this->currentUser=$currentUser;
    }

    /**
     * user login api
     */
    public function userLoginAPI($data){
       // $url = "https://qa.training.com/DigitalAPI/api/signIn/user/";
        $url = $_ENV['NIITDigitalPlatformAPI_USERLOGIN'];
        $data = json_encode($data);
        $headers = array(
            "content-type: application/json"
        );
        $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          $response = curl_exec($ch);
          curl_close($ch);
         //  echo '<pre>'; print_r($response); print_r($data); die();
          return $response;
      }

      /**
       * user login OTP Send api
       */
      public function AjaxCallBackLoginOTPsendAPI($data){
        $headers = array(
            "content-type: application/json"
        );
       // $url = 'https://qa.training.com/NIITDigitalPlatformAPI/api/GenerateOTP';
        $url = $_ENV['NIITDigitalPlatformAPI_GenerateOTP'];
        $email = $data['EMAILID'];
        $data_array = array(
          "StudentCode" => $email,
          "OldValue" => "0000000000",
          "NewValue" => "0000000000",
          "Type" => "emailotp",
          "OrgId" => "1",
          "serverip" => $_SERVER['SERVER_ADDR'],
          "clientip" => $_SERVER['REMOTE_ADDR'],
        );
        $data_json = json_encode($data_array);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        //echo '<pre>'; print_r($data_array); print_r($response);  die();
        return $response;
      }

      /**
       * Send OTP SMS api
       */
      public function SendOTPSMSAPI($data, $text){
        $headers = array(
            "content-type: application/json"
        );
      //  $url = 'http://qa.training.com/DigitalApi/api/signIN/SendOTPSMS';
        $url = $_ENV['DigitalApi_SendOTPSMS'];
        
        //$msg = $data->OTP.$text;
        $msg = 'Your One Time Password (OTP) is '.$data->OTP.' - NIIT'; 
        $transactionId = rand(0000000000,9999999999999999);
        $data_array = array(
          "appId" => '63',
          "transactionId" => $transactionId,
          "mobileNo" => $data->MobileNo,
          "messageText" => $msg,
        );
        $data_json = json_encode($data_array);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
         // echo '<pre>'; print_r($data_array); print_r($response);  die();
        return $response;
      }



      /**
       * user login with OTP api
       */
      public function AjaxCallBackLoginwithotpAPI($data){
        $otp = $data['OTP'];
        $email = $data['EMAILID'];
        $customerId = $data['customerId'];
        $headers = array(
            "content-type: application/json"
        );
        //$url = 'https://qa.training.com/NIITDigitalPlatformAPI/api/ProcessUserProfileUpdationRequest';
        $url = $_ENV['NIITDigitalPlatformAPI_USERLOGIN'];
        $data_array = array(
          "EMAILID" => $email,
          "PASSWORD" => "",
          "OTPValue" => $otp
        );
        $data_json = json_encode($data_array);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        //echo '<pre>'; print_r($data_array); print_r($response);  die();
        return $response;
      }
      /**
     * user logout api
     */
    public function userLogoutAPI($uid){

        $data=array();
        $data["VCRememberMeCode"]=$uid;
        $data["OpType"]='SIGNOUT';
        $data["HandlerRequest"]='SignOut';
        $data = json_encode($data);
        $headers = array(
            "content-type: application/json"
        );

      //  $url = 'http://qa.training.com/Handlers/User/UserManagement.ashx';
        $url = $_ENV['UserManagement_Logout'];
        $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          $response = curl_exec($ch);
          curl_close($ch);
          return $response;
      }
      /**
       * user register api
       */
      public function UserRegisterAPI($form_data){

        // $signup_url = "https://qa.training.com/DigitalAPI/api/signUp/user/";
        $signup_url = $_ENV['Digital_API_SIGNUP'];
        
        $poset_field_data=json_encode($form_data);
        $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL,$signup_url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $poset_field_data );
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array("content-type: application/json"));
          $response = curl_exec($ch);
          curl_close($ch);
        //  echo '<pre>'; print_r($response); die();
          return $response;
      }
      /**
       * user Forgot password API
       */
      public function forgotPasswordAPI($form_data){

        // $url = "https://qa.training.com/DigitalAPI/api/InsertUserActivationDetails";
        $url = $_ENV['DigitalAPI_forgotPassword'];
        
          $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("content-type: application/json"));
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
      }
      /**
       * get country code values
       */
      public function getCountryAPI(){
       //   $url = 'https://qa.training.com/DigitalAPI/api/signup/getcountrycode';
          $url = $_ENV['DigitalAPI_getcountrycode'];
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL,$url);
          curl_setopt($ch, CURLOPT_HTTPGET, 1);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $country_data = json_decode($response);
            $options = array();
            foreach($country_data->Table1 as $value){
                $key = $value->InternationalDialing.'@'.$value->CountryName.'@'.$value->CountryCode;
                $options[$key]= $value->CountryCode.'  -  '.$value->CountryName;
            }
            curl_close($ch);
            return $options;
      }
      /***
       * Update password
       */
      public function UpdatePasswordAPI($form_data){
      //  $url = 'https://qa.training.com/DigitalAPI/api/user/ChangePassword';
        $url = $_ENV['DigitalAPI_ChangePassword'];

        
          $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("content-type: application/json"));
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
      }
      /**
       * user menu API
       */
      public function UserMenuAPI($postField){
        //   $url = 'https://qa.training.com/DigitalAPI/api/menu/GetMenuDetails';
        // //$url = $_ENV['DigitalAPI_GetMenuDetails'];
        
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL,$url);
        //     curl_setopt($ch, CURLOPT_HTTPGET, 1);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //         // 'CustomerID: 331983',
        //         'CustomerID: $postField',
        //         'ComponentID: 2'
        //     ));
        //     $response = curl_exec($ch);
        //     curl_close($ch);
        //     $response=json_decode($response);
        $response = '';
            return $response;
        }


      /**
       * 
       * Update drupal user password
       */
      public function UpdateUserPassword($uid,$password){
        $account = \Drupal::entityTypeManager()->getStorage('user')->load($uid);
        $account->setPassword($password);
        return $account->save();
      }
      public function FormRegexValidation($pattren,$value){
        return preg_match($pattren, $value);
      }
      public function ValidatePassword($value){
        $str_small= preg_match('/[?=.a-z]/', $value);
        $str_capital= preg_match('/[?=.A-Z]/', $value);
        $str_number= preg_match('/[?=.0-9]/', $value);
        $str_symbol= preg_match('/(?=.[!@#\$%\^&])/', $value);
        $strlen=strlen($value);
        if(!$str_small || !$str_capital || !$str_number || !$str_symbol && $strlen > 5 && $strlen < 30){
            return 0;
        }else{
            return 1;
        }
      }
    
    /**
     * register new user;
     */
    public function RegisterNewUser($user_data_json,$password, $email){
        $user_data=json_decode($user_data_json);
      //  echo '<pre>'; print_r($user_data); die();
        if(is_numeric($user_data->CUSTOMER_ID)){
            $check_user = user_load_by_mail($email);
            if(!is_object($check_user)){
              $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
              $user = \Drupal\user\Entity\User::create();
               $cok = md5(time());
		       setcookie('usrlogsetcok', $cok);
              $email_id = '';
              if(isset($user_data->EMAIL_ID) && !empty($user_data->EMAIL_ID)){
                $email_id = $user_data->EMAIL_ID;
              }else{
                $email_id = $user_data->EMAILID;
              }
              //Mandatory settings
              if($password == 'default'){
                  $user->setPassword($user_data->PASSWORD);
                  if($user_data->USER_TYPE == "ENROLL"){
                    if (!filter_var($user_data->Login_ID, FILTER_VALIDATE_EMAIL)) {
                      $user->setEmail($user_data->Login_ID.'@dummyniit.com');
                    }else{
                      $user->setEmail($user_data->Login_ID);
                    }
                    
                    $user->setUsername($user_data->Login_ID);
                  }else{
                    $user->setEmail($email_id);
                    $user->setUsername($email_id);
                  }
                    //Optional settings
              }else{
                  $user->setPassword($password);
                  if($user_data->USER_TYPE == "ENROLL"){
                    if (!filter_var($user_data->Login_ID, FILTER_VALIDATE_EMAIL)) {
                      $user->setEmail($user_data->Login_ID.'@dummyniit.com');
                    }else{
                      $user->setEmail($user_data->Login_ID);
                    }
                    $user->setUsername($user_data->Login_ID);
                  }else{
                    $user->setEmail($email_id);
                    $user->setUsername($email_id);
                  }
                  // $user->setEmail($user_data->EMAIL_ID);
                  // $user->setUsername($user_data->EMAIL_ID);  //Optional settings
              }
              $user->enforceIsNew();
              if($user_data->USER_TYPE == "ENROLL"){
                $user->set('field_student_status', 'Enrolled');
              }else{
                $user->set('field_student_status', '');
              }
              $user->set('field_communication_emailid',$email_id);
              $user->set('field_customer_id',$user_data->CUSTOMER_ID);
              $user->set('field_user_name',$user_data->NAME);
              $user->set('field_mobile_number',$user_data->MOBILENO);
              $user->set("init", 'email');
              $user->addRole('niit');
              $user->set("langcode", $language);
              $user->set("preferred_langcode", $language);
              $user->set("preferred_admin_langcode", $language);
              $user->activate();
              $user->save();
            }
//echo '<pre>'; print_r($user_data->CUSTOMER_ID); die();
            return $this->CheckUserExists($user_data->CUSTOMER_ID);
        }
    }
    /**
     * check user 
     */
    public function CheckUserExists($cid){
        $uid=0;
        $ids = \Drupal::entityQuery('user')
            ->condition(FIELD_CUSTOMER_ID,$cid)
            ->execute();
        if($ids){
            $arrayKeys = array_keys($ids);
            $uid=$ids[$arrayKeys[0]];
        }
        return intval($uid);
    }
    /**
     * get new registered customer id
     */
    public function GetNewUserId($cid){
        $uid=false;
        $ids = \Drupal::entityQuery('user')
            ->condition(FIELD_CUSTOMER_ID,$cid)
            ->execute();
        if($ids){
            $arrayKeys = array_keys($ids);
            $uid=$ids[$arrayKeys[0]];
        }
        return $uid;
    }
    public function CreateLoginSession($uid){
        // $account = \Drupal\user\Entity\User::load($uid);
        // \Drupal::service('session')->migrate();
        // \Drupal::service('session')->set('uid', $account->id());
        // \Drupal::moduleHandler()->invokeAll('user_login', array($account));
        // $account = \Drupal\user\Entity\User::load($uid);
        // user_login_finalize($account);
    }

    public function GetUserAccountLinks($uid){

        $user=\Drupal\user\Entity\User::load($uid);
        \Drupal::service('session')->migrate();
        \Drupal::service('session')->set('uid', $uid);
        \Drupal::moduleHandler()->invokeAll('user_login', array($user));
        //$_SESSION['uid'] = $uid;
        \Drupal::logger('sso')->info($uid);
        user_login_finalize($user);
        $output=array();
        $options_logout = [
            ATTRIBUTES => [TAG_CLASS => ['user-logout']]
        ];
        $options_account = [
            ATTRIBUTES => [TAG_CLASS => ['user-account']]
        ];

        //  $url = 'https://qa.training.com/DigitalAPI/api/menu/GetMenuDetails';
        //$url = $_ENV['DigitalAPI_GetMenuDetails'];

        $userCustomerId = $user->get('field_customer_id')->value;

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_HTTPGET, 1);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'CustomerID: $userCustomerId',
        //     'ComponentID: 2'
        // ));
        // $response = curl_exec($ch);
        // curl_close($ch);
        // $response=json_decode($response);

        $username= $user->getUsername();
        if(isset($user->field_user_name)){
            $username=$user->get('field_user_name')->getValue()[0]['value'];
        }
        $logout_link = \Drupal\Core\Link::fromTextAndUrl(t('LogOut'), \Drupal\Core\Url::fromUri('internal:/user/logout', $options_logout))->toString();
        $my_account = \Drupal\Core\Link::fromTextAndUrl(t('My Account'), \Drupal\Core\Url::fromUri('internal:/user/'.$uid, $options_account))->toString();

          $update_pwd_form_btn =
          '<span class="user-form-btn login"><button type="button" 
          class="user-login" 
          data-toggle="modal" 
          data-target="#update_password_modal_form">Update Password?</button></span>';
        // $currentAccount->id(); //To get User ID
        $user_html='<div id="user-main-container-header" class="user-menu-container">';
        $user_html.='<ul class="user-login-menu">';
            $user_html.='<li class="welcome-user">Welcome '.$username.'</li>';
            $user_html.='<li class="user-avtor"><img class="img-responsive" alt="niit user" src="../img/user.jpeg"/>';
            $user_html.='<ul>';
                $user_html.='<li>'.$my_account.'</li>';
                $user_html.='<li>'.$update_pwd_form_btn.'</li>';
                $user_html.='<li>'.$logout_link.'</li>';
            $user_html.='</ul>';
            $user_html.='</li>';
        $user_html.='</ul>';
        $user_html.='</div>';
        $output['html']=$user_html;
        return $output;
    }
    public function EncripPassword($user_data){
        
        $method = 'aes-256-cbc';
        $key = '8080808080808080';
        $iv = 'Ivan Medvedev';
        return base64_encode(openssl_encrypt($user_data, $method, $key, OPENSSL_RAW_DATA, $iv));
    }
    public function DecriptPassword($plaintext){
        $method = 'aes-256-cbc';
        $key = '8080808080808080';
        $iv = 'Ivan Medvedev';
        return openssl_decrypt(base64_decode($plaintext), $method, $key, OPENSSL_RAW_DATA, $iv);
    }

    
    /* key clock change password api -start */
    public function keyClockCheckOldpasswoedAPI($username, $currentPwd){
      // $url = 'https://login-preprod.niit.com/auth/realms/niit-sso/protocol/openid-connect/token';
      $url = $_ENV['keyclock_mainurl'].'/auth/realms/'.$_ENV['Keyclock_realm'].'/protocol/openid-connect/token';
      // $post_field = 'grant_type=password&username='.$username.'&password='.$currentPwd.'&client_id=niit.test&client_secret=f4cd0405-f729-4418-a812-b66e6c08db84';
      $post_field = 'grant_type=password&username='.$username.'&password='.$currentPwd.'&client_id='.$_ENV['keycloak_client_id'].'&client_secret='.$_ENV['keycloak_client_secret'];
      $curl = curl_init();
      curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $post_field,
          CURLOPT_HTTPHEADER => array(
              'Content-Type: application/x-www-form-urlencoded'
          ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      $json_output = json_decode($response);

      if($json_output->error == 'invalid_grant'){
        $output = 'Invalid current password';
      }else if(isset($json_output->access_token) && !empty($json_output->access_token)){
        $output = 'Valid current password';
      }else{
        $output = 'Error';
      }
      return $output;
    }
    public function keyClockGenerateClientAccessToken(){
      // $url = 'https://login-preprod.niit.com/auth/realms/niit-sso/protocol/openid-connect/token';
      $url = $_ENV['keyclock_mainurl'].'/auth/realms/'.$_ENV['Keyclock_realm'].'/protocol/openid-connect/token';

      // $post_field = 'grant_type=client_credentials&client_id=admin-cli&client_secret=1bcc6bf7-c3f8-4588-97e8-4abece8eef3a';
      $post_field = 'grant_type=client_credentials&client_id='.$_ENV['keycloak_admin_client_id'].'&client_secret='.$_ENV['keycloak_admin_client_secret'];
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $post_field,
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/x-www-form-urlencoded'
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      $output = json_decode($response);
      return $output;
    }
    public function keyClockresetPasswordIdGenerate($username, $accessToken){
      // $url = 'https://login-preprod.niit.com/auth/admin/realms/niit-sso/users?username='.$username;
      $url = $_ENV['keyclock_mainurl'].'/auth/admin/realms/'.$_ENV['Keyclock_realm'].'/users?username='.$username;
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$accessToken
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      $output = json_decode($response);
      return $output;
    }
    public function keyClockresetPasswordAPI($newPassword, $accessToken, $urlId){
      // $url = 'https://login-preprod.niit.com/auth/admin/realms/niit-sso/users/'.$urlId.'/reset-password';
      $url = $_ENV['keyclock_mainurl'].'/auth/admin/realms/'.$_ENV['Keyclock_realm'].'/users/'.$urlId.'/reset-password';
      $field = [
          'type' => 'password',
          'temporary' => 'false',
          'value' => $newPassword,
      ];
      $field_data = json_encode($field);
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => $field_data,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$accessToken,
            'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      $output = json_decode($response);
      return $output;
    }
    /* key clock change password api - end */
	
	public function keyClockdirectlogout($accessToken, $urlId){
		
		$url = $_ENV['keyclock_mainurl'].'/auth/admin/realms/'.$_ENV['Keyclock_realm'].'/users/'.$urlId.'/logout';
		$curl = curl_init();
	  curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
      'Authorization: Bearer '.$accessToken
      ),
      ));

	  $response = curl_exec($curl);

	  curl_close($curl);
	  $output = json_decode($response);
      return $output;
	}
}