<?php
global $DWH_wponetheme_slider;

$slider_atts = $viewData['atts'];
$slider_items = $viewData['slider_items'];
$slider_inline_colorbox_ctr = 0;
$output = '';

$output .= '<div id="'.$slider_atts['id'].'-container">'."\n";
$output .= '    <div id="'.$slider_atts['id'].'" class="nivoSlider '.$slider_atts['class'].'">'."\n";
/*list slider items*/
foreach ( $slider_items as $key => $slider_item ) {

    /* check if slider is expired */
    if ( !dwh_is_expired( $slider_item['slider_expire'] ) ) {

        $title = preg_replace( array('/-/', '/_/', '/\d/'), array(' ', ' ', ''), get_the_title( $slider_item['slider_id'] ) );
        $image_title = dwh_empty( $slider_item['slider_title'] ) ? $slider_item['slider_title'] : $title;
        $image_caption = dwh_empty( $slider_item['slider_caption'] ) ? $slider_item['slider_caption'] : $image_title;
        $image_alt = dwh_empty( $slider_item['slider_alt'] ) ? $slider_item['slider_alt'] : $title;
        $image_class = dwh_empty( $slider_item['slider_class'] ) ? 'wp-image-'.$slider_item['slider_id'].' '.$slider_item['slider_class'] : 'wp-image-'.$slider_item['slider_id'];
        $image_thumbnail = ( $slider_atts['type'] === 'thumbnail' ) ? 'data-thumb="'.$slider_item['img_thumbnail_src'].'" ' : null;
        $slider_image = '<img '.$image_thumbnail.'src="'.$slider_item['img_src'].'" class="'.$image_class.'" alt="'.$image_alt.'" title="'.$image_caption.'" srcset="'.$slider_item['img_srcset'].'" width="'.$slider_item['image'][1].'" sizes="( max-width: '.$slider_item['image'][1].'px ) 100vw, '.$slider_item['image'][1].'px"/>';
        $slider_inline_colorbox_ctr = ( $slider_item['slider_colorbox'] == 'colorbox-inline' ) ? $slider_inline_colorbox_ctr + 1: $slider_inline_colorbox_ctr;

        if ( $slider_item['slider_colorbox'] == 'colorbox-inline' ) {
            $slider_link = '#container-'.$slider_item['slider_id'].'-'.$key;
        } else if ( $slider_item['slider_colorbox'] == 'colorbox' ) {
            $slider_link = $slider_item['img_modal_src'];
        } else {
            $slider_link = $slider_item['slider_link'];
        }

        if ( $slider_item['slider_colorbox'] == 'default' || $slider_item['slider_colorbox'] == 'none' && !dwh_empty( $slider_item['slider_link'] ) ) {

            $output .= $slider_image."\n";

        } else {

            $output .= '<a href="'.$slider_link.'" class="'.$slider_item['slider_colorbox'].'" title="'.$slider_item['slider_caption'].'" rel="'.$slider_item['slider_rel'].'">'."\n";
            $output .= $slider_image."\n";
            $output .= '</a>'."\n";
        }

    } /* end expire condition */
} /*end foreach*/
$output .= '    </div>'."\n";
$output .= '</div>'."\n";

if ( $slider_inline_colorbox_ctr > 0 ) {
    /*list slider items*/
    $output .= '<div class="hide">'."\n";
    foreach ( $slider_items as $key => $slider_item ) {
        if ( dwh_empty( $slider_item['slider_id'] && $slider_item['slider_colorbox'] == 'colorbox-inline' ) ) {
            $output .= '<div id="container-'.$slider_item['slider_id'].'-'.$key.'">'."\n";
            $output .= $slider_item['slider_inline_content']."\n";
            $output .= '</div>'."\n";
        }
    } /*end foreach*/
    $output .= '</div>'."\n";
}

echo $output;