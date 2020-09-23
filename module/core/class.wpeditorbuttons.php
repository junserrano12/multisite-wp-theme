<?php
/*

Function: Core Wpeditor Buttons Class

*/

Class DWH_WpeditorButtons
{
 
	
	public function __construct(){ }

	/*
	* Action init
	* @return (none)
	*/
	 
	function initialize()
	{	
		
	}
	
	
	/*
	* Register Button to mce external buttons
	* @return (none)
	*/
	 
	function register_button( $button_sets )
	{	
		add_filter( 'mce_buttons', function( $buttons ) use( $button_sets ){
			
			if( $button_sets ){
				foreach( $button_sets as $key => $val ){
					array_push( $buttons, $val );
				}
			}
			
			return $buttons;
		});
	}
	
	
	/*
	* Add button to tinymce
	* @return (none)
	*/
	 
	function add_button( $plugin_name )
	{	
		add_filter( "mce_external_plugins", function( $plugin_array ) use( $plugin_name ){
			
			$button_script = get_template_directory().'/module/wpeditor-buttons/'. $plugin_name .'/js/plugin.js';
			
			if(file_exists($button_script))
			{
				$plugin_array[$plugin_name] = get_template_directory_uri().'/module/wpeditor-buttons/'. $plugin_name .'/js/plugin.js';;
			}
			
			return $plugin_array;
			
		});
	}

	
	/*
	Gets the fields based on a specific post type
	@param (string) - Name of button
	*/
	function get_button_config( $button_name )
	{
		$config_button = array();
	    $dir = get_template_directory() . '/module/wpeditor-buttons/' . $button_name . '/config.details.php';

	    if( file_exists( $dir )) 
	    {
	    	$config_button = include( $dir );
	    	return $config_button;
	    }
	}
	
	
	/*
	Gets the fields based on a specific post type
	@param (string) - Name of button
	*/
	function load_script_config( $config = null, $button_name )
	{
		if( $config ){
			return 'var '. $button_name .' = '. json_encode( $config ) .';';
		}
		
	}


}

?>