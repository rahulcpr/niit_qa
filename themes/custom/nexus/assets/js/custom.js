function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 600) {
    document.getElementById("icici-navbar").style.top = "0";
  } else {
    document.getElementById("icici-navbar").style.top = "-70px";
  }
}
$(document).scroll(function() {
  var y = $(this).scrollTop();
  if (y > 750) {
    $('.navDownloadBrochure').fadeIn(500);
  } else {
    $('.navDownloadBrochure').fadeOut(500);
  }
});
(function ($) {

  // **ICICI Page JQuery Start

  if($('#icici-page-navbar').is(':visible')){
    window.onscroll = function() {scrollFunction(); };
  }
  // **ICICI Page JQuery End
  
  $(window).on('load', function() {
    $('.vide0Card-share-icons-mobile').hide();
    $('.mobile-share-img').click(function(event){
      event.preventDefault();
      $('.vide0Card-share-icons-mobile').toggle();
    });
    /* Navigation */

    // $('#main-menu > nav > ul').superfish({
    //   delay:       500,                // 0.1 second delay on mouseout
    //   animation:   { opacity:'show',height:'show'},  // fade-in and slide-down animation
    //   dropShadows: true                // disable drop shadows
    // });

    $('#navigation ul.sf-js-enabled').slicknav();
  });
})(jQuery);

( function() {
  /* Course page blocks add css Start: */
  $('.keyHighlighted .row .views-field-nothing').addClass('col-md-6');
  /* Course page blocks add css Stop: */ 
  var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
      is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
      is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

  if ( ( is_webkit || is_opera || is_ie ) && 'undefined' !== typeof( document.getElementById ) ) {
    var eventMethod = ( window.addEventListener ) ? 'addEventListener' : 'attachEvent';
    window[ eventMethod ]( 'hashchange', function() {
      var element = document.getElementById( location.hash.substring( 1 ) );

      if ( element ) {
        if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
          element.tabIndex = -1;

        element.focus();
      }
    }, false );
  }
})();



/* listing see more and less more start here */ 
$(document).ready(function(){
  $('.btn-seeMore .see-m').click(function(){
    $('.see-more').slideToggle('fast');
    $('.see-m').toggle();
    $('.less-m').toggle();
  });
  $('.btn-seeMore .less-m').click(function(){
    $('.see-more').slideToggle('fast');
    $('.see-m').toggle();
    $('.less-m').toggle();
  });
/* listing see more and less more end here */

/*active start */
  $(".link").click(function () {
    $(".link").removeClass("active");    
    $(this).addClass("active");   
  });
  
    /* Small card slider */ 
  $('.slider').slick({
		arrows: true,
		dots: false,
		infinite: true,
		initialSlide: 0,
		slidesToScroll: 1,
		slidesToShow: 1,
		responsive: [                        
			{
				breakpoint: 1024,
			  settings: {
				slidesToShow: 2,
				slidesToScroll: 2,
				adaptiveHeight: true,
			  },
			},
			{
			  breakpoint: 600,
				settings: {
				centerMode: false,
				variableWidth: true,
				slidesToShow: 1,
				slidesToScroll: 1,
				autoplay: true,
				autoplaySpeed: 2500,
				swipeToSlide: true,
				pauseOnHover: true, 
				pauseOnFocus: true,
				arrows:false,
				touchMove: true,
				focusOnSelect: true,
				swipeToSlide: true
			  }
			}
		]
  });
  
	/* Big cards slider */ 
	$('.slider-big-cards').slick({
	  arrows: true,
	  dots: false,
	  infinite: true,
	  initialSlide: 0.5,
	  slidesToScroll: 1,
	  slidesToShow: 2.5,

	  responsive: [                        
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          adaptiveHeight: true,
        },
      },
      {
        breakpoint: 600,
        settings: {
        centerMode: false,
        variableWidth: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2500,
        swipeToSlide: true,
        pauseOnHover: true, 
        pauseOnFocus: true,
        arrows:false,
        touchMove: true,
        focusOnSelect: true,
        swipeToSlide: true
        }
      }
	  ]
  });

});
 
 //active  end

 $('.js-anchor-link').click(function(e){
  e.preventDefault();
  var target = $($(this).attr('href'));
  if(target.length){
    var scrollTo = target.offset().top;
    $('body, html').animate({scrollTop: scrollTo+'px'}, 800);
  }
});

$(document).ready(function(){
  $('#nav li').click(function(){
    $('li').removeClass("active");
    $(this).addClass("active");
});
});

$('#myCarousel').carousel({
  interval: 4000
});

//modal image
// Get the modal
var modal = document.getElementById("myModal");
// Get the image and insert it inside the modal - use its "alt" text as a caption
// var img = document.getElementById("myImg");
var modalImg = document.getElementById("modal-img");
var captionText = document.getElementById("caption");
// img.onclick = function(){
//   modal.style.display = "block";
//   modalImg.src = this.src;
//   captionText.innerHTML = this.alt;
// }


document.addEventListener("click", (e) => {
 const elem = e.target;
 if (elem.id==="myImg") {
   modal.style.display = "block";
   modalImg.src = elem.dataset.biggerSrc || elem.src;
   captionText.innerHTML = elem.alt; 
   
 }
})

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
 modal.style.display = "none";
 
}


$(document).ready(function() {
  $('.thumbnailCertificate').click(function(){
        $('.modal-body-Certificate').empty();
        var title = $(this).parent('a').attr("title");
        $('.modal-title').html(title);
        $($(this).parents('div').html()).appendTo('.modal-body-Certificate');
        $('#myModalCertificate').modal({show:true});
  });
  });



  slider = (event, id) => {
    event.preventDefault();
    document.getElementById(id).click();
    // alert("Ankit");
    // console.log(event.target.id);
    

}




 
 
 


// related courses & course centre slider start

if($('#exampleSlider-tools_new').is(':visible')){
    $('#exampleSlider-tools_new').multislider({
        continuous: true,
        duration: 4000
    });
}
if($('#exampleSlider-tools').is(':visible')){
    $('#exampleSlider-tools').multislider({
        continuous: true,
        duration: 4000
    });
}
if($('#exampleSlider-rating').is(':visible')){
    $('#exampleSlider-rating').multislider({
      interval:false,
      slideAll:false,
      autoSlide: false,
  });
}
if($('#exampleSliders').is(':visible')){
    $('#exampleSliders').multislider({
      interval:false,
      slideAll:false,
      autoSlide: false,
  });
}
if($('#exampleSlider3').is(':visible')){
    $('#exampleSlider3').multislider({
        continuous: true,
        duration: 4000
    });
}
if($('#exampleSlider').is(':visible')){
    $('#exampleSlider').multislider({
        interval: 4000,
        slideAll: false,
        duration: 1500,
        autoSlide: false
    });
  }
if($('#exampleSlider-1').is(':visible')){
    $('#exampleSlider-1').multislider({
        interval: false,
        slideAll: false,
        duration: 2000,
        autoSlide: false
    });
  }
if($('#exampleSlider-3').is(':visible')){
      $('#exampleSlider-3').multislider({
        interval: 4000,
        slideAll: false,
        duration: 2000,
        autoSlide: false
    });
}
if($('#exampleSlider5').is(':visible')){
    $('#exampleSlider5').multislider({
         interval: 3000,  
        slideAll: false,
        duration: 2000,
        autoSlide: false
        });
}
if($('#exampleSlider6').is(':visible')){
    $('#exampleSlider6').multislider({
         interval: 4000,  
        slideAll: false,
        duration: 4000,
        autoSlide: true
        });
}
if($('#exampleSlider20').is(':visible')){
    $('#exampleSlider20').multislider({
         interval: 4000,  
        slideAll: false,
        duration: 4000,
        autoSlide: true
        });
}
if($('#exampleSlider21').is(':visible')){
    $('#exampleSlider21').multislider({
         interval: 4000,  
        slideAll: false,
        duration: 4000,
        autoSlide: true
        });
}

if($('#exampleSlider111-0').is(':visible')){
    $('#exampleSlider111-0').multislider({
      interval:false,
      slideAll:false,
      autoSlide: false,
  });
}

