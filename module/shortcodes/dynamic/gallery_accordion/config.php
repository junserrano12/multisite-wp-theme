
<?php
	
	return array(

				'name'  => 'Accordion Gallery',
				'tag'  => '[gallery_accordion]',
				'type' => 'Dynamic',
				'desc' => 'Displays multiple gallery accordion',
				'param' => array(
									'ids' => 'Required. Image ids separated by comma (e.g."1,2,3").',
									'name' => 'Optional. Should be unique. The id of the container. (Default e.g. "accordion-container").',
									'ctabuttonlink ' => 'Optional. CTA Button Text. (Default. e.g. "Check availability and price").',
									'class' => 'Optional. CTA Button class. (Default. e.g. "button ctapackage").',
									'spanimageclass' => 'Optional. How many columns you want to display. Should be less than or equal to 12. Integer value. Default(e.g. 3)',
									'ctabutton' => 'Optional. Show/hide CTA Button. Boolean. (Default. e.g. "false").',
									'showfirst ' => 'Optional. To show first element of accordion. Boolean. (Default. e.g. "true").',
									'colorbox' => 'Optional. Values(colorbox-inline, colorbox). (Default e.g. "colorbox").'

								),
				'data' => 'Based on tag parameters',
				'usage' => '[gallery_accordion ids="1,2,3" name="accordion-container" ctabuttonlink="Check availability and price" ctabutton="true" class="button ctapackage" iscolorbox="true" showfirst="true"]',
				'notes' => 'Use add media button to create gallery and initially get the image id(s)',
				'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/screenshot.png'

				);

?>