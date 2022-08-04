 function onlyDouble(evt) {
    var val1;
    if (!(evt.keyCode == 46 || (evt.keyCode >= 48 && evt.keyCode <= 57)))
        return false;
    var parts = evt.srcElement.value.split('.');
    if (parts.length > 2)
        return false;
    if (evt.keyCode == 46)
        return (parts.length == 1);
    if (evt.keyCode != 46) {
        var currVal = String.fromCharCode(evt.keyCode);
        val1 = parseFloat(String(parts[0]) + String(currVal));
        if(parts.length==2)
            val1 = parseFloat(String(parts[0])+ "." + String(currVal));
    }

    if (val1 > 100)
        return false;
    if (parts.length == 2 && parts[1].length >= 2) return false;
}

function openloginpopup_script(id){
  if(jQuery('input#'+id+'openloginpopup').val() == 1){
    LogInPopUpHeaderMsgUpdate('Hey! You already have an account. Sign in to continue your application', 'hide_signup');
  }
}

function LogInPopUpHeaderMsgUpdate(header_msg, sign_up_btn){
  jQuery('#sso-user-login-form .modal-header h4.modal-title').empty();
  jQuery('#sso-user-login-form .modal-header h4.modal-title').html(header_msg);
  if(sign_up_btn == 'hide_signup'){
    jQuery('#sso-user-login-form .modal-header h4.modal-title').css('font-size', '15px');
    jQuery('#sso-user-login-form p.text-center.signin-pt-1').hide();
    jQuery('#sso-user-login-form .modalSubTitle').hide();
  }else{
    jQuery('#sso-user-login-form .modal-header h4.modal-title').css('font-size', '20px');
    jQuery('#sso-user-login-form p.text-center.signin-pt-1').show();
    jQuery('#sso-user-login-form .modalSubTitle').show();
  }
  jQuery('#user_account_modal_form').modal('show');
}

function register_popup_info(){
    jQuery('#user_account_modal_form #register').addClass('active');
    jQuery('#user_account_modal_form #login').removeClass('active');
    jQuery('#user_account_modal_form').modal('show');
}

