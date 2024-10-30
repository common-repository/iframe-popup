<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class iframepopup_cls_dbquery
{
	public static function popup_count($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$result = 0;
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT COUNT(*) AS `count` FROM `".$prefix."iframepopup` WHERE `id` = %d", array($id));
		}
		else
		{
			$sSql = "SELECT COUNT(*) AS `count` FROM `".$prefix."iframepopup`";
		}
		$result = $wpdb->get_var($sSql);
		return $result;
	}
	
	public static function popup_select($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$arrRes = array();
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT * FROM `".$prefix."iframepopup` where id = %d", array($id));
		}
		else
		{
			$sSql = "SELECT * FROM `".$prefix."iframepopup` order by id desc";
		}
		$arrRes = $wpdb->get_results($sSql, ARRAY_A);
		return $arrRes;
	}
	
	public static function popup_widget($id = 0, $cat = "")
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$arrRes = array();
		$sSql = "SELECT * FROM `".$prefix."iframepopup` where url <> ''";
		if ($id > 0)
		{
			$sSql = $sSql . " and id = ".$id;
		}
		if ($cat <> "")
		{
			$sSql = $sSql . " and group = '".$cat."'";
		}
		$sSql = $sSql . " and ( expiration >= NOW() or expiration = '0000-00-00 00:00:00' )";
		$sSql = $sSql . " and ( starttime <= NOW() or starttime = '0000-00-00 00:00:00' )";
		$sSql = $sSql . " Order by rand()";
		$sSql = $sSql . " LIMIT 0,1";
		$arrRes = $wpdb->get_results($sSql, ARRAY_A);
		return $arrRes;
	}
	
	public static function popup_delete($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("DELETE FROM `".$prefix."iframepopup` WHERE `id` = %d LIMIT 1", $id);
		$wpdb->query($sSql);
		return true;
	}
	
	public static function popup_act($data = array(), $action = "ins")
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		
		if($action == "ins")
		{
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."iframepopup` 
			(`title`,`url`, `width`, `height`, `transitionin`, `transitionout`, `centeronscroll`, `titleshow`, `expiration`, `starttime`, `overlaycolor`, `group`, `timeout`)
			VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", 
			array($data["title"], $data["url"], $data["width"], $data["height"], $data["transitionin"], $data["transitionout"], $data["centeronscroll"], 
			$data["titleshow"], $data["expiration"], $data["starttime"], $data["overlaycolor"], $data["group"], $data["timeout"]) );
			$wpdb->query($sql);
			return "sus";
		}
		elseif($action == "ups")
		{
			$sql = $wpdb->prepare("UPDATE `".$prefix."iframepopup` SET `title` = %s, `url` = %s, `width` = %s, `height` = %s, `transitionin` = %s, `transitionout` = %s, 
			`centeronscroll` = %s, `titleshow` = %s, `expiration` = %s, `starttime` = %s, `overlaycolor` = %s, `group` = %s, `timeout` = %s WHERE id = %d LIMIT 1", 
			array($data["title"], $data["url"], $data["width"], $data["height"], $data["transitionin"], $data["transitionout"], $data["centeronscroll"], 
			$data["titleshow"], $data["expiration"], $data["starttime"], $data["overlaycolor"], $data["group"], $data["timeout"], $data["id"]));
			$wpdb->query($sql);
			return "sus";
		}
		else
		{
			return "err";
		}
	}
	
	public static function popup_default()
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		
		$title = "iframe popup - sample data";
		$url = "http://www.example.com/";
		$sql = $wpdb->prepare("INSERT INTO `".$prefix."iframepopup` (`title`,`url`)	VALUES(%s, %s)", array($title, $url));
		$wpdb->query($sql);
		
		$title = "iframe popup - URL must start with either http or https";
		$url = "http://www.example.com/";
		$sql = $wpdb->prepare("INSERT INTO `".$prefix."iframepopup` (`title`,`url`,`overlaycolor`)	VALUES(%s, %s, %s)", array($title, $url, "#FF0000"));
		$wpdb->query($sql);
		
		return true;
	}
}
?>