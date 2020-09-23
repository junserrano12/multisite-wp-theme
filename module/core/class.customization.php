<?php
/*

*/

Class DWH_Customization
{
	
	function __construct() {}

	/* Initally sets theme designer data array indexes */
	function init( $config_set_types )
	{	
		if( $config_set_types )
		{
			foreach ($config_set_types as $key => $config_set_type ) {
			
				$design_config_sets =  $this->get_design_config_sets( $config_set_type );
				
				foreach ($design_config_sets as $key => $design_set ) {
						
					$design_set_option = 'dwh_theme_designer_'.$design_set;

					if( (bool)get_dwh_option( $design_set_option ) == false )
					{	
						$theme_design_data = get_dwh_option( $design_set_option );

						if( !isset( $theme_design_data['settings'] ))
						{
							$theme_design_data['settings'] = array( 'enable_flag' => 1 );
						}

						if( !isset( $theme_design_data['design_styles'] ))
						{
							$theme_design_data['design_styles'] = array();
						}

						update_option( $design_set_option ,$theme_design_data);
					}
				}	

			}
			
		}

	}

	/* gets customization sets 
	@type - site or page to load the corresponding designer settings
	*/

	function get_design_config_sets( $type  )
	{		
		global $DWH_Admin;

		$dir = get_template_directory() . '/module/themes/'.$type.'/';
		$design_sets = array();

		if(file_exists($dir))
		{
			$dir_scan = scandir($dir);
			foreach($dir_scan as $dir_item)
			{		

				if($dir_item!='.'&& $dir_item!='..')
				{		
					$path = $dir . $dir_item;
					$ext = pathinfo( $path , PATHINFO_EXTENSION);

					if( $ext != 'php' )
					{
						$design_sets[] =  $dir_item;

					}
					
				}
			}

			return $design_sets;
			
		}
	}

	/* gets customization set configurations */
	function get_design_config( $design_type , $design_set )
	{	
		if( $design_type && $design_set )
		{	

			$dir = DWH_SITE_THEME_DIR . '/'.$design_type.'/'.$design_set.'/designer/design-sets/';
			$design_set_config = array();
			$opt_customization_list = array();

			if(file_exists($dir))
			{
				$dir_scan = scandir($dir);
				foreach($dir_scan as $dir_item)
				{		
					if($dir_item!='.'&& $dir_item!='..')
					{		

						$config = include( $dir . $dir_item );
						$opt_name = explode( '.php', $dir_item );
						$opt_name = $opt_name[0];
						$design_set_config[] =  array( $opt_name => $config );
					}
				}

				/* Reorder configuration sets */

				if( !empty( $design_set_config ) )
				{
					/* Set Order */
					$options_order_dir = DWH_SITE_THEME_DIR . '/'.$design_type.'/'.$design_set.'/designer/config/config.designer.php';
					
					if( file_exists( $options_order_dir ) )
					{	
						$opt_list_order = include( $options_order_dir );

						foreach ($opt_list_order as $key => $value) {

							$customization_name = $key;

							foreach ($design_set_config as $key => $design_set_config_info ) {

								if( array_key_exists( $customization_name , $design_set_config_info ))
								{		
									if( isset( $design_set_config[$key] ))
									{
										$opt_customization_list_item = $design_set_config[$key];
										$opt_customization_list[] = array_shift( $opt_customization_list_item );
									}
									
								}
							}	
						}
					}
				}

				return $opt_customization_list;
			
			}

		}
		
	}
	
	/* Reset designer set
	@design_set (string) - designer set name
	@option_value (array) - comes with array keys(i.e. settings, design_styles). Ex. $option_value['settings']; $option_value['design_styles']
	@return (bool)
	*/
	function reset_designer_set( $design_set , $option_value )
	{
		
		$theme_design_data = get_dwh_option( $design_set );
		$theme_design_styles = $theme_design_data['design_styles'];
		
		if( isset( $option_value['settings'] ) ){
			$theme_design_data['settings'] = $option_value['settings'];
		}
		if( isset( $option_value['design_styles'] ) ){
			$theme_design_data['design_styles'] = $option_value['design_styles'];
		}
		
		return update_option( $design_set , $theme_design_data );

	}

	/* Enable or disable design customization 
	@toggle (bool) 
	@return (bool)
	*/
	function enable( $design_set , $toggle )
	{	
		$design_set = 'dwh_theme_designer_'.$design_set;
		
		if( (bool)get_dwh_option( $design_set ) == true )
		{	
			$theme_design_data = get_dwh_option( $design_set );	
			$enable_flag = $toggle == 'true' ? 1 : 0;
			$theme_design_data['settings']['enable_flag'] = $enable_flag;
			return update_option( $design_set , $theme_design_data);
		}
		
	}


	/* Delete design set
	@option_row (array) - index array of the design set item
	@return (bool)
	*/
	function delete_set( $design_set , $option_row )
	{
	
		$theme_design_data = get_dwh_option( $design_set );
		$theme_design_styles = $theme_design_data['design_styles'];
		$theme_design_styles_new = array();
		if( $theme_design_styles[$option_row] ) unset( $theme_design_styles[$option_row] );

		foreach ($theme_design_styles as $key => $value) {
			$theme_design_styles_new[] = $value;
		}
		$theme_design_data['design_styles'] = $theme_design_styles_new;
		$theme_design_data = $theme_design_data;
		return update_option( $design_set , $theme_design_data );

	}

	/* Save design set
	@option_values (array) - design set array
	@return (bool)
	*/
	function save_set( $design_set , $option_values )
	{
		if( $option_values )
		{	
			$design_set = 'dwh_theme_designer_'.$design_set;

			if( (bool)get_dwh_option( $design_set ) )
			{
				$theme_design_data = get_dwh_option( $design_set );
				$theme_design_styles = $theme_design_data['design_styles'];

				if( $theme_design_styles == '' or !is_array( $theme_design_styles ) )
				{
					$theme_design_styles = array();
				}

				array_push( $theme_design_styles , $option_values );
				$theme_design_data = $theme_design_data;
				$theme_design_data['design_styles'] = $theme_design_styles;
				update_option( $design_set , $theme_design_data );
				end( $theme_design_data['design_styles'] );
				return key( $theme_design_data['design_styles'] );
			
			}
			
		}
		
	}

	/* Pull design set info
	@option_row (int) - index of the design style set
	@return (array) - design set array
	*/
	function get_set( $design_set, $option_row )
	{	
		$design_set = 'dwh_theme_designer_'.$design_set;

		if( (bool)get_dwh_option( $design_set ) )
		{
			$theme_design_data = get_dwh_option( $design_set );
			$theme_design_styles = $theme_design_data['design_styles'];
			if( isset( $theme_design_styles[$option_row] ) ) return  $theme_design_styles[$option_row];
		}

		
	}

	/* Save design set
	@option_row (int) - index of the design style set
	@option_values (array) - design set array
	@return (bool)
	*/
	function update_set( $design_set , $option_row , $option_values )
	{	
		$design_set = 'dwh_theme_designer_'.$design_set;

		if( (bool)get_dwh_option( $design_set ) )
		{

			if( !empty( $option_values ) ) 
			{
				$theme_design_data = get_dwh_option( $design_set );
				$theme_design_styles = $theme_design_data['design_styles'];
				if( $theme_design_styles[$option_row] ) $theme_design_styles[$option_row] = $option_values;
				$theme_design_data = $theme_design_data;
				$theme_design_data['design_styles'] = $theme_design_styles;
				return update_option( $design_set ,$theme_design_data);		
			}
		}
		
	}

	/* Renders theme designer styles 
	@design_set (string) - name of the design set
	@type
	@return (css)
	*/
	function render( $render_type , $design_type , $design_set , $scope = null )
	{	

		if( $design_set )
		{	
			$design_config_sets = $this->get_design_config_sets( $design_type );
			$theme_design_data = get_dwh_option('dwh_theme_designer_'.$design_set);
			$is_render = false;

			/* Render if design settings is enable */
			if(!empty( $theme_design_data ) && !empty( $theme_design_data['design_styles'] ) )
			{	
				if( isset( $theme_design_data['design_styles'] ) )
				{
		
					if( isset( $theme_design_data['settings']['enable_flag'] ) && $theme_design_data['settings']['enable_flag'] == true )
					{	
						$is_render = true;
					}
					
					if( $scope == 'admin' )
					{
						$is_render = true;
					}

					if( $is_render == true )
					{
						$style_set = $this->parse_theme_designer_data( $theme_design_data );	
					

						switch ( $render_type ) {

								case 'css':
											
										$style_set = str_replace( array( '<style>' , '</style>' ) , '', $style_set );
										return $style_set;

									break;
								
								case 'style':

				
										if( $design_type == 'site' )
										{
											echo $style_set;
										} 
										else
										{	
											add_action('wp_head' , function() use( $style_set ){
												echo $style_set;
											});
											
										}
										
									break;
						
						}

					}
				}
			}
			
			
		}
	
	}


	function parse_theme_designer_data( $theme_design_data )
	{
		$open_tag = '{';
		$close_tag = '}';
		$colon = ':';
		$semicolon = ';';
		$new_line = '';
		$style_set = '<style>';
		$style_set	.= ""."\r\n";


		if(!empty( $theme_design_data ) && !empty( $theme_design_data['design_styles'] ) )
		{	
			if( isset( $theme_design_data['design_styles'] ) )
			{
				foreach ($theme_design_data['design_styles'] as $key => $design_set_info) {
					
					/* Filter empty all empty array indexes */	
					$attribute_info = array_filter($design_set_info['attributes']);
					
					/* Display only non empty $attribute_info */
					if( !empty( $attribute_info ) )
					{	
						$style_set .= $design_set_info['selector'];
						$style_set .= $open_tag;
						
						foreach ($design_set_info['attributes'] as $attribute => $attribute_value ) {
							if( $attribute_value != '')
							{
								$style_set .= $new_line;
								$style_set .= $attribute . $colon . $attribute_value . $semicolon;
							}
						}

						$style_set .= $new_line;
						$style_set .= $close_tag;
					}
				}	

				$style_set .= '</style>';

				return $style_set;
			}

		}

	}


}	

?>