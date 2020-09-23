<?php

	function dwh_accordion( $atts = NULL, $content = NULL ){

		$data['atts'] = $atts;
		$data['content'] = $content;
		$data['dir'] = array('module/shortcodes/static', __FUNCTION__ , 'views');
		$data['view'] = __FUNCTION__;

		ob_start();
		_process_custom_content( load_view( $data ) );
		$html = ob_get_contents();
		ob_end_clean();
		
		return $html;

	}
?>