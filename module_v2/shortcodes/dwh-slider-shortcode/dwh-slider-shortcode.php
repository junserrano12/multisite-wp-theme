<?php
if ( !function_exists( 'dwh_slider_shortcode' ) )
{
	function dwh_slider_shortcode( $atts )
	{

		ob_start();
		dwh_slider( $atts );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}

if ( !function_exists( 'dwh_slider' ) )
{
	function dwh_slider( $atts, $return = false )
	{
		global $DWH_wponetheme_slider;

		/*convert int and bool string to bool and int variable*/
		if ( $atts ) {
			foreach ( $atts as $key => $value ) {

				if ( $value == 'true' ) {
					$value = true;
				} else if( $value == 'false' ) {
					$value = false;
				} else if ( is_numeric( $value ) ) {
					$value = (int)$value;
				}

				$atts[$key] = $value;
			}

		}


		$slider        		      = isset( $atts['slider'] ) ? $atts['slider'] : 'flexslider'; /*flexslider, nivo, carousel*/
		$type 				      = isset( $atts['type'] ) ? $atts['type'] : 'default'; /*default, bullet, thumbnail*/
		$id             	      = isset( $atts['id'] ) ? $atts['id'] : 'dwh-slider-'.$slider.'-'.$DWH_wponetheme_slider->counter;
		$class       		      = isset( $atts['class'] ) ? $slider.'-slider '.$atts['class'] : $slider.'-slider';

		$defaultselector 		  = isset( $atts['id'] ) ? '#'.$atts['id'] : '#main-'.$id ;
		$selector       		  = isset( $atts['selector'] ) ? $atts['selector'] : $defaultselector;
		$selectorrd 	 		  = str_replace( array( '.', '#', '-'), array( '_class_', '_id_', '_' ), $selector );
		$sliderobject 	 		  = 'dwh_'.$slider.$selectorrd;

		$imagesize 				  = isset( $atts['imagesize'] ) ? $atts['imagesize'] : 'full';
		$modalsize 				  = isset( $atts['modalsize'] ) ? $atts['modalsize'] : 'large';
		$thumbnailsize			  = isset( $atts['thumbnailsize'] ) ? $atts['thumbnailsize'] : 'small-thumbnail-image';

		$args					  = array();
		$args['id']               = isset( $atts['id'] ) ? $atts['id'] : $id;
		$args['class']            = isset( $atts['class'] ) ? $atts['class'] : $class;
		$args['slider']           = isset( $atts['slider'] ) ? $atts['slider'] : $slider;
		$args['type']             = isset( $atts['type'] ) ? $atts['type'] : $type;
		$args['selector']         = isset( $atts['selector'] ) ? $atts['selector'] : $selector;
		$args['imagesize'] 	      = isset( $atts['imagesize'] ) ? $atts['imagesize'] : $imagesize;
		$args['modalsize'] 	      = isset( $atts['modalsize'] ) ? $atts['modalsize'] : $modalsize;
		$args['thumbnailsize'] 	  = isset( $atts['thumbnailsize'] ) ? $atts['thumbnailsize'] : $thumbnailsize;
		$args['disable'] 	      = isset( $atts['disable'] ) ? $atts['disable'] : false;

		$args['datasrc'] 		  = isset( $atts['datasrc'] ) ? $atts['datasrc'] : 'media';
		$args['ids'] 			  = isset( $atts['ids'] ) ? $atts['ids'] : null;
		$args['posttype']		  = isset( $atts['posttype'] ) ? $atts['posttype'] : 'collection';

		switch ( $slider ) {
			case 'flexslider':

				$args['animation']        = isset( $atts['animation'] ) ? $atts['animation'] : 'fade';
				$args['easing']           = isset( $atts['easing'] ) ? $atts['easing'] : 'swing';
				$args['direction']        = isset( $atts['direction'] ) ? $atts['direction'] : 'horizontal';
				$args['slideshowspeed']   = isset( $atts['slideshowspeed'] ) ? $atts['slideshowspeed'] : 7000;
				$args['animationspeed']   = isset( $atts['animationspeed'] ) ? $atts['animationspeed'] : 600;
				$args['startat']          = isset( $atts['startat'] ) ? $atts['startat'] : 0;
				$args['initdelay']        = isset( $atts['initdelay'] ) ? $atts['initdelay'] : 0;
				$args['prevtext']         = isset( $atts['prevtext'] ) ? $atts['prevtext'] : '';
				$args['nexttext']         = isset( $atts['nexttext'] ) ? $atts['nexttext'] : '';
				$args['randomize']        = isset( $atts['randomize'] ) ? $atts['randomize'] : false;
				$args['animationloop']    = isset( $atts['animationloop'] ) ? $atts['animationloop'] : true;
				$args['usecss']           = isset( $atts['usecss'] ) ? $atts['usecss'] : true;
				$args['touch']            = isset( $atts['touch'] ) ? $atts['touch'] : true;
				$args['keyboard']         = isset( $atts['keyboard'] ) ? $atts['keyboard'] : true;
				$args['reverse']          = isset( $atts['reverse'] ) ? $atts['reverse'] : false;
				$args['smoothheight']     = isset( $atts['smoothheight'] ) ? $atts['smoothheight'] : false;
				$args['vide']             = isset( $atts['vide'] ) ? $atts['vide'] : false;
				$args['controlnav']       = isset( $atts['controlnav'] ) ? $atts['controlnav'] : true;
				$args['directionnav']     = isset( $atts['directionnav'] ) ? $atts['directionnav'] : true;
				$args['pauseplay']        = isset( $atts['pauseplay'] ) ? $atts['pauseplay'] : false;

				/*
				$args['namespace']    	   = isset( $atts['namespace'] ) ? $atts['namespace'] : "flex-"
				$args['selector']          = isset( $atts['selector'] ) ? $atts['selector'] : ".slides > li"
				$args['animation']         = isset( $atts['animation'] ) ? $atts['animation'] : "fade"
				$args['easing']            = isset( $atts['easing'] ) ? $atts['easing'] : "swing"
				$args['direction']         = isset( $atts['direction'] ) ? $atts['direction'] : "horizontal"
				$args['reverse']           = isset( $atts['reverse'] ) ? $atts['reverse'] : false
				$args['animationLoop']     = isset( $atts['animationLoop'] ) ? $atts['animationLoop'] : true
				$args['smoothHeight']      = isset( $atts['smoothHeight'] ) ? $atts['smoothHeight'] : false
				$args['startAt']           = isset( $atts['startAt'] ) ? $atts['startAt'] : 0
				$args['slideshow']         = isset( $atts['slideshow'] ) ? $atts['slideshow'] : true
				$args['slideshowSpeed']    = isset( $atts['slideshowSpeed'] ) ? $atts['slideshowSpeed'] : 7000
				$args['animationSpeed']    = isset( $atts['animationSpeed'] ) ? $atts['animationSpeed'] : 600
				$args['initDelay']         = isset( $atts['initDelay'] ) ? $atts['initDelay'] : 0
				$args['randomize']         = isset( $atts['randomize'] ) ? $atts['randomize'] : false
				$args['pauseOnAction']     = isset( $atts['pauseOnAction'] ) ? $atts['pauseOnAction'] : true
				$args['pauseOnHover']      = isset( $atts['pauseOnHover'] ) ? $atts['pauseOnHover'] : false
				$args['useCSS']            = isset( $atts['useCSS'] ) ? $atts['useCSS'] : true
				$args['touch']             = isset( $atts['touch'] ) ? $atts['touch'] : true
				$args['video']             = isset( $atts['video'] ) ? $atts['video'] : false
				$args['controlNav']        = isset( $atts['controlNav'] ) ? $atts['controlNav'] : true
				$args['directionNav']      = isset( $atts['directionNav'] ) ? $atts['directionNav'] : true
				$args['prevText']          = isset( $atts['prevText'] ) ? $atts['prevText'] : "Previous"
				$args['nextText']          = isset( $atts['nextText'] ) ? $atts['nextText'] : "Next"
				$args['keyboard']          = isset( $atts['keyboard'] ) ? $atts['keyboard'] : true
				$args['multipleKeyboard '] = isset( $atts['multipleKeyboard '] ) ? $atts['multipleKeyboard '] : false
				$args['mousewheel']        = isset( $atts['mousewheel'] ) ? $atts['mousewheel'] : false
				$args['pausePlay']         = isset( $atts['pausePlay'] ) ? $atts['pausePlay'] : false
				$args['pauseText']         = isset( $atts['pauseText'] ) ? $atts['pauseText'] : 'Pause'
				$args['playText']          = isset( $atts['playText'] ) ? $atts['playText'] : 'Play'
				$args['controlsContainer'] = isset( $atts['controlsContainer'] ) ? $atts['controlsContainer'] : ""
				$args['manualControls']    = isset( $atts['manualControls'] ) ? $atts['manualControls'] : ""
				$args['sync']              = isset( $atts['sync'] ) ? $atts['sync'] : ""
				$args['asNavFor']          = isset( $atts['asNavFor'] ) ? $atts['asNavFor'] : ""
				$args['itemWidth']         = isset( $atts['itemWidth'] ) ? $atts['itemWidth'] : 0
				$args['itemMargin']        = isset( $atts['itemMargin'] ) ? $atts['itemMargin'] : 0
				$args['minItems']          = isset( $atts['minItems'] ) ? $atts['minItems'] : 0
				$args['maxItems']          = isset( $atts['maxItems'] ) ? $atts['maxItems'] : 0
				$args['move']              = isset( $atts['move'] ) ? $atts['move'] : 0

				*/

				break;

			case 'nivoslider':

				$args['effect']           = isset( $atts['effect'] ) ? $atts['effect'] : 'random';
				$args['slices']           = isset( $atts['slices'] ) ? $atts['slices'] : 8;
				$args['boxcols']          = isset( $atts['boxcols'] ) ? $atts['boxcols'] : 8;
				$args['boxrows']          = isset( $atts['boxrows'] ) ? $atts['boxrows'] : 4;
				$args['animspeed']        = isset( $atts['animspeed'] ) ? $atts['animspeed'] : 800;
				$args['pausetime']        = isset( $atts['pausetime'] ) ? $atts['pausetime'] : 3000;
				$args['startslide']       = isset( $atts['startslide'] ) ? $atts['startslide'] : 0;
				$args['directionnav']     = isset( $atts['directionnav'] ) ? $atts['directionnav'] : true;
				$args['controlnav']       = isset( $atts['controlnav'] ) ? $atts['controlnav'] : true;
				$args['controlnavthumbs'] = isset( $atts['controlnavthumbs'] ) ? $atts['controlnavthumbs'] : false;
				$args['pauseonhover']     = isset( $atts['pauseonhover'] ) ? $atts['pauseonhover'] : false;
				$args['manualadvance']    = isset( $atts['manualadvance'] ) ? $atts['manualadvance'] : false;
				$args['prevtext']         = isset( $atts['prevtext'] ) ? $atts['prevtext'] : '';
				$args['nexttext']         = isset( $atts['nexttext'] ) ? $atts['nexttext'] : '';
				$args['randomstart']      = isset( $atts['randomstart'] ) ? $atts['randomstart'] : false;

				/*
				functions attributtes

				$args['beforeChange']     = isset( $args['beforeChange'] ) ? $args['beforeChange'] : function(){};
				$args['afterChange']      = isset( $args['afterChange'] ) ? $args['afterChange'] : function(){};
				$args['slideshowEnd']     = isset( $args['slideshowEnd'] ) ? $args['slideshowEnd'] : function(){};
				$args['lastSlide']        = isset( $args['lastSlide'] ) ? $args['lastSlide'] : function(){};
				$args['afterLoad']        = isset( $args['afterLoad'] ) ? $args['afterLoad'] : function(){};

				efffects
					sliceDown
					sliceDownLeft
					sliceUp
					sliceUpLeft
					sliceUpDown
					sliceUpDownLeft
					fold
					fade
					random
					slideInRight
					slideInLeft
					boxRandom
					boxRain
					boxRainReverse
					boxRainGrow
					boxRainGrowReverse
				*/

				break;
		}

		$DWH_wponetheme_slider->util_object = array_merge( $DWH_wponetheme_slider->util_object, array( $sliderobject => $args ) );
		$DWH_wponetheme_slider->counter = $DWH_wponetheme_slider->counter + 1;

		$filePath = dirname( __FILE__ ).'/views/'.$slider.'-view.php';
		$viewData = array( 'atts' => $args, 'slider_items' => dwh_get_slider_items( $args ) );

		wp_enqueue_script( 'dwh-'.$slider );

		$html = $DWH_wponetheme_slider->render( $filePath, $viewData );

		if ( $return ) return $html;
		echo $html;
	}
}

if ( !function_exists( 'dwh_get_slider_items' ) )
{
	function dwh_get_slider_items( $atts )
	{
		global $post;
		global $DWH_wponetheme_slider;

		extract( $atts );
		$slider_items = array();

		switch ( $datasrc ) {
			case 'media':

				$post_thumbnail_id = ( has_post_thumbnail() ) ? get_post_thumbnail_id() : false;
				$slider_item_ids = isset( $atts['ids'] ) ? $atts['ids'] : $post_thumbnail_id;

				if ( $slider_item_ids ) {
					$slider_item_ids = explode( ',', $slider_item_ids);

					foreach ( $slider_item_ids as $key => $slider_item_id ) {
						$attachment = get_post( $slider_item_id );

						if ( $attachment ) {
							$title = preg_replace( array('/-/', '/_/', '/\d/'), array(' ', ' ', ''), get_the_title( $slider_item_id ) );
							$content = dwh_empty( $attachment->post_content ) ? $attachment->post_content : null;
							$excerpt = dwh_empty( $attachment->post_excerpt ) ? $attachment->post_excerpt : $content;

							$slider_items[$key]['slider_id']			  = $slider_item_id;
							$slider_items[$key]['image']				  = wp_get_attachment_image_src( $slider_item_id, $imagesize );
							$slider_items[$key]['img_src'] 				  = wp_get_attachment_image_url( $slider_item_id, $imagesize );
							$slider_items[$key]['img_modal_src'] 		  = wp_get_attachment_image_url( $slider_item_id, $modalsize );
							$slider_items[$key]['img_thumbnail_src'] 	  = wp_get_attachment_image_url( $slider_item_id, $thumbnailsize );
							$slider_items[$key]['img_srcset'] 			  = wp_get_attachment_image_srcset( $slider_item_id, 'full' );
							$slider_items[$key]['slider_caption']		  = $excerpt;
							$slider_items[$key]['slider_description']	  = $content;
							$slider_items[$key]['slider_title']			  = dwh_empty( get_post_meta( $slider_item_id, '_wp_attachment_image_title', true ) ) ? get_post_meta( $slider_item_id, '_wp_attachment_image_title', true) : $title;
							$slider_items[$key]['slider_alt']			  = dwh_empty( get_post_meta( $slider_item_id, '_wp_attachment_image_alt', true ) ) ? get_post_meta( $slider_item_id, '_wp_attachment_image_alt', true) : $title;
							$slider_items[$key]['slider_link']			  = dwh_empty( get_post_meta( $slider_item_id, 'attachment_image_link', true ) ) ? get_post_meta( $slider_item_id, 'attachment_image_link', true) : '';
							$slider_items[$key]['slider_class']			  = dwh_empty( get_post_meta( $slider_item_id, 'attachment_image_class', true ) ) ? get_post_meta( $slider_item_id, 'attachment_image_class', true) : null;
							$slider_items[$key]['slider_expire']		  = dwh_empty( get_post_meta( $slider_item_id, 'dwh_image_expire_date', true ) ) ? get_post_meta( $slider_item_id, 'dwh_image_expire_date', true) : null;
							$slider_items[$key]['slider_output_type']     = 'slider';
							$slider_items[$key]['slider_rel']             = null;
							$slider_items[$key]['slider_overlay_content'] = null;

							/* change value of lad data */
							$slider_colorbox = dwh_empty( get_post_meta( $slider_item_id, 'dwh_image_colorbox', true ) ) ? get_post_meta( $slider_item_id, 'dwh_image_colorbox', true) : 'none';
							switch ( $slider_colorbox ) {
								case 'none':
									$slider_items[$key]['slider_colorbox'] = 'none';
									break;
								case 'default':
									$slider_items[$key]['slider_colorbox'] = 'colorbox';
									break;
								case 'inline':
									$slider_items[$key]['slider_colorbox'] = 'colorbox-inline';
								break;
							}

						}
					}
				}

				break;

			case 'posts':

				break;

			case 'slider-item':

				$slider_item_fields = dwh_empty( dwh_get_data( 'slider-item' ) ) ? dwh_get_data( 'slider-item' ) : false;

				if ( $slider_item_fields ) {

					foreach ( $slider_item_fields as $key => $slider_item_fields ) {
						$slider_item_id = isset( $slider_item_fields['slider_id'] ) ? $slider_item_fields['slider_id'] : false;
						$slider_item_id = ( $slider_item_fields['slider_output_type'] == 'map' || $slider_item_fields['slider_output_type'] == 'iframe' ) ? dwh_get_data( 'logo', 'onetheme_customizer_options' ) : $slider_item_id;

						foreach ( $slider_item_fields as $field_key => $field_value ) {
							$slider_items[$key][$field_key] = $field_value;
						}

						if ( $slider_item_id ) {

							$attachment = get_post( $slider_item_id );

							if ( $attachment ) {

								$slider_items[$key]['image']				= wp_get_attachment_image_src( $slider_item_id, $imagesize );
								$slider_items[$key]['img_src'] 				= wp_get_attachment_image_url( $slider_item_id, $imagesize );
								$slider_items[$key]['img_modal_src'] 		= wp_get_attachment_image_url( $slider_item_id, $modalsize );
								$slider_items[$key]['img_thumbnail_src'] 	= wp_get_attachment_image_url( $slider_item_id, $thumbnailsize );
								$slider_items[$key]['img_srcset'] 			= wp_get_attachment_image_srcset( $slider_item_id, 'full' );

							}
						}
					}

				}

				break;
		}


		return $slider_items;

	}
}

if ( !function_exists( 'dwh_localize_slider_shortcode_scripts' ) )
{
	add_action( 'wp_footer', 'dwh_localize_slider_shortcode_scripts' );
	function dwh_localize_slider_shortcode_scripts()
	{
		global $DWH_wponetheme_slider;

		$shortcode_localize_scripts = $DWH_wponetheme_slider->util_object;
		$objects = array();

		/* remove duplicate object */
		foreach ( $shortcode_localize_scripts as $object_name => $atts ) {
			array_push( $objects, $atts );
		}

		$slider_objects = array( 'objects' => $objects );
		wp_localize_script( 'global', 'slider_objects', $slider_objects );

	}
}