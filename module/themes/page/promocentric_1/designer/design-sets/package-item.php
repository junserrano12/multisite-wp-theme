<?php

/* Package */
return array(

				'details' => array(
											'title' => 'Package List Item ',
											'description' => 'Package List Items Customization',
											'category' => 'package'
									),
				'sections' => array(

									array(

											'selector' => '.row-item',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'package-list-item-con-bg-color',
																								'field_title' 		=> 'Package Item Container background',
																								'field_description' => 'This will change Package List Item background color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
																'border-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'package-list-item-con-border-color',
																								'field_title' 		=> 'Package List Item Boder Color',
																								'field_description' => 'This will change Package List Item Border color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'package-list-item-con-font-color',
																								'field_title' 		=> 'Package List Item font color',
																								'field_description' => 'This will change Package List Item font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )
								) 
		


		);



?>