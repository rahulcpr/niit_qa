<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Drupal\file\Entity\File;


class TestimonialVideo extends ControllerBase {    
    public function ControllerPage($node_id) {

    	$iciciTestimonialTabDataOutput = '';  
        $node = Node::load($node_id);
        if(is_object($node) && $node->bundle() == 'course'){
        	$testimonialResult = array();

        	$nodeTesitmonialIds = $node->get('field_course_testimonials')->getValue();
	        if(!empty($nodeTesitmonialIds)){
	            foreach ($nodeTesitmonialIds as $nodeTesitmonialId) {
	                $nodeTesitmonialData = Node::load($nodeTesitmonialId['target_id']);
	                if(!empty($nodeTesitmonialData->field_testimonial_type_new->target_id)){
	                    $testimonialResult[$nodeTesitmonialData->field_testimonial_type_new->target_id][$nodeTesitmonialId['target_id']]['testimonial_type'] = (Term::load($nodeTesitmonialData->field_testimonial_type_new->target_id))->getName();
	                    $testimonialResult[$nodeTesitmonialData->field_testimonial_type_new->target_id][$nodeTesitmonialId['target_id']]['title'] = $nodeTesitmonialData->getTitle();
	                    $testimonialResult[$nodeTesitmonialData->field_testimonial_type_new->target_id][$nodeTesitmonialId['target_id']]['video'] = $nodeTesitmonialData->field_testimonial_video->value;
	                    $testimonialResult[$nodeTesitmonialData->field_testimonial_type_new->target_id][$nodeTesitmonialId['target_id']]['about_testimonial'] = $nodeTesitmonialData->field_about_testimonial->value;
	                     $testimonialResult[$nodeTesitmonialData->field_testimonial_type_new->target_id][$nodeTesitmonialId['target_id']]['image_uri'] = (\Drupal\file\Entity\File::load($nodeTesitmonialData->field_testimonial_image->target_id))->url();
	                     $testimonialResult[$nodeTesitmonialData->field_testimonial_type_new->target_id][$nodeTesitmonialId['target_id']]['testimonial_description'] = $nodeTesitmonialData->field_testimonial_description->value;
	                     $testimonialResult[$nodeTesitmonialData->field_testimonial_type_new->target_id][$nodeTesitmonialId['target_id']]['testimonial_placement_company'] = $nodeTesitmonialData->field_placement_company->value;
	                }
	            }
	        }

	        if(!empty($testimonialResult)){
	        	foreach ($testimonialResult as $key => $value) {
		            $testimonialTypeName = (Term::load($key))->getName();
		            $iciciTestimonialTabDataOutput .= '<div id="exampleSlider111-0" class="">
		                <div class="MS-content">';  

		            foreach ($value as $key1 => $value1) {
		                if (strlen($value1['testimonial_description']) > 150){
		                    $newTestimonialData = substr($value1['testimonial_description'], 0, 150) . '...';  
		                }else{
		                    $newTestimonialData = $value1['testimonial_description'];  
		                }
		                if($value1['testimonial_type'] == 'Students Speak'){
		                    if(!empty($value1['video'])){
		                        $iciciTestimonialTabDataOutput .= '<div class="item">
		                            <iframe width="100%" height="267" src="'.$value1['video'].'?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		                            <div class="testimonalNameV">
		                                <h5>
		                                    <b>-'.$value1['title'].'</b>                      
		                                </h5>
		                                <h6>'.$value1['testimonial_placement_company'].'</h6>
		                            </div>
		                          </div>';
		                    }else{
		                        $iciciTestimonialTabDataOutput .= '<div class="item">
		                            <span class="thumbnail" href="javascript:void(0);">
		                              <img src="'.$value1['image_uri'].'" class="img-responsive"  alt="'.$value1['title'].'">
		                              <p class="mt-3">
		                                '.$newTestimonialData.'
		                              </p>
		                              <h5 class="mt-5">
		                                <b>-'.$value1['title'].'</b>                      
		                              </h5>
		                              <h6>'.$value1['testimonial_placement_company'].'</h6>
		                            </span>
		                          </div>';
		                    }
		                }
		            }
		            $iciciTestimonialTabDataOutput .= '</div>
		                <div class="MS-controls">
		                  <button class="MS-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
		                  <button class="MS-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
		                </div>
		            </div>';
		        }
	        }
        }

      $return = ['data' => $iciciTestimonialTabDataOutput ];
    
      return new JsonResponse($return);
    }
}