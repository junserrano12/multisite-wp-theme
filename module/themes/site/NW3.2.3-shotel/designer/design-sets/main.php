<?php

/* Main */
return array(

				'details' => array(
											'title' => 'Main',
											'description' => 'Main Customization',
											'category' => 'main'
									),
				'sections' => array(

									array(

											'selector' => '#main-container',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'main-con-bg-color',
																								'field_title' 		=> 'Main Container background',
																								'field_description' => 'This will change Main background color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'main-con-font-color',
																								'field_title' 		=> 'Main font color',
																								'field_description' => 'This will change Main font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )


								) 
		


		);



?>