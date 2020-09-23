<?php
/* Custom post type custom fields */

global $post;
$post_id = $post->ID;


return array(
				'tagline' 	=> get_post_meta( $post_id, 'tagline', true ),
				'promo_group' => get_post_meta( $post_id, 'promo_group', true  ),
				'page_theme' => get_post_meta( $post_id, 'page_theme', true ) 
			);


?>
