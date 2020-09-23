<?php

global $DWH_Widget;

/////

global $DWH_Data;
global $DWH_Theme;
global $DWH_Options;

extract($data);
extract($instance);

$title = isset($title) ? $title : '';
$content = isset($content) ? $content : '';
$show_inner_pages_class = $show_inner_pages == 'yes' ? 'show-inner-pages ':'';
$show_only_once_class = $show_only_once == 'yes' ? 'show-only-once':'';
$show_class = $show_inner_pages_class . $show_only_once_class;


$site_theme_config 			 = $DWH_Theme->get_site_theme_config();
$site_theme_category		 = strtolower($site_theme_config['details']['category']);
$ga_track_event_click 		 = $DWH_Data->get_ga_track_event( $site_theme_category, 'default', 'promo-popup', true, $data );
$ga_track_event_click2 		 = $DWH_Data->get_ga_track_event( $site_theme_category, 'default', 'promo-popup-selectdates', true, $data );
//$ga_track_event_link_push 	 = $DWH_Data->get_ga_track_event( $site_theme_category, 'link', 'promo', true, $data );
$ga_track_event_link_push 	 = '';

/* if universal analytics */
$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
//$ga_onclick_event = $gtm_flag == 0 ? 'onclick="'. $ga_track_event_click . $ga_track_event_link_push .'"' : '';
$ga_onclick_event = $gtm_flag == 0 ? $ga_track_event_click . $ga_track_event_link_push : '';
$ga_onclick_event2 = $gtm_flag == 0 ? $ga_track_event_click2 . $ga_track_event_link_push : '';

////
?>
<div class="hide">
	<div id="splash-container" class="<?php echo $show_class; ?>">	
		<span class="hide uaTracker" data-tracker="<?php echo $ga_onclick_event; ?>" ></span>
		<span class="hide uaTracker2" data-tracker="<?php echo $ga_onclick_event2; ?>" ></span>
		<div class="splash-content">
			<h2 class="align-center title"><?php echo $title;?></h2>
			<?php echo _process_custom_content($content);?>
		</div>
	</div>
</div>
