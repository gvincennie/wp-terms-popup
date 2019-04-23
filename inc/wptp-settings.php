<?php function wptp_settings() { ?>
<div class="wrap wptp-wrap">
	<h2>WP Terms Popup</h2>
	
	<h2 class="nav-tab-wrapper">
		<a href="<?php echo add_query_arg( array( 'post_type' => 'termpopup', 'page' => WP_TERMS_POPUP_NAME . '-settings' ), admin_url('edit.php') ); ?>" class="nav-tab nav-tab-active"><?php _e('Settings', WP_TERMS_POPUP_NAME); ?></a>
		<a href="<?php echo add_query_arg( array( 'post_type' => 'termpopup','page' => WP_TERMS_POPUP_NAME . '-appearance' ), admin_url('edit.php') ); ?>" class="nav-tab"><?php _e('Appearance', WP_TERMS_POPUP_NAME); ?></a>
	</h2>
	
	<form name="termsForm" method="post" action="options.php">
		<?php wp_nonce_field('update-options') ?>
		
		<div class="wptp-setting">
			<h3><?php _e('Popups', WP_TERMS_POPUP_NAME); ?></h3>
			
			<table>
				<tbody>
					<tr>
						<td colspan="2">
							<label for="termsopt_adminenabled">
								<input type="checkbox" id="termsopt_adminenabled" name="termsopt_adminenabled" value="1" <?php checked( '1', get_option('termsopt_adminenabled') ); ?>>
								<span><?php _e('Enable popups for logged in users?', WP_TERMS_POPUP_NAME); ?></span>
							</label>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<label for="termsopt_sitewide">
								<input type="checkbox" id="termsopt_sitewide" name="termsopt_sitewide" value="1" <?php checked( '1', get_option('termsopt_sitewide') ); ?> onclick="if (this.checked == true) { document.getElementById('wptp_termsopt_page').style.display = 'table-row'; } else { document.getElementById('wptp_termsopt_page').style.display = 'none'; }">
								<span><?php _e('Enable only one popup sitewide?', WP_TERMS_POPUP_NAME); ?></span>
							</label>
						</td>
					</tr>
					<tr id="wptp_termsopt_page" style="<?php echo get_option('termsopt_sitewide') == 1 ? 'display:table-row;' : 'display:none;' ?>">
						<th><?php _e('Sitewide Terms Popup', WP_TERMS_POPUP_NAME); ?></th>
						<td>
							<?php if ((wp_dropdown_pages("name=termsopt_page&post_type=termpopup&echo=0")) == '' ) : ?>
							<?php printf( __( 'Please <a href="%s">create your first Terms Popup</a> to proceed.', WP_TERMS_POPUP_NAME), esc_url( 'post-new.php?post_type=termpopup' ) ); ?>
							<?php else : ?>
							<?php wp_dropdown_pages("name=termsopt_page&post_type=termpopup&show_option_none=".__('- Select -')."&selected=" .get_option('termsopt_page')); ?>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label for="termsopt_page_exclusion">
								<input type="checkbox" id="termsopt_page_exclusion" name="termsopt_page_exclusion" value="1" <?php checked( '1', get_option('termsopt_page_exclusion') ); ?> onclick="if (this.checked == true) { document.getElementById('wp_termsopt_page').style.display = 'table-row'; } else { document.getElementById('wptp_termsopt_page').style.display = 'none'; }">
								<span><?php _e('Disable Popoups for certian pages?', WP_TERMS_POPUP_NAME); ?></span>
							</label>
						</td>
					</tr>
					<tr id="wptp_termsopt_page" style="<?php echo get_option('termsopt_page_exclusion') == 1 ? 'display:table-row;' : 'display:none;' ?>">
						<th><?php _e('Excluded pages for Popups', WP_TERMS_POPUP_NAME); ?></th>
						<td>
							<?php if ((wp_dropdown_pages("name=termsopt_page&post_type=termpopup&echo=0")) == '' ) : ?>
							<?php printf( __( 'Please <a href="%s">create your first Terms Popup</a> to proceed.', WP_TERMS_POPUP_NAME), esc_url( 'post-new.php?post_type=termpopup' ) ); ?>
							<?php else : ?>
							<?php wp_dropdown_pages("name=termsopt_page&post_type=termpopup&show_option_none=".__('- Select -')."&selected=" .get_option('termsopt_page')); ?>
							<?php endif; ?>
						</td>
					</tr>
					<tr class="has-help">
						<th><?php _e('Agreement Expiration', WP_TERMS_POPUP_NAME); ?></th>
						<td><input class="small-text" type="number" name="termsopt_expiry" min="0" max="999" value="<?php echo get_option('termsopt_expiry'); ?>"> <?php _e('Hours', WP_TERMS_POPUP_NAME); ?></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<small><?php _e('This setting controls how much time passes before a user has to agree to your popup again.', WP_TERMS_POPUP_NAME); ?></small><br>
							<small><?php _e('Leaving this blank will make popups reappear after 72 hours.', WP_TERMS_POPUP_NAME); ?></small><br>
							<small><?php _e('Setting this to 0 will force the popup to appear every time a page is loaded.', WP_TERMS_POPUP_NAME); ?></small><br>
							<small><strong><?php _e('Agreement Expiration does not apply to popups displayed by a shortcode.', WP_TERMS_POPUP_NAME); ?></strong></small>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
					
		<div class="wptp-setting">
			<h3><?php _e('Background', WP_TERMS_POPUP_NAME); ?></h3>
			
			<table>
				<tbody>
					<tr class="has-help">
						<th><?php _e('Transparency', WP_TERMS_POPUP_NAME); ?></th>
						<td><input class="small-text" type="number" name="termsopt_opac" min="1" max="10" value="<?php echo get_option('termsopt_opac'); ?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><small><?php _e('This setting controls the darkness of content behind the popup. 1 = Light, 10 = Dark.', WP_TERMS_POPUP_NAME); ?></small></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="wptp-setting">
			<h3><?php _e('Buttons', WP_TERMS_POPUP_NAME); ?></h3>
			
			<p><?php _e('These values will be the default options for all new Terms Popups you create.', WP_TERMS_POPUP_NAME); ?></p>
			
			<table>
				<tbody>
					<tr>
						<th><?php _e('Agree Button Text', WP_TERMS_POPUP_NAME); ?></th>
						<td><input type="text" name="termsopt_agreetxt" size="20" value="<?php echo get_option('termsopt_agreetxt'); ?>"></td>
					</tr>
					
					<tr>
						<th><?php _e('Decline Button Text', WP_TERMS_POPUP_NAME); ?></th>
						<td><input type="text" name="termsopt_disagreetxt" size="20" value="<?php echo get_option('termsopt_disagreetxt'); ?>"></td>
					</tr>
					
					<tr class="has-help">
						<th><?php _e('Decline URL Redirect', WP_TERMS_POPUP_NAME); ?></th>
						<td><input type="text" name="termsopt_redirecturl" size="45" value="<?php echo get_option('termsopt_redirecturl'); ?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><small><?php _e('This URL is the website users will be sent to if they click the Decline button.', WP_TERMS_POPUP_NAME); ?></small></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<p><input class="button-primary" type="submit" name="Submit" value="Save Settings" /></p>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="termsopt_adminenabled,termsopt_sitewide,termsopt_page,termsopt_agreetxt,termsopt_disagreetxt,termsopt_redirecturl,termsopt_opac,termsopt_expiry" />
	</form>

	<?php include_once('wptp-footer.php'); ?>
</div>
<?php } ?>
