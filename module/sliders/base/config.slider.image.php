<?php

return array( 

				'details' => array(
											'title' => 'Image Slider',
											'description' => '(Default)',
											'category' => 'slider'
									),
				'settings' => array(

											'slider-item-type'  => array(

																'properties' => array(
																						'control_type'	 	=> 'hidden',
																						'field_title' 		=> 'Slider Type:',
																						'field_description' => 'Slider item type',
																						'required'          => 1,
																						'class'             => 'narrow-width'
																					  )

																),
											'slider-item-id'  => array(

																'properties' => array(
																						'control_type'	 	=> 'image',
																						'field_title' 		=> 'Add Image:',
																						'field_description' => 'Upload or insert image from media library.',
																						'required'          => 1,
																						'class'             => 'hide'
																					  )

																),
											'slider-item-expire'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Image Expire:',
																						'field_description' => 'Add image expiration (d-M-YYYY)',
																						'required'          => 0,
																						'class'             => 'datepicker'
																					  )

																),
											'slider-item-title'  => array(

																'properties' => array(

																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Image Title:',
																						'field_description' => 'Put your image name',
																						'required'          => 0,
																						'class'             => ''
																					  )

															),
											'slider-item-caption'  => array(

																'properties' => array(

																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Image Caption:',
																						'field_description' => 'Image Caption',
																						'required'          => 0,
																						'class'             => ''
																					  )

															),
											'slider-item-class'  => array(

																'properties' => array(

																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Image Class:',
																						'field_description' => 'Image Class',
																						'required'          => 0,
																						'class'             => ''
																					  )

															),
											'slider-item-overlaycontent'  => array(

																'properties' => array(

																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Overlay Content:',
																						'field_description' => 'Put your overlay content here (e.g. shotcodes, html, etc.)',
																						'required'          => 0,
																						'class'             => ''
																					  )

															),
											'slider-item-url'  => array(

																'properties' => array(

																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Custom URL:',
																						'field_description' => 'Put your image url',
																						'required'          => 0,
																						'class'             => ''
																					  )

															),
											'slider-item-description'  => array(

																'properties' => array(

																						'control_type'	 	=> 'textarea',
																						'field_title' 		=> 'Image Description :<br><br>',
																						'field_description' => 'Put all your html contents here',
																						'required'          => 0,
																						'class'             => '',
																						'id'             => 'image_desc_editor_'
																					  )

															),
											'slider-item-rel'  => array(

																'properties' => array(

																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Image Rel:',
																						'field_description' => 'Put your group name here',
																						'required'          => 0,
																						'class'             => ''
																					  )

															),
											'slider-item-popup'  => array(

																'properties' => array(

																						'control_type'	 	=> 'hidden',
																						'field_title' 		=> 'Overlay Content:',
																						'field_description' => 'Put your overlay content here (e.g. shotcodes, html, etc.)',
																						'required'          => 0,
																						'class'             => ''
																					  ),
																					  
																'selections' => array(
																					
																						array( 
																							'control_type'	 	=> 'radio',
																							'field_name' 		=> 'item-popup-',
																							'field_title' 		=> 'Default',
																							'field_value' 		=> 'default',
																							'field_description' => 'Disable image popup',
																							'required'          => 0,
																							'class'             => 'with-radio'
																						
																						),
																						
																						array( 
																							'control_type'	 	=> 'radio',
																							'field_name' 		=> 'item-popup-',
																							'field_title' 		=> 'Popup',
																							'field_value' 		=> 'popup',
																							'field_description' => 'Enable image popup',
																							'required'          => 0,
																							'class'             => 'with-radio'
																						
																						),
																						
																						array( 
																							'control_type'	 	=> 'radio',
																							'field_name' 		=> 'item-popup-',
																							'field_title' 		=> 'Popup with content',
																							'field_value' 		=> 'popupwithcontent',
																							'field_description' => 'Enable image popup with content',
																							'required'          => 0,
																							'class'             => 'with-radio'
																						
																						)
																					
																					)

															)

								)

		);

?>
