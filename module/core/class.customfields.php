<?php
/*

Function: Core Custom Fields Class

*/


Class DWH_CustomFields
{	
	public $custom_field_set;
	public $custom_field_item;
	public $slider_field_item;

	function __contruct() { }

	/**
	 * Load the custom fields for a specific custom post type
	 *
	 * @param  string   $name Name of the module to load from
	*/ 
	function load( $custom_field_set , $custom_field_item )
	{		
		$this->custom_field_set = $custom_field_set;
		$this->custom_field_item = $custom_field_item;
		$this->add_post_type_meta_box( $custom_field_set , $custom_field_item );
		$this->save_post( $custom_field_set , $custom_field_item );
	}
	
	/* function load_attachment_fields()
	{
		$this->add_attachment_fields();
		$this->save_attachment_fields();
	
	}
	
	function add_attachment_fields()
	{	
		add_filter( 'attachment_fields_to_edit', function( $form_fields, $post ){
		
				$custom_fields = include( get_template_directory().'/module/attachments/media/config.fields.php' );
				
				foreach( $custom_fields as $key => $value ){
					
					$form_fields[ $key ] = $value;
				
				}
				
				return $form_fields;
		
		});
		
	}
	
	function save_attachment_fields()
	{	
		add_filter( 'attachment_fields_to_save', function( $post, $attachment ){
		
				$custom_fields = include( get_template_directory().'/module/attachments/media/config.fields.php' );
				
				foreach( $custom_fields as $key => $value ){
					
					if( isset( $attachment[ $key ] ) ){
					
						update_post_meta( $post['ID'], $key, $attachment[ $key ]);
						
					}
				}
					
				return $post;
		
		});
		
	} */

	function add_post_type_meta_box( $custom_field_set , $custom_field_item )
	{
		add_action('add_meta_boxes', function() use( $custom_field_set , $custom_field_item ) {
					
			$dir = get_template_directory().'/module/'.$custom_field_set. '/' .$custom_field_item.'/config.details.php';
			
			if(file_exists( $dir ))
			{
				$custom_field_set_details = include( $dir );
			
				add_meta_box('custom_post_type_section_id', $custom_field_set_details['title'], function() use( $custom_field_set , $custom_field_item ){
						
						$custom_fields = $this->get_fields( $custom_field_set , $custom_field_item );
						$data['type'] = $custom_field_item;
						$data['dir'] = array('module',$custom_field_set , $custom_field_item ,'views');
						$data['view'] = $custom_field_item;
						$data['customfields'] = $custom_fields;
						load_view( $data );

				},  $custom_field_item );
			}
			
		});

	}

	function add_custom_fields_meta_box( $posttypes , $custom_field_set , $custom_field_item )
	{
			
		/* assign current slider item */
		if( $custom_field_set == 'sliders' ) 
			$this->slider_field_item = $custom_field_item != '' ? $custom_field_item : 'base';
			
			add_action('add_meta_boxes', function() use( $posttypes, $custom_field_set , $custom_field_item ) {
					
				$custom_field_item_info = include( get_template_directory().'/module/'.$custom_field_set.'/'.$custom_field_item.'/config.details.php' );

				foreach ($posttypes as $key => $posttype_section ) {
					
					add_meta_box('custom_post_type_section_'.$posttype_section . '-' . $custom_field_item , $custom_field_item_info['title'], function() use( $custom_field_set , $custom_field_item ){

							$custom_fields = $this->get_fields( $custom_field_set , $custom_field_item );
							$data['type'] = $custom_field_item;
							$data['dir'] = array('module',$custom_field_set , $custom_field_item , 'admin' ,'views');
							$data['view'] = $custom_field_item;
							$data['customfields'] = $custom_fields;
							
							load_view( $data );

					},  $posttype_section );

				}
		});

		$this->save_post( $custom_field_set , $custom_field_item );
	}
	
	/* custom content shortcode */
	function add_custom_content_fields_meta_box( $posttypes , $custom_field_set , $custom_field_item )
	{
		
		/* assign current slider item */
		if( $custom_field_set == 'sliders' ) 
			
			$this->slider_field_item = $custom_field_item != '' ? $custom_field_item : 'base';
		
		
		add_action('add_meta_boxes', function() use( $posttypes, $custom_field_set , $custom_field_item ) {
				
			$custom_field_item_info = include( get_template_directory().'/module/'.$custom_field_set.'/'.$custom_field_item.'/config.details.php' );

			foreach ($posttypes as $key => $posttype_section ) {
				
				add_meta_box('custom_post_type_section_'.$posttype_section . '-' . $custom_field_item , $custom_field_item_info['title'], function() use( $custom_field_set , $custom_field_item ){

						$custom_fields = $this->get_fields( $custom_field_set , $custom_field_item );
						$data['type'] = $custom_field_item;
						$data['dir'] = array('module',$custom_field_set , $custom_field_item , 'admin' ,'views');
						$data['view'] = $custom_field_item;
						$data['customfields'] = $custom_fields;
						
						load_view( $data );

				},  $posttype_section );

			}

		});

		$this->save_post( $custom_field_set , $custom_field_item );
	}
	
	/*
	Gets the fields based on a specific post type
	@param (string) - Name of the post type
	@return (array) - post type config and values
	*/
	function get_fields( $custom_field_set , $custom_field_item )
	{	
		$post_type_fields = include( get_template_directory().'/module/'.$custom_field_set.'/'.$custom_field_item.'/config.fields.php' );
		return $post_type_fields;
	}



	function save_post( $custom_field_set , $custom_field_item ) {
		
		add_action('save_post', function( $post_id ) use( $custom_field_set , $custom_field_item ){

			if ( !isset($_POST['load_custom_fields_view_specific_nonce']) )
				return $post_id;
			
			if ( empty( $_POST ) && ( !check_admin_referer( 'load_custom_fields_view_specific', 'load_custom_fields_view_specific_nonce' ) ) )
			   return $post_id;
			
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
				return $post_id;
			
			if ( $_POST['post_type'] == $custom_field_item ) {
			
				if ( ! current_user_can( 'edit_page', $post_id ) )
					return $post_id;
					
			} else {    
				if ( ! current_user_can( 'edit_post', $post_id ) )
					return $post_id;
			}
			

			/* 
			* add hack for special custom fields used in post types
			* e.g. promo groups and sliders
			*/
				
				/* check post_content with custom content shortcode */
				if ( has_shortcode( $_POST['post_content'], 'get_custom_content' ) ) {
				
					$pattern = get_shortcode_regex();
					
					if ( preg_match_all( '/'. $pattern .'/s', $_POST['post_content'], $matches ) ) {

						foreach( $matches[2] as $key => $match ){
							
							if( $match === 'get_custom_content' ){
								
								$ccfields = explode('key=\"', trim($matches[3][$key]) );
								
								$ccfkey = explode( '\"', $ccfields[1] );
								
								/* create meta key using shortcode tag param key */
								update_post_meta( $post_id, $ccfkey[0], $_POST[$ccfkey[0]] );
								
							}
						}
					}
				}
			
			
				/* start with empty array */
				$empty_meta_keys_arr = array(
										'promo_group' => 1,
										'slider' => 1
									);
						
				
				/* if promo group */
				if( isset($_POST['promo-name']) ){
					
					$post_type_custom_fields_promo = include( get_template_directory().'/module/post-types/promocentric/config.promo.php' );
					$promo_arr = array();
					
					/* prepare clean array */
					foreach( $post_type_custom_fields_promo as $promo_field => $promo_val ){
						
						foreach( $_POST[$promo_field] as $key => $val){
							
							$promo_arr[$promo_field][] = $val;
						}
					}
					
					/* update promo group */
					update_post_meta( $post_id, 'promo_group', $promo_arr );
					
					/* assign 0 means not empty */
					$empty_meta_keys_arr['promo_group'] = 0;
				}
				
				
				
				/* if slider */
				if( isset($_POST['slider-item-type']) AND $custom_field_set == 'sliders' ){
				
					//$slider_fields = include( get_template_directory().'/module/'.$custom_field_set.'/'.$custom_field_item.'/config.php' );
					$slider_fields = include( get_template_directory().'/module/'.$custom_field_set.'/'.$custom_field_item.'/config.presave.php' );
					
					$slider_arr = array();
					
					/* whitelist array for special fields */
					$nl2br2_arr = array( 'slider-item-description' );
					
					/* add slider type to clean array */
					foreach( $slider_fields as $key => $val ){
						
						if( $key == 'slider-item' ){
							
							foreach( $val as $slider_field => $slider_val ){
								foreach( $_POST[$slider_field] as $key1 => $val1 ){
								
									if( in_array( $slider_field, $nl2br2_arr ) ){
										$slider_arr[ $slider_field ][] = return_nl2br2( trim( $val1 ) );
										
									}
									else{
										$slider_arr[ $slider_field ][] = trim( $val1 );
										
									}
								}
							}
						}
						
						/* if not slider-item */
						else{
							$slider_arr[ $key ][] = trim( $_POST[$key][0] );
							
						}

					}
					
					/* update slider */
					update_post_meta( $post_id, 'slider', array( $slider_arr ) );
					
					/* assign 0 means not empty */
					$empty_meta_keys_arr['slider'] = 0;
				}
				
				
				/* check for special custom fields empty */
				foreach( $empty_meta_keys_arr as $key => $val ){
					
					/* if value is 1 means empty; empty meta value */
					if( $val ) update_post_meta( $post_id, $key, '' );
					
				}
				

				
			/* 
			* after hack do normal custom fields update
			*/
			$posttypecustomfields = $this->get_fields( $custom_field_set , $custom_field_item );
			
			/* update post meta */
			foreach( $posttypecustomfields as $key => $val ){

				if( isset( $_POST[$key] ))
				{	
				
					update_post_meta( $post_id, $key, $_POST[$key] );
				}
		
			}


			
			
		});
	
	}

}	

?>