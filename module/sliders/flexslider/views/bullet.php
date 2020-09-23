<?php
	
	if( isset( $data['sliderdata'] ) ){
		
		$sliderdata = $data['sliderdata'];
		$sliderpopup = array();
		
		/* put marker if bullet slider */
		if( trim( $sliderdata['slider-type'][0] ) == "Bullet Slider" ){
			echo '<input type="hidden" name="slider-new-bullet" value="Bullet Slider"/>';
		}
		
		/* Get hotel info */
		global $DWH_Options;
		$hotel_info = $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0 );										
		$hotelnamelocation = $hotel_info->hotel_name .' in '. $hotel_info->hotel_location;
?>
	
			<div id="slider" class="flexslider slider-default">
				<ul class="slides">
					
					<?php
						$ctr = 0;
						$expirectr = 0;
						$is_first_image = true;
						
						foreach( $sliderdata['slider-item-type'] as $itemtype )
						{
							
							/*check if is first image*/
							$img_data_src = ($is_first_image) ? null : 'data-';
							$img_data_class = ($is_first_image) ? null : ' lazy';

							/* 
							* if iframe
							*/
							if( $itemtype == 'iframe' ){
					?>
							
								<li>
									<div class="slider-iframe-container">
										<?php echo $sliderdata['slider-item-iframe'][ $ctr ]; ?>
									</div>
								</li>
					
					<?php
							}
							
							/* 
							* if map
							*/
							
							elseif( $itemtype == 'map' )
							{
								
								/* Get map info */
								$map_info 	= $sliderdata['map'];
								$map_width  = ($map_info['map_width'] != '' || $map_info['map_width'] != null) ? $map_info['map_width'] : '100%'; 
								$map_height = ($map_info['map_height'] != '' || $map_info['map_height'] != null) ? $map_info['map_height'] : '420px';
								
								if( $map_info['map_latitude'] && $map_info['map_longitude'] )
								{
					?>
									<li>
										<div class="slider-map-container">
											<?php echo do_shortcode('[dwh_map lat="'. $map_info['map_latitude'] .'" lng="'. $map_info['map_longitude'] .'" width="'.$map_width.'" height="'.$map_height.'" id="newmapwrapper'. $ctr .'"]'); ?>
										</div>
									</li>
					<?php	
								}
							}
							
							/* 
							* if slider
							*/
							elseif( $itemtype == 'slider' )
							{
								
								$datenow = date('d-M-Y');
								$expiredate = $datenow;
								if( isset( $sliderdata['slider-item-expire'][$ctr] ) ){
									$expiredate = trim( $sliderdata['slider-item-expire'][$ctr] ) != '' ? $sliderdata['slider-item-expire'][$ctr] : $datenow;
								}
								
								/* validate item expiration  */
								if( strtotime($expiredate) >= strtotime($datenow) ){
								
									$itemid = trim( $sliderdata['slider-item-id'][$ctr] );
									/* 
									* only display if with image id
									*/
									if( $itemid ){
										
										$itempopup = trim( $sliderdata['slider-item-popup'][$ctr] ) != '' ? trim( $sliderdata['slider-item-popup'][$ctr] ) : 'default' ;
										$itemtitle = trim( $sliderdata['slider-item-title'][$ctr] );
										$itemcaption = isset( $sliderdata['slider-item-caption'][$ctr] ) ? $sliderdata['slider-item-caption'][$ctr] : '' ;
										$itemoverlaycontent = isset( $sliderdata['slider-item-overlaycontent'][$ctr] ) ? trim( $sliderdata['slider-item-overlaycontent'][$ctr] ) : '';
										$itemurl = trim( $sliderdata['slider-item-url'][$ctr] );
										$itemclass = trim( $sliderdata['slider-item-class'][$ctr] );
										$itemdesc = trim( $sliderdata['slider-item-description'][$ctr] );
										$itemrel = trim( $sliderdata['slider-item-rel'][$ctr] );
										$imagesrc = wp_get_attachment_image_src( $itemid , 'full' )[0]; 
										
										/* Get image object */
										$slider_image_info = get_post( $itemid );
										
										$itemimagetitle = $slider_image_info->post_title;
										$itemimagetitle = $itemimagetitle == '' ? $itemtitle : $itemimagetitle;
										$itemimagetitle = $itemimagetitle == '' ? $hotelnamelocation : $itemimagetitle;
										
										$itemimagealt = get_post_meta( $itemid, '_wp_attachment_image_alt', true);
										$itemimagealt = $itemimagealt  == '' ? $hotelnamelocation : $itemimagealt;
										
										$itemrelfinal = $itemrel != '' ? 'rel="'. $itemrel .'"' : '';
										$itemurlfinal = $itemurl != '' ? 'href="'. $itemurl .'" target="_blank"' : $itemurl;
										$itemclassfinal = $itemclass != '' ? ' class="'. $itemclass .'" ' : '';
										
					?>
										<li>
											<div class="slider-image-container">
												
												<?php
												
													/* 
													* item is default
													*/
													if( $itempopup == 'default' ){
														
														if( $itemurlfinal ){
												?>		
														
															<a <?php echo $itemurlfinal . $itemclassfinal; ?>>
																<img <?php echo $img_data_src; ?>src="<?php echo makeAbsoluteToRelative($imagesrc); ?>" class="slider-image<?php echo $img_data_class; ?>" title="<?php echo $itemimagetitle; ?>" alt="<?php echo $itemimagealt; ?>" />
															</a>
												<?php
														}
														else{
												?>
															<img <?php echo $img_data_src; ?>src="<?php echo makeAbsoluteToRelative($imagesrc); ?>" class="slider-image<?php echo $img_data_class; ?>" title="<?php echo $itemimagetitle; ?>" alt="<?php echo $itemimagealt; ?>" />
												<?php		
														}
													}
													
													/* 
													* item is popup
													*/
													elseif( $itempopup == 'popup' ){
														
												?>
														<a class="colorbox" <?php echo $itemrelfinal; ?> title="<?php echo $itemtitle; ?>" href="<?php echo $imagesrc; ?>">
															<img <?php echo $img_data_src; ?>src="<?php echo makeAbsoluteToRelative($imagesrc); ?>" class="slider-image<?php echo $img_data_class; ?>" title="<?php echo $itemimagetitle; ?>" alt="<?php echo $itemimagealt; ?>" />
														</a>
												
												<?php
													}
												
													/* 
													* item is popupwithcontent
													*/
													elseif( $itempopup == 'popupwithcontent' ){
													
														/* store ctr value to sliderpopup array */
														$sliderpopup[] = $ctr;
												?>
														
														<a class="colorbox-inline" <?php echo $itemrelfinal; ?> href="#colorbox-inline-popup-<?php echo $ctr; ?>">
															<img <?php echo $img_data_src; ?>src="<?php echo makeAbsoluteToRelative($imagesrc); ?>" class="slider-image<?php echo $img_data_class; ?>" title="<?php echo $itemimagetitle; ?>" alt="<?php echo $itemimagealt; ?>" />
														</a>
														
												<?php
													}
												?>

											</div>
											
										<?php 
											/* 
											* display caption
											*/
											/* $itemtitle = $itemtitle == '' ? $slider_image_info->post_title : $itemtitle; */
											$itemcaption = $itemcaption == '' ? $slider_image_info->post_excerpt : $itemcaption;
											$itemimagedesc = $slider_image_info->post_content;
											
											if( $itemcaption OR $itemimagedesc ){
										?>
												<div class="slider-image-caption">
													<?php
														if( $itemcaption ){
													?>
															<div class="slider-caption"><?php echo $itemcaption; ?></div>
													<?php
														}
														
														if( $itemimagedesc ){
													?>
															<div class="slider-description"><?php echo $itemimagedesc; ?></div>
													<?php
														}
													?>
												</div>
										<?php
											}
										?>
										
										<?php
											/* marker shortcode goes here.. */
											if( $itemoverlaycontent ){
												echo do_shortcode( $itemoverlaycontent );
											}
										?>
										
										</li>
					
					<?php
									/* update tag to check first image */
									$is_first_image = false;

									}
									
									/* else add default image */
									else{
					?>	
										<li>
											<div class="slider-image-container">
												<img src="<?php echo makeAbsoluteToRelative($sliderdata['default_image_src']['full']); ?>" title="<?php echo $hotelnamelocation; ?>" alt="<?php echo $hotelnamelocation; ?>"/>
											</div>
										</li>
					<?php
									}
									
								}
								
								/* if all image are expire */
								else{ 
									$expirectr++; 
								}
								
							}
							
							$ctr++;
						}
						
						/* if items were all expired */
						if( $expirectr >= count( $sliderdata['slider-item-type'] ) ){
					?>
							<li>
								<div class="slider-image-container">
									<img src="<?php echo makeAbsoluteToRelative($sliderdata['default_image_src']['full']); ?>" title="<?php echo $hotelnamelocation; ?>" alt="<?php echo $hotelnamelocation; ?>"/>
								</div>
							</li>
					<?php
						}
					?>
					
				</ul>
			</div>
		
			<!-- prepare hidden popups -->
			<?php
				foreach( $sliderpopup as $popup ){
					$popupcontent = trim( $sliderdata['slider-item-description'][$popup] );
			?>
					
					<div class="hide">
						<div id="colorbox-inline-popup-<?php echo $popup; ?>">
							<?php echo wpautop( $popupcontent ); ?>
						</div>	
					</div>
					
			<?php
				}
			?>
			<!-- end hidden popups -->
<?php
	}
 ?>