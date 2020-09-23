<div class="meta-box-slider">

	<?php
		/* Slider Settings */
		$data['dir'] = array('module','sliders/base','admin','views');
		$data['view'] = 'slider-settings';
		load_view( $data );
	?>
	
	<?php
		/* Slider Items */
		$data['customfields']['view_mode'] = 'all';
		$data['dir'] = array('module','sliders/base','admin','views');
		$data['view'] = 'slider-items';
		load_view( $data );
	?>
	
</div>