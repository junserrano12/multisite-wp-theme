<?php 

return array( 

				'details' => array(
										'title' => 'Internal Fonts',
										'description' => 'Integrate available theme fonts into your CSS',
										'category' => 'Fonts',
										'multiple' => 1,
										'block_list' => array( 'editor' )
								),
				'settings' => array(

										'font_name'  => array(

																'properties' => array(
																						'control_type'	 	=> 'relation',
																						'field_title' 		=> 'Fontface Name',
																						'field_description' => '',
																						'required'          => 1
																					
																					  )

															)


								   )	



			);

?>