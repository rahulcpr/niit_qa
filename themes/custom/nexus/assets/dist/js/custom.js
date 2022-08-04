'use strict';
(function ($) {
  $(window).on('load', function () {

    /* Navigation */

// $('#main-menu > nav > ul').superfish({
//       delay: 0, 
//       animation: { opacity: 'show', height: 'show' }, 
//       dropShadows: true 
//     });

$("#rating-and-review-head").click(function() {
    $('html, body').animate({
        scrollTop: $("#rating-and-review").offset().top
    }, 2000);
});

$('#navigation ul.sf-js-enabled').slicknav();

var hrefVal =  $('#courseCategory').attr('href'); 
if(hrefVal != null){
var baseurl = window.location.origin; // return hostname  
var pathname = window.location.pathname; // Returns path only
var pathSplited = pathname.split('/');
var length = pathSplited.length;

var res = hrefVal.replace("category", pathSplited[length-2]);
var hrefUrlslash = baseurl+"/"+res;
var hrefUrl = hrefUrlslash.replace('//india', '/india'); 
$('#courseCategory').attr('href', '');
$('#courseCategory').attr('href', hrefUrl);
}



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
	  
  });

})(jQuery);

(function () {
  var is_webkit = navigator.userAgent.toLowerCase().indexOf('webkit') > -1,
      is_opera = navigator.userAgent.toLowerCase().indexOf('opera') > -1,
      is_ie = navigator.userAgent.toLowerCase().indexOf('msie') > -1;

  if ((is_webkit || is_opera || is_ie) && 'undefined' !== typeof document.getElementById) {
    var eventMethod = window.addEventListener ? 'addEventListener' : 'attachEvent';
    window[eventMethod]('hashchange', function () {
      var element = document.getElementById(location.hash.substring(1));

      if (element) {
        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) element.tabIndex = -1;

        element.focus();
      }
    }, false);
  }
})();




jQuery(document).ready(function(){
	
jQuery('.slider4show').slick({
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
jQuery(".mentors").slick({
        dots: false,
        infinite: true,
		arrow: true,
        slidesToShow: 2,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                    dots: false,
                    arrow: true,
                    slidesToScroll: 1
                }
            },{ breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    dots: false,
                    arrow: true,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 490,
                settings: {
                    slidesToShow: 1,
                    dots: false,
                    slidesToScroll: 1
                }
            }]
      });
jQuery(".driveinindia").slick({
        dots: true,
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                    dots: false,
                    arrow: true,
                    slidesToScroll: 1
                }
            },{ breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    dots: false,
                    arrow: true,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 490,
                settings: {
                    slidesToShow: 1,
                    dots: false,
                    slidesToScroll: 1
                }
            }]
      });	  
jQuery('.event_carousel').slick({
        infinite: true,
          arrows: true,
          speed: 500,
          slidesToShow: 2,
          slidesToScroll: 1,
          autoplay: false,
          autoplaySpeed: 3000,
          adaptiveHeight: true,
          responsive: [{
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
          }]
      });  
jQuery('.slider4aply').slick({
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

jQuery.fn.randomize = function (selector) {
        var $elems = selector ? $(this).find(selector) : $(this).children(),
            $parents = $elems.parent();

        $parents.each(function () {
            $(this).children(selector).sort(function (childA, childB) {
                // * Prevent last slide from being reordered
                if ($(childB).index() !== $(this).children(selector).length - 1) {
                    return Math.round(Math.random()) - 0.5;
                }
            }.bind(this)).detach().appendTo(this);
        });

        return this;
    }; 

jQuery(".archive-slider-random").randomize().slick({
    dots: false,
    infinite: true,
    arrows: true,
    speed: 500,
  slidesPerRow: 4,
    rows: 2,
    centerMode: true,
    centerPadding: '0px',
    adaptiveHeight: true,
    autoplay: false,
    autoplaySpeed: 3000,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                arrows: true,
        slidesPerRow: 3,
          rows: 2,
                infinite: true
            }
    }, {
            breakpoint: 768,
            settings: {
                arrows: true,
        slidesPerRow: 2,
          rows: 2
            }
        }, {
            breakpoint: 600,
            settings: {
                arrows: true,
        slidesPerRow: 2,
          rows: 2
            }
        }, {
            breakpoint: 480,
            settings: {
                arrows: true,
        slidesPerRow: 1,
        slidesToShow: 1,
          rows: 2
            }
        }
    ]
});

