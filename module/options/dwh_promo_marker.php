<?php 

return array( 

				'details' => array(
										'title' => 'Promo Markers',
										'description' => 'markers that can be used as content overlays like promo discounts...',
										'category' => 'Markers',
										'multiple' => 1
										
								),
				'settings' => array(	

										
										'promo_marker_id'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Promo marker ID',
																						'field_description' => 'System generated Unique ID to be used for shortcode rendering.',
																						'required'          => 1
																					
																					  )

															),
										'text'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Text',
																						'field_description' => '',
																						'required'          => 1
																					
																					  )

															),
										'background_image'  => array(

																'properties' => array(
																						'control_type'	 	=> 'image',
																						'field_title' 		=> 'Image',
																						'field_description' => '',
																						'required'          => 0
																					
																					  )

															)


								   )	



			);

?>