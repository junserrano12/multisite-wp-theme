<?php
	
	extract( $data );
	
	$container_id 	= isset($atts['id']) ? trim( $atts['id'] ) : '';
	$lat 			= isset($atts['lat']) ? trim( $atts['lat'] ) : '';
	$lng 			= isset($atts['lng']) ? trim( $atts['lng'] ) : '';
	
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


	if( $container_id !="" AND $lat !="" AND $lng !="" ){
	 
		$html = '';
		$html = '<div id="'.$container_id.'" class="dwh-map-container" style="width: '.$width.'; height: '.$height.'" data-lat="'. $lat .'" data-lng="'. $lng .'" ></div>';
						 
		echo $html;		
	}

?>