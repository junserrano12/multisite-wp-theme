<?php $tab_entity = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>
<?php
	
	return array(

				'name'  => 'Tab - Static',
				'tag'  => '[dwh_tabs]<br>[dwh_tab title=""][/dwh_tab]<br>[/dwh_tabs]',
				'type' => 'Static',
				'desc' => 'Displays a tab; Follows an html tag based structure with the tag [dwh_tabs] as an opening tag and [/dwh_tabs] as a closing tag; followed inside with tags [dwh_tab title="Title"][/dwh_tab] tags as tab sections.',
				'param' => array(
									'[dwh_tabs]' => 'No parameter',
									'[dwh_tab]' => '<br> title="Required. Tabs section head title (e.g. "Title 1"). (Default e.g. "").'
								),
				'data' => 'Based on tag parameters',
				'usage' => ' [dwh_tabs][dwh_tab title="Title 1"]Content 1[/dwh_tab][dwh_tab title="Title 2"]Content 2[/dwh_tab][/dwh_tabs]',
				'notes' => 'Needs proper opening and closing tags to work properly',
				'screenshot' => get_template_directory_uri() . '/module/documentation/screenshots/shortcodes/tab.png'
			);

?>