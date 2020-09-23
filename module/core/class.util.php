<?php
/*

Function: Core Util Class

*/

Class DWH_Util
{
	function __contruct() { }

	/*
	* Loads a class from the library section
	* @param (string) name of the library
	* @return ( object )
	*/
	function load_library( $lib_name )
	{	

		if( isset( $lib_name ))
		{
			$lib_file = get_template_directory() . '/module/libraries/'.$lib_name.'.php';

			return require_once( $lib_file );

		}
	

	}

	/* 
	* check input value
	* @param $control_type: required; input type like email, url, etc.
	* @param $value: required; input value
	* return boolean: true if ok, false if not
	*/
	function check_field_input_type( $control_type, $value )
	{
		
		switch( $control_type ):
			
			case 'email':
				
				if( is_email( $value ) ) 
					
					return true;
				
			break;
			
			case 'url':
				
				$regex = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
				
				if( preg_match( $regex, $value ) )
					
					return true;
				
			break;
		
		endswitch;
		
		return false;
		
	}
	
	
	
	/* 
	* sanitize input value
	* @param $control_type: required; input type like email, url, etc.
	* @param $value: required; input value; default is empty
	* return cleaned value
	*/
	function sanitize_field_input_value( $control_type, $value )
	{	
		global $allowed_html;
		
		switch( $control_type ):
			
			case 'email':
				
				return sanitize_email( trim( $value ) );
			break;
			
			case 'url':
				
				return esc_url_raw( trim( $value ) );
			break;
			
			case 'text':
			case 'select':
			case 'image':
				
				return stripslashes( sanitize_text_field( trim( $value ) ) );
			break;
			
			case 'textarea':
				
				return stripslashes( trim($value ) );
			break;
			
			case 'tag':
				$value = stripslashes( trim($value ) );
				$value =  trim($value );
				return $value;
			break;
		
		endswitch;
		
		return trim( $value );
		
	}


	/* Enable or disable flush rewrite
	@toggle (bool) 
	@return (bool)
	*/
	function enable_flush_rewrite(  $toggle )
	{	
		$option_set = 'dwh_option_permalink_flush';
		
		if( (bool)get_dwh_option( $option_set ) == true )
		{	
			$theme_design_data = get_dwh_option( $option_set );	
			$enable_flag = $toggle == 'true' ? 1 : 0;
			$theme_design_data['enable_flag'] = $enable_flag;
			return update_option( $option_set , $theme_design_data);
		}
		
	}


}	

?>