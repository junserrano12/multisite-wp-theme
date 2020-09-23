<?php

return array( 

		'details' => array(
							'title' => 'Google Trackers',
							'description' => 'Google Analytics | Tag Manager | Remarketing Tag',
							'category' => 'SEO',
							'multiple' => 0,
							'block_list' => array( 'editor' )
						),
		'settings' => array(

					'tag_manager_flag'  => array(

												'properties' => array(

													'control_type'	 	=> 'select',
													'field_title' 		=> 'Enable google tag manager?',
													'field_description' => 'Select yes if you want to enable google tag manager',
													'required'          => 0
												)
											),
					'universal_analytics'  => array(

												'properties' => array(

													'control_type'	 	=> 'select',
													'field_title' 		=> 'Activate Universal Analytics',
													'field_description' => 'Select YES to enable Universal Analytics',
													'required'          => 0
												)
											),
					'google_tag_manager_code'  => array(

												'properties' => array(

														'control_type'	 	=> 'text',
														'field_title' 		=> 'Google tag manager code',
														'field_description' => 'Add google tag manager code here (e.g. GTM-XXXXX)',
														'required'          => 0
												)
											),
					'ua_analytics_code1' => array(
											
										'properties' => array(

												'control_type'	 	=> 'text',
												'field_title' 		=> "Universal Analytics 1",
												'field_description' => "Used when Universal Analytics field set to YES (e.g. UA-XXXXXXXX-1)",
												'required'          => 0

										)
									
									  ),
					'ua_analytics_code2' => array(
											
										'properties' => array(

												'control_type'	 	=> 'text',
												'field_title' 		=> "Universal Analytics 2",
												'field_description' => "Additional field for extra Universal Analytics code (e.g. UA-XXXXXXXX-2)",
												'required'          => 0

										)
									
									  ),
					'ga_code' => array(
											
										'properties' => array(

												'control_type'	 	=> 'text',
												'field_title' 		=> "Ga Code",
												'field_description' => "Will enable Google Analytics if this code is active (e.g. UA-XXXXX-1)",
												'required'          => 0

										)
									
									  ),
					'ga_code_2' => array(

										'properties' => array(
												'control_type'	 	=> 'text',
												'field_title' 		=> "Ga Code 2",
												'field_description' => "Additional field for extra Google Analytics code (e.g. UA-XXXXX-2)",
												'required'          => 0
											)
									  ),
					'ga_remarketing' => array(

											'properties' => array(
												'control_type'	 	=> 'text',
												'field_title' 		=> "Google Remarketing",
												'field_description' => "Will enable Google Remarketing script if this code is active",
												'required'          => 0
											)
									  )
				)

);

?>



