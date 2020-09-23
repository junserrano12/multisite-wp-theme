<?php


return array( 

				'details' => array(
										'title' => 'Hotel Information',
										'description' => 'Hotel Information',
										'category' => 'Hotel Information',
										'multiple' => 1

									),
				'settings' => array(


										'hotel_id'  => array(

																'properties' => array(
																					'control_type'	 	=> 'text',
																					'field_title' 		=> 'Hotel ID',
																					'field_description' => 'Hotel ID should be unique.',
																					'required'          => 1
																				  ),

															),
										'hotel_name'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Hotel Name',
																						'field_description' => 'Whats your hotel name',
																						'required'          => 1
																						
																					  )

															),
										'hotel_location'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Location',
																						'field_description' => 'Whats your hotel description',
																						'required'          => 1
																						
																					  )

															),
										'hotel_domain'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Hotel Domain',
																						'field_description' => 'URL: Provide hotel domain here',
																						'required'          => 1
																						
																					  )

															),
										'main_flag'  => array(

																'properties' => array(
																						'control_type'	 	=> 'select',
																						'field_title' 		=> 'Main Hotel?',
																						'field_description' => 'Main Hotel',
																						'required'          => 0
																						
																					  )

															)

									)

	 );

?>

