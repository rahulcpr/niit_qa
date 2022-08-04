<?php
namespace Drupal\niit_categorynode_api\Plugin\rest\resource;
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
 *   id = "niit_allarticles_get",
 *   label = @Translation("niit popular all articles"),
 *   uri_paths = {
 *     "canonical" = "/get/api/viewall/popular_articles"
 *   }
 * ) 
 */
class AllArticlesResources extends ResourceBase
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
        AccountProxyInterface $current_user
		
    ) {
        parent::__construct(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $serializer_formats,
            $logger
        );
        $this->currentUser = $current_user;
    }
    /**
     * {@inheritdoc}
     */
    public static function create(
        ContainerInterface $container,
        array $configuration,
        $plugin_id,
        $plugin_definition
    ) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->getParameter("serializer.formats"),
            $container->get("logger.factory")->get("niit_popular_allarticles_api"),
            $container->get("current_user")
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
	
    public function get()
    {
        // You must to implement the logic of your REST Resource here.
        // Use current user after pass authentication to validate access.
        if (!$this->currentUser->hasPermission("access content")) {
            throw new AccessDeniedHttpException();
        }
		     $parameters = \Drupal::request()->get('pager');
			/* if($parameters == '1'){
             $range = 0;
			 }elseif($parameters == '2'){
             $range = 10;
			 }elseif($parameters == '3'){
             $range = 20;
			 }elseif($parameters == '4'){
             $range = 30;
			 }elseif($parameters == '5'){
             $range = 40;
			 }else{
				 $range = 0;
			 }*/
			 if(empty($parameters)){
					$parameters = 1;
				}
				 $rangeFrom = ($parameters - 1) * 10;
				 $rangeTo =  10;
				 
        $query = \Drupal::entityQuery("node")
            ->condition("type", "blog_post")
            ->condition("status", 1)
			->sort('changed' , 'DESC')
            ->range($rangeFrom, $rangeTo);
			
      

        $result = $query->execute();

        $nid = \Drupal::entityManager()
            ->getStorage("node")
            ->loadMultiple($result);
	    $countquery = \Drupal::entityQuery("node")
        ->condition("type", "blog_post")
        ->condition("status", 1);
        $countresult = $countquery->execute();
	

			
        if ($nid) {
            foreach ($nid as $key => $value) {
				$data['section_name'] = 'Popular Articles';
			   $data['record'] = count($countresult);
                $ctype_icon = $value->get("field_image")->getValue()[0][
                    "target_id"
                ];
                if (is_numeric($ctype_icon)) {
                    $file1 = File::load($ctype_icon);
                    $courseicon = $file1->url();
                } else {
                    $courseicon = "";
                }
                if ($value->get("field_duration")->value) {
                    $duration = 'Article - '. $value->get("field_duration")->value;
                } else {
                    $duration = "";
                }

                $tid = $value->get("field_categories")->getValue()[0]["target_id"];
				if($tid){
                  $term = Term::load($tid);
                  $category = $term->label();
				} else {
					  
					  $category ='';
				}
             

                $data['list'][] = [
                    "nid" => $value->id(),
                   "title" => $value->label(),
                   // "descrption" => $value->body->value,
                   "course_image" => $courseicon,
                   "course_duration" => $duration,
					"category" =>  $category,
					"changed_on" => $value->changed->value,
					//"pager" => $range, 
					
                ];
            }
			
            $output["status"] = "200";
            $output["message"] = "data found";
            $output["data"] = $data;
        } else {
            $output["status"] = "200";
            $output["message"] = "No data found";
			$data['section_name'] = 'Popular Articles';
			$data['record'] = 0;
			$data['list'] = [];
			$output["data"] = $data;
            //$output["data"] = [];
        }

        $response = new ResourceResponse($output);
        $response->addCacheableDependency($output);
        return $response;
    }
}
