<div class="row">

    <div class="span10 offset1">
        <?=$this->draw('account/menu')?>
        <h1>Foursquare</h1>

    </div>

</div>
<div class="row">
    <div class="span10 offset1">
        <form action="/account/foursquare/" class="form-horizontal" method="post">
            <?php
                if (empty(\Idno\Core\site()->session()->currentUser()->foursquare)) {
            ?>
                    <div class="control-group">
                        <div class="controls-config">
	                       <div class="row">
						   		<div class="span6">
                            <p>
                                Easily share locations to Foursquare.</p>  
                                
                                <p>
                                With Foursquare connected, you can cross-post check-ins that you publish publicly on your site.
                            </p>
						   		</div>
	                       </div>
	                       <div class="social span4">
	                       
                            <p>
                                <a href="<?=$vars['login_url']?>" class="connect fsqr">Connect Foursquare</a>
                            </p>
	                       </div>
                        </div>
                    </div>
                <?php

                } else {

                    ?>
                    <div class="control-group">
                        <div class="controls-config">
	                       <div class="row">
						    <div class="span6">
                            <p>
                                Your account is currently connected to Foursquare. Public check-ins that you publish here
                                can be cross-posted to Foursquare.
                            </p>
						    </div>
	                       </div>
	                       <div class="social">
                            <p>
                                <input type="hidden" name="remove" value="1" />
                                <button type="submit" class="connect fsqr connected">Disconnect Foursquare</button>
                            </p>
	                       </div>
                        </div>
                    </div>

                <?php

                }
            ?>
            <?= \Idno\Core\site()->actions()->signForm('/account/foursquare/')?>
        </form>
    </div>
</div>
