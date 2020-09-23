<?php

return array(
				array(
					'type'		=> 'api',
					'handle' 	=> 'gmaps',
					'src'  		=> '//maps.google.com/maps/api/js?v=3',
					'deps' 		=> '',
					'ver'		=> '1.0',
					'in_footer' => false
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'app_util',
					'src'  		=> get_template_directory_uri() . '/js/modules/app_util.js',
					'deps' 		=> '',
					'ver'		=> '1.0',
					'in_footer' => false
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'flexslider',
					'src'  		=> get_template_directory_uri() . '/js/lib/jquery.flexslider-min.js',
					'deps' 		=> array('jquery'),
					'ver'		=> '1.0',
					'in_footer' => false
				),
                array(
					'type'  	=> 'local',
					'handle'	=> 'datatable',
					'src'   	=> get_template_directory_uri() . '/module/admin/js/datatables.min.js',
					'deps'  	=> array('jquery'),
					'ver'  		=> '1.0',
					'in_footer' => false
				),
				array(
					'type'		=> 'local',
					'handle'	=> 'google-map',
					'src'  		=> get_template_directory_uri() . '/js/modules/google.map.js',
					'deps' 		=> array('jquery'),
					'ver'		=> '1.0',
					'in_footer' => false
				),
				array(
					'type'		=> 'wordpress',
					'handle' 	=> 'media-upload',
					'src'  		=> '',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'wordpress',
					'handle' 	=> 'thickbox',
					'src'  		=> '',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'wordpress',
					'handle' 	=> 'jquery-ui-datepicker',
					'src'  		=> '',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'wordpress',
					'handle' 	=> 'jquery-ui-sortable',
					'src'  		=> '',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'wordpress',
					'handle' 	=> 'iris', /* colourpicker */
					'src'  		=> '',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'jquery-generate',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/jquery.generatefile.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'generalsettings',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/admin.generalsettings.js',
					'deps' 		=> '',
					'ver'		=> '1.2',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'codemirror-plugin',
					'src'  		=> get_template_directory_uri() . '/module/admin/plugins/codemirror/js/codemirror.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'codemirror-plugin-css-js',
					'src'  		=> get_template_directory_uri() . '/module/admin/plugins/codemirror/js/codemirror.css.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'chosen-plugin',
					'src'  		=> get_template_directory_uri() . '/module/admin/plugins/chosen/js/chosen.jquery.min.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'codemirror-js',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/codemirror.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'chosen-js',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/chosen.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'colorpicker-js',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/colorpicker.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'options',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/admin.options.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'admin.widgets',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/admin.widgets.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'admin.tables',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/admin.tables.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'admin.tabs',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/admin.tabs.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'prettify',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/prettify.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'scroll-to-top',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/scrolltotop.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'colorbox-js',
					'src'  		=> get_template_directory_uri() . '/js/lib/jquery.colorbox-min.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'colorbox-ui',
					'src'  		=> get_template_directory_uri() . '/module/admin/plugins/colorbox/js/colorbox.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'admin-restrictions',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/admin.restrictions.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				),
				array(
					'type'		=> 'local',
					'handle' 	=> 'global-scripts',
					'src'  		=> get_template_directory_uri() . '/module/admin/js/global.js',
					'deps' 		=> '',
					'ver'		=> '',
					'in_footer' => true
				)
				

		);
	


?>
