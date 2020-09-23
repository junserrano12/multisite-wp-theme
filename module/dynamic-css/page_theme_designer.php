<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
global $DWH_Customization;
global $DWH_Theme;

header("Content-type: text/css");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

if( isset( $_GET['theme'] ) )
{
	$theme = $_GET['theme'];
	echo $DWH_Customization->render( 'css' , 'site' , $theme );
}

?>