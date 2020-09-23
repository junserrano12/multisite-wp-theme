<?php

$organic_clicker_text = 'organic-clickers';
$ppc_clicker_text = 'ppc-clickers';

return array(
						
				'aw' => array( 

							'reservation-menu' 	=>	array( 
														'category' 			=> "'".$ppc_clicker_text."'",	
														'action' 			=> "'go-to-select-dates'",
														'opt_label' 		=> "'reservation-menu'", 
														'non_interaction'  	=> 'false'
													),
							'reservation-menu-footer' =>	array( 
														'category' 			=> "'ppc-clickers'",	
														'action' 			=> "'go-to-select-dates'",
														'opt_label' 		=> "'reservation-footer-menu'", 
														'non_interaction'  	=> 'false'
													),
							'cta-button' 		=>	array( 
														'category' 			=> "'".$ppc_clicker_text."'",	
														'action' 			=> "'go-to-select-dates'",
														'opt_label' 		=> "'cta-button'",
														'non_interaction'  	=> 'false'
													),
							'cta-link' 		=>	array( 
														'category' 			=> "'".$ppc_clicker_text."'",	
														'action' 			=> "'go-to-select-dates'",
														'opt_label' 		=> "'cta-button'",
														'non_interaction'  	=> 'false'
													),
							'modify-cancel' 	=>	array( 
														'category' 			=> "'".$ppc_clicker_text."'",	
														'action' 			=> "'modify-cancel'",
														'opt_label' 		=> "'text-link'",
														'non_interaction'  	=> 'false'
													),
							'calendar-widget' 	=>	array( 
														'category' 			=> "'".$ppc_clicker_text."'",	
														'action' 			=> "'go-to-showrooms'",
														'opt_label' 		=> "'calendar-widget'",
														'non_interaction'  	=> 'false'
													),
							'promocentric' 	=>	array( 
														'category' 			=> "'".$ppc_clicker_text."'",	
														'action' 			=> "'promo-centric'",
														'opt_label' 		=> "''", /* promo id will be append on the promo view */
														'non_interaction'  	=> 'false'
													),
							'flashdeal' 	=>	array( 
														'category' 			=> "'".$ppc_clicker_text."'",	
														'action' 			=> "'flash-deal'",
														'opt_label' 		=> "''", /* promo id will be append on the promo view */
														'non_interaction'  	=> 'false'
													)
						),
				'nw' => array( 

								'reservation-menu' 	=>	array( 
															'category' 			=> "'".$organic_clicker_text."'",	
															'action' 			=> "'go-to-select-dates'",
															'opt_label' 		=> "'reservation-menu'", 
															'non_interaction'  	=> 'false'
														),
								'reservation-menu-footer' =>	array( 
															'category' 			=> "'".$organic_clicker_text."'",	
															'action' 			=> "'go-to-select-dates'",
															'opt_label' 		=> "'reservation-footer-menu'", 
															'non_interaction'  	=> 'false'
														),
								'cta-button' 		=>	array( 
															'category' 			=> "'".$organic_clicker_text."'",	
															'action' 			=> "'go-to-select-dates'",
															'opt_label' 		=> "'cta-button'",
															'non_interaction'  	=> 'false'
														),
								'cta-link' 		=>	array( 
															'category' 			=> "'".$organic_clicker_text."'",	
															'action' 			=> "'go-to-select-dates'",
															'opt_label' 		=> "'text-link'",
															'non_interaction'  	=> 'false'
														),
								'modify-cancel' 	=>	array( 
															'category' 			=> "'".$organic_clicker_text."'",	
															'action' 			=> "'modify-cancel'",
															'opt_label' 		=> "'text-link'",
															'non_interaction'  	=> 'false'
														),
								'calendar-widget' 	=>	array( 
															'category' 			=> "'".$organic_clicker_text."'",	
															'action' 			=> "'go-to-showrooms'",
															'opt_label' 		=> "'calendar-widget'",
															'non_interaction'  	=> 'false'
														),
								'text-link-footer' 	=>	array( 
															'category' 			=> "'".$organic_clicker_text."'",	
															'action' 			=> "'go-to-select-dates'",
															'opt_label' 		=> "'text-link-footer'",
															'non_interaction'  	=> 'false'
														)

							 )


			);

?>