<?php

/* Gets the option set item - field properties  */

	check_ajax_referer( 'option_get_option_set_data', 'nonce_sec' );
	
		global $DWH_Options, $DWH_Admin;
		
		$option_set = trim($_POST['option_set']);
		$option_row = trim($_POST['option_row']);
		$mode = trim($_POST['mode']);
		$option_set_data = array();
		
		/* if hotel branch */
		if( $mode == 'hotel_branch' ){
			
			$option_data = get_dwh_option( $option_set );
			
			if( $option_data ){
				
				foreach( $option_data as $key => $value ){
					
					if( $value['dwh_hotels_id'] == $option_row ){
						
						/* dont forget to assign its row */
						$option_set_data[ $key ] = $value;
					
					}

				}
				
			}
			
		}
		
		/* if page theme */
		elseif( $mode == 'page_theme' ){
			
			$pagetype = $option_row;
			$pagetyperel = $DWH_Admin->get_page_types();
			$pagetypearr = array();
			
			/* refine array */
			foreach( $pagetyperel as $key => $val ) $pagetypearr[] = $val[0];
			
			/* if within values */
			if( in_array( $pagetype, $pagetypearr) ){
				
				$pagethemearr = $DWH_Admin->get_page_themes();
				$option_set_data[ $key ] = $pagethemearr;
			}
		
		}
		
		
		/* construct new array for return as json */
		$option_set_arr = array(
							'option_data' => count( $option_set_data ) > 0 ? $option_set_data : ''
						);
		
		echo json_encode( $option_set_arr );
		

	die();

?>