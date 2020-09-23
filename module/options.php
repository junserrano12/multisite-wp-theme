<?php

	$config_migrate = array();

	/* Options Class */
	$dir = get_template_directory().'/module/core/class.options.php';
	if(file_exists($dir)) include( $dir );

	$DWH_Options = new DWH_Options();

	if( is_admin() )
	{
		$DWH_Options->load_options();
	}

	/* Enable Disable Analytics */
	$google_analytics_info = $DWH_Options->get_dwh_site_option_set('dwh_api_google_analytics',0);

	if( $google_analytics_info )
	{
		$google_analytics_info = (array)$google_analytics_info;
		$google_analytics_info = array_shift( $google_analytics_info );
	 	$ga_code = isset($google_analytics_info['ga_code']) && $google_analytics_info['ga_code']!='' ? $google_analytics_info['ga_code'] : '';
		$ga_code2 = isset($google_analytics_info['ga_code_2']) && $google_analytics_info['ga_code_2']!='' ? $google_analytics_info['ga_code_2'] : '';
		$uni_analytics = isset( $google_analytics_info['universal_analytics'] ) && $google_analytics_info['universal_analytics'] != 0 ? $google_analytics_info['universal_analytics'] : '';
		$uni_analytics_c1 = isset( $google_analytics_info['ua_analytics_code1'] ) && $google_analytics_info['ua_analytics_code1'] != '' ? $google_analytics_info['ua_analytics_code1'] : '';
		$uni_analytics_c2 = isset( $google_analytics_info['ua_analytics_code2'] ) && $google_analytics_info['ua_analytics_code2'] != '' ? $google_analytics_info['ua_analytics_code2'] : '';
		define('SERVICE_GA_ANALYTICS', $ga_code != '' ? true : false );
		define('SERVICE_U_ANALYTICS', ($uni_analytics_c1 != '' || $uni_analytics_c2 != '') && $uni_analytics != '' ? true : false );

	}
	else
	{
		define('SERVICE_GA_ANALYTICS', false );
		define('SERVICE_U_ANALYTICS', false );
	}


	/*
	* After Switch Theme
	* Load Default Option Sets
	*/
	add_action('after_switch_theme', function(){

		global $DWH_Options;
		$themesettingsdefault = get_dwh_option( 'dwh_theme_settings_default' );

		/*
		* checklist validation
		* if theme settings exists
		*/
		if( $themesettingsdefault ){

			/* load default settings */
			if( !$themesettingsdefault['enable_flag'] ){
				$DWH_Options->reset_option_sets();
				$DWH_Options->load_default_settings();

				update_option( 'dwh_theme_settings_default' , array( 'enable_flag' => 1 ) );
			}
		}

		/* if theme settings do not exists; set default value 0 */
		else{
			update_option( 'dwh_theme_settings_default' , array( 'enable_flag' => 0 ) );

			/* get default option */
			$themesettingsdefault = get_dwh_option( 'dwh_theme_settings_default' );

			/* load default option */
			if( $themesettingsdefault ){

				/* load default settings */
				if( !$themesettingsdefault['enable_flag'] ){

					$DWH_Options->reset_option_sets();
					$DWH_Options->load_default_settings();
					update_option( 'dwh_theme_settings_default' , array( 'enable_flag' => 1 ) );
				}
			}
		}

	});


	/* Add Permalink option  */
	update_option( 'dwh_option_permalink_flush' , array( 'enable_flag' => 0 ) );