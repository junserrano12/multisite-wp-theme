<?php

/* Menu Item Hover*/
return array(

				'details' => array(
											'title' => 'Menu Item Hover',
											'description' => 'Menu Item Hover Customization',
											'category' => 'menu'
									),
				'sections' => array(

									array(

											'selector' => '#main-menu li a:hover',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'menu-item-hover-con-bg-color',
																								'field_title' 		=> 'Menu Container background',
																								'field_description' => 'This will change Menu Item background color on hover',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'menu-item-hover-con-font-color',
																								'field_title' 		=> 'Menu font color',
																								'field_description' => 'This will change menu item font color on hover',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )


								) 
		


		);



?>