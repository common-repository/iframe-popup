<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'popup-edit-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? sanitize_text_field($_GET['did']) : '0';
if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }

// First check if ID exist with requested ID
$result = '0';
$result = iframepopup_cls_dbquery::popup_count($did);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'iframe-popup'); ?></strong></p></div><?php
}
else
{
	$iframepopup_errors = array();
	$iframepopup_success = '';
	$iframepopup_error_found = FALSE;
	
	$data = array();
	$data = iframepopup_cls_dbquery::popup_select($did);
	
	// Preset the form fields
	$form = array(
		'id' => $data[0]['id'],
		'title' => $data[0]['title'],
		'url' => $data[0]['url'],
		'width' => $data[0]['width'],
		'height' => $data[0]['height'],
		'transitionin' => $data[0]['transitionin'],
		'transitionout' => $data[0]['transitionout'],
		'centeronscroll' => $data[0]['centeronscroll'],
		'titleshow' => $data[0]['titleshow'],
		'expiration' => $data[0]['expiration'],
		'starttime' => $data[0]['starttime'],
		'overlaycolor' => $data[0]['overlaycolor'],
		'group' => $data[0]['group'],
		'timeout' => $data[0]['timeout']
	);
}
// Form submitted, check the data
if (isset($_POST['iframepopup_form_submit']) && $_POST['iframepopup_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('iframepopup_form_edit');
	
	$form['title']			= isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
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
	$form['centeronscroll'] 	= iframepopup_cls_validation::val_tf($form['centeronscroll']);
	
	$form['titleshow'] 		= isset($_POST['titleshow']) ? sanitize_text_field($_POST['titleshow']) : '';
	$form['titleshow'] 		= iframepopup_cls_validation::val_tf($form['titleshow']);
	
	$form['expiration'] 	= isset($_POST['expiration']) ? sanitize_text_field($_POST['expiration']) : '';
	$form['starttime'] 		= isset($_POST['starttime']) ? sanitize_text_field($_POST['starttime']) : '';
	$form['overlaycolor'] 	= isset($_POST['overlaycolor']) ? sanitize_text_field($_POST['overlaycolor']) : '';
	$form['group'] 			= isset($_POST['group']) ? sanitize_text_field($_POST['group']) : '';
	$form['timeout'] 		= isset($_POST['timeout']) ? sanitize_text_field($_POST['timeout']) : '';
	$form['id'] 			= isset($_POST['id']) ? sanitize_text_field($_POST['id']) : '';

	//	No errors found, we can add this Group to the table
	if ($iframepopup_error_found == FALSE)
	{	
		$action = iframepopup_cls_dbquery::popup_act($form, "ups");
		if($action == "sus")
		{
			$iframepopup_success = __('Details was successfully updated.', 'iframe-popup');
		}
		elseif($action == "err")
		{
			$iframepopup_success = __('Oops unexpected error occurred.', 'iframe-popup');
			$iframepopup_error_found = TRUE;
		}
	}
}

if ($iframepopup_error_found == TRUE && isset($iframepopup_errors[0]) == TRUE)
{
	?><div class="error fade"><p><strong><?php echo $iframepopup_errors[0]; ?></strong></p></div><?php
}
if ($iframepopup_error_found == FALSE && strlen($iframepopup_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $iframepopup_success; ?> 
		<a href="<?php echo IFRAMEPOP_ADMINURL; ?>"><?php _e('Click here', 'iframe-popup'); ?></a> 
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
      <h3><?php _e('Update details', 'iframe-popup'); ?></h3>
	  
	  	<label for="tag-a"><?php _e('Iframe URL', 'iframe-popup'); ?></label>
		<input name="url" type="text" id="url" value="<?php echo $form['url']; ?>" size="70" maxlength="255" />
		<p><?php _e('Enter URL to display in Iframe popup window. URL must start with either http or https.', 'iframe-popup'); ?><br />Example: http://www.gopiplus.com/</p>
		
		<label for="tag-a"><?php _e('Popup title', 'iframe-popup'); ?></label>
		<input name="title" type="text" id="title" value="<?php echo $form['title']; ?>" size="70" maxlength="255" />
		<p><?php _e('Enter your title for popup window.', 'iframe-popup'); ?></p>

		<label for="tag-a"><?php _e('Width', 'iframe-popup'); ?></label>
		<select name="width" id="width">
			<option value='30%' <?php if($form['width'] == '30%') { echo "selected='selected'" ; } ?>>30%</option>
			<option value='35%' <?php if($form['width'] == '35%') { echo "selected='selected'" ; } ?>>35%</option>
			<option value='40%' <?php if($form['width'] == '40%') { echo "selected='selected'" ; } ?>>40%</option>
			<option value='45%' <?php if($form['width'] == '45%') { echo "selected='selected'" ; } ?>>45%</option>
			<option value='50%' <?php if($form['width'] == '50%') { echo "selected='selected'" ; } ?>>50%</option>
			<option value='55%' <?php if($form['width'] == '55%') { echo "selected='selected'" ; } ?>>55%</option>
			<option value='60%' <?php if($form['width'] == '60%') { echo "selected='selected'" ; } ?>>60%</option>
			<option value='65%' <?php if($form['width'] == '65%') { echo "selected='selected'" ; } ?>>65%</option>
			<option value='70%' <?php if($form['width'] == '70%') { echo "selected='selected'" ; } ?>>70%</option>
			<option value='75%' <?php if($form['width'] == '75%') { echo "selected='selected'" ; } ?>>75%</option>
			<option value='80%' <?php if($form['width'] == '80%') { echo "selected='selected'" ; } ?>>80%</option>
			<option value='85%' <?php if($form['width'] == '85%') { echo "selected='selected'" ; } ?>>85%</option>
			<option value='90%' <?php if($form['width'] == '90%') { echo "selected='selected'" ; } ?>>90%</option>
		</select>
		<p><?php _e('Select your width percentage for popup window.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Height', 'iframe-popup'); ?></label>
		<select name="height" id="height">
			<option value='30%' <?php if($form['height'] == '30%') { echo "selected='selected'" ; } ?>>30%</option>
			<option value='35%' <?php if($form['height'] == '35%') { echo "selected='selected'" ; } ?>>35%</option>
			<option value='40%' <?php if($form['height'] == '40%') { echo "selected='selected'" ; } ?>>40%</option>
			<option value='45%' <?php if($form['height'] == '45%') { echo "selected='selected'" ; } ?>>45%</option>
			<option value='50%' <?php if($form['height'] == '50%') { echo "selected='selected'" ; } ?>>50%</option>
			<option value='55%' <?php if($form['height'] == '55%') { echo "selected='selected'" ; } ?>>55%</option>
			<option value='60%' <?php if($form['height'] == '60%') { echo "selected='selected'" ; } ?>>60%</option>
			<option value='65%' <?php if($form['height'] == '65%') { echo "selected='selected'" ; } ?>>65%</option>
			<option value='70%' <?php if($form['height'] == '70%') { echo "selected='selected'" ; } ?>>70%</option>
			<option value='75%' <?php if($form['height'] == '75%') { echo "selected='selected'" ; } ?>>75%</option>
			<option value='80%' <?php if($form['height'] == '80%') { echo "selected='selected'" ; } ?>>80%</option>
			<option value='85%' <?php if($form['height'] == '85%') { echo "selected='selected'" ; } ?>>85%</option>
			<option value='90%' <?php if($form['height'] == '90%') { echo "selected='selected'" ; } ?>>90%</option>
		</select>
		<p><?php _e('Select your height percentage for popup window.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Transition In', 'iframe-popup'); ?></label>
		<select name="transitionin" id="transitionin">
			<option value='fade' <?php if($form['transitionin'] == 'fade') { echo "selected='selected'" ; } ?>>fade</option>
			<option value='elastic' <?php if($form['transitionin'] == 'elastic') { echo "selected='selected'" ; } ?>>elastic</option>
			<option value='none' <?php if($form['transitionin'] == 'none') { echo "selected='selected'" ; } ?>>none</option>
		</select>
		<p><?php _e('Transition type while opening popup window.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Transition Out', 'iframe-popup'); ?></label>
		<select name="transitionout" id="transitionout">
			<option value='fade' <?php if($form['transitionout'] == 'fade') { echo "selected='selected'" ; } ?>>fade</option>
			<option value='elastic' <?php if($form['transitionout'] == 'elastic') { echo "selected='selected'" ; } ?>>elastic</option>
			<option value='none' <?php if($form['transitionout'] == 'none') { echo "selected='selected'" ; } ?>>none</option>
		</select>
		<p><?php _e('Transition type while closing popup window.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Center on scroll', 'iframe-popup'); ?></label>
		<select name="centeronscroll" id="centeronscroll">
			<option value='true' <?php if($form['centeronscroll'] == 'true') { echo "selected='selected'" ; } ?>>true</option>
			<option value='false' <?php if($form['centeronscroll'] == 'false') { echo "selected='selected'" ; } ?>>false</option>
		</select>
		<p><?php _e('If true, popup window is centered while scrolling page.', 'iframe-popup'); ?></p>

		<label for="tag-a"><?php _e('Show Title', 'iframe-popup'); ?></label>
		<select name="titleshow" id="titleshow">
			<option value='true' <?php if($form['titleshow'] == 'true') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='false' <?php if($form['titleshow'] == 'false') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('Display title under popup window.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Start Date', 'iframe-popup'); ?></label>
		<input name="starttime" type="text" id="starttime" value="<?php echo substr($form['starttime'],0,10); ?>" maxlength="10" />
		<p><?php _e('Please enter popup display start date in this format YYYY-MM-DD', 'iframe-popup'); ?></p>			
		
		<label for="tag-a"><?php _e('Expiration Date', 'iframe-popup'); ?></label>
		<input name="expiration" type="text" id="expiration" value="<?php echo substr($form['expiration'],0,10); ?>" maxlength="10" />
		<p><?php _e('Please enter popup expiration date in this format YYYY-MM-DD', 'iframe-popup'); ?></p>	
		
		<label for="tag-a"><?php _e('Overlay Color', 'iframe-popup'); ?></label>
		<input class="color" name="overlaycolor" type="text" id="overlaycolor" value="<?php echo $form['overlaycolor']; ?>" maxlength="7" />
		<p><?php _e('Color of the overlay for popup window. (Example: #666666)', 'iframe-popup'); ?></p>	
		
		<label for="tag-a"><?php _e('Category', 'iframe-popup'); ?></label>
		<?php
		$thisselected = "";
		?>
		<select name="group" id="group">
			<?php 
			for($i=1; $i<=15; $i++) 
			{ 
				if($form['group'] == "Category".$i) 
				{ 
					$thisselected = "selected='selected'" ; 
				}
				?><option value='Category<?php echo $i; ?>' <?php echo $thisselected; ?>>Category<?php echo $i; ?></option><?php
				$thisselected = "";
			} 
			?>
		</select>
		<p><?php _e('Select category for this popup content.', 'iframe-popup'); ?></p>
		
		<label for="tag-a"><?php _e('Timeout', 'iframe-popup'); ?></label>
		<select name="timeout" id="timeout">
			<option value='1000' <?php if($form['timeout'] == '1000') { echo "selected='selected'" ; } ?>>1 Sec</option>
			<option value='2000' <?php if($form['timeout'] == '2000') { echo "selected='selected'" ; } ?>>2 Sec</option>
			<option value='4000' <?php if($form['timeout'] == '4000') { echo "selected='selected'" ; } ?>>4 Sec</option>
			<option value='6000' <?php if($form['timeout'] == '6000') { echo "selected='selected'" ; } ?>>6 Sec</option>
			<option value='8000' <?php if($form['timeout'] == '8000') { echo "selected='selected'" ; } ?>>8 Sec</option>
			<option value='10000' <?php if($form['timeout'] == '10000') { echo "selected='selected'" ; } ?>>10 Sec</option>
			<option value='12000' <?php if($form['timeout'] == '12000') { echo "selected='selected'" ; } ?>>12 Sec</option>
			<option value='15000' <?php if($form['timeout'] == '15000') { echo "selected='selected'" ; } ?>>15 Sec</option>
			<option value='20000' <?php if($form['timeout'] == '20000') { echo "selected='selected'" ; } ?>>20 Sec</option>
		</select>
		<p><?php _e('Timeout to open popup window.', 'iframe-popup'); ?></p>
	  
      <input name="id" id="id" type="hidden" value="<?php echo $form['id']; ?>">
      <input type="hidden" name="iframepopup_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Submit', 'iframe-popup'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_iframepopup_redirect()" value="<?php _e('Cancel', 'iframe-popup'); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_iframepopup_help()" value="<?php _e('Help', 'iframe-popup'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('iframepopup_form_edit'); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo wp_create_nonce( 'popup-edit-nonce' ); ?>"/>
    </form>
</div>
<p class="description"><?php echo IFRAMEPOP_OFFICIAL; ?></p>
</div>