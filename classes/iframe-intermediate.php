<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class iframepopup_cls_intermediate
{
	public static function iframepopup_admin()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(IFRAMEPOP_DIR.'page'.DIRECTORY_SEPARATOR.'popup-add.php');
				break;
			case 'edit':
				require_once(IFRAMEPOP_DIR.'page'.DIRECTORY_SEPARATOR.'popup-edit.php');
				break;
			case 'set':
				require_once(IFRAMEPOP_DIR.'page'.DIRECTORY_SEPARATOR.'popup-setting.php');
				break;
			default:
				require_once(IFRAMEPOP_DIR.'page'.DIRECTORY_SEPARATOR.'popup-show.php');
				break;
		}
	}
}

class iframepopup_cls_validation
{
	public static function num_val($value)
	{
		$returnvalue = "valid";
		if( !is_numeric($value) ) 
		{ 
			$returnvalue = "invalid";
		}
		return $returnvalue;
	}
	
	public static function effect_val($value)
	{
		$returnvalue = "fade";
		if($value == "fade" || $value == "elastic" || $value == "none")
		{
			$returnvalue = $value;
		}
		return $returnvalue;
	}
	
	public static function val_yn($value)
	{
		$returnvalue = "YES";
		if($value == "YES" || $value == "NO")
		{
			$returnvalue = $value;
		}
		return $returnvalue;
	}
	
	public static function val_tf($value)
	{
		$returnvalue = "true";
		if($value == "true" || $value == "false")
		{
			$returnvalue = $value;
		}
		return $returnvalue;
	}
}
?>