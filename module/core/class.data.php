<?php
/*
Function: Core Data Class
*/
Class DWH_Data
{	

	public $view;

	public function __construct(){

	}

	function get_hotel_address( $address_type , $is_contact_info = null , $data = null )
	{
		global $DWH_Options;

		$hotel_info = $DWH_Options->get_dwh_site_option_field('dwh_hotels', 0);
		$hotel_address = $DWH_Options->get_dwh_site_option_set_by_field_name('dwh_hotel_address','dwh_hotels_id',0);
		$hotel_contact = $DWH_Options->get_dwh_site_option_set_by_field_name('dwh_hotel_contact','dwh_hotels_id',0);

		if( $address_type == "block" )
		{
			$this->view = 'widget_address_text_block';
		}
		else if( $address_type == "inline" )
		{
			$this->view = 'widget_address_text_inline';
		}

		$data['dir']  = array('module/widgets','widget_address_text','views');
		$data['view'] = $this->view;
		
		$data['is_contact_info'] = $is_contact_info;
		$data['hotel_info'] = $hotel_info;
		$data['hotel_address'] = $hotel_address;

		if( $is_contact_info == true )
		{
			$data['hotel_contact'] = $hotel_contact;
		}
		
		load_view( $data );

	}
 
	/* Displays a collection of links within a specified view
	@param (string) - $view - name of the link
	@param (string) - $category - link category so link types are filtered
	@param (array)  - $data - option data array
	*/
	function get_links( $view , $category, $data = null )
	{
		global $DWH_Options;
		$data['link_collection'] = $DWH_Options->get_option_set_data('dwh_links' );
		$data['dir'] = array('module/widgets', $view , 'views');
		$data['view'] = $view;
		load_view( $data );

	}
	
	/* 
	* Render Widget
	* @param (string) - $view - name of view
	* @param (string) - $data - option data array with widget name
	*/
	function get_widget( $view, $data = null ){
		
		$widget_name = isset( $data['name'] ) ? $data['name'] : '';

		if( $widget_name ){
			
			$widget_name_dir =  get_template_directory() . '/module/widgets/'. $widget_name;		
			if( file_exists( $widget_name_dir ) ){
				$data['atts'] = $data;		
				$data['dir'] = array('module/shortcodes/dynamic', $view , 'views');
				$data['view'] = $view;
				load_view( $data );
			}
		}
		
	}
	
	/* 
	* Render slider
	*/
	function get_slider(){
		
		global $DWH_Slider;
		
		/* get sldier data */
		$param = $this->get_slider_data();
		
		/* get slider info */
		$data = $this->get_slider_info( $param );
		
		/* call render slider */
		$DWH_Slider->render( $data );
		
	}
	
	
	/* 
	* get slider data
	*/
	function get_slider_data(){
		
		global $DWH_Slider, $post;
		
		$param = array();
		$slider_name = 'flexslider';
		$slider_mode = 'site';
		$post_id = '';
		
		/* get post id */
		if( $post ) $post_id = $post->ID;
		
		/* 1st Priority - get post data */
		$slider_post_data = array();
		$slider_post_arr = get_post_meta( $post_id, 'slider', true );
		
			if( is_array( $slider_post_arr ) ){
				$slider_post_data = $slider_post_arr[0];
				/* prepare slider properties */
				$slider_mode = $slider_post_data['slider-mode'][0];
				$slider_name = $slider_post_data['slider-name'][0];
			
			}
			
			
		/* check slider mode */
		$slider_option_data = array();
		if( $slider_mode == 'site' ){
		
			/* get option data */
			$slider_options_arr = get_dwh_option( 'dwh_slider' );
			
			/* get proper slider data from options */		
			if( is_array( $slider_options_arr ) ){
				
				/* first store slider data */
				$slider_option_data = unserialize( $slider_options_arr[0]['slider-data'] );
				
				/* remove slider data */
				unset( $slider_options_arr[0]['slider-data'] );
				
				foreach( $slider_options_arr[0] as $key => $val ){
					
					$slider_option_data[ $key ] = array();
					array_push( $slider_option_data[ $key ], $val );
					
					if( $key == 'slider-name' ) $slider_name = $val;
				}
			}
		}
		
		$param['slider_post_data'] = $slider_post_data;
		$param['slider_option_data'] = $slider_option_data;
		$param['slider_mode'] = $slider_mode;
		$param['slider_name'] = $slider_name;
		
		return $param;
	
	}
	
	/* 
	* get slider info
	*/
	function get_slider_info( $data ){
	
		global $DWH_Options, $DWH_Theme;
		extract( $data );
		
		/* Get site info */
		$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0 );
		/* Get map info */
		$map_info = (array) $DWH_Options->get_dwh_site_option_field( 'dwh_api_google_map',0 );
		
		/* Slider default banner */
		$banner_id = isset( $site_info->banner_id ) ? $site_info->banner_id : '';
		
		if( isset( $banner_id ) && $banner_id!='' ){
			$banner_media = array(
								'full' => wp_get_attachment_image_src($banner_id, 'full')[0],
								'small' => wp_get_attachment_image_src($banner_id, 'small-thumbnail-image')[0],
								'medium' => wp_get_attachment_image_src($banner_id, 'medium-thumbnail-image')[0],
								'large' => wp_get_attachment_image_src($banner_id, 'large-thumbnail-image')[0],
							);
							
		}
		else{
			
			/* Get theme info */
			$theme_info = $DWH_Theme->get_site_theme_config();
			$full_image = get_template_directory_uri() .'/images/banner.jpg';
			
			if( $theme_info['details']['category'] == 'AW' )
				$full_image = get_template_directory_uri() .'/images/banner-620x420.jpg';
		
			$banner_media = array(
								'full' => $full_image,
								'small' => get_template_directory_uri() .'/images/banner-40x40.jpg',
								'medium' => get_template_directory_uri() .'/images/banner-150x150.jpg',
								'large' => get_template_directory_uri() .'/images/banner-150x150.jpg',
							);
		}
		
		$slider_type = 'default';
		
		/* check global and page level slider data */
		if( $slider_post_data OR $slider_option_data ){
			
			/* page level */
			if( $slider_mode == 'page' ){
			
				if( $slider_post_data ){
					$slider_type = $slider_post_data['slider-type'][0];
					/* check for types */
					if( $slider_type == 'Default Slider' OR $slider_type == 'Bullet Slider' )
						$slider_type = 'bullet';
					else
						$slider_type = 'thumbnail';
						
					$data['sliderdata'] = $slider_post_data;
				}
			}	
				
			/* site level */
			else{
				
				if( isset( $slider_option_data['slider-item-type'] ) ){
					$slider_type = $slider_option_data['slider-type'][0];
					/* check for types */
					if( $slider_type == 'Default Slider' OR $slider_type == 'Bullet Slider' )
						$slider_type = 'bullet';
					else
						$slider_type = 'thumbnail';
					
					$data['sliderdata'] = $slider_option_data;
				}
			}
		
		}
		
		/* prepare load view data */
		$data['sliderdata']['default_image_src'] = $banner_media;
		$data['sliderdata']['map'] = $map_info;
		$data['type'] = $slider_name;
		$data['dir'] = array('module/sliders', $slider_name, 'views');
		$data['view'] = $slider_type;
		
		return $data;
	
	}
	
	
	function get_cta_config()
	{
		
		$cta_config_dir =  get_template_directory() . '/module/cta/config.php';

		if( file_exists( $cta_config_dir ) )
		{
			$cta_config = include( $cta_config_dir );	
			return $cta_config;
		}

	}

	/* Displays a cta button
	@param (array) - $param - cta button parameters
	*/
	function get_cta( $data )
	{

		if( $data ){
			
			extract( $data );
			global $DWH_Options;

			$cta_settings 					= isset( $data['cta_settings'] ) ? $data['cta_settings'] : array();
			$cta_config 					= $this->get_module_config('cta');
			$data['cta_settings']['config'] = $cta_config; 

			$site_info						= $DWH_Options->get_dwh_site_option_field('dwh_sites',0);
			$data['site_info']				= $site_info;
			$hotels 						= $DWH_Options->get_dwh_site_option_set('dwh_hotels');
			$hotel_info 					= array();

			foreach ($hotels as $key => $hotel) {
				if( $hotel['main_flag'] == 1) $data['hotel_info'] = $hotel;
			}


			if(!empty( $cta_settings ))
			{	
				/* exclude from view vars */
				$cta_settings_exclude = array('cta_title','cta_label');

				foreach ($cta_settings as $key => $value) {

					if( !in_array( $key , $cta_settings_exclude ) )
					{	
						/* Declare non disabled views only*/
						if( $value != 'disable')
						{
							$data['cta']['views'][$key] = strtolower( $value );
						}

						/* Display Branches dropdown */
						if( $site_info->corpsite_flag == true )
						{	
							$data['cta']['views']['cta_hotel_branches']	= 'cta_hotel_branches';
						}

						/* Modify or Cancel Link  */
						if( $site_info->corpsite_flag == false )
						{	
							$data['cta']['views']['cta_modify_cancel'] = 'cta_modify_cancel';
						}
						
					}
				}
			}
			
			/* load cta */
			load_view( $data );
		}

	}
	
	/*
	* initialize cta widget
	*/
	function get_cta_widget()
	{
		global $DWH_Data;
		global $DWH_Options;

		/* Get Site info */
		$site_info 				= $DWH_Options->get_dwh_site_option_field('dwh_sites', 0);
		$site_theme_name		= $site_info->site_theme;
		$site_theme_category 	= "";

		/* Get Hotel Info*/
		$hotels 				= $DWH_Options->get_dwh_site_option_set('dwh_hotels');
		$hotel_info 			= array();

		/* Set Hotel Branches*/
		foreach ($hotels as $key => $hotel) {
			$hotel_info = ($hotel['main_flag'] == 1) ? $hotel : null;
			$data['hotel_branches'][] = $hotel;
		}

		/* Default CTA Settings */
		$cta_config_default_dir		= get_template_directory() . '/module/widgets/widget_cta/config.fields.default.php';
		$cta_config_default 		= file_exists( $cta_config_default_dir ) ? include( $cta_config_default_dir ) : array();
		$data['cta_settings_fields'] = $cta_config_default;
		
		if( $site_info )
		{			
			/* Get Theme Site Config */
			$site_theme_config_dir 	= get_template_directory() . '/module/themes/site/'. $site_theme_name .'/config.php';
			$site_theme_config 		= file_exists( $site_theme_config_dir ) ? include( $site_theme_config_dir ) : null;
			$site_theme_category 	= isset( $site_theme_config['details']['category'] ) ? $site_theme_config['details']['category'] : null;
			
			/* Get CTA Option */
			$cta_info = $DWH_Options->get_dwh_site_option_field( 'dwh_cta', 0 );
				
			if( $cta_info )
			{
				
				/*
					NOTE:
						Code can be optimized check conditional statement if redundant						
				*/
				$bpg_default = '';
				$bpg_inclusion = '';
						
				if( array_key_exists( $site_theme_category, $cta_config_default ))
				{	
					if( array_key_exists( $cta_info->cta_set , $cta_config_default[$site_theme_category] ))
					{
						$cta_config_default 							= $cta_config_default[$site_theme_category][$cta_info->cta_set]['settings'];
						$cta_config_default['cta_set']					= isset( $cta_info->cta_set ) && ($cta_info->cta_set != '') ? $cta_info->cta_set : $cta_config_default['cta_set'];
						$cta_config_default['cta_bpg_tip'] 				= isset( $cta_info->bpg_tip ) && ($cta_info->bpg_tip != '') ? $cta_info->bpg_tip : $bpg_default;
						$cta_config_default['cta_bpg_inclusion'] 		= isset( $cta_info->bpg_inclusion ) && ($cta_info->bpg_inclusion != '') ? $cta_info->bpg_inclusion : $bpg_inclusion;
						$cta_config_default['cta_promo_code'] 			= isset( $cta_info->cta_promo_code ) && ($cta_info->cta_promo_code != '') ? $cta_info->cta_promo_code : '';
						$cta_config_default['cta_title'] 				= isset( $cta_info->cta_title ) && ($cta_info->cta_title != '') ? $cta_info->cta_title : $cta_config_default['cta_title'];
						$cta_config_default['cta_label'] 				= isset( $cta_info->cta_label ) && ($cta_info->cta_label != '') ? $cta_info->cta_label : $cta_config_default['cta_label'];
						$cta_config_default['cta_modify_cancel_link'] 	= isset( $cta_info->cta_modify_cancel_link ) && ($cta_info->cta_modify_cancel_link != '') ? $cta_info->cta_modify_cancel_link : 'Modify or Cancel';
						$cta_config_default['cta_modify_cancel_text'] 	= isset( $cta_info->cta_modify_cancel_text ) && ($cta_info->cta_modify_cancel_text != '') ? $cta_info->cta_modify_cancel_text : 'your reservation';
						$cta_config_default['terms_and_condition'] 		= isset( $cta_info->terms_and_condition ) && ($cta_info->terms_and_condition != '') ? $cta_info->terms_and_condition : '';

						/* Set CTA Settings */
						$data['cta_settings'] 							= $cta_config_default;
					} 
					else 
					{
						/* Set Initial CTA Set Settings for NW and AW if no option field is setup*/
						if( strtolower($site_theme_category) == 'nw' ) 
						{
							$cta_config_default = $cta_config_default[$site_theme_category]['set_c']['settings'];
						} 
						else if( strtolower($site_theme_category) == 'aw' ) 
						{
							$cta_config_default = $cta_config_default[$site_theme_category]['set_b']['settings'];
						}

						if( $cta_config_default ) 
						{	
							$cta_config_default['cta_bpg_tip'] 			= isset( $cta_info->bpg_tip ) ? $cta_info->bpg_tip : $bpg_default;
							$cta_config_default['cta_bpg_inclusion']	= isset( $cta_info->bpg_inclusion ) ? $cta_info->bpg_inclusion : $bpg_inclusion;
							$data['cta_settings'] 						= $cta_config_default;									
						}
					}

				}
			}
			else
			{

				if( array_key_exists( $site_theme_category, $cta_config_default ))
				{			
					if( strtolower($site_theme_category) == 'nw' )
					{
						$cta_config_default = $cta_config_default[$site_theme_category]['set_c']['settings'];
					}
					else if( strtolower($site_theme_category) == 'aw' )
					{
						$cta_config_default = $cta_config_default[$site_theme_category]['set_b']['settings'];
					}

					if( $cta_config_default )
					{	
						$cta_config_default['cta_bpg_tip'] 			= isset( $cta_info->bpg_tip ) ? $cta_info->bpg_tip : $bpg_default;
						$cta_config_default['cta_bpg_inclusion'] 	= isset( $cta_info->bpg_inclusion ) ? $cta_info->bpg_inclusion : $bpg_inclusion;
						$data['cta_settings'] 						= $cta_config_default;									
					}
				}				
			}

		}
		
		$data['dir'] 	= array( 'module/widgets', 'widget_cta', 'views' );
		$data['view'] 	= 'widget_cta';
		
		$this->get_cta( $data );

	}
	
	/* Displays map
	@param (string) - $view - name of view
	@param (array)  - $data - option data array
	*/
	function get_map( $view, $data = null )
	{
		global $DWH_Options;
		
		/* Get map detais */
		$map = (array) $DWH_Options->get_dwh_site_option_field( 'dwh_api_google_map',0);
		
		$data['atts'] = $data;
		$data['atts']['map'] = $map;
		$data['dir'] = array('module/shortcodes/dynamic', $view , 'views');
		$data['view'] = $view;
		load_view( $data );

	}
	
	/* Displays a promo content via shortcode
	@param (string) - $view - name of view
	@param (array)  - $data - option data array
	*/
	function get_promo_marker( $view, $data = null )
	{
		global $DWH_Options;
		global $DWH_Theme;

		extract( $data );

		/* Get links details */
		$promo_marker_info = (array) $DWH_Options->get_option_set_data( 'dwh_promo_marker' );

		if( !empty( $promo_marker_info ) )
		{
			
			foreach ($promo_marker_info as $key => $value) {
				
				$data['promo_marker_info'] = !empty( $promo_marker_info ) ? $promo_marker_info : array();
				$data['atts'] = $atts;		
				$data['dir']  = $dir;
				$data['view'] = $view;
				load_view( $data );

			}

		}

	}

	/* Displays fblike
	@param (string) - $view - name of view
	@param (array)  - $data - option data array
	*/
	function get_fblike( $view, $data = null )
	{
		global $DWH_Options;
		
		/* Get links details */
		$site_links = (array) $DWH_Options->get_option_set_data( 'dwh_links' );
		
		foreach( $site_links as $key => $val ){
			
			if( $val['name'] == 'facebook' )
				$data['fb'] = $val;
		}
		
		$data['atts'] = $data;		
		$data['dir'] = array('module/shortcodes/dynamic', $view , 'views');
		$data['view'] = $view;
		load_view( $data );

	}


	/* Displays fbshare button
	@param (string) - $view - name of view
	@param (array)  - $data - option data array
	*/
	function get_fbshare( $view, $data = null )
	{	
		$data['atts'] = $data;		
		$data['dir'] = array('module/shortcodes/dynamic', $view , 'views');
		$data['view'] = $view;
		load_view( $data );
	}
	
	/* Displays custom content from post meta
	@param (string) - $view - name of view
	@param (array)  - $data - option data array
	*/
	function get_custom_content( $view, $param = null )
	{
		global $post;
		
		$customkey = isset( $param['key'] ) ? $param['key'] : 'content';
		$customsingle = isset( $param['single '] ) ? $param['single '] : true;
		
		$data['atts'] = $param;
		$data['custom_content'] = get_post_meta( $post->ID, $customkey, $customsingle );
		$data['dir'] = array('module/shortcodes/dynamic', $view , 'views');
		$data['view'] = $view;
		load_view( $data );
		
	}



	function get_templates( $type )
	{	
		if( $type )
		{
			$dir = get_template_directory() . '/module/templates/'.$type;
			$exclude = array('partials');

			if( file_exists( $dir ))
			{
				$dir_scan  = scandir($dir);
				$templates = array();

				foreach ($dir_scan as $key => $dir_item ) {

					if($dir_item!='.'&& $dir_item!='..')
					{	
						if(!in_array( $dir_item , $exclude))
						{	
							$ex = explode( '.php' , $dir_item );
							$templates[] = $ex[0];
						}
						
					}

				}
				return $templates;
			}
		}
		

	}

	

	function get_module_config( $module_name )
	{
		if( $module_name )
		{
			$confile = get_template_directory() . '/module/'. $module_name . '/config.php' ;

			if( file_exists( $confile ))
			{
				return include( $confile );
			}

		}
	}

	/* Gets the google analytics event
	@param (string) - event_name - ga track event optlabel
	@param (string) - event_name - ga track event optlabel
	Note: GA params needs to be encloses in a single quote
	*/
	function get_ga_track_event( $category, $event_type, $event_name = null , $cross_domain_link = false , $data )
	{	
		global $DWH_Options;
		extract($data);

		$hotels 			= $DWH_Options->get_dwh_site_option_set('dwh_hotels');
		$hotel_info 		= array();

		foreach ( $hotels as $key => $hotel ){
			if( $hotel['main_flag'] == 1) $hotel_info = $hotel;
			 $data['hotel_branches'][] =  $hotel;
		};

		$ga_track_event = "";
		$config_ga_analytics = array();
		$hotel_id = $hotel_info['hotel_id'];

		switch ( $event_type ) {

			case 'default':
					
				if( $event_name )
				{
					$config_ga_analytics = include( get_template_directory().'/config/config.ga_analytics.php' );
					$config_ga_analytics = (object) $config_ga_analytics[$category][$event_name];
					$config_u_analytics = include( get_template_directory().'/config/config.u_analytics.php' );
					$config_u_analytics = (object) $config_u_analytics[$category][$event_name];
				}

				/* param for promo events */
				if( isset( $promo ) )
				{
					$config_ga_analytics->opt_label = "'" . $promo['promoid'] . "'";
				}
				if ( SERVICE_GA_ANALYTICS == true){
					$ga_track_event = "_gaq.push(['_trackEvent', ". $config_ga_analytics->category .", ". $config_ga_analytics->action .",". $config_ga_analytics->opt_label .",, " .$config_ga_analytics->non_interaction ."]);";
				}
				if ( SERVICE_U_ANALYTICS == true ){
					$ga_track_event = "ga('send', ". $config_u_analytics->type .", ".$config_u_analytics->category.", ".$config_u_analytics->action.", ".$config_u_analytics->label.");";
				}
				

				break;
			
			case 'link':
				

				if( $cross_domain_link == true && SERVICE_U_ANALYTICS == false )
				{	
					/* param for promo events */
					
					if( !DWH_SSL ){
						
						if(isset( $promo ))
						{
							$ga_track_event  = "_gaq.push(['_link', '".$link_url_config['base_url'];
							$ga_track_event .= (isset( $hotel_id )) ? $hotel_id."/" : '';
							$ga_track_event .= (isset( $promo['startdate'] )) ? $promo['startdate']."/" : '';	
							$ga_track_event .= (isset( $promo['nextdate'] )) ? $promo['nextdate']."/" : '';	
							$ga_track_event .= (isset( $link_url_config['param1'] )) ? $link_url_config['param1']."/" : '';
							$ga_track_event .= (isset( $promo['promoid'] )) ? $promo['promoid']."/" : '';	
							$ga_track_event .= (isset( $link_url_config['param2'] )) ? $link_url_config['param2']."/" : '';	
							$ga_track_event .= "']); return true;";
						}
						else
						{	
							$ga_track_event  = "_gaq.push(['_link', '".$link_url_config['base_url'].$hotel_id."/";
							$ga_track_event .= (isset( $link_url_config['param1'] )) ? $link_url_config['param1']."/" : '';
							$ga_track_event .= (isset( $link_url_config['param2'] )) ? $link_url_config['param2']."/" : '';	
							$ga_track_event .= "']); return true;";
						}
					
					}
					
				}

				break;
		}



		 if ( SERVICE_GA_ANALYTICS == true || SERVICE_U_ANALYTICS == true )
		 {
		 	return $ga_track_event;
		 }
		 else
		 {
		 	return "";
		 }
		
		
	}


	function get_cta_settings()
	{

		global $DWH_Data;
		global $DWH_Options;

		/* Get site info */
		$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);
		$cta_settings = array();
		$hotels = $DWH_Options->get_dwh_site_option_set('dwh_hotels');
		$site_theme_name = $site_info->site_theme;
		$site_theme_category = "";
		$hotel_info = array();

		foreach ($hotels as $key => $hotel) {
			if( $hotel['main_flag'] == 1) $hotel_info = $hotel;
			 $data['hotel_branches'][] =  $hotel;
		}

		/* default settings */
		$confile = get_template_directory() . '/module/widgets/widget_cta/config.fields.default.php';
		$cta_config_default = file_exists( $confile ) ? include( $confile ) : array();

		if( $site_info )
		{		
			$site_theme_config_dir =  get_template_directory() . '/module/themes/site/'.$site_theme_name.'/config.php';
		
			if( file_exists( $site_theme_config_dir ) )
			{	
				$site_theme_config = include( $site_theme_config_dir );
				
				if( isset( $site_theme_config['details']['category'] ) )
				{
					$site_theme_category = $site_theme_config['details']['category'];
				}
				
			}

			/* Get cta info */
			$cta_info = $DWH_Options->get_dwh_site_option_field( 'dwh_cta',0);

			if( $cta_info )
			{		
				if( array_key_exists( $site_theme_category, $cta_config_default ))
				{	
					
					if( array_key_exists( $cta_info->cta_set , $cta_config_default[$site_theme_category] ))
					{
						$cta_config_default = $cta_config_default[$site_theme_category][$cta_info->cta_set]['settings'];
						$cta_config_default['cta_title'] = $cta_info->cta_title;
						$cta_config_default['cta_label'] = $cta_info->cta_label != '' ? $cta_info->cta_label : $cta_config_default['cta_label'];
						$cta_config_default['cta_bpg_tip'] = isset( $cta_info->bpg_tip ) ? $cta_info->bpg_tip : $bpg_default;
						$cta_config_default['cta_bpg_inclusion'] = isset( $cta_info->bpg_inclusion ) ? $cta_info->bpg_inclusion : $bpg_inclusion;

						$cta_settings =  $cta_config_default;	
					}
					else
					{	
						if( $site_theme_category == 'NW' || $site_theme_category == 'nw' )
						{
							$cta_config_default = $cta_config_default[$site_theme_category]['set_c']['settings'];
						}
						else if( $site_theme_category == 'AW' || $site_theme_category == 'aw' )
						{
							$cta_config_default = $cta_config_default[$site_theme_category]['set_b']['settings'];
						}

						if(!empty( $cta_config_default ))
						{	
							$cta_config_default['cta_bpg_tip'] = isset( $cta_info->bpg_tip ) ? $cta_info->bpg_tip : $bpg_default;
							$cta_config_default['cta_bpg_inclusion'] = isset( $cta_info->bpg_inclusion ) ? $cta_info->bpg_inclusion : $bpg_inclusion;
							$cta_settings =  $cta_config_default;									
						}
					}

				}
			}
			else
			{	

				if( array_key_exists( $site_theme_category, $cta_config_default ))
				{			
					if( $site_theme_category == 'NW' || $site_theme_category == 'nw' )
					{
						$cta_config_default = $cta_config_default[$site_theme_category]['set_c']['settings'];
					}
					else if( $site_theme_category == 'AW' || $site_theme_category == 'aw' )
					{
						$cta_config_default = $cta_config_default[$site_theme_category]['set_b']['settings'];
					}

					if(!empty( $cta_config_default ))
					{	
						$cta_config_default['cta_bpg_tip'] = isset( $cta_info->bpg_tip ) ? $cta_info->bpg_tip : $bpg_default;
						$cta_config_default['cta_bpg_inclusion'] = isset( $cta_info->bpg_inclusion ) ? $cta_info->bpg_inclusion : $bpg_inclusion;
						$cta_settings =  $cta_config_default;									
					}
				}
	
				
			}

		}

		if( !empty( $cta_settings )) return $cta_settings;

	}
	
	
	/* 
	* get all posts and post meta
	* @param (array) array of post type
	* @return object
	*/
	function get_all_post_info( $post_type ){
		
		if( $post_type ){		
		
			$post_data = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1 ) );
			
			foreach( $post_data as $key => $val ){
				$post_data[$key]->post_meta = get_post_meta( $val->ID );
			}
			
			return $post_data;
		}
	
	}

}
?>