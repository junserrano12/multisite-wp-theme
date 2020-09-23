<?php

Class DWH_Options
{	

	/* Migration vars */
	public $migration_from_options = array();
	public $migration_to_options = array();
	public $migration_to_options_set = array();
	public $migration_options_set = array();
	public $migration_options_fields = array();
	public $from_option_fields = array();
	public $temp_migration_options_set = array();
	public $option_set_list = array();
	/* Migration vars */


	/* Opset autoload vars */
	public $option_set_fields;


	/* Default option values */
	function load_default_settings( $option_sets = null )
	{	

		$config_options_dir = get_template_directory() . "/config/config.options.fields.php";
		$default_options_set = array();
		

		if( file_exists( $config_options_dir )){

			$config_options_default = include( $config_options_dir );

			foreach ($config_options_default as $key => $value) {

				$option_set_key = $key;
				$option_set = get_dwh_option($option_set_key);

				if( $option_sets )
				{
					if( in_array( $option_set_key , $option_sets ))
					{
						/* if the option set has no values */
						if( count( $option_set ) < 1 )
						{
							if( count( $config_options_default[$option_set_key] ) > 0)
							{	
								
								$this->update_option_set_item( $option_set_key , '', $config_options_default[$option_set_key], 'default' );
								
							}
							
						}

					}
				}
				else
				{
					/* if the option set has no values */
					if( count( $option_set ) < 1 )
					{
						if( count( $config_options_default[$option_set_key] ) > 0)
						{	
							
							$this->update_option_set_item( $option_set_key , '', $config_options_default[$option_set_key], 'default' );
							
						}
						
					}
				}
				

			}

		}
		

	}


	function reset_option_sets( $option_sets = null )
	{	
		/* Reset option sets based on parameters */
		if( $option_sets )
		{	
			foreach ($option_sets as $option_set ) {
				 update_option( $option_set , array() ); 
			}
		}
		else
		{	
			/* Reset site option sets */
			$config_options_dir = get_template_directory() . "/module/options/";
			$option_default_arr = array();
			
			if( file_exists( $config_options_dir )){
				
				$config_options_scan_dir = scandir( $config_options_dir );
				
				foreach ($config_options_scan_dir as $key => $option_set) {
					if($option_set!='.'&& $option_set!='..')
					{	
						$option_set			= explode('.php', $option_set );
						$option_set 		= $option_set[0];		
						
						update_option( $option_set , array() ); 
					}
				}
			}


			/* Reset theme designer option sets */
			
		}
		

	}


	/* loads options list */
	function get_options_list()
	{
		
		$config_options_dir = get_template_directory() . "/module/options";
		$config_options_list = array();

		if( file_exists( $config_options_dir )){

			$config_options_dir = scandir( $config_options_dir );
			
			foreach ($config_options_dir as $key => $option_item) {

				if($option_item!='.' && $option_item!='..')
				{	
					$opt_item = explode( '.php', $option_item );
					$config_options_list[] = $opt_item[0];
				}
			}
		}

		return $config_options_list;
	}



	/* Option set autoload vars */
	function load_options()
	{
		
		$config_options_dir = get_template_directory() . "/module/options";
		$option_default_arr = array();

		if( file_exists( $config_options_dir )){

			
			$config_options_dir = scandir( $config_options_dir );
			
			foreach ($config_options_dir as $key => $option_item) {
				
				if($option_item!='.'&& $option_item!='..')
				{			
					$option_item = explode('.php', $option_item );
					$option_item = $option_item[0];
					
					/* If the option set does not exists then include it */
					if( (bool)get_dwh_option( $option_item ) == FALSE )
					{	
						add_option( $option_item , array() );

					}

				}

			}
		}


	}


	/* Migrates wp option data configuration to new option structure
	@param (string) - $ver - configuration version file to load
	*/
	function migrate_option_settings( $ver_from , $ver_to )
	{	
		global $DWH_PostTypes;

		if( $ver_from && $ver_to )
		{	

			$mig_file = get_template_directory() . '/module/migrate/versions/'.$ver_from.'.php';
			
			if( file_exists( $mig_file ) )
			{	
				/* Get migration config info */
				$mig_info = include( $mig_file );
				$new_option_val = array();
				$new_option_set = array();
				$hotel_ids = array();
				$hotel_names = array();
				$hotel_branches = array();
				$hotel_address  = array();
				$hotel_contact  = array();
				$contact_count = 0;
				$dwh_pages = array();
				$dwh_pages_item = array();
				$hotel_contact = array();

				if(array($mig_info))
				{	
					/* Loop through option migration config */
					foreach ($mig_info as $key => $value) 
					{
						$mig_info_value = $value;
						$from_option 	= $value['from']['option_name'];
						$from_field  	= $value['from']['field_name'];
						$from_field_val = "";
						$to_option 		= $value['to']['option_name'];
						$to_field 		= $value['to']['field_name'];
						$from_data 	= array();
						
						/* Get data destination set */
						$to_data = get_dwh_option($to_option);
						$from_data = (array)get_dwh_option($from_option);
						
						$from_field_data = array();
						$non_exists_keys = array();

						/* check if from field exists in from data */
						if( array_key_exists( $from_field , $from_data ))
						{	
							$from_field_val = $from_data[$from_field];
						}
						else
						{
							$from_field_val = '';
						}
						
						/* Check if destination field is empty */
						if( $to_field!="" )
						{	

							if( $to_option == 'dwh_hotel_address' )
							{
	
								$new_option_set[$to_option]['dwh_hotels_id'] = 0;
								$new_option_set[$to_option][$to_field] = $from_field_val;
							}
							else if( $to_option == 'dwh_hotel_contact' )
							{		

								if( isset( $from_data[$from_field] ))
								{	
									/* Contact 1 */
									$hotel_contact['hotelcontact_1']['dwh_hotels_id'] = 0;

									if( $from_field == 'countrycode')
									{	
										$hotel_contact['hotelcontact_1']['country_code'] = $from_data[$from_field];
										
									}
									else if( $from_field == 'areacode' )
									{
										$hotel_contact['hotelcontact_1']['area_code'] = $from_data[$from_field];
									}
									else if( $from_field == 'tel' )
									{
										$hotel_contact['hotelcontact_1']['telephone'] = $from_data[$from_field];
										$hotel_contact['hotelcontact_1']['email'] = '';
									}

									
									/* Contact 2 */
									$hotel_contact['hotelcontact_2']['dwh_hotels_id'] = 0;

									if( $from_field == 'countrycode1')
									{
										$hotel_contact['hotelcontact_2']['country_code'] = $from_data[$from_field];
									}
									else if( $from_field == 'areacode1' )
									{
										$hotel_contact['hotelcontact_2']['area_code'] = $from_data[$from_field];
									}
									else if( $from_field == 'tel1' )
									{
										$hotel_contact['hotelcontact_2']['telephone'] = $from_data[$from_field];
										$hotel_contact['hotelcontact_2']['email'] = '';
									}

									/* Contact 3 */
									$hotel_contact['hotelcontact_3']['dwh_hotels_id'] = 0;

									if( $from_field == 'countrycode2')
									{
										$hotel_contact['hotelcontact_3']['country_code'] = $from_data[$from_field];
									}
									else if( $from_field == 'areacode2' )
									{
										$hotel_contact['hotelcontact_3']['area_code'] = $from_data[$from_field];
									}
									else if( $from_field == 'tel2' )
									{
										$hotel_contact['hotelcontact_3']['telephone'] = $from_data[$from_field];
										$hotel_contact['hotelcontact_3']['email'] = '';
									}
								}

							}
							else if( $to_option == 'dwh_sites' && $to_field=='site_theme')
							{	
								$new_option_set[$to_option]['site_theme'] = $ver_to;
							}
							else if( $to_option == 'dwh_fonts_internal' )
							{

								$site_fonts = array(
														'getfontfutura' 	=>  'futuran',
														'getfontparsekctt'	=>	'parsekctt'
												   );
								
								if( isset( $from_data[$from_field] ))
								{	
									if( $from_data[$from_field] == 1)
									{
										$site_font = $site_fonts[$from_field];
										$new_option_set[$to_option][] = array( 'font_name' => $site_font );
									}
								}
						
							}
							else
							{
								$new_option_set[$to_option][$to_field] = $from_field_val;
							}
							
						}
						else if( $to_option == 'dwh_links' )
						{	
							$link_url = isset( $from_data[$from_field] ) && $from_data[$from_field]!="" ? $from_data[$from_field] : '';
							
							if( $link_url !="" )
							{
								$new_option_set[$to_option][] = array(
																	'name' 			=> $from_field,
																	'url'  			=> $link_url,
																	'category' 		=> 'social_media',
																	'icon' 			=> $from_field . '-icon'
																 );
							}	
						}
						else if( $to_option == 'dwh_hotel_branches' )
						{
							if( isset( $from_data['hotelids'] ) && isset( $from_data['hotelnames'] ))
							{
								if( count( $from_data['hotelids'] ) > 0 )
								{
									$hotel_ids 		=  $from_data['hotelids'] ;
									$hotel_names 	=  $from_data['hotelnames'] ;
								}
							}
						}
						else if( $to_option == 'dwh_fonts_external' )
						{	
							if( isset( $from_data[$from_field]) )
							{	
								$name 	= "Google Font";
								$url 	= $from_data[$from_field];
								$new_option_set[$to_option] = array( 'name' => $name ,'url' => $url );
							}
						}
						else if( $to_option == 'dwh_pages' )
						{	
							
								$aw_css_styles = array(

										'customflashpagestyle1' => array('page_theme' => 'flashdeal_1','page_type' => 'flashdeal','section' => 'page_css'),
										'customflashpagemediaquerystyle1' => array('page_theme' => 'flashdeal_1','page_type' => 'flashdeal','section' => 'page_mediaquery'),
										'customflashpagestyle2' => array('page_theme' => 'flashdeal_2','page_type' => 'flashdeal','section' => 'page_css'), 
										'customflashpagemediaquerystyle2' => array('page_theme' => 'flashdeal_2','page_type' => 'flashdeal','section' => 'page_mediaquery'),
										'customflashpagestyle3' => array('page_theme' => 'flashdeal_3','page_type' => 'flashdeal','section' => 'page_css'),
										'customflashpagemediaquerystyle3' => array('page_theme' => 'flashdeal_3','page_type' => 'flashdeal','section' => 'page_mediaquery'), 
										'custompagestyle' => array('page_theme' => 'promocentric_1','page_type' => 'promocentric','section' => 'page_css'),
										'custompagemediaquerystyle' => array('page_theme' => 'promocentric_1','page_type' => 'promocentric','section' => 'page_mediaquery')
	
								);
							
							if( array_key_exists( $from_field , $aw_css_styles ) )
							{

								if( array_key_exists( $from_field, $from_data))
								{
									$page_type = $aw_css_styles[$from_field]['page_type'];
									$page_theme = $aw_css_styles[$from_field]['page_theme'];
									$page_css = $aw_css_styles[$from_field]['section'] == 'page_css' ? $from_data[$from_field] : '';
									$page_mediaquery = $aw_css_styles[$from_field]['section'] == 'page_mediaquery' ? $from_data[$from_field] : '';
									
									$dwh_pages_item['page_type']		= $page_type;
									$dwh_pages_item['page_theme']		= $page_theme;
									$dwh_pages_item['page_css']			= $page_css;
									$dwh_pages_item['page_mediaquery']	= $page_mediaquery;

									if( array_key_exists( $to_option , $new_option_set ))
									{
										if( !array_key_exists( $page_theme , $new_option_set[$to_option] ))
										{	
											$new_option_set[$to_option][$page_theme][] = $dwh_pages_item;
										}
										else
										{
											$new_option_set[$to_option][$page_theme][] = $dwh_pages_item;
										}
									}
									else
									{
										$new_option_set[$to_option][$page_theme][] = $dwh_pages_item;
									}
								}
								
							}
												
						}
							
					}

					/* Hotel Information */
					if( isset( $new_option_set['dwh_hotels'] ) )
					{	
						$new_option_set['dwh_hotels']['main_flag'] = 1;
						$new_option_set['dwh_hotels'] = array( 0 => $new_option_set['dwh_hotels'] );
					}
					
					
					foreach ($new_option_set['dwh_hotels'] as $key => $value) {

							$hotel_list[] = array(

												'hotel_id' 	 => $value['hotel_id'],
												'hotel_name' => $value['hotel_name'],
									            'hotel_location' => $value['hotel_location'],
									            'hotel_domain' => $value['hotel_domain'],
									            'main_flag'  => 1  
									        );
					}



					/* Corpsite Hotel Branches */
					$hotelids =  !empty( $hotel_ids ) ? explode( "\n", $hotel_ids ) : '';
					$hotelnames = !empty( $hotel_names ) ? explode( "\n", $hotel_names ) : '';
					$hotels_count = count( $hotelids );

					if( !empty( $hotelnames ) || !empty( $hotelids ) )
					{
						for ($i=0; $i < $hotels_count; $i++) { 

							$hotel_list[] = array(

												'hotel_id' 	 => $hotelids[$i],
												'hotel_name' => $hotelnames[$i],
									            'hotel_location' => '',
									            'hotel_domain' => '',
									            'main_flag'  => 0    
									        );

						}

						$new_option_set['dwh_sites']['corpsite_flag'] = '1';
					}
					else
					{
						$new_option_set['dwh_sites']['corpsite_flag'] = '0';
					}

					$new_option_set['dwh_hotels'] = $hotel_list;

					/* dwh pages */
					if( array_key_exists( 'dwh_pages' , $new_option_set ))
					{
						
						$dwh_pages_items = array();

						/* Extract Flash deal theme styles css */
						$flashdeal_1_1	= $new_option_set['dwh_pages']['flashdeal_1'][0];
						$flashdeal_1_2 	= $new_option_set['dwh_pages']['flashdeal_1'][1];
						$flashdeal_1_1  = array_filter($flashdeal_1_1);
						$flashdeal_1_2  = array_filter($flashdeal_1_2);
						$flashdeal_1	= array_merge( $flashdeal_1_1, $flashdeal_1_2 );

						$flashdeal_2_1	= $new_option_set['dwh_pages']['flashdeal_2'][0];
						$flashdeal_2_2	= $new_option_set['dwh_pages']['flashdeal_2'][1];
						$flashdeal_2_1  = array_filter($flashdeal_2_1);
						$flashdeal_2_2  = array_filter($flashdeal_2_2);
						$flashdeal_2	= array_merge( $flashdeal_2_1, $flashdeal_2_2 );

						$flashdeal_3_1	= $new_option_set['dwh_pages']['flashdeal_3'][0];
						$flashdeal_3_2	= $new_option_set['dwh_pages']['flashdeal_3'][1];
						$flashdeal_3_1  = array_filter($flashdeal_3_1);
						$flashdeal_3_2  = array_filter($flashdeal_3_2);
						$flashdeal_3	= array_merge( $flashdeal_3_1, $flashdeal_3_2 );

						/* Extract promo centric theme styles css */
						$promocentric_1_1	= $new_option_set['dwh_pages']['promocentric_1'][0];
						$promocentric_1_2	= $new_option_set['dwh_pages']['promocentric_1'][1];
						$promocentric_1_1  = array_filter($promocentric_1_1);
						$promocentric_1_2  = array_filter($promocentric_1_2);
						$promocentric_1 = array_merge( $promocentric_1_1, $promocentric_1_2 );

						array_push( $dwh_pages_items , $flashdeal_1 );
						array_push( $dwh_pages_items , $flashdeal_2 );
						array_push( $dwh_pages_items , $flashdeal_3 );	
						array_push( $dwh_pages_items , $promocentric_1 );
						
						$new_option_set['dwh_pages'] = array();
						$new_option_set['dwh_pages'] = $dwh_pages_items;
					
					}	


					/* Hotel Contact information */
					$hotel_contact_val = "";
					foreach ($hotel_contact as $key => $value) {
						$hotel_contact_val[] = $value;
					}

					$new_option_set['dwh_hotel_contact'] = $hotel_contact_val;
			

					/* Site data */
					if( isset( $new_option_set['dwh_meta'] ) )
					{
					
						/* get additional style options for aw  */
						if( $ver_from == strtolower( 'aw' ) )
						{	
							$css_parse_data = $this->parse_css_options( $ver_from );

							if( $css_parse_data )
							{	
								$site_custom_css = $new_option_set['dwh_sites']['site_css'];
								$site_custom_css .= $css_parse_data;
								$new_option_set['dwh_sites']['site_css'] = $site_custom_css;
							}	

						}

						$new_option_set['dwh_sites'] = array( $new_option_set['dwh_sites'] );
					}


					/* Site meta data */
					if( isset( $new_option_set['dwh_meta'] ) )
					{
						$new_option_set['dwh_meta'] = array( 0 => $new_option_set['dwh_meta'] );
					}

					/* Hotel Addresses */
					if( isset( $new_option_set['dwh_hotel_address'] ) )
					{
						$new_option_set['dwh_hotel_address'] = array( 0 => $new_option_set['dwh_hotel_address'] );
					}

					
					/* Hotel Addresses */
					if( isset( $new_option_set['dwh_api_facebook_tab'] ) )
					{
						$new_option_set['dwh_api_facebook_tab'] = array( 0 => $new_option_set['dwh_api_facebook_tab'] );
					}
					
					/* External fonts */
					if( isset( $new_option_set['dwh_fonts_external'] ) )
					{
						$new_option_set['dwh_fonts_external'] = array( 0 => $new_option_set['dwh_fonts_external'] );
					}

					/* External fonts */
					if( isset( $new_option_set['dwh_api_google_webmaster_tool'] ) )
					{
						$new_option_set['dwh_api_google_webmaster_tool'] = array( 0 => $new_option_set['dwh_api_google_webmaster_tool'] );
					}

					/* web master tool - site verification */
					if( isset( $new_option_set['dwh_api_google_webmaster_tool'] ) )
					{
						$new_option_set['dwh_api_google_publisher'] = array( 0 => $new_option_set['dwh_api_google_publisher'] );
					}

					/*  api google map */
					if( isset( $new_option_set['dwh_api_google_map'] ) )
					{
						$new_option_set['dwh_api_google_map'] = array( 0 => $new_option_set['dwh_api_google_map'] );
					}

					/* api google analytics */
					if( isset( $new_option_set['dwh_api_google_webmaster_tool'] ) )
					{
						$new_option_set['dwh_api_google_analytics'] = array( 0 => $new_option_set['dwh_api_google_analytics'] );
					}

					/* Update current option with the new option sets */
					foreach ( $new_option_set as $key => $value) {
						$this->update_option_set_item( $key , '' , $value , 'default' );
					}
				}
				
				/* Migrate Custom Post Types */
				$this->migrate_custom_post_types( $ver_from );

			}

		}
	}
		
	
	/* 
	* Handle page, flashdeal, promocentric post type and custom fields migration
	* @param $ver_from (String): Required. Site theme version (e.g. aw)
	*/
	function migrate_custom_post_types( $ver )
	{
	
			$posts = get_pages();
			
			/* handle all pages */
			foreach ($posts as $key => $post) {

				$page_data = get_post_meta( $post->ID );
				$page_theme = "";
				$post_type	= "";
				$flashdeal_thumb = array();
				
				/* get header attachment */
				$attachments = array();
				if( isset( $page_data['header'][0] ) AND $page_data['header'][0] )

					$attachments = unserialize( $page_data['header'][0] );
					
					
						/* Check version */
						if( $ver == 'aw' ){
						
							/* check page template */
							if( isset( $page_data['_wp_page_template']  ) ){
								
								$page_theme = array_shift( $page_data['_wp_page_template'] );						
								$page_template = array('page-promocentric.php','page-flashdeal.php');
								
								/* only convert promocentric and flashdeal template */
								if( in_array( $page_theme, $page_template ) ){
								
									$page_theme_style = '';
									
									/* promocentric */
									if( $page_theme == 'page-promocentric.php' )
									{	
										
										$page_theme_style = 'promocentric_1';	
										$post_type = "promocentric";
										$promo_item = include( get_template_directory().'/module/post-types/promocentric/config.promo.php' );
										
										/* prepare promogroup data from header attachment */
										if ( $attachments ) {
											
											foreach( $attachments as $attachment ) {
												
												/* if gallery */
												if( $attachment['gallery'] ){

													$imgid_arr = explode(',', $attachment['gallery'] );
													
													foreach( $imgid_arr as $imgid ){
														
														/* Get image object */
														$post_image_info = get_post( $imgid );
														
														/* Get hotel info */
														$hotel_info = $this->get_dwh_site_option_field( 'dwh_hotels',0);
														/* $hotelid 		= $hotel_info->hotel_id; */
														$customlink 	= get_post_meta( $imgid, '_rt-image-link', true);
														$startdate 		= get_post_meta( $imgid, '_rt-image-start-date', true);
														$enddate 		= get_post_meta( $imgid, '_rt-image-end-date', true);
														$promoenddate 	= get_post_meta( $imgid, '_rt-image-promo-end-date', true);
														$promoid 		= get_post_meta( $imgid , '_rt-image-promoid', true) ;
														
														array_push( $promo_item['promo-name'], $post_image_info->post_title );
														array_push( $promo_item['promo-label'], $post_image_info->post_excerpt );
														array_push( $promo_item['promo-image'], $imgid );
														array_push( $promo_item['promo-desc'], $post_image_info->post_content );
														array_push( $promo_item['promo-rate-plan-id'], $promoid );
														array_push( $promo_item['promo-stay-start'], $startdate );
														array_push( $promo_item['promo-stay-end'], $enddate );
														array_push( $promo_item['promo-period-end'], $promoenddate );
													
													}
												
												}
												
												/* if imgid */
												if( $attachment['imgid'] ){
													
													/* Get image object */
													$post_image_info = get_post( $attachment['imgid'] );
													
													/* Get hotel info */
													$hotel_info = $this->get_dwh_site_option_field( 'dwh_hotels',0);
													/* $hotelid 		= $hotel_info->hotel_id; */
													$customlink 	= get_post_meta( $attachment['imgid'], '_rt-image-link', true);
													$startdate 		= get_post_meta( $attachment['imgid'], '_rt-image-start-date', true);
													$enddate 		= get_post_meta( $attachment['imgid'], '_rt-image-end-date', true);
													$promoenddate 	= get_post_meta( $attachment['imgid'], '_rt-image-promo-end-date', true);
													$promoid 		= get_post_meta( $attachment['imgid'] , '_rt-image-promoid', true) ;
													
													array_push( $promo_item['promo-name'], $post_image_info->post_title );
													array_push( $promo_item['promo-label'], $post_image_info->post_excerpt );
													array_push( $promo_item['promo-image'], $attachment['imgid'] );
													array_push( $promo_item['promo-desc'], $post_image_info->post_content );
													array_push( $promo_item['promo-rate-plan-id'], $promoid );
													array_push( $promo_item['promo-stay-start'], $startdate );
													array_push( $promo_item['promo-stay-end'], $enddate );
													array_push( $promo_item['promo-period-end'], $promoenddate );
													
												}

											}
											
											/* create migrated key to promo item array; value yes */
											$promo_item['migrated'] = 'yes';
												
											/* update promo group */
											update_post_meta( $post->ID, 'promo_group', $promo_item );
											
										}

									}
									
									/* flashdeal */
									else if( $page_theme == 'page-flashdeal.php' )
									{
										$post_type = "flashdeal";
										
										
										/* handle page themes */
										$page_theme_style_temp = array_shift( $page_data['flashpagestyle'] );
										
										switch( $page_theme_style_temp ){
											case 'style1':
												$page_theme_style = 'flashdeal_1';
											break;
											case 'style2':
												$page_theme_style = 'flashdeal_2';
											break;
											case 'style3':
												$page_theme_style = 'flashdeal_3';
											break;
											default:
												$page_theme_style = 'flashdeal_1';
											break;
										}
										
										/* push post ID to flashdeal_thumb array */
										array_push( $flashdeal_thumb, $post->ID );
										
									}
									
									/* create migrated meta key to flashdeal; value yes */
									update_post_meta( $post->ID, 'migrated', 'yes' );
									
									/* update page theme */
									update_post_meta( $post->ID, 'page_theme', $page_theme_style );
									
									/* Convert post into custom post type */
									set_post_type( $post->ID , $post_type );
									
								}
								

							}
						
						}
					
				
				/* prepare slider from header attachment */
				if ( $attachments ) {
				
					/* get slider config */
					$slider_fields = include( get_template_directory().'/module/sliders/base/config.presave.php' );
					
					$slider_arr = array();
					$slider_type_ctr = 0;
					
					/* set defaults */
					$slider_arr['slider-name'] = array('flexslider');
					$slider_arr['slider-mode'] = array('page');
					$slider_arr['slider-type'] = array('Default Slider');
					
					/* push slider item fields to slider_arr */
					foreach( $slider_fields['slider-item'] as $key => $val ){
						$slider_arr[ $key ] = array();
					}
					
					/* get attachment image id */
					foreach( $attachments as $attachment ){
						
						/* check if iframe */
						if( $attachment['iframe'] ){
							
							/* 
							* 2 things
							* slider-item-type = iframe
							* slider-item-iframe = attachment['iframe']
							*/
							array_push( $slider_arr['slider-item-type'], 'iframe' );
							array_push( $slider_arr['slider-item-expire'], '' );
							array_push( $slider_arr['slider-item-title'], '' );
							array_push( $slider_arr['slider-item-caption'], '' );
							array_push( $slider_arr['slider-item-overlaycontent'], '' );
							array_push( $slider_arr['slider-item-url'], '' );
							array_push( $slider_arr['slider-item-description'], '' );
							array_push( $slider_arr['slider-item-rel'], '' );
							array_push( $slider_arr['slider-item-id'], '' );
							array_push( $slider_arr['slider-item-popup'], '' );
							array_push( $slider_arr['slider-item-iframe'], $attachment['iframe'] );
							
							/* slider type counter */
							$slider_type_ctr++;
							
						}
						
						/* if gallery */
						if( $attachment['gallery'] ){

							$imgid_arr = explode(',', $attachment['gallery'] );
							
							foreach( $imgid_arr as $imgid ){
							
								/* Get image object */
								$post_image_info = get_post( $imgid );
								$customlink 	 = get_post_meta( $imgid, '_rt-image-link', true);
								
								array_push( $slider_arr['slider-item-type'], 'slider' );
								array_push( $slider_arr['slider-item-expire'], '' );
								array_push( $slider_arr['slider-item-title'], $post_image_info->post_title );
								array_push( $slider_arr['slider-item-caption'], $post_image_info->post_excerpt );
								array_push( $slider_arr['slider-item-overlaycontent'], '' );
								array_push( $slider_arr['slider-item-url'], $customlink );
								array_push( $slider_arr['slider-item-description'], $post_image_info->post_content );
								array_push( $slider_arr['slider-item-rel'], 'group1' );
								array_push( $slider_arr['slider-item-id'], $imgid );
								array_push( $slider_arr['slider-item-popup'], 'default' );
								array_push( $slider_arr['slider-item-iframe'], '' );
								
								/* slider type counter */
								$slider_type_ctr++;

							}
						
						}
						
						/* if imgid */
						else{
							
							if( $attachment['imgid'] ){
								
								/* Get image object */
								$post_image_info = get_post( $attachment['imgid'] );
								$customlink 	 = get_post_meta( $attachment['imgid'], '_rt-image-link', true);
								
								array_push( $slider_arr['slider-item-type'], 'slider' );
								array_push( $slider_arr['slider-item-expire'], '' );
								array_push( $slider_arr['slider-item-title'], $post_image_info->post_title );
								array_push( $slider_arr['slider-item-caption'], $post_image_info->post_excerpt );
								array_push( $slider_arr['slider-item-overlaycontent'], '' );
								array_push( $slider_arr['slider-item-url'], $customlink );
								array_push( $slider_arr['slider-item-description'], $post_image_info->post_content );
								array_push( $slider_arr['slider-item-rel'], 'group1' );
								array_push( $slider_arr['slider-item-id'], $attachment['imgid'] );
								array_push( $slider_arr['slider-item-popup'], 'default' );
								array_push( $slider_arr['slider-item-iframe'], '' );
								
								/* slider type counter */
								$slider_type_ctr++;
							}
							
						}
						
					}
					
					
					/*
					* Pages
					* set Thumbnail small if slider item is greater than 1 
					*/
					if( $slider_type_ctr > 1 ) $slider_arr['slider-type'] = array('Thumbnail Small');
					
					
					/*
					* Flashdeal template
					* set Thumbnail medium if slider item is greater than 1 
					*/
					if( $flashdeal_thumb ){
						
						foreach( $flashdeal_thumb as $flashdealid ){
							
							if( $slider_type_ctr > 1 ) $slider_arr['slider-type'] = array('Thumbnail Medium');
							
						}
						
					}
					
					/* Check if NW */
					if( $ver == 'nw' ){
						$slider_arr['slider-type'] = array('Bullet Slider');
						
					}
					
					/* update slider */
					update_post_meta( $post->ID, 'slider', array( $slider_arr ) );
					

				}
				
			}
			
			
			/* handle all media attachment  */	
			$media_args = array(
					'post_type' => 'attachment',
					'post_status' => 'inherit',
					'posts_per_page' => -1
					);

			$attachment_arr = new WP_Query( $media_args );
			
			foreach( $attachment_arr->posts as $key => $value ){
				
				$customlink = get_post_meta( $value->ID, '_rt-image-link', true);
				$imagetitle = get_post_meta( $value->ID, '_rt-image-title', true);
				$imgalt = get_post_meta( $value->ID, '_rt-image-alt', true);
				$imgoffset = get_post_meta( $value->ID, '_rt-offset-span', true);
				
				update_post_meta( $value->ID, 'attachment_image_link', $customlink );
				update_post_meta( $value->ID, 'attachment_image_class', $customlink );
				update_post_meta( $value->ID, 'attachment_image_title', $imagetitle );
				update_post_meta( $value->ID, 'attachment_image_alt', $imgalt );
				update_post_meta( $value->ID, 'attachment_offset', $imgoffset );
				
			}
		
	}

	function parse_css_options( $ver )
	{	

		if( $ver )
		{	
			$migrate_config = array();
			$dir = get_template_directory().'/module/migrate/composer/'.$ver.'/config.php';	
			$option_key = "";
			$output = "";

			if( file_exists( $dir )) 
			{
				$migrate_config = include( $dir );
				$migrate_config = array_shift( $migrate_config );
			}
			
			if( !empty( $migrate_config ))
			{
				foreach ($migrate_config as $key => $value) {
					
					$option_key = $key;

					if( (bool)get_dwh_option($option_key) == true )
					{

						$option_set_data = get_dwh_option($option_key);
						$option_set_val = $value;

						foreach ($option_set_val as $key => $value) {
								
							if( $value['category'] == 'css' )
							{	
								$field_name = $value['field'];
							
								if( array_key_exists( $field_name, $option_set_data ) )
								{
									$data[$field_name] = $option_set_data[$field_name];
								}


							}
						}

						if( count( $data ) > 1 )
						{
							$file_css = get_template_directory().'/module/migrate/composer/'.$ver.'/css.php';

							if( file_exists( $file_css ))
							{	
								$output = include($file_css);	
							}
						}

					}
					
				}
			}
			
			if( !empty( $output ))
			{
				return $output;
			} 	
		}
	

	}


	/**
	 * Adds an option set item
	 *
	 * @param  string   $option_set Name of the wp option registered setting name
	 * @param  integer  $option_row option set item id or subset array id
	 * @param  array    $option_values  Set of option set specific item containing field keys and values
	 * @return none     updates the option set item data
	 */ 
	function add_option_set_item(  $option_set , $option_values )
	{
		$option = get_dwh_option( $option_set );
		array_push( $option , $option_values );
		update_option( $option_set , $option );
		end( $option );
		return key( $option );
	}

	/**
	 * Updates an option set item
	 *
	 * @param  string   $option_set Name of the wp option registered setting name
	 * @param  integer  $option_row option set item id or subset array id
	 * @param  array    $option_values  Set of option set specific item containing field keys and values
	 * @return none     updates the option set item data
	 */ 
	function update_option_set_item(  $option_set , $option_row = null , $option_values, $mode = 'default'  )
	{		
		
		if( $mode == 'default' ){
		
			update_option( $option_set , $option_values );
		}
		else{
			
			$option = get_dwh_option($option_set);
			
			if( $option ){
				
				foreach ($option as $key => $value) {
						
					if( $key == $option_row )
					{
						$option[$option_row] = $option_values;
					}
				}
			
			}
			
			update_option( $option_set , $option );

		}
		
		
	}
	

	/**
	 * deletes an option set item
	 *
	 * @param  string   $option_set Name of the wp option registered setting name
	 * @param  integer  $option_value option field index
	 */ 
	function delete_option_set_item(  $option_set , $option_row )
	{
		
		$option = get_dwh_option($option_set);
		$new_option_val = array();

		foreach ($option as $key => $value) {
			
			if( $key != $option_row )
			{
				$new_option_val[$key] = $value;
			} 

		}

		return update_option( $option_set , $new_option_val );

	}




	/**
	 * Get option set details collection
	 *
	 * @param  none
	 * @return array  returns an array from the option set config files
	 */ 
	function get_option_set_list()
	{
		$config_options_dir = get_template_directory() . "/module/options/";
		$option_default_arr = array();

		if( file_exists( $config_options_dir )){

			$config_options_scan_dir = scandir( $config_options_dir );
			
			foreach ($config_options_scan_dir as $key => $option_set) {
				
				if($option_set!='.'&& $option_set!='..')
				{	
					$option_set_info 	= include( $config_options_dir . $option_set );		
					$option_set			= explode('.php', $option_set );
					$option_set 		= $option_set[0];

					$this->option_set_list[$option_set] = $option_set_info['details'] ;
					
				}

			}

			
			if( count( $this->option_set_list ) > 0 )
			{

				/* Set Order */
				$options_order_dir = get_template_directory() . '/config/config.options.table.php';
				$opt_list_value = array();

				if( file_exists( $options_order_dir ) )
				{
					$opt_list_order = include( $options_order_dir );

					foreach ($opt_list_order as $key => $value) {

						if( array_key_exists( $key , $this->option_set_list ))
						{
							$opt_list_value[$key] = $this->option_set_list[$key];
							$opt_list_value[$key]['icon'] = $value['icon'];
						}
						
					}
				}

				return $opt_list_value;
			}

		}
		
	}

	/**
	 * Get option set settings
	 *
	 * @param  string   $option_set Name of the wp option registered setting name
	 * @return false    if the option config file does not exists
	 * @return array  	returns an array from the option set config file
	 */ 
	function  get_option_set_properties( $option_set )
	{	
		if( $option_set )
		{
			$option_set_item_properties =  get_template_directory() . "/module/options/".$option_set.".php";

			if( file_exists( $option_set_item_properties ) )
			{
				$option_set_item_properties = include( $option_set_item_properties );
				return $option_set_item_properties;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	
	}



	/**
	 * Get option set data from wp options table
	 *
	 * @param  string   $option_set Name of the wp option registered setting name
	 * @return false    if the option has not been registered on the wp settings option
	 * @return array  	returns an array from the option set config file
	 */ 
	function  get_option_set_data( $option_set )
	{	
		if( $option_set )
		{
			
			if( (bool)get_dwh_option( $option_set ) )
			{
				$option_set_data = get_dwh_option( $option_set );
				
				if( count( $option_set_data ) > 0 )
				{
					return $option_set_data;
				}
				else
				{
					return false;
				}

			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	
	}


	/**
	 * Get option set data from wp options table and return as an object
	 *
	 * @param  string   $option_set Name of the wp option registered setting name
	 * @param  number   $option_row index of the option set array
	 * @return false    if the option has not been registered on the wp settings option
	 * @return array  	returns an object from the option set config file
	 */ 
	function  get_dwh_site_option_set( $option_set )
	{		

		if( $option_set )
		{

			if( (bool)get_dwh_option( $option_set ) )
			{	
				$option_set_data = get_dwh_option( $option_set );							

				if( count( $option_set_data ) > 0 )
				{		
					return (object)$option_set_data ;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	
	}

	function  get_dwh_site_option_field( $option_set, $option_row = null )
	{		

		if( $option_set )
		{

			if( (bool)get_dwh_option( $option_set ) )
			{	
				$option_set_data = get_dwh_option( $option_set );

				if( array_key_exists( $option_row , $option_set_data ))
				{
					if( count( $option_set_data ) > 0 )
					{	
						return (object)$option_set_data[$option_row] ;
					}
					else
					{
						return false;
					}
				}
				
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	
	}

	function  get_dwh_site_option_set_by_field_name( $option_set, $field_name, $field_value )
	{		


		if( $option_set )
		{	
			if( (bool)get_dwh_option( $option_set ) )
			{	
				$option_set_data = get_dwh_option( $option_set );	
				$option_data_set = array();								

				if( count( $option_set_data ) > 0 )
				{	
					foreach ($option_set_data as $key => $value) {

						if( $value[$field_name] == $field_value)
						{
							$option_data_set[] = array( 'id' => $key, 'value' => $value );
						}
					}

					if( count( $option_data_set ) > 1 )
					{
						return (object)$option_data_set;
					}
					else
					{	
						if( array_key_exists( 0, $option_data_set ) )
						{
							return (object)$option_data_set[0];
						}
						
					}

				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	
	}

	function get_xml()
	{
		$optionsetlist = $this->get_option_set_list(); 

		/* include other option sets to xml */
		$include_options = array( 'dwh_hotel_address' , 'dwh_hotel_contact' );
 		$config_options_dir = get_template_directory() . "/module/options/";

		foreach ($include_options as $key => $include_option ) {
				
			if( file_exists( $config_options_dir . $include_option . '.php' ) ){

				$option_set_info = include( $config_options_dir . $include_option . '.php'  );
				$optionsetlist[$include_option] = $option_set_info['details'];
			}

		}

		$option_set_value = array();
		global $DWH_Admin;

		if( $optionsetlist  )
		{	
			/* Basic theme data otions */

			foreach ($optionsetlist as $key => $optionsetvalue ) {

				$option_set = $key;
				$option_set_value[$key] = get_dwh_option( $option_set );

			}

			/* Theme Designer data */
			$page_themes = $DWH_Admin->get_page_themes();

			foreach ( $page_themes as $key => $page_theme_info ) {
				$page_theme_option_name = 'dwh_theme_designer_'.$key;
				
				if( (bool)get_dwh_option( $page_theme_option_name ) )
				{
					$page_theme_option_data = get_dwh_option( $page_theme_option_name );
					$option_set_value[$page_theme_option_name] = $page_theme_option_data;
				}

			}

			$site_themes = $DWH_Admin->get_site_themes();

			foreach ( $site_themes as $key => $site_theme_info ) {
				$site_theme_option_name = 'dwh_theme_designer_'.$key;
				
				if( (bool)get_dwh_option( $site_theme_option_name ) )
				{
					$page_theme_option_data = get_dwh_option( $site_theme_option_name );
					$option_set_value[$site_theme_option_name] = $page_theme_option_data;
					
				}
				
			}

			/* Parse XML */
			$xml  = "";
			$xml .= '<?xml version="1.0" encoding="UTF-8" ?>';
			$xml .= '<dwh_options>';
			$xml .= $this->generate_xml_from_array( $option_set_value , $xml );
			$xml .= '</dwh_options>';

			return $xml;

		}

	}

	function generate_xml_from_array( $option_set_value , $xml = null ) {
	
		$xml = "";
		
		/* Check if it is an array and of course not empty */
		if( is_array( $option_set_value ) && !empty( $option_set_value ) )
		{	
			/* Loop on the array */
			foreach ($option_set_value as $option_set_key => $option_set_item_value ) {
				
				if( !is_numeric( $option_set_key ) )
				{	
					$xml .= '<'.$option_set_key.'>';

					/* Check if the value is an array and then regenerate */
					if( is_array( $option_set_item_value ) )
					{
						$xml .= $this->generate_xml_from_array( $option_set_item_value , $xml );
					}
					else
					{
						$xml .=  htmlspecialchars( $option_set_item_value , ENT_QUOTES );
					}	

					$xml .= '</'.$option_set_key.'>'; 
				}
				else
				{

					$xml .= '<value>';

					/* Check if the value is an array and then regenerate */
					if( is_array( $option_set_item_value ) )
					{
						$xml .= $this->generate_xml_from_array( $option_set_item_value , $xml );
					}
					else
					{
						$xml .= htmlspecialchars( $option_set_item_value , ENT_QUOTES );
					}	

					


					$xml .= '</value>'; 

				}

				
			}	

			return $xml;
		}

		

	}

	/* Import dwh options */
	function import_options( $xml )
	{	
		if( $xml )
		{
			global $XML2Array;
			global $DWH_Admin;

			$site_options_from_xml = $XML2Array->createArray( $xml );
			$site_options_val = array();
			$current_option_val = "";
			$option_set = "";
			$option_set_list = $this->get_option_set_list();

			/* include other option sets to xml */
			$include_options = array( 'dwh_hotel_address' , 'dwh_hotel_contact' );
	 		$config_options_dir = get_template_directory() . "/module/options/";

			foreach ($include_options as $key => $include_option ) {
					
				if( file_exists( $config_options_dir . $include_option . '.php' ) ){

					$option_set_info = include( $config_options_dir . $include_option . '.php'  );
					$option_set_list[$include_option] = $option_set_info['details'];
				}

			}


			if( !empty( $site_options_from_xml ))
			{
				/* Convert XML value to array and arrange site options data structure indexes */
				foreach ($site_options_from_xml as $key => $node) {

					foreach ($node as $key => $node_value) {

						$option_set = $key;
						$current_option_val = get_dwh_option( $option_set );

						/*  if value not empty*/
						if( !empty( $node_value ) )
						{
							if( isset( $node_value['value'] ))
							{	
								$node_value = array_shift( $node_value );
								$node_value =  array( $node_value );
							}
						
							if( is_array( $node_value ) )
							{	
								if( isset( $node_value[0] ))
								{	
									/* If atleast there is a numeric index loop and attain all indexes */
									$node_value = array_shift( $node_value );
								}
								else
								{	
									$node_value = array( $node_value );
								}
									
								$site_options_val[$option_set] = $current_option_val;
							}

							$site_options_val[$option_set] = $node_value;
						}	
						else{

							/* If value empty get current value */	
							$site_options_val[$option_set] = $current_option_val;

						}
						
					}

				}
				
		
				/* Loop through arrange array data indexes and update wp site options */
				if( !empty( $site_options_val ) )
				{
					foreach ( $site_options_val as $site_option_set => $site_option_val_item ) {

						if( !empty( $site_option_val_item ) )
						{

							if( !array_key_exists( $site_option_set , $option_set_list ))
							{							
								/* Remove first value index */
								$site_option_val_item = $this->remove_index_rec( 'value' , $site_option_val_item );
								$site_option_val_item = array_shift( $site_option_val_item );
							}
							else
							{	

								if( !$this->is_numeric_array(  $site_option_val_item ) )
								{
									$site_option_val_item = array( $site_option_val_item );
								}

							}

			
							update_option( $site_option_set , $site_option_val_item );
						}
						
					}
				}

				

				return true;
				
			}
		}
		
	}

	function is_numeric_array($arr)
	{
	    return array_keys($arr) === range(0,(count($arr)-1));
	}



	function remove_index_rec( $index , $array )
	{	
		$new_array_value = $array;

		if( $index )
		{	
			/* Check if its an array and then reconstruct array structure */
			if( is_array( $array ) && !empty( $array ) )
			{
				foreach ($array as $key => $value) {

					if( !empty( $value ) )
					{	
						/* Check if index is found */
						if( isset( $value[$index] ) )
						{	
							$new_array_value[$key] = $value[$index];
						}
						else
						{	
							/* Check if index is not set */
							$new_array_value[$key] = $this->remove_index_rec( $index , $value );	
						}

					}
					
				}

				return $new_array_value;

			}
			else
			{
				return false;
			}

		}

	}

	function get_migration_list()
	{
		$dir = get_template_directory() . "/module/migrate/versions";
		$mig_list = array();

		if( file_exists( $dir )){

			$dir = scandir( $dir );
			
			foreach ($dir as $key => $dir_item) {

				if($dir_item!='.' && $dir_item!='..')
				{	
					$mig_list_item = explode( '.php', $dir_item );
					$mig_list[] = $mig_list_item[0];
				}
			}
		}

		return $mig_list;
	}


}
?>