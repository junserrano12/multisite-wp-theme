<?php
	
	/* Designer Theme Save  */
	check_ajax_referer( 'option_theme_designer_save', 'nonce_sec' );
		
		global $DWH_Options, $DWH_Util, $DWH_Sidebar, $DWH_Customization;

		$option_set = $_POST['option_set'];
		$option_design_type = $_POST['design_type'];
		$option_design_set = $_POST['design_set'];
			

		$option_row = trim($_POST['option_row']);
		$mode = trim($_POST['mode']);
		$success = 0;
		$insert_id = 0;
			
		/* Get option set config */	
		$design_set_config = $DWH_Customization->get_design_config( $option_design_type , $option_design_set );	

		if( !empty( $design_set_config ) )
		{
			/* loop through config */
			foreach( $design_set_config as $key => $val ){
				
				$theme_name = sanitize_title_with_dashes( strtolower( $val['details']['title'] ) );
				
				if( $option_set == $theme_name ){
					
					foreach( $val['sections'] as $sec_key => $sec_val ){
						
						$option_val = array();
						$option_detect = 0;
						
						$attributes = $sec_val['attributes'];
					
						foreach( $attributes as $key1 => $val1 ){
							
							foreach( $_POST['option_value'] as $post_field => $val_field ){
								
								if( $val1['properties']['field_name'] == $val_field['field_name'] ){
								
									$option_val['attributes'][ $key1 ] = $val_field['value'];
									$option_detect++;
								}
								
							}
							
						}
						
						/* construct array */
						if( $option_detect ){
						
							$option_val['option_set'] = $option_set;
							$option_val['category'] = $val['details']['category'];
							$option_val['selector'] = $sec_val['selector'];
							
						}
						
					}

		
					/* adding */
					if( $mode == 'add' ){
						
						$insert_id = $DWH_Customization->save_set( $option_design_set , $option_val );
						$success++;
					}
					/* updating */
					else{
						
						$DWH_Customization->update_set( $option_design_set , $option_row, $option_val );
						$insert_id = $option_row;
						$success++;
						
					}
					
				}
				
			}
			
			/* if success is greater than 0 */
			if( $success ){
				


				$theme_designer_css_Val = $DWH_Customization->render( 'css' , $option_design_type , $option_design_set , 'admin' ); 

				/* construct new array for return as json */
				$option_set_arr = array(
									'success' => 1,
									'msg' => 'Section Updated.',
									'option_data' => $option_val,
									'insert_id' => $insert_id,
									'theme_designer_css' => isset( $theme_designer_css_Val ) && !is_null( $theme_designer_css_Val ) ? $theme_designer_css_Val : ''
								);
			
			}
			
			/* if with errors */
			else{
				/* construct new array for return as json */
				$option_set_arr = array(
									'success' => 0,
									'msg' => "Sorry! I'm trying but I can't be able to update this section"
								);
			}
			
			/* ofcourse return as json data */
			echo json_encode( $option_set_arr );
		
		}
	
	die();
			
?>