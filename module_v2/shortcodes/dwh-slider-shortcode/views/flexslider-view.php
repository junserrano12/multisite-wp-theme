<?php
global $DWH_wponetheme_slider;

$slider_atts = $viewData['atts'];
$slider_items = $viewData['slider_items'];

$slider_inline_colorbox_ctr = 0;
$output = '';

$output .= '<div id="'.$slider_atts['id'].'-container" class="loading">'."\n";
$output .= '	<div id="'.$slider_atts['id'].'" class="flexslider '.$slider_atts['class'].'">'."\n";
$output .= '		<ul class="slides">'."\n";

/*list slider items*/
foreach ( $slider_items as $key => $slider_item ) {
	/* check if slider is expired */
	if ( !dwh_is_expired( $slider_item['slider_expire'] ) ) {
		$output .= '<li>'."\n";
		/* switch output of slider item from map slider and iframe*/
		switch ( $slider_item['slider_output_type'] ) {
			case 'map':
				/*load iframe view*/

				$args = array(
							'longitude' => isset( $slider_item['slider_longitude'] ) ? $slider_item['slider_longitude'] : false,
							'latitude'  => isset( $slider_item['slider_latitude'] ) ? $slider_item['slider_latitude'] : false,
							'zoom'      => isset( $slider_item['slider_zoom'] ) ? $slider_item['slider_zoom'] : 16,
							'width'     => isset( $slider_item['slider_width'] ) ? $slider_item['slider_width'] : '100%',
							'height'    => isset( $slider_item['slider_height'] ) ? $slider_item['slider_height'] : '420px'
						);

				if ( $args['longitude'] && $args['latitude'] ) {
					$output .= '<div class="slider-map-container">'."\n";
					$output .= dwh_google_maps( $args, true );
					$output .= '</div>'."\n";
				} else {
					$output .= dwh_default_banner( array( 'class' => 'slider-image-container' ), true )."\n";
				}

				break;

			case 'iframe':
				/*load iframe view*/
				$args = array(
							'src'    => isset( $slider_item['slider_iframe_src'] ) ? $slider_item['slider_iframe_src'] : null,
							'type'   => 'html'
						);
				if ( isset( $args['src'] ) ) {

					$output .= '<div class="slider-iframe-container">'."\n";
					$output .= dwh_iframe( $args, true );
					$output .= '</div>'."\n";

				} else {

					$output .= dwh_default_banner( array( 'class' => 'slider-image-container' ), true )."\n";

				}

				break;

			case 'slider':
			default:
				/*load slider*/
				$title = preg_replace( array('/-/', '/_/', '/\d/'), array(' ', ' ', ''), get_the_title( $slider_item['slider_id'] ) );
				$image_title = dwh_empty( $slider_item['slider_title'] ) ? $slider_item['slider_title'] : $title;
				$image_alt = isset($slider_item['slider_alt']) && dwh_empty( $slider_item['slider_alt'] ) ? $slider_item['slider_alt'] : $title;
				$image_class = dwh_empty( $slider_item['slider_class'] ) ? 'wp-image-'.$slider_item['slider_id'].' '.$slider_item['slider_class'] : 'wp-image-'.$slider_item['slider_id'];
				$slider_image = '<img src="'.$slider_item['img_src'].'" class="'.$image_class.'" alt="'.$image_alt.'" title="'.$image_title.'" srcset="'.$slider_item['img_srcset'].'" width="'.$slider_item['image'][1].'" sizes="( max-width: '.$slider_item['image'][1].'px ) 100vw, '.$slider_item['image'][1].'px"/>';
				$slider_inline_colorbox_ctr = ( $slider_item['slider_colorbox'] == 'colorbox-inline' ) ? $slider_inline_colorbox_ctr + 1: $slider_inline_colorbox_ctr;
				$slider_link = null;

				if ( $slider_item['slider_colorbox'] == 'colorbox-inline' ) {
					$slider_link = '#container-'.$slider_item['slider_id'].'-'.$key;
				} else if ( $slider_item['slider_colorbox'] == 'colorbox' ) {
					$slider_link = $slider_item['img_modal_src'];
				} else {
					$slider_link = $slider_item['slider_link'];
				}

				$output .= '<div class="slider-image-container image-container">'."\n";

				if ( $slider_item['slider_colorbox'] == 'none' && !dwh_empty( $slider_item['slider_link'] ) ) {

					$output .= $slider_image."\n";

				} else {

					$output .= '<a href="'.$slider_link.'" class="'.$slider_item['slider_colorbox'].'" title="'.$slider_item['slider_caption'].'" rel="'.$slider_item['slider_rel'].'">'."\n";
					$output .= $slider_image."\n";
					$output .= '</a>'."\n";
				}

				$output .= '</div>'."\n";

				if ( dwh_empty( $slider_item['slider_caption'] ) ) {
					$output .= '<div class="slider-image-caption">'."\n";
					$output .= '	<div class="slider-caption">'.$slider_item['slider_caption'].'</div>'."\n";
					$output .= '</div>'."\n";
				}

				if ( dwh_empty( $slider_item['slider_overlay_content'] ) ) {
					$output .= $slider_item['slider_overlay_content']."\n";
				}

				break;

		} /*end switch*/

		$output .= '</li>'."\n";
	} /* end expire condition */
} /*end foreach*/

