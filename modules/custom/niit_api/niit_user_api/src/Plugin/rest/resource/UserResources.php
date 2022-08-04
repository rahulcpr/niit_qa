<?php
namespace Drupal\niit_user_api\Plugin\rest\resource;
use Drupal\node\Entity\Node;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\CacheableResponseInterface;
use  \Drupal\user\Entity\User;
/**
 * Annotation for get method
 *
 * @RestResource(
 *   id = "niit_user_get",
 *   label = @Translation("niit user GET"),
 *   uri_paths = {
 *     "canonical" = "/get/niit/api/user"
 *   }
 * )
 */
class UserResources extends ResourceBase
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
            $container->get('logger.factory')->get('niit_user_api'),
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
 public function get($uids) {

    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
     if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }
	// $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
	 // $user = \Drupal\user\Entity\User::load($uid);
	 //$entities = \Drupal::entityManager()
     // ->getStorage('user')
	 // $users = \Drupal\user\Entity\User::load($userid);
              // foreach($entities as $key => $u) {
				//	$data[] = ['user_id' => $u->id(),'users_mailid' => $u->getEmail(),'user_name' => $u->getUsername()];
                
                // }
				
	  $uids = \Drupal::entityQuery('user')
	           ->execute();
	 // $uids = '';
      if($uids){
				
      $entities = \Drupal::entityTypeManager()
      ->getStorage('user')
      ->loadMultiple($uids);
        foreach (array_slice($entities,0, 2)  as $key => $entity ) {
            $data[] = ['uid' =>$entity->id(),'Email' => $entity->getEmail(), 
	                          'Username' => $entity->getUsername(), 
	                          'Roles' => $entity->getRoles(), 
							  'Customer ID' => $entity->get(field_customer_id)->value,
                              'Custom Roles' => $entity->get(field_custom_roles)->value, 
                              'Student Status' => $entity->get(field_student_status)->value, 							  
	                          'Custom Username' => $entity->get(field_user_name)->value,
	                          'Mobile Number' => $entity->get(field_mobile_number)->value,
							  'User Status' => $entity->get('status', 1 || 0),
							  ];
		}
			$output['msg'] = 'data found';
	        $output['data'] = $data;
	                $output['status'] = "1";
        }else{
		              $output['msg'] = 'No data found';
		              $output['data'] = [];
		              $output['status'] = "0";
		}
 // kint($data);
        $response = new ResourceResponse($output);
        $response->addCacheableDependency($output);
        return $response;
     }
   }