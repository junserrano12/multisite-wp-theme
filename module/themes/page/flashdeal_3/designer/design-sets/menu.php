<?php

/* Menu */
return array(

				'details' => array(
											'title' => 'Menu',
											'description' => 'Menu Customization',
											'category' => 'menu'
									),
				'sections' => array(

									array(

											'selector' => '#menu-primary-menu',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'menu-con-bg-color',
																								'field_title' 		=> 'Menu Container background',
																								'field_description' => 'This will change Menu background color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'menu-con-font-color',
																								'field_title' 		=> 'Menu font color',
																								'field_description' => 'This will change menu font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )


								) 
		


		);



?>