'use strict';
var serverRootPath = window.serverRootPath;
// const serverRootPath = "http://localhost/niit/files/";

var $ = jQuery.noConflict();

// this code only applicable on placement and center page.
var completeUrl = window.location.href.split("/");
var lasturl = completeUrl.pop();
var centerType = completeUrl[4];
var flagApiCall = true;
if(lasturl == 'student' || lasturl == 'recruiter' || lasturl == 'enroll-for-placement')
{
    flagApiCall = false;
}
if(centerType == 'centre' || centerType == 'center')
{
    flagApiCall = false;
}
// Check if its a mobile browser
(function (a) {
    (jQuery.browser = jQuery.browser || {}).mobile = /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4));
})(navigator.userAgent || navigator.vendor || window.opera);

function openNav(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("navUL");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}``




									jQuery(".Faculty").slick({
									dots: false,        
									infinite: true,
									arrows: true,
									speed: 500,
									slidesToShow: 1,
									slidesToScroll: 1,
									autoplay:false,
									autoplaySpeed:3000,
									responsive: [{
									breakpoint: 1200,
									settings: {
									slidesToShow: 1,
									slidesToScroll: 1,
									infinite: true                
									}
									}, {
									breakpoint: 1024,
									settings: {
									slidesToShow: 1,
									slidesToScroll: 1
									}
									}, {
									breakpoint: 600,
									settings: {
									slidesToShow: 1,
									slidesToScroll: 1
									}
									}, {
									breakpoint: 490,
									settings: {
									slidesToShow: 1,
									slidesToScroll: 1
									}
									}]
									 });



var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

var getUrlArrayParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    var values = [];
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            values.push(sParameterName[1]);
        }
    }
    return values;
};

function getTrimmedContent(htmlText, length) {
    
    var $str1 = jQuery(htmlText); //this turns your string into real html
    
    var pText = $str1.text();
    if (!length) {
        length = 200;
    }
    
    return pText.slice(0, length);
}

function distance(lat1, lon1, lat2, lon2, unit) {
    var radlat1 = Math.PI * lat1 / 180;
    var radlat2 = Math.PI * lat2 / 180;
    var theta = lon1 - lon2;
    var radtheta = Math.PI * theta / 180;
    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
    if (dist > 1) {
        dist = 1;
    }
    dist = Math.acos(dist);
    dist = dist * 180 / Math.PI;
    dist = dist * 60 * 1.1515;
    if (unit == "K") {
        dist = dist * 1.609344;
    }
    if (unit == "N") {
        dist = dist * 0.8684;
    }
    return dist;
}

function getRandom(arr, n) {
    var result = new Array(n),
        len = arr.length,
        taken = new Array(len);
    if (n > len) return false;
    while (n--) {
        var x = Math.floor(Math.random() * len);
        result[n] = arr[x in taken ? taken[x] : x];
        taken[x] = --len in taken ? taken[len] : len;
    }
    return result;
}

function playYoutubeVideo(youtubeUrl) {
    jQuery('#youtube-modal').modal('show');
    var embedLink = "https://www.youtube.com/embed/" + youtubeEmbedLink(youtubeUrl);
    jQuery('#youtube-modal iframe').attr("src", embedLink);
}

jQuery('#youtube-modal').on('hidden.bs.modal', function (e) {
    jQuery('#youtube-modal iframe').attr("src", "");
});

function youtubeEmbedLink(url) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);

    if (match && match[2].length == 11) {
        return match[2];
    } else {
        return 'error';
    }
}

/* for privacy policy checkbox*/
jQuery( ".privacy-policy-pop-submit" ).click(function() {
 
  if(jQuery('.privacy-policy-pop').is(":checked") == false)
    {  alert("You must accept the privacy policy to submit this form.");
        return;
    } 
});

jQuery( ".privacy-policy-pop-submit2" ).click(function() {
 
  if(jQuery('.privacy-policy-pop2').is(":checked") == false)
    {  alert("You must accept the privacy policy to submit this form.");
        return;
    } 
});

jQuery( ".privacy-policy-pop-submit3" ).click(function() {

    if(jQuery('.privacy-policy-pop3').is(":checked") == false)
    {  alert("You must accept the privacy policy to submit this form.");
        return;
    }
});

jQuery( ".privacy-policy-pop-submit4" ).click(function() {

    if(jQuery('.privacy-policy-pop4').is(":checked") == false)
    {  alert("You must accept the privacy policy to submit this form.");
        return;
    }
});

/* end privacy policy*/

jQuery(document).ready(function($) {

    /*FOR OFFER BAR CLOSE*/
    $(document).on('click', '.offer_top_bar .close_offer', function(){
        $(this).parents('.offer_top_bar').fadeOut();
    });


    $(function () {
        var url = '';

        $('.specialmentor').click(function () {
            url = $(this).attr("data-id");
            $('.specialmentorbody').fadeIn(200);
            // Finally you reasign the URL back to your iframe, so when you hide and load it again you still have the link
            $('.specialmentorbody iframe').attr('data-src', url);
            $('.specialmentorbody iframe').attr('src', url);
        });

        $('.mentorclose').click(function () {
            $('.specialmentorbody').hide();
            // Finally you reasign the URL back to your iframe, so when you hide and load it again you still have the link
            $('.specialmentorbody iframe').attr('data-src','');
            $('.specialmentorbody iframe').attr('src','');
        });
      var testimonial_url = '';

      var career_play = ''; 
      
        $('.career_play').click(function() {

            career_play = $(this).attr("data-id");
            
            $('.career_model_body').fadeIn(200);
            // Finally you reasign the URL back to your iframe, so when you hide and load it again you still have the link
            $('.career_model_body iframe').attr('data-src', career_play);
            $('.career_model_body iframe').attr('src', career_play);
        });

       

        $('.testimonialplay').click(function() {
            testimonial_url = $(this).attr("data-id");
            $('.testimonila_model_body').fadeIn(200);
            // Finally you reasign the URL back to your iframe, so when you hide and load it again you still have the link
            $('.testimonila_model_body iframe').attr('data-src', testimonial_url);
            $('.testimonila_model_body iframe').attr('src', testimonial_url);
        });

         $('.careervideoclose').click(function() {
            $('.career_model_body').hide();
            //Then assign the src to null, this then stops the video been playing
            $('.career_model_body iframe').attr('data-src', '');
            $('.career_model_body iframe').attr('src', '');
        });
        $('.testimonialclose').click(function() {
            $('.testimonila_model_body').hide();
            //Then assign the src to null, this then stops the video been playing
            $('.testimonila_model_body iframe').attr('data-src', '');
            $('.testimonila_model_body iframe').attr('src', '');
        });

        var megaUrl = "";
        $('.megadriveplay').click(function() {
            megaUrl = $(this).attr("data-id");
            $('.megadriveplaydiv').fadeIn(200);
            // Finally you reasign the URL back to your iframe, so when you hide and load it again you still have the link
            $('.testimonila_model_body iframe').attr('data-src', megaUrl);
            $('.megadriveplaydiv iframe').attr('src', megaUrl);
        });

        $('.megadriveclose').click(function() {
            $('.megadriveplaydiv').hide();
            //Then assign the src to null, this then stops the video been playing
            $('.megadriveplaydiv iframe').attr('data-src', '');
            $('.megadriveplaydiv iframe').attr('src', '');
        });


    });
});


jQuery(function () {
    var sidebarFirst = document.getElementById("sidebar-first");
    if (document.getElementById("sidebar-container")) {
        document.getElementById("sidebar-container").appendChild(sidebarFirst);
    }
});


jQuery(function () {
    jQuery("#explore-more-courses").click(function (event) {
        event.preventDefault();
        var activeTab = jQuery(".active").find("a").attr("href");

        var query = "";
        switch (activeTab) {
            case "#tab-1":
                query = "?keys=&f%5B0%5D=course_domain_category%3A428";
                break;
            case "#tab-2":
                query = "?keys=&f%5B0%5D=course_domain_category%3A427";
                break;
            case "#tab-3":
                query = "?keys=&f%5B0%5D=course_domain_category%3A426";
                break;
			case "#tab-4":
                query = "?keys=&f%5B0%5D=course_category%3A254";
                break;	
            default:
                break;
        }
        window.location.href = serverRootPath + "search/content" + query;
    });
});

