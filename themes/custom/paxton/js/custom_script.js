/* Attached Drupal behavior */ 
(function ($, Drupal, drupalSettings) {
	Drupal.behaviors.hmel = {
		attach: function (context, settings) {
			/* Default hide Search form */ 
			$('#views-exposed-form-ifbi-insights-insights-listing .form-actions input, #views-exposed-form-news-ifbi-page-1 .form-actions input').hide();
			/* End */ 
			
			/* Placeholder on site search */ 
			$('.search-block-form .form-search').attr("placeholder", "Search");
			/* End */ 

			/* solution of Homepage view mode text none */ 
			$('.homepage-solution-view-mode a').text('');
			/* End */ 
		}
	};
})(jQuery, Drupal, drupalSettings);


jQuery(document).ready(function(){
	if(jQuery('body').hasClass('path-ifbi-team')) {
		getAccordion("#tab-data ul",768);
	}
	jQuery('.search-block-form #search-block-form').hide();
	jQuery(".Header_Search").click(function(){
		jQuery(".Header_Search").addClass("searchclose"); 
		jQuery(".Header_Search_Close").addClass("searchopen"); 
		jQuery('.search-block-form .form-search').show();
		jQuery('.search-block-form #search-block-form').show();
		
	});
	jQuery(".Header_Search_Close").click(function(){
		jQuery(".Header_Search_Close").removeClass("searchopen");
		jQuery(".Header_Search").removeClass("searchclose");
		jQuery('.search-block-form .form-search').hide();
		jQuery('.search-block-form #search-block-form').hide();
	});
	
	jQuery(".back-top").click(function(){
		jQuery("html, body").animate({ scrollTop: 0 }, "slow");
	});
	
	jQuery(".ifbi-solutions").attr("href", "#");
	
/* 	jQuery(".team-title").click(function(){
		alert($(this).attr('role'));
	});
 */});

jQuery(window).scroll(function(){
	if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		jQuery(".back-top").show();
	} else {
		jQuery(".back-top").hide();
	}
});