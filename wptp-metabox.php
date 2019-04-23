<?php
function wptp_metabox_setup() {
	
	add_action( 'add_meta_boxes', 'wptp_metaboxes' );
	add_action( 'save_post', 'wptp_metabox_save_post_setting', 10, 2 );
	add_action( 'save_post', 'wtp_savePopupMeta', 10, 2 );
	
}

add_action( 'load-post.php', 'wptp_metabox_setup' );
add_action( 'load-post-new.php', 'wptp_metabox_setup' );


function wptp_metaboxes() {
	
	$screen = array( 'post', 'page' );

	add_meta_box(
		
		'termpopup-setting',
		esc_html__( 'WP Terms Popup', WP_TERMS_POPUP_NAME ),
		'wptp_metabox_display_post_setting',
		$screen,
		'side',
		'default'
		
	);
	
	add_meta_box(
		
		'thepopup-meta',
		esc_html__( 'WP Terms Popup Settings', WP_TERMS_POPUP_NAME ),
		'wtp_popupMeta',
		'termpopup',
		'normal',
		'high'
		
	);
}

// Metabox for Post Setting
function wptp_metabox_display_post_setting( $object, $box ) {

	wp_nonce_field( basename( __FILE__ ), 'terms_enablepopup_nonce' );
	
?>
	<table>
		<tbody>
			<tr>
				<td>
					<label for="terms_enablepop">
						<input type="checkbox" id="terms_enablepop" name="terms_enablepop" value="1" <?php checked( '1', get_post_meta( $object->ID, 'terms_enablepop', true ) ); ?>>
						<span><?php _e('Enable Popup?', WP_TERMS_POPUP_NAME); ?></span>
					</label>
				</td>
			</tr>
			
			<tr>
				<td><?php _e('Terms Popup to Show on this Post:', WP_TERMS_POPUP_NAME); ?></td>
			</tr>
			
			<tr>
				<td>
					<?php
						if ((wp_dropdown_pages("name=termsopt_page&post_type=termpopup&echo=0")) == '' ) {
							
							printf( __( 'Please <a href="%s">create your first Terms Popup</a> to proceed.', WP_TERMS_POPUP_NAME ), esc_url( 'post-new.php?post_type=termpopup' ) );
						
						} else {
							
							$isselected = get_post_meta( $object->ID, 'terms_selectedterms', true );
							wp_dropdown_pages("name=terms_selectedterms&post_type=termpopup&show_option_none=".__('- Select -')."&selected=" .$isselected);
							
						}
					?>
				</td>
			</tr>
		</tbody>
	</table>
<?php
}

function wptp_metabox_save_post_setting( $post_id, $post ) {

  if ( !isset( $_POST['terms_enablepopup_nonce'] ) || !wp_verify_nonce( $_POST['terms_enablepopup_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  $post_type = get_post_type_object( $post->post_type );

  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  $new_enablepop_value = ( isset( $_POST['terms_enablepop'] ) ? sanitize_html_class( $_POST['terms_enablepop'] ) : '' );
  $new_selectedterms_value = ( isset( $_POST['terms_selectedterms'] ) ? sanitize_html_class( $_POST['terms_selectedterms'] ) : '' );

  $enablepop_key = 'terms_enablepop';
  $enablepop_value = get_post_meta( $post_id, $enablepop_key, true );
  
  $selectedterms_key = 'terms_selectedterms';
  $selectedterms_value = get_post_meta( $post_id, $selectedterms_key, true );

  
  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_enablepop_value && '' == $enablepop_value )
    add_post_meta( $post_id, $enablepop_key, $new_enablepop_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_enablepop_value && $new_enablepop_value != $enablepop_value )
    update_post_meta( $post_id, $enablepop_key, $new_enablepop_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_enablepop_value && $enablepop_value )
    delete_post_meta( $post_id, $enablepop_key, $enablepop_value );
	

  if ( $new_selectedterms_value && '' == $selectedterms_value )
    add_post_meta( $post_id, $selectedterms_key, $new_selectedterms_value, true );

  elseif ( $new_selectedterms_value && $new_selectedterms_value != $selectedterms_value )
    update_post_meta( $post_id, $selectedterms_key, $new_selectedterms_value );

  elseif ( '' == $new_selectedterms_value && $selectedterms_value )
    delete_post_meta( $post_id, $selectedterms_key, $selectedterms_value );
}

// Metabox for WP Terms Popup Custom Post Type
function wtp_savePopupMeta( $post_id, $post ) {

  if ( !isset( $_POST['terms_popupmeta_nonce'] ) || !wp_verify_nonce( $_POST['terms_popupmeta_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  $post_type = get_post_type_object( $post->post_type );

  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  $metakeys = array('terms_agreetxt', 'terms_disagreetxt', 'terms_redirecturl');

  foreach ($metakeys as $metakey) {
	$new_meta_value = ( isset( $_POST[$metakey] ) ? $_POST[$metakey] : '' );

	$meta_key = $metakey;
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
  }
}


function wtp_popupMeta( $object, $box ) {
	
	wp_nonce_field( basename( __FILE__ ), 'terms_popupmeta_nonce' );
	
	$default_termsopt_agreetxt = get_option('termsopt_agreetxt');
	$default_termsopt_terms_disagreetxt = get_option('termsopt_disagreetxt');
	$default_termsopt_redirecturl = get_option('termsopt_redirecturl');
	
	$post_terms_agreetxt = get_post_meta( $object->ID, 'terms_agreetxt', true );
	$post_termsopt_terms_disagreetxt = get_post_meta( $object->ID, 'terms_disagreetxt', true );
	$post_termsopt_redirecturl = get_post_meta( $object->ID, 'terms_redirecturl', true );
	
	$meta_terms_agreetxt = '';
	$meta_termsopt_terms_disagreetxt = '';
	$meta_termsopt_redirecturl = '';
	
	if ( strlen( $post_terms_agreetxt ) == 0 ) { $meta_terms_agreetxt = $default_termsopt_agreetxt; } else { $meta_terms_agreetxt = $post_terms_agreetxt; }
	if ( strlen( $post_termsopt_terms_disagreetxt ) == 0 ) { $meta_termsopt_terms_disagreetxt = $default_termsopt_terms_disagreetxt; } else { $meta_termsopt_terms_disagreetxt = $post_termsopt_terms_disagreetxt; }
	if ( strlen( $post_termsopt_redirecturl ) == 0 ) { $meta_termsopt_redirecturl = $default_termsopt_redirecturl; } else { $meta_termsopt_redirecturl = $post_termsopt_redirecturl; }
?>

	<table>
		<tbody>
			<tr>
				<td><?php _e('Agree Button Text', WP_TERMS_POPUP_NAME); ?></td>
				<td><input type="text" name="terms_agreetxt" size="20" value="<?php echo $meta_terms_agreetxt; ?>"></td>
			</tr>
			
			<tr>
				<td><?php _e('Decline Button Text', WP_TERMS_POPUP_NAME); ?></td>
				<td><input type="text" name="terms_disagreetxt" size="20" value="<?php echo $meta_termsopt_terms_disagreetxt; ?>"></td>
			</tr>
			
			<tr class="has-help">
				<td><?php _e('Decline URL Redirect', WP_TERMS_POPUP_NAME); ?></td>
				<td><input type="text" name="terms_redirecturl" size="45" value="<?php echo $meta_termsopt_redirecturl; ?>"></td>
			<tr>
				<td></td>
				<td><small><?php _e('This URL is the website users will be sent to if they click the Decline button.', WP_TERMS_POPUP_NAME); ?></small></td>
			</tr>
		</tbody>
	</table>

<?php
}
