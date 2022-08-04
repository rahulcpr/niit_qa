jQuery(document).ready(function($){

   if ((jQuery(".nav-tabs li").hasClass("active ss0"))){
        jQuery('.testimonial-ind-slider').hide();        
        jQuery('.testimonial-pro-slider').hide();
   }

    jQuery('.ss0 a').click(function(){
        jQuery('.testimonial-stu-slider').show();
        jQuery('.testimonial-ind-slider').hide();        
        jQuery('.testimonial-pro-slider').hide();
    });
    jQuery('.ss1 a').click(function(){
        jQuery('.testimonial-stu-slider').hide();
        jQuery('.testimonial-pro-slider').show();
        jQuery('.testimonial-ind-slider').hide();
        
            });
     jQuery('.ss2 a').click(function(){
        jQuery('.testimonial-stu-slider').hide();
        jQuery('.testimonial-pro-slider').hide();
        jQuery('.testimonial-ind-slider').show();
    });
 });

(function ($, Drupal) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {

    }
  };
})(jQuery, Drupal);


'use strict';
( function ( document, window, index )
{
    
    var inputs = document.querySelectorAll( '.form-file' );
    Array.prototype.forEach.call( inputs, function( input )
    {
        var label    = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.querySelector( 'span' ).innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });

        // Firefox bug fix
        input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
        input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
    });
}( document, window, 0 ));

//call javascript method define on top for SEO purspecive
$("#appointmentCounselor").click(function () {
    var eventName = "Appointment With Counselor";
    var formIdName = "appointment_for_counselor";
    onFormSuccess(eventName,formIdName);
});

function onFormSuccess(eventName,formIdName) {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
    event: eventName, // form event name should be changed according to forms.
    formId: formIdName //form id needs to be changed for each form depending on hard codes
    });
    // Rest of the success callback code
}

// Custom JS for common operations.
jQuery(function ($) {
    // Toggle header and remove link in menu.
    if ($('.navKnowledgeCenter').length) {
        $(".navKnowledgeCenter").attr('href', 'javascript://');
    }
    if ($('.navAlumni').length) {
        $(".navAlumni").attr('href', 'javascript://');
    }
    if ($('.navPlacement').length) {
        $(".navPlacement").attr('href', 'javascript://');
    }

    // Preloader for page load
    $("#preloader").fadeOut(500);


/////////////////////////////////////////////////////////////////////// For
// Lead form page
    $('.lead-form-label').removeClass('visually-hidden');
    $('.lead-form-group input, .lead-form-group textarea').focus(function () {
        $(this).parents().parents('.lead-form-group').addClass('lead-focused');
    });
    $('.lead-form-group input, .lead-form-group textarea').blur(function () {
        var inputValue = $(this).val();
        if (inputValue == "") {
            $(this).removeClass('filled');
            $(this)
            .parents()
            .parents('.lead-form-group')
            .removeClass('lead-focused');
        }
        else {
            $(this).addClass('filled');
        }
    });

/////////////////////////////////////////////////////////////////////// For
// Category Page Filterby Option 
     $('#filterby').click(function() {
        $(this).toggleClass('active');
        $('.checkdata').toggle();
      });
    $( window ).resize(function() {
        if( $( window ).width()>767){
          $('.checkdata').toggle(true);
        }else{
          $('.checkdata').toggle(false);
        }
    });




});
// For FB Plugin in home page
(function ($) {
    var a = null;
    $(window).resize(function () {
        if (a != null) {
            clearTimeout(a);
        }
        a = setTimeout(function () {
          // FB.XFBML.parse();
        }, 1000);
    });
})(jQuery);


