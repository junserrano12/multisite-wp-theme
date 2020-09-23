<?php 
	/* 
		CTA Set B
		Default		
	*/
	
	extract($data);
	$data['dir'] 	= array('module/cta/parts');
	
	/*CTA TITLE*/
	$data['view'] 	= 'cta_title';
	load_view( $data );

	/*CTA BUTTON*/
	$data['view'] 	= 'cta_button';
	load_view( $data );

	/*CTA MOC*/
	$data['view'] 	= 'cta_modify_cancel';
	load_view( $data );

	/*INCLUSIONS*/
	$data['view'] 	= 'cta_inclusions';
	load_view( $data );
?>
