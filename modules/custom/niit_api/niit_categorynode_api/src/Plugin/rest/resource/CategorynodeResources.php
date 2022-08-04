<?php
namespace Drupal\niit_categorynode_api\Plugin\rest\resource;
use Drupal\node\Entity\Node;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\CacheableResponseInterface;
use  \Drupal\user\Entity\User;
use \Drupal\file\Entity\File;
use Drupal\media\Entity\Media;

/**
 * Annotation for get method
 *
 * @RestResource(
 *   id = "niit_categorynode_get",
 *   label = @Translation("niit categorynode"),
 *   uri_paths = {
 *     "canonical" = "/get/api/categorynode/data/{tid}"
 *   }
 * )
 */
class CategorynodeResources extends ResourceBase
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
            $container->get('logger.factory')->get('niit_categorynode_api'),
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
	public function get($tid = NULL) {

    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
		if (!$this->currentUser->hasPermission('access content')) {
			throw new AccessDeniedHttpException();
		}
      
	if($tid){
		   $query = \Drupal::entityQuery('node')
        ->condition('type', 'course')
        ->condition('field_course_', $tid)
		->condition('status', 1)
        ->condition('field_select_template', 'course_selfpaced', 'NOT IN' )
		->sort('changed' , 'DESC')
		->range(0,5);
		
		$result = $query->execute();
		
		$pagetemp = \Drupal::entityManager()->getStorage('node')->loadMultiple($result);
		 $countquery = \Drupal::entityQuery('node')
        ->condition('type', 'course')
        ->condition('field_course_', $tid)
		->condition('status', 1)
        ->condition('field_select_template', 'course_selfpaced', 'NOT IN' );	
		$countresult = $countquery->execute();
		$term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($tid);
        //$data[category_name] = $term->label();
		$queryone = \Drupal::entityQuery('node')
        ->condition('type', 'course')
        ->condition('field_course_', $tid)
		->condition('status', 1)
        ->condition('field_select_template', 'course_selfpaced')
		->sort('changed' , 'DESC')
		->range(0,5);
		
		$resultone = $queryone->execute();
		
		$nid = \Drupal::entityManager()->getStorage('node')->loadMultiple($resultone);
		$countqueryone = \Drupal::entityQuery('node')
        ->condition('type', 'course')
        ->condition('field_course_', $tid)
		->condition('status', 1)
        ->condition('field_select_template', 'course_selfpaced');
		
		
		$countresultone = $countqueryone->execute();
		
     // $nid = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'course', 'field_course_' => $tid, /*'field_select_template' =>'course_selfpaced'*/]);
	  //$pagetemp = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'course','field_course_' => $tid,]);
        $data = [];
		
		if($nid){ // main condition for Block 1
		    $i = 0;
			foreach($nid as $key => $value){
			$data[0]['section_name'] = $term->label();
			$data[0]['record'] = count($countresultone);
		 
			if(is_null($value->get('field_course_video_review')->getValue()[0]['input'])){
							$vlink =  '';
						
						}else{
							//$vlink =  '';
							$vlink = $value->get('field_course_video_review')->getValue()[0]['input'];
						}
						if($value->get('field_course_type_icon')->getValue()[0]['target_id']){
							$ctype_icon = $value->get('field_course_type_icon')->getValue()[0]['target_id'];
		                    $file1 = File::load($ctype_icon);
		                    $courseicon = $file1->url();
						
						}else{
							$courseicon = '';
						}
						if($value->get('field_course_newly_star_rating')->value){
							
							$starval = $value->get('field_course_newly_star_rating')->value.'/5';
						}else{
							$starval = '0/5';
							
						}if($value->get('field_campaign_code')->value){
                  $campaign_code = $value->get('field_campaign_code')->value;
				} else {
					  
					  $campaign_code ='';
				}
				if($value->get('field_center_list')->value){
                  $center_list = $value->get('field_center_list')->value;
				} else {
					  
					  $center_list ='';
				}if($value->get('field_course_center_code')->getValue()[0]['target_id']){
							$ctype = $value->get('field_course_center_code')->getValue()[0]['target_id'];
							$node = node_load($ctype);
                              $n=$node->title->value;
						
						}else{
							$n = '';
						}
						if($value->get('field_course_summary')->value){
                  $descrption = $value->get('field_course_summary')->value;
				} else {
					  
					  $descrption ='';
				}


		 
			$data[0]['list'][$i] = [
						'nodeid' => $value->id(),
						'title' => $value->title->value,
						'descrption' => $descrption,
						'star' => $starval,
						'course_image' => file_create_url($value->get('field_course_image')->entity->getFileUri('url')),
						'course_duration' => $value->get('field_course_duration')->value,
						'course_icon' => $courseicon,//file_create_url($value->get(field_course_duration_icon)->entity->getFileUri('url')),
						'intro_videos' => $vlink,
						'course_type' => 'free',
						'campaign_code' => $campaign_code,
						'center_code' =>  $n,
						'center_list' => $center_list,
						'changed_on' => $value->changed->value,
					
			];
		
			$i++;			
		
					
			}
			$output['status'] = "200";
			$output['message'] = 'data found';
			$output['data'] = $data;
		}else{
			$output['status'] = "400";
			$output['message'] = 'No data found';
			$output['data'] = [];
		} // End  of main condition of block 2
		
		 
		if($pagetemp){ // Start of second block
		
			$j = 0;
			if($nid){
				$z=$z+1;
			}else{
				$z=0;
			}
			
			foreach($pagetemp as $key => $value){
			$data[$z]['section_name'] = "Upgrade To Our Advance Track";
			$data[$z]['record'] = count($countresult);
			
			if($pagetemp){
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
						}if($value->get('field_campaign_code')->value){
                  $campaign_code = $value->get('field_campaign_code')->value;
				} else {
					  
					  $campaign_code ='';
				}
				if($value->get('field_center_list')->value){
                  $center_list = $value->get('field_center_list')->value;
				} else {
					  
					  $center_list ='';
				}if($value->get('field_course_center_code')->getValue()[0]['target_id']){
							$ctype = $value->get('field_course_center_code')->getValue()[0]['target_id'];
							$node = node_load($ctype);
                              $n=$node->title->value;
						
						}else{
							$n = '';
						}if($value->get('field_course_summary')->value){
                  $descrption = $value->get('field_course_summary')->value;
				} else {
					  
					  $descrption ='';
				}
			
				$data[$z]['list'][$j] = [
						'nodeid' => $value->id(),
						'title' => $value->title->value,
						'descrption' => $descrption,
						'intro_videos' => $vlink,
						'star' => $starval,
						'course_type' => $course_type,
						'course_image' => file_create_url($value->get('field_course_image')->entity->getFileUri('url')),
						'course_duration' => $value->get('field_course_duration')->value,
						'course_icon' => $courseicon,
						'select_template' => $value->get('field_select_template')->value,
						'campaign_code' => $campaign_code,
						'center_code' =>  $n,
						'center_list' => $center_list,
						'changed_on' => $value->changed->value,
						
				];
			
			$j++;			
				}
					
			}
			$output['status'] = "200";
			$output['message'] = 'data found';
			$output['data'] = $data;
		}else{
			$output['status'] = "400";
			$output['message'] = 'No data found';
			$output['data'] = [];
		} // end of second block
		
	}else{
		  $output['status'] = "400";
		  $output['message'] = 'No data found';
		  $output['data'] = [];
	} // End of tid check
	
	$response = new ResourceResponse($output);
    $response->addCacheableDependency($output);
    return $response;
  }
}