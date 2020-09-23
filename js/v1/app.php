<?php
global $DWH_Options;
global $DWH_Data;
global $DWH_Theme;
global $DWH_Admin;
global $post;

/* Get Site data and Settings */
$site_info				= $DWH_Options->get_dwh_site_option_field('dwh_sites',0);
$site_theme_config 		= $DWH_Theme->get_site_theme_config();
$site_url 				= str_replace( 'https://', '', $_SERVER['HTTP_HOST'] );
$site_url 				= str_replace( 'http://', '', $site_url );
$base_url               = site_url();
$cacheBust 				= $DWH_Theme->cache_buster();
$cta_language        	= $DWH_Options->get_option_set_data( 'dwh_cta_language' );
$ibe_url 				= $DWH_Options->get_option_set_data( 'dwh_ibe_url' );

if( $DWH_Theme->cdn_enable() ) {
	$site_cdn 	= isset( $site_info->site_theme ) ? $site_info->cdn_flag : 0;
	if($site_cdn){
		$cdn_url				= $base_url;
		$cdn_path 				= 'wp-content/themes/';
	}else{
		$cdn_url				= ($DWH_Theme->cdn_url() === '/' || $DWH_Theme->cdn_url() === '' ) ? $base_url : $DWH_Theme->cdn_url();
		$cdn_path 				= ($DWH_Theme->cdn_url() === '/' || $DWH_Theme->cdn_url() === '') ? 'wp-content/themes/' : $DWH_Theme->cdn_theme_path();
	}
} else {
	$cdn_url				= $base_url;
	$cdn_path 				= 'wp-content/themes/';
}

if( DWH_SSL == true ){
	$site_url = $DWH_Theme->http_to_https( $site_url );
	$base_url = $DWH_Theme->http_to_https( $base_url );
	$cdn_url  = $DWH_Theme->http_to_https( $cdn_url );
}

$post_types 			= $DWH_Admin->get_page_types();
$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
$hotels 				= $DWH_Options->get_dwh_site_option_set('dwh_hotels');
$hotel_info 			= array();
$hotelmain  			= (array) $hotels;

/* Get posttypes */
$post_types_list = array();
foreach ($post_types as $key => $post_type) {
	$post_types_list[] = array_shift( $post_type );
}

/* Get theme info */
$wp_theme_info = wp_get_theme();

/* Set Hotel Flag */
if( !empty( $hotels ) )
{
	foreach ($hotels as $key => $hotel) {
		if( $hotel['main_flag'] == 1)
		{
			 $hotel_info = $hotel;
		}
	}
}

/* SET SLIDER */
$slider_data = $DWH_Data->get_slider_data();
if( isset( $slider_data['slider_name'] ) ){
	$slider_type = $slider_data['slider_name'];
	if( $slider_type != '') $slider_js = $base_url .'/wp-content/themes/'.$wp_theme_info->stylesheet.'/module/sliders/'.$slider_type.'/js/settings.min'.$cacheBust;
}

/* GET CTA */
$cta_link_config = $DWH_Data->get_module_config('cta');

/* Check for GA info */
if( $google_analytics_info )
{
	$ga_code = isset($google_analytics_info->ga_code) && $google_analytics_info->ga_code !='' ? $google_analytics_info->ga_code : '';
	$ga_code2 = isset($google_analytics_info->ga_code_2) && $google_analytics_info->ga_code_2 !='' ? $google_analytics_info->ga_code_2 : '';
	$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
	$gtm_code = isset( $google_analytics_info->google_tag_manager_code ) && $google_analytics_info->google_tag_manager_code != '' ? $google_analytics_info->google_tag_manager_code : '';
}


