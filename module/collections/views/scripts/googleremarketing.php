<?php

	global $DWH_Options;

	$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics', 0);
	$garemarketing 			= isset($google_analytics_info->ga_remarketing) ? $google_analytics_info->ga_remarketing : null;
	
	if($garemarketing != '' || $garemarketing != null){
	?>
		<script type="text/javascript">;
		/* <![CDATA[ */
		var google_conversion_id = <?php echo $garemarketing; ?>;
		var google_custom_params = window.google_tag_params;
		var google_remarketing_only = true;
		/* ]]> */
		</script>
		<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
		<noscript>;
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/<?php echo $garemarketing; ?>/?value=0&guid=ON&script=0"/>
		</div>;
		</noscript>
		
<?php } ?>