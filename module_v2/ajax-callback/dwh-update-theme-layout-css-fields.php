<?php
check_ajax_referer( 'dwh-update-theme-layout-css-fields', 'security' );
$data = $_POST['data'];
$custom_data = $data['custom_data'];

$template_layout    = isset( $custom_data['layout'] ) && dwh_empty( $custom_data['layout'] ) ? $custom_data['layout'] : 'blank-template';
$template_version   = dwh_get_theme_template( $template_layout );
$template_path      = get_template_directory().'/module_v2/theme-templates/'.$template_version.'/'.$template_layout;

$tags = isset( $custom_data['tags'] ) && dwh_empty( $custom_data['tags'] ) ? $custom_data['tags'] : false;

$results = array();

if ( $tags ) {
    foreach ( $tags as $key => $tag ) {
        $file = $template_path.'/'.$tag['type'].'/'.$tag['file'].'.'.$tag['extension'];

        if ( $template_version == 'v2' || $tag['file'] == 'style-above-the-fold' || $tag['type'] == 'template' ) {
            $results[$tag['handle']] = file_get_contents( $file );
        } else {
            $results[$tag['handle']] = '';
        }
    }
}

echo json_encode( $results );

wp_die();