if($('#exampleSlider111-1').is(':visible')){
    $('#exampleSlider111-1').multislider({
      interval:false,
      slideAll:false,
      autoSlide: false,
  });
}
if($('#exampleSlider111-2').is(':visible')){
    $('#exampleSlider111-2').multislider({
      interval:false,
      slideAll:false,
      autoSlide: false,
  });
}

if($('#exampleSlider-industructor').is(':visible')){
    $('#exampleSlider-industructor').multislider({
      interval:false,
      slideAll:false,
      autoSlide: false,
  });
}

// related courses & course centre slider end

// tooltip & testimonial slider start
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip(); 
  if($('#testimonial-slider').is(':visible')){
    $("#testimonial-slider").owlCarousel({
        items:1,
        itemsDesktop:[1199,1],
        itemsDesktopSmall:[979,1],
        itemsTablet:[768,1],
        itemsMobile:[600,1],
        pagination:true,
        navigation:false,
        navigationText:["",""],
        slideSpeed:2000,
        autoPlay:true
    });
  }
  if($('#testimonial-slider-1').is(':visible')){
    $("#testimonial-slider-1").owlCarousel({
        items:1,
        itemsDesktop:[1199,1],
        itemsDesktopSmall:[979,1],
        itemsTablet:[768,1],
        itemsMobile:[600,1],
        pagination:true,
        navigation:false,
        navigationText:["",""],
        slideSpeed:2000,
        autoPlay:true
    });
  }
  

 });
// tooltip & testimonial slider end

/* Course stickyNavbar Start: */ 
var width = $(window).width(); 
var height = $(window).height(); 

// if ((width >= 768)) {
 //do something
  // $(window).scroll(function(){
  //   var sticky = $('.sticky-navbar'),
  //       scroll = $(window).scrollTop();

  //   if (scroll >= 600) sticky.addClass('fixed');
  //   else sticky.removeClass('fixed');
  // });
// }
/* Course stickyNavbar End: */ 

$('.searchbychar').click(function (e) {
  // event.preventDefault();
    var divID = $(this).attr('href');
    $('html, body').animate({
        scrollTop: $(divID).offset().top -200
    }, 2000);
    e.preventDefault();
});
$('.searchbycharICICI').click(function (e) {
  // event.preventDefault();
  $('.icici-page-scroll a').removeClass("Active");
  $(this).addClass("Active");
    var divID = $(this).attr('href');
    $('html, body').animate({
        scrollTop: $(divID).offset().top -70
    }, 2000);
    e.preventDefault();
});
// $('.cust-btnEnrolNow').click(function(){
//   $('#ImageLoader').show();
//   $( document ).ajaxStart(function() {
//     $('#ImageLoader').hide();
//     });
// });
if($('#navbar').is(':visible')){
  window.onscroll = function() {myFunction();};  
  var navbar = document.getElementById("navbar");
  var sticky = navbar.offsetTop;
}

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky");
  } else {
    navbar.classList.remove("sticky");
  }
}

$( function() {
    var location_select = $('select[name="prfrd_cntr"]');
    location_select.empty();
    location_select.html("<option value=''> Nearest Center </option>");

    // $( ".ms-ajax-form-example .customdate" ).datepicker({
	   //    changeMonth: true,
	   //    changeYear: true,
    //     dateFormat: "dd-mm-yy",
    //     yearRange: "c-90:c"

	   //  });
    // $( ".ms-ajax-form-embed-popup .customdate" ).datepicker({
	   //    changeMonth: true,
	   //    changeYear: true,
    //     dateFormat: "dd-mm-yy",
    //     yearRange: "c-90:c"
	   //  });
    // $( ".ms-ajax-form-popup .customdate" ).datepicker({
	   //    changeMonth: true,
	   //    changeYear: true,
    //     dateFormat: "dd-mm-yy",
    //     yearRange: "c-90:c"
	   //  });
    // $( ".ms-ajax-callback-form-popup .customdate" ).datepicker({
	   //    changeMonth: true,
	   //    changeYear: true,
    //     dateFormat: "dd-mm-yy",
    //     yearRange: "c-90:c"
	   //  });
} );
jQuery(document).ajaxComplete(function(){

  initAutocomplete();

  $( function() {
    // $( ".ms-ajax-form-example .customdate" ).datepicker({
	   //    changeMonth: true,
	   //    changeYear: true,
    //     dateFormat: "dd-mm-yy",
    //     yearRange: "c-90:c"
	   //  });
    // $( ".ms-ajax-form-embed-popup .customdate" ).datepicker({
	   //    changeMonth: true,
	   //    changeYear: true,
    //     dateFormat: "dd-mm-yy",
    //     yearRange: "c-90:c"
	   //  });
    // $( ".ms-ajax-form-popup .customdate" ).datepicker({
	   //    changeMonth: true,
	   //    changeYear: true,
    //     dateFormat: "dd-mm-yy",
    //     yearRange: "c-90:c"
	   //  });
    // $( ".ms-ajax-callback-form-popup .customdate" ).datepicker({
	   //    changeMonth: true,
	   //    changeYear: true,
    //     dateFormat: "dd-mm-yy",
    //     yearRange: "c-90:c"
	   //  });
    
  });
 //  jQuery('#ms_ajax_popup_page_enquire_Modal').on('show.bs.modal', function (e) {
 //    jQuery( "#ms_ajax_popup_page_enquire_Modal .customdate" ).datepicker({
	//       changeMonth: true,
	//       changeYear: true,
 //        dateFormat: "dd-mm-yy",
 //        yearRange: "c-90:c"
	//     });
 // });


});



jQuery(document).ready(function(){

      jQuery('#myButton').click();      
      var list = jQuery("#careerPageUl > li");
      var numToShow = 10;
      var button = jQuery("#loadMorecareernew");
      var numInList = list.length;
      list.hide();
      button.hide();
      if (numInList > numToShow) {
        button.show();
      }
      list.slice(0, numToShow).show();

      button.click(function(){
          var showing = list.filter(':visible').length;
          list.slice(showing - 1, showing + numToShow).fadeIn();
          var nowShowing = list.filter(':visible').length;
          if (nowShowing >= numInList) {
            button.hide();
          }
      });

});


jQuery(document).on("click","#toggle_icon_career",function() {
        jQuery(this).parents('.hr-jobs-listing').find('.hr-job_discribption').toggle(); jQuery(this).parents('.hr-jobs-listing').find('#toggle_icon_career').hide(); jQuery(this).parents('.hr-jobs-listing').find('#toggle_icon_career_minus').show(); 
    });

jQuery(document).on("click","#toggle_icon_career_minus",function() {
        jQuery(this).parents('.hr-jobs-listing').find('.hr-job_discribption').toggle(); jQuery(this).parents('.hr-jobs-listing').find('#toggle_icon_career').show(); jQuery(this).parents('.hr-jobs-listing').find('#toggle_icon_career_minus').hide(); 
    });

/************************* KC Home Page jQuery ************** Start **/

$('#exampleSlider-kc').multislider({
    interval: 4000,
    slideAll: false,
    duration: 1500,
    autoSlide: false
});
$('#kcRecentStories').multislider({
    interval: 4000,
    slideAll: false,
    duration: 1500,
    autoSlide: false
});
$(document).ready(function(){
    $("#search").focus(function() {
      $(".search-box").addClass("border-searching");
      $(".search-icon").addClass("si-rotate");
    });
    $("#search").blur(function() {
      $(".search-box").removeClass("border-searching");
      $(".search-icon").removeClass("si-rotate");
    });
    $("#search").keyup(function() {
        if($(this).val().length > 0) {
          $(".go-icon").addClass("go-in");
        }
        else {
          $(".go-icon").removeClass("go-in");
        }
    });
    $(".go-icon").click(function(){
      $(".search-form").submit();
    });
});

