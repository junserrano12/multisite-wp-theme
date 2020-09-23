<?php 
	/* 
		CTA Set D 
		Non-BPG
		With Calendar
	*/

	extract($data);
	$data['dir'] 	= array('module/cta/parts');

	/*FORM OPEN TAG*/
	$data['view']	= 'cta_form_open';
	load_view( $data );

	/*CTA TITLE*/
	$data['view'] 	= 'cta_title';
	load_view( $data );

	/*IF CORPSITE*/
	if(isset($cta['views']['cta_hotel_branches'])){
		$data['view'] 	= $cta['views']['cta_hotel_branches'];
		load_view( $data );	
	}

	/*CTA CALENDAR*/
	$data['view'] 	= 'cta_calendar';
	load_view( $data );
	
	/*CTA PROMOCODE*/
	$data['view'] 	= 'cta_promo_code';
	load_view( $data );

	/*CTA BUTTON*/
	$data['view'] 	= 'cta_button';
	load_view( $data );

	/*CTA MOC*/
	$data['view'] 	= 'cta_modify_cancel';
	load_view( $data );

	/*FORM OPEN TAG*/
	$data['view']	= 'cta_form_close';
	load_view( $data );
?>