<?php

/* Theme Config */

return array(		
				'details' 	=>    array( 
										'name' => 'AW - Default Theme',
										'description' => '	<ul>
																<li>Fixed slider (620px x 420px)</li>
																<li>Sidebar contains logo and Cta Container</li>
																<li>Sidebar is fixed</li>
																<li>Site is scrollable</li>
																<li>Cta Container elements are vertical aligned</li>
																<li>Cta Container include inclusions details</li>
																<li>AW Site</li>
																<li>Promocentric</li>
																<li>Flashdeal</li>																
															</ul>
														 ',														 
										'category' => 'AW'
									),
				'sidebars' 	=> array(
								array('id'=>'body-top','name'=>'Body Top', 'description' => 'Body Top'),
								array('id'=>'body-bottom','name'=>'Body Bottom', 'description' => 'Body Bottom'),
								array('id'=>'header-container-content','name'=>'Header Content','description'=> 'Header Content'),
								array('id'=>'main-container-top','name'=>'Main Container Top','description'=> 'Main Container Top'),
								array('id'=>'main-container-bottom','name'=>'Main Container Bottom','description'=> 'Main Container Bottom'),
								array('id'=>'sidebar-container-content','name'=>'Sidebar Content', 'description' => 'Sidebar Content'),
								array('id'=>'primary-header-content','name'=>'Primary Header Content','description'=> 'Primary Header Content'),
								array('id'=>'primary-footer-content','name'=>'Primary Footer Content','description'=> 'Primary Footer Content'),
								array('id'=>'slider-container-content','name'=>'Slider Content','description'=> 'Slider Content'),
								array('id'=>'footer-container-content','name'=>'Footer Content','description'=> 'Footer Content')
								  ),
				'widgets' 	=> array(
 
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
															'header-container-content' => array(

																								'widgets' => array(

																													'widget_ga_translate'
																												  )

																								),
															'sidebar-container-content' => array(

																								'widgets' => array(
																													'widget_logo',
																													'widget_cta'
																												  )

																								),
															'primary-header-content' => array(

																								'widgets' => array(
																													'widget_menu'
																												  )

																								),
															'footer-container-content' => array(

																								'widgets' => array( 
																													'widget_address_text',
																													'widget_copyright_text'
																												  )

																								),
															'slider-container-content' => array(

																								'widgets' => array(
																													'widget_slider'
																												  )

																								)
														  )
									),
				'pages' 	=> array( 'Home', 'Rooms', 'Facilities', 'Location' ),
				'menu' 		=> array(
										'primary'     => array('Home', 'Rooms', 'Facilities', 'Location', 'Reservation')
								),
				'postypes' 	=> array('flashdeal', 'promocentric'),
				'designer' 	=>   array( 'enable_flag' => true )


				

			);


?>