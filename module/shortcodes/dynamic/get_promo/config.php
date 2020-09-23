<?php
	
	return array(

			'name'  => 'Promocentric',
			'tag'  => '[get_promo]',
			'type' => 'Dynamic',
			'desc' => 'Displays valid promo',
			'param' => array(
								'cta_display' => 'Optional. Display CTA, the calendar and the button or button only or none at all, default is cta. Values(cta, button, none).',
							),
			'data' => 'Based on Site Settings configuration',
			'usage' => ' [get_promo]',
			'notes' => '',
			'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/screenshot.png'

			);

?>