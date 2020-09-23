<?php 
	/* 
		CTA Set A 
		Best Price Guarantee
	*/

	extract($data);
	$data['dir'] 	= array('module/cta/parts');

	/*CTA BUTTON*/
	$data['view'] 	= 'cta_button';
	load_view( $data );

	/*BPG OPEN*/
	$data['view'] 	= 'bpg_tag_open';
	load_view( $data );

	/*BPG TITLE*/
	$data['view'] 	= 'cta_title';
	load_view( $data );

	/*INCLUSIONS*/
	$data['view'] 	= 'cta_inclusions';
	load_view( $data );

	/*BPG CLOSE*/
	$data['view'] 	= 'bpg_tag_close';
	load_view( $data );

	/*CTA MOC*/
	$data['view'] 	= 'cta_modify_cancel';
	load_view( $data );

	/*BPG MODAL*/
	$data['view'] 	= 'bpg_modal';
	load_view( $data );
?>