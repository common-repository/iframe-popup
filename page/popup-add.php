<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'popup-add-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<div class="wrap">
<?php
$iframepopup_errors = array();
$iframepopup_success = '';
$iframepopup_error_found = FALSE;

// Preset the form fields
$form = array(
	'id' => '',
	'title' => '',
	'url' => '',
	'width' => '',
	'height' => '',
	'transitionin' => '',
	'transitionout' => '',
	'centeronscroll' => '',
	'titleshow' => '',
	'expiration' => '',
	'starttime' => '',
	'overlaycolor' => '',
	'group' => '',
	'timeout' => ''
);

// Form submitted, check the data
if (isset($_POST['iframepopup_form_submit']) && $_POST['iframepopup_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('iframepopup_form_add');
	
	$form['title'] 			= isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
	if ($form['title'] == '')
	{
		$iframepopup_errors[] = __('Enter your title for popup window.', 'iframe-popup');
		$iframepopup_error_found = TRUE;
	}
	
	$form['url'] 			= isset($_POST['url']) ? sanitize_text_field($_POST['url']) : '';
	$form['url']			= esc_url_raw($form['url']);
	if ($form['url'] == '')
	{
		$iframepopup_errors[] = __('Enter URL to display in Iframe popup window. URL must start with either http or https', 'iframe-popup');
		$iframepopup_error_found = TRUE;
	}

	$form['width'] 			= isset($_POST['width']) ? sanitize_text_field($_POST['width']) : '';
	$form['height'] 		= isset($_POST['height']) ? sanitize_text_field($_POST['height']) : '';
	
	$form['transitionin'] 	= isset($_POST['transitionin']) ? sanitize_text_field($_POST['transitionin']) : '';
	$form['transitionin'] 	= iframepopup_cls_validation::effect_val($form['transitionin']);
	
	$form['transitionout'] 	= isset($_POST['transitionout']) ? sanitize_text_field($_POST['transitionout']) : '';
	$form['transitionout'] 	= iframepopup_cls_validation::effect_val($form['transitionout']);
	
	$form['centeronscroll'] = isset($_POST['centeronscroll']) ? sanitize_text_field($_POST['centeronscroll']) : '';
	$form['centeronscroll'] = iframepopup_cls_validation::val_tf($form['centeronscroll']);
	
	$form['titleshow'] 		= isset($_POST['titleshow']) ? sanitize_text_field($_POST['titleshow']) : '';
	$form['titleshow'] 		= iframepopup_cls_validation::val_tf($form['titleshow']);
	
	$form['expiration'] 	= isset($_POST['expiration']) ? sanitize_text_field($_POST['expiration']) : '';
	$form['starttime'] 		= isset($_POST['starttime']) ? sanitize_text_field($_POST['starttime']) : '';
	$form['overlaycolor'] 	= isset($_POST['overlaycolor']) ? sanitize_text_field($_POST['overlaycolor']) : '';
	$form['group'] 			= isset($_POST['group']) ? sanitize_text_field($_POST['group']) : '';
	$form['timeout'] 		= isset($_POST['timeout']) ? sanitize_text_field($_POST['timeout']) : '';

	//	No errors found, we can add this Group to the table
	if ($iframepopup_error_found == FALSE)
	{
		$action = iframepopup_cls_dbquery::popup_act($form, "ins");
		if($action == "sus")
		{
			$iframepopup_success = __('New details was successfully added.', 'iframe-popup');
		}
		elseif($action == "err")
		{
			$iframepopup_success = __('Oops unexpected error occurred.', 'iframe-popup');
			$iframepopup_error_found = TRUE;
		}

		// Reset the form fields
		$form = array(
			'id' => '',
			'title' => '',
			'url' => '',
			'width' => '',
			'height' => '',
			'transitionin' => '',
			'transitionout' => '',
			'centeronscroll' => '',
			'titleshow' => '',
			'expiration' => '',
			'starttime' => '',
			'overlaycolor' => '',
			'group' => '',
			'timeout' => ''
		);
	}
}

if ($iframepopup_error_found == TRUE && isset($iframepopup_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $iframepopup_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($iframepopup_error_found == FALSE && strlen($iframepopup_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $iframepopup_success; ?> <a href="<?php echo IFRAMEPOP_ADMINURL; ?>"><?php _e('Click here', 'iframe-popup'); ?></a> 
			<?php _e('to view the details', 'iframe-popup'); ?></strong></p>
	  </div>
	  <?php
	}
?>
<script language="JavaScript" src="<?php echo IFRAMEPOP_URL; ?>inc/color/jscolor.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e(IFRAMEPOP_PLUGIN_DISPLAY, 'iframe-popup'); ?></h2>
	<form name="iframepopup_form" method="post" action="#" onsubmit="return _iframepopup_submit()"  >
      <h3><?php _e('Add details', 'iframe-popup'); ?></h3>
      
	  	<label for="tag-a"><?php _e('Iframe URL', 'iframe-popup'); ?></label>
		<input name="url" type="text" id="url" value="" size="70" maxlength="255" />
		<p><?php _e('Enter URL to display in Iframe popup window. URL must start with either http or https.', 'iframe-popup'); ?><br />Example: http://www.gopiplus.com/</p>
		
		<label for="tag-a"><?php _e('Popup title', 'iframe-popup'); ?></label>
		<input name="title" type="text" id="title" value="" size="70" maxlength="255" />
		<p><?php _e('Enter your title for popup window.', 'iframe-popup'); ?></p>

		<label for="tag-a"><?php _e('Width', 'iframe-popup'); ?></label>
		<select name="width" id="width">
			<option value='30%'>30%</option>
			<option value='35%'>35%</option>
			<option value='40%'>40%</option>
			<option value='45%'>45%</option>
			<option value='50%'>50%</option>
			<option value='55%'>55%</option>
			<option value='60%' selected="selected">60%</option>
			<option value='65%'>65%</option>
			<option value='70%'>70%</option>
			<option value='75%'>75%</option>
			<option value='80%'>80%</option>
			<option value='85%'>85%</option>
			<option value='90%'>90%</option>
		</select>
		<p><?php _e('Select your width percentage for popup window.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Height', 'iframe-popup'); ?></label>
		<select name="height" id="height">
			<option value='30%'>30%</option>
			<option value='35%'>35%</option>
			<option value='40%'>40%</option>
			<option value='45%'>45%</option>
			<option value='50%'>50%</option>
			<option value='55%'>55%</option>
			<option value='60%' selected="selected">60%</option>
			<option value='65%'>65%</option>
			<option value='70%'>70%</option>
			<option value='75%'>75%</option>
			<option value='80%'>80%</option>
			<option value='85%'>85%</option>
			<option value='90%'>90%</option>
		</select>
		<p><?php _e('Select your height percentage for popup window.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Transition In', 'iframe-popup'); ?></label>
		<select name="transitionin" id="transitionin">
			<option value='fade' selected="selected">fade</option>
			<option value='elastic'>elastic</option>
			<option value='none'>none</option>
		</select>
		<p><?php _e('Transition type while opening popup window.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Transition Out', 'iframe-popup'); ?></label>
		<select name="transitionout" id="transitionout">
			<option value='fade' selected="selected">fade</option>
			<option value='elastic'>elastic</option>
			<option value='none'>none</option>
		</select>
		<p><?php _e('Transition type while closing popup window.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Center on scroll', 'iframe-popup'); ?></label>
		<select name="centeronscroll" id="centeronscroll">
			<option value='true' selected="selected">true</option>
			<option value='false'>false</option>
		</select>
		<p><?php _e('If true, popup window is centered while scrolling page.', 'iframe-popup'); ?></p>

		<label for="tag-a"><?php _e('Show Title', 'iframe-popup'); ?></label>
		<select name="titleshow" id="titleshow">
			<option value='true' selected="selected">YES</option>
			<option value='false'>NO</option>
		</select>
		<p><?php _e('Display title under popup window.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Start Date', 'iframe-popup'); ?></label>
		<input name="starttime" type="text" id="starttime" value="2016-01-01" maxlength="10" />
		<p><?php _e('Please enter popup display start date in this format YYYY-MM-DD', 'iframe-popup'); ?></p>			
		
		<label for="tag-a"><?php _e('Expiration Date', 'iframe-popup'); ?></label>
		<input name="expiration" type="text" id="expiration" value="9999-12-31" maxlength="10" />
		<p><?php _e('Please enter popup expiration date in this format YYYY-MM-DD', 'iframe-popup'); ?></p>	
		
		<label for="tag-a"><?php _e('Overlay Color', 'iframe-popup'); ?></label>
		<input class="color" type="text" name="overlaycolor" id="overlaycolor" value="#666666" maxlength="7" />
		<p><?php _e('Color of the overlay for popup window. (Example: #666666)', 'iframe-popup'); ?></p>	
		
		<label for="tag-a"><?php _e('Category', 'iframe-popup'); ?></label>
		<select name="group" id="group">
			<?php for($i=1; $i<=15; $i++) { ?>
				<option value='Category<?php echo $i; ?>'>Category<?php echo $i; ?></option>
			<?php } ?>
		</select>
		<p><?php _e('Select category for this popup content.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Timeout', 'iframe-popup'); ?></label>
		<select name="timeout" id="timeout">
			<option value='1000'>1 Sec</option>
			<option value='2000'>2 Sec</option>
			<option value='4000' selected="selected">4 Sec</option>
			<option value='6000'>6 Sec</option>
			<option value='8000'>8 Sec</option>
			<option value='10000'>10 Sec</option>
			<option value='12000'>12 Sec</option>
			<option value='15000'>15 Sec</option>
			<option value='20000'>20 Sec</option>
		</select>
		<p><?php _e('Timeout to open popup window.', 'iframe-popup'); ?></p>
	  
      <input name="id" id="id" type="hidden" value="">
      <input type="hidden" name="iframepopup_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Submit', 'iframe-popup'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_iframepopup_redirect()" value="<?php _e('Cancel', 'iframe-popup'); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_iframepopup_help()" value="<?php _e('Help', 'iframe-popup'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('iframepopup_form_add'); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo wp_create_nonce( 'popup-add-nonce' ); ?>"/>
    </form>
</div>
<p class="description"><?php echo IFRAMEPOP_OFFICIAL; ?></p>
</div>