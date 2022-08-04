<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloController.
 */

namespace Drupal\niit_common\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\views\Views;

class CityController extends ControllerBase {

    public function content($name) {
        $view = Views::getView('get_city');
        if (is_object($view)) {
            $view->setArguments((array) $name);
            $view->setDisplay('get_city_json');
            $view->preExecute();
            $view->execute();
        }

        if (isset($view->result)) {
            $output = '<select>';
            foreach ($view->result as $key => $row) {
                $output .= '<option value="' . $row->_entity->get('tid')
                        ->getValue()[0]['value'] . '">' . $row->_entity->get('name')
                        ->getValue()[0]['value'] . '</option>';

            }
            $output .= '</select>';
        }

        return $output;
    }
}
