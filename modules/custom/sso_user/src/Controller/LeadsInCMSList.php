<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Database\Query\TableSortExtender;

class LeadsInCMSList extends ControllerBase {    

    public function ControllerPage() {    	
		$header = array(
			array('data' => t('S.No.'), 'field' => 'id', 'sort' => 'desc'),
			array('data' => t('Name'), 'field' => 'name'),
			array('data' => t('Mobile Number'), 'field' => 'mobile_number'),
			array('data' => t('Email'), 'field' => 'email_id'),
			array('data' => t('Campaign Code'), 'field' => 'campaign_code'),
			array('data' => t('Course Code'), 'field' => 'course_code'),
			array('data' => t('Currently Pursuing'), 'field' => 'currently_pursuing'),
			array('data' => t('Prize Category'), 'field' => 'prize_category'),
			array('data' => t('Created Date'), 'field' => 'lead_unique_id'),
		  );
		$database = \Drupal::database();
		$query = $database->select('custom_capture_leads_cms_table','t');
		$query->fields('t', array('id', 'name', 'mobile_number', 'email_id', 'campaign_code', 'course_code', 'currently_pursuing', 'prize_category', 'lead_unique_id'));
		//$query->addField('loc','name','name_alias');
		$table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')->orderByHeader($header);
		$pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(20);
		$result = $pager->execute();

      foreach($result as $row) {
		  date_default_timezone_set("Asia/Calcutta");
		  $row->lead_unique_id = date('d-m-Y h:i:s A' ,explode('_', $row->lead_unique_id)[1]);
          $rows[] = array('data' => (array) $row);
      }


      $build = array(
          '#markup' => '<div class="col-md-12 mb-5"><h2 class="iciciMainTitle">Lead Data table</h2></div>'
      );

      $build['location_table'] = array(
        '#theme' => 'table', '#header' => $header,
        '#rows' => $rows,
		'#attributes' => array(
              'class' => array('table table-bordered')
            ),
		'#empty' => t('No Pending Comment'),
      );
     $build['pager'] = array(
       '#type' => 'pager'
     );
	 
        return [
          '#type' => '#markup',
          '#markup' => '<div class="container"><div class="pen-comment-list">'.render($build).'</div></div>',
        ];

    }


}