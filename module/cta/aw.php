<?php 
	/*extract $data*/
	extract($data);

	/*view cta set*/
	if( isset($cta['views']['cta_set']) ){
		$data['dir'] 	= array('module/cta/aw');
		$data['view'] 	= $cta['views']['cta_set'];
		load_view( $data );
	}
?>