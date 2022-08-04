<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloController.
 */

namespace Drupal\niit_common\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\HttpFoundation\Response;
use Drupal\node\Entity\Node;

class RelatedCoursesData extends ControllerBase {
   public function css_js(){
    global $base_url;
    $include_common_js = $base_url.'/'.\Drupal::theme()->getActiveTheme()->getPath().'/assets/common_js/custom.js';
       $build['#attached']['library'][] = $include_common_js;
       return $build;
     }

    public function RelatedCoursesInfo($course_id) {
     $base_url = (isset($_ENV['DRUPAL_PROTOCOL_DOMAIN']) && !is_null($_ENV['DRUPAL_PROTOCOL_DOMAIN'] )) ? $_ENV['DRUPAL_PROTOCOL_DOMAIN']."/india" : \Drupal::urlGenerator()
    ->generateFromRoute('<front>', [], ['absolute' => TRUE]);
      self::css_js();
        $course_ids = array($course_id);
        $cityCenterList = \Drupal::service('niit_common.niit_related_courses')->GetBatchesUsingLocation();
        $center_codes = array_column($cityCenterList['cityCenterList'],'centerCode');
        $related_courses = \Drupal::service('niit_common.niit_related_courses')->niit_related_courses_info($course_ids);
        /* Get batches */
        $NodeBatchDetails = \Drupal::entityManager()->getStorage('node')->load($course_id);
        $course_code = !empty($NodeBatchDetails->field_course_code->value)?$NodeBatchDetails->field_course_code->value:'';
        $course_delivery_mode_code = !empty($NodeBatchDetails->field_delivery_mode_code->value)?$NodeBatchDetails->field_delivery_mode_code->value:'';
        $batchIdWith = \Drupal::service('niit_common.niit_related_courses')->get_course_fee_and_details($course_delivery_mode_code,$course_code);
        $batchIdWithDate = $batchIdWith['batchIdWithDate'];
        $batchId = $batchIdWith['batchId'];
        $courseBatchDetail = $batchIdWith['courseBatchDetail'];
        $courseBatchDetailRes = htmlspecialchars($batchIdWith['courseBatchDetailRes']);
        $course_image = $related_courses[0]['course_image'];
        $course_title = $related_courses[0]['course_title'];
        $course_duration = $related_courses[0]['course_duration'];
        $course_api_fee = $related_courses[0]['course_api_fee'];
        $course_api_base_fee = $related_courses[0]['course_api_base_fee'];
        $course_cms_fee = $related_courses[0]['course_cms_fee'];
        $course_type = $related_courses[0]['course_type'];
        $course_proceed_button = $related_courses[0]['course_proceed_button_link'];
        $course_enroll_nowlink = $related_courses[0]['course_enroll_now_link'];

        $actual_link = "{$_ENV['DRUPAL_PROTOCOL_DOMAIN']}{$_SERVER['REQUEST_URI']}";
        // $actual_link = "https://sandbox-qa.niit.com/".$_SERVER['REQUEST_URI'];
        $site_current_url = $actual_link;
        /* Enroll Now popup start */ 

        if($cityCenterList['userCityName'] == 'Delhi'){
            $cityCenterList['userCityName'] = 'Delhi-NCR';
        }
        $output = '';
                $output .= '<div class="modal-header">
        <div class="container">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <div class="course_head">
            <div class="row">
               <div class="col-md-3 course_image">
                  <figure>
                     <img src='.$course_image.'>
                  </figure>
               </div>
               <div class="col-md-9">
                  <div class="right_section">
                     <h2 class="text-center">'.$course_title.'</h2> 
                     <div class="course_detail">';
                        if(!empty($course_duration)){ 
                            $output .= '<div class="box"><h3>Total Duration </h3><p>'.$course_duration.'</p></div>';
                        } 
                    // {% if node.field_course_fee.value %} 
                    if(!empty($course_api_fee) && $course_api_fee != 0){                               
                    $output .= '<div class="box">
                           <span class="FeeTooltip">
                           <i class="fa fa-info-circle"></i>
                           <span class="tip_popup">Actual Fees may vary, depending upon your centre selection.</span>
                           </span> 
                           <h3>
                              Course Fee
                           </h3>';
                           // {% if CenterBatchFee != 0 %}
                         //if(!empty($course_api_fee) && $course_api_fee != 0){     
                         $output .=  '<p><i class="fas fa-rupee-sign"></i>
                              <span id="price-batch">'.$course_api_fee.'</span>';

                         if(!empty($course_api_base_fee) && $course_api_base_fee != 0){   
                          $output .=  '<small id="price-basefee">&nbsp; &nbsp;<del><i class="fa fa-rupee"></i> '.$course_api_base_fee.'</del></small>';
                          }
                         $output .= '<span id="price-batch-center"></span>
                              <br>
                              <span class="small_font">( Excluding GST @ 18% )</span>
                           </p>';
                           // {% endif %}
                          //  }
                        $output .= '</div>';
                        // {% endif %} 
                        }
                        // {% if node.field_course_type.value %}
                        if(!empty($course_type)) {
                        $output .= '<div class="box">
                           <h3> 
                              Course Type
                           </h3>
                           <p>'.$course_type.'</p>
                        </div>';
                        }
                        // {% endif %}
                     $output .= '</div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
 <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-body">
          <div class="container">
               <div class="search_section">
                  <div class="row searchrow">
                     <div class="col-sm-offset-1 col-sm-5 text-right">
                        <label> Choose Your Centre In</label>
                     </div>
                     <div class="col-sm-5">
                        <div class="form-group" attributes="'.$course_id.'">
                           <form id="myform" method="post" attributes="'.$course_id.'">
                              <input type="text" class="form-control" placeholder="Enter City" value="'.$cityCenterList['userCityName'].'" id="searchCity" attributes="'.$course_id.'"> 
                              <!--<i class="rightarrow"><img src="'.$base_url.'/sites/default/files/2018-11/input-right-arrow.png" alt=""></i>-->
                              <input type = "hidden" name="courseBatchDetailRes" id="courseBatchDetailRes" value="'.$courseBatchDetailRes.'">
                              <input type = "hidden" name ="city_lat" id = "city_lat" value = "'.$cityCenterList['userLatitude'].'" >
                              <input type = "hidden" name ="city_long" id = "city_long" value = "'.$cityCenterList['userLongitude'].'" >
                              <input type = "hidden" name ="location_lat" id = "location_lat" value = "'.$cityCenterList['userLatitude'].'" >
                              <input type = "hidden" name ="location_long" id = "location_long" value = "'.$cityCenterList['userLongitude'].'" >
                              <input type = "hidden" name ="checkedLocation" id = "checkedLocation" value = "0" >
                              <input type = "hidden" name = "enrollNow" id= "enrollNow" value="'.$course_enroll_nowlink.'" >
                              <input type = "hidden" name = "basePath" id = "basePath" value="'.$base_url.'">
                              <input type = "hidden" name = "proceedButtonLink" id = "proceedButtonLink" value="'.$course_proceed_button.'">
                           </form>
                           <a href="javascript:void(0);" class="btn-primary gobtn" id="searchSubmit" attributes="'.$course_id.'">
                           <i><img src="'.$base_url.'/sites/default/files/2018-11/icon-search.png"></i>
                           </a>
                        </div>
                        <!-- <div class="text-right">
                           <a href="javascript:void(0);" onClick="geoFindMe();"><img src="'.$base_url.'/sites/default/files/2018-11/map-icon-blue11x15px.png" alt=""> Use my current Location</a></div>-->
                        <span id="out"></span>  
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <ul class="citylist" id="cityList" >
                           <li id="1" onClick="checkclick(\'city-mumbai\');" attributes="'.$course_id.'">
                              <img src="'.$base_url.'/sites/default/files/2018-11/icon-mumbai.png" alt="Mumbai">
                              <span id="city-mumbai">Mumbai</span>
                           </li>
                           <li id="2" onClick="checkclick(\'city-bengaluru\');" attributes="'.$course_id.'">
                              <img src="'.$base_url.'/sites/default/files/2018-11/icon-bengaluru.png" alt="Bengaluru">
                              <span id="city-bengaluru">Bengaluru</span>
                           </li>
                           <li id="3" class="active" onClick="checkclick(\'city-delhi-ncr\');" attributes="'.$course_id.'">
                              <img src="'.$base_url.'/sites/default/files/2018-11/icon-delhi.png" alt="DelhiNCR">
                              <span id="city-delhi-ncr">Delhi-NCR</span>
                           </li>
                           <li id="4" onClick="checkclick(\'city-kolkata\');" attributes="'.$course_id.'">
                              <img src="'.$base_url.'/sites/default/files/2018-11/icon-kolkata.png" alt="Kolkata">
                              <span id="city-kolkata" value="Kolkata">Kolkata</span>
                           </li>
                           <li id="5" onClick="checkclick(\'city-chennai\');" attributes="'.$course_id.'">
                              <img src="'.$base_url.'/sites/default/files/2018-11/icon-chennai.png" alt="Chennai">
                              <span id="city-chennai">Chennai</span>
                           </li>
                           <li id="6" onClick="checkclick(\'city-ahmedabad\');" attributes="'.$course_id.'">
                              <img src="'.$base_url.'/sites/default/files/2018-11/icon-ahemdabad.png" alt="Ahmedabad">
                              <span id="city-ahmedabad">Ahmedabad</span>
                           </li>
                           <li id="7" onClick="checkclick(\'city-hyderabad\');" attributes="'.$course_id.'">
                              <img src="'.$base_url.'/sites/default/files/2018-11/icon-hyderabad.png" alt="Hyderabad">
                              <span id="city-hyderabad">Hyderabad</span>
                           </li>
                           <li id="8" onClick="checkclick(\'city-pune\');" attributes="'.$course_id.'">
                              <img src="'.$base_url.'/sites/default/files/2018-11/icon-pune.png" alt="Pune">
                              <span id="city-pune">Pune</span>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="searching-centre" style="display:none" id="searching-centre"><img src="'.$base_url.'/sites/default/files/2018-11/loader-center.gif"></div>
               </div>
               <div class="niit_centres">';
                  // {% if cityCenterList is empty  %}
               if(empty($cityCenterList['cityCenterList'])) {
                  $output .= '<div class="heading_section text-center">
                     <h2 id="messageifno">No Centre available</h2>
                  </div>
                  <div class="centres_section 1" id="ParentCenterDiv">
                     <div class="scrolllist arrowslick" id="CenterDiv">
                     </div>
                  </div>';
                  // {% else %}
                  }else{
                  $output .= '<div class="heading_section text-center">
                     <h2 id="messageifno">NIIT Centre for You (For service support and local faculty access)</h2>
                  </div>
                  <div class="centres_section 2">
                  <div class="scrolllist arrowslick" id="CenterDiv">';
                        // {% for centerList in cityCenterList %}
                    foreach ($cityCenterList['cityCenterList'] as $key => $value) {
                            // centerList = $value
                        // {% if centerList.centerCode in centerCode %}
                          // if($nonBatchesCenters == 1){
                          //   $nonBatchesCenters = 0;
                      
                      if(in_array($value['centerCode'], $center_codes)){
                      $output .= '<div class="col-md-12 CheckEmptybatches-'.$key.'">
                        <!-- shifali start--> 
                        <div class="centre_box">
                              <div class="row">
                                 <div class="enrollMsg">This centre accepts online enrolment for the course</div>
                                 <div class="col-sm-7">
                                    <h3 id="centerName-'.$value['centerCode'].'">'.$value['centerName'].'</h3>
                                    <p class="locate_centre">
                                       <!-- <a class="toltip_link" href="#" data-toggle="tooltip" title="'.$value['centerLocation'].'" data-placement="top" data-content="'.$value['centerLocation'].'"><i><img src="'.$base_url.'/sites/default/files/2018-11/icon-locate.png" alt=""></i>  Locate the Centre</a> -->
                                       <a class="toltip_link" href="javascript:void(0);"><i><img src="'.$base_url.'/sites/default/files/2018-11/icon-locate.png" alt=""></i>  Locate the Centre</a> 
                                       <span class="tip_popup">'.$value['centerLocation'].'</span>                       
                                    </p>
                                 </div>
                                 <div class="col-sm-5">
                                    <div class="mapbox">
                                       <iframe src="https://maps.google.com/maps?q='.$value['centerName'].'&hl=es;z=14&amp;output=embed" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>
                                 </div>
                              </div>';
                              
                              // {% if centerList.centerCode in centerCode %}
                              if(in_array($value['centerCode'],$center_codes)){
                              // $nonBatchesCenters = 1; 
                              $output .= '<div class="row batch_start_on">
                                 <div class="col-sm-6">
                                    <label>Batch starts on</label>
                                    <div class="catfilter sortby_filter">
                                       <select id="date-'.$value['centerCode'].'" name="batchid_no[]" onChange="showBatchTime(this.value,\''.$value['centerCode'].'\',\''.$batchId.'\');">'; 
                                        $output .= '<option value="0">Select Date</option>';
                                          // {% for key,value in batchIdWithDate %}
                                        $CheckEmptybatches = [];
                                        foreach ($batchIdWithDate as $keys => $values) {
                                          // {% if centerList.centerCode == key %}
                                        if($value['centerCode'] == $keys) {
                                          // {% set batchDate = value %}
                                            // $batchDate[] = $value;
                                          // {% for key,value in batchDate %}
                                        foreach ($values as $batchDatekey => $batchDateVal) {
                                            $batchIds = implode(",",$batchDateVal);
                                          // {% set batchIds =  value | join(", ") %}
                                            $CheckEmptybatches[] = $batchIds;
                                         $output .= '<option value='.$batchIds.'>'.$batchDatekey.'</option>';
                                          // {% endfor %}
                                          // {% endif %} 
                                          // {% endfor %}  
                                                }                                              
                                            }
                                        }
                                        if(empty($CheckEmptybatches)){
                                          $output .= '<script>jQuery(".CheckEmptybatches-'.$key.'").remove();</script>';
                                        }                      
                                      $output .='</select>';
                                      
                                    $output .= '</div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="FeeFlotElement" style="display:none" id="feesId-block-'.$value['centerCode'].'">
                                       <label>Course Fees</label>
                                       <p id="batchfee-id" > <i class="fas fa-rupee-sign"> </i> <span id="feesId-'.$value['centerCode'].'"></span>/- </p>
                                       <small class="base-fee-center"><del> <i class="fas fa-rupee-sign"> </i> <span id="BasefeesId-'.$value['centerCode'].'"></span>/-  </del></small>
                                       
                                    </div>
                                 </div>
                              </div>
                             <div class="row course_starting_from">
                              <div class="col-md-12">
                                    <label>Course Starting From (Select Batch Timings)</label>
                                    <div class="clearfix"></div>
                                    <ul class="timelist">';
                                       // {% for courseBatch in courseBatchDetail %}
                                    $counted = 0;
                                    foreach ($courseBatchDetail as $courseBatchkey => $courseBatchValue) {
                                       // {% if centerList.centerCode == courseBatch.SRC_ICD %}
                                        if($value['centerCode'] == $courseBatchValue['SRC_ICD']){
                                            $counted = 1;
                                            // $courseBatchValue['SRC_ICD']
                                            // $courseBatchValue['batchID']
                                            // $courseBatchValue['batchTimings']
                                            // $courseBatchValue['batchID'] \''.$courseBatchValue['batchFees'].'\'
                                    $output .='<li id="batchStart-'.$courseBatchValue['SRC_ICD'].'-'.$courseBatchValue['batchID'].'"  onClick="getFormId(\''.$courseBatchValue['batchID'].'\',\''.$courseBatchValue['SRC_ICD'].'\',\''.$courseBatchValue['batchFees'].'\',\''.$courseBatchValue['baseFees'].'\')" style="display:none">
                                          <div class="start_time">
                                            '.$courseBatchValue['batchTimings'].'
                                          </div>
                                       </li>';
                                       // {% endif %} 
                                       // {% endfor %}
                                    }
                                       $counted++;
                                }
                                   $output .= '</ul>';
                                    // {% for courseBatch in courseBatchDetail %}
                                   foreach ($courseBatchDetail as $courseBatchkey => $courseBatchValue) {
                                    
                                    // {% if centerList.centerCode == courseBatch.SRC_ICD %}
                                    if($value['centerCode'] == $courseBatchValue['SRC_ICD']){
                                        $style = ($courseBatchValue['batchID'] == 164)?'style="display:block"':'style="display:none"';
                                   $output .= 
                                   '<!-- <div {% if courseBatch.batchID == 164 %} style="display:block" {% else %} style="display:none" {% endif %} id="batchid-{{ courseBatch.batchID }}"> -->

                                   <div '.$style.' id="batchid-'.$courseBatchValue['batchID'].'">
                                    <p> 
                                    <form id="enroll-'.$value['centerCode'].'-'.$courseBatchValue['batchID'].'" action="'.$course_proceed_button.'" method="post">
                                       <input type="hidden" name="pCourseCode" value="'.$courseBatchValue['courseCode'].'">
                                       <input type="hidden" name="pModalId" value="'.$courseBatchValue['batchType'].'">
                                       <input type="hidden" name="pcollectionPlanId" value="'.$courseBatchValue['patternCode'].'">
                                       <input type="hidden" name="pbatchId" value="'.$courseBatchValue['batchID'].'">
                                       <input type="hidden" name="pSrcId" value="'.$courseBatchValue['SRC_ICD'].'">
                                       <input type="hidden" name="pDstId" value="'.$courseBatchValue['DST_ICD'].'">
                                       <input type="hidden" name="pisUserLoggedIn" value="N">
                                       <input type="hidden" name="pBatchTimings" value="'.$courseBatchValue['batchTimings'].'">
                                       <input type="hidden" name="pBatchStartDate" value="'.$courseBatchValue['batchStartDate'].'">
                                       <input type="hidden" name="pBatchEndDate" value="'.$courseBatchValue['batchEndDate'].'">
                                       <input type="hidden" name="pFee" value="'.$courseBatchValue['batchFees'].'">
                                       <input type="hidden" name="CourseId" value="'.$courseBatchValue['courseID'].'">
                                       <input type="hidden" name="CourseVersion" value="1">
                                       <input type="hidden" name="CategoryName" value="Digital Marketing">
                                       <input type="hidden" name="SeoUrl" value="web-apps-development-courses-online/web-apps-development-using-node-js">
                                       <input type="hidden" name="pcheckEnroll" value="ENROLL">
                                       <input type="hidden" name="bthcurrencyCode" value="'.$courseBatchValue['currencyCode'].'">
                                       <input type="hidden" name="bthSymbolType" value="'.$courseBatchValue['SymbolType'].'">
                                       <input type="hidden" name="bthSymbolValue" value="'.$courseBatchValue['SymbolValue'].'">
                                       <input type="hidden" name="Minimum_Denomination" value="'.$courseBatchValue['Minimum_Denomination'].'">
                                       <input type="hidden" name="Minimum_Denomination_Value" value="'.$courseBatchValue['Minimum_Denomination_Value'].'">
                                       <input type="hidden" name="IsTax_IncludeIN_Collection" value="'.$courseBatchValue['IsTax_IncludeIN_Collection'].'">
                                       <input type="hidden" name="SourcePlatformName" value="NIITCOM">
                                       <input type="hidden" name="RequestName" value="Enrollment">
                                       <input type="hidden" name="eventdata" value="">
                                       <input type="hidden" name="NIITCourseURL" value="'.$site_current_url.'">
                                    </form>
                                 </p>
                                 </div>';
                                 // {% endif %}
                                 // {% endfor %}
                                }
                            }
                               $output .= '<input type="hidden" id="'.$value['centerCode'].'" value="" />
                                 <a href="javascript:void(0)" id="submit-'.$value['centerCode'].'" onclick="SubmitPreForm(this, \''.$value['centerCode'].'\')" class="morebtn" attributes="'.$course_id.'">Proceed</a>
                                 <div class="clearfix"></div>
                                 <!--<p class="btmtext">You will be redirected to NIITs learning portal (www.training.com) for completing the registration and payment process.</p>-->
                              </div>
                           </div>';
                           // {% else %}
                            }
                            else{
                            $output .= '<div class="row course_starting_from">
                              <div class="col-md-12">
                                 <div class="nobatch_avail">
                                    <div class="nobatch_content">
                                       <label>No Batch available.</label> 
                                    </div>
                                    <p>
                                       <a href="'.$course_enroll_nowlink.'&centerId='.$value['centerId'].'&cityName='.$value['centerCity'].'&centerName='.$value['centerName'].'" target="_blank" class="morebtnpro">Enquire Now</a>
                                    </p>
                                 </div>
                              </div>
                           </div>';
                           // {% endif %}
                        }
                        $output .='</div> <!-- Shifali END--></div>';
                     // {% endif%}
                       //}
                     
                     // {% endfor %}
                        }
                      }
          $output .= '<div class="col-md-12" id="exploreMoreCustomLoad" >
                        <div class="centre_box explore_more" >
                           <div class="row">
                              <div class="alert-mgs-explore"><label class="text-center"><i>View Other Offline Centres</i></label>
                              </div>
                              <a href="#" id="exploreMore" class="morebtnpro" onclick="exploremorecheck()" attributes="'.$course_id.'">Explore More</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>';
               // {% endif %}
                }
            $output .= '</div>
         </div>
      </div>
   </div>
</div>';

        /* End: */ 
      return new Response(render($output));
    }


}
