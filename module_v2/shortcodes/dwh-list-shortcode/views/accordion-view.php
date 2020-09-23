<?php
global $DWH_wponetheme_list;

$atts           = $viewData['atts'];
$content        = $viewData['content'];

$output         = '';
$itemattributes = dwh_get_shortcode_atts( $content, array('dwh_item', 'dwh_inner_list') );
$itemtitles     = dwh_get_shortcode_atts_value( $itemattributes, 'title' );
$itemshow       = dwh_get_shortcode_atts_value( $itemattributes, 'show' );
$itemcontents   = dwh_get_shortcode_content( $content, array('dwh_item', 'dwh_inner_list') );

$output .= '<div id="'.$atts['id'].'" class="'.$atts['class'].'" data-effect="'.$atts['accordioneffect'].'" data-toggle="'.$atts['accordiontoggle'].'">'."\n";
$output .= '    <ul class="accordion-list">'."\n";

foreach ( $itemcontents as $key => $itemcontent ) {

    $content = $DWH_wponetheme_list->load_shortcode_content( $itemcontent );

    if ( $atts['accordiondisplay'] == 'all' ) {
        $display  = 'block';
        $activeclass = ' item-active';
    } else if ( $atts['accordiondisplay'] == 'none' ) {
        $display  = 'none';
        $activeclass = null;
    } else {
        $display  = ( $itemshow[$key] ) ? 'block' : 'none';
        $activeclass = ( $itemshow[$key] ) ? ' item-active' : null;
    }

    $output .= '    <li class="accordion-item">'."\n";
    $output .= '        <div class="item-title'.$activeclass.'">'."\n";
    $output .= '            <a href="#'.$atts['id'].'-accordion-content-'.$key.'" class="item-link accordion-link">'.$itemtitles[$key].'</a>'."\n";
    $output .= '        </div>'."\n";
    $output .= '        <div id="'.$atts['id'].'-accordion-content-'.$key.'" class="item-content'.$activeclass.'" style="display:'.$display.'">'."\n";
    $output .= dwh_modify_the_content( $content )."\n";
    $output .= '        </div>'."\n";
    $output .= '    </li>'."\n";

}

$output .= '    </ul>'."\n";
$output .= '</div>'."\n";

echo $output;