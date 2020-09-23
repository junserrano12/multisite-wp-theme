<?php
	
	return array(

			'name'  => 'Company Address',
			'tag'  => '[get_address]',
			'type' => 'Dynamic',
			'desc' => 'Gets the address of the business site owner',
			'param' => array(
								'address_type' => 'Required. The display of the address. Values(block, inline).',
							),
			'data' => 'Based on Site Settings configuration',
			'usage' => ' [get_address address_type="block"]',
			'notes' => '',
			'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/screenshot.png'

			);

?>