<div class="row">

    <div class="col-md-10 col-md-offset-1">
        <?= $this->draw('account/menu') ?>
        <h1>Foursquare</h1>

    </div>

</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <?php
            if (empty(\Idno\Core\site()->session()->currentUser()->foursquare)) {
                ?>
                <div class="control-group">
                    <div class="controls-config">
                        <div class="row">
                            <div class="col-md-7">
                                <p>
                                    Easily share locations to Foursquare.</p>

                                <p>
                                    With Foursquare connected, you can cross-post check-ins that you publish publicly on
                                    your site.
                                </p>
                            </div>
                        </div>

                        <div class="social">

                            <p>
                                <a href="<?= $vars['login_url'] ?>" class="connect fsqr"><i class="fa fa-foursquare"></i> Connect Foursquare</a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php

            } else if (!\Idno\Core\site()->config()->multipleSyndicationAccounts()) {

                ?>
                <div class="controls-group">
                    <div class="controls-config">
                        <div class="row">
                            <div class="col-md-7">
                                <p>
                                    Your account is currently connected to Foursquare. Public check-ins that you publish
                                    here
                                    can be cross-posted to Foursquare.
                                </p>


								<div class="social">
									<form action="<?= \Idno\Core\site()->config()->getDisplayURL() ?>foursquare/deauth"
                                  class="form-horizontal" method="post">
								  <p>
                                    <input type="hidden" name="remove" value="1" />
                                    <button type="submit" class="connect fsqr connected"><i class="fa fa-foursquare"></i>
 Disconnect Foursquare</button>
                                    <?= \Idno\Core\site()->actions()->signForm('/account/foursquare/') ?>
									</p>
                            		</form>

                				</div>

            <?php

            } else {

                ?>
                <div class="controls-group">
                    <div class="controls-config">
                        <div class="row">
                            <div class="col-md-7">

			   					<p>
                                    You have connected the following Foursquare accounts. Public check-ins that you
                                    publish here
                                    can be cross-posted to Foursquare.
                                </p>
   
                        <?php

                            if ($accounts = \Idno\Core\site()->syndication()->getServiceAccounts('foursquare')) {

                                foreach ($accounts as $account) {

                                    ?>
                                    <div class="social">
                                    <form action="<?= \Idno\Core\site()->config()->getDisplayURL() ?>foursquare/deauth"
                                          class="form-horizontal" method="post">
                                        <p>
                                            <input type="hidden" name="remove" class="form-control" value="<?= $account['username'] ?>"/>
                                            <button type="submit"
                                                    class="connect fsqr connected"><i class="fa fa-foursquare"></i>
 <?= $account['name'] ?> (Disconnect)
                                            </button>
                                            <?= \Idno\Core\site()->actions()->signForm('/foursquare/deauth/') ?>
                                        </p>
                                    </form>
                                    </div>
                                <?php

                                }

                            } else {

                                ?>
                    			
                                	<div class="social">
                                    <form action="<?= \Idno\Core\site()->config()->getDisplayURL() ?>foursquare/deauth"
                                          class="form-horizontal" method="post">
                                        <p>
                                            <input type="hidden" name="remove" value="1" class="form-control" />
                                            <button type="submit" class="connect fsqr connected"><i class="fa fa-foursquare"></i>
 Disconnect Foursquare
                                            </button>
                                            <?= \Idno\Core\site()->actions()->signForm('/account/foursquare/') ?>
                                        </p>
                                    </form>
                                    </div>

                            <?php

                            }

                        ?>
                    			
									<p>
										<a href="<?= $vars['login_url'] ?>" class=""><i class="fa fa-plus"></i> Add another Foursquare account</a>
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
