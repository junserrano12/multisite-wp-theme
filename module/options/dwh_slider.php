<?php

return array( 

				'details' => array(
											'title' => 'Site Slider',
											'description' => 'Slider Settings',
											'category' => 'Slider Settings',
											'multiple' => 0,
											'block_list' =>  array( 'editor' )
									),
				'settings' => array(

											'slider-name'  => array(

																'properties' => array(
																						'control_type'	 	=> 'relation',
																						'field_title' 		=> 'Slider Name',
																						'field_description' => 'What slider would you like to use on this one.',
																						'required'          => 1,
																						'class'             => 'narrow-width'
																					  )

																),
											'slider-mode'  => array(

																'properties' => array(
																						'control_type'	 	=> 'relation',
																						'field_title' 		=> 'Slider Mode',
																						'field_description' => 'The slider mode',
																						'required'          => 1,
																						'extra_property'    => 'readonly',
																						'class'             => 'narrow-width'
																					  )

																),
											'slider-type'  => array(

																'properties' => array(

																						'control_type'	 	=> 'relation',
																						'field_title' 		=> 'Type of Slider',
																						'field_description' => 'How do you want your slider to be displayed.',
																						'required'          => 1,
																						'class'             => 'narrow-width'

																					
																					  )

															),
											'slider-data'  => array(

																'properties' => array(

																						'control_type'	 	=> 'tag',
																						'field_title' 		=> 'Slider Data',
																						'field_description' => 'Slider Item Data',
																						'required'          => 0,
																						'class'             => 'hide'

																					
																					  )

															)

								)

		);

?>
