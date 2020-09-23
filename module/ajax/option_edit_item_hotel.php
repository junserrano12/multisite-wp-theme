<?php

/* Edit Hotel Option settings row  */
		check_ajax_referer( 'option_edit_item_hotel', 'nonce_sec' );
		
			global $DWH_Options, $DWH_Admin, $DWH_Util;
			
			$option_set = trim($_POST['option_set']);
			$option_row = trim($_POST['option_row']);
			$mode = trim($_POST['mode']);
			$hotel_option_data = array();
			$hotel_option_contact = array();
			
			
			/* Basically all the hotel information */
			$hotels_data = array(
								'dwh_hotels' =>	'dwh_hotels', 
								'dwh_hotel_address' => 'dwh_hotel_address',
								'dwh_hotel_contact' => 'dwh_hotel_contact'
							);
			
			$hotels_option = array();
			$hotels_property = array();
			
			/* loop through hotels data and get option and properties */
			foreach( $hotels_data as $key => $val ){
				
				$hotels_option[ $key ] = array();
				$hotels_property[ $key ] = array();
				
				/* get option data */
				$hotels_option[ $key ] = $DWH_Options->get_option_set_data( $val );
				
				/* get option set properties */
				$hotels_property[ $key ] = $DWH_Options->get_option_set_properties( $val );
			}
			
			$optionrel = array();
			$optionimg = array();
			
			/* loop through hotels property array */
			foreach( $hotels_property as $key => $val ){
				
				/* if not hotel contact */
				if( $key != 'dwh_hotel_contact' ){
					
					$val_hotel = $val['settings'];
					
					/* loop through field properties */
					foreach( $val_hotel as $key_field => $val_field ){

						/* and check if control_type is relation */
						if( $val_field['properties']['control_type'] == 'relation' ){

							/* push to relation array */
							$optionrel[$key] = array();
							array_push( $optionrel[$key], 0 );
							
						}
						
						
						/* check if control_type is image */
						elseif( $val_field['properties']['control_type'] == 'image' ){
							
							$imgsrc = '';
							$imgid = $mode == 'edit' ? $hotels_option[ $key ][0][ $key_field ] : 0;
							
							$imgsrcarr = wp_get_attachment_image_src( $imgid , 'medium');
							if( $imgsrcarr ) $imgsrc = $imgsrcarr[0];
							
							/* push to image array */
							$optionimg[ $key ] = array();
							array_push( $optionimg, $imgsrc );	
							
						}
						
					}
				
				}

			
			}
			
			/* if edit mode */
			if( $mode == 'edit' ){
				
				$hotel_address_arr = array();
				$hotel_hotel_arr = array();
				
				/* loop through options data */
				foreach( $hotels_option as $key => $value ){
					
					/* If Hotel Information */
					if( $key == 'dwh_hotels' ){
						
						$hotel_option_data[ $key ] = array();
						
						/* if with value */
						if( array_key_exists( $option_row, $value ) ){
							
							array_push( $hotel_hotel_arr, $value[ $option_row ] );
						}
						
						/* if no value */
						else{
							
							/* add empty values */
							foreach( $hotels_property[ $key ]['settings'] as $prop => $prop_val ){
								
								$hotel_hotel_arr[0][ $prop ] = '';
							}
						}
						
						$hotel_option_data[ $key ] = $hotel_hotel_arr;
						
						
					}
					
					/* if Hotel Address */
					if( $key == 'dwh_hotel_address' ){
						
						$hotel_option_data[ $key ] = array();
						
						$ctr = 0;
						/* loop through values array based on dwh_hotel_id */
						foreach( $value as $key1 => $val1 ){
							
							if( $val1[ 'dwh_hotels_id' ] == $option_row ){
								
								array_push( $hotel_address_arr, $val1 );
								$ctr++;
							}
						}
						
						/* if no entry found */
						if( !$ctr ){
							
							/* add empty values */
							foreach( $hotels_property[ $key ]['settings'] as $prop => $prop_val ){
								
								$hotel_address_arr[0][ $prop ] = '';
							}
						}
						
						$hotel_option_data[ $key ] = $hotel_address_arr;
					
					}
					
					/* If Hotel Contact */
					elseif( $key == 'dwh_hotel_contact'  ){
						
						$hotel_option_data[ $key ] = array();
							
						if(!empty( $value ))
						{
							/* loop through values array based on dwh_hotel_id */
							foreach( $value as $key1 => $val1 ){
								
								if( $val1[ 'dwh_hotels_id' ] == $option_row ){
									
									$hotel_option_data[ $key ][ $key1 ] = $val1;
								}
							}
						}
					}
					
				
				}
			
			}
			
			/* construct new array for return as json */
			$option_set_arr = array(
								'option_settings' => $hotels_property,
								'option_data' => $mode == 'edit' ? $hotel_option_data : '',
								'option_data_contact' => $mode == 'edit' ? $hotel_option_contact : '',
								'option_relation' => $optionrel,
								'option_image' => $optionimg
							);
								
			echo json_encode( $option_set_arr );
	
	die();

?>