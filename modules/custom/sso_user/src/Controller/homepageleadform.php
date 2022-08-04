<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\user\Entity\User;

class homepageleadform extends ControllerBase {  
  
    public function homepageleadformfnctn() {

//$variables['homepageform'] = \Drupal::formBuilder()->getForm('Drupal\sso_user\Form\HomePageMultistepForm');
$homepageldform = $variables['homepageform'];
        $ajax_response = new AjaxResponse();
        $ajax_response->addCommand(new AppendCommand('.homepagelead-ldform', $homepageldform));
        return $ajax_response;
    }
}        