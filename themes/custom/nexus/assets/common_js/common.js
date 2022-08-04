function modularpage_check(){
    jQuery('.click_by_modular input').val('1');
    jQuery('#user_account_modal_form #login p.text-center.signin-pt-1 a').trigger('click');
    jQuery('#user_account_modal_form').modal('show');
    enroll_modular_click();
}

function popupicici_popup(){
    if(jQuery(".last_step_data_display").is(":visible")){
         jQuery('#check_eligibility_display').modal('show');
    } else{
        jQuery('#ms_ajax_popup_page_enquire_Modal').modal('show');
    } 
    ga_signIn_signUp_event('Apply Now', 'CourseOverview_EnquiryForm');
    $("input[name='enqry_free_trial_check']").val("");
}
function popupicicifree_popup(){
    if(jQuery(".last_step_data_display").is(":visible")){
         jQuery('#check_eligibility_display').modal('show');
    } else{
        jQuery('#ms_ajax_popup_page_enquire_Modal').modal('show');
    } 
    ga_signIn_signUp_event('Apply Now', 'CourseOverview_EnquiryForm');
    //document.getElementById("edit-enqry-free-trial-check").setAttribute('value','My default value');
    $("input[name='enqry_free_trial_check']").val("free");
    
}
function video_iframe_popup(src){
    if(src != ''){
        if(jQuery('#myModal-videos #iframe_data').text() == ''){
            var iframe = '<iframe width="100%" height="400" src="'+src+'?rel=0&autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            jQuery('#myModal-videos #iframe_data').replaceWith('<div id="iframe_data">'+iframe+'</div>'); 
            setTimeout(function(){
              jQuery('#myModal-videos').modal('show');
            }, 0);
        }
        else{
		
              jQuery('#myModal-videos').modal('show');	
        }
		$('#myModal-videos').on('hide.bs.modal', function (e) {
        $('#myModal-videos').each(function(){
		var iframehide = '<iframe width="100%" height="400" src="'+src+'?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
		$('#myModal-videos #iframe_data').replaceWith('<div id="iframe_data">'+iframehide+'</div>');
    });
	})
		 	
    }
}
function stackathonform_popup(nid){
            var nodeid = nid;
            jQuery.ajax({
                url : '/india/stackathon_for_selfpaced',
                type: 'POST',
                data: {nodeid: nodeid},
                
                success: function(response) {
                    jQuery('#StackathonLeadForm').modal('show');
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=node_id]').empty(); 
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=node_id]').val(response.data.node_id);
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=node_batchId]').empty(); 
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=node_batchId]').val(response.data.batchId);
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=course_code]').empty(); 
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=course_code]').val(response.data.course_code);
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=campaign_code]').empty(); 
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=campaign_code]').val(response.data.campaign_code);
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=prfrd_cntr]').empty(); 
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=prfrd_cntr]').val(response.data.center_name);
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=template_type]').empty(); 
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=template_type]').val(response.data.template_type);
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=content_type]').empty(); 
                    jQuery('#StackathonLeadForm .stackathon-lead-form-id input[name=content_type]').val(response.data.content_type);
                    
                }
              });               
}
/*function mobile_menuclicktab(){
    if (jQuery('a.menuIcon').hasClass('active')) {
        jQuery('ul.navUL li .stage2Nav').slideUp();
        jQuery('ul.navUL > li').removeClass('selected');
    }
    jQuery('a.menuIcon').toggleClass('active');
    jQuery('.navmobile').slideToggle();
    jQuery('.navmobile, nav').toggleClass('activate');
    jQuery('html').toggleClass('menuActive');
}

function mobile_sub1(clicked_id){
    if (jQuery('#'+clicked_id).parents('ul.navUL > li').hasClass('selected')) {
        jQuery('#'+clicked_id).parents('ul.navUL > li').parents('nav').find('.stage2Nav').slideUp();
        jQuery('#'+clicked_id).parents('ul.navUL > li').parents('nav').find('ul.navUL li').removeClass('selected');
    } else {
        jQuery('ul.navUL > li .stage2Nav').slideUp();
        jQuery('#'+clicked_id).parents('ul.navUL > li').find('.stage2Nav').slideDown(); //.siblings('li').find('.subNavUL').slideUp();
        jQuery('#'+clicked_id).parents('ul.navUL > li').addClass('selected').siblings('li').removeClass('selected');
    }
    jQuery('.stage2Nav').toggleClass('activate');
}

function mobile_sub2(clicked_id){
    if (jQuery('#'+clicked_id).parents('ul.subNavUL li').hasClass('selected')) {
        jQuery('#'+clicked_id).parents('ul.subNavUL li').parents('.stage2Nav').find('.stage3Nav').slideUp();
        jQuery('#'+clicked_id).parents('ul.subNavUL li').parents('.stage2Nav').find('ul.subNavUL li').removeClass('selected');
    } else {
        jQuery('ul.subNavUL > li .stage3Nav').slideUp();
        jQuery('#'+clicked_id).parents('ul.subNavUL li').find('.stage3Nav').slideDown(); //.siblings('li').find('.subNavUL').slideUp();
        jQuery('#'+clicked_id).parents('ul.subNavUL li').addClass('selected').siblings('li').removeClass('selected');
    }
    jQuery('.stage3Nav').toggleClass('activate');
}

function mobile_sub3(clicked_id){
    if (jQuery('#'+clicked_id).parents('ul.subNavUL3 li').hasClass('selected')) {
        jQuery('#'+clicked_id).parents('ul.subNavUL3 li').parents('.stage3Nav').find('.stage4Nav').slideUp();
        jQuery('#'+clicked_id).parents('ul.subNavUL3 li').parents('.stage3Nav').find('ul.subNavUL3 li').removeClass('selected');
    } else {
        jQuery('ul.subNavUL3 > li .stage4Nav').slideUp();
        jQuery('#'+clicked_id).parents('ul.subNavUL3 li').find('.stage4Nav').slideDown(); //.siblings('li').find('.subNavUL').slideUp();
        jQuery('#'+clicked_id).parents('ul.subNavUL3 li').addClass('selected').siblings('li').removeClass('selected');
    }
}*/

