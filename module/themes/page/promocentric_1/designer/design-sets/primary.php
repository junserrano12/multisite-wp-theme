<?php

/* Primary */
return array(

				'details' => array(
											'title' => 'Primary',
											'description' => 'Primary Customization',
											'category' => 'main'
									),
				'sections' => array(

									array(

											'selector' => '#primary',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'primary-main-con-bg-color',
																								'field_title' 		=> 'Primary Main Container background',
																								'field_description' => 'This will change Primary background color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'primary-main-con-font-color',
																								'field_title' 		=> 'Primary Main font color',
																								'field_description' => 'This will change Primary font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )
								) 
		


		);



?>