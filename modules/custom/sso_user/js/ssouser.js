jQuery(document).ready(function(){
	
  jQuery('.upComingSliderEvent .prev').click(function(){ 
    var prependList = function() {
      if( jQuery('.upComingSliderEvent .card').hasClass('activeNow') ) {
        var lastCard = jQuery(".card-list .card").length - 1;
        var $slicedCard = jQuery('.upComingSliderEvent .card').slice(lastCard).removeClass('transformThis activeNow');
        jQuery('.upComingSliderEvent ul.card-list').prepend($slicedCard);
      }
    }
    jQuery('.upComingSliderEvent ul.card-list li').last().removeClass('transformPrev').addClass('transformThis').prev().addClass('activeNow');
    setTimeout(function(){prependList(); }, 150);
  });

  jQuery('.upComingSliderEvent .next').click(function() {
    var appendToList = function() {
      if( jQuery('.upComingSliderEvent .card').hasClass('activeNow') ) {
        var $slicedCard = jQuery('.upComingSliderEvent .card').slice(0, 1).addClass('transformPrev');
        jQuery('.upComingSliderEvent ul.card-list').append($slicedCard);
      }}
    
        jQuery('.upComingSliderEvent ul.card-list li').removeClass('transformPrev').last().addClass('activeNow').prevAll().removeClass('activeNow');
    setTimeout(function(){appendToList();}, 150);
  });

  if(jQuery("#fb_twitter_widget").is(":visible")){
    setTimeout(function(){ 
     jQuery.ajax({
      url : '/india/fbtwwidget',
      type: 'POST',
      success: function(response) {
        if(response){
          jQuery("#fb_twitter_widget").replaceWith(response);
        }
      }
     });
    }, 12000);
  }

  if(jQuery("#testimonial_video").is(":visible")){
    var node_id = jQuery('#testimonial_video').attr('nid');
    jQuery.ajax({
      url : '/india/testimonil-video/'+node_id,
      type: 'POST',
      success: function(response) {
        console.log(response);
        if(response.data){
          jQuery("#testimonial_video").replaceWith('<div id="testimonial_video">'+response.data+'</div>');
        }
      }
    });  
  }
  
  if(jQuery("#updowncote").is(":visible")){
    var node_id = jQuery('#updowncote').attr('nid');
    jQuery.ajax({
      url : '/india/article_per_user_vote/'+node_id,
      type: 'POST',
      success: function(response) {
        console.log(response);
        jQuery("#updowncote").replaceWith('');
        if(response == 1){
          jQuery('.up-btn').addClass('disabled');
          jQuery('.up-btn').prop('disabled', true);
        }
        else if(response == 2){
          jQuery('.down-btn').addClass("disabled");
          jQuery('.down-btn').prop('disabled', true);
        }
      }
    });  
  }

  var myapplication_check = localStorage.getItem('myapplication');
  if(myapplication_check == 1){
    jQuery('#myapplication_menu').css('display', 'block');
  }
  else{
    jQuery('#myapplication_menu').css('display', 'none');
  }

  if(jQuery("#user_application_myModal #myapplication-data").text() == 'Application'){ 
    var myapplication = localStorage.getItem('myapplication');
    if(myapplication != 1){
      jQuery.ajax({
        url : '/india/myapplication-popup',
        type: 'POST',
        success: function(response) {
          console.log(response);
          if(response.display == 1){
            var output = response.data;
            jQuery('#myapplication_menu').css('display', 'block');
            jQuery("#user_application_myModal .modal-header h4.modal-title").css('display', 'block');
            jQuery("#user_application_myModal .modal-header .modalSubTitle").css('display', 'block');
            jQuery("#myapplication-data").replaceWith('<div id="myapplication-data">'+output+'</div>');
            jQuery('#user_application_myModal').modal('show');
            localStorage.setItem('myapplication', '1');
            
          }
          else{
            jQuery("#user_application_myModal .modal-header h4.modal-title").css('display', 'none');
            jQuery("#user_application_myModal .modal-header .modalSubTitle").css('display', 'none');
            jQuery("#myapplication-data").replaceWith('<div id="myapplication-data">No Pending Application</div>');
            jQuery('#myapplication_menu').css('display', 'none');
          }
        }
      });
    } 
  }

  jQuery(document).on("click","#change-emailotp",function() {
    jQuery('.regsiter-first-block').css('display', 'block');
    jQuery('.reg-second-step').css('display', 'none');
    jQuery('#otp-send-msg').text('');
  });


  jQuery(document).on("click","#current-app-user",function() {
    jQuery('.loading-modal').css('display', 'block');
    jQuery.ajax({
      url : '/india/myapplication-popup',
      type: 'POST',
      success: function(response) {
        console.log(response);
        if(response.display == 1){
          var output = response.data;
          jQuery("#user_application_myModal .modal-header h4.modal-title").css('display', 'block');
          jQuery("#user_application_myModal .modal-header .modalSubTitle").css('display', 'block');
          jQuery("#myapplication-data").replaceWith('<div id="myapplication-data">'+output+'</div>');
          jQuery('#user_application_myModal').modal('show');
        }
        else{
          jQuery("#user_application_myModal .modal-header h4.modal-title").css('display', 'none');
          jQuery("#user_application_myModal .modal-header .modalSubTitle").css('display', 'none');
          jQuery("#myapplication-data").replaceWith('<div id="myapplication-data">No Pending Application</div>');
        }
        jQuery('.loading-modal').css('display', 'none');
      }
    });    
  });

  jQuery(document).on("click",".up-btn",function() {
    jQuery(this).addClass('disabled');
    jQuery(this).prop('disabled', true);
    jQuery('.down-btn').removeClass("disabled");
    jQuery('.down-btn').prop('disabled', false);
    var feedback = 1;
    var node_id = jQuery(this).attr("nid");
    jQuery.ajax({
      url : '/india/updownvote/'+node_id+'/'+feedback,
      type: 'POST',
      data: {node_id: node_id, feedback : feedback },
      success: function(response) {
        // Data Layer Push
        kc_article_up_down_vote_datalayer('Up vote');
      }
    });    
  });

  jQuery(document).on("click",".down-btn",function() {
    jQuery(this).addClass('disabled');
    jQuery(this).prop('disabled', true);
    jQuery('.up-btn').removeClass("disabled");
    jQuery('.up-btn').prop('disabled', false);
    var feedback = 0;
    var node_id = jQuery(this).attr("nid");
    jQuery.ajax({
      url : '/india/updownvote/'+node_id+'/'+feedback,
      type: 'POST',
      data: {node_id: node_id, feedback : feedback },
      success: function(response) {
        // Data Layer Push
        kc_article_up_down_vote_datalayer('Down vote');
      }
    });    
  });

   if(jQuery("#det-replace-web").is(":visible")){
    var node_id = jQuery('.web-details-display').attr('nid');
    jQuery.ajax({
      url : '/india/web-details-display/'+node_id,
      type: 'POST',
      success: function(response) {
        console.log(response);
        if(response.data){
         jQuery("#det-replace-web").replaceWith(response.data); console.log(response.mobile_display);
         if(response.mobile_display == 1){
           jQuery('.sso-user-joinwebinar-form .web-name').hide();
           jQuery('.sso-user-joinwebinar-form .web-mail').hide();
           jQuery('.sso-user-joinwebinar-form input[name="mobile_display"]').val(response.mobile_display);
         }
         else{
           jQuery('.sso-user-joinwebinar-form .web-name').show();
           jQuery('.sso-user-joinwebinar-form .web-mail').show();
           jQuery('.sso-user-joinwebinar-form input[name="mobile_display"]').val(response.mobile_display);
         }
         if(response.lead_cd){
           jQuery('.sso-user-joinwebinar-form input[name="enqry_f_nm"]').val(response.enqry_nm);
           jQuery('.sso-user-joinwebinar-form input[name="enqry_crsspndnc_eml"]').val(response.enqry_crsspndnc_eml);
           jQuery('.sso-user-joinwebinar-form input[name="enqry_crsspndnc_mbl"]').val(response.enqry_crsspndnc_mbl);
           jQuery('.sso-user-joinwebinar-form input[name="lead_cd"]').val(response.lead_cd);
           jQuery('.sso-user-joinwebinar-form input[name="lead_encrypt"]').val(response.lead_encrypt);

           jQuery('.sso-user-joinwebinar-form input[name="enqry_f_nm"]').attr('readonly', true);
           jQuery('.sso-user-joinwebinar-form input[name="enqry_crsspndnc_eml"]').attr('readonly', true);
           jQuery('.sso-user-joinwebinar-form input[name="enqry_crsspndnc_mbl"]').attr('readonly', true);
         }
         else{
          jQuery('.sso-user-joinwebinar-form input[name="enqry_f_nm"]').val('');
          jQuery('.sso-user-joinwebinar-form input[name="enqry_crsspndnc_eml"]').val('');
          jQuery('.sso-user-joinwebinar-form input[name="enqry_crsspndnc_mbl"]').val('');
          jQuery('.sso-user-joinwebinar-form input[name="lead_cd"]').val('');
          jQuery('.sso-user-joinwebinar-form input[name="lead_encrypt"]').val('');

          jQuery('.sso-user-joinwebinar-form input[name="enqry_f_nm"]').attr('readonly', false);
          jQuery('.sso-user-joinwebinar-form input[name="enqry_crsspndnc_eml"]').attr('readonly', false);
          jQuery('.sso-user-joinwebinar-form input[name="enqry_crsspndnc_mbl"]').attr('readonly', false);

         }
        }
      }
    }); 

   }

   if(jQuery('.sso-user-joinwebinar-form input[name="mobile_display"]').val() == 1){
     jQuery('.sso-user-joinwebinar-form .web-name').hide();
     jQuery('.sso-user-joinwebinar-form .web-mail').hide();
     jQuery('.sso-user-joinwebinar-form input[name="mobile_display"]').val('1');
   }
   else{
     jQuery('.sso-user-joinwebinar-form .web-name').show();
     jQuery('.sso-user-joinwebinar-form .web-mail').show();
     jQuery('.sso-user-joinwebinar-form input[name="mobile_display"]').val('0');
   }

  jQuery(document).on("click","#leadencrypt_joinwebniar",function() {
    var node_id = jQuery(this).attr('node_id');
    var lead_encrypt = jQuery(this).attr('lead_encrypt');
    var lead_cd = jQuery(this).attr('lead_cd');
    jQuery.ajax({
      url : '/india/leadencrypt-joinWebnier',
      type: 'POST',
      data: {node_id: node_id, lead_encrypt : lead_encrypt, lead_cd : lead_cd },
      success: function(response) {
         //jQuery(".ajax-response").replaceWith('<div class="ajax-response alert alert-success">Thank You</div>');
      }
    });     
    var startdata = jQuery('.auto_js_refresh_web').attr('startdata');
    var enddata = jQuery('.auto_js_refresh_web').attr('enddata');
    var category = jQuery('.auto_js_refresh_web').attr('category');
    var currentdata = Math.floor(new Date().getTime()/1000) - 12600;  console.log(currentdata);
    if(category == 'recorded'){
      jQuery(".ajax-response").replaceWith('<div class="ajax-response alert alert-success">Thank you, you will be redirected to the programme in a separate tab (Allow pop-up if not redirected automatically)</div>'); 
    	var href = jQuery('#web_link_redirect').attr('href');
      window.open(href);
    }
    else{
    	if(startdata <= currentdata && currentdata <= enddata){
	      jQuery(".ajax-response").replaceWith('<div class="ajax-response alert alert-success">Thank you, you will be redirected to the webinar in a separate tab (Allow pop-up if not redirected automatically)</div>'); 
	      var href = jQuery('#web_link_redirect').attr('href');
	      window.open(href);
	    }
	    else{
	      jQuery(".ajax-response").replaceWith('<div class="ajax-response alert alert-success">Thank you, you have successfully registered for the webinar</div>'); 
	    }   
    }
     
  });




  jQuery(document).on("click","#login-user-webinar",function() {
    var node_id = jQuery(this).attr('node_id');
    jQuery.ajax({
      url : '/india/currentuser-joinwebnier',
      type: 'POST',
      data: {node_id: node_id },
      success: function(response) {
         //jQuery(".ajax-response").replaceWith('<div class="ajax-response alert alert-success">Thank You</div>');
      }
    });     
    var startdata = jQuery('.auto_js_refresh_web').attr('startdata');
    var enddata = jQuery('.auto_js_refresh_web').attr('enddata');
    var category = jQuery('.auto_js_refresh_web').attr('category');
    var currentdata = Math.floor(new Date().getTime()/1000) - 12600;  console.log(currentdata);
    if(category == 'recorded'){
      jQuery(".ajax-response").replaceWith('<div class="ajax-response alert alert-success">Thank you, you will be redirected to the programme in a separate tab (Allow pop-up if not redirected automatically)</div>'); 
      var href = jQuery('#web_link_redirect').attr('href');
      window.open(href);
    }
    else{
	    if(startdata <= currentdata && currentdata <= enddata){
	      jQuery(".ajax-response").replaceWith('<div class="ajax-response alert alert-success">Thank you, you will be redirected to the webinar in a separate tab (Allow pop-up if not redirected automatically)</div>'); 
	      var href = jQuery('#web_link_redirect').attr('href');
	      window.open(href);
	    }
	    else{
	      jQuery(".ajax-response").replaceWith('<div class="ajax-response alert alert-success">Thank you, you have successfully registered for the webinar</div>'); 
	    }
	}    
  });

  jQuery('.sso-user-register-form .user-term-policy input').on('click', function(){
    if (jQuery(this).is(':checked') && jQuery('input[name="mob_reg"]').val() == 1 ) {
      jQuery(this).parents('.sso-user-register-form').find('.register-sub input').prop('disabled',false);                
    } else {
        jQuery(this).parents('.sso-user-register-form').find('.register-sub input').prop('disabled',true);                
    }
  });

  if (jQuery('.sso-user-register-form .user-term-policy input').is(':checked') && jQuery('.sso-user-register-form input[name="mob_reg"]').val() == 1 ) {
    jQuery('.sso-user-register-form .register-sub input').prop('disabled',false);               
  } else {
    jQuery('.sso-user-register-form .register-sub input').prop('disabled',true);               
  }

  jQuery('.forgot_password_modal_form').on('click', function(){
      jQuery('.user-form-modal.in').modal('toggle');
      jQuery('#forgot_password_modal_form').modal('toggle');
  });

  jQuery(document).on("click",'.back-to-login',function() {
      jQuery('#forgot_password_modal_form').modal('toggle');
      jQuery('#user_account_modal_form').modal('toggle');
  });

  jQuery('.sso-user-assessemt-form .submit-web-btn input').click(function(){
    var name = email = mobile = other = 1;
    if(jQuery(this).parents('form').find('input[name="enqry_f_nm"]').val() == ''){
      name = 0;
    }
    if(jQuery(this).parents('form').find('input[name="enqry_crsspndnc_city"]').val() == ''){
      other = 0;
    }
    if(jQuery(this).parents('form').find('input[name="crrntlydoing"]').val() == ''){
      other = 0;
    }
    if(jQuery(this).parents('form').find('select[name="strmofedu"]').val() == ''){
      other = 0;
    }
    if(jQuery(this).parents('form').find('select[name="enqry_crsspndnc_mbl"]').val() == ''){
      mobile = 0;
    }
    else{
      var mobileval = jQuery(this).parents('form').find('input[name="enqry_crsspndnc_mbl"]').val();
      if(jQuery(this).parents('form').find('input[name="countrycode"]').val() == '+91' && mobileval.length != 10){
        mobile = 0;
      }

      if(jQuery(this).parents('form').find('input[name="countrycode"]').val() != '+91' && mobileval.length > 12){
        mobile = 0;
      }
    }

    if(jQuery(this).parents('form').find('input[name="enqry_crsspndnc_eml"]').val() == ''){
      email = 0;
    }
    else{
      var emailid = jQuery(this).parents('form').find('input[name="enqry_crsspndnc_eml"]').val();
      var newemail = emailid.replace(/\s+/g,'');
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if(regex.test(newemail) ){
        jQuery.ajax({
            url : '/india/check-email',
            type: 'POST',
            async: false,
            data: { newemail: newemail},
            success: function(response) {  
              if(response.data == 1){ 
                  email = 1;
                  if(name == 1 && email == 1 && mobile == 1 && other == 1){
                    var _popup = '';
                    _popup = window.open('', 'TheWindow', "width=1280, height=720, left=100, top=50, resizable=yes, scrollbars=yes, modal=yes, alwaysRaised=yes");
                    _popup.document.write(GetProcessingHtml());
                  }
              }
              else{
                  email = 0;
              } 
            }
        });
      }
      else{
        email = 0;
      }
    }

  });

  jQuery('.hide-password').on('click', function(){
    var password_field = jQuery(this).parents('.password-field-custom').find('input').attr('type');
    var textname = jQuery(this).html();

    if(password_field == 'password'){
      jQuery(this).parents('.password-field-custom').find('input').attr('type', 'text');
    }
    else{
      jQuery(this).parents('.password-field-custom').find('input').attr('type', 'password');
    }

    if(textname == '<i class="fa fa-eye-slash" aria-hidden="true"></i>'){
      jQuery(this).html('<i class="fa fa-eye" aria-hidden="true"></i>');
    }
    else{
      jQuery(this).html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
    }
  });

  jQuery(document).on("click",".register_otp-check",function() {
    jQuery(this).parents('form').find('.otp-loader').addClass('please-wait-display');
    jQuery(this).parents('form').find('.regotp_msg').css('display', 'none');
    jQuery(this).parents('form').find('.otp-register .form-item-registerotp input').val('');
    jQuery('.otp-register .form-item-registerotp input').removeClass('border-error');
    jQuery('.sso-user-register-form .otp-register').css('display', 'none');
    jQuery('.your-otp-error').text('');
    var country_code = jQuery(this).parents('form').find('.country-code .form-item-countrycode input').val();
    var mobile = jQuery(this).parents('form').find('.form-item-mobileno input.mobile-numbr').val();
    var email =  jQuery(this).parents('form').find('.form-item-email input').val();
    var emailcheck = 0;
    if(jQuery(this).parents('form').find('.form-item-your-name input').val() == ''){
      jQuery('.form-item-your-name input').addClass('border-error');
      jQuery('.your-name-error').text('Field can not be empty');
    }
    else{
      var namestr = jQuery(this).parents('form').find('.form-item-your-name input').val();
      var str = /^[A-Za-z ]+$/;
      if(str.test(namestr) ){
        jQuery('.form-item-your-name input').removeClass('border-error');
        jQuery('.your-name-error').text('');
      }
      else{
        jQuery('.form-item-your-name input').addClass('border-error');
        jQuery('.your-name-error').text('Invalid Name');
      }
    }
    if(jQuery(this).parents('form').find('.form-item-email input').val() == ''){
      jQuery('.form-item-email input').addClass('border-error');
      jQuery('.your-email-error').text('Field can not be empty');
    }
    else{
       var newemail = email.replace(/\s+/g,'');
       var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
       if(regex.test(newemail) ){
        jQuery('.form-item-email input').removeClass('border-error');
        jQuery('.your-email-error').text('');
        emailcheck = 1;
       }
       else{
        jQuery('.form-item-email input').addClass('border-error');
        jQuery('.your-email-error').text('Invalid Email');
       }
    }
    if(jQuery(this).parents('form').find('.form-item-mobileno input.mobile-numbr').val() == ''){
      jQuery('.form-item-mobileno input.mobile-numbr').addClass('border-error');
      jQuery('.your-mobile-error').text('Field can not be empty');
    }
    else{
      jQuery('.form-item-mobileno input.mobile-numbr').removeClass('border-error');
      jQuery('.your-mobile-error').text('');
    }
    /************************************/
    var enableEmailOTP_Check = 0;
    if(jQuery(this).parents('form').attr('class') == 'stackathon-lead-form-id'){
      enableEmailOTP_Check = jQuery('form.stackathon-lead-form-id input.EnableEmailOTP_Check').val();
    }
    /************************************/
    if(mobile != ''  && emailcheck == 1){
      if( ((mobile.length == 10 && country_code == '+91') || (country_code != '+91' && mobile.length > 5 && mobile.length < 13) )){
        var textcheck = jQuery(this).parents('form').find('#country-code-updator .register_otp-check').text();
        var register = 1;
        if(country_code == '+91'){
          register = 2;
          var msg = 'We have sent you 6 digit OTP on '+mobile+' & '+email+'. OTP will be valid for 5 minutes';
          if(textcheck == 'Resend'){
            var msg = 'We have sent you 6 digit OTP on '+mobile+' & '+email+'. OTP will be valid for 5 minutes';
          }
        }else{
          var msg = 'We have sent you 6 digit OTP on '+email+'. OTP will be valid for 5 minutes';
          if(textcheck == 'Resend'){
            var msg = 'We have resent you 6 digit OTP on '+email+'. OTP will be valid for 5 minutes';
          }
        }
        if(enableEmailOTP_Check == 1){
          var msg = 'We have sent you 6 digit OTP on '+email+'. OTP will be valid for 5 minutes';
          if(textcheck == 'Resend'){
            var msg = 'We have resent you 6 digit OTP on '+email+'. OTP will be valid for 5 minutes';
          }
        }
        var name = '';
        jQuery.ajax({
            url : '/india/eligible_mobile_otp',
            type: 'POST',
            data: {mobile: mobile, email: email, name: name, register: register, enableEmailOTP_Check: enableEmailOTP_Check},
            success: function(response) {  
                if(response.data == 1){ 
                    jQuery('.sso-user-register-form .regotp_msg').css('display', 'block');
                    jQuery('.form-item-mobileno input.mobile-numbr').removeClass('border-error');
                    jQuery('.sso-user-register-form .register_otp-check span').text('Resend');
                    jQuery('.sso-user-register-form .regotp_msg').replaceWith('<div class="col-md-12 regotp_msg"><p>'+msg+'</p></div>');
                    jQuery('.sso-user-register-form .otp-register').css('display', 'block');
                    jQuery('.sso-user-register-form .form-item-email input').removeClass('border-error');
                    jQuery('.your-mobile-error').text('');
                }
                else{
                    jQuery('.sso-user-register-form .otp-register').css('display', 'none');
                    jQuery('.form-item-mobileno input.mobile-numbr').focus();
                    jQuery('.form-item-mobileno input.mobile-numbr').addClass('border-error');
                    jQuery('.your-mobile-error').text('Invalid Number');
                } 
                jQuery('.sso-user-register-form .otp-loader').removeClass('please-wait-display');
            }
        });
      }
      else{
          jQuery('.form-item-mobileno input.mobile-numbr').addClass('border-error');
          jQuery('.your-mobile-error').text('Invalid Number');
          jQuery(this).parents('form').find('.otp-register').css('display', 'none');
          jQuery(this).parents('form').find('.otp-loader').removeClass('please-wait-display');
      }
    }
    else{
      jQuery(this).parents('form').find('.otp-register').css('display', 'none');
      jQuery(this).parents('form').find('.otp-loader').removeClass('please-wait-display');
    }

  });

  jQuery(document).on("click",".verify-register-otp",function() {
    jQuery(this).parents('form').find('.verify-loader').addClass('please-wait-display');
    var mobile = jQuery(this).parents('form').find('.form-item-mobileno input.mobile-numbr').val();
    var otpstring = jQuery(this).parents('form').find('.otp-register .form-item-registerotp input').val();
    var otp = otpstring.replace(/\s+/g,'');
    var email =  jQuery(this).parents('form').find('.form-item-email input').val();
    if(otp != ''){
      if(otp.length == 6){
        var name = '';
        jQuery.ajax({
            url : '/india/eligible_mobile_otp_verify',
            type: 'POST',
            data: {otp: otp, mobile: mobile, email: email, name: name},
            success: function(response) {  console.log(response);
                if(response.data == 1){
                    jQuery('.sso-user-register-form .form-item-mobileno input.mobile-numbr').prop('readonly', true);
                    jQuery('.sso-user-register-form .form-item-country select').prop('disabled', 'disabled');
                    jQuery('.sso-user-register-form .otp-register').css('display', 'none');
                    jQuery('.sso-user-register-form .register_otp-check').replaceWith('<div class="otp-reg-verify"><span>Verified</span></div>');
                    jQuery('.sso-user-register-form input[name="mob_reg"]').val('1');
                    if(jQuery('.stackathon-lead-form-id').is(':visible')){
                      jQuery('.sso-user-register-form input[name="email_reg"]').val('1');
                    }
                    jQuery('.sso-user-register-form .regotp_msg').text('');
                    jQuery('.your-otp-error').text('');
                    if (jQuery('.sso-user-register-form .user-term-policy input').is(':checked')) {
                        jQuery('.sso-user-register-form .register-sub .subscription-submit').prop('disabled',false);                
                    } else {
                        jQuery('.sso-user-register-form .register-sub .subscription-submit').prop('disabled',true);                
                    }
                }
                else if(response.data == 2){
                  jQuery('.your-otp-error').text('OTP Expired');
                  jQuery('.sso-user-register-form .otp-register .form-item-registerotp input').addClass('border-error');
                  jQuery('.sso-user-register-form input[name="mob_reg"]').val('0');
                  if(jQuery('.stackathon-lead-form-id').is(':visible')){
                    jQuery('.sso-user-register-form input[name="email_reg"]').val('0');
                  }
                }
                else{
                    jQuery('.your-otp-error').text('Invalid OTP');
                    jQuery('.sso-user-register-form .otp-register .form-item-registerotp input').addClass('border-error');
                    jQuery('.sso-user-register-form input[name="mob_reg"]').val('0');
                    if(jQuery('.stackathon-lead-form-id').is(':visible')){
                      jQuery('.sso-user-register-form input[name="email_reg"]').val('0');
                    }
                }
                jQuery('.sso-user-register-form .verify-loader').removeClass('please-wait-display');
            }
        });
      }
      else{
         jQuery(this).parents('form').find('.otp-register .form-item-registerotp input').focus(); 
         jQuery('.your-otp-error').text('Wrong OTP');
         jQuery(this).parents('form').find('.otp-register .form-item-registerotp input').addClass('border-error');
         jQuery(this).parents('form').find('input[name="mob_reg"]').val('0');
         if(jQuery('.stackathon-lead-form-id').is(':visible')){
            jQuery('.sso-user-register-form input[name="email_reg"]').val('0');
          }
         jQuery(this).parents('form').find('.verify-loader').removeClass('please-wait-display');
      }
    }
    else{
      jQuery(this).parents('form').find('.otp-register .form-item-registerotp input').focus(); 
      jQuery('.your-otp-error').text('Field can not be empty');
      jQuery(this).parents('form').find('.otp-register .form-item-registerotp input').addClass('border-error');
      jQuery(this).parents('form').find('input[name="mob_reg"]').val('0');
      if(jQuery('.stackathon-lead-form-id').is(':visible')){
        jQuery('.sso-user-register-form input[name="email_reg"]').val('0');
      }
      jQuery(this).parents('form').find('.verify-loader').removeClass('please-wait-display');
    }
    
  });


  jQuery('.register_otp_check_hp').click(function(){
   
    var mobile = jQuery('.enqry_crsspndnc_mbl').val();
    var country_code = "+91";
    var enableEmailOTP_Check = 1;


    if(mobile != ''){
      if( mobile.length == 10 && country_code == '+91'){
        var register = 1;
        
        jQuery.ajax({
            url : '/india/eligible_mobile_otp',
            type: 'POST',
            data: {mobile: mobile, register: register, enableEmailOTP_Check: enableEmailOTP_Check},
            success: function(response) {  
                if(response.data == 1){ 
                    console.log(mobile);
                }
                else{
                    //jQuery('.your-mobile-error').text('Invalid Numberr');
                    console.log("Error");
                } 
                jQuery('.sso-user-register-form .otp-loader').removeClass('please-wait-display');
            }
        });
      }
    }
    
   // console.log(country_code); 
    
    

  });

  jQuery('.verify-register-otp-hp').click(function(){
    //jQuery(this).parents('form').find('.verify-loader').addClass('please-wait-display');
    //console.log('Hi');
    var mobile = jQuery('.enqry_crsspndnc_mbl').val();
    var otpstring = jQuery('.registerotp-val').val();
    var otp = otpstring.replace(/\s+/g,'');
    
    

    //var email =  jQuery(this).parents('form').find('.form-item-email input').val();
    if(otp != ''){
      if(otp.length == 6){
        var name = '';
        jQuery.ajax({
            url : '/india/eligible_mobile_otp_verify',
            type: 'POST',
            data: {otp: otp, mobile: mobile, name: name},
            success: function(response) {  //console.log(response);
                if(response.data == 1){                  
                    //jQuery('.otp_check_status_hp').val('newVal');
                    //console.log(mobile);
                    $("#second-form").addClass("homepageformhide");
                    $("#third-form").removeClass("homepageformhide");

                }
                else if(response.data == 2){
                  jQuery(".otp_verification_hp").text("OTP Expired");
                }
                else{
                    jQuery(".otp_verification_hp").text("Enter a valid OTP");
                }
                jQuery('.sso-user-register-form .verify-loader').removeClass('please-wait-display');
            }
        });
      }
      else{
         jQuery(".otp_verification_hp").text("Enter a valid OTP");
         //console.log("otpgtebrt");
      }
    }
    else{
      //console.log("otpsss");
         jQuery(".otp_verification_hp").text("Enter a valid OTP");
      }
    
  });




});








