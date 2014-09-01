<?php

    if ($foursquare = \Idno\Core\site()->plugins()->get('Foursquare')) {
        $login_url = $foursquare->getAuthURL();
    }

?>
<div class="social">
    <a href="<?= $login_url ?>" class="connect fsqr <?php

        if (!empty(\Idno\Core\site()->session()->currentUser()->foursquare['access_token'])) {
            echo 'connected';
        }

    ?>" target="_top">Foursquare<?php

            if (!empty(\Idno\Core\site()->session()->currentUser()->foursquare['access_token'])) {
                echo ' - connected!';
            }

        ?></a>
    <label class="control-label">Share locations to Foursquare.</label>
</div>