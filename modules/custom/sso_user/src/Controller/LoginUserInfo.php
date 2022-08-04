<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\user\Entity\User;

class LoginUserInfo extends ControllerBase {  
  
    public function AfterLoginUserInfo() {
      // Code start
	  $variables['user_info'] = '';
  $variables['mob_user_info_signup'] = '';
  $variables['mob_user_info_login'] = '';
  $variables['course_brochure_url'] = '';

	    $uid = \Drupal::currentUser()->id();
  if ($uid > 0) {
    $user_html = '';
    $mob_user_html = '';
    $currentAccount = \Drupal::currentUser();
    $options_logout = [
      'attributes' => ['class' => ['user-logout']]
    ];
    $options_account = [
      'attributes' => ['class' => ['user-account']]
    ];
    // $logout_link = \Drupal\Core\Link::fromTextAndUrl(t('Sign out'), \Drupal\Core\Url::fromUri('internal:/user/logout', $options_logout))->toString();
    $logout_redirect_uri = urlencode($_ENV['DRUPAL_PROTOCOL_DOMAIN']."/india/user/logout");
    //--- updated for keycloak issue
	//$logout_link = '<a href="'.$_ENV["keyclock_mainurl"].'/auth/realms/'.$_ENV["Keyclock_realm"].'/protocol/openid-connect/logout?redirect_uri='.$logout_redirect_uri.'">Sign Out</a>';
    $logout_link = '<a href="'.$_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india/niitlogout">Sign Out</a>';
	$my_account = \Drupal\Core\Link::fromTextAndUrl(t('My Account'), \Drupal\Core\Url::fromUri('internal:/user/'.$currentAccount->id(), $options_account))->toString();
    $kc_my_profile_option = [
      'attributes' => ['class' => ['kc-my-preferences']]
    ];
    $kc_my_profile = \Drupal\Core\Link::fromTextAndUrl(t('My Preferences'), \Drupal\Core\Url::fromUri('internal:/my-preferences', $kc_my_profile_option))->toString();
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
   // echo '<pre>';print_r($user); die();
    $userName = $user->get('field_user_name')->value;
    $userName_array = explode(' ', $user->get('field_user_name')->value);
    $userName_first = $userName_array[0];
    if(empty($userName_first)){
      if(!empty($user->get('field_communication_emailid')->value)){
        $userName_first = $user->get('field_communication_emailid')->value;
      }
      else{
        $userName_first = $user->get('mail')->value;
      }
    }
    // $words = explode(" ", $userName_first);
    // $short_name = "";
    // foreach ($words as $w) {
    //   $short_name .= $w[0];
    // }
    $short_name = substr($userName_first, 0 , 1);
    $userCustomerId = $user->get('field_customer_id')->value;
    $c_email = $user->get('field_communication_emailid')->value;
    $fieldUserEnrolled = $user->get('field_student_status')->value;
    $userMyCourseLink = "";
    if($fieldUserEnrolled == 'Enrolled'){
      $userMyCourseLink = studentMyCourseLinkGenerate($userName, $c_email, $userCustomerId);
    }
    $variables['userMyCourseLink'] = $userMyCourseLink;
    $user_custom_role = $user->get('field_custom_roles')->value;
    // $user_custom_role = "OLP,FAC_ADMIN,MENTOR";
    $user_custom_role_array = explode(',', $user_custom_role);
    $My_Batches_link = '';
    if(!empty($user_custom_role) && in_array("MENTOR", $user_custom_role_array)){
      $My_Batches_link = '<li><a href="javascript:void(0);" class="clsOpenMyBatchesLink">My Batches</a></li>'; 
    }
    if(!empty($user_custom_role) && in_array("MENTORNEW", $user_custom_role_array)){
      $My_Batches_link = '<li><a href="javascript:void(0);" class="clsOpenMyBatchesLink">My Batches</a></li>';
    }
    if(!empty($user_custom_role) && in_array("TRIAL_USER", $user_custom_role_array)){
      $My_Batches_link = '<li><a href="javascript:void(0);" class="clsOpenMyBatchesLink">My Trial Programs</a></li>';
    }
    // $UserService = \Drupal::service('sso_user.user');
    // $response_menu = $UserService->UserMenuAPI($userCustomerId);
    // $api_menu = '';
    // foreach($response_menu as $val){
    //   $api_menu .= '<li><a href="'.$val->SubMenuURL.'">'.$val->SubMenuDescription.'</a></li>';
    // }
    // $currentAccount->id(); //To get User ID
    if(strlen($userName_first) > 12){
        $firstUserName =  substr($userName_first, 0, 12)."...";
    }else{
        $firstUserName =  $userName_first;
    }
    $user_html.='<div class="user-menu-container dropdown">';
        $user_html.='<span data-toggle="dropdown" class="welcome-user dropdown-toggle" ><img onclick="register_popup_info()" src="/india/themes/custom/nexus/assets/images/my-account.png" alt="my-account"> Hi '.$firstUserName.'</span>';
        // $user_html.='<li class="user-avtor"><img class="img-responsive" alt="niit user" src="../img/user.jpeg"/>';
          $user_html.='<ul class="dropdown-menu">';
          $user_html.= $userMyCourseLink;
          $user_html.= $My_Batches_link;
          $user_html.='<li>'.$kc_my_profile.'</li>';
          // $user_html.='<li id="myapplication_menu"><span id="current-app-user">My Application</span></li>';
           $user_html.='<li data-toggle="modal" data-target="#update_password_modal_form" class="update_password_modal_form"><a href ="javascript:void(0);">Change Password</a></li>';
           $user_html.='<li class= "signout-user">'.$logout_link.'</li>';
       //   $user_html .= $api_menu;
          $user_html.='</ul>';
    $user_html.='</div>';
    $variables['user_info']=$user_html;

    

  } else {

 
    //$user_login_form_btn = '<a class="btn btn-default signin_btn" href="/india/moLogin">Sign In</a>';
    //$variables['user_info']=$user_login_form_btn;

	
	$user_login_form_btn = '<p><a class="signin-user" href="javascript:void(0);" onclick="register_popup_info()">sign in</a></p>';
      // $user_login_form_btn = '<li class="signin" onclick="register_popup_info()">
      //     <span>
      //         <img src="/india/themes/custom/nexus/assets/images/my-account.png" alt="my-account">
      //         <b class="only-mob"> Sign In</b>
      //     </span>
      // </li>';
      $variables['user_info']=$user_login_form_btn;

    

  }
	  // Code end
	  
		$userdata = $variables['user_info'];
		$ajax_response = new AjaxResponse();
		$ajax_response->addCommand(new AppendCommand('#afterlogin-userinfo', $userdata));
		return $ajax_response;
    
    }
	
