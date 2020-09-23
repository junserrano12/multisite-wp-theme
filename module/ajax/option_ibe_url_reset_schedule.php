<?php

	global $DWH_Options, $DWH_Util;

	check_ajax_referer( 'option_ibe_url_reset_schedule', 'nonce_sec' );

	update_option('ibeLastUpdate', '');

	$response = array(
						'msg' => 'Successfully reset'
					);


		echo json_encode($response);

	die();
