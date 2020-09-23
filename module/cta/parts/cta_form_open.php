<?php
global $DWH_Data;
global $DWH_Theme;
extract($data);

$data['dir']              = array('module/cta/parts');
$site_theme_config        = $DWH_Theme->get_site_theme_config();
$site_theme_category      = strtolower($site_theme_config['details']['category']);
$link_url_config          = $cta_settings['config'][$site_theme_category]['calendar'];
$data['link_url_config']  = $link_url_config;
$ga_track_event_click     = $DWH_Data->get_ga_track_event($site_theme_category,'default','calendar-widget', true , $data );
$ga_track_event_link_push = $DWH_Data->get_ga_track_event($site_theme_category,'link','calendar-widget', true , $data );
$link_url                 = $link_url_config['base_url']. $hotel_info['hotel_id'] .'/'. $link_url_config['param1'] . $link_url_config['param2'];
$link_url                 = str_replace('http://','https://',$link_url);
?>
<form id="booking" class="courier" method="GET" action="<?php echo $link_url;?>">
    <input type="hidden" name="hotelid" class="hotelid" value="<?php echo $hotel_info['hotel_id']; ?>" />