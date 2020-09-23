<?php
global $DWH_Options;
$ssl	        = ( defined('DWH_SSL') && DWH_SSL == true ) ? 'https://' : 'http://';
// $cdnurl	        = ( defined('DWH_CDN_URL') && DWH_CDN_URL != '' ) ? $ssl.DWH_CDN_URL : $ssl.'wpcdn.directwithhotels.com';
// $cloudFrontURL	= ( defined('DWH_CLOUDFRONT_URL') && DWH_CLOUDFRONT_URL != '' ) ? $ssl.DWH_CLOUDFRONT_URL : $ssl.'d3kjsgogkkmhg7.cloudfront.net';

$cdnurl	        = '';
$cloudFrontURL	= '';

$themename 		= esc_html( get_template() );
$wpincludes 	= '/wp-includes/js/';
$wpthemes   	= '/wp-content/themes/';
$wpuploads  	= '/wp-content/uploads/';
	
$desktopCTALink = ibe_retiever_url();
	
return array(
				'cdnenable'		=> true,						
				'cdnurl' 		=> $cdnurl,
				'cdnthemepath' 	=> $cdnurl.$wpthemes,
				'cdnpath' 		=> array(
									$cdnurl.$wpincludes,
									$wpthemes.$themename.'/module/dynamic-css/',
									$cdnurl.$wpthemes,
									$cloudFrontURL.$wpuploads,
									$cloudFrontURL.$wpuploads,
									'\''.$cloudFrontURL.$wpuploads,
									'"'.$cloudFrontURL.$wpuploads,
									$desktopCTALink
								),
				'relativepath'	=> array(
									$wpincludes,
									$wpthemes.$themename.'/module/dynamic-css/',
									$wpthemes,
									$wpuploads,
									$wpuploads,
									'\''.$wpuploads,
									'"'.$wpuploads,
									$desktopCTALink
								),
				'cdnpattern' 	=> array(
									'/(http|https)\:\/\/([0-9a-zA-Z\.\-\_]+)\/wp-includes\/js\//',
									'/(http|https)\:\/\/([0-9a-zA-Z\.\-\_]+)\/wp-content\/themes\/([0-9a-zA-Z\.\-\_]+)\/module\/dynamic-css\//',
									'/(http|https)\:\/\/([0-9a-zA-Z\.\-\_]+)\/wp-content\/themes\//',
									'/(http|https)\:\/\/([0-9a-zA-Z\.\-\_]+)\/wp-content\/uploads\//',
									'/\.\.\/wp-content\/uploads\//',
									'/\'\/wp-content\/uploads\//',
									'/\"\/wp-content\/uploads\//',
									'/http:\/\/reservations.directwithhotels.com/'
								)
			);

?>