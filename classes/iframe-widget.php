<a id="iframepopup<?php echo $form['id']; ?>" title="<?php echo $form['title']; ?>" href="<?php echo $form['url']; ?>"></a>
<script type="text/javascript"> 
function iframepopupwidow()
{
	jQuery("#iframepopup<?php echo $form['id']; ?>").fancybox({
	'width'				: '<?php echo $form['width']; ?>',
	'height'			: '<?php echo $form['height']; ?>',
	'autoScale'			: false,
	'transitionIn'		: '<?php echo $form['transitionin']; ?>',
	'transitionOut'		: '<?php echo $form['transitionout']; ?>',
	'type'				: 'iframe',
	'centerOnScroll'	: <?php echo $form['centeronscroll']; ?>,
	'titleShow'			: <?php echo $form['titleshow']; ?>,
	'overlayColor'		: '<?php echo $form['overlaycolor']; ?>'
	}).trigger('click');;
}
setTimeout('iframepopupwidow()', '<?php echo $form['timeout']; ?>');
</script>