<?php
	extract( $data );
	$type = isset($atts['type']) ? $atts['type'] : 'text';	
	$marker_id = isset( $atts['id'] ) ? $atts['id'] : '';
	$promo_markers = $promo_marker_info;
?>

<?php if( $marker_id!="" ):?>

	<?php foreach ($promo_markers as $key => $promo_marker_info ) :?>

		<?php  if(  $promo_marker_info['promo_marker_id'] == $marker_id ) :?>
		
		<?php
				switch( $type ):
					case 'text' : 
		?>
						<div class="promo-marker-text">
						<?php echo isset( $promo_marker_info['text'] ) ? $promo_marker_info['text'] : '';?>
						</div>
		<?php
					break;
					case 'image' : 
						
						if( isset( $promo_marker_info['background_image'] ) )
							$imagesrc = wp_get_attachment_image_src( $promo_marker_info['background_image'] , 'full' )[0];
		?>
							<div class="promo-marker-text">
								<!-- Image ids to read here -->
								<img src="<?php echo $imagesrc; ?>" alt="">
							</div>
		<?php 
					break;
				endswitch;
			endif;
		?>

	<?php endforeach;?>

<?php endif;?>