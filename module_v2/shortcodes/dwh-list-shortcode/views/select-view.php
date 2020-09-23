<?php
global $DWH_wponetheme_list;

$atts           = $viewData['atts'];
$content        = $viewData['content'];

$output         = '';
$itemattributes = dwh_get_shortcode_atts( $content, array('dwh_item', 'dwh_inner_list') );
$itemtitles     = dwh_get_shortcode_atts_value( $itemattributes, 'title' );
$itemshow       = dwh_get_shortcode_atts_value( $itemattributes, 'show' );
$itemcontents   = dwh_get_shortcode_content( $content, array('dwh_item', 'dwh_inner_list') );

$output .= '<div id="'.$atts['id'].'" class="'.$atts['class'].'">'."\n";
$output .= '    <div class="select-title-container">'."\n";
$output .= '        <select class="select-list">'."\n";

foreach ( $itemtitles as $key => $itemtitle ) {
    $selected = ( $key < 1 ) ? ' selected' : null;
    $output .= '        <option class="item-title" value="#'.$atts['id'].'-select-content-'.$key.'">'.$itemtitle.'</option>'."\n";
}

$output .= '        </select>'."\n";
$output .= '    </div>'."\n";
$output .= '    <div class="select-content-container">'."\n";

foreach ( $itemcontents as $key => $itemcontent ) {
    $content = $DWH_wponetheme_list->load_shortcode_content( $itemcontent );
    $display = ( $key < 1 ) ? 'block' : 'none';
    $activeclass = ( $key < 1 ) ? ' item-active' : null;

    $output .= '    <div id="'.$atts['id'].'-select-content-'.$key.'" class="item-content'.$activeclass.'" style="display:'.$display.'">'."\n";
    $output .= dwh_modify_the_content( $content )."\n";
    $output .= '    </div>'."\n";
}

$output .= '    </div>'."\n";
$output .= '</div>'."\n";

echo $output;