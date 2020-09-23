
<?php

/* Menu Item Active*/
return array(

				'details' => array(
											'title' => 'Menu Item Active',
											'description' => 'Menu Item Active Customization',
											'category' => 'menu'
									),
				'sections' => array(

									array(

											'selector' => '#main-menu li.current-menu-item a',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'menu-item-active-con-bg-color',
																								'field_title' 		=> 'Menu Container background',
																								'field_description' => 'This will change Active Menu Item background color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'menu-item-active-con-font-color',
																								'field_title' 		=> 'Menu font color',
																								'field_description' => 'This will change active menu item font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )


								)
		


		);



?>