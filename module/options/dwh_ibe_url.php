<?php

global $DWH_Options;
/* Get Hotel Info*/
$hotels 				= $DWH_Options->get_dwh_site_option_set('dwh_hotels');
$hotel_info 			= array();

/* Set Hotel Branches*/
foreach ($hotels as $key => $hotel) {
	$data['hotel_branches'][] = $hotel;
}

$hid = $data['hotel_branches'];
$hid_arr_str = '';
if(count($hid) > 1){
	foreach($hid as $key=>$value){
		foreach($value as $key_id=>$val_hid){
			if($key_id == 'hotel_id'){
				//echo $val_hid.'<br />';
				$hid_arr_str .= $val_hid . ',';
			}
		}
	}
	$hid_arr_str = substr($hid_arr_str,0,-1);
}else{
	$hotel_info  = $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0);
	$hid_arr_str = $hotel_info->hotel_id;
}



return array(

				'details' => array(
										'title' => 'IBE URL',
										'description' => 'Fetch custom domain for CTA button and links',
										'category' => 'scripts',
										'multiple' => 1,
										'block_list' => array( 'editor' )
								),
				'settings' => array(

										'ibe_desktop_url'  => array(

															'properties' => array(
																					'control_type'	 	=> 'text',
																					'field_title' 		=> '',
																					'field_token' 		=> '42e0207a1278481b82c24dc898396530c8f4725a',
																					'field_issue_token' => 'https://reservations.directwithhotels.com/PropertySubdomain/issueToken',
																					'field_domain' 		=> 'https://reservations.directwithhotels.com/PropertySubdomain/get',
																					'field_hid_arr'		=> $hid_arr_str, //hotel IDs separated with comma if corpsite
																					'field_description' => "",
																					'required'          => 1
																				  )

															)


								   )

			);

?>