// Get city based on state selection in lead form.
jQuery(document).ready(function ($) {

    if ($('#edit-location').length) {
        $('#edit-location').on("change", function (event) {
            event.preventDefault();
            var selectHtml = '<option value="-none-">City</option>';
            // Get state id.
            var idCIty = $(this).val();
            //  Get all cities based on state.
            jQuery.ajax({
                // Views rest export fetching data.
                url: '/india/state/' + idCIty + '?_format=json',
                data: {},
                success: function (data) {
                    var jsonParseData = JSON.stringify(data);
                    var parseJson = JSON.parse(jsonParseData);
                    // Loop to create select list.
                    for (var i = 0, l = parseJson.length; i < l; i++) {
                        var option = parseJson[i];
                        // Split array and get city id with name.
                        var cityData = option.city.split('::');
                        // city[0] is key and city[1] is name of city.
                        if (typeof(cityData[0]) === 'string' && typeof(cityData[1]) === 'string') {
                            selectHtml += '<option value=' + cityData[0] + '>' + cityData[1] + '</option>';
                        }
                        else {
                            selectHtml += '<option value=' + i + '>' + option.city + '</option>';

                        }
                    }
                    // Append html.
                    document.getElementById("edit-city").disabled = false;
                    $('#edit-city').html(selectHtml);
                },
                type: 'GET'
            });
            return false;
        });
    }


    if ($('.GetinTouch').length) {
        $('#edit-city').on("change", function (event) {
            event.preventDefault();
            var selectHtml = '<option value="-none-">Center</option>';
            // Get state id.
            var idCIty = $(this).val();
            //  Get all cities based on state.
            jQuery.ajax({
                // Views rest export fetching data.
                url: '/india/centre/' + idCIty + '?_format=json',
                data: {},
                success: function (data) {
                    var jsonParseData = JSON.stringify(data);
                    var parseJson = JSON.parse(jsonParseData);
                    // Loop to create select list.
                    for (var i = 0, l = parseJson.length; i < l; i++) {
                        var option = parseJson[i];
                        // Split array and get city id with name.
                        var cityData = option.city.split('::');
                        // city[0] is key and city[1] is name of city.
                        if (typeof(cityData[0]) === 'string' && typeof(cityData[1]) === 'string') {
                            selectHtml += '<option value=' + cityData[0] + '>' + cityData[1] + '</option>';
                        }
                        else {
                            selectHtml += '<option value=' + i + '>' + option.city + '</option>';

                        }
                    }
                    // Append html.
                    document.getElementById("edit-center").disabled = false;
                    $('#edit-center').html(selectHtml);
                },
                type: 'GET'
            });
            return false;
        });
    }
});


/* To Enrollment for placement : Start*/

jQuery(function(){
    jQuery("#edit-upload-jd-recruitment").on('change', function(){
        /* get select value to perform show hide action on upload file */
        var uploadDoc = jQuery("#edit-upload-jd-recruitment").val(); 
        /* Hide upload feature only if nothing is selected else show */
        if(uploadDoc == 'upload-jd') {
            jQuery("#fill_up_required_form").hide();
            jQuery("#show_all_section").hide();
            jQuery("#upload_document_id").show();
             
        }
        else if(uploadDoc == 'fill-jd'){
            jQuery("#upload_document_id").hide();
            jQuery("#fill_up_required_form").show();
            jQuery("#show_all_section").show();
         }
        else{
         jQuery("#upload_document_id").hide(); 
         jQuery("#fill_up_required_form").hide();
         jQuery("#show_all_section").hide();
        } 
    });
    
    function destroyCarousel() {
        if (jQuery('.scrolllist').hasClass('slick-initialized')) {
            jQuery('.scrolllist').slick('unslick');
        }
    }   
    
/* center list search form */ 
jQuery('#searchSubmit').on('click', function (event){
document.getElementById('searching-centre').style.display="block";
//enable new div when NO Centre available on page load for the first time
var centreAvailableTrue = document.getElementById('messageifno').textContent;
if (centreAvailableTrue != 'NIIT Centre for You') {
    document.getElementById('ParentCenterDiv').style.display='block';    
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
var proceedButtonLink = document.getElementById("proceedButtonLink").value;
var courseBatchDetailRes = document.getElementById('courseBatchDetailRes').value;
var requestUrl = url;
if(searchCity == "Delhi-Ncr" || searchCity == "New Delhi" || searchCity == "Delhi" || searchCity == "Gurgaon" || searchCity == "gurgaon" || searchCity == "Noida" || searchCity == "noida" || searchCity == "Ghaziabad" || searchCity == "ghaziabad" || searchCity == "Faridabad" || searchCity == "faridabad" ){
    var olsearchCity = "Delhi-Ncr";
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
        proceedButtonLink : proceedButtonLink,
        currentUrl : currentUrl
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
        
                jQuery('#messageifno').text("NIIT Centre for You");
                jQuery(".scrolllist").html('');
                jQuery('#CenterDiv').html(data);
                jQuery('[data-toggle="tooltip"]').tooltip();
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
                        adaptiveHeight: true,
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
                                    centerMode: false,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                }, 500);
        
        }
            });
 });

