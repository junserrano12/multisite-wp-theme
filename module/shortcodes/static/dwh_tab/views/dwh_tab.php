<?php
	
	extract( $data );
	
	$tab_title = isset( $atts['title'] ) ? $atts['title'] : '';
	
?>
	<div id="" class="tab tab-container" data-title="<?php echo $tab_title; ?>">
		<?php echo do_shortcode($content); ?>
	</div>