jQuery(".archive-slider").slick({
    dots: false,
    infinite: true,
    arrows: true,
    speed: 500,
	slidesPerRow: 4,
    rows: 2,
    centerMode: true,
    centerPadding: '0px',
    adaptiveHeight: true,
    autoplay: false,
    autoplaySpeed: 3000,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                arrows: true,
				slidesPerRow: 3,
    			rows: 2,
                infinite: true
            }
		}, {
            breakpoint: 768,
            settings: {
                arrows: true,
				slidesPerRow: 2,
    			rows: 2
            }
        }, {
            breakpoint: 600,
            settings: {
                arrows: true,
				slidesPerRow: 2,
    			rows: 2
            }
        }, {
            breakpoint: 480,
            settings: {
                arrows: true,
				slidesPerRow: 1,
				slidesToShow: 1,
    			rows: 2
            }
        }
    ]
});
 



jQuery('.star_alumni_slider, .star_faculty_slider').slick({
      autoplay:true,
	  infinite: true,
	  slidesToShow:2,
	  slidesToScroll: 2,
	  arrows:true,
      prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
      nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
      responsive: [
      {
	  breakpoint: 1024,
	  settings: {
		slidesToShow: 1,
		slidesToScroll: 1
	  }
	}
  ]
}); 
jQuery(".placementcom").slick({
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
jQuery(".slidermain").slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        autoplay: true,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                dots: false,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 490,
            settings: {
                slidesToShow: 1,
                dots: false,
                slidesToScroll: 1
            }
        }]
    });	    
