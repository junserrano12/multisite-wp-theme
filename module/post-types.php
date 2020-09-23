<?php
/*
Function: Autoload Post Types
*/


/* Post Types Class */
if(file_exists(get_template_directory().'/module/core/class.posttypes.php'))
	require_once(get_template_directory().'/module/core/class.posttypes.php');

$DWH_PostTypes = new DWH_PostTypes();  
$allow_post_types = array();

/* Get site info */
$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);

if( $site_info )
{
	$site_theme = $site_info->site_theme;
	
	if( $site_theme )
	{

		$site_theme_config_dir =  get_template_directory() . '/module/themes/site/'.$site_theme_name.'/config.php';

		if( file_exists( $site_theme_config_dir ) )
		{
			$site_theme_config = include( $site_theme_config_dir );

			if( isset( $site_theme_config['details']['category'] ) )
			{
				$site_theme_category = $site_theme_config;

				if( array_key_exists( 'postypes', $site_theme_category ))
				{	
					$allow_post_types = $site_theme_category['postypes'];


				}
				
			}
			
		}

	}

}

/* include Components */
$dir = str_replace('\\', '/',get_template_directory()).'/module/post-types';

if(file_exists( $dir ))
{
	$dir = scandir( $dir );

	foreach($dir as $dir_item)
	{		
		if($dir_item!='.'&& $dir_item!='..')
		{	
			if( $allow_post_types )
			{	
				if( in_array( $dir_item , $allow_post_types ))
				{	
					$dir_file = get_template_directory().'/module/post-types/'.$dir_item.'/'.$dir_item.'.php';

					if( file_exists( $dir_file ) )
					{	
						//include( $dir_file );
						/* run Components */
						$DWH_PostTypes->load( $dir_item );
					}
				}
				
			}
			
		}
	}

}

/* End of widget.php */
	
?>