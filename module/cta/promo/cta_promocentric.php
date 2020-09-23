<?php 
global $DWH_Data;
global $DWH_Theme;
global $DWH_Options;

extract($data);

$hotelid 						 = $hotel_info['hotel_id'];
$ctr							 = $ctr;
$promo_group_info 				 = $page_fields['promo_group'];

if( $promo_group_info ){

		$promoid 					 = isset( $promo_group_info['promo-rate-plan-id'][$ctr] ) ? $promo_group_info['promo-rate-plan-id'][$ctr] : date("Y-m-d");
		$startdate 					 = isset( $promo_group_info['promo-stay-start'][$ctr] ) ? $promo_group_info['promo-stay-start'][$ctr] : date("Y-m-d");
		$enddate 					 = isset( $promo_group_info['promo-stay-end'][$ctr]  ) ? $promo_group_info['promo-stay-end'][$ctr] : date("Y-m-d");
		$numberofnights				 = 1;
		$promoenddate 				 = isset( $promo_group_info['promo-period-end'][$ctr] ) ? $promo_group_info['promo-period-end'][$ctr] : date("Y-m-d");
		$currentdate 				 = date("Y-m-d");
		$nextdate					 = date('Y-m-d', strtotime( $startdate .'+1 days') );
		$timediff 					 = intval( strtotime( $promoenddate ) - strtotime( $currentdate ) );
		$numberdays 				 = intval($timediff / 86400);
		$isexpired 					 = ($numberdays < 0) ? true : false;
		$startdate 					 = date("Y-m-d", strtotime($startdate));
		$enddate 					 = date("Y-m-d", strtotime($enddate));
		
		if( $nextdate > $enddate ) $nextdate = $enddate;
		
		if (strtotime($currentdate) > strtotime($startdate)){
			$startdate 				 = $currentdate;
		} 

		/* Append promo param on the url */

		/* Prepare CTA promo button link */
		$site_theme_config 			 = $DWH_Theme->get_site_theme_config();
		$site_theme_category		 = strtolower($site_theme_config['details']['category']);

		$link_url_config 			 = $cta_settings['config']['promo']['calendar'];
		$data['link_url_config'] 	 = $link_url_config;
		$link_url 					 = $link_url_config['base_url'];
		$link_url 					.= $hotelid.'/';
		$link_url 					.= $startdate . '/';
		$link_url 					.= $nextdate . '/';
		$link_url 					.= ( isset( $link_url_config['param1'] ) ) ? $link_url_config['param1'].'/' : '';
		// $link_url 					.= $promoid . '/';
		// $link_url 					.= ( isset( $link_url_config['param2'] ) ) ? $link_url_config['param2'].'/' : '';
		
		/* Append ga event params */
		$data['promo'] 				 = array( 'promoid' => $promoid , 'startdate' => $startdate, 'nextdate' => $nextdate );
		$ga_track_event_click 		 = $DWH_Data->get_ga_track_event( $site_theme_category, 'default', 'promocentric', true, $data );
		$ga_track_event_link_push 	 = $DWH_Data->get_ga_track_event( $site_theme_category, 'link', 'promo', true, $data );
		
		/* if universal analytics */
		$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
		$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
		$ga_onclick_event = $gtm_flag == 0 ? 'onclick="'. $ga_track_event_click . $ga_track_event_link_push .'"' : '';
		
		             
    $fullURL = $_SERVER['HTTP_HOST'];
    if(strpos($fullURL,'istana-kl') > 0){
        $link_url = str_replace('reservations', 'reservations2', $link_url);
    }
		
?>	

		<input type="hidden" name="hotelid" value="<?php echo $hotelid; ?>" />
		<input type="hidden" name="promoid" value="<?php echo $promoid; ?>" />
		<input type="hidden" name="startdate" value="<?php echo $startdate; ?>" />
		<input type="hidden" name="enddate" value="<?php echo $enddate; ?>" />
		<div class="control-wrapper cta-calendar-wrapper">
				<?php 
					if ( !$isexpired ){
				?>
						<div class="cta-date-remaining">
							<p><?php echo ($numberdays > 1)? "Ends in <span>$numberdays Days</span>" : 'Ends <span>Today</span>'; ?></p>
							<div class="cta-calendar-container">
								<label class="calendar-label" for="arrival">Arrival Date:</label>
								<input class="calendar-input" id="arrival_date<?php echo $ctr; ?>" name="arrival" value="<?php echo date("d M Y", strtotime( $startdate ) ); ?>" type="text" data-item-id="<?php echo $ctr;?>" readonly />
							</div>
							<div class="cta-calendar-container">
								<label class="calendar-label" for="departure">Departure Date:</label>
								<input class="calendar-input" id="departure_date<?php echo $ctr; ?>" name="departure" value="<?php echo date("d M Y", strtotime( $nextdate ) ); ?>" type="text" data-item-id="<?php echo $ctr;?>" readonly />
							</div>
							<div class="cta-number-of-nights-container hide">
								<label class="numberofnights-label" for="numberOfNights">Number of Nights:</label>
								<input class="numberofnights-input" id="number_of_nights_<?php echo $ctr; ?>" name="numberOfNights" value="<?php //echo $numberofnights; ?>" type="text" size="2" />
							</div>
						</div>
				<?php
					}
				?>
		</div>

		<div class="control-wrapper control-button-wrapper">
			<div class="cta-button-container">
				<?php 
					if ( $isexpired ){
				?>
						<a onclick="return false;" class="button ctapromobutton ctaexpiredbutton" href="#?">Expired</a>
				<?php 
					}else{ 
				?>
						<a cta-button-id="<?php echo $ctr;?>" <?php echo $ga_onclick_event; ?> class="button ctapromobutton" href="<?php echo $link_url;?>">Check Availability and Prices</a>
				<?php 
					}
				?>
			</div>
		</div>
<?php
	}
?>