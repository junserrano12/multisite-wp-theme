<?php
	global $DWH_Slider, $DWH_Options;
	
	$slidersettings = $DWH_Options->get_option_set_properties( 'dwh_slider' );
	$slideritems = $DWH_Slider->get_slider_config( 'all' );
	
	/* remove slider_data key */
	unset( $slidersettings['settings']['slider-data'] );
	
	/* slider fields array */
	$sliderfields = array();
	$slideritemsfields = array();
	
	/* loop through slider settings config first */
	foreach( $slidersettings['settings'] as $key => $val ){
		
		/* assign key to slider field array key */
		$sliderfields[ $key ] = '';
	}
	
	/* then, loop through slider items config */
	foreach( $slideritems as $key => $val ){
		
		if( $val['settings'] ){
			foreach( $val['settings'] as $key1 => $val1 ){
				
				/* assign key to slider field array key */
				$slideritemsfields[ $key1 ] = '';
			}
			
		}
	
	}
	
	$sliderfields['slider-item'] = $slideritemsfields;
	
	return $sliderfields; 
	
?>