<?php
namespace Drupal\niit_course_details\Plugin\rest\resource;

use Drupal\node\Entity\Node;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\CacheableResponseInterface;
use Drupal\user\Entity\User;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;

/**
 * Annotation for get method
 *
 * @RestResource(
 *   id = "niit_upcomingevent_get",
 *   label = @Translation("niit upcomingevent"),
 *   uri_paths = {
 *     "canonical" = "/get/api/upcomingevent"
 *   }
 * )
 */
class EventResources extends ResourceBase
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
            $container->get('logger.factory')->get('niit_course_details'),
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
	 $todaysdate = new DrupalDateTime('now');
     $todaysdate = $todaysdate->format(\Drupal\datetime\Plugin\Field\FieldType\DateTimeItemInterface::DATETIME_STORAGE_FORMAT);

	$query = \Drupal::entityQuery('node')
        ->condition('type', 'webinar')
		->condition('status', 1)
		->condition('field_enad_date', $todaysdate ,'>=')
		->range(0,10);
		
		$result = $query->execute();
		$event = \Drupal::entityManager()->getStorage('node')->loadMultiple($result);
    if($event){
		 
	  foreach ($event as $key => $value ) {
		  
			$ctype_icon = $value->get('field_overview_image')->getValue()[0]['target_id'];
           if(is_numeric($ctype_icon)){
	            $file1 = File::load($ctype_icon);
	      $courseicon = $file1->url();
             }else{
				 
	              $courseicon = '';
        } 		
        $data[] = ['nodeid' => $value->id(),
			        'title' => $value->label(),
					'course_image' => $courseicon,
					'startdate' => $value->get('field_start_date')->date->format('jS F Y'),
                   // 'enddate' => $value->get('field_enad_date')->date->format('jS F Y'),
					//'enddateunix' => $value->get('field_enad_date')->date->getTimestamp(),
					//'todaysdate' => $todaysdate,
				  ];
	    }
		    $output['status'] = "200";
			$output['message'] = 'data found';
	        $output['data'] = $data;
	        
        }else{        
		    $output['status'] = "200";
		    $output['message'] = 'No data found';
		    $output['data'] = [];
		              
		}
 
    $response = new ResourceResponse($output);
    $response->addCacheableDependency($output);
    return $response;
  }
}