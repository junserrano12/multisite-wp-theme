<?php 

return array( 

				'details' => array(
										'title' => 'IBE URL Switch',
										'description' => 'Fetch custom domain for CTA button and links automatically',
										'category' => 'scripts',
										'multiple' => 1,
										'block_list' => array( 'editor' )
								),
				'settings' => array(

									'ibe_url_switch'  => array(

													'properties' => array(
																		'control_type'	 	=> 'select',
																		'field_title' 		=> 'Auto Sync?',
																		'field_description' => 'Turning IBE URL to auto sync',
																		'required'          => 1
																		
																		  )

													),
									'ibe_url_switch_interval'  => array(

													'properties' => array(
																		'control_type'	 	=> 'relation',
																		'field_title' 		=> 'Interval',
																		'field_description' => 'Set interval for IBE URL autosync(default is every 8hour)',
																		'required'          => 0
																		
																		  )

													)

								   )	

			);

?>