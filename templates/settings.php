<div class="wrap">

	<?php settings_errors(); ?>
	
	<form method="post" action="options.php">
		<?php 
			settings_fields( 'st_gsuite_app_settings' );
			do_settings_sections( 'stgsuiteapp_settings' );
			submit_button( 'Extract Zip ' );
		?>
	</form>
	
</div>