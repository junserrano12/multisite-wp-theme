<div class="wrap">
	<?php
		global $DWH_Options;
		global $DWH_Admin;

		$site_themes = $DWH_Admin->get_site_themes();
		$page_themes = $DWH_Admin->get_page_themes();
		$setting_is_enabled = true;
		$delete_enable_flag = true;
		$totalContent = 0;
		$totalIBEUrlContent = 0;
		$currentOption = '';
		$totalSwitchIBEURL = 0;
		$totalCTALang = 0;

		/* Get Hotel Info*/
		$hotels 				= $DWH_Options->get_dwh_site_option_set('dwh_hotels');
		$hotel_info 			= array();

		/* Set Hotel Branches*/
		foreach ($hotels as $key => $hotel) {
			$data['hotel_branches'][] = $hotel;
		}

		$hid = $data['hotel_branches'];
		$arr_str = '';
		if(count($hid) > 1){
			foreach($hid as $key=>$value){
				foreach($value as $key_id=>$val_hid){
					if($key_id == 'hotel_id'){
						//echo $val_hid.'<br />';
						$arr_str .= $val_hid . ',';
					}
				}
			}
			//echo $arr_str = substr($arr_str,0,-1);
		}

	/* Array ( [hotel_branches] =>
			Array (
					[0] => Array ( [hotel_id] => 19145 [hotel_name] => Hotel Name 1 [hotel_location] => City, Country 1 [hotel_domain] => www.hotel1.com [main_flag] => 1 )
					[1] => Array ( [hotel_id] => 3092 [hotel_name] => hdhdh [hotel_location] => hdhdh [hotel_domain] => dfhd [main_flag] => 0 )
				 )
		   ) */
	?>
		<!-- Screen icons are no longer used as of WordPress 3.8. -->
		<ul class="tab-menu">
			<li><a href="#generalcontent" class="active">Site Settings</a></li>
		</ul>

		<div id="generalcontent" class="tab-container show">

			<h3> Site Settings </h3>

			<?php $optionsetlist = $DWH_Options->get_option_set_list();?>

			<table class="dwh-datatable display hover cell-border" cellspacing="0" width="100%">
			    <thead>
			        <tr>
			        	<th> Name </th>
			            <th> Description </th>
			            <th> Category </th>
			            <th> Action  </th>
			        </tr>
			    </thead>
			    <tbody>
			    	<?php  foreach( $optionsetlist as $key => $value ): ?>

			    	<?php  /* Set user role filter */

						if( isset(  $value['block_list'] ))
						{
							if( in_array( DWH_USER_ROLE , $value['block_list'] ) )
							{
								$setting_is_enabled = false;
							}
						}
						else
						{
							$setting_is_enabled = true;
						}

			    	?>

					<tr class="<?php echo $setting_is_enabled == false ? 'hide' : '';?>">
						<td option_title="<?php echo $value['title']; ?>">
							<a href="#" class="btn-launch button-site-options" option_set="<?php echo $key; ?>">
								<span class="dashicons <?php echo $value['icon'];?>"></span>
								<?php echo $value['title']; ?>
								<span style="float:right;font-weight:bold;color:#000">
								<?php if( $DWH_Options->get_option_set_data( $key ) ):?>
									<?php
										if($key == 'dwh_sitemap'){
											$totalContent = count( $DWH_Options->get_option_set_data('sitemap_xml'));
										}
										if($key == 'dwh_ibe_url'){
											$totalIBEUrlContent = count( $DWH_Options->get_option_set_data('ibe_desktop_url'));
										}
										if($key == 'dwh_site_robots'){
											$totalRobotsContent = count( $DWH_Options->get_option_set_data('robots_txt'));
										}
										if($key == 'dwh_ibe_url_switch'){
											$totalSwitchIBEURL = count( $DWH_Options->get_option_set_data('ibe_url_switch'));
										}
										if($key == 'dwh_cta_language'){
											$totalCTALang = count( $DWH_Options->get_option_set_data('cta_language'));
										}
									?>
									<?php echo count( $DWH_Options->get_option_set_data( $key ) > 0 ? $DWH_Options->get_option_set_data( $key ) : '' ) ;?>
								<?php endif;?>
								</span>
							</a>
						</td>
						<td> <?php echo $value['description']; ?> </td>
						<td> <?php echo $value['category']; ?> </td>
						<td option_title="<?php echo $value['title']; ?>">
							<a href="#" class="btn-launch button-primary" option_set="<?php echo $key; ?>">Launch</a>
						</td>
					</tr>

			        <?php endforeach; ?>

			   	</tbody>
			</table>

		</div>


			<!-- options view holder here -->

			<?php /* Set initial */ $setting_is_enabled = true; ?>

			<?php foreach( $optionsetlist as $optionskey => $optionsval ): ?>

					<?php $optionsetproperties = $DWH_Options->get_option_set_properties( $optionskey ); ?>


					<div id="<?php echo $optionskey; ?>" class="tab-container">

						<a href="#" option_set="<?php echo $optionskey; ?>" class="option-close">Close</a>

						 <h3> <span class="dashicons <?php echo $optionsval['icon'];?>"></span> <?php echo _e( $optionsval['title'] .' Settings' ); ?>  </h3>

							<table class="dwh-datatable display hover cell-border" cellspacing="0" width="100%">
								<thead>

										<tr class="<?php echo $setting_is_enabled == false ? 'hide' : '';?>">
											<?php if( $optionsetproperties ):?>
												<?php

												?>
														<?php foreach( $optionsetproperties['settings'] as $key => $value ): ?>

															<?php
																/* Set user role filter */
																if( isset( $value['properties']['block_list'] ))
																{
																	if( in_array( DWH_USER_ROLE , $value['properties']['block_list'] ) )
																	{
																		$setting_is_enabled = false;
																	}
																}
																else
																{
																	$setting_is_enabled = true;
																}

															?>
															<?php

																if( $setting_is_enabled == true):?>
																<th>
																	<?php
																		if($optionskey == 'dwh_ibe_url'){
																			echo '<span style="display:inline-block; width:150px; float:left; text-align:left;">Hotel ID</span>' ;
																			echo '<span style="display:inline-block; float:left; text-align:left;">IBE URL</span>' ;
																		}else{
																			echo $value['properties']['field_title'];

																		}
																	?>
																</th>
															<?php endif;?>
														<?php endforeach;?>
											<?php endif; ?>
											<th> Action </th>
										</tr>

								</thead>

								<tbody>
									<?php

										/*
										* data row should be base on actual data from option
										*/
										$optionsetdata = $DWH_Options->get_option_set_data( $optionskey );

										if( $optionsetdata ):

											$detect = 0;
											$optionrow = 0;
											$option_rel_ctr = 0;

											/* Set enabled setting initially */
											$setting_is_enabled = true;

											foreach( $optionsetdata as $key => $value ):
												$optionrow = $key;

									?>


												<tr>
													<?php $setting_is_enabled = true;?>
													<?php foreach( $optionsetproperties['settings'] as $key1 => $value1 ):?>
													<?php

														/* Set user role filter */
														if( isset( $value1['properties']['block_list'] ))
														{
															if( in_array( DWH_USER_ROLE , $value1['properties']['block_list'] ) )
															{
																$setting_is_enabled = false;
															}
														}
														else
														{
															$setting_is_enabled = true;
														}

													?>

													<?php if( $setting_is_enabled == true):?>

													<?php
															$optionval = '';
															$deleted_flag = '';
															$optionrel = '';

															/* check for control_type */
															if( $value1['properties']['control_type'] == 'relation' ):

																/* config for hack options fields */
																$hack_arr = array(
																				'site_theme',
																				'page_type',
																				'page_theme',
																				'font_name'
																			);

																$delete_arr = array();

																/* if hack option fields */
																if( in_array( $key1, $hack_arr) ):

																	$optionval = array_key_exists( $key1, $optionsetdata[$optionrow] ) ? $optionsetdata[$optionrow][$key1] : '';

																/* Check for true or false values */
																else:

																	/* explode to get option_set */
																	$optionsetarr = explode( '_id', $key1 );

																	/* get option_set data based on option_set and option_row */
																	$new_option_row = array_key_exists( $key1, $optionsetdata[$optionrow] ) ? $optionsetdata[$optionrow][$key1] : '';

																	/* $new_option_row is unpredictable, so we make sure they within array index */
																	if( $new_option_row != '' AND $new_option_row < count( $optionsetdata ) ):

																		$optionrelarr = (array) $DWH_Options->get_dwh_site_option_field( $optionsetarr[0], $optionsetdata[$optionrow][$key1] );

																		$optionrel = ( count( $optionrelarr ) > 0 && array_key_exists('hotel_name',  $optionrelarr) ) ? $optionrelarr['hotel_name'] : '';


																	endif;

																	/* double check verification */
																	$optionval = $optionrel != '' ? $optionrel : '';

																endif;


															/* if control_type is textarea */
															elseif( $value1['properties']['control_type'] == 'textarea' ):

																$optionval = $value1['properties']['field_title'] .' content...';

															/* if control_type is not relation and textarea */
															else:

																/* check if key exist otherwise empty */
																$optionval = array_key_exists( $key1, $optionsetdata[$optionrow] ) ? $optionsetdata[$optionrow][$key1] : '';


															endif;

													?>
															<td>
															<?php

																switch ( $optionskey ) {

																	case 'dwh_sites':

																			if( $key1 == 'site_theme')
																			{
																				 $optionval = $site_themes[$optionval]['name'];
																			}
																			else if( $key1 == 'corpsite_flag')
																			{
																				$optionval = $optionval == 1 ? 'Yes' : 'No';
																			}

																		break;

																	case 'dwh_pages':

																			if( $key1 == 'page_theme')
																			{
																				 if( isset( $page_themes[$optionval]['name'] ))
																				 {
																				 	$optionval = $page_themes[$optionval]['name'];
																				 }
																				 else
																				 {
																				 	$deleted_flag = 'deleted';
																				 	$optionval = $optionval;
																				 }

																			}


																		break;

																	case 'dwh_hotels':

																			if( $key1 == 'main_flag')
																			{
																				$delete_enable_flag = $optionval == 1 ? false : true;
																				$optionval = $optionval == 1 ? 'Yes' : 'No';

																			}

																		break;

																	case 'dwh_meta':

																			if( $key1 == 'noindexnofollow')
																			{
																				$optionval = $optionval == 1 ? 'Yes' : 'No';
																			}

																		break;

																	case 'dwh_links':

																			if( $key1 == 'category')
																			{
																				$optionval = $optionval == 'social_media' ? 'Social Media' : '';
																			}

																		break;

																	case 'dwh_slider':

																			if( $key1 == 'slider-data'){
																				$optionval = $optionval != '' ? 'Slider Item Object' : '';
																			}
																			else{
																				$optionval = array_key_exists( $key1, $optionsetdata[$optionrow] ) ? $optionsetdata[$optionrow][$key1] : '';
																			}

																		break;

																	default:

																			$delete_enable_flag = true;

																		break;
																}

															?>
																<?php  if( $deleted_flag == 'deleted'):?>

																	<?php echo $optionval;?> <span style="color:red"> has been deleted </span>

																<?php else:?>

																	<?php
																		if($key1 == 'cscript_location'){

																			echo $optionsetdata[$optionrow][$key1];

																		}elseif($key1 == 'code_snippets_location'){

																			echo $optionsetdata[$optionrow][$key1];

																		}elseif($key1 == 'cscript_display_to'){
																			if(esc_html( $optionval ) == ''){
																				echo 'All Pages';
																			}else{
																				echo esc_html( $optionval );
																			}
																		}elseif($key1 == 'robots_action'){

																			echo $optionsetdata[$optionrow][$key1];

																		}elseif($key1 == 'ibe_desktop_url'){

																			$optionval = json_decode($optionval);
																			$defaultURL = 'http://reservations.directwithhotels.com';

																			foreach($optionval as $key=>$value){
																				echo '<p style="padding:2px 0;">';
																				echo '<span style="display:inline-block; width:100px;font-weight:bold;">'.$key.'</span>';
																				$value = (array)$value;
																				$data = $value['data'];
																				$dektopDomain = $data->ibe_desktop_subdomain;

																				if(trim($dektopDomain) == '' || trim($dektopDomain) == 'https://'){
																					echo $defaultURL;
																				}else{
																					echo $dektopDomain;
																				}
																				/* foreach($data as $index=>$val){
																					echo $val;
																				} */
																				echo '</p>';
																			}
																		}elseif($key1 == 'ibe_url_switch'){
																			$value = esc_html( $optionval );
																			$arr = array(0=>'No',1=>'Yes');
																			echo $arr[$value];

																		}elseif($key1 == 'cta_language'){
																			$cta_language = $DWH_Options->get_option_set_data( 'dwh_cta_language' );
																			echo $cta_language[0]['cta_language'];

																		}elseif($key1 == 'ibe_url_switch_interval'){
																			$ibe_sync_interval = $DWH_Options->get_option_set_data( 'dwh_ibe_url_switch' );

																			$interval = isset( $ibe_sync_interval[0]['ibe_url_switch_interval'] ) ? $ibe_sync_interval[0]['ibe_url_switch_interval'].' hr' : '8 hr';
																			echo  $interval;

																		}else{
																			echo esc_html( $optionval );

																		}
																	?>
																<?php endif;
																		?>

															</td>

													<?php endif;?>


													<?php endforeach; ?>
														<td>

															<a href="#" class="btn-datatable-edit button-primary" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>" option_row="<?php echo $optionrow; ?>">Edit</a>

															<?php  if( $optionsval['multiple'] ):?>
																<?php if( $delete_enable_flag == true ):?>
																<a href="" class="btn-datatable-delete button-primary" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>" option_row="<?php echo $optionrow; ?>">Delete</a>
																<?php endif?>
															<?php endif; ?>

														</td>
												</tr>
									<?php
											endforeach;
										endif;
									?>

								 </tbody>
							</table>

							<?php

								if( $optionsval['multiple'] ){

									/* special case for Hotel */
									if( $optionskey == 'dwh_hotels' ){

										$currentOption = 'dwh_hotels';

										/* get Hotel Info */
										$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites', 0 );

										$hotelbranchhide = 'hide';

										if( $site_info ){
											/* only display if is corpsite */
											if( $site_info->corpsite_flag ){
												$hotelbranchhide = '';
											}
										}
							?>
										<a href="#" class="btn-datatable-add button-primary <?php echo $hotelbranchhide; ?>" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Add Branches</a>
							<?php
									}else{
										if($optionskey == 'dwh_sitemap'){
											if($totalContent == 0){ //show the add button
							?>
												<a href="#" class="btn-datatable-add button-primary sitemap-xml-add-button" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Add Sitemap XML</a>
							<?php
											}else{
												//dont show add button for sitemap_xml
							?>
												<a href="#" style="display:none" class="btn-datatable-add button-primary sitemap-xml-add-button" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Add Sitemap XML</a>
							<?php
											}
										}else if($optionskey == 'dwh_site_robots'){
											if($totalRobotsContent == 0){ //show the add button
							?>
												<a href="#" class="btn-datatable-add button-primary robots-txt-add-button" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Add Robots Text</a>
							<?php
											}else{
							?>
												<a href="#" style="display:none" class="btn-datatable-add button-primary robots-txt-add-button" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Add Robots Text</a>
							<?php
											}
										}else if($optionskey == 'dwh_cta_language'){
											if($totalCTALang == 0){ //show the add button
							?>
												<a href="#" class="btn-datatable-add button-primary cta-lang-add-button " option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Set CTA Language</a>
							<?php
											}else{
							?>
												<a href="#" style="display:none" class="btn-datatable-add button-primary cta-lang-add-button" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Set CTA Language</a>
							<?php
											}
										}else if($optionskey == 'dwh_ibe_url_switch'){
											if($totalSwitchIBEURL == 0){ //show the add button
							?>
												<a href="#" class="btn-datatable-add button-primary ibe-url-autosync-add-button" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Set IBE Auto Sync</a>
							<?php
											}else{
							?>
												<a href="#" style="display:none" class="btn-datatable-add button-primary ibe-url-autosync-add-button" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Set IBE Auto Sync</a>
							<?php
											}
										}else if($optionskey == 'dwh_ibe_url'){
											$currentOption = 'dwh_ibe_url';

											if($totalIBEUrlContent == 0){ //show add button
							?>
												<a href="#" class="btn-datatable-add generate-ibe-url-button button-primary" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Generate IBE URL</a>
							<?php

											}else{ //do not show the add button
							?>
												<a href="#" style="display:none" class="btn-datatable-add generate-ibe-url-button button-primary" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Generate IBE URL</a>
							<?php
											}

										}else{
											$currentOption = $optionskey;
							?>
											<a href="#" class="btn-datatable-add button-primary" option_title="<?php echo $optionsval['title']; ?>" option_set="<?php echo $optionskey; ?>">Add Entry</a>
							<?php
										}
									}

								}
							?>
					</div>

			<?php endforeach;?>
			<!-- end options view holder here -->



		<!-- edit options modal -->
		<div class="hide">
			<div class="options-popupmodal popup-edit">
				<div class="content">
					<div class="options-popupmodal-area">
						<a class="close" href="#">Close</a>
						<h3><?php _e( 'Edit Entry' ); ?></h3>
						<div class="options-popupmodal-fields">
						</div>
						<a href="#" class="btn-datatable-update button-primary">Update</a>
					</div>
					<div class="popup-event-notification" style="margin: 10px 0 0 20px; display:none;">
						<span class="event-loader">
							<img src="<?php echo  bloginfo('template_url'); ?>/images/ajaxloader.gif" />
						</span>
						<span class="event-message">Please wait...</span>
					</div>
				</div>
			</div>
			<div class="options-mask"></div>
		</div>
		<!-- end edit options modal -->

		<!-- add options modal -->
		<div class="hide">
			<div class="options-popupmodal popup-add">
				<div class="content">
					<div class="options-popupmodal-area">
						<a class="close" href="#">Close</a>
						<h3><?php _e( 'Add Entry' ); ?></h3>
						<div class="options-popupmodal-fields">

						</div>

						<a href="#" class="btn-datatable-processadd button-primary">Add</a>

					</div>
					<div class="popup-event-notification" style="margin: 10px 0 0 20px; display:none;">
						<span class="event-loader">
							<img src="<?php echo  bloginfo('template_url'); ?>/images/ajaxloader.gif" />
						</span>
						<span class="event-message">Please wait...</span>
					</div>
				</div>
			</div>
			<div class="options-mask"></div>
		</div>
		<!-- end add options modal -->

		<!-- preloader modal -->
		<div class="hide">
			<div class="options-preloader">Loading...</div>
			<div class="options-mask"></div>
		</div>
		<!-- end preloader modal -->

</div>
