<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
global $DWH_Customization;
global $DWH_Options;
global $DWH_Theme;

header("Content-type: text/css");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$page_info = $DWH_Options->get_option_set_data( 'dwh_pages' );
$page_info  = (array)$page_info;

if( $page_info )
{
	$theme = isset( $_GET['theme'] ) ? $_GET['theme'] : '';
	$style_type = isset( $_GET['style_type'] ) ? $_GET['style_type'] : '';

	if( $theme )
	{
		/* Get page info index based on a specific page theme */
		foreach ( $page_info as $key => $page_detail ) {

			if( $page_detail['page_theme'] ==  $theme )
			{
				$page_info = $page_detail;
			}
		}
	}

	echo isset( $page_info[$style_type] ) ? $page_info[$style_type] : '';	
}

?>