// Set selected city into city search field
jQuery(".citylist li").click(function ()
{
document.getElementById('searching-centre').style.display="block";
//enable new div when NO Centre available on page load for the first time
var centreAvailableTrue = document.getElementById('messageifno').textContent;
if (centreAvailableTrue != 'NIIT Centre for You') {
    document.getElementById('ParentCenterDiv').style.display='block';    
}
var currentUrl      = window.location.href;
var spanId = jQuery('#'+this.id+' span').attr("id");
var spanValue = jQuery("#"+spanId).text();
var requestUrl = "/india/citySearchFormREquest.php";
var searchCity = spanValue;
var courseBatchDetailRes = document.getElementById('courseBatchDetailRes').value;
var latitude = document.getElementById('location_lat').value;
var longitude = document.getElementById('location_long').value;
var checkedLocation = document.getElementById("checkedLocation").value;
var enrollNow = document.getElementById("enrollNow").value;
var basePath = document.getElementById("basePath").value;
var proceedButtonLink = document.getElementById("proceedButtonLink").value;
jQuery("#searchCity").val(spanValue);
jQuery('.citylist li').removeClass('active');
jQuery('#'+this.id+' span').parent('li').addClass('active');
jQuery.post(requestUrl,
    {
        searchCity: searchCity,
        checkedLocation : checkedLocation,
        latitude : latitude,
        longitude : longitude,
        courseBatchDetailRes: courseBatchDetailRes,
        enrollNow : enrollNow,
        basePath : basePath,
        proceedButtonLink : proceedButtonLink,
        currentUrl : currentUrl
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

                jQuery('#messageifno').text("NIIT Centre for You");
                jQuery(".scrolllist").html('');
                jQuery('#CenterDiv').html(data);
                jQuery('[data-toggle="tooltip"]').tooltip();
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
                        adaptiveHeight: true,
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
                                    centerMode: false,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                }, 500);
                
                
        }
            });

});
// show Tooltip on mouse hover
jQuery('[data-toggle="tooltip"]').tooltip();

// Search center using pressing of Enter Key
jQuery("#myform").submit(function (e) {
    e.preventDefault();
    
 document.getElementById('searching-centre').style.display="block";
     //enable new div when NO Centre available on page load for the first time
        var centreAvailableTrue = document.getElementById('messageifno').textContent;
        if (centreAvailableTrue != 'NIIT Centre for You') {
            document.getElementById('ParentCenterDiv').style.display='block';    
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
            var olsearchCity = "Delhi-Ncr";
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
                proceedButtonLink : proceedButtonLink,
                currentUrl : currentUrl
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
        
                jQuery('#messageifno').text("NIIT Centre for You");
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
});
// End get list

});

jQuery(function(){
    jQuery("#edit-industry").on('change', function(){
        /* get select value to perform show hide action on upload file */
        var selBox = jQuery("#edit-industry").val();
        /* Hide upload feature only if nothing is selected else show */
        if(selBox == 'others') {
            jQuery("#edit-other-text").val('');
            jQuery("#otherText").show();
        }
        else{
            jQuery("#otherText").hide();
            jQuery("#edit-other-text").val('');

        }
    });

});


/* To Enrollment for placement : End*/



/* To Enrollment for placement : End*/

function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              getCenterList();
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } 
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}


//Function to be called on click on explore more centre
function exploremorecheck() {
    var searchCity = document.getElementById('searchCity').value;
        if(searchCity == "Delhi-Ncr" || searchCity == "New Delhi" || searchCity == "Delhi"){
            searchCity = "Delhi-NCR";
        }
    var currentUrl      = window.location.href;
    var requestUrl = "/india/citySearchFormREquestExploreButton.php";
    var courseBatchDetailRes = document.getElementById('courseBatchDetailRes').value;
    var latitude = document.getElementById('location_lat').value;
    var longitude = document.getElementById('location_long').value;
    var checkedLocation = document.getElementById("checkedLocation").value;
    var enrollNow = document.getElementById("enrollNow").value;
    var basePath = document.getElementById("basePath").value;
    var proceedButtonLink = document.getElementById("proceedButtonLink").value;
    jQuery.post(requestUrl,
        {
            searchCity: searchCity,
            checkedLocation : checkedLocation,
            latitude : latitude,
            longitude : longitude,
            courseBatchDetailRes: courseBatchDetailRes,
            enrollNow : enrollNow,
            basePath : basePath,
            proceedButtonLink : proceedButtonLink,
            currentUrl : currentUrl
        },
                function(data, status){
                destroyCarousel();  
                
                if (data == 1){ 
                jQuery(".scrolllist").html('');
                jQuery('#CenterDiv').html('');
                jQuery('#messageifno').text("No centre available");
                
            }
            else{

                    jQuery('#messageifno').text("NIIT Centre for You");
                    jQuery(".scrolllist").html('');
                    jQuery('#CenterDiv').html(data);
                    jQuery('[data-toggle="tooltip"]').tooltip();
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
                            adaptiveHeight: true,
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
                                        centerMode: false,
                                        slidesToScroll: 1
                                    }
                                }
                            ]
                        });
                    }, 500);
                    
                    
            }
        });
}


