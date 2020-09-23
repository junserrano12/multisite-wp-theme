<?php
/* Site theme - Site Css */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
global $DWH_Options;
global $DWH_Theme;

header("Content-type: text/css");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$site_info 	= $DWH_Options->get_dwh_site_option_field( 'dwh_sites', 0 );
$site_cdn 	= isset( $site_info->site_theme ) ? $site_info->cdn_flag : 0;	
$site_css 	= isset( $site_info->site_css ) ? _minify_dynamic_css($site_info->site_css) : '';

if( $DWH_Theme->cdn_enable() ) {
	if($site_cdn){
		echo dwh_convert_path_to_relative($site_css);
	}else{
		echo dwh_convert_path_to_cdn($site_css);
	}
} else {
	echo dwh_convert_path_to_relative($site_css);
}

?>