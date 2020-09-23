<?php 

return array( 

			'details' => array(
									'title' => 'Hotel Contact Information',
									'description' => 'Hotel contact details',
									'category' => 'Hotel Information',
									'multiple' => 0


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
									'country_code'  => array(

															'properties' => array(
																					'control_type'	 	=> 'text',
																					'field_title' 		=> 'Country Code',
																					'field_description' => '',
																					'required'          => 0
																				
																				  )

														),
									'area_code'  => array(

															'properties' => array(
																					'control_type'	 	=> 'text',
																					'field_title' 		=> 'Area Code',
																					'field_description' => '',
																					'required'          => 0
																				
																				  )

														),
									'telephone'  => array(

															'properties' => array(
																					'control_type'	 	=> 'text',
																					'field_title' 		=> 'Telephone',
																					'field_description' => '',
																					'required'          => 1
																					
																				  )

														),
									'email'  => array(

															'properties' => array(
																					'control_type'	 	=> 'email',
																					'field_title' 		=> 'Email Address',
																					'field_description' => '',
																					'required'          => 0
																				
																				  )

														)

							   )

			


		);

?>