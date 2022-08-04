<?php
    
    namespace Drupal\niit_common;
    use Drupal\node\Entity\Node;
    use Drupal\taxonomy\Entity\Term;
    use Drupal\views\Plugin\views\query\QueryPluginBase;
    use Drupal\Core\Url;
    use Drupal\user\Entity\User;
    use Twig\Extra\Intl\IntlExtension;
    /**
     * Class DefaultService.
     *
     * @package Drupal\demo_module
     */
    class TwigExtension extends \Twig_Extension {
        
        /**
         * {@inheritdoc}
         * This function must return the name of the extension. It must be
         * unique.
         */
        public function getName() {
            return 'block_display';
        }
        
        /**
         * In this function we can declare the extension function.
         */
        public function getFunctions() {
            return [
                new \Twig_SimpleFunction( 'getCourseData', [
                    $this,
                    'getCourseData',
                ], ['is_safe' => ['html']] ),
                new \Twig_SimpleFunction( 'getAuthorDataInKMS', [
                    $this,
                    'getAuthorDataInKMS',
                ], ['is_safe' => ['html']] ),
                new \Twig_SimpleFunction( 'getArticleDataInKMS', [
                    $this,
                    'getArticleDataInKMS',
                ], ['is_safe' => ['html']] ),
                new \Twig_SimpleFunction( 'generateTaxonomyUrl', [
                    $this,
                    'generateTaxonomyUrl',
                ], ['is_safe' => ['html']] ),
                new \Twig_SimpleFunction( 'generateCategoryBreadcrumb', [
                    $this,
                    'generateCategoryBreadcrumb',
                ], ['is_safe' => ['html']] ),
                new \Twig_SimpleFunction( 'generateIconWithText', [
                    $this,
                    'generateIconWithText',
                ], ['is_safe' => ['html']] ),
                new \Twig_SimpleFunction( 'generateRatingStarIcons', [
                    $this,
                    'generateRatingStarIcons',
                ], ['is_safe' => ['html']] ),
                new \Twig_SimpleFunction( 'getArticleCommentRating', [
                    $this,
                    'getArticleCommentRating',
                ], ['is_safe' => ['html']] ),
                new \Twig_SimpleFunction( 'getNextPrevUrlKCBlog', [
                    $this,
                    'getNextPrevUrlKCBlog',
                ], ['is_safe' => ['html']] ),
				new \Twig_SimpleFunction( 'generateCourseCardSec', [
                    $this,
                    'generateCourseCardSec',
                ], ['is_safe' => ['html']] ),
                new \Twig_SimpleFunction( 'generateEnrollNowAndAccessBtn', [
                    $this,
                    'generateEnrollNowAndAccessBtn',
                ], ['is_safe' => ['html']] ),
				new \Twig_SimpleFunction( 'getTopCourseCategoryBannerCounter', [
                    $this,
                    'getTopCourseCategoryBannerCounter',
                ], ['is_safe' => ['html']] ),
            ];
        }
        
        /*
		 * This function is used to return alt of an image
		* Set image title as alt.
		*/
        public function generateEnrollNowAndAccessBtn($nodeId, $courseCode, $btnTxt1, $btnTxt2, $pageType){
            $uid = \Drupal::currentUser()->id();
            $user = \Drupal\user\Entity\User::load($uid);
            $userCustomerId = $user->get('field_customer_id')->value;

            //$getEnrollmentData = json_decode(file_get_contents('https://qa.training.com/DigitalApi/api/digital/enrollment/v1/customer/'.$userCustomerId.'/program/'.$courseCode));
             $getEnrollmentData = json_decode(file_get_contents($_ENV['DOMAIN_TRAINING_COM'].'DigitalApi/api/digital/enrollment/v1/customer/'.$userCustomerId.'/program/'.$courseCode));

            if(!empty($getEnrollmentData->Data) && $getEnrollmentData->TotalRecords > 0 && $uid > 0){
                $stackathonLeadFormBtn = '<a href="javascript:void(0);" class="clsOpenMyBatchesLink StackathonLeadFormBtn" user_cid="'.$userCustomerId.'"><span class="btn btn-primary btnApply">'.$btnTxt1.'</span></a>';
                $stackathonLeadForm = '';
            }else{
                if($pageType == 'DetailPage'){
                    $stackathonLeadFormBtn = '<a href="javascript:void(0);" class="StackathonLeadFormBtn"  data-toggle="modal" data-target="#StackathonLeadForm">
                       <span class="btn btn-primary btnApply">'.$btnTxt2.'</span>

                      </a>';
                    $stackathonLeadForm = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\StackathonLeadForm', $nodeId);
                    $stackathonLeadForm = '<div id="StackathonLeadForm" class="modal fade leadLightBox StackathonLeadFormCls" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <button type="button" class="close leadCusCloseBtn" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>  
                          <div class="modal-body p-0">
                             '.render($stackathonLeadForm).'
                          </div>
                        </div>
                      </div>
                    </div>';
                }else if($pageType == 'LandingPage'){
                    $stackathonLeadForm = "";
                    $stackathonLeadFormBtn = '<a href="javascript:void(0);" class="sp_enrollNow col-md-12" node-id="'.$nodeId.'" onclick="stackathonform_popup('.$nodeId.');">'.$btnTxt2.'</a>';
                }else {
                    $stackathonLeadForm = "";
                    $stackathonLeadFormBtn = "";
                }
                
            }   
            $output = [];
            $output['stackathonLeadForm'] = $stackathonLeadForm;
            $output['stackathonLeadFormBtn'] = $stackathonLeadFormBtn;
            return !empty( $output ) ? $output : '';
        }
		public function generateCourseCardSec($item) {
            // Get current alias path based on language.
            $result = !empty( $item ) ? views_embed_view( 'home_page', 'block_3', $item ) : '';
            
            return !empty( $result ) ? $result : '';
        }
        public function getNextPrevUrlKCBlog($nid, $tid){
            
            if(!empty($nid) && !empty($tid)){
                $cid = 'KMS:GetDetailPageNextPrevLink:'.$nid;

                if ($cacheitem = \Drupal::cache()->get($cid)) {

                    $cacheData = $cacheitem->data;
                    return  $cacheData['data'];
                    
                }
                else{

                    $ratingQuery = \Drupal::entityQuery('node');
                    $ratingQuery->condition('type', 'blog_post');
                    $ratingQuery->condition('field_categories', $tid);
                    $ratingQuery->condition('status', 1);
                    $ratingNodeIds = $ratingQuery->execute();
                    $node_ids = array_values($ratingNodeIds);
                    $current_node = array_search($nid, $node_ids);
                    $prev_node = $node_ids[$current_node-1];
                    $next_node = $node_ids[$current_node+1];
                    if(!empty($prev_node)){
                        $nodeData = Node::load($prev_node);
                        $nodeTitle = $nodeData->getTitle();

                        $node_alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$prev_node);
                        // $host_url = \Drupal::request()->getSchemeAndHttpHost();
                        // $pre_url = $host_url.''.$node_alias;
                        
                        $prev_url = $_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india'.$node_alias;

                        $prev_url_link = '<label> <a href ="'.$prev_url.'" class="pre_article_link"> <i class="fa fa-angle-left" aria-hidden="true"></i> PREV</a> <span> '.$nodeTitle.' </span> </label>';

                    }
                    if(!empty($next_node)){
                        $nodeData = Node::load($next_node);
                        $nodeTitle = $nodeData->getTitle();

                        $node_alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$next_node);
                        // $host_url = \Drupal::request()->getSchemeAndHttpHost();
                        // $pre_url = $host_url.''.$node_alias;
                        
                        $next_url = $_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india'.$node_alias;
                        $next_url_link = '<label> <span> '.$nodeTitle.' </span> <a href ="'.$next_url.'" class="next_article_link"> NEXT <i class="fa fa-angle-right" aria-hidden="true"></i></a></label>';
                    }
                    $output = '<div class="row next-pre mt-4">
                                <div class="col-md-12 pre">'.$prev_url_link.'</div>              
                                <div class="pre col-md-12 text-right mt-4 m-mt5px">'.$next_url_link.'</div>              

                            </div>';

                    $cacheObject = [
                        'data' => $output,
                    ];
                    \Drupal::cache()->set($cid, $cacheObject);
                    return !empty( $output ) ? $output : '';

                }

            }
        }
        public function generateRatingStarIcons($rating){
            if(!empty($rating)){
                if($rating > 0 && $rating < 1){
                    $output .= '<i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                }elseif($rating == 1){
                    $output .= '<i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                }
                elseif($rating > 1 && $rating < 2){
                    $output .= '<i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                }
                elseif($rating == 2){
                    $output .= '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                }
                elseif($rating > 2 && $rating < 3){
                    $output .= '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                }
                elseif($rating == 3){
                    $output .= '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
                }
                elseif($rating > 3 && $rating < 4){
                    $output .= '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i>';
                }
                elseif($rating == 4){ 
                    $output .= '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>';
                }
                elseif($rating > 4 && $rating < 5){
                    $output .= '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i>';
                }
                elseif($rating == 5){
                    $output .= '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
                }
            }else{
                $output .= '<i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
            }
            $result = $output;
            return !empty( $result ) ? $result : '';
        }
        public function generateIconWithText($text){
            if($text == 'Videos'){
                $output = "<i class='fa fa-play-circle'></i>";
            }else if($text == 'Audio'){
                $output = "<i class='fa fa-headphones'></i>";
            }else{
                $output = "<i class='fa fa-book'></i>";
            }
            $result = $output;
            return !empty( $result ) ? $result : '';
        }
        public function generateTaxonomyUrl($item){
            $aliasManager = \Drupal::service('path.alias_manager');
            $term_url = $aliasManager->getAliasByPath('/taxonomy/term/' . $item);
            $result = $_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india'.$term_url;
            return !empty( $result ) ? $result : '';
        }
        public function generateCategoryBreadcrumb($termId, $all_links){
            $ancestors = \Drupal::service('entity_type.manager')->getStorage("taxonomy_term")->loadAllParents($termId);
            $list = [];
            foreach ($ancestors as $term) {
              $list[$term->id()]['nm'] = $term->label();
              $list[$term->id()]['id'] = $term->id();
            }
            $output = '';
            foreach (array_reverse($list) as $key => $value) {
                $aliasManager = \Drupal::service('path.alias_manager');
                $term_url = $aliasManager->getAliasByPath('/taxonomy/term/' . $value['id']);
                $url = $_ENV['DRUPAL_PROTOCOL_DOMAIN'].'/india'.$term_url;
                if($all_links == 'Y'){
                    $output .='<li><a href="'.$url.'">'.$value['nm'].'</a></li>';
                }else{
                    if($value['id'] != $termId){
                        $output .='<li><a href="'.$url.'">'.$value['nm'].'</a></li>';
                    }else{
                        $output .='<li>'.$value['nm'].'</li>';
                    }
                }
                
                
            }
            return !empty( $output ) ? $output : '';
        }
        public function getCourseData($item) {
            // Get current alias path based on language.
            $result = !empty( $item ) ? views_embed_view( 'related_courses', 'get_courses_in_menu', $item ) : '';
            
            return !empty( $result ) ? $result : '';
        }
      
        public function getAuthorDataInKMS($item) {
            $cid = 'KMS:GetAuthor:'.$item;

            if ($cacheitem = \Drupal::cache()->get($cid)) {

                $cacheData = $cacheitem->data;
                return  (array) $cacheData['data'];
                
            }
            else{

                $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
                $token = $tokenArray->data->token;
                $authorDataFields = [
                        'module' => 'content_data_by_id',
                        'vid' => $item,
                        'token' => $token
                    ];
                $result = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($authorDataFields);

                $cacheObject = [
                    'data' => $result,
                ];
                \Drupal::cache()->set($cid, $cacheObject);
                
                return !empty( $result ) ? $result : '';

            }

        }
        public function getArticleDataInKMS($item) {

            $cid = 'KMS:GetArticle:'.$item;
            if ($cacheitem = \Drupal::cache()->get($cid)) {

                $cacheData = $cacheitem->data;
                return  (array) $cacheData['data'];

            }
            else{

                $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
                $token = $tokenArray->data->token;
                $authorDataFields = [
                        'module' => 'related_content',
                        'txn_id' => $item,
                        'field' => 'cgrp',
                        'val' => 'Article',
                        'order_by' => 'order_by',
                        'token' => $token 
                    ];
                $result = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($authorDataFields);

                $cacheObject = [
                    'data' => $result,
                ];
                \Drupal::cache()->set($cid, $cacheObject);
                
                return !empty( $result ) ? $result : '';

            }
            
        }
        public function getArticleCommentRating($vId){
            $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Get');
            $token = $tokenArray->data->token;
            $authorDataFields = [
                    'module' => 'get_data',
                    'type' => 'CANDR',
                    'vId' => $vId,
                    'token' => $token,
                    'page_num' => 1
                ];
            $result = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICallMethod($authorDataFields);
            return !empty( $result ) ? $result : '';
        }
		
		/**
         * get Top Course Category Banner Counter
         */
        public function getTopCourseCategoryBannerCounter($nodeId) {
            $count = 0;    
            $query = \Drupal::entityQuery('node');
            $query->condition('type', 'course');
            $query->condition('field_top_course_category', $nodeId);
            $query->condition('status', 1);
            $nodeIds = $query->execute();
            if($nodeIds) {
                $count = count($nodeIds);
            }
            return $count;
        } 
    }
