<?php

/* CTA*/
return array(

				'details' => array(
											'title' => 'CTA',
											'description' => 'CTA Customization',
											'category' => 'cta'
									),
				'sections' => array(

									array(

											'selector' => '.cta-container',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'cta-con-bg-color',
																								'field_title' 		=> 'CTA Container background',
																								'field_description' => 'This will change CTA background color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'cta-con-font-color',
																								'field_title' 		=> 'CTA font color',
																								'field_description' => 'This will change cta font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )


								) 
		


		);



?>