$(document).ready(function(){
//var nodeid = jQuery('#pageNodeId').text();
if(jQuery('#pageNodeBundle').text() == 'course'){
var nodeid = jQuery('#pageNodeId').text();
//alert(nodeid);
} else {
var nodeid = jQuery('#mynodeid').text();
//alert(nodeid);
}

var mynodeid = jQuery('#mynodeid').text();

//Drupal.ajax({ url: '/india/generate_multistep_form_using_ajax' }).execute();
if($('#multi-div').is(':visible')){
  
  Drupal.ajax({ url: '/india/multistep_form_using_ajax/'+nodeid}).execute();
  //Drupal.ajax({ url: '/pop_multistep_form_using_ajax/'+nodeid}).execute();
}
if($('.multi-div').is(':visible')){
  
  Drupal.ajax({ url: '/india/multistep_second_form_using_ajax/'+nodeid}).execute();
  //Drupal.ajax({ url: '/pop_multistep_form_using_ajax/'+nodeid}).execute();
}
//if($('#mobile-multi-div').is(':visible')){
//Drupal.ajax({ url: '/india/mobile_multistep_form_using_ajax/'+nodeid}).execute();
//Drupal.ajax({ url: '/india/pop_multistep_form_using_ajax/'+nodeid}).execute();
//}
if($('#popmulti-div').is(':visible')){
//Drupal.ajax({ url: '/india/multistep_form_using_ajax/'+nodeid}).execute();
Drupal.ajax({ url: '/india/pop_multistep_form_using_ajax/'+nodeid}).execute();
}


//Drupal.ajax({ url: '/india/multistep_apply_btn_using_ajax/'+nodeid}).execute();
Drupal.ajax({ url: '/india/login_user_info'}).execute();
Drupal.ajax({ url: '/india/register_user_info'}).execute();
//Drupal.ajax({ url: '/india/talk_to_expert/'+nodeid}).execute();
//Drupal.ajax({ url: '/india/user_reg_link'}).execute(); // Not in used on QA due to new design template
Drupal.ajax({ url: '/india/mobile_user_reg_link'}).execute();
Drupal.ajax({ url: '/india/my_programs'}).execute();
Drupal.ajax({ url: '/india/my_programs_pop'}).execute();
Drupal.ajax({ url: '/india/continue_register_user_pop'}).execute();

/*if($('.Self-stackathon-div').is(':visible')){
Drupal.ajax({ url: '/india/Self_land_stackathon_form/'+nodeid}).execute();
}*/
if($('.self-paced-embed-div').is(':visible')){
  Drupal.ajax({ url: '/india/Self_paced_stackathon_form/'+nodeid}).execute();
}


if($('.enrollnow-div').is(':visible')){
Drupal.ajax({ url: '/india/modular_enrollnow_login/'+nodeid}).execute();
}
if($('.enrollnow-div-nokia').is(':visible')){
Drupal.ajax({ url: '/india/modular_enrollnow_login_nokia/'+nodeid}).execute();
}

if($('.callback').is(':visible')){
  Drupal.ajax({ url: '/india/talk_to_expert'}).execute();
}
if($('#talk-to-expert-form').is(':visible')){
Drupal.ajax({ url: '/india/talk-to-exp-pop/'+nodeid}).execute();
}
if($('#simple-lead-form').is(':visible')){
Drupal.ajax({ url: '/india/simple-lead-form-ajax/'+mynodeid}).execute();
}
if($('#mobile-simple-lead-form').is(':visible')){
Drupal.ajax({ url: '/india/mobile-simple-lead-form-ajax/'+mynodeid}).execute();
}

if($('.Stackathon-Lead-Form-div').is(':visible')){
Drupal.ajax({ url: '/india/stackathon_lead_button_ajax/'+nodeid}).execute();
}

if($('.broucherpdf').is(':visible')){
Drupal.ajax({ url: '/india/stackroute_brochure_pdf/'+nodeid}).execute();
}
if($('.homepagelead-ldform').is(':visible')){
Drupal.ajax({ url: '/india/homepageleadform' }).execute();
}

});
// jQuery( '.call' ).click(function() { 
//   jQuery( '.callback-blk .expert-div .edit-enqry_crsspndnc_course' ).remove(); 
// // alert(); 
// }); 

(function($) {
$(document).ajaxComplete(function(e, xhr, settings){
  // For My Program Auto click code start by Sachin
  // if (settings.url == "/india/login_user_info?_wrapper_format=drupal_ajax") {
  //   var lnkVer = jQuery('a.my-course-menu-link-single').attr('lnkVer');
  //   if(lnkVer == "Y@@V2"){
  //     jQuery("#my-course-menu-link-single").click();
  //     jQuery('#my-course-menu-link-single').off('click');
  //   }
  // }
  // For My Program Auto click code End
  
  if (settings.url == "/india/register_user_info?_wrapper_format=drupal_ajax") {
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
 }
 var pageid = jQuery('#pageNodeId').text();
if($('.Self-stackathon-div').is(':visible')){
 if (settings.url == "/india/Self_land_stackathon_form/"+pageid+"?_wrapper_format=drupal_ajax") {
 //alert("my id "+pageid+"node id");
// alert('hi');
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
 }
 }
 
});
}(jQuery));

