<?php

/* Migration for AW Site Data */

return array(

				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'faviconid' ),
						'to'   => array('option_name' => 'dwh_sites', 'field_name' => 'favicon_id' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'logoid' ),
						'to'   => array('option_name' => 'dwh_sites', 'field_name' => 'logo_id' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'hotelname' ),
						'to'   => array('option_name' => 'dwh_hotels', 'field_name' => 'hotel_name' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'hotellocation' ),
						'to'   => array('option_name' => 'dwh_hotels', 'field_name' => 'hotel_location' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'hotelid' ),
						'to'   => array('option_name' => 'dwh_hotels', 'field_name' => 'hotel_id' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'hoteldomain' ),
						'to'   => array('option_name' => 'dwh_hotels', 'field_name' => 'hotel_domain' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'termsandcondition' ),
						'to'   => array('option_name' => 'dwh_sites', 'field_name' => 'terms_and_condition' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'gacode' ),
						'to'   => array('option_name' => 'dwh_api_google_analytics', 'field_name' => 'ga_code' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'gacode2' ),
						'to'   => array('option_name' => 'dwh_api_google_analytics', 'field_name' => 'ga_code_2' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'gpublisher' ),
						'to'   => array('option_name' => 'dwh_api_google_publisher', 'field_name' => 'publisher' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'noindexnofollow' ),
						'to'   => array('option_name' => 'dwh_meta', 'field_name' => 'noindex_nofollow' ) 
					),	
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'nofollow' ),
						'to'   => array('option_name' => 'dwh_meta', 'field_name' => 'noindex_nofollow' ) 
					),		
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'googleverification' ),
						'to'   => array('option_name' => 'dwh_api_google_webmaster_tool', 'field_name' => 'site_verification_code' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'latitude' ),
						'to'   => array('option_name' => 'dwh_api_google_map', 'field_name' => 'map_latitude' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'longtitude' ),
						'to'   => array('option_name' => 'dwh_api_google_map', 'field_name' => 'map_longitude' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'zoom' ),
						'to'   => array('option_name' => 'dwh_api_google_map', 'field_name' => 'map_zoom' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'customstyle' ),
						'to'   => array('option_name' => 'dwh_sites', 'field_name' => 'site_css' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'custommediaquerystyle' ),
						'to'   => array('option_name' => 'dwh_sites', 'field_name' => 'site_mediaquery' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'facebook' ),
						'to'   => array('option_name' => 'dwh_links', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'twitter' ),
						'to'   => array('option_name' => 'dwh_links', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'googleplus' ),
						'to'   => array('option_name' => 'dwh_links', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'tripadvisor' ),
						'to'   => array('option_name' => 'dwh_links', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'instagram' ),
						'to'   => array('option_name' => 'dwh_links', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'pinterest' ),
						'to'   => array('option_name' => 'dwh_links', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'tumblr' ),
						'to'   => array('option_name' => 'dwh_links', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'foursquare' ),
						'to'   => array('option_name' => 'dwh_links', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'youtube' ),
						'to'   => array('option_name' => 'dwh_links', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'linkedin' ),
						'to'   => array('option_name' => 'dwh_links', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'country' ),
						'to'   => array('option_name' => 'dwh_hotel_address', 'field_name' => 'country' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'street1' ),
						'to'   => array('option_name' => 'dwh_hotel_address', 'field_name' => 'street_1' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'street2' ),
						'to'   => array('option_name' => 'dwh_hotel_address', 'field_name' => 'street_2' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'zippostal' ),
						'to'   => array('option_name' => 'dwh_hotel_address', 'field_name' => 'zip_code' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'citytown' ),
						'to'   => array('option_name' => 'dwh_hotel_address', 'field_name' => 'city_town' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'stateprovinceregion' ),
						'to'   => array('option_name' => 'dwh_hotel_address', 'field_name' => 'state_region' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'customscript' ),
						'to'   => array('option_name' => 'dwh_sites', 'field_name' => 'site_js_scripts' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'countrycode' ),
						'to'   => array('option_name' => 'dwh_hotel_contact', 'field_name' => 'country_code' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'areacode' ),
						'to'   => array('option_name' => 'dwh_hotel_contact', 'field_name' => 'area_code' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'tel' ),
						'to'   => array('option_name' => 'dwh_hotel_contact', 'field_name' => 'telephone' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'countrycode1' ),
						'to'   => array('option_name' => 'dwh_hotel_contact', 'field_name' => 'country_code' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'areacode1' ),
						'to'   => array('option_name' => 'dwh_hotel_contact', 'field_name' => 'area_code' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'tel1' ),
						'to'   => array('option_name' => 'dwh_hotel_contact', 'field_name' => 'telephone' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'countrycode2' ),
						'to'   => array('option_name' => 'dwh_hotel_contact', 'field_name' => 'country_code' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'areacode2' ),
						'to'   => array('option_name' => 'dwh_hotel_contact', 'field_name' => 'area_code' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'tel2' ),
						'to'   => array('option_name' => 'dwh_hotel_contact', 'field_name' => 'telephone' ) 
					),
				array( 	
						'from' => array('option_name' => 'dwh_theme_skeleton', 'field_name' => '' ),
						'to'   => array('option_name' => 'dwh_sites', 'field_name' => 'site_theme' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'getfontfamily' ),
						'to'   => array('option_name' => 'dwh_fonts_external', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'defaultbannerimageid' ),
						'to'   => array('option_name' => 'dwh_sites', 'field_name' => 'banner_id' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'getfontfutura' ),
						'to'   => array('option_name' => 'dwh_fonts_internal', 'field_name' => 'font_name' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'getfontparsekctt' ),
						'to'   => array('option_name' => 'dwh_fonts_internal', 'field_name' => 'font_name' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'customflashpagestyle1' ),
						'to'   => array('option_name' => 'dwh_pages', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'customflashpagemediaquerystyle1' ),
						'to'   => array('option_name' => 'dwh_pages', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'customflashpagestyle2' ),
						'to'   => array('option_name' => 'dwh_pages', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'customflashpagemediaquerystyle2' ),
						'to'   => array('option_name' => 'dwh_pages', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'customflashpagestyle3' ),
						'to'   => array('option_name' => 'dwh_pages', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'customflashpagemediaquerystyle3' ),
						'to'   => array('option_name' => 'dwh_pages', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'custompagestyle' ),
						'to'   => array('option_name' => 'dwh_pages', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'style_option', 'field_name' => 'custompagemediaquerystyle' ),
						'to'   => array('option_name' => 'dwh_pages', 'field_name' => '' ) 
					),
				array( 	
						'from' => array('option_name' => 'general_option', 'field_name' => 'fbappid' ),
						'to'   => array('option_name' => 'dwh_api_facebook_tab', 'field_name' => 'app_id' ) 
					)


			);

?>
