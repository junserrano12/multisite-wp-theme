<?php
if( !class_exists( 'DWH_wponetheme_config' ) )
{
	class DWH_wponetheme_config
	{
		public function __construct()
		{
		}

		public function get_directory_list( $directory = null )
		{
			$directory_lists = array();

			if( $directory ) {

				$dir_scan = scandir( $directory );

				foreach ( $dir_scan as $dir_item )
				{
					if( $dir_item != '.' && $dir_item != '..' &&  !preg_match( '/.php|.js|.css|.txt/', $dir_item ) )
					{
						array_push( $directory_lists, $dir_item );
					}
				}
			}

			return $directory_lists;
		}

		public function get_config( $config_directory, $config_name, $ext )
		{
			$config_file = $config_directory . $config_name . '.' . $ext;

			if ( file_exists( $config_file ) ) {
				switch ( $ext ) {
					case 'php':

						return include( $config_file );

						break;

					case 'json':

						$file_content = file_get_contents( $config_file );

						$search = array(
										'get_template_directory_uri()',
										'get_stylesheet_directory_uri()',
										'dwh_get_main_directory_uri()',
										'dwh_get_theme_template_uri()',
										'includes_url()'
									);

						$replace = array(
										get_template_directory_uri(),
										get_stylesheet_directory_uri(),
										dwh_get_main_directory_uri(),
										dwh_get_theme_template_uri(),
										includes_url()
									);

						$file_content = str_replace( $search, $replace, $file_content );

						return json_decode( $file_content );

						break;

					case 'css':

						$file_content = file_get_contents( $config_file );
						return $file_content;

						break;

					default:

						return false;

						break;
				}

			} else {

				return false;

			}
		}
	}
}