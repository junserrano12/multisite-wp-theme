<?php 
	/*extract $data*/
	extract($data);

	/*view cta type*/
	if( isset($cta['views']['cta_type']) ){
		$data['dir'] 	= array('module/cta/promo');
		$data['view'] 	= $cta['views']['cta_type'];
		load_view( $data );
	}
?>