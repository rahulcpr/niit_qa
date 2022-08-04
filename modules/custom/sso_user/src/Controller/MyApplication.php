<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;


class MyApplication extends ControllerBase {    
    public function ControllerPage() {

    	$output = '';
    	$output_mob = '';
    	$output_desk = '';
    	$display = 0;
    	$i = 0;
    	$arrow = '';
        $user_id = \Drupal::currentUser()->id();
        if(!empty($user_id) && $user_id > 0){

        	$user = \Drupal\user\Entity\User::load($user_id);
		    $userMail = $user->get('mail')->value;
		    $userCustomerId = $user->get('field_customer_id')->value;
		    $userMobileNo = $user->get('field_mobile_number')->value;

		    $data = myapplication_continue_data($userMobileNo);

		    foreach ($data as $key => $value) {
	            $camp_code = $value->campaign;
	            $course_code = $value->intrstd_prgrm;
	            $applicationid = $value->applicationid;
	            $app_data = '';
	            if(!empty($applicationid)){
                  $app_data = '<h6><i>Application id : '.$applicationid.'</i></h6>';
	            }

		    	$database = \Drupal::database();
				$query = $database->query("Select c.entity_id FROM {node__field_course_code} as c INNER JOIN {node__field_campaign_code} as camp ON c.entity_id= camp.entity_id INNER JOIN {node_field_data} as n ON n.nid=c.entity_id WHERE c.bundle = 'course' and camp.bundle='course' and n.type='course' and n.status=1 and camp.field_campaign_code_value='$camp_code' and c.field_course_code_value='$course_code' ");
				$node_id =$query->fetchField();
				if(!empty($node_id)){
					$node = Node::load($node_id);
	                $title = $node->getTitle();
					$course_image = $node->get('field_course_image')->getvalue();
					$course_image_url = '';
			        if(!empty($course_image)) {
			            $course_image_details = file_load($course_image[0]['target_id']);
			            $course_image_url = file_create_url($course_image_details->uri->value);
			        }

			        $CourseType = $node->get('field_delivery_mode_code')->getValue()[0]['value'];
			        $url = '';
			        if($node->hasField('field_proceed_button_link')){
			          if(!empty($node->get('field_proceed_button_link')->getValue()[0]['value'])){
			            $url=$node->get('field_proceed_button_link')->getValue()[0]['value'];
			          }
			        }

			        $course_id= '';
		            $course_batch_id = '';
		            $mainCoursedetails = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($CourseType , $course_code);
		            if(!empty($mainCoursedetails['courseBatchDetail'][0])){
		              $course_id = $mainCoursedetails['courseBatchDetail'][0]['courseID'];
		              $course_batch_id = $mainCoursedetails['courseBatchDetail'][0]['batchID'];
		            }

			        $final_json = (array) $value;

		            $update_data = array(
		              'source' => 'NIITCOM',
		              'CustomerId' => $userCustomerId,
		              'RequestedURL'=> '',
		              'NewSignup' => 'true',
		              'TYPE' => 'U',
		              'orgid' => 1,
		              'CourseId' => $course_id,
		              'BatchId' => $course_batch_id,
		              'enqry_crsspndnc_eml' => $userMail,
		            );
		            $new_json = array_merge($final_json, $update_data);
		            $final_json_send = create_application($new_json);

			        $continue_btn = '<div class="btn btn-primary" id="my-application-continue" nid="'.$node_id.'">Continue Your Application</div><form id="" name="form" method="post" action="'.$url.'" style="display:none;" class="myapp-form-'.$node_id.'">
			        <input type="hidden" name="eventdata" value="">
		            <input type="hidden" name="token" value="'.$final_json_send.'" tabindex="0">
		            <input type="submit" value="Continue Your Application" class="btn btn-primary continue-btn">
		            </form>';

	                $output_desk .= '<div class="myApplicationCourseList">
						              <div class="col-md-3 pl-0">
						                <img src="'.$course_image_url.'" class="img-responsive">
						              </div>
						              <div class="col-md-9">
						                <div class="MyAppCourseDetails">
						                  <h4>'.$title.'</h4>
						                  '.$app_data.'
						                </div>
						                '.$continue_btn.'
						              </div>
						            </div>';

				    if($i == 0){
                       $output_mob .= '<div class="item active">';
				    }
				    else{
                       $output_mob .= '<div class="item">';
                       $arrow = '<a class="left carousel-control" href="#myCarousel" data-slide="prev">
		                    <span class="glyphicon glyphicon-chevron-left"></span>
		                    <span class="sr-only">Previous</span>
		                  </a>
		                  <a class="right carousel-control" href="#myCarousel" data-slide="next">
		                    <span class="glyphicon glyphicon-chevron-right"></span>
		                    <span class="sr-only">Next</span>
		                  </a>';
				    }

					$output_mob .= '<div class="card">
				                        <img src="'.$course_image_url.'" class="card-img-top">
				                        <div class="card-body">
				                          <h4>'.$title.'</h4>
				                          '.$app_data.'
				                          '.$continue_btn.'
				                        </div>
				                      </div>
				                    </div>';

				    $display = 1;
				    $i++;

				}
	
		    }
		    $output .= '<div class="mobile-hide">'.$output_desk.'</div>
		               <div class="desktop-hide">
		              <div class="container">
		                <div id="myCarousel" class="carousel slide" data-ride="carousel">              
		                  <div class="carousel-inner">'.$output_mob.'</div>

		                  <!-- Left and right controls -->
		                  '.$arrow.'
		                </div>
		              </div>
		            </div>';

        }

      $return = ['data' => $output, 'display' => $display ];
    
      return new JsonResponse($return);
    }
}