/* CTA URL configuration */
/*json format from db*/
$ibe_urls   = (array)json_decode($ibe_url[0]['ibe_desktop_url']);
$idUrl 		= array();
foreach ( $ibe_urls as $key => $value ) {
    $ibeurls = (array)$value;
    foreach ( $ibeurls as $result => $ibeurl ) {
        $ibeurl = (array)$ibeurl;
        $idUrl[$key] = isset($ibeurl['ibe_desktop_subdomain']) ? $ibeurl['ibe_desktop_subdomain'] : '';
    }
}

/* END PHP VARIABLE*/
?>

<script type="text/javascript">

/* ibeurl list */
var ibeurl = <?php echo json_encode($idUrl); ?>;

/* cache buster */
var cbuster = {
	'cache_bust' : "<?php echo $cacheBust; ?>",
}

/* Google Analytics info */
var google_analytics_info = {
	'ga_code' 	: "<?php echo isset( $ga_code ) ? $ga_code : ''; ?>",
	'ga_code_2' : "<?php echo isset( $ga_code2 ) ? $ga_code2 : ''; ?>",
	'gtm_flag' 	: "<?php echo isset( $gtm_flag ) ? $gtm_flag : ''; ?>",
	'gtm_code' 	: "<?php echo isset( $gtm_code ) ? $gtm_code : ''; ?>"
};

/* Site info */
var site_info = {
	'base_url' 			: "<?php echo $base_url; ?>",
	'cdn_url' 			: "<?php echo $cdn_url; ?>",
	'theme_path' 		: "wp-content/themes/<?php echo $wp_theme_info->stylesheet;?>/",
	'cdn_path' 			: "<?php echo $cdn_path . $wp_theme_info->stylesheet;?>/",
	'site_category' 	: "<?php echo isset( $site_theme_config['details']['category'] ) ? $site_theme_config['details']['category'] : '';?>",
	'hotel_domain' 		: "<?php echo $site_url; ?>",
	'hotel_name' 		: "<?php echo isset( $hotelmain[0]['hotel_name'] ) ? $hotelmain[0]['hotel_name'] : '';?>",
	'hotel_location' 	: "<?php echo isset( $hotelmain[0]['hotel_location'] ) ? $hotelmain[0]['hotel_location'] : '';?>",
	'is_corpsite' 		: '<?php echo isset($site_info->corpsite_flag) ? $site_info->corpsite_flag : ""; ?>',
	'post_types' 		: <?php echo json_encode( $post_types_list ); ?>
};

/* Page info */
var page_info = {
	'post_type' : "<?php echo isset( $post->post_type ) ? $post->post_type : '';?>"
};

/* Slider JS */
var path_slider = {
	'slider' : '<?php echo isset( $slider_js ) ? $slider_js : '';?>'
};

/* Hotel info */
var hotel_info = <?php echo json_encode( $hotel_info );?>;

/* CTA Settings */
var cta_settings = [];
var cta_link_config = <?php echo json_encode( $cta_link_config ); ?>;
var cta_language = '<?php echo isset($cta_language[0]['cta_language']) ? $cta_language[0]['cta_language'] : 'en'; ?>';

/* Device Type */
<?php if( USER_DEVICE == 'mobile' || wp_is_mobile() ) :?>
var is_mobile = true;
<?php else:?>
var is_mobile = false;
<?php endif;?>

<?php
	/*
	* if google universal analytics
	*/
	$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;

	if( !$gtm_flag ){

		/* if with google analytics */
		if( $ga_code ){
?>
			/*Google Analytics*/
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '<?php echo isset( $ga_code ) ? $ga_code : ''; ?>']);
			_gaq.push(['_setDomainName', '<?php echo $site_url; ?>']);
			_gaq.push(['_setAllowLinker', true]);
			_gaq.push(['_trackPageview']);
			<?php if($ga_code2) : ?>
			_gaq.push(['b._setAccount', '<?php echo isset( $ga_code2 ) ? $ga_code2 : ''; ?>'], ['b._trackPageview']);
			<?php endif; ?>
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();

<?php
		}
	}
?>

</script>