$(document).ready(function(){

    $("#search-page-load-more .viewResultListing_kc").click(function(){
        var currentPage = $("#search-page-load-more #currentPageNumberCount").val();
        var totlePage = $("#search-page-load-more #totalPageNumberCount").val();
        var kcSearchType = $("#search-page-load-more #kc-search-type").val();
        var searchVal = $("#search-page-load-more #searchVal").val();
        $.ajax({
            url : '/india/load_more_get_article',
            type: 'POST',
            data: {currentPage: currentPage, totlePage: totlePage, kcSearchType: kcSearchType, searchVal: searchVal},
            beforeSend: function(){
                $('#loading-section').append('<center class="loader_load"><h3><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...</h3></center>');
            },
            success: function(response) {
                $(".list-append-section").append(response.data);
                if(response.totlePage == response.currentPage){
                  $("#search-page-load-more #currentPageNumberCount").val(response.currentPage);
                  $("#search-page-load-more .viewResultListing_kc").hide();
                }else{
                  $("#search-page-load-more #currentPageNumberCount").val(response.currentPage);
                  $("#search-page-load-more #viewResultListing_kc").show();
                }
                
                $('#loading-section').empty();
                
            }
        });
    });


    $("#search-page-load-more .viewResultListing_kc_event").click(function(){
        var currentPage = $("#search-page-load-more #currentPageNumberCount").val();
        var totlePage = $("#search-page-load-more #totalPageNumberCount").val();
        var kcSearchType = $("#search-page-load-more #kc-search-type").val();
        var searchValscgrp = $("#search-page-load-more #searchValscgrp").val();
        var searchValevtyp = $("#search-page-load-more #searchValevtyp").val();

        var searchValevdgt = $("#search-page-load-more #searchValevdgt").val();
        var searchValevdlt = $("#search-page-load-more #searchValevdlt").val();
        $.ajax({
            url : '/india/load_more_get_event',
            type: 'POST',
            data: {
                currentPage: currentPage, 
                totlePage: totlePage, 
                kcSearchType: kcSearchType, 
                searchValscgrp: searchValscgrp, 
                searchValevtyp: searchValevtyp,
                searchValevdgt: searchValevdgt,
                searchValevdlt: searchValevdlt
              },
            beforeSend: function(){
                $('#loading-section').append('<center class="loader_load"><h3><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...</h3></center>');
            },
            success: function(response) {
                $(".list-append-section").append(response.data);
                if(response.totlePage == response.currentPage){
                  $("#search-page-load-more #currentPageNumberCount").val(response.currentPage);
                  $("#search-page-load-more .viewResultListing_kc_event").hide();
                }else{
                  $("#search-page-load-more #currentPageNumberCount").val(response.currentPage);
                  $("#search-page-load-more #viewResultListing_kc_event").show();
                }
                
                $('#loading-section').empty();
                
            }
        });
    });
    /**********************************
    ** Onload div load bookmark code **
    **********************************/
    $('span.kc-bookmark-btn').click(function(){ 
      var nodeId = $(this).attr('node-id');
      var bmkText = $(this).attr('bmk-text');
      $(this).append('<span class="pull-right"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Plaese Wait...</span>');
      $(this).addClass("kc-bookmark-btn-2");
      jQuery.ajax({
        url : '/india/kc_onload_bookmark_btn',
        type: 'POST',
        data: {nodeId: nodeId, bmkText: bmkText},
        success: function(response) {
          if(response.data){
            $(".kc-bookmark-btn-2").empty();
            $(".kc-bookmark-btn-2").append(response.data);
            $(".kc-bookmark-btn-2").removeClass("kc-bookmark-btn");
          }
        }
      });
    });

    if(jQuery("span.kc-bookmark-btn").is(":visible")){
      $("span.kc-bookmark-btn").click();
      $('span.kc-bookmark-btn').off('click');
    }

    $(document).on("click","span.kc-bookmark-btn-2", function() {
      var nodeId = $(this).attr('node-id');
      var categoryId = $(this).attr('category-id');
      var bmkText = $(this).attr('bmk-text');
      var isWL = $('span.bookmark-sec', this).attr('isWL');
      // push datalayer
      var link_text = $('span.bookmark-sec', this).text();
      kc_article_bookmark_datalayer(link_text);

      $(this).empty();
      $(this).append('<span class="pull-right"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Plaese Wait...</span>');
      $(this).addClass("kc-bookmark-btn-3");
      jQuery.ajax({
        url : '/india/kc_onclick_bookmark_btn',
        type: 'POST',
        data: {nodeId: nodeId, categoryId: categoryId, isWL: isWL, bmkText: bmkText},
        success: function(response) {
          if(response.data){
            $(".kc-bookmark-btn-3").empty();
            $(".kc-bookmark-btn-3").append(response.data);
            $(".kc-bookmark-btn-3").removeClass("kc-bookmark-btn-3");
          }
        }
      });
    });
    /***********************************/
    $(document).on("click","#WriteAReview #submitReviewBtn", function() {
      var vId = $('#articleNodeId').val();
      var rating = $('#selectRatingKC').val();
      var comment = $('#commentBoxKC').val();
      var type = 'ratingComment';
      $.ajax({
            url : '/india/kc_rating_and_comment_url',
            type: 'POST',
            data: {vId: vId, rating: rating, comment: comment, type: type},
            success: function(response) {
              if(response.data == 1){
                location.reload();
              }
            }
        });
    });
    $(document).on("click","#blog-post-load-more .viewResultListing_kc", function() {
      var vId = $('#current-vId').val();
      var currentPage = $('#currentPageNumberCount').val();
      var totlePage = $('#totalPageNumberCount').val();
      var type = $('#comment-type').val();
      $.ajax({
            url : '/india/kc_rating_and_comment_url',
            type: 'POST',
            data: {vId: vId, currentPage: currentPage, totlePage: totlePage, type: type},
            beforeSend: function(){
                $('#loading-section').append('<center class="loader_load"><h4><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Please Wait...</h4></center>');
            },
            success: function(response) {
              $(".list-append-section").append(response.data);
              if(response.totlePage == response.currentPage){
                $("#blog-post-load-more #currentPageNumberCount").val(response.currentPage);
                $("#blog-post-load-more .viewResultListing_kc").hide();
              }else{
                $("#blog-post-load-more #currentPageNumberCount").val(response.currentPage);
                $("#blog-post-load-more #viewResultListing_kc").show();
              }
              $('#loading-section').empty();
            }
        });
    });

    $(document).on("click","#clear-all-bookmark", function() {
      if (confirm('Are you sure to clear bookmark list?')) {
        jQuery.ajax({
          url: '/india/clear_bookmark_list',
          type: 'POST',
          async : true,
          dataType : "json",
          success: function (response) {
            if (response.status == 1) {
              $(".user-bookmark-list").empty();
              $(".user-bookmark-list").append(response.msg);
              $('#loading-section').empty();
            }
          }             
        });
      }
 
  }); 
    // Article star rating Code
    if(jQuery(".article-star-rating-sec").is(":visible")){
      var nodeId = jQuery('.article-star-rating-sec').attr('node-id');
      jQuery.ajax({
        url : '/india/kc_article_star_rating_append',
        type: 'POST',
        data: {nodeId: nodeId},
        beforeSend: function(){
          $('.article-star-rating-sec').append('<span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Please Wait...</span>');
        },
        success: function(response) {
          if(response.data){
            $(".article-star-rating-sec").empty();
            $(".article-star-rating-sec").append(response.data);
          }
        }
      });
    }
    // Follow and unfollow category Script -- start
    $(document).on("click",".blog-post-follow-btn-2", function() {
      var cId = $(this).attr('category-Id');
      var sts = $('a.kc-follow-btn', this).attr('sts');
      //datalayer push
      var link_text = $('a.kc-follow-btn .follow-text', this).text();
      kc_article_follow_unfollow_datalayer(link_text);

      $(this).addClass("blog-post-follow-btn-new");
      $(this).empty();
      $(this).append('<span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Please Wait...</span>');
      $.ajax({
        url : '/india/kc_category_onclick_follow_unfollow',
        type: 'POST',
        data: {cId: cId, sts: sts},
        success: function(response) {
          if(response.data){
            $(".blog-post-follow-btn-new").empty();
            $(".blog-post-follow-btn-new").append(response.data);
            $('.blog-post-follow-btn-new').removeClass("blog-post-follow-btn-new");
          }
        }
      }); 
    }); 
    $(document).on("click",".blog-post-follow-btn", function() {
      var cId = jQuery(this).attr('category-Id');
      $(this).addClass("blog-post-follow-btn-2");
      $(this).append('<span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Please Wait...</span>');
      jQuery.ajax({
        url : '/india/kc_category_onload_follow_unfollow',
        type: 'POST',
        data: {cId: cId},
        success: function(response) {
          if(response.data){
            $(".blog-post-follow-btn").empty();
            $(".blog-post-follow-btn").append(response.data);
            $(".blog-post-follow-btn").removeClass('blog-post-follow-btn');
          }
        }
      });
    });
    if(jQuery(".blog-post-follow-btn").is(":visible")){
      $(".blog-post-follow-btn").click();
      $('.blog-post-follow-btn').off('click');
    }
    // Follow and unfollow category Script -- end



    $(document).on("click","#bmk-load-more .viewResultListing_kc", function() {
      var currentPage = $('#bmkCurrentPageNumberCount').val();
      var totlePage = $('#bmkTotalPageNumberCount').val();
      $.ajax({
            url : '/india/kc_my_profile_load_more_bookmark',
            type: 'POST',
            data: {currentPage: currentPage, totlePage: totlePage},
            beforeSend: function(){
                $('#bmk-loading-section').append('<center class="loader_load"><h4><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...</h4></center>');
            },
            success: function(response) {
              $(".bmk-list-append-sec").append(response.data);
              if(response.totlePage == response.currentPage){
                $("#bmk-load-more #bmkCurrentPageNumberCount").val(response.currentPage);
                $("#bmk-load-more .viewResultListing_kc").hide();
              }else{
                $("#bmk-load-more #bmkCurrentPageNumberCount").val(response.currentPage);
                $("#bmk-load-more #viewResultListing_kc").show();
              }
              $('#bmk-loading-section').empty();
            }
        });
    });
    // 
    if(jQuery(".setBookmarkListData").is(":visible")){
      jQuery.ajax({
        url : '/india/kc_my_preferences_bookmark_list',
        type: 'POST',
        beforeSend: function(){
          $('.setBookmarkListData').append('<span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Please Wait...</span>');
        },
        success: function(response) {
          if(response.data){
            $(".setBookmarkListData").empty();
            $(".setBookmarkListData").append(response.data);
          }
        }
      });
    }
    if(jQuery(".setFollowingListData").is(":visible")){
      jQuery.ajax({
        url : '/india/kc_my_preferences_following_list',
        type: 'POST',
        beforeSend: function(){
          $('.setFollowingListData').append('<span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Please Wait...</span>');
        },
        success: function(response) {
          if(response.data){
            $(".setFollowingListData").empty();
            $(".setFollowingListData").append(response.data);
          }
        }
      });
    }

    /*************** User My course Menu ************* start **/
    jQuery(document).on("click",'#user_mycourse_modal_box .my-course-cancel-btn',function() {
      jQuery('#user_mycourse_modal_box').modal('toggle');
    });
    jQuery(document).on("click",'#user_mycourse_modal_box .my-course-continue-btn',function() {
      var user_cid = jQuery('#user_mycourse_modal_box input[name="my_course_generate_token"]:checked').attr('user_cid');
      var user_email = jQuery('#user_mycourse_modal_box input[name="my_course_generate_token"]:checked').attr('user_email');
      var user_name = jQuery('#user_mycourse_modal_box input[name="my_course_generate_token"]:checked').attr('user_name');
      var lnkVer = jQuery('#user_mycourse_modal_box input[name="my_course_generate_token"]:checked').attr('lnkVer');
      if(user_cid && user_email && user_name){
        jQuery('#user_mycourse_modal_box .unplanErrorClass').empty();
          jQuery.ajax({
          url : '/india/my_course_link_generate_radio_btn_click',
          type: 'POST',
          data: {user_cid: user_cid, user_email: user_email, user_name: user_name, lnkVer: lnkVer},
          success: function(response) {
            if(response.data){
              jQuery("<a>").prop({target: "_blank", href: response.data })[0].click();
              jQuery('#user_mycourse_modal_box').modal('toggle');
            }
          }
        });
      }else{
        jQuery('#user_mycourse_modal_box .unplanErrorClass').empty();
        jQuery('#user_mycourse_modal_box .unplanErrorClass').append('<div class="mb-4">Please select a Email/Student ID.</div>');
      }
    });
    jQuery(document).on("click",'a.my-course-menu-link-single',function() {
      var user_cid = jQuery('a.my-course-menu-link-single').attr('user_cid');
      var user_email = jQuery('a.my-course-menu-link-single').attr('user_email');
      var user_name = jQuery('a.my-course-menu-link-single').attr('user_name');
      var lnkVer = jQuery('a.my-course-menu-link-single').attr('lnkVer');
        jQuery.ajax({
        url : '/india/my_course_link_generate_radio_btn_click',
        type: 'POST',
        data: {user_cid: user_cid, user_email: user_email, user_name: user_name, lnkVer: lnkVer},
        success: function(response) {
          if(response.data){
            jQuery("<a>").prop({target: "_blank", href: response.data })[0].click();
          }
        }
      });
    });
    

    jQuery(document).on("click", "a.clsOpenMyBatchesLink", function(){
      // var user_cid = jQuery('a.clsOpenMyBatchesLink').attr('user_cid');
      var pageNodeId = jQuery('#pageNodeId').text();
      jQuery.ajax({
        url : '/india/my_batches_link_generate_click',
        type: 'POST',
        data: {pageNodeId: pageNodeId},
        success: function(response) {
          if(response.data){
            jQuery("<a>").prop({target: "_blank", href: response.data })[0].click();
          }
        }
      });
    });

    jQuery(document).on("click", ".StackathonLeadFormCls .modal-content .leadCusCloseBtn", function(){
      location.reload();
    });



    jQuery(document).on("click",'.signInFormLoginWOTPLink a.login_with_otp_link_cls',function() {
      jQuery(".signInFormLoginWPwdLink ").removeClass("signIn_hide_form_field");
      jQuery(".signInFormLoginWPwdLink ").addClass("signIn_show_form_field");
      jQuery(".signInFormLoginWOTPLink ").removeClass("signIn_show_form_field");
      jQuery(".signInFormLoginWOTPLink ").addClass("signIn_hide_form_field");
      jQuery(".btn-signup .login_with_pwd_btn").removeClass("signIn_show_form_field");
      jQuery(".btn-signup .login_with_pwd_btn").addClass("signIn_hide_form_field");
      jQuery(".btn-signup .login_with_otp_btn").removeClass("signIn_hide_form_field");
      jQuery(".btn-signup .login_with_otp_btn").addClass("signIn_show_form_field");
      jQuery(".signIn-reset-pwd").removeClass("signIn_show_form_field");
      jQuery(".signIn-reset-pwd").addClass("signIn_hide_form_field");
      jQuery(".regsiter-first-block .password-field-custom").removeClass("signIn_show_form_field");
      jQuery(".regsiter-first-block .password-field-custom").addClass("signIn_hide_form_field");
      jQuery(".modalSubTitle.signInwithPwdText").removeClass("signIn_show_form_field");
      jQuery(".modalSubTitle.signInwithPwdText").addClass("signIn_hide_form_field");
      jQuery(".modalSubTitle.signInwithOTPText").removeClass("signIn_hide_form_field");
      jQuery(".modalSubTitle.signInwithOTPText").addClass("signIn_show_form_field");
    });
    jQuery(document).on("click",'.signInFormLoginWPwdLink a.login_with_pwd_link_cls',function() {
      jQuery(".signInFormLoginWPwdLink ").removeClass("signIn_show_form_field");
      jQuery(".signInFormLoginWPwdLink ").addClass("signIn_hide_form_field");
      jQuery(".signInFormLoginWOTPLink ").removeClass("signIn_hide_form_field");
      jQuery(".signInFormLoginWOTPLink ").addClass("signIn_show_form_field");
      jQuery(".btn-signup .login_with_pwd_btn").removeClass("signIn_hide_form_field");
      jQuery(".btn-signup .login_with_pwd_btn").addClass("signIn_show_form_field");
      jQuery(".btn-signup .login_with_otp_btn").removeClass("signIn_show_form_field");
      jQuery(".btn-signup .login_with_otp_btn").addClass("signIn_hide_form_field");
      jQuery(".signIn-reset-pwd").removeClass("signIn_hide_form_field");
      jQuery(".signIn-reset-pwd").addClass("signIn_show_form_field");
      jQuery(".regsiter-first-block .password-field-custom").removeClass("signIn_hide_form_field");
      jQuery(".regsiter-first-block .password-field-custom").addClass("signIn_show_form_field");
      jQuery(".modalSubTitle.signInwithPwdText").removeClass("signIn_hide_form_field");
      jQuery(".modalSubTitle.signInwithPwdText").addClass("signIn_show_form_field");
      jQuery(".modalSubTitle.signInwithOTPText").removeClass("signIn_show_form_field");
      jQuery(".modalSubTitle.signInwithOTPText").addClass("signIn_hide_form_field");
    });

    jQuery(document).on("click",'.user-course-eligibility-check',function() {
      var courseCode = jQuery(this).attr('course-code');
      var courseSecCls = ".courseSec"+courseCode;
	  jQuery(this).addClass("new-user-course-eligibility-check");
      jQuery.ajax({
        url : '/india/eligibility-search-page',
        type: 'POST',
        data: {courseCode: courseCode},
        success: function(response) {
          console.log(response.eligibilityStatus);
          if(response.eligibilityStatus){
            jQuery(courseSecCls).empty();
            jQuery(courseSecCls).append(response.eligibilityStatus);
          }
        }
      });
    });
      if(jQuery(".user-course-eligibility-check").is(":visible")){
        jQuery(".user-course-eligibility-check").click();
      }
    /*************** User My course Menu ************* End **/

    if(jQuery("body").is(":visible")){
      
      
      var nid = jQuery('#pageNodeId').text();
      jQuery.ajax({
        url : '/india/autoRedirectLoaderSec/'+nid,
        type: 'POST',
        success: function(response) {
          if(response.data){
            $(".formAutoRedirectLoaderSec").empty();
            $(".formAutoRedirectLoaderSec").append(response.data);
          }
          // var intervalVar = "";
          // if(response.loaderEnable == "show"){
          //   intervalVar = setInterval(function(){
          //       if(jQuery(".ContinueYourApplicationForm").is(":visible")){
          //           jQuery('.ContinueYourApplicationForm').submit();
          //           clearInterval(intervalVar);
          //       }
          //       if(jQuery(".nokiaEnrollnow input[name='token']").is(":visible")){
          //           if(jQuery(".nokiaEnrollnow input[name='token']").val()){
          //               EnrollSubmitPreForm();
          //               clearInterval(intervalVar);
          //           }
          //       }
          //   }, 200);
          // }

        }
      });
    }
    // if(jQuery(".ContinueYourApplicationForm").is(":visible")){
    //     jQuery('.ContinueYourApplicationForm').submit();
    // }
    // if(jQuery(".nokiaEnrollnow input[name='token']").is(":visible")){
    //     if(jQuery(".nokiaEnrollnow input[name='token']").val()){
    //         EnrollSubmitPreForm();
    //     }
    // }
    /***Code for wipro page start***/
    jQuery(document).on("click", ".wiproPageSuperSetSec button.wiproPageVerifyBtn", function(){

      var superSetId = jQuery('.wiproPageSuperSetSec .wiproPageSuperSetbox').val();
      if(superSetId == ""){
        var superSetId = jQuery('.wiproPageSuperSetSecMob .wiproPageSuperSetSec .wiproPageSuperSetbox').val();
      }
      if(superSetId == ""){
        jQuery('.wiproPageSuperSetSec .superset_id_msg').empty();
        jQuery('.wiproPageSuperSetSec .superset_id_msg').append('<span style="font-size: 11px; color: red;">Please enter your Superset ID.</span>');
      }else{
        jQuery('.wiproPageSuperSetSec .superset_id_msg').empty();
        jQuery.ajax({
          url : '/india/wiproPageSupersetIdCheck',
          type: 'POST',
          data: {superSetId: superSetId},
          success: function(response) {
            if(response.data){
              if(response.data == 'verified'){
                jQuery('.wiproPageSuperSetSec .superset_id_msg').empty();
                jQuery('.wiproPageSuperSetSec .wiproPageVerifyBtn').empty();
                jQuery('.wiproPageSuperSetEnrollBtn').empty();
                jQuery('.wiproPageSuperSetSec .superset_id_msg').append('<span style="font-size: 11px; color: #10c810;">Your Superset id is successfully verified.</span>');
                jQuery('.wiproPageSuperSetSec .wiproPageVerifyBtn').append('Verified');
                jQuery('.wiproPageSuperSetSec .wiproPageVerifyBtn').prop('disabled', true);
                jQuery('.wiproPageSuperSetSec .wiproPageSuperSetbox').prop('readonly', true);
                jQuery('.wiproPageSuperSetEnrollBtn').append('<span class="btn btn-primary btnApply" onclick="modularpage_check()">Enroll Now</span>');
              }else{
                jQuery('.wiproPageSuperSetSec .superset_id_msg').empty();
                jQuery('.wiproPageSuperSetSec .superset_id_msg').append('<span style="font-size: 11px; color: red;">Your Superset id is invalid.</span>');
              }
              
            }
          }
        });

      }
      // alert(superSetId);
      
    });
    /***Code for wipro page End***/

});