function destroyCarousel() {
    if (jQuery('.scrolllist').hasClass('slick-initialized')) {
        jQuery('.scrolllist').slick('unslick');
    }
}
function showBatchTime(batchId, centerCode, ids){
    var bid = ids.split(',');
    var batchId = batchId.split(',');
    for(i = 0; i < batchId .length; i++ ){
        var index = bid.indexOf(batchId[i]);
        if (index > -1) {
            bid.splice(index, 1);
        }
        var batchStartId = "batchStart-"+centerCode+"-"+batchId[i];
        document.getElementById(batchStartId).style.display='block';
        if(i == 0 && batchId[0] > 0){
          batchfeeid = "batchStart-"+centerCode+"-"+batchId[0];
          jQuery('#'+batchfeeid).trigger('click');
        }
    }

    for(k = 0; k < bid.length; k++ ){
        batchStartId = "batchStart-"+centerCode+"-"+bid[k];
        jQuery("#"+batchStartId).hide();
    }
}

function getFormId(batchId, centerCode, batchFees, baseFees){
    var batchStartId = "batchStart-"+centerCode+"-"+ batchId;
    var feeId = "feesId-"+centerCode;
    var BasefeeId = "BasefeesId-"+centerCode;
    var feeIdBlock = "feesId-block-"+centerCode;
    var formId = "enroll-"+ centerCode + '-'+ batchId;
    var anchorId = 'submit-'+centerCode;
    document.getElementById(centerCode).value = formId;
    document.getElementById('price-batch').innerHTML=batchFees;
    //Display fees on batch selection on the center card
    jQuery('.FeeFlotElement').hide();
    document.getElementById(feeIdBlock).style.display='block';   
    document.getElementById(feeId).innerHTML=batchFees;
    if(baseFees !='' && baseFees > 0){
      document.getElementById(BasefeeId).innerHTML=baseFees;
    }
    else{
       jQuery('.base-fee-center').css('display', 'none'); 
    }
    jQuery('#centerName-'+centerCode).parents('.centre_box').find('.timelist li').removeClass('active');
    jQuery('#centerName-'+centerCode).parents('.centre_box').find('.morebtn').removeClass('active');
    document.getElementById(batchStartId).classList.add("active");
    document.getElementById(anchorId).classList.add("active");
}

// This function is using for submitting of form
    // check if button has active class
function submitForm(centerCode){

    var feeId           = "feesId-"+centerCode;
    var centerId        = "centerName-"+centerCode;
    var currentUrl      = window.location.href;
    var centreFees      = document.getElementById(feeId).textContent;
    var centreName      = document.getElementById(centerId).textContent;

    if(jQuery('#submit-'+centerCode).hasClass('active')){
        //SEO code ends here
        var formId = document.getElementById(centerCode).value;
        document.getElementById(formId).submit();
    }
}
// This function is using for submitting of Enroll Now Submit Form
function enrollNowSubmit(batchID){
    var radioBatchID = $("input[name='priceRedioButton']:checked").val();
    document.getElementById('enrollForm-'+radioBatchID).submit();
}
function enrollNowSubmitInstallment(batchIDwithK){
    document.getElementById('enrollFormInstallment-'+batchIDwithK).submit();
}
function relatedCourseEnrollNowSubmit(batchID){
    document.getElementById('relatedCourseEnrollForm-'+batchID).submit();
}
// This function is using for opening of ecom popup

