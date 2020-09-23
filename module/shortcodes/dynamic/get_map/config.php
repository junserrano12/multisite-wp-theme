<?php
	
	return array(

			'name'  => 'Google Map',
			'tag'  => '[get_map]',
			'type' => 'Dynamic',
			'desc' => 'Displays a goole map',
			'param' => array(									
								'lat ' => 'Required. Center the map on a specific point north or south of the equator. Map latitude coordinate (e.g. 0.0). ',
								'lng ' => 'Required. Center the map on a specific point east or west of the prime meridian. Map longitude coordinate (e.g. 0.0).',
								'zoom ' => 'Required. The initial resolution at which to display the map. Must be an integer value. Zoom 0 is the lowest zoom level in which the map of the Earth is fully zoomed out. Higher zoom level doubles the precision in both horizontal and vertical dimensions. (Default e.g. "16")',
								'width ' => 'Optional. The horizontal dimension of the map (e.g. "200"). (Default e.g. "100%")',
								'height ' => 'Optional. The map vertical dimension (e.g. "250"). (Default e.g. "250px").'
							),
			'data' => 'Based on Site Settings configuration',
			'usage' => ' [get_map width="500" height="350"]',
			'notes' => '',
			'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/screenshot.png'

			);

?>