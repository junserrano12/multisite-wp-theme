<?php

/* Theme Config */

return array(		
				'details' =>    array( 
										'name' => 'NW - Microtel Theme',
										'description' => 'The Menu is place on top of the logo and slider, The Logo container is beside slider and the content is just below the slider it has a left sidebar container',
										'description' => '	<ul>
																<li>Fixed slider (686px x 300px)</li>
																<li>Logo is beside slider</li>
																<li>Sidebar contains cta</li>
																<li>Site is scrollable</li>
																<li>Cta container elements are horizontal</li>
																<li>Hotel Type Template</li>
															</ul>
														 ',
										'category' => 'NW'
									),
				'sidebars' => array(
								array('id'=>'body-top','name'=>'Body Top', 'description' => 'Body Top'),
								array('id'=>'body-bottom','name'=>'Body Bottom', 'description' => 'Body Bottom'),
								array('id'=>'header-container-top','name'=>'Header Container Top','description'=> 'Header Container Top'),
								array('id'=>'header-container-content','name'=>'Header Container Content','description'=> 'Header Container Content'),
								array('id'=>'header-container-bottom','name'=>'Header Container Bottom','description'=> 'Header Container Bottom'),
								array('id'=>'main-container-top','name'=>'Main Container Top','description'=> 'Main Container Top'),
								array('id'=>'main-container-bottom','name'=>'Main Container Bottom','description'=> 'Main Container Bottom'),
								array('id'=>'footer-container-top','name'=>'Footer Container Top','description'=> 'Footer Container Top'),
								array('id'=>'footer-container-content','name'=>'Footer Content','description'=> 'Footer Content'),
								array('id'=>'footer-container-bottom','name'=>'Footer Container Bottom','description'=> 'Footer Container Bottom'),
								array('id'=>'sidebar-container-content','name'=>'Sidebar Content','description'=> 'Sidebar Content'),
							      ),
				'widgets' => array(
 
										'default' => array(
						 									'disabled' => array(
						 										
						 														'WP_Pages',
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
		
										'custom' => array( 
																
																'header-container-top' => array(
																									'widgets' => array(
																														'widget_ga_translate',
																														'widget_menu'
																													  )
																									),
																'header-container-content' => array(
																									'widgets' => array(
																														'widget_logo',
																														'widget_slider'
																													  )
																									),
																'footer-container-content' => array(

																									'widgets' => array(
																														'widget_menu_secondary',
																														'widget_address_text',
																														'widget_social_media',
																														'widget_copyright_text'
																													  )

																									),
																'sidebar-container-content' => array(

																									'widgets' => array(
																														'widget_cta'
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