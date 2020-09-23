<?php
	global $DWH_Options, $DWH_Theme;
	$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);
	$hotel_info = $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0);
	$logoid    = isset( $site_info->logo_id ) ? $site_info->logo_id : null;
	$logourl   = ($logoid != null) ? wp_get_attachment_url($logoid) : get_template_directory_uri().'/images/logo.png';
	$hotelnamelocation = "";
	$home_url = esc_url( home_url( '/' ) );
	
	if( DWH_SSL == true ){
		$home_url = $DWH_Theme->http_to_https( $home_url );
	}
	
	if(!empty( $hotel_info )) $hotelnamelocation = $hotel_info->hotel_name .' in '. $hotel_info->hotel_location;
?>
	

	<div id="logo-container">
		<a class="logo" href="<?php echo $home_url; ?>" rel="home">
			<img src="<?php echo makeAbsoluteToRelative($logourl);?>" title="<?php echo $hotelnamelocation;?>">
		</a>
	</div>
	
	