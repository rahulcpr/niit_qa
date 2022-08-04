jQuery(".gallery-responsive").slick({
    dots: !0,
    arrows: !1,
    infinite: !0,
    speed: 300,
    slidesToShow: 2,
    slidesToScroll: 1,
    autoplay: !1,
    autoplaySpeed: !1,
    responsive: [{
        breakpoint: 1024,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: !0,
            dots: !1
        }
    }, {
        breakpoint: 600,
        settings: {
            slidesToShow: 1.03,
            slidesToScroll: 1,
            dots: !1
        }
    }, {
        breakpoint: 480,
        settings: {
            slidesToShow: 1.03,
            slidesToScroll: 1,
            dots: !1
        }
    }]
});
jQuery(document).ready(function() {
    jQuery('[data-toggle="tooltip"]').tooltip()
})

/*mega menu*/
jQuery(document).ready(function() {
    jQuery("div.bhoechie-tab-menu>div.list-group>a").click(function(a) {
        a.preventDefault(), jQuery(this).siblings("a.active").removeClass("active"), jQuery(this).addClass("active");
        var b = jQuery(this).index();
        jQuery("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active"), jQuery("div.bhoechie-tab>div.bhoechie-tab-content").eq(b).addClass("active")
    })
})

jQuery(document).ready(function() {
    jQuery(".program_cta").click(function() {
        jQuery("#mega_menu_new").slideToggle("slow"), jQuery("body").toggleClass("fixed-position")
    })
})
jQuery(document).ready(function() {
    jQuery("#collapse_it").click(function() {
        jQuery("#mega_menu_new").slideToggle("slow"), jQuery("body").toggleClass("fixed-position")
    })
})

/*mobile Navigation*/

console.clear();
const navExpand = [].slice.call(document.querySelectorAll(".nav-expand")),
    backLink = `<li class="nav-item">
    <a class="nav-link nav-back-link img-ds nav-expand-link" href="javascript:;">
        <i class="fa fa-arrow-left"></i> <span> Go Back</span>
            </a>
</li>`;
navExpand.forEach(a => {
    a.querySelector(".nav-expand-content").insertAdjacentHTML("afterbegin", backLink), a.querySelector(".nav-link").addEventListener("click", () => a.classList.add("active")), a.querySelector(".nav-back-link").addEventListener("click", () => a.classList.remove("active"))
});
const ham = document.getElementById('ham');
if (ham) {
ham.addEventListener("click", function() {
    document.body.classList.toggle("nav-is-toggled");
});
}
const sach = document.getElementById('mob_close_it');
if (sach) {
sach.addEventListener('click', function() {
    document.body.classList.toggle('nav-is-toggled');
});
}

jQuery(document).ready(function() {

    /* Small card slider */
    jQuery(".slider").slick({
        arrows: !0,
        dots: !1,
        infinite: !0,
        initialSlide: 0,
        slidesToScroll: 1,
        slidesToShow: 1,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                adaptiveHeight: !0
            }
        }, {
            breakpoint: 600,
            settings: {
                centerMode: !1,
                variableWidth: !0,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: !0,
                autoplaySpeed: 2500,
                swipeToSlide: !0,
                pauseOnHover: !0,
                pauseOnFocus: !0,
                arrows: !1,
                touchMove: !0,
                focusOnSelect: !0,
            }
        }]
    })

    jQuery(".slider-related-courses").slick({
        arrows: true,
        dots: false,
        infinite: true,
        initialSlide: 0.5,
        slidesToScroll: 1,
        slidesToShow: 2.5,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                adaptiveHeight: true
            }
        }, {
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
                focusOnSelect: true
            }
        }]
    })

    /* Big cards slider */
    jQuery(".slider-big-cards-new").slick({
        arrows: !0,
        dots: !0,
        infinite: !0,
        initialSlide: .5,
        slidesToScroll: 1,
        slidesToShow: 2.5,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                adaptiveHeight: !0
            }
        }, {
            breakpoint: 600,
            settings: {
                centerMode: !1,
                variableWidth: !0,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: !0,
                autoplaySpeed: 2500,
                swipeToSlide: !0,
                pauseOnHover: !0,
                pauseOnFocus: !0,
                arrows: !1,
                touchMove: !0,
                focusOnSelect: !0,
                swipeToSlide: !0
            }
        }]
    })

    // jQuery(".accordion").on("click", ".heading", function() {
    //         jQuery(this).toggleClass("active").next().slideToggle();
    //         jQuery(".contents").not(jQuery(this).next()).slideUp(300);
    //         jQuery(this).siblings().removeClass("active");});
    jQuery(".1-heading").click(function() {
        jQuery(".1-contents").slideToggle("300");
    });
    jQuery(".2-heading").click(function() {
        jQuery(".2-contents").slideToggle("300");
    });

});

jQuery().ready(function() {
    jQuery(".get-started-slider").slick({
        arrows: !0,
        dots: !1,
        slidesToShow: 2,
        nextArrow: '<div class="slick-custom-arrow slick-custom-arrow-right"><i class="fa fa-angle-right"></i></div>',
        prevArrow: '<div class="slick-custom-arrow slick-custom-arrow-left"><i class="fa fa-angle-left"></i></div>',
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: !0,
                dots: !1
            }
        }, {
            breakpoint: 600,
            settings: {
                slidesToShow: 1.10,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 480,
            settings: {
                slidesToShow: 1.10,
                slidesToScroll: 1
            }
        }]
    })
})

jQuery(".gallery-responsive1").slick({
    dots: !0,
    arrows: !1,
    infinite: !0,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: !0,
    autoplaySpeed: 5e4,
    responsive: [{
        breakpoint: 1024,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: !0,
            dots: !0
        }
    }, {
        breakpoint: 600,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 480,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
    }]
})
jQuery(function () {

    jQuery(".step-point-content:not(:first-of-type)").css("display", "none");
    jQuery(".step-res-heading:first-of-type").addClass("open");
       
    jQuery(".step-res-heading").click(function () {
     jQuery(".open").not(this).removeClass("open").next().slideUp(300);
     jQuery(this).toggleClass("open").next().slideToggle(300);
    });
      });
     
     //tabbing js
     jQuery(document).ready(function() {
    // Add minus icon for collapse element which is open by default
    jQuery(".collapse.in").each(function() {
     jQuery(this)
    .siblings(".faq-res-heading")
    .find(".glyphicon")
    .addClass("rotate");
    });
     
    // Toggle plus minus icon on show hide of collapse element
    jQuery(".collapse")
     .on("show.bs.collapse", function() {
    jQuery(this)
     .parent()
     .find(".glyphicon")
     .addClass("rotate");
     })
     .on("hide.bs.collapse", function() {
    jQuery(this)
     .parent()
     .find(".glyphicon")
     .removeClass("rotate");
     });
      });
// jQuery(".gallery-responsive").slick({dots:!0,arrows:!1,infinite:!0,speed:300,slidesToShow:1.7,slidesToScroll:1,autoplay:!1,autoplaySpeed:!1,responsive:[{breakpoint:1024,settings:{slidesToShow:1.7,slidesToScroll:1,infinite:!0,dots:!0}},{breakpoint:600,settings:{slidesToShow:1.7,slidesToScroll:1}},{breakpoint:480,settings:{slidesToShow:1,slidesToScroll:1}}]})

var pan = jQuery('#pageNodeBundle').text();
if (pan == 'course_category') {
    jQuery('.list-unstyled .req_callb').remove();

}