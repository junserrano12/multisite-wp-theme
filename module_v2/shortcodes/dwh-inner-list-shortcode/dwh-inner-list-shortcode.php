<?php
if ( !function_exists( 'dwh_inner_list_shortcode' ) )
{
	function dwh_inner_list_shortcode( $atts, $content = null )
	{
		global $DWH_inner_list;

		extract( dwh_inner_list_atts( $atts ) );

		$DWH_inner_list->util_object 		= array_merge( $DWH_inner_list->util_object, array( $object => dwh_inner_list_atts( $atts ) ) );
		$DWH_inner_list->counter 			= $DWH_inner_list->counter + 1;

		$filePath 	= plugin_dir_path( __FILE__ ).'/views/inner-list-view.php';
		$viewData 	= array( 'atts' => $atts, 'list_atts' => dwh_inner_list_atts( $atts ), 'content' => $DWH_inner_list->load_shortcode_content( $content ) );

		ob_start();
		$DWH_inner_list->render( $filePath, $viewData, false );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}

if ( !function_exists( 'dwh_inner_list_atts' ) )
{
	function dwh_inner_list_atts( $atts )
	{
		global $DWH_inner_list;

		$id 	 			= isset( $atts['id'] ) ? $atts['id'] : 'dwh_inner_list_'.$DWH_inner_list->counter;
		$class 				= isset( $atts['class'] ) ? $atts['class'].' dwh-list-wrapper dwh-' : 'dwh-list-wrapper dwh-';
		$selector 			= isset( $atts['selector'] ) ? $atts['selector'] : '#'.$id;
		/*option: default, list, lists, accordions, grid*/
		$desktoplayout 		= isset( $atts['desktop'] ) ? $atts['desktop'] : 'default';
		$mobilelayout 		= isset( $atts['mobile'] ) ? $atts['mobile'] : 'dropdown';
		$tabletlayout 		= isset( $atts['tablet'] ) ? $atts['tablet'] : $mobilelayout;
		/*option: default, all, signle*/
		$accordiontoggle	= isset( $atts['accordiontoggle'] ) ? $atts['accordiontoggle'] : 'default';
		/*option: default, slide, fade*/
		$accordioneffect 	= isset( $atts['accordioneffect'] ) ? $atts['accordioneffect'] : 'slide';
		/*option: default, all, none*/
		$accordiondisplay 	= isset( $atts['accordiondisplay'] ) ? $atts['accordiondisplay'] : 'default';
		$object				= 'dwh_'.str_replace( array( '.', '#', '-' ), array( '_class_', '_id_', '_'), $selector );


		return array(
					'id' 				=> $id,
					'class' 			=> $class,
					'selector' 			=> $selector,
					'desktoplayout' 	=> $desktoplayout,
					'mobilelayout'		=> $mobilelayout,
					'tabletlayout'		=> $tabletlayout,
					'accordiontoggle' 	=> $accordiontoggle,
					'accordioneffect' 	=> $accordioneffect,
					'accordiondisplay' 	=> $accordiondisplay,
					'object' 			=> $object,
					'counter' 			=> $DWH_inner_list->counter
				);
	}
}