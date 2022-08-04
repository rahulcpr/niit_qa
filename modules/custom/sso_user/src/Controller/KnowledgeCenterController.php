<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Drupal\user\Entity\User;
use Drupal\Core\Url; 
use Drupal\Core\Path\AliasManager;


class KnowledgeCenterController extends ControllerBase { 
    /**************************************
    ** Knowledge Center Search Page code **
    ***************************************/   
    public function KCSearchPage() {
    	$base_url = (isset($_ENV['DRUPAL_PROTOCOL_DOMAIN']) && !is_null($_ENV['DRUPAL_PROTOCOL_DOMAIN'] )) ? $_ENV['DRUPAL_PROTOCOL_DOMAIN']."/india/" : \Drupal::urlGenerator()->generateFromRoute('<front>', [], ['absolute' => TRUE]);
    	$path_to_theme = $base_url.'/'.\Drupal::theme()->getActiveTheme()->getPath();

    	$tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
    	 	$searchDataFields = [
                'module' => 'search',
                'keyword' => $_GET['keyword'],
                'token' => $token
            ];
        	
        	$searchDataArray = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($searchDataFields);
        }
    	return [
            '#title' => 'Search Page',
            '#theme' => 'kc_search_page',
            '#searchDataArray' => $searchDataArray,
            '#searchVal' => $_GET['keyword'],
            '#path_to_theme' => $path_to_theme,
            '#page_num' => 1,
        ];
    }
    /***********************************************
    ** Knowledge Center category search page code **
    ***********************************************/
    public function KCCategorySearchPage() {
        // print_r('hello');
        $base_url = (isset($_ENV['DRUPAL_PROTOCOL_DOMAIN']) && !is_null($_ENV['DRUPAL_PROTOCOL_DOMAIN'] )) ? $_ENV['DRUPAL_PROTOCOL_DOMAIN']."/india/" : \Drupal::urlGenerator()->generateFromRoute('<front>', [], ['absolute' => TRUE]);
        $path_to_theme = $base_url.'/'.\Drupal::theme()->getActiveTheme()->getPath();

        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            $searchDataFields = [
                'module' => 'related_content',
                'field' => 'cgrp',
                'val' => 'Article',
                'txn_id' => $_GET['category'],
                'token' => $token
            ];
            $searchDataArray = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($searchDataFields);
        }
        return [
            '#title' => 'Category Listing Page',
            '#theme' => 'kc_categorysearch_page',
            '#searchDataArray' => $searchDataArray,
            '#searchVal' => $_GET['category'],
            '#path_to_theme' => $path_to_theme,
            '#page_num' => 1,
        ];
    }

    /********************************************
    ** Knowledge Center Load More Article code **
    ********************************************/
    public function loadMoreGetArticleData() {
    	$requestField = \Drupal::request()->request;
	    $currentPage = $requestField->get('currentPage') + 1;
	    $totlePage = $requestField->get('totlePage');
	    $kcSearchType = $requestField->get('kcSearchType');
	    $searchVal = $requestField->get('searchVal');

	    $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            if($kcSearchType == 'Search'){
            	$searchDataFields = [
	                'module' => 'search',
	                'keyword' => $searchVal,
	                'token' => $token,
	                'page_num' => $currentPage
	            ];
            }else if($kcSearchType == 'Category'){
            	$searchDataFields = [
	                'module' => 'related_content',
	                'txn_id' => $searchVal,
	                'field' => 'cgrp',
                    'val' => 'Article',
	                'token' => $token,
	                'page' => $currentPage
	            ];
            }else{}
    	 	
        	$searchDataArray = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($searchDataFields);
        }

        foreach ($searchDataArray->data as $key => $value) {
        	$termName = '';
        	if(!empty($value->map_taxonomy[0]->value)){
        		$aliasManager = \Drupal::service('path.alias_manager');
	            $term_url = $aliasManager->getAliasByPath('/taxonomy/term/' . $value->map_taxonomy[0]->id);
	            $url = $_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india'.$term_url;
        		$termName = '<p class="kmcgbar"><a href="'.$url.'">'.$value->map_taxonomy[0]->value.'</a></p>';
        	}
        	// $authorDataFields = [
         //            'module' => 'content_data_by_id',
         //            'vid' => $value->athr,
         //            'token' => $token
         //        ];
         //    $authorData = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($authorDataFields);
            $authorName = '';
            $duration = '';
            if(!empty($value->athrinfo->nm)){
            	$authorName = ' · By &nbsp;'.$value->athrinfo->nm;
            }
            if(!empty($value->duration)){
            	$duration = ' · '.$value->duration;
            }
            $iconGenerate = \Drupal::service('niit_common.twig.TwigExtension')->generateIconWithText($value->scgrp);
        	$data .= '<div class="col-md-12 kc_articles_right">
		        <div class="imagebar">
		        	<div class="col-md-4 pl-0">
		          		<a href="'.$value->src.'"><img src="'.$value->img.'" alt="'.$value->ttl.'" class="img-responsive"></a>
		          	</div>
		          	<div class="col-md-8 pl-0">
		          <div class="kc_img_cap">
		            '.$termName.'
		            <h5><a href="'.$value->src.'">'.$value->ttl.'</a></h5>
		            <p class="art_para">'.strip_tags($value->dsc).'</p>
		            <p class="articlebar">'.$iconGenerate.' <b>'.$value->scgrp.'</b>'.$duration.''.$authorName.' </p>
		          </div>
		        </div>

		        </div>
		      </div>';
        }

    	$return = ['data' => $data, 'totlePage' => $totlePage, 'currentPage' => $currentPage];
    	return new JsonResponse($return);	
    }
    /*************************************
    ** Knowledge Center Event Page code **
    *************************************/
    public function KCEventsPage() {
        $base_url = (isset($_ENV['DRUPAL_PROTOCOL_DOMAIN']) && !is_null($_ENV['DRUPAL_PROTOCOL_DOMAIN'] )) ? $_ENV['DRUPAL_PROTOCOL_DOMAIN']."/india/" : \Drupal::urlGenerator()->generateFromRoute('<front>', [], ['absolute' => TRUE]);
        $path_to_theme = $base_url.'/'.\Drupal::theme()->getActiveTheme()->getPath();

        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');

        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            $urlDataSetArray = [
                'module' => 'search',
                'token' => $token,
                'page_num' => 1
            ];

            if(empty($_GET['evdgt'])){
                $_GET['evdgt'] = date('Y-m-d');
            }
            $fieldDataSetArray['query']['cgrp'] = "Event";
            if($_GET['scgrp'] && !empty($_GET['scgrp'])){
                $fieldDataSetArray['query']['scgrp'] = $_GET['scgrp'];
            }
            if($_GET['evtyp'] && !empty($_GET['evtyp'])){
                $fieldDataSetArray['query']['evtyp'] = $_GET['evtyp'];
                if($_GET['evtyp'] == 'schedule'){
                   $time = time();
                   $fieldDataSetArray['query']['range']['evd']['gt'] = $time;
                }
            }
            // if($_GET['evdgt'] && !empty($_GET['evdgt'])){
            //     $fieldDataSetArray['query']['range']['evd']['gt'] = strtotime($_GET['evdgt']);
                
            //     if($_GET['evdlt'] && !empty($_GET['evdlt'])){
            //         $fieldDataSetArray['query']['range']['evd']['lt'] = strtotime($_GET['evdlt']);
            //     }
            // }

            $searchDataArray =\Drupal::service('custom_campaign.niit_kc_services')->KMSSearchContentAPIforEvents($urlDataSetArray, json_encode($fieldDataSetArray));
        }
        return [
            '#title' => 'Event Listing Page',
            '#theme' => 'kc_events_page',
            '#searchDataArray' => $searchDataArray,
            '#searchValscgrp' => $_GET['scgrp'],
            '#searchValevtyp' => $_GET['evtyp'],
            '#searchValevdgt' => strtotime($_GET['evdgt']),
            '#searchValevdlt' => strtotime($_GET['evdlt']),
            '#path_to_theme' => $path_to_theme,
            '#page_num' => 1,
        ];
    }
    /******************************************
    ** Knowledge Center Event Load more code **
    ******************************************/
    public function loadMoreGetEventData() {
        $requestField = \Drupal::request()->request;
        $currentPage = $requestField->get('currentPage') + 1;
        $totlePage = $requestField->get('totlePage');
        $kcSearchType = $requestField->get('kcSearchType');
        $searchValscgrp = $requestField->get('searchValscgrp');
        $searchValevtyp = $requestField->get('searchValevtyp');
        // $searchValevdgt = $requestField->get('searchValevdgt');
        // $searchValevdlt = $requestField->get('searchValevdlt');

        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;

            $urlDataSetArray = [
                'module' => 'search',
                'token' => $token,
                'page_num' => $currentPage
            ];

            $fieldDataSetArray['query']['cgrp'] = "Event";
            if($searchValscgrp && !empty($searchValscgrp)){
                $fieldDataSetArray['query']['scgrp'] = $searchValscgrp;
            }
            if($searchValevtyp && !empty($searchValevtyp)){
                $fieldDataSetArray['query']['evtyp'] = $searchValevtyp;
                if($searchValevtyp == 'schedule'){
                   $time = time();
                   $fieldDataSetArray['query']['range']['evd']['gt'] = $time;
                }
            }
            // if($searchValevdgt && !empty($searchValevdgt)){
            //     $fieldDataSetArray['query']['range']['evd']['gt'] = $searchValevdgt;
                
            //     if($searchValevdlt && !empty($searchValevdlt)){
            //         $fieldDataSetArray['query']['range']['evd']['lt'] = $searchValevdlt;
            //     }
            // }

            $searchDataArray =\Drupal::service('custom_campaign.niit_kc_services')->KMSSearchContentAPIforEvents($urlDataSetArray, json_encode($fieldDataSetArray));
            
        }

        foreach ($searchDataArray->data as $key => $value) {
            $termName = '';
            if(!empty($value->map_taxonomy[0]->value)){
                $aliasManager = \Drupal::service('path.alias_manager');
                $term_url = $aliasManager->getAliasByPath('/taxonomy/term/' . $value->map_taxonomy[0]->id);
                $url = $_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india'.$term_url;
                $termName = '<p class="kmcgbar"><a href="'.$url.'">'.$value->map_taxonomy[0]->value.'</a></p>';
            }
            // $authorDataFields = [
            //         'module' => 'content_data_by_id',
            //         'vid' => $value->athr,
            //         'token' => $token
            //     ];
            // $authorData = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($authorDataFields);
            $authorName = '';
            $duration = '';
            if(!empty($value->athrinfo->nm)){
                $authorName = ' · By &nbsp;'.$value->athrinfo->nm;
            }
            if(!empty($value->duration)){
                $duration = ' · '.$value->duration;
            }
            $iconGenerate = \Drupal::service('niit_common.twig.TwigExtension')->generateIconWithText($value->scgrp);
            $data .= '<div class="col-md-12 kc_articles_right">
                <div class="imagebar">
                    <div class="col-md-4 pl-0">
                        <a href="'.$value->src.'"><img src="'.$value->img.'" alt="'.$value->ttl.'" class="img-responsive"></a>
                    </div>
                    <div class="col-md-8 pl-0">
                  <div class="kc_img_cap">
                    '.$termName.'
                    <h5><a href="'.$value->src.'">'.$value->ttl.'</a></h5>
                    <p class="art_para">'.strip_tags($value->dsc).'</p>
                    <ul class="datetimebar list-inline">
                        <li> <i class="fa fa-calendar-o"></i> &nbsp; '.date('l, jS F  Y', $value->evd).' </li>
                        <li> <i class="fa fa-clock-o"></i> &nbsp; '.date('g:i A', $value->evrdt).' - '.date('g:i A', $value->evrcdt).' </li>
                    </ul>
                    <p class="articlebar">'.$iconGenerate.' <b>'.$value->scgrp.'</b>'.$duration.''.$authorName.' </p>
                  </div>
                </div>

                </div>
              </div>';
        }

        $return = ['data' => $data, 'totlePage' => $totlePage, 'currentPage' => $currentPage];
        return new JsonResponse($return);   
    }
    /***************************************************
    ** Knowledge Center Onpage Load Bookmark Btn code **
    ****************************************************/
    public function onloadBookmarkBtnFunction(){
        $requestField = \Drupal::request()->request;
        $nodeId = $requestField->get('nodeId');
        $bmkText = $requestField->get('bmkText');
        if($bmkText == 'Yes'){
            $msg1 = 'Add To Bookmark';
            $msg2 = 'Remove Bookmark';
        }else{
            $msg1 = '';
            $msg2 = '';
        }
        $btn = '';
        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Post');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            $fields = [
                    'module' => 'content_data_by_id',
                    'vid' => $nodeId,
                    'token' => $token
                ];
            $bookmarkData = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($fields);
            if($bookmarkData->status == 1){
                if(!empty($bookmarkData->data)){
                    if($bookmarkData->data[0]->isWL == 1){
                        $btn = '<span class="bookmark-sec" isWL="false">
                                    '.$msg2.' <i class="fa fa-bookmark make-bookmark"></i>
                              </span>';
                    }else{
                        $btn = '<span class="bookmark-sec" isWL="true">
                                    '.$msg1.' <i class="fa fa-bookmark-o make-bookmark"></i>
                              </span>';
                    }
                }
            }
        }
        $return = ['data' => $btn];
        return new JsonResponse($return);
    }
    /***************************************************
    ** Knowledge Center Onclick Load Bookmark Btn code **
    ****************************************************/
    public function onClickBookmarkBtnFunction(){
        $requestField = \Drupal::request()->request;
        $nodeId = $requestField->get('nodeId');
        $categoryId = $requestField->get('categoryId');
        $isWL = $requestField->get('isWL');
        $bmkText = $requestField->get('bmkText');
        if($bmkText == 'Yes'){
            $msg1 = 'Add To Bookmark';
            $msg2 = 'Remove Bookmark';
        }else{
            $msg1 = '';
            $msg2 = '';
        }
        $btn = '';
        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Post');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            $urlDataSetArray = [
                'module' => 'update_bkm',
                'token' => $token
            ];
            $fieldDataSetArray = [
               'vId' => $nodeId,
               'isWL' => $isWL,
               'cId' => $categoryId,
            ];
            $contentCreateAPI = \Drupal::service('custom_campaign.niit_kc_services')->KMSSaveVote($urlDataSetArray, $fieldDataSetArray);
            if($contentCreateAPI->status == 1){
                if($isWL == 'true'){
                    $btn = '<span class="bookmark-sec" isWL = "false">
                                '.$msg2.' <i class="fa fa-bookmark make-bookmark"></i>
                          </span>';
                }else{
                    $btn = '<span class="bookmark-sec" isWL = "true">
                                '.$msg1.' <i class="fa fa-bookmark-o make-bookmark"></i>
                          </span>';
                }
            }
        }

        $return = ['data' => $btn];
        return new JsonResponse($return);
    }
    /*******************************************************
    ** Knowledge Center Rating and Comment code **
    *******************************************************/
    public function ratingAndCommentFunction(){
        $requestField = \Drupal::request()->request;
        $vId = $requestField->get('vId');
        $type = $requestField->get('type');

        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Post');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            if($type == 'ratingComment'){
                $rating = $requestField->get('rating');
                $comment = $requestField->get('comment');
                $urlDataSetArray = [
                    'module' => 'feedback',
                    'token' => $token
                ];
                $fieldDataSetArray = [
                   'vId' => $vId,
                   'rating' => $rating,
                   'comment' => $comment,
                ];
                $contentCreateAPI = \Drupal::service('custom_campaign.niit_kc_services')->KMSSaveVote($urlDataSetArray, $fieldDataSetArray);
                if($contentCreateAPI->status == 1){
                   $output = 1; 
                }
                $return = ['data' => $output];
            }else if($type == 'viewMoreComment'){
                $currentPage = $requestField->get('currentPage') + 1;
                $totlePage = $requestField->get('totlePage');
                $commentDataFields = [
                        'module' => 'get_data',
                        'type' => 'CANDR',
                        'vId' => $vId,
                        'token' => $token,
                        'page_num' => $currentPage
                    ];
                $result = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($commentDataFields);
                if($result->status == 1){
                    $output_data = '';
                    foreach ($result->data as $key => $value) {
                        $starRating = \Drupal::service('niit_common.twig.TwigExtension')->generateRatingStarIcons($value->rating);
                        $output_data .= '<div class="kc_pR_z article-comment-list mb-5">
                                        <div>
                                            <img src="/india/themes/custom/nexus/assets/images/comment-user.png">
                                            <label>'.$value->username.'</label>
                                        </div>
                                        <div class="user-rate">'.$starRating.'</div>
                                        <p>Reviewed on&nbsp;'.date('jS F  Y', $value->comment->dt).'</p>
                                        <p>'.$value->comment->c.'</p>
                                    </div>';
                    }
                    $return = ['data' => $output_data, 'totlePage' => $totlePage, 'currentPage' => $currentPage]; 
                }
            }
              
        }
        return new JsonResponse($return);
    }
    /***************************************
    ** Knowledge Center User Profile code **
    ****************************************/
    public function myPreferencesPageFunction(){
        // $token = '';
        // $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
        // if($tokenArray->status == 1){
        //     $token = $tokenArray->data->token;
        //     // Get Bookmark data Array
        //     $bookmarkDataFields = [
        //                 'module' => 'get_data',
        //                 'type' => 'BKM',
        //                 'token' => $token,
        //                 'page_num' => 1,
        //             ];
        //     $bookmarkDataArray = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($bookmarkDataFields);

            // $followingCategoryFields = [
            //             'module' => 'get-follow',
            //             'token' => $token
            //         ];
            // $followCategoryDataArray = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($followingCategoryFields);

        // }
        return [
            '#title' => 'My Preferences',
            // '#theme' => 'kc_mypreferences_page',
            // '#bookmarkDataArray' => $bookmarkDataArray,
            // '#followCategoryDataArray' => $followCategoryDataArray,
            // '#token' => $token,
        ];
    }
    /*****************************************
    ** Knowledge Center  Follow/Unfollow List code **
    *****************************************/
    public function KCMyPreferencesFollowingList(){
        $output_data = '';
        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            $followingCategoryFields = [
                        'module' => 'get-follow',
                        'token' => $token
                    ];
            $result = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($followingCategoryFields);

            $category_fields = [
                            'module' => 'get-follow',
                            'token' => $token
                    ];
            $category_data = [];
            $followCategoryArray = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($category_fields);
            if($followCategoryArray->status == 1){
                foreach ($followCategoryArray->data as $key => $value) {
                    if(!empty($value->txn_id)){
                        $category_data[$key] = $value->txn_id;
                    }
                }
            }
            
            // if($result->status == 1){
                if(!empty($result->data)){
                    $output_data .= '<ul class="kc_recentStories_right list-unstyled kc-bookmark-list">';
                    foreach ($result->data as $key => $value) {
                        if (in_array($value->txn_id, $category_data)){
                            $btn = '<a href="javascript:void(0);" class="kc-follow-btn" sts ="false">
                                    <i class="fa fa-minus-circle" aria-hidden="true"></i> <span class="follow-text">Un-Follow this category</span>
                                </a>';
                        }else{
                            $btn = '<a href="javascript:void(0);" class="kc-follow-btn" sts ="true">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> <span class="follow-text">Follow this category</span>
                                </a>';
                        }
                        $output_data .= '<li>
                                    <a href="'.$value->src.'">
                                      <img src="'.$value->img.'" alt="'.$value->txn_name.'">
                                    </a>
                                    <div class="rs-contect col-md-12 pr-5">
                                      <label><a href ="'.$value->src.'">'.$value->txn_name.'</a></label>
                                      <div class="articlebar">
                                        <div class="blog-post-follow-btn-2" category-Id="'.$value->txn_id.'">
                                        '.$btn.'
                                        </div>
                                      </div>
                                    </div>
                                  </li>';
                    }
                    $output_data .= '</ul>';
                }else{
                    $output_data .= '<ul class="kc_recentStories_right list-unstyled kc-bookmark-list">
                                    <li>** You are not following any category.</li>
                                </ul>';
                }
            // }
        }
        $return = ['data' => $output_data];
        return new JsonResponse($return);
    }
    /*****************************************
    ** Knowledge Center  Bookmark List code **
    *****************************************/
    public function KCMyPreferencesBookmarkList(){
        $output_data = '';
        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            $bookmarkDataFields = [
                    'module' => 'get_data',
                    'type' => 'BKM',
                    'token' => $token,
                    'page_num' => 1,
                ];
            $result = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($bookmarkDataFields);
            // if($result->status == 1){
                if(!empty($result->data)){
                    $output_data .= '<button class="btn btn-primary pull-right" id="clear-all-bookmark">Clear Bookmark list</button>
                            <div id="loading-section"></div>
                            <div id="user-bookmark-list">
                                <ul class="kc_recentStories_right list-unstyled kc-bookmark-list">';
                
                    foreach ($result->data as $key => $value) {
                        /*****************************************/
                        $termName = '';
                        if(!empty($value->map_taxonomy[0]->value)){
                            $aliasManager = \Drupal::service('path.alias_manager');
                            $term_url = $aliasManager->getAliasByPath('/taxonomy/term/' . $value->map_taxonomy[0]->id);
                            $url = $_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india'.$term_url;
                            $termName = '<span class="rsc-heading"><a href="'.$url.'">'.$value->map_taxonomy[0]->value.'</a></span>';
                        }
                        $authorName = '';
                        $duration = '';
                        if(!empty($value->athrinfo->nm)){
                            $authorName = ' · By &nbsp;'.$value->athrinfo->nm;
                        }
                        if(!empty($value->duration)){
                            $duration = ' · '.$value->duration;
                        }
                        $iconGenerate = \Drupal::service('niit_common.twig.TwigExtension')->generateIconWithText($value->scgrp);
                        $bookmark = '';
                        if($value->isWL == 1){
                            $bookmark = '<span class="kc-bookmark-btn" node-id="'.$value->vId.'" category-id="'.$value->map_taxonomy[0]->id.'" bmk-text="No">
                                        <span class="bookmark-sec" isWL="false">
                                            <i class="fa fa-bookmark make-bookmark"></i>
                                        </span>
                                    </span>';
                        }else{
                            $bookmark = '<span class="kc-bookmark-btn" node-id="'.$value->vId.'" category-id="'.$value->map_taxonomy[0]->id.'" bmk-text="No">
                                        <span class="bookmark-sec" isWL="true">
                                            <i class="fa fa-bookmark-o make-bookmark"></i>
                                        </span>
                                    </span>';
                        }
                        $output_data .= '<li>
                                            <a href="'.$value->src.'">
                                              <img src="'.$value->img.'" alt="'.$value->ttl.'">
                                            </a>
                                            <div class="rs-contect col-md-12 pr-5">
                                              '.$termName.'
                                              <label><a href ="'.$value->src.'">'.$value->ttl.'</a></label>
                                              <div class="articlebar">
                                              '.$iconGenerate.' <b>'.$value->scgrp.'</b>'.$duration.''.$authorName.' 
                                              '.$bookmark.'
                                              </div>
                                            </div>
                                          </li>';
                        /*****************************************/
                    }
                    $output_data .= '<div class="bmk-list-append-sec"></div>
                            </ul>
                            <div class="col-md-12 kc_articles_right" id="bmk-load-more">
                                <input type="hidden" id="bmkCurrentPageNumberCount" value="1">
                                <input type="hidden" id="bmkTotalPageNumberCount" value="'.$result->pages.'">
                                <div id="bmk-loading-section"></div>';
                                if($result->pages > 1){
                                    $output_data .= '<p class="text-center">
                                        <button class="viewResultListing_kc">VIEW MORE <i class="fa fa-chevron-down pl-2"></i> </button>
                                    </p>';
                                }
                    $output_data .=' </div>
                        </div>';
                }else{
                    $output_data .= '<div id="user-bookmark-list">
                                <ul class="kc_recentStories_right list-unstyled kc-bookmark-list">
                                    <li>** No Bookmark is available.</li>
                                </ul>
                            </div>';
                }
            // }
        }
        $return = ['data' => $output_data];
        return new JsonResponse($return);
    }
    /*********************************************
    ** Knowledge Center Load More Bookmark code **
    *********************************************/
    public function myProfileLoadMoreBookmark(){
        $requestField = \Drupal::request()->request;
        $currentPage = $requestField->get('currentPage') + 1;
        $totlePage = $requestField->get('totlePage');

        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            // Get Bookmark data Array
            $bookmarkDataFields = [
                        'module' => 'get_data',
                        'type' => 'BKM',
                        'token' => $token,
                        'page_num' => $currentPage,
                    ];
            $result = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($bookmarkDataFields);
            if($result->status == 1){
                $output_data = '';
                foreach ($result->data as $key => $value) {
                    $termName = '';
                    if(!empty($value->map_taxonomy[0]->value)){
                        $aliasManager = \Drupal::service('path.alias_manager');
                        $term_url = $aliasManager->getAliasByPath('/taxonomy/term/' . $value->map_taxonomy[0]->id);
                        $url = $_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india'.$term_url;
                        $termName = '<span class="rsc-heading"><a href="'.$url.'">'.$value->map_taxonomy[0]->value.'</a></span>';
                    }
                    // $authorData = \Drupal::service('niit_common.twig.TwigExtension')->getAuthorDataInKMS($value->athr);
                    $authorName = '';
                    $duration = '';
                    if(!empty($value->athrinfo->nm)){
                        $authorName = ' · By &nbsp;'.$authorData->data[0]->nm;
                    }
                    if(!empty($value->duration)){
                        $duration = ' · '.$value->duration;
                    }
                    $iconGenerate = \Drupal::service('niit_common.twig.TwigExtension')->generateIconWithText($value->scgrp);
                    $bookmark = '';
                    if($value->isWL == 1){
                        $bookmark = '<span class="kc-bookmark-btn-2" node-id="'.$value->vId.'" category-id="'.$value->map_taxonomy[0]->id.'" bmk-text="No">
                                    <span class="bookmark-sec" isWL="false">
                                        <i class="fa fa-bookmark make-bookmark"></i>
                                    </span>
                                </span>';
                    }else{
                        $bookmark = '<span class="kc-bookmark-btn-2" node-id="'.$value->vId.'" category-id="'.$value->map_taxonomy[0]->id.'" bmk-text="No">
                                    <span class="bookmark-sec" isWL="true">
                                        <i class="fa fa-bookmark-o make-bookmark"></i>
                                    </span>
                                </span>';
                    }
                    $output_data .= '<li>
                                        <a href="'.$value->src.'">
                                          <img src="'.$value->img.'" alt="'.$value->ttl.'">
                                        </a>
                                        <div class="rs-contect col-md-12 pr-5">
                                          '.$termName.'
                                          <label><a href ="'.$value->src.'">'.$value->ttl.'</a></label>
                                          <div class="articlebar">
                                          '.$iconGenerate.' <b>'.$value->scgrp.'</b>'.$duration.''.$authorName.' 
                                          '.$bookmark.'
                                          </div>
                                        </div>
                                      </li>';
                }
                $return = ['data' => $output_data, 'totlePage' => $totlePage, 'currentPage' => $currentPage]; 
            }
        }
        return new JsonResponse($return);
    }
    /******************************************************
    ** Knowledge Center User Profile clear bookmark list **
    ******************************************************/
    public function myProfileClearBookmarkList(){
        $output = 0;
        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            // Get Bookmark data Array
            $clearBookmarkData = [
                        'module' => 'empty_BKM',
                        'token' => $token
                    ];
            $bookmarkDataArray = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($clearBookmarkData);
            if($bookmarkDataArray->status == 1){
               $output = 1; 
               $msg = '<ul class="kc_recentStories_right list-unstyled kc-bookmark-list">
                        <li>**No Bookmark is available.</li>
                    </ul>';
                $return = ['data' => $output, 'msg' => $msg];
            }
        }
        
        return new JsonResponse($return);
    }
    /***********************************************************
    ** Knowledge Center Category Onload Follow Un-Follow code **
    ***********************************************************/
    public function categoryOnloadFollowUnfollow(){
        $current_user = \Drupal::currentUser();

        $requestField = \Drupal::request()->request;
        $categoryId = $requestField->get('cId');

        $finalCategoryArray = '';
        $btn = '';
        $category_data = [];

        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');

        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            // $cid = 'KMS:UserCategoryFollowData:'.$current_user->id();
            // if($cacheitem = \Drupal::cache()->get($cid)) {
            //     $cacheData = $cacheitem->data;
            //     $finalCategoryArray =  (array) $cacheData['data'];
            // }else{
                # set follow category in cache category Array Data
                $category_fields = [
                            'module' => 'get-follow',
                            'token' => $token
                    ];
                $followCategoryArray = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($category_fields);
                if($followCategoryArray->status == 1){
                    foreach ($followCategoryArray->data as $key => $value) {
                        if(!empty($value->txn_id)){
                            $category_data[$key] = $value->txn_id;
                        }
                    }
                    // $cid = 'KMS:UserCategoryFollowData:'.$current_user->id();
                    // $cacheObject = [
                    //     'data' => $category_data,
                    // ];
                    // \Drupal::cache()->set($cid, $cacheObject);
                    $finalCategoryArray = $category_data;
                }
            // }
            if (in_array($categoryId, $finalCategoryArray)){
                $btn = '<a href="javascript:void(0);" class="kc-follow-btn" sts ="false">
                        <i class="fa fa-minus-circle" aria-hidden="true"></i> <span class="follow-text">Un-Follow this category</span>
                    </a>';
            }else{
                $btn = '<a href="javascript:void(0);" class="kc-follow-btn" sts ="true">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> <span class="follow-text">Follow this category</span>
                    </a>';
            }
        }
        $return = ['data' => $btn, 'tokenArray' => $tokenArray];
        return new JsonResponse($return);
    }
    /***********************************************************
    ** Knowledge Center Category OnClick Follow Un-Follow code **
    ***********************************************************/
    public function categoryOnclickFollowUnfollow(){
        $current_user = \Drupal::currentUser();

        $requestField = \Drupal::request()->request;
        $categoryId = $requestField->get('cId');

        if($requestField->get('sts') == 'true'){
            $sts = 1; 
        }else if($requestField->get('sts') == 'false'){
           $sts = 0; 
        }

        $finalCategoryArray = '';
        $btn = '';
        $category_data = [];
        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
        if($tokenArray->status == 1){
            $token = $tokenArray->data->token;
            // Push Follow/Unfollow data in KMS
            $fields = [
                        'module' => 'follow',
                        'cid' => $categoryId,
                        'sts' => $sts,
                        'token' => $token
                    ];
            $apiResponse = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($fields);
            if($apiResponse->status == 1){
                # set follow category in cache category Array Data
                $category_fields = [
                            'module' => 'get-follow',
                            'token' => $token
                    ];
                $followCategoryArray = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($category_fields);
                if($followCategoryArray->status == 1){
                    foreach ($followCategoryArray->data as $key => $value) {
                        if(!empty($value->txn_id)){
                            $category_data[$key] = $value->txn_id;
                        }
                    }
                    // $current_user = \Drupal::currentUser();
                    // $cid = 'KMS:UserCategoryFollowData:'.$current_user->id();
                    // $cacheObject = [
                    //     'data' => $category_data,
                    // ];
                    // \Drupal::cache()->set($cid, $cacheObject);
                
                    $finalCategoryArray = $category_data;
                }
            }         
            
            if (in_array($categoryId, $finalCategoryArray)){
                $btn = '<a href="javascript:void(0);" class="kc-follow-btn" sts ="false">
                        <i class="fa fa-minus-circle" aria-hidden="true"></i> <span class="follow-text">Un-Follow this category</span>
                    </a>';
            }else{
                $btn = '<a href="javascript:void(0);" class="kc-follow-btn" sts ="true">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> <span class="follow-text">Follow this category</span>
                    </a>';
            }

        }
        $return = ['data' => $btn];
        return new JsonResponse($return);
    }
    /**********************************************************
    ** Knowledge Center Article Detail Page Star Rating Code **
    **********************************************************/
    public function articleStarRatingAppend(){
        $requestField = \Drupal::request()->request;
        $nodeId = $requestField->get('nodeId');

        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
        $token = $tokenArray->data->token;
        $authorDataFields = [
                'module' => 'content_data_by_id',
                'vid' => $nodeId,
                'token' => $token
            ];
        $result = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($authorDataFields);
        if($result->status == 1){
            $starRating = \Drupal::service('niit_common.twig.TwigExtension')->generateRatingStarIcons($result->data[0]->avgRating);
            if(!empty($result->data[0]->avgRating)){
                $output = '<p class="article-rating-star">'.$starRating.'</p>
                            <p class="article-rating-txt"><span>'.$result->data[0]->avgRating.'/5</span> OVERALL RATING</p>';
            }else{
                $output = '<p class="article-rating-star">'.$starRating.'</p>
                            <p class="article-rating-txt"><span>Be the first to comment.</p>';
            }
            
        }
        $return = ['data' => $output];
        return new JsonResponse($return);
    }
    public function wiproPageSupersetIdCheck(){
        $requestField = \Drupal::request()->request;
        $superSetId = $requestField->get('superSetId');
        $database = \Drupal::database();
        $query = $database->select('wipro_superset_id','t');
        $query->fields('t', array('email', 'supersetid'));
        $query->condition('t.supersetid', $superSetId, '=');
        $result = $query->execute()->fetchAll();
        if(!empty($result)){
            $output =  "verified";
        }else{
            $output =  'invalid';
        }
        $return = ['data' => $output];
        return new JsonResponse($return);
    }
    /**********************************************************
    ** Application form auto Redirect Loader Sec code **
    **********************************************************/
    public function autoRedirectLoaderSec($nid){
        $reffer_array = explode('?', $_SERVER['HTTP_REFERER']);
        $readUrl = "";
        if(!empty($reffer_array)){
          $query_string = explode('&', $reffer_array[1]);
          foreach($query_string as $val){
            if(strtolower($val) == 'read=y'){
              $readUrl = "Y";
            }
          }
        }
        if ($readUrl == 'Y') {
            $loaderEnable = "";
            $output = "";
        }else{
            if (!empty($nid)) {
                $current_user = \Drupal::currentUser();
                $node_data = Node::load($nid);
                $ContentTypeName = $node_data->bundle();
                $ContentTitle = $node_data->getTitle();
                // $nid = $node->id();
                
                $loaderEnable = "";

                if($node_data->bundle() == 'course'){

                    // $variables['loaderEnable'] = "";
                    if($current_user->id() > 0){
                        $currentUserid = $current_user->id();
                        $campaignCode = $node_data->field_campaign_code->value; 
                        $courseCode = $node_data->field_course_code->value;
                        $course_template_type = $node_data->field_select_template->value;
                        if($course_template_type == "course_axis"){
                            $divClass = "course_axis_cls";
                        }else if($course_template_type == "course_icici"){
                            $divClass = "course_icici_cls";
                        }else{
                            $divClass = "";
                        }
                        $finalResult = application_form_status($campaignCode, $courseCode, $currentUserid, 'current_user');
                        if($finalResult['check_eligibility'] == 'Y'){
                            if($finalResult['applctn_opn'] == 'Y'){
                                if($_REQUEST['read'] == "Y"){
                                    $loaderEnable = "hide";
                                    $output = "";
                                }else{
                                    $loaderEnable = "show";
                                    $output = '<div class="a loader '.$divClass.'" id="dv_loader" style="--n: 5;" loaderEnable="show">
                                        <div class="dot" style="--i: 0;"></div>
                                        <div class="dot" style="--i: 1;"></div>
                                        <div class="dot" style="--i: 2;"></div>
                                        <div class="dot" style="--i: 3;"></div>
                                        <div class="dot" style="--i: 4;"></div>
                                    </div>';
                                }
                            }
                        }  
                    }
                }
            }
        }
        
        $return = ['data' => $output, 'loaderEnable' => $loaderEnable];
        return new JsonResponse($return);
    }


}