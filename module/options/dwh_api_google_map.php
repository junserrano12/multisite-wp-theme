<?php

return array( 

				'details' => array(
											'title' => 'Google Map',
											'description' => 'For google maps',
											'category' => 'SEO',
											'multiple' => 0,
											'block_list' => array( 'editor' )
									),
				'settings' => array(


									'map_latitude' => array(
															
															'properties' => array(

																		'control_type'	 	=> 'text',
																		'field_title' 		=> "Latitude",
																		'field_description' => "Center the map on a specific point north or south of the equator. Map latitude coordinate (e.g. 0.0).",
																		'required'          => 1

																)
														
														  ),
									'map_longitude' => array(

																'properties' => array(
																		'control_type'	 	=> 'text',
																		'field_title' 		=> "Longitude",
																		'field_description' => "Center the map on a specific point east or west of the prime meridian. Map longitude coordinate (e.g. 0.0).",
																		'required'          => 1
																	)
														  ),
									'map_zoom' => array(
																'properties' => array(
																		'control_type'	 	=> 'text',
																		'field_title' 		=> 'Zoom',
																		'field_description' => 'The initial resolution at which to display the map. Must be an integer value. Zoom 0 is the lowest zoom level in which the map of the Earth is fully zoomed out. Higher zoom level doubles the precision in both horizontal and vertical dimensions. (Default e.g. "16")',
																		'required'          => 1
																	)
														  ),
									'map_iframe' => array(
																'properties' => array(
																		'control_type'	 	=> 'url',
																		'field_title' 		=> 'Iframe URL',
																		'field_description' => '',
																		'required'          => 0
																	)
															
														  ),
									'map_width' => array(
																'properties' => array(
																		'control_type'	 	=> 'text',
																		'field_title' 		=> 'Container width',
																		'field_description' => '',
																		'required'          => 0
																	)
															
														  ),
									'map_height' => array(
																'properties' => array(
																		'control_type'	 	=> 'text',
																		'field_title' 		=> 'Container height',
																		'field_description' => '',
																		'required'          => 0
																	)
															
														  )

																

								)

		);

?>