<?php

/* Header */
return array(

				'details' => array(
											'title' => 'Header Content',
											'description' => 'Header Content Customization',
											'category' => 'header'
									),
				'sections' => array(

									array(

											'selector' => '#header .content',
											'attributes'  => array(

																'background-color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'header-con-bg-color',
																								'field_title' 		=> 'Header Container background',
																								'field_description' => 'This will change Header background color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																),
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'header-con-font-color',
																								'field_title' 		=> 'Header font color',
																								'field_description' => 'This will change header font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )


								) 
		


		);



?>