jQuery('.knowledge').slick({
        dots: false,
        infinite: true,
		arrows: true,
        speed: 500,
        slidesToShow: 3,
        slidesToScroll: 1,
		autoplay:false,
		autoplaySpeed:3000,
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
jQuery(".knowledge-2").slick({
                            dots: false,
                            infinite: true,
                            arrows: false,
                            speed: 500,
                            slidesToShow: 2,
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
jQuery(".knowledge-centers").slick({
    dots: false,
    infinite: true,
    arrows: true,
    speed: 500,
    slidesToShow: 3,
    slidesToScroll: 1,
    centerMode: true,
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
jQuery(".amazing_com").slick({
        dots: false,
        infinite: true,
        arrows: true,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: '0px',
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

						

//////////////////////////////////////////////////////
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
}

///////////////////////////////////////////////
///////////////////////////////////////////////////////Footer ///////////////////////////////////////////////////
jQuery(function () {
    if (window.matchMedia("only screen and (max-width:767px)").matches) {
        jQuery(".accordionContent1").hide();
        jQuery("#accon1").show();
    } else {
        jQuery(".accordionContent1").show();
        jQuery(".accordionButton1").removeClass("on1");
        jQuery(".accordionButton1").css({
            "background-image": "none"
        });
    }
    jQuery(".accordionButton1").click(function () {
        if (window.matchMedia("only screen and (max-width:767px)").matches) {
            jQuery(".accordionButton1").removeClass("on1");
            jQuery(".accordionContent1").slideUp("normal");
            if (jQuery(this).next().is(":hidden") == true) {
                jQuery(this).addClass("on1");
                jQuery(this).next().slideDown("normal");
            }
        } else {
            jQuery(".accordionContent1").show();
            //jQuery('.accordionButton1').removeClass('on1');
        }
    });
	
	
	
	
	
});

jQuery(".accordionButton").click(function () {
    jQuery(".accordionButton").removeClass("on");
    jQuery(".accordionContent").slideUp("normal");
    if (jQuery(this).next().is(":hidden") == true) {
        jQuery(this).addClass("on");
        jQuery(this).next().slideDown("normal");
    }
});
jQuery(".accordionContent").hide();

jQuery(window).resize(function () {
    if (window.matchMedia("only screen and (max-width:767px)").matches) {
        jQuery(".accordionContent1").hide();
    } else {
        jQuery(".accordionContent1").show();
        jQuery(".accordionButton1").removeClass("on1");
        jQuery(".accordionButton1").css({
            "background-image": "none"
        });
    }
});
///////////////////////////////////////////////////////Footer ///////////////////////////////////////////////////

jQuery(function () {
    jQuery(".srchpop").click(function () {
        jQuery(".tcbox, .overlay4").fadeIn();
    });
    jQuery(".closetcpop").click(function () {
        jQuery(".tcbox, .overlay4").fadeOut();
    });
    ////////////////////////////////////////////////
    jQuery(".errorbtn").click(function () {
        jQuery(".errorbox, .overlay5").fadeIn();
    });
    jQuery(".closepop").click(function () {
        jQuery(".overlay5").fadeOut();
        jQuery(".modal-backdrop").fadeOut();
        jQuery("body").removeClass("modal-open");
    });
    ////////////////////////////////////////////////
    jQuery("#getc").click(function () {
        jQuery(".fieldwraprel").slideToggle();
        jQuery("html,body").animate({
            scrollTop: jQuery("#getc").offset().top
        }, 1000);
    });
});

jQuery(function () {
    var expanded = false;
    jQuery(".filtrmob").click(function () {
        if (expanded = !expanded) {
            jQuery(".filtrbx").animate({
                "margin-left": 15
            }, "slow");
        } else {
            jQuery(".filtrbx").animate({
                "margin-left": -315
            }, "slow");
        }
    });
});

/*Fix Header Start */
jQuery(document).scroll(function () {
    if (jQuery(document).scrollTop() >= 38) {
        jQuery(".stickyhero-tabs-container").addClass("fixedActice");
    } else {
        jQuery(".stickyhero-tabs-container").removeClass("fixedActice");
    }
});

jQuery(window).resize(function () {
    if (window.matchMedia("only screen and (min-width:1169px)").matches) {} else {}
});

/*Fix Header End */


jQuery(".regular-growth select").each(function () {
    var $this = jQuery(this),
        numberOfOptions = jQuery(this).children("option").length;

    $this.addClass("select-hidden");
    $this.wrap('<div class="select"></div>');
    $this.after('<div class="select-styled"></div>');

    var $styledSelect = $this.next("div.select-styled");
    $styledSelect.text($this.children("option").eq(0).text());

    var $list = jQuery("<ul />", {
        class: "select-options"
    }).insertAfter($styledSelect);

    for (var i = 0; i < numberOfOptions; i++) {
        jQuery("<li />", {
            text: $this.children("option").eq(i).text(),
            rel: $this.children("option").eq(i).val()
        }).appendTo($list);
    }

    var $listItems = $list.children("li");

    $styledSelect.click(function (e) {
        e.stopPropagation();
        jQuery("div.select-styled.active").not(this).each(function () {
            jQuery(this).removeClass("active").next("ul.select-options").hide();
        });
        jQuery(this).toggleClass("active").next("ul.select-options").toggle();
    });

    $listItems.click(function (e) {
        e.stopPropagation();
        $styledSelect.text(jQuery(this).text()).removeClass("active");
        $this.val(jQuery(this).attr("rel"));
        $list.hide();
    });

    jQuery(document).click(function () {
        $styledSelect.removeClass("active");
        $list.hide();
    });
});
//////////////////////////////////

jQuery(function () {
    jQuery(".nav8").click(function () {
        jQuery("html,body").animate({
            scrollTop: jQuery("#section8").offset().top
        }, 1000);
    });
});

// Scroll On TOP //
jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 100) {
        jQuery(".back-top").fadeIn();
    } else {
        jQuery(".back-top").fadeOut();
    }
});
jQuery(".back-top a").click(function () {
    jQuery("html, body").animate({
        scrollTop: 0
    }, 800);
    return false;
});











