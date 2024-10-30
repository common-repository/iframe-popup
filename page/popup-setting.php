<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'popup-setting-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e(IFRAMEPOP_PLUGIN_DISPLAY, 'iframe-popup'); ?></h2>
    <?php
	$iframepopup_session = get_option('iframepopup_session');

	if (isset($_POST['iframepopup_form_submit']) && $_POST['iframepopup_form_submit'] == 'yes')
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('iframepopup_form_setting');
			
		$iframepopup_session = stripslashes(sanitize_text_field($_POST['iframepopup_session']));	
		if($iframepopup_session != "YES" && $iframepopup_session != "NO")
		{
			$iframepopup_session = "NO";
		} 
		
		update_option('iframepopup_session', $iframepopup_session );
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details was successfully updated.', 'iframe-popup'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<h3><?php _e('Session Setting', 'iframe-popup'); ?></h3>
	<form name="iframepopup_form_setting" method="post" action="#" onsubmit="return _iframepopup_submit_setting()">
		<label for="tag-title"><?php _e('Session option (Global setting)', 'iframe-popup'); ?></label>
		<select name="iframepopup_session" id="iframepopup_session">
            <option value=''>Select</option>
			<option value='NO' <?php if($iframepopup_session == 'NO') { echo 'selected' ; } ?>>NO</option>
            <option value='YES' <?php if($iframepopup_session == 'YES') { echo 'selected' ; } ?>>YES</option>
          </select>
		<p><?php _e('Select YES to show popup once per session, Meaning, popup never appear again if user navigate to another page.', 'iframe-popup'); ?></p>
				
		<div style="height:10px;"></div>
		<input type="hidden" name="iframepopup_form_submit" value="yes"/>
		<input name="iframepopup_submit" id="iframepopup_submit" class="button" value="<?php _e('Submit', 'iframe-popup'); ?>" type="submit" />
		<input name="publish" lang="publish" class="button" onclick="_iframepopup_redirect()" value="<?php _e('Cancel', 'iframe-popup'); ?>" type="button" />
		<input name="Help" lang="publish" class="button" onclick="_iframepopup_help()" value="<?php _e('Help', 'iframe-popup'); ?>" type="button" />
		<?php wp_nonce_field('iframepopup_form_setting'); ?>
		<input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo wp_create_nonce( 'popup-setting-nonce' ); ?>"/>
	</form>
  </div>
  <br />
  <p class="description"><?php echo IFRAMEPOP_OFFICIAL; ?></p>
</div>