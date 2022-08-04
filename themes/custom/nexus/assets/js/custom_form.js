////////////////////////////////////////////////////
// on page load multi step form render code start //
////////////////////////////////////////////////////

jQuery(document).ready(function(){
    jQuery(".CustomMultiStepFormSec .custom-step-one-form").show();

    jQuery(document).on("click", ".home_banner_left_block button.customFormGoBtn", function(){
      var mobileNumber = jQuery('.home_banner_left_block  input.mobileNumberField').val();
      jQuery('.CustomMultiStepFormSec .custom-step-one-form :input[name="enqry_crsspndnc_mbl"]').val(mobileNumber);
    });
});
function getUserLoginCookieNiit(name) {
    // Split cookie string and get all individual name=value pairs in an array
    var cookieArr = document.cookie.split(";");
    
    // Loop through the array elements
    for(var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        
        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if(name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            return decodeURIComponent(cookiePair[1]);
        }
    }
    
    // Return null if not found
    return null;
}
// alert(getUserLoginCookieNiit('usrlogsetcok'));
if(getUserLoginCookieNiit('usrlogsetcok')){
  var pageNodeId = jQuery('#pageNodeId').text();
  $.ajax({
    url : '/india/multistep_form_check_login_user', 
    type: 'POST',
    // dataType: "json",
    data: {pageNodeId: pageNodeId},
    // beforeSend: function(){
    //   $('.CustomMultiStepFormSec .custom-step-two-form .loader-div').append('<p><span><i class="fa fa-spinner fa-spin"></i> Please Wait...</span></p>');
    // },
    success: function(response) {
      if(response.data){
        
        // console.log(response.data);
        if(response.status_data.current_step == 3){
          $(".CustomMultiStepFormSec .custom-step-one-form").hide();
          $(".CustomMultiStepFormSec .custom-step-two-form").hide();
          $(".CustomMultiStepFormSec .custom-step-three-form").show();
          $(".CustomMultiStepFormSec .custom-step-three-form .custom-step-three-output").empty();
          $(".CustomMultiStepFormSec .custom-step-three-form .custom-step-three-output").append(response.thirdForm);
        }else if(response.status_data.current_step == 2){
          $(".CustomMultiStepFormSec .custom-step-one-form").hide();
          $(".CustomMultiStepFormSec .custom-step-two-form").show();
          $(".CustomMultiStepFormSec .custom-step-three-form").hide();
          $(".CustomMultiStepFormSec .custom-step-two-form #scroll-form .close").click();
        }else{
          if(response.data.name){
            $('.CustomMultiStepFormSec .custom-step-one-form :input[name="enqry_f_nm"]').val(response.data.name);
            $('.CustomMultiStepFormSec .custom-step-one-form :input[name="enqry_f_nm"]').prop('readonly', true);
          }
          if(response.data.mobile){
            $('.CustomMultiStepFormSec .custom-step-one-form :input[name="enqry_crsspndnc_mbl"]').removeClass('only-numeric-value');
            $('.CustomMultiStepFormSec .custom-step-one-form :input[name="enqry_crsspndnc_mbl"]').val(response.data.mobile);
            $('.CustomMultiStepFormSec .custom-step-one-form :input[name="enqry_crsspndnc_mbl"]').prop('readonly', true);

            $('.home_banner_left_block .mobileNumberField.only-numeric-value').val(response.data.mobile);
            $('.home_banner_left_block .mobileNumberField.only-numeric-value').prop('readonly', true);
          }
          if(response.data.email){
            $('.CustomMultiStepFormSec .custom-step-one-form :input[name="enqry_crsspndnc_eml"]').val(response.data.email);
            $('.CustomMultiStepFormSec .custom-step-one-form :input[name="enqry_crsspndnc_eml"]').prop('readonly', true);
          }
        }

        if(response.data.mobile){
          $('.home_banner_left_block .mobileNumberField.only-numeric-value').val(response.data.mobile);
          $('.home_banner_left_block .mobileNumberField.only-numeric-value').prop('readonly', true);
        }

      }
    }
  });
}
////////////////////////////////////////////////////
// on page load multi step form render code start //
////////////////////////////////////////////////////





