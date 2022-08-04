<?php

namespace Drupal\niit_common\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\user\Entity\User;
use Drupal\taxonomy\Entity\Term;
 
class GoogleTagEventController extends ControllerBase {

  public function googleTagEventDatalayerFunction(Request $request) {
    # Request All Data for sent by post
    $requestField = \Drupal::request()->request;
    $pageTitle = $this->stringCapitalizeRemoveDash($requestField->get('pageTitle'));
    $node_id = $requestField->get('node_id');
    $menu_text = $requestField->get('menu_text');
    $menu_url = $requestField->get('menu_url');
    $pageNodeId = $requestField->get('pageNodeId');
    $clientID = $requestField->get('clientID');
    $type = $requestField->get('type');
    $pageNodeBundle = $requestField->get('pageNodeBundle');
    $pageCourseCode = $requestField->get('pageCourseCode');
    $pageModeOfDelevery = $requestField->get('pageModeOfDelevery');
    $coursefeedetails = $requestField->get('coursefeedetails');
    $mobileNumber = $requestField->get('mobileNumber');

    $CenterCity = '';
    $CourseStartDate = '';
    $CourseEnrollmentcheck = '';
    if(!empty($requestField->get('CenterCity'))){
        $CenterCity = $requestField->get('CenterCity');
    }
    if(!empty($requestField->get('CourseStartDate'))){
        $CourseStartDate = $requestField->get('CourseStartDate');
    }
    if(!empty($requestField->get('CourseEnrollmentcheck'))){
        $CourseEnrollmentcheck = $requestField->get('CourseEnrollmentcheck');
    }
    
    
    $menuUrlArray = explode('/', $menu_url);
    # Buttion action and action_text set
    if(trim($menu_text) == 'Enroll Now'){
      $action = 'Enrollment_'.$pageTitle.'_EnrollNow';
    }else if(trim($menu_text) == 'Apply Now'){
      $action = $pageTitle.'_ApplyNow';
    }else if(trim($menu_text) == 'Request a call back'){
      $action = $pageTitle.'_RequestACallBack';
    }else if(trim($menu_text) == 'Download Brochure'){
      $action = $pageTitle.'_DownloadBrochure';
    }else if(trim($menu_text) == 'Connect with us'){
      $action = $pageTitle.'_ConnectWithUs';
    }else if($type == 'PopularProgrammes' || $type == 'JobAssuredProgrammes' || $type == 'RelatedCourses'){
      if(trim($menu_text) == 'Know More'){
        $action = 'KnowMoreAboutCourses_'.$pageTitle.'_KnowMore';
      }else if(trim($menu_text) == 'Enquire Now'){
        $action = 'Enrollment_'.$pageTitle.'_EnquireNow';
      }else{
        $action = 'KnowMoreAboutCourses_'.$pageTitle.'_CourseTitle';
      }
    }else{
        if($pageNodeBundle == 'knowledge_center_slider'){
            if($menu_text == 'Verify'){
                $action = 'KCHomePage_VerifyOTP';
            } else {
                $action = 'KCHomePage_'.$this->stringCapitalizeRemoveDash(trim($menu_text));
            }
        }
        elseif($pageNodeBundle == 'HierarchyCategory'){
            if($menu_text == 'Verify'){
                $action = 'KCCategoryPage_VerifyOTP';
            } else {
                $action = 'KCCategoryPage_'.$this->stringCapitalizeRemoveDash(trim($menu_text));
            }
        }
        else {
            $action = $pageTitle.'_'.$this->stringCapitalizeRemoveDash(trim($menu_text));
        }
    }


    /*****************************************************************/
    if($pageNodeBundle == 'page'){
          
      if($type == "TopMenu" || $type == "PopularProgrammes" || $type == 'JobAssuredProgrammes' || $type == 'RelatedCourses'){
        /************************************************/
        $getNodeId = explode('/', $node_id);
        $get_NodeId = (int) filter_var($getNodeId[1], FILTER_SANITIZE_NUMBER_INT);
        if (strpos($menu_url, '?course') !== false) {
          $menu_urlExplod = explode('?course=', $menu_url);
          $menu_urlExplod_nid = (int) filter_var($menu_urlExplod[1], FILTER_SANITIZE_NUMBER_INT);
          $getNodeData = Node::load($menu_urlExplod_nid);
          # Node Id to get Node URL
          if(is_object($getNodeData) && is_null($getNodeData) == FALSE){
            $menuUrlArray = explode('/', $getNodeData->url());
            $top_course_category = stringGetLowerWithDash($getNodeData->field_top_course_category->target_id);
            $top_course_category = $top_course_category ? '_'.$top_course_category : '';
            $event = $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.stringCapitalizeGetTitleFirstLetter($getNodeData->getTitle()).''.$top_course_category.'_'.$type.'_'.$action;
          }
        }else if(is_numeric($get_NodeId)){
          $getNodeData = Node::load($get_NodeId);
          if(is_object($getNodeData) && is_null($getNodeData) == FALSE){
            $menuUrlArray = explode('/', $getNodeData->url());
            if($getNodeData->gettype() == 'course'){

              $event.= $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.stringCapitalizeGetTitleFirstLetter($getNodeData->getTitle());
              $top_course_category = stringGetLowerWithDash($getNodeData->field_top_course_category->target_id);
              $event.=$top_course_category ? '_'.$top_course_category : '';
              $event.= '_'.$type.'_'.$action;
            }else if($getNodeData->gettype() == 'course_category'){
              if(is_numeric($getNodeData->field_catgory->target_id)){
                $categoryTypeName = (Term::load($getNodeData->field_catgory->target_id))->getName();
                $SubCatogery = str_replace(' ', '-', strtolower($categoryTypeName));
              }
              $event = stringCapitalizeGetTitleFirstLetter($getNodeData->getTitle()).'_'.$SubCatogery.'_'.$type.'_'.$action;
            }else if(empty($menuUrlArray[2])){
              $event = 'Home_'.$type.'_'.$action;
            }else{
              $event = $this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
            }
            // if(!empty($menuUrlArray[4])){
            //   $event = $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.$this->stringCapitalizeGetFirstLetter($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
            // }else if(!empty($menuUrlArray[3])){
            //   $event = $this->stringCapitalizeRemoveDash($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
            // }else if(empty($menuUrlArray[2])){
            //   $event = 'Home_'.$type.'_'.$action;
            // }else{
            //   $event = $this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
            // }
          }
        }else{
          # Url to get Node and set event Name.
            $urlWithoutIndia = substr($menu_url, 6);
            $path = \Drupal::service('path.alias_manager')->getPathByAlias($urlWithoutIndia);
            if(preg_match('/node\/(\d+)/', $path, $matches)) {
              $node = Node::load($matches[1]);
              if(is_object($node) && is_null($node) == FALSE){
                $event.= $node->get('field_course_code')->getValue()[0]['value'].'-'.stringCapitalizeGetTitleFirstLetter($node->getTitle());
                $top_course_category = stringGetLowerWithDash($node->field_top_course_category->target_id);
                $event.= $top_course_category ? '_'.$top_course_category : '_'.$type.'_'.$action;
                // $event = $node->get('field_course_code')->getValue()[0]['value'].'-'.$this->stringCapitalizeGetFirstLetter($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
              }
            }
        }
        /************************************************/
      }else{
        $event = 'Home_'.$type.'_'.$action;
      }  
    }else if(/*$pageNodeBundle == 'course' || */ $pageNodeBundle == 'course_landing_page'){
      
      if($type == "TopMenu" || $type == "PopularProgrammes" || $type == 'JobAssuredProgrammes' || $type == 'RelatedCourses'|| $pageNodeBundle == 'course_landing_page'){
        /************************************************/
        $getNodeId = explode('/', $node_id);
        $get_NodeId = (int) filter_var($getNodeId[1], FILTER_SANITIZE_NUMBER_INT);
        if (strpos($menu_url, '?course') !== false) {
          $menu_urlExplod = explode('?course=', $menu_url);
          $menu_urlExplod_nid = (int) filter_var($menu_urlExplod[1], FILTER_SANITIZE_NUMBER_INT);
          $getNodeData = Node::load($menu_urlExplod_nid);
          # Node Id to get Node URL
          if(is_object($getNodeData) && is_null($getNodeData) == FALSE){
            $menuUrlArray = explode('/', $getNodeData->url());

            $top_course_category = stringCategoryCapitalizeRemoveDash($getNodeData->field_top_course_category->target_id);
            if(is_numeric($getNodeData->field_catgory->target_id)){
              $categoryTypeName = (Term::load($getNodeData->field_catgory->target_id))->getName();
              $SubCatogery = str_replace(' ', '-', strtolower($categoryTypeName));
            }
            //old code
            // $event = $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.$this->stringCapitalizeGetFirstLetter($menuUrlArray[2]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[1]).'_'.$type.'_'.$action;
               $event.= $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.$top_course_category.'';
               $event.= $course_catgory ? '_'.$course_catgory : '_'.$type.'_'.$action;
          }
        }else if(is_numeric($get_NodeId)){
          $getNodeData = Node::load($get_NodeId);
          if(is_object($getNodeData) && is_null($getNodeData) == FALSE){
            $menuUrlArray = explode('/', $getNodeData->url());
            if($getNodeData->gettype() == 'course'){

              $event.= $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.stringCapitalizeGetTitleFirstLetter($getNodeData->getTitle());
              $top_course_category = stringGetLowerWithDash($getNodeData->field_top_course_category->target_id);
              $event.=$top_course_category ? '_'.$top_course_category : '';
              $event.= '_'.$type.'_'.$action;
            }else if($getNodeData->gettype() == 'course_category'){
              if(is_numeric($getNodeData->field_catgory->target_id)){
                $categoryTypeName = (Term::load($getNodeData->field_catgory->target_id))->getName();
                $SubCatogery = str_replace(' ', '-', strtolower($categoryTypeName));
              }
              //$event = stringCapitalizeGetTitleFirstLetter($getNodeData->getTitle()).'_'.$SubCatogery.'_'.$type.'_'.$action;//rachit comment
			  $event = 'ContinueApplication_SuccessA';
            }else if(empty($menuUrlArray[2])){
              //$event = 'Home_'.$type.'_'.$action;//rachit comment
			  $event = 'ContinueApplication_SuccessB';
            }else{
              //$event = $this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;//rachit comment
			  $event = 'ContinueApplication_SuccessC';
			  
            }

          }
        }else{
          # Url to get Node and set event Name.
            $urlWithoutIndia = substr($menu_url, 6);
            $path = \Drupal::service('path.alias_manager')->getPathByAlias($urlWithoutIndia);
            if(preg_match('/node\/(\d+)/', $path, $matches)) {
              $node = Node::load($matches[1]);
              if(is_object($node) && is_null($node) == FALSE){
                $event.= $node->get('field_course_code')->getValue()[0]['value'].'-'.stringCapitalizeGetTitleFirstLetter($node->getTitle());
                $top_course_category = stringGetLowerWithDash($node->field_top_course_category->target_id);
                $event.= $top_course_category ? '_'.$top_course_category : '_'.$type.'_'.$action;





                // $nodeCourseTitle = stringCapitalizeGetTitleFirstLetter($node->getTitle());
                // $top_course_category =stringCategoryCapitalizeRemoveDash($node->field_top_course_category->target_id);
                // // $event = $node->get('field_course_code')->getValue()[0]['value'].'-'.$this->stringCapitalizeGetFirstLetter($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
                // $event = $node->get('field_course_code')->getValue()[0]['value'].'-'.$nodeCourseTitle.''.$top_course_category.'_'.$type.'_'.$action;
              }
            }
        }
        /************************************************/
      }else{
          $urlArray = explode('/', $menu_url);
          // old code remove by ajeet
          // if($urlArray[1] == 'india'){
          //   $event = $pageCourseCode.'-'.$this->stringCapitalizeGetFirstLetter($urlArray[3]).'_'.$this->stringCapitalizeRemoveDash($urlArray[2]).'_'.$type.'_'.$action;
          // }else{
          //   $event = $pageCourseCode.'-'.$this->stringCapitalizeGetFirstLetter($urlArray[2]).'_'.$this->stringCapitalizeRemoveDash($urlArray[1]).'_'.$type.'_'.$action;
          // } 
          if($urlArray[1] == 'india'){
            $urlWithoutIndia = substr($menu_url, 6);
            $path = \Drupal::service('path.alias_manager')->getPathByAlias($urlWithoutIndia);
          }else{
            $path = \Drupal::service('path.alias_manager')->getPathByAlias($menu_url);
          }
          $menu_nid = (int) filter_var($path, FILTER_SANITIZE_NUMBER_INT);
          $getNodeData = Node::load($menu_nid);
          if(is_object($getNodeData) && is_null($getNodeData) == FALSE){
            
            $top_course_category = stringGetLowerWithDash($getNodeData->field_top_course_category->target_id);
            $top_course_category = $top_course_category ? '_'.$top_course_category : '';
          }
         // $event = $pageCourseCode.'-'.stringCapitalizeGetTitleFirstLetter($getNodeData->getTitle()).''.$top_course_category.'_'.$type.'_'.$action;
    //  $event = $action;
      }  
    }else{
      if($type == "TopMenu" || $type == "PopularProgrammes" || $type == 'JobAssuredProgrammes' || $type == 'RelatedCourses'){
        /************************************************/
        $getNodeId = explode('/', $node_id);
        $get_NodeId = (int) filter_var($getNodeId[1], FILTER_SANITIZE_NUMBER_INT);
        if (strpos($menu_url, '?course') !== false) {
          $menu_urlExplod = explode('?course=', $menu_url);
          $menu_urlExplod_nid = (int) filter_var($menu_urlExplod[1], FILTER_SANITIZE_NUMBER_INT);
          $getNodeData = Node::load($menu_urlExplod_nid);
          # Node Id to get Node URL
          if(is_object($getNodeData) && is_null($getNodeData) == FALSE){
            $menuUrlArray = explode('/', $getNodeData->url());
            $arrayCount = count($menuUrlArray);
            // $event = $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.$this->stringCapitalizeGetFirstLetter($menuUrlArray[2]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[1]).'_'.$type.'_'.$action;
            $top_course_category = stringGetLowerWithDash($getNodeData->field_top_course_category->target_id);
            $event = $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.stringCapitalizeGetTitleFirstLetter($getNodeData->getTitle()).'_'.$top_course_category.'_'.$type.'_'.$action;
          }
        }else if(is_numeric($get_NodeId)){
          $getNodeData = Node::load($get_NodeId);
          if(is_object($getNodeData) && is_null($getNodeData) == FALSE){
            $menuUrlArray = explode('/', $getNodeData->url());
            if($getNodeData->gettype() == 'course'){
              $event.= $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.stringCapitalizeGetTitleFirstLetter($getNodeData->getTitle());
              $top_course_category = stringGetLowerWithDash($getNodeData->field_top_course_category->target_id);
              $event.=$top_course_category ? '_'.$top_course_category : '';
              $event.= '_'.$type.'_'.$action;
            }else if($getNodeData->gettype() == 'course_category'){
              if(is_numeric($getNodeData->field_catgory->target_id)){
                $categoryTypeName = (Term::load($getNodeData->field_catgory->target_id))->getName();
                $SubCatogery = str_replace(' ', '-', strtolower($categoryTypeName));
              }
              $event = stringCapitalizeGetTitleFirstLetter($getNodeData->getTitle()).'_'.$SubCatogery.'_'.$type.'_'.$action;
            }else if(empty($menuUrlArray[2])){
              $event = 'Home_'.$type.'_'.$action;
            }else{
              $event = $this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
            }
            // if(!empty($menuUrlArray[4])){
            //   $event = $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.$this->stringCapitalizeGetFirstLetter($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
            // }else if(!empty($menuUrlArray[3])){
            //   $event = $this->stringCapitalizeRemoveDash($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
            // }else if(empty($menuUrlArray[2])){
            //   $event = 'Home_'.$type.'_'.$action;
            // }else{
            //   $event = $this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
            // }
          }
        }else{
          # Url to get Node and set event Name.
            $urlWithoutIndia = substr($menu_url, 6);
            $path = \Drupal::service('path.alias_manager')->getPathByAlias($urlWithoutIndia);
            if(preg_match('/node\/(\d+)/', $path, $matches)) {
              $node = Node::load($matches[1]);
              if(is_object($node) && is_null($node) == FALSE){
                $event.= $node->get('field_course_code')->getValue()[0]['value'].'-'.stringCapitalizeGetTitleFirstLetter($node->getTitle());
                $top_course_category = stringGetLowerWithDash($node->field_top_course_category->target_id);
                $event.= $top_course_category ? '_'.$top_course_category : '_'.$type.'_'.$action;

                // $event = $node->get('field_course_code')->getValue()[0]['value'].'-'.stringCapitalizeGetTitleFirstLetter($node->getTitle()).'_'.stringCategoryCapitalizeRemoveDash($node->field_top_course_category->target_id).'_'.$type.'_'.$action;
                // $event = $node->get('field_course_code')->getValue()[0]['value'].'-'.$this->stringCapitalizeGetFirstLetter($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
              }
            }
        }
        /************************************************/
      }
      elseif($pageNodeBundle == 'HierarchyCategory'){
        $event = 'KnowledgeCenter_'.$type.'_'.$action;
      }
      else{
        $urlArray = explode('/', $menu_url);
        $event = $this->stringCapitalizeRemoveDash($urlArray[2]).'_'.$type.'_'.$action;
      }
    }
    /*****************************************************************/



        # According to url set event Name
        // if($type == "TopMenu" || $type == "PopularProgrammes" || $type == 'JobAssuredProgrammes' || $type == 'RelatedCourses'){
        //   /***********************/
        //   $getNodeId = explode('/', $node_id);
        //   if (strpos($menu_url, '?course') !== false) {
        //     $menu_urlExplod = explode('?course=', $menu_url);
        //     $getNodeData = Node::load($menu_urlExplod[1]);
        //     # Node Id to get Node URL
        //     $menuUrlArray = explode('/', $getNodeData->url());
        //     $event = $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.$this->stringCapitalizeGetFirstLetter($menuUrlArray[2]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[1]).'_'.$type.'_'.$action;
        //   }else if(is_numeric($getNodeId[1])){
        //     $getNodeData = Node::load($getNodeId[1]);
        //     $menuUrlArray = explode('/', $getNodeData->url());
        //     if(!empty($menuUrlArray[4])){
        //       $event = $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.$this->stringCapitalizeGetFirstLetter($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
        //     }else if(!empty($menuUrlArray[3])){
        //       $event = $this->stringCapitalizeRemoveDash($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
        //     }else if(empty($menuUrlArray[2])){
        //       $event = 'Home_'.$type.'_'.$action;
        //     }else{
        //       $event = $this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
        //     }
        //   }else{
        //     # Url to get Node and set event Name.
        //     $urlWithoutIndia = substr($menu_url, 6);
        //     $path = \Drupal::service('path.alias_manager')->getPathByAlias($urlWithoutIndia);
        //     if(preg_match('/node\/(\d+)/', $path, $matches)) {
        //       $node = Node::load($matches[1]);
        //       $event = $node->get('field_course_code')->getValue()[0]['value'].'-'.$this->stringCapitalizeGetFirstLetter($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
        //     }
        //   }
        //   /***********************/
        // }
        

        
        # Get Student Lead form submit data Session

        session_start();
        $formStudentMobile = !empty($_SESSION['formStudentMobile']) ? $_SESSION['formStudentMobile'] : '';
        $formStudentCity = !empty($_SESSION['formStudentCity']) ? $_SESSION['formStudentCity'] : '';
        $formStudentState = !empty($_SESSION['formStudentState']) ? $_SESSION['formStudentState'] : '';
        $formStudentDOB = !empty($_SESSION['formStudentDOB']) ? $_SESSION['formStudentDOB'] : '';
        $formStudentPrfrdCntr = !empty($_SESSION['formStudentPrfrdCntr']) ? $_SESSION['formStudentPrfrdCntr'] : '';
        $formStudentPrfrdCntrName = !empty($_SESSION['formStudentPrfrdCntrName']) ? $_SESSION['formStudentPrfrdCntrName'] : '';
        $formStudentLeadId = !empty($_SESSION['formStudentLeadId']) ? md5($_SESSION['formStudentLeadId']) : '';
        
        // Check session mobile number
        if(empty($formStudentMobile)){
            $formStudentMobile = !empty($mobileNumber) ? md5(trim($mobileNumber)) : '';
        }
        if(!empty($_SESSION['formStudentLeadId']) || $CourseEnrollmentcheck == 1){
          $courseEnrollmentOpen = 'Yes';
        }else{
          $courseEnrollmentOpen = 'No';
        }

        if(!empty($requestField->get('CentreName'))){
            $formStudentPrfrdCntrName = $requestField->get('CentreName');
        }
        
        if(!empty($requestField->get('CentreId'))){
            $formStudentPrfrdCntr = $requestField->get('CentreId');
        }
        


        # Home Page Event Data
        if($pageNodeBundle == 'page'){
          $PageSubCategory = 'HomePage';      
        } 
        if(/*$pageNodeBundle == 'course' ||*/ $pageNodeBundle == 'course_landing_page'){
          

          $PageSubCategory = 'Top';
          //$PageSubSubCategory = 'CoursePage';
		  $pageCategory = 'Program Detail Page';
		  

          $urlArray = explode('/', $menu_url);
          // lod code removed by ajeet
          // if($urlArray[1] == 'india'){
          //   if($pageTitle == 'LandingPage'){
          //     $currentPageTitle = 'india:'.$urlArray[2].':'.$urlArray[3].':'.$urlArray[4].':CampaignLandingPage';
          //   }else{
          //     $currentPageTitle = 'india:'.$urlArray[2].':'.$urlArray[3].':'.$urlArray[4];
          //   }
          //   $currentCourseCatogery = $urlArray[3];
          //   $currentCourseSubCatogery = $urlArray[2];
          //   $currentCourseName = $urlArray[3].':'.$urlArray[4];
          // }else{
          //   if($pageTitle == 'LandingPage'){
          //     $currentPageTitle = 'india:'.$urlArray[1].':'.$urlArray[2].':'.$urlArray[3].':CampaignLandingPage';
          //   }else{
          //     $currentPageTitle = 'india:'.$urlArray[1].':'.$urlArray[2].':'.$urlArray[3];
          //   }
          //   $currentCourseCatogery = $urlArray[2];
          //   $currentCourseSubCatogery = $urlArray[1];
          //   $currentCourseName = $urlArray[2].':'.$urlArray[3];
          // }
          // $mainCoursedetails = \Drupal::service('niit_common.niit_related_courses')->niit_related_courses_info([$pageNodeId]);
          if($urlArray[1] == 'india'){
            $urlWithoutIndia = substr($menu_url, 6);
            $path = \Drupal::service('path.alias_manager')->getPathByAlias($urlWithoutIndia);
          }else{
            $path = \Drupal::service('path.alias_manager')->getPathByAlias($menu_url);
          }
          $menu_nid = (int) filter_var($path, FILTER_SANITIZE_NUMBER_INT);
          $getNodeData = Node::load($menu_nid);
          # Node Id to get Node URL
          if(is_object($getNodeData) && is_null($getNodeData) == FALSE){
            $suffix = '';
            if($pageTitle == 'LandingPage'){
              $suffix = ':CampaignLandingPage';
            }

            $top_course_category = stringGetLowerWithDash($getNodeData->field_top_course_category->target_id);
            if(is_numeric($getNodeData->field_catgory->target_id)){
              $categoryTypeName = (Term::load($getNodeData->field_catgory->target_id))->getName();
              $SubCatogery = str_replace(' ', '-', strtolower($categoryTypeName));
            }
            $courseTitle = stringGetLowerWithDash($getNodeData->getTitle());
            
            $currentPageTitle.= 'india';
            $currentPageTitle.= $course_catgory ? ':'.$course_catgory : '';
            $currentPageTitle.= $top_course_category ? ':'.$top_course_category : $top_course_category;
            $currentPageTitle.= ':'.$courseTitle.''.$suffix;
            
            $currentCourseCatogery = $top_course_category;
            $currentCourseSubCatogery = $course_catgory;
            $currentCourseName = $course_catgory.':'.$courseTitle;
          }



          $CourseCode = $pageCourseCode;
          $CourseType = $pageModeOfDelevery;
          $courseFeeData = explode('@@', $coursefeedetails);
          $CourseFees = ($courseFeeData[0]!='No') ? strval($courseFeeData[0]) : '';
          $CourseBaseFees = ($courseFeeData[1]!='No') ? strval($courseFeeData[1]) : ''; 
          $CourseRating = ($courseFeeData[2]!='No') ? $courseFeeData[2] : '';
          $CourseReviews = ($courseFeeData[3]!='No') ? $courseFeeData[3] : '';
          $AvailableBatches = ($courseFeeData[4]!='No') ? $courseFeeData[4] : '';
          $CourseStartDate = ($courseFeeData[4]!='No') ? $courseFeeData[4] : '';
          $CourseDuration = ($courseFeeData[5]!='No') ? $courseFeeData[5] : '';
          $CampaignCode = ($courseFeeData[6]!='No') ? $courseFeeData[6] : '';
          $CourseEnrollmentNow = $courseEnrollmentOpen;

        

          if($pageTitle == 'LandingPage'){
            $pageTitle = 'CoursePage';
          }
        }

        if($pageNodeBundle == 'knowledge_center_slider'){
            $pageTitle = 'KnowledgeCentrePage';
            $currentPageTitle = 'india:knowledge-center';
        }
        elseif($pageNodeBundle == 'HierarchyCategory'){
          $pageTitle = 'KnowledgeCentreCategoryPage';
          $urlArray = explode('/', $menu_url);
          if($urlArray[1] == 'india'){
            $a = str_replace('/',":",$menu_url);
            $currentPageTitle = ltrim($a, ':');
          }
          else{
            $a = str_replace('/',":",$menu_url);
            $currentPageTitle = 'india:'.ltrim($a, ':');
          }
        }
        # Course Page
        // if (!empty($pageNodeId)) {
        //     $resultUrl = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$pageNodeId);
        //     $node = \Drupal\node\Entity\Node::load($pageNodeId);
        //     $nid = $pageNodeId;
        //     if($node->bundle() == 'page'){
        //       $PageSubCategory = 'HomePage';
        //     }else if($node->bundle() == 'course'){

        //       $PageSubCategory = 'CourseCatalogPage';
        //       $PageSubSubCategory = 'CoursePage';

        //       $urlArray = explode('/', $resultUrl);
        //         if($urlArray[1] == 'india'){
        //           if($pageTitle == 'LandingPage'){
        //             $currentPageTitle = 'india:'.$urlArray[2].':'.$urlArray[3].':'.$urlArray[4].':CampaignLandingPage';
        //           }else{
        //             $currentPageTitle = 'india:'.$urlArray[2].':'.$urlArray[3].':'.$urlArray[4];
        //           }
        //           $currentCourseCatogery = $urlArray[3];
        //           $currentCourseSubCatogery = $urlArray[2];
        //           $currentCourseName = $urlArray[3].':'.$urlArray[4];
        //         }else{
        //           if($pageTitle == 'LandingPage'){
        //             $currentPageTitle = 'india:'.$urlArray[1].':'.$urlArray[2].':'.$urlArray[3].':CampaignLandingPage';
        //           }else{
        //             $currentPageTitle = 'india:'.$urlArray[1].':'.$urlArray[2].':'.$urlArray[3];
        //           }
        //           $currentCourseCatogery = $urlArray[2];
        //           $currentCourseSubCatogery = $urlArray[1];
        //           $currentCourseName = $urlArray[2].':'.$urlArray[3];
        //         }
        //         $mainCoursedetails = \Drupal::service('niit_common.niit_related_courses')->niit_related_courses_info([$nid]);
        //       $CourseCode = $mainCoursedetails[0]['course_code'];
        //       // $CourseDuration = $mainCoursedetails[0]['course_duration'];
        //       $CourseFees = strval($mainCoursedetails[0]['course_api_fee']);
        //       $CourseBaseFees = strval($mainCoursedetails[0]['course_api_base_fee']);
        //       $CourseType = $node->field_mode_of_delivery->value;
        //       $CourseRating = $mainCoursedetails[0]['course_star_rating_value'];
        //       $CourseReviews = $mainCoursedetails[0]['course_total_review'];
        //       $CourseEnrollmentNow = $courseEnrollmentOpen;

        //       $AvailableBatches = $mainCoursedetails[0]['batchAvailable'];

        //       if($pageTitle == 'LandingPage'){
        //         $pageTitle = 'CoursePage';
        //       }
        //       /****/
        //     }
        // }

        # Is user Login
        $current_user = \Drupal::currentUser();
        $roles = $current_user->getRoles();
        if($roles[1] == 'niit'){
            $user = User::load($current_user->id());
            $StudentEmailID = md5($user->getEmail());
            $StudentName = $user->get('field_user_name')->value;
            $formStudentMobile = md5($user->get('field_mobile_number')->value);
        }

        # Set Final output dataLayer Array
        $output = array(
          'ClientId' => $clientID,
          'event' =>  $event,
          'Country' =>  "India",
          'pageCategory' =>  !empty($pageTitle) ? $pageTitle : '',
          'pageSubCategory' => !empty($PageSubCategory) ? $PageSubCategory : '',
          'PageSubSubCategory' => !empty($PageSubSubCategory) ? $PageSubSubCategory : '',
          'PageName' => !empty($currentPageTitle) ? $currentPageTitle : '',
          'CourseCatogery' => !empty($currentCourseCatogery) ? $currentCourseCatogery : '',
          'CourseSubCatogery' => !empty($currentCourseSubCatogery) ? $currentCourseSubCatogery : '',
          'CourseName' => !empty($currentCourseName) ? $currentCourseName : '',
          'CourseCode' => !empty($CourseCode) ? $CourseCode : '',
          'CourseDuration' => !empty($CourseDuration) ? $CourseDuration : '',
          'CourseFees' => !empty($CourseFees) ? $CourseFees : '',
          'CourseBaseFee' => !empty($CourseBaseFees) ? $CourseBaseFees : '',
          'CourseFeesTax' => "",
          'CourseType' => !empty($CourseType) ? $CourseType : '',
          'CourseRating' => !empty($CourseRating) ? $CourseRating : '',
          'CourseReviews' => !empty($CourseReviews) ? $CourseReviews : '', 
          'CourseEnrollmentNow' => !empty($CourseEnrollmentNow) ? $CourseEnrollmentNow : '',
          'LeadId' => $formStudentLeadId,
          'CentreName' => $formStudentPrfrdCntrName,
          'CentreId' => $formStudentPrfrdCntr,
          'CenterState' => $formStudentState,
          'CenterCity' => $CenterCity,
          'AvailableBatches' => !empty($AvailableBatches) ? $AvailableBatches : '',
          'SelectedBatch' => "",
          'CourseStartDate' => $CourseStartDate,
          'StudentEncryptedMobileNumber' => $formStudentMobile,
          'StudentRegistrationNumber' => "",
          'StudentDOB' => $formStudentDOB,
          'StudentGender' => "",
          'StudentCountry' => "India",
          'StudentState' => $formStudentState,
          'StudentCity' => $formStudentCity,
          'StudentPinCode' => "",
          /*************** New variable ************* start *******/
          'StudentEncryptedEmailID' => !empty($StudentEmailID) ? $StudentEmailID : '',
          'StudentName' => !empty($StudentName) ? $StudentName : '',
          'CouponCode' => '',
          'CampaignCode' => $CampaignCode,

          'articleName' => '',
          'articleCategory' => '',
          'articleSubCategory' => ''
          /*************** New variable ************* end *********/
        );
        $result = ['data' => $output];
        return new JsonResponse($result);
        
    }
      # String Capitalized with Remove Space/Space.
      public function stringCapitalizeRemoveDash($string){
        return preg_replace("/[^a-zA-Z0-9\s]/", "", implode('-', array_map('ucfirst', explode('-', $string))));
      }
      # String Capitalized with Get First Letter.
      public function stringCapitalizeGetFirstLetter($string){
        $words = explode(" ", ucwords(str_replace('-', ' ', $string)));
        $output = "";
        foreach ($words as $w) {
          $output .= $w[0];
        }
        return $output;
      }
    # ICICI Center Data Update
  public function courseCenterDataOnCitySelectFunction(Request $request) {
    $requestField = \Drupal::request()->request;
    $city = $requestField->get('city');
    $state = $requestField->get('state');
    $campaignCode = $requestField->get('campaignCode');

    $outPut = get_final_center_data_with_design($campaignCode, $city, $state);
    $result = ['data' => $outPut];
    return new JsonResponse($result);
  }
  public function dataLayer_Event_Session_destroy(){
    $globalSetUTMCookie = \Drupal::service('custom_campaign.niit_kc_services')->globalFuctionForGetUTMPerameterAndSetCookie();
    unset($_SESSION['formStudentMobile']);
    unset($_SESSION['formStudentCity']);
    unset($_SESSION['formStudentState']);
    unset($_SESSION['formStudentDOB']);
    unset($_SESSION['formStudentPrfrdCntr']);
    unset($_SESSION['formStudentPrfrdCntrName']);
    unset($_SESSION['formStudentLeadId']);
    $result = ['data' => 'clear'];
    return new JsonResponse($result);
  }
  public function misc_content_api(){
    $ORGID = $_SERVER['HTTP_ORGID'];
    $COURSECODE = $_SERVER['HTTP_COURSECODE'];
    $CONTENTKEY = $_SERVER['HTTP_CONTENTKEY'];
    $i = 0;
    $output = [];
    if(!empty($ORGID) && !empty($COURSECODE)){
      $query = \Drupal::entityQuery('node');
      $query->condition('type', 'misc_content');
      $query->condition('field_active', 'Yes');
      if(!empty($ORGID)){
        $query->condition('field_orgid', $ORGID);
      }
      if(!empty($COURSECODE)){
        $query->condition('field_coursecode', $COURSECODE);
      }
      if(!empty($CONTENTKEY)){
        $query->condition('field_contentkey', $CONTENTKEY);
      }
      $query->condition('status', 1);
      $NodeIds = $query->execute();
      foreach ($NodeIds as $key => $NodeId) {
        $nodeData = Node::load($NodeId);
        $userId = $nodeData->getOwner()->id();
        $user = \Drupal\user\Entity\User::load($userId);
        $userName = $user->get('name')->value;

        $output[$i]['ORGID'] = $nodeData->field_orgid->value;
        $output[$i]['BUID'] = $nodeData->field_buid->value;
        $output[$i]['CourseCode'] = $nodeData->field_coursecode->value;
        $output[$i]['ProductCode'] = $nodeData->field_productcode->value;
        $output[$i]['PageType'] = $nodeData->field_pagetype->value;
        $output[$i]['ContentType'] = $nodeData->field_contenttype->value;
        $output[$i]['Content'] = $nodeData->field_content_misc->value;
        $output[$i]['Active'] = $nodeData->field_active->value;
        $output[$i]['Referer'] = $nodeData->field_referer->value;
        $output[$i]['ContentLink'] = $nodeData->field_contentlink->uri;
        $output[$i]['ContentKey'] = $nodeData->field_contentkey->value;
        $output[$i]['Target'] = $nodeData->field_target->value;
        $output[$i]['createdon'] = date('d-M-Y', $nodeData->changed->value);
        $output[$i]['createdby'] = $userName;
        $output[$i]['changedon'] = date('d-M-Y', $nodeData->changed->value);
        $output[$i]['changedby'] = $userName;

        $i++;
      }
    }
    $result = ['data' => $output];
    return new JsonResponse($result);
  }
  # GA code send API
  public function ga_course_content_api(){
    $COURSECODE = $_SERVER['HTTP_COURSECODE'];
    // $COURSECODE = 'PGDM';
    $i = 0;
    $output = [];
    if(!empty($COURSECODE)){
      $query = \Drupal::entityQuery('node');
      $query->condition('type', 'course');
      $query->condition('field_course_code', $COURSECODE);
      $query->condition('status', 1);
      $nodeIds = $query->execute();


      $cookieAll = explode('.', $_COOKIE['_ga']);
      $gaCookie = $cookieAll[2].'.'.$cookieAll[3];

      foreach ($nodeIds as $key => $nodeId) {
        $pageTitle = 'CoursePage';
        $node_id = 'node_id/'.$nodeId;
        $menu_text = 'ContinueYourApplication';
        // $menu_url = '';
        $pageNodeId = $nodeId;
        $clientID = $gaCookie;
        $type = 'ApplicationSubmit_Enrollment';
        
        // $menuUrlArray = explode('/', $menu_url);
        
        $action = $pageTitle.'_'.$this->stringCapitalizeRemoveDash(trim($menu_text));

        $getNodeId = explode('/', $node_id);
        # According to url set event Name
        if(is_numeric($getNodeId[1])){
          $getNodeData = Node::load($getNodeId[1]);
          $menuUrlArray = explode('/', $getNodeData->url());
          if(!empty($menuUrlArray[4])){
            $event = $getNodeData->get('field_course_code')->getValue()[0]['value'].'-'.$this->stringCapitalizeGetFirstLetter($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
          }else if(!empty($menuUrlArray[3])){
            $event = $this->stringCapitalizeRemoveDash($menuUrlArray[3]).'_'.$this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
          }else if(empty($menuUrlArray[2])){
            $event = 'Home_'.$type.'_'.$action;
          }else{
            $event = $this->stringCapitalizeRemoveDash($menuUrlArray[2]).'_'.$type.'_'.$action;
          }
        }
        
        # Course Page
        if (!empty($pageNodeId)) {
            $resultUrl = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$pageNodeId);
            $node = \Drupal\node\Entity\Node::load($pageNodeId);
            $nid = $pageNodeId;
            if($node->bundle() == 'course'){

              $PageSubCategory = 'CourseCatalogPage';
              $PageSubSubCategory = 'CoursePage';

              $urlArray = explode('/', $resultUrl);
                if($urlArray[1] == 'india'){
                  $currentPageTitle = 'india:'.$urlArray[2].':'.$urlArray[3].':'.$urlArray[4];
                  $currentCourseCatogery = $urlArray[3];
                  $currentCourseSubCatogery = $urlArray[2];
                  $currentCourseName = $urlArray[3].':'.$urlArray[4];
                }else{
                  $currentPageTitle = 'india:'.$urlArray[1].':'.$urlArray[2].':'.$urlArray[3];
                  $currentCourseCatogery = $urlArray[2];
                  $currentCourseSubCatogery = $urlArray[1];
                  $currentCourseName = $urlArray[2].':'.$urlArray[3];
                }
              $mainCoursedetails = \Drupal::service('niit_common.niit_related_courses')->niit_related_courses_info([$nid]);
              $CourseCode = $mainCoursedetails[0]['course_code'];
              $CourseDuration = $mainCoursedetails[0]['course_duration'];
              $CourseFees = strval($mainCoursedetails[0]['course_api_fee']);
              $CourseBaseFees = strval($mainCoursedetails[0]['course_api_base_fee']);
              $CourseType = $node->field_mode_of_delivery->value;
              $CourseRating = $mainCoursedetails[0]['course_star_rating_value'];
              $CourseReviews = $mainCoursedetails[0]['course_total_review'];
              $CourseEnrollmentNow = $courseEnrollmentOpen;
              $AvailableBatches = $mainCoursedetails[0]['batchAvailable'];

              /****/
            }
        }
        # Is user Login
        $current_user = \Drupal::currentUser();
        $roles = $current_user->getRoles();
        if($roles[1] == 'niit'){
            $user = User::load($current_user->id());
            $StudentEmailID = md5($user->getEmail());
            $StudentName = $user->get('field_user_name')->value;
            $formStudentMobile = md5($user->get('field_mobile_number')->value);
        }
        # Set Final output dataLayer Array
        $output[$i] = array(
          'ClientId' => $clientID,
          'event' =>  $event,
          'Country' =>  "India",
          'pageCategory' =>  !empty($pageTitle) ? $pageTitle : '',
          'pageSubCategory' => !empty($PageSubCategory) ? $PageSubCategory : '',
          'PageSubSubCategory' => !empty($PageSubSubCategory) ? $PageSubSubCategory : '',
          'PageName' => !empty($currentPageTitle) ? $currentPageTitle : '',
          'CourseCatogery' => !empty($currentCourseCatogery) ? $currentCourseCatogery : '',
          'CourseSubCatogery' => !empty($currentCourseSubCatogery) ? $currentCourseSubCatogery : '',
          'CourseName' => !empty($currentCourseName) ? $currentCourseName : '',
          'CourseCode' => !empty($CourseCode) ? $CourseCode : '',
          'CourseDuration' => !empty($CourseDuration) ? $CourseDuration : '',
          'CourseFees' => !empty($CourseFees) ? $CourseFees : '',
          'CourseBaseFee' => !empty($CourseBaseFees) ? $CourseBaseFees : '',
          'CourseFeesTax' => "",
          'CourseType' => !empty($CourseType) ? $CourseType : '',
          'CourseRating' => !empty($CourseRating) ? $CourseRating : '',
          'CourseReviews' => !empty($CourseReviews) ? $CourseReviews : '', 
          'CourseEnrollmentNow' => 'Yes',
          'LeadId' => '',
          'CentreName' => '',
          'CentreId' => '',
          'CenterState' => '',
          'CenterCity' => '',
          'AvailableBatches' => !empty($AvailableBatches) ? $AvailableBatches : '',
          'SelectedBatch' => "",
          'CourseStartDate' => !empty($AvailableBatches) ? $AvailableBatches : '',
          'StudentEncryptedMobileNumber' => '',
          'StudentRegistrationNumber' => "",
          'StudentDOB' => '',
          'StudentGender' => "",
          'StudentCountry' => "India",
          'StudentState' => '',
          'StudentCity' => '',
          'StudentPinCode' => "",
          /*************** New variable ************* start *******/
          'StudentEncryptedEmailID' => !empty($StudentEmailID) ? $StudentEmailID : '',
          'StudentName' => !empty($StudentName) ? $StudentName : '',
          'CouponCode' => '',
          'CampaignCode' => '',

          'articleName' => '',
          'articleCategory' => '',
          'articleSubCategory' => ''

          /*************** New variable ************* end *********/
        );
        $i++;
      }


    }

    $result = ['data' => $output];
    return new JsonResponse($result);
  }
  # get GA client Id
  public function get_ga_client_id(){
    $cookieAll = explode('.', $_COOKIE['_ga']);
    $gaCookie = $cookieAll[2].'.'.$cookieAll[3];
    $return = ['data' => $gaCookie];
    return new JsonResponse($return); 
  }
  #
}