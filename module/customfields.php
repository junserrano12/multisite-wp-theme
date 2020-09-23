<?php
/*
Function: Autoload Post Types
*/


/* Post Types Class */
if(file_exists(get_template_directory().'/module/core/class.customfields.php'))
	require_once(get_template_directory().'/module/core/class.customfields.php');

$DWH_CustomFields = new DWH_CustomFields();

global $DWH_Admin;

/* include Components */

/* Custom Post Types */
$dir = str_replace('\\', '/',get_template_directory()).'/module/post-types';
$posttypes = array();

if(file_exists( $dir ))
{
	$dir = scandir( $dir );

	foreach($dir as $dir_item)
	{
		if($dir_item!='.'&& $dir_item!='..')
		{
			$posttype = $dir_item;

			/* Dont include page on collections */
			if( $dir_item != 'page')
			{
				$posttypes[] = $dir_item;
				$DWH_CustomFields->load( 'post-types' , $posttype );
			}


		}
	}

}

array_push( $posttypes, 'page' );

/* load Page custom fields */
$DWH_CustomFields->add_custom_fields_meta_box( $posttypes, 'post-types', 'page');


if( !$DWH_Admin->is_restricted( DWH_USER_ROLE , 'metaboxes' , 'id' , 'custom_content_section_id' ) )
{
	/* call add metabox for custom content shortcode */
	add_page_inner_custom_content_box( $posttypes );
}

/* Load Slider Custom field */
$DWH_CustomFields->add_custom_fields_meta_box( $posttypes, 'sliders' , 'base' );


/* Update Metabox Display Sequence */
if( $posttypes ){
	foreach( $posttypes as $key => $val ){

		$meta_order_dir =  get_template_directory() . '/module/post-types/'. $val .'/config.metaboxes.order.php';
		if( file_exists( $meta_order_dir ) )
		{
			$meta_order_config = include( $meta_order_dir );
			$metabox_order = get_user_meta( get_current_user_id(), 'meta-box-order_'. $val, true );

			if(isset($metabox_order['normal'])) $metabox_order['normal'] = implode( ',', $meta_order_config );

			update_user_meta( get_current_user_id(), 'meta-box-order_'. $val, $metabox_order );
		}

	}
}