jQuery(document).ready(function(){
  // var loaderEnable = jQuery('#dv_loader').attr('loaderEnable');
  // var intervalVar = "";
  // if(loaderEnable == 'show'){
  //   intervalVar = setInterval(function(){
  //     if(jQuery(".iciciCheckEligiblityForm .check_eligibility_display .continue-form")){
  //       jQuery('.ContinueYourApplicationForm').submit();
  //       clearInterval(intervalVar);
  //     }
  //   }, 100);
  // }
  setTimeout(function(){
    if(jQuery(".nokiaEnrollnow input[name='token']").val()){
      EnrollSubmitPreForm();
    }
  }, 3000); 
  
});

if(jQuery('#dv_loader').attr('loaderEnable')){
  if(jQuery('#dv_loader').attr('loaderEnable') == 'show'){
    jQuery(window).on('load', function(){
      setTimeout(removeLoader, 5); //wait for page load PLUS one seconds.
    });
    function removeLoader(){
        jQuery( "#dv_loader" ).fadeOut(5, function() {
          // fadeOut complete. Remove the loading div
          jQuery( "#dv_loader" ).remove(); //makes page more lightweight 
      });  
    }
  }
}
/************************* KC Home Page jQuery ************** End **/



$(document).ready(function() {
    $('.card-slider2').slick({
         dots: false,
            arrows: true,
            slidesToShow: 2,
            infinite: false,
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 2,
                  infinite: false,
                  slidesToScroll: 1
                }
              },
              {
                breakpoint: 800,
                settings: {
                  slidesToShow: 2,
                  infinite: false,
                  slidesToScroll: 1
                }
              },
              {
                breakpoint: 600,
                settings: {
                  slidesToShow: 1.25,
                  slidesToScroll: 1,
                  infinite: false,
                  arrows: false
                }
              }
            ]
          });
        });



