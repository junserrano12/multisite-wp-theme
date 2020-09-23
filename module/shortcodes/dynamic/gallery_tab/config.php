<?php
	
	return array(

				'name'  => 'Tab-based Gallery',
				'tag'  => '[gallery_tab]',
				'type' => 'Dynamic',
				'desc' => 'Gallery tab-based',
				'param' => array(
									'ids' => 'Required. Image ids separated by comma (e.g."1,2,3").',
									'name' => 'Optional. Should be unique. The id of the container. (Default e.g. "tab-container").',
									'colorbox' => 'Optional. Values(colorbox-inline, colorbox). (Default e.g. "colorbox").'
								),
				'data' => 'Based on tag parameters',
				'usage' => ' [gallery_tab ids="1,2,3" name="tab-container-1"]',
				'notes' => 'Use add media button to create gallery and initially get the image id(s)',
				'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/screenshot.png'

				);

?>