<?php

namespace Drupal\niit_community_gallery\Plugin\Block;

use Drupal\node\Entity\Node;
use Drupal\Core\Block\BlockBase;


/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id ="niit_community_gallery",
 *   admin_label = @Translation("NIIT Community Gallery"),
 *   category = @Translation("Blocks")
 * )
 */
class NiitCommunityBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
      $niitcommunitygallery = $this->_getData();
        return array(
            '#theme' => 'my-customfunctions',
            '#arguments' => $niitcommunitygallery,
            '#cache' => array('max-age' => 0),
        );


    }

    // Get NIIT community network records
    public function _getData(){
        $query = \Drupal::entityQuery('node')
            ->condition('status', 1) //published or not
            ->condition('type', 'our_amazing_community_network'); //content type
            //->pager(10); //specify results to return
        $nids = $query->execute();
        # get node detail with using node id
        $verticalNode = array();
        $horizontalNode = array();
        $horizontalImage = "";
        $verticalImage = "";
        foreach($nids as $key=>$val) {
            $title = Node::load($val)->get('title')->value;
            $hImg = Node::load($val)->get('field_horizontal_image')->getValue();
            $hfile = \Drupal\file\Entity\File::load($hImg[0]['target_id']);

            if (is_object($hfile) && is_null($hfile) == FALSE) {
               $horizontalImageUri = parse_url($hfile->url());
               $horizontalImage = $horizontalImageUri['path'];
            }
            $vImg= Node::load($val)->get('field_natwork_image')->getValue();
            $vfile = \Drupal\file\Entity\File::load($vImg[0]['target_id']);
            if (is_object($vfile) && is_null($vfile) == FALSE) {
                $verticalImageUri = parse_url($vfile->url());
               $verticalImage = $verticalImageUri['path'];
            }
            $displayPosition= Node::load($val)->get('field_display_position')->value;
            $body= Node::load($val)->get('body')->value;
            $natworkFacebook = Node::load($val)->get('field_natwork_facebook')->value;
            $natworkInstagram = Node::load($val)->get('field_natwork_instagram')->value;
            $natworkTwitter = Node::load($val)->get('field_natwork_twitter')->value;
            $networkYoutube = Node::load($val)->get('field_network_youtube')->value;
            $shortText = Node::load($val)->get('field_short_text')->value;
            # total node of vertical and horizontal
            if($displayPosition == "vertical"){
                $verticalNode[] = array('title'=>$title,
                    'horizontalImage'=>$horizontalImage,
                    'verticalImage'=>$verticalImage,
                    'displayPosition'=>$displayPosition,
                    'body'=>$body,
                    'natworkFacebook'=>$natworkFacebook,
                    'natworkInstagram'=>$natworkInstagram,
                    'natworkTwitter'=>$natworkTwitter,
                    'networkYoutube'=>$networkYoutube,
                    'shortText'=>$shortText);
            }else if($displayPosition == "horizontal"){
                $horizontalNode[] = array('title'=>$title,
                    'horizontalImage'=>$horizontalImage,
                    'verticalImage'=>$verticalImage,
                    'displayPosition'=>$displayPosition,
                    'body'=>$body,
                    'natworkFacebook'=>$natworkFacebook,
                    'natworkInstagram'=>$natworkInstagram,
                    'natworkTwitter'=>$natworkTwitter,
                    'networkYoutube'=>$networkYoutube,
                    'shortText'=>$shortText);
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
    return $NiitCommunityInfo = array('horizontal'=>$horizontalNodePop, 'vertical'=>$verticalNodePop);
    }


}