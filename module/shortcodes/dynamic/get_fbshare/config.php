<?php
	
	return array(

			'name'  => 'Facebook Share',
			'tag'  => '[get_fbshare]',
			'type' => 'Dynamic',
			'desc' => 'Displays a facebook share button',
			'param' => array(
								'url' => ' Optional. url. (e.g. "https://www.facebook.com/directwithhotels"). Default based on site domain url.',
								'layout' => 'Optional. Facebook share button layout. Values (link, box_count, button_count, button , icon_link , icon ). Default (link).'
							),
			'data' => 'Based on Site Settings configuration',
			'usage' => ' [get_fbshare url="https://www.facebook.com/directwithhotels" layout="button_count"] ',
			'notes' => '',
			'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/screenshot.png'

			);

?>
