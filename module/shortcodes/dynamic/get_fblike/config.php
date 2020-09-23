<?php
	
	return array(

			'name'  => 'Facebook Like',
			'tag'  => '[get_fblike]',
			'type' => 'Dynamic',
			'desc' => 'Gets the fblike button and the number of likes with a specified facebook fan page URL',
			'param' => array(
								'url' => ' Optional. Facebook fan page url. (e.g. "https://www.facebook.com/directwithhotels"). Default based on site settings.',
								'layout' => 'Optional. Facebook Like layout. Values (standard, box_count, button_count, button). Default (standard).',
								'colorscheme ' => 'Optional. Values (light, dark). Default (light).'
							),
			'data' => 'Based on Site Settings configuration',
			'usage' => ' [get_fblike url="https://www.facebook.com/directwithhotels" layout="standard" colorscheme="light"]',
			'notes' => '',
			'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/screenshot.png'

			);

?>