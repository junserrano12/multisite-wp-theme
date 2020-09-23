<?php

return array( 

				'details' => array(
											'title' => 'Sitemap XML',
											'description' => 'Sitemap XML Settings',
											'category' => 'Sitemap XML Settings',
											'multiple' => 1,
											'block_list' =>  array( 'editor' )
									),
				'settings' => array(

											'sitemap_xml'  => array(

																'properties' => array(
																						'control_type'	 	=> 'textarea',
																						'field_title' 		=> 'Content',
																						'field_description' => 'Insert XML code.',
																						'required'          => 1,
																						'class'             => 'full-width'
																					  )

																)

								)

		);

?>
