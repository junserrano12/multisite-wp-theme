<?php
	
	if( isset( $data['sliderdata'] ) ) :
	
		$sliderdata = $data['sliderdata'];
		$slidertype = trim( $sliderdata['slider-type'][0] );
		$imagethumbsrc = array();
		$thumbnailiframe = get_template_directory_uri() .'/images/banner-150x150.jpg';
		$thumbnailmap = get_template_directory_uri() .'/images/banner-150x150.jpg';
		$sliderpopup = array();
		
		/* put marker if thumbnail medium or thumbnail small */
		if( $slidertype == "Thumbnail Medium" ):
			echo '<input type="hidden" name="slider-new-thumbnail-medium" value="Thumbnail Medium"/>';
		
		elseif( $slidertype == "Thumbnail Large" ):
			echo '<input type="hidden" name="slider-new-thumbnail-large" value="Thumbnail Large"/>';
			
		else:
			echo '<input type="hidden" name="slider-new-thumbnail-small" value="Thumbnail Small"/>';
			$thumbnailiframe = get_template_directory_uri() .'/images/banner-40x40.jpg';
			$thumbnailmap = get_template_directory_uri() .'/images/banner-40x40.jpg';
		
		endif;
		
		/* Get hotel info */
		global $DWH_Options;
		$hotel_info = $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0 );										
		$hotelnamelocation = $hotel_info->hotel_name .' in '. $hotel_info->hotel_location;
		
?>
	
			<div class="flexslider slider-thumb">
				<ul class="slides">
					
					<?php
						$ctr = 0;
						$expirectr = 0;
						
						foreach( $sliderdata['slider-item-type'] as $itemtype ){
							
							/* 
							* if iframe
							*/
							if( $itemtype == 'iframe' ):
								
								if( $sliderdata['slider-item-iframe'][ $ctr ] ):
					?>
									<li>
										<div class="slider-iframe-container">
											<?php 
												echo $sliderdata['slider-item-iframe'][ $ctr ]; 
												$imagethumbsrc[] = $thumbnailiframe;
											?>
										</div>
									</li>
					<?php
								endif;
								
							/* 
							* if map
							*/
							
							elseif( $itemtype == 'map' ):
							
								/* Get map info */
								$map_info = $sliderdata['map'];
								$map_width  = ($map_info['map_width'] != '' || $map_info['map_width'] != null) ? $map_info['map_width'] : '100%'; 
								$map_height = ($map_info['map_height'] != '' || $map_info['map_height'] != null) ? $map_info['map_height'] : '420px';
								
								if( $map_info['map_latitude'] && $map_info['map_longitude'] ):
					?>
									<li>
										<div class="slider-map-container">
											<?php 
												echo do_shortcode('[dwh_map lat="'. $map_info['map_latitude'] .'" lng="'. $map_info['map_longitude'] .'" width="'.$map_width.'" height="'.$map_height.'" id="newmapwrapper'. $ctr .'"]');
												$imagethumbsrc[] = $thumbnailmap;
											?>
										</div>
									</li>
					<?php	
								endif;
								
							/* 
							* if slider
							*/
							elseif( $itemtype == 'slider' ):
								
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
										
										$itempopup = trim( $sliderdata['slider-item-popup'][$ctr] ) != '' ? trim( $sliderdata['slider-item-popup'][$ctr] ) : 'default';
										$itemtitle = trim( $sliderdata['slider-item-title'][$ctr] );
										$itemcaption =  isset( $sliderdata['slider-item-caption'][$ctr] ) ? $sliderdata['slider-item-caption'][$ctr] : '' ;
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
										
										$customthumbsize = array(150, 150);
										if( $slidertype == "Thumbnail Small" ) $customthumbsize = 'small-thumbnail-image';
										if( $slidertype == "Thumbnail Medium" ) $customthumbsize = 'medium-thumbnail-image';
										if( $slidertype == "Thumbnail Large" ) $customthumbsize = 'large-thumbnail-image';
										
										$imagethumbsrc[] = wp_get_attachment_image_src( $itemid , $customthumbsize )[0];
										
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
																<img src="<?php echo makeAbsoluteToRelative($imagesrc); ?>" class="slider-image" title="<?php echo $itemimagetitle; ?>" alt="<?php echo $itemimagealt; ?>" />
															</a>
												<?php
														}
														else{
												?>
															<img src="<?php echo makeAbsoluteToRelative($imagesrc); ?>" class="slider-image" title="<?php echo $itemimagetitle; ?>" alt="<?php echo $itemimagealt; ?>" />
												<?php
														}
													}
													
													/* 
													* item is popup
													*/
													elseif( $itempopup == 'popup' ){
														
												?>
														<a class="colorbox" <?php echo $itemrelfinal; ?> title="<?php echo $itemtitle; ?>" href="<?php echo $imagesrc; ?>">
															<img src="<?php echo makeAbsoluteToRelative($imagesrc); ?>" class="slider-image" title="<?php echo $itemimagetitle; ?>" alt="<?php echo $itemimagealt; ?>" />
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
															<img src="<?php echo makeAbsoluteToRelative($imagesrc); ?>" class="slider-image" title="<?php echo $itemimagetitle; ?>" alt="<?php echo $itemimagealt; ?>" />
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
														/* if( $itemtitle )
															echo '<p class="slider-title"><?php echo $itemtitle; ?></p>'; */
													?>
															
													<?php
														if( $itemcaption )
													?>
															<div class="slider-caption"><?php echo $itemcaption; ?></div>
													<?php
														if( $itemimagedesc )
													?>
															<div class="slider-description"><?php echo $itemimagedesc; ?></div>
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
									}
									
									/* else add default image */
									else{
									
										/* prepare custom thumbnail size */
										$customthumbsize = $sliderdata['default_image_src']['medium'];
										if( $slidertype == "Thumbnail Small" ) $customthumbsize = $sliderdata['default_image_src']['small'];
										elseif( $slidertype == "Thumbnail Large" ) $customthumbsize = $sliderdata['default_image_src']['large'];
										
										$imagethumbsrc[] = $customthumbsize;
					?>	
										<li>
											<div class="slider-image-container">
												<img src="<?php echo makeAbsoluteToRelative($sliderdata['default_image_src']['full']); ?>" title="<?php echo $hotelnamelocation; ?>" alt="<?php echo $hotelnamelocation; ?>"/>
											</div>
										</li>
					<?php
									}
									
								}
								else{
									$expirectr++;
								}
								
							endif;
							
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
			
			
			<!-- setup carousel -->
			<?php
				if( $imagethumbsrc && count( $imagethumbsrc ) > 1 ):
			?>
					<div id="carousel-thumb" class="flexslider carousel-thumb">
						<ul class="slides">
							<?php
								foreach( $imagethumbsrc as $img ):
							?>
									<li>
										<div class="slider-image-container">
										  	<img src="<?php echo makeAbsoluteToRelative($img); ?>" title="<?php echo $hotelnamelocation; ?>" alt="<?php echo $hotelnamelocation; ?>" />
										</div>
									</li>
							<?php
								endforeach;
							?>
						</ul>
					</div>
			<?php	
				endif;
			?>
			
			
			<!-- prepare hidden popups -->
			<?php
				foreach( $sliderpopup as $popup ):
					$popupcontent = trim( $sliderdata['slider-item-description'][$popup] );
			?>
					
					<div class="hide">
						<div id="colorbox-inline-popup-<?php echo $popup; ?>">
							<?php echo wpautop( $popupcontent ); ?>
						</div>	
					</div>
					
			<?php
				endforeach;
			?>
			<!-- end hidden popups -->
	
<?php
	endif;
 ?>