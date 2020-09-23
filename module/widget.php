<?php

global $DWH_Options;

$site_info = array();
$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);

/* Widget Class */
$widget_class_dir = get_template_directory().'/module/core/class.widget.php';
if(file_exists( $widget_class_dir )) require_once( $widget_class_dir );
$DWH_Widget = new DWH_Widget();  

/* Unregister widgets */
$DWH_Widget->unregister_widgets( $site_info );
$DWH_Widget->initialize_basetheme_register_sidebars( $site_info );

/* Autoload Widgets */
$widget_dir = get_template_directory().'/module/widgets';

/* Check if the widgets directory exists */
if(file_exists( $widget_dir ))
{
	$widget_dir = scandir( $widget_dir );

	/* Loop through the widgets directory */
	foreach($widget_dir as $widget_class)
	{		
		if($widget_class!='.'&& $widget_class!='..')
		{	
			add_action('widgets_init',function()use( $DWH_Widget , $widget_class ){

			$widget_filename = get_template_directory().'/module/widgets/'.$widget_class.'/'.$widget_class.'.php';

				if(file_exists($widget_filename))
				{
					include( $widget_filename );
					$DWH_Widget->register($widget_class);
				}

			});		
		}
	}

}


/* End of widget.php */
?>