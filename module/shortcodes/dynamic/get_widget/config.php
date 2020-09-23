<?php
	
	return array(

			'name'  => 'Widget Render',
			'tag'  => '[get_widget]',
			'type' => 'Dynamic',
			'desc' => 'Render widget based on provided name',
			'param' => array(
								'name' => 'Required. The name of the widget to be rendered.',
							),
			'data' => 'Based on tag parameters',
			'usage' => ' [get_widget name="widget_logo"]',
			'notes' => '',
			'screenshot' => get_template_directory_uri()

			);

?>