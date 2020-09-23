<?php

/* Enable flag for theme designer rendering  */
check_ajax_referer( 'option_theme_designer_enable', 'nonce_sec' );

global $DWH_Customization;

$enable_flag = $_POST['designer_enable_flag'];
$design_set  = $_POST['design_set'];

$response = $DWH_Customization->enable( $design_set , $enable_flag );
echo json_encode( array( 'success' => $response ) );

die();

?>