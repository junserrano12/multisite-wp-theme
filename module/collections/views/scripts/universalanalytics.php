<?php
global $DWH_Options;
global $uniAnalyticCodes;

$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);

if( $google_analytics_info ){
	$ga_code = isset($google_analytics_info->ga_code) && $google_analytics_info->ga_code !='' ? $google_analytics_info->ga_code : '';
	$ga_code2 = isset($google_analytics_info->ga_code_2) && $google_analytics_info->ga_code_2 !='' ? $google_analytics_info->ga_code_2 : '';
	/* google tag manager */
	$tgm_flag = isset( $google_analytics_info->tag_manager_flag ) && $google_analytics_info->tag_manager_flag == 1 ? $google_analytics_info->tag_manager_flag : 0;
	$gtm_code = isset( $google_analytics_info->google_tag_manager_code ) ? $google_analytics_info->google_tag_manager_code : '';
	$uni_analytics = isset( $google_analytics_info->universal_analytics ) ? $google_analytics_info->universal_analytics : 0;
	$uni_analytics_code1 = isset( $google_analytics_info->ua_analytics_code1 ) ? $google_analytics_info->ua_analytics_code1 : 0;
	$uni_analytics_code2 = isset( $google_analytics_info->ua_analytics_code2 ) ? $google_analytics_info->ua_analytics_code2 : 0;
}

if( $tgm_flag == 0 && $uni_analytics != 0 && ($uni_analytics_code1 != '' || $uni_analytics_code2 != '')){
	$uniAnalyticCodes = true;
?>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	<?php if( $uni_analytics_code1 != '' && $uni_analytics_code2 == ''){ ?>
		ga('create', '<?php echo $uni_analytics_code1; ?>', 'auto');
		ga('send', 'pageview');
	<?php } ?>

	<?php if( $uni_analytics_code1 == '' && $uni_analytics_code2 != ''){ ?>
		ga('create', '<?php echo $uni_analytics_code2; ?>', 'auto', 'hotelTracker');
		ga('hotelTracker.send', 'pageview');
	<?php } ?>

	<?php if( $uni_analytics_code1 != '' && $uni_analytics_code2 != ''){ ?>
		ga('create', '<?php echo $uni_analytics_code1; ?>', 'auto');
		ga('create', '<?php echo $uni_analytics_code2; ?>', 'auto', 'hoteltracker');
		ga('send', 'pageview');
		ga('hoteltracker.send', 'pageview');
	<?php } ?>
</script>
<?php } else {
	$uniAnalyticCodes = false;
} ?>