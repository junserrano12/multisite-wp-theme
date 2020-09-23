<?php

return array( 

				'details' => array(
											'title' => 'Google Webmaster tool',
											'description' => 'For boosting site traffic flow',
											'category' => 'SEO',
											'multiple' => 0,
											'block_list' => array( 'editor' )
									),
				'settings' => array(


											'site_verification_tag'  => array(

																	'properties' => array(
																							'control_type'	 	=> 'tag',
																							'field_title' 		=> 'Site verification tag',
																							'field_description' => 'Add meta tag to verify site ownership (e.g. &lt;meta name="google-site-verification" content="String_we_ask_for"&gt;). Replace "String_we_ask_for" with your unique string from google webmaster tools.',
																							'required'          => 0
																						
																						  )

																)

								)

		);

?>
