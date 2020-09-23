<?php
if ( !function_exists( 'dwh_list_shortcode' ) )
{
	function dwh_list_shortcode( $atts, $content = null )
	{

		ob_start();
		dwh_list( $atts, $content );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}

if ( !function_exists( 'dwh_list' ) )
{
	function dwh_list( $atts, $content, $return = false )
	{
		global $DWH_wponetheme_list;

		$device = dwh_detect_device();

		/*option: default, list, lists, accordions, grid*/
		if ( $device->mobile ) {
			$layout = isset( $atts['mobile'] ) ? $atts['mobile'] : 'dropdown';
		} else if ( $device->tablet ) {
			$layout = isset( $atts['tablet'] ) ? $atts['tablet'] : 'dropdown';
		} else {
			$layout = isset( $atts['desktop'] ) ? $atts['desktop'] : 'list';
		}

		$id                  = isset( $atts['id'] ) ? $atts['id'] : 'dwh-list-'.$DWH_wponetheme_list->counter;
		$class               = isset( $atts['class'] ) ? $atts['class'].' dwh-list-wrapper dwh-'.$layout.'-wrapper' : 'dwh-list-wrapper dwh-'.$layout.'-wrapper';
		$defaultselector     = isset( $atts['id'] ) ? '#'.$atts['id'] : '#'.$id ;
		$selector            = isset( $atts['selector'] ) ? $atts['selector'] : $defaultselector;
		$selectorrd          = str_replace( array( '.', '#', '-'), array( '_class_', '_id_', '_' ), $selector );
		$listobject          = 'dwh_'.$selectorrd;

		$args['id']               = $id;
		$args['class']            = $class;
		$args['selector']         = $selector;
		$args['layout']           = $layout;
		/*option: default, all, signle*/
		$args['accordiontoggle']  = isset( $atts['accordiontoggle'] ) ? $atts['accordiontoggle'] : 'default';
		/*option: default, slide, fade*/
		$args['accordioneffect']  = isset( $atts['accordioneffect'] ) ? $atts['accordioneffect'] : 'slide';
		/*option: default, all, none*/
		$args['accordiondisplay'] = isset( $atts['accordiondisplay'] ) ? $atts['accordiondisplay'] : 'default';

		$DWH_wponetheme_list->util_object = array_merge( $DWH_wponetheme_list->util_object, array( $listobject => $args ) );
		$DWH_wponetheme_list->counter     = $DWH_wponetheme_list->counter + 1;

		$filePath	= dirname( __FILE__ ).'/views/'.$layout.'-view.php';
		$viewData 	= array( 'atts' => $args, 'content' => $content );

		wp_enqueue_script( 'dwh-list-script' );

		$html = $DWH_wponetheme_list->render( $filePath, $viewData );

		if ( $return ) return $html;
		echo $html;
	}
}