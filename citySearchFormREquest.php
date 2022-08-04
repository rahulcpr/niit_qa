<?php
include_once('function.php');
$centerList = getCenterList();
if(isset($_POST['searchCity']) && !empty($_POST['searchCity'])) {
  $dcity = $_POST['searchCity'];	
  $cityName = $_POST['searchCity']=='Delhi-NCR' ? 'New Delhi,Noida,Faridabad,Gurgaon,Ghaziabad': $_POST['searchCity'];
  $latitude = $_POST['latitude'];
  $longitude = $_POST['longitude'];
  $checkedLocation = $_POST['checkedLocation'];
  $enrollNow = $_POST['enrollNow'];
  $nodeid = trim($enrollNow,"/india/lead-form/?course=");
  $basePath = $_POST['basePath'];
  $proceedButtonLink = $_POST['proceedButtonLink'];
  $searchedCenterList = searchByCity($centerList, $cityName, $latitude, $longitude, $dcity);
  $node_response = $_POST['courseBatchDetailRes'];
  $node_response_array =  json_decode($node_response);
  $centerCode = array();
  $batchStartTime = array();
  $batchStBid = array();
  $currentUrl = $_POST['currentUrl'];

  foreach($node_response_array as $_node_response_array) {	
    foreach($_node_response_array as $value) {
      $centerCode[]=$value->SRC_ICD;
      $batchStartTime[] = $value->TimeZoneShortBatchStartDateUTC;
      $courseBatchDetail[] = array(
        'batchID'=>$value->batchID,
      	'courseID'=>$value->courseID,
        'batchType'=>$value->batchType,
        'batchStartDate'=>$value->batchStartDate,
        'batchEndDate'=>$value->batchEndDate,
        'batchFees'=>$value->batchFees,
        'baseFees'=>$value->baseFees,
        'currencyCode'=>$value->currencyCode,
        'courseCode'=>$value->courseCode,
        'isInstallmentAvailable'=>$value->isInstallmentAvailable,
        'IS_Batch_Available'=>$value->IS_Batch_Available,
        'Batch_UnAvailableMeessge'=>$value->Batch_UnAvailableMeessge,
        'batchTimings'=>$value->batchTimings,
        'patternCode'=>$value->patternCode,
        'SRC_ICD'=>$value->SRC_ICD,
        'DST_ICD'=>$value->DST_ICD,
        'SymbolType'=>$value->SymbolType,
        'SymbolValue'=>$value->SymbolValue,
        'Minimum_Denomination'=>$value->Minimum_Denomination,
        'Minimum_Denomination_Value'=>$value->Minimum_Denomination_Value,
        'IsTax_IncludeIN_Collection'=>$value->IsTax_IncludeIN_Collection,
        'TimeZoneShortBatchStartDateUTC'=>$value->TimeZoneShortBatchStartDateUTC
      );  
    }
  }
  $courseBatchDetail = array_unique($courseBatchDetail, SORT_REGULAR);
  $centerCode = array_unique($centerCode);
  sort($batchStartTime);
  $batchStartTime = array_unique($batchStartTime);
  # create batch id object start time wise
  foreach($centerCode as $_centerCode) {
    foreach( $courseBatchDetail as $_courseBatchDetail ) {
      if($_centerCode == $_courseBatchDetail['SRC_ICD']) {
        $batchIdWithDate[$_courseBatchDetail['SRC_ICD']][$_courseBatchDetail['TimeZoneShortBatchStartDateUTC']][]=$_courseBatchDetail['batchID'];
        $CenterBatchId[$_courseBatchDetail['SRC_ICD']][] = $_courseBatchDetail['batchID'];
        $batchId[] = $_courseBatchDetail['batchID'];
      }
    }
  }
  $batchId = implode(',', $batchId);
  $display = 'style="display:none"';
  # make response data for view file
  if(!empty($searchedCenterList)){
    foreach($searchedCenterList as $_searchedCenterList){
      /* Check center distance from current user location 
    	if user has allowed own location
      */
      if(in_array($_searchedCenterList['centerCode'], $centerCode)){
        $nonBatchesCenters = 1;  
        # Batch starts date dropdown list making 
        $batchStartDropDown = '<div class="row batch_start_on">
                                <div class="col-sm-6">
                                 <label>Batch starts on</label>
                                  <div class="catfilter sortby_filter"><select id="date-'.$_searchedCenterList['centerCode'].'" name="batchid_no[]" onChange="showBatchTime(this.value, \''.$_searchedCenterList['centerCode'].'\', \''.$batchId.'\' );">
                      <option value="0">Select Date</option>';
                                                  
        $batchTimingList ='<div class="row course_starting_from">
            
                                    <div class="col-md-12">
                                      <label>Course Starting From (Select Batch Timings)</label> 
                                      <div class="clearfix"></div>
                                      <ul class="timelist">';
        $batchEnrollForm = '';
        $courseBatchId = array();
        foreach($courseBatchDetail as $courseBatch){
          if($_searchedCenterList['centerCode'] == $courseBatch['SRC_ICD']){  
          // Check course center code  
            //$batchStBid[$courseBatch['TimeZoneShortBatchStartDateUTC']]=$courseBatch['batchID'];
            if($courseBatch['batchID'] == 163 and in_array($_searchedCenterList['centerCode'], $centerCode)){
                $display = 'style="display:none"';
            }else{
                $display = 'style="display:none"';
            }

            # Batch Timing list making
          //  echo '<pre>'; print_r($courseBatch); die();
           $getformid = $courseBatch['batchID'].", '".$courseBatch['SRC_ICD']."', ".$courseBatch['batchFees'].", ".$courseBatch['baseFees'];
            
            $batchTimingList .= '<li id="batchStart-'.$_searchedCenterList['centerCode'].'-'.$courseBatch['batchID'].'" '.$display.' onClick="getFormId('.$getformid.' )" class="">
             <div class="start_time" id = "'.$courseBatch['batchID'].'">'.$courseBatch['batchTimings'].'</div>
             </li>';

            # Batch Enroll form making

            $batchEnrollForm .= '<div id="batchid-'.$courseBatch['batchID'] .'" '.$display.'>
                          <p>
                         <form id="enroll-'.$_searchedCenterList['centerCode'].'-'.$courseBatch['batchID'].'" action="'.$proceedButtonLink.'" method="post">
                         <input type="hidden" name="pCourseCode" value="'.$courseBatch['courseCode'].'">
                         <input type="hidden" name="pModalId" value="'.$courseBatch['batchType'].'">
                         <input type="hidden" name="pcollectionPlanId" value="'.$courseBatch['patternCode'].'">
                         <input type="hidden" name="pbatchId" value="'.$courseBatch['batchID'].'">
                         <input type="hidden" name="pSrcId" value="'.$courseBatch['SRC_ICD'].'">
                         <input type="hidden" name="pDstId" value="'.$courseBatch['DST_ICD'].'">
                         <input type="hidden" name="pisUserLoggedIn" value="N">
                         <input type="hidden" name="pBatchTimings" value="'.$courseBatch['batchTimings'].'">
                         <input type="hidden" name="pBatchStartDate" value="'.$courseBatch['batchStartDate'].'">
                         <input type="hidden" name="pBatchEndDate" value="'.$courseBatch['batchEndDate'].'">
                         <input type="hidden" name="pFee" value="'.$courseBatch['batchFees'].'">
                         <input type="hidden" name="CourseId" value="'.$courseBatch['courseID'].'">
                         <input type="hidden" name="CourseVersion" value="1">
                         <input type="hidden" name="CategoryName" value="Digital Marketing">
                         <input type="hidden" name="SeoUrl" value="web-apps-development-courses-online/web-apps-development-using-node-js">
                         <input type="hidden" name="pcheckEnroll" value="ENROLL">
                         <input type="hidden" name="bthcurrencyCode" value="'.$courseBatch['currencyCode'].'">
                         <input type="hidden" name="bthSymbolType" value="'.$courseBatch['SymbolType'].'">
                         <input type="hidden" name="bthSymbolValue" value="'.$courseBatch['SymbolValue'].'">
                         <input type="hidden" name="Minimum_Denomination" value="'.$courseBatch['Minimum_Denomination'].'">
                         <input type="hidden" name="Minimum_Denomination_Value" value="'.$courseBatch['Minimum_Denomination_Value'].'">
                         <input type="hidden" name="IsTax_IncludeIN_Collection" value="'.$courseBatch['IsTax_IncludeIN_Collection'].'">
                         <input type="hidden" name="SourcePlatformName" value="NIITCOM">
                         <input type="hidden" name="RequestName" value="Enrollment">
                         <input type="hidden" name="eventdata" value="">
                         <input type="hidden" name="NIITCourseURL" value="'.$currentUrl.'">
                        </form>
                          </p>
                       </div>';
          }   
        }
  
        foreach($batchIdWithDate as $key=>$_batchIdWithDate) {
          if($key == $_searchedCenterList['centerCode']) {
            foreach($_batchIdWithDate as $key=>$val) {
              $batchStartDropDown .= "<option value='".implode(', ', $val)."'>".$key."</option>";   
            } 
          }
        }

        $batchStartDropDown .='</select>
                                </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="FeeFlotElement" style="display:none" id="feesId-block-'.$_searchedCenterList['centerCode'].'">
                                    <label>Course Fees</label>
                                    <p id="batchfee-id" > <i class="fas fa-rupee-sign"> </i> <span id="feesId-'.$_searchedCenterList['centerCode'].'"></span>/-  </p>
                                    <small class="base-fee-center"><del> <i class="fas fa-rupee-sign"> </i> <span id="BasefeesId-'.$_searchedCenterList['centerCode'].'"></span>/-  </del></small>
                                  </div>
                                </div>
                                </div>
                                ';
        $batchTimingList .= "</ul>" ;
        $batchStartDropDown .= $batchTimingList;
        $batchStartDropDown .= $batchEnrollForm;
        $noBatchAvailable = $batchStartDropDown; 
        //$includeText = '<div class="clearfix"></div><p class="btmtext">You will be redirected to NIITs learning portal (www.training.com) for completing the registration and payment process.</p>';
        $proceedButton = '<a href="javascript:void(0)" id="submit-'.$_searchedCenterList['centerCode'].'" onclick="SubmitPreForm(this, \''.$_searchedCenterList['centerCode'].'\')" class="morebtn" attributes="'.$nodeid.'">Proceed</a>';
      }

      if ($nonBatchesCenters == 1) {
        $nonBatchesCenters = 0;
              echo $responseData = '<div class="col-md-12">
                          <div class="centre_box">

                            <div class="row">
                              <div class="enrollMsg">This centre accepts online enrolment for this course</div>
                              <div class="col-sm-7">
                                <h3 id="centerName-'.$_searchedCenterList['centerCode'].'">'.$_searchedCenterList['centerName'].'</h3>
                                <p class="locate_centre">
                                    <a href="javascript:void(0);" class="toltip_link" ><i><img src="'.$basePath.'/sites/default/files/2018-11/icon-locate.png" alt=""></i>  Locate the Centre</a>
                    <span class="tip_popup">'.$_searchedCenterList['centerLocation'].'</span> 
                                </p>

                              </div>
                              <div class="col-sm-5">
                                <div class="mapbox">
                                  <iframe 
                     src="https://maps.google.com/maps?q='.$_searchedCenterList['centerName'].'&hl=es;z=14&amp;output=embed"
                     width="600" 
                     height="450" 
                     frameborder="0" 
                     style="border:0" 
                     allowfullscreen>
                    </iframe>
                                  
                    </div>
                              </div>

                            </div>
                  '.$noBatchAvailable.'
                              <input type="hidden" id="'.$_searchedCenterList['centerCode'].'" value="" />
                            '.$proceedButton.'
                          '.$includeText.'
                </div>
                        </div>
                </div>
                </div>
                ';
      }
      
    }
    echo $responseData = '
                    <div class="col-md-12" id="exploreMoreCustomLoad" >
                        <div class="centre_box explore_more" >
                          <div class="row">
                          <div class="alert-mgs-explore"><label class="text-center"><i>View Other Centres: Not Accepting Online Enrolment</i></label></div>
                            <a href="#" id="exploreMore" class="morebtnpro" onclick="exploremorecheck()" attributes="'.$nodeid.'">Explore More</a>
                          </div>
                        </div>
                    </div>
                    ';

  }else{
    	echo $empty = 1;
    }
}
?>