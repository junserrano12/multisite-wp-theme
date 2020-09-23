<div id="shortcodes" class="tab-container">
	<strong> Types: </strong> <br>
	 Dynamic - pulls data from a configuration i.e. Hotel Information on the General Gettings <br>
	 Static - Limited to html structure
	 <br><br>
	<table class="dwh-datatable display hover cell-border" cellspacing="0" width="100%">
	    <thead>
	        <tr>
	        	<th> Details </th>
	            <th> Screenshots </th>
	        </tr>
	    </thead>
	    <tbody>

			<?php

				/* Autoload Shortcodes */
				$dir = DWH_SITE_SHORTCODES_DIR.'dynamic';
				
				/* Check if the shortcodes directory exists */
				if(file_exists( $dir ))
				{
					$dir_scan = scandir( $dir );
					
					/* Loop through the shorcodes directory */

					/* Type: Dynamic Widgets */
					foreach($dir_scan as $dir_item)
					{		
						if($dir_item!='.'&& $dir_item!='..')
						{
							
							$config = get_module_config( array('shortcodes','dynamic',$dir_item ) , 'config' );
							
							if( $config )
							{
								$name = isset($config['name']) ? $config['name'] : '';
								$tag = isset($config['tag']) ? $config['tag'] : '';
								$type = isset($config['type']) ? $config['type'] : '';
								$desc = isset($config['desc']) ? $config['desc'] : '';
								$param = isset($config['param']) ? $config['param'] : '';
								$data = isset($config['data']) ? $config['data'] : '';
								$usage = isset($config['usage']) ? $config['usage'] : '';
								$notes = isset($config['notes']) ? $config['notes'] : '';
							
								/* Screenshots */
								$screenshot_dir = DWH_SITE_SHORTCODES_DIR . strtolower( $type ) . '/' .  $dir_item . '/screenshots/';
								$screenshot_url = DWH_SITE_SHORTCODES_URI . strtolower( $type ) . '/' .  $dir_item . '/screenshots/';
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
								$css_dir = DWH_SITE_SHORTCODES_DIR . strtolower( $type ) . '/' .  $dir_item . '/css/';
								$css_url = DWH_SITE_SHORTCODES_URI . strtolower( $type ) . '/' .  $dir_item . '/css/';
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
									<td width="50%"> 
								
										<h2><?php echo $name;?></h2> 

										<h4 class="section-title"> Tag(s): </h4>
										<?php echo $tag;?>

										<h4 class="section-title"> Type: </h4>
										<?php echo $type;?>

										<h4 class="section-title"> Description: </h4>
										<?php echo $desc;?>

										<h4 class="section-title"> Parameter(s): </h4>
										<?php if(is_array($param)) :?>
											<ul>
											<?php foreach ($param as $key => $value):?>
												<li> <span class="attribute"><?php echo $key;?></span> = <?php echo $value;?> </li>
											<?php endforeach;?>
											</ul>
										<?php endif;?>

										<h4 class="section-title"> Usage: </h4>

										<!-- View Source -->
										<span>
											<input type="button" class="button-primary btn-view-source-codemirror" value="View Source">
											<div class="hide"><?php echo $usage;?></div>
										</span>
										<!-- View Source -->

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
									<td width="50%"> 	

									 	<?php if( !empty( $screenshots ) ):?>
									 		<?php foreach ($screenshots as $key => $value):?>
										 		<a href="#<?php echo sanitize_title_with_dashes( $name );?>-<?php echo $key;?>" rel="<?php echo sanitize_title_with_dashes( $name );?>" class="colorbox-inline">
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
						
							<?php
							
							}

						}

					}

				}

			?>

			<?php

				/* Autoload Shortcodes */
				$shortcode_dir = DWH_SITE_SHORTCODES_DIR.'static';

				/* Check if the shortcodes directory exists */
				if(file_exists( $shortcode_dir ))
				{
					$shortcode_dir = scandir( $shortcode_dir );
					
					/* Loop through the shorcodes directory */

					/* Type: Dynamic Widgets */
					foreach($shortcode_dir as $shortcode_class)
					{		
						if($shortcode_class!='.'&& $shortcode_class!='..')
						{
							$config = get_module_config( array('shortcodes','static', $shortcode_class ) , 'config' );
							
							if( $config )
							{
								
								$name = isset($config['name']) ? $config['name'] : '';
								$tag = isset($config['tag']) ? $config['tag'] : '';
								$type = isset($config['type']) ? $config['type'] : '';
								$desc = isset($config['desc']) ? $config['desc'] : '';
								$param = isset($config['param']) ? $config['param'] : '';
								$data = isset($config['data']) ? $config['data'] : '';
								$usage = isset($config['usage']) ? $config['usage'] : '';
								$notes = isset($config['notes']) ? $config['notes'] : '';
								
								/* Screenshots */
								$screenshot_dir = DWH_SITE_SHORTCODES_DIR . strtolower( $type ) . '/' .  $shortcode_class . '/screenshots/';
								$screenshot_url = DWH_SITE_SHORTCODES_URI . strtolower( $type ) . '/' .  $shortcode_class . '/screenshots/';
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
								$css_dir = DWH_SITE_SHORTCODES_DIR . strtolower( $type ) . '/' .  $shortcode_class . '/css/';
								$css_url = DWH_SITE_SHORTCODES_URI . strtolower( $type ) . '/' .  $shortcode_class . '/css/';
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
									<td width="50%"> 
								
										<h2><?php echo $name;?></h2> 

										<h4 class="section-title"> Tag(s): </h4>
										<?php echo $tag;?>

										<h4 class="section-title"> Type: </h4>
										<?php echo $type;?>

										<h4 class="section-title"> Description: </h4>
										<?php echo $desc;?>

										<h4 class="section-title"> Parameter(s): </h4>
										<?php if(is_array($param)) :?>
											<ul>
											<?php foreach ($param as $key => $value):?>
												<li> <span class="attribute"><?php echo $key;?></span> = <?php echo $value;?> </li>
											<?php endforeach;?>
											</ul>
										<?php endif;?>

										<h4 class="section-title"> Data: </h4>
										<?php echo $data;?>

										<h4 class="section-title"> Usage: </h4>
										
										<!-- View Source -->
										<span>
											<input type="button" class="button-primary btn-view-source-codemirror" value="View Source">
											<div class="hide"><?php echo html_entity_decode( $usage );?></div>
										</span>
										<!-- View Source -->
										
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
									<td width="50%"> 	
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
						
							<?php
							
							}

						}

					}

				}

			?>

   		</tbody>
	</table>
</div>
