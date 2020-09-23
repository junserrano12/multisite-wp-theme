<?php
return array( 
				'details' => array(
										'title' => 'Package Settings',
										'description' => 'Promos and Flashdeal Post settings',
										'category' => 'Page Settings',
										'multiple' => 0,
										'block_list' => array( 'editor' )
								),
				'settings' => array(
										'page_type'  => array(
																'properties' => array(
																						'control_type'	 	=> 'relation',
																						'field_title' 		=> 'Page Type',
																						'field_description' => '',
																						'required'          => 1
																					
																					  )
															),
										'page_theme'  => array(
																'properties' => array(
																						'control_type'	 	=> 'relation',
																						'field_title' 		=> 'Page Theme',
																						'field_description' => '',
																						'required'          => 1
																						
																					  )
															),
										'page_css'  => array(
																	'properties' => array(
																						'control_type'	 	=> 'textarea',
																						'field_title' 		=> 'Custom CSS',
																						'field_description' => 'Page level: Add your custom css rules here.',
																						'required'          => 0
																					
																					  )
																),
										'page_mediaquery'  => array(
																'properties' => array(
																						'control_type'	 	=> 'textarea',
																						'field_title' 		=> 'Custom Media Query',
																						'field_description' => 'Page level: Add your custom media query rules here.',
																						'required'          => 0
																					
																					  )
															)
								)
		
		);
?>