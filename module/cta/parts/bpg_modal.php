<?php 
global $post;
global $DWH_Options;
global $DWH_Theme;
global $DWH_Data;

extract( $data );

/* Get hotel info */
$hotel_info 			= $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0 );
$site_theme_config 		= $DWH_Theme->get_site_theme_config();
$site_theme_category 	= strtolower($site_theme_config['details']['category']);
$link_url_config_dir 	= get_template_directory() . '/module/cta/config.php';

if( file_exists( $link_url_config_dir ))
{	
	$link_url_config 			 = include( $link_url_config_dir );
	$link_url_config 			 = $link_url_config[$site_theme_category]['button'];
	$data['hotel_info'] 		 = $hotel_info;
	$data['link_url_config'] 	 = $link_url_config;
	$ga_track_event_click 		 = $DWH_Data->get_ga_track_event( $site_theme_category,'default','cta-link', true , $data );
	$ga_track_event_link_push 	 = $DWH_Data->get_ga_track_event( $site_theme_category,'link','cta-link', true , $data );
	$link_url 					 = $link_url_config['base_url'].$hotel_info->hotel_id . '/';
	$link_url 					.= isset($link_url_config['param1']) ? $link_url_config['param1'] : null;
	
	/* if universal analytics */
	$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
	$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
	$ga_onclick_event = $gtm_flag == 0 ? 'onclick="'. $ga_track_event_click . $ga_track_event_link_push .'"' : '';
	
}

?>

<div id="bpgmodal-container" class="hide">
	<div id="bpgmodal">
		<div class="content">
			<div class="bpgmodal-content">
				<!-- <h2 class="align-center">Best Price Guarantee Terms &amp; Conditions</h2> -->
				<?php if( isset( $cta_settings['terms_and_condition']  ) && $cta_settings['terms_and_condition'] != "" ):?>
					<?php echo $cta_settings['terms_and_condition']; ?>
				<?php else: ?>
				<?php	
					$data['dir'] 		= array('module/collections','views','texts');
					$data['view'] 		= 'termsandconditions';
					$data['str_val']	= $hotel_info->hotel_name;
					$data['str_rep']	= '$hotelname';
					$terms 				= replace_file_str_val( $data ); 
					echo $terms;
				 ?>
				<?php endif; ?>				
				<div class="align-center">
					<a class="button ctabpglink" <?php echo $ga_onclick_event; ?> href="<?php echo $link_url;?>">
						<?php echo isset(  $cta_settings['cta_label'] ) ? $cta_settings['cta_label'] : null;?>
					</a>	
				</div>
			</div>
		</div>
	</div>	
</div>