<?php function wptp_appearance() { ?>
<div class="wrap wptp-wrap">
	<h2>WP Terms Popup</h2>
	
	<h2 class="nav-tab-wrapper">
		<a href="<?php echo add_query_arg( array( 'post_type' => 'termpopup', 'page' => WP_TERMS_POPUP_NAME . '-settings' ), admin_url('edit.php') ); ?>" class="nav-tab"><?php _e('Settings', WP_TERMS_POPUP_NAME); ?></a>
		<a href="<?php echo add_query_arg( array( 'post_type' => 'termpopup', 'page' => WP_TERMS_POPUP_NAME . '-appearance' ), admin_url('edit.php') ); ?>" class="nav-tab nav-tab-active"><?php _e('Appearance', WP_TERMS_POPUP_NAME); ?></a>
	</h2>
	
	<?php if ( !is_plugin_active( 'wp-terms-popup-pro/index.php' ) && !is_plugin_active( 'wp-terms-popup-designer/index.php' ) ) : ?>
	<div id="col-container">
		<div id="col-right">
			<div class="col-wrap">
				<div class="inside">
					<h1><?php _e('Get More Control with WP Terms Popup Designer', WP_TERMS_POPUP_NAME); ?></h1>
					
					<p>
					<?php _e('Purchase the WP Terms Popup Designer plugin and adjust these parts of your popups without writing any code:', WP_TERMS_POPUP_NAME); ?>
					</p>
					
					<ul>
						<li><?php _e('Header Background Color', WP_TERMS_POPUP_NAME); ?></li>
						<li><?php _e('Header Text Color', WP_TERMS_POPUP_NAME); ?></li>
						<li><?php _e('Header Text Alignment', WP_TERMS_POPUP_NAME); ?></li>
						<li><?php _e('Main Background Color', WP_TERMS_POPUP_NAME); ?></li>
						<li><?php _e('Main Text Color', WP_TERMS_POPUP_NAME); ?></li>
						<li><?php _e('Button Background Color', WP_TERMS_POPUP_NAME); ?></li>
						<li><?php _e('Button Text Color', WP_TERMS_POPUP_NAME); ?></li>
						<li><?php _e('... and more.', WP_TERMS_POPUP_NAME); ?></li>
					</ul>
					
					<p>
					<?php _e('WP Terms Popup Designer integrates directly into the free plugin. After purchase and installation, this Appearance tab will be replaced with the Designer plugin.', WP_TERMS_POPUP_NAME); ?>
					</p>
					
					<p>
					<a class="wptp-button" target="_blank" href="https://termsplugin.com/designer">Learn About WP Terms Popup Designer</a>
					</p>
				</div>
			</div>
		</div>

		<div id="col-left">
			<div class="col-wrap">
				<div class="inside">
					<img src="<?php echo plugins_url('/assets/img/appearance.png', dirname(__FILE__)); ?>">
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<?php if ( is_plugin_active( 'wp-terms-popup-designer/index.php' ) ) { wptp_designer_settings(); } ?>
	
	<?php if ( is_plugin_active( 'wp-terms-popup-pro/index.php' ) && !is_plugin_active( 'wp-terms-popup-designer/index.php' )) { wtp_popupProSettingsPage(); } ?>

	<?php include_once('wptp-footer.php'); ?>
</div>
<?php } ?>
