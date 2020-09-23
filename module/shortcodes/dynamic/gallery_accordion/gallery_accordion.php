<?php

function gallery_accordion( $atts )
{
	global $DWH_Options;
	
	/* Get site info */
	$site_info = (array) $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0);
	
	$data['atts'] = $atts;
	$data['site_info'] = $site_info;
	$data['dir'] = array('module/shortcodes/dynamic', __FUNCTION__ , 'views');
	$data['view'] = __FUNCTION__;	
	
	ob_start();
	
	_process_custom_content( load_view( $data ) );
	
	$html = ob_get_contents();
	ob_end_clean();
	
	return $html;

}


?>
