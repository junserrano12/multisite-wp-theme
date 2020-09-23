<?php 
	/* 
		CTA Set A 
		Best Price Guarantee
		Non-Calendar
	*/

	extract($data);
	$data['dir'] 	= array('module/cta/parts');

	/*BPG TITLE*/
	$data['view'] 	= 'cta_title';
	load_view( $data );

	/*IF CORPSITE*/
	if(isset($cta['views']['cta_hotel_branches'])){
		$data['view'] 	= $cta['views']['cta_hotel_branches'];
		load_view( $data );	
	}

	/*CTA BUTTON*/
	$data['view'] 	= 'cta_button';
	load_view( $data );

	/*CTA MOC*/
	$data['view'] 	= 'cta_modify_cancel';
	load_view( $data );

	/*BPG MODAL*/
	$data['view'] 	= 'bpg_modal';
	load_view( $data );
?>