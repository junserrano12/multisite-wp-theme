<?php
$result = array();
$result = array('updated'=>'','ibe_url'=>'','forbidden'=>'0','error'=>'');	/* set array values */

$nonce = wp_create_nonce($_POST['security']);
if ( ! wp_verify_nonce( $nonce, 'dwh-ibeurl-security-nonce' ) )
{
	$result['forbidden'] = '1';
	$result['error']     = 'Forbidden Page';
	echo json_encode($result);
	die();
}

$urlpattern   = "/\b(?:(?:https?|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
$new_ibeurl   = isset($_POST['ibeurl']) && $_POST['ibeurl'] != '' ? trim($_POST['ibeurl']) : '';
$domain       = isset($_POST['domain']) && $_POST['domain'] != '' ? trim($_POST['domain']) : '';
$hotel_id     = isset($_POST['hotel_id']) && $_POST['hotel_id'] != '' ? trim($_POST['hotel_id']) : '';
$hid          = false;

/* do validation */
if( $domain == '' ){
	$result['error']     = 'Hotel Website field must not be empty';
}else if( $new_ibeurl == '' ){
	$result['error']     = 'IBE URL field must not be empty';
}else if( !filter_var( $domain, FILTER_VALIDATE_URL) ||  !filter_var( $new_ibeurl, FILTER_VALIDATE_URL) ){
	$result['error']     = 'Failed: Invalid URL was found, please check both fields';
}else if( $hotel_id == '' ){
	$result['error']     = 'Hotel ID is important';
}else if( !is_numeric($hotel_id) ){
	$result['error']     = 'Hotel ID is not valid';
}else if( !preg_match($urlpattern, $new_ibeurl) ){
	$result['error']     = 'Failed: Invalid URL was found, please check fields';
}else{

	$data     = get_option('onetheme_hotel_options');/* retrieve data */	
	
	if(is_array($data) && count($data) > 0) {
		
		$data_json1 = json_encode($data);
		
		if($new_ibeurl != ''){
			
			$type = $data['type'];			
				
			if( isset($data['hotel-single']) ){/* for single hotel */
				if(array_key_exists( 'hotel_subdomain',$data['hotel-single'] )){
					
					if($data['hotel-group']['hotel_id'] == $hotel_id){
						$data['hotel-single']['hotel_subdomain'] = $new_ibeurl;
					}
				}
			}						
			
			if( isset($data['hotel-group'])){/* for group hotel */
				$hotel_group = $data['hotel-group'];

				if( is_array($hotel_group) ){
					foreach($hotel_group as $key=>$index){
						if( array_key_exists('hotel_subdomain',$hotel_group[$key]) ){
							
							if($data['hotel-group'][$key]['hotel_id'] == $hotel_id){
								$hid = true;
								$data['hotel-group'][$key]['hotel_subdomain'] = $new_ibeurl;									
							}
							
						}
					}
				}
			}				

			if(!$hid && $type != 'single'){
				$result['error']   = 'Hotel ID not found';
			}else{
				
				update_option('onetheme_hotel_options', $data);/* update option */
				
				$data2      = get_option('onetheme_hotel_options');/* retrieve data */
				$data_json2 = json_encode($data2);
				
				/* validate if new ibeurl is successfully saved */
				if( $data_json1 !=  $data_json2 ){
					$result['updated']   = '1';
					$result['ibe_url']   = $new_ibeurl;
				}else{
					$result['error']   = 'Update failed';
				}
				
			}				
			
		}else{
			$result['error']   = 'Unable to continue, empty IBE URL field';
		}

	}else{/* option name is not set */
		$result['error'] = 'Option name not set';
	}
}
$result['json'] = json_encode($data); 
echo json_encode($result);
wp_die();