/////////////////////////////////////
// step one form submit code start //
/////////////////////////////////////
jQuery( ".custom-step-one-form" ).submit(function( event ) {
  event.preventDefault();
  

  const data = new FormData(event.target);
  const formJSON = Object.fromEntries(data.entries());

  // for multi-selects, we need special handling
  // formJSON.snacks = data.getAll('snacks');

  // const results = document.querySelector('.step_two_result pre');
  // results.innerText = JSON.stringify(formJSON, null, 2);
  // alert(JSON.stringify(formJSON, null, 2));

  // var fieldValidationList = jQuery('.CustomMultiStepFormSec .custom-step-one-form .fieldValidationList').text();
  // jQuery.each(fieldValidationList, function(i, item) {

  //   // alert(item.field + '=' + jQuery('.CustomMultiStepFormSec .custom-step-one-form .'+item.field).val());
  //   alert(item.field);
  // });

  	var formdata = JSON.stringify(formJSON, null, 2);

  	const formDataArr = jQuery.parseJSON(formdata);
  	var errorSet = 0;
  	jQuery('.CustomMultiStepFormSec h6.custom_error').remove(); 
    jQuery('.CustomMultiStepFormSec input').css('border-color', '#ddd');
  	if((formDataArr.enqry_f_nm).length !=0){
  		var pattern=/^[a-zA-Z ]{3,30}$/; 
      	// var values_name = $(this).val();
        if(!pattern.test(formDataArr.enqry_f_nm)) { 
          	jQuery('.CustomMultiStepFormSec input[name="enqry_f_nm"]').after(" <h6 name='error_msg_name' class='mt-2 error_msg_name custom_error'>Please Enter Valid Name</h6>");
          	jQuery('.CustomMultiStepFormSec input[name="enqry_f_nm"]').css('border-color', 'red');
          	jQuery('.CustomMultiStepFormSec h6[name="error_msg_name"]').css('color', 'red');
          	errorSet = 1;
        } 
  	}else{
  		jQuery('.CustomMultiStepFormSec input[name="enqry_f_nm"]').after(" <h6 name='error_msg_name' class='mt-2 error_msg_name custom_error'>Please Enter Name</h6>");
      	jQuery('.CustomMultiStepFormSec input[name="enqry_f_nm"]').css('border-color', 'red');
      	jQuery('.CustomMultiStepFormSec h6[name="error_msg_name"]').css('color', 'red');
      	errorSet = 1;
  	}
  	if((formDataArr.enqry_crsspndnc_mbl).length !=0){
  		var pattern=/^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[6789]\d{9}$/; 
        if(!pattern.test(formDataArr.enqry_crsspndnc_mbl)) { 
          	jQuery('.CustomMultiStepFormSec input[name="enqry_crsspndnc_mbl"]').after(" <h6 name='error_msg_mbl' class='mt-2 error_msg_mbl custom_error'>Please Enter Valid Mobile Number</h6>");
          	jQuery('.CustomMultiStepFormSec input[name="enqry_crsspndnc_mbl"]').css('border-color', 'red');
          	jQuery('.CustomMultiStepFormSec h6[name="error_msg_mbl"]').css('color', 'red');
          	errorSet = 1;
        } 
  	}else{
  		jQuery('.CustomMultiStepFormSec input[name="enqry_crsspndnc_mbl"]').after(" <h6 name='error_msg_mbl' class='mt-2 error_msg_mbl custom_error'>Please Enter Mobile Number</h6>");
        jQuery('.CustomMultiStepFormSec input[name="enqry_crsspndnc_mbl"]').css('border-color', 'red');
        jQuery('.CustomMultiStepFormSec h6[name="error_msg_mbl"]').css('color', 'red');
        errorSet = 1;
  	}
  	if((formDataArr.enqry_crsspndnc_eml).length !=0){
  		var pattern=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; 
        if(!pattern.test(formDataArr.enqry_crsspndnc_eml)) { 
          	jQuery('.CustomMultiStepFormSec input[name="enqry_crsspndnc_eml"]').after(" <h6 name='error_msg_eml' class='mt-2 error_msg_eml custom_error'>Please Enter Valid Email ID</h6>");
          	jQuery('.CustomMultiStepFormSec input[name="enqry_crsspndnc_eml"]').css('border-color', 'red');
          	jQuery('.CustomMultiStepFormSec h6[name="error_msg_eml"]').css('color', 'red');    
          	errorSet = 1;       
        } 
  	}else{
  		jQuery('.CustomMultiStepFormSec input[name="enqry_crsspndnc_eml"]').after(" <h6 name='error_msg_eml' class='mt-2 error_msg_eml custom_error'>Please Enter Email ID</h6>");
        jQuery('.CustomMultiStepFormSec input[name="enqry_crsspndnc_eml"]').css('border-color', 'red');
        jQuery('.CustomMultiStepFormSec h6[name="error_msg_eml"]').css('color', 'red');  
        errorSet = 1;  
  	}
  	if(errorSet == 0){
  		$('.CustomMultiStepFormSec .custom-step-one-form :button[type="submit"]').prop('disabled', true);
  		$.ajax({
		    url : '/india/step_one_form_submit_code',
		    type: 'POST',
		    dataType: "json",
		    data: {results: formdata},
		    beforeSend: function(){
		      	$('.CustomMultiStepFormSec .custom-step-one-form .loader-div').append('<p><span><i class="fa fa-spinner fa-spin"></i> Please Wait...</span></p>');
		    },
		    success: function(response) {
		      	if(response.msg == 'Already Registered'){
			        // jQuery('#user_account_modal_form').modal('toggle');
			        $('.CustomMultiStepFormSec .custom-step-one-form :button[type="submit"]').prop('disabled', false);
			        $('.CustomMultiStepFormSec .custom-step-one-form .custom-messages-wrapper').append('<div class="alert alert-danger">Email Already Registered</div>');
			        $('.CustomMultiStepFormSec .custom-step-one-form .loader-div').empty();
		      	}
		      	if(response.data){
			        $('.CustomMultiStepFormSec .custom-step-one-form .loader-div').empty();
			        $(".CustomMultiStepFormSec .custom-step-one-form").hide();
			        $(".CustomMultiStepFormSec .custom-step-two-form").show();
			        jQuery("#afterlogin-userinfo").html("");
			        Drupal.ajax({ url: "/india/login_user_info"}).execute();
		      	}
		    }
	  	});
  	}
  
});
///////////////////////////////////
// step one form submit code End //
///////////////////////////////////