	// ------------------- Not in Use------//
	public function UserRegisterLink() {
	
	  // Code start
	  $variables['register_info'] = "";
	  if (\Drupal::currentUser()->isAnonymous()) {
	    $variables['register_info'] = '<p class="mb-0 text-right"><small><i>New User? Click here to <span onclick="register_popup_info()"><u>Register</u></span></i></small></p>';
      }
	  // Code end
	  // Not in use on QA new template but on Production old template used.
		$userdata = $variables['register_info'];
		$ajax_response = new AjaxResponse();
		$ajax_response->addCommand(new AppendCommand('#userloginlink', $userdata));
		return $ajax_response;
	}
	//------------------ not in use-----------------//
	public function MobileLoginRegisterLink() {
	
	  //Code start	
	  $variables['mob_user_info_signup'] = "";
	  $uid = \Drupal::currentUser()->id();
  if ($uid > 0) {
    $user_html = '';
    $mob_user_html = '';
    $currentAccount = \Drupal::currentUser();
    $options_logout = [
      'attributes' => ['class' => ['user-logout']]
    ];
    $options_account = [
      'attributes' => ['class' => ['user-account']]
    ];

    $logout_redirect_uri = urlencode($_ENV['DRUPAL_PROTOCOL_DOMAIN']."/india/user/logout");
	// keycloak update logout issue
	$logout_link1 = '<a href="'.$_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india/niitlogout">Sign Out</a>';
    //$logout_link = '<a href="'.$_ENV["keyclock_mainurl"].'/auth/realms/'.$_ENV["Keyclock_realm"].'/protocol/openid-connect/logout?redirect_uri='.$logout_redirect_uri.'">Sign Out</a>';

    $my_account = \Drupal\Core\Link::fromTextAndUrl(t('My Account'), \Drupal\Core\Url::fromUri('internal:/user/'.$currentAccount->id(), $options_account))->toString();
    $kc_my_profile_option = [
      'attributes' => ['class' => ['kc-my-preferences']]
    ];
    $kc_my_profile = \Drupal\Core\Link::fromTextAndUrl(t('My Preferences'), \Drupal\Core\Url::fromUri('internal:/my-preferences', $kc_my_profile_option))->toString();

    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $userName = $user->get('field_user_name')->value;
    $userName_array = explode(' ', $user->get('field_user_name')->value);
    $userName_first = $userName_array[0];
    if(empty($userName_first)){
      if(!empty($user->get('field_communication_emailid')->value)){
        $userName_first = $user->get('field_communication_emailid')->value;
      }
      else{
        $userName_first = $user->get('mail')->value;
      }
    }

    $short_name = substr($userName_first, 0 , 1);

    $userCustomerId = $user->get('field_customer_id')->value;

    $c_email = $user->get('field_communication_emailid')->value;
    $fieldUserEnrolled = $user->get('field_student_status')->value;
    $userMyCourseLink = "";
    if($fieldUserEnrolled == 'Enrolled'){
      $userMyCourseLink = studentMyCourseLinkGenerate($userName, $c_email, $userCustomerId);
    }
    $variables['userMyCourseLink'] = $userMyCourseLink;


    $user_custom_role = $user->get('field_custom_roles')->value;
    $user_custom_role_array = explode(',', $user_custom_role);
    $My_Batches_link = '';
    if(!empty($user_custom_role) && in_array("MENTOR", $user_custom_role_array)){
      $My_Batches_link = '<li><a href="javascript:void(0);" class="clsOpenMyBatchesLink" user_cid="'.$userCustomerId.'">My Batches</a></li>';
    }
    if(!empty($user_custom_role) && in_array("TRIAL_USER", $user_custom_role_array)){
      $My_Batches_link = '<li><a href="javascript:void(0);" class="clsOpenMyBatchesLink" user_cid="'.$userCustomerId.'">My Trial Programs</a></li>';
    }
   
    if(strlen($userName_first) > 12){
        $firstUserName =  substr($userName_first, 0, 12)."...";
    }else{
        $firstUserName =  $userName_first;
    }
    /*$user_html.='<div class="user-menu-container dropdown">';
        $user_html.='<span data-toggle="dropdown" class="welcome-user dropdown-toggle" ><span class="short-user">'.$short_name.'</span> Hi '.$firstUserName.' <i class="fas fa-angle-down"></i></span>';
          $user_html.='<ul class="dropdown-menu">';
          $user_html.= $userMyCourseLink;
          $user_html.= $My_Batches_link;
          $user_html.='<li>'.$kc_my_profile.'</li>';
          $user_html.='<li id="myapplication_menu"><span id="current-app-user">My Application</span></li>';
           $user_html.='<li data-toggle="modal" data-target="#update_password_modal_form"><a href ="javascript:void(0);">Change Password</a></li>';
           $user_html.='<li>'.$logout_link.'</li>';
          $user_html.='</ul>';
    $user_html.='</div>';
    $variables['user_info']=$user_html;*/

    $mob_user_html .='<div class="mobLogIns"><ul><div class="user-menu-container dropdown menu-display-hide">';
        $mob_user_html.='<span data-toggle="dropdown" class="welcome-user dropdown-toggle" ><img onclick="register_popup_info()" src="/india/themes/custom/nexus/assets/images/my-account.png" alt="my-account"> Hi '.$userName_first.' </span>' ;
          $mob_user_html.='<ul class="dropdown-menu">';
          $mob_user_html.='<li id="myapplication_menu"><a id="current-app-user">My Application</a></li>';
          $mob_user_html.= $userMyCourseLink;
          $mob_user_html.= $My_Batches_link;
          $mob_user_html.='<li>'.$kc_my_profile.'</li>';
           $mob_user_html.='<li data-toggle="modal" data-target="#update_password_modal_form" class="update_password_modal_form"><a href ="javascript:void(0);">Change Password</a></li>';
           
           $mob_user_html.='<li>'.$logout_link1.'</li>';
          $mob_user_html.='</ul>';
    $mob_user_html.='</div></ul></div>';

    $variables['mob_user_info_signup'] = $mob_user_html;

  } else {
	  
	    // $mob_user_login_form_btn = '<div class="top-menu-sigin-blk p-0"><ul><li class="signin"><div class="m-signBtn"><span class="new_sign_signup" onclick="register_popup_info()"><img src="/india/themes/custom/nexus/assets/images/my-account.png" alt="my-account"> <b class="only-mob"> Sign Up</b></span></li></ul></div></div>';
      $mob_user_login_form_btn = '<li class="new_sign_signup" onclick="register_popup_info()"><img src="/india/themes/custom/nexus/assets/images/my-account.png" alt="my-account"> <b class="only-mob"> Sign Up</b></li>';
        $variables['mob_user_info_signup'] = $mob_user_login_form_btn;
		
      } 
	  // Code end
	  
		$userdata = $variables['mob_user_info_signup'];
		$ajax_response = new AjaxResponse();
		$ajax_response->addCommand(new AppendCommand('#mobileloginlink', $userdata));
		return $ajax_response;
	}
	
