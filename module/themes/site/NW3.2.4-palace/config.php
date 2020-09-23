<?php

/* Theme Config */

return array(		
	'details' 	=>	array( 
						'name' => 'NW - Palace Hotel Theme',
						'description' => '	<ul>
												<li>Wide slider (1366px x 550px)</li>
												<li>Site is scrollable</li>
												<li>Single Primary Menu Container</li>
												<li>Logo and Cta container is in a single placeholder together</li>
												<li>Cta container elements are vertical</li>
												<li>Can be used for Resort and Hotel Type</li>												
											</ul
>										 ',
						'category' => 'NW'
					),
	'sidebars' 	=> array(
						array('id'=>'body-top','name'=>'Body Top', 'description' => 'Body Top'),
						array('id'=>'body-bottom','name'=>'Body Bottom', 'description' => 'Body Bottom'),
						array('id'=>'header-container-top','name'=>'Header Container Top','description'=> 'Top Header Container'),
						array('id'=>'header-container-content','name'=>'Header Container Content','description'=> 'Header Container Content'),
						array('id'=>'header-container-bottom','name'=>'Header Container Bottom','description'=> 'Bottom Header Container'),
						array('id'=>'slider-container-top','name'=>'Slider Container Top','description'=> 'Slider Container Top'),
						array('id'=>'slider-container-content','name'=>'Slider Content','description'=> 'Slider Content'),
						array('id'=>'slider-container-bottom','name'=>'Slider Container Bottom','description'=> 'Slider Container Bottom'),
						array('id'=>'main-container-top','name'=>'Main Container Top','description'=> 'Main Container Top'),
						array('id'=>'main-container-content','name'=>'Main Container Content','description'=> 'Main Container Content'),
						array('id'=>'main-container-bottom','name'=>'Main Container Bottom','description'=> 'Main Container Bottom'),
						array('id'=>'footer-container-top','name'=>'Footer Container Top','description'=> 'Footer Container Top'),
						array('id'=>'footer-container-content','name'=>'Footer Content','description'=> 'Footer Content'),
						array('id'=>'footer-container-bottom','name'=>'Footer Container Bottom','description'=> 'Footer Container Bottom')
			    	),
	'widgets' 	=> array(
						'default' 	=> 	array(
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
						'custom' 	=> 	array( 
											'header-container-content' 	=> 	array(
																				'widgets' => array(
																								'widget_ga_translate',
																								'widget_logo',
																								'widget_menu'
																							)
																				),
											'slider-container-content' 	=> 	array(
																				'widgets' => array(
																								'widget_slider'
																							)
																				),
											'slider-container-bottom' 	=> 	array(
																				'widgets' => array(
																								'widget_cta'
																							)
																				),
											'footer-container-content' 	=> 	array(
																				'widgets' => array(
																								'widget_menu_secondary',
																								'widget_address_text',
																								'widget_social_media',
																								'widget_copyright_text'
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

/*end config*/