/////////////////////////////////////
// step Two form submit code start //
/////////////////////////////////////
jQuery( ".custom-step-two-form" ).submit(function( event ) {
  event.preventDefault();
  // alert('hello');
  $('.CustomMultiStepFormSec .custom-step-Two-form :button[type="submit"]').prop('disabled', true);

  const data = new FormData(event.target);
  const formJSON = Object.fromEntries(data.entries());

  // for multi-selects, we need special handling
  // formJSON.snacks = data.getAll('snacks');

  // const results = document.querySelector('.step_two_result pre');
  // results.innerText = JSON.stringify(formJSON, null, 2);
  // alert(JSON.stringify(formJSON, null, 2));
  var formdata = JSON.stringify(formJSON, null, 2);

  const formDataArr = jQuery.parseJSON(formdata);
  var errorSet = 0;
  jQuery('.CustomMultiStepFormSec h6.custom_error').remove(); 
  jQuery('.CustomMultiStepFormSec input').css('border-color', '#ddd');

  if(formDataArr.enqry_dob == ""){
    jQuery('.CustomMultiStepFormSec input[name="enqry_dob"]').after(" <h6 name='error_msg_dob' class='mt-2 custom_error'>Please Enter DOB</h6>");
    jQuery('.CustomMultiStepFormSec input[name="enqry_dob"]').css('border-color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_dob"]').css('color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_dob"]').slice(1).remove();
    errorSet = 1;
  }
  if(formDataArr.perclassten == "") { 
    jQuery('.CustomMultiStepFormSec input[name="perclassten"]').after(" <h6 name='error_msg_perclassten' class='mt-2 custom_error'>Please Enter 10th Marks</h6>");
    jQuery('.CustomMultiStepFormSec input[name="perclassten"]').css('border-color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_perclassten"]').css('color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_perclassten"]').slice(1).remove();
    errorSet = 1;
  }
  if(formDataArr.perclasstwelve == "") { 
    jQuery('.CustomMultiStepFormSec input[name="perclasstwelve"]').after(" <h6 name='error_msg_perclasstwelve' class='mt-2 custom_error'>Please Enter 12th Marks</h6>");
    jQuery('.CustomMultiStepFormSec input[name="perclasstwelve"]').css('border-color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_perclasstwelve"]').css('color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_perclasstwelve"]').slice(1).remove(); 
    errorSet = 1;
  } 
  if(formDataArr.perclassgrad == "") { 
    jQuery('.CustomMultiStepFormSec input[name="perclassgrad"]').after(" <h6 name='error_msg_perclassgrad' class='mt-2 custom_error'>Please Enter Graduation Marks</h6>");
    jQuery('.CustomMultiStepFormSec input[name="perclassgrad"]').css('border-color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_perclassgrad"]').css('color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_perclassgrad"]').slice(1).remove(); 
    errorSet = 1;
  }
  if(formDataArr.crrntlydoing == "") { 
    jQuery('.CustomMultiStepFormSec select[name="crrntlydoing"]').after(" <h6 name='error_msg_crrntlydoing' class='mt-2 custom_error'>Please Enter Current Pursuing.</h6>");
    jQuery('.CustomMultiStepFormSec select[name="crrntlydoing"]').css('border-color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_crrntlydoing"]').css('color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_crrntlydoing"]').slice(1).remove();
    errorSet = 1;
  }
  if(formDataArr.strmofedu == "") { 
    jQuery('.CustomMultiStepFormSec select[name="strmofedu"]').after(" <h6 name='error_msg_strmofedu' class='mt-2 custom_error'>Please Enter Stream of Education.</h6>");
    jQuery('.CustomMultiStepFormSec select[name="strmofedu"]').css('border-color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_strmofedu"]').css('color', 'red');
    jQuery('.CustomMultiStepFormSec h6[name="error_msg_strmofedu"]').slice(1).remove();
    errorSet = 1;
  }   


  if(errorSet == 0){
    $.ajax({
      url : '/india/step_two_form_submit_code',
      type: 'POST',
      dataType: "json",
      data: {results: formdata},
      beforeSend: function(){
        $('.CustomMultiStepFormSec .custom-step-two-form .loader-div').append('<p><span><i class="fa fa-spinner fa-spin"></i> Please Wait...</span></p>');
      },
      success: function(response) {
        if(response.data){
          $('.CustomMultiStepFormSec .custom-step-two-form .loader-div').empty();
          $(".CustomMultiStepFormSec .custom-step-two-form").hide();
          $(".CustomMultiStepFormSec .custom-step-three-form").show();
          $(".CustomMultiStepFormSec .custom-step-three-form .custom-step-three-output").append(response.threeStepOutput);
        }
      }
    });
  }

});
///////////////////////////////////
// step Two form submit code End //
///////////////////////////////////






