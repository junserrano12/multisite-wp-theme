<?php

return array( 

				'details' => array(
											'title' => 'Site Meta data',
											'description' => 'Site meta data like robots',
											'category' => 'SEO',
											'multiple' => 0,
											'block_list' => array( 'editor' )
									),
				'settings' => array(
											
											'noindexnofollow'  => array(

																	'properties' => array(
																							'control_type'	 	=> 'select',
																							'field_title' 		=> 'Enable noindex, nofollow?',
																							'field_description' => 'If enabled, the spider will NOT crawl the page and the rest of your webpages .',
																							'required'          => 1
																						
																						  )

																)

								)

		);

?>
