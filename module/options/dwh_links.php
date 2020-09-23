<?php 

return array( 

				'details' => array(
										'title' => 'Links',
										'description' => 'URL collections',
										'category' => 'links',
										'multiple' => 1,
										'block_list' => array( 'editor' )
								),
				'settings' => array(

										'category'  => array(

																'properties' => array(
																						'control_type'	 	=> 'select',
																						'field_title' 		=> 'Category',
																						'field_description' => '',
																						'required'          => 1
																					
																					  )

															),
										'name'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Name of link',
																						'field_description' => '',
																						'required'          => 1
																					
																					  )

															),
										'url'  => array(

																'properties' => array(
																						'control_type'	 	=> 'url',
																						'field_title' 		=> 'URL',
																						'field_description' => '',
																						'required'          => 1
																					
																					  )

															),
										'icon'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Icon',
																						'field_description' => '',
																						'required'          => 1
																					
																					  )

															)
										


								   )	



			);

?>