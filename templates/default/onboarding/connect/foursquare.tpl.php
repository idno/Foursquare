<?php

    if ($foursquare = \Idno\Core\site()->plugins()->get('Foursquare')) {
        $login_url = $foursquare->getAuthURL();
    }

?>
<div class="social">
    <a href="<?= $login_url ?>" class="connect fsqr <?php

        if (!empty(\Idno\Core\site()->session()->currentUser()->foursquare)) {
            echo 'connected';
        }

    ?>">Foursquare<?php

            if (!empty(\Idno\Core\site()->session()->currentUser()->foursquare)) {
                echo ' - connected!';
            }

        ?></a>
    <label class="control-label">Share locations to Foursquare.</label>
</div>