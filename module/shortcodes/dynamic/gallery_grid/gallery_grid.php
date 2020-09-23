<?php
function gallery_grid( $atts )
{
	$data['atts'] = $atts;
	$data['dir'] = array('module/shortcodes/dynamic', __FUNCTION__ , 'views');
	$data['view'] = __FUNCTION__;	
	
	ob_start();
	_process_custom_content( load_view( $data ) );
	$html = ob_get_contents();
	ob_end_clean();
	
	return $html;
}

?>
