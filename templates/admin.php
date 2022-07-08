<div class="wrap">
	<h1>Dashboard</h1>
	<?php settings_errors(); ?>

	<table class="wp-list-table widefat fixed striped table-view-list posts">
		<thead>
			<th>Domain</th>
			<th>QuickStart File</th>
			<th>Token File</th>
			<th>Termianl Test Command</th>
			<th>Cron Job</th>
		</thead>
		<tbody>
			
				<?php 	
					if( ! empty(get_option('stgsuiteapp_dashbaord') ) )
					{	
					$options = get_option( 'stgsuiteapp_dashbaord' );
							
						foreach ($options as $option) {
							$dirname = substr($option['domain_name'], 0, strpos($option['domain_name'], '.'));
       						$dir = get_stylesheet_directory().'/'.$dirname.'/';
							$qs_filestatus = ( file_exists( $dir . 'quickstart.php') ? '&#10003' : '&#10060;' );							
							$tkn_filestatus = ( file_exists( $dir . 'token.php') ? '&#10003' : '&#10060;' );							
							echo '<tr>'.
							'<td>'.$option['domain_name'].'</td>'.	
							'<td>'.$qs_filestatus.'</td>'.	
							'<td>'.$tkn_filestatus.'</td>'.
							'<td>cd '.$dir.'<br/><br/>php'.' '.'quickstart.php</td>'.
							'<td>cd '.$dir.'; '.'/usr/local/bin/php quickstart.php</td>'.
							'</tr>';	
						}
								
					}
					else
					{
					?>
					<tr>
						<td colspan="3" class="text-center">No data Found</td>
					</tr>
					<?php
					}
				 ?>
			
		</tbody>
	</table>

</div>