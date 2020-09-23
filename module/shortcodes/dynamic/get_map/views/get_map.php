<?php 
	
	extract( $data );	

	$lat 			= $atts['map']['map_latitude'];
	$lng 			= $atts['map']['map_longitude'];
	$zoom 			= $atts['map']['map_zoom'];
	$iframe 		= $atts['map']['map_iframe'];

	if(isset($atts['width']) && ($atts['width'] != null || $atts['width'] != '')){
		$width = (is_numeric( substr($atts['width'], -1))) ? $atts['width'].'px' : $atts['width'];
	}else{
		if($atts['map']['map_width'] != '' || $atts['map']['map_width'] != null){
			$width = (is_numeric( substr($atts['map']['map_width'], -1))) ?  $atts['map']['map_width'].'px' : $atts['map']['map_width'];
		}else{
			$width = '100%';
		}
	}
			
	if(isset($atts['height']) && ($atts['height'] != null || $atts['height'] != '')){
		$height = (is_numeric( substr($atts['height'], -1))) ? $atts['height'].'px' : $atts['height'];
	}else{
		if($atts['map']['map_height'] != '' || $atts['map']['map_height'] != null){
			$height = (is_numeric( substr($atts['map']['map_height'], -1))) ?  $atts['map']['map_height'].'px' : $atts['map']['map_height'];
		}else{
			$height = '420px';
		}
	}
	
	if( $lat AND $lng ){
	
		$html  ='<div id="map-canvas" style="width: '. $width .'; height: '. $height .'" data-lat="'. $lat .'" data-lng="'. $lng .'" data-zoom="'. $zoom .'"></div>';

		echo $html;
		
	}


?>