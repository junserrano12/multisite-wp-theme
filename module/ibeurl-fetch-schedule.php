<?php

add_action('init','trigger_this');
function trigger_this(){

	global $DWH_Options;
	$ibe_sync_interval = $DWH_Options->get_option_set_data( 'dwh_ibe_url_switch' );
	$interval = isset($ibe_sync_interval[0]['ibe_url_switch_interval']) ? $ibe_sync_interval[0]['ibe_url_switch_interval'] : 8; /*default is 8hours*/
	$intervalUpdate = 60*60*$interval;
	$currentTime = time(); /* get current time */
	$lastUpdatedTime = (get_option('ibeLastUpdate') != null && get_option('ibeLastUpdate') != '') ? get_option('ibeLastUpdate') : $currentTime;

	if( $currentTime >= (int)$lastUpdatedTime ){
		$newschedule = $currentTime + (int)$intervalUpdate; /* set new schedule */
		update_option( 'ibeLastUpdate', $newschedule ); /* update last updated time*/
		update_ibe_url();
	}
}

function update_ibe_url() {
	global $DWH_Options;
	$config_ibeurl = include_once(get_template_directory().'/module/options/dwh_ibe_url.php');
	$getIssuedToken = $config_ibeurl['settings']['ibe_desktop_url']['properties']['field_issue_token'];
	$getDomainIBE   = $config_ibeurl['settings']['ibe_desktop_url']['properties']['field_domain'];

	$ibe_url    = $DWH_Options->get_option_set_data( 'dwh_ibe_url' );
   	$ibeSwitch 	= $DWH_Options->get_dwh_site_option_set('dwh_ibe_url_switch');
	$ibeSwitch  = (array)$ibeSwitch;
	$ibeSwitch  = isset($ibeSwitch[0]['ibe_url_switch']) ? $ibeSwitch[0]['ibe_url_switch'] : '';

	$issuedToken    = custom_curl($getIssuedToken);

	$hotelIds = getHotelInfo();
	$hoteilIDAndIBEDomain = array();
	if(count($hotelIds) > 0){
		foreach($hotelIds as $key=>$hid){
			$tokenIs = sha1($issuedToken . $hid);
			$domainIBE = custom_curl($getDomainIBE,$hid,$tokenIs);
			$hoteilIDAndIBEDomain[$hid] = $domainIBE;
		}
	}

	$fetchedDomainResult = json_encode($hoteilIDAndIBEDomain);
	$ibe_domain          = array();
	$ibe_domain[0]['ibe_desktop_url'] = $fetchedDomainResult;

	/* update if switch is equal to yes, default: the system will set to auto even switch is not yet set */
	if($ibeSwitch == '' || $ibeSwitch == NULL || $ibeSwitch == 1){
		if($ibe_url != $ibe_domain){
			update_option( 'dwh_ibe_url', $ibe_domain );
		}
	}
}

function getHotelInfo(){
	global $DWH_Options;
	/* Get Hotel Info*/
	$hotels 				= $DWH_Options->get_dwh_site_option_set('dwh_hotels');
	$hotel_info 			= array();

	/* Set Hotel Branches*/
	foreach ($hotels as $key => $hotel) {
		$data['hotel_branches'][] = $hotel;
	}

	$hid = $data['hotel_branches'];
	$hid_arr_str = array();
	if(count($hid) > 1){
		foreach($hid as $key=>$value){
			foreach($value as $key_id=>$val_hid){
				if($key_id == 'hotel_id'){
					$hid_arr_str[] = $val_hid;
				}
			}
		}
	}else{
		$hotel_info  = $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0);
		$hid_arr_str[] = $hotel_info->hotel_id;
	}

	return $hid_arr_str;
}

function custom_curl($url,$hotel_id=false,$issuedToken = false){

	$curl = curl_init();

	$postFields = ($hotel_id && $issuedToken) ? "property_id=".$hotel_id."&token=".$issuedToken : '';

	curl_setopt_array($curl, array(
		CURLOPT_URL             => $url,
		CURLOPT_RETURNTRANSFER  => true,
		CURLOPT_ENCODING        => "",
		CURLOPT_MAXREDIRS       => 10,
		CURLOPT_TIMEOUT         => 30,
        CURLOPT_HEADER          => false,
		CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST   => "POST",
		CURLOPT_POSTFIELDS      => $postFields,
		CURLOPT_HTTPHEADER      => array(
											"cache-control: no-cache",
											"content-type: application/x-www-form-urlencoded"
										),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	$response = (array)json_decode($response,true);
	$response = ( $err ) ? $err : $response;

	if($postFields == '' && !$err){
		return $response['data']['token'];
	}else{
		return $response;
	}


}


?>