jQuery(document).ajaxComplete(function(){

  jQuery('#exampleSlider111-0').multislider({
      interval:false,
      slideAll:false,
      autoSlide: false,
  });

  var myapplication_check = localStorage.getItem('myapplication');
  if(myapplication_check == 1){
    jQuery('#myapplication_menu').css('display', 'block');
  }
  else{
    jQuery('#myapplication_menu').css('display', 'none');
  }

  if(jQuery('.sso-user-joinwebinar-form input[name="mobile_display"]').val() == 1){
     jQuery('.sso-user-joinwebinar-form .web-name').hide();
     jQuery('.sso-user-joinwebinar-form .web-mail').hide();
     jQuery('.sso-user-joinwebinar-form input[name="mobile_display"]').val('1');
   }
   else{
     jQuery('.sso-user-joinwebinar-form .web-name').show();
     jQuery('.sso-user-joinwebinar-form .web-mail').show();
     jQuery('.sso-user-joinwebinar-form input[name="mobile_display"]').val('0');
   }

  if (jQuery('.sso-user-register-form .user-term-policy input').is(':checked') && jQuery('.sso-user-register-form input[name="mob_reg"]').val() == 1 ) {
    jQuery('.sso-user-register-form .register-sub input').prop('disabled',false);               
  } else {
    jQuery('.sso-user-register-form .register-sub input').prop('disabled',true);               
  }

  jQuery(".btn-main-hpg-course").click(function(){
   if (jQuery('select[name="user_course_new"]').val() == '')
    if(!jQuery(".fourthsteperror").html()){
    {
     //alert ("hello");
     jQuery( ".fourthsteperror" ).append( "Field can not be empty" );
     }
   }
  });

  jQuery(".Changnumbrclstxt").click(function() {
  jQuery("#third-form").addClass("homepageformhide");
  jQuery("#first-form").removeClass("homepageformhide");
   });
  
  if($('.enqry_crsspndnc_mbl_loggin').is(':visible')){
    jQuery("#first-form").addClass("homepageformhide");
    jQuery("#fourth-form").removeClass("homepageformhide");
  }  

});

