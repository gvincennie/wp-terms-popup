<?php
$currentpostid = get_the_ID();
$enabled = get_post_meta( $currentpostid, 'terms_enablepop', true );
	
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

if ((get_post_meta( $termspageid, 'terms_redirecturl', true )) != '' ) {
	
	$termsRedirectUrl = get_post_meta( $termspageid, 'terms_redirecturl', true );
	
} elseif (get_option( 'termsopt_redirecturl' ) && get_option( 'termsopt_redirecturl' ) != '') {
	
	$termsRedirectUrl = get_option('termsopt_redirecturl');
	
} else {
	
	$termsRedirectUrl = 'https://google.com';
	
}

if (get_option('termsopt_expiry') && get_option('termsopt_expiry') != '' && get_option('termsopt_expiry') > 0) {
	
	$sesslifetime = (get_option('termsopt_expiry')) * 60 * 60;
	
} else {
    
    if (get_option('termsopt_expiry') != '' && get_option('termsopt_expiry') == 0) {

        $sesslifetime = 0;

    } else {

        $sesslifetime = 3 * 24 * 60 * 60;

    }

}

$wptp_cookie = 'wptp_terms_'.$termspageid;

if (isset($_POST['SubmitAgree'])) {
	
	setcookie($wptp_cookie, 'accepted', time() + $sesslifetime, "/");
	
} elseif (isset($_POST['SubmitDecline'])) {
	
    if (!headers_sent()) {
	    
        header('Location: '.$termsRedirectUrl);
        
        exit;
        
	} else {
		
		echo '<script type="text/javascript">';
		echo 'window.location.href="'.$url.'";';
		echo '</script>';
		echo '<noscript>';
		echo '<meta http-equiv="refresh" content="0;url='.$termsRedirectUrl.'" />';
		echo '</noscript>';
		
		exit;
		
    }
    
}
?>
