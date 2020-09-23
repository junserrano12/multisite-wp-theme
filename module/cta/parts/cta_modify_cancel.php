<?php 
extract($data);
global $DWH_Data;
global $DWH_Theme;
global $DWH_Options;

$data['dir'] 				 = array('module/cta');
$site_theme_config 			 = $DWH_Theme->get_site_theme_config();
$site_theme_category 		 = strtolower($site_theme_config['details']['category']);
$link_url_config 			 = $cta_settings['config'][$site_theme_category]['moclink'];
$data['link_url_config'] 	 = $link_url_config;
$ga_track_event_click 		 = $DWH_Data->get_ga_track_event($site_theme_category,'default','modify-cancel', true , $data );
$ga_track_event_link_push 	 = $DWH_Data->get_ga_track_event($site_theme_category,'link','modify-cancel', true , $data );
$link_url 					 = $link_url_config['base_url'].$hotel_info['hotel_id'] . '/';
$link_url 					.= isset($link_url_config['param1']) ? $link_url_config['param1'] . '/' : '';
// $link_url 					.= isset($link_url_config['param2']) ? $link_url_config['param2'] . '/' : '';

/* if universal analytics */
$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
$ga_onclick_event = $gtm_flag == 0 ? 'onclick="'. $ga_track_event_click . $ga_track_event_link_push .'"' : '';

$fullURL = $_SERVER['HTTP_HOST'];

if(strpos($fullURL,'istana-kl') > 0){
    $link_url = str_replace('reservations', 'reservations2', $link_url);
}

	if( $site_info->corpsite_flag == 0 ){ 
?>
		<div class="control-wrapper cta-moc-container">
			<p><a class="ctamodify" <?php echo $ga_onclick_event; ?> href="<?php echo $link_url;?>"><?php echo $cta_settings['cta_modify_cancel_link'];?></a> <?php echo $cta_settings['cta_modify_cancel_text'];?></p>
		</div>
<?php 
	}
?>