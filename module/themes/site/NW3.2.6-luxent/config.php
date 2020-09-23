<?php

/* Theme Config */

return array(		
			'details' 	=>	array( 
									'name' => 'NW - Luxent Hotel Theme',
									'description' => '	<ul>
															<li>Full Screen Background slider (1366px x 750px)</li>
															<li>Content is the only scrollable part</li>
															<li>Menu Container is fixed at the top side horizontally list</li>
															<li>Logo and Cta are place at the left side with its own placeholder</li>
															<li>Cta container elements are vertical</li>
															<li>Toggle click drawer button to hide and show content placeholder</li>
															<li>Best for Known Hotel Type not recommended for resort</li>
														</ul>
													',

									'category' => 'NW'
								),
			'sidebars' 	=> 	array(
								array('id'=>'body-top','name'=>'Body Top', 'description' => 'Body Top'),
								array('id'=>'body-bottom','name'=>'Body Bottom', 'description' => 'Body Bottom'),
								array('id'=>'header-container-content','name'=>'Header Content','description'=> 'Header Content'),
								array('id'=>'slider-container-top','name'=>'Slider Container Top','description'=> 'Slider Container Top'),
								array('id'=>'slider-container-content','name'=>'Slider Content','description'=> 'Slider Content'),
								array('id'=>'slider-container-bottom','name'=>'Slider Container Bottom','description'=> 'Slider Container Bottom'),
								array('id'=>'main-container-top','name'=>'Main Container Top','description'=> 'Main Container Top'),
								array('id'=>'main-container-bottom','name'=>'Main Container Bottom','description'=> 'Main Container Bottom'),
								array('id'=>'footer-container-top','name'=>'Footer Container Top','description'=> 'Footer Container Top'),
								array('id'=>'footer-container-content','name'=>'Footer Content','description'=> 'Footer Content'),
								array('id'=>'footer-container-bottom','name'=>'Footer Container Bottom','description'=> 'Footer Container Bottom')
						      ),
			'widgets' 	=> 	array(
								'default'	=> 	array(
				 									'disabled' 	=> 	array(
				 														'WP_Calendar',
				 														'WP_Widget_Archives',
				 														'WP_Widget_Links',
				 														'WP_Widget_Meta',
				 														'WP_Widget_Search',
				 														'WP_Widget_Text',
				 														'WP_Widget_Categories',
				 														'WP_Widget_Recent_Posts',
				 														'WP_Widget_Recent_Comments',
				 														'WP_Widget_RSS',
				 														'WP_Widget_Tag_Cloud',
				 														'Twenty_Eleven_Ephemera_Widget'
						 											)
				 									), 
								'custom' 	=> 	array( 
													'header-container-content' 	=> 	array(
																						'widgets' => array(
																										'widget_menu',
																										'widget_logo',
																										'widget_cta'
																									)

																					),	
													'header-container-bottom' 	=> 	array(
																						'widgets' => array(
																									)

																					),	
													'main-container-bottom' 	=> 	array(
																						'widgets' => array(
																										'widget_social_media',
																										'widget_address_text',
																										'widget_copyright_text'
																									)
																					),
													'slider-container-content' 	=> 	array(
																						'widgets' => array(
																										'widget_slider'
																									)
																					)
							)
						),
			'pages' 	=> array( 'Home', 'Rooms', 'Facilities', 'Location', 'Gallery', 'Promo', 'Contact Us', 'Sitemap' ),
			'menu' 		=> array(
									'primary'     => array( 'Home', 'Rooms', 'Reservation' ),
									'secondary'   => array( 'Home', 'Rooms', 'Facilities', 'Reservation', 'Sitemap' )
							),
			'postypes' 	=> array(),
			'designer' =>   array( 'enable_flag' => false )
			

		);