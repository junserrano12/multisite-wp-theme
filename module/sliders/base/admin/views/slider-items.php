<?php
	/* 
	* when $data['customfields'] is being extracted,
	* ff. main array holder below
	* $slider_settings - holds the slider settings config
	* $slider_items - holds the slider item config
	* $slider_data - holds the slider data
	*/
	extract( $data['customfields'] );
?>

<?php
	global $DWH_Slider;
	
	echo $DWH_Slider->new_slider( $slider_items, $slider_data );
?>