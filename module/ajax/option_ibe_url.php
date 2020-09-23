<?php

	global $DWH_Options, $DWH_Util;

	check_ajax_referer( 'option_ibe_url', 'nonce_sec' );

$url_arr       = array();	
$IBEDomain     = $_POST['domain'];	
$assignedToken = $_POST['token'];
$IDs_array     = $_POST['property_ids'];
$IDs_array     = explode(',',$IDs_array);
$genToken = '';
function tk_encrypt($token,$id){
	$token = sha1($token . $id);
	return $token;
}
foreach($IDs_array as $key=>$value){
	$curl = curl_init();
		
	$genToken = tk_encrypt($assignedToken,$value);

	curl_setopt_array($curl, array(
		CURLOPT_URL             => $IBEDomain,
		CURLOPT_RETURNTRANSFER  => true,
		CURLOPT_ENCODING        => "",
		CURLOPT_MAXREDIRS       => 10,
		CURLOPT_TIMEOUT         => 30,
		CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST   => "POST",
		CURLOPT_POSTFIELDS      => "property_id=".$value."&token=".$genToken,
		CURLOPT_HTTPHEADER      => array(
											"cache-control: no-cache",
											"content-type: application/x-www-form-urlencoded"
										),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	$response = (array)json_decode($response,true); //convert the returned json to array
	$url_arr[$value] = $response;
	
}	
	
	
	echo json_encode($url_arr);
	
die();	
