<?php
	
	return array(

			'name'  => 'Promo Marker',
			'tag'  => '[get_promo_marker]',
			'type' => 'Dynamic',
			'desc' => 'Gets a promo marker with a specified content that can be inserted via shortcode to any sections of the site',
			'param' => array(
								'type' => '',
								'id'   => 'A unique id to get the specific marker data from the Promo Marker settings'
							),
			'data' => 'Based on Site Settings configuration',
			'usage' => ' [get_promo_marker type="text" id="12345"]',
			'notes' => '',
			'screenshot' => ''

			);

?>