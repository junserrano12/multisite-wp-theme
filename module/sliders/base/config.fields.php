<?php
	global $DWH_Slider, $DWH_Options;
	
	include( get_template_directory().'/module/sliders/base/base.php' );
	
	$slidersettings = $DWH_Options->get_option_set_properties( 'dwh_slider' );
	$slidersettingsdata = $DWH_Slider->get_slider_settings_default();
	$slideritems = $DWH_Slider->get_slider_config( 'all' );
	
	/* remove slider data */
	unset( $slidersettings['settings']['slider-data'] );
	
	$slidersettingsdata['slider-name'] = $slidername;
	$slidersettingsdata['details']['data-type'] = $data_type;
	
	
	$slider_config_arr['slider_settings']['field_settings'] = $slidersettings;
	$slider_config_arr['slider_settings']['field_data'] = $slidersettingsdata;
	$slider_config_arr['slider_items'] = $slideritems;
	$slider_config_arr['slider_data'] = $sliderdata;
	
	return $slider_config_arr;
	
?>