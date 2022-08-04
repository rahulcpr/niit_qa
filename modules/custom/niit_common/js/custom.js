(function ($) {
    'use strict';
    Drupal.behaviors.niit_common = {
        attach: function (context, settings) {
            // Team js fixes for showing popup.
            if (context == '[object HTMLFormElement]') {
                var eventCarousel=jQuery('.event_carousel');

                $.each(eventCarousel,function(index,eventCarousalElem){
                    if(!$(eventCarousalElem).is('.slick-initialized')){

                        $(eventCarousalElem).slick({
                            infinite: true,
                            arrows: true,
                            speed: 500,
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            autoplay: false,
                            autoplaySpeed: 3000,
                            adaptiveHeight: true,
                            responsive: [
                                {
                                    breakpoint: 1200,
                                    settings: {
                                        slidesToShow: 2,
                                        autoplay: false,
                                        slidesToScroll: 1,
                                        infinite: true
                                    }
                                }, {
                                    breakpoint: 1024,
                                    settings: {
                                        slidesToShow: 2,
                                        autoplay: false,
                                        slidesToScroll: 1
                                    }
                                }, {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 2,
                                        autoplay: false,
                                        slidesToScroll: 1
                                    }
                                }, {
                                    breakpoint: 600,
                                    settings: {
                                        slidesToShow: 1,
                                        adaptiveHeight: true,
                                        autoplay: false,
                                        slidesToScroll: 1
                                    }
                                }
                            ]
                        });
                    }
                });


                var sliderForCenter = jQuery('.slider4aply');
                $.each(sliderForCenter, function (index, eventCarousalElem) {
                    if (!$(eventCarousalElem).is('.slick-initialized')) {

                        $(eventCarousalElem).slick({

                                infinite: true,
                                arrows: true,
                                speed: 500,
                                slidesToShow: 4,
                                slidesToScroll: 1,
                                autoplay: false,
                                autoplaySpeed: 3000,
                                adaptiveHeight: true,
                                responsive: [{
                                    breakpoint: 1200,
                                    settings: {
                                        slidesToShow: 3,
                                        autoplay: false,
                                        slidesToScroll: 1,
                                        infinite: true
                                    }
                                }, {
                                    breakpoint: 1024,
                                    settings: {
                                        slidesToShow: 2,
                                        autoplay: false,
                                        slidesToScroll: 1
                                    }
                                }, {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 2,
                                        autoplay: false,
                                        slidesToScroll: 1
                                    }
                                }, {
                                    breakpoint: 600,
                                    settings: {
                                        slidesToShow: 1,
                                        adaptiveHeight: true,
                                        autoplay: false,
                                        slidesToScroll: 1
                                    }
                                }]
                            }
                        );
                    }
                });

            }
        }

    };
}(jQuery));

/*
jQuery(".jobtypecheckbox1").click(function(){
    var allSelect = [];
    jQuery.each(jQuery("input[name='check_school_nid']:checked"), function(){            
        allSelect.push(jQuery(this).val());
    });
    var allSelectmain = allSelect.toString();
    if (allSelect.length === 0) {
    }else {
         console.log(allSelectmain);
    }

});


jQuery(".categorytypecheckbox").click(function(){
  var allSelectcat = [];
  jQuery.each(jQuery("input[name='check_category_type']:checked"), function(){            
    allSelectcat.push(jQuery(this).val());
  });
  var allSelectmainone = allSelectcat.toString();
  if (allSelectcat.length === 0) {
    }else {
         console.log(allSelectmainone);
    }
});



jQuery(".locationvalue1").click(function(){
  var allSelectloc = [];
  jQuery.each(jQuery("input[name='check_location_val']:checked"), function(){            
    allSelectloc.push(jQuery(this).val());
  });
  var allSelectmaintwo = allSelectloc.toString();
  if (allSelectloc.length === 0) {
    
  }else {
     console.log(allSelectmaintwo);
  }
});*/

jQuery( document ).ready(function() {
jQuery(".hr-career-jobList .hr-job-filter .filer-checkbox input[type='checkbox']").click(function(){
    
    var allSelect = [];
    jQuery.each(jQuery(".hr-career-jobList .hr-job-filter .filer-checkbox input[name='check_school_nid']:checked"), function(){            
        allSelect.push(jQuery(this).val());

    });
    
    if (allSelect.length === 0) {
         var jobtype = 'jobtype';
    }else{
        var jobtype = allSelect.toString();
    }

    

    var allSelectcat = [];
    jQuery.each(jQuery(".hr-career-jobList .hr-job-filter .filer-checkbox input[name='check_category_type']:checked"), function(){            
        allSelectcat.push(jQuery(this).val());
    });
    
    if (allSelectcat.length === 0) {
         var Categoryid = 'Categoryid';
    }else{
        var Categoryid = allSelectcat.toString();
    }
    
    
    var allSelectloc = [];
      jQuery.each(jQuery(".hr-career-jobList .hr-job-filter .filer-checkbox input[name='check_location_val']:checked"), function(){            
        allSelectloc.push(jQuery(this).val());
      });
      
      if (allSelectloc.length === 0) {
         var CountryKey = 'CountryKey';
        }else{
            var allSelectloc1 = allSelectloc.join('^');
            var CountryKey = allSelectloc1.toString();
        }

   
     var Keyword = 'Keyword';

   /*var urlfortest = '/career-job-vacancy/'+CountryKey+'/'+Categoryid+'/'+Keyword+'/'+jobtype;
    */
        
   
     jQuery.ajax({
            url : '/india/career-job-vacancy/'+CountryKey+'/'+Categoryid+'/'+Keyword+'/'+jobtype,
            type: 'POST',
            beforeSend: function(){
                jQuery('#job_loader').append('<center class="job_loader_load"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...</center>');
            },
            success: function(response) {
                
                   jQuery(".career-job-vacancy-data").replaceWith('<div class="career-job-vacancy-data">'+response.data+'</div>');
                   jQuery('#job_loader').replaceWith('<div id="job_loader"></div>');
                   jQuery('#loadMorecareernew').hide();
            }
        }); 
    

    });
});


