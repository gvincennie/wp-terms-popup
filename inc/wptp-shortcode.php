<?php
function wtp_shortcodeCall ( $atts ) { //shortcodes are for popups on custom post types

	if (is_admin()) { return; }

	extract( shortcode_atts( array(
		
        'id' => 0
        
    ), $atts ) ); //default id
	
	$isshortcode = 1;
	
	$termsidscode = $atts['id'];	
	$termspageid = $termsidscode;
	
	if( (get_post_meta( $termspageid, 'terms_redirecturl', true )) != '' ) {
		
		$termsRedirectUrl = get_post_meta( $termspageid, 'terms_redirecturl', true );
		
	}
	elseif (get_option('termsopt_redirecturl') && get_option('termsopt_redirecturl') != '') {
		
		$termsRedirectUrl = get_option('termsopt_redirecturl');
		
	}
	else {
		
		$termsRedirectUrl = 'http://google.com';
		
	}
	
	include(ABSPATH.'wp-content/plugins/wp-terms-popup/wptp-popup.php');
	
}
add_shortcode('wpterms', 'wtp_shortcodeCall');
