<?php 

	extract($data);
?>
<div id="slider" class="nivoSlider slider-default">

	<?php if( array( $sliderdata ) ):?>
		<?php if( $sliderdata['default_image_src'] ):?>
			<img src="<?php echo $sliderdata['default_image_src']; ?>" title="" alt=""/>
		<?php endif;?>
	<?php endif;?>
			
</div>