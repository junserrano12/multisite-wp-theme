<?php

return array(
			
			'id' => 'button_set_layout',
			'title' => 'Add Layout',
			'text' => 'Layout',
			'description' => 'Insert tabular layout',
			'image_icon' => '',	
			'body' => array(
							array(
								'type' => 'listbox',
								'name' => 'layout',
								'label' => 'Layout',
								'values' => array(
												array(
													'text' => 'Full Column',
													'value' => '<div class="row-fluid"><div class="span12">lorem ipsum....</div></div>'
												),
												array(
													'text' => '2 Column',
													'value' => '<div class="row-fluid"><div class="span6">lorem ipsum....</div><div class="span6">lorem ipsum....</div></div>'
												),
												array(
													'text' => '2 Col (4&8)',
													'value' => '<div class="row-fluid"><div class="span4">lorem ipsum....</div><div class="span8">lorem ipsum....</div></div>'
												),
												array(
													'text' => '2 Col (8&4)',
													'value' => '<div class="row-fluid"><div class="span8">lorem ipsum....</div><div class="span4">lorem ipsum....</div></div>'
												),
												array(
													'text' => '3 Column',
													'value' => '<div class="row-fluid"><div class="span4">lorem ipsum....</div><div class="span4">lorem ipsum....</div><div class="span4">lorem ipsum....</div></div>'
												),
												array(
													'text' => '4 Column',
													'value' => '<div class="row-fluid"><div class="span3">lorem ipsum....</div><div class="span3">lorem ipsum....</div><div class="span3">lorem ipsum....</div><div class="span3">lorem ipsum....</div></div>'
												)
												
											)
							)
							
						)

			);

?>
