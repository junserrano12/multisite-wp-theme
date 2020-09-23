<?php
global $DWH_Data;
global $DWH_Theme;
global $DWH_Options;
extract($data);

$site_theme_config 	 = $DWH_Theme->get_site_theme_config();
$site_theme_category = strtolower($site_theme_config['details']['category']);
$cta_language        = $DWH_Options->get_option_set_data( 'dwh_cta_language' );
$cta_language        = isset($cta_language[0]['cta_language']) ? $cta_language[0]['cta_language'] : 'en';

if( $cta['views']['cta_calendar'] == 'cta_non_calendar' ){

	$link_url_config 			 = $cta_settings['config'][$site_theme_category]['button'];
	$data['link_url_config'] 	 = $link_url_config;
	$ga_track_event_click 		 = $DWH_Data->get_ga_track_event($site_theme_category,'default','cta-button', true , $data );
	$ga_track_event_link_push 	 = $DWH_Data->get_ga_track_event($site_theme_category,'link','cta-button', true , $data );
	$link_url 					 = $link_url_config['base_url'].$hotel_info['hotel_id'] . '/0/0/0/0/0/'.$cta_language.'/0';
	//$link_url 					.= isset($link_url_config['param1']) ? $link_url_config['param1']: null;

	/* if universal analytics */
	$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
	$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
	$ga_onclick_event = $gtm_flag == 0 ? 'onclick="'. $ga_track_event_click . $ga_track_event_link_push .'"' : '';


	?>

	<div class="control-wrapper cta-button-container custom-test-button">
		<a class="button ctabutton" <?php echo $ga_onclick_event; ?> href="<?php echo $link_url;?>">
		<?php echo $cta_settings['cta_label'];?>
		</a>
	</div>
<?php } else {

		// $link_url_config 			 = $cta_settings['config'][$site_theme_category]['calendar'];
		// $data['link_url_config'] 	 = $link_url_config;
		// $ga_track_event_click 		 = $DWH_Data->get_ga_track_event($site_theme_category,'default','calendar-widget', true , $data );
		// $ga_track_event_link_push 	 = $DWH_Data->get_ga_track_event($site_theme_category,'link','calendar-widget', true , $data );
		// $link_url 					 = $link_url_config['base_url'].$hotel_info['hotel_id'].'/';
		// //$link_url 					.= isset($link_url_config['param1']) ? $link_url_config['param1']: null;

		$data['dir']              = array('module/cta/parts');
		$site_theme_config        = $DWH_Theme->get_site_theme_config();
		$site_theme_category      = strtolower($site_theme_config['details']['category']);
		$link_url_config          = $cta_settings['config'][$site_theme_category]['calendar'];
		$data['link_url_config']  = $link_url_config;
		$ga_track_event_click     = $DWH_Data->get_ga_track_event($site_theme_category,'default','calendar-widget', true , $data );
		$ga_track_event_link_push = $DWH_Data->get_ga_track_event($site_theme_category,'link','calendar-widget', true , $data );
		$link_url                 = $link_url_config['base_url']. $hotel_info['hotel_id'] .'/'. $link_url_config['param1'] . $link_url_config['param2'];
		$link_url                 = str_replace('http://','https://',$link_url);

		/* if universal analytics */
		$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
		$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
		$ga_onclick_event = $gtm_flag == 0 ? 'onclick="'. $ga_track_event_click . $ga_track_event_link_push .'"' : '';
	?>
		<div class="control-wrapper cta-button-container">
			<input class="button ctabutton hide" type="hidden" value="<?php echo $cta_settings['cta_label'];?>" <?php echo $ga_onclick_event; ?>>
			<a class="button ctabutton dwhctabooking" href="<?php echo $link_url; ?>" <?php echo $ga_onclick_event; ?>><?php echo $cta_settings['cta_label'];?></a>
		</div>

<?php } ?>