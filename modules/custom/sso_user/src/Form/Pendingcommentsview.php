<?php
/**
 * @file
 * Contains \Drupal\sso_user\Form\ContributeForm.
 */

namespace Drupal\sso_user\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Contribute form.
 */
class Pendingcommentsview extends FormBase {
  /**
   * {@inheritdoc}
   */
  
  public function getFormId() {
    return 'view_pending_cmt'; 
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $node_id = NULL) {

    $output = array();
    $page = 1;
    if(!empty($_GET['page'])){
       $page = $_GET['page'] + 1;
    }

    $form['#prefix'] = '<div class="container"><div class="table-pen">';
    $form['#suffix'] = '</div></div>';

    $form['table'] = [
      '#type' => 'table',
      '#title' => 'Sample Table',
      '#header' => array('User Name', 'Comment', 'Action'),
    ];

    $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Post');
    $token = $tokenArray->data->token;
    $authorDataFields = [
            'module' => 'get_data',
            'type' => 'comment',
            'token' => $token,
            'page_num' => $page,
            'status' => 0,
            'vId' => $node_id,
        ];
    $results = \Drupal::service('custom_campaign.niit_kc_services')->GetAPICommentMethod($authorDataFields);
    if(!empty($results->data) && $results->status == 1){
      foreach ($results->data as $key => $result) {

        $form['table'][$key]['username'] = [
            '#type' => 'textfield',
            '#value' => $result->username,
            '#attributes' => ['readonly' => 'readonly'],
        ]; 

        $form['table'][$key]['comment'] = [
            '#type' => 'markup',
            '#markup' => $result->comment,
        ];

        $form['table'][$key]['approve'] = [
            '#type' => 'radios',
            '#options' => [1 => 'Approved', 2 => 'Disapproved'],
        ]; 

      }

      if($results->pages > 1){
        $num_per_page = 10;
        $offset = $num_per_page * $page;
        $total = $num_per_page * ($results->pages);
        pager_default_initialize($total, $num_per_page);
        $form['pager'] = [
          '#type' => 'pager'
        ]; 
      }

      $form['nid'] = [
        '#type' => 'hidden',
        '#value' => $node_id,
      ]; 

      $form['page'] = [
        '#type' => 'hidden',
        '#value' => $page,
      ];                                        

      $form['actions']['submit'] = [
          '#type' => 'submit',
          '#value' => $this->t('Submit'),
      ];
    }  
    else{
      $form['emp'] = [
        '#type' => 'markup',
        '#markup' => 'No Pending Comments',
      ];

    }

    return $form;
  }

   /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

      $node_id =  $form_state->getUserInput()['nid'];
      $page_id =  $form_state->getUserInput()['page_id'];

      $tokenArray = \Drupal::service('custom_campaign.niit_kc_services')->generateJWTToken('Post');
      if($tokenArray->status == 1){
          $token = $tokenArray->data->token;
          $urlDataSetArray = [
                  'module' => 'update-comment-sts',
                  'token' => $token
              ];

          foreach ($urlDataSetArray as $key => $value) {
            $output .= $key.'='.$value.'&';
          }
          $url_data = rtrim($output, '&');

          $fieldDataSetArray = [];
          foreach($form_state->getValue('table') as $val){  
            $sts = 0;
            if(!empty($val['approve'])){
              $sts = $val['approve'];
            }
            $fieldDataSetArray[] = [
              'username' => $val['username'],
              'videoId' => $node_id,
              'sts' => $sts,
            ];
          }

          $data = json_encode($fieldDataSetArray);

          //$main_url = 'https://niit-kms-stg.niit-mts.com/api/webservices.php?'.$url_data;
          $main_url = $_ENV['NIIT_KMS_API_MAP'].'api/webservices.php?'.$url_data;

          $headers = array(
              "content-type: application/json"
            );

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $main_url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          $response = curl_exec($ch);
          curl_close($ch);
      }

      // url to redirect
      $path = '/pending-comment-view/'.$node_id;
      // query string
      $page = 0; 
      if($page_id > 0){
         $page = $page_id - 1;
      }
      $path_param = [
       'page' => $page,
      ];
      // use below if you have to redirect on your known url
      $url = Url::fromUserInput($path, ['query' => $path_param]);
      $form_state->setRedirectUrl($url);
      return;
    
  }
  
}

