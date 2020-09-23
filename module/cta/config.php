<?php
global $DWH_Options;
$desktopCTALink = str_replace('http://', 'https://', ibe_retiever_url());
$cta_options	= $DWH_Options->get_option_set_data( 'dwh_cta_language' );
$cta_language	= isset($cta_options[0]['cta_language']) ? $cta_options[0]['cta_language'] : 'en';

return array(
			'aw' => array(
						'button' 	=> array(
										'base_url' 	=> $desktopCTALink .'/reservation/selectDates/',
										'param1' 	=> $cta_language,
										'param2'	=> '/0/0/0/0/'
									),
						'calendar' 	=> array(

										'base_url' 	=> $desktopCTALink .'/reservation/showRooms/',
										'param1' 	=> $cta_language,
										'param2'	=> '/0/0/0/0/'
									),
						'processdate' 	=> array(
										'base_url' 	=> $desktopCTALink .'/reservation/showRooms/',
										'param1' 	=> $cta_language,
										'param2'	=> '/0/0/0/0/'
									),
						'moclink' 	=> array(

										'base_url' 	=> $desktopCTALink .'/reservation/modifyCancelPage/',
										'param1' 	=> $cta_language,
										'param2'	=> '/0/0/0/0/'
									),
						'promocode'	=> array(
										'base_url' 	=> $desktopCTALink .'/reservation/showRoomsPromo/',
										'param1' 	=> $cta_language,
										'param2'	=> '',
										'param3' 	=> ''
									)
			),
			'nw' => array(
						'button' 	=> array(
										'base_url' 	=> $desktopCTALink .'/reservation/selectDates/',
										'param1' 	=> $cta_language,
										'param2' 	=> '/0/0/0/0/'
									),
						'calendar' 	=> array(
										'base_url' 	=> $desktopCTALink .'/reservation/showRooms/',
										'param1'    => $cta_language,
										'param2' 	=> '/0/0/0/0/'
									),
						'processdate' 	=> array(
										'base_url' 	=> $desktopCTALink .'/reservation/showRooms/',
										'param1'    => $cta_language,
										'param2' 	=> '/0/0/0/0/'
									),
						'moclink' 	=> array(
										'base_url' 	=> $desktopCTALink .'/reservation/modifyCancelPage/',
										'param1'    => $cta_language,
										'param2' 	=> '/0/0/0/0/'
									),
						'promocode'	=> array(
										'base_url' 	=> $desktopCTALink .'/reservation/showRoomsPromo/',
										'param1'    => $cta_language,
										'param2' 	=> '',
										'param3' 	=> ''
									)
			),
			'promo' => array(
						'flexi' 	=> array(
										'base_url' 	=> $desktopCTALink .'/reservation/',
										'param1' 	=> 'availCalendarFlexi',
										'param2'	=> $cta_language.'/0/0/0/0',
										'param3'	=> 'ppc'
									),
						'promocode'	=> array(
										'base_url' 	=> $desktopCTALink .'/reservation/showRooms/',
										'param1' 	=> $cta_language.'/0/0/0/0/prv/promoCode',
										'param2'	=> 'ppc'
									),
						'calendar'	=> array(
										'base_url' 	=> $desktopCTALink .'/reservation/showRooms/',
										'param1' 	=> $cta_language.'/0/0/ppc/0',
										'param2'	=> 'ppc'
									)
			)
);
?>