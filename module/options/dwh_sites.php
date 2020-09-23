<?php

return array( 

				'details' => array(
											'title' => 'Site Settings',
											'description' => 'Site configurations',
											'category' => 'Site Settings',
											'multiple' => 0
									),
				'settings' => array(

											'site_theme'  => array(

																	'properties' => array(
																							'control_type'	 	=> 'relation',
																							'field_title' 		=> 'Site Theme',
																							'field_description' => 'What is your site theme',
																							'required'          => 1,
																							'class'             => 'full-width'
																						  )

																),
											'corpsite_flag'  => array(

																'properties' => array(
																						'control_type'	 	=> 'select',
																						'field_title' 		=> 'Corp site?',
																						'field_description' => 'If the hotel is a corp site',
																						'required'          => 0,
																						'block_list' 		=> array( 'editor' )
																						
																					  )

															),
											'cdn_flag'  => array(

																'properties' => array(
																						'control_type'	 	=> 'select',
																						'field_title' 		=> 'Disable CDN',
																						'field_description' => 'Select Yes to Disable CDN',
																						'required'          => 1,
																						'block_list' 		=> array( 'editor' )																						
																					  )
															),
											'logo_id'  => array(

																'properties' => array(

																						'control_type'	 	=> 'image',
																						'field_title' 		=> 'Logo ID',
																						'field_description' => 'Upload or insert image from media library.',
																						'required'          => 0,
																						'class'             => 'narrow-width'

																					
																					  )

															),
											'favicon_id'  => array(

																	'properties' => array(

																							'control_type'	 	=> 'image',
																							'field_title' 		=> 'Favicon ID',
																							'field_description' => 'Upload or insert image from media library. Favicon will automatically be generated from logo image if no image uploaded here.',
																							'required'          => 0,
																							'class'             => 'narrow-width'

																						
																						  )

																),
											'banner_id'  => array(

																	'properties' => array(

																							'control_type'	 	=> 'image',
																							'field_title' 		=> 'Banner ID',
																							'field_description' => 'Upload or insert image from media library.',
																							'required'          => 0,
																							'class'             => 'narrow-width'
	
																						
																						  )

																),
											'site_css'  => array(

																	'properties' => array(

																							'control_type'	 	=> 'textarea',
																							'field_title' 		=> 'Custom CSS',
																							'field_description' => 'Site level: Add your custom css rules here.',
																							'required'          => 0,
																							'class'             => 'full-width',
																							'block_list' 		=> array( 'editor' )	

																						
																						  )

																),
											'site_mediaquery'  => array(

																	'properties' => array(

																							'control_type'	 	=> 'textarea',
																							'field_title' 		=> 'Custom Media Query',
																							'field_description' => 'Site level: Add your custom media query rules here.',
																							'required'          => 0,
																							'class'             => 'full-width',
																							'block_list' 		=> array( 'editor' )

																						
																						  )

																)

								)

		);

?>
