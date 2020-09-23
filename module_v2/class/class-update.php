<?php
if( !class_exists( 'DWH_wponetheme_updater' ) )
{
	class DWH_wponetheme_updater
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
			add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_update' ) );
			add_filter( 'cron_schedules', array( $this, 'custom_cron_schedule' ) );

			add_action( 'admin_init', array( $this, 'scheduler' ) );
			add_action( 'wponetheme_update_event', array( $this, 'update' ) );

			add_action( 'load-update-core.php', array( $this, 'update' ) );
			add_action( 'load-update.php', array( $this, 'update' ) );
			add_action( 'load-themes.php', array( $this, 'update' ) );
		}

		public function custom_cron_schedule( $schedules ) {
	        $schedules['wponetheme_update_schedule'] = array(
	            'interval' => 60*60*8,
	            'display'  => __( 'Scheduled One Theme Update' ),
	        );
	        return $schedules;
		}

		public function scheduler()
		{
			if ( !wp_next_scheduled( 'wponetheme_update_event' ) ) {
				wp_schedule_event( strtotime("00:00:00"), 'wponetheme_update_schedule', 'wponetheme_update_event' );
			}
		}

		public function update()
		{
			$last_update 	= get_site_transient( 'update_themes' );
			$new_update 	= $this->check_update( $last_update );
			set_site_transient( 'update_themes', $new_update );
		}

		public function check_update( $transient )
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