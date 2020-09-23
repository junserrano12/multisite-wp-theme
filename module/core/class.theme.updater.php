<?php
if( !class_exists( 'DWH_onetheme_updater' ) )
{
	class DWH_onetheme_updater
	{
		protected $name;
		protected $version;

		public function __construct( $name, $version )
		{
			$this->name 		= $name;
			$this->version 		= $version;
			$this->initialize();
		}

		public function get_name()
		{
			return $this->name;
		}

		public function get_version()
		{
			return $this->version;
		}

		public function initialize()
		{
			add_filter( 'pre_set_site_transient_update_themes', array( $this, 'dwh_onetheme_check_update' ) );
			add_filter( 'cron_schedules', array( $this, 'dwh_onetheme_custom_cron_schedule' ) );

			add_action( 'admin_init', array( $this, 'dwh_onetheme_scheduler' ) );
			add_action( 'dwh_update_onetheme_event', array( $this, 'dwh_update_onetheme' ) );

			add_action( 'load-update-core.php', array( $this, 'dwh_update_onetheme' ) );
			add_action( 'load-update.php', array( $this, 'dwh_update_onetheme' ) );
			add_action( 'load-themes.php', array( $this, 'dwh_update_onetheme' ) );
		}

		public function dwh_onetheme_custom_cron_schedule( $schedules ) {
	        $schedules['dwh_update_onetheme_schedule'] = array(
	            'interval' => 60*60*8,
	            'display'  => __( 'Scheduled One Theme Update' ),
	        );
	        return $schedules;
		}

		public function dwh_onetheme_scheduler()
		{
			if ( !wp_next_scheduled( 'dwh_update_onetheme_event' ) ) {
				wp_schedule_event( strtotime("00:00:00"), 'dwh_update_onetheme_schedule', 'dwh_update_onetheme_event' );
			}
		}

		public function dwh_update_onetheme()
		{
			$last_update 	= get_site_transient( 'update_themes' );
			$new_update 	= $this->dwh_onetheme_check_update( $last_update );
			set_site_transient( 'update_themes', $new_update );
		}

		public function dwh_onetheme_check_update( $transient )
		{
			if ( property_exists( $transient, 'checked') ) {

				if ( $checked = $transient->checked ) {

					$info 			= $this->get_info();
					$out_of_date 	= version_compare( $info->version, $this->version, ">" );

					if( $out_of_date ) {

			            $theme_data = wp_get_theme();
			            $theme_slug = $theme_data->get_template();

			            $transient->response[$theme_slug] = array(
			                'new_version' 	=> $info->version,
			                'package' 		=> $info->package,
			                'url' 			=> $info->url,
			                'slug' 			=> $theme_slug
			            );
	        		}
				}
			}

	        return $transient;
		}

		public function get_info()
		{
			$url 			= 'http://releases.hotelhosting.co/dwh-onetheme/'.$this->name.'.json';
			$response 		= wp_remote_get( $url );
			$response_body 	= wp_remote_retrieve_body( $response );
		    $result 		= json_decode( $response_body, true );
		    $result 		= array_shift( $result );
		    return (object)$result;
		}
	}
}