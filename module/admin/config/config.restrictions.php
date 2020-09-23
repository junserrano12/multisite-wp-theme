<?php
/* 
WP Theme Sections - Restrictions configuration 
Block list - sections declared per user role is where they would be restricted from
*/

return array(


			'Super Admin' => array(
							),
			'Administrator' => array(
							),
			'Editor' => array(
								'caps' => array(

										'delete_others_pages',
										'delete_others_posts',
										'delete_private_pages',
										'delete_private_posts',
										'delete_published_pages',
										'delete_published_posts',
										'edit_others_pages',
										'edit_others_posts',
										'edit_private_pages',
										'edit_private_posts',
										'edit_published_pages',
										'edit_published_posts',
										'manage_categories',
										'manage_links',
										'moderate_comments',
										'publish_pages',
										'publish_posts'


									),
								'metaboxes' => array(

													array( 'enable_flag' => false , 'id' => 'trackbacksdiv' , 'location' => 'normal' ),
													array( 'enable_flag' => false , 'id' => 'postcustom' , 'location' => 'normal' ),
													array( 'enable_flag' => false , 'id' => 'commentstatusdiv' , 'location' => 'normal' ),
													array( 'enable_flag' => false , 'id' => 'commentsdiv' , 'location' => 'normal' ),
													array( 'enable_flag' => false , 'id' => 'slugdiv' , 'location' => 'normal' ),
													array( 'enable_flag' => false , 'id' => 'authordiv' , 'location' => 'normal' ),
													array( 'enable_flag' => false , 'id' => 'postexcerpt' , 'location' => 'normal' ),
													array( 'enable_flag' => false , 'id' => 'postimagediv' , 'location' => 'side' ),
													array( 'enable_flag' => false , 'id' => 'custom_content_section_id' , 'location' => 'normal', 'fieldsets' => array( 'seo' , 'cta' ) ),
													array( 'enable_flag' => false , 'id' => 'custom_post_type_section_promocentric-page' , 'location' => 'normal' ),


													),
								'screen_option' => array( 'enable_flag' => false ),
								'menus' => array(

													array( 'link' => 'edit-comments.php' , 'base' => 'edit-comments.php' ),
													array( 'link' => 'wpcf7' , 'base' => 'toplevel_page_wpcf7' )
											
												),
								'wp_default_editor' => array( 'filter_name' => 'wp_default_editor', 'filter_data' => 'html', 'remove_selector' => '.wp-editor-tabs, #wp-fullscreen-mode-bar' ) /*tinymce, html*/
							),
			'Author' => array(
								'metaboxes' => array(),
								'settings' => array()
							),
			'Conrtibutor' => array(
								'metaboxes' => array(),
								'settings' => array()
							),
			'Subscriber' => array(
								'metaboxes' => array(),
								'settings' => array()
							)

		);


?>