<?php
	
	global $post, $DWH_Slider;

	/* get slider data */
	$sliderdata = array();

	/* get page slider */
	if( $post ){
		
		$post_id = $post->ID;
		
		$slider_fields_arr = get_post_meta( $post_id, 'slider', true );

		/* get proper slider data from post meta */		
		if( is_array( $slider_fields_arr ) ) $sliderdata = $slider_fields_arr[0];
		
		$data_type = 'post_meta';
		
	}
	
	/* get slider list */
	$slider_list = $DWH_Slider->get_slider_list();
	$slidername = array();
	
	foreach( $slider_list as $key => $val ){
		
		$slidername[$val] = array(
								'name' => ucfirst( $val ),
								'value' => $val
							);
	
	}

?>