<?php

/* Menu Item */
return array(

				'details' => array(
											'title' => 'Menu Item',
											'description' => 'Menu Item Customization',
											'category' => 'menu'
									),
				'sections' => array(

									array(
											'selector' => '#main-menu li a',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'menu-item-con-bg-color',
																								'field_title' 		=> 'Menu Container background',
																								'field_description' => 'This will change Menu Item background color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'menu-item-con-font-color',
																								'field_title' 		=> 'Menu font color',
																								'field_description' => 'This will change Menu Item font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )


								) 
		


		);



?>