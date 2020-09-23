<?php

return array( 

				'details' => array(
											'title' => 'Robots Text File',
											'description' => 'Robots Text File Settings',
											'category' => 'Robots Text File Settings',
											'multiple' => 1,
											'block_list' =>  array( 'editor' )
									),
				'settings' => array(

											'robots_txt'  => array(

																'properties' => array(
																						'control_type'	 	=> 'textarea',
																						'field_title' 		=> 'Content',
																						'field_description' => 'Insert robots text code. If leave empty, default robots.txt file will be use.',
																						'required'          => 1,
																						'class'             => 'full-width'
																					  )

																),
										'robots_action'  => array(

																'properties' => array(
																						'control_type'	 	=> 'relation',
																						'field_title' 		=> 'Action',
																						'field_description' => 'Append code or replace the default robots text file',
																						'required'          => 1
																					
																					  )

															)

								)

		);

?>
