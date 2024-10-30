<?php
/*
Plugin Name: iframe popup
Plugin URI: http://www.gopiplus.com/work/2014/04/13/iframe-popup-wordpress-plugin/
Description: Iframe popup plugin is specially developed to display any webpage in the popup window using web URL. Iframe popup uses JQuery fancybox extension to display popup in iframe window. This plugin will help you to display popup window easily in your blog. You can easily customize the fancybox popup attributes in the plugin admin page.
Version: 3.3
Author: Gopi Ramasamy
Donate link: http://www.gopiplus.com/work/2014/04/13/iframe-popup-wordpress-plugin/
Author URI: http://www.gopiplus.com/work/2014/04/13/iframe-popup-wordpress-plugin/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*  
Copyright 2021 iframe popup (www.gopiplus.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

if (!session_id()) { session_start(); }

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'iframe-stater.php');
add_action('admin_menu', array( 'iframepopup_cls_registerhook', 'iframepopup_adminmenu' ));
register_activation_hook(IFRAMEPOP_FILE, array( 'iframepopup_cls_registerhook', 'iframepopup_activation' ));
register_deactivation_hook(IFRAMEPOP_FILE, array( 'iframepopup_cls_registerhook', 'iframepopup_deactivation' ));
add_action( 'widgets_init', array( 'iframepopup_cls_registerhook', 'iframepopup_widget_loading' ));
add_shortcode( 'iframe-popup', 'iframepopup_shortcode' );
add_action('wp_enqueue_scripts', 'iframepopup_add_javascript_files');
add_action('admin_enqueue_scripts', array( 'iframepopup_cls_registerhook', 'iframepopup_load_adminscripts' ));


function iframepopup_textdomain() 
{
	  load_plugin_textdomain( 'iframe-popup' , false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'iframepopup_textdomain');
?>