<?php

	/* Media Custom fields */
	if( $post ) $post_id = isset( $post->ID ) ? $post->ID : '';

	return array(
					'attachment_image_link' => array(
													'label' => __( 'Custom Link' ),
													'input' => 'text',
													'value' => get_post_meta( $post_id, "attachment_image_link", true),
													'helps' => __( 'Add image custom url link' )
												),
					'attachment_image_class' => array(
													'label' => __( 'Custom Class' ),
													'input' => 'text',
													'value' => get_post_meta( $post_id, "attachment_image_class", true),
													'helps' => __( 'Add image custom class' )
												),
					'attachment_image_title' => array(
													'label' => __( 'Image Title' ),
													'input' => 'text',
													'value' => get_post_meta( $post_id, "attachment_image_title", true),
													'helps' => 'Provide another image title'
												),
					'attachment_image_alt' => array(
													'label' => __( 'Image Alt' ),
													'input' => 'text',
													'value' => get_post_meta( $post_id, "attachment_image_alt", true),
													'helps' => __( 'Provide another image alt' )
												),
					'attachment_offset' => array(
													'label' => __( 'Offset' ),
													'input' => 'text',
													'value' => get_post_meta( $post_id, "attachment_offset", true),
													'helps' => __( 'The image offset' )
												)
				);
		
?>