function showEcomPoPup(course_id){
    $('.loader').show();
    $('#course_modal').html('');
    $.ajax({
        url: Drupal.url('RelatedCourses/'+course_id),
        type:"GET",
        //contentType:"application/json; charset=utf-8",
        //dataType:"json",
        success: function(response) {
        $('.loader').hide();
        $('#course_modal').append(response);
        // Drupal.attachBehaviors();
        // $('#form-id').ajaxForm();
     
        jQuery('#course_modal').modal('show');
        setTimeout(function () {
        jQuery(".scrolllist").slick({
            dots: false,
            infinite: false,
            arrows: true,
            speed: 500,
            slidesToShow: 3,
            slidesToScroll: 1,
            centerMode: false,
            centerPadding: '0px',
            autoplay: false,
            autoplaySpeed: 3000,
            adaptiveHeight: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        arrows: true,
                        infinite: true,
                    }
                }, {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        arrows: true,
                        slidesToScroll: 1
                    }
                }, {
                    breakpoint: 490,
                    settings: {
                        slidesToShow: 1,
                        arrows: true,
                        slidesToScroll: 1,
                    }
                }
            ]
        });
    }, 500);
       }
    });
}

// Get center list when click on autocomplete link
function  getCenterList(){
    document.getElementById('searching-centre').style.display="block";
    //enable new div when NO Centre available on page load for the first time
    var centreAvailableTrue = document.getElementById('messageifno').textContent;
    if (centreAvailableTrue != 'NIIT Centre for You (For service support and local faculty access)') {
        if(!!document.getElementById('ParentCenterDiv'))
        {
            document.getElementById('ParentCenterDiv').style.display='block';    
        }
    }
    var currentUrl      = window.location.href;
    var url = "/india/citySearchFormREquest.php";
    var searchCity = document.getElementById('searchCity').value;
    if(searchCity == "Delhi-Ncr" || searchCity == "New Delhi" || searchCity == "Delhi"){
        searchCity = "Delhi-NCR";
    }

    var latitude = document.getElementById('location_lat').value;
    var longitude = document.getElementById('location_long').value;
    var checkedLocation = document.getElementById("checkedLocation").value;
    var enrollNow = document.getElementById("enrollNow").value;
    var basePath = document.getElementById("basePath").value;
    var courseBatchDetailRes = document.getElementById('courseBatchDetailRes').value;
    var proceedButtonLink = document.getElementById("proceedButtonLink").value;
    var requestUrl = url;
    if(searchCity == "Delhi-Ncr" || searchCity == "New Delhi" || searchCity == "Delhi" || searchCity == "Gurgaon" || searchCity == "gurgaon" || searchCity == "Noida" || searchCity == "noida" || searchCity == "Ghaziabad" || searchCity == "ghaziabad" || searchCity == "Faridabad" || searchCity == "faridabad" ){
        var	olsearchCity = "Delhi-Ncr";
        var res = olsearchCity.toLowerCase();
    }
    else{
        var res = searchCity.toLowerCase();
    }

    searchCity = searchCity[0].toUpperCase() + searchCity.slice(1);
    var spanId = 'city-'+res;
    jQuery('.citylist li').removeClass('active');
    jQuery('#'+spanId).parent('li').addClass('active');
    jQuery.post(requestUrl,
        {
            searchCity: searchCity,
            checkedLocation : checkedLocation,
            latitude : latitude,
            longitude : longitude,
            courseBatchDetailRes: courseBatchDetailRes,
            enrollNow : enrollNow,
            basePath : basePath,
            currentUrl : currentUrl,
            proceedButtonLink
        },
        function(data, status){
            document.getElementById('searching-centre').style.display="none";
            destroyCarousel();

            if (data == 1){
                jQuery(".scrolllist").html('');
                jQuery('#CenterDiv').html('');
                jQuery('#messageifno').text("No centre available");

            }
            else{
                jQuery('#messageifno').text("NIIT Centre for You (For service support and local faculty access)");
                jQuery(".scrolllist").html('');
                jQuery('#CenterDiv').html(data);
                setTimeout(function () {
                    jQuery(".scrolllist").slick({
                        dots: false,
                        infinite: true,
                        arrows: true,
                        speed: 500,
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        centerMode: false,
                        centerPadding: '0px',
                        autoplay: false,
                        autoplaySpeed: 3000,
                        responsive: [
                            {
                                breakpoint: 1024,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 1,
                                    arrows: true,
                                    infinite: true
                                }
                            }, {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 1,
                                    arrows: true,
                                    slidesToScroll: 1
                                }
                            }, {
                                breakpoint: 490,
                                settings: {
                                    slidesToShow: 1,
                                    arrows: true,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                }, 500);
            }
        });
}

function initAutocomplete() {

  var options = {
                              types: ['(cities)'], 
                              fields: ["address_component"],
                              componentRestrictions: {'country': ['in']}
               };

    jQuery(document).ready(function () {

        jQuery('#google-place-field-Enq_Now, #google-place-field-ms_desktop').on('keyup', function () {
            var input_value = jQuery(this).val();
            
          jQuery('#google-place-field-Enq_Now, #google-place-field-ms_desktop').val(input_value);
            
        });
        
        var campaignCode =  jQuery('input[name="source"]').val();
        var coursecode =  jQuery('input[name="intrstd_prgrm"]').val();

        jQuery('#google-place-field-Enq_Now, #google-place-field-ms_desktop').autocomplete({
            source: function (request, response) {
                var autodata = jQuery('#google-place-field-Enq_Now').val();
                if (autodata == undefined || autodata == ''){
                   var autodata = jQuery('#google-place-field-ms_desktop').val(); 
                }

                $("input[name='enqry_crsspndnc_state']").each(function(){
                        $(this).val('');
                    });
                
                if(autodata.trim().length < 3){
                 return;
                }
                //var DOMAIN_TRAINING_COM = drupalSettings.DOMAIN_TRAINING_COM_PATH.path;
                var autocompleteUrl = 'https://qa.training.com/NiitDigitalPlatformAPI/api/GetCityList/Search/' + autodata + '';
                //console.log(autocompleteUrl);
                jQuery.ajax({
                    url:  autocompleteUrl,
                    type: 'GET',
                    cache: false,
                    dataType: 'json',
                    success: function (users) {
                        //console.log(users);
                        response($.map(users.cityMasterModel, function (data) {
                            return {
                                label:  data.Text,
                                value: data.Value,
                            };
                         
                        }));
                       
                    },
                    error: function (xmlHttpRequest, textStatus, errorThrown) {
                        console.log('some error occured', textStatus, errorThrown);
                        
                        jQuery('.ui-menu.ui-widget.ui-widget-content.ui-autocomplete.ui-front').css('display', 'none');
                        
                    }

                });
                
            },
            minLength: 1,
            select: function (event, ui) {
                //alert('you have selected ' + ui.item.label + ' ID: ' + ui.item.value);
                 var url = '/india/get_camp_preferred_center';
                 
                  var selectedcity = ui.item.value;
                  if (selectedcity != ''){
                  var locationDataArr = ui.item.value.split('-');
                 
                  $("input[name='enqry_crsspndnc_state']").each(function(){
                        $(this).val(locationDataArr[1]);
                    });

                  }
                 
                 
                  jQuery.ajax({
                    url : url,
                    type: 'POST',
                    data: {city: locationDataArr[0], state: locationDataArr[1], campaignCode: campaignCode, coursecode: coursecode},
                    beforeSend: function(){
                        //alert('you have selected t' + locationDataArr['city'] + ' ID: ' + ui.item.value);
                        var location_select = jQuery(' select[name="prfrd_cntr"]');
                        location_select.empty();
                        location_select.html("<option value=''> Please wait ... </option>");
                    },
                    success: function(response) {
                        if(response.data) {
                            var data = response.data;
                            //alert('you have selected at' + data + ' ID: ' + ui.item.value);
                            var location_select = jQuery(' select[name="prfrd_cntr"]');
                            location_select.empty();
                            if(response.count == 1){
                                location_select.html("<option value=''> Nearest Support Location </option>");
                                jQuery(' prfrd-cntr-step').css('display', 'block');
                                jQuery(' .display_center').val('1');
                            }
                            else{
                                jQuery(' prfrd-cntr-step').css('display', 'none');
                                jQuery(' .display_center').val('0');
                            }
                            jQuery.each(data, function(key, value) {
                             location_select.append(jQuery("<option></option>").attr("value",key).text(value));
                            });
                        }
                    }
                  });
                
                jQuery('#google-place-field-Enq_Now, #google-place-field-ms_desktop').val(ui.item.label);
                return false;
            }

        });

       /**/
    });

    setTimeout(function(){ 
        jQuery('#google-place-field-ms_desktop').attr('autocomplete', 'new-ms');
        jQuery('#google-place-field-Enq_Now').attr('autocomplete', 'new-now');
        jQuery('#google-place-field-Rqst_Cll_bck').attr('autocomplete', 'new-bck');
        jQuery('#google-place-field-ms_embed').attr('autocomplete', 'new-embed');
    }, 3000);

}
