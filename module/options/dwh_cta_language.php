<?php 

return array( 

				'details' => array(
										'title' => 'CTA Language',
										'description' => 'Set the language to be use in the CTA button',
										'category' => 'CTA Settings',
										'multiple' => 1,
										'block_list' => array( 'editor' )
								),
				'settings' => array(

									'cta_language'  => array(

													'properties' => array(
																		'control_type'	 	=> 'relation',
																		'field_title' 		=> 'CTA Language',
																		'field_description' => 'Setting language to be use in the CTA button',
																		'required'          => 1
																		
																		  )

													)


								   )	

			);

?>