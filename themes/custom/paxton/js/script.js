
    jQuery("#carousel").owlCarousel({
      autoplay: true,
      lazyLoad: true,
      loop: true,
      margin: 20,
      /*
     animateOut: 'fadeOut',
     animateIn: 'fadeIn',
     */
      responsiveClass: true,
      autoHeight: true,
      autoplayTimeout: 7000,
      smartSpeed: 800,
      nav: true,
      responsive: {
        0: {
          items: 1
        },

        600: {
          items: 2
        },

        1024: {
          items: 4
        },

        1366: {
          items: 6
        }
      }
    });
    jQuery("#carousel2").owlCarousel({
      autoplay: true,
      lazyLoad: true,
      loop: true,
      margin: 20,
      /*
     animateOut: 'fadeOut',
     animateIn: 'fadeIn',
     */
      responsiveClass: true,
      autoHeight: true,
      autoplayTimeout: 7000,
      smartSpeed: 800,
      nav: true,
      responsive: {
        0: {
          items: 1
        },

        600: {
          items: 2
        },

        1024: {
          items: 4
        },

        1366: {
          items: 4
        }
      }
    });
    jQuery("#carousel3").owlCarousel({
      autoplay: true,
      lazyLoad: true,
      loop: true,
      margin: 20,
      /*
     animateOut: 'fadeOut',
     animateIn: 'fadeIn',
     */
      responsiveClass: true,
      autoHeight: true,
      autoplayTimeout: 7000,
      smartSpeed: 800,
      nav: true,
      responsive: {
        0: {
          items: 1
        },

        600: {
          items: 2
        },

        1024: {
          items: 4
        },

        1366: {
          items: 4
        }
      }
    });
    jQuery("#carousel4").owlCarousel({
      autoplay: true,
      lazyLoad: true,
      loop: true,
      margin: 20,
      /*
     animateOut: 'fadeOut',
     animateIn: 'fadeIn',
     */
      responsiveClass: true,
      autoHeight: true,
      autoplayTimeout: 7000,
      smartSpeed: 800,
      nav: true,
      responsive: {
        0: {
          items: 1
        },

        600: {
          items: 1
        },

        1024: {
          items: 2
        },

        1366: {
          items: 2
        }
      }
    });
    jQuery("#carousel5").owlCarousel({
      autoplay: true,
      lazyLoad: true,
      loop: true,
      margin: 20,
      /*
     animateOut: 'fadeOut',
     animateIn: 'fadeIn',
     */
      responsiveClass: true,
      autoHeight: true,
      autoplayTimeout: 7000,
      smartSpeed: 800,
      nav: true,
      responsive: {
        0: {
          items: 2
        },

        600: {
          items: 2
        },

        1024: {
          items: 4
        },

        1366: {
          items: 6
        }
      }
    });
    jQuery("#carousel6").owlCarousel({
      autoplay: true,
      lazyLoad: true,
      loop: true,
      margin: 20,
      responsiveClass: true,
      autoHeight: true,
      autoplayTimeout: 7000,
      smartSpeed: 800,
      nav: true,
      responsive: {
        0: {
          items: 1
        },

        600: {
          items: 1
        },

        1024: {
          items: 2
        },

        1366: {
          items: 3
        }
      }
    });
    jQuery("#carousel7").owlCarousel({
      autoplay: true,
      lazyLoad: true,
      loop: true,
      margin: 20,
      responsiveClass: true,
      autoHeight: true,
      autoplayTimeout: 7000,
      smartSpeed: 800,
      nav: true,
      responsive: {
        0: {
          items: 1
        },

        600: {
          items: 1
        },

        1024: {
          items: 2
        },

        1366: {
          items: 2.5
        }
      }
    });

var topbtn = $('#topbtn');
$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    topbtn.addClass('show');
  } else {
    topbtn.removeClass('show');
  }
});
topbtn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});

