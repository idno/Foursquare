<div class="row">

    <div class="span10 offset1">
        <?= $this->draw('account/menu') ?>
        <h1>Foursquare</h1>

    </div>

</div>
<div class="row">
    <div class="span10 offset1">
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
                                    With Foursquare connected, you can cross-post check-ins that you publish publicly on
                                    your site.
                                </p>
                            </div>
                        </div>
                        <div class="social span6">

                            <p>
                                <a href="<?= $vars['login_url'] ?>" class="connect fsqr">Connect Foursquare</a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php

            } else if (!\Idno\Core\site()->config()->multipleSyndicationAccounts()) {

                ?>
                <div class="control-group">
                    <div class="controls-config">
                        <div class="row">
                            <div class="span6">
                                <p>
                                    Your account is currently connected to Foursquare. Public check-ins that you publish
                                    here
                                    can be cross-posted to Foursquare.
                                </p>

                        <div class="social span6">
                            <form action="<?= \Idno\Core\site()->config()->getDisplayURL() ?>foursquare/deauth"
                                  class="form-horizontal" method="post">
                                <p>
                                    <input type="hidden" name="remove" value="1"/>
                                    <button type="submit" class="connect fsqr connected">Disconnect Foursquare</button>
                                    <?= \Idno\Core\site()->actions()->signForm('/account/foursquare/') ?>
                                </p>
                            </form>
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
                                    You have connected the following Foursquare accounts. Public check-ins that you
                                    publish here
                                    can be cross-posted to Foursquare.
                                </p>
   
                        <?php

                            if ($accounts = \Idno\Core\site()->syndication()->getServiceAccounts('foursquare')) {

                                foreach ($accounts as $account) {

                                    ?>
                                    <div class="social span6">
                                    <form action="<?= \Idno\Core\site()->config()->getDisplayURL() ?>foursquare/deauth"
                                          class="form-horizontal" method="post">
                                        <p>
                                            <input type="hidden" name="remove" value="<?= $account['username'] ?>"/>
                                            <button type="submit"
                                                    class="connect fsqr connected"><?= $account['name'] ?> (Disconnect)
                                            </button>
                                            <?= \Idno\Core\site()->actions()->signForm('/foursquare/deauth/') ?>
                                        </p>
                                    </form>
                                    </div>
                                <?php

                                }

                            } else {

                                ?>
                    			
                                <div class="social span6">
                                    <form action="<?= \Idno\Core\site()->config()->getDisplayURL() ?>foursquare/deauth"
                                          class="form-horizontal" method="post">
                                        <p>
                                            <input type="hidden" name="remove" value="1"/>
                                            <button type="submit" class="connect fsqr connected">Disconnect Foursquare
                                            </button>
                                            <?= \Idno\Core\site()->actions()->signForm('/account/foursquare/') ?>
                                        </p>
                                    </form>
                                    </div>

                            <?php

                            }

                        ?>
                    			
									<p>
										<a href="<?= $vars['login_url'] ?>" class=""><icon class="icon-plus"></icon> Click here
                            to connect another Foursquare account</a>
                    				</p>
                    	</div>
                	</div>
    			</div>
               </div>
            <?php

            }
        ?>
    </div>
</div>
