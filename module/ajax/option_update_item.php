<?php

	/* Updates an option set item  */

	check_ajax_referer( 'option_update_item', 'nonce_sec' );
		
		global $DWH_Options, $DWH_Util, $DWH_Sidebar, $DWH_Slider, $DWH_Theme;
		
		$option_set = trim($_POST['option_set']);
		$option_row = trim($_POST['option_row']);
		$option_values = array();
		$option_values1 = array();
		$option_error = array();
		$selected_theme = '';
		
		/* 
		* 1st step
		* check for control type that needs validation
		* get site theme value
		*/
		
			/* whitelist types for validation */
			$validate_arr = array(
								'email',
								'url'
							);
		
			/* get option set property */
			$optionsetproperties = $DWH_Options->get_option_set_properties( $option_set )['settings'];
			
			/* loop through $_POST data */
			foreach( $_POST['option_values'] as $key => $val ){
				
				$field_name = $val['field_name'];
				switch( $field_name ){
					
					/* exclude reactivate sidebar and reset menu */
					case 'chk-reactivate-template-sidebars':
					case 'chk-reset-menu':
							continue;
						break;
					
					default:
							$field_object = $optionsetproperties[ $val['field_name'] ];
							$control_type = $field_object['properties']['control_type'];
							$post_value = $val['value'];
							
							/* if control type is whitelisted */
							if( in_array( $control_type, $validate_arr ) && $field_object['properties']['required'] ){
								
								/* start validation */
								if( !$DWH_Util->check_field_input_type( $control_type, $post_value ) )
									
									/* add to errors array */
									array_push( $option_error, $field_object['properties'] );
								
							}
						
						break;
				}
				
				/* get selected theme value for later */
				if( $val['field_name'] == 'site_theme' ) $selected_theme = $val['value'];
				
			}
		
		
		/* 
		* 2nd step
		* process
		*/
		
			/* if no error */
			if( !count( $option_error ) > 0 ):
				
				/* prepare clean array structure */
				foreach( $_POST['option_values'] as $key => $val ){
					
					$field_name = $val['field_name'];
					switch( $field_name ){
						
						/* 
						* sidebar reactivation here 
						*/
						case 'chk-reactivate-template-sidebars':
							
								/* Get site info */
								$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites', 0 );
								
								/* Theme name */
								$site_theme_name  = $site_info->site_theme;
								
								/* 
								* 2 very important things here...
								* if checked and selected theme is equal to site theme
								* if selected theme is not equal to site theme
								*/
								if( ( $val['value'] AND $site_theme_name == $selected_theme ) OR ( $site_theme_name != $selected_theme ) ){
									
									/* New Theme configuration */
									$theme_template_config_path = DWH_SITE_THEME_DIR.'/site/'.$selected_theme.'/config.php';
									
									/* reset sidebar theme config */
									$DWH_Sidebar->reset_sidebar_theme_config( $theme_template_config_path );
									
									/* Autoload Widgets on the Theme template sidebars */
									$DWH_Sidebar->reset_sidebar_content();
									$DWH_Sidebar->register_sidebars();
									$DWH_Sidebar->add_widgets();
									
									/* Get sidebar options */
									$sidebar_options = get_dwh_option('sidebars_widgets');

									/* Update widget iteration for theme display */
									$widget_option = array( 1 => null, '_multiwidget' => 1 );

									foreach ($sidebar_options as $key => $value) {
										
										if(is_array($value))
										{
											foreach ($value as $key => $widget_item) {

												$widget_name  = explode('-', $widget_item);
												update_option('widget_'.$widget_name[0],$widget_option);

											}
										}

									}
									
									$sidebar_activated = 1;
								
								}
							
							break;
						
						/* 
						* reset menu here
						*/
						case 'chk-reset-menu':
						
								/* Get site info */
								$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites', 0 );
								
								/* Theme name */
								$site_theme_name  = $site_info->site_theme;
								
								/* 
								* 2 very important things here...
								* if checked and selected theme is equal to site theme
								* if selected theme is not equal to site theme
								*/
								if( ( $val['value'] AND $site_theme_name == $selected_theme ) OR ( $site_theme_name != $selected_theme ) ){
									
									$dir = DWH_SITE_THEME_DIR .'/site/'. $site_theme_name .'/config.php';
									if( file_exists( $dir )) $site_theme_config = include( $dir	); 

									if( $site_theme_config ){
									
										/* reset menu nav */
										$DWH_Theme->reset_default_menu();
										
										/* load default menu nav*/
										$DWH_Theme->load_default_menu( $site_theme_config );
									}
									
								}
								
							break;
						
						/* 
						* default process goes here
						*/
						default:
							
								/* whitelist for hotels */
								$relation_hotels = array(
													'main_flag',
													'dwh_hotels_id'
												);
								
								/* set up field array for control type */
								$field_object = $optionsetproperties[ $val['field_name'] ];
								$control_type = $field_object['properties']['control_type'];
								
								/* get hotel row for saving */
								$option_values[ $val['field_name'] ] = $DWH_Util->sanitize_field_input_value( $control_type, $val['value'] );
								
								/* this is for return as json */
								$option_values1[ $val['field_name'] ] = $DWH_Util->sanitize_field_input_value( $control_type, $val['value'] );
								
							break;
					}
					
				}


				/* special case, filter and update site meta data noindexnofollow for AW */
				if( $option_set == 'dwh_sites' ){
					
					$meta_data = get_dwh_option('dwh_meta');
					
					if( $meta_data )
					{	
						/* Get site theme config to confirm site category */
						$site_theme_name  = $option_values['site_theme'];
						$dir = DWH_SITE_THEME_DIR .'/site/'.$site_theme_name.'/config.php';
						if( file_exists( $dir )) $site_theme_config = include( $dir	); 

						if( $site_theme_config )
						{
							$site_category = isset( $site_theme_config['details']['category'] ) ? $site_theme_config['details']['category'] : '';

							if( strtolower( $site_category ) == 'aw' )
							{
								foreach ($meta_data as $key => $value) {
							
									if( isset( $value['noindexnofollow'] ))
									{
										$meta_data_val = array( 'noindexnofollow' => 1 );
										$DWH_Options->update_option_set_item(  'dwh_meta', $key, $meta_data_val , 'update' );
									}
								}
							}
						}

						
					}

					/* save to options */
					
				}
				
				/* special case, filter for hotel address */
				if( $option_set == 'dwh_hotel_address' ){
					
					$hotel_address_arr = array();
					
					/* get option address */
					$option_row_data = $DWH_Options->get_option_set_data( $option_set );
					
					foreach( $option_row_data as $key => $val ){
						
						if( $val['dwh_hotels_id'] == $option_row ){
							
							$hotel_address_arr[ $key ] = $val;
							/* reference option row; add new value */
							$option_row_data[ $key ] = $option_values;
						}
					
					}
					
					/* if no option row found */
					if( !$hotel_address_arr ){
						
						/* add option row; add new value */
						$option_row_data[ $option_row ] = $option_values;
					}
					
					/* save to options */
					$DWH_Options->update_option_set_item(  $option_set, '', $option_row_data, 'default' );
					
				}
				
				/* special case, filter for hotel contact */
				if( $option_set == 'dwh_hotel_contact' ){
					
					/* save to options */
					$DWH_Options->update_option_set_item(  $option_set, $option_row, $option_values, 'update' );
				}
				
				/* special case, filter for slider data */
				if( $option_set == 'dwh_slider' ){
					
					$slideritemdata = array();
					$sliderfields = array();
					
					if( isset( $_POST['slider_item'] ) ) $slideritemdata = $_POST['slider_item'];
					
					$slideritems = $DWH_Slider->get_slider_config( 'all' );
					
					if( $slideritems ){
						
						foreach( $slideritems as $key => $val ){
							
							if( $val['settings'] ){
								
								foreach( $val['settings'] as $key1 => $val1 ){
									array_push( $sliderfields, $key1 );
								}
							}
							
						}
						
						$slideritemsarr = array();
						
						foreach( $sliderfields as $key => $val ){
							foreach( $slideritemdata as $key1 => $val1 ){
								foreach( $val1 as $key_item => $key_val ){
									
									$keyvalarr = explode('[]', $key_val['field_name'] );
									if( $val == $keyvalarr[0] ){
										$slideritemsarr[$val][$key1] = $key_val['value'];
									}
								}
								
							}
							
						}
						
						/* update slider_data */
						if( isset( $option_values['slider-data'] ) ) $option_values['slider-data'] = serialize( $slideritemsarr );
					}
			
					/* save to options */
					$DWH_Options->update_option_set_item(  $option_set, $option_row, $option_values, 'update' );
				}
				
				/* if not the continue save */
				else{
				
					/* Filter data match for current data set*/
					$new_option_dataset = array();
					$new_option_val = array();
					$cur_option_set_data = get_dwh_option( $option_set );
					$cur_option_set_count = count( $cur_option_set_data );
					
					/* Loop through current data option sets , match keys and store values */

					for ($i=0; $i < $cur_option_set_count; $i++) { 

						$cur_option_set_field_val = $cur_option_set_data[$i];

						foreach ($cur_option_set_field_val as $key => $set_field ) {
							
							$cur_option_set_field_name = $key;
							
							if( isset( $option_values[$cur_option_set_field_name] ) )
							{
								$new_option_val[$cur_option_set_field_name] = $option_values[$cur_option_set_field_name] ;
							}
							else
							{
								$new_option_val[$cur_option_set_field_name] = $cur_option_set_field_val[$cur_option_set_field_name] ;
							}

							/* Loop through option set settings to get new fields and its value */
							foreach ($optionsetproperties as $key => $value ) {
								
								if( !isset( $new_option_val[$key] ) )
								{
									$new_option_val[$key]  = $option_values[$key] ;
								}
							}
						}

						$new_option_dataset = $new_option_val;
						$DWH_Options->update_option_set_item(  $option_set, $option_row, $new_option_dataset, 'update' );
					} 
					
				}

				/* construct new array for return as json */
				$option_set_arr = array(
									'success' => 1,
									'msg' => 'Options updated',
									'option_data' => $option_values1,
									'option_settings' => $optionsetproperties,
									'sidebar_data' => isset( $sidebar_activated  ) ? $sidebar_activated : 0
								);
								
								
			/* if with errors */
			else:
			
				/* construct new array for return as json */
				$option_set_arr = array(
									'success' => 0,
									'msg' => 'Options not updated',
									'option_error' => $option_error
								);
					
			
			endif;
		
			/* ofcourse return as json data */
			echo json_encode( $option_set_arr );
	
	die();

?>