	public function MyPrograms() {
	
	  $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
	  
	  $userCustomerId = $user->get('field_customer_id')->value;
      $c_email = $user->get('field_communication_emailid')->value;
      $userName = $user->get('field_user_name')->value;
	  $fieldUserEnrolled = $user->get('field_student_status')->value;
      $userMyCourseLink = "";
      if($fieldUserEnrolled == 'Enrolled'){
        $userMyCourseLink = studentMyCourseLinkGenerate($userName, $c_email, $userCustomerId);
      }
      $variables['userMyCourseLink'] = $userMyCourseLink;
	  
	    $progdata = $variables['userMyCourseLink'];
		$ajax_response = new AjaxResponse();
		$ajax_response->addCommand(new AppendCommand('#user-mycourse-link', $progdata));
		return $ajax_response;
	}
	
	public function MyProgramsPop() {
	
	   $variables['myCourseUserPopUpModal'] = '';
	   $uid = \Drupal::currentUser()->id();
	  if ($uid > 0) {
 
		$user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
		$userName = $user->get('field_user_name')->value;
	
	   /**************************My Course modal***********************Start****************/
		$userCustomerId = $user->get('field_customer_id')->value;

		$c_email = $user->get('field_communication_emailid')->value;
		$fieldUserEnrolled = $user->get('field_student_status')->value;
		$userMyCourseLink = "";
		if($fieldUserEnrolled == 'Enrolled'){
		  $variables['myCourseUserPopUpModal'] = studentMyCourseModalFormGenerate($userName, $c_email, $userCustomerId);
		}
       /**************************My Course modal***********************End****************/
	  }
		$progdatapop = $variables['myCourseUserPopUpModal'];
		$ajax_response = new AjaxResponse();
		$ajax_response->addCommand(new AppendCommand('#mycourse-userpopup', $progdatapop));
		return $ajax_response;
	}
}
