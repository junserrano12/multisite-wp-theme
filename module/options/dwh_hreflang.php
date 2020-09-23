<?php


return array( 

				'details' => array(
										'title' => 'HREFLang Metatag',
										'description' => 'Insert hreflang Metatag',
										'category' => 'SEO',
										'multiple' => 1

									),
				'settings' => array(


										'hreflang_url'  => array(

																'properties' => array(
																					'control_type'	 	=> 'text',
																					'field_title' 		=> 'URL',
																					'field_description' => 'http://kr.zuespalacehotel.com',
																					'required'          => 1
																				  ),

															),
										'hreflang_value'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'hreflang',
																						'field_description' => 'Ex: ko-kr',
																						'required'          => 1
																						
																					  )

															)

									)

	 );

?>

