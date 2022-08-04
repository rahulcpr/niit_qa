<?php
namespace Drupal\niit_user_api\Plugin\rest\resource;
use Drupal\node\Entity\Node;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\CacheableResponseInterface;
/**
 * Annotation for get method
 *
 * @RestResource(
 *   id = "user_get_api_miniorangeuser",
 *   label = @Translation("api GET miniorangeuser"),
 *   uri_paths = {
 *     "canonical" = "/get/api/miniorangeuser"
 *   }
 * )
 */
class MiniorangeResources extends ResourceBase
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
 public function get() {

    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
     if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }
	$curl = curl_init();
$user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
$customer_id = $user->get('field_customer_id')->value;
//print_r($customer_id); die();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://qa.training.com/NIITDigitalPlatformAPI/api/digital/enrollment/v1/enrolleduserinfo',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    "CustomerID: $customer_id"
  ),
));

$data = curl_exec($curl);
//echo '<pre>'; print_r($response);print_r($customer_id); die();
curl_close($curl);


    $response = new ResourceResponse($data);
    $response->addCacheableDependency($data);
    return $response;
  }
}