<div class="row">

    <div class="span10 offset1">
	            <?=$this->draw('admin/menu')?>
        <h1>Foursquare configuration</h1>

    </div>

</div>
<div class="row">
    <div class="span10 offset1">
        <form action="<?=\Idno\Core\site()->config()->getURL()?>admin/foursquare/" class="form-horizontal" method="post">
            <div class="control-group">
                <div class="controls-config">
                    <p>
                        To begin using Foursquare, <a href="https://foursquare.com/developers/apps" target="_blank">create a new application in
                            the Foursquare apps portal</a>.</p>
                    <p>
                        Set the redirect URL to be:<br />
                        <input type="text" class="span5" value="<?=\Idno\Core\site()->config()->url?>foursquare/callback" />
                    </p>
                </div>
            </div>
            <div class="control-group">
	                                <p>
                        Once you've finished, fill in the details below. You can then <a href="<?=\Idno\Core\site()->config()->getURL()?>account/foursquare/">connect your Foursquare account</a>.
                    </p>
                <label class="control-label" for="name">Client ID</label>
                <div class="controls">
                    <input type="text" id="name" placeholder="Client ID" class="span6" name="clientId" value="<?=htmlspecialchars(\Idno\Core\site()->config()->foursquare['clientId'])?>" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="name">Client secret</label>
                <div class="controls">
                    <input type="text" id="name" placeholder="Client secret" class="span6" name="secret" value="<?=htmlspecialchars(\Idno\Core\site()->config()->foursquare['secret'])?>" >
                </div>
            </div>
            
                      <div class="control-group">
	          <p>
                        After the Foursquare application is configured, you must enable it under Plugins.
                    </p>

          </div>  
            <div class="control-group">
                <div class="controls-save">
                    <button type="submit" class="btn btn-primary">Save settings</button>
                </div>
            </div>
            <?= \Idno\Core\site()->actions()->signForm('/admin/foursquare/')?>
        </form>
    </div>
</div>