/////////////////////////////////////
// Homepage Jquery code start here //
/////////////////////////////////////
jQuery(document).ajaxComplete(function(){
if($('.welcome-user').is(':visible')){
    $("#first-form").addClass("homepageformhide");
    $("#fourth-form").removeClass("homepageformhide");
  } 
});  

jQuery( ".register_otp_check_hp_new" ).click(function( event ) {
  event.preventDefault();
  $('.ErrorClassmobile').empty();
  jQuery(".Changnumbrcls").empty();
  // alert('hello');
  //$('.CustomMultiStepFormSec .custom-step-Two-form :button[type="submit"]').prop('disabled', true);
 
  const data = $('input[name="enqry_crsspndnc_mbl_new"]').val();
  //alert(data);
  var errorSet = 0;
 
  var pattern=/^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[6789]\d{9}$/; 
  //var values_mobile = $(this).val();
    if(!pattern.test(data)) { 

     if (data == ''){ 
      $('.ErrorClassmobile').append('Field can not be empty');
       errorSet = 1;
     }
     else{
      $('.ErrorClassmobile').append('Enter Correct Mobile No.');
       errorSet = 1;
     }
    } 
        

  var formdata = JSON.stringify(data, null, 2);
  //alert(formdata);
  if(errorSet == 0){
  $.ajax({
    url : '/india/homepageleadformfirststep',
    type: 'POST',
    dataType: "json",
    data: {results: formdata},
    success: function(response) {
      if(response.data){
        jQuery("#third-form").removeClass("homepageformhide");
        jQuery("#first-form").addClass("homepageformhide");
        jQuery(".Changnumbrcls").append(response.data + '<span class="Changnumbrclstxt">Change no.<span>');
      }
    }
  });
}
});




