<?php
return array(
			array(
				'type'		=> 'local',
				'handle' 	=> 'jquery',
				'src'  		=> get_template_directory_uri() . '/js/lib/jquery.min.js',
				'deps' 		=> '',
				'ver'		=> '1.0',
				'in_footer' => false
			),
			array(
				'type'		=> 'local',
				'handle' 	=> 'require',
				'src'  		=> get_template_directory_uri() . '/js/v1/require.min.js',
				'deps' 		=> array('jquery'),
				'ver'		=> '1.2',
				'in_footer' => true
			)
	);
?>