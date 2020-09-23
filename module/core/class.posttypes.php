<?php
/*

Function: Core Posttype Class

*/

Class DWH_PostTypes	
{	

	public $custom_field_options;
	public $custom_field_labels;
	public $custom_field_args;
	public $posttype;

	function __contruct() { }

	
	function load( $posttype_class )
	{	
		global $post;
		
		$dir = get_template_directory().'/module/post-types/';

		if(file_exists( $dir ))
		{	

			if( $posttype_class )
			{	
				$post_type_file = $dir . $posttype_class . '/' . $posttype_class . '.php';

				if( file_exists( $post_type_file ))
				{	
					if(!class_exists( $posttype_class ))
					{
						include( $post_type_file );
						$post_class_obj = new $posttype_class;
						$post_class_obj->load();
					}
				}
				
				if( is_admin() )
				{	
					$current_post_type = isset( $_GET['post'] ) ? get_post_type( $_GET['post'] ) : '';
					
					if( !$current_post_type ){
						$current_post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
					}
			
					if($posttype_class!='.'&& $posttype_class!='..')
					{	
						if( $posttype_class ===  $current_post_type )
						{
							$this->load_admin_styles( $posttype_class );
							$this->load_admin_scripts( $posttype_class );
						}
						
					}

				}
			}
			
		}

	}


	function load_admin_scripts( $posttype )
	{
		/*  Scripts */ 
		$dir = get_template_directory().'/module/post-types/'.$posttype.'/js/admin';
		
		if( file_exists( $dir ) )
		{
			$dir = scandir( $dir );

			foreach($dir as $dir_item)
			{		
				$handle = explode('.',$dir_item);
				$src = "";

				/* Js Extension */ 
				if($handle[1] === 'js')
				{	
					if($dir_item!='.'&& $dir_item!='..')
					{	
						$src = get_template_directory_uri().'/module/post-types/'.$posttype.'/js/admin/'.$dir_item;
						add_action('admin_init', function() use( $handle, $src, $posttype ){
							
						 	wp_register_script('script-'. $posttype .'-'. $handle[0], $src);
						 	wp_enqueue_script('script-'. $posttype .'-'. $handle[0]);

						});
					}
				}
				else /* Php Extension */
				{	
					if($dir_item!='.'&& $dir_item!='..')
					{	
						$src = get_template_directory().'/module/post-types/'.$posttype.'/js/admin/'.$dir_item;
						add_action('admin_footer', function() use ( $handle , $src ){
							include($src);
						});
					}

				}

				
			}
		}
		
	}

	function  load_admin_styles( $posttype )
	{
		/* Admin Styles */
		$dir = get_template_directory().'/module/post-types/'.$posttype.'/css/admin';

		if(file_exists( $dir ))
		{
			$dir = scandir( $dir );
			/* enqueue default style */		
			add_action('admin_init', function(){		
				wp_enqueue_style( 'jquery-ui-datepicker-style' , 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css');  		
			});

			foreach($dir as $dir_item)
			{		
				if($dir_item!='.'&& $dir_item!='..')
				{	
					$handle = explode('.css',$dir_item);
					$src = get_template_directory_uri().'/module/post-types/'.$posttype.'/css/admin/'.$dir_item;

					add_action('admin_init', function() use( $posttype, $handle , $src ){
					 	wp_enqueue_style('style-admin-'. $posttype . $handle[0], $src);
					});
				}
			}
		}

	}

	
	function load_frontend_scripts( $posttype, $template )
	{

		/*  Scripts */ 
		$dir = scandir(get_template_directory().'/module/post-types/'.$posttype.'/templates/'.$template.'/js');
	
		foreach($dir as $dir_item )
		{		
			$handle = explode('.',$dir_item);
			$src = "";

			/* Js Extension */ 
			if($handle[1] === 'js')
			{	

				if($dir_item!='.'&& $dir_item!='..')
				{	
					$src = get_template_directory_uri().'/module/post-types/'.$posttype.'/templates/'.$template.'/js/'.$dir_item;
					wp_register_script('script-'. $posttype . '-' . $template .'-'. $handle[0], $src);
					wp_enqueue_script('script-'. $posttype . '-' . $template .'-'. $handle[0]);

				}

			}
			else /* Php Extension */
			{	
				
				if($dir_item!='.'&& $dir_item!='..')
				{	
					$src = get_template_directory().'/module/post-types/'.'/templates/'.$template.'/js/'.$dir_item;
					
						if( !is_admin() )
						{
							include($src);
						}
				
				}
				
				
			}

			
		}
	}

	function load_frontend_styles( $posttype, $template )
	{	

		/* Front End Styles */
		

			/* Post type Styles */
			$style_dir = scandir(get_template_directory().'/module/post-types/'.$posttype.'/css/frontend');

			foreach($style_dir as $dir_item)
			{		
				if($dir_item!='.'&& $dir_item!='..')
				{	
					$handle = explode('.css',$dir_item);
					$src = get_template_directory_uri().'/module/post-types/'.$posttype.'/css/frontend/'.$dir_item;

					add_action('wp',function( $posttype, $template, $handle, $src ){

						wp_enqueue_style('style-posttype-'. $posttype .'-'. $handle[0], $src);

					});
				}
			}

			/* Post type Template styles */
			$style_dir = scandir(get_template_directory().'/module/post-types/'.$posttype.'/templates/'.$template.'/css');
			
			foreach($style_dir as $dir_item)
			{		
				if($dir_item!='.'&& $dir_item!='..')
				{	
					$handle = explode('.css',$dir_item);
					$src = get_template_directory_uri().'/module/post-types/'.$posttype.'/templates/'.$template.'/css/'.$dir_item;
					
					add_action('init',function() use ( $posttype, $template, $handle, $src ){
						wp_enqueue_style('style-posttype-template-'. $posttype .'-'.$template.'-'. $handle[0], $src);
					});

				}
			}
	}

	function get_template_list( $posttype )
	{
		/* Template list */
		$dir = get_template_directory().'/module/post-types/'.$posttype.'/templates';
		$template_list = array();

		if(file_exists( $dir ))
		{
			$dir = scandir( $dir );
		
			foreach($dir as $dir_item)
			{		
				if( $dir_item!='.'&& $dir_item!='..' && !is_null( $dir_item ) )
				{	
					array_push( $template_list , $dir_item );
				}
			}

			return $template_list;
		}
	}
 	

 	function get_post_types()
 	{
 		/* Template list */
		$dir = get_template_directory().'/module/post-types/';
		$template_list = array();

		if(file_exists( $dir ))
		{
			$dir_scan = scandir( $dir );
		
			foreach( $dir_scan as $dir_Val )
			{		
				if( $dir_Val!='.'&& $dir_Val!='..' && !is_null( $dir_Val ) )
				{	
					array_push( $template_list , $dir_Val );
				}

			}

			return $template_list;
		}
 	}

 	/* Create post
 	@param (array) - $param - post parameters
  	*/
 	function create_custom_post_type( $param )
 	{
 		if( $param )
 		{
 			if( wp_insert_post( $param ) ) 
 			{
 				$post_id = wp_insert_post($param);
 				return $post_id;
 			}
 	
 		}
 	}

 	/* insert post meta
 	@param (array) - $param - post meta parameters
 	*/
 	function create_post_meta( $param )
 	{	
 		if( $param )
 		{
 			add_post_meta(	
 							$param['post_id'],
 							$param['meta_key'], 
 							$param['meta_value'], 
 							$param['unique']
 						);
 		}
 	
 	}


}

?>