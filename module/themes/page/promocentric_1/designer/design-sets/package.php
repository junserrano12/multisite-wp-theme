<?php

/* Package */
return array(

				'details' => array(
											'title' => 'Package Container',
											'description' => 'Package Customization',
											'category' => 'package'
									),
				'sections' => array(

									array(

											'selector' => '.entry-list',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'package-list-con-bg-color',
																								'field_title' 		=> 'Package Container background',
																								'field_description' => 'This will change Package background color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'package-list-con-font-color',
																								'field_title' 		=> 'Package font color',
																								'field_description' => 'This will change Package font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )
								) 
		


		);



?>