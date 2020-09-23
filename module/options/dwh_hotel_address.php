<?php

return array( 



			'details' => array(
										'title' => 'Hotel Addresses',
										'description' => 'Address details',
										'category' => 'Hotel Information',
										'multiple' => 1

								),
			'settings' => array(
										'dwh_hotels_id'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Hotel ID',
																						'field_description' => '',
																						'required'          => 1
																					
																					  )

															),
										'street_1'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Street 1',
																						'field_description' => '',
																						'required'          => 0
																					
																					  )
																
															),
										'street_2'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Street 2',
																						'field_description' => '',
																						'required'          => 0
																					
																					  )

															),
										'city_town'  	=> array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'City/Town',
																						'field_description' => '',
																						'required'          => 0
																					
																					  )

															),
										'state_region'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'State',
																						'field_description' => '',
																						'required'          => 0
																					
																					  )

															),
										'country'  	=> array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Country',
																						'field_description' => '',
																						'required'          => 0
																					
																					  )

															),
										'zip_code'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Zip Code / Postal Code',
																						'field_description' => '',
																						'required'          => 0
																					
																					  )

															)

								)


			

		);


?>