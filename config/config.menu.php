<?php

return  array(

			array(
						'section' 	 	=> 'main',
						'page_title' 	=> 'Site Settings',
						'menu_title' 	=> 'Site Settings',
						'capability' 	=>  array('super admin','administrator','editor'),
						'page_slug'		=> 'dwh-settings',
						'parent_slug'	=> 'dwh-settings',
						'page'		 	=> '/module/admin/views/option-settings.php',
						'icon'			=> 'dashicons-admin-site',
						'position'	 	=> 3

					),
			array(
						'section' 	 	=> 'sub',
						'page_title' 	=> 'dwh-settings',
						'menu_title' 	=> 'Options Settings',
						'capability' 	=>  array('super admin','administrator'),
						'page_slug'		=> 'dwh-options-migration',
						'parent_slug'	=> 'dwh-settings',
						'page'		 	=> '/module/admin/views/option-migration.php',
						'icon'			=> 'dashicons-migrate',
						'position'	 	=> 1


					),
			// array(
			// 			'section' 	 	=> 'sub',
			// 			'page_title' 	=> 'dwh-settings',
			// 			'menu_title' 	=> 'Theme Designer',
			// 			'capability' 	=>  array('super admin','administrator','editor'),
			// 			'page_slug'		=> 'dwh-theme-designer',
			// 			'parent_slug'	=> 'dwh-settings',
			// 			'page'		 	=> '/module/admin/views/theme-customization.php',
			// 			'icon'			=> 'dashicons-welcome-write-blog',
			// 			'position'	 	=> 2
			// 		),
			array(
						'section' 	 	=> 'sub',
						'page_title' 	=> 'dwh-settings',
						'menu_title' 	=> 'Theme Guide',
						'capability' 	=>  array('super admin','administrator','editor'),
						'page_slug'		=> 'dwh-theme-docu',
						'parent_slug'	=> 'dwh-settings',
						'page'		 	=> '/module/admin/views/dwh-theme-doc.php',
						'icon'			=> 'dashicons-welcome-write-blog',
						'position'	 	=> 3

					)
			

		 );

?>