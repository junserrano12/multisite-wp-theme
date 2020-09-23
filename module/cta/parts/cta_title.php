<?php 
/*
BPG TITLE
*/
global $DWH_Theme;
extract($data);

$cta_title 				= isset( $cta_settings['cta_title'] ) ? $cta_settings['cta_title'] : null;
$hotel_name 			= isset( $hotel_info['hotel_name'] ) ? $hotel_info['hotel_name'] : null;
$site_theme_config 		= $DWH_Theme->get_site_theme_config();
$site_theme_category 	= strtolower($site_theme_config['details']['category']);
$titleopentag 			= ($site_theme_category == 'aw') ? '<span class="bpglinkcontainer">' : '<h3>';
$titleclosetag			= ($site_theme_category == 'aw') ? '</span>' : '</h3>';

if( isset( $cta_settings['cta_bpg_tip'] ) && ( $cta_settings['cta_bpg_tip'] != '' ) ) {
 	$cta_bpg_tip 		=  $cta_settings['cta_bpg_tip'];
} else {
	$data['dir'] 		= array('module/collections','views','texts');
	$data['view'] 		= 'bpg_tip';
	$data['str_val']	= $hotel_name;
	$data['str_rep']	= '$hotelname';
	$cta_bpg_tip		= replace_file_str_val( $data );
}

if( $cta_settings['cta_bpg'] == 'cta_bpg' ){ ?>
	<div class="control-wrapper cta-title-container">
		<?php echo $titleopentag; ?>
			<a class="colorbox-inline bpglinksmall" href="#bpgmodal"><span class="bpgcheck"></span><?php echo $cta_title; ?></a>
			<a class="bpgtip">
				<div id="bpgtipcontent">
					<span><?php echo $cta_bpg_tip; ?></span>
				</div>
			</a>
		<?php echo $titleclosetag; ?>		
	</div>
<?php } else { ?>
<div class="control-wrapper cta-title-container">
	<h3><?php echo $cta_settings['cta_title'];?></h3>
</div>
<?php } ?>