jQuery(document).ready(function(){

	if(jQuery('select[name="crrntlydoing"]').val() == 'Completed Graduation' || jQuery('select[name="crrntlydoing"]').val() == 'Post Graduate' 
        || jQuery('select[name="crrntlydoing"]').val() == 'Working Professional' || jQuery('select[name="crrntlydoing"]').val() == 'Pursuing Post Graduation'
        || jQuery('select[name="crrntlydoing"]').val() == '3rd Year of Graduation' || jQuery('select[name="crrntlydoing"]').val() == '4th Year of Graduation'
         || jQuery('select[name="crrntlydoing"]').val() == 'Given Final Year Graduation Exams Awaiting Result' || jQuery('select[name="crrntlydoing"]').val() == 'Diploma Holder'){
            jQuery('.form-item-perclassgrad').css('display','block');
    }else{
        jQuery('.form-item-perclassgrad').css('display','none');
    }
    if(jQuery('select[name="crrntlydoing"]').val() != 'Working Professional'){
        jQuery('input[name="ttl_wrk_exp"]').val(0);
    } else {
        jQuery('input[name="ttl_wrk_exp"]').val('');
    }

    if (jQuery('.ms-ajax-form-popup .check-disab input').is(':checked')  && (jQuery('.ms-ajax-form-popup input[name="mob_verified"]').val() == 1)  && (jQuery('.ms-ajax-form-popup .display_center').val() != '') ) {
        jQuery('.ms-ajax-form-popup .check-disab input').parents('.ms-ajax-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false);  
        jQuery('.ms-ajax-form-popup .mob-otp-verify .dis-otp-field').replaceWith('<span class="otp-send-verify">Verified</span>');  
        jQuery('.ms-ajax-form-popup .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').prop('readonly', true);              
    } else {
        jQuery('.ms-ajax-form-popup .check-disab input').parents('.ms-ajax-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
    }

    if (jQuery('.ms-ajax-callback-form-popup .check-disab input').is(':checked')  && (jQuery('.ms-ajax-callback-form-popup input[name="mob_verified"]').val() == 1)  && (jQuery('.ms-ajax-callback-form-popup .display_center').val() != '')  ) {
        jQuery('.ms-ajax-callback-form-popup .check-disab input').parents('.ms-ajax-callback-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false);  
        jQuery('.ms-ajax-callback-form-popup .mob-otp-verify .dis-otp-field').replaceWith('<span class="otp-send-verify">Verified</span>');  
        jQuery('.ms-ajax-callback-form-popup .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').prop('readonly', true);              
    } else {
        jQuery('.ms-ajax-callback-form-popup .check-disab input').parents('.ms-ajax-callback-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
    }


    jQuery(document).on("click", '.ms-ajax-form-popup .check-disab input',function() {
      //  if (jQuery(this).is(':checked') ) {
        if (jQuery(this).is(':checked')  && jQuery('.ms-ajax-form-popup .form-item-enqry-crsspndnc-mbl input').is('[readonly]')  && (jQuery('.ms-ajax-form-popup .display_center').val() != '') ) {
            jQuery(this).parents('.ms-ajax-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false);                
        } else {
            jQuery(this).parents('.ms-ajax-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
        }
    });

    jQuery(document).on("click", '.ms-ajax-callback-form-popup .check-disab input',function() {
      //  if (jQuery(this).is(':checked')) {
        if (jQuery(this).is(':checked')  && jQuery('.ms-ajax-callback-form-popup .form-item-enqry-crsspndnc-mbl input').is('[readonly]') && (jQuery('.ms-ajax-callback-form-popup .display_center').val() != '') ) {
            jQuery(this).parents('.ms-ajax-callback-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false);                
        } else {
            jQuery(this).parents('.ms-ajax-callback-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
        }
    });


 });

jQuery(document).ajaxComplete(function(){

    if (jQuery('.ms-ajax-form-popup .check-disab input').is(':checked') && (jQuery('.ms-ajax-form-popup input[name="mob_verified"]').val() == 1)  && (jQuery('.ms-ajax-form-popup .display_center').val() != '') ) {
        jQuery('.ms-ajax-form-popup .check-disab input').parents('.ms-ajax-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false); 
        jQuery('.ms-ajax-form-popup .mob-otp-verify .dis-otp-field').replaceWith('<span class="otp-send-verify">Verified</span>');  
        jQuery('.ms-ajax-form-popup .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').prop('readonly', true);                
    } else {
        jQuery('.ms-ajax-form-popup .check-disab input').parents('.ms-ajax-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
    }

    if (jQuery('.ms-ajax-callback-form-popup .check-disab input').is(':checked')  && (jQuery('.ms-ajax-callback-form-popup input[name="mob_verified"]').val() == 1) && (jQuery('.ms-ajax-callback-form-popup .display_center').val() != '')  ) {
        jQuery('.ms-ajax-callback-form-popup .check-disab input').parents('.ms-ajax-callback-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',false);
        jQuery('.ms-ajax-callback-form-popup .mob-otp-verify .dis-otp-field').replaceWith('<span class="otp-send-verify">Verified</span>');  
        jQuery('.ms-ajax-callback-form-popup .mob-otp-verify .form-item-enqry-crsspndnc-mbl input').prop('readonly', true);                  
    } else {
        jQuery('.ms-ajax-callback-form-popup .check-disab input').parents('.ms-ajax-callback-form-popup').find('.leadLightBoxSubBtn.step-one-dis').prop('disabled',true);                
    }

    if(jQuery('select[name="crrntlydoing"]').val() == 'Completed Graduation' || jQuery('select[name="crrntlydoing"]').val() == 'Post Graduate' 
        || jQuery('select[name="crrntlydoing"]').val() == 'Working Professional' || jQuery('select[name="crrntlydoing"]').val() == 'Pursuing Post Graduation'
        || jQuery('select[name="crrntlydoing"]').val() == '3rd Year of Graduation' || jQuery('select[name="crrntlydoing"]').val() == '4th Year of Graduation'
         || jQuery('select[name="crrntlydoing"]').val() == 'Given Final Year Graduation Exams Awaiting Result' || jQuery('select[name="crrntlydoing"]').val() == 'Diploma Holder'){

        jQuery('.form-item-perclassgrad').css('display','block');
    }else{
        jQuery('.form-item-perclassgrad').css('display','none');
    }
        
    jQuery('select[name="crrntlydoing"]').on('change', function() {
    console.log(this.value);
    if(this.value == 'Completed Graduation' || this.value == 'Post Graduate' || this.value == 'Working Professional' || this.value == 'Pursuing Post Graduation' || this.value == '3rd Year of Graduation' || this.value == '4th Year of Graduation'
    || this.value == 'Given Final Year Graduation Exams Awaiting Result' || this.value == 'Diploma Holder'){
        jQuery('.form-item-perclassgrad').css('display','block');
    } else {
        jQuery('.form-item-perclassgrad').css('display','none');
    }
    if(this.value != 'Working Professional'){
        jQuery('input[name="ttl_wrk_exp"]').val(0);
    } else {
        jQuery('input[name="ttl_wrk_exp"]').val('');
    }
    });
});