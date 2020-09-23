
<?php
	
	return array(

				'name'  => 'Dynamic Custom Content',
				'tag'  => '[get_custom_content]',
				'type' => 'Dynamic',
				'desc' => 'Create dynamic custom content per shortcode declaration',
				'param' => array(
									'key' => 'Required. Should be unique. The custom content meta name. String. (Default e.g. "content")',
									'single' => 'Optional. The return data type of the custom content. Boolean. (Default e.g. "true").'
								),
				'data' => 'Based on tag parameters',
				'usage' => '[get_custom_content]',
				'notes' => '',
				'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/screenshot.png'

				);

?>