<?php

return array( 

				'details' => array(
											'title' => 'Google Publisher',
											'description' => 'For google authoring and publishers',
											'category' => 'SEO',
											'multiple' => 0,
											'block_list' =>  array( 'editor' )
									),
				'settings' => array(


											'publisher'  => array(

																	'properties' => array(
																							'control_type'	 	=> 'url',
																							'field_title' 		=> 'Publisher URL',
																							'field_description' => 'Publisher URL: Should be valid url for 3rd party source. Will automatically generate tag for publisher link (e.g. http://directwithhotels.com).',
																							'required'          => 0
																						
																						  )

																)

								)

		);

?>
