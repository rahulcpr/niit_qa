<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;
use Drupal\Component\Render\FormattableMarkup;

class Pendingcomments extends ControllerBase {    

    public function ControllerPage() {    	

        $header = [
            'title' => t('Title'),
            'summary' => t('Summary'),
            'count' => t('Pending Comment'),
            'view' => t('View'),
        ];

        $output = array();
        $page = 1;
        if(!empty($_GET['page'])){
           $page = $_GET['page'] + 1;
        }

        $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Post');
        $token = $tokenArray->data->token;
        $authorDataFields = [
                'module' => 'get_data',
                'type' => 'comment-stats',
                'token' => $token,
                'page_num' => $page,
            ];
        $results = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICommentMethod($authorDataFields);
        if(!empty($results->data) && $results->status == 1){
            foreach ($results->data as $result) {  
                if (!empty($result->vId)) {
                  $view = new FormattableMarkup('<a class="btn v-con" href=":link">View Comments</a>', [':link' => "/india/pending-comment-view/$result->vId"]);
                   $output[$result->vId] = [
                     'title' => $result->ttl,
                     'summary' => $result->dsc,
                     'count' => $result->cmnt_cnt,
                     'view' => $view,
                   ];
                }
            }
        }  

        $build['table'] = [
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $output,
            '#empty' => t('No Pending Comment'),
        ];

        if($results->pages > 1){
            $num_per_page = 10;
            $offset = $num_per_page * $page;
            $total = $num_per_page * ($results->pages);
            pager_default_initialize($total, $num_per_page);
            $build['pager'] = [
              '#type' => 'pager'
            ];  
        }

        return [
          '#type' => '#markup',
          '#markup' => '<div class="container"><div class="pen-comment-list">'.render($build).'</div></div>',
        ];

    }


}