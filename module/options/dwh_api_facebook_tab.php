<?php

return array( 

				'details' => array(
											'title' => 'Facebook Tab',
											'description' => 'For facebook tab APIs',
											'category' => 'APIs',
											'multiple' => 0,
											'block_list' => array( 'editor' )
									),
				'settings' => array(


											'app_id'  => array(

																	'properties' => array(
																							'control_type'	 	=> 'text',
																							'field_title' 		=> 'Facebook App ID',
																							'field_description' => 'A Facebook app. Apps are created, maintained and deleted in the app dashboard',
																							'required'          => 0
																						
																						  )

																),
											'redirect_uri'  => array(

																	'properties' => array(
																							'control_type'	 	=> 'text',
																							'field_title' 		=> 'Redirect URL',
																							'field_description' => 'The URL to redirect to after a person clicks a button on the dialog. Required when using URL redirection. This URL must be owned by the same app specified by the app_id. The redirect will include a URL parameter tabs_added which is an array of IDs of any pages that the app was added to using the dialog.',
																							'required'          => 0
																						
																						  )

																)

								)

		);

?>
