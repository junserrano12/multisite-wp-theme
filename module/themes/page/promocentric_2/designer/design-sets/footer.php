<?php

/* Footer */
return array(

				'details' => array(
											'title' => 'Footer',
											'description' => 'Footer Customization',
											'category' => 'footer'
									),
				'sections' => array(

									array(

											'selector' => '#footer',
											'attributes'  => array(
															   'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'footer-con-bg-color',
																								'field_title' 		=> 'Footer background',
																								'field_description' => 'This will change Footer background color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   	'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'footer-con-font-color',
																								'field_title' 		=> 'Footer font color',
																								'field_description' => 'This will change Footer font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )


								) 
		


		);
?>