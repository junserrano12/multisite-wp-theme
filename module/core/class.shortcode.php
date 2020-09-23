<?php
/*

Function: Core Widget Class

*/

Class DWH_Shortcode
{
 
	
	public function __construct(){ }

	/*
	* Registers a widget
	* @return (none)
	*/
	 
	function register($tag_name,$function)
	{	
		add_shortcode($tag_name,$function);
	}

	function unregister_shortcodes($tag_name)
	{	
		$config_theme = $this->config_theme;
		
			/* Dynamic  */ 
	    	foreach ($config_theme['shortcodes_custom']['dynamic'] as $key) {

	    		if($key['enable'] == FALSE)
	    		{
	    			remove_shortcode($key['name']);
	    		}
	    	}

	    	/* Static */  
	    	foreach ($config_theme['shortcodes_custom']['static'] as $key) {

	    		if($key['enable'] == FALSE)
	    		{
	    			remove_shortcode($key['name']);
	    		}
	    	}

	}

	function load_script( $type , $tag_name )
	{		

		$handle = $tag_name;
		$script_path = '/module/shortcodes/'.$type.'/'.$handle.'/js/'.$tag_name.'.js';
		$src_path = get_template_directory().$script_path;
		$src_url = get_template_directory_uri().$script_path;
		$version = 1.0;
		$in_footer = true;
		$add_action = "";

		if(file_exists($src_path) == TRUE)
		{
			if($in_footer == true)
			{
				$add_action = "wp_footer";
			}
			else
			{
				$add_action = "init";
			}

			add_action($add_action,function() use ($handle, $src_url,$version, $in_footer){

				wp_register_script($handle,$src_url,'',$version,$in_footer);
				wp_enqueue_script($handle,$src_url,'',$version,$in_footer);
			
			});
				
		}
		
	}

	function load_styles( $type, $base_dir_name, $tag_name )
	{		
	
		
		$handle = $tag_name;
		$script_path = '/module/shortcodes/'.$type.'/'.$handle.'/css/'.$tag_name.'.css';
		$src_path = get_template_directory().$script_path;
			
	
		if(file_exists($src_path) == TRUE)
		{
			$src_url = get_template_directory_uri().$script_path;
			$version = 1.0;
			$in_footer = false;

			add_action('init',function() use ($handle, $src_url,$version, $in_footer){

				wp_register_script($handle,$src_url,'',$version,$in_footer);
				wp_enqueue_style($handle,$src_url,'',$version,$in_footer);
			
			});
				
		}
		
	}

				


	

}

?>