(function($) {
  $.fn.myTest = function(data) {
      $('.user-form-modal.in').modal('toggle');
      $('.loading-modal').css('display', 'block');
      localStorage.removeItem('myapplication');
  };
  $.fn.customerlogin = function(dataval) {
    var data = JSON.parse(dataval);
    console.log(data);
    if($('input[name="pbatchId"]').val() == '0' || $('input[name="pbatchId"]').val() == ''){
      $('input[name="pCourseCode"]').val(data.courseCode);
      $('input[name="pModalId"]').val(data.batchType);
      $('input[name="pcollectionPlanId"]').val(data.patternCode);
      $('input[name="pbatchId"]').val(data.batchID);
      $('input[name="pSrcId"]').val(data.SRC_ICD);
      $('input[name="pDstId"]').val(data.DST_ICD);
      $('input[name="pBatchTimings"]').val(data.batchTimings);
      $('input[name="pBatchStartDate"]').val(data.batchStartDate);
      $('input[name="pBatchEndDate"]').val(data.batchEndDate);
      $('input[name="pFee"]').val(data.batchFees);
      $('input[name="CourseId"]').val(data.courseID);      
      $('input[name="bthcurrencyCode"]').val(data.currencyCode);
      $('input[name="bthSymbolType"]').val(data.SymbolType);
      $('input[name="bthSymbolValue"]').val(data.SymbolValue);
      $('input[name="Minimum_Denomination"]').val(data.Minimum_Denomination);
      $('input[name="Minimum_Denomination_Value"]').val(data.Minimum_Denomination_Value);
      $('input[name="IsTax_IncludeIN_Collection"]').val(data.IsTax_IncludeIN_Collection);
    }
    $('input#CustomerId_modular').val(data.CustomerID);    
  };
  $.fn.modularlogin = function(data) {
    console.log(data);
      $('.user-form-modal.in').modal('toggle');
      if(data){
        $('input#ecomtoken_modular').val(data);
      }
      else{
        location.reload();
      }
     
  };
  $.fn.assessmentTest = function(data) {
    console.log(data);
      if(data){
        jQuery(".ajax-response").replaceWith('<div class="ajax-response alert alert-success msg-response">Thank you, you will be redirected to the test in a separate window (Allow pop-up if not redirected automatically)</div>');
        $('.assess-div input#token_assess').val(data);
        document.getElementById('testaasest').submit();
         location.reload();
      }
      else{
        $('.loading-modal').css('display', 'block');
        location.reload();
      }
     
  };
})(jQuery);

