<?php
	
	return array(

			'name'  => 'Teaser Gallery',
			'tag'  => '[gallery_teaser]',
			'type' => 'Dynamic',
			'desc' => 'Teaser container for front page based on 12 columns',
			'param' => array(
								'ids' => 'Required. Image ids separated by comma (e.g."1,2,3").',
								'columns' => 'Optional. The grid columns. (Default. e.g. 4).',
								'readmore ' => 'Optional. Teaser content read more text. (Default e.g. "Read More")',
								'imagesize' => 'Optional. The image size you wanted to display. Values(thumbnail, medium, large, full). (Default e.g. "medium")',
								'teaserlink' => 'Optional. Teaser custom external link text. Default text(e.g. "Read More" )',
								'teaserlinktext' => 'Optional. Teaser custom external link text. Default(e.g. teaserlink if specified)',
								'titleontop' => 'Optional. Show image title on top of the image . Boolean. (Default. e.g. "false")',
								'colorbox' => 'Optional. Values(colorbox-inline, colorbox). (Default e.g. "colorbox").'

							),
			'data' => 'Based on tag parameters',
			'usage' => ' [gallery_teaser ids="1,2" columns="4" imagesize="large" teaserlink="Read More" teaserlinktext="Read More" titleontop="false"]',
			'notes' => 'Use add media button to create gallery and initially get the image id(s). ',
			'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/screenshot.png'

			);

?>