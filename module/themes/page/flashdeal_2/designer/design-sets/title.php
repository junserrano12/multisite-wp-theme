<?php

/* Title */
return array(

				'details' => array(
											'title' => 'Header Title',
											'description' => 'Body Customization',
											'category' => 'title'
									),
				'sections' => array(

									array(

											'selector' => 'h1, h2, h3',
											'attributes'  => array(
															   'color' => array(

																			'properties' => array(

																								'control_type'	 	=> 'custom',
																								'field_name' 		=> 'title-con-font-color',
																								'field_title' 		=> 'Title font color',
																								'field_description' => 'This will change Title font color',
																								'required'          => 0,
																								'feature' 			=> 'colorpicker'
																								
																							  )


																)


												)


										 )


								) 
		


		);



?>