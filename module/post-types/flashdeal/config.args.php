<?php

return array(
			'label'               => __( $this->posttype , $val['text_domain'] ),
			'description'         => __( $val['description'], $val['text_domain'] ),
			'labels'              => $this->labels,
			'supports'            => array( 
										'title', 
										'editor', 
										'excerpt', 
										'author', 
										'thumbnail', 
										'comments', 
										'trackbacks', 
										'revisions', 
										'custom-fields', 
										'page-attributes', 
										'post-formats', 
									),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => $val['menu_position'],
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'menu_position'		  => 7

		);

?>