jQuery( document ).ready(function() {

    jQuery(document).on("click",".job_filter .search_career",function() {
        var Keyword = 'Keyword';
        if(jQuery('.job_filter .keyword_career').val()){
          Keyword = jQuery('.job_filter .keyword_career').val();
        }
        var CountryKey = 'CountryKey';
        if(jQuery('.job_filter .country_career').val()){
          CountryKey = jQuery('.job_filter .country_career').val();
        }
        var Categoryid = 'Categoryid';
        if(jQuery('.job_filter .category_career').val()){
          Categoryid = jQuery('.job_filter .category_career').val();
        }
        var jobtype = 'jobtype';

        jQuery.ajax({
            url : '/india/career-job-vacancy/'+CountryKey+'/'+Categoryid+'/'+Keyword+'/'+jobtype,
            type: 'POST',
            beforeSend: function(){
                jQuery('#job_loader').append('<center class="job_loader_load"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...</center>');
            },
            success: function(response) {
                
                   jQuery(".career-job-vacancy-data").replaceWith('<div class="career-job-vacancy-data">'+response.data+'</div>');
                   jQuery('#job_loader').replaceWith('<div id="job_loader"></div>');
                   jQuery('#loadMorecareernew').hide();
            }
        });
    });

    jQuery(document).on("click",".course_filter_main .search_career",function() {
		//alert();
		var Nid = jQuery('#pageNodeId').text();
        var Iama = 'Iama';
        if(jQuery('.course_filter_main .category_iama').val()){
          Iama = jQuery('.course_filter_main .category_iama').val();
        }
		//alert(Iama);
        var Looking = 'Looking';
        if(jQuery('.course_filter_main .category_looking').val()){
          Looking = jQuery('.course_filter_main .category_looking').val();
        }
        var Studying = 'Studying';
        if(jQuery('.course_filter_main .category_studying').val()){
          Studying = jQuery('.course_filter_main .category_studying').val();
        }
        

        jQuery.ajax({
			url : '/india/top-category-filter/'+Iama+'/'+Looking+'/'+Studying+'/'+Nid,
            type: 'POST',
            beforeSend: function(){
                jQuery('#course_filter_loader').append('<center class="job_loader_load"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...</center>');
            },
            success: function(response) {
                console.log(response.data);
                   jQuery(".coursefilterdata").replaceWith('<div class="coursefilterdata">'+response.data+'</div>');
                   jQuery('#course_filter_loader').replaceWith('<div id="course_filter_loader"></div>');
                   jQuery('#loadMorecareernew').hide();
            }
        });
    });
    
});




jQuery( document ).ready(function() {
jQuery(".center-information-new .center-course-details, .center-information-new .center-city-details ").on('change',function(){

    var courseTypeId = jQuery('.center-course-details-1').val();

    
    
    var cityCode = jQuery('.center-course-details-2').val();
    
    
   

     jQuery.ajax({
      url : '/india/centerInformationDetailsApi',
      type: 'POST',
      data: {courseTypeId: courseTypeId, cityCode: cityCode},
      beforeSend: function(){
          jQuery('#job_loader').append('<center class="job_loader_load"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...</center>');
      },
      success: function(response) {
          
              jQuery(".career-center-details").replaceWith('<div class="career-center-details">'+response.data+'</div>');
                   jQuery('#job_loader').replaceWith('<div id="job_loader"></div>');
                   jQuery('#loadMorecareernew').hide();
            }
        }); 
    

    });
});



function toggleIcon(e) {
 jQuery(e.target)
    .prev('.panel-heading')
    .find(".more-less")
    .toggleClass('glyphicon-plus glyphicon-minus');
}



(function ($) {

  $('.carousel-showmanymoveone .item').each(function(){
    var itemToClone = $(this);  
    

    for (var i=1;i<4;i++) {
      itemToClone = itemToClone.next();

 
      if (!itemToClone.length) {
        itemToClone = $(this).siblings(':first');
      }

      itemToClone.children(':first-child').clone()
        .addClass("cloneditem-"+(i))
        .appendTo($(this));
    }
  });

  $('.custom-page-sliders').each(function() {
    var id = jQuery(this).attr(id);
      $('#'+id).carousel({ interval: 2000 });
  });

 

}(jQuery));




function mycareerFunction() {
    var input, filter, ul, li, label, j, txtValue;
    input = document.getElementById("mycareerInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (j = 0; j < li.length; j++) {
        label = li[j].getElementsByTagName("label")[0];
        txtValue = label.textContent || label.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[j].style.display = "";
        } else {
            li[j].style.display = "none";
        }
    }
}










