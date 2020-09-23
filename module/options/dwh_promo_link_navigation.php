<?php 

return array( 

				'details' => array(
										'title' => 'Promo Link Navigation',
										'description' => 'AW Promo Link Navigation',
										'category' => 'Promo',
										'multiple' => 0,
										'block_list' => array( 'editor' )
								),
				'settings' => array(

										'promo_post_ids'  => array(

																'properties' => array(
																						'control_type'	 	=> 'hidden',
																						'field_title' 		=> 'Promo Pages',
																						'field_description' => 'Select AW promo pages to be shown on frontend.',
																						'required'          => 0
																					
																					  )

															),
										'promo_label_single'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Single Promo Menu Label',
																						'field_description' => 'Customize your menu label for single promo page.',
																						'required'          => 0
																					
																					  )

															),
										'promo_label_multiple'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Multiple Promo Menu Label',
																						'field_description' => 'Customize your menu label for multiple promo pages.',
																						'required'          => 0
																					
																					  )

															)

								   )	



			);

?>