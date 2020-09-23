<?php
global $DWH_wponetheme_list;

$atts           = $viewData['atts'];
$content        = $viewData['content'];

$output         = '';
$itemattributes = dwh_get_shortcode_atts( $content, array('dwh_item', 'dwh_inner_list') );
$itemtitles     = dwh_get_shortcode_atts_value( $itemattributes, 'title' );
$itemshow       = dwh_get_shortcode_atts_value( $itemattributes, 'show' );
$itemcontents   = dwh_get_shortcode_content( $content, array('dwh_item', 'dwh_inner_list') );

$output     .= '<div id="'.$atts['id'].'" class="'.$atts['class'].'">'."\n";
$output     .= '    <ul class="lists">'."\n";

foreach ( $itemcontents as $key => $itemcontent ) {
    $content     = $DWH_wponetheme_list->load_shortcode_content( $itemcontent );
    $output     .= '<li class="list-item">'."\n";
    $output     .= '    <div class="item-title">'."\n";
    $output     .= '        <p class="item-text list-text">'.$itemtitles[$key].'</p>'."\n";
    $output     .= '    </div>'."\n";
    $output     .= '    <div class="item-content">'."\n";
    $output     .= dwh_modify_the_content( $content )."\n";
    $output     .= '    </div>'."\n";
    $output     .= '</li>'."\n";
}

$output     .= '    </ul>'."\n";
$output     .= '</div>'."\n";

echo $output;