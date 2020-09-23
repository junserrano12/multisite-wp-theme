<?php

/* Enable flag for theme designer rendering  */
check_ajax_referer( 'option_theme_designer_reset', 'nonce_sec' );

global $DWH_Customization;

$design_set  = $_POST['data']['design_set'];
$option_value['design_styles'] = array();
$response = $DWH_Customization->reset_designer_set( $design_set, $option_value );

echo json_encode( array( 'success' => $response ) );

die();

?>