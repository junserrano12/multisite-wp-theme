<?php
/*
Core Theme Class
*/
Class DWH_Theme
{
	public $page_styles;

	function load_menu_appearance($menu)
	{
		foreach ($menu as $key) {
			add_theme_support( ''.$key.'' );
		}
	}

	function get_site_theme_config()
	{
		global $DWH_Options;

		/* Get site info */
		$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);

		if( $site_info )
		{
			$site_theme_name = $site_info->site_theme;

			if( $site_theme_name )
			{
				$site_theme_config_dir =  get_template_directory() . '/module/themes/site/'.$site_theme_name.'/config.php';

				if( file_exists( $site_theme_config_dir ) )
				{
					$site_theme_config = include( $site_theme_config_dir );
					return $site_theme_config;
				}

			}
		}

	}

	function get_page_theme_config( $page_theme )
	{
		global $DWH_Options;

		if( $page_theme )
		{
			$theme_name = $page_theme;

			if( $theme_name )
			{
				$theme_config_dir =  get_template_directory() . '/module/themes/page/'.$theme_name.'/config.php';

				if( file_exists( $theme_config_dir ) )
				{
					$theme_config = include( $theme_config_dir );
					return $theme_config;
				}

			}
		}

	}

	function get_site_theme_list()
	{
		/* get site dir */
		$site_dir = get_template_directory() .'/module/themes/site/';
		$site_list = array();

		/* Check if site directory exists */
		if( file_exists( $site_dir ) ){
			$site_dir = scandir( $site_dir );

			/* Loop through the site directory */
			foreach( $site_dir as $site_name ){
				if( $site_name != '.' && $site_name != '..' ){
					array_push( $site_list, $site_name );
				}
			}

		}

		return $site_list;

	}

	/* cache buster */
	function cache_buster()
	{
		$site_global_cb_dir = get_template_directory().'/config/config.cache.buster.php';
		if(file_exists($site_global_cb_dir)) $config_cb = include($site_global_cb_dir);
		$cacheBust = isset($config_cb['cb']) ? '.'.$config_cb['cb'] : '';

		/*DEBUG*/
		// $date = new DateTime();
		// $cacheBust = '.'.$date->getTimestamp();

		return $cacheBust;
	}

	/* CDN */
	function cdn_theme_path()
	{
		$site_global_cdn_dir = get_template_directory().'/config/config.cdn.php';
		if(file_exists($site_global_cdn_dir)) $config_cdn = include($site_global_cdn_dir);
		$cdnpath = isset($config_cdn['cdnthemepath']) ? $config_cdn['cdnthemepath'] : '';

		return $cdnpath;
	}

	function cdn_paths()
	{
		$site_global_cdn_dir = get_template_directory().'/config/config.cdn.php';
		if(file_exists($site_global_cdn_dir)) $config_cdn = include($site_global_cdn_dir);
		$cdnpath = isset($config_cdn['cdnpath']) ? $config_cdn['cdnpath'] : '';

		return $cdnpath;
	}

	function relative_paths()
	{
		$site_global_cdn_dir = get_template_directory().'/config/config.cdn.php';
		if(file_exists($site_global_cdn_dir)) $config_cdn = include($site_global_cdn_dir);
		$relativepath = isset($config_cdn['relativepath']) ? $config_cdn['relativepath'] : '';

		return $relativepath;
	}

	function cdn_url()
	{
		$site_global_cdn_dir = get_template_directory().'/config/config.cdn.php';
		if(file_exists($site_global_cdn_dir)) $config_cdn = include($site_global_cdn_dir);
		$cdnurl = isset($config_cdn['cdnurl']) ? $config_cdn['cdnurl'] : '';

		return $cdnurl;
	}

	function cdn_pattern()
	{
		$site_global_cdn_dir = get_template_directory().'/config/config.cdn.php';
		if(file_exists($site_global_cdn_dir)) $config_cdn = include($site_global_cdn_dir);
		$cdnpattern = isset($config_cdn['cdnpattern']) ? $config_cdn['cdnpattern'] : '';

		return $cdnpattern;
	}

	function cdn_enable()
	{
		$site_global_cdn_dir = get_template_directory().'/config/config.cdn.php';
		if(file_exists($site_global_cdn_dir)) $config_cdn = include($site_global_cdn_dir);
		$cdnenable = isset($config_cdn['cdnenable']) ? $config_cdn['cdnenable'] : false;

		return $cdnenable;
	}

	/*
	Loads Site fonts to the header
	*/
	function header_site_fonts()
	{
		$fonts_dir = get_template_directory() . '/fonts/';
		$fonts_url = get_template_directory_uri() . '/fonts/';

		if(!is_admin())
		{

			if( DWH_SSL == true )
			{
				$fonts_url = get_template_directory_uri() . '/fonts/';
				$fonts_url = $this->http_to_https( $fonts_url );
			}

			if(file_exists($fonts_dir))
			{

				global $DWH_Options;
				$theme_fonts = $DWH_Options->get_dwh_site_option_set('dwh_fonts_internal');

				if( count( $theme_fonts ) > 0 )
				{

					add_action('wp_enqueue_scripts',function() use ( $fonts_url, $theme_fonts ){

						if(!empty( $theme_fonts ))
						{
							/* Register Font Style */
							foreach ($theme_fonts as $font ) {

								$font_src = $fonts_url . $font['font_name']. '/' .$font['font_name'] .'.min'.$this->cache_buster().'.css';
								wp_register_style( 'font-' .$font['font_name'] , $font_src );
								wp_enqueue_style( 'font-' .$font['font_name'] , $font_src );
							}

						}

					});

				}

			}

		}

	}

	/* Loads Site Metadata to the header */
	function header_meta_data()
	{
		$dir = get_template_directory() . '/module/meta/';

		if(file_exists($dir))
		{
			/* Load Meta data */
			$dir_scan = scandir( $dir );

			if(!is_admin())
			{
				foreach($dir_scan as $dir_item)
				{
					if($dir_item!='.'&& $dir_item!='..')
					{
						include( $dir . $dir_item );
					}
				}

			}
		}

	}

	/* Loads Site headerlinks to the header */
	function header_links()
	{
		$dir = get_template_directory() . '/module/link/';

		if(file_exists($dir))
		{
			/* Load Meta data */
			$dir_scan = scandir( $dir );

			if(!is_admin())
			{
				foreach($dir_scan as $dir_item)
				{
					if($dir_item!='.'&& $dir_item!='..')
					{
						include( $dir . $dir_item );
					}
				}
			}

		}

	}

	/* Loads Site css to the header */
	function header_site_styles()
	{
		$site_styles_global_dir = get_template_directory().'/config/config.styles.global.php';
		$site_styles_global_config = array();
		if(file_exists($site_styles_global_dir)) $site_styles_global_config = include($site_styles_global_dir);

		$cacheBust = $this->cache_buster() != '' ? $this->cache_buster() : '.';

		if( !is_admin() ){

			add_action('wp_enqueue_scripts',function() use( $site_styles_global_config, $cacheBust ){
				foreach ($site_styles_global_config as $key) {

					if( DWH_SSL == true )
					{
						wp_enqueue_style( 'site-' . $key['handle'], substr($this->http_to_https( $key['src'] ),0,-4).$cacheBust.'.css', array(), '', 'all');
					}

					else
					{
						wp_enqueue_style( 'site-' . $key['handle'], substr($key['src'],0,-4).$cacheBust.'.css', array(), '', 'all');
					}

				}

			});

		}

	}

	/*  Loads Site js scripts to the header */
	function header_site_scripts()
	{

		$site_scripts_global_dir = get_template_directory().'/config/config.scripts.global.php';
		$config_scripts = array();
		$config_cb = array();
		if(file_exists($site_scripts_global_dir)) $config_scripts = include($site_scripts_global_dir);

		$cacheBust = $this->cache_buster() != '' ? $this->cache_buster() : '.';

		if( !is_admin() ){
			/* deregister wordpress jquery */
			wp_deregister_script('jquery');

			add_action('wp_enqueue_scripts',function() use( $config_scripts, $cacheBust ){

				foreach ($config_scripts as $key) {
					switch ( $key['type'] ) {
						case 'api':
								wp_register_script($key['handle'],$key['src'].'.js',$key['deps'],$key['ver'],$key['in_footer']);
								wp_enqueue_script($key['handle'],$key['src'].'.js',$key['deps'],$key['ver'],$key['in_footer']);
							break;

						case 'local':
								if( DWH_SSL == true )
								{
									wp_register_script($key['handle'], $this->http_to_https( substr($key['src'],0,-3).$cacheBust.'.js' ) ,$key['deps'],$key['ver'],$key['in_footer']);
									wp_enqueue_script($key['handle'], $this->http_to_https( substr($key['src'],0,-3).$cacheBust.'.js' ) ,$key['deps'],$key['ver'],$key['in_footer']);
								}
								else{
									wp_register_script($key['handle'],substr($key['src'],0,-3).$cacheBust.'.js',$key['deps'],$key['ver'],$key['in_footer']);
									wp_enqueue_script($key['handle'],substr($key['src'],0,-3).$cacheBust.'.js',$key['deps'],$key['ver'],$key['in_footer']);
								}
							break;
						default:
								/* Wordpress script library */
								wp_enqueue_script($key['handle']);
							break;
					}

				}
			});

		}

	}

	/* Loads Site dynamic scripts - .php extension */
	function header_site_dynamic_scripts()
	{
		$site_scripts_global_dir = get_template_directory().'/config/config.scripts.dynamic.global.php';
		$config_scripts = array();
		if(file_exists($site_scripts_global_dir)) $config_scripts = include($site_scripts_global_dir);

		foreach ($config_scripts as $key) {

			if(file_exists( $key['src'] ))
			{
				if( $key['in_footer'] == true )
				{
					 add_action('wp_footer',function() use($key){
					 	include( $key['src'] );
					 });
				}
				else
				{
					include( $key['src'] );
				}
			}
		}

	}

	/* Loads Site theme css to the header
	@site_info - site details
	@style_name - name of the file or style to load
 	*/
	function header_site_theme_add_style( $site_info , $style_name )
	{
		if( $site_info && $style_name )
		{
			$dir = DWH_SITE_THEME_DIR . 'site/' . $site_info->site_theme . '/css/' . $style_name . '.min.css';
			$cacheBust = $this->cache_buster() != '' ? $this->cache_buster() : '.';

			if( file_exists( $dir ))
			{
				$handle = $style_name;
				$src = DWH_SITE_THEME_URI . 'site/' . $site_info->site_theme . '/css/' . $style_name . '.min'.$cacheBust.'.css';

				if( DWH_SSL == true )
				{
					$src = $this->http_to_https( $src );
				}

				add_action('wp_enqueue_scripts',function() use ( $handle , $src ){
					wp_enqueue_style('site-theme-'. $handle , $src );
				});
			}
		}

	}

	/* Loads Site theme scripts to the header
	@param (array) - $site_info - site details
	*/
	function header_site_theme_add_scripts( $site_info )
	{
		if( $site_info )
		{
			$dir = DWH_SITE_THEME_DIR . '/site/' . $site_info->site_theme . '/js';

			if(file_exists($dir))
			{
				$dir_scan = scandir($dir);

				$cacheBust = $this->cache_buster() != '' ? $this->cache_buster() : '.';

				foreach($dir_scan as $dir_val)
				{
					if( $dir_val!='.' && $dir_val!='..' && strpos($dir_val, '.min.') )
					{
						$file_name = explode('.min.',$dir_val);
						$handle	= $file_name[0];
						$script_ext = $file_name[1];
						$src = DWH_SITE_THEME_URI . 'site/' . $site_info->site_theme . '/js/' . $handle. '.min'.$cacheBust.'.'.$script_ext;

						if( DWH_SSL == true  )
						{
							$src = $this->http_to_https( $src );
						}

						switch ( $script_ext ) {

							case 'js':

									add_action('wp_enqueue_scripts',function() use ( $handle , $src ){
										wp_enqueue_script( 'site-theme-' . $handle , $src, false );
									});

								break;

						}
					}

				}
			}

		}

	}

	/*
	Loads a page theme file
	@param (string) - name of style to load
	@param (string) - page theme to load
	*/
	function get_page_theme_part( $page_theme , $name , $data = null )
	{
		if( $page_theme )
		{
			$page_theme_dir = DWH_SITE_THEME_DIR . 'page/' . $page_theme;

			if( file_exists( $page_theme_dir ))
			{
				$page_theme_file = $page_theme_dir . '/' . $name . '.php';
				$response = false;
				if( file_exists( $page_theme_dir )) $response = true;
				if( file_exists( $page_theme_file )) $response = true;
				if( $response  == true ) include( $page_theme_file );
			}
		}

	}

	/* Loads page theme css to the header
	@page_theme - name of theme to load from
	@style_name - name of the file or style to load
	*/
	function header_page_theme_add_style( $page_theme , $style_name )
	{
		if( !is_admin() )
		{

			if( $page_theme && $style_name )
			{
				$dir = DWH_SITE_THEME_DIR . 'page/' . $page_theme . '/css/' . $style_name . '.css';
				$cacheBust = $this->cache_buster() != '' ? $this->cache_buster() : '.';

				if( file_exists( $dir ) )
				{
					$handle = $style_name;
					$src = DWH_SITE_THEME_URI . 'page/' . $page_theme . '/css/' . $style_name . '.min'.$cacheBust.'.css';

					if( DWH_SSL == true )
					{
						$src = $this->http_to_https( $src );
					}

					add_action('wp_enqueue_scripts',function() use ( $handle , $src ){
						wp_enqueue_style('page-theme-'. $handle , $src );
					});
				}

			}

		}

	}


	/* Loads page theme scripts to the header
	@param (array) - $page_theme - name of theme to load from
	*/
	function header_page_theme_add_scripts( $page_theme )
	{
		$dir = DWH_SITE_THEME_DIR . '/site/' . $page_theme . '/js';

		if( !is_admin() )
		{
			if(file_exists($dir))
			{
				$dir_scan = scandir($dir);
				$cacheBust = $this->cache_buster() != '' ? $this->cache_buster() : '.';

				foreach($dir_scan as $dir_val)
				{
					if($dir_val!='.'&& $dir_val!='..' && strpos($dir_val, '.min.'))
					{
						$file_name = explode('.min.',$dir_val);
						$handle	= $file_name[0];
						$script_ext = $file_name[1];
						$src = DWH_SITE_THEME_URI . 'site/' . $page_theme . '/js/' . $handle. '.min'. $cacheBust . '.' . $script_ext;

						if( DWH_SSL == true )
						{
							$src = $this->http_to_https( $src );
						}

						switch ( $script_ext ) {

							case 'js':

									add_action('init', function() use( $handle, $src ){

										wp_register_script( 'page-theme-script-'. $handle, $src );
										wp_enqueue_script( 'page-theme-script-'. $handle );

									});

								break;

						}
					}

				}
			}
		}

	}

	/* Loads or creates site theme default pages */
	function load_default_pages( $site_theme_config )
	{
		add_action('init' , function() use( $site_theme_config ){

			if( $site_theme_config){
				$site_category = isset( $site_theme_config['details']['category'] ) ? $site_theme_config['details']['category'] : '';
				$page_view_dir = get_template_directory() . '/module/collections/views/default-site-pages/'.$site_category . '/';
				$page_view_dir = strtolower( $page_view_dir );

				if( array_key_exists( 'pages' , $site_theme_config ))
				{
					$pages =  $site_theme_config['pages'];

					if( $pages )
					{
						foreach ( $pages as $key => $page ) {

							if( $page )
							{
								if ( !get_page_by_title( $page, 'OBJECT', 'page') ){

									$page_content = "";

									if( file_exists( $page_view_dir ) )
									{
										$filename = strtolower( $page_view_dir . $page . '.php' );

										if( file_exists( $filename  ) ){
											$page_content = file_get_contents( $filename );
										}
									}

									$new_page = array(
										'menu_order' => $key,
										'post_title' => $page,
										'post_status' => 'publish',
										'post_date' => date('Y-m-d H:i:s'),
										'post_type' => 'page',
										'comment_status' => 'closed',
										'page_template' => ($page === 'Home') ? 'page-home.php' : '',
										'post_content'  => $page_content
									);

									wp_insert_post($new_page);
								}
							}

						}
					}
				}

			}

		});

	}

	/* Register nav menu locations */
	function register_nav_menu_location( $locations )
	{

		if( $locations ) register_nav_menus( $locations );

	}

	/* Unregister nav menu location */
	function unregister_nav_menu_location( $locations )
	{
		if( is_array( $locations ) ){

			foreach( $locations as $key => $value ){
				if ( is_nav_menu( $value ) ) {
					wp_delete_nav_menu( $value );
				}
			}
		}

	}

	/* Loads or creates site theme default menus */
	function load_default_menu( $site_theme_config )
	{
		add_action('init' , function() use( $site_theme_config ){

			$locations = array(
				'primary' => __('Primary Menu', 'primary'),
				'secondary' => __('Secondary Menu', 'secondary')
			);

			/* register nav menu */
			$this->register_nav_menu_location( $locations );

			/* add menu items to menu location */
			if( $site_theme_config){

				if( isset( $site_theme_config['menu'] ) ){

					$menus =  $site_theme_config['menu'];

					foreach( $locations as $key => $value ){

						$menu_name = $value;
						$menu_location = $key;
						$menu_exists = wp_get_nav_menu_object( $menu_name );
						$menu_id = "";
						$menu_item_id = 0;
						$pagetitles = array();

						if( !$menu_exists ){

							$menu_id = wp_create_nav_menu( $menu_name );

							if( isset( $menus[ $menu_location ] ) ) $pagetitles = $menus[ $menu_location ];

							foreach( $pagetitles as $pagekey => $pagetitle ){
								if( $pagetitle == 'Reservation' ) {
									wp_update_nav_menu_item( $menu_id, 0, array(
									'menu-item-title' =>  $pagetitle,
									'menu-item-classes' => 'ctareservation',
									'menu-item-status' => 'publish'));

								}else{
									wp_update_nav_menu_item( $menu_id, 0, array(
									'menu-item-title' => $pagetitle,
									'menu-item-object' => 'page',
									'menu-item-object-id' => get_page_by_path( strtolower($pagetitle) )->ID,
									'menu-item-type' => 'post_type',
									'menu-item-status' => 'publish'));
								}
							}
						}
					}
				}

				/*Set default menu locations*/
				$menulocations = get_theme_mod( 'nav_menu_locations');
				$menus = wp_get_nav_menus();

				$menu_obj = (array)($menus);

				foreach ( $menu_obj as $key => $value ){

					if( $value->name == 'Primary Menu' )
					{
						$menulocations['primary'] = $value->term_id;
					}
					else if( $value->name == 'Secondary Menu' )
					{
						$menulocations['secondary'] = $value->term_id;
					}

				}

				set_theme_mod( 'nav_menu_locations', $menulocations );

			}

		});

	}

	function reset_default_menu()
	{

		$locations = array(
			'primary' => __('Primary Menu', 'primary'),
			'secondary' => __('Secondary Menu', 'secondary')
		);

		/* unregister nav menu */
		return $this->unregister_nav_menu_location( $locations );

	}

	function is_ssl()
	{

		if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ){

			define( 'DWH_SSL', true );
		}
		else
		{
			define( 'DWH_SSL', false );
		}

	}

	function http_to_https( $url )
	{
		if( $url )
		{
			return str_replace('http://', 'https://', $url );
			/* return preg_replace('|^http://|', 'https://', $url ); */
		}

	}

	/* Loads a dynamic css style */
	function add_dynamic_css( $handle , $filename , $style_param = null )
	{

		if( $handle && $filename )
		{
			$dir 		= get_template_directory() . '/module/dynamic-css/'.$filename.'.php';
			$src 		= get_template_directory_uri() . '/module/dynamic-css/'.$filename.'.php';

			if( $style_param )
			{
				$count = 0;

				foreach ($style_param as $key => $value ) {

					if( $count == 0 ) {
						$src .= '?'.$key.'=' . $value;
					}
					else{
						$src .= '&'.$key.'=' . $value;
					}

					$count++;
				}

			}

			if( file_exists( $dir ) )
			{
				add_action('wp_enqueue_scripts',function()use( $handle , $src ){

					if( DWH_SSL == true ){
						$src = $this->http_to_https( $src );
					}

					wp_enqueue_style( $handle , $src );

				});
			}

		}

	}

	function siteCustomScript( $arr, $location )
	{
		$ct = count($arr);
		$pageTitle = get_the_title();
		if( $ct > 0 && is_array($arr) ){
			foreach($arr as $key=>$arrVal){
				$scriptLocation    = $arr[$key]['cscript_location'];
				$scriptDisplayPage = $arr[$key]['cscript_display_to'];
				$scriptDisplayPage = explode(',',$scriptDisplayPage);
				if($scriptLocation == $location && in_array($pageTitle,$scriptDisplayPage)){
					echo "\n";
					echo $arr[$key]['custom_script'];
					echo "\n";
				}elseif($scriptLocation == $location && $scriptDisplayPage[0] == 'All Pages'){
					echo "\n";
					echo $arr[$key]['custom_script'];
					echo "\n";
				}
			}
		}
	}

	/* ====================================== */
	/*DEPRICATED*/
	/* ====================================== */

	/* Load theme view
	@type - type of theme under module/themes
	@theme_name - name of theme under module/themes
	*/
	function header_theme_views( $type , $theme_name , $view , $data = null )
	{
		if( $type && $theme_name )
		{
			$dir = DWH_SITE_THEME_DIR . $type . '/' . $theme_name . '/views/'. $view . '.php';
			if( file_exists( $dir )) include( $dir );
		}

	}

	/*add style sheet for the active skeleton theme*/
	function header_site_theme_template_add_styles( $site_info )
	{

		$theme_style_dir = DWH_SITE_THEME_DIR . $default_style . '/css';

		if(file_exists($theme_style_dir))
		{
			$theme_style_dir_scan = scandir($theme_style_dir);

			foreach($theme_style_dir_scan as $style)
			{
				if($style!='.'&& $style!='..')
				{
					$style_arr = explode('.',$style);
					$handle	= $style_arr[0];
					$style_ext = $style_arr[1];
					$src = DWH_SITE_THEME_URI . $default_style . '/css/' . $handle. '.' . $style_ext;

					switch ($style_ext) {

						case 'css':
								add_action('wp_enqueue_scripts',function() use ($handle,$src){
									wp_enqueue_style('theme-'.$handle.'-style',$src);
								});

							break;

					}
				}

			}
		}

	}


	/* Loads Site theme css to the header
	@param (array) - $site_info - site details
	*/
	function header_site_theme_add_styles( $site_info )
	{

		if( $site_info )
		{
			$dir = DWH_SITE_THEME_DIR . 'site/' . $site_info->site_theme . '/css';

			if( file_exists( $dir ))
			{
				$dir_scan = scandir($dir);

				foreach($dir_scan as $dir_val)
				{
					if($dir_val!='.'&& $dir_val!='..')
					{
						$file_name = explode('.css', $dir_val);
						$handle = $file_name[0];
						$src = DWH_SITE_THEME_URI . 'site/' . $site_info->site_theme . '/css/' . $dir_val;

						if( DWH_SSL == true )
						{
							$src = $this->http_to_https( $src );
						}

						add_action('wp_enqueue_scripts',function() use ( $handle , $src ){
							wp_enqueue_style('site-theme-'. $handle , $src );
						});

					}

				}
			}

		}

	}

	/* Prints an line site dynamic css -  from the site options
	   @site_info - site details
	   @render_type - render type of the css code block
	   @style_name - name of the site style indexed
	*/
	function header_site_dynamic_css( $render_type = null , $site_info , $style_name )
	{
		$css_custom = "";

		if( $site_info )
		{

			$site_info = (array)$site_info;

			if( $style_name )
			{
				if( isset( $site_info[$style_name] ) )
				{
					$css_custom	 .= $site_info[$style_name] !='' ? $site_info[$style_name] : '';
				}
			}


			if( trim($css_custom)!="" )
			{
				$style_set	 = "<style>";
				$style_set	.= $css_custom;
				$style_set	.= "</style>";

				if( $render_type )
				{
					switch ( $render_type ) {

						case 'page':

								add_action('wp_head',function()use($style_set){
									echo $style_set;
								});

							break;

						case 'site':

								echo $style_set;

							break;

					}
				}
				else
				{
					echo $style_set;
				}



			}

		}

	}

	/*
	Loads a site theme file
	@param (string) - name of style to load
	@param (string) - page theme to load
	*/
	function get_site_theme_part( $site_theme , $name , $data = null )
	{
		if( $site_theme )
		{
			$site_theme_dir = DWH_SITE_THEME_DIR . 'site/' . $site_theme;

			if( file_exists( $site_theme_dir ))
			{
				$site_theme_file = $site_theme_dir . '/' . $name . '.php';
				$response = false;
				if( file_exists( $site_theme_dir )) $response = true;
				if( file_exists( $site_theme_file )) $response = true;
				if( $response  == true ) include( $site_theme_file );
			}
		}

	}

	/* Loads page theme css to the header
	@param (array) - $page_theme - name of theme to load from
	*/
	function header_page_theme_add_styles( $page_theme )
	{

		$dir = DWH_SITE_THEME_DIR . 'page/' . $page_theme . '/css';
		$dir_scan = scandir($dir);

		if( !is_admin() )
		{
			foreach($dir_scan as $dir_val)
			{
				if($dir_val!='.'&& $dir_val!='..')
				{
					$file_name = explode('.css', $dir_val);
					$handle = $file_name[0];
					$src = DWH_SITE_THEME_URI . 'page/' . $page_theme . '/css/' . $dir_val;

					if( DWH_SSL == true )
					{
						$src = $this->http_to_https( $src );
					}

					add_action('wp_enqueue_scripts',function() use ( $handle , $src ){
						wp_enqueue_style('page-theme-'. $handle , $src );
					});

				}

			}
		}

	}

	/* Prints an line page dynamic css -  from the page settings
   @page_info - page details
   @style_name - name of the site style indexed
	*/
	function header_page_dynamic_css( $page_info , $style_name )
	{
		$css_custom = "";

		if( $page_info )
		{
			if( $style_name )
			{
				if( isset( $page_info[$style_name] ) )
				{
					$css_custom	 .= $page_info[$style_name] !='' ? $page_info[$style_name] : '';
				}
			}

			if( trim($css_custom)!="" )
			{
				add_action('wp_head',function()use( $css_custom ){

					$css_print	= "<style>";
					$css_print	.= "/*"."Page Theme CSS"."*/";
					$css_print	.= $css_custom;
					$css_print	.= "</style>";
					echo $css_print;

				});
			}

		}
	}

	/* Load theme styles per type and theme name
	   under their css folders
	@type - type of theme under module/themes
	@theme_name - name of theme under module/themes
	*/
	function header_theme_styles( $type , $theme_name )
	{
		if( $type && $theme_name )
		{
			$dir = DWH_SITE_THEME_DIR . $type . '/' . $theme_name . '/css/';

			if( file_exists($dir) )
			{
				$scan_dir = scandir( $dir );

				foreach ( $scan_dir as $key => $dir_item ) {

					if( $dir_item!='..' && $dir_item!='.' )
					{
						$css_name = explode( '.css' , $dir_item );
						$handle = $type.'-'.$theme_name.'-'.$css_name[0];
						$src 	= DWH_SITE_THEME_URI . $type . '/' . $theme_name . '/css/' . $dir_item;

						wp_register_style( $handle , $src , false );
						wp_enqueue_style( $handle , $src , false );

					}
				}
			}
		}

	}

/*end of class*/
}



/*end of file*/
?>