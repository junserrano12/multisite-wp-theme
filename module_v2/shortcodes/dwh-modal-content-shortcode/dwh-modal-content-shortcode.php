<?php
if ( !function_exists( 'dwh_modal_content_shortcode' ) )
{
	function dwh_modal_content_shortcode( $atts, $content = null )
	{
		global $DWH_plugin_util;
		$filePath			= plugin_dir_path( __FILE__ ).'/views/dwh-modal-content-view.php';
		$atts['content'] 	= dwh_plugin_modify_the_content( $DWH_plugin_util->load_shortcode_content( $content ) );
		$viewData			= array( 'atts' => $atts );

		ob_start();
		$DWH_plugin_util->render( $filePath, $viewData, false );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}