jQuery( ".btn-main-hpg-nwjs" ).click(function( event ) {
  event.preventDefault();
  $('.ErrorClassname').empty();
  $('.ErrorClassemail').empty();
  // alert('hello');
  //$('.CustomMultiStepFormSec .custom-step-Two-form :button[type="submit"]').prop('disabled', true);

  const data = $('input[name="enqry_f_nm_new"]').val();
  const data1 = $('input[name="enqry_crsspndnc_eml_new"]').val();
  const data2 = $('input[name="enqry_crsspndnc_mbl_new"]').val();
  //alert(data2);
   
   var errorSet = 0;
   if (data == ''){ 
    $('.ErrorClassname').append('Name Field can not be empty');
    errorSet = 1;
   }

   var pattern=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; 
  //var values_mobile = $(this).val();
    if(!pattern.test(data1)) { 

     if (data1 == ''){ 
      $('.ErrorClassemail').append('Email Field can not be empty');
      errorSet = 1;
     }
     else{
      $('.ErrorClassemail').append('Enter Correct email');
      errorSet = 1;
     }
    }  
   

  var formdata = JSON.stringify(data, null, 2);
  var formdata1 = JSON.stringify(data1, null, 2);
  var formdata2 = JSON.stringify(data2, null, 2);
  //alert(formdata);
  if(errorSet == 0){
  $.ajax({
    url : '/india/homepageleadformsecondstep',
    type: 'POST',
    dataType: "json",
    data: {results: formdata, results1: formdata1, results2: formdata2},
    beforeSend: function(){
        $('.loader-div-third').append('<p><span><i class="fa fa-spinner fa-spin"></i> Please Wait...</span></p>');
    },
    success: function(response) {
      if(response.msg){
        jQuery('.ErrorClassemail').append('Already Registered user <b><a class="ErrorClasssignin" href="/india/moLogin">  Sign In</a></b>');
        $('.loader-div-third').empty();
      }
      if(response.data){
        if(response.data1){
        //alert(response.data);
        jQuery("#fourth-form").removeClass("homepageformhide");
        jQuery("#third-form").addClass("homepageformhide");
        $('.loader-div-third').empty();
        //alert(response.data1);
       }
      }
    }
  });
 }
});


jQuery( ".btn-main-hpg-course-nwjs" ).click(function( event ) {
  event.preventDefault();
  $('.fourthsteperror').empty();
  // alert('hello');
  //$('.CustomMultiStepFormSec .custom-step-Two-form :button[type="submit"]').prop('disabled', true);

  const data = $('select[name="user_course_new"]').find(":selected").val();
  const data1 = $('input[name="enqry_f_nm_new"]').val();
  const data2 = $('input[name="enqry_crsspndnc_eml_new"]').val();
  const data4 = $('input[name="enqry_crsspndnc_mbl_new"]').val();
  const data5 = $('input[name="enqry_whatsapp_checkbox"]').val();
  //alert(data);
   
  var errorSet = 0;
   if (data == ''){ 
    $('.fourthsteperror').append('Select a Program');
    errorSet = 1;
   }

        

  var formdata = JSON.stringify(data, null, 2);
  var formdata1 = JSON.stringify(data1, null, 2);
  var formdata2 = JSON.stringify(data2, null, 2)
  var formdata4 = JSON.stringify(data4, null, 2);
  var formdata5 = JSON.stringify(data5, null, 2);
  //alert(formdata);
  if(errorSet == 0){
   $.ajax({
    url : '/india/homepageleadformfnctnthird',
    type: 'POST',
    dataType: "json",
    data: {results: formdata, results1: formdata1, results2: formdata2, results4: formdata4, results5: formdata5},
    beforeSend: function(){
        $('.loader-div-fourth').append('<p><span><i class="fa fa-spinner fa-spin"></i> Please Wait...</span></p>');
    },
    success: function(response) {
      if(response.data){
        jQuery("#fourth-form").addClass("homepageformhide");
        jQuery("#fifth-form").removeClass("homepageformhide");
        jQuery("#fourth-form").hide();
        jQuery(".fifth_step_name").append('Good Choice ' + response.name);
        jQuery(".fifth_step_coursename").append(response.coursename);
        jQuery('.loader-div-fourth').empty();
        if(response.item0){
        jQuery(".fifth-form-first-li-h5").append(response.item0);
        }
        else{
          jQuery(".fifth-form-first-li").hide();
        }
        if(response.item1){
        jQuery(".fifth-form-second-li-h5").append(response.item1);
        }
        else{
          jQuery(".fifth-form-second-li").hide();
        }
        if(response.item2){
        jQuery(".fifth-form-third-li-h5").append(response.item2);
        }
        else{
          jQuery(".fifth-form-third-li").hide();
        }
        jQuery(".fifth-form-href a").prop("href", response.path);
      } 
    }
  });
 }
});


////////////////////////////////////
// Homepage Jquery code ends here //
////////////////////////////////////