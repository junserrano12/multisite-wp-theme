<?php

	global $DWH_Options, $DWH_Util;

	check_ajax_referer( 'option_ibe_token', 'nonce_sec' );
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL             => $_POST['domain'],
		CURLOPT_RETURNTRANSFER  => true,
		CURLOPT_ENCODING        => "",
		CURLOPT_MAXREDIRS       => 10,
		CURLOPT_TIMEOUT         => 30,
		CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST   => "POST",
		CURLOPT_HTTPHEADER      => array(
											"cache-control: no-cache",
											"content-type: application/x-www-form-urlencoded"
										),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	echo $response;
	
	die();