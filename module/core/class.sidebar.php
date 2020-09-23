<?php
Class DWH_Sidebar
{	
	public $site_theme_config;

	function __construct()
	{

		global $DWH_Options;

		$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);
	
		if( $site_info )
		{
			$site_theme_name  = $site_info->site_theme;
			$dir = DWH_SITE_THEME_DIR .'/site/'.$site_theme_name.'/config.php';
			if( file_exists( $dir )) $this->site_theme_config = include( $dir	); 
		}
		

	}
	
	function reset_sidebar_theme_config( $dir )
	{
		
		if( file_exists( $dir )) $this->site_theme_config = include( $dir );
		
	}
	

	function add_widgets()
	{	

		$sidebar_new_set = array();
		$sidebar_options = get_dwh_option('sidebars_widgets');

		foreach ( $this->site_theme_config['widgets']['custom'] as $sidebar_id => $sidebar_widget) {

			$entry_sidebar_widgets_count = $this->count_entry_sidebar_widgets($sidebar_id);
			$entry_sidebar_widgets_array = $this->entry_widget_pre_set_array($entry_sidebar_widgets_count);
			$defaults = array('wp_inactive_widgets','array_version');

			foreach ($sidebar_options as $sidebar_option_key => $sidebar_option_widget) {
				
				/* Store default sidebar values */ 
				if(in_array($sidebar_option_key,$defaults))
				{
					$sidebar_new_set[$sidebar_option_key] = $sidebar_option_widget;
				}

				/* Check if sidebar option matches the template registered sidebar ids*/
				if( $sidebar_id == $sidebar_option_key )
				{		
					$sidebar_new_set[$sidebar_id] = $entry_sidebar_widgets_array;
				}
				
		
			}	
		
		}
		
		/* Update sidebar content */
		update_option('sidebars_widgets',$sidebar_new_set);
		
	}


	function register_sidebars()
	{	

		$sidebar_new_set = array();
		$sidebar_options = get_dwh_option('sidebars_widgets');
		$defaults = array('wp_inactive_widgets','array_version');

		
		foreach ( $this->site_theme_config['sidebars'] as $sidebar_id => $value) {

			foreach ($sidebar_options as $sidebar_option_key => $sidebar_option_widget) {
		
				/* Store default sidebar values */ 
				if(in_array($sidebar_option_key,$defaults))
				{
					$sidebar_new_set[$sidebar_option_key] = $sidebar_option_widget;
				}

			}	

			$sidebar_new_set[$value['id']] = array();
		
		}

		update_option('sidebars_widgets',$sidebar_new_set);

	}

	function reset_sidebar_content()
	{

		$sidebar_options = get_dwh_option('sidebars_widgets');
		$sidebar_new_set = array();
		$defaults = array('wp_inactive_widgets','array_version');

		foreach ($sidebar_options as $sidebar_option_key => $sidebar_option_widget) {

			if(in_array( $sidebar_option_key , $defaults ))
			{
				$sidebar_new_set[$sidebar_option_key] = $sidebar_option_widget;
			}
		
		}	
		
		update_option('sidebars_widgets',$sidebar_new_set);
			
	}


	function is_sidebar_active_in_theme_template($sidebar_id)
	{

		foreach ($this->site_theme_config['widgets']['custom'] as $sidebar_template_id => $sidebar_template_widget ) {
		

			 if($sidebar_id == $sidebar_template_id ){
			 	return true;
			 } 
			 else
			 {
			 	return false;
			 }

		}
	
	}

	function entry_widget_pre_set_array($entry_sidebar_widgets_count)
	{		

		$data = array();

		foreach ($entry_sidebar_widgets_count  as $key => $value) {
		
			$widget_option = array( 1 => null, '_multiwidget' => 1 );
			add_option( 'widget_'.$key , $widget_option );
			
			$is_active = $this->is_widget_active_on_sidebars($key . '-1');

			if($is_active == false)
			{
				$data[] =  $key . '-1';
			}

		}

		return $data;
		
	}

	function entry_widget_set_array($widget,$count)
	{	
		global $dwh_sidebar_widgets;

		$widget_entry_item = array();
		$widget_entry_item_set = array();

		for ($i=1; $i < $count + 1; $i++) { 
	 				
	 		$widget_array_val = array( $widget . '-' . $i);
			return $widget_array_val; 
		}

	}

	function count_entry_sidebar_widgets($sidebar_id = NULL)
	{
			
		$widget_entry_collections = array();

		foreach ($this->site_theme_config['widgets']['custom'][$sidebar_id]['widgets'] as $key => $value) {
			$widget_entry_collections[] = $value;
		}

		return array_count_values($widget_entry_collections);

	}

	function is_widget_active_on_sidebars($widget_id)
	{

		$sidebar_options = get_dwh_option('sidebars_widgets');

		foreach ($sidebar_options as $key => $value) {
				
				if(count($value) > 0)
				{	
					if(is_array($value))
					{
						foreach ($value as $key => $widget_item) {

							if($widget_id == $widget_item)
							{
								return true;
							}
							else
							{
								return false;
							}

						}
					}
					
				}


		}



	}

}

?>