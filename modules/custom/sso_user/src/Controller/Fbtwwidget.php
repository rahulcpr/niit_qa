<?php

namespace Drupal\sso_user\Controller; 
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class Fbtwwidget extends ControllerBase {    
    public function ControllerPage() {

      $output = '<div role="tabpanel" class="tab-pane active" id="facebook">
                    <div id="fb-root"></div>
                    <script>(function (d, s, id) {
                        var js,
                            fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) {
                            return;
                        }
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.1";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, "script", "facebook-jssdk"));</script>
                    <div class="fb-page" data-href="https://www.facebook.com/NIIT4u" data-tabs="timeline" data-width="1000" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                        <div class="fb-xfbml-parse-ignore">
                            <blockquote cite="https://www.facebook.com/NIIT4u">
                                <a href="https://www.facebook.com/NIIT4u" rel="nofollow">NIIT</a>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="twitter">
                    <a class="twitter-timeline" data-height="450" href="https://twitter.com/NIITLtd?ref_src=twsrc%5Etfw" rel="nofollow">Tweets by NIITLtd</a>
                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>';
    
      return new JsonResponse($output);
    }
}