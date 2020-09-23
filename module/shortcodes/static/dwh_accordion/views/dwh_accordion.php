<?php

	extract( $data );
	$accordion_title = isset( $atts['title'] ) ? $atts['title'] : '';
?>

	<li class="accordion-item">
		<div class="accordion-caption">
			<a href=""><?php echo $accordion_title; ?></a>
		</div>
		<div style="display:block" id="" class="accordion-content">
			<div class="row-fluid"><?php echo do_shortcode( $content ); ?></div>
		</div>
	</li>