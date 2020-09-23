<?php
	
	return array(

				'name'  => 'Grid-based Gallery',
				'tag'  => '[gallery_grid]',
				'type' => 'Dynamic',
				'desc' => 'Grid-based gallery based on 12 columns',
				'param' => array(
									'ids' => 'Required. Image ids separated by comma (e.g."1,2,3").',
									'name' => 'Optional. The class of the container. (Default e.g. "gallery-grid-container").',
									'caption ' => 'Optional. To show image caption. Boolean. (Default. e.g. "false")',
									'title' => 'Optional. To show image title below image. Boolean. (Default. e.g. "false")',
									'titleontop ' => 'Optional. Show image title on top of the image . Boolean. (Default. e.g. "false")',
									'textalign' => 'Optional. Image title alignment. Values(left, right, center). (Default. e.g. "center")',
									'columns' => 'Optional. The grid columns. (Default. e.g. 4).',
									'rel' => 'Optional. Image popup modal grouping. (Default e.g. "group").',
									'colorbox' => 'Optional. Values(colorbox-inline, colorbox). (Default e.g. "colorbox").',
									'imagesize' => 'Optional. The image size you wanted to display. Values(thumbnail, medium, large, full). (Default e.g. "medium")',
									'displaycolorboxtitle' => 'Optional. To show image title on image popup modal. Boolean. (Default e.g. "false")'
								),
				'data' => 'Based on tag parameters',
				'usage' => ' [gallery_grid ids="1,2,3" name="gallery-grid-container1" caption="true" title="true" titleontop="false" textalign="left" columns="3" colorbox="colorbox-inline" imagesize="medium" rel="group1" displaycolorboxtitle="true"]',
				'notes' => 'Use add media button to create gallery and initially get the image id(s)',
				'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/screenshot.png'

				);

?>