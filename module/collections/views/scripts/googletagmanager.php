<?php

	global $DWH_Options;
	
	$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
	
	/* google tag manager */
	$tgm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
	$gtm_code = isset( $google_analytics_info->google_tag_manager_code ) ? $google_analytics_info->google_tag_manager_code : '';
	
	if( $tgm_flag ){

		/* if with gtm code */
		if( $gtm_code ){
?>
			<!-- Google Tag Manager -->
			<noscript><iframe src="//www.googletagmanager.com/ns.html?id=<?php echo $gtm_code; ?>"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','<?php echo $gtm_code; ?>');</script>
			<!-- End Google Tag Manager -->
	
<?php	
		}	
	}
?>