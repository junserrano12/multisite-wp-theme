<?php
check_ajax_referer( 'dwh-reset-textarea-default-content', 'security' );
$data = $_POST['data'];
$custom_data = $data['custom_data'];

/*update path for layout and css path*/
$template_layout    = isset( $custom_data['layout'] ) && dwh_empty( $custom_data['layout'] ) ? $custom_data['layout'] : 'blank-template';
$template_version   = dwh_get_theme_template( $template_layout );

$custom_data['path'] = str_replace( array( 'dwh_get_theme_layout()', 'dwh_get_theme_template()' ), array( $template_layout, $template_version ), $custom_data['path'] );

$file_content = dwh_get_file_content( (object)$custom_data, true );
echo $file_content;

wp_die();