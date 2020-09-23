<?php

	return array(
				'details' =>     array( 
									'name' => 'Slider Settings',
									'description' => '',
									'data-type' => ''
								),
				'slider-name' => '',
				'slider-mode' => array(
									'page' => array(
										'name' => 'Page',
										'value' => 'page'
									),
									'site' => array(
										'name' => 'Site',
										'value' => 'site'
									)
								),
				'slider-type' => array(
									'default' => array(
											'name' => 'Default Slider',
											'value' => 'Default Slider'
										), 
									'bullet' => array(
											'name' => 'Bullet Slider',
											'value' => 'Bullet Slider'
										), 
									'thumbnaillarge' => array(
											'name' => 'Thumbnail Large ( 300 x Auto)',
											'value' => 'Thumbnail Large'
										), 
									'thumbnailmedium' => array(
											'name' => 'Thumbnail Medium ( 150 x Auto)',
											'value' => 'Thumbnail Medium'
										), 
									'thumbnailsmall' => array(
											'name' => 'Thumbnail Small (40 x 40 hard crop)',
											'value' => 'Thumbnail Small'
										)
								),
				'slider-upload-image-src' => get_template_directory_uri() .'/images/default-noimage-150x150.jpg'
			);

?>