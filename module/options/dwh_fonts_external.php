<?php 

return array( 

				'details' => array(
										'title' => 'External Fonts',
										'description' => 'Integrate google fonts into your CSS',
										'category' => 'Fonts',
										'multiple' => 1,
										'block_list' => array( 'editor' )
								),
				'settings' => array(

										'name'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Name of font',
																						'field_description' => "Font name to be added to your CSS styles. For example: <b>font-family: 'Pacifico', cursive</b>;",
																						'required'          => 1
																					
																					  )

															),
										'tag'  => array(

																'properties' => array(
																						'control_type'	 	=> 'tag',
																						'field_title' 		=> 'Font External tag',
																						'field_description' => '',
																						'required'          => 1
																					
																					  )

															)


								   )	

			);

?>