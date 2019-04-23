<?php
if (get_option( 'termsopt_opac' ) ) {
	
	if (get_option( 'termsopt_opac' ) != '10') {
		
		$termsopacmoz = '0.'.get_option('termsopt_opac');
		$termsopac = '.'.get_option('termsopt_opac').'0';
		$termsopacfilter = get_option('termsopt_opac').'0';
		
	} elseif (get_option( 'termsopt_opac' ) == '10') {
		
		$termsopacmoz = '1.0';
		$termsopac = '1.0';
		$termsopacfilter = '100';
		
	}
	
} else {

	$termsopacmoz = '0.8';
	$termsopac = '.80';
	$termsopacfilter = '80';
	
}

include_once(ABSPATH.'wp-admin/includes/plugin.php' );

if (is_plugin_active( 'wp-terms-popup-designer/index.php' )) {
	
	include(ABSPATH.'wp-content/plugins/wp-terms-popup-designer/inc/wptp-designer-css.php' );
	
}
else {
	
	include('inc/wptp-css.php');

}
?>
<div id="tfade" class="tdarkoverlay" <?php if ($isshortcode == 1) { echo 'style="display:none"'; } ?>></div>
<div id="tlight" class="tbrightcontent" <?php if ($isshortcode == 1) { echo 'style="display:none"'; } ?>>
	<div class="termspopupcontainer">
		<?php if ($termspageid) : $termscontent = get_post($termspageid); ?>
		<h3 class="termstitle"><?php echo $termscontent->post_title; ?></h3>
			
		<div class="termscontentwrapper">
			<?php
                $wptp_content = $termscontent->post_content;
                
                $wptp_content = wptexturize($wptp_content);
                $wptp_content = convert_smilies($wptp_content);
                $wptp_content = convert_chars($wptp_content);
                $wptp_content = prepend_attachment($wptp_content);
                $wptp_content = do_shortcode($wptp_content);
                $wptp_content = shortcode_unautop($wptp_content);
                $wptp_content = wpautop($wptp_content);

                echo $wptp_content;
			?>
		</div>
		<?php endif; ?>

		<?php
            // Find Agree Button Text
            if ((get_post_meta( $termspageid, 'terms_agreetxt', true )) != '') {
                
                $tagree = get_post_meta( $termspageid, 'terms_agreetxt', true );
                
            } elseif (get_option( 'termsopt_agreetxt' ) != '') {
                
                $tagree = get_option( 'termsopt_agreetxt' );
                
            } else {
                
                $tagree = __('I Agree', WP_TERMS_POPUP_NAME);

            }
            
            // Find Decline Button Text
            if ((get_post_meta( $termspageid, 'terms_disagreetxt', true )) != '' ) {
                
                $tdisagree = get_post_meta( $termspageid, 'terms_disagreetxt', true );
                
            } elseif (get_option( 'termsopt_disagreetxt' ) != '') {
                
                $tdisagree = get_option( 'termsopt_disagreetxt' );
                
            } else {
                
                $tdisagree = __('I Do Not Agree', WP_TERMS_POPUP_NAME);
                
            }
            
            // Find Decline URL Redirect
            if ((get_post_meta( $termspageid, 'terms_redirecturl', true )) != '' ) {
        
                $termsRedirectUrl = get_post_meta( $termspageid, 'terms_redirecturl', true );
                
            } elseif (get_option( 'termsopt_redirecturl' ) && get_option( 'termsopt_redirecturl' ) != '') {
                
                $termsRedirectUrl = get_option('termsopt_redirecturl');
                
            } else {
                
                $termsRedirectUrl = 'https://google.com';
                
            }
		?>
		
		<?php if ($isshortcode == 1) : ?>
		<div class="tthebutton">
			<input class="termsagree" type="button" onclick="ttb_wtp_agree_shortcode_button_call()" value="<?php echo $tagree; ?>" />
			<input class="termsdecline" type="button" onclick="window.location.replace('<?php echo $termsRedirectUrl ?>')" value="<?php echo $tdisagree; ?>" />
		</div>
		<?php else : ?>	
		<form method="post">
			<div class="tthebutton">
				<?php do_action('ttb_wtp_before_buttons_inside_form'); ?>
					
				<input class="termsagree" name="SubmitAgree" type="submit" value="<?php echo $tagree; ?>" />
			    <input class="termsdecline" type="button" onclick="window.location.replace('<?php echo $termsRedirectUrl ?>')" value="<?php echo $tdisagree; ?>" />
			</div>
		</form>
		<?php endif; ?>
	</div>
</div>

<?php if ($isshortcode == 1) : $ttermspopupagreed = 'ttermspopupagreed'.$termspageid; ?>
<script>
function ttb_wtp_agree_shortcode_button_call() {
	
	document.getElementById("tfade").style.display = "none";
	document.getElementById("tlight").style.display = "none";

	if (localStorage.getItem('<?php echo json_encode($ttermspopupagreed); ?>') != 'agreed') {

        localStorage.setItem('<?php echo json_encode($ttermspopupagreed); ?>','agreed');

    }

}

if (localStorage.getItem('<?php echo json_encode($ttermspopupagreed); ?>') != 'agreed') {

	document.getElementById("tfade").style.display = "block";
	document.getElementById("tlight").style.display = "block";
	
}
</script>
<?php endif; ?>
