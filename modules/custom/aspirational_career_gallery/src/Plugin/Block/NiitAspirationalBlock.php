<?php

namespace Drupal\aspirational_career_gallery\Plugin\Block;
use Drupal\node\Entity\Node;
use Drupal\Core\Block\BlockBase;


/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id ="aspirational_career_gallery",
 *   admin_label = @Translation("NIIT Aspirational Career Gallery"),
 *   category = @Translation("Blocks")
 * )
 */
class NiitAspirationalBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
      $niitaspirationalgallery = $this->_getData();
        return array(
            '#theme' => 'aspirational-career',
            '#arguments' => $niitaspirationalgallery,
            '#cache' => array('max-age' => 0),
        );


    }

    // Get NIIT community network records
    public function _getData(){
        # Get Current Node id(category id)
        $node = \Drupal::routeMatch()->getParameter('node');
        if ($node instanceof \Drupal\node\NodeInterface && is_null($node) == FALSE) {
            if ($node->gettype() == 'course_category') {
                $nid = $node->id();
            }
        }


        $query = \Drupal::entityQuery('node')
            ->condition('status', 1) //published or not
            ->condition('type', 'it_jobs'); //content type
            //->pager(10); //specify results to return
        $nids = $query->execute();
        # get node detail with using node id
        $verticalNode = array();
        $horizontalNode = array();
        $horizontalImage = "";
        $verticalImage = "";
        foreach($nids as $key => $val) {
            $node_it_jobs = Node::load($val);
            $title = $node_it_jobs->get('title')->value;
            $hImg = $node_it_jobs->get('field_h')->getValue();
            if(is_numeric($hImg[0]['target_id'])){

                
                $hfile = \Drupal\file\Entity\File::load($hImg[0]['target_id']);
                if (is_object($hfile) && is_null($hfile) == FALSE) {
                    $horizontalImageUri = parse_url($hfile->url());
                    $horizontalImage = $horizontalImageUri['path'];
                }
            }
            $vImg = $node_it_jobs->get('field_vertical_image')->getValue();
            if(is_numeric($vImg[0]['target_id'])){
                
                $vfile = \Drupal\file\Entity\File::load($vImg[0]['target_id']);
                if (is_object($vfile) && is_null($vfile) == FALSE) {
                    $verticalImageUri = parse_url($vfile->url());
                    $verticalImage = $verticalImageUri['path'];
                }
            }

            $displayPosition = $node_it_jobs->get('field_display_position_it')->value;
            $body = $node_it_jobs->get('body')->value;
            $networkYoutube = $node_it_jobs->get('field_job_youtube_video')->value;
            $shortText = $node_it_jobs->get('field_job_short_text')->value;
            $category = $node_it_jobs->get('field_job_category')->target_id;
            $topCategory = $node_it_jobs->get('field_job_top_category')->target_id;# total node of vertical and horizontal
            if ($nid == $topCategory){
                if ($displayPosition == "vertical") {
                    $verticalNode[] = array('title' => $title,
                        'horizontalImage' => $horizontalImage,
                        'verticalImage' => $verticalImage,
                        'displayPosition' => $displayPosition,
                        'body' => $body,
                        'networkYoutube' => $networkYoutube,
                        'shortText' => $shortText,
                        'category' => $category,
                        'topCategory' => $topCategory
                    );
                } else if ($displayPosition == "horizontal") {
                    $horizontalNode[] = array('title' => $title,
                        'horizontalImage' => $horizontalImage,
                        'verticalImage' => $verticalImage,
                        'displayPosition' => $displayPosition,
                        'body' => $body,
                        'networkYoutube' => $networkYoutube,
                        'shortText' => $shortText,
                        'category' => $category,
                        'topCategory' => $topCategory
                    );
                }
        }
        }
        # Get second last and last vertical node
        $hlast = array_pop($horizontalNode);
        $hsecond_last = array_pop($horizontalNode);
        $horizontalNodePop = array($hsecond_last, $hlast);
        # Get second last and last vertical node
        $vlast = array_pop($verticalNode);
        $vsecond_last = array_pop($verticalNode);
        $verticalNodePop = array($vsecond_last,  $vlast);
    return $niitaspirationalgallery = array('horizontal'=>$horizontalNodePop, 'vertical'=>$verticalNodePop);
    }


}