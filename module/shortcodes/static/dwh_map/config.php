<?php
	
	return array(

		'name'  => 'Google Map - Static',
		'tag'  => '[dwh_map]',
		'type' => 'Static',
		'desc' => 'Generates a google map; Can display multiple maps within a page',
		'param' => array(									
							'id' => 'Required. Should be unique. The map container id. (Default e.g. "").',
							'lat' => 'Required. Center the map on a specific point north or south of the equator. Map latitude coordinates (e.g. 0.0). (Default e.g. "") ',
							'lng' => 'Required. Center the map on a specific point east or west of the prime meridian. Map longitude coordinates (e.g. 0.0). (Default e.g. "")',
							'width' => 'Optional. The horizontal dimension of the map (e.g. "200"). (Default e.g. "100%").',
							'height' => 'Optional. The map vertical dimension (e.g. "250"). (Default e.g. "250px").'
						),
		'data' => 'Based on tag parameters',
		'usage' => ' [dwh_map id="map1" lat="14.600446" lng="120.983393" width="600" height="250"]',
		'notes' => "Verify map location and visibility on Google Map - go to: http://www.maps.google.com",
		'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/googlemap.png'

		);

?>