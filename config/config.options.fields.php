<?php

/* Schema */
return array(
	
		 		'dwh_hotels' => array(	
								 				 array( 
				 										'hotel_id' 				=> '000001',
				 										'hotel_name' 			=> 'Hotel Name 1',
					 									'hotel_location' 		=> 'City, Country 1',
					 									'hotel_domain' 			=> 'www.hotel1.com',
					 									'main_flag' 			=> 1

				 									)
		 							),
				'dwh_hotel_address' => array(	
								 				 array( 
				 										'dwh_hotels_id' 		=> 0,
					 									'street_1' 				=> '',
					 									'street_2' 				=> '',
					 									'city_town' 			=> '',
					 									'state_region' 			=> '',
					 									'country' 				=> '',
					 									'zip_code' 				=> ''

				 									)
		 							),
				'dwh_hotel_contact' => array(	
								 				 array( 
				 										'dwh_hotels_id' 		=> 0,
					 									'country_code' 			=> '',
					 									'area_code' 			=> '',
					 									'telephone' 			=> '',
					 									'email' 				=> ''

				 									)
		 							),
		 		'dwh_sites' => array(	
		 								
								 		 array( 
				 									'site_theme' 			=> 'NW3.2.1-default',
													'corpsite_flag'         => 0,
													'cdn_flag'         		=> 0,
				 									'logo_id'				=> '',				
													'favicon_id'			=> '',
													'banner_id'				=> '',
													'site_css'				=> '',
													'site_mediaquery'		=> ''
				 								)

		 							),
				'dwh_meta' => array(	
								 		 array( 
				 									'noindexnofollow' => 0

				 								)
		 							),

				'dwh_api_google_publisher' => array(

												array(
														'publisher' => ''
													)

											),
				'dwh_api_google_webmaster_tool' => array(

												array(
														'site_verification_tag' => ''
													)

											),
				'dwh_api_facebook_tab' => array(

												array(
														'app_id' => '',
														'redirect_uri' => ''
													)

											),
				'dwh_api_google_map' => array(

												array(
														'map_latitude' => '',
														'map_longitude' => '',
														'map_zoom' => 16,
														'map_iframe' => ''
													)

											),
				'dwh_api_google_analytics' => array(

												array(
														'ga_code' => '',
														'ga_code_2' => '',
														'ga_remarketing' => ''
													)


											),
				'dwh_cta' => array(

												array(
														'cta_set' 	=> 'set_a',
														'bpg_tip' => '',
														'bpg_inclusion' => '',
														'cta_promo_code' => 0,
														'cta_title' => 'Best Price Guarantee',
														'cta_label' => 'Check Availability and Prices',
														'cta_footer_link' => 'Check availability and prices',
														'cta_modify_cancel_link' => 'Modify or Cancel',
														'cta_modify_cancel_text' => 'your reservation',
														'terms_and_condition'   => ''
													)



											),
				'dwh_promo_link_navigation' => array(

												array(
														'promo_post_ids' => '',
														'promo_label_single' => '',
														'promo_label_multiple' => ''
													)


											),
				'dwh_slider' => array(

												array(
														'slider-name' => 'flexslider',
														'slider-mode' => 'site',
														'slider-type' => 'Default Slider',
														'slider-data' => ''
													)


											)
											
			);


?>