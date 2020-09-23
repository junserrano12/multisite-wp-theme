<?php
/* Custom post type custom fields */

global $post;
$post_id = $post->ID;

return array(
					'title_field' 		=> get_post_meta( $post_id, 'title_field', true ),
					'address_field' 	=> get_post_meta( $post_id, 'address_field', true ),
					'page_title_field' 	=> get_post_meta( $post_id, 'page_title_field', true ),
					'meta_keywords' 	=> get_post_meta( $post_id, 'meta_keywords', true ),
					'meta_description' 	=> get_post_meta( $post_id, 'meta_description', true ),
					'meta_robots' 		=> get_post_meta( $post_id, 'meta_robots', true ),
					'page_theme' 		=> get_post_meta( $post_id, 'page_theme', true ),
					'cta_display_flag' 	=> get_post_meta( $post_id, 'cta_display_flag', true ),
					'h1_display_flag' 	=> get_post_meta( $post_id, 'h1_display_flag', true )
				);
?>