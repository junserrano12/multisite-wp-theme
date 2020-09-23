<?php 
global $DWH_Options;
global $DWH_Theme;
$site_info = $DWH_Options->get_dwh_site_option_field('dwh_sites',0);

if( $site_info ) :
	$faviconurl = get_template_directory_uri().'/favicon.ico';
	
	if( trim( $site_info->favicon_id ) )
		$faviconurl = wp_get_attachment_url( $site_info->favicon_id );
	elseif( trim( $site_info->logo_id ) )
		$faviconurl = wp_get_attachment_url( $site_info->logo_id );
		
	/* if ssl */
	if( DWH_SSL == true ) $faviconurl = $DWH_Theme->http_to_https( $faviconurl );

?>
<!-- Defaults -->
<link rel="shortcut icon" href="<?php echo makeAbsoluteToRelative($faviconurl);?>" type="image/x-icon">
<link rel="icon" href="<?php echo makeAbsoluteToRelative($faviconurl);?>" />
<?php endif;?>
<!--[if IE]><link rel="shortcut icon" href=""><![endif]-->
<link rel="profile" href="http://gmpg.org/xfn/11"/>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" /> 