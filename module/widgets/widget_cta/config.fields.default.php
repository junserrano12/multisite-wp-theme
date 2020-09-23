<?php

return array(

	'AW' =>  array(

			'set_a' 			=> array(

										'name' 			=> 	'Set A' ,
										'description' 	=> 	'This will show the BPG together with the CTA button',
										'screenshot'  	=> 	get_template_directory_uri() . '/module/cta/aw/set_a.png',
										'settings'	    =>  array(

																'cta_set'					=> 'set_a',
																'cta_type'					=> 'aw',
																'cta_title' 				=> 'Best Price Guarantee',
																'cta_label' 				=> 'Check Availability and Prices', 
																'cta_bpg' 					=> 'cta_bpg',
																'cta_calendar'  			=> 'cta_non_calendar',
																'cta_modify_cancel_link'  	=> 'Modify or Cancel',
																'cta_modify_cancel_text' 	=> 'your reservation'

																)
			
									),
			'set_b' 			=> array(

										'name' 			=> 	'Set B' ,
										'description' 	=> 	'This will show the CTA button without the BPG',
										'screenshot'  	=> 	get_template_directory_uri() . '/module/cta/aw/set_b.png',
										'settings'	    =>  array(

																'cta_set'					=> 'set_b',
																'cta_type'					=> 'aw',
																'cta_title' 				=> 'Easy Booking at Low Rates',
																'cta_label' 				=> 'Check Availability and Prices',
																'cta_bpg' 					=> 'cta_non_bpg',
																'cta_calendar'  			=> 'cta_non_calendar',
																'cta_modify_cancel_link'  	=> 'Modify or Cancel',
																'cta_modify_cancel_text' 	=> 'your reservation'

																)
			
									),
			'set_c' 			=> array(

										'name' 			=> 	'Set C' ,
										'description' 	=> 	'This will show the BPG , CTA button and the calendar with optional promocode',
										'screenshot'  	=> 	get_template_directory_uri() . '/module/cta/aw/set_c.png',
										'settings'	    =>  array(

																'cta_set'					=> 'set_c',
																'cta_type'					=> 'aw',
																'cta_title' 				=> 'Best Price Guarantee',
																'cta_label' 				=> 'Check Availability and Prices', 
																'cta_bpg' 					=> 'cta_bpg',
																'cta_calendar' 				=> 'cta_calendar',
																'cta_modify_cancel_link'  	=> 'Modify or Cancel',
																'cta_modify_cancel_text' 	=> 'your reservation',
																'cta_promo_code' 			=> 1

																)
			
									),
			'set_d' 			=> array(

										'name' 			=> 	'Set D' ,
										'description' 	=> 	'This will show the CTA button without the BPG, CTA button and the calendar with optional promocode',
										'screenshot'  	=> 	get_template_directory_uri() . '/module/cta/aw/set_d.png',
										'settings'	    =>  array(

																'cta_set'					=> 'set_d',
																'cta_type'					=> 'aw',
																'cta_title' 				=> 'Easy Booking at Low Rates',
																'cta_label' 				=> 'Check Availability and Prices', 
																'cta_bpg' 					=> 'cta_non_bpg',
																'cta_calendar'  			=> 'cta_calendar',
																'cta_modify_cancel_link'  	=> 'Modify or Cancel',
																'cta_modify_cancel_text' 	=> 'your reservation',
																'cta_promo_code' 			=> 1

																)
			
									)
		),
	'NW' => array(

			'set_a' 			=> array(

										'name' 			=>	'Set A' ,
										'description' 	=> 	'This will show the BPG and CTA button without the calendar',
										'screenshot'  	=> 	get_template_directory_uri() . '/module/cta/nw/set_a.png',
										'settings'	    =>  array(

																'cta_set'					=> 'set_a',
																'cta_type'					=> 'nw',
																'cta_title' 				=> 'Best Price Guarantee',
																'cta_label' 				=> 'Check Availability and Prices', 
																'cta_bpg' 					=> 'cta_bpg',
																'cta_calendar'  			=> 'cta_non_calendar',
																'cta_modify_cancel_link'  	=> 'Modify or Cancel',
																'cta_modify_cancel_text' 	=> 'your reservation'

																)
			
									),
			'set_b' 			=> array(

										'name' 			=> 	'Set B' ,
										'description' 	=> 	'This will show the BPG , CTA button, calendar and optional promocode',
										'screenshot'  	=> 	get_template_directory_uri() . '/module/cta/nw/set_b.png',
										'settings'	    =>  array(

																'cta_set'					=> 'set_b',
																'cta_type'					=> 'nw',
																'cta_title' 				=> 'Best Price Guarantee',
																'cta_label' 				=> 'Check Availability and Prices', 
																'cta_bpg' 					=> 'cta_bpg',
																'cta_calendar' 				=> 'cta_calendar',
																'cta_modify_cancel_link'  	=> 'Modify or Cancel',
																'cta_modify_cancel_text' 	=> 'your reservation',
																'cta_promo_code' 			=> 1

																)
			
									),
			'set_c' 			=> array(

										'name' 			=> 	'Set C' ,
										'description' 	=> 	'This will show the CTA Button only',
										'screenshot'  	=> 	get_template_directory_uri() . '/module/cta/nw/set_c.png',
										'settings'	    =>  array(
			
																'cta_set'					=> 'set_c',
																'cta_type'					=> 'nw',
																'cta_title' 				=> 'Easy Booking at Low Rates',
																'cta_label' 				=> 'Check Availability and Prices', 
																'cta_bpg' 					=> 'cta_non_bpg',
																'cta_calendar'  			=> 'cta_non_calendar',
																'cta_modify_cancel_link'  	=> 'Modify or Cancel',
																'cta_modify_cancel_text' 	=> 'your reservation'

																)
			
									),
			'set_d' 			=> array(

										'name' 			=> 	'Set D' ,
										'description' 	=> 	'This will show the CTA button without the BPG, calendar and optional promocode',
										'screenshot'  	=> 	get_template_directory_uri() . '/module/cta/nw/set_d.png',
										'settings'	    =>  array(

																'cta_set'					=> 'set_d',
																'cta_type'					=> 'nw',
																'cta_title' 				=> 'Easy Booking at Low Rates',
																'cta_label' 				=> 'Check Availability and Prices', 
																'cta_bpg' 					=> 'cta_non_bpg',
																'cta_calendar'  			=> 'cta_calendar',
																'cta_modify_cancel_link'  	=> 'Modify or Cancel',
																'cta_modify_cancel_text' 	=> 'your reservation',
																'cta_promo_code' 			=> 1

																)
			
									)

		)
		
);

?>