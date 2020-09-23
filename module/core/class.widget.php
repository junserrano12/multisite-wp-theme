<?php
/*
Function: Core Widget Class
*/

Class DWH_Widget
{	


	public function __construct(){

	}

	/*
	* Registers a widget
	*
	* @param (widget array) Collection of widget names to be registered
	* @return (none)
	*/

	function register( $widget_name )
	{	
		register_widget($widget_name);		
	}

	function unregister_widgets( $site_info ) {
	 	
	 	if( $site_info )
	 	{
	 		add_action('widgets_init',function() use( $site_info ){

		    	$config_dir = DWH_SITE_THEME_DIR . 'site/'. $site_info->site_theme . '/config.php';
		    	$site_sidebar_config = array();

		    	if(file_exists( $config_dir ))
			    {
			     	$site_sidebar_config = include( $config_dir ); 

			     	/* Unregister Default Widgets */ 
			    	if(!empty( $site_sidebar_config )) 
		    		{
				    	foreach ( $site_sidebar_config['widgets']['default']['disabled'] as $key => $value) {
				    		unregister_widget($value);	
				    	}
				    }

		    	}
		    });
	 	}
	    
	}

	function initialize_basetheme_register_sidebars( $site_info ) {

	    /* Register Sidebars */
	    if( $site_info )
	    {
	    	 $config_dir = DWH_SITE_THEME_DIR . 'site/'. $site_info->site_theme . '/config.php';

		    $site_sidebar_config = array();

		    if(file_exists( $config_dir ))
		    {
		     	$site_sidebar_config = include( $config_dir );

		     	if(!empty( $site_sidebar_config  )) 
		    	{
		    		foreach ( $site_sidebar_config['sidebars'] as $key => $value) {

		    			if( function_exists('register_sidebar') )
		    			{	
		    				register_sidebar(
				   					array( 'id' => $value['id'], 'name' => $value['name'], 'description' => $value['description']  )
				  				);
		    			}
						 
					}
		    	}

		    }
	    }

	    
	}

	/* Displays a widget form
	@param (array) - $param - widget form instance parameters
	@return (view) - widget settings
	*/
	function load_form_settings( $data )
	{	
		load_view( $data );
	}

	function load_form_fields( $widget_class , $data )
	{	
	
		$instance = $data['form_instance'];
		$form_fields = $this->get_form_fields( $widget_class->id_base );
		

		foreach ($form_fields as $key => $value) {

			$form_fields[$key]['properties']['field_name'] = $widget_class->get_field_name( $key ); 

			if( $instance )
			{	
				if( isset( $instance[$key] ))
				{
					$form_fields[$key]['properties']['field_value'] = $instance[$key]; 
				}
				else
				{
					$form_fields[$key]['properties']['field_value'] = ''; 
				}
			}
			else
			{	
				if( isset( $form_fields[$key]['properties']['values'] ))
				{
					$form_fields[$key]['properties']['field_value'] = $form_fields[$key]['properties']['values']; 
				}
				else
				{	
					if(isset( $form_fields[$key]['properties']['field_value'] ))
					{
						$form_fields[$key]['properties']['field_value'] = $form_fields[$key]['properties']['field_value']; 
					}
					else
					{
						$form_fields[$key]['properties']['field_value'] = ''; 
					}
					
				}
				
			}
		}

		return $form_fields;
	}

	function get_form_fields( $widget_name )
	{
		$config_fields = array();
	    $dir = get_template_directory() . '/module/widgets/' . $widget_name . '/config.fields.php';

	    if( file_exists( $dir )) 
	    {
	    	$config_fields = include( $dir );
	    	return $config_fields;
	    }
	}

	function get_form_field_element( $widget_field_name, $properties )
	{	
		$control_type = $properties['control_type'];
		$field_title = $properties['field_title'];
		$field_name = $properties['field_name'];
		$field_value = '';

		if(  array_key_exists( 'values' , $properties ) )
		{
			$field_value = $properties['field_value'] != "" ? $properties['field_value'] : $properties['values']; 
		}
		else
		{
			if( array_key_exists( 'field_value' , $properties ) ){
				$field_value = $properties['field_value'] != "" ? $properties['field_value'] : ''; 
			}
			
		}
		
		$field_description = $properties['field_description'];
		
		$class_wrapper = '';
		if( isset($properties['class']) ){
			if( $properties['class'] ) $class_wrapper = ' '. $properties['class'];
		}
	
		$html_start = '<div class="control-wrapper'. $class_wrapper .'">';
		$html_end 	= '</div>';
		$html = "";
		$required = '';
		
		if( $properties['required'] ){
			$required = ' required';
		}

		switch ( $control_type ) {

			case 'text':

					$html .= $html_start;
					$html .= '<label for="">'.$field_title.'</label>';
					$html .= '<input class="widefat" id="'.$field_name.'" name="'.$field_name.'" type="text" value="'.$field_value.'">';
					$html .= $html_end;
				
				break;

			case 'checkbox':

					$value 	 = $field_value  == '' ? 0 : 1;
					$checked = $field_value  == '' ? '' : 'checked';

					$html .= $html_start;
					$html .= '<label for="">'.$field_title.'</label>';
					$html .= '<input class="checkbox" id="'.$field_name.'" name="'.$field_name.'" type="checkbox" value="'.$value.'" '.$checked.'>';
					$html .= $html_end;

				break;

			case 'radio':

					$value 	 = $field_value  == '' ? 0 : 1;
					$checked = $field_value  == '' ? '' : 'checked="checked"';

					$html .= $html_start;
					$html .= '<label for="">'.$field_title.'</label>';
					$html .= '<input class="widefat" id="'.$field_name.'" name="'.$field_name.'" type="radio" value="'.$value.'" '.$checked.'>';
					$html .= $html_end;

				break;

			case 'select':

					$html .= $html_start;
					$html .= '<label for="">'.$field_title.'</label>';
					$html .= '<select class="widefat" id="'.$field_name.'" name="'.$field_name.'">';

					foreach ($properties['values'] as $value) {
						$selected =  $field_value == $value['value'] ? 'selected' : '';
					 	$html .= '<option value="'.$value['value'].'" '.$selected.'>'.$value['text'].'</option>';
					}

					$html .= '</select>';
					$html .= $html_end;

				break;

			case 'textarea':

					$html .= $html_start;
					$html .= '<label for="">'.$field_title.'</label>';
					$html .= '<textarea class="textarea-editor widefat" rows="5" id="'.$field_name.'" name="'.$field_name.'">'.esc_attr( $field_value ).'</textarea>';
					$html .= $html_end;
				
				break;
				
			case 'custom':
					
					$style = '';
					if( $field_value ){
						$style = ' style="background-color:'. $field_value .'"';
					}	

					$html .= $html_start;
					$html .= '<label><p class="title">'.$field_title.'</p>';
					$html .= '<input'. $style .' class="widefat option-field '. $properties['feature'] . $required .'" id="'.$field_name.'" name="'.$field_name.'" type="text" value="'.$field_value.'" readonly>';
					$html .= '<input type="button" value="Clear" class="btn-reset-designer-field button-secondary"><p class="description">'. $properties['field_description'] .'</p>';
					$html .= '</label>';
					$html .= $html_end;
				
				break;

		}

		return $html;
	}


	/*Depricated*/
	function load_script( $name , $in_footer , $version )
	{		
		$handle = $name;
		$src_path = DWH_SITE_WIDGETS_DIR . $name . '/js/' . $name . '.js';
		$src_url =  DWH_SITE_WIDGETS_URI . $name . '/js/' . $name . '.js';
		$version = $version;
		$in_footer = $in_footer;
	
		if(file_exists( $src_path ) == TRUE)
		{
			wp_register_script( $handle, $src_url,'', $version , $in_footer );
			wp_enqueue_script( $handle, $src_url,'', $version , $in_footer );
		}
		
	}

	/*end of class*/
}

?>