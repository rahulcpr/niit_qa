<?php

namespace Drupal\ms_ajax_form_example\Step;

use Drupal\ms_ajax_form_example\Button\StepThreePreviousButton;

/**
 * Class StepFinalize.
 *
 * @package Drupal\ms_ajax_form_example\Step
 */
class StepFinalize extends BaseStep {

  /**
   * {@inheritdoc}
   */
  protected function setStep() {
    return StepsEnum::STEP_FINALIZE;
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
      new StepThreePreviousButton(),
    ];
  }
  
  public function GetStepMessage($screen_id){
    $html='Your Request submited to NIIT team';
    if($screen_id != ''){
        $field_query=  db_select('camp_ms_form__field_submission_message','msg');
        $field_query->fields('msg',array('field_submission_message_value'));
        $field_query->condition('msg.entity_id',$screen_id);
        $field_values=$field_query->execute()->fetchCol();
        $html='';
        $html.='<h3 class="sucess"><i class="far fa-check-circle"></i>
            </h3><h4>'.$field_values[0].'</h4>';
        unset($_SESSION['step_message']);
    }
    return $html;
  }

  /**
   * {@inheritdoc}
   */
  public function buildStepFormElements($form_name) {

    if(isset($_SESSION['form_step']) && $_SESSION['form_step'] == 3){
      $userName = ''; 
      if(isset($_SESSION['finalResult']) && !empty($_SESSION['finalResult'])){
         $userName = $_SESSION['finalResult']['json_data']->enqry_f_nm;
      }
            
      $not_eligible_data = '<div class = "embedFormFinalMsg sorry-msg">
                              <h3 class="sucess-pop"><i class="fa fa-frown-o"></i></h3>
                              <h4 class="leadPopFinalText">Sorry, '.$userName.' <br> <small class="errorTextPop">You are not eligible for this program</small></h4>
                            </diV>';

      $form['completed'] = [
        '#type' => 'markup',
        '#markup' => $not_eligible_data,
        '#allowed_tags' => ['h1', 'h2', 'h3','h4','h5','h6', 'span', 'ul', 'li','strong', 'p', 'div', 'i', 'input', 'small', 'br'],
      ];

      //echo'<pre>'; print_r($_SESSION['finalResult']); die('gg');

      $return_value['f_field']=$form;


    }
    else{

      $create_application = $_SESSION['create_application'];
      $form['markup_script'] = [
        '#markup' => '<div class="markup_script"></div>',
      ];
      $form['title_script'] = array(
        '#type' => 'markup',
        '#markup' => '<script>
            jQuery("html, body").animate({scrollTop: jQuery(".markup_script").offset().top -100}, 500);
          </script>',
        '#allowed_tags' => ['script'],
      );
      
        $data = '';
        $hidden_popup_data = '';
        $check_eligibility = $_SESSION['check_eligibility'];
       
        if($check_eligibility['IsEligible'] == 1){
          $final_formdata = $_SESSION['final_formdata'];
          $name = $final_formdata['enqry_f_nm'];
          $final_json = create_application($final_formdata);

           $data_hson = $final_formdata['source'];
          \Drupal::logger('my_module')->info($data_hson);

          if($final_json != 'Fail'){
            // $url = $_ENV['Admission_Application'];
            // if($final_formdata['campaign'] == 'NIITSTCK'){
            //   $url = $_ENV['Stackroute_Admission_Application'];
            // }
            //$url = 'https://admissionqa.niit.com/Admission/Ifbi/Application.aspx';
            if($create_application == 1){
            $url = $final_formdata['enroll_link'];
        
            if($final_formdata['NewSignup'] == 'false' || empty($final_formdata['enroll_link'])){
              $url = $_ENV['Admission_loginurl'];
            }
          //  $continue_btn = '';
          //  $continue_msg = 'You are eligible for the program. Our program advisor will call you shortly.';
          //  if($final_formdata['isAppliedCenter'] == 1 && in_array($final_formdata['prfrd_cntr'], explode(', ', $final_formdata['centerListData']))){
              $continue_btn = '<form id="" name="form" method="post" action="'.$url.'" class="ContinueYourApplicationForm">
              <input type="hidden" name="eventdata" value="">
              <input type="hidden" name="token" value="'.$final_json.'" tabindex="0">
              <input type="submit" value="Complete Your Application" class="btn btn-primary continue-btn">
              </form>
              <div class="lead-des pt-3"> Taking you to application form in <span id="pageBeginCountdownText" class="pageBeginCountdownText">5</span> seconds.</div>
              <div class="hideScript"><script>
              countiuneYourApplicationPageRedirectScript();
              countiuneYourApplicationEventData();
              </script></div>';
              $continue_msg = 'You are eligible to apply for the programme.';
           // }
            }
            else{
              $continue_btn = '';
              $continue_msg = 'You are eligible for the program. Our program advisor will call you shortly.';
            }
            
  // <div class="remind_me">Remind me Later</div>
            $data .= '<div class="check_eligibility_display embed-data">
                        <div class="check_eligibility_success">
                          <div class="continue-data">
                            <div class="col-md-12 emb-img">
                              <img src= "/india/themes/custom/nexus/assets/images/confirm-popup.png" class="img-responsive">
                            </div>
                            <div class="col-md-12 emb-data">
                              <div class="congrats">Congratulations</div>
                              <div class="lead-name">'.$name.'</div>
                              <div class="lead-des">'.$continue_msg.'</div>
                              <div class="continue-form">'.$continue_btn.'</div>
                             
                            </div>
                          </div>
                        </div>
                      </div>
                <script>
                checkEligibilityFormEventAll("CheckEligibilityForm", "ApplicationSuccess");
                </script>';

            $form['completed'] = [
              '#markup' => $data,
              '#allowed_tags' => ['h1', 'h2', 'h3','h4','h5','h6', 'span', 'ul', 'li','strong', 'p', 'div', 'form', 'input', 'img', 'script'],
             // HASH_PREFIX => $data,
            ];
        
        $hidden_popup_data .= '<div class="check_eligibility_display_hidden">
                                      <div class="display_hidden">
                                        <div class="row continue-data">
                                          <div class="col-sm-12 left-part">
                                            <img src= "/india/themes/custom/nexus/assets/images/confirm-popup.png" class="img-responsive">
                                          </div>
                                          <div class="col-sm-12 right-part">
                                            <div class="congrats">Congratulations</div>
                                            <div class="lead-name">'.$name.'</div>
                                            <div class="lead-des">'.$continue_msg.'</div>
                                            <div class="continue-form">'.$continue_btn.'</div>
                                           
                                        </div>
                                      </div>
                                    </div><div class="last_step_data_display"></div>';

              $form['hidden_popup_data'] = [
                '#markup' => $hidden_popup_data,
                '#allowed_tags' => ['h1', 'h2', 'h3','h4','h5','h6', 'span', 'ul', 'li','strong', 'p', 'div', 'form', 'input', 'img'],
              ];
        
          $script_data = "<script>
                        var data = jQuery('.check_eligibility_display_hidden').html();
                        jQuery('.check_eligibility_display_popup .full_data').html(data);
                      </script>";
            $form['hidden_popup_script_data'] = [
              '#markup' => $script_data,
              '#allowed_tags' => ['script'],
            ];
            if(isset($_SESSION['web_popup']) && $_SESSION['web_popup'] == 1){
              

              $script = "<script>
                          jQuery('#check_eligibility_display').modal('show');
                        </script>";
               $form['hidden_popup_script'] = [
                '#markup' => $script,
                '#allowed_tags' => ['script'],
              ];

            }

         }

        }
        else if($check_eligibility['IsEligible'] == 0){
          $final_formdata = $_SESSION['final_formdata'];
          $name = $final_formdata['enqry_f_nm'];
          // $data .= '<div class="check_eligibility_display"><ul class="check_eligibility_error">';
          // foreach ($check_eligibility['reason'] as $key => $value) {
          //   $data .= '<li class="check_eligibility_list">'.$value.'</li>';
          // }
          // $data .= '</ul></div>';

          $data .= '<div class = "embedFormFinalMsg">
                      <img src="/india/themes/custom/nexus/assets/images/cartoon-exhausted-woman-sitting.png" class="img-responsive">
                      <h4 class="leadPopFinalText">Sorry, '.$name.' <br> <small class="errorTextPop">You are not eligible for this program</small></h4>
                      <a href="https://sandbox-preprod.niit.com/india/search/content?keys=java" class="explore-more-courses">Explore More Courses</a>
                    </diV>
                    <script>
                      checkEligibilityFormEventAll("CheckEligibilityForm", "ApplicationFail");
                    </script>';

          $form['completed'] = [
            '#markup' => $data,
            '#allowed_tags' => ['h1', 'h2', 'h3','h4','h5','h6', 'span', 'ul', 'li','strong', 'p', 'div', 'br', 'i', 'small', 'script', 'img', 'a'],
           // HASH_PREFIX => $data,
          ];


      $hidden_popup_data .= '<div class="check_eligibility_display_hidden"><div class="display_hidden"><div class = "embedFormFinalMsg">
                      <img src="/india/themes/custom/nexus/assets/images/cartoon-exhausted-woman-sitting.png" class="img-responsive">
                      <h4 class="leadPopFinalText">Sorry, '.$name.' <br> <small class="errorTextPop">You are not eligible for this program1</small></h4>
                      <a href="https://sandbox-preprod.niit.com/india/search/content?keys=java" class="explore-more-courses">Explore More Courses</a>
                    </diV></div></div><div class="last_step_data_display"></div>';

            $form['hidden_popup_data'] = [
              '#markup' => $hidden_popup_data,
              '#allowed_tags' => ['h1', 'h2', 'h3','h4','h5','h6', 'span', 'ul', 'li','strong', 'p', 'div', 'br', 'i', 'small', 'script', 'img', 'a'],
            ];
      
      $script_data = "<script>
                        var data = jQuery('.check_eligibility_display_hidden').html();
                        jQuery('.check_eligibility_display_popup .full_data').html(data);
                      </script>";
            $form['hidden_popup_script_data'] = [
              '#markup' => $script_data,
              '#allowed_tags' => ['script'],
            ];

          if(isset($_SESSION['web_popup']) && $_SESSION['web_popup'] == 1){

            

            $script = "<script>
                        jQuery('#check_eligibility_display').modal('show');
                      </script>";
             $form['hidden_popup_script'] = [
              '#markup' => $script,
              '#allowed_tags' => ['script'],
            ];

          }

        }
        else{
          if(isset($_SESSION['screen_id'])){
            $form[HASH_PREFIX] = '<div class = "embedFormFinalMsg">';
            $form['completed'] = [
              '#markup' => '',
              HASH_PREFIX =>$this->GetStepMessage($_SESSION['screen_id']),
            ];
            $form[HASH_SUFFIX] = '</div>';
          }
        }

      $return_value['f_field']=$form;
      /**unset session veriables */

      unset($_SESSION['web_popup']);
      unset($_SESSION['create_application']);
      unset($_SESSION['check_eligibility']);
      unset($_SESSION['final_formdata']);
      unset($_SESSION['screen_id']);
      unset($_SESSION['get_form']);
      unset($_SESSION['last_step']);
      unset($_SESSION['step_message']);
      unset($_SESSION['form_step']);


    }

    

    /** */
    return $return_value;
  }

}
