<div id="widgets" class="tab-container">
	<strong> Note: </strong> <br>
	Widgets are autoloaded upon activation of the site theme through Site settings. <br> 
	You can choose to reactivate it or manually arrange it on the widgets section. <br>
	Once reactivated it will override any manual updates on widget settings. 
	<br><br>
	<table class="dwh-datatable display hover cell-border" cellspacing="0" width="100%">
	    <thead>
	        <tr>
	        	<th> Details </th>
	            <th> Screenshots </th>
	        </tr>
	    </thead>

	    <tbody>

			<?php  $dir = DWH_SITE_WIDGETS_DIR; ?>
			<?php if(file_exists( $dir )) :?>
			<?php $dir_scan = scandir( $dir ); ?>
				<?php foreach($dir_scan as $dir_item):?>			
					<?php if($dir_item!='.'&& $dir_item!='..'):?>					
						<?php $config = get_module_config( array('widgets',$dir_item ) , 'config.doc' ); ?>
						<?php 

							$name = isset($config['name']) ? $config['name'] : '';
							$desc = isset($config['desc']) ? $config['desc'] : '';
							$data = isset($config['data']) ? $config['data'] : '';
							$notes = isset($config['notes']) ? $config['notes'] : '';
							
							/* Screenshots */
							$screenshot_dir = DWH_SITE_WIDGETS_DIR . '/' .  $dir_item . '/screenshots/';
							$screenshot_url = DWH_SITE_WIDGETS_URI . '/' .  $dir_item . '/screenshots/';
							$screenshots = array();

							if( file_exists( $screenshot_dir )){

								$screenshot_dir_scan = scandir( $screenshot_dir );
								foreach ($screenshot_dir_scan as $key => $screenshot_item) {
									
									if( $screenshot_item!='.' && $screenshot_item!='..')
									{
										if( file_exists( $screenshot_dir . $screenshot_item ))
										{
											$screenshots[] = $screenshot_url . $screenshot_item; 
										}
									}
									
								}
							}
							/* Screenshots */

							/* CSS */
							$css_dir = DWH_SITE_WIDGETS_DIR . $dir_item . '/css/';
							$css_url = DWH_SITE_WIDGETS_URI . $dir_item . '/css/';
							$css = array();

							if( file_exists( $css_dir )){

								$css_dir_scan = scandir( $css_dir );
								foreach ($css_dir_scan as $key => $css_item) {
									
									if( $css_item!='.' && $css_item!='..')
									{
										if( file_exists( $css_dir . $css_item ))
										{
											$css[] = file_get_contents( $css_dir . $css_item ); 
										}
									}
									
								}
							}
							/* CSS */

						?>
						<tr>
							<td> 
								<h2><?php echo $name;?></h2> 

								<h4 class="section-title"> Description: </h4>
								<?php echo $desc;?>

								<h4 class="section-title"> Data: </h4>
								<?php echo $data;?>

								<h4 class="section-title"> Notes: </h4>
								<?php echo $notes;?>

								<h4 class="section-title"> CSS </h4>
								

								<?php if( !empty( $css ) ):?>
							 		<?php foreach ($css as $key => $value):?>
							 			
							 			<!-- View Source -->
										<span>
											<input type="button" class="button-primary btn-view-source-codemirror" value="View Source">
											<div class="hide"><?php echo $value;?></div>
										</span>
										<!-- View Source -->

							 		<?php endforeach;?>
							 	<?php else:?>
							 		<h3> No css available </h3>
							 	<?php endif;?>

							</td>
							<td>	
								<?php if( !empty( $screenshots ) ):?>
							 		<?php foreach ($screenshots as $key => $value):?>
								 		<a href="#<?php echo sanitize_title_with_dashes( $name );?>-<?php echo $key;?>" class="colorbox-inline">
								 			<img width="250px" src="<?php echo $value;?>">
								 		</a>
								 		<div class="hide">
								 			<div id="<?php echo sanitize_title_with_dashes( $name );?>-<?php echo $key;?>">
								 				<img src="<?php echo $value;?>">
								 			</div>
								 		</div>
							 		<?php endforeach;?>
							 	<?php else:?>
							 		<h3> No screenshot(s) available </h3>
							 	<?php endif;?>
							</td>
							
						</tr>
						
					<?php endif;?>
				<?php endforeach;?>			
			<?php endif;?>

		</tbody>
	</table>
</div>