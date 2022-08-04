// jQuery Document Ready Function Start
jQuery( document ).ready(function() {
    setTimeout(function() {
        $(".course").addClass("mid-course");
        $(".mid-course .link").addClass("mid-link");
        $('.add-cl >li:nth-child(3)').addClass("listitem2");
     //   $('.main-header ul li:nth-child(3)').addClass("listitem3");
        $(".banner-slider .button-primary").addClass("view_coursebtn");
        $(".banner-slider .button-primary span").addClass("view_videoebtn");
        $(".top-nav .button-primary").addClass("call_btn");
        $(".mid-course .button-secondary").addClass("allcourse_btn");
		$(".contentimgrow label").addClass("article-name");
		$("#collapse-course-0 .new_mutlistep_apply_btn").addClass("middle-enroll");
		$('#afterlogin-userinfo ul li:nth-child(4)').addClass("signout-user");
		$('.social a:nth-child(1)').addClass("accle-twi");
		$('.social a:nth-child(2)').addClass("accle-fb");
		$('.social a:nth-child(3)').addClass("accle-insta");
		
		
//alert(); 
}, 250);
// Define Constant dataLayer Array
var GOOGLE_TAG_EVENT_DATALAYER_URL = drupalSettings.DRUPAL_SITE_PATH_INDIA.GOOGLE_TAG_EVENT_DATALAYER_URL; 

const dataLayerArray = {};
dataLayerArray['ClientId'] = '';
dataLayerArray['event'] =  '';
dataLayerArray['Country'] = 'India';
dataLayerArray['pageCategory'] = '';
dataLayerArray['pageSubCategory'] = '';
dataLayerArray['PageSubSubCategory'] = '';
dataLayerArray['PageName'] = '';
dataLayerArray['CourseCatogery'] = '';
dataLayerArray['CourseSubCatogery'] = '';
dataLayerArray['CourseName'] = '';
dataLayerArray['CourseCode'] = '';
dataLayerArray['CourseDuration'] = '';
dataLayerArray['CourseFees'] = '';
dataLayerArray['CourseBaseFee'] = '';
dataLayerArray['CourseFeesTax'] = '';
dataLayerArray['CourseType'] = '';
dataLayerArray['CourseRating'] = '';
dataLayerArray['CourseReviews'] = '';
dataLayerArray['CourseEnrollmentNow'] = '';
dataLayerArray['LeadId'] = '';
dataLayerArray['CentreName'] = '';
dataLayerArray['CentreId'] = '';
dataLayerArray['CenterState'] = '';
dataLayerArray['CenterCity'] = '';
dataLayerArray['AvailableBatches'] = '';
dataLayerArray['SelectedBatch'] = '';
dataLayerArray['CourseStartDate'] = '';
dataLayerArray['StudentEncryptedMobileNumber'] = jQuery('#formStudentMobile').text();
dataLayerArray['StudentRegistrationNumber'] = '';
dataLayerArray['StudentDOB'] = '';
dataLayerArray['StudentGender'] = '';
dataLayerArray['StudentCountry'] = 'India';
dataLayerArray['StudentState'] = '';
dataLayerArray['StudentCity'] = '';
dataLayerArray['StudentPinCode'] = '';
/*************** New variable ************* start *******/
dataLayerArray['StudentEncryptedEmailID'] = jQuery('#formStudentEmail').text();
dataLayerArray['StudentName'] = jQuery('#formStudentName').text();
dataLayerArray['CouponCode'] = '';
dataLayerArray['CampaignCode'] = '';
dataLayerArray['articleName'] = '';
dataLayerArray['articleCategory'] = '';
dataLayerArray['articleSubCategory'] = '';
dataLayerArray['pageNodeBundle']= '';
dataLayerArray['StudentName']= '';
dataLayerArray['StudentEncryptedMobileNumber']= '';
dataLayerArray['StudentEncryptedEmailID']= '';
dataLayerArray['Question'] =  '';
/*************** New variable ************* end *********/

jQuery(document).ajaxComplete(function(){
jQuery('#third-form .btn-main-hpg').click(function(){
    //event.preventDefault();
    //alert();
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefee').text();
    var nodeid = jQuery('#pageNodeId').text();
    var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
    var StudentEncryptedMobileNumber = jQuery.md5(jQuery('#enqry_crsspndnc_mbl').val());
    var StudentEncryptedEmailID = jQuery.md5(jQuery('#edit-enqry-crsspndnc-eml').val());
    //var StudentName = jQuery('#edit-enqry-f-nm').val();
    var sname= jQuery('.fouthstepname').text();
    var StudentName = sname.substring(3, s.length);
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'NextClicked';
    dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['StudentEncryptedMobileNumber'] = StudentEncryptedMobileNumber;
    dataLayerArray['StudentEncryptedEmailID'] = StudentEncryptedEmailID;
    dataLayerArray['StudentName']= StudentName;

    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
})
});

/* Homepage call Event!!!! */
/*jQuery(document).on("click", ".signout-user a", function () {
	 var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
   var coursesubcategory = menu_url.split('/')[4];
   var pagename = menu_url.split('/')[5];
   var pagenametwo = menu_url.split('/')[6];
 var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    if(pagebundle == 'home_page'){
    dataLayerArray['event'] = 'Home_LogOut';//'Home_CallSelected_click:${pageTitle.replace(/\s/g, '-')}pageTitle';
	}else{
		dataLayerArray['event'] = 'LogOut';
	}
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else{
	   dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
	   
   }
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;

    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
   
});*/

/*jQuery(document).on("click", ".call_btn a", function () {
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
   var coursesubcategory = menu_url.split('/')[4];
   var pagename = menu_url.split('/')[5];
   var pagenametwo = menu_url.split('/')[6];
 var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    if(pagebundle == 'home_page'){
    dataLayerArray['event'] = 'Home_CallSelected';//'Home_CallSelected_click:${pageTitle.replace(/\s/g, '-')}pageTitle';
	}else{
		dataLayerArray['event'] = 'CallSelected';
	}
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else{
	   dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
	   
   }
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;

    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".signin", function () {
    var pageTitle = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();

    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'Home_Login'//'Home_Login:${pageTitle.replace(/\s/g, '-')}pageTitle';
    dataLayerArray['PageName'] = 'Home Page';//pageTitle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;

    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
*/
jQuery(document).on("click", ".open-menu a", function () {
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var coursecategory = jQuery('#courseCategory').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
	if(pagebundle == 'home_page'){
    dataLayerArray['event'] = 'Home_AllCourses_Selected';
	}else{
		dataLayerArray['event'] = 'AllCourses_Selected';
	}
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else{
	   dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;
	   
   }
    dataLayerArray['pageCategory'] = pageTitleAll;
	dataLayerArray['pageSubCategory'] = 'Top:All Courses';
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
	dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
   
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".menu-tab li a", function () {
//event.preventDefault();

	var category = jQuery(this).text();
// alert(category);
	var coursecode = jQuery('#pageCourseCode').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var coursecategory = jQuery('#courseCategory').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
	if(pagebundle == 'home_page'){
    dataLayerArray['event'] = 'Home_CourseCategory_Selected';//'Home_CallSelected_click:${pageTitle.replace(/\s/g, '-')}pageTitle';
	}else{
		dataLayerArray['event'] = 'CategorySelected';
	}
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else{
	   dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
	   
   }
    dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = 'Top:AllCourses';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseCatogery'] = category;
	dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
		 dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".course .tabs.only-desk  li a", function () {
//alert();
//jQuery('.course ul li a').click(function() {
   //event.preventDefault();
    //alert(category);
    var category = jQuery(this).text();
//alert(category);
var pageTitle = jQuery('#pageTitleAll').text();
var pageNodeBundle = jQuery('#pageNodeBundle').text();
var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_CourseCategory_Selected';
    dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = jQuery('#pageCategory').text();
    dataLayerArray['pageSubCategory'] = 'Mid:Courses';
    dataLayerArray['CourseCatogery'] = category;


// Trigger dataLayer with Const Variable
window.dataLayer = window.dataLayer || [];
window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".allcourse_btn a", function (e) {
    var category = jQuery(this).text();
    var pageTitle = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
//var subcategory = jQuery(this).attr('subcategory');
//var coursecode = jQuery(this).attr('coursecode');
//alert(category);
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_ExploreAllCourses';
    dataLayerArray['PageName'] = 'Home Page';
    //dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Mid:Courses';
   dataLayerArray['CourseCatogery'] = 'Explore All Courses';


// Trigger dataLayer with Const Variable
window.dataLayer = window.dataLayer || [];
window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".arrow-left", function () {
    var title = jQuery(this).attr('title');
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
// alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_Testimonials_Previous';
    dataLayerArray['PageName'] = 'Home Page';
   // dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageSubCategory'] = 'Testimonials';
	dataLayerArray['pageCategory'] = 'Home Page';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
//alert();
});
jQuery(document).on("click", ".arrow-right", function () {
    var title = jQuery(this).attr('title');
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_Testimonials_Next';
    dataLayerArray['PageName'] = 'Home Page';
    //dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageSubCategory'] = 'Testimonials';
	dataLayerArray['pageCategory'] = 'Home Page';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", "li.call", function () {
 //  alert();
 var title = jQuery(this).attr('title');
 var pageNodeBundle = jQuery('#pageNodeBundle').text();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_RequestCallSelected';
    dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageSubCategory'] = 'Request a callback';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

jQuery(document).on("click", ".close-back", function () {
  //alert();
  var title = jQuery(this).attr('title');
    //var pageNodeBundle = jQuery('#pageNodeBundle').text();

    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_RequestCall_Close';
    dataLayerArray['PageName'] = 'Home Page';
   dataLayerArray['pageSubCategory'] = 'Request a call back';
   dataLayerArray['pageCategory'] = 'Home Page';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/*jQuery(document).on("click", ".col-one li a", function () {
     //e.preventDefault();
	//alert();
	var category = jQuery(this).text();
	var firstHeader = jQuery(".col-one h6").text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['pageCategory'] = pageTitleAll;
	if(pagebundle == 'home_page'){
    dataLayerArray['event'] = `Home_AN_${category.replace(/\s/g, '')}`;
	}else{
		dataLayerArray['event'] = `${category.replace(/\s/g, '')}`;

	}
	//dataLayerArray['PageName'] = 'Home Page';
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else{
	   dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
	   
   }
   if(pagebundle == 'home_page' ){
	   dataLayerArray['pageSubCategory'] = category;
   }else{
	   dataLayerArray['pageSubCategory'] = 'Bottom';//`india:${pagename}`; 
	   
   }
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
   


	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".col-two li a", function () {
	var category = jQuery(this).text();
	var firstHeader = jQuery(".col-two h6").text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
	dataLayerArray['pageCategory'] = pageTitleAll;
	if(pagebundle == 'home_page'){
    dataLayerArray['event'] = `Home_NC_${category.replace(/\s/g, '')}`;
	}else{
		dataLayerArray['event'] = `${category.replace(/\s/g, '')}`;

	}
	//dataLayerArray['PageName'] = 'Home Page';
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else{
	   dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
	   
   }
   if(pagebundle == 'home_page' ){
	   dataLayerArray['pageSubCategory'] = category;
   }else{
	   dataLayerArray['pageSubCategory'] = 'Bottom';//`india:${pagename}`; 
	   
   }
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".col-three li a", function () {
   //  e.preventDefault();
	//alert();
	var category = jQuery(this).text();
	var firstHeader = jQuery(".col-three h6").text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['pageCategory'] = pageTitleAll;
	if(pagebundle == 'home_page'){
    dataLayerArray['event'] = `Home_INV_${category.replace(/\s/g, '')}`;
	}else{
		dataLayerArray['event'] = `${category.replace(/\s/g, '')}`;

	}
	//dataLayerArray['PageName'] = 'Home Page';
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else{
	   dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
	   
   }
   if(pagebundle == 'home_page' ){
	   dataLayerArray['pageSubCategory'] = category;
   }else{
	   dataLayerArray['pageSubCategory'] = 'Bottom';//`india:${pagename}`; 
	   
   }
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;


	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".col-four li a", function () {
	var category = jQuery(this).text();
	var firstHeader = jQuery(".col-four h6").text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['pageCategory'] = pageTitleAll;
	if(pagebundle == 'home_page'){
    dataLayerArray['event'] = `Home_PC_${category.replace(/\s/g, '')}`;
	}else{
		dataLayerArray['event'] = `${category.replace(/\s/g, '')}`;

	}
	//dataLayerArray['PageName'] = 'Home Page';
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else{
	   dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
	   
   }
   if(pagebundle == 'home_page' ){
	   dataLayerArray['pageSubCategory'] = category;
   }else{
	   dataLayerArray['pageSubCategory'] = 'Bottom';//`india:${pagename}`; 
	   
   }
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".col-sm-2 li a", function () {
	var category = jQuery(this).text();
	var firstHeader = jQuery(".col-sm-2 h6").text();
    //var pageTitle = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['pageCategory'] = pageTitleAll;
	if(pagebundle == 'home_page'){
    dataLayerArray['event'] = `Home_GS_${category.replace(/\s/g, '')}`;
	}else{
		dataLayerArray['event'] = `${category.replace(/\s/g, '')}`;

	}
	//dataLayerArray['PageName'] = 'Home Page';
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else{
	   dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
	   
   }
   if(pagebundle == 'home_page' ){
	   dataLayerArray['pageSubCategory'] = category;
   }else{
	   dataLayerArray['pageSubCategory'] = 'Bottom';//`india:${pagename}`; 
	   
   }
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});*/
jQuery(document).on("click", ".gallery-sec .button-secondary a", function () {
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_ExploreAllCourses';//'Home_ExploreKC';
    dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Mid: Knowledge Centre';
    

	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", " .grid__box1 .button-tertiary a", function () {
	var articleCategory = jQuery(this).text();
	var articleName = jQuery(".grid__box1 h2 a").text();
	//alert(articleName);
    var pageTitle = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_KC_ArticleSelected';
    dataLayerArray['PageName'] = 'Home Page';
   // dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Knowledge Center';
    dataLayerArray['articleName'] = articleName;
    dataLayerArray['articleCategory'] = articleCategory;

	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".grid__box2 .button-tertiary a", function () {
	 //e.preventDefault();
	//alert();
	var articleCategory = jQuery(this).text();
	var articleName = jQuery(".grid__box2 h2 a").text();
	//alert(articleName);
    var pageTitle = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_KC_ArticleSelected';
    dataLayerArray['PageName'] = 'Home Page';
   // dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Knowledge Center';
    dataLayerArray['articleName'] = articleName;
    dataLayerArray['articleCategory'] = articleCategory;

	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".grid__box3 .button-tertiary a", function () {
	// e.preventDefault();
	//alert();
	var articleCategory = jQuery(this).text();
	var articleName = jQuery(".grid__box3 h2 a").text();
//	alert(articleName);
var pageTitle = jQuery('#pageTitleAll').text();
var pageNodeBundle = jQuery('#pageNodeBundle').text();
var title = jQuery(this).attr('title');
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_KC_ArticleSelected';
    dataLayerArray['PageName'] = 'Home Page';
   // dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Knowledge Center';
    dataLayerArray['articleName'] = articleName;
    dataLayerArray['articleCategory'] = articleCategory;

	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".grid__box4 .button-tertiary a", function () {
	// e.preventDefault();
	//alert();
	var articleCategory = jQuery(this).text();
	var articleName = jQuery(".grid__box4 h2 a").text();
	//alert(articleName);
    var pageTitle = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_KC_ArticleSelected';
    dataLayerArray['PageName'] = 'Home Page';
   // dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Knowledge Center';
    dataLayerArray['articleName'] = articleName;
    dataLayerArray['articleCategory'] = articleCategory;

	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".grid__box5 .button-tertiary a", function () {
	// e.preventDefault();
	//alert();
	var articleCategory = jQuery(this).text();
	var articleName = jQuery(".grid__box4 h2 a").text();
	//alert(articleName);
    var pageTitle = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_KC_ArticleSelected';
    dataLayerArray['PageName'] = 'Home Page';
   // dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Knowledge Center';
    dataLayerArray['articleName'] = articleName;
    dataLayerArray['articleCategory'] = articleCategory;

	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

jQuery(document).on("click", ".grid__box6 .button-tertiary a", function (e) {
	// e.preventDefault();
	//alert();
	var articleCategory = jQuery(this).text();
	var articleName = jQuery(".grid__box6 h2 a").text();
	//alert(articleName);
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_KC_ArticleSelected';
    dataLayerArray['PageName'] = 'Home Page';
  //  dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Knowledge Center';
    dataLayerArray['articleName'] = articleName;
    dataLayerArray['articleCategory'] = articleCategory;

	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".grid__box7 .button-tertiary a", function (e) {
	 //e.preventDefault();
	//alert();
	var articleCategory = jQuery(this).text();
	var articleName = jQuery(".grid__box7 h2 a").text();
	//alert(articleName);
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_KC_ArticleSelected';
    dataLayerArray['PageName'] = 'Home Page';
 //   dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Knowledge Center';
    dataLayerArray['articleName'] = articleName;
    dataLayerArray['articleCategory'] = articleCategory;

	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".grid__box8 .button-tertiary a", function () {
	// e.preventDefault();
	//alert();
	var articleCategory = jQuery(this).text();
	var articleName = jQuery(".grid__box8 h2 a").text();
	//alert(articleName);
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_KC_ArticleSelected';
    dataLayerArray['PageName'] = 'Home Page';
 //   dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Knowledge Center';
    dataLayerArray['articleName'] = articleName;
    dataLayerArray['articleCategory'] = articleCategory;

	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".grid__box9 .button-tertiary a", function () {
	// e.preventDefault();
	//alert();
	var articleCategory = jQuery(this).text();
	var articleName = jQuery(".grid__box9 h2 a").text();
	//alert(articleName);
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_KC_ArticleSelected';
    dataLayerArray['PageName'] = 'Home Page';
  //  dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Knowledge Center';
    dataLayerArray['articleName'] = articleName;
    dataLayerArray['articleCategory'] = articleCategory;

	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".search_icon img", function () {
	var coursecategory = jQuery('#courseCategory').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	

	//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
	if(pagebundle == 'home_page'){
    dataLayerArray['event'] = 'Home_SearchOccured';//'Home_CallSelected_click:${pageTitle.replace(/\s/g, '-')}pageTitle';
	}else{
		dataLayerArray['event'] = 'Course_SearchOccured';
	}
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else{
	   dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
	   
   }
   dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	 dataLayerArray['CourseCatogery'] = coursecategory;
	 dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

jQuery(document).on("click", ".banner-slider .view_coursebtn a", function () {
//event.preventDefault();
var menu_url = jQuery(this).attr('href');
//var test= "https://www.niit.com/india/gg/dcd"
var category = menu_url.split('/')[5];
var CourseName = menu_url.split('/')[6];
var CourseNames = CourseName.split('?')[0];
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_Banner_ViewCourses';
    dataLayerArray['PageName'] =  'Home Page';
   // dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Top: All Courses';//new changes
    dataLayerArray['CourseCatogery'] = category;
    dataLayerArray['CourseName'] = CourseNames;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);

});
jQuery(document).on("click",".mid-course .mid-link a",function() {
	var node_id = jQuery(this).attr('node-id');
    var menu_url = jQuery(this).attr('href');
    var title = jQuery(this).attr('title');
    var category = jQuery(this).attr('category');
    var subcategory = jQuery(this).attr('subcategory');
    var coursecode = jQuery(this).attr('coursecode');


	var pageTitle = jQuery('#pageTitleAll').text();
	var pageNodeId = jQuery('#pageNodeId').text();
	// AXISS-BAF_graduates_TopMenu_CoursePage_PriorityBankingProgramme

	dataLayerArray['event'] = 'Home_CourseSelected';
	dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['CourseDuration'] = jQuery(this).attr('duration');

    var coursefeedetails = jQuery('#coursefeedetails').text();
    if(coursefeedetails){
    	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
     dataLayerArray['CourseFees'] = coursefeedetails[0];
     dataLayerArray['CourseRating'] = coursefeedetails[2];
     dataLayerArray['CourseReviews'] = coursefeedetails[3];
     dataLayerArray['AvailableBatches'] = coursefeedetails[4];
     dataLayerArray['CourseStartDate'] = coursefeedetails[4];
     dataLayerArray['CourseBaseFee'] = (coursefeedetails[1] != 'No') ? coursefeedetails[1] : '';
 }
 dataLayerArray['pageCategory'] = 'Home Page';
 dataLayerArray['pageSubCategory'] = 'Mid: All Courses';
 dataLayerArray['PageSubSubCategory'] = jQuery('#pageSubSubCategory').text();
 //dataLayerArray['CourseCatogery'] = category;
 dataLayerArray['CourseCatogery'] = category;
 dataLayerArray['CourseSubCatogery'] = subcategory;
 dataLayerArray['CourseName'] = title;
 dataLayerArray['CampaignCode'] = jQuery(this).attr('campaign');
 dataLayerArray['CourseCode'] = coursecode;
 dataLayerArray['CourseType'] = jQuery(this).attr('mode');

 dataLayerArray['StudentEncryptedMobileNumber'] = jQuery('#formStudentMobile').text();
 dataLayerArray['StudentCity'] = jQuery('#formStudentCity').text();
 dataLayerArray['StudentState'] = jQuery('#formStudentState').text();
 dataLayerArray['StudentDOB'] = jQuery('#formStudentDOB').text();

	// Trigger dataLayer with Const Variable
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push(dataLayerArray);
	// console.log(dataLayerArray);
});

jQuery(document).on("click", ".view_videoebtn", function () {
 //  alert();
 var title = jQuery(this).attr('title');
// var pageNodeBundle = jQuery('#pageNodeBundle').text();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_Banner_PlayVideo';
    dataLayerArray['PageName'] = 'Home Page';
    //dataLayerArray['pageNodeBundle'] = pageNodeBundle;
    dataLayerArray['pageSubCategory'] = 'Top: All Courses';
    dataLayerArray['PageSubSubCategory'] = '#AbPlacement Pakki';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/*jQuery(document).on("click", ".list-unstyled li a", function () {
	var pagesubsubcat = jQuery(this).text();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_CorporateTraining_Selected';
    dataLayerArray['PageName'] = 'Home Page';

    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Top: Corporate Training';
    dataLayerArray['PageSubSubCategory'] = pagesubsubcat;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});*/
/*jQuery(document).on("click", ".listitem2 a", function () {
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Home_KnowledgeCentre_Selected';
    dataLayerArray['PageName'] = 'Home Page';

    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = ' Top:Knowledge Center';

    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});*/
//function Eventrequestacall(){
	jQuery(document).ajaxComplete(function(){
       jQuery('.homepage_submit_btn').click(function(){
  var StudentName = jQuery('.edit-enqry-f-nm').val();
  var StudentEncryptedMobileNumber = jQuery.md5(jQuery('.edit-enqry-crsspndnc-mbl').val());
  var StudentEncryptedEmailID = jQuery.md5(jQuery('.edit-enqry-crsspndnc-eml').val());
dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
dataLayerArray['event'] =  'Home_LeadSubmitted';
dataLayerArray['PageName'] = 'Home Page';
dataLayerArray['pageCategory'] = 'Home Page';
dataLayerArray['StudentName'] = StudentName;
dataLayerArray['StudentEncryptedMobileNumber'] = StudentEncryptedMobileNumber;
dataLayerArray['StudentEncryptedEmailID'] = StudentEncryptedEmailID;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
})
   });

   jQuery(document).on("click" ,'.free-trialCTA', function () { 
   var title = jQuery(this).attr('title'); 
    // Set Data Layer Variable 
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text(); 
    dataLayerArray['event'] =  'Book_free_session'; 
    dataLayerArray['PageName'] = 'Home Page'; 
    //dataLayerArray['pageNodeBundle'] = pageNodeBundle; 
    dataLayerArray['pageSubCategory'] = 'New Stack Route'; 
    // Trigger dataLayer with Const Variable 
    window.dataLayer = window.dataLayer || []; 
    window.dataLayer.push(dataLayerArray); 
    });

    jQuery(document).on("click" ,'.broucherpdf span', function () { 
        // event.preventDefault(); 
//    alert(); 
       var title = jQuery(this).attr('title'); 
// var pageNodeBundle = jQuery('#pageNodeBundle').text(); 
   // Set Data Layer Variable 
   dataLayerArray['ClientId'] = jQuery('#gaCookie').text(); 
   dataLayerArray['event'] =  'New_stack_route_brochure'; 
   dataLayerArray['PageName'] = 'Home Page'; 
   dataLayerArray['pageSubCategory'] = 'New Stack Route'; 
   // Trigger dataLayer with Const Variable 
   window.dataLayer = window.dataLayer || []; 
   window.dataLayer.push(dataLayerArray); 
});

   /*End Home Event Tracking*/
   /*New Home Event Tracking*/
   jQuery(document).on("click", ".twi", function () {
    // event.preventDefault();
	//alert();
	var category = jQuery(this).text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'twitterSelected';
	if(pagebundle == 'home_page'){
	dataLayerArray['PageName'] = 'Home Page';
	}else if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}else{
		dataLayerArray['PageName'] = 'Program Category Listing Page';
	}
	if(pagebundle == 'home_page'){
    dataLayerArray['pageCategory'] = pageTitleAll;
	}else if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
	dataLayerArray['pageSubCategory'] = 'Bottom';//category;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
   jQuery(document).on("click", ".f_book", function () {
   //  event.preventDefault();
	//alert();
	var category = jQuery(this).text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'facebookSelected';
	if(pagebundle == 'home_page'){
	dataLayerArray['PageName'] = 'Home Page';
	}else if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}else{
		dataLayerArray['PageName'] = 'Program Category Listing Page';
	}
	if(pagebundle == 'home_page'){
    dataLayerArray['pageCategory'] = pageTitleAll;
	}else if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
	dataLayerArray['pageSubCategory'] = 'Bottom';//category;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".in_gram", function () {
   //  event.preventDefault();
//	alert();
	var category = jQuery(this).text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'InstaSelected';
	if(pagebundle == 'home_page'){
	dataLayerArray['PageName'] = 'Home Page';
	}else if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}else{
		dataLayerArray['PageName'] = 'Program Category Listing Page';
	}
	if(pagebundle == 'home_page'){
       dataLayerArray['pageCategory'] = pageTitleAll;
	}else if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
	dataLayerArray['pageSubCategory'] = 'Bottom';//category;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".kcreadmore", function () {
	// event.preventDefault();
	//alert();
	var articleName = jQuery(this).attr('articlename');
	//alert(articleName);
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'Readmore';
    dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['pageSubCategory'] = 'Knowledge Center';
    dataLayerArray['articleName'] = articleName;
    dataLayerArray['articleCategory'] = 'Article';

	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".col-one li a", function () {
    // event.preventDefault();
	//alert();
	var category = jQuery(this).text();
	var firstHeader = jQuery(".col-one h6").text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'Aboutus';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'home_page'){
	dataLayerArray['PageName'] = 'Home Page';
	}else if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}else{
		dataLayerArray['PageName'] = 'Program Category Listing Page';
	}
	if(pagebundle == 'home_page'){
    dataLayerArray['pageCategory'] = pageTitleAll;
	}else if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
 	dataLayerArray['pageSubCategory'] = 'Bottom';//`india:${pagename}`; 
    //dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".col-two li a", function () {
    // event.preventDefault();
	//alert();
	var category = jQuery(this).text();
	var firstHeader = jQuery(".col-two h6").text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'Newscoverage';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'home_page'){
	dataLayerArray['PageName'] = 'Home Page';
	}else if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}else{
		dataLayerArray['PageName'] = 'Program Category Listing Page';
	}
	if(pagebundle == 'home_page'){
    dataLayerArray['pageCategory'] = pageTitleAll;
	}else if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
 	dataLayerArray['pageSubCategory'] = 'Bottom';//`india:${pagename}`; 
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".col-three li a", function () {
    // event.preventDefault();
	//alert();
	var category = jQuery(this).text();
	var firstHeader = jQuery(".col-three h6").text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'Investors';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'home_page'){
	dataLayerArray['PageName'] = 'Home Page';
	}else if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}else{
		dataLayerArray['PageName'] = 'Program Category Listing Page';
	}
	if(pagebundle == 'home_page'){
    dataLayerArray['pageCategory'] = pageTitleAll;
	}else if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
 	dataLayerArray['pageSubCategory'] = 'Bottom';//`india:${pagename}`; 
    //dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".get_startfree", function () {
	// event.preventDefault();
	//alert();
	var menu_url = jQuery(this).attr('href');
	var subcategory = menu_url.split('/')[2];
	var category = menu_url.split('/')[3];
	var CourseDuration = jQuery(this).attr('course_d');
	var CourseName = jQuery(this).attr('course_nam');
	//alert(articleName);
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'ViewCourse';
    dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = 'Home Page';
    dataLayerArray['CourseName'] = CourseName;
    dataLayerArray['CourseCatogery'] = category;
    dataLayerArray['CourseSubCatogery'] = subcategory;
	dataLayerArray['CourseDuration'] = CourseDuration;
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
	jQuery(document).on("click", ".call_btn a", function () {
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'CallSelected';
	dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".kc-topmenu a", function () {
	var pageTitle = jQuery('#pageTitleAll').text();
	var coursecategory = jQuery('#courseCategory').text();
    var pagebundle = jQuery('#pageNodeBundle').text();
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'KCSelected';
	    if(pagebundle == 'home_page'){
    dataLayerArray['pageCategory'] = pageTitle;//'Home_CallSelected_click:${pageTitle.replace(/\s/g, '-')}pageTitle';
	}else if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}else{
	   dataLayerArray['PageName'] = 'Program Category Listing Page'; 
	   
   }
   dataLayerArray['CourseCatogery'] = coursecategory;
   dataLayerArray['CourseCode'] = coursecode;
   dataLayerArray['pageSubCategory'] = ' Top:Knowledge Center';
   if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}

    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".corp-training li a", function () {
	var pagesubsubcat = jQuery(this).text();
	var pageTitle = jQuery('#pageTitleAll').text();
    var pagebundle = jQuery('#pageNodeBundle').text();
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var coursecategory = jQuery('#courseCategory').text();
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] =  'CorporatetrainingSelected';
    if(pagebundle == 'home_page'){
    dataLayerArray['pageCategory'] = pageTitle;//'Home_CallSelected_click:${pageTitle.replace(/\s/g, '-')}pageTitle';
	}else if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}else{
	   dataLayerArray['PageName'] = 'Program Category Listing Page'; 
	   
   }
    dataLayerArray['pageSubCategory'] = 'Top: Corporate Training';
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
	dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
	dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    //dataLayerArray['PageSubSubCategory'] = pagesubsubcat;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".signin-user", function () {
    var pageTitle = jQuery('#pageTitleAll').text();
    var pagebundle = jQuery('#pageNodeBundle').text();
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'SignIn';
    if(pagebundle == 'home_page'){
    dataLayerArray['pageCategory'] = pageTitle;//'Home_CallSelected_click:${pageTitle.replace(/\s/g, '-')}pageTitle';
	}else if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}else{
	   dataLayerArray['PageName'] = 'Program Category Listing Page'; 
	   
   }
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}

    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".signout-user a", function () {
	 var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'SignOut';//'Home_CallSelected_click:${pageTitle.replace(/\s/g, '-')}pageTitle';
	if(pagebundle == 'home_page'){
    dataLayerArray['pageCategory'] = pageTitleAll;//'Home_CallSelected_click:${pageTitle.replace(/\s/g, '-')}pageTitle';
	}else if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}else{
	   dataLayerArray['PageName'] = 'Program Category Listing Page'; 
	   
   }
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCatogery'] = coursecategory;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}

    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
   
});
jQuery(document).on("click", ".program_cta a", function () {
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var coursecategory = jQuery('#courseCategory').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var pageTitleAll = jQuery('#pageTitleAll').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
	dataLayerArray['event'] = 'ProgramClicked';
	if(pagebundle == 'home_page'){
	dataLayerArray['PageName'] = 'Home Page';
	}else if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}else{
		dataLayerArray['PageName'] = 'Program Category Listing Page';
	}
	if(pagebundle == 'home_page'){
    dataLayerArray['pageCategory'] = pageTitleAll;
	}else if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
	dataLayerArray['pageSubCategory'] = 'Top:Programs';
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".register_otp-check span", function () {
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'GenerateOTP';
	dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".req_callb a", function () {
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
    // alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'RequestCallBack';
	dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".whats_us a", function () {
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
    // alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'WhatsappUs';
	dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".explr_cta", function () {
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'ExploreProgramClicked';
	dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery('#edit-register-otp-check').click(function(){
	//event.preventDefault();
	//alert();
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
	var StudentEncryptedMobileNumber = jQuery.md5(jQuery('.enqry_crsspndnc_mbl').val());
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'GoClicked';
	dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
	dataLayerArray['StudentEncryptedMobileNumber'] = StudentEncryptedMobileNumber;
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery('.verify-register-otp-hp').click(function(){
	//event.preventDefault();
	//alert();
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
	var StudentEncryptedMobileNumber = jQuery.md5(jQuery('.enqry_crsspndnc_mbl').val());
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'VerifyClicked';
	dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
	dataLayerArray['StudentEncryptedMobileNumber'] = StudentEncryptedMobileNumber;
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery('#edit-submit--4').click(function(){
	//event.preventDefault();
	//alert();
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
	var StudentEncryptedMobileNumber = jQuery.md5(jQuery('.enqry_crsspndnc_mbl').val());
	var StudentEncryptedEmailID = jQuery.md5(jQuery('.edit-enqry-crsspndnc-eml').val());
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'NextClicked';
	dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = jQuery('#pageSubCategory').text();
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
	dataLayerArray['StudentEncryptedMobileNumber'] = StudentEncryptedMobileNumber;
	dataLayerArray['StudentEncryptedEmailID'] = StudentEncryptedEmailID;
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery('#edit-submit--5').click(function(){
	//event.preventDefault();
	//alert();
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
	var StudentEncryptedMobileNumber = jQuery.md5(jQuery('.enqry_crsspndnc_mbl').val());
	var StudentEncryptedEmailID = jQuery.md5(jQuery('.edit-enqry-crsspndnc-eml').val());
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'LeadSubmitted';
	dataLayerArray['PageName'] = 'Home Page';
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = 'Done';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
	dataLayerArray['StudentEncryptedMobileNumber'] = StudentEncryptedMobileNumber;
	dataLayerArray['StudentEncryptedEmailID'] = StudentEncryptedEmailID;
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
   /*End New Home Event Tracking*/
   /* NEW Program Page Event Tracking */
   jQuery(document).on("click", ".download a", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'DownloadBrochureSelected';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}
 	dataLayerArray['pageSubCategory'] = 'Top: Accelerate your carrier'; 
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

jQuery(document).on("click", ".seeplan", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'SeeAllPlansSelected';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}
 	dataLayerArray['pageSubCategory'] = 'Mid'; 
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".emi-wm", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'EMIPlanWithMoratorium';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}
 	dataLayerArray['pageSubCategory'] = 'Bottom: Payment Methods'; 
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".emi-cost", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'NoCostEMI';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}
 	dataLayerArray['pageSubCategory'] = 'Bottom: Payment Methods'; 
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".emi-upfront", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'PaymentUpfront';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
 	dataLayerArray['pageSubCategory'] = 'Bottom: Payment Methods'; 
	}
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".check-curriculum", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'ProgramCurriculumChecked';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
 	dataLayerArray['pageSubCategory'] = 'Mid: Top Skills you will learn'; 
	}
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

jQuery(document).on("click", ".faq-program", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var Question = jQuery(this).attr('question');
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'FAQsSelected';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
 	dataLayerArray['pageSubCategory'] = 'Bottom:FAQs'; 
	}
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	dataLayerArray['Question'] = Question;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

jQuery(document).on("click", ".learn_mor", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'LearnMoreSelected';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
 	dataLayerArray['pageSubCategory'] = 'Mid: Take the screening test'; 
	}
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".customFormGoBtn", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var StudentEncryptedMobileNumber = jQuery.md5(jQuery('.enqry_crsspndnc_mbl').val());
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'MobileNumber_Proceed';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
 	     
	}
	dataLayerArray['pageSubCategory'] = 'Top';
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	dataLayerArray['StudentEncryptedMobileNumber'] = StudentEncryptedMobileNumber;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".accle-twi", function () {
    // event.preventDefault();
	//alert();
	var category = jQuery(this).text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'twitterSelected';
	 if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}
	dataLayerArray['pageSubCategory'] = 'Top: Accelerate your carrier';//category;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
   jQuery(document).on("click", ".accle-fb", function () {
   //  event.preventDefault();
	//alert();
	var category = jQuery(this).text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'facebookSelected';
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}
	dataLayerArray['pageSubCategory'] = 'Top: Accelerate your carrier';//category;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".accle-insta", function () {
   //  event.preventDefault();
//	alert();
	var category = jQuery(this).text();
	var pageNodeBundle = jQuery('#pageNodeBundle').text();
	var title = jQuery(this).attr('title');
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'InstaSelected';
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}
	dataLayerArray['pageSubCategory'] = 'Top: Accelerate your carrier';//category;
    dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".strtapp", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'ApplicationStarted';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
 	dataLayerArray['pageSubCategory'] = 'Mid: Application Start'; 
	}
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".step-one-dis", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var StudentEncryptedMobileNumber = jQuery.md5(jQuery('#form-popup-wrapper :input[name="enqry_crsspndnc_mbl"]').val());
	var StudentEncryptedEmailID = jQuery.md5(jQuery('#form-popup-wrapper :input[name="enqry_crsspndnc_eml"]').val());
	var StudentName =  jQuery('#form-popup-wrapper :input[name="enqry_f_nm"]').val();
	//alert(category);step-one-dis
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'LeadSubmiited';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
 	     
	}
	dataLayerArray['pageSubCategory'] = 'Top';
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	dataLayerArray['StudentEncryptedMobileNumber'] = StudentEncryptedMobileNumber;
	dataLayerArray['StudentEncryptedEmailID'] = StudentEncryptedEmailID;
	dataLayerArray['StudentName']= StudentName;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".ContinueYourApplicationForm .continue-btn", function () {
    // event.preventDefault();
	//alert();
    var pagebundle =  jQuery('#pageNodeBundle').text();
	var coursecategory = jQuery('#courseCategory').text();
	var coursecode = jQuery('#pageCourseCode').text();
	var pageTitleAll = jQuery('#pageTitleAll').text();
	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var StudentEncryptedMobileNumber = jQuery.md5(jQuery('.custom-step-one-form :input[name="enqry_crsspndnc_mbl"]').val());
	var StudentEncryptedEmailID = jQuery.md5(jQuery('.custom-step-one-form :input[name="enqry_crsspndnc_eml"]').val());
	var StudentName =  jQuery('.custom-step-one-form :input[name="enqry_f_nm"]').val();
	//alert(category);
	
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'ContinueApplication_Proceed';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
 	     
	}
	dataLayerArray['pageSubCategory'] = 'Top';
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	dataLayerArray['StudentEncryptedMobileNumber'] = StudentEncryptedMobileNumber;
	dataLayerArray['StudentEncryptedEmailID'] = StudentEncryptedEmailID;
	dataLayerArray['StudentName']= StudentName;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

/* End New program page Event Tracking*/

   
   /*----Category Page Event Tracking-------*/
   jQuery(document).on("click", ".category_iama", function () {
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'PersonaDropdownOpen';
	dataLayerArray['PageName'] = 'Program Category Listing Page';
    dataLayerArray['pageCategory'] = 'Program Category';
    dataLayerArray['pageSubCategory'] = 'Top';
    //dataLayerArray['CourseName'] = CourseName;
   // dataLayerArray['CourseCatogery'] = category;
   // dataLayerArray['CourseSubCatogery'] = subcategory;
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
  jQuery(document).on("click", ".category_looking", function () {
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'GoalDropdownOpen';
	dataLayerArray['PageName'] = 'Program Category Listing Page';
    dataLayerArray['pageCategory'] = 'Program Category';
    dataLayerArray['pageSubCategory'] = 'Top';
    //dataLayerArray['CourseName'] = CourseName;
   // dataLayerArray['CourseCatogery'] = category;
   // dataLayerArray['CourseSubCatogery'] = subcategory;
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
  jQuery(document).on("click", ".category_studying", function () {
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'AvailiabilityDropdownOpen';
	dataLayerArray['PageName'] = 'Program Category Listing Page';
    dataLayerArray['pageCategory'] = 'Program Category';
    dataLayerArray['pageSubCategory'] = 'Top';
    //dataLayerArray['CourseName'] = CourseName;
   // dataLayerArray['CourseCatogery'] = category;
   // dataLayerArray['CourseSubCatogery'] = subcategory;
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".exp-program-title", function () {
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var menu_url = jQuery(this).attr('href');
	var courseName = jQuery(this).attr('coursname');
	var coursecategory = menu_url.split('/')[3];
	var subcategory = menu_url.split('/')[2];
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'ProgramExplored';
	dataLayerArray['PageName'] = 'Program Category Listing Page';
    dataLayerArray['pageCategory'] = 'Program Category';
    dataLayerArray['pageSubCategory'] = 'Explore Other Programs';
    dataLayerArray['CourseName'] = courseName;
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseSubCatogery'] = subcategory;
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".view-prog a", function () {
	//event.preventDefault();
	//alert();
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var menu_url = jQuery(this).attr('href');
	var courseName = jQuery(this).attr('coursename');
	var coursecategory = menu_url.split('/')[3];
	var subcategory = menu_url.split('/')[2];
	var duration = jQuery(this).attr('dur');
	var coursetype = jQuery(this).attr('mode');
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'View Program';
	dataLayerArray['PageName'] = 'Program Category Listing Page';
    dataLayerArray['pageCategory'] = 'Program Category';
    dataLayerArray['pageSubCategory'] = 'List of Programs';
    dataLayerArray['CourseName'] = courseName;
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseSubCatogery'] = subcategory;
	dataLayerArray['CourseType'] = coursetype;
	dataLayerArray['CourseDuration'] = duration;
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".new-batchfill a", function () {
	//event.preventDefault();
	//alert();
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var menu_url = jQuery(this).attr('href');
	var courseName = jQuery(this).attr('course-name');
	var coursecategory = menu_url.split('/')[3];
	var subcategory = menu_url.split('/')[2];
	var pagenametwo = menu_url.split('/')[4];
	var duration = jQuery(this).attr('duration');
	var coursetype = jQuery(this).attr('mode-delivery');
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'View Program';
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${subcategory}:${coursecategory}:${pagenametwo}`;
	}else{
		dataLayerArray['PageName'] = 'Program Category Listing Page';
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
	}else{
		dataLayerArray['pageCategory'] = 'Program Category';
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageSubCategory'] = 'Related Courses';
	}else{
		dataLayerArray['pageSubCategory'] = 'New Batch filling fast!';
	}
    dataLayerArray['CourseName'] = courseName;
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseSubCatogery'] = subcategory;
	dataLayerArray['CourseType'] = coursetype;
	dataLayerArray['CourseDuration'] = duration;
    
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
   
   
   /*----End Category Page Event Tracking------*/
   
   /* Start Self-paced course Event*/
   
   jQuery(document).on("click", ".kmcgbar a", function () {
    var pageTitle = 'Home Page';
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
var pagename = menu_url.split('/')[5];
var pagenametwo = menu_url.split('/')[6];
var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'ArticleSelected';
	dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = 'Bottom';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['articleName'] = jQuery('.article-name').text();;
    dataLayerArray['articleCategory'] = pagename;
    dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".slick-prev-icon", function () {
    var pageTitle = 'Home Page';
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
   var coursesubcategory = menu_url.split('/')[4];
   var pagename = menu_url.split('/')[5];
   var pagenametwo = menu_url.split('/')[6];
   var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'PreviousCourseSeen';
	dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = 'Middle';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".slick-next-icon", function () {
    var pageTitle = 'Home Page';
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	 var coursesubcategory = menu_url.split('/')[4];
   var pagename = menu_url.split('/')[5];
   var pagenametwo = menu_url.split('/')[6];
   var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'NextcourseSeen';
	dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = 'Middle';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".sp_cta_desktop a", function () {
	//event.preventDefault();
    var pageTitle = 'Home Page';
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	 var coursesubcategory = menu_url.split('/')[4];
  var pagename = menu_url.split('/')[5];
  var pagenametwo = menu_url.split('/')[6];
  var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'ApplyNowSelected';
	dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = 'Middle';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".new_mutlistep_apply_btn a", function () {
	//event.preventDefault();
    var pageTitle = 'Home Page';
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	 var coursesubcategory = menu_url.split('/')[4];
   var pagename = menu_url.split('/')[5];
   var pagenametwo = menu_url.split('/')[6];
   var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'EnrollNowSelected';
	dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = 'Top';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;//pagename;
    dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".middle-enroll a", function () {
	//event.preventDefault();
    var pageTitle = 'Home Page';
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	 var coursesubcategory = menu_url.split('/')[4];
   var pagename = menu_url.split('/')[5];
   var pagenametwo = menu_url.split('/')[6];
   var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'EnrollNowSelected';
	dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = 'Middle';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
    dataLayerArray['CourseCatogery'] = coursecategory;//pagename;
    dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".fb-icon", function () {
    var pageTitle = 'Home Page';
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
    var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'FacebookSelected';
	dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = 'Bottom';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on("click", ".twitter-icon", function () {
    var pageTitle = 'Home Page';
    var pageTitleAll = jQuery('#pageTitleAll').text();
    var title = jQuery(this).attr('title');
    var coursecode = jQuery('#pageCourseCode').text();
    var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
	var menu_url = jQuery(location).attr('href');
	var nodeid = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
    var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
    var coursecategory = jQuery('#courseCategory').text();
//alert();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'TwitterSelected';
	dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
    dataLayerArray['pageCategory'] = pageTitleAll;
    dataLayerArray['pageSubCategory'] = 'Bottom';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
    dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	dataLayerArray['CourseCatogery'] = coursecategory;
	dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

   
   
   /* End Self-paced course Event*/

// Global mobile menu Click event
jQuery(document).on("click",".top-menucourses .link a.course-menu-lnk",function() {
	var node_id = jQuery(this).attr('node-id');
    var menu_url = jQuery(this).attr('href');
    var title = jQuery(this).attr('title');
    var category = jQuery(this).attr('category');
    var subcategory = jQuery(this).attr('subcategory');
    var coursecode = jQuery(this).attr('coursecode');
    var pageTitleAll = jQuery('#pageTitleAll').text();
	var pageNodeId = jQuery('#pageNodeId').text();
	var pagebundle =  jQuery('#pageNodeBundle').text();
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	//var pageTitleAll = jQuery('#pageTitleAll').text();
	// AXISS-BAF_graduates_TopMenu_CoursePage_PriorityBankingProgramme

	//dataLayerArray['event'] = 'Home_CourseSelected';
	if(pagebundle == 'home_page'){
    dataLayerArray['event'] = 'Home_CourseSelected';//'Home_CallSelected_click:${pageTitle.replace(/\s/g, '-')}pageTitle';
	}else{
		dataLayerArray['event'] = 'Course_CourseSelected';
	}
   if(pagebundle == 'home_page' ){
	   dataLayerArray['PageName'] = 'Home Page';
   }else{
	   dataLayerArray['PageName'] = `india:${pagename}:${pagenametwo}`;//`india:${pagename}`; 
	   
   }
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['CourseDuration'] = jQuery(this).attr('duration');

    var coursefeedetails = jQuery('#coursefeedetails').text();
    if(coursefeedetails){
    	var coursefeedetails = jQuery('#coursefeedetails').text().split('@@');
     dataLayerArray['CourseFees'] = coursefeedetails[0];
     dataLayerArray['CourseRating'] = coursefeedetails[2];
     dataLayerArray['CourseReviews'] = coursefeedetails[3];
     dataLayerArray['AvailableBatches'] = coursefeedetails[4];
     dataLayerArray['CourseStartDate'] = coursefeedetails[4];
     dataLayerArray['CourseBaseFee'] = (coursefeedetails[1] != 'No') ? coursefeedetails[1] : '';
 }
 if(pagebundle == 'home_page' ){
	   dataLayerArray['pageCategory'] = pageTitleAll;
   }else{
	   dataLayerArray['pageCategory'] = pageTitleAll;
	   
   }
 
 dataLayerArray['pageSubCategory'] = 'Top:All Courses';
 dataLayerArray['PageSubSubCategory'] = jQuery('#pageSubSubCategory').text();
 dataLayerArray['CourseCatogery'] = category;
 dataLayerArray['CourseSubCatogery'] = subcategory;
 dataLayerArray['CourseName'] = title;
 dataLayerArray['CampaignCode'] = jQuery(this).attr('campaign');
 dataLayerArray['CourseCode'] = coursecode;
 dataLayerArray['CourseType'] = jQuery(this).attr('mode');

 dataLayerArray['StudentEncryptedMobileNumber'] = jQuery('#formStudentMobile').text();
 dataLayerArray['StudentCity'] = jQuery('#formStudentCity').text();
 dataLayerArray['StudentState'] = jQuery('#formStudentState').text();
 dataLayerArray['StudentDOB'] = jQuery('#formStudentDOB').text();

	// Trigger dataLayer with Const Variable
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push(dataLayerArray);
});
// Global New desktop menu Click event
jQuery(document).on("click","#navbarCollapse li a, .loginSignUpDropDown li a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = jQuery(this).attr('data-drupal-link-system-path');
    var menu_url = jQuery(this).attr('href');
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// alert(pageNodeId);
  	var type = 'TopMenu';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// Global Popular Programmes Overlay Click event
jQuery(document).on("click","section.sliderinner-wrap .hometoptab .slick-list .slick-slide .detailsinfo a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = jQuery(this).attr('data-drupal-link-system-path');
    var menu_url = jQuery(this).attr('href');
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'PopularProgrammes';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// Home Popular Programmes Tabs Click event
jQuery(document).on("click","section.slidetrending .tabnav-container ul.nav-tabs li a",function() {
    var pageTitle = jQuery('#pageTitleAll').text();
    var formStudentMobile = jQuery('#formStudentMobile').text();
    var formStudentCity = jQuery('#formStudentCity').text();
    var formStudentState = jQuery('#formStudentState').text();
    var formStudentDOB = jQuery('#formStudentDOB').text();
    var menu_text = jQuery(this).text();
    var type = 'Tab';
    var clientID = jQuery('#gaCookie').text();
  	// Set Data Layer Variable
  	dataLayerArray['ClientId'] = clientID;
  	dataLayerArray['event'] =  'PopularProgrammes_Explore_'+pageTitle.replace(/\s/g, '')+'_'+menu_text.replace(/\s/g, '')+type;
      dataLayerArray['pageCategory'] = pageTitle.replace(/\s/g, '');
      dataLayerArray['pageSubCategory'] = 'PopularProgrammes';
      dataLayerArray['PageSubSubCategory'] = 'PopularProgrammesTabs';
      dataLayerArray['PageName'] = 'india:'+pageTitle.replace(/\s/g, '');
      dataLayerArray['StudentEncryptedMobileNumber'] = formStudentMobile;
      dataLayerArray['StudentState'] = formStudentState;
      dataLayerArray['StudentCity'] = formStudentCity;
      dataLayerArray['StudentDOB'] = formStudentDOB;

	// Trigger dataLayer with Const Variable
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push(dataLayerArray);

	
});
// Home Popular Programmes Explore more Button Click event
jQuery(document).on("click","section.slidetrending .tabnav-container .morebtn",function() {
    var pageTitle = jQuery('#pageTitleAll').text();
    var formStudentMobile = jQuery('#formStudentMobile').text();
    var formStudentCity = jQuery('#formStudentCity').text();
    var formStudentState = jQuery('#formStudentState').text();
    var formStudentDOB = jQuery('#formStudentDOB').text();
    var menu_text = jQuery(this).text();
    var clientID = jQuery('#gaCookie').text();
  	// Set Data Layer Variable
  	dataLayerArray['ClientId'] = clientID;
  	dataLayerArray['event'] =  'PopularProgrammes_Explore_'+pageTitle.replace(/\s/g, '')+'_'+menu_text.replace(/\s/g, '');
      dataLayerArray['pageCategory'] = pageTitle.replace(/\s/g, '');
      dataLayerArray['pageSubCategory'] = 'PopularProgrammes';
      dataLayerArray['PageSubSubCategory'] = 'PopularProgrammesExploreMore';
      dataLayerArray['PageName'] = 'india:'+pageTitle.replace(/\s/g, '');
      dataLayerArray['StudentEncryptedMobileNumber'] = formStudentMobile;
      dataLayerArray['StudentState'] = formStudentState;
      dataLayerArray['StudentCity'] = formStudentCity;
      dataLayerArray['StudentDOB'] = formStudentDOB;

	// Trigger dataLayer with Const Variable
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push(dataLayerArray);

	
});
// Home Page Banner Talk To Expert Form submit Click event
jQuery(document).on("click","form.webform-submission-talk-to-expert-form .webform-button--submit",function() {
    var pageTitle = jQuery('#pageTitleAll').text();
    var formStudentMobile = jQuery('#formStudentMobile').text();
    var formStudentCity = jQuery('#formStudentCity').text();
    var formStudentState = jQuery('#formStudentState').text();
    var formStudentDOB = jQuery('#formStudentDOB').text();
    var menu_text = jQuery(this).text();
    var type = 'TalktoOurExperts_Banner';
    var clientID = jQuery('#gaCookie').text();
  	// Set Data Layer Variable
  	dataLayerArray['ClientId'] = clientID;
  	dataLayerArray['event'] =  type+'_EnquiryForm_'+pageTitle.replace(/\s/g, '')+'_Submit';
      dataLayerArray['pageCategory'] = pageTitle.replace(/\s/g, '');
      dataLayerArray['pageSubCategory'] = type;
      dataLayerArray['PageName'] = 'india:'+pageTitle.replace(/\s/g, '');
      dataLayerArray['StudentEncryptedMobileNumber'] = formStudentMobile;
      dataLayerArray['StudentState'] = formStudentState;
      dataLayerArray['StudentCity'] = formStudentCity;
      dataLayerArray['StudentDOB'] = formStudentDOB;

	// Trigger dataLayer with Const Variable
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push(dataLayerArray);
	
});
// Home Page Knowledge Center Social Media tab Click event
jQuery(document).on("click","section.sliderinner-wrap .know-iframe ul li a",function() {
    var pageTitle = jQuery('#pageTitleAll').text();
    var formStudentMobile = jQuery('#formStudentMobile').text();
    var formStudentCity = jQuery('#formStudentCity').text();
    var formStudentState = jQuery('#formStudentState').text();
    var formStudentDOB = jQuery('#formStudentDOB').text();
    var menu_text = jQuery(this).text();
    var type = 'KnowledgeCentre';
    var clientID = jQuery('#gaCookie').text();
  	// Set Data Layer Variable
  	dataLayerArray['ClientId'] = clientID;
  	dataLayerArray['event'] =  type+'_'+menu_text.replace(/\s/g, '')+'_Social_'+pageTitle.replace(/\s/g, '')+'_TabClick';
      dataLayerArray['pageCategory'] = pageTitle.replace(/\s/g, '');
      dataLayerArray['PageSubCategory'] = type;
      dataLayerArray['PageSubSubCategory'] = type+'_Social';
      dataLayerArray['PageName'] = 'india:'+pageTitle.replace(/\s/g, '');
      dataLayerArray['StudentEncryptedMobileNumber'] = formStudentMobile;
      dataLayerArray['StudentState'] = formStudentState;
      dataLayerArray['StudentCity'] = formStudentCity;
      dataLayerArray['StudentDOB'] = formStudentDOB;

	// Trigger dataLayer with Const Variable
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push(dataLayerArray);
	
});
// Home Page Banner know more Click event
jQuery(document).on("click","section.slider-container .slidermain .slick-track .slick-slide .slidewrap .contantbox a",function() {
    var pageTitle = jQuery('#pageTitleAll').text();
    var formStudentMobile = jQuery('#formStudentMobile').text();
    var formStudentCity = jQuery('#formStudentCity').text();
    var formStudentState = jQuery('#formStudentState').text();
    var formStudentDOB = jQuery('#formStudentDOB').text();
    var menu_text = jQuery(this).text();
    var type = 'Banner';
    var clientID = jQuery('#gaCookie').text();
    var href = jQuery(this).attr("attr").replace(/\n/g, '');;

  	// Set Data Layer Variable
  	dataLayerArray['ClientId'] = clientID;
  	dataLayerArray['event'] =  type+'_KnowMoreAboutCourses_'+pageTitle.replace(/\s/g, '')+'_'+menu_text.replace(/\s/g, '');
      dataLayerArray['pageCategory'] = pageTitle.replace(/\s/g, '');
      dataLayerArray['pageSubCategory'] = type;
      dataLayerArray['PageSubSubCategory'] = type+'_'+href;
      dataLayerArray['PageName'] = 'india:'+pageTitle.replace(/\s/g, '');
      dataLayerArray['StudentEncryptedMobileNumber'] = formStudentMobile;
      dataLayerArray['StudentState'] = formStudentState;
      dataLayerArray['StudentCity'] = formStudentCity;
      dataLayerArray['StudentDOB'] = formStudentDOB;

	// Trigger dataLayer with Const Variable
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push(dataLayerArray);
	
});
//////////////////////////////////////////
//////////// ICICI Page Event ////////////
//////////////////////////////////////////

// ICICI Page Click Event Start
// Global mobile and desktop menu Click event
var classCoursePage = '.DonloadButn .btnReqCall, .StackRouteDonloadButn .btnReqCall, .iciciPriceMain .btnApply, .StackroutePriceSec .btnApply';
jQuery(document).on("click",classCoursePage,function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'Enrollment';
    jQuery.ajax({
     url : GOOGLE_TAG_EVENT_DATALAYER_URL,
     type: 'POST',
     data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
     success: function(response) {
        if(response) {
           window.dataLayer = window.dataLayer || [];
           window.dataLayer.push(response.data);

       } else {
           console.log('Ajax Error');
           return false;
       }
   }
});
});
// Download Button
jQuery(document).on("click",'.dwnld-broshure-btn, .StackRouteDonloadButn .btnDownlaod',function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'EnquiryForm';
    jQuery.ajax({
     url : GOOGLE_TAG_EVENT_DATALAYER_URL,
     type: 'POST',
     data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
     success: function(response) {
        if(response) {
           window.dataLayer = window.dataLayer || [];
           window.dataLayer.push(response.data);

       } else {
           console.log('Ajax Error');
           return false;
       }
   }
});
});
// 3 Easy Step process Apply Now Event
jQuery(document).on("click","#easyStepProcee .text-center .btnApply, .embraceSec .text-center .btnApply",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'Easy3StepProcess_Enrollment';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });

// Eligibility Apply Now Event
jQuery(document).on("click","#iciciEligibility .text-center .btnApply, .eligibilitySec .text-center .btnApply",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'EligibilityComponent_Enrollment';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });

// ICICI Testimonoal Tabs Event
jQuery(document).on("click","#icicitestimonoal .iciciTestimonoalTabBtn li a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'Testimonials_KnowMoreAboutCourses';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// Course Details Download Brochure
jQuery(document).on("click","#iciciCourseDetail .brochureDwnloadBtn",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var menu_text = jQuery(this).text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'CourseDetails_EnquiryForm';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// Course Details FAQ Collapse and Expand Tabs Event
jQuery(document).on("click","#iciciCourseDetail .iciciAccordianDetail .panel-heading a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var PageSubSubCategory = jQuery(this).text().replace(/\s\s+/g, '');
    if(jQuery(this).attr('class')){
       var menu_text = 'Collapse';
   }else{
       var menu_text = 'Expand';
   }
  	// var current_path = window.location.pathname;
  	var type = 'CourseDetails_DetailCourseContent';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               response.data.PageSubSubCategory = PageSubSubCategory;
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// FAQ Collapse and Expand Tabs Event
jQuery(document).on("click",".icici-faq .iciciAccordianDetail .panel-heading a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var PageSubSubCategory = jQuery(this).text().replace(/\s\s+/g, '');
    if(jQuery(this).attr('class')){
       var menu_text = 'Collapse';
   }else{
       var menu_text = 'Expand';
   }
  	// var current_path = window.location.pathname;
  	var type = 'FAQs_KnowMoreAboutCourses';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               response.data.PageSubSubCategory = PageSubSubCategory;
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// STILL HAVE A QUERY Contact With Us Event
jQuery(document).on("click","#iciciStillHaveissue .btnApply, .stackrouteHaveQuery .btnApply, .careerrouteHaveQuery .btnApply",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'StillHaveAQuery_EnquiryForm';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// Stricky Bar Click  Event
jQuery(document).on("click","#icici-navbar .icici-page-scroll a, .stickyNavbar ul.list-unstyled li a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    if(jQuery.isNumeric(menu_text.replace(/\s/g, ''))){
       menu_text = 'Call';
   }
	// var current_path = window.location.pathname;
    var type = 'CourseOverview_KnowMoreAboutCourses';
    jQuery.ajax({
     url : GOOGLE_TAG_EVENT_DATALAYER_URL,
     type: 'POST',
     data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
     success: function(response) {

        if(response) {
           window.dataLayer = window.dataLayer || [];
           window.dataLayer.push(response.data);

       } else {
           console.log('Ajax Error');
           return false;
       }
   }
});
});
// Stricky Bar Call Button Click
jQuery(document).on("click","#icici-navbar .iciciStickyNav a, .phone-ga a.phone-icon, .sticky-navbar.mobile-hide a.phone-icon",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'Call';
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'CourseOverview_EnquiryForm';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });

// Modular FAQ Collapse and Expand Tabs Event
jQuery(document).on("click",".faq .views-field-field-faq h3.faqfield-question",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var PageSubSubCategory = jQuery(this).text().replace(/\s\s+/g, '');
    if(jQuery(this).hasClass('ui-state-active')){
       var menu_text = 'Expand';
   }else{
       var menu_text = 'Collapse';
   }
  	// var current_path = window.location.pathname;
  	var type = 'FAQs_KnowMoreAboutCourses';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               response.data.PageSubSubCategory = PageSubSubCategory;
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });

// Modular Course Module Collapse and Expand Tabs Event
jQuery(document).on("click",".courseModuleNewSec .corseMod h3.faqfield-question",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var PageSubSubCategory = jQuery(this).text().replace(/\s\s+/g, '');
    if(jQuery(this).hasClass('ui-state-active')){
       var menu_text = 'Expand';
   }else{
       var menu_text = 'Collapse';
   }
  	// var current_path = window.location.pathname;
  	var type = 'CourseDetails_DetailCourseContent';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               response.data.PageSubSubCategory = PageSubSubCategory;
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });


//////////////////////////////////////////
/////// Old Product Page Event ///////////
//////////////////////////////////////////

// Left Side Enroll Now button click event
jQuery(document).on("click",".leftCollege .btnBox .EnrollNow a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'Enrollment';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });

// Right Side Get In Touch Submit click event
jQuery(document).on("click",".GetinTouch form.getproduct input[type=submit]",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).val();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'GetInTouchWithUs_EnquiryForm';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// Right Side Get In Touch Submit click event
jQuery(document).on("click",".GetinTouch form input[type=submit]",function() {
	// e.preventDefault();
	var name = jQuery(this).parents('form').find('input#edit-name').val();
	var phone = jQuery(this).parents('form').find('input#edit-mobile').val();
	var email = jQuery(this).parents('form').find('input#edit-email').val();
	if(!empty(name) && !empty(phone) && !empty(email)){
		var pageTitle = jQuery('#pageTitleAll').text();
       var node_id = 'node_id/'+jQuery('#pageNodeId').text();
       var menu_url = window.location.pathname;
       var menu_text = jQuery(this).val();
       var pageNodeId = jQuery('#pageNodeId').text();
       var clientID = jQuery('#gaCookie').text();
       var pageNodeBundle = jQuery('#pageNodeBundle').text();
       var pageCourseCode = jQuery('#pageCourseCode').text();
       var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
       var coursefeedetails = jQuery('#coursefeedetails').text();
	  	// var current_path = window.location.pathname;
	  	var type = 'GetInTouchWithUs_EnquiryForm';
	  	jQuery.ajax({
            url : GOOGLE_TAG_EVENT_DATALAYER_URL,
            type: 'POST',
            data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
            success: function(response) {

               if(response) {
                  window.dataLayer = window.dataLayer || [];
                  window.dataLayer.push(response.data);

              } else {
                  console.log('Ajax Error');
                  return false;
              }
          }
      });

    }

});
// Course Overview Course Details/Modules/Eligibility Click Event
jQuery(document).on("click","#horizontalTab2 ul li a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'CourseOverview_KnowMoreAboutCourses';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// Global Popular Programmes Overlay Click event
jQuery(document).on("click",".Ajob-container .slick-list .slick-slide .detailsinfo a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = jQuery(this).attr('data-drupal-link-system-path');
    var menu_url = jQuery(this).attr('href');
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	if(pageTitle == 'Home'){
  		var type = 'JobAssuredProgrammes';
  	}else{
  		var type = 'RelatedCourses';
  	}	  	
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// FAQ Collapse and Expand Tabs Event
jQuery(document).on("click",".faq-wrap .accordionButton",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var PageSubSubCategory = jQuery(this).text().replace(/\s\s+/g, '');
    if(jQuery(this).attr('class') == 'accordionButton on'){
       var menu_text = 'Expand';
   }else{
       var menu_text = 'Collapse';
   }
  	// var current_path = window.location.pathname;
  	var type = 'FAQs_KnowMoreAboutCourses';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               response.data.PageSubSubCategory = PageSubSubCategory;
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// Bottom Side Counselling Appointment Submit click event
jQuery(document).on("click",".ftop-appoinment .fieldwrap .gdprForm button[type=submit]",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'Counselling_Appointment';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });
// Webinar Btn Click Event
jQuery(document).on("click",".join-web.reload-web, .record-btn .rec-link",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
  	// var node_id = 'node_id/'+jQuery('#pageNodeId').text();
  	// var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
  	// var current_path = window.location.pathname;
  	var type = 'Webinar';

  	dataLayerArray['ClientId'] = clientID;
  	dataLayerArray['event'] =  pageTitle.replace(/\s/g, '')+'_'+type+'_'+menu_text.replace(/\s/g, '');
      dataLayerArray['pageCategory'] = pageTitle.replace(/\s/g, '');
	// dataLayerArray['pageSubCategory'] = type;
	dataLayerArray['PageName'] = 'india:'+pageTitle.replace(/\s/g, '');

	// Trigger dataLayer with Const Variable
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push(dataLayerArray);
});

// Modular Talk to our expert Btn Click Event
jQuery(document).on("click",".stillText a, .modularRequestCallBack a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'EnquiryForm';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });

// Modular Enroll now city Click Event Start
jQuery(document).on("click",".course_modal .citylist li",function() {
    // e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).find('span').text();
    var pageNodeId = jQuery(this).attr('attributes');
    var clientID = jQuery('#gaCookie').text();
    var CourseEnrollmentcheck = 1;
    var CenterCity = jQuery(this).find('span').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    // var current_path = window.location.pathname;
    var type = 'CourseDetails_Enrollment';
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {CenterCity: CenterCity, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, CourseEnrollmentcheck : CourseEnrollmentcheck, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

            if(response) {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(response.data);
                
            } else {
                console.log('Ajax Error');
                return false;
            }
        }
    });
});

// Explore more button on related course
jQuery(document).on("click","#exploreMoreCustomLoad .explore_more a.morebtnpro",function() {
    // e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery(this).attr('attributes');
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    // var current_path = window.location.pathname;
    var type = 'EnquiryForm';
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

            if(response) {
                response.data.PageName = menu_url.replace(/[/ ]/g, ":").slice(1);
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(response.data);
                
            } else {
                console.log('Ajax Error');
                return false;
            }
        }
    });
});

// search buttor on related course page    
jQuery(document).on("click",".search_section .form-group #myformautocomplete-list",function() {
    // e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).find('input').val();
    var pageNodeId = jQuery(this).attr('attributes');
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    // var current_path = window.location.pathname;
    var type = 'CourseDetails_Enrollment';
    var CourseEnrollmentcheck = 1;
    var CenterCity = jQuery(this).find('input').val();
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {CenterCity: CenterCity, CourseEnrollmentcheck: CourseEnrollmentcheck, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

            if(response) {
                response.data.PageName = menu_url.replace(/[/ ]/g, ":").slice(1);
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(response.data);
                
            } else {
                console.log('Ajax Error');
                return false;
            }
        }
    });
});

jQuery(document).on("click","#searchCityautocomplete-list div",function() {
    // e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).find('input').val();
    var pageNodeId = jQuery("#myform").attr('attributes');
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    // var current_path = window.location.pathname;
    var type = 'CourseDetails_Enrollment';
    var CourseEnrollmentcheck = 1;
    var CenterCity = jQuery(this).find('input').val();
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {CenterCity: CenterCity, CourseEnrollmentcheck: CourseEnrollmentcheck, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

            if(response) {
                response.data.PageName = menu_url.replace(/[/ ]/g, ":").slice(1);
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(response.data);
                
            } else {
                console.log('Ajax Error');
                return false;
            }
        }
    });
});

// Modular Hardware and Software Requirements popup Click Event
jQuery(document).on("click",".modularSystemRequirement a",function() {
    // e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'HardwareSoftwareRequirements';
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'EnquiryForm';
    var CourseEnrollmentcheck = 1;
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {CourseEnrollmentcheck: CourseEnrollmentcheck, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

            if(response) {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(response.data);
                
            } else {
                console.log('Ajax Error');
                return false;
            }
        }
    });
});

// Modular EnrollNow popup Click Event
jQuery(document).on("click",".productPageBanner .cust-btnEnrolNow a, .desktop-hide .courseDetail-info .cust-btnEnrolNow a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'Enroll Now';
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'CourseDetails';
    var CourseEnrollmentcheck = 1;
    jQuery.ajax({
     url : GOOGLE_TAG_EVENT_DATALAYER_URL,
     type: 'POST',
     data: {CourseEnrollmentcheck: CourseEnrollmentcheck, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
     success: function(response) {

        if(response) {
           window.dataLayer = window.dataLayer || [];
           window.dataLayer.push(response.data);

       } else {
           console.log('Ajax Error');
           return false;
       }
   }
});
});

// Modular EnrollNow popup Click Event - Sticky bar
jQuery(document).on("click",".sticky-navbar .cust-btnEnrolNow a",function() {
    // e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'Enroll Now';
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'CourseOverview';
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

            if(response) {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(response.data);
                
            } else {
                console.log('Ajax Error');
                return false;
            }
        }
    });
});
//Modular Related Courese Title link
jQuery(document).on("click","#related-course .card-title-new a",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery(this).attr('node_id');
    var menu_url = jQuery(this).attr('href');
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// alert(pageNodeId);
  	var type = 'RelatedCourses';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });


// Modular Related Courses EnrollNow popup Click Event - working
jQuery(document).on("click","#related-course .card-body a.btn-infos-2",function() {
    // e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'Enroll Now';
    var pageNodeId = jQuery(this).attr('attributes');
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'RelatedCourses';
    var CourseEnrollmentcheck = 1;
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {CourseEnrollmentcheck: CourseEnrollmentcheck, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

            if(response) {
                response.data.PageName = current_path.replace(/[/ ]/g, ":").slice(1);
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(response.data);
                
            } else {
                console.log('Ajax Error');
                return false;
            }
        }
    });
});

// Course Below lead form submit Click Event
jQuery(document).on("click",".getproduct .connectBtn .webform-button--submit",function() {
    // e.preventDefault();.GetinTouch form input[type=submit]
    var name = jQuery(this).parents('form').find('input[name="name"]').val();
    var phone = jQuery(this).parents('form').find('input[name="mobile"]').val();
    var email = jQuery(this).parents('form').find('input[name="email"]').val();
    if(name != '' && phone != '' && email != ''){
        var pageTitle = jQuery('#pageTitleAll').text();
        var node_id = 'node_id/'+jQuery('#pageNodeId').text();
        var menu_url = window.location.pathname;
        var menu_text = jQuery(this).val();
        var pageNodeId = jQuery('#pageNodeId').text();
        var clientID = jQuery('#gaCookie').text();
        var pageNodeBundle = jQuery('#pageNodeBundle').text();
        var pageCourseCode = jQuery('#pageCourseCode').text();
        var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
        var coursefeedetails = jQuery('#coursefeedetails').text();
        // var current_path = window.location.pathname;
        var type = 'GetInTouchWithUs_EnquiryForm';
        jQuery.ajax({
            url : GOOGLE_TAG_EVENT_DATALAYER_URL,
            type: 'POST',
            data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
            success: function(response) {

                if(response) {
                    window.dataLayer = window.dataLayer || [];
                    window.dataLayer.push(response.data);
                    
                } else {
                    console.log('Ajax Error');
                    return false;
                }
            }
        });

    }

});

// Social icons on modular course page - Facebook
jQuery(document).on("click",".vide0Card-share-icons .fa-facebook",function() {
    // e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'Facebook';
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var type = 'CourseDetails_SocialShare';
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var CourseEnrollmentcheck = 0;
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {CourseEnrollmentcheck: CourseEnrollmentcheck, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

            if(response) {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(response.data);
                
            } else {
                console.log('Ajax Error');
                return false;
            }
        }
    });
});

// Social icons on modular course page - Twitter
jQuery(document).on("click",".vide0Card-share-icons .fa-twitter",function() {
    // e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'Twitter';
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'CourseDetails_SocialShare';
    var CourseEnrollmentcheck = 0;
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {CourseEnrollmentcheck: CourseEnrollmentcheck, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

            if(response) {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(response.data);
                
            } else {
                console.log('Ajax Error');
                return false;
            }
        }
    });
});

// Social icons on modular course page - LinkedIn
jQuery(document).on("click",".vide0Card-share-icons .fa-linkedin",function() {
    // e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'Linkedin';
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'CourseDetails_SocialShare';
    var CourseEnrollmentcheck = 0;
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {CourseEnrollmentcheck: CourseEnrollmentcheck, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

            if(response) {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(response.data);

            } else {
                console.log('Ajax Error');
                return false;
            }
        }
    });
});

// Watch Intro Video Click Event
jQuery(document).on("click",".newIntroVideo",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
		var menu_text = 'WatchIntroVideo';//jQuery(this).val();
		var pageNodeId = jQuery('#pageNodeId').text();
		var clientID = jQuery('#gaCookie').text();
		var pageNodeBundle = jQuery('#pageNodeBundle').text();
		var pageCourseCode = jQuery('#pageCourseCode').text();
        var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
        var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'WatchIntroVideo';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });

// Why Join ABPB Program Video Click Event
jQuery(document).on("click",".video-play-button",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
		var menu_text = 'WhyJoinABPBProgram';//jQuery(this).val();
		var pageNodeId = jQuery('#pageNodeId').text();
		var clientID = jQuery('#gaCookie').text();
		var pageNodeBundle = jQuery('#pageNodeBundle').text();
		var pageCourseCode = jQuery('#pageCourseCode').text();
        var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
        var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'WhyJoinABPBProgram';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });

// Fee Section Apply Now Event
jQuery(document).on("click","#feeSection .btnPayment .btnApply",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'ProgramFee_Enrollment';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });

// Fee Section View Payment Plan click Event
jQuery(document).on("click","#feeSection .btnPayment button.paymentOpt",function() {
	// e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
  	// var current_path = window.location.pathname;
  	var type = 'ProgramFee_Enrollment';
  	jQuery.ajax({
         url : GOOGLE_TAG_EVENT_DATALAYER_URL,
         type: 'POST',
         data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
         success: function(response) {

            if(response) {
               window.dataLayer = window.dataLayer || [];
               window.dataLayer.push(response.data);

           } else {
               console.log('Ajax Error');
               return false;
           }
       }
   });
  });

// FAQs on Interview page Collapse and Expand
jQuery(document).on("click",".icici-faqa .iciciAccordianDetail .panel-heading a",function() {
    // e.preventDefault();
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var pageNodeId = jQuery('#pageNodeId').text();
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    if(jQuery(this).attr('class')){
        var menu_text = 'Collapse';
    }else{
        var menu_text = 'Expand';
    }
    // var current_path = window.location.pathname;
    var type = 'FAQs_KnowMoreAboutCourses';
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

            if(response) {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(response.data);
                
            } else {
                console.log('Ajax Error');
                return false;
            }
        }
    });
});
//////////////////////////////////////////
//////////////////////////////////////////
/*jQuery(document).on("click",".ContinueYourApplicationForm .continue-btn",function() {
	var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'ContinueYourApplication';
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'ApplicationSubmit_Enrollment';
    jQuery.ajax({
     url : GOOGLE_TAG_EVENT_DATALAYER_URL,
     type: 'POST',
     data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
     success: function(response) {

        if(response) {
				// var eventdata = encodeURI(JSON.stringify(response.data));
    //             jQuery('form.ContinueYourApplicationForm input[name="eventdata"]').val(eventdata);
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(response.data);

} else {
   console.log('Ajax Error');
   return false;
}
}
});
});*/

//MyApplication Popup continue btn click
jQuery(document).on("click","#myapplication-data #my-application-continue",function() {
	var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery(this).attr('nid');
    var menu_url = window.location.pathname;
    var menu_text = 'ContinueYourApplication';
    var pageNodeId = jQuery(this).attr('nid');
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'ApplicationSubmit_Enrollment';
    jQuery.ajax({
     url : GOOGLE_TAG_EVENT_DATALAYER_URL,
     type: 'POST',
     data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
     success: function(response) {

        if(response) {
           var eventdata = encodeURI(JSON.stringify(response.data));
           jQuery('form.myapp-form-'+pageNodeId+' input[name="eventdata"]').val(eventdata);
           window.dataLayer = window.dataLayer || [];
           window.dataLayer.push(response.data);
           jQuery('form.myapp-form-'+pageNodeId+' input.continue-btn').trigger('click');

       } else {
           console.log('Ajax Error');
           return false;
       }
   }
});
});

// Mobile footer Apply Now btn click
jQuery(document).on("click","#mobile-sticky-footer span.btnApply",function() {
	var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'Footer_Enrollment';
    jQuery.ajax({
     url : GOOGLE_TAG_EVENT_DATALAYER_URL,
     type: 'POST',
     data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
     success: function(response) {

        if(response) {
           window.dataLayer = window.dataLayer || [];
           window.dataLayer.push(response.data);

       } else {
           console.log('Ajax Error');
           return false;
       }
   }
});
});
// Sign In sign Up button click event ********** Start
jQuery(document).on("click",".loginSignUpDropDown li button.signin_btn, .navmobile .m-signBtn button.signin_btn",function() {
	var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = jQuery(this).text();
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'TopMenu_Enrollment';
    jQuery.ajax({
     url : GOOGLE_TAG_EVENT_DATALAYER_URL,
     type: 'POST',
     data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
     success: function(response) {

        if(response) {
           window.dataLayer = window.dataLayer || [];
           window.dataLayer.push(response.data);

       } else {
           console.log('Ajax Error');
           return false;
       }
   }
});
});
// Register Form event 
jQuery(document).on("click","form.sso-user-register-form .register_otp-check span, form.sso-user-register-form .otp-register span.verify-register-otp, form.sso-user-register-form p.signin-pt-1 a",function() {
    var menu_text = jQuery(this).text();
    var ga_event_type = '';
    var click_by_modular = jQuery('form.sso-user-register-form .click_by_modular input').val();
    var pagetype = jQuery('form.sso-user-register-form input[name="pagetype"]').val();
    var mobileNumber = jQuery(this).parents('form.sso-user-register-form').find('input.mobile-numbr').val();
    if(click_by_modular == 1){
      ga_event_type = 'EnrollmentPopUP_Enrollment';
  }else{
    if(pagetype == 'KC'){
        ga_event_type = 'Registration';
        if(jQuery('#pageNodeBundle').text() == 'HierarchyCategory'){
           var categoryTitle = jQuery('.kc_detalpage_header .kc_artcle_news .Pagetitle').text();
           var categorySlug = categoryTitle.replace(/\s/g, '');
           ga_event_type = categorySlug+'_Registration';
       }
   } else {
    ga_event_type = 'RegisterPopUp_Enrollment';
}
}
ga_signIn_signUp_event(menu_text.replace(/\s/g, ''), ga_event_type, mobileNumber);
});
// Sign In Form event 
jQuery(document).on("click","form.sso-user-login-form .forgot_password_modal_form a b, form.sso-user-login-form p.signin-pt-1 a",function() {
	var menu_text = jQuery(this).text();
	var click_by_modular = jQuery('form.sso-user-login-form .click_by_modular input').val();
	if(click_by_modular == 1){
		var ga_event_type = 'EnrollmentPopUP_Enrollment';
	}else{
		var ga_event_type = 'SignInPopUp_Enrollment';
	}
	ga_signIn_signUp_event(menu_text.replace(/\s/g, ''), ga_event_type);
});
// Continue application button click event
jQuery(document).on("click",".course-page-breadcrub .desk-com button.com-app",function() {
	var menu_text = jQuery(this).text();
	var ga_event_type = 'CourseDetails_Enrollment';
	ga_signIn_signUp_event(menu_text.replace(/\s/g, ''), ga_event_type);
});
// check eligibility form mobile number varification
jQuery(document).on("click",".mob-otp-verify span.dis-otp-field, .otp-verify span.check-otp-display",function() {
	var menu_text = jQuery(this).text();
	var ga_event_type = 'CheckEligibility_Enrollment';
	ga_signIn_signUp_event(menu_text.replace(/\s/g, ''), ga_event_type);
});
// Sign In sign Up button click event ********** End


//Lead Magnet Widget start

jQuery(document).on("click", ".magnet-widget .white-btn", function () {
    
    var pageTitle = jQuery('#pageTitleAll').text();
    var coursecode = jQuery('#pageCourseCode').text();

    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'Magnet_Widget_Course Details';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['pageCategory'] = " CoursePage";

    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});


jQuery(document).on("click", ".magnet-widget .Stackathon-Lead-Form-div .StackathonLeadFormBtn", function () {
    
    var pageTitle = jQuery('#pageTitleAll').text();
    var coursecode = jQuery('#pageCourseCode').text();

    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'Magnet_Widget_Start Learning';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['pageCategory'] = " CoursePage";

    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

jQuery(document).on("click", ".magnet-widget .Stackathon-Lead-Form-div .clsOpenMyBatchesLink", function () {
    
    var pageTitle = jQuery('#pageTitleAll').text();
    var coursecode = jQuery('#pageCourseCode').text();

    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'Magnet_Widget_Access Your Course';
    dataLayerArray['CourseCode'] = coursecode;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['pageCategory'] = " CoursePage";

    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});



jQuery(document).on("click", ".magnet-widget .Stackathon-Lead-Form-div .StackathonLeadFormBtn", function () {     
    jQuery(".subscription-submit").click(function() {
       setTimeout(function() {
        if(jQuery('.Self-stackathon-div .congratulation_screen').is(':visible')){
  
            var pageTitle = jQuery('#pageTitleAll').text();
            var coursecode = jQuery('#pageCourseCode').text();

            // Set Data Layer Variable
            dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
            dataLayerArray['event'] = 'Magnet_Widget_Success';
            dataLayerArray['CourseCode'] = coursecode;
            dataLayerArray['PageName'] = getTabRelativeURL();
            dataLayerArray['pageCategory'] = " CoursePage";

            // Trigger dataLayer with Const Variable
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push(dataLayerArray);          
            
        };

        if(jQuery('.Self-stackathon-div .subscription-submit').is(':visible')){
  
            var pageTitle = jQuery('#pageTitleAll').text();
            var coursecode = jQuery('#pageCourseCode').text();

            // Set Data Layer Variable
            dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
            dataLayerArray['event'] = 'Magnet_Widget_Fail';
            dataLayerArray['CourseCode'] = coursecode;
            dataLayerArray['PageName'] = getTabRelativeURL();
            dataLayerArray['pageCategory'] = " CoursePage";

            // Trigger dataLayer with Const Variable
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push(dataLayerArray);          
            
        };

       }, 5000);  
    
    });
});



//Lead Magnet Widget end

    ///////////////////////////////////////
//////// Knowledge Center ////////////
/////////////////////////////////////

/* Banner search box tracking
 * @event: KnowledgeCenter_Search_KCHomePage_SearchOccurred
 */
 jQuery(document).on('submit', '#kc-artciles #searchBox form#searchform', function () {
    var keywordSearch = $(this).find(jQuery('input[name=keyword]'));
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'KnowledgeCenter_Search_KCHomePage_SearchOccurred';
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = keywordSearch.val();
    dataLayerArray['pageCategory'] = "KnowledgeCentrePage";
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* Banner link click tracking 
 * @event: KnowledgeCenter_TopBanner_KCHomePage_BannerClick
 */
 jQuery(document).on("click", "#kc-artciles .kcHome_banner #kcCarousel .banner-textbox label a", function () {
    var linkTitle = jQuery(this).text();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['event'] = 'KnowledgeCenter_TopBanner_KCHomePage_BannerClick';
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentrePage";
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* Feature article category tracking
 * @event: KnowledgeCenter_FeaturedArticles_<ArticleCategory>_KCHomePage_CategoryClicked
 */
 jQuery(document).on('click', '#kc-artciles .kc_home_articles .imagebar .kc_img_cap kmcgbar a', function () {
    var linkTitle = jQuery(this).text();
    var categoryTitle = jQuery(this).text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_FeaturedArticles_${categorySlug}_KCHomePage_CategoryClicked`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentrePage";
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

/* Feature article tracking
 * @event: KnowledgeCenter_FeaturedArticles_<ArticleCategory>_KCHomePage_ArticleClicked
 */
 jQuery(document).on('click', '#kc-artciles .kc_home_articles .imagebar .kc_img_cap h5 a', function () {
    var linkTitle = jQuery(this).text();
    var categoryTitle = $(this).parents('.kc_img_cap').find('.kmcgbar>a').text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_FeaturedArticles_${categorySlug}_KCHomePage_ArticleClicked`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentrePage";
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* Feature article tracking 2
 * @event: KnowledgeCenter_FeaturedArticles_<ArticleCategory>_KCHomePage_ArticleClicked
 */
 jQuery(document).on('click', '#kc-artciles .kc_articles2 .contentimg label a, #kc-artciles .kc_articles2_right .contentbar label a', function () {
    var linkTitle = jQuery(this).text();
    var categoryTitle = $(this).parents('.contentimg, .contentbar').find('.kmcgbar>a').text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_FeaturedArticles_${categorySlug}_KCHomePage_ArticleClicked`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentrePage";
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* Feature Category tracking 2
 * @event: KnowledgeCenter_FeaturedArticles_<ArticleCategory>_KCHomePage_CategoryClicked
 */
 jQuery(document).on('click', '#kc-artciles .kc_articles2 .contentimg kmcgbar a, #kc-artciles .kc_articles2_right .contentbar kmcgbar a', function () {
    var linkTitle = jQuery(this).text();
    var categoryTitle = jQuery(this).text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_FeaturedArticles_${categorySlug}_KCHomePage_CategoryClicked`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentrePage";
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* Recent stories category click tracking
 * @event: KnowledgeCenter_RecentStories_<ArticleCategory>_KCHomePage_CategoryClicked
 */
 jQuery(document).on('click', '#kc-artciles .kc_home_recentStories .kc_recentStory .kc_recentStories_left a', function () {
    var categoryTitle = jQuery(this).text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    var linkTitle = jQuery(this).text();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_RecentStories_${categorySlug}_KCHomePage_CategoryClicked`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentrePage";
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* Recent stories article click tracking
 * @event: KnowledgeCenter_RecentStories_<ArticleCategory>_KCHomePage_ArticleClicked
 */
 jQuery(document).on('click', '#kc-artciles .kc_home_recentStories .kc_recentStory .kc_recentStories_right .rs-contect label a', function () {
    var linkTitle = jQuery(this).text();
    var categoryTitle = $(this).parents('.rs-contect').find('.rsc-heading>a').text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_RecentStories_${categorySlug}_KCHomePage_ArticleClicked`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentrePage";
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* Top categories click tracking
 * @event: KnowledgeCenter_TopCategories_KCHomePage_<ArticleCategory>
 */
 jQuery(document).on('click', '#kc-artciles .kc_top_categoy .categoriesbar .text-box a', function () {
    var categoryTitle = jQuery(this).text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    var linkTitle = jQuery(this).text();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_TopCategories_KCHomePage_${categorySlug}`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentrePage";
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* Upcoming event
 * @event: KnowledgeCenter_UpcomingEvents_<ArticleCategory>_KCHomePage_EventClicked
 * TODO
 */
 jQuery(document).on('click', '#kc-artciles .kc_upcoming_event #kcEventCarousel .text-box a', function () {
    // Set Data Layer Variable
    var linkTitle = jQuery(this).text();
    var categoryTitle = jQuery(this).data('taxonomy');
    var categorySlug = categoryTitle.replace(/\s/g, '');
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_UpcomingEvents_${categorySlug}_KCHomePage_EventClicked`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentrePage";
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

///////////////////////////////////////
/// Knowledge Center Article Page ////
/////////////////////////////////////

/* View course with CourseCode event
 * @event: KnowledgeCenter_<CourseCode>_CourseEnquiry_KCArticlePage_ViewCourse
 */
 jQuery(document).on('click', '#blog-pagesection .msg-course .view-btn-cl a', function () {
    var courseCode = jQuery(this).data('course-code');
    var linkTitle = jQuery(this).parents('.msg-course-text').find('h3').text();
    var categories = getBreadcrumbs();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_${courseCode}_CourseEnquiry_KCArticlePage_ViewCourse`;
    dataLayerArray['linkClicked'] = linkTitle; // send course name
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['pageCategory'] = "KnowledgeCentreArticlePage";
    dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['PageSubSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';

    dataLayerArray['articleName'] = jQuery('#pageTitleAll').text();
    dataLayerArray['articleCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['articleSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* View course with related articles
 * @event: KnowledgeCenter_RelatedArticles_<ArticleCategory>_KCArticlePage_ArticleClicked
 */
 jQuery(document).on('click', '#blog-pagesection .related-bl .course-content h4 a', function () {
    var linkTitle = jQuery(this).text();
    var categoryTitle = $(this).parents('.course-content').find('.kc_tech-tag>a').text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    var categories = getBreadcrumbs();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_RelatedArticles_${categorySlug}_KCArticlePage_ArticleClicked`;
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['pageCategory'] = "KnowledgeCentreArticlePage";
    dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['PageSubSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';

    dataLayerArray['articleName'] = jQuery('#pageTitleAll').text();
    dataLayerArray['articleCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['articleSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

///////////////////////////////////////
/// Knowledge Center Category Page ///
/////////////////////////////////////

/* Feature article tracking on category page
 * @event: KnowledgeCenter_FeaturedArticles_<ArticleCategory>_KCCategoryPage_ArticleClicked
 */
 jQuery(document).on('click', '#texonomy-page .kc_home_articles .imagebar .kc_img_cap h5 a', function () {
    var linkTitle = jQuery(this).text();
    var categoryTitle = $(this).parents('.kc_img_cap').find('.kmcgbar>a').text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    var categories = getBreadcrumbs();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_FeaturedArticles_${categorySlug}_KCCategoryPage_ArticleClicked`;
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['pageCategory'] = "KnowledgeCentreCategoryPage";
    dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['PageSubSubCategory'] = (categories.length > 3 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

/* Feature category tracking on category page
 * @event: KnowledgeCenter_FeaturedArticles_<ArticleCategory>_KCCategoryPage_CategoryClicked
 */
 jQuery(document).on('click', '#texonomy-page .kc_home_articles .imagebar .kc_img_cap .kmcgbar a', function () {
    var linkTitle = jQuery(this).text();
    var categoryTitle = jQuery(this).text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    var categories = getBreadcrumbs();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_FeaturedArticles_${categorySlug}_KCCategoryPage_CategoryClicked`;
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['pageCategory'] = "KnowledgeCentreCategoryPage";
    dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['PageSubSubCategory'] = (categories.length > 3 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* Recent stories category click tracking on category page
 * @event: KnowledgeCenter_RecentStories_<ArticleCategory>_KCCateoryPage_CategoryClicked
 */
 jQuery(document).on('click', '#texonomy-page .kc_home_recentStories .kc_recentStory .kc_recentStories_left a', function () {
    var categoryTitle = jQuery(this).text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    var linkTitle = jQuery(this).text();
    var categories = getBreadcrumbs();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_RecentStories_${categorySlug}_KCCateoryPage_CategoryClicked`;
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['pageCategory'] = "KnowledgeCentreCategoryPage";
    dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['PageSubSubCategory'] = (categories.length > 3 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* Recent stories article click tracking on category page
 * @event: KnowledgeCenter_RecentStories_<ArticleCategory>_KCCateoryPage_ArticleClicked
 */
 jQuery(document).on('click', '#texonomy-page .kc_home_recentStories .kc_recentStory .kc_recentStories_right .rs-contect label a', function () {
    var linkTitle = jQuery(this).text();
    var categoryTitle = $(this).parents('.rs-contect').find('.rsc-heading>a').text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_RecentStories_${categorySlug}_KCCateoryPage_ArticleClicked`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentreCategoryPage";
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
/* Upcoming event
 * @event: KnowledgeCenter_UpcomingEvents_<ArticleCategory>_KCCategoryPage_EventClicked
 * TODO
 */
 jQuery(document).on('click', '#texonomy-page .kc_upcoming_event #kcEventCarousel .text-box a', function () {
    var linkTitle = jQuery(this).text();
    var categoryTitle = jQuery(this).data('taxonomy');
    var categorySlug = categoryTitle.replace(/\s/g, '');
    var categories = getBreadcrumbs();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_UpcomingEvents_${categorySlug}_KCCategoryPage_EventClicked`;
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['pageCategory'] = "KnowledgeCentreCategoryPage";
    dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['PageSubSubCategory'] = (categories.length > 3 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});


// Start
jQuery(document).on('click', 'button.writeReviewBtn', function(){
	var linkTitle = jQuery(this).text();
    var categoryTitle = jQuery('.kc_detalpage_header .ArticleCategorytxt span a').text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    var categories = getBreadcrumbs();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_ReviewArticle_${categorySlug}_KCArticlePage_WriteReview`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentreArticlePage";
    dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['PageSubSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';

    dataLayerArray['articleName'] = jQuery('#pageTitleAll').text();
    dataLayerArray['articleCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['articleSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

jQuery(document).on('click', 'a.pre_article_link', function(){
	var linkTitle = 'Previous Article';
    var categoryTitle = jQuery('.kc_detalpage_header .ArticleCategorytxt span a').text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    var categories = getBreadcrumbs();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_NavigateArticle_${categorySlug}_KCArticlePage_PreviousArticle`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentreArticlePage";
    dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['PageSubSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';

    dataLayerArray['articleName'] = jQuery('#pageTitleAll').text();
    dataLayerArray['articleCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['articleSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});
jQuery(document).on('click', 'a.next_article_link', function(){
	var linkTitle = 'Next Article';
    var categoryTitle = jQuery('.kc_detalpage_header .ArticleCategorytxt span a').text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    var categories = getBreadcrumbs();
    // Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = `KnowledgeCenter_NavigateArticle_${categorySlug}_KCArticlePage_NextArticle`;
    dataLayerArray['PageName'] = getTabRelativeURL();
    dataLayerArray['linkClicked'] = linkTitle;
    dataLayerArray['pageCategory'] = "KnowledgeCentreArticlePage";
    dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['PageSubSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';

    dataLayerArray['articleName'] = jQuery('#pageTitleAll').text();
    dataLayerArray['articleCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
    dataLayerArray['articleSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
    // Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
});

//End

//////////////////////////////////////////
if(jQuery('form.ContinueYourApplicationForm').is(':visible')){
  countiuneYourApplicationEventData();
};
if(jQuery('form.ContinueYourApplicationForm').not(':visible')){
	 countiuneYourApplicationEventfail();
};
});
var GOOGLE_TAG_EVENT_DATALAYER_URL = drupalSettings.DRUPAL_SITE_PATH_INDIA.GOOGLE_TAG_EVENT_DATALAYER_URL; 

// jQuery Document Ready Function End
/*function ga_signIn_signUp_event(menu_text, type, mobileNumber = ''){
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = menu_text;
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = type;
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails, mobileNumber: mobileNumber},
        success: function(response) {

         if(response) {
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push(response.data);

        } else {
            console.log('Ajax Error');
            return false;
        }
    }
});
}*/
function dataLayerArrayFunction(){
    var dataLayerArray = {};
    dataLayerArray['ClientId'] = '';
    dataLayerArray['event'] =  '';
    dataLayerArray['Country'] = 'India';
    dataLayerArray['pageCategory'] = '';
    dataLayerArray['pageSubCategory'] = '';
    dataLayerArray['PageSubSubCategory'] = '';
    dataLayerArray['PageName'] = '';
    dataLayerArray['CourseCatogery'] = '';
    dataLayerArray['CourseSubCatogery'] = '';
    dataLayerArray['CourseName'] = '';
    dataLayerArray['CourseCode'] = '';
    dataLayerArray['CourseDuration'] = '';
    dataLayerArray['CourseFees'] = '';
    dataLayerArray['CourseBaseFee'] = '';
    dataLayerArray['CourseFeesTax'] = '';
    dataLayerArray['CourseType'] = '';
    dataLayerArray['CourseRating'] = '';
    dataLayerArray['CourseReviews'] = '';
    dataLayerArray['CourseEnrollmentNow'] = '';
    dataLayerArray['LeadId'] = '';
    dataLayerArray['CentreName'] = '';
    dataLayerArray['CentreId'] = '';
    dataLayerArray['CenterState'] = '';
    dataLayerArray['CenterCity'] = '';
    dataLayerArray['AvailableBatches'] = '';
    dataLayerArray['SelectedBatch'] = '';
    dataLayerArray['CourseStartDate'] = '';
    dataLayerArray['StudentEncryptedMobileNumber'] =  jQuery('#formStudentMobile').text();
    dataLayerArray['StudentRegistrationNumber'] = '';
    dataLayerArray['StudentDOB'] = '';
    dataLayerArray['StudentGender'] = '';
    dataLayerArray['StudentCountry'] = 'India';
    dataLayerArray['StudentState'] = '';
    dataLayerArray['StudentCity'] = '';
    dataLayerArray['StudentPinCode'] = '';
    /*************** New variable ************* start *******/
    dataLayerArray['StudentEncryptedEmailID'] = jQuery('#formStudentEmail').text();
    dataLayerArray['StudentName'] = jQuery('#formStudentName').text();
    dataLayerArray['CouponCode'] = '';
    dataLayerArray['CampaignCode'] = '';

    dataLayerArray['articleName'] = '';
    dataLayerArray['articleCategory'] = '';
    dataLayerArray['articleSubCategory'] = '';
    dataLayerArray['pageNodeBundle']= '';
    dataLayerArray['StudentName']= '';
    dataLayerArray['StudentEncryptedMobileNumber']= '';
    dataLayerArray['StudentEncryptedEmailID']= '';
    /*************** New variable ************* end *********/
    return dataLayerArray;
}

/// Start
function kc_article_up_down_vote_datalayer(linkTitle){
    var linkTitle_event = linkTitle.replace(/\s/g, '');
    var categoryTitle = jQuery('.kc_detalpage_header .ArticleCategorytxt span a').text();
    var categorySlug = categoryTitle.replace(/\s/g, '');
    var categories = getBreadcrumbs();
// Set Data Layer Variable
var dataLayerArray = dataLayerArrayFunction();

dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
dataLayerArray['event'] = `KnowledgeCenter_VoteArticle_${categorySlug}_KCArticlePage_${linkTitle_event}`;
dataLayerArray['PageName'] = getTabRelativeURL();
dataLayerArray['linkClicked'] = linkTitle;
dataLayerArray['pageCategory'] = "KnowledgeCentreArticlePage";
dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
dataLayerArray['PageSubSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';

dataLayerArray['articleName'] = jQuery('#pageTitleAll').text();
dataLayerArray['articleCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
dataLayerArray['articleSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
// Trigger dataLayer with Const Variable
window.dataLayer = window.dataLayer || [];
window.dataLayer.push(dataLayerArray);
}
function kc_article_follow_unfollow_datalayer(linkTitle){
    var nodeBundle = jQuery('#pageNodeBundle').text();
    if(linkTitle == 'Follow this category'){
     linkTitle_event = 'Follow';
 }else{
     linkTitle_event = 'Unfollow';
 }
// var linkTitle_event = linkTitle.replace(/\s/g, '');
var categoryTitle = jQuery('.kc_detalpage_header .ArticleCategorytxt span a').text();
var categorySlug = categoryTitle.replace(/\s/g, '');
var categories = getBreadcrumbs();
// Set Data Layer Variable
var dataLayerArray = dataLayerArrayFunction();

dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
dataLayerArray['event'] = `KnowledgeCenter_FollowCategory_${categorySlug}_KCArticlePage_${linkTitle_event}`;
dataLayerArray['PageName'] = getTabRelativeURL();
dataLayerArray['linkClicked'] = linkTitle;
dataLayerArray['pageCategory'] = "KnowledgeCentreArticlePage";
dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
dataLayerArray['PageSubSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';

if(nodeBundle == 'blog_post'){
  dataLayerArray['articleName'] = jQuery('#pageTitleAll').text();
  dataLayerArray['articleCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
  dataLayerArray['articleSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
}
// Trigger dataLayer with Const Variable
window.dataLayer = window.dataLayer || [];
window.dataLayer.push(dataLayerArray);
}
function kc_article_bookmark_datalayer(linkTitle){
    if(linkTitle.trim() == 'Add To Bookmark'){
     linkTitle_event = 'AddBookmark';
 }else{
     linkTitle_event = 'RemoveBookmark';
 }
 var nodeBundle = jQuery('#pageNodeBundle').text();
 if(nodeBundle == 'blog_post'){
     pagetype = 'KCArticlePage'; 
 }else{
     pagetype = 'KCHomePage'; 
 }
// var linkTitle_event = linkTitle.replace(/\s/g, '');
var categoryTitle = jQuery('.kc_detalpage_header .ArticleCategorytxt span a').text();
var categorySlug = categoryTitle.replace(/\s/g, '');
var categories = getBreadcrumbs();
// Set Data Layer Variable
var dataLayerArray = dataLayerArrayFunction();

dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
dataLayerArray['event'] = `KnowledgeCenter_BookmarkArticle_${categorySlug}_${pagetype}_${linkTitle_event}`;
dataLayerArray['PageName'] = getTabRelativeURL();
dataLayerArray['linkClicked'] = linkTitle.trim();
dataLayerArray['pageCategory'] = "KnowledgeCentreArticlePage";
dataLayerArray['pageSubCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
dataLayerArray['PageSubSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';

if(nodeBundle == 'blog_post'){
  dataLayerArray['articleName'] = jQuery('#pageTitleAll').text();
  dataLayerArray['articleCategory'] = (categories.length > 2 && categories[2]) ? categories[2].replace(/\s/g, '') : '';
  dataLayerArray['articleSubCategory'] = (categories.length > 4 && categories[3]) ? categories[3].replace(/\s/g, '') : '';
}

// Trigger dataLayer with Const Variable
window.dataLayer = window.dataLayer || [];
window.dataLayer.push(dataLayerArray);
}
/// End

// Jquary For prograssive webForm Button Event
/*function checkEligibilityFormEventAll(menu_text, successMsg){
// alert('hello');
var pageTitle = jQuery('#pageTitleAll').text();
var node_id = 'node_id/'+jQuery('#pageNodeId').text();
var menu_url = window.location.pathname;
var menu_text = menu_text;
var pageNodeId = jQuery('#pageNodeId').text();
var current_path = window.location.pathname;
var clientID = jQuery('#gaCookie').text();
var pageNodeBundle = jQuery('#pageNodeBundle').text();
var pageCourseCode = jQuery('#pageCourseCode').text();
var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
var coursefeedetails = jQuery('#coursefeedetails').text();
var type = 'CheckEligibility_Enrollment';
jQuery.ajax({
    url : GOOGLE_TAG_EVENT_DATALAYER_URL,
    type: 'POST',
    data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
    success: function(response) {

     if(response) {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push(response.data);

        if(successMsg){
           ApplicationFormStatusEvent(successMsg);
       }
   } else {
    console.log('Ajax Error');
    return false;
}
}
});
}*/
// Jquary For prograssive webForm Application Status Event
function ApplicationFormStatusEvent(menu_text){
// alert('hello');
var pageTitle = jQuery('#pageTitleAll').text();
var node_id = 'node_id/'+jQuery('#pageNodeId').text();
var menu_url = window.location.pathname;
var menu_text = menu_text;
var pageNodeId = jQuery('#pageNodeId').text();
var current_path = window.location.pathname;
var clientID = jQuery('#gaCookie').text();
var pageNodeBundle = jQuery('#pageNodeBundle').text();
var pageCourseCode = jQuery('#pageCourseCode').text();
var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
var coursefeedetails = jQuery('#coursefeedetails').text();
var type = 'ApplicationSubmit_Enrollment';
jQuery.ajax({
    url : GOOGLE_TAG_EVENT_DATALAYER_URL,
    type: 'POST',
    data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
    success: function(response) {

     if(response) {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push(response.data);

    } else {
        console.log('Ajax Error');
        return false;
    }
}
});
}
// Jquary For prograssive webForm Button Event
function webniarFormEventAll(menu_text){
// alert('hello');
var pageTitle = jQuery('#pageTitleAll').text();
var node_id = 'node_id/'+jQuery('#pageNodeId').text();
var menu_url = window.location.pathname;
var menu_text = menu_text;
var pageNodeId = jQuery('#pageNodeId').text();
var current_path = window.location.pathname;
var clientID = jQuery('#gaCookie').text();
var type = 'Webinar';

var dataLayerArrayNew = dataLayerArrayFunction();

dataLayerArrayNew['ClientId'] = clientID;
dataLayerArrayNew['event'] =  pageTitle.replace(/\s/g, '')+'_'+type+'_'+menu_text.replace(/\s/g, '');
dataLayerArrayNew['pageCategory'] = pageTitle.replace(/\s/g, '');
// dataLayerArray['pageSubCategory'] = type;
dataLayerArrayNew['PageName'] = 'india:'+pageTitle.replace(/\s/g, '');

// Trigger dataLayer with Const Variable
window.dataLayer = window.dataLayer || [];
window.dataLayer.push(dataLayerArrayNew);
}

// Jquary For prograssive TalkToOurExpertForm Submit Button Event
function talktoourexpertFormEventAll(menu_text){
// alert('hello');
var pageTitle = jQuery('#pageTitleAll').text();
var node_id = 'node_id/'+jQuery('#pageNodeId').text();
var menu_url = window.location.pathname;
var menu_text = menu_text;
var pageNodeId = jQuery('#pageNodeId').text();
var current_path = window.location.pathname;
var clientID = jQuery('#gaCookie').text();
var pageNodeBundle = jQuery('#pageNodeBundle').text();
var pageCourseCode = jQuery('#pageCourseCode').text();
var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
var coursefeedetails = jQuery('#coursefeedetails').text();
var type = 'TalkToOurExpert';
jQuery.ajax({
    url : GOOGLE_TAG_EVENT_DATALAYER_URL,
    type: 'POST',
    data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
    success: function(response) {

     if(response) {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push(response.data);

    } else {
        console.log('Ajax Error');
        return false;
    }
}
});
}

// Jquary For prograssive Simpleleadformsubmit Submit Button Event
function FormsubmitleadEventAll(menu_text){
// alert('hello');
var pageTitle = jQuery('#pageTitleAll').text();
var node_id = 'node_id/'+jQuery('#pageNodeId').text();
var menu_url = window.location.pathname;
var menu_text = menu_text;
var pageNodeId = jQuery('#pageNodeId').text();
var current_path = window.location.pathname;
var clientID = jQuery('#gaCookie').text();
var pageNodeBundle = jQuery('#pageNodeBundle').text();
var pageCourseCode = jQuery('#pageCourseCode').text();
var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
var coursefeedetails = jQuery('#coursefeedetails').text();
var type = 'Lead';
jQuery.ajax({
    url : GOOGLE_TAG_EVENT_DATALAYER_URL,
    type: 'POST',
    data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
    success: function(response) {

     if(response) {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push(response.data);

    } else {
        console.log('Ajax Error');
        return false;
    }
}
});
}

// Jquary For prograssive Modular Page Login Register Button Event
function loginregistermodularEvent(menu_text){
// alert('hello');
var pageTitle = jQuery('#pageTitleAll').text();
var node_id = 'node_id/'+jQuery('#pageNodeId').text();
var menu_url = window.location.pathname;
var menu_text = menu_text;
var pageNodeId = jQuery('#pageNodeId').text();
var current_path = window.location.pathname;
var clientID = jQuery('#gaCookie').text();
var pageNodeBundle = jQuery('#pageNodeBundle').text();
var pageCourseCode = jQuery('#pageCourseCode').text();
var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
var coursefeedetails = jQuery('#coursefeedetails').text();
var type = 'CourseDetails_Enrollment';
jQuery.ajax({
    url : GOOGLE_TAG_EVENT_DATALAYER_URL,
    type: 'POST',
    data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
    success: function(response) {

     if(response) {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push(response.data);

        jQuery('.not_display_continue .con-moduler-enrollnow').trigger('click');
        jQuery('.loading-modal').css('display', 'block');
    } else {
        console.log('Ajax Error');
        return false;
    }
}
});
}

function SubmitPreForm(objBtn, cntr_cd) {
// e.preventDefault();
var pageTitle = jQuery('#pageTitleAll').text();
var node_id = 'node_id/'+jQuery('#pageNodeId').text();
var menu_url = window.location.pathname;
var menu_text = jQuery(objBtn).text();
//var pageNodeId = jQuery('#pageNodeId').text();
var pageNodeId = jQuery(objBtn).attr('attributes');
var clientID = jQuery('#gaCookie').text();
var pageNodeBundle = jQuery('#pageNodeBundle').text();
var pageCourseCode = jQuery('#pageCourseCode').text();
var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
var coursefeedetails = jQuery('#coursefeedetails').text();
// var current_path = window.location.pathname;
var type = 'CourseDetails_Enrollment';
var CourseEnrollmentcheck = 1;
var CenterCity = jQuery( "input#searchCity" ).val();
var CentreName = jQuery(objBtn).parents('.centre_box').find('.col-sm-7 h3').text();
var CourseStartDate = jQuery(objBtn).parents('.centre_box').find('.batch_start_on .sortby_filter select option:selected' ).text();
var classattr = jQuery(objBtn).parents('.centre_box').find('.col-sm-7 h3').attr('id');
var CentreId = classattr.replace('centerName-', '');
var batchID = jQuery(objBtn).parents('.centre_box').find('.batch_start_on .sortby_filter select' ).val();

jQuery.ajax({
    url : GOOGLE_TAG_EVENT_DATALAYER_URL,
    type: 'POST',
    data: {CentreId: CentreId, CourseStartDate: CourseStartDate, CentreName: CentreName, CenterCity: CenterCity, CourseEnrollmentcheck: CourseEnrollmentcheck, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
    success: function(response) {

        if(response) {
          response.data.PageName = menu_url.replace(/[/ ]/g, ":").slice(1);	
          var eventdata = encodeURI(JSON.stringify(response.data));
          jQuery('#enroll-'+CentreId+'-'+batchID+' input[name="eventdata"]').val(eventdata);
          window.dataLayer = window.dataLayer || [];
          window.dataLayer.push(response.data);

          submitForm(cntr_cd);
      } else {
         console.log('Ajax Error');
         return false;
     }
 }
});
}
function countiuneYourApplicationEventfail(){
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pagebundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
	var StudentEncryptedMobileNumber = jQuery.md5(jQuery('#form-popup-wrapper :input[name="enqry_crsspndnc_mbl"]').val());
	var StudentEncryptedEmailID = jQuery.md5(jQuery('#form-popup-wrapper :input[name="enqry_crsspndnc_eml"]').val());
	var StudentName =  jQuery('#form-popup-wrapper :input[name="enqry_f_nm"]').val();
	var pageSubCategory = 'Top';
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var coursecode = jQuery('#pageCourseCode').text();
	var coursecategory = jQuery('#courseCategory').text();
	// Set Data Layer Variable
    var dataLayerArray = dataLayerArrayFunction();
	
	// Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'ContinueApplication_Failed';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
 	     
	}
	dataLayerArray['pageSubCategory'] = 'Top';
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	dataLayerArray['StudentEncryptedMobileNumber'] = StudentEncryptedMobileNumber;
	dataLayerArray['StudentEncryptedEmailID'] = StudentEncryptedEmailID;
	dataLayerArray['StudentName']= StudentName;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
}
function countiuneYourApplicationEventData(){
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'ContinueYourApplication';
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pagebundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'ApplicationSubmit_Enrollment';
	var StudentEncryptedMobileNumber = jQuery.md5(jQuery('#form-popup-wrapper :input[name="enqry_crsspndnc_mbl"]').val());
	var StudentEncryptedEmailID = jQuery.md5(jQuery('#form-popup-wrapper :input[name="enqry_crsspndnc_eml"]').val());
	var StudentName =  jQuery('#form-popup-wrapper :input[name="enqry_f_nm"]').val();
	var pageSubCategory = 'Top';
	var eventname = 'ContinueApplication_Success';
	var menu_url = jQuery(location).attr('href');
	var coursesubcategory = menu_url.split('/')[4];
    var pagename = menu_url.split('/')[5];
    var pagenametwo = menu_url.split('/')[6];
	var coursecode = jQuery('#pageCourseCode').text();
	var coursecategory = jQuery('#courseCategory').text();
	// Set Data Layer Variable
    var dataLayerArray = dataLayerArrayFunction();
	
	// Set Data Layer Variable
    dataLayerArray['ClientId'] = jQuery('#gaCookie').text();
    dataLayerArray['event'] = 'ContinueApplication_Success';//`Home_AN_${category.replace(/\s/g, '')}`;
	if(pagebundle == 'course'){
		dataLayerArray['PageName'] = `india:${coursesubcategory}:${pagename}:${pagenametwo}`;
	}
	if(pagebundle == 'course'){
		dataLayerArray['pageCategory'] = 'Program Detail Page';
 	     
	}
	dataLayerArray['pageSubCategory'] = 'Top';
    dataLayerArray['CourseCatogery'] = coursecategory;
    dataLayerArray['CourseType'] = jQuery('#pageModeOfDelevery').text();
    dataLayerArray['CourseFees'] = coursefeedetails;
	dataLayerArray['CourseCode'] = coursecode;
	dataLayerArray['StudentEncryptedMobileNumber'] = StudentEncryptedMobileNumber;
	dataLayerArray['StudentEncryptedEmailID'] = StudentEncryptedEmailID;
	dataLayerArray['StudentName']= StudentName;
	if(pagebundle == 'course'){
		dataLayerArray['CourseSubCatogery'] = coursesubcategory;
	}
	if(pagebundle == 'course'){
		dataLayerArray['CourseName'] = `${pagename}:${pagenametwo}`;
	}
   
	// Trigger dataLayer with Const Variable
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(dataLayerArray);
    /*jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {pageSubCategory: pageSubCategory, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails, StudentEncryptedMobileNumber:StudentEncryptedMobileNumber, StudentEncryptedEmailID:StudentEncryptedEmailID, StudentName:StudentName},
        success: function(response) {

         if(response) {
            var eventdata = encodeURI(JSON.stringify(response.data));
			//var eventdata = 'ContinueApplication_Success';
			jQuery('form.ContinueYourApplicationForm input[name="eventdata"]').val(eventdata);
			// window.dataLayer = window.dataLayer || [];
			// window.dataLayer.push(response.data);
			
		} else {
			console.log('Ajax Error');
			return false;
		}
	}
});*/
}
/*function countiuneYourApplicationEventDataForRedirectApplication(){
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'ContinueYourApplication';
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'ApplicationSubmit_Enrollment';
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

         if(response) {
            var eventdata = encodeURI(JSON.stringify(response.clientID));
            jQuery('form.ContinueYourApplicationForm input[name="eventdata"]').val(eventdata);
            document.getElementById("ContinueYourApplicationFormId").submit();
			// window.dataLayer = window.dataLayer || [];
			// window.dataLayer.push(response.data);
			
		} else {
			console.log('Ajax Error');
			return false;
		}
	}
});
}*/
function EnrollSubmitPreForm() {
// e.preventDefault();
var pageTitle = jQuery('#pageTitleAll').text();
var node_id = 'node_id/'+jQuery('#pageNodeId').text();
var menu_url = window.location.pathname;
var menu_text = 'Enroll Now';
var pageNodeId = jQuery('#pageNodeId').text();
var clientID = jQuery('#gaCookie').text();
var pageNodeBundle = jQuery('#pageNodeBundle').text();
var pageCourseCode = jQuery('#pageCourseCode').text();
var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
var coursefeedetails = jQuery('#coursefeedetails').text();
// var current_path = window.location.pathname;
var type = 'CourseDetails';
var CourseEnrollmentcheck = 1;

jQuery.ajax({
    url : GOOGLE_TAG_EVENT_DATALAYER_URL,
    type: 'POST',
    data: {CourseEnrollmentcheck: CourseEnrollmentcheck, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
    success: function(response) {
        if(response) {
         var eventdata = encodeURI(JSON.stringify(response.data));
         jQuery('input[name="eventdata"]').val(eventdata);
         window.dataLayer = window.dataLayer || [];
         window.dataLayer.push(response.data);

         jQuery('.not_display_continue .con-moduler-enrollnow').trigger('click');
     } else {
         console.log('Ajax Error');
         return false;
     }
 }
});
}

function continuetest() {
// e.preventDefault();
window.open('', 'TheWindow', "width=1280, height=720, left=100, top=50, resizable=yes, scrollbars=yes, modal=yes, alwaysRaised=yes");
var pageTitle = jQuery('#pageTitleAll').text();
var node_id = 'node_id/'+jQuery('#pageNodeId').text();
var menu_url = window.location.pathname;
var menu_text = 'Take Test';
var pageNodeId = jQuery('#pageNodeId').text();
var clientID = jQuery('#gaCookie').text();
var pageNodeBundle = jQuery('#pageNodeBundle').text();
var pageCourseCode = jQuery('#pageCourseCode').text();
var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
var coursefeedetails = jQuery('#coursefeedetails').text();
// var current_path = window.location.pathname;
var type = 'TakeTest';

jQuery.ajax({
    url : GOOGLE_TAG_EVENT_DATALAYER_URL,
    type: 'POST',
    data: {pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
    success: function(response) {
        if(response) {
         var eventdata = encodeURI(JSON.stringify(response.data));
         jQuery('input[name="eventdata"]').val(eventdata);
         window.dataLayer = window.dataLayer || [];
         window.dataLayer.push(response.data);

         document.getElementById('testaasest').submit();

                //   jQuery('.not_display_continue .continue-btn').trigger('click');
            } else {
             console.log('Ajax Error');
             return false;
         }
     }
 });
}

function enroll_modular_click(){
    var pageTitle = jQuery('#pageTitleAll').text();
    var node_id = 'node_id/'+jQuery('#pageNodeId').text();
    var menu_url = window.location.pathname;
    var menu_text = 'Enroll Now';
    var pageNodeId = jQuery('#pageNodeId').text();
    var current_path = window.location.pathname;
    var clientID = jQuery('#gaCookie').text();
    var pageNodeBundle = jQuery('#pageNodeBundle').text();
    var pageCourseCode = jQuery('#pageCourseCode').text();
    var pageModeOfDelevery = jQuery('#pageModeOfDelevery').text();
    var coursefeedetails = jQuery('#coursefeedetails').text();
    var type = 'CourseDetails';
    var CourseEnrollmentcheck = 1;
    jQuery.ajax({
        url : GOOGLE_TAG_EVENT_DATALAYER_URL,
        type: 'POST',
        data: {CourseEnrollmentcheck: CourseEnrollmentcheck, pageTitle: pageTitle, node_id : node_id, menu_text : menu_text, menu_url : menu_url, type : type, pageNodeId : pageNodeId, clientID : clientID, pageNodeBundle : pageNodeBundle, pageCourseCode: pageCourseCode, pageModeOfDelevery: pageModeOfDelevery, coursefeedetails:coursefeedetails},
        success: function(response) {

         if(response) {
            var eventdata = encodeURI(JSON.stringify(response.data));
            jQuery('input[name="eventdata"]').val(eventdata);

            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push(response.data);

        } else {
            console.log('Ajax Error');
            return false;
        }
    }
});
}

/**
* Get current page relative URL
*/
function getTabRelativeURL(){
    var pathName = window.location.pathname;
    return pathName.replace(/^\/|\/$/g, "").replace(/\//g, ":");
}
/**
* Get current page breadcrumbs
*/
function getBreadcrumbs(){
    var allBreadCrumbs = $(".page-breadcrumbs .breadcrumb li").map(function() {
        return $(this).text().trim();
    }).get();

    return allBreadCrumbs;
}    

if(jQuery('body').is(':visible')){
    jQuery.ajax({
        url : '/india/dataLayer_Event_Session_destroy',
        type: 'POST',
        success: function(response) {

        }
    });
};
///////////////////////////////////////////////
////////   GET Center Data     ////////////////
///////////////////////////////////////////////
if(jQuery('.iciciCourseCenterData').is(':visible')){
    var campaignCode = jQuery('#nodeCampaignCode').val();
    var CityName = jQuery('#iciciCenterCityName').val();
    jQuery.ajax({
        url : '/india/get_center_data_for_city_change_url',
        type: 'POST',
        data: {city: CityName, state: '', campaignCode: campaignCode},
        beforeSend: function(){
            jQuery('#job_loader').append('<center class="job_loader_load"><h3><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...</h3></center>');
        },
        success: function(response) {

            jQuery(".iciciCourseCenterData").replaceWith('<div class="iciciCourseCenterData">'+response.data+'</div>');
            jQuery('#job_loader').replaceWith('<div id="job_loader"></div>');
            jQuery('#exampleSlider-1').multislider({
                interval: false,
                slideAll: false,
                duration: 2000,
                autoSlide: false
            });
        }
    });
}