function radioButtonClick(id){
    $("div.upcomingBatchesPrice").hide();
    $("#priceSection" + id).show();
    $(".instructorsFaculty div.instructorSec").hide();
    $("#instructorSec-" + id).show();
}


jQuery(document).ready(function(){

    if($('.ProductBox.blog-details-wrp .blog-details').is(':visible')){
        $('.ProductBox.blog-details-wrp .blog-details ul').removeClass("r-tabs-nav");
        $('.ProductBox.blog-details-wrp .blog-details ul li').removeClass("r-tabs-tab");
    }

    $("#myModal-videos").on('hidden.bs.modal', function (e) {
        $("#myModal-videos iframe").attr("src", $("#myModal-videos iframe").attr("src"));
    });

    $("#user_account_modal_form").on('hidden.bs.modal', function (e) {
        $('.click_by_modular input').val('0');
    });

    if($('.OutTopolacement #exampleSlider5').is(':visible')){
        if (jQuery(window).width() > 992) {
            var numItems = jQuery('#exampleSlider5 .MS-content .item').length;
            if(numItems <= 3){
                jQuery('#exampleSlider5 .MS-controls').hide();
            }else{
                jQuery('#exampleSlider5 .MS-controls').show();
            }
        }else{
            var numItems = jQuery('#exampleSlider5 .MS-content .item').length;
            if(numItems <= 3){
                jQuery('#exampleSlider5 .MS-controls').show();
            }else{
                jQuery('#exampleSlider5 .MS-controls').hide();
            }
        }
    }
    if($('.career-pagemainsection #exampleSlider111-0').is(':visible')){
        if (jQuery(window).width() > 992) {
            var numItems = jQuery('#exampleSlider111-0 .MS-content .item').length;
            if(numItems <= 3){
                jQuery('#exampleSlider111-0 .MS-controls').hide();
            }else{
                jQuery('#exampleSlider111-0 .MS-controls').show();
            }
        }else{
            var numItems = jQuery('#exampleSlider111-0 .MS-content .item').length;
            if(numItems <= 3){
                jQuery('#exampleSlider111-0 .MS-controls').show();
            }else{
                jQuery('#exampleSlider111-0 .MS-controls').hide();
            }
        }
    }
    jQuery( window ).resize(function() {
        if($('.OutTopolacement #exampleSlider5').is(':visible')){
            if (jQuery(window).width() > 992) {
                var numItems = jQuery('#exampleSlider5 .MS-content .item').length;
                if(numItems <= 3){
                    jQuery('#exampleSlider5 .MS-controls').hide();
                }else{
                    jQuery('#exampleSlider5 .MS-controls').show();
                }
            }else{
                var numItems = jQuery('#exampleSlider5 .MS-content .item').length;
                if(numItems <= 3){
                    jQuery('#exampleSlider5 .MS-controls').show();
                }else{
                    jQuery('#exampleSlider5 .MS-controls').hide();
                }
            }
        }
        if($('.career-pagemainsection #exampleSlider111-0').is(':visible')){
            if (jQuery(window).width() > 992) {
                var numItems = jQuery('#exampleSlider111-0 .MS-content .item').length;
                if(numItems <= 3){
                    jQuery('#exampleSlider111-0 .MS-controls').hide();
                }else{
                    jQuery('#exampleSlider111-0 .MS-controls').show();
                }
            }else{
                var numItems = jQuery('#exampleSlider111-0 .MS-content .item').length;
                if(numItems <= 3){
                    jQuery('#exampleSlider111-0 .MS-controls').show();
                }else{
                    jQuery('#exampleSlider111-0 .MS-controls').hide();
                }
            }
        }
    });
});