$(document).ready(function() {
          $('.card-slider1').slick({
             dots: false,
            arrows: true,
            slidesToShow: 3,
            infinite: false,
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 2,
                  infinite: false,
                  slidesToScroll: 1
                }
              },
              {
                breakpoint: 800,
                settings: {
                  slidesToShow: 2,
                  infinite: false,
                  slidesToScroll: 1
                }
              },
              {
                breakpoint: 600,
                settings: {
                  slidesToShow: 1.25,
                  slidesToScroll: 1,
                  infinite: false,
                  arrows: false
                }
              }
            ]
          });
        });


$(document).ready(function() {
          $('.card-slider4').slick({
            dots: false,
            arrows: true,
            slidesToShow: 2,
            infinite: false,
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 2
                }
              },
              {
                breakpoint: 800,
                settings: {
                  slidesToShow: 2,
                  infinite: false,
                  slidesToScroll: 1
                }
              },
              {
                breakpoint: 600,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  infinite: false,
                  arrows: true
                }
              }
            ]
          });
        });   


$(document).ready(function() {
          $('.card-slider5').slick({
            dots: false,
            arrows: true,
            slidesToShow: 3,
            infinite: false,
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 2
                }
              },
              {
                breakpoint: 800,
                settings: {
                  slidesToShow: 2,
                  infinite: false,
                  slidesToScroll: 1
                }
              },
              {
                breakpoint: 600,
                settings: {
                  slidesToShow: 1.25,
                  slidesToScroll: 1,
                  infinite: false,
                  arrows: true
                }
              }
            ]
          });
        });   

var btnapplynow = $('#mobile-sticky-footer');
if (window.navigator.userAgent.indexOf("Mobile") > -1) {
  btnapplynow.css("display","none");
    $(window).scroll(function() {
      if ($(window).scrollTop() > 550) {
        btnapplynow.css("display","block");
      } else {
        btnapplynow.css("display","none");
      }
    });
 }







var CourseDetailListingnewvar = $('.CourseDetailListingnew2');
var CourseDetailListingnewvar1 = $('.CourseDetailListingnew3');
if (window.navigator.userAgent.indexOf("Mobile") > -1) {
  CourseDetailListingnewvar.css("display","none");
 CourseDetailListingnewvar1.css("display","none");
  
$(function() {
  $('.iciciCourseDetailTitle').click(function(j) {


     if ($(this).hasClass('CourseDetailicon_up')) {
    // The box that we clicked has a class of bad so let's remove it and add the good class
       $(this).removeClass('CourseDetailicon_up');
       $(this).addClass('CourseDetailicon_down');
      } else {
        // The user obviously can't follow instructions so let's alert them of what is supposed to happen next
        $(this).addClass('CourseDetailicon_up');
        $(this).removeClass('CourseDetailicon_down');
      }
    
    var dropDown = $(this).closest('.iciciCourseDetailSectionnew').find('.CourseDetailListingnew');
    $(this).closest('.iciciCourseDetail_accordion').find('.CourseDetailListingnew').not(dropDown).slideUp();
    
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
    } else {
      $(this).closest('.iciciCourseDetail_accordion').find('.iciciCourseDetailTitle.active').removeClass('active');
      $(this).addClass('active');
    }
    
    dropDown.stop(false, true).slideToggle();
    j.preventDefault();
  });
});
}





var selector = $('.panel-defaul-new div');

$(selector).on('click', function(){
    $(selector).removeClass('in');
    $(this).addClass('in');
});


jQuery(document).ready(function(){

      var list = jQuery(".selfPaced_courseBoxNew1");
      var numToShow = 2;
      var button = jQuery(".sp_viewAll1");
      var numInList = list.length;
      list.hide();
      button.hide();
      if (numInList > numToShow) {
        button.show();
      }
      list.slice(0, numToShow).show();

      button.click(function(){
          var showing = list.filter(':visible').length;
          list.slice(showing - 1, showing + numToShow).fadeIn();
          var nowShowing = list.filter(':visible').length;
          if (nowShowing >= numInList) {
            button.hide();
          }
      });

});

jQuery(document).ready(function(){

      var list = jQuery(".selfPaced_courseBoxNew2");
      var numToShow = 2;
      var button = jQuery(".sp_viewAll2");
      var numInList = list.length;
      list.hide();
      button.hide();
      if (numInList > numToShow) {
        button.show();
      }
      list.slice(0, numToShow).show();

      button.click(function(){
          var showing = list.filter(':visible').length;
          list.slice(showing - 1, showing + numToShow).fadeIn();
          var nowShowing = list.filter(':visible').length;
          if (nowShowing >= numInList) {
            button.hide();
          }
      });

});

