<?php
namespace Drupal\niit_search_api\Plugin\rest\resource;
use Drupal\node\Entity\Node;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\CacheableResponseInterface;
use Drupal\user\Entity\User;
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;
use Drupal\taxonomy\Entity\Term;
/**
 * Annotation for get method
 *
 * @RestResource(
 *   id = "niit_allsearch",
 *   label = @Translation("niit all search data"),
 *   uri_paths = {
 *     "canonical" = "/get/api/allsearch/data"
 *   }
 * )
 */
class Allsearchdata extends ResourceBase
{
    /**
     * A current user instance.
     *
     * @var \Drupal\Core\Session\AccountProxyInterface
     */
    protected $currentUser;
    /**
     * Constructs a Drupal\rest\Plugin\ResourceBase object.
     *
     * @param array $configuration
     *   A configuration array containing information about the plugin instance.
     * @param string $plugin_id
     *   The plugin_id for the plugin instance.
     * @param mixed $plugin_definition
     *   The plugin implementation definition.
     * @param array $serializer_formats
     *   The available serialization formats.
     * @param \Psr\Log\LoggerInterface $logger
     *   A logger instance.
     * @param \Drupal\Core\Session\AccountProxyInterface $current_user
     *   A current user instance.
     */
    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        array $serializer_formats,
        LoggerInterface $logger,
        AccountProxyInterface $current_user)
    {
	parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
	$this->currentUser = $current_user;
    }
    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->getParameter('serializer.formats'),
            $container->get('logger.factory')->get('niit_search_api'),
            $container->get('current_user')
        );
    }
    /**
     * Responds to GET requests.
     *
     * Returns a list of bundles for specified entity.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
	public function get() {

    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
		if (!$this->currentUser->hasPermission('access content')) {
			throw new AccessDeniedHttpException();
		}
		$parameters = \Drupal::request()->get('key');
		//$k= array();
    	$k=$parameters;
		if(!empty($parameters)){
		
		$parquery = \Drupal::entityQuery('node')
    	->condition('type', 'course')
    	->condition('title', $k,'CONTAINS');
		
    	$parresult = $parquery->execute();
    	$parnid = \Drupal::entityManager()->getStorage('node')->loadMultiple($parresult);
	}else{
	
	    if($cat_tidone=426){
		$query_first = \Drupal::entityQuery('node')
        ->condition('type', 'course')
		->condition('field_course_', $cat_tidone)
        ->groupBy("field_course_")
		->range(0,5);
		$resultone = $query_first->execute();
		
		$nidone = \Drupal::entityManager()->getStorage('node')->loadMultiple($resultone);
	}if($cat_tid=427){
		$query = \Drupal::entityQuery('node')
        ->condition('type', 'course')
		->condition('field_course_', $cat_tid)
        ->groupBy("field_course_")
		->range(0,5);
		$result = $query->execute();
		
		$nid = \Drupal::entityManager()->getStorage('node')->loadMultiple($result);
	}
	if($cat_tidsec=428){
		$querysec = \Drupal::entityQuery('node')
        ->condition('type', 'course')
		->condition('field_course_', $cat_tidsec)
        ->groupBy("field_course_")
		->range(0,5);
		$resultsec = $querysec->execute();
		
		$nidsec = \Drupal::entityManager()->getStorage('node')->loadMultiple($resultsec);
	}
	if($cat_tidthird=432){
		$querythird = \Drupal::entityQuery('node')
        ->condition('type', 'course')
		->condition('field_course_', $cat_tidthird)
        ->groupBy("field_course_")
		->range(0,5);
		$resultthird = $querythird->execute();
		
		$nidthird = \Drupal::entityManager()->getStorage('node')->loadMultiple($resultthird);
	}
	}
		
	

        $data = [];
		//$clasa = (object) array();
		
		if($nidone){ // main condition for Block 1
		   // $i = 0;
			foreach($nidone as $key => $value){
			$data[0]['section_name'] = $category;
			$data[0]['record'] = count($nidone);
		 
			if($value->get('field_course_newly_star_rating')->value <= 5 && !empty($value->get('field_course_newly_star_rating')->value)){
                                                  $starval = $value->get('field_course_newly_star_rating')->value.'/5';
                                                  $course_type = 'Popular';
                                                }elseif($value->get('field_course_newly_star_rating')->value > 0 && !empty($value->get('field_course_newly_star_rating')->value)){
                                                  $starval = $value->get('field_course_newly_star_rating')->value.'/5';
                                                  $course_type = 'Trending';
                                                }else{
													
													 $starval = '0/5';
													 $course_type = '';
												}
				if(is_null($value->get('field_course_video_review')->getValue()[0]['input'])){
							$vlink =  '';
						
						}else{
							//$vlink =  '';
							$vlink = $value->get(field_course_video_review)->getValue()[0]['input'];
						}
						if($value->get('field_course_type_icon')->getValue()[0]['target_id']){
							$ctype_icon = $value->get('field_course_type_icon')->getValue()[0]['target_id'];
		                    $file1 = File::load($ctype_icon);
		                    $courseicon = $file1->url();
						
						}else{
							$courseicon = '';
						}
						if($value->get('field_course_center_code')->getValue()[0]['target_id']){
							$ctype = $value->get('field_course_center_code')->getValue()[0]['target_id'];
							$node = node_load($ctype);
                              $n=$node->title->value;
						
						}else{
							$n = '';
						}
						$tid = $value->get("field_course_")->getValue()[0]["target_id"];
				if($tid){
                  $term = Term::load($tid);
                  $category = $term->label();
				} else {
					  
					  $category ='';
				}if($value->get('field_course_summary')->value){
                  $descrption = $value->get('field_course_summary')->value;
				} else {
					  
					  $descrption ='';
				}if($value->get('field_select_template')->value){
                  $select_template = $value->get('field_select_template')->value;
				} else {
					  
					  $select_template ='';
				}
				if($value->get('field_campaign_code')->value){
                  $campaign_code = $value->get('field_campaign_code')->value;
				} else {
					  
					  $campaign_code ='';
				}
				if($value->get('field_center_list')->value){
                  $center_list = $value->get('field_center_list')->value;
				} else {
					  
					  $center_list ='';
				}

		 
			$data[0]['list'][] = [
						'nodeid' => $value->id(),
						'title' => $value->title->value,
						'descrption' => $descrption,
						'intro_videos' => $vlink,
						'star' => $starval,
						'course_type' => $course_type,
						'course_image' => file_create_url($value->get('field_course_image')->entity->getFileUri('url')),
						'course_duration' => $value->get('field_course_duration')->value,
						'course_icon' => $courseicon,
						'select_template' => $select_template,
						'campaign_code' => $campaign_code,
						'center_code' =>  $n,
						'center_list' => $center_list,
						'course_category' => $category,
						//'normaltesing' => 'gfd',
					
			];
		
			//$i++;			
		
					
			}
			$output['status'] = "200";
			$output['message'] = 'data found';
			$output['data'] = $data;
		}else{
			$output['status'] = "200";
			$output['message'] = 'No data found';
			$output['data'] = [];
		}
		if($nid){ // main condition for Block 1
			foreach($nid as $key => $value){
			$data[1]['section_name'] = $category;
			$data[1]['record'] = count($nid);
		 
			if($value->get('field_course_newly_star_rating')->value <= 5 && !empty($value->get('field_course_newly_star_rating')->value)){
                                                  $starval = $value->get('field_course_newly_star_rating')->value.'/5';
                                                  $course_type = 'Popular';
                                                }elseif($value->get('field_course_newly_star_rating')->value > 0 && !empty($value->get('field_course_newly_star_rating')->value)){
                                                  $starval = $value->get('field_course_newly_star_rating')->value.'/5';
                                                  $course_type = 'Trending';
                                                }else{
													
													 $starval = '0/5';
													 $course_type = '';
												}
				if(is_null($value->get('field_course_video_review')->getValue()[0]['input'])){
							$vlink =  '';
						
						}else{
							//$vlink =  '';
							$vlink = $value->get(field_course_video_review)->getValue()[0]['input'];
						}
						if($value->get('field_course_type_icon')->getValue()[0]['target_id']){
							$ctype_icon = $value->get('field_course_type_icon')->getValue()[0]['target_id'];
		                    $file1 = File::load($ctype_icon);
		                    $courseicon = $file1->url();
						
						}else{
							$courseicon = '';
						}
						if($value->get('field_course_center_code')->getValue()[0]['target_id']){
							$ctype = $value->get('field_course_center_code')->getValue()[0]['target_id'];
							$node = node_load($ctype);
                              $n=$node->title->value;
						
						}else{
							$n = '';
						}
						$tid = $value->get("field_course_")->getValue()[0]["target_id"];
				if($tid){
                  $term = Term::load($tid);
                  $category = $term->label();
				} else {
					  
					  $category ='';
				}if($value->get('field_course_summary')->value){
                  $descrption = $value->get('field_course_summary')->value;
				} else {
					  
					  $descrption ='';
				}if($value->get('field_select_template')->value){
                  $select_template = $value->get('field_select_template')->value;
				} else {
					  
					  $select_template ='';
				}
				if($value->get('field_campaign_code')->value){
                  $campaign_code = $value->get('field_campaign_code')->value;
				} else {
					  
					  $campaign_code ='';
				}
				if($value->get('field_center_list')->value){
                  $center_list = $value->get('field_center_list')->value;
				} else {
					  
					  $center_list ='';
				}

		 
			$data[1]['list'][] = [
						'nodeid' => $value->id(),
						'title' => $value->title->value,
						'descrption' => $descrption,
						'intro_videos' => $vlink,
						'star' => $starval,
						'course_type' => $course_type,
						'course_image' => file_create_url($value->get('field_course_image')->entity->getFileUri('url')),
						'course_duration' => $value->get('field_course_duration')->value,
						'course_icon' => $courseicon,
						'select_template' => $select_template,
						'campaign_code' => $campaign_code,
						'center_code' =>  $n,
						'center_list' => $center_list,
						'course_category' => $category,
						//'normaltesing' => 'gfd',
					
			];
		
			//$j++;			
		
					
			}
			$output['status'] = "200";
			$output['message'] = 'data found';
			$output['data'] = $data;
		}else{
			$output['status'] = "200";
			$output['message'] = 'No data found';
			$output['data'] = [];
		}
		if($nidsec){ // main condition for Block 1
		    
			foreach($nidsec as $key => $value){
			$data[2]['section_name'] = $category;
			$data[2]['record'] = count($nidsec);
		 
			if($value->get('field_course_newly_star_rating')->value <= 5 && !empty($value->get('field_course_newly_star_rating')->value)){
                                                  $starval = $value->get('field_course_newly_star_rating')->value.'/5';
                                                  $course_type = 'Popular';
                                                }elseif($value->get('field_course_newly_star_rating')->value > 0 && !empty($value->get('field_course_newly_star_rating')->value)){
                                                  $starval = $value->get('field_course_newly_star_rating')->value.'/5';
                                                  $course_type = 'Trending';
                                                }else{
													
													 $starval = '0/5';
													 $course_type = '';
												}
				if(is_null($value->get('field_course_video_review')->getValue()[0]['input'])){
							$vlink =  '';
						
						}else{
							//$vlink =  '';
							$vlink = $value->get(field_course_video_review)->getValue()[0]['input'];
						}
						if($value->get('field_course_type_icon')->getValue()[0]['target_id']){
							$ctype_icon = $value->get('field_course_type_icon')->getValue()[0]['target_id'];
		                    $file1 = File::load($ctype_icon);
		                    $courseicon = $file1->url();
						
						}else{
							$courseicon = '';
						}
						if($value->get('field_course_center_code')->getValue()[0]['target_id']){
							$ctype = $value->get('field_course_center_code')->getValue()[0]['target_id'];
							$node = node_load($ctype);
                              $n=$node->title->value;
						
						}else{
							$n = '';
						}
						$tid = $value->get("field_course_")->getValue()[0]["target_id"];
				if($tid){
                  $term = Term::load($tid);
                  $category = $term->label();
				} else {
					  
					  $category ='';
				}if($value->get('field_course_summary')->value){
                  $descrption = $value->get('field_course_summary')->value;
				} else {
					  
					  $descrption ='';
				}if($value->get('field_select_template')->value){
                  $select_template = $value->get('field_select_template')->value;
				} else {
					  
					  $select_template ='';
				}
				if($value->get('field_campaign_code')->value){
                  $campaign_code = $value->get('field_campaign_code')->value;
				} else {
					  
					  $campaign_code ='';
				}
				if($value->get('field_center_list')->value){
                  $center_list = $value->get('field_center_list')->value;
				} else {
					  
					  $center_list ='';
				}

		 
			$data[2]['list'][] = [
						'nodeid' => $value->id(),
						'title' => $value->title->value,
						'descrption' => $descrption,
						'intro_videos' => $vlink,
						'star' => $starval,
						'course_type' => $course_type,
						'course_image' => file_create_url($value->get('field_course_image')->entity->getFileUri('url')),
						'course_duration' => $value->get('field_course_duration')->value,
						'course_icon' => $courseicon,
						'select_template' => $select_template,
						'campaign_code' => $campaign_code,
						'center_code' =>  $n,
						'center_list' => $center_list,
						'course_category' => $category,
						//'normaltesing' => 'gfd',
					
			];
		
			//$j++;			
		
					
			}
			$output['status'] = "200";
			$output['message'] = 'data found';
			$output['data'] = $data;
		}else{
			$output['status'] = "200";
			$output['message'] = 'No data found';
			$output['data'] = [];
		}
		if($nidthird){ // main condition for Block 1
		    
			foreach($nidthird as $key => $value){
			$data[3]['section_name'] = $category;
			$data[3]['record'] = count($nidthird);
		 
			if($value->get('field_course_newly_star_rating')->value <= 5 && !empty($value->get('field_course_newly_star_rating')->value)){
                                                  $starval = $value->get('field_course_newly_star_rating')->value.'/5';
                                                  $course_type = 'Popular';
                                                }elseif($value->get('field_course_newly_star_rating')->value > 0 && !empty($value->get('field_course_newly_star_rating')->value)){
                                                  $starval = $value->get('field_course_newly_star_rating')->value.'/5';
                                                  $course_type = 'Trending';
                                                }else{
													
													 $starval = '0/5';
													 $course_type = '';
												}
				if(is_null($value->get('field_course_video_review')->getValue()[0]['input'])){
							$vlink =  '';
						
						}else{
							//$vlink =  '';
							$vlink = $value->get(field_course_video_review)->getValue()[0]['input'];
						}
						if($value->get('field_course_type_icon')->getValue()[0]['target_id']){
							$ctype_icon = $value->get('field_course_type_icon')->getValue()[0]['target_id'];
		                    $file1 = File::load($ctype_icon);
		                    $courseicon = $file1->url();
						
						}else{
							$courseicon = '';
						}
						if($value->get('field_course_center_code')->getValue()[0]['target_id']){
							$ctype = $value->get('field_course_center_code')->getValue()[0]['target_id'];
							$node = node_load($ctype);
                              $n=$node->title->value;
						
						}else{
							$n = '';
						}
						$tid = $value->get("field_course_")->getValue()[0]["target_id"];
				if($tid){
                  $term = Term::load($tid);
                  $category = $term->label();
				} else {
					  
					  $category ='';
				}if($value->get('field_course_summary')->value){
                  $descrption = $value->get('field_course_summary')->value;
				} else {
					  
					  $descrption ='';
				}if($value->get('field_select_template')->value){
                  $select_template = $value->get('field_select_template')->value;
				} else {
					  
					  $select_template ='';
				}
				if($value->get('field_campaign_code')->value){
                  $campaign_code = $value->get('field_campaign_code')->value;
				} else {
					  
					  $campaign_code ='';
				}
				if($value->get('field_center_list')->value){
                  $center_list = $value->get('field_center_list')->value;
				} else {
					  
					  $center_list ='';
				}

		 
			$data[3]['list'][] = [
						'nodeid' => $value->id(),
						'title' => $value->title->value,
						'descrption' => $descrption,
						'intro_videos' => $vlink,
						'star' => $starval,
						'course_type' => $course_type,
						'course_image' => file_create_url($value->get('field_course_image')->entity->getFileUri('url')),
						'course_duration' => $value->get('field_course_duration')->value,
						'course_icon' => $courseicon,
						'select_template' => $select_template,
						'campaign_code' => $campaign_code,
						'center_code' =>  $n,
						'center_list' => $center_list,
						'course_category' => $category,
						//'normaltesing' => 'gfd',
					
			];
		
			//$j++;			
		
					
			}
			$output['status'] = "200";
			$output['message'] = 'data found';
			$output['data'] = $data;
		}else{
			$output['status'] = "200";
			$output['message'] = 'No data found';
			$output['data'] = [];
		}
		if($parnid){ // main condition for Block 2
		    //$i = 0;
			foreach($parnid as $key => $value){
			//$data['section_name'] = $term->label();
				$data['record'] = count($parnid);
				
				if($value->get('field_course_newly_star_rating')->value <= 5 && !empty($value->get('field_course_newly_star_rating')->value)){
					$starval = $value->get('field_course_newly_star_rating')->value.'/5';
					$course_type = 'Popular';
				}elseif($value->get('field_course_newly_star_rating')->value > 0 && !empty($value->get('field_course_newly_star_rating')->value)){
					$starval = $value->get('field_course_newly_star_rating')->value.'/5';
					$course_type = 'Trending';
				}else{
					
					$starval = '0/5';
					$course_type = '';
				}
				if(is_null($value->get('field_course_video_review')->getValue()[0]['input'])){
					$vlink =  '';
					
				}else{
							//$vlink =  '';
					$vlink = $value->get(field_course_video_review)->getValue()[0]['input'];
				}
				if($value->get('field_course_type_icon')->getValue()[0]['target_id']){
					$ctype_icon = $value->get('field_course_type_icon')->getValue()[0]['target_id'];
					$file1 = File::load($ctype_icon);
					$courseicon = $file1->url();
					
				}else{
					$courseicon = '';
				}
				if($value->get('field_course_center_code')->getValue()[0]['target_id']){
					$ctype = $value->get('field_course_center_code')->getValue()[0]['target_id'];
					$node = node_load($ctype);
					$n=$node->title->value;
					
				}else{
					$n = '';
				}
				$tid = $value->get("field_course_")->getValue()[0]["target_id"];
				if($tid){
					$term = Term::load($tid);
					$category = $term->label();
				} else {
					
					$category ='';
				}
				if($value->get('field_campaign_code')->value){
					$campaign_code= $value->get('field_campaign_code')->value;
					
				} else {
					
					$campaign_code ='';
				}
				if($value->get('field_center_list')->value){
					$center_list=$value->get('field_center_list')->value;
					
				} else {
					
					$center_list ='';
				}
				if($value->get('field_course_image')->getValue()[0]['target_id']){
							$course_imageid = $value->get('field_course_image')->getValue()[0]['target_id'];
		                    $file1 = File::load($course_imageid);
		                    $course_image = $file1->url();
						
						}else{
							$course_image = '';
						}
						if($value->get('field_course_duration')->value){
							$course_duration = $value->get('field_course_duration')->value;
		                 
						}else{
							$course_duration = '';
						}
						if($value->get('field_select_template')->value){
							$select_template = $value->get('field_select_template')->value;
		                 
						}else{
							$select_template = '';
						}
				
				$data['list'][] = [
					'nodeid' => $value->id(),
					'title' => $value->title->value,
						//'descrption' => $value->get('field_course_summary')->value,
					'intro_videos' => $vlink,
					'star' => $starval,
					'course_type' => $course_type,
					'course_image' => $course_image,
					'course_duration' => $course_duration,
					'course_icon' => $courseicon,
				    'select_template' => $select_template,
					'campaign_code' => $campaign_code,
					'center_code' =>  $n,
					'center_list' => $center_list,
					'course_category' => $category,
					//'tesingquery' => 'dfd',
					
				];
				
			//$i++;			
				
				
			}
			$output['status'] = "200";
			$output['message'] = 'data found';
			$output['data'] = array($data);
		}/*else{
			$output['status'] = "200";
			$output['message'] = 'No data found';
			$data['record'] = 0;
			$data['list'] =[];
			$output['data'] = $data;
		}*/ /// End  of main condition of block 2
	
	
	$response = new ResourceResponse($output);
    $response->addCacheableDependency($output);
    return $response;
  }
}