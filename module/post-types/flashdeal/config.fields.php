<?php
/* Custom post type custom fields */

global $post;
$post_id = $post->ID;

return array(
				'iscustompage' => '',
				'iscustomflashpage' => get_post_meta( $post_id, 'iscustomflashpage', true ),
				'tagline' => get_post_meta( $post_id, 'tagline', true ),
				'promoid' => get_post_meta( $post_id, 'promoid', true ),
				'start_date' => get_post_meta( $post_id, 'start_date', true ),
				'end_date' => get_post_meta( $post_id, 'end_date', true ),
				'promo_end_date' => get_post_meta( $post_id, 'promo_end_date', true ),
				'catchphrase' => '<span>Limited Time Offer</span>',
				'page_theme' => get_post_meta( $post_id, 'page_theme', true ),
				'migrated' => get_post_meta( $post_id, 'migrated', true )
			);


?>
