<div class="wrap">
	<h1>Gsuite App </h1>
	<?php settings_errors(); ?>

	<form method="post" action="options.php" enctype="multipart/form-data">
		<?php 
			settings_fields( 'st_gsuite_app_dashboard_settings' );
			do_settings_sections( 'stgsuiteapp_dashbaord' );
			submit_button();
		?>
	</form>

</div>