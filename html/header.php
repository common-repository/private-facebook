<div id="private-facebook">
	<h1>Private Facebook</h1>
	<small>Your blog, the private way</small>

	<div id="set-facebook-app" class="information <?= (!$facebook)?(''):('hidden') ?>">
		You need to <strong>create and configure a new Facebook app</strong> to use this plugin —
		<a href="https://developers.facebook.com/apps" target="_blank">click here to create a new app</a>.
		
		<form method="post">
		<div id="settings">
			<span>
				<label>App ID <input type="text" name="facebook_app_id" class="classic" value="<?= get_option("pf_facebook_app_id", null) ?>" /></label>
			</span>
			<span>
				<label>Secret key <input type="text" name="facebook_secret_id" class="classic" value="<?= get_option("pf_facebook_secret_id", null) ?>" /></label>
				<input type="submit" class="button-secondary action big" value="Save settings" />
			</span>
		</div>
		</form>
		<div class="clear">&nbsp;</div>
	</div>

	<div class="show-settings <?= (isset($facebook) && $facebook)?(''):('hidden') ?>">
		<a onclick="jQuery('#set-facebook-app').fadeIn(); jQuery('.show-settings').hide();" class="button-secondary action big">Show settings</a>
	</div>
