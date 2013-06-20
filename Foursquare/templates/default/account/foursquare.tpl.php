<div class="row">

    <div class="span10 offset1">
        <h3>Foursquare</h3>
        <?=$this->draw('account/menu')?>
    </div>

</div>
<div class="row">
    <div class="span10 offset1">
        <form action="/account/foursquare/" class="form-horizontal" method="post">
            <?php
                if (empty(\Idno\Core\site()->session()->currentUser()->foursquare)) {
            ?>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                If you have a Foursquare account, you may connect it here. Your
                                public checkins on this site will be copeied to Foursquare.
                            </p>
                            <p>
                                <a href="<?=$vars['login_url']?>" class="btn btn-large btn-success">Click here to connect Foursquare to your account</a>
                            </p>
                        </div>
                    </div>
                <?php

                } else {

                    ?>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                Your account is currently connected to Foursquare. Public checkins that you make here
                                will be syndicated to Foursquare.
                            </p>
                            <p>
                                <input type="hidden" name="remove" value="1" />
                                <button type="submit" class="btn-primary">Click here to remove Foursquare from your account.</button>
                            </p>
                        </div>
                    </div>

                <?php

                }
            ?>
            <?= \Idno\Core\site()->actions()->signForm('/account/foursquare/')?>
        </form>
    </div>
</div>