jQuery(document).ready(function(){

      var list = jQuery(".selfPaced_courseBoxNew3");
      var numToShow = 2;
      var numToShowe = 12;
      var button = jQuery(".sp_viewAll3");
      var numInList = list.length;
      list.hide();
      button.hide();
      if (numInList > numToShow) {
        button.show();
      }
      list.slice(0, numToShow).show();

      button.click(function(){
          var showing = list.filter(':visible').length;
          list.slice(showing - 1, showing + numToShowe).fadeIn();
          var nowShowing = list.filter(':visible').length;
          if (nowShowing >= numInList) {
            button.hide();
          }
      });

});





/*Chandan==================================================================*/

/* Bannerjs start here */$().ready(function(){
  $('.slick-carousel').slick({
    arrows: false,
    centerPadding: "0px",
    dots: false,
    slidesToShow: 1,
    autoplay: true,
    infinite: false
  });
});
/* Bannerjs end here */



$('a[data-slide]').click(function(e) {
  e.preventDefault();
  var slideno = $(this).data('slide');
  $('.slider-nav').slick('slickGoTo', slideno - 1);
});

/* testimonial js start here */
$(".person-slider.new-faculty-sec").not(".slick-initialized").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    rows: 0,
    dots: !0,
    arrows: !1,
    adaptiveHeight: !1,
    infinite: !1,
    cssEase: "linear",
    autoplay: true,
    responsive: [{
        breakpoint: 769,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
    }]
});

$(".person-slider").not(".slick-initialized").slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    rows: 0,
    dots: !0,
    arrows: !1,
    adaptiveHeight: !1,
    infinite: !1,
    cssEase: "linear",
    autoplay: true,
    responsive: [{
        breakpoint: 769,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
    }]
});

/* testimonial js End here */

/* Tab js start here */
$(".tabs li").click(function() {
    var t = $(this).attr("data-tab");
    $(".tabs li").removeClass("current"), $(".tabs-content").removeClass("current"), $(this).addClass("current"), $("#" + t).addClass("current")
}),

$(".menu-tab li").click(function() {
    var t = $(this).attr("data-tab");
    $(".menu-tab li").removeClass("current"), $(".menu-tab li").removeClass("current"), $(this).addClass("current"), $("#" + t).addClass("current"), $("#" + t).fadeIn(), $("#" + t).siblings().fadeOut()
});
/* Tab js End here */


$(".alumni_playBtn").on("click", function() {
    $("#video")[0].src = $("#video").attr("src") + "?autoplay=1", $(".alumni-banner .video-sec").addClass("active"), $(".alumni-trigger").addClass("hidden")
});
/* Menu js start here */
$(".open-menu").on("click", function() {
    $(".menu-blk").addClass("active");
    var t = $(this).attr("data-id");
    console.log("lol"), $("#" + t).show(), $("#" + t).siblings().hide(), $("html,body").addClass("flow")
}), $(".menu-close-btn").on("click", function() {
    $(".menu-blk").removeClass("active"), $("html,body").removeClass("flow")
}), $(".ham").on("click", function() {
    $(".mobile-menu").addClass("active"), $("html,body").addClass("flow")
}), $(".mobile-menu-close").on("click", function() {
    $(".mobile-menu").removeClass("active"), $("html,body").removeClass("flow")
}), $(".callback ul .call").on("click", function() {
    $(".callback ul").fadeOut(300), $(".callback,.callback-blk").fadeIn(300)
}), $(".close-back").on("click", function() {
    $(".callback ul").fadeIn(300), $(".callback-blk").fadeOut(300)

}), $(".mobile_EmbeddedLeadForm").on("click", function() {
    $(".mobile_EmbeddedLeadForm").fadeOut(300), $(".mobile_EmbeddedLeadForm,.callback-blk").fadeIn(300)
}), $(".close-back").on("click", function() {
    $(".mobile_EmbeddedLeadForm").fadeIn(300), $(".callback-blk").fadeOut(300)
});
// For HP callback form start
if (jQuery(window).width() > 768) {
  if(jQuery("#callback").is(":visible")){       
    jQuery("#callback_mobile").remove();
}
}

if (jQuery(window).width() < 768) {
  if(jQuery("#callback_mobile").is(":visible")){       
    jQuery("#callback").remove();
}
}
// For HP callback form end

$(".accord-btn").on("click", function() {
    console.log(0), $(this).hasClass("active") ? ($(".accord-btn").removeClass("active"), $(".accord-content").stop(!0, !0).slideUp()) : ($(".accord-btn").removeClass("active"), $(".accord-content").stop(!0, !0).slideUp(), $(this).addClass("active"), $(this).parent(".accord-blk").find(".accord-content").slideDown())
});
/* Menu js End here */
$('#slick1_partners').slick({
    rows: 2,
    dots: true,
    arrows: false,
    infinite: true,
    autoplay: true,
    slidesToShow: 5,
    slidesToScroll: 1
});

$(".slider-primary").not(".slick-initialized").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    rows: 0,
    dots: !0,
    arrows: !0,
    nextArrow: '<img class="arrow-left" src="/india/themes/custom/nexus/assets/images/forward-arrow-2.png">',
    prevArrow: '<img class="arrow-right" src="/india/themes/custom/nexus/assets/images/Back-arrow-2.png">',
    infinite: !1,
    appendArrows: ".left-event .arrows",
    appendDots: ".arrows .dots-item",
    responsive: [{
        breakpoint: 769,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2
        }
    }, {
        breakpoint: 640,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
    }]
}), $(window).width() <= 1024 && $(".mob-slider").not(".slick-initialized").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: !1,
    draggable: !0,
    dots: !1,
    responsive: [{
        breakpoint: 769,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
    }]
});

$(".slider.slider-for").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: !1,
    dots: !1,
    infinite: true,
    autoplay: true,
    asNavFor: ".slider.slider-nav"
}), $(".slider.slider-nav").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: true,
    arrows: !0,
    infinite: true,
    autoplay: true,
    focusOnSelect: !1,
    nextArrow: '<img src="/india/themes/custom/nexus/assets/images/forward-arrow.png" class="arrow-right" alt="next">',
    prevArrow: '<img src="/india/themes/custom/nexus/assets/images/Back-arrow.png" class="arrow-left" alt="previous">',
    asNavFor: ".slider.slider-for",
    responsive: [{
        breakpoint: 769,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: !0,
            arrows: !1
        }
    }]
});
function headerMenuOpenClose(nid){
    jQuery('.mob-2ndlevel-menu .menu_categoryOpen a').empty();
    jQuery('.mob-2ndlevel-menu .menu_categoryOpen a').append('<i class="fa fa-angle-down"></i>');
    jQuery('.mob-2ndlevel-menu .menu_categoryOpen a.clickToOpenMenu-'+nid).empty();
    jQuery('.mob-2ndlevel-menu .menu_categoryOpen a.clickToOpenMenu-'+nid).append('<i class="fa fa-angle-up"></i>');
    jQuery('.mob-2ndlevel-menu .accord-content-level-3').css("display","none");
    jQuery('.mob-2ndlevel-menu .menu_categoryOpen-'+nid).css("display","block");
}

$('.courseSecNewTabs .dropdown-menu li.dropdown-item a').on('click', function() {
  var getValue = $(this).text();
  $('.courseSecNewTabs .dropdown a.dropdown-toggle b').text(getValue);
});


