<?php
global $post;
global $DWH_Data;
global $DWH_Theme;
global $DWH_Options;

extract($data);

/* Hotel Information*/
$hotelid 					 = $hotel_info['hotel_id'];

/* Promo Details Settings*/
$post_id 					 = $post->ID;
$image_attributes 			 = wp_get_attachment_image_src( $post_id, 'full' );
$catchphrase 				 = $page_fields['catchphrase'];
$startdate 					 = $page_fields['start_date'];
$enddate 					 = $page_fields['end_date'];
$promoenddate 				 = $page_fields['promo_end_date'];
$promoid 					 = $page_fields['promoid'];
$currentdate 				 = date("Y-m-d");
$timediff 					 = intval( strtotime($promoenddate) - strtotime($currentdate) );
$numberdays 				 = intval($timediff / 86400);		
$isexpired 					 = ($numberdays < 0) ? true : false;

if (strtotime($currentdate) > strtotime($startdate)){
	$startdate 				 = $currentdate;
}

$startdate 					 = date("Y-m-d", strtotime($startdate));
$enddate 					 = date("Y-m-d", strtotime($enddate));

/* Prepare CTA promo button link */
$link_url_config 			 = $cta_settings['config']['promo']['calendar'];
$data['link_url_config'] 	 = $link_url_config;
$link_url 					 = $link_url_config['base_url'].$link_url_config['param1'].'/'.$hotelid.'/';

/* Append promo param on the url */
$link_url 					.= $startdate . '/';
$link_url 					.= $promoid . '/';
$link_url 					.= isset( $link_url_config['param2'] ) ? $link_url_config['param2'] : null;
$link_url 					.= isset( $link_url_config['param3'] ) ? $link_url_config['param3'] : null;

/* Append ga event params */
$site_theme_config 			 = $DWH_Theme->get_site_theme_config();
$site_theme_category  		 = strtolower($site_theme_config['details']['category']);
$data['promo'] 				 = array( 'promoid' => $promoid , 'startdate' => $startdate );
$ga_track_event_click 		 = $DWH_Data->get_ga_track_event($site_theme_category, 'default', 'flashdeal', true, $data);
$ga_track_event_link_push 	 = $DWH_Data->get_ga_track_event($site_theme_category, 'link', 'promo', true, $data);

/* if universal analytics */
$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
$ga_onclick_event = $gtm_flag == 0 ? 'onclick="'. $ga_track_event_click . $ga_track_event_link_push .'"' : '';

?>

<input type="hidden" name="hotelid" value="<?php echo $hotelid; ?>" />
<input type="hidden" name="promoid" value="<?php echo $promoid; ?>" />
<input type="hidden" name="startdate" value="<?php echo $startdate; ?>" />
<input type="hidden" name="enddate" value="<?php echo $enddate; ?>" />

<div class="control-wrapper cta-catchphrase">
	<?php echo $catchphrase; ?>
</div>

<div class="control-wrapper">
	<div class="cta-date-remaining">
		<?php if($isexpired):?>
			<p>Expired</p>
		<?php else: ?>
			<p><?php echo ($numberdays > 1)? "Ends in <span>$numberdays Days</span>" : 'Ends <span>Today</span>'; ?></p>
		<?php endif;?>
	</div>
	<div class="cta-calendar-container">	
		<span class="calendar-label">Select Date:</span>
		<div id="calendar-<?php echo $post_id; ?>" class="calendar-input">
			<input data-item-id="<?php echo $post_id;?>" class="text_reserve inputDate" id="selectDate-<?php echo $post_id; ?>" name="selectDate" value="" type="text" readonly="">
		</div>
	</div>
</div>

<div class="control-wrapper">
	<div class="cta-button-container">
		<?php if($isexpired){ ?>
			<a onclick="return false;" class="button ctapromobutton ctaexpiredbutton" href="#?">Expired</a>
		<?php } else { ?>
			<a target="_blank" cta-button-id="<?php echo $post_id;?>" <?php echo $ga_onclick_event; ?> class="button ctapromobutton" href="<?php echo $link_url;?>">Check Availability and Prices</a>
		<?php } ?>
	</div>
</div>