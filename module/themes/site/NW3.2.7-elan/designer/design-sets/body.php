<?php

/* Body*/
return array(

				'details' => array(
											'title' => 'Body',
											'description' => 'Body Customization',
											'category' => 'body'
									),
				'sections' => array(

									array(

											'selector' => 'body',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'body-con-bg-color',
																								'field_title' 		=> 'Body background',
																								'field_description' => 'This will change Body background color',
																								'required'          => 0,
																								'class'             => 'half-width',
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'body-con-font-color',
																								'field_title' 		=> 'Body font color',
																								'field_description' => 'This will change body font color',
																								'required'          => 0,
																								'class'             => 'half-width',
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )


								) 
		


		);



?>