jQuery(function ($) { 

  $(document).delegate('.only-numeric-value','keypress', function(e) {
      //var regex = /^\d+$/;
      var regex = /^[0-9\b]*$/;
      var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
      if (regex.test(str)) {
          return true;
      }

      e.preventDefault();
      return false;
  });
});
// Js for selfPaced
   
    $('.tabselect2').click(function() {
       
        $('.new_sp_productTestimonial .advancedprog1').hide();
        $('.new_sp_productTestimonial .advancedprog3').hide();
        $('.new_sp_productTestimonial .advancedprog2').show();
        $('.new-hp-page-wrapper .populareevents1').hide();
        $('.new-hp-page-wrapper .populareevents3').hide();
        $('.new-hp-page-wrapper .populareevents2').show();
        $('.new_sp_productTestimonial .populararticless1').hide();
        $('.new_sp_productTestimonial .populararticless3').hide();
        $('.new_sp_productTestimonial .populararticless2').show();
        $('.card-slider4').slick("refresh");
        $('.card-slider5').slick("refresh");
        $('.slider-primary').slick("refresh");
    });
 
    $('.tabselect1').click(function() {
        
        $('.new_sp_productTestimonial .advancedprog1').show();
        $('.new_sp_productTestimonial .advancedprog3').hide();
        $('.new_sp_productTestimonial .advancedprog2').hide();
        $('.new-hp-page-wrapper .populareevents1').show();
        $('.new-hp-page-wrapper .populareevents3').hide();
        $('.new-hp-page-wrapper .populareevents2').hide();
        $('.new_sp_productTestimonial .populararticless1').show();
        $('.new_sp_productTestimonial .populararticless3').hide();
        $('.new_sp_productTestimonial .populararticless2').hide();
        $('.card-slider4').slick("refresh");
        $('.card-slider5').slick("refresh");
        $('.slider-primary').slick("refresh");
    });

    $('.tabselect3').click(function() {
        
        $('.new_sp_productTestimonial .advancedprog1').hide();
        $('.new_sp_productTestimonial .advancedprog3').show();
        $('.new_sp_productTestimonial .advancedprog2').hide();
        $('.new-hp-page-wrapper .populareevents1').hide();
        $('.new-hp-page-wrapper .populareevents3').show();
        $('.new-hp-page-wrapper .populareevents2').hide();
        $('.new_sp_productTestimonial .populararticless1').hide();
        $('.new_sp_productTestimonial .populararticless3').show();
        $('.new_sp_productTestimonial .populararticless2').hide();
        $('.card-slider4').slick("refresh");
        $('.card-slider5').slick("refresh");
        $('.slider-primary').slick("refresh");
    });



//animation trigger on click
$(".download-btn").click(function() {
  $(".download").toggleClass("download--animate");
  $(".bar").toggleClass("bar--animate");
  $(".btn__arrow").toggleClass("btn__arrow--animate");
  $(".btn__stop").toggleClass("btn__stop--animate");
  $(".btn__done").toggleClass("btn__done--animate");
});

/*var IDLE_TIMEOUT = 60; //seconds
var _idleSecondsCounter = 0;


document.onclick = function () {
    _idleSecondsCounter = 0;
};

document.onmousemove = function () {
    _idleSecondsCounter = 0;
};

document.onkeypress = function () {
    _idleSecondsCounter = 0;
};

document.onscroll = function () {
    _idleSecondsCounter = 0;
};

window.setInterval(CheckIdleTime, 1000);

function CheckIdleTime() {
    _idleSecondsCounter++;
    var oPanel = document.getElementById("SecondsUntilExpire");
    if (oPanel)
        oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
    if (_idleSecondsCounter >= IDLE_TIMEOUT) {
        acquireIO.max();
        IDLE_TIMEOUT = 15000;
    }
}
*/


if($(".hidedefaulthdrftrnw").is(":visible")){
      $(".new_hp_header").hide();
      $(".new-hp-footer").hide();
    }



jQuery(document).ajaxComplete(function(){

  if(window.outerWidth < 769) {
    if($('div[role="alert"]').is(':visible'))
        {
          $('.landing-embed-form .js-form-submit').css('margin-top','69px');
        }

       
    $(".landing-embed-form").attr("id", "multistepsform");            
    //$(".landing-embed-form #ms-ajax-form-example").attr("id", "multistepsform");
    //$(".landing-embed-form").prepend("<fieldset id='fieldsetids'><legend id='legendsid'><i>Start Your Application</i></legend>");
    $(".landing-embed-form .checkEligibTitle").hide();
    $(".landing-embed-form #form-wrapper").appendTo(".landing-embed-form #fieldsetids");
    $(".landing-embed-form .js-form-item-enqry-f-nm").hide(); 
    $(".landing-embed-form .js-form-item-enqry-crsspndnc-mbl").hide();
    $(".landing-embed-form .suffix-privacy-policy").hide();
    $(".landing-embed-form .embed-popup-btn").hide();
    $(".landing-embed-form input[name='enqry_f_nm']").after("<i class='fa fa-arrow-left previous action-button action-button-prev2'></i>");
    $(".landing-embed-form .action-button-prev2").click(function() {
              $(".landing-embed-form .js-form-item-enqry-crsspndnc-mbl").show();
              $(".landing-embed-form .js-form-item-enqry-f-nm").hide();
              $(".landing-embed-form .suffix-privacy-policy").hide();
              $(".landing-embed-form .step-one-dis").hide();

            }); 
    $(".landing-embed-form input[name='enqry_crsspndnc_eml']").after("<input type='button' name='next' class='next action-button action-button-email' value='Next'>");

    $(".landing-embed-form .action-button-email").click(function() {
      $(".landing-embed-form .js-form-item-enqry-crsspndnc-mbl").show();
      $(".landing-embed-form .js-form-item-enqry-crsspndnc-eml").hide();
      $(".landing-embed-form .usernm_new").hide();
      $(".landing-embed-form input[name='enqry_crsspndnc_mbl']").after("<i class='fa fa-arrow-left previous action-button action-button-prev1'></i>");
      $(".landing-embed-form input[name='enqry_crsspndnc_mbl']").after("<input type='button' name='next' class='next action-button action-button-mbl' value='Next'>");
      
      $(".landing-embed-form .action-button-prev1").click(function() {
        
        $(".landing-embed-form .js-form-item-enqry-crsspndnc-mbl").hide();
        $(".landing-embed-form .js-form-item-enqry-crsspndnc-eml").show();
        $(".landing-embed-form .usernm_new").show();
        $(".landing-embed-form .suffix-privacy-policy").hide();
        
      });

      $(".landing-embed-form .action-button-mbl").click(function() {
        $(".landing-embed-form .js-form-item-enqry-crsspndnc-mbl").hide();
        $(".landing-embed-form .js-form-item-enqry-f-nm").show();
        $(".landing-embed-form .embed-popup-btn").show();
        $(".landing-embed-form .suffix-privacy-policy").show();
        $(".landing-embed-form .step-one-dis").show();
        $(".landing-embed-form .form-submit").switchClass('leadLightBoxSubBtn','action-button'); 
        $(document).ajaxComplete(
          function(){
           $(".landing-embed-form #multistepsform").attr("id", "ms-ajax-form-example");
           $(".landing-embed-form #legendsid").hide();
             
          })

      });
       

    });
    
  }

})

 //tabbing js
 $(document).ready(function() {
  // Add minus icon for collapse element which is open by default
  $(".collapse.in").each(function() {
    $(this)
    .siblings(".faq-res-heading")
    .find(".glyphicon")
    .addClass("rotate");
  });
  
  // Toggle plus minus icon on show hide of collapse element
  $(".collapse")
    .on("show.bs.collapse", function() {
    $(this)
      .parent()
      .find(".glyphicon")
      .addClass("rotate");
    })
    .on("hide.bs.collapse", function() {
    $(this)
      .parent()
      .find(".glyphicon")
      .removeClass("rotate");
    });
  });





/*
if ($(".signin-user").is(":visible") == true) { 
    $(".homepagemultistepformformid").show(); 
}else {
    $(".homepagemultistepformformid").hide(); 
}*/


$('.payment-mode .pay-right .tab-content .tab-pane:first-child').addClass('active');
$('.payment-mode .pay-tabs-left li:first-child').addClass('active top');


/*jQuery(".register_otp_check_hp").click(function() {
   var pattern=/^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[6789]\d{9}$/; 
          var values_mobile = $(this).val();
            if(!pattern.test(values_mobile)) { 
              
              $('input[name="enqry_crsspndnc_mbl_new"]').after(" <h6 name='liked_txt_mbl' class='mt-2 liked_txt_mbl'>Please Enter Valid Mobile Number</h6>");
              $('input[name="enqry_crsspndnc_mbl_new"]').css('border-color', 'red');
              $('h6[name="liked_txt_mbl"]').css('color', 'red');
             
            }
           else{  
            jQuery("#third-form").removeClass("homepageformhide");
            jQuery("#first-form").addClass("homepageformhide");
          }
});*/


