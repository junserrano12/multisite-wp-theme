<?php
extract($data);
global $DWH_Data;
global $DWH_Theme;

$site_theme_config 			 = $DWH_Theme->get_site_theme_config();
$site_theme_category 		 = strtolower($site_theme_config['details']['category']);
$link_url_config 			 = $cta_settings['config'][$site_theme_category]['calendar'];
$data['link_url_config'] 	 = $link_url_config;
$ga_track_event_click 		 = $DWH_Data->get_ga_track_event($site_theme_category,'default','calendar-widget', true , $data );
$ga_track_event_link_push 	 = $DWH_Data->get_ga_track_event($site_theme_category,'link','calendar-widget', true , $data );
$link_url 					 = $link_url_config['base_url'].$hotel_info['hotel_id'].'/';
//$link_url 					.= isset($link_url_config['param1']) ? $link_url_config['param1'] : '';
$input_type					 = 'text'; //(wp_is_mobile()) ? 'date' : 'text';
$is_readonly				 = 'readonly'; //(!wp_is_mobile()) ? 'readonly' : null;
$dateToday                   = ''; //(wp_is_mobile()) ? date("Y-m-d") : '';
$todayPlusOne                = ''; //(wp_is_mobile()) ? date("Y-m-d", strtotime("+ 1 day")) : '';
?>

<div class="control-wrapper cta-calendar-container">
    <span class="calendar-label">Check In:</span>
    <div class="calendar-input">
        <input gtbfieldid="5" class="text_reserve inputDate" id="arrival_date" name="arrival" value="<?php echo $dateToday; ?>" min="<?php echo $dateToday; ?>" type="<?php echo $input_type; ?>" <?php echo $is_readonly; ?>/>
    </div>
</div>
<div class="control-wrapper cta-calendar-container">
    <span class="calendar-label">Check Out:</span>
    <div class="calendar-input">
        <input gtbfieldid="6" class="text_reserve inputDate2" id="departure_date" name="departure" value="<?php echo $todayPlusOne; ?>" min="<?php echo $todayPlusOne; ?>" type="<?php echo $input_type; ?>" <?php echo $is_readonly; ?>>
    </div>
</div>