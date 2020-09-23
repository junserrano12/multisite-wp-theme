<?php $tab_entity = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>
<?php
	return array(

			'name'  => 'Accordion - Static',
			'tag'  => '[dwh_accordions]<br>[dwh_accordion title=""][/dwh_accordion]<br>[dwh_accordions]',
			'type' => 'Static',
			'desc' => 'Displays an accordion; Follows an html tag based structure with the tag [dwh_accordions] as an opening tag and [/dwh_accordions] as a closing tag; followed inside with tags [dwh_accordion title="Title"][/dwh_accordion] tags as accordion sections.',
			'param' => array(									
								'[dwh_accordions]' => 'No parameter',
								'[dwh_accordion]' => '<br> title="Required. Accordion section head title (e.g. "Title 1"). (Default e.g. "").'
							),
			'data' => 'Based on tag parameters',
			'usage' => ' [dwh_accordions][dwh_accordion title="Title 1"]Content 1[/dwh_accordion][dwh_accordion title="Title 2"][/dwh_accordion][/dwh_accordions]',
			'notes' => 'Needs proper opening and closing tags to work properly',
			'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/accordion.png'

			);

?>