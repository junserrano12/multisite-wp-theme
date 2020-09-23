<?php
if( !class_exists( 'DWH_wponetheme_init' ) )
{
	class DWH_wponetheme_init
	{
		public function __construct()
		{
			$this->load_Dependencies();
			$this->deregister_Scripts();

			$this->load_Scripts();
			$this->load_Styles();

			$this->load_Admin_Scripts();
			$this->load_Admin_Styles();

			$this->load_Actions();
			$this->load_Filters();
		}

		public function load_Dependencies()
		{
			require( dwh_get_main_directory().'/module_v2/functions/migrate.php' );
			require( dwh_get_main_directory().'/module_v2/functions/hooks.php' );
			require( dwh_get_main_directory().'/module_v2/functions/global.php' );
			require( dwh_get_main_directory().'/module_v2/functions/shortcodes.php' );
			require( dwh_get_main_directory().'/module_v2/functions/template.php' );

			require( dwh_get_main_directory().'/module_v2/functions/actions.php' );
			require( dwh_get_main_directory().'/module_v2/functions/filters.php' );
			require( dwh_get_main_directory().'/module_v2/functions/support.php' );

            require( dwh_get_main_directory().'/module_v2/functions/theme-options.php' );
            require( dwh_get_main_directory().'/module_v2/functions/custom-fields.php' );

		}

		public function deregister_Scripts()
		{
			add_action( 'wp', function() {
				if( !is_admin() ) {
					wp_deregister_script( 'jquery' );
					wp_deregister_script( 'jquery-migrate' );
				}
			} );
		}

		public function load_Scripts()
		{
			if( !is_admin() ) {

				$config_scripts = dwh_get_config('config.scripts', 'json');

				add_action( 'wp_enqueue_scripts', function() use ( $config_scripts ) {

					foreach ( $config_scripts as $script ) {
						if ( is_array( $script ) ) {
							$script = (object) $script;
						}

						$handle 		= isset( $script->handle ) ? $script->handle : false;
						$src 			= isset( $script->src ) ? $script->src : false;
						$deps 			= isset( $script->deps ) ? $script->deps : array();
						$ver 			= isset( $script->ver ) ? $script->ver : false;
						$in_footer 		= isset( $script->in_footer ) ? $script->in_footer : false;
						$has_comment	= isset( $script->has_comment ) ? $script->has_comment : false;
						$register_only 	= isset( $script->register_only ) ? $script->register_only : false;
						$parameter 		= isset( $script->parameter ) ? $script->parameter : false;

						if ( $parameter ) {
							$query_args = array();
							foreach ( $parameter as $param ) {
								$key     = isset( $param->key ) ? $param->key : false;
								$option  = isset( $param->option ) ? $param->option : false;
								$field   = isset( $param->field ) ? $param->field : false;
								$default = isset( $param->default ) ? $param->default : null;
								$value   = dwh_empty( dwh_get_data( $field, $option ) ) ? dwh_get_data( $field, $option ) : $default;
								$data    = isset( $param->data ) ? $param->data : false;
								$amp     = ( $param === end( $parameter ) ) ? "&" : null;

								if ( $key ) {
									/*single value in theme option*/
									$query_args[$key] = $value;
								} else {
									/*multiple value in single theme option*/
									foreach ( $data as $datavalue ) {
										$defaultval  = isset( $datavalue->default ) ? $datavalue->default : null;
										$subfieldval = isset( $value[$datavalue->name] ) ? $value[$datavalue->name] : $defaultval;
										$subfieldkey = isset( $datavalue->key ) ? $datavalue->key : false;
										$subfieldamp = ( $datavalue === end( $data ) ) ? "&" : null;

										if ( $subfieldkey ) {
											$query_args[$subfieldkey] = $subfieldval;
										}
									}
								}
							}
							$src = add_query_arg( $query_args, $src );
						}

						if ( $src ) {
							wp_register_script( $handle, $src, $deps, $ver, $in_footer );
							if ( !$register_only ) {
								wp_enqueue_script( $handle );
							}
						} else {
							if( $has_comment ) {
								if( is_singular() && comments_open() && get_option('thread_comments') ) {
									wp_enqueue_script( $handle );
								}
							} else {
								wp_enqueue_script( $handle );
							}
						}
					}

				}, 99 );

				add_filter( 'script_loader_tag', function( $tag, $handle ) {

					if ( $handle == 'html5shiv' ) {
						return '<!--[if lt IE 9]>'."\n".$tag.'<![endif]-->'."\n";
					} else if ( strpos( $handle, 'defer' ) ) {
						return str_replace( 'src', 'defer src', $tag );
					} else if ( strpos( $handle, 'async' ) ) {
						return str_replace( 'src', 'async src', $tag );
					} else {
						return $tag;
					}

				}, 10, 2 );

			}
		}

		public function load_Styles()
		{
			if ( !is_admin() ) {

				$config_styles = dwh_get_config('config.styles', 'json');

				add_action( 'wp_enqueue_scripts', function() use ( $config_styles ) {
					global $scss;

					$scss->registerFunction("get_template_directory_uri", function( $args ) {
						$protocol = ( is_ssl() || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) ? 'https://' : 'http://';
						$url = str_replace( site_url(), DWH_CDN_URL, get_template_directory_uri() );
						return $protocol.$url;
					});

					foreach ( $config_styles as $style ) {
						if ( is_array( $style ) ) {
							$style = (object) $style;
						}

						$handle 		= isset( $style->handle ) ? $style->handle : false;
						$src 			= isset( $style->src ) ? $style->src : false;
						$deps 			= isset( $style->deps ) ? $style->deps : array();
						$ver 			= isset( $style->ver ) ? $style->ver : false;
						$media			= isset( $style->media ) ? $style->media : 'all';
						$enqueue 		= isset( $style->enqueue ) ? $style->enqueue : true;
						$inline  		= isset( $style->inline ) ? $style->inline : false;
						$optioname 		= isset( $style->option ) ? $style->option : null;
						$fieldname 		= isset( $style->field ) ? $style->field : null;
						$register_only 	= isset( $style->register_only ) ? $style->register_only : false;
						$custom_page 	= isset( $style->custom_page ) ? $style->custom_page : false;

						if ( !$custom_page && ( !is_page_template() || is_front_page() ) ) {

							if ( $inline ) {

								$customstyle = dwh_get_data( $fieldname, $optioname );

								try {

									$customstyle = $scss->compile( $customstyle );
									$customstyle = dwh_css_compresion( $customstyle );
									wp_add_inline_style( $handle, $customstyle );

								} catch ( Exception $e ) {

									echo '<!--'.$e->getMessage().'-->'."\n";

								}

							} else {

								wp_register_style( $handle, $src, $deps, $ver, $media );

								if ( !is_admin() && $handle && $enqueue ) {
									if ( !$register_only ) {
										wp_enqueue_style( $handle );
									}
								}

							}

						} else if ( is_page_template( $custom_page.'.php') && $custom_page ) {

							wp_register_style( $handle, $src, $deps, $ver, $media );
							wp_enqueue_style( $handle );

							$customstyle = dwh_get_data( $custom_page.'-style' );

							try {

								$customstyle = $scss->compile( $customstyle );
								$customstyle = dwh_css_compresion( $customstyle );
								wp_add_inline_style( $custom_page, $customstyle );

							} catch ( Exception $e ) {

								echo '<!--'.$e->getMessage().'-->'."\n";

							}

						}
					}
				} );

				add_filter( 'style_loader_tag', function( $tag, $handle ) {
					global $wp_styles;
					global $DWH_wponetheme_styles;

					$isdeffered = dwh_empty( dwh_get_data( 'defer-stylesheet', 'onetheme_customizer_options') ) ? dwh_get_data( 'defer-stylesheet', 'onetheme_customizer_options') : false;

				   	if ( $DWH_wponetheme_styles ) {

				   		if ( ( strpos( $handle, 'plugin' ) || strpos( $handle, 'main' ) ) && $isdeffered  ) {
						    $style_tags = $wp_styles->query( $handle );
						    array_push( $DWH_wponetheme_styles->util_object, $style_tags->handle );
							return str_replace( 'href', 'data-href', $tag );
				   		} else {
				   			return $tag;
				   		}

					}

				}, 10, 2 );

				add_action( 'wp_head', function() {
					global $DWH_wponetheme_styles;
					if ( $DWH_wponetheme_styles ) {
						$style_objects = array( 'objects' => $DWH_wponetheme_styles->util_object );
						wp_localize_script( 'global', 'style_objects', $style_objects );
					}
				} );

				// add_action( 'wp_footer', function() {
				// 	$script = '';
				// 	$script .= '<script type=\'text/javascript\'>'."\n";
				// 	$script .= 'function loadDWHStyle(){'."\n";
				// 	$script .= '	if ( typeof style_objects !== "undefined" ) {'."\n";
				// 	$script .= '		JQ.each(style_objects.objects, function(key,val){'."\n";
				// 	$script .= '			_links = JQ(\'#\'+val+\'-css\');'."\n";
				// 	$script .= '			_links.attr( \'href\', _links.data(\'href\') );'."\n";
				// 	$script .= '		});'."\n";
				// 	$script .= '	}'."\n";
				// 	$script .= '}'."\n";
				// 	$script .= 'JQ(document).ready(function(){'."\n";
				// 	$script .= '	JQ(window).on(\'load\', function(){'."\n";
				// 	$script .= '		loadDWHStyle();'."\n";
				// 	$script .= '	});'."\n";
				// 	$script .= '});'."\n";
				// 	$script .= '</script>'."\n";
				// 	echo $script;
				// }, 99 );
			}
		}

		public function load_Admin_Scripts()
		{
			if( is_admin() ) {

				$config_scripts = dwh_get_config('config.admin.scripts', 'json');

				/* wp_enqueue_media */
				add_action( 'admin_enqueue_scripts', function() {

					if ( function_exists( 'wp_enqueue_media' ) ) {
						wp_enqueue_media();
					} else {
					    wp_enqueue_style( 'thickbox' );
					    wp_enqueue_script( 'media-upload' );
					    wp_enqueue_script( 'thickbox' );
					}

				} );

				add_action( 'admin_enqueue_scripts', function() use ( $config_scripts ) {

					foreach ( $config_scripts as $script ) {

						if ( is_array( $script ) ) {
							$script = (object) $script;
						}

						$handle 	= isset( $script->handle ) ? $script->handle : false;
						$src 		= isset( $script->src ) ? $script->src : false;
						$deps 		= isset( $script->deps ) ? $script->deps : array();
						$ver 		= isset( $script->ver ) ? $script->ver : false;
						$in_footer 	= isset( $script->in_footer ) ? $script->in_footer : false;

						if( $src ) {
							wp_register_script( $handle, $src, $deps, $ver, $in_footer );
							wp_enqueue_script( $handle );
						} else {
							wp_enqueue_script( $handle );
						}
					}

				});
			}
		}

		public function load_Admin_Styles()
		{
			if ( is_admin() ) {
				$config_styles = dwh_get_config('config.admin.styles', 'json');

				add_action( 'admin_enqueue_scripts', function() use ( $config_styles ) {

					foreach( $config_styles as $key => $style ) {

						if( is_array( $style ) ) {
							$style = (object) $style;
						}

						$handle 		= isset( $style->handle ) ? $style->handle : false;
						$src 			= isset( $style->src ) ? $style->src : false;
						$deps 			= isset( $style->deps ) ? $style->deps : array();
						$ver 			= isset( $style->ver ) ? $style->ver : false;
						$media			= isset( $style->media ) ? $style->media : 'all';

						wp_register_style( $handle, $src, $deps, $ver, $media );
						wp_enqueue_style( $handle );

					}
				} );
			}
		}

		public function load_Actions()
		{
			/* load parent theme actions */
			dwh_wponetheme_load_default_actions();
		}

		public function load_Filters()
		{

			dwh_wponetheme_load_default_filters();
		}
	}
}