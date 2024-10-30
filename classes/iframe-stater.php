<?php
$iframepop_plugin_name = 'iframe-popup';
$iframepop_current_folder = dirname(dirname(__FILE__));
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if(!defined('IFRAMEPOP_TDOMAIN')) define('IFRAMEPOP_TDOMAIN', $iframepop_plugin_name);
if(!defined('IFRAMEPOP_PLUGIN_NAME')) define('IFRAMEPOP_PLUGIN_NAME', $iframepop_plugin_name);
if(!defined('IFRAMEPOP_PLUGIN_DISPLAY')) define('IFRAMEPOP_PLUGIN_DISPLAY', "IFrame popup");
if(!defined('IFRAMEPOP_DIR')) define('IFRAMEPOP_DIR', $iframepop_current_folder.DS);
if(!defined('IFRAMEPOP_URL')) define('IFRAMEPOP_URL',plugins_url().'/'.strtolower('iframe-popup').'/');
define('IFRAMEPOP_FILE',IFRAMEPOP_DIR.'iframe-popup.php');
if(!defined('IFRAMEPOP_FAV')) define('IFRAMEPOP_FAV', 'http://www.gopiplus.com/work/2014/04/13/iframe-popup-wordpress-plugin/');
if(!defined('IFRAMEPOP_ADMINURL')) define('IFRAMEPOP_ADMINURL', get_option('siteurl') . '/wp-admin/options-general.php?page=iframe-popup');
define('IFRAMEPOP_OFFICIAL', 'Check official website for more information <a target="_blank" href="'.IFRAMEPOP_FAV.'">click here</a>');
require_once(IFRAMEPOP_DIR.'classes'.DIRECTORY_SEPARATOR.'iframe-register.php');
require_once(IFRAMEPOP_DIR.'classes'.DIRECTORY_SEPARATOR.'iframe-intermediate.php');
//require_once(IFRAMEPOP_DIR.'classes'.DIRECTORY_SEPARATOR.'iframe-common.php');
require_once(IFRAMEPOP_DIR.'classes'.DIRECTORY_SEPARATOR.'iframe-loadwidget.php');
require_once(IFRAMEPOP_DIR.'classes'.DIRECTORY_SEPARATOR.'iframe-query.php');
?>