(function($) {
  $.fn.closeModal = function(data) {
      setTimeout(
          function() {
              $('.user-form-modal.in').modal('toggle');
          },
          2000);
  };
})(jQuery);

(function($) {
  $.fn.webTest = function(data) {
    var startdata = jQuery('.auto_js_refresh_web').attr('startdata');
    var enddata = jQuery('.auto_js_refresh_web').attr('enddata');
    var category = jQuery('.auto_js_refresh_web').attr('category');
    var currentdata = Math.floor(new Date().getTime()/1000) - 12600;
    webniarFormEventAll("Continue");
    if(category == 'recorded'){
    	var href = jQuery('#web_link_redirect').attr('href');
        window.open(href);
    }
    else{
	    if(startdata <= currentdata && currentdata <= enddata){
	      var href = jQuery('#web_link_redirect').attr('href');
	      window.open(href);
	    } 
	}
  };
  $.fn.talkTest = function(data) {
    talktoourexpertFormEventAll("Continue");
  };
  $.fn.leadTest = function(data) {
    FormsubmitleadEventAll("Continue");
  };
  $.fn.assessentloginpoup = function(data) {
    LogInPopUpHeaderMsgUpdate('Hey! You already have an account. Sign in to continue your application', 'hide_signup');
  };
  $.fn.loginregister_modular = function(data) {
    loginregistermodularEvent(data);
  };
  $.fn.otpsectiondisplay = function(data) {
    $('.regsiter-first-block').css('display', 'none');
    $('.reg-second-step').css('display', 'block');
  };
})(jQuery);
  
