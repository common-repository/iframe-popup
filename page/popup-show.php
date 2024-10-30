<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'popup-show-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_iframepopup_display']) && $_POST['frm_iframepopup_display'] == 'yes')
{
	$did = isset($_GET['did']) ? sanitize_text_field($_GET['did']) : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$iframepopup_success = '';
	$iframepopup_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$result = iframepopup_cls_dbquery::popup_count($did);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'iframe-popup'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('iframepopup_form_show');
			
			//	Delete selected record from the table
			iframepopup_cls_dbquery::popup_delete($did);
			
			//	Set success message
			$iframepopup_success_msg = TRUE;
			$iframepopup_success = __('Selected record was successfully deleted.', 'iframe-popup');
		}
	}
	
	if ($iframepopup_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $iframepopup_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e(IFRAMEPOP_PLUGIN_DISPLAY, 'iframe-popup'); ?>
	<a class="add-new-h2" href="<?php echo IFRAMEPOP_ADMINURL; ?>&page=iframe-popup&ac=add"><?php _e('Add New', 'iframe-popup'); ?></a></h2>
    <div class="tool-box">
	<?php
		$myData = array();
		$myData = iframepopup_cls_dbquery::popup_select(0);
		?>
		<form name="frm_iframepopup_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
			<th scope="col"><?php _e('Id', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Title', 'iframe-popup'); ?></th>
            <th scope="col"><?php _e('URL', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Width', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Height', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Start Date', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Expiration', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Category', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Overlay Color', 'iframe-popup'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
			<th scope="col"><?php _e('Id', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Title', 'iframe-popup'); ?></th>
            <th scope="col"><?php _e('URL', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Width', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Height', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Start Date', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Expiration', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Category', 'iframe-popup'); ?></th>
			<th scope="col"><?php _e('Overlay Color', 'iframe-popup'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td><?php echo $data['id']; ?></td>
						<td><?php echo stripslashes(substr($data['title'], 0, 25)); ?>...
						<div class="row-actions">
						<span class="edit">
						<a title="Edit" href="<?php echo IFRAMEPOP_ADMINURL; ?>&ac=edit&amp;did=<?php echo $data['id']; ?>"><?php _e('Edit', 'iframe-popup'); ?></a> | </span>
						<span class="trash">
						<a onClick="javascript:_iframepopup_delete('<?php echo $data['id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'iframe-popup'); ?></a></span> 
						</div>
						</td>
						<td><a target="_blank" href="<?php echo $data['url']; ?>"><img src="<?php echo IFRAMEPOP_URL; ?>image/link_icon.gif" /></a></td>
						<td><?php echo $data['width']; ?></td>
						<td><?php echo $data['height']; ?></td>
						<td><?php echo substr($data['starttime'],0,10); ?></td>
						<td><?php echo substr($data['expiration'],0,10); ?></td>
						<td><?php echo $data['group']; ?></td>
						<td><?php echo $data['overlaycolor']; ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="9" align="center"><?php _e('No records available.', 'iframe-popup'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('iframepopup_form_show'); ?>
		<input type="hidden" name="frm_iframepopup_display" value="yes"/>
		<input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo wp_create_nonce( 'popup-show-nonce' ); ?>"/>
      </form>	
	  <div class="tablenav bottom">
	  <a href="<?php echo IFRAMEPOP_ADMINURL; ?>&amp;ac=add"><input class="button action" type="button" value="<?php _e('Add New', 'iframe-popup'); ?>" /></a>
	  <a href="<?php echo IFRAMEPOP_ADMINURL; ?>&amp;ac=set"><input class="button action" type="button" value="<?php _e('Session Setting', 'iframe-popup'); ?>" /></a>
	  <a target="_blank" href="<?php echo IFRAMEPOP_FAV; ?>"><input class="button action" type="button" value="<?php _e('Help', 'iframe-popup'); ?>" /></a>
	  <a target="_blank" href="<?php echo IFRAMEPOP_FAV; ?>"><input class="button button-primary" type="button" value="<?php _e('Short Code', 'iframe-popup'); ?>" /></a>
	  </div>
	<h3><?php _e('Plugin configuration option', 'iframe-popup'); ?></h3>
	<ol>
		<li><?php _e('Use plugin short code in the widget (To display entire website)', 'iframe-popup'); ?>.</li>
		<li><?php _e('Add popup into specific  post or page using short code', 'iframe-popup'); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code', 'iframe-popup'); ?></li>
	</ol>
	<p class="description"><?php echo IFRAMEPOP_OFFICIAL; ?></p>
	</div>
</div>