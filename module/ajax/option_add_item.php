<?php

/* Add option set item  */

	global $DWH_Options, $DWH_Util;

	check_ajax_referer( 'option_add_item', 'nonce_sec' );
	
		$option_set = trim($_POST['option_set']);
		$option_row = trim($_POST['option_row']);
		$option_values = array();
		$option_values1 = array();
		$option_error = array();
		
		
		/* 
		* 1st step
		* check for control type that needs validation
		*/
		
			/* whitelist types for validation */
			$validate_arr = array(
								'email',
								'url'
							);
		
			/* get option set property */
			$optionsetarr = $DWH_Options->get_option_set_properties( $option_set );
			$optionsetproperties = $optionsetarr['settings'];
			
			/* loop through $_POST data */
			foreach( $_POST['option_values'] as $key => $val ):
			
				$field_object = $optionsetproperties[ $val['field_name'] ];
				$control_type = $field_object['properties']['control_type'];
				$post_value = $val['value'];
				
				/* if control type is whitelisted */
				if( in_array( $control_type, $validate_arr ) && $field_object['properties']['required'] ):
					
					/* start validation */
					if( !$DWH_Util->check_field_input_type( $control_type, $post_value ) )
						
						/* add to errors array */
						array_push( $option_error, $field_object['properties'] );
					
				endif;
				
			endforeach;
		
		
		/* 
		* 2nd step
		* process
		*/
		
			/* if no error */
			if( !count( $option_error ) > 0 ):
				
				/* prepare clean array structure */
				foreach( $_POST['option_values'] as $key => $val ){
				
					/* whitelist for hotels */
					$relation_hotels = array(
										'main_flag',
										'dwh_hotels_id'
									);
					
					/* set up field array for control type */
					$field_object = $optionsetproperties[ $val['field_name'] ];
					$control_type = $field_object['properties']['control_type'];
				
					/* check if hotel id */
					if( in_array( $val['field_name'], $relation_hotels ) ){
						
						/* main flag 1 is main hotel; dwh_hotels_id 0 is main hotel */
							$main_flag = 1;
							$dwh_hotels_id = 0;
							
							if( $val['field_name'] == 'main_flag' AND $option_row > 0 ) {
								$main_flag = 0;
								
								/* get hotel row for saving */
								$option_values[ $val['field_name'] ] = $main_flag;
								
							}
							
							/* get hotel row for saving */
							$option_values[ $val['field_name'] ] = $DWH_Util->sanitize_field_input_value( $control_type, $val['value'] );
							
							/* this is for return as json */
							$option_values1[ $val['field_name'] ] = $DWH_Util->sanitize_field_input_value( $control_type, $val['value'] );
						
					}
					
					/* else */
					else{
						
						/* get hotel row for saving */
						$option_values[ $val['field_name'] ] = $DWH_Util->sanitize_field_input_value( $control_type, $val['value'] );
						
						/* this is for return as json */
						$option_values1[ $val['field_name'] ] = $DWH_Util->sanitize_field_input_value( $control_type, $val['value'] );
					}
				
				}
				
				$insert_id = $DWH_Options->add_option_set_item(  $option_set, $option_values );
				
				/* construct new array for return as json */
				$option_set_arr = array(
									'success' => 1,
									'msg' => 'Options added',
									'option_details' => $optionsetarr['details'],
									'option_data' => $option_values1,
									'option_settings' => $optionsetproperties,
									'insert_id' => $insert_id
								);
				
			
			/* if with errors */
			else:
				
				/* construct new array for return as json */
				$option_set_arr = array(
									'success' => 0,
									'msg' => 'Options not Added',
									'option_error' => $option_error
								);
					
			endif;			
		
		
		/* ofcourse return as json data */
		echo json_encode( $option_set_arr );
	
	die();

?>