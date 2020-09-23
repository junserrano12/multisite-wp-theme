<?php 
$pageList = page_title_list();
return array( 

				'details' => array(
										'title' => 'Code Snippets',
										'description' => 'Integrate code snippets or custom scripts outside of the content areas',
										'category' => 'scripts',
										'multiple' => 1,
										'block_list' => array( 'editor' )
								),
				'settings' => array(

										'cscript_name'  => array(

																'properties' => array(
																						'control_type'	 	=> 'text',
																						'field_title' 		=> 'Name or description',
																						'field_description' => "The name of your script",
																						'required'          => 1
																					
																					  )

															),
										'custom_script'  => array(

																'properties' => array(
																						'control_type'	 	=> 'textarea',
																						'field_title' 		=> 'Custom Script',
																						'field_description' => '',
																						'required'          => 1
																					
																					  )

															),
										'cscript_location'  => array(

																'properties' => array(
																						'control_type'	 	=> 'relation',
																						'field_title' 		=> 'Location',
																						'field_description' => 'Place to integrate this script',
																						'required'          => 1
																					
																					  )

															),
										'cscript_display_to'  => array(

																'properties' => array(
																						'control_type'	 	=> 'checkbox',
																						'field_title' 		=> 'Page to display',
																						'field_description' => 'Page to integrate this script, if no checkbox is selected the script displays to all pages',
																						'required'          => 0,
																						'option_value'      => $pageList
																					
																					  )

															)


								   )	

			);

?>