jQuery(function () {
	
var nodeBundle = jQuery('#pageNodeBundle').text();	
if(nodeBundle == 'course_category'){
    if(flagApiCall == true) {
        // TOP NAVIGATION MENU CONTENT
        jQuery.get(serverRootPath + "category-taxonomy?_format=json", function (data) {
            
            //top-course-category
            data.forEach(function (taxonomy) {
                jQuery("#leadform-coursetype").append("<option value=\"" + taxonomy.uuid[0].value + "\">" + taxonomy.name[0].value + "</option>");
            });
            var taxonomies = data;
            jQuery.get(serverRootPath + "top-course-category?_format=json", function (ccData) {

                ccData.forEach(function (cc) {
                    cc.courses = [];
                });

                /* taxonomies.forEach(function (taxonomy) {
                     taxonomy.topCourseCategories = ccData.slice();
                 });*/

                var uriCategory = getUrlParameter('c');

                var url = window.location.href.split("/");

                // for local envirnment change it with url[3] / url [4]
                var categoryType1 = url[4];
                var categoryType2 = url[5];

                ccData.forEach(function (category) {
                    var courseUrl1 = '';
                    var courseUrl2 = '';
                    if (category.path[0] && category.path[0].alias) {
                        courseUrl1 = category.path[0].alias.split("/")[1];
                        courseUrl2 = category.path[0].alias.split("/")[2];
                    }

                    if (courseUrl1 === categoryType1 && courseUrl2 === categoryType2) {

                        jQuery("#top-category-name").html(category.title[0].value + " ");
                        jQuery(".top-category-name").html(category.title[0].value + " ");
                        //INSERT BANNER HERE
                        var bannerImage = category.field_category_banner_image[0] ? category.field_category_banner_image[0].url : window.serverRootPath + 'themes/custom/nexus/assets/images/category-banner.jpg';

                        var bannerImageMobile = category.field_banner_image_mobile[0] ? category.field_banner_image_mobile[0].url : window.serverRootPath + 'themes/custom/nexus/assets/images/category-banner-m.jpg';

                        var bannerContent = category.field_banner_content[0] ? category.field_banner_content[0].value : '';

                        var innerHtml = "\n <img src=\"" + bannerImage + "\" class=\"hide600\" width=\"\" height=\"\">\n <img src=\"" + bannerImageMobile + "\" class=\"show600\" width=\"\" height=\"\">\n <div class=\"contantbox\">\n " + bannerContent + "\n </div>\n ";
                        jQuery("#category-banner").html(innerHtml);

                        // WHY IT IS BOOMING SECTION
                        var boomingImage = category.field_booming_section_image[0] ? category.field_booming_section_image[0].url : window.serverRootPath + "themes/custom/nexus/assets/images/cat-videobg.jpg";
                        var boomingVideo = category.field_booming_sectiob_video[0] ? category.field_booming_sectiob_video[0].value : undefined;
                        var boomingInnerHtml = "\n <div class=\"container fullwidth\">\n <div class=\"row\">\n <div class=\"col-md-6 rightimgwidth\">\n <div class=\"rightwrap\">\n <img src=\"" + boomingImage + "\" width=\"\" height=\"\" class=\"scale\">\n                                    " + (boomingVideo ? "\n                                    <div class=\"play\">\n                                        <a data-youtube=\"" + boomingVideo + "\"><i class=\"far fa-play-circle\"></i></a>\n                                    </div>\n                                    " : '') + "\n                                </div>\n                            </div>\n                            <div class=\"col-md-6\">\n                                <div class=\"leftwrap\">\n                                    <div class=\"headding text-left\">\n                                    <h2>" + (category.field_booming_section_heading[0] ? category.field_booming_section_heading[0].value : "") + "</h2>\n                                    <span></span>\n                                </div>\n                                <div class=\"talentbox-wrap1\">\n                                    <div class=\"GlobalBox\">\n                                        <div class=\"row\">\n                                            " + (category.field_booming_point_1_image[0] && category.field_booming_point_1_text[0] ? "\n                                            <div class=\"col-xs-6\"> \n                                                <div class=\"catfourbox\"><div class=\"circleBox\"><img src=\"" + category.field_booming_point_1_image[0].url + "\"></div><h2>" + category.field_booming_point_1_text[0].value + "</h2></div>\n                                            </div>\n                                            " : "") + "\n                                            " + (category.field_booming_point_2_image[0] && category.field_booming_point_2_text[0] ? "\n                                            <div class=\"col-xs-6\"> \n <div class=\"catfourbox\"><div class=\"circleBox\"><img src=\"" + category.field_booming_point_2_image[0].url + "\"></div><h2>" + category.field_booming_point_2_text[0].value + "</h2></div>\n </div>\n " : "") + "\n " + (category.field_booming_point_3_image[0] && category.field_booming_point_3_text[0] ? "\n <div class=\"col-xs-6\"> \n <div class=\"catfourbox\"><div class=\"circleBox\"><img src=\"" + category.field_booming_point_3_image[0].url + "\"></div><h2>" + category.field_booming_point_3_text[0].value + "</h2></div>\n </div>\n " : "") + "\n " + (category.field_booming_point_4_image[0] && category.field_booming_point_4_text[0] ? "\n <div class=\"col-xs-6\"> \n <div class=\"catfourbox\"><div class=\"circleBox\"><img src=\"" + category.field_booming_point_4_image[0].url + "\"></div><h2>" + category.field_booming_point_4_text[0].value + "</h2></div>\n </div>\n " : "") + "\n </div>\n</div>\n </div>\n</div>\n </div>\n </div>\n <div class=\"clr\"></div>\n </div>\n ";
                        jQuery("#why-it-is-booming").html(boomingInnerHtml);

                        //Alumni Speaks
                        
                        if (category.field_category_alumni_speaks.length > 0) {
                            jQuery.get(serverRootPath + "alumni-speak?_format=json", function (alumniSpeakList) {
                                var innerHtml = '';
                                
                                window.alumniSpeakList = [];
                                alumniSpeakList.forEach(function (alumni) {
                                    category.field_category_alumni_speaks.forEach(function (courseAlumni) {
                                        if (alumni.uuid[0].value == courseAlumni.target_uuid) {
                                            window.alumniSpeakList.push(alumni);
                                            
                                            var thumbImg = alumni.field_thumbnail_image[0] ? alumni.field_thumbnail_image[0].url : '';
                                            var name = alumni.field_alumni_name[0] ? alumni.field_alumni_name[0].value : '';
                                            var bannerImage = alumni.field_banner_image[0] ? alumni.field_banner_image[0].url : '';
                                            var speakText = alumni.metatag.value.description;
                                            var alumniVideo = alumni.field_alumni_video[0] ? alumni.field_alumni_video[0].value : undefined;
                                            innerHtml = innerHtml + ("\n                                                <div class=\"alumni-speak-item\" data-merge=\"2\">\n                                                    <div class=\"alumni_wrap\">\n                                                    \t<img class=\"hide600\" data-lazy=\"" + bannerImage + "\" width=\"\" height=\"\">\n                                                        <img class=\"show600\" data-lazy=\"" + bannerImage + "\" width=\"\" height=\"\">\n                                                    \t<div class=\"alumni_content\">\n                                                            <div class=\"alumni_shortdesc\">\n                                                            <div class=\"tophead\">\n                                                                <div class=\"headding text-center colorwhite\">\n                                                                    <h2>Alumni Speak </h2>\n                                                                    <h3>Find out what our Alumni have to say.</h3>\n                                                                    <span></span>\n                                                                </div>\n                                                                " + (alumniVideo ? "\n                                                                    <div class=\"playbutton\"><a data-youtube=\"" + alumniVideo + "\"><i class=\"fas fa-play\"></i></a></div>\n                                                                " : "") + "\n                                                                <div class=\"testi-txt\"><p>\u201C" + speakText + "\u201D</p></div>\n                                                            </div>\n                                                            </div>\n                                                        </div>\n                                                    </div>\n                                                </div>\n                                        ");
                                        }
                                    });
                                });
                               
                                jQuery("#alumni-speak-category").html(innerHtml);
                                jQuery('#alumni-speak-category').slick({
                                    infinite: true,
                                    arrows: true,
                                    speed: 500,
                                    lazyLoad: 'ondemand',
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    autoplay: true,
                                    autoplaySpeed: 3000,
                                    adaptiveHeight: false,
                                    responsive: [{
                                        breakpoint: 1200,
                                        settings: {
                                            slidesToShow: 1,
                                            autoplay: true,
                                            slidesToScroll: 1,
                                            infinite: true
                                        }
                                    }, {
                                        breakpoint: 1024,
                                        settings: {
                                            slidesToShow: 1,
                                            autoplay: true,
                                            slidesToScroll: 1
                                        }
                                    }, {
                                        breakpoint: 768,
                                        settings: {
                                            slidesToShow: 1,
                                            autoplay: true,
                                            slidesToScroll: 1
                                        }
                                    }, {
                                        breakpoint: 600,
                                        settings: {
                                            slidesToShow: 1,
                                            adaptiveHeight: true,
                                            autoplay: true,
                                            slidesToScroll: 1
                                        }
                                    }]
                                });
                            });
                        }

                        if (jQuery("#placementPartnerCompany")) {
                            
                            jQuery.get(serverRootPath + "niit-placement-companies?_format=json", function (data) {
                                var filteredComs = [];
                                var innerHtml = "";
                                data.forEach(function (company) {
                                    category.field_c_placement_company_list.forEach(function (catCompany) {
                                        if (company.uuid[0].value == catCompany.target_uuid) {
                                            if (!company.field_company_logo[0]) {
                                                return;
                                            }
                                            filteredComs.push(catCompany);
                                            innerHtml = innerHtml + ("\n                                        <div class=\"cus-sayingtxt\">\n                                        <img data-lazy=\"" + company.field_company_logo[0].url + "\" style=\"width:unset; margin: auto;\">\n                                        </div>\n                                        ");
                                        }
                                    });
                                });
                                if (filteredComs.length == 0) {
                                    jQuery("#placement-parent").hide();
                                }
                                jQuery("#placementPartnerCompany").html(innerHtml);
                                jQuery("#placementPartnerCompany").slick({
                                    dots: false,
                                    infinite: true,
                                    arrows: true,
                                    lazyLoad: 'ondemand',
                                    speed: 500,
                                    slidesToShow: 5,
                                    centerMode: true,
                                    centerPadding: '0px',
                                    slidesToScroll: 1,
                                    autoplay: true,
                                    autoplaySpeed: 3000,
                                    responsive: [{
                                        breakpoint: 1200,
                                        settings: {
                                            slidesToShow: 4,
                                            slidesToScroll: 1,
                                            infinite: true
                                        }
                                    }, {
                                        breakpoint: 1024,
                                        settings: {
                                            slidesToShow: 3,
                                            slidesToScroll: 1
                                        }
                                    }, {
                                        breakpoint: 600,
                                        settings: {
                                            slidesToShow: 1,
                                            slidesToScroll: 1
                                        }
                                    }, {
                                        breakpoint: 490,
                                        settings: {
                                            slidesToShow: 1,
                                            slidesToScroll: 1
                                        }
                                    }]
                                });
                            });
                        }
                    }
                });
                taxonomies.forEach(function (taxonomy) {
                    taxonomy.topCourseCategories = [];
                    ccData.forEach(function (cc) {
                        taxonomy.topCourseCategories.push({
                            "title": cc.title,
                            "uuid": cc.uuid,
                            "courses": [],
                            "path": cc.path[0] && cc.path[0].alias ? cc.path[0].alias.substr(1) : "node/" + cc.nid[0].value
                        });
                    });
                    // taxonomy.topCourseCategories.forEach(function (cc) {
                    //     cc.courses = [];
                    // });
                });
                jQuery.get(serverRootPath + "trending-courses?_format=json", function (trendingCoursesData) {
                    window.trendingCoursesData = trendingCoursesData;
                    trendingCoursesData.forEach(function name(course) {
                        if (course.field_catgory[0] && course.field_catgory[0].target_uuid && course.field_top_course_category[0] && course.field_top_course_category[0].target_uuid) {
                            taxonomies.forEach(function (taxonomy) {
                                if (taxonomy.uuid[0].value == course.field_catgory[0].target_uuid) {
                                    taxonomy.topCourseCategories.forEach(function (topCourseCategory) {
                                        if (topCourseCategory.uuid[0].value == course.field_top_course_category[0].target_uuid) {
                                            topCourseCategory.courses.push(course);
                                        }
                                    });
                                }
                            });
                        }
                    });
                    for (var k = 0; k < taxonomies.length; k++) {
                        for (var j = 0; j < taxonomies[k].topCourseCategories.length; j++) {
                            if (taxonomies[k].topCourseCategories[j].courses.length === 0) {
                                taxonomies[k].topCourseCategories.splice(j, 1);
                                j--;
                            }
                        }
                    }
                    

                    jQuery("#top-nav-calc").html("\n                <li>\n                    <a class=\"navPlacement\" href=\"#placement-assistance\">Placements</a>\n                </li>\n                <li>\n                    <a class=\"navAlumni\" href=\"#alumni\">Alumni</a>\n                </li>\n                <li>\n                    <a class=\"navKnowledgeCenter\" href=\"#knowledge-center\">Knowledge\n                        Center</a>\n                </li>\n                ");

                    var menuInnerHtml = "";
                    taxonomies.forEach(function (taxonomy) {
                        var taxonomyLi = "\n                    \n                    <li>\n                    <a href=\"javascript://\">" + taxonomy.name[0].value + "</a>\n                    <span class=\"arrow pull-right sub1\">&nbsp;</span>\n                    <div class=\"stage2Nav\">\n                    <ul class=\"subNavUL\">\n                    \n                    ";
                        taxonomy.topCourseCategories.forEach(function (courseCategory) {
                            
                            taxonomyLi = taxonomyLi + ("\n                        <li>\n                        <a href=\"" + window.serverRootPath + courseCategory.path + "?t=" + taxonomy.uuid[0].value + "&c=" + courseCategory.uuid[0].value + "\">" + courseCategory.title[0].value + "</a>\n                        <span class=\"arrow pull-right sub2\">&nbsp;</span>\n                        <div class=\"stage3Nav\">\n                        <ul class=\"subNavUL3\">\n                        ");
                            courseCategory.courses.forEach(function (course) {
                                var path = course.path[0] && course.path[0].alias ? course.path[0].alias.substr(1) : "node/" + course.nid[0].value;
                                var title = course.field_course_short_name[0] ? course.field_course_short_name[0].value : course.title[0].value;
                                var fullTitle = course.title[0].value;
                                
                                path = path.replace(/^\//, '');
                                
                                var courseUrl = "" + window.serverRootPath + path;
                                var t = course.field_catgory[0] ? "t=" + course.field_catgory[0].target_uuid : '';
                                var enquireUrl = window.serverRootPath + "lead-form?ref=course&course=" + course.uuid[0].value + "&" + t;
                                jQuery(".node-" + course.nid[0].value).attr("href", courseUrl);
                                jQuery(".enquire-" + course.nid[0].value).attr("href", enquireUrl);
                                taxonomyLi = taxonomyLi + ("\n                            <li><a href=\"" + courseUrl + "\">" + title + "</a> \n                            <span class=\"arrow pull-right sub3\">&nbsp;</span>\n                            <div class=\"stage4Nav\">\n                            <ul class=\"righttnav\">\n                            <div class=\"menuright-box\">\n                            <img src=\"" + (course.field_course_image[0] ? course.field_course_image[0].url : '') + "\" class=\"scale\" alt=\"img\">\n                            <div class=\"detailbox\">\n                            <p>" + fullTitle + "</p>\n                            <p>" + (course.field_course_short_description[0] ? course.field_course_short_description[0].value : '') + "</p>\n                            <a class=\"enroll\" href=\"" + course.field_enroll_now_link[0].value + "\">Enroll Now</a> \n                            </div>\n                            </div>\n                            </ul>\n                            </div>\n                            </li>");
                            });
                            taxonomyLi = taxonomyLi + "\n                        </ul>\n                        </div>\n                        </li>\n                        ";
                        });
                        taxonomyLi = taxonomyLi + "\n                    </div>\n                    </li>\n                    ";
                        menuInnerHtml = menuInnerHtml + taxonomyLi;
                    });
                    jQuery("#top-nav-calc").prepend(menuInnerHtml);
                    window.placementAssistedProgram = [];
                    window.trendingCoursesData.forEach(function (course) {
                        if (course.field_is_placement_assisted[0] && course.field_is_placement_assisted[0].value) {
                            window.placementAssistedProgram.push(course);
                        }
                    });
                    if (jQuery('#assuredJobContainer')) {
                        var limit = window.placementAssistedProgram.length;
                        for (var i = 0; i < limit; i++) {
                            var course = window.placementAssistedProgram[i];
                            
                            var colour;
                            if (course.field_colour[0]) {
                                colour = course.field_colour[0].value;
                            } else {
                                colour = "#75c2be";
                            }
                            var image = course.field_course_image[0] ? course.field_course_image[0].url : '';
                            var name = course.title[0] ? course.title[0].value : '';
                            var trial = course.field_course_trial[0] ? course.field_course_trial[0].value : '';
                            var duration = course.field_course_duration[0] ? course.field_course_duration[0].value : '';
                            var certification = course.field_course_certification[0] ? course.field_course_certification[0].value : '';
                            var startDate = course.field_course_starting_on[0] ? course.field_course_starting_on[0].value : '';
                            // var enrolNowLink = course.field_enroll_now_link[0]? course.field_enroll_now_link[0].value : '';
                            var enrolNowLink = window.location.origin + ("/india/lead-form?course=" + course.nid[0].value);
                            var path = course.path[0] && course.path[0].alias ? course.path[0].alias.substr(1) : "node/" + course.nid[0].value;
                            var knowMoreLink = "" + window.serverRootPath + path;
                            var rating = course.field_rating[0] ? course.field_rating[0].value : 0;
                            var ratingElement = "";

                            jQuery('#assuredJobContainer').append("\n<div class=\"col-xs-12\">\n <div class=\"cat-item\">\n <div class=\"img\"><img data-lazy=\"" + image + "\" alt=\"img\"></div>\n                        <div class=\"overlay\"><div  class=\"head\">" + name + "</div>\n                        <div class=\"info finance\" style=\"background-color: " + colour + "\">\n                        <div class=\"detailsinfo\">\n<h3> <a  href=\"" + knowMoreLink + "\">" + name + "</a> <span></span></h3>\n<p>Duration: " + duration + "<br>Certification: " + certification + "<br>Batches starting soon</p>\n<a class=\"enrollbtn\" href=\"" + enrolNowLink + "\">Enquire Now  </a>\n <a class=\"enrollbtn\" href=\"" + knowMoreLink + "\">Know More </a>\n</div>\n</div>\n</div>\n</div>\n</div>\n\t\t\t\t\t\t\n");
                        }

                        if (window.placementAssistedProgram.length > 4) {
                            jQuery('#assuredSeeMore').show();
                        }
                        if (!jQuery.browser.mobile) {
                            jQuery(".assuredJobContainer-parent .slick-arrow").hide();
                        }
                        jQuery(".assuredJobContainer-parent .slick-arrow").show();

                        jQuery(".slider5aply").slick({
                            infinite: true,
                            arrows: true,
                            speed: 500,
                            lazyLoad: 'ondemand',
                            slidesToShow: 4,
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

                    if (jQuery("#niit-community-container")) {
                        jQuery.get(serverRootPath + "our-amazing-network?_format=json", function (networks) {
                            var randomFour = getRandom(networks, 4);
                            if (!randomFour) {
                                return;
                            }
                            
                            var innerHtml = "\n<div class=\"arrowslick\">\n<div class=\"col-xs-12 col-sm-4\">\n                        <div class=\"achieve-box\">\n                            <div class=\"img-box square\">\n                                <img src=\"" + (randomFour[0].field_natwork_image[0] ? randomFour[0].field_natwork_image[0].url : '') + "\" class=\"scale\" alt=\"img\">\n                                <div class=\"overlay videoo\">\n                                    <div class=\"head\">\n                                        <h3>\n                                            " + (randomFour[0].title[0] ? randomFour[0].title[0].value : '') + "\n                                        </h3>\n                                        <p>" + (randomFour[0].field_short_text[0] ? randomFour[0].field_short_text[0].value : '') + "</p>\n                                        " + (randomFour[0].field_youtube_video[0] ? "\n                                        <p>\n                                        " + (randomFour[0].field_natwork_facebook[0] ? "\n                                            <a href=\"" + randomFour[0].field_natwork_facebook[0].value + "\">\n                                                <i class=\"fab fa-facebook-f\"></i>\n                                            </a>\n                                        " : '') + "\n                                        " + (randomFour[0].field_natwork_twitter[0] ? "\n                                            <a href=\"" + randomFour[0].field_natwork_twitter[0].value + "\">\n                                                <i class=\"fab fa-twitter\"></i>\n                                            </a>\n                                        " : '') + "\n                                        " + (randomFour[0].field_natwork_instagram[0] ? "\n                                            <a href=\"" + randomFour[0].field_natwork_instagram[0].value + "\">\n                                                <i class=\"fab fa-instagram\"></i>\n                                            </a>\n                                        " : '') + "\n                                        </p>\n                                        " : "") + "\n                                    </div>\n                                    " + (randomFour[0].field_youtube_video[0] ? "\n                                        <a class=\"play\" data-youtube=\"" + randomFour[0].field_youtube_video[0].value + "\"><i class=\"far fa-play-circle\"></i></a>\n                                    " : "\n                                    <div class=\"info\">\n                                        <div class=\"detailsinfo\">\n                                            " + (randomFour[0].body[0] ? randomFour[0].body[0].value : '') + "\n                                        </div>\n                                    </div>\n                                    ") + "\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                    <div class=\"col-xs-12 col-sm-4\">\n                        <div class=\"achieve-box\">\n                            <div class=\"img-box square\">\n                                <img src=\"" + (randomFour[1].field_horizontal_image[0] ? randomFour[1].field_horizontal_image[0].url : '') + "\" class=\"scale\" alt=\"img\">\n                                <div class=\"overlay videoo\">\n                                    <div class=\"head\">\n                                        <h3>\n                                            " + (randomFour[1].title[0] ? randomFour[1].title[0].value : '') + "\n                                        </h3>\n                                        <p>\n                                            " + (randomFour[1].field_short_text[0] ? randomFour[1].field_short_text[0].value : '') + "\n                                        </p>\n                                    </div>\n                                    " + (randomFour[1].field_youtube_video[0] ? "\n                                        <a class=\"play\" data-youtube=\"" + randomFour[1].field_youtube_video[0].value + "\"><i class=\"far fa-play-circle\"></i></a>\n                                    " : "\n                                    <div class=\"info\">\n                                        <div class=\"detailsinfo\">\n                                            " + (randomFour[1].body[0] ? randomFour[1].body[0].value : '') + "\n                                        </div>\n                                    </div>\n                                    ") + "\n                                </div>\n                            </div>\n                            <div class=\"img-box square\">\n                                <img src=\"" + (randomFour[2].field_horizontal_image[0] ? randomFour[2].field_horizontal_image[0].url : '') + "\" class=\"scale\" alt=\"img\">\n                                <div class=\"overlay videoo\">\n                                    <div class=\"head\">\n                                        <h3>\n                                            " + (randomFour[2].title[0] ? randomFour[2].title[0].value : '') + "\n                                        </h3>\n                                        <p>\n                                            " + (randomFour[2].field_short_text[0] ? randomFour[2].field_short_text[0].value : '') + "\n                                        </p>\n                                    </div>\n                                    " + (randomFour[2].field_youtube_video[0] ? "\n                                        <a class=\"play\" data-youtube=\"" + randomFour[2].field_youtube_video[0].value + "\" href=\"\"><i class=\"far fa-play-circle\"></i></a>\n                                    " : "\n                                    <div class=\"info\">\n                                        <div class=\"detailsinfo\">\n                                            " + (randomFour[2].body[0] ? randomFour[2].body[0].value : '') + "\n                                        </div>\n                                    </div>\n                                    ") + "\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                    <div class=\"col-xs-12 col-sm-4\">\n                        <div class=\"achieve-box\">\n                            <div class=\"img-box square video\">\n                                <img src=\"" + (randomFour[3].field_natwork_image[0] ? randomFour[3].field_natwork_image[0].url : '') + "\" class=\"scale\" alt=\"img\">\n                                <div class=\"overlay videoo\">\n                                    <div class=\"head\">\n                                        <h3>\n                                            " + (randomFour[3].title[0] ? randomFour[3].title[0].value : '') + "\n                                        </h3>\n                                        <p>" + (randomFour[3].field_short_text[0] ? randomFour[3].field_short_text[0].value : '') + "</p>\n                                        " + (randomFour[3].field_youtube_video[0] ? "\n                                        <p>\n                                        " + (randomFour[3].field_natwork_facebook[0] ? "\n                                            <a href=\"" + randomFour[3].field_natwork_facebook[0].value + "\">\n                                                <i class=\"fab fa-facebook-f\"></i>\n                                            </a>\n                                        " : '') + "\n                                        " + (randomFour[3].field_natwork_twitter[0] ? "\n                                            <a href=\"" + randomFour[3].field_natwork_twitter[0].value + "\">\n                                                <i class=\"fab fa-twitter\"></i>\n                                            </a>\n                                        " : '') + "\n                                        " + (randomFour[3].field_natwork_instagram[0] ? "\n                                            <a href=\"" + randomFour[3].field_natwork_instagram[0].value + "\">\n                                                <i class=\"fab fa-instagram\"></i>\n                                            </a>\n                                        " : '') + "\n                                        </p>\n                                        " : "") + "\n                                    </div>\n                                    " + (randomFour[3].field_youtube_video[0] ? "\n                                        <a class=\"play\" data-youtube=\"" + randomFour[3].field_youtube_video[0].value + "\"><i class=\"far fa-play-circle\"></i></a>\n                                    " : "\n                                    <div class=\"info\">\n                                        <div class=\"detailsinfo\">\n                                            " + (randomFour[3].body[0] ? randomFour[3].body[0].value : '') + "\n                                        </div>\n                                    </div>\n                                    ") + "\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n                ";
                            jQuery("#niit-community-container").html(innerHtml);
                            jQuery('[data-youtube]').click(function (event) {
                               
                                var youtubeLink = jQuery(this).data("youtube");
                                playYoutubeVideo(youtubeLink);
                            });
                            jQuery("#niit-community-container .arrowslick").slick({
                                dots: false,
                                infinite: true,
                                arrows: false,
                                speed: 500,
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                centerMode: true,
                                centerPadding: '0px',
                                autoplay: false,
                                autoplaySpeed: 3000,
                                responsive: [{
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
                                }]
                            });
                        });
                    }

                    window.sameCategoryCourses = [];
                    if (window.courseTopCategory && window.courseId) {
                        window.trendingCoursesData.forEach(function (course) {
                            if (course.field_top_course_category[0] && course.field_top_course_category[0].target_uuid == window.courseTopCategory && course.nid[0].value != window.courseId) {
                                window.sameCategoryCourses.push(course);
                            }
                        });
                    }

                    

                    if (window.sameCategoryCourses.length > 0) {
                        if (jQuery('#relatedCourses')) {
                            var limit = window.sameCategoryCourses.length > 4 && !jQuery.browser.mobile ? 4 : window.sameCategoryCourses.length;
                            for (var i = 0; i < limit; i++) {
                                var course = window.sameCategoryCourses[i];

                                var colour;
                                if (course.field_colour[0]) {
                                    colour = course.field_colour[0].value;
                                } else {
                                    colour = "#75c2be";
                                }
                                var image = course.field_course_image[0] ? course.field_course_image[0].url : '';
                                var name = course.title[0] ? course.title[0].value : '';
                                var trial = course.field_course_trial[0] ? course.field_course_trial[0].value : '';
                                var duration = course.field_course_duration[0] ? course.field_course_duration[0].value : '';
                                var certification = course.field_course_certification[0] ? course.field_course_certification[0].value : '';
                                var startDate = course.field_course_starting_on[0] ? course.field_course_starting_on[0].value : '';
                                var enrolNowLink = window.location.origin + ("/india/lead-form?course=" + course.nid[0].value);
                                var path = course.path[0] && course.path[0].alias ? course.path[0].alias.substr(1) : "node/" + course.nid[0].value;
                                var knowMoreLink = "" + window.serverRootPath + path;
                                var rating = course.field_rating[0] ? course.field_rating[0].value : 0;
                                var ratingElement = "<div class=\"starrating\">";
                                for (var _i2 = 1; _i2 <= 5; _i2++) {
                                    if (_i2 <= rating) {
                                        ratingElement = ratingElement + ("<div class=\"rate-image star1-on even s" + _i2 + "\"></div>");
                                    } else {
                                        ratingElement = ratingElement + ("<div class=\"rate-image star-off odd s" + _i2 + "\"></div>");
                                    }
                                }
                                ratingElement = ratingElement + "</div>";
                                jQuery('#relatedCourses').append("\n                <div class=\"col-xs-12 col-sm-6 col-md-3\">\n<div class=\"cat-item\">\n <div class=\"img\"><img src=\"" + image + "\" alt=\"img\"></div>\n                <div class=\"overlay\"><div class=\"head\">" + name + "</div>\n <div class=\"info finance\" style=\"background-color: " + colour + "\">\n <div class=\"detailsinfo\">\n <h3>" + name + "  <span></span></h3>\n <p> " + trial + "<br> " + duration + "<br>Certification: " + certification + "<br>Batch starting soon </p>\n <a class=\"enrollbtn\" href=\"" + enrolNowLink + "\">Enquire Now  </a>\n <a class=\"enrollbtn\" href=\"" + knowMoreLink + "\">Know More </a>\n</div>\n</div>\n</div>\n</div>\n");
                            }


                            if (jQuery.browser.mobile) {
                                jQuery('#relatedCourses').owlCarousel({
                                    autoPlay: false,
                                    slideSpeed: 2000,
                                    pagination: false,
                                    navigation: true,
                                    items: 4,
                                    /* transitionStyle : "fade", */
                                    /* [This code for animation ] */
                                    navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                                    itemsDesktop: [1199, 3],
                                    itemsDesktopSmall: [980, 2],
                                    itemsTablet: [599, 1],
                                    itemsMobile: [479, 1]
                                });
                            }

                            if (window.sameCategoryCourses.length > 4) {
                                
                                jQuery('#assuredSeeMore').show();
                            } else {
                                
                                jQuery('#assuredSeeMore').hide();
                            }
                        }
                    } else {
                        jQuery("#relatedCoursesWholeContainerOnCoursePage").hide();
                    }

                    if (window.searchCenter && window.courseId) {
                        window.trendingCoursesData.forEach(function (course) {
                            if (course.uuid[0].value == window.courseId) {
                                if (course.field_course_center_code.length > 0) {
                                    jQuery.get(serverRootPath + "list-center?_format=json", function (centerList) {
                                        window.courseCenterList = [];
                                        window.stateList = [];
                                        centerList.forEach(function (center) {
                                           
                                            course.field_course_center_code.forEach(function (centerEntity) {
                                                if (center.uuid[0].value == centerEntity.target_uuid) {
                                                    window.courseCenterList.push(center);
                                                }
                                            });
                                            if (center.field_center_state[0] && center.field_center_state[0].value) {
                                                var state = {
                                                    "name": center.field_center_state[0].value,
                                                    cities: []
                                                };
                                                var stateSearchIndex = _.findIndex(window.stateList, function (o) {
                                                    return o.name == state.name;
                                                });
                                                if (stateSearchIndex != -1) {
                                                    state = window.stateList[stateSearchIndex];
                                                }
                                                if (center.field_center_city[0] && center.field_center_city[0].value) {
                                                    var city = {
                                                        "name": center.field_center_city[0].value,
                                                        centerList: []
                                                    };
                                                    var citySearchIndex = _.findIndex(state.cities, function (o) {
                                                        return o.name == city.name;
                                                    });
                                                    if (citySearchIndex != -1) {
                                                        city = state.cities[citySearchIndex];
                                                    }
                                                    city.centerList.push(center);
                                                    if (citySearchIndex == -1) {
                                                        state.cities.push(city);
                                                    }
                                                }
                                                if (stateSearchIndex == -1) {
                                                    window.stateList.push(state);
                                                }
                                            }
                                        });
                                        window.stateList.forEach(function (state) {
                                            jQuery("#stateSelect").append("\n                                <option value=\"" + state.name + "\">" + state.name + "</option>\n                                ");
                                        });
                                        jQuery("#stateSelect").change(function () {
                                            var val = jQuery(this).val();
                                            window.stateList.forEach(function (state) {
                                                if (state.name == val) {
                                                    jQuery("#stateCity").html('<option>Select City</option>');
                                                    state.cities.forEach(function (city) {
                                                        jQuery("#stateCity").append("\n                                            <option value=\"" + city.name + "\">" + city.name + "</option>\n                                            ");
                                                    });
                                                }
                                            });
                                        });
                                        jQuery("#stateCity").change(function () {
                                            var stateSelected = jQuery("#stateSelect").val();
                                            var citySelected = jQuery("#stateCity").val();
                                            window.stateList.forEach(function (state) {
                                                if (state.name == stateSelected) {
                                                    state.cities.forEach(function (city) {
                                                        if (city.name == citySelected) {
                                                            jQuery("#stateCenter").html("<option value=\"\">Select NIIT Center</option>");
                                                            city.centerList.forEach(function (center) {
                                                                
                                                                var title = center.title[0] ? center.title[0].value : 'NIIT Center';
                                                                var centerCode = center.field_center_code[0] ? center.field_center_code[0].value : "NIITCOM";
                                                                jQuery("#stateCenter").append("<option value=\"" + centerCode + "\">" + title + "</option>");
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        });
                                        
                                        var limit = window.courseCenterList.length > 3 ? 3 : window.courseCenterList.length;
                                        for (var _i3 = 0; _i3 < limit; _i3++) {
                                            var center = window.courseCenterList[_i3];
                                            var title = center.title[0] ? center.title[0].value : 'NIIT Center';
                                            var address = center.field_center_location[0] ? center.field_center_location[0].value : '';
                                            var city = center.field_center_city[0] ? center.field_center_city[0].value : '';
                                            var phone = center.field_center_phone[0] ? center.field_center_phone[0].value : '';
                                            var email = center.field_center_email[0] ? center.field_center_email[0].value : '';
                                            var lat = center.field_center_latitude[0] ? center.field_center_latitude[0].value : '';
                                            var long = center.field_center_longitude[0] ? center.field_center_longitude[0].value : '';
                                            var centerInnerHtml = "\n                                <div class=\"col-sm-4\">\n                                <div class=\"map-box\">\n                                <div class=\"detailbox\">\n                                <h2>" + title + "</h2>\n                                <p>" + address + "</p>\n                                <p><strong>City:</strong>" + city + "</p>\n                                <p>\n                                <strong>Phone:</strong>" + phone + "\n                                </p>\n                                <p>\n                                <strong>E-mail:</strong>" + email + "\n                                </p>\n                                <p>Directions:</p>\n                                </div>\n                                <div class=\"mapframe\">\n                                <iframe\n                                src=\"https://maps.google.com/maps?q=" + lat + "," + long + "&z=15&output=embed\"\n                                width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>\n                                </div>\n                                </div>\n                                \n                                ";
                                            jQuery('#center-container').append(centerInnerHtml);
                                        }
                                        window.sortedCenter = [];
                                        if (navigator.geolocation) {
                                            navigator.geolocation.getCurrentPosition(function (position) {
                                                window.courseCenterList.forEach(function (center) {
                                                    var lat = center.field_center_latitude[0] ? center.field_center_latitude[0].value : '';
                                                    var long = center.field_center_longitude[0] ? center.field_center_longitude[0].value : '';
                                                    center.distance = distance(position.coords.latitude, position.coords.longitude, lat, long);
                                                });
                                                window.sortedCenter = _.sortBy(window.courseCenterList, [function (o) {
                                                    return o.distance;
                                                }]);

                                                jQuery('#center-container').html('');
                                                var limit = window.sortedCenter.length > 3 ? 3 : window.sortedCenter.length;
                                                for (var _j = 0; _j < limit; _j++) {
                                                    var center = window.sortedCenter[_j];
                                                    var title = center.title[0] ? center.title[0].value : 'NIIT Center';
                                                    var address = center.field_center_location[0] ? center.field_center_location[0].value : '';
                                                    var city = center.field_center_city[0] ? center.field_center_city[0].value : '';
                                                    var phone = center.field_center_phone[0] ? center.field_center_phone[0].value : '';
                                                    var email = center.field_center_email[0] ? center.field_center_email[0].value : '';
                                                    var lat = center.field_center_latitude[0] ? center.field_center_latitude[0].value : '';
                                                    var long = center.field_center_longitude[0] ? center.field_center_longitude[0].value : '';
                                                    var centerInnerHtml = "\n                                        <div class=\"col-sm-4\">\n                                        <div class=\"map-box\">\n                                        <div class=\"detailbox\">\n                                        <h2>" + title + "</h2>\n                                        <p>" + address + "</p>\n                                        <p><strong>City:</strong>" + city + "</p>\n                                        <p>\n                                        <strong>Phone:</strong>" + phone + "\n                                        </p>\n                                        <p>\n                                        <strong>E-mail:</strong>" + email + "\n                                        </p>\n                                        <p>Directions:</p>\n                                        </div>\n                                        <div class=\"mapframe\">\n                                        <iframe\n                                        src=\"https://maps.google.com/maps?q=" + lat + "," + long + "&z=15&output=embed\"\n                                        width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>\n                                        </div>\n                                        </div>\n                                        </div>\n                                        ";
                                                    jQuery('#center-container').append(centerInnerHtml);
                                                }
                                            });
                                        } else {
                                        }
                                    });
                                }
                                
                                if (course.field_course_alumni_speak.length > 0) {
                                    jQuery.get(serverRootPath + "alumni-speak?_format=json", function (alumniSpeakList) {
                                        var innerHtml = '';
                                        
                                        window.alumniSpeakList = [];
                                        alumniSpeakList.forEach(function (alumni) {
                                            course.field_course_alumni_speak.forEach(function (courseAlumni) {
                                                if (alumni.uuid[0].value == courseAlumni.target_uuid) {
                                                    window.alumniSpeakList.push(alumni);
                                                    var thumbImg = alumni.field_thumbnail_image[0] ? alumni.field_thumbnail_image[0].url : '';
                                                    var name = alumni.field_alumni_name[0] ? alumni.field_alumni_name[0].value : '';
                                                    var bannerImage = alumni.field_banner_image[0] ? alumni.field_banner_image[0].url : '';
                                                    var speakText = alumni.metatag.value.description;
                                                    var alumniVideo = alumni.field_alumni_video[0] ? alumni.field_alumni_video[0].value : undefined;
                                                    innerHtml = innerHtml + ("\n                                                <div class=\"alumni-speak-item\" data-merge=\"2\">\n                                                    <div class=\"alumni_wrap\">\n                                                    \t<img class=\"hide600\" src=\"" + bannerImage + "\" width=\"\" height=\"\">\n                                                        <img class=\"show600\" src=\"" + bannerImage + "\" width=\"\" height=\"\">\n                                                    \t<div class=\"alumni_content\">\n                                                            <div class=\"alumni_shortdesc\">\n                                                            <div class=\"tophead\">\n                                                                <div class=\"headding text-center colorwhite\">\n                                                                    <h2>Alumni Speak </h2>\n                                                                    <h3>Find out what our Alumni have to say.</h3>\n                                                                    <span></span>\n                                                                </div>\n                                                                " + (alumniVideo ? "\n                                                                    <div class=\"playbutton\"><a data-youtube=\"" + alumniVideo + "\"><i class=\"fas fa-play\"></i></a></div>\n                                                                " : "") + "\n                                                                <div class=\"testi-txt\"><p>\u201C" + speakText + "\u201D</p></div>\n                                                            </div>\n                                                            </div>\n                                                        </div>\n                                                    </div>\n                                                </div>\n                                                ");
                                                }
                                            });
                                        });
                                        
                                        jQuery("#alumni-speak-course").html(innerHtml);
                                        jQuery("#alumni-speak-course").slick({
                                            infinite: true,
                                            arrows: true,
                                            speed: 500,
                                            slidesToShow: 1,
                                            slidesToScroll: 1,
                                            autoplay: true,
                                            autoplaySpeed: 3000,
                                            adaptiveHeight: false,
                                            responsive: [{
                                                breakpoint: 1200,
                                                settings: {
                                                    slidesToShow: 1,
                                                    autoplay: true,
                                                    slidesToScroll: 1,
                                                    infinite: true
                                                }
                                            }, {
                                                breakpoint: 1024,
                                                settings: {
                                                    slidesToShow: 1,
                                                    autoplay: true,
                                                    slidesToScroll: 1
                                                }
                                            }, {
                                                breakpoint: 768,
                                                settings: {
                                                    slidesToShow: 1,
                                                    autoplay: true,
                                                    slidesToScroll: 1
                                                }
                                            }, {
                                                breakpoint: 600,
                                                settings: {
                                                    slidesToShow: 1,
                                                    adaptiveHeight: true,
                                                    autoplay: true,
                                                    slidesToScroll: 1
                                                }
                                            }]
                                        });
                                    });
                                } else {
                                    jQuery("#alumni").hide();
                                }

                                
                                if (course.field_staralumni.length > 0) {
                                    
                                    if (jQuery("#starAlumniSectionWholeContainerOnCategoryPage")) {
                                        jQuery.get(serverRootPath + "alumni-carousel?_format=json", function (data) {
                                            var innerHtml = "";
                                            data.forEach(function (starAlumni) {
                                                course.field_staralumni.forEach(function (courseStarAlumni) {
                                                    if (starAlumni.uuid[0].value == courseStarAlumni.target_uuid) {
                                                        innerHtml = innerHtml + ("<div class=\"StarAlumni\">\n                                                        <h2>Star Alumni</h2>\n                                                        <section class=\"Alumni\" id=\"starAlumniSectionOnCategoryPage\">\n                                                        <div>\n                                                        <div class=\"photogallery\">\n                                                        <div class=\"imgStarAlumni\">\n                                                        <img src=\"" + starAlumni.field_alumnis_image[0].url + "\">\n                                                        </div>\n                                                        <h3>" + starAlumni.field_alumnis_name[0].value + "</h3>\n                                                        <p>" + starAlumni.field_alumnis_designation[0].value + "\n                                                        <br/>" + starAlumni.field_alumnis_company_name[0].value + "\n                                                        </p>\n                                                        </div>\n                                                        </div>\n                                                        </section>\n                                                        </div>\n                                                        ");
                                                    }
                                                });
                                            });
                                            

                                           
                                            jQuery("#starAlumniSectionWholeContainerOnCategoryPage").html(innerHtml);
                                            jQuery(".alumni_faculty_new").slick({
                                                dots: false,
                                                infinite: true,
                                                arrows: true,
                                                speed: 500,
                                                slidesToShow: 1,
                                                slidesToScroll: 1,
                                                autoplay: false,
                                                autoplaySpeed: 3000,
                                                responsive: [{
                                                    breakpoint: 1200,
                                                    settings: {
                                                        slidesToShow: 1,
                                                        slidesToScroll: 1,
                                                        infinite: true
                                                    }
                                                }, {
                                                    breakpoint: 1024,
                                                    settings: {
                                                        slidesToShow: 1,
                                                        slidesToScroll: 1
                                                    }
                                                }, {
                                                    breakpoint: 600,
                                                    settings: {
                                                        slidesToShow: 1,
                                                        slidesToScroll: 1
                                                    }
                                                }, {
                                                    breakpoint: 490,
                                                    settings: {
                                                        slidesToShow: 1,
                                                        slidesToScroll: 1
                                                    }
                                                }]
                                            });
                                        });
                                    }
                                }

                                if (course.field_faculties.length > 0) {
                                    if (jQuery("#starFacultySectionWholeContainerOnCategoryPage")) {
                                        jQuery.get(serverRootPath + "star-faculty?_format=json", function (data) {
                                            var innerHtml = "";
                                            data.forEach(function (starFaculty) {
                                                course.field_faculties.forEach(function (courseFaculty) {
                                                    if (starFaculty.uuid[0].value == courseFaculty.target_uuid) {
                                                        innerHtml = innerHtml + ("\n <div class=\"StarAlumni\">\n <h2>Star faculty</h2>\n<section id=\"starFacultySectionOnCategoryPage\">\n<div>\n<div class=\"photogallery\">\n<div class=\"imgStarAlumni2\">\n<img src=\"" + starFaculty.field_faculty_image[0].url + "\">\n</div>\n<h3>" + starFaculty.title[0].value + "</h3>\n<p>" + starFaculty.field_faculty_qualification[0].value + "</p>\n</div>\n</div>\n</section>\n</div>\n");
                                                    }
                                                });
                                            });
                                            jQuery("#starFacultySectionWholeContainerOnCategoryPage").html(innerHtml);
                                            jQuery(".start_faculty_new").slick({
                                                dots: false,
                                                infinite: true,
                                                arrows: true,
                                                speed: 500,
                                                slidesToShow: 1,
                                                slidesToScroll: 1,
                                                autoplay: false,
                                                autoplaySpeed: 3000,
                                                responsive: [{
                                                    breakpoint: 1200,
                                                    settings: {
                                                        slidesToShow: 1,
                                                        slidesToScroll: 1,
                                                        infinite: true
                                                    }
                                                }, {
                                                    breakpoint: 1024,
                                                    settings: {
                                                        slidesToShow: 1,
                                                        slidesToScroll: 1
                                                    }
                                                }, {
                                                    breakpoint: 600,
                                                    settings: {
                                                        slidesToShow: 1,
                                                        slidesToScroll: 1
                                                    }
                                                }, {
                                                    breakpoint: 490,
                                                    settings: {
                                                        slidesToShow: 1,
                                                        slidesToScroll: 1
                                                    }
                                                }]
                                            });
                                        });
                                    }
                                } else {
                                    jQuery("#starFacultySectionWholeContainerOnCategoryPage").hide();
                                }

                                if (course.field_placement_company_list.length > 0) {
                                    jQuery("#course-placement-company-container").show();
                                    if (jQuery("#course-placement-company")) {
                                        jQuery.get(serverRootPath + "niit-placement-companies?_format=json", function (data) {
                                            var innerHtml = "";
                                            data.forEach(function (company) {
                                                course.field_placement_company_list.forEach(function (courseCompany) {
                                                    if (company.uuid[0].value == courseCompany.target_uuid) {
                                                        if (!company.field_company_logo[0]) {
                                                            return;
                                                        }
                                                        innerHtml = innerHtml + ("\n                                                        <div class=\"cus-sayingtxt\">\n                                                        <img src=\"" + company.field_company_logo[0].url + "\" style=\"width:unset; margin: auto;\">\n                                                        </div>\n                                                        ");
                                                    }
                                                });
                                            });
                                            jQuery("#course-placement-company").html(innerHtml);
                                            jQuery("#course-placement-company").slick({
                                                dots: false,
                                                infinite: true,
                                                arrows: true,
                                                speed: 500,
                                                slidesToShow: 5,
                                                centerMode: true,
                                                centerPadding: '0px',
                                                slidesToScroll: 1,
                                                autoplay: true,
                                                autoplaySpeed: 3000,
                                                responsive: [{
                                                    breakpoint: 1200,
                                                    settings: {
                                                        slidesToShow: 4,
                                                        slidesToScroll: 1,
                                                        infinite: true
                                                    }
                                                }, {
                                                    breakpoint: 1024,
                                                    settings: {
                                                        slidesToShow: 3,
                                                        slidesToScroll: 1
                                                    }
                                                }, {
                                                    breakpoint: 600,
                                                    settings: {
                                                        slidesToShow: 1,
                                                        slidesToScroll: 1
                                                    }
                                                }, {
                                                    breakpoint: 490,
                                                    settings: {
                                                        slidesToShow: 1,
                                                        slidesToScroll: 1
                                                    }
                                                }]
                                            });
                                        });
                                    }
                                } else {
                                    jQuery("#course-placement-company-container").hide();
                                }
                            }
                        });
                    }

                    jQuery(window).resize(function () {
                        if (window.matchMedia("only screen and (max-width:1170px)").matches) {
                        }
                        else {
                            jQuery('.navmobile').show();
                            jQuery('nav').addClass('activate');
                            jQuery('.menuIcon').removeClass('active');
                        }
                    });
                });
            });
        });
    }
}
});





jQuery(function () {

    if (jQuery(".niit-advantage-media .views-field-field-advantage-video iframe")[0]) {
        var embedLink = jQuery(".niit-advantage-media .views-field-field-advantage-video iframe").attr("src");
        if (!embedLink) {
            jQuery(".advantage-wrap .rightwrap .overlay.videoo").hide();
        }
        jQuery(".advantage-wrap .rightwrap .overlay.videoo").click(function () {
            jQuery('#advantage-youtube-modal').modal('show');
            jQuery('#advantageYoutubeIframe').attr("src", embedLink);
        });
        jQuery('#advantage-youtube-modal').on('hidden.bs.modal', function (e) {
            jQuery('#advantageYoutubeIframe').attr("src", "");
        });
    }

    if (jQuery(".why-it-is-booming-media .views-field-field-booming-video iframe")[0]) {
        var embedLink = jQuery(".why-it-is-booming-media .views-field-field-booming-video iframe").attr("src");
        if (!embedLink) {
            jQuery(".advantage-wrap .rightwrap .overlay.videoo").hide();
        }
        jQuery(".why-it-is-booming-media .play a").click(function () {
            jQuery('#booming-youtube-modal').modal('show');
            jQuery('#boomingYoutubeIframe').attr("src", embedLink);
        });
        jQuery('#booming-youtube-modal').on('hidden.bs.modal', function (e) {
            jQuery('#boomingYoutubeIframe').attr("src", "");
        });
    }

    jQuery(".knowledge-box .morebtn").click(function (event) {
        event.stopPropagation();
        var button = jQuery(this);
        jQuery(button[0].parentNode.parentElement).children(".overlayimg").slideDown();
    });

    jQuery(".overlayimg .clsbtn").click(function (event) {
        var button = jQuery(this);
        jQuery(button[0].parentNode).slideUp();
    });

var nodeBundle = jQuery('#pageNodeBundle').text();  
if(nodeBundle == 'course_category'){
 if(flagApiCall == true) {

     if (jQuery("#category-taxonomy")) {

         var uriTaxonomy = getUrlParameter('t');
         var uriTaxonomyTT = getUrlParameter('tt');
         var uriCategory = getUrlParameter('c');

         var url = window.location.href.split("/");
         // for local envirnment change it with url[3] / url [4]
         var categoryType1 = url[4];
         var categoryType2 = url[5];

         jQuery.get(serverRootPath + "category-taxonomy?_format=json", function (data) {
             jQuery.get(serverRootPath + "top-course-category?_format=json", function (ccData) {
                 var listingPageCatTaxQuery = {};
                 var listingPageTopCatTaxQuery = {};
                 data.forEach(function (t) {
                     listingPageCatTaxQuery[t.uuid[0].value] = "f%5B1%5D=course_category%3A" + t.tid[0].value;

                 });
                 ccData.forEach(function (t) {
                     listingPageTopCatTaxQuery[t.uuid[0].value] = undefined;
                 });

                 jQuery("#category-explore-more").click(function (event) {
                     event.preventDefault();
                     var uuid = jQuery("#category-taxonomy").val();
                     var catSearchQuery = listingPageTopCatTaxQuery[uriCategory] ? "" + listingPageTopCatTaxQuery[uriCategory] : '';
                     window.location.href = serverRootPath + ("search/content?keys=&" + catSearchQuery + "&" + listingPageCatTaxQuery[uuid]);
                 });
                 var innerHtml = "";
                 data.forEach(function (taxonomy) {
                     
                     var selectCategory = 'College Students';
                    
                     if (categoryType1 == 'college-students') {
                         selectCategory = 'College Students';
                     }
                     else if (categoryType1 == 'graduates') {
                         selectCategory = 'Graduates';
                     }
                     else if (categoryType1 == 'short-term-courses') {
                         selectCategory = 'Short Term Courses';                         
                     }
                     
                     if (selectCategory.toLowerCase() == taxonomy.name[0].value.toLowerCase()) {
                         innerHtml = innerHtml + ("<option selected value=\"" + taxonomy.name[0].value + "\">" + taxonomy.name[0].value + "</option>");

                     } else {
                         innerHtml = innerHtml + ("<option value=\"" + taxonomy.name[0].value + "\">" + taxonomy.name[0].value + "</option>");
                     }
                 });

                 if (typeof(uriTaxonomyTT) != "undefined") {
                     innerHtml = innerHtml + "<option selected value=\"all\">All</option>";
                 }
                 else {
                     innerHtml = innerHtml + "<option value=\"all\">All</option>";
                 }



                 jQuery("#category-taxonomy").append(innerHtml);
                 if (jQuery("#trendingCourse")) {

                     jQuery.get(serverRootPath + "trending-courses?_format=json", function (data) {
                         data.forEach(function (course) {

                             if (course.field_top_course_category[0] && !listingPageTopCatTaxQuery[course.field_top_course_category[0].target_uuid]) {
                                 listingPageTopCatTaxQuery[course.field_top_course_category[0].target_uuid] = course.field_course_top_category_search[0] ? "f%5B0%5D=course_top_category_search_page_filter_%3A" + course.field_course_top_category_search[0].target_id : undefined;
                             }
                         });

                         window.trendingCourses = data;
                         var innerHtml = "";
                         var limit = window.trendingCourses.length > 4 && !jQuery.browser.mobile ? 4 : window.trendingCourses.length;
                         for (var i = 0; i < limit; i++) {
                             var element = data[i];
                             var title = "",
                                 image = serverRootPath + "themes/custom/nexus/assets/images/tabimg01.jpg",
                                 enrolLink = "",
                                 duration = "",
                                 certification = "",
                                 startingOn = "";

                             if (element.title[0]) {
                                 title = element.title[0].value;
                             }

                             if (element.field_course_image[0]) {
                                 image = element.field_course_image[0].url;
                             }

                             var colour;
                             if (element.field_colour[0]) {
                                 colour = element.field_colour[0].value;
                             } else {
                                 colour = "#75c2be";
                             }

                             if (element.field_enroll_now_link[0]) {
                                 enrolLink = window.location.origin + ("/india/lead-form?course=" + element.nid[0].value);
                             }

                             if (element.field_course_duration[0]) {
                                 duration = element.field_course_duration[0].value;
                             }

                             if (element.field_course_certification[0]) {
                                 certification = element.field_course_certification[0].value;
                             }

                             if (element.field_course_starting_on[0]) {
                                 startingOn = element.field_course_starting_on[0].value;
                             }
                             var path = element.path[0] ? element.path[0].alias.substr(1) : "node/" + element.nid[0].value;
                             var knowMoreLink = "" + window.serverRootPath + path;
                             var rating = element.field_rating[0] ? element.field_rating[0].value : 0;

                             var ratingElement = "<div class=\"starrating\">";
                             for (var _i4 = 1; _i4 <= 5; _i4++) {
                                 if (_i4 <= rating) {
                                     ratingElement = ratingElement + ("<div class=\"rate-image star1-on even s" + _i4 + "\"></div>");
                                 } else {
                                     ratingElement = ratingElement + ("<div class=\"rate-image star-off odd s" + _i4 + "\"></div>");
                                 }
                             }
                             ratingElement = ratingElement + "</div>";

                             innerHtml = innerHtml + ("\n<div class=\"col-xs-12 item\">\n<div class=\"cat-item\">\n<div class=\"img\" style=\"background-image: url(" + image + "); display: block; height: 20em;\n                        background-position: center;\n background-size: cover;\n  background-repeat: no-repeat;\">\n                        </div>\n                        <div class=\"overlay\">\n       <div class=\"head\">" + title + "</div>\n  <div class=\"info finance\" style=\"background-color: " + colour + "\">\n                        <div class=\"detailsinfo\">\n  <h3> <a href=\"" + knowMoreLink + "\">dsadad" + title + "</a>\n" + ratingElement + "\n<span></span>\n</h3>\n<p>\n  " + duration + "\n <br>Certification:  " + certification + "\n  <br>Batch starting soon\n </p>\n <a class=\"enrollbtn\" href=\"" + enrolLink + "\">Enquire Now </a>\n <a class=\"enrollbtn\" href=\"" + knowMoreLink + "\">Know More </a>\n</div>\n</div>\n</div>\n</div>\n</div>\n");

                         }
                         window.courseLoaded = limit;
                         jQuery("#trendingCourse").html(innerHtml);

                         jQuery('#trendingCourse .arrowslick').slick({
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
                         });

                         if (window.trendingCourses.length > 4 && !jQuery.browser.mobile) {
                             jQuery("#show-more").show();
                         }
                         /*else {
                                                    jQuery("#show-more").hide();
                                                }*/

                         //jQuery("#show-more").click(function () {


                         limit = window.courseLoaded + 4 < window.trendingCourses.length ? window.courseLoaded + 4 : window.trendingCourses.length;
                         for (var _i5 = 0; _i5 < limit; _i5++) {
                             var element = window.trendingCourses[_i5];
                             var _title = "",
                                 _image = "../themes/custom/nexus/assets/images/tabimg01.jpg",
                                 _enrolLink = "",
                                 _duration = "",
                                 _certification = "",
                                 _startingOn = "";

                             if (element.title[0]) {
                                 _title = element.title[0].value;
                             }

                             var colour;
                             if (element.field_colour[0]) {
                                 colour = element.field_colour[0].value;
                             } else {
                                 colour = "#75c2be";
                             }

                             if (element.field_course_image[0]) {
                                 _image = element.field_course_image[0].url;
                             }

                             if (element.field_enroll_now_link[0]) {
                                 _enrolLink = window.location.origin + ("/india/lead-form?course=" + element.nid[0].value);
                             }

                             if (element.field_course_duration[0]) {
                                 _duration = element.field_course_duration[0].value;
                             }

                             if (element.field_course_certification[0]) {
                                 _certification = element.field_course_certification[0].value;
                             }

                             if (element.field_course_starting_on[0]) {
                                 _startingOn = element.field_course_starting_on[0].value;
                             }
                             var path = element.path[0] ? element.path[0].alias.substr(1) : "node/" + element.nid[0].value;
                             var knowMoreLink = "" + window.serverRootPath + path;
                             var rating = element.field_rating[0] ? element.field_rating[0].value : 0;
                             var ratingElement = "<div class=\"starrating\">";
                             for (var _i6 = 1; _i6 <= 5; _i6++) {
                                 if (_i6 <= rating) {
                                     ratingElement = ratingElement + ("<div class=\"rate-image star1-on even s" + _i6 + "\"></div>");
                                 } else {
                                     ratingElement = ratingElement + ("<div class=\"rate-image star-off odd s" + _i6 + "\"></div>");
                                 }
                             }
                             ratingElement = ratingElement + "</div>";

                             innerHtml = innerHtml + ("\n                            <div class=\"col-xs-12\">\n                            <div class=\"cat-item\">\n                            <div class=\"img\" style=\"background-image: url(" + _image + "); display: block; height: 20em;\n                            background-position: center;\n                            background-size: cover;\n                            background-repeat: no-repeat;\">\n                            </div>\n                            <div class=\"overlay\">\n                            <div class=\"head\">" + _title + "</div>\n<div class=\"info finance\" style=\"background-color: " + colour + "\">\n                            <div class=\"detailsinfo\">\n<h3><a href=\"" + knowMoreLink + "\">" + _title + "</a>\n<span></span>\n                            </h3>\n                            <p> " + _duration + "\n                            <br>Certification:  " + _certification + "\n                            <br>Batch starting soon </p>\n                            <a class=\"enrollbtn\" href=\"" + _enrolLink + "\">Enquire Now </a>\n<a class=\"enrollbtn\" href=\"" + knowMoreLink + "\">Know More </a>\n</div>\n</div>\n</div>\n</div>\n</div>\n");
                         }
                         window.courseLoaded = limit;
                         jQuery("#trendingCourse").remove();
                         jQuery("#trendingCourseParent").html("<div class=\"contant-tab\">\n <div id=\"trendingCourse\">\n\n\n</div>\n </div>");
                         jQuery("#trendingCourse").append(innerHtml);
                         jQuery('#trendingCourse').slick({
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
                         });
                         if (jQuery("#category-taxonomy").val() != 'all') {
                             var value = jQuery("#category-taxonomy").val();

                             if (jQuery("#trendingCourse")) {
                                 jQuery("#trendingCourse").val(uriTaxonomy);
                             }
                             var taxonomy = jQuery("#category-taxonomy").val();

                             if (jQuery("#trendingCourse")) {

                                 jQuery.get(serverRootPath + "trending-courses?_format=json", function (data) {
                                     window.taxonomyCourses = [];
                                     data.forEach(function (course) {

                                         if (course.path[0] && course.path[0].alias) {
                                             var courseUrl1 = course.path[0].alias.split("/")[1];
                                             var courseUrl2 = course.path[0].alias.split("/")[2];

                                             if ((categoryType1 === courseUrl1 && categoryType2 === courseUrl2) || taxonomy == "all") {

                                                 window.taxonomyCourses.push(course);
                                             }

                                         }
                                     });

                                     
                                     window.filterCourses = [];
                                     var appliedFilters = [];
                                     jQuery("input[name='filterTrendingCourse[]']").each(function () {

                                         var filter = jQuery(this);
                                         if (filter.prop("checked")) {
                                             appliedFilters.push(filter.val());
                                         }

                                         if (filter.prop("checked") && (filter.val() == "field_is_placement_assisted" || filter.val() == "field_is_short_term" || filter.val() == "field_is_most_popular" || filter.val() == "field_new_upcoming")) {

                                             window.taxonomyCourses.forEach(function (course, index) {
                                                 if (course[filter.val()][0] && course[filter.val()][0].value) {
                                                     window.filterCourses.push(course);

                                                 }
                                             });
                                         }
                                         //remove rating featured.
                                         if (filter.prop("checked") && filter.val() == "field_rating") {
                                             window.taxonomyCourses.forEach(function (course, index) {
                                                 if (course[filter.val()][0] && course[filter.val()][0].value > 4) {
                                                     
                                                     window.filterCourses.push(course);
                                                 }
                                             });
                                         }
                                     });

                                     if (appliedFilters.length == 0) {
                                         window.taxonomyCourses.forEach(function (course) {
                                             window.filterCourses.push(course);
                                         });
                                     }
                                     
                                     var limit = window.filterCourses.length > 4 && !jQuery.browser.mobile ? 4 : window.filterCourses.length;

                                     var innerHtml = "";
                                     for (var _i7 = 0; _i7 < limit; _i7++) {
                                         var element = window.filterCourses[_i7];
                                         var _title2 = "",
                                             _image2 = serverRootPath + "themes/custom/nexus/assets/images/tabimg01.jpg",
                                             _enrolLink2 = "",
                                             _duration2 = "",
                                             _certification2 = "",
                                             _startingOn2 = "";

                                         if (element.title[0]) {
                                             _title2 = element.title[0].value;
                                         }

                                         var colour;
                                         if (element.field_colour[0]) {
                                             colour = element.field_colour[0].value;
                                         } else {
                                             colour = "#75c2be";
                                         }

                                         if (element.field_course_image[0]) {
                                             _image2 = element.field_course_image[0].url;
                                         }

                                         if (element.field_enroll_now_link[0]) {
                                             _enrolLink2 = window.location.origin + ("/india/lead-form?course=" + element.nid[0].value);
                                         }

                                         if (element.field_course_duration[0]) {
                                             _duration2 = element.field_course_duration[0].value;
                                         }

                                         if (element.field_course_certification[0]) {
                                             _certification2 = element.field_course_certification[0].value;
                                         }

                                         if (element.field_course_starting_on[0]) {
                                             _startingOn2 = element.field_course_starting_on[0].value;
                                         }
                                         var path = element.path[0] ? element.path[0].alias.substr(1) : "node/" + element.nid[0].value;
                                         var knowMoreLink = "" + window.serverRootPath + path;
                                         var rating = element.field_rating[0] ? element.field_rating[0].value : 0;
                                         var ratingElement = "<div class=\"starrating\">";
                                         for (var _i8 = 1; _i8 <= 5; _i8++) {
                                             if (_i8 <= rating) {
                                                 ratingElement = ratingElement + ("<div class=\"rate-image star1-on even s" + _i8 + "\"></div>");
                                             } else {
                                                 ratingElement = ratingElement + ("<div class=\"rate-image star-off odd s" + _i8 + "\"></div>");
                                             }
                                         }

                                         ratingElement = ratingElement + "</div>";
                                         innerHtml = innerHtml + ("\n<div class=\"col-xs-12\">\n<div class=\"cat-item\">\n<div class=\"img\" style=\"background-image: url(" + _image2 + "); display: block; height: 20em;\n background-position: center;\n background-size: cover;\n background-repeat: no-repeat;\">\n</div>\n<div class=\"overlay\">\n<div class=\"head\">" + _title2 + "</div>\n<div class=\"info finance\" style=\"background-color: " + colour + "\">\n<div class=\"detailsinfo\">\n<h3><a href=\"" + knowMoreLink + "\">" + _title2 + "</a> " + ratingElement + "\n<span></span>\n</h3>\n<p> " + _duration2 + "\n<br>Certification:  " + _certification2 + "\n<br>Batch starting soon </p>\n<a class=\"enrollbtn\" href=\"" + _enrolLink2 + "\">Enquire Now </a>\n<a class=\"enrollbtn\" href=\"" + knowMoreLink + "\">Know More </a>\n</div>\n</div>\n</div>\n</div>\n</div>\n");
                                     }
                                     window.courseLoaded = limit;
                                     jQuery("#trendingCourse").remove();
                                     jQuery("#trendingCourseParent").html("<div class=\"contant-tab\">\n<div id=\"trendingCourse\">\n \n\n </div>\n </div>");
                                     
                                     jQuery("#trendingCourse").html(innerHtml);
                                     jQuery('#trendingCourse').slick({
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
                                     });
                                     if (window.filterCourses.length > 4 && !jQuery.browser.mobile) {
                                         jQuery("#show-more").show();
                                     }
                                 });
                             }
                         }
                     });
                 }


                 if (jQuery('#category-based-articles')) {
                     jQuery.get(serverRootPath + "category-articles?_format=json", function (categoryBasedArticles) {
                         
                         var articlesInnerHtml = "";
                         categoryBasedArticles.forEach(function (article) {

                             if (article.field_top_category[0] && article.field_top_category[0].url) {

                                 var cate_url_top1 = article.field_top_category[0].url.split("/")[2];
                                 var cate_url_top2 = article.field_top_category[0].url.split("/")[3];

                                 if (cate_url_top1 == categoryType1 && cate_url_top2 == categoryType2) {

                                     var image = article.field_knowledge_image[0] ? article.field_knowledge_image[0].url : '';
                                     var title = article.title[0] ? article.title[0].value : '';
                                     var body = article.body[0] ? getTrimmedContent(article.body[0].processed) : '';
                                     articlesInnerHtml = articlesInnerHtml + ("\n<div class=\"col-lg-12\">\n<div class=\"knowledge-box kb1\">\n<div class=\"overlayimg\"><img data-lazy=\"" + image + "\" class=\"\" alt=\"img\"> <span class=\"clsbtn\" id=\"clsbtn1\">X</span></div>\n<div class=\"knowimg\"><img data-lazy=\"" + image + "\" class=\"scale\" alt=\"img\"></div>\n<div class=\"detailbox\">\n<h2>" + title + "</h2>\n<p>" + body + "</p>\n<a class=\"morebtn seemr1\" href=\"javascript://\" tabindex=\"0\">See More</a>\n</div>\n</div>\n</div>\n");
                                     jQuery("#category-based-articles").html(articlesInnerHtml);
                                 }
                             }
                         });
                         jQuery(".knowledge-box .morebtn").click(function (event) {
                             event.stopPropagation();
                             var button = jQuery(this);
                             jQuery(button[0].parentNode.parentElement).children(".overlayimg").slideDown();
                         });
                         jQuery(".overlayimg .clsbtn").click(function (event) {
                             var button = jQuery(this);
                             jQuery(button[0].parentNode).slideUp();
                         });
                         jQuery("#category-based-articles").slick({
                             dots: false,
                             infinite: true,
                             arrows: false,
                             speed: 500,
                             lazyLoad: 'ondemand',
                             slidesToShow: 3,
                             centerMode: true,
                             centerPadding: '0px',
                             slidesToScroll: 1,
                             autoplay: false,
                             autoplaySpeed: 3000,
                             responsive: [{
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
                             }]
                         });
                     });
                 }


                 if (jQuery("#ourPartners")) {
                     jQuery.get(serverRootPath + "our-partners?_format=json", function (data) {
                         var innerHtml = "";
                         data.forEach(function (partner) {
                             if (partner.field_partner_category[0] && partner.field_partner_top_category[0] && partner.field_partner_category[0].target_uuid && partner.field_partner_top_category[0].target_uuid) {
                                 if (partner.field_partner_category[0].target_uuid == uriTaxonomy && partner.field_partner_top_category[0].target_uuid == uriCategory) {
                                     if (!partner.field_partner_img[0]) {
                                         return;
                                     }
                                     innerHtml = innerHtml + ("\n <div>\n <div class=\"cus-sayingtxt\">\n <img src=\"" + partner.field_partner_img[0].url + "\" width=\"\" height=\"\">\n </div>\n </div>\n ");
                                 }
                             }
                         });

                         jQuery("#ourPartners").html(innerHtml);
                         jQuery("#ourPartners").slick({
                             dots: false,
                             infinite: true,
                             arrows: true,
                             speed: 500,
                             slidesToShow: 5,
                             slidesToScroll: 1,
                             autoplay: true,
                             autoplaySpeed: 3000,
                             responsive: [{
                                 breakpoint: 1200,
                                 settings: {
                                     slidesToShow: 4,
                                     slidesToScroll: 1,
                                     infinite: true
                                 }
                             }, {
                                 breakpoint: 1024,
                                 settings: {
                                     slidesToShow: 3,
                                     slidesToScroll: 1
                                 }
                             }, {
                                 breakpoint: 600,
                                 settings: {
                                     slidesToShow: 1,
                                     slidesToScroll: 1
                                 }
                             }, {
                                 breakpoint: 490,
                                 settings: {
                                     slidesToShow: 1,
                                     slidesToScroll: 1
                                 }
                             }]
                         });
                     });
                 }
                 if (jQuery("#pacementCompany")) {
                     jQuery.get(serverRootPath + "alumni-carousel?_format=json", function (data) {
                         var filteredData = [];
                         var innerHtml = "";

                         // for local envirnment change it with employee.field_alumni_work_top_category[0].url.split("/") change url[1] / url [2]
                         data.forEach(function (employee) {

                             var alumni1 = '';
                             var alumni2 = '';
                             if (employee.field_alumni_work_top_category[0] && employee.field_alumni_work_top_category[0].url) {
                                 alumni1 = employee.field_alumni_work_top_category[0].url.split("/")[2];
                                 alumni2 = employee.field_alumni_work_top_category[0].url.split("/")[3];
                             }
                             if (categoryType1 == alumni1 && categoryType2 == alumni2) {
                                 filteredData.push(employee);
                                 innerHtml = innerHtml + ("\n <div>\n <div class=\"amazingwrap\">\n <img data-lazy=\"" + employee.field_alumnis_image[0].url + "\" width=\"\" height=\"\" class=\"mainimg\">\n <h2>" + employee.field_alumnis_name[0].value + "</h2>\n <div class=\"hoverhide\">\n <h3>Work for</h3>\n  <h2>" + employee.field_alumnis_company_name[0].value + "</h2>\n </div>\n <div class=\"hovershow\">\n  <h3>Work as</h3>\n  <h2>" + employee.field_alumnis_designation[0].value + "</h2>\n   <img data-lazy=\"" + employee.field_alumnis_company_image[0].url + "\" width=\"\" height=\"\" class=\"scale\">\n </div>\n </div>\n </div>\n ");
                             }
                         });
                         if (filteredData.length == 0) {
                             jQuery("#pacementCompany").hide();
                         }
                         jQuery("#pacementCompany #amazingCompanyWrapper").html(innerHtml);
                         jQuery("#amazingCompanyWrapper").slick({
                             dots: false,
                             infinite: true,
                             arrows: true,
                             speed: 500,
                             lazyLoad: 'ondemand',
                             slidesToShow: 3,
                             centerMode: true,
                             centerPadding: '0px',
                             slidesToScroll: 1,
                             autoplay: false,
                             autoplaySpeed: 3000,
                             adaptiveHeight: true,
                             responsive: [{

                                 breakpoint: 1200,
                                 settings: {
                                     slidesToShow: 4,
                                     slidesToScroll: 1,
                                     infinite: true
                                 }
                             }, {
                                 breakpoint: 1024,
                                 settings: {
                                     slidesToShow: 3,
                                     slidesToScroll: 1
                                 }
                             }, {
                                 breakpoint: 768,
                                 settings: {
                                     slidesToShow: 2,
                                     slidesToScroll: 1
                                 }
                             }, {
                                 breakpoint: 600,
                                 settings: {
                                     slidesToShow: 1,
                                     adaptiveHeight: true,
                                     slidesToScroll: 1
                                 }
                             }]
                         });
                     });
                 }

                 if (jQuery("#it-jobs-category")) {
                     jQuery.get(serverRootPath + "it-jobs?_format=json", function (data) {
                        

                         if (data.length > 0) {
                             var categoryJobs = [];
                             // change locally job.field_job_top_category[0].url.split("/")[1] or [2]
                             data.forEach(function (job) {
                                 

                                 var courseUrl1 = '';
                                 var courseUrl2 = '';

                                 if (job.field_job_top_category[0] && job.field_job_top_category[0].url) {
                                     courseUrl1 = job.field_job_top_category[0].url.split("/")[2];
                                     courseUrl2 = job.field_job_top_category[0].url.split("/")[3];
                                 }
                                 if (categoryType1 === courseUrl1 && categoryType2 === courseUrl2) {
                                     categoryJobs.push(job);
                                 }
                             });
                             var randomFour = getRandom(categoryJobs, 4);
                             if (!randomFour) {
                                 return;
                             }
                             var innerHtml = "\n<div class=\"arrowslick\">\n<div class=\"col-xs-12 col-sm-4\">\n                                    <div class=\"achieve-box\">\n                                        <div class=\"img-box square\">\n                                            <img src=\"" + (randomFour[0].field_vertical_image[0] ? randomFour[0].field_vertical_image[0].url : '') + "\" class=\"scale\" alt=\"img\">\n                                            <div class=\"overlay videoo\">\n                                                <div class=\"head\">\n                                                    <h3>\n                                                        " + (randomFour[0].title[0] ? randomFour[0].title[0].value : '') + "\n                                                    </h3>\n                                                    <p>" + (randomFour[0].field_job_short_text[0] ? randomFour[0].field_job_short_text[0].value : '') + "</p>\n                                                    \n                                                </div>\n                                                " + (randomFour[0].field_job_youtube_video[0] ? "\n                                                    <a class=\"play\" data-youtube=\"" + randomFour[0].field_job_youtube_video[0].value + "\"><i class=\"far fa-play-circle\"></i></a>\n                                                " : "\n                                                <div class=\"info\">\n                                                    <div class=\"detailsinfo\">\n                                                        " + (randomFour[0].body[0] ? randomFour[0].body[0].value : '') + "\n                                                    </div>\n                                                </div>\n                                                ") + "\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                                <div class=\"col-xs-12 col-sm-4\">\n                                    <div class=\"achieve-box\">\n                                        <div class=\"img-box square\">\n                                            <img src=\"" + (randomFour[1].field_h[0] ? randomFour[1].field_h[0].url : '') + "\" class=\"scale\" alt=\"img\">\n                                            <div class=\"overlay videoo\">\n                                                <div class=\"head\">\n                                                    <h3>\n                                                        " + (randomFour[1].title[0] ? randomFour[1].title[0].value : '') + "\n                                                    </h3>\n                                                    <p>\n                                                        " + (randomFour[1].field_job_short_text[0] ? randomFour[1].field_job_short_text[0].value : '') + "\n                                                    </p>\n                                                </div>\n                                                " + (randomFour[1].field_job_youtube_video[0] ? "\n                                                    <a class=\"play\" data-youtube=\"" + randomFour[1].field_job_youtube_video[0].value + "\"><i class=\"far fa-play-circle\"></i></a>\n                                                " : "\n                                                <div class=\"info\">\n                                                    <div class=\"detailsinfo\">\n                                                        " + (randomFour[1].body[0] ? randomFour[1].body[0].value : '') + "\n                                                    </div>\n                                                </div>\n                                                ") + "\n                                            </div>\n                                        </div>\n                                        <div class=\"img-box square\">\n                                            <img src=\"" + (randomFour[2].field_h[0] ? randomFour[2].field_h[0].url : '') + "\" class=\"scale\" alt=\"img\">\n                                            <div class=\"overlay videoo\">\n                                                <div class=\"head\">\n                                                    <h3>\n                                                        " + (randomFour[2].title[0] ? randomFour[2].title[0].value : '') + "\n                                                    </h3>\n                                                    <p>\n                                                        " + (randomFour[2].field_job_short_text[0] ? randomFour[2].field_job_short_text[0].value : '') + "\n                                                    </p>\n                                                </div>\n                                                " + (randomFour[2].field_job_youtube_video[0] ? "\n                                                    <a class=\"play\" data-youtube=\"" + randomFour[2].field_job_youtube_video[0].value + "\"><i class=\"far fa-play-circle\"></i></a>\n                                                " : "\n                                                <div class=\"info\">\n                                                    <div class=\"detailsinfo\">\n                                                        " + (randomFour[2].body[0] ? randomFour[2].body[0].value : '') + "\n                                                    </div>\n                                                </div>\n                                                ") + "\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                                <div class=\"col-xs-12 col-sm-4\">\n                                    <div class=\"achieve-box\">\n                                        <div class=\"img-box square video\">\n                                            <img src=\"" + (randomFour[3].field_vertical_image[0] ? randomFour[3].field_vertical_image[0].url : '') + "\" class=\"scale\" alt=\"img\">\n                                            <div class=\"overlay videoo\">\n                                                <div class=\"head\">\n                                                    <h3>\n                                                        " + (randomFour[3].title[0] ? randomFour[3].title[0].value : '') + "\n                                                    </h3>\n                                                    <p>" + (randomFour[3].field_job_short_text[0] ? randomFour[3].field_job_short_text[0].value : '') + "</p>\n                                                </div>\n                                                " + (randomFour[3].field_job_youtube_video[0] ? "\n                                                    <a class=\"play\" data-youtube=\"" + randomFour[3].field_job_youtube_video[0].value + "\"><i class=\"far fa-play-circle\"></i></a>\n                                                " : "\n                                                <div class=\"info\">\n                                                    <div class=\"detailsinfo\">\n                                                        " + (randomFour[3].body[0] ? randomFour[3].body[0].value : '') + "\n                                                    </div>\n                                                </div>\n                                                ") + "\n                                            </div>\n                                        </div>\n                                    </div>\n                                </div>\n                            </div>\n                            ";
                             jQuery("#it-jobs-category").html(innerHtml);
                             jQuery('[data-youtube]').click(function (event) {
                                 
                                 var youtubeLink = jQuery(this).data("youtube");
                                 playYoutubeVideo(youtubeLink);
                             });

                             jQuery("#it-jobs-category .arrowslick").slick({
                                 dots: false,
                                 infinite: true,
                                 arrows: false,
                                 speed: 500,
                                 slidesToShow: 3,
                                 centerMode: true,
                                 centerPadding: '0px',
                                 slidesToScroll: 1,
                                 autoplay: false,
                                 autoplaySpeed: 3000,
                                 responsive: [{
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
                                 }]
                             });
                         }

                         else {
                             if (jQuery("#aspirational-career")) {
                                 jQuery("#aspirational-career").hide();
                             }
                         }
                     });
                 }
             });
         });
     }

 }
}

var nodeBundle = jQuery('#pageNodeBundle').text();  
if(nodeBundle == 'course_category'){
    jQuery("#category-taxonomy").change(function () { 

        jQuery("input[name='filterTrendingCourse[]']").each(function () { 
            var filter = jQuery(this);

             if (filter.val() != "field_is_most_popular") {
                filter.prop("checked", false);
            } else {
                filter.prop("checked", true);
            }
        });

         var value = jQuery(this).val();
         var uriCategory = getUrlParameter('c');
         var taxonomy = jQuery("#category-taxonomy").val();

        if (jQuery("#trendingCourse")) {
            jQuery.get(serverRootPath + "trending-courses?_format=json", function (data) {
                window.taxonomyCourses = [];

                var urlcase = 'college-students';
                if(taxonomy == 'College Students')
                {
                    urlcase = 'college-students';
                }
                if(taxonomy == 'Short Term Courses')
                {
                    urlcase = 'short-term-courses';
                }
                else if(taxonomy == 'Graduates')
                {
                    urlcase = 'graduates';
                }
                /*else if(taxonomy == 'Working Professionals')
                {
                    urlcase = 'working-professionals';
                }*/

                data.forEach(function (course) {

                    var courseUrl1 = '';
                    var courseUrl2 = '';

                    if(course.path[0] && course.path[0].alias) {
                        courseUrl1 = course.path[0].alias.split("/")[1];
                        courseUrl2 = course.path[0].alias.split("/")[2];
                    }
                    if ((urlcase === courseUrl1 && categoryType2 === courseUrl2) || taxonomy == "all") {
                        window.taxonomyCourses.push(course);
                    }

                });
                
                window.filterCourses = [];
                var appliedFilters = [];
                jQuery("input[name='filterTrendingCourse[]']").each(function () {
                    var filter = jQuery(this);
                    
                    if (filter.prop("checked")) {
                        appliedFilters.push(filter.val());
                    }

                    if (filter.prop("checked") && (filter.val() == "field_is_placement_assisted" || filter.val() == "field_is_short_term" || filter.val() == "field_is_most_popular" || filter.val() == "field_new_upcoming")) {
                        // if (window.filterCourses.length > 0) {
                        //     window.taxonomyCourses = window.filterCourses.splice(0, window.filterCourses.length);
                        // }
                        window.taxonomyCourses.forEach(function (course, index) {

                            if (course[filter.val()][0] && course[filter.val()][0].value) {
                                
                                window.filterCourses.push(course);
                            }
                        });
                    }
                });
                if (appliedFilters.length == 0) {
                    window.taxonomyCourses.forEach(function (course) {
                        window.filterCourses.push(course);
                    });
                }
                
                var innerHtml = "";
                var limit = window.filterCourses.length > 4 && !jQuery.browser.mobile ? 4 : window.filterCourses.length;

                for (var i = 0; i < limit; i++) {
                    var element = window.filterCourses[i];
                    var title = "",
                        image = serverRootPath + "themes/custom/nexus/assets/images/tabimg01.jpg",
                        enrolLink = "",
                        duration = "",
                        certification = "",
                        startingOn = "";

                    if (element.title[0]) {
                        title = element.title[0].value;
                    }

                    var colour;
                    if (element.field_colour[0]) {
                        colour = element.field_colour[0].value;
                    } else {
                        colour = "#75c2be";
                    }

                    if (element.field_course_image[0]) {
                        image = element.field_course_image[0].url;
                    }

                    if (element.field_enroll_now_link[0]) {
                        enrolLink =  window.location.origin + ("/india/lead-form?course=" + element.nid[0].value);
                    }

                    if (element.field_course_duration[0]) {
                        duration = element.field_course_duration[0].value;
                    }

                    if (element.field_course_certification[0]) {
                        certification = element.field_course_certification[0].value;
                    }

                    if (element.field_course_starting_on[0]) {
                        startingOn = element.field_course_starting_on[0].value;
                    }
                    var path = element.path[0] ? element.path[0].alias.substr(1) : "node/" + element.nid[0].value;
                    var knowMoreLink = "" + window.serverRootPath + path;
                    var rating = element.field_rating[0] ? element.field_rating[0].value : 0;
                    var ratingElement = "<div class=\"starrating\">";
                    for (var _i9 = 1; _i9 <= 5; _i9++) {
                        if (_i9 <= rating) {
                            ratingElement = ratingElement + ("<div class=\"rate-image star1-on even s" + _i9 + "\"></div>");
                        } else {
                            ratingElement = ratingElement + ("<div class=\"rate-image star-off odd s" + _i9 + "\"></div>");
                        }
                    }

                    ratingElement = ratingElement + "</div>";

                    innerHtml = innerHtml + ("\n<div class=\"col-xs-12\">\n <div class=\"cat-item\">\n<div class=\"img\" style=\"background-image: url(" + image + "); display: block; height: 20em;\nbackground-position: center;\nbackground-size: cover;\nbackground-repeat: no-repeat;\">\n</div>\n<div class=\"overlay\">\n<div class=\"head\"> " + title + "</div>\n<div class=\"info finance\" style=\"background-color: " + colour + "\">\n<div class=\"detailsinfo\">\n<h3> <a href=\"" + knowMoreLink + "\">" + title + "</a> " + ratingElement + "\n<span></span>\n</h3>\n<p> " + duration + "\n<br>Certification:  " + certification + "\n  </p>\n <a class=\"enrollbtn\" href=\"" + enrolLink + "\">Enquire Now </a>\n<a class=\"enrollbtn\" href=\"" + knowMoreLink + "\">Know More </a>\n </div>\n</div>\n</div>\n</div>\n</div>\n");
                }
                window.courseLoaded = limit;
                jQuery("#trendingCourse").html("");
                jQuery("#trendingCourseParent").html("<div class=\"contant-tab\">\n<div id=\"trendingCourse\">\n \n\n</div>\n</div>");

                jQuery("#trendingCourse").html("");
                jQuery("#trendingCourse").html(innerHtml);
                jQuery('#trendingCourse').slick({
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
                    });
                if (window.filterCourses.length > 4 && !jQuery.browser.mobile) {
                    /* if select all  */
                        var innerHtml = "";
                            limit = window.courseLoaded + 4 < window.trendingCourses.length ? window.courseLoaded + 4 : window.trendingCourses.length;
                            for (var _i5 = 0; _i5 < limit; _i5++) {
                                var element = window.trendingCourses[_i5];
                                var _title = "",
                                    _image = "../themes/custom/nexus/assets/images/tabimg01.jpg",
                                    _enrolLink = "",
                                    _duration = "",
                                    _certification = "",
                                    _startingOn = "";

                                if (element.title[0]) {
                                    _title = element.title[0].value;
                                }

                                var colour;
                                if (element.field_colour[0]) {
                                    colour = element.field_colour[0].value;
                                } else {
                                    colour = "#75c2be";
                                }

                                if (element.field_course_image[0]) {
                                    _image = element.field_course_image[0].url;
                                }

                                if (element.field_enroll_now_link[0]) {
                                    _enrolLink =  window.location.origin + ("/india/lead-form?course=" + element.nid[0].value);
                                }

                                if (element.field_course_duration[0]) {
                                    _duration = element.field_course_duration[0].value;
                                }

                                if (element.field_course_certification[0]) {
                                    _certification = element.field_course_certification[0].value;
                                }

                                if (element.field_course_starting_on[0]) {
                                    _startingOn = element.field_course_starting_on[0].value;
                                }
                                var path = element.path[0] ? element.path[0].alias.substr(1) : "node/" + element.nid[0].value;
                                var knowMoreLink = "" + window.serverRootPath + path;
                                var rating = element.field_rating[0] ? element.field_rating[0].value : 0;
                                var ratingElement = "<div class=\"starrating\">";
                                for (var _i6 = 1; _i6 <= 5; _i6++) {
                                    if (_i6 <= rating) {
                                        ratingElement = ratingElement + ("<div class=\"rate-image star1-on even s" + _i6 + "\"></div>");
                                    } else {
                                        ratingElement = ratingElement + ("<div class=\"rate-image star-off odd s" + _i6 + "\"></div>");
                                    }
                                }
                                ratingElement = ratingElement + "</div>";

                                innerHtml = innerHtml + ("\n<div class=\"col-xs-12\">\n<div class=\"cat-item\">\n<div class=\"img\" style=\"background-image: url(" + _image + "); display: block; height: 20em;\nbackground-position: center;\nbackground-size: cover;\nbackground-repeat: no-repeat;\">\n</div>\n                            <div class=\"overlay\">\n                            <div class=\"head\">" + _title + "</div>\n                            <div class=\"info finance\" style=\"background-color: " + colour + "\">\n                            <div class=\"detailsinfo\">\n                            <h3><a href=\"" + knowMoreLink + "\">" + _title + "</a>\n<span></span>\n</h3>\n<p> " + _duration + "\n<br>Certification:  " + _certification + "\n<br>Batch starting soon </p>\n<a class=\"enrollbtn\" href=\"" + _enrolLink + "\">Enquire Now </a>\n<a class=\"enrollbtn\" href=\"" + knowMoreLink + "\">Know More </a>\n</div>\n</div>\n</div>\n</div>\n</div>\n");
                            }
                            window.courseLoaded = limit;
                            jQuery("#trendingCourse").remove();
                            jQuery("#trendingCourseParent").html("<div class=\"contant-tab\">\n<div id=\"trendingCourse\">\n\n\n</div>\n</div>");
                            jQuery("#trendingCourse").html(innerHtml);
                            jQuery('#trendingCourse').slick({
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
                    });
                } else {
                    jQuery("#show-more").hide();
                }
            });
        }
    });
}




    var nodeBundle = jQuery('#pageNodeBundle').text();  
    if(nodeBundle == 'course_category'){
    jQuery("input[name='filterTrendingCourse[]']").change(function () {
        var taxonomy = jQuery("#category-taxonomy").val();
        if (jQuery("#trendingCourse")) { 
            jQuery.get(serverRootPath + "trending-courses?_format=json", function (data) {
                window.taxonomyCourses = [];
                data.forEach(function (course) { 

                var courseUrl1 = course.path[0].alias.split("/")[1];
                var courseUrl2 = course.path[0].alias.split("/")[2];
                var urlcase = 'college-students';
                if(taxonomy === 'College Students')
                {
                    urlcase = 'college-students';
                }
                else if(taxonomy === 'Graduates')
                {
                    urlcase = 'graduates';
                }
                else if(taxonomy === 'Short Term Courses')
                {
                    urlcase = 'short-term-courses';
                }
               /* else if(taxonomy === 'Working Professionals')
                {
                    urlcase = 'working-professionals';
                }*/
                 if ((urlcase === courseUrl1 && categoryType2 === courseUrl2)  || taxonomy == "all")
                    {
                         window.taxonomyCourses.push(course);
                    }
                });

                window.filterCourses = [];
                var appliedFilters = [];
                jQuery("input[name='filterTrendingCourse[]']").each(function () {
                    var filter = jQuery(this);
                    
                    if (filter.prop("checked")) {
                        appliedFilters.push(filter.val());
                    }

                    if (filter.prop("checked")  && (filter.val() == "field_is_placement_assisted" || filter.val() == "field_is_short_term" || filter.val() == "field_is_most_popular" || filter.val() == "field_new_upcoming")) {
                       
                        window.taxonomyCourses.forEach(function (course, index) {
                            var exists = _.find(window.filterCourses, function (o) {
                                return o.uuid[0].value == course.uuid[0].value;
                            });
                            if (!exists) {
                                if (course[filter.val()][0] && course[filter.val()][0].value) {
                                    window.filterCourses.push(course); 
                                }
                            }
                        });
                    }
                });
                if (appliedFilters.length == 0) {
                    window.taxonomyCourses.forEach(function (course) {
                        window.filterCourses.push(course);
                    });
                }
                
                var limit = window.filterCourses.length > 4 && !jQuery.browser.mobile ? 4 : window.filterCourses.length;
                var innerHtml = "";
                for (var i = 0; i < limit; i++) {
                    var element = window.filterCourses[i];
                    var title = "",
                        image = serverRootPath + "themes/custom/nexus/assets/images/tabimg01.jpg",
                        enrolLink = "",
                        duration = "",
                        certification = "",
                        startingOn = "";

                    if (element.title[0]) {
                        title = element.title[0].value;
                    }

                    var colour;
                    if (element.field_colour[0]) {
                        colour = element.field_colour[0].value;
                    } else {
                        colour = "#75c2be";
                    }

                    if (element.field_course_image[0]) {
                        image = element.field_course_image[0].url;
                    }

                    if (element.field_enroll_now_link[0]) {
                        enrolLink =  window.location.origin + ("/india/lead-form?course=" + element.nid[0].value);
                    }

                    if (element.field_course_duration[0]) {
                        duration = element.field_course_duration[0].value;
                    }

                    if (element.field_course_certification[0]) {
                        certification = element.field_course_certification[0].value;
                    }

                    if (element.field_course_starting_on[0]) {
                        startingOn = element.field_course_starting_on[0].value;
                    }
                    var path = element.path[0] ? element.path[0].alias.substr(1) : "node/" + element.nid[0].value;
                    var knowMoreLink = "" + window.serverRootPath + path;
                    var rating = element.field_rating[0] ? element.field_rating[0].value : 0;
                    var ratingElement = "<div class=\"starrating\">";
                    for (var _i10 = 1; _i10 <= 5; _i10++) {
                        if (_i10 <= rating) {
                            ratingElement = ratingElement + ("<div class=\"rate-image star1-on even s" + _i10 + "\"></div>");
                        } else {
                            ratingElement = ratingElement + ("<div class=\"rate-image star-off odd s" + _i10 + "\"></div>");
                        }
                    }

                    ratingElement = ratingElement + "</div>";

                    innerHtml = innerHtml + ("\n                        <div class=\"col-xs-12\">\n                        <div class=\"cat-item\">\n                        <div class=\"img\" style=\"background-image: url(" + image + "); display: block; height: 20em;\n                        background-position: center;\n                        background-size: cover;\n                        background-repeat: no-repeat;\">\n                        </div>\n                        <div class=\"overlay\">\n                        <div class=\"head\">" + title + "</div>\n                        <div class=\"info finance\" style=\"background-color: " + colour + "\">\n                        <div class=\"detailsinfo\">\n<h3><a href=\"" + knowMoreLink + "\">" + title + "</a>" + ratingElement + "\n<span></span>\n</h3>\n<p> " + duration + "\n<br>Certification:  " + certification + "\n<br>Batch starting soon </p>\n<a class=\"enrollbtn\" href=\"" + enrolLink + "\">Enquire Now</a>\n<a class=\"enrollbtn\" href=\"" + knowMoreLink + "\">Know More </a>\n</div>\n</div>\n</div>\n</div>\n</div>\n");
                }
                window.courseLoaded = limit;
                jQuery("#trendingCourse").remove();
                jQuery("#trendingCourseParent").html("<div class=\"contant-tab\">\n<div id=\"trendingCourse\">\n                            \n                            \n                        </div>\n                    </div>");
                
                jQuery("#trendingCourse").html(innerHtml);

                jQuery('#trendingCourse').slick({
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
                    });
                if (window.filterCourses.length > 4 && !jQuery.browser.mobile) {
                    jQuery("#show-more").show();
                } else {
                    jQuery("#show-more").hide();
                }
            });
        }
    });
    }
});

/******* Mobile Menu code End   *****/


jQuery(function () {
    jQuery(".nav8").click(function () {
        jQuery("html,body").animate({
            scrollTop: jQuery("#section8").offset().top
        }, 1000);
    });
});

if (window.matchMedia("only screen and (min-width:1169px)").matches) {
    
    jQuery(".navmobile").show();
    jQuery("nav").addClass("activate");
} else {
    
    //jQuery.browser.mobile = true;
    jQuery.browser.mobile = true;
    jQuery(".navmobile").hide();
    jQuery("nav").removeClass("activate");
    jQuery(".menuIcon").removeClass("active");
}

jQuery(".navPlacement").click(function () {
    jQuery('html,body').animate({
        scrollTop: jQuery("#placement-assistance").offset().top - 85
    }, 1000);

    if (window.matchMedia("only screen and (max-width:1168px)").matches) {
        jQuery('.navmobile').slideUp();
        jQuery('nav').removeClass('activate');
        jQuery('.menuIcon').removeClass('active');
    } else {}
});
jQuery(".navAlumni").click(function () {
    jQuery('html,body').animate({
        scrollTop: jQuery("#alumni").offset().top - 85
    }, 1000);
    if (window.matchMedia("only screen and (max-width:1168px)").matches) {
        jQuery('.navmobile').slideUp();
        jQuery('nav').removeClass('activate');
        jQuery('.menuIcon').removeClass('active');
    } else {}
});
jQuery(".navKnowledgeCenter").click(function () {
    jQuery('html,body').animate({
        scrollTop: jQuery("#knowledge-center").offset().top - 85
    }, 1000);
    if (window.matchMedia("only screen and (max-width:1168px)").matches) {
        jQuery('.navmobile').slideUp();
        jQuery('nav').removeClass('activate');
        jQuery('.menuIcon').removeClass('active');
    } else {}
});



jQuery(".form-alert").hide();

var request;

jQuery(".gdprForm").submit(function (event) {

    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = jQuery(this);

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    var gdprCheck = $form.find(".gdpr-required");

    if (!gdprCheck[0].checked) {
        alert("You must accept the privacy policy to submit this form.");
        return;
    }

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // Fire off the request to /form.php
    request = jQuery.ajax({
        url: serverRootPath + "forms.php" + window.location.search,
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR) {
        // Log a message to the console
        
        if (response.response == "true") {
            gtag('config', 'AW-935775742');
            //jQuery('#formResponse').modal('show')
            jQuery('#formResponse').fadeIn();
        }
    });

    jQuery('.gdprForm')[0].reset();

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });
});

jQuery(".search-content-form").submit(function (event) {
    var ser2 = jQuery("#textfield").val();
    if (jQuery("#select-box1").val() == "") {
        window.location = serverRootPath + "search/content?keys="+ser2;
        return false;
    }
});
var nodeBundle = jQuery('#pageNodeBundle').text();  
if(nodeBundle == 'course_category'){
if(flagApiCall == true) {
    jQuery(function () {

    
    //if (window.leadForm) {
    var ref = getUrlParameter('ref');

    jQuery.get(serverRootPath + "list-center?_format=json", function (centerList) {
        jQuery.get(serverRootPath + "category-taxonomy?_format=json", function (data) {
            var courseList = '';
            jQuery.get(serverRootPath + "trending-courses?_format=json", function (courses) {
                courses.forEach(function (course) {
                    courseList = courseList + ("<option " + (getUrlParameter('course') == course.uuid[0].value ? "selected=\"selected\"" : '') + " value=\"" + course.title[0].value + "\">" + course.title[0].value + "</option>");
                });
                
                //top-course-category
                var courseTypeList = '';


                data.forEach(function (taxonomy) {

                        courseTypeList = courseTypeList + ("<option " + (getUrlParameter('t') == taxonomy.uuid[0].value  ? "selected=\"selected\"" : '') + " value=\"" + taxonomy.uuid[0].value + "\">" + taxonomy.name[0].value + "</option>");
                });



                window.stateList = [];
                var stateList = '';
                centerList.forEach(function (center) {
                    
                    if (center.field_center_state[0] && center.field_center_state[0].value) {
                        var state = {
                            "name": center.field_center_state[0].value,
                            cities: []
                        };
                        var stateSearchIndex = _.findIndex(window.stateList, function (o) {
                            return o.name == state.name;
                        });
                        if (stateSearchIndex != -1) {
                            state = window.stateList[stateSearchIndex];
                        }
                        if (center.field_center_city[0] && center.field_center_city[0].value) {
                            var city = {
                                "name": center.field_center_city[0].value,
                                centerList: []
                            };
                            var citySearchIndex = _.findIndex(state.cities, function (o) {
                                return o.name == city.name;
                            });
                            if (citySearchIndex != -1) {
                                city = state.cities[citySearchIndex];
                            }
                            city.centerList.push(center);
                            if (citySearchIndex == -1) {
                                state.cities.push(city);
                            }
                        }
                        if (stateSearchIndex == -1) {
                            window.stateList.push(state); 
                        }
                    }
                });
                
                window.stateList.forEach(function (state) {
                    stateList = stateList + ("\n                <option value=\"" + state.name + "\">" + state.name + "</option>\n                ");
                });
                var ref = getUrlParameter('ref');
                var name = "\n            <div class=\"lead-form-group\">\n                <label class=\"lead-form-label\" for=\"name\">Full Name</label>\n                <input name=\"name\" type=\"text\" pattern=\"^[a-zA-Z\\s]*$\" oninvalid=\"setCustomValidity('Numbers and special characters are not allowed in name field')\"\n                            onchange=\"try{setCustomValidity('')}catch(e){}\" required id=\"name\" class=\"lead-form-input\"/>\n            </div>\n            ";
                var companyName = "\n            <div class=\"lead-form-group leadmobmrg\">\n                <label class=\"lead-form-label\" for=\"company\">Company Name</label>\n                <input id=\"company\" name=\"company\" class=\"lead-form-input\" type=\"text\" oninvalid=\"setCustomValidity('Company name is required')\"\n                                onchange=\"try{setCustomValidity('')}catch(e){}\" />\n            </div>\n            ";
                var mobileNumber = "\n            <div class=\"lead-form-group\">\n                <label class=\"lead-form-label\" for=\"phone\">Mobile Number</label>\n                <input type=\"text\" pattern=\"^\\d{10}$\" name=\"phone\" required oninvalid=\"setCustomValidity('Please enter a valid 10 digit mobile number')\"\n                                onchange=\"try{setCustomValidity('')}catch(e){}\" id=\"phone\" class=\"lead-form-input\"/>\n            </div>\n            ";
                var email = "\n            <div class=\"lead-form-group\">\n                <label class=\"lead-form-label\" for=\"email\">Email Id</label>\n                <input id=\"email\" name=\"email\" class=\"lead-form-input\" type=\"email\" oninvalid=\"setCustomValidity('Please enter a valid email')\"\n                                onchange=\"try{setCustomValidity('')}catch(e){}\" required/>\n            </div>\n            ";
                var courseType = "\n            <div class=\"leadf\">\n                <select " + (getUrlParameter('t') ? 'disabled' : '') + " id=\"leadform-coursetype\" name=\"courseType\" class=\"form-control\" style=\"background: transparent; border-radius: 0; padding: 12px 0px 5px 0; width: 100%; border: 0; box-shadow: 0 1px 0 0 #d3d3d3; transition: box-shadow 150ms ease-out; background: none; margin-top: 12px; font-weight: 400; color: #90939c; font-size: 20px; height: 45px\">\n                    <option value=\"\">Course Type</option>\n                    " + courseTypeList + "\n                </select>\n            </div>\n            ";
                var designation = "\n            <div class=\"lead-form-group\">\n                <label class=\"lead-form-label\" for=\"designation\">Designation</label>\n                <input id=\"designation\" name=\"designation\" class=\"lead-form-input\" type=\"text\"/>\n            </div>\n            ";
                var city = "\n            <div class=\"leadf\">\n                <select required id=\"stateCity\" name=\"city\" class=\"form-control\" style=\"background: transparent; border-radius: 0; padding: 12px 0px 5px 0; width: 100%; border: 0; box-shadow: 0 1px 0 0 #d3d3d3; transition: box-shadow 150ms ease-out; background: none; margin-top: 12px; font-weight: 400; color: #90939c; font-size: 20px; height: 45px\">\n                    <option>City</option>\n                </select>\n            </div>\n            ";
                var state = "\n            <div class=\"leadf\">\n                <select required id=\"stateSelect\" name=\"state\" class=\"form-control\" style=\"background: transparent; border-radius: 0; padding: 12px 0px 5px 0; width: 100%; border: 0; box-shadow: 0 1px 0 0 #d3d3d3; transition: box-shadow 150ms ease-out; background: none; margin-top: 12px; font-weight: 400; color: #90939c; font-size: 20px; height: 45px\">\n                    <option>State</option>\n                    " + stateList + "\n                </select>\n            </div>\n            ";
                var pinCode = "\n            <div class=\"lead-form-group leadpin-margin\">\n                <label class=\"lead-form-label\" for=\"pin\">Pin Code</label>\n                <input id=\"pin\" name=\"pin\" class=\"lead-form-input\" type=\"text\" oninvalid=\"setCustomValidity('Please enter a valid pin code')\" pattern=\"^\\d{6}$\" name=\"pin\"\n                onchange=\"try{setCustomValidity('')}catch(e){}\"/>\n            </div>\n            ";
                var country = "\n            <div class=\"leadf\">\n                <select id=\"Country\" name=\"country\" class=\"form-control\" style=\"background: transparent; border-radius: 0; padding: 12px 0px 5px 0; width: 100%; border: 0; box-shadow: 0 1px 0 0 #d3d3d3; transition: box-shadow 150ms ease-out; background: none; margin-top: 12px; font-weight: 400; color: #90939c; font-size: 20px; height: 45px\">\n                    <option value=\"\">Country</option>\n                    <option value=\"India\">India</option>\n                </select>\n            </div>\n            ";
                var query = "\n            <div class=\"lead-form-group leadwidth\">\n                <label class=\"lead-form-label\" for=\"query\">Query</label>\n                <input id=\"query\" class=\"lead-form-input\" name=\"query\" type=\"text\"/>\n            </div>\n            ";
                var course = "\n                    <div class=\"leadf\">\n                    <select " + (getUrlParameter('course') ? 'disabled' : '') + " required id=\"Course\" name=\"course\" class=\"form-control\" style=\"background: transparent; border-radius: 0; padding: 12px 0px 5px 0; width: 100%; border: 0; box-shadow: 0 1px 0 0 #d3d3d3; transition: box-shadow 150ms ease-out; background: none; margin-top: 12px; font-weight: 400; color: #90939c; font-size: 20px; height: 45px\">\n                        <option value=\"\">Course</option>\n                        " + courseList + "\n                    </select>\n                </div>\n            ";
                var submit = "\n            <div class=\"lead-form-sbmt\"><input type=\"submit\" name=\"button\" id=\"button\" value=\"submit\"\n                                                    class=\"btn-leadform\"></div>\n            ";
                var gdpr = "\n                    <div class=\"publish_checkbox\">\n                        <div class=\"js-form-item form-item js-form-type-checkbox form-item-checkbox js-form-item-checkbox\">\n                            <input type=\"checkbox\" id=\"edit-checkbox\" name=\"checkbox\" value=\"1\" class=\"form-checkbox required gdpr-required\" aria-required=\"true\">\n                            <label for=\"edit-checkbox\" class=\"option\">Please tick this box to indicate that you understand that your personal data will be used in accordance with the <a target=\"_blank\" href=\"https://ppm.niit.com/consent-form/prospective_customer.html\" style=\"color: #0161b5;\">Privacy Policy</a> here *</label>\n                        </div>\n                    </div>\n                    ";
                var innerHtml = "";
                var bannerInnerHtml = "";
                switch (ref) {
                    case 'school':
                        jQuery(".breadcrumb-replace").html("School");
                        bannerInnerHtml = "\n                        <img src=\"" + window.schoolBannerImage + "\" class=\"hide600\" width=\"\" height=\"\"> <img\n                            src=\"" + window.schoolBannerImage + "\" class=\"show600\" width=\"\" height=\"\">\n                        <div class=\"contantbox leadform-bannerbox\">\n                        " + window.schoolBannerText + "\n                        </div>\n                        ";
                        innerHtml = "\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + name + "\n                        </div>\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + email + "\n                        </div>\n                    </div>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + mobileNumber + "\n                        </div>\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + companyName + "\n                        </div>\n                    </div>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-12\">\n                            " + query + "\n                        </div>\n                    </div>\n                    ";
                        break;
                    case 'enterprises':
                        jQuery(".breadcrumb-replace").html("Enterprises");
                        bannerInnerHtml = "\n                        <img src=\"" + window.enterprisesBannerImage + "\" class=\"hide600\" width=\"\" height=\"\"> <img\n                            src=\"" + window.enterprisesBannerImage + "\" class=\"show600\" width=\"\" height=\"\">\n                        <div class=\"contantbox leadform-bannerbox\">\n                        " + window.enterprisesBannerText + "\n                        </div>\n                        ";
                        innerHtml = "\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + name + "\n                        </div>\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + email + "\n                        </div>\n                    </div>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + mobileNumber + "\n                        </div>\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + companyName + "\n                        </div>\n                    </div>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-12\">\n                            " + query + "\n                        </div>\n                    </div>\n                    ";
                        break;
                    case 'course':
                    case 'category':
                    default:
                        jQuery(".breadcrumb-replace").html("Talk To Our Experts");
                        bannerInnerHtml = "\n                        <img src=\"" + window.courseBannerImage + "\" class=\"hide600\" width=\"\" height=\"\"> <img\n                            src=\"" + window.courseBannerImage + "\" class=\"show600\" width=\"\" height=\"\">\n                        <div class=\"contantbox leadform-bannerbox\">\n                        " + window.courseBannerText + "\n                        </div>\n                        ";
                        innerHtml = "\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + name + "\n                        </div>\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + email + "\n                        </div>\n                    </div>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + mobileNumber + "\n                        </div>\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + companyName + "\n                        </div>\n                    </div>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + designation + "\n                        </div>\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + courseType + "\n                        </div>\n                    </div>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-12\">\n                            " + course + "\n                        </div>\n                    </div>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + country + "\n                        </div>\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + state + "\n                        </div>\n                    </div>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + city + "\n                        </div>\n                        <div class=\"col-xs-12 col-sm-6\">\n                            " + pinCode + "\n                        </div>\n                    </div>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12 col-sm-12\">\n                            " + query + "\n                        </div>\n                    </div>\n                    ";
                        break;
                }
                innerHtml = innerHtml + gdpr + submit;
                jQuery("#leadform-container").html(innerHtml);
                jQuery("#lead-form-banner").html(bannerInnerHtml);

                jQuery('.lead-form-group input').focus(function () {
                    jQuery(this).parents('.lead-form-group').addClass('lead-focused');
                });

                jQuery('.lead-form-group input').blur(function () {
                    var inputValue = jQuery(this).val();
                    if (inputValue == "") {
                        jQuery(this).removeClass('filled');
                        jQuery(this).parents('.lead-form-group').removeClass('lead-focused');
                    } else {
                        jQuery(this).addClass('filled');
                    }
                });
                jQuery("#stateSelect").change(function () {
                    var val = jQuery(this).val();
                    //alert(val);
                    window.stateList.forEach(function (state) {
                        if (state.name == val) {
                            jQuery("#stateCity").html('<option>Select City</option>');
                            state.cities.forEach(function (city) {
                                jQuery("#stateCity").append("\n                    <option value=\"" + city.name + "\">" + city.name + "</option>\n                    ");
                            });
                        }
                    });
                });
            });
        });
        
    });
    //}
    var course_category = getUrlParameter('course_category');
    if (course_category) {
        jQuery('#leadform-coursetype').val(course_category);
    }
    jQuery(".leadform-category-url").attr("href", jQuery(".leadform-category-url").attr("href") + "?ref=category");
});
}
}

if(flagApiCall == true) {

    jQuery(function () {
        jQuery('.search-content-form').attr('action', window.location.origin + '/india/search/content');

        jQuery("#subscribe-form form").attr('action', jQuery("#subscribe-form form").attr('action') + '?subscribed=true');

        jQuery("#subscribe-form form input.form-email").attr('placeholder', "your.email@domain.com");

        if (getUrlParameter("subscribed") == "true") {
            // #newsletter-modal
            jQuery('#newsletter-modal').modal('show');
        }

        if (jQuery.browser.mobile) {
            jQuery("#show-more").hide();
        }
    });
}
jQuery("#lead-form-api").submit(function (event) {

    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = jQuery(this);

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    var gdprCheck = $form.find(".gdpr-required");

    if (!gdprCheck[0].checked) {
        alert("You must accept the privacy policy to submit this form.");
        return;
    }

    // Serialize the data in the form
    var serializedData = $form.serialize();

    
    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // Fire off the request to /form.php
    request = jQuery.ajax({
        url: serverRootPath + "forms.php" + window.location.search,
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR) {
        // Log a message to the console
        
        jQuery('#formResponse').modal('show');
        if (response.response == "true") {
            gtag('config', 'AW-935775742');
            jQuery('#formResponse').modal('show');
            // $inputs.each(function () {
            //     jQuery(this).val('');
            // });
        }
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        gtag('config', 'AW-935775742');
        jQuery('#formResponse').modal('show');
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputss
        $inputs.prop("disabled", false);
    });
});

jQuery(function () {
    jQuery("[data-bgcolour]").each(function (index) {
        jQuery(this).css("background-color", jQuery(this).attr("data-bgcolour"));
    });
});

jQuery(function () {
    var allUserReviewBoxes = jQuery(".user-review-box");
    var x = Math.floor(Math.random() * 5);
    jQuery(allUserReviewBoxes[x]).show();
});

jQuery('#alumni_slider').slick({
    infinite: true,
    arrows: true,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
    adaptiveHeight: false,
    responsive: [{
    breakpoint: 1200,
    settings: {
    slidesToShow: 1,
    autoplay: true,
    slidesToScroll: 1,
    infinite: true
    }
    }, {
    breakpoint: 1024,
    settings: {
    slidesToShow: 1,
    autoplay: true,
    slidesToScroll: 1
    }
    }, {
    breakpoint: 768,
    settings: {
    slidesToShow: 1,
    autoplay: true,
    slidesToScroll: 1
    }
    }, {
    breakpoint: 600,
    settings: {
    slidesToShow: 1,
    adaptiveHeight: true,
    autoplay: true,
    slidesToScroll: 1
    }
    }]
});


$(".refreshSlider").click(function() {

   $('.slider6aply').slick('refresh');

});

/* For Placement Page JS */


var sliderForCareer = jQuery('.slider6aply');  

$.each(sliderForCareer, function (index, eventCarousalCareer) { 

   if (!$(eventCarousalCareer).is('.slick-initialized')) { 
         
        $(eventCarousalCareer).slick({

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
/* For Placement Page JS */