$output .= '		</ul>'."\n";
$output .= '	</div>'."\n";

/* if condition to load carousel thumbnail*/
if ( $slider_atts['type'] === 'thumbnail' ) {
	$output .= '<div id="thumbnail-'.$slider_atts['id'].'" class="flexslider flexslider-thumbnail">'."\n";
	$output .= '	<ul class="slides">'."\n";
	/*list slider items*/

	foreach ( $slider_items as $key => $slider_item ) {
		$title        = preg_replace( array('/-/', '/_/', '/\d/'), array(' ', ' ', ''), get_the_title( $slider_item['slider_id'] ) );
		$image_title  = isset( $slider_item['slider_title'] ) && dwh_empty( $slider_item['slider_title'] ) ? $slider_item['slider_title'] : $title;
		$image_alt    = isset( $slider_item['slider_alt'] ) && dwh_empty( $slider_item['slider_alt'] ) ? $slider_item['slider_alt'] : $title;
		$image_class  = isset( $slider_item['slider_class'] ) && dwh_empty( $slider_item['slider_class'] ) ? 'wp-image-'.$slider_item['slider_id'].' '.$slider_item['slider_class'] : 'wp-image-'.$slider_item['slider_id'];
		$slider_image = '<img src="'.$slider_item['img_thumbnail_src'].'" class="'.$image_class.'" alt="'.$image_alt.'" title="'.$image_title.'"/>';

		switch ( $slider_item['slider_output_type'] ) {
			case 'map':
			case 'iframe':

				$output .= '<li>'."\n";
				$output .= '	<div class="thumbnail-image-container">'."\n";
				$output .= dwh_logo( 'image', true )."\n";
				$output .= '	</div>'."\n";
				$output .= '</li>'."\n";

				break;

			case 'slider':
			default:

				/*load slider*/
				$output .= '<li>'."\n";
				$output .= '	<div class="thumbnail-image-container">'."\n";
				$output .= $slider_image."\n";
				$output .= '	</div>'."\n";
				$output .= '</li>'."\n";

				break;

		} /*end switch*/

	} /*end foreach*/
	$output .= '	</ul>'."\n";
	$output .= '</div>'."\n";

} /* close if condition*/

if ( $slider_inline_colorbox_ctr > 0 ) {
	$output .= '<div class="hide">'."\n";
	/*list slider items*/
	foreach ( $slider_items as $key => $slider_item ) {
		if ( dwh_empty( $slider_item['slider_id'] && $slider_item['slider_colorbox'] == 'colorbox-inline' ) ) {
			$output .= '<div id="container-'.$slider_item['slider_id'].'-'.$key.'">'."\n";
			$output .= $slider_item['slider_inline_content']."\n";
			$output .= '</div>'."\n";
		}
	} /*end foreach*/
	$output .= '</div>'."\n";
}

$output .= '</div>'."\n"; /*close slider container*/

echo $output;