jQuery(document).ready(function(){

    jQuery('.form-item-enqry-crsspndnc-city input').bind("cut copy paste",function(e) {
         e.preventDefault();
     });

    jQuery(".form-item-enqry-crsspndnc-city input").keypress(function(e){
         var keyCode = e.which;
 
        if ( keyCode != 8 && keyCode !=32 && (keyCode < 48 || (keyCode > 57 && keyCode < 65) || (keyCode > 90 && keyCode < 97) || (keyCode > 90 && keyCode < 97) || keyCode > 122 )) { 
          return false;
        }
    });
    jQuery('#user_account_modal_form').on('hidden.bs.modal', function () {
        var header_msg = 'Lets Get Started';
        jQuery('#sso-user-login-form .modal-header h4.modal-title').empty();
        jQuery('#sso-user-login-form .modal-header h4.modal-title').html(header_msg);
        jQuery('#sso-user-login-form .modal-header h4.modal-title').css('font-size', '20px');
        jQuery('#user_account_modal_form #register p.text-center.signin-pt-1 a').trigger('click');
        jQuery('#sso-user-login-form p.text-center.signin-pt-1').show();
    });

    jQuery('input[type="number"]').keypress(function(e) {
        var keyCode = (e.keyCode ? e.keyCode : e.which);
        if (keyCode != 8 && keyCode != 0 && keyCode < 48 || keyCode > 57){
            e.preventDefault();
        }
    });

    jQuery(document).on("click",".dis-otp-field",function() {
        jQuery(this).parents('form').find('.otp-loader').addClass('please-wait-display');
        jQuery(this).parents('form').find('.otp-send-msg').css('display', 'none');
        var mobile = jQuery(this).parents('form').find('.mob-otp-verify .form-item-enqry-crsspndnc-mbl input').val();
        if(mobile.length == 10){
            var textcheck = jQuery(this).parents('form').find('.mob-otp-verify .dis-otp-field').text();
            var msg = 'We have sent you a 6 digit OTP on '+mobile;
            if(textcheck == 'Resend'){
              var msg = 'We have resent you a 6 digit OTP on '+mobile;
            }
            var formclass = jQuery(this).parents('form').attr('class');
            var email = '';//jQuery(this).parents('form').find('.form-item-enqry-crsspndnc-eml input').val();
            var name = '';//jQuery(this).parents('form').find('.form-item-enqry-f-nm input').val();
            jQuery.ajax({
                url : '/india/eligible_mobile_otp',
                type: 'POST',
                data: {mobile: mobile, email: email, name: name},
                success: function(response) {  //console.log(formclass);
                    if(response.data == 1){ //console.log(response.data);
                        jQuery('.'+formclass+' .otp-send-msg').css('display', 'block');
                        jQuery('.'+formclass+' .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').removeClass('border-error');
                        jQuery('.'+formclass+' .mob-otp-verify .dis-otp-field').text('Resend');
                        jQuery('.'+formclass+' .otp-verify .otp-send-msg').replaceWith('<div class="otp-send-msg">'+msg+'</div>');
                        jQuery('.'+formclass+' .otp-verify').css('display', 'block');
                    }
                    else{
                        jQuery('.'+formclass+' .otp-verify').css('display', 'none');
                        jQuery('.'+formclass+' .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').focus();
                        jQuery('.'+formclass+' .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').addClass('border-error');
                    } 
                    jQuery('.'+formclass+' .otp-loader').removeClass('please-wait-display');
                }
            });
        }
        else{
            jQuery(this).parents('form').find('.mob-otp-verify .form-item-enqry-crsspndnc-mbl input').focus();
            jQuery(this).parents('form').find('.mob-otp-verify .form-item-enqry-crsspndnc-mbl input').addClass('border-error');
            jQuery(this).parents('form').find('.otp-verify').css('display', 'none');
            jQuery(this).parents('form').find('.otp-loader').removeClass('please-wait-display');
        }
    });

    jQuery(document).on("click",".check-otp-display",function() {
        jQuery(this).parents('form').find('.verify-loader').addClass('please-wait-display');
        var mobile = jQuery(this).parents('form').find('.mob-otp-verify .form-item-enqry-crsspndnc-mbl input').val();
        var otp = jQuery(this).parents('form').find('.otp-verify .form-item-varify-otp input').val();
        if(otp.length == 6){
            var formclass = jQuery(this).parents('form').attr('class');
            var email = '';//jQuery(this).parents('form').find('.form-item-enqry-crsspndnc-eml input').val();
            var name = '';//jQuery(this).parents('form').find('.form-item-enqry-f-nm input').val();
            jQuery.ajax({
                url : '/india/eligible_mobile_otp_verify',
                type: 'POST',
                data: {otp: otp, mobile: mobile, email: email, name: name},
                success: function(response) {  console.log(response);
                    if(response.data == 1){
                        jQuery('.'+formclass+' .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').prop('readonly', true);
                        jQuery('.'+formclass+' .otp-verify').css('display', 'none');
                        jQuery('.'+formclass+' .mob-otp-verify .dis-otp-field').replaceWith('<span class="otp-send-verify">Verified</span>');
                        jQuery('.'+formclass+' input[name="mob_verified"]').val('1');
                        // if (jQuery('.'+formclass+' .check-disab input').is(':checked') && (jQuery('.'+formclass+' .display_center').val() != '') ) {
                            // jQuery('.'+formclass+' .leadLightBoxSubBtn.step-one-dis').prop('disabled',false);                
                        // } else {
                            // jQuery('.'+formclass+' .leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
                        // }
                    }
                    else{
                        jQuery('.'+formclass+' .otp-verify .form-item-varify-otp input').removeClass('border-error');
                        jQuery('.'+formclass+' .otp-verify .form-item-varify-otp input').addClass('border-error');
                        jQuery('.'+formclass+' input[name="mob_verified"]').val('0');
                    }
                    jQuery('.'+formclass+' .verify-loader').removeClass('please-wait-display');
                }
            });
        }
        else{
           jQuery(this).parents('form').find('.otp-verify .form-item-varify-otp input').focus(); 
           jQuery(this).parents('form').find('.otp-verify .form-item-varify-otp input').addClass('border-error');
           jQuery(this).parents('form').find('input[name="mob_verified"]').val('0');
           jQuery(this).parents('form').find('.verify-loader').removeClass('please-wait-display');
        }
    });




    if(jQuery('select[name="crrntlydoing"]').val() == 'Completed Graduation' || jQuery('select[name="crrntlydoing"]').val() == 'Post Graduate' 
        || jQuery('select[name="crrntlydoing"]').val() == 'Working Professional' || jQuery('select[name="crrntlydoing"]').val() == 'Pursuing Post Graduation'
        || jQuery('select[name="crrntlydoing"]').val() == '3rd Year of Graduation' || jQuery('select[name="crrntlydoing"]').val() == '4th Year of Graduation'
         || jQuery('select[name="crrntlydoing"]').val() == 'Given Final Year Graduation Exams Awaiting Result' || jQuery('select[name="crrntlydoing"]').val() == 'Diploma Holder'){

        jQuery('.form-item-perclassgrad').css('display','block');
    }else{
        jQuery('.form-item-perclassgrad').css('display','none');
        jQuery('.embedFormFieldCount6').addClass('fivetosix');
    }
    if(jQuery('select[name="crrntlydoing"]').val() != 'Working Professional'){
        jQuery('input[name="ttl_wrk_exp"]').val(0);
    } else {
        jQuery('input[name="ttl_wrk_exp"]').val('');
    }


    if (jQuery('.ms-ajax-form-example .check-disab input').is(':checked') && (jQuery('.ms-ajax-form-example input[name="mob_verified"]').val() == 1) && (jQuery('.ms-ajax-form-example .display_center').val() != '') ) {
        jQuery('.ms-ajax-form-example .check-disab input').parents('.ms-ajax-form-example').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false);
        jQuery('.ms-ajax-form-example .mob-otp-verify .dis-otp-field').replaceWith('<span class="otp-send-verify">Verified</span>');  
        jQuery('.ms-ajax-form-example .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').prop('readonly', true);              
    } else {
        jQuery('.ms-ajax-form-example .check-disab input').parents('.ms-ajax-form-example').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
    }


    if (jQuery('.ms-ajax-form-embed-popup .check-disab input').is(':checked') && (jQuery('.ms-ajax-form-embed-popup input[name="mob_verified"]').val() == 1) && (jQuery('.ms-ajax-form-embed-popup .display_center').val() != '') ) {
        jQuery('.ms-ajax-form-embed-popup .check-disab input').parents('.ms-ajax-form-embed-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false); 
        jQuery('.ms-ajax-form-embed-popup .mob-otp-verify .dis-otp-field').replaceWith('<span class="otp-send-verify">Verified</span>');  
        jQuery('.ms-ajax-form-embed-popup .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').prop('readonly', true);                
    } else {
        jQuery('.ms-ajax-form-embed-popup .check-disab input').parents('.ms-ajax-form-embed-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
    }

    // jQuery(document).on("click", '.ms-ajax-form-example .check-disab input',function() {
        // if (jQuery(this).is(':checked') && (jQuery('.ms-ajax-form-example input[name="mob_verified"]').val() == 1) && (jQuery('.ms-ajax-form-example .display_center').val() != '') ) {
            // jQuery(this).parents('.ms-ajax-form-example').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false);                
        // } else {
            // jQuery(this).parents('.ms-ajax-form-example').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
        // }
    // });

    // jQuery(document).on("click", '.ms-ajax-form-embed-popup .check-disab input',function() {
        // if (jQuery(this).is(':checked') && (jQuery('.ms-ajax-form-embed-popup input[name="mob_verified"]').val() == 1) && (jQuery('.ms-ajax-form-embed-popup .display_center').val() != '') ) {
            // jQuery(this).parents('.ms-ajax-form-embed-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false);                
        // } else {
            // jQuery(this).parents('.ms-ajax-form-embed-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
        // }
    // });

    if(jQuery('.ms-ajax-form-example .display_center').val() == 1){
        jQuery('.ms-ajax-form-example .prfrd-cntr-step').css('display', 'block');
    }
    else{
        jQuery('.ms-ajax-form-example .prfrd-cntr-step').css('display', 'none');
    }

    if(jQuery('.ms-ajax-form-popup .display_center').val() == 1){
        jQuery('.ms-ajax-form-popup .prfrd-cntr-step').css('display', 'block');
    }
    else{
        jQuery('.ms-ajax-form-popup .prfrd-cntr-step').css('display', 'none');
    }

 });

Drupal.behaviors.msajaxModuleBehavior = {
  attach: function (context, settings) {
    jQuery('.form-item-enqry-crsspndnc-city input').bind("cut copy paste",function(e) {
        e.preventDefault();
    });

    jQuery(".form-item-enqry-crsspndnc-city input").keypress(function(e){
         var keyCode = e.which;
 
        if ( keyCode != 8 && keyCode !=32 && (keyCode < 48 || (keyCode > 57 && keyCode < 65) || (keyCode > 90 && keyCode < 97) || (keyCode > 90 && keyCode < 97) || keyCode > 122 )) { 
          return false;
        }
    });

  }
};

jQuery(document).ajaxComplete(function(){
if($('.form-item-enqry-whatsapp-checkbox input').is(':visible')){
        $('.embed-popup-btn').addClass("updated_privacy_policy");
}
});

jQuery(document).ajaxComplete(function(){

    jQuery('.form-item-enqry-crsspndnc-city input').bind("cut copy paste",function(e) {
        e.preventDefault();
    });

    jQuery(".form-item-enqry-crsspndnc-city input").keypress(function(e){
         var keyCode = e.which;
 
        if ( keyCode != 8 && keyCode !=32 && (keyCode < 48 || (keyCode > 57 && keyCode < 65) || (keyCode > 90 && keyCode < 97) || (keyCode > 90 && keyCode < 97) || keyCode > 122 )) { 
          return false;
        }
    });

    jQuery('input[type="number"]').keypress(function(e) {
        var keyCode = (e.keyCode ? e.keyCode : e.which);
        if (keyCode != 8 && keyCode != 0 && keyCode < 48 || keyCode > 57){
            e.preventDefault();
        }
    });

    if(jQuery('.ms-ajax-form-example .display_center').val() == 1){
        jQuery('.ms-ajax-form-example .prfrd-cntr-step').css('display', 'block');
    }
    else{
        jQuery('.ms-ajax-form-example .prfrd-cntr-step').css('display', 'none');
    }

    if(jQuery('.ms-ajax-form-popup .display_center').val() == 1){
        jQuery('.ms-ajax-form-popup .prfrd-cntr-step').css('display', 'block');
    }
    else{
        jQuery('.ms-ajax-form-popup .prfrd-cntr-step').css('display', 'none');
    }


    if (jQuery('.ms-ajax-form-example .check-disab input').is(':checked') && (jQuery('.ms-ajax-form-example input[name="mob_verified"]').val() == 1) && (jQuery('.ms-ajax-form-example .display_center').val() != '') ) {
        jQuery('.ms-ajax-form-example .check-disab input').parents('.ms-ajax-form-example').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false); 
        jQuery('.ms-ajax-form-example .mob-otp-verify .dis-otp-field').replaceWith('<span class="otp-send-verify">Verified</span>');  
        jQuery('.ms-ajax-form-example .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').prop('readonly', true);                
    } else {
        jQuery('.ms-ajax-form-example .check-disab input').parents('.ms-ajax-form-example').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
    }


    if (jQuery('.ms-ajax-form-embed-popup .check-disab input').is(':checked') && (jQuery('.ms-ajax-form-embed-popup input[name="mob_verified"]').val() == 1) && (jQuery('.ms-ajax-form-embed-popup .display_center').val() != '') ) {
        jQuery('.ms-ajax-form-embed-popup .check-disab input').parents('.ms-ajax-form-embed-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false); 
        jQuery('.ms-ajax-form-embed-popup .mob-otp-verify .dis-otp-field').replaceWith('<span class="otp-send-verify">Verified</span>');  
        jQuery('.ms-ajax-form-embed-popup .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').prop('readonly', true);                
    } else {
        jQuery('.ms-ajax-form-embed-popup .check-disab input').parents('.ms-ajax-form-embed-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
    }
    
    if(jQuery('select[name="crrntlydoing"]').val() == 'Completed Graduation' || jQuery('select[name="crrntlydoing"]').val() == 'Post Graduate' 
        || jQuery('select[name="crrntlydoing"]').val() == 'Working Professional' || jQuery('select[name="crrntlydoing"]').val() == 'Pursuing Post Graduation'
        || jQuery('select[name="crrntlydoing"]').val() == '3rd Year of Graduation' || jQuery('select[name="crrntlydoing"]').val() == '4th Year of Graduation'
         || jQuery('select[name="crrntlydoing"]').val() == 'Given Final Year Graduation Exams Awaiting Result' || jQuery('select[name="crrntlydoing"]').val() == 'Diploma Holder' ){
        jQuery('.form-item-perclassgrad').css('display','block');
    }else{
        jQuery('.form-item-perclassgrad').css('display','none');
        jQuery('.embedFormFieldCount6').addClass('fivetosix');
    }
        
    jQuery('select[name="crrntlydoing"]').on('change', function() {
        console.log(this.value);
         if(this.value == 'Completed Graduation' || this.value == 'Post Graduate' || this.value == 'Working Professional' || this.value == 'Pursuing Post Graduation'
            || this.value == '3rd Year of Graduation' || this.value == '4th Year of Graduation'
            || this.value == 'Given Final Year Graduation Exams Awaiting Result' || this.value == 'Diploma Holder'  
            ){
           jQuery('.form-item-perclassgrad').css('display','block');
        }else{
            jQuery('.form-item-perclassgrad').css('display','none');
            jQuery('.embedFormFieldCount6').addClass('fivetosix');
        }
        if(this.value != 'Working Professional'){
            jQuery('input[name="ttl_wrk_exp"]').val(0);
        } else {
            jQuery('input[name="ttl_wrk_exp"]').val('');
        }
      });
});