// jQuery(document).ready(function($){
//     console.log(drupalSettings.path.baseUrl);   
// });

function leadtokencreate(uid, nid){
  if( nid != '' && uid != ''){
    jQuery('.loading-modal').css('display', 'block');
    jQuery.ajax({
      url : '/india/leadtokencreate',
      type: 'POST',
      data: {uid: uid, nid: nid},
      success: function(response) {  
        if(response.data){ 
          jQuery('.not_display_continue input#ecomtoken_modular').val(response.data);
          EnrollSubmitPreForm();
        }
        else{
          location.reload();
        }
      }
    });
  }
  else{
    location.reload();
  }
}

function GetProcessingHtml(){

    var tempHtml = '';
    tempHtml += '<html>';
    tempHtml += '<head>';
    tempHtml += '    <title></title>';
    tempHtml += '    <meta charset="utf-8">';
    tempHtml += '    <meta http-equiv="Content-type" content="text/html; charset=utf-8">';
    tempHtml += '    <meta name="viewport" content="width=device-width, initial-scale=1">';
    tempHtml += '    <style type="text/css">';
    tempHtml += '        body {';
    tempHtml += '            background-color: #f0f0f2;';
    tempHtml += '            margin: 0;';
    tempHtml += '            padding: 0;';
    tempHtml += '            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;';
    tempHtml += '        }';
    tempHtml += '        div {';
    tempHtml += '            width: 600px;';
    tempHtml += '            margin: 5em auto;';
    tempHtml += '            padding: 2em;';
    tempHtml += '            background-color: #fdfdff;';
    tempHtml += '            border-radius: 0.5em;';
    tempHtml += '            box-shadow: 2px 3px 7px 2px rgba(0,0,0,0.02);';
    tempHtml += '        }';
    tempHtml += '        a:link, a:visited {';
    tempHtml += '            color: #38488f;';
    tempHtml += '            text-decoration: none;';
    tempHtml += '        }';
    tempHtml += '        @media (max-width: 700px) {';
    tempHtml += '            div {';
    tempHtml += '                margin: 0 auto;';
    tempHtml += '                width: auto;';
    tempHtml += '            }';
    tempHtml += '        }';
    tempHtml += '    </style>';
    tempHtml += '</head>';
    tempHtml += '<body>';
    tempHtml += '    <div>';
    tempHtml += '        <h1>We are processing your request...</h1>';
    tempHtml += '        <p>Kindly be patient while we gather the required information before starting the test. </p>';
    tempHtml += '    </div>';
    tempHtml += '</body>';
    tempHtml += '</html>';

    return tempHtml;
}

function countiuneYourApplicationPageRedirectScript(){
  countiuneYourApplicationCountdown(5, 'pageBeginCountdownText').then(value => jQuery('.ContinueYourApplicationForm').submit());
}
function countiuneYourApplicationCountdown(timeleft, text) {
  return new Promise((resolve, reject) => {
    var countdownTimer = setInterval(() => {
      timeleft--;
      jQuery('.pageBeginCountdownText').empty();
      jQuery('.pageBeginCountdownText').text(timeleft);
      if (timeleft <= 1) {
        clearInterval(countdownTimer);
        resolve(true);
      }
    }, 1000);
  });
}


