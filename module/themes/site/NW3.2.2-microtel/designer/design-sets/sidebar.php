<?php

/* Sidebar */
return array(

				'details' => array(
											'title' => 'Sidebar',
											'description' => 'Sidebar Customization',
											'category' => 'sidebar'
									),
				'sections' => array(

									array(

											'selector' => '#sidebar',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'sidebar-con-bg-color',
																								'field_title' 		=> 'Sidebar Container background',
																								'field_description' => 'This will change Sidebar background color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'sidebar-con-font-color',
																								'field_title' 		=> 'Sidebar font color',
																								'field_description' => 'This will change Sidebar font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )


								) 
		


		);



?>