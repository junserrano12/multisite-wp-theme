<?php
/*
BPG INCLUSIONS
*/

extract($data);
$cta_title 				= isset( $cta_settings['cta_title'] ) ? $cta_settings['cta_title'] : null;
$hotel_name 			= isset( $hotel_info['hotel_name'] ) ? $hotel_info['hotel_name'] : null;

if( isset( $cta_settings['cta_bpg_inclusion'] ) && ( $cta_settings['cta_bpg_inclusion'] != '' ) ) {
 	$bpg_inclusions 	=  $cta_settings['cta_bpg_inclusion'];
} else {
	$data['dir'] 		= array('module/collections','views','texts');
	$data['view'] 		= 'bpg_inclusions';
	$data['str_val']	= $hotel_name;
	$data['str_rep']	= '$hotelname';
	$bpg_inclusions		= replace_file_str_val( $data );
}
?>
<div class="control-wrapper cta-inclusions-container">
	<?php echo $bpg_inclusions; ?>
</div>