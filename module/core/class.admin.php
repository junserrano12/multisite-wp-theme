<?php
/*

Function: Core Admin Class

*/

Class DWH_Admin
{
	function __contruct()
	{

	}

	/*
	* Registers a widget
	* @return (none)
	*/
	function load()
	{

	}

	/* Loads dashboard settings */
	function load_settings( $menu_config )
	{

		if (is_admin()) {

			$is_menu_allowed = false;

			add_action('admin_menu',function() use ( $menu_config ){


			foreach ($menu_config as $key => $value) {

				/* Check if menu is allowed for the user */
				if( in_array( DWH_USER_ROLE , $value['capability'] ))
				{
					$is_menu_allowed = true;
				}
				else
				{
					$is_menu_allowed = false;
				}


				if( $is_menu_allowed == true )
				{
					if( $value['section'] == 'main' )
					{
						add_menu_page( $value['page_title'], $value['menu_title'], DWH_USER_ROLE , $value['page_slug'] ,  function() use ( $value ){
							include(get_template_directory(). $value['page'] );
						}, $value['icon'], $value['position']);

					}
					else
					{
						add_submenu_page( $value['parent_slug'] , $value['page_title'], $value['menu_title'], DWH_USER_ROLE , $value['page_slug'] ,  function() use ( $value ){
							include(get_template_directory(). $value['page'] );
						}, $value['icon'] , $value['position'] );
					}
				}

			}


			});


		}

	}

	function load_scripts()
	{
		if (is_admin()) {

			add_action('admin_init',function(){

				$site_config_menu_dir = get_template_directory().'/config/config.menu.php';
				$config_menu = array();
				$config_arr = array();

				/* only enable enqueue media to custom setting define on config menu */
				if(file_exists($site_config_menu_dir)){
					$config_menu = include($site_config_menu_dir);
					foreach( $config_menu as $key => $val ){
						array_push( $config_arr, $val['page_slug'] );
					}
				}

				/* if request is page and page is equal to defined pages in menu */
				if( isset($_REQUEST['page']) ){
					if( in_array( $_REQUEST['page'], $config_arr ) ){
						/* include all media files necessary to use media Javascript API */
						wp_enqueue_media();
					}
				}

			});


			$site_scripts_global_dir = get_template_directory().'/module/admin/config/config.scripts.global.php';
			$config_scripts = array();
			if(file_exists($site_scripts_global_dir)) $config_scripts = include($site_scripts_global_dir);

			add_action('init',function() use ( $config_scripts ){

				foreach ($config_scripts as $key) {

					switch ($key['type']) {
						case 'api':
								wp_register_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
								wp_enqueue_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
							break;
						case 'local':
								wp_register_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
								wp_enqueue_script($key['handle'],$key['src'],$key['deps'],$key['ver'],$key['in_footer']);
							break;
						default:
								/* Wordpress script library */
								wp_enqueue_script($key['handle']);

							break;
					}

				}


			});

			$dir = get_template_directory().'/module/admin/js/';

			if( file_exists( $dir ))
			{
				$admin_dir_scripts = scandir( $dir );

				foreach($admin_dir_scripts as $admin_script)
				{
					$handle = explode('.',$admin_script);
					$src = "";

					if( isset( $handle[1] ))
					{
						/* Php Extension */
						if( $handle[1] == 'php')
						{
							if($admin_script!='.'&& $admin_script!='..')
							{
								$src = $dir . $admin_script;
								add_action('admin_footer', function() use ( $handle, $src ){
									include($src);
								});
							}

						}
					}


				}
			}


		}

	}

	function load_styles()
	{
		if (is_admin()) {

			$site_styles_global_dir = get_template_directory().'/module/admin/config/config.styles.global.php';
			$site_styles_global_config = array();
			if(file_exists($site_styles_global_dir)) $site_styles_global_config = include($site_styles_global_dir);

			add_action('init',function() use ( $site_styles_global_config ){

				foreach ($site_styles_global_config as $key) {

						wp_enqueue_style( 'admin-' . $key['handle'],$key['src']);
					}
			});

		}

	}

	function get_site_themes()
	{
		$dir = DWH_SITE_THEME_DIR .'site/';
		$response = false;

		if( file_exists($dir)) $response = true;

		if( $response == true )
		{
			$dir_scan = scandir( $dir );

			foreach($dir_scan as $dir_item)
			{
				if($dir_item!='.'&& $dir_item!='..')
				{
					$site_theme =  $dir_item;
					$theme_config_url = DWH_SITE_THEME_DIR . 'site/' . $site_theme . '/config.php';
					$theme_info = file_exists($theme_config_url) ? include($theme_config_url) : array();
					$theme_info = $theme_info['details'];
					$screenshot_path = DWH_SITE_THEME_DIR . 'site/' . $site_theme . '/screenshot.jpg';
					$screenshot_url = DWH_SITE_THEME_URI . 'site/' . $site_theme . '/screenshot.jpg';
					$screenshot = file_exists( $screenshot_path ) ?  $screenshot_url : 'No screenshot available';
					$theme_info['screenshot'] = $screenshot;
					$list[$site_theme] = $theme_info;
				}
			}

			return $list;
		}

	}

	function get_site_fonts()
	{

		$dir = get_template_directory().'/fonts' ;
		$response = false;

		if( file_exists($dir)) $response = true;

		if( $response == true )
		{
			$dir_scan = scandir( $dir );

			foreach($dir_scan as $dir_item)
			{
				if($dir_item!='.'&& $dir_item!='..')
				{
				 	$font_name = $dir_item;
					$font_config_url = get_template_directory().'/fonts/'.$font_name.'/config.php';
					$font_info = file_exists($font_config_url) ? include($font_config_url) : array();
					$font_info = $font_info['details'];
					$list[$font_name] = $font_info;
				}
			}

			return $list;
		}

	}


	function get_page_theme_config( $theme )
	{
		$dir  = get_template_directory() . '/module/themes/page/';
		$config_dir = $dir . $theme . '/config.php';
		if( file_exists($config_dir) ) return include( $config_dir );
	}


	function get_site_theme_config( $theme )
	{
		$dir  = get_template_directory() . '/module/themes/site/';
		$config_dir = $dir . $theme . '/config.php';
		if( file_exists($config_dir) ) return include( $config_dir );
	}


	function get_themes( $type )
	{
		$dir  = get_template_directory() . '/module/themes/' . $type ;
		$response = false;
		$list = array();

		if( file_exists($dir)) $response = true;

		if( $response == true )
		{
			$dir_scan = scandir( $dir );

			foreach($dir_scan as $dir_item)
			{
				if($dir_item!='.'&& $dir_item!='..'&&$dir_item!='header.php'&&$dir_item!='footer.php')
				{
					$theme_name =  $dir_item;
					$theme_config_url = $dir . $theme_name . '/config.php';
					$theme_info = file_exists($theme_config_url) ? include($theme_config_url) : array();
					$theme_info  = $theme_info['details'];

					$screenshot_path = $dir . $page_theme . '/screenshot.jpg';
					$screenshot_url = DWH_SITE_THEME_URI . 'page/' . $theme_name . '/screenshot.jpg';
					$screenshot = file_exists( $screenshot_path ) ?  $screenshot_url : 'No screenshot available';
					$theme_info['screenshot'] = $screenshot;
					$list[$theme_name] = $theme_info;
				}
			}

			return $list;
		}

	}


	function get_page_themes()
	{
		$dir  = DWH_SITE_THEME_DIR . '/page';
		$response = false;
		$list = array();

		if( file_exists($dir)) $response = true;

		if( $response == true )
		{
			$dir_scan = scandir( $dir );

			foreach($dir_scan as $dir_item)
			{
				if($dir_item!='.'&& $dir_item!='..'&&$dir_item!='header.php'&&$dir_item!='footer.php')
				{
					$page_theme =  $dir_item;
					$theme_config_url = DWH_SITE_THEME_DIR . 'page/' . $page_theme . '/config.php';
					$theme_info = file_exists($theme_config_url) ? include($theme_config_url) : array();
					$theme_info  = $theme_info['details'];

					$screenshot_path = DWH_SITE_THEME_DIR . 'page/' . $page_theme . '/screenshot.jpg';
					$screenshot_url = DWH_SITE_THEME_URI . 'page/' . $page_theme . '/screenshot.jpg';
					$screenshot = file_exists( $screenshot_path ) ?  $screenshot_url : 'No screenshot available';
					$theme_info['screenshot'] = $screenshot;
					$list[$page_theme] = $theme_info;
				}
			}

			return $list;
		}

	}


	function get_page_types()
	{
		$dir  = get_template_directory() . '/module/post-types';
		$response = false;

		if( file_exists($dir)) $response = true;

		if( $response == true )
		{
			$dir_scan = scandir( $dir );

			foreach($dir_scan as $dir_item)
			{
				if($dir_item!='.'&& $dir_item!='..'&&$dir_item!='page')
				{
					$list[] = array( $dir_item );
				}
			}

			return $list;
		}

	}

	/* Saves new page themes on wp options dwh_pages option set */
	function autoload_new_page_themes()
	{

		$page_themes = $this->get_page_themes();

		if( !empty( $page_themes ))
		{
			$page_settings = array();

			if( (bool)get_dwh_option('dwh_pages') == true )
			{
				$page_settings = get_dwh_option('dwh_pages');
			}

			$is_active = false;

			/* collect page settings data */
			foreach ($page_themes as $key => $page_theme ) {


				$page_theme_info =  array(
											'page_type' 			=> $page_theme['category'],
											'page_theme' 			=> $key,
											'page_css'				=> '',
											'page_mediaquery'		=> ''
										 );

				$is_active = recursive_array_search( $key , $page_settings );

				if( $is_active != false  )
				{ }
				else
				{
					array_push( $page_settings , $page_theme_info );
				}

			}

			/* Check if page settings is not empty */
			if( !empty( $page_settings ) )
			{
				update_option('dwh_pages' , $page_settings );
			}

		}
	}


	/* Checks wether the section or area is restricted for the user
	@role 		: wordpress user role
	@category 	: category to restrict within the app
	@set 		: Main setting name under a category
	@item 		: Item under a category set
	@mode 		: search mode
	*/
	function is_restricted( $user_role , $category , $field_name = null , $field_value = null , $mode = 'match' )
	{

		$restriction_config = $this->get_user_role_restrictions();
		$user_role = $user_role ? ucfirst( $user_role ) : '';

		/* Check param and config */
		if( !$user_role && !$category ) return true;

		/* Check if category is set */
		if( isset( $restriction_config[$user_role][$category] ) && empty( $restriction_config[$user_role][$category] ) ) return true;

		/* If set is specified */

		if( isset( $restriction_config[$user_role][$category]) )
		{
			if( !empty( $restriction_config[$user_role][$category] ) )
			{
				switch ( $mode ) {

					case 'match':

							foreach ( $restriction_config[$user_role][$category] as $key => $field_values ) {

								if( isset( $field_values[$field_name] ) )
								{
									if( $field_values[$field_name] == $field_value )
									{
										return true;
									}
								}
							}

						break;

					case 'lookup':

							foreach ( $restriction_config[$user_role][$category] as $key => $field_values ) {

								if( isset( $field_values[$field_name] ) )
								{
									if( is_array( $field_values[$field_name] ) && in_array( $field_value , $field_values[$field_name] ) )
									{
										return true;
									}
								}
							}

						break;
				}

			}
		}

		return false;

 	}


 	function load_restrictions()
 	{


			$restriction_config = $this->get_user_role_restrictions();

			if( !empty( $restriction_config ) )
			{

				foreach ($restriction_config as $key => $restriction_config_item ) {

					$user_role = strtolower( $key );

					if( $user_role == DWH_USER_ROLE )
					{
						/* Restriction sections */
						foreach ($restriction_config_item as $key => $restriction_config ) {

							switch ( $key ) {

								case 'caps':

										add_action('admin_init', function()use( $restriction_config , $user_role ){

											foreach ($restriction_config as $key => $cap) {

												/* Check if Multi site */
												if( is_multisite() ) {

												    $role = get_role( $user_role );
												    $role->remove_cap( $cap );
												}

											}

										});


									break;

								case 'metaboxes':

										add_action('admin_init', function()use( $restriction_config ){

											add_action( 'add_meta_boxes', function()use( $restriction_config ){

												foreach ( $restriction_config as $key => $metabox ) {

													if( !$metabox['enable_flag']  )
													{
														remove_meta_box( $metabox['id'] , get_post_type() , $metabox['location'] );
													}

												}

											});

										});

									break;


								case 'screen_option':

										add_action('admin_init', function(){

											if( isset( $restriction_config['enable_flag'] ) )
											{
												if( $restriction_config['enable_flag'] == false )
												{
													add_filter('screen_options_show_screen',function(){ return false; });
												}
											}

										});


									break;

								case 'menus':


											foreach ( $restriction_config as $key => $menu_item ) {


												$author = wp_get_current_user();

												/* Remove menu */
												add_action('admin_menu',function()use( $menu_item ){
													remove_menu_page( $menu_item['link'] );
												});

												/* Restrict page visit */
												add_action( 'current_screen', function()use( $menu_item ){

													$screen = get_current_screen();
													$base = $screen->id;

													$pattern = '/^'.$base.'/';
													preg_match_all( $pattern , $menu_item['base'] , $matches );
													$matches = array_shift( $matches );

													if(  isset( $matches[0] ) )
													{
														if( $matches[0] == $base )
														{
															wp_die('This page is restricted');
														}

													}

												});

											}

									break;
							}

						}
					}
				}
			}


		/* call filters */
		$this->load_restrictions_filter();

 	}

	/* restriction filter function */
	function load_restrictions_filter(){

		$restriction_config = $this->get_user_role_restrictions();

		if( $restriction_config )
			{

				foreach ($restriction_config as $key => $restriction_config_item ) {

					$user_role = strtolower( $key );

					if( $user_role == DWH_USER_ROLE )
					{
						/* Restriction sections */
						foreach ($restriction_config_item as $key1 => $val1 ) {

							switch ( $key1 ) {

								case 'wp_default_editor':

										if( $val1 ){

											if( $val1['filter_data'] == 'html' ){
												$this->restrict_wpeditor( $val1, 'tinymce' );
											}

											elseif( $val1['filter_data'] == 'tinymce' ){
												$this->restrict_wpeditor( $val1, 'html' );
											}

										}

									break;

							}

						}
					}
				}
			}

	}


	function restrict_wpeditor( $filter, $data = '' ){

		if( $filter ){

			if( isset( $filter['filter_name'] ) ){
				add_filter( $filter['filter_name'], function() use( $data ){ return $data; });
			}

			add_action('admin_print_scripts', function() use( $filter ){
				$editor_html = "<script type='text/javascript'>\n";
				$editor_html .= 'var wp_default_editor = '. json_encode( $filter ) .';';
				$editor_html .= "\n</script>";
				echo $editor_html;

			});

		}

	}

 	function display_notice( $type , $message )
 	{
 		if( $type && $message )
 		{
 			$html = '<div class="'.$type.'">
			      	 	<p>'.$message.'</p>
			    	 </div>';

			return $html;
 		}

 	}

 	/* Gets user role restrictions config */
 	function get_user_role_restrictions()
 	{
 		$restriction_config = array();
 		$dir =  get_template_directory() . '/module/admin/config/config.restrictions.php';
 		if( file_exists( $dir ) )  $restriction_config = include( $dir );
 		return $restriction_config;
 	}


}
