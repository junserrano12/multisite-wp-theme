<?php
/*
Shortcode Loader
*/

/* Shortcode Class */
$shortcode_class_dir = get_template_directory().'/module/core/class.shortcode.php';
if(file_exists( $shortcode_class_dir )) require_once( $shortcode_class_dir );
$DWH_Shortcode = new DWH_Shortcode(); 

/* Autoload Shortcodes */
$shortcode_dir = get_template_directory().'/module/shortcodes/dynamic';

/* Check if the shortcodes directory exists */
if(file_exists( $shortcode_dir ))
{
	$shortcode_dir = scandir( $shortcode_dir );
	
	/* Loop through the shorcodes directory */

	/* Type: Dynamic Widgets */
	foreach($shortcode_dir as $shortcode_class)
	{		
		if($shortcode_class!='.'&& $shortcode_class!='..')
		{	
			$shortcode_filename = get_template_directory().'/module/shortcodes/dynamic/'.$shortcode_class.'/'.$shortcode_class.'.php';

			if(file_exists($shortcode_filename))
			{	
				/* if(!in_array($shortcode_class,$GLOBALS['THEME_BLACKLIST_CONFIG']['shortcodes']['dynamic']['disabled']))
				{ */	
					/* Set up shortcode path and handle */
					include($shortcode_filename);
					$base_path = get_template_directory_uri().'/module/shortcodes/dynamic/'.$shortcode_filename.'/'.$shortcode_filename;
					
					/* Register Shortcode */
					$DWH_Shortcode->register($shortcode_class , $shortcode_class);
					//$DWH_Shortcode->load_styles('dynamic',$base_path,$shortcode_class);	

					/* Check if the script is to be loaded in the header */
				// 	if(in_array($shortcode_class, $GLOBALS['THEME_TEMPLATE_SHORTCODE_SCRIPT_CONFIG']['in_header']))
				// 	{
				// 		$in_footer = false;
				// 	}
				// 	else
				// 	{
				// 		$in_footer = true;
				// 	}
					
				// 	/* load Shortcode script */
				// 	$DWH_Shortcode->load_script('dynamic',$shortcode_class, $in_footer);	
				/* } */
			}		
		}
	}

	/* Type: Static Shortcodes */
	foreach( glob(get_template_directory().'/module/shortcodes/static/*/*.php') as $class_path )
	{	
		$path = str_replace("\\", "/", $class_path);	
		$path_parts = pathinfo($path);

		/* if(!in_array($path_parts['filename'],$GLOBALS['THEME_BLACKLIST_CONFIG']['shortcodes']['static']['disabled']))
		{ */	
			if(is_file($path))
			{
				/* Set up shortcode path and handle */
				include( $path ); 
				$file_name = explode('.php', strtolower(basename($class_path))); 
				$tag_name = $file_name[0]; 
				$base_path = get_template_directory_uri().'/module/shortcodes/static/'.$path_parts['dirname'].'/'.$tag_name;

				/* Register Shortcode */
				$DWH_Shortcode->register($path_parts['filename'] , $path_parts['filename']);
				

				/* Check if the script is to be loaded in the header */
				// if(in_array($shortcode_class, $GLOBALS['THEME_TEMPLATE_SHORTCODE_SCRIPT_CONFIG']['in_header']))
				// {
				// 	$in_footer = false;
				// }
				// else
				// {
				// 	$in_footer = true;
				// }
					
				// /* load Shortcode script */
				// $DWH_Shortcode->load_script('static',$tag_name, $in_footer);


			}
		/* } */
		
	}
}

?>