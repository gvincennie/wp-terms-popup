<?php
/*
Plugin Name: WP Terms Popup
Plugin URI: https://termsplugin.com
Description: Website Popups for WordPress. You can use WP Terms Popup to ask users to agree to your terms of service, privacy policy or age verification request before they are allowed to access your website.
Version: 1.5.0
Author: Link Software LLC
Author URI: https://linksoftwarellc.com
*/

define('WP_TERMS_POPUP_NAME', 'terms-popup-plugin');

function wptp_styles () {
		
   wp_register_style( 'wptp-css-popup', plugins_url( 'wp-terms-popup/assets/css/wptp-popup.css' ) );
   wp_enqueue_style( 'wptp-css-popup' );
   
}
add_action( 'wp_enqueue_scripts', 'wptp_styles', 1 );

function wptp_admin_style () {
	
	wp_enqueue_style( 'wptp-css-admin', plugin_dir_url( __FILE__ ) . 'assets/css/wptp-admin.css', '', null, 'all' );
	
}
add_action( 'admin_enqueue_scripts', 'wptp_admin_style' );

function wptp_scripts () {
	
   wp_enqueue_script( 'wtplocalstoragefallback', plugins_url( 'wp-terms-popup/assets/js/lspolyfill.js' ), false );
   
}
add_action( 'wp_enqueue_scripts', 'wptp_scripts' );

function wptp_set_cookie () {
	
	if (is_user_logged_in()) {
		
		if (get_option('termsopt_adminenabled') == 1) {
			
			include_once('wptp-cookie.php');
			
		}
		
	} else {
		
		include_once('wptp-cookie.php');
		
	}

}
add_action('get_header', 'wptp_set_cookie');

function wptp_open_popup () {
	
    $isshortcode = 0;
    
    if (isset($_POST) && !empty($_POST)) { return; }
	
	if (get_option( 'termsopt_sitewide' ) == 1) {
		
		$termspageid = get_option( 'termsopt_page' );
		
		if (!$termspageid || $termspageid == '') {
			
			return;
			
		}
		
	} elseif (get_option( 'termsopt_sitewide' ) <> 1) {
		
		$currentpostid = get_the_ID();
		$enabled = get_post_meta( $currentpostid, 'terms_enablepop', true );
		
		if ($enabled == 1) {
			
			$termspageid = get_post_meta( $currentpostid, 'terms_selectedterms', true );
			
		} elseif ($enabled <> 1) {
			
			return;
			
		}
		
	}
	else {
		
		return;
		
	}
		
	$wptp_cookie = 'wptp_terms_'.$termspageid;

	if (isset($_POST['SubmitAgree']) || (isset($_COOKIE[$wptp_cookie]) && $_COOKIE[$wptp_cookie] == 'accepted')) {
		
		// DO NOT DISPLAY POPUP, USE THIS FOR FUTURE FEATURES
		
	} else {
		
		include_once(ABSPATH.'wp-admin/includes/plugin.php' );
		
		if (is_plugin_active( 'wp-terms-popup-pro/index.php' )) {
			
			include(ABSPATH.'wp-content/plugins/wp-terms-popup-pro/terms-pro.php' );
			
		}
		else {
			
			include('wptp-popup.php');
	
		}
	}

}
add_action('get_footer', 'wptp_open_popup');

function wptp_menu() {
	
    add_submenu_page('edit.php?post_type=termpopup', __('WP Terms Popup Settings', WP_TERMS_POPUP_NAME), __('Settings', WP_TERMS_POPUP_NAME), 'manage_options', WP_TERMS_POPUP_NAME.'-settings', 'wptp_settings');
    add_submenu_page('edit.php?post_type=termpopup', __('WP Terms Popup Appearance', WP_TERMS_POPUP_NAME), __('Appearance', WP_TERMS_POPUP_NAME), 'manage_options', WP_TERMS_POPUP_NAME.'-appearance', 'wptp_appearance');
    
}
add_action( 'admin_menu', 'wptp_menu' );

require_once('inc/wptp-post-type.php');
require_once('inc/wptp-metabox.php');
require_once('inc/wptp-shortcode.php');
require_once('inc/wptp-settings.php');
require_once('inc/wptp-appearance.php');
?>
