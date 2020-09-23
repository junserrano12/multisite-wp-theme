<?php 

	extract($data);
	
	/* Get hotel info */
	global $DWH_Options;
	$hotel_info = $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0 );										
	$hotelnamelocation = $hotel_info->hotel_name .' in '. $hotel_info->hotel_location;
?>
<div id="slider" class="flexslider slider-default">
	<ul class="slides">
		<li>
			<div class="slider-image-container">

				<?php if( array( $sliderdata ) ):?>
					<?php if( $sliderdata['default_image_src'] ):?>
						<img src="<?php echo makeAbsoluteToRelative($sliderdata['default_image_src']['full']); ?>" title="<?php echo $hotelnamelocation; ?>" alt="<?php echo $hotelnamelocation; ?>"/>
					<?php endif;?>
				<?php endif;?>
				
			</div>
		</li>		
	</ul>
</div>