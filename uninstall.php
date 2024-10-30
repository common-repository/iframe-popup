<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

function iframepopup_delete_plugin() {
	global $wpdb;

	delete_option( 'iframe_popup_db' );
	delete_option( 'iframepopup_session' );	

	$wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'iframepopup' ) );
		
}

iframepopup_delete_plugin();