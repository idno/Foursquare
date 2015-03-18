<div class="row">

    <div class="col-md-10 col-md-offset-1">
	            <?=$this->draw('admin/menu')?>
        <h1>Foursquare configuration</h1>

    </div>

</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <form action="<?=\Idno\Core\site()->config()->getURL()?>admin/foursquare/" class="form-horizontal" method="post">
            <div class="controls-group">
                <div class="controls-config">
                    <p>
                        To begin using Foursquare, <a href="https://foursquare.com/developers/apps" target="_blank">create a new application in
                            the Foursquare apps portal</a>.</p>
                    <p>
                        Set the redirect URL to be:<br />
                        <input type="text" class="form-control" value="<?=\Idno\Core\site()->config()->url?>foursquare/callback" />
                    </p>
                </div>
            </div>
            
            <div class="controls-group">
	                                <p>
                        Once you've finished, fill in the details below. You can then <a href="<?=\Idno\Core\site()->config()->getURL()?>account/foursquare/">connect your Foursquare account</a>.
                    </p>
                    
                <label class="control-label" for="client-id">Client ID</label>

                    <input type="text" id="client-id" placeholder="Client ID" class="form-control" name="clientId" value="<?=htmlspecialchars(\Idno\Core\site()->config()->foursquare['clientId'])?>" >

                <label class="control-label" for="client-secret">Client secret</label>

                    <input type="text" id="client-secret" placeholder="Client secret" class="form-control" name="secret" value="<?=htmlspecialchars(\Idno\Core\site()->config()->foursquare['secret'])?>" >

            </div>
            
                      <div class="controls-group">
	          <p>
                        After the Foursquare application is configured, site users must authenticate their Foursquare account under Settings.
                    </p>

          </div>  
            <div>
                <div class="controls-save">
                    <button type="submit" class="btn btn-primary">Save settings</button>
                </div>
            </div>
            <?= \Idno\Core\site()->actions()->signForm('/admin/foursquare/')?>
        </form>
    </div>
</div>
