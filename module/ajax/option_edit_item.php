<?php

/* Edits option settings row  */
		check_ajax_referer( 'option_edit_item', 'nonce_sec' );
			
				global $DWH_Options, $DWH_Admin, $DWH_Util, $DWH_Data, $DWH_Slider;
			
			$hotels 			= $DWH_Options->get_dwh_site_option_set('dwh_hotels');
			$hotel_info 		= array();

			foreach ($hotels as $key => $hotel) {
				if( $hotel['main_flag'] == 1) $hotel_info = $hotel;
			}

			$option_set = trim($_POST['option_set']);
			$option_row = trim($_POST['option_row']);
			$mode = trim($_POST['mode']);
			$option_set_info = get_dwh_option( $option_set );
			$data = array();
			
			/* get option set property */
			$optionsetdetails = $DWH_Options->get_option_set_properties( $option_set )['details'];
			$optionsetproperties = $DWH_Options->get_option_set_properties( $option_set )['settings'];
			$optionrel = array();
			$optionimg = array();
			$optionpagetheme = array();
			$postinfoarr = array();
			$sliderarr = array();
			$slideritems = array();
			$slideritemsdata = array();

			
			/* loop through field properties */
			foreach( $optionsetproperties as $key => $val ){
			
				/* and check if control_type is relation */
				if( $val['properties']['control_type'] == 'relation' ){
					
					/* if site themes */
					if( $key == 'site_theme' ){
						
						$optionrelarr = $DWH_Admin->get_site_themes();

						/* push to relation array */
						array_push( $optionrel, $optionrelarr );

					}
					/* if page type */
					elseif( $key == 'page_type' ){
						
						$optionrelarr = $DWH_Admin->get_page_types();
						
						/* push to relation array */
						array_push( $optionrel, $optionrelarr );
					}
					
					/* if page template */
					elseif( $key == 'page_theme' ){
						
						$optionrelarr = $DWH_Admin->get_page_themes();
						
						/* push to relation array */
						array_push( $optionrel, $optionrelarr );
						array_push( $optionpagetheme, $optionrelarr );

					}

					/* if fonts internal */
					elseif( $key == 'font_name' ){
						
						$optionrelarr = $DWH_Admin->get_site_fonts();

						/* push to relation array */
						array_push( $optionrel, $optionrelarr );
					}
					
					/* if slider name */
					elseif( $key == 'slider-name' ){
						
						$optionrelarr = $DWH_Slider->get_slider_config( 'slider-name' );

						/* push to relation array */
						array_push( $optionrel, $optionrelarr );
					}
					
					/* if slider mode */
					elseif( $key == 'slider-mode' ){
						
						$slidermodearr = $DWH_Slider->get_slider_config( 'slider-mode' );
						
						foreach( $slidermodearr as $key_mode => $val_mode ){
							if( $key_mode == 'site' ) $optionrelmodearr[ $key_mode ] = $val_mode;
						}
						
						/* push to relation array */
						array_push( $optionrel, $optionrelmodearr );
					}
					
					/* if slider type */
					elseif( $key == 'slider-type' ){
						
						$optionreltypearr = $DWH_Slider->get_slider_config( 'slider-type' );

						/* push to relation array */
						array_push( $optionrel, $optionreltypearr );
					}
					
					/* else */
					else{
					
						$optionsetarr = explode( '_id', $key ); 
						$optionset = $optionsetarr[0];
						
						$optionrelarr = $DWH_Options->get_dwh_site_option_set( $optionset );
						
						/* push to relation array */
						array_push( $optionrel, $optionrelarr );
					
					}
					
				}
				
				elseif( $val['properties']['control_type'] == 'hidden' ){
					
					switch( $key ){
						
						case 'promo_post_ids':
							
							$postinfo_arr = $DWH_Data->get_all_post_info( array('flashdeal','promocentric') );
							$postinfo_cat = array();
							foreach( $postinfo_arr as $key => $val ){
								array_push( $postinfo_cat, $val->post_type );
							}
							
							/* add to postinfo array */
							$postinfoarr['category'] = array_unique( $postinfo_cat );
							$postinfoarr['posts'] = $postinfo_arr;
							
						break;
						
						default: break;
					}
					
				}
				
				/* if Slider Data */
				elseif( $key == 'slider-data' ){
						
						$slideritems = $DWH_Slider->get_slider_config( 'all' );
						
						if( $mode == 'edit' ){								
							$slideritemsdata = unserialize( $option_set_info[$option_row]['slider-data'] );
							
							/* prepare image src */
							if( isset( $slideritemsdata['slider-item-id'] ) ){
								foreach( $slideritemsdata['slider-item-id'] as $key => $val ){
								
									$img_arr = $DWH_Slider->get_slider_settings_default();
									$img_src = $img_arr['slider-upload-image-src'];
									$img_srcarr = wp_get_attachment_image_src( $val, 'medium');
									
									if( $img_srcarr ) $img_src = $img_srcarr[0];
									
									$slideritemsdata['slider-item-imagesrc'][] = $img_src;
								}
							}
						
						}
						
				}
				
				/* if widget cta */
				elseif( $key == 'cta_set' ){
						
						/* CTA default BPG Tip */
						$data['dir'] 		= array('module/collections','views','texts');
						$data['view'] 		= 'bpg_tip';
						$data['str_val']	= $hotel_info['hotel_name'];
						$data['str_rep']	= '$hotelname';
						$bpg_tip 			= replace_file_str_val( $data );
						
						/* CTA default BPG Inclusion */
						$data['dir']  = array('module/collections','views','texts');
						$data['view'] = 'bpg_inclusions';
						ob_start();
						load_view( $data );
						$bpg_inclusion = ob_get_contents();
						ob_end_clean();

						/* Get default settings */
						$widget_name = 'widget_cta';
						$confile = get_template_directory() . '/module/widgets/'.$widget_name.'/config.fields.default.php';
						
						/* Get site info */
						$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);
							
						if( $site_info )
						{	
							$site_theme_name = $site_info->site_theme;

							if( file_exists( $confile ) )
							{	                
								$cta_config_default = include( $confile );
								
								$site_theme_config_dir =  get_template_directory() . '/module/themes/site/'.$site_theme_name.'/config.php';
							
								if( file_exists( $site_theme_config_dir ) )
								{	
									$site_theme_config = include( $site_theme_config_dir );
									
									if( isset( $site_theme_config['details']['category'] ) )
									{
										$site_theme_category = $site_theme_config['details']['category'];

										if( array_key_exists( $site_theme_category, $cta_config_default ))
										{			
											$cta_config_default = $cta_config_default[$site_theme_category];
											
											if( !empty( $cta_config_default ))
											{	
												$cta_config_default['cta_bpg_tip'] = $bpg_tip;
												$cta_config_default['cta_bpg_inclusion'] = $bpg_inclusion;
												$data['widget_settings'] = $cta_config_default;
											}
										}
									}
									
								}
							}
						}

					}

				
				/* if terms and conditions */
				elseif( $key == 'terms_and_condition' ){
				
					$data['dir'] = array('module/collections','views','texts');
					$data['view'] = 'termsandconditions';
					$data['str_val']	= $hotel_info['hotel_name'];
					$data['str_rep']	= '$hotelname';
					$terms = replace_file_str_val( $data ); 
					
					if( $mode == 'edit'){
						
						$default_terms_and_conditions = trim( $option_set_info[ 0 ][ $key ] ) != '' ? trim( $option_set_info[ 0 ][ $key ] ) : $terms;
						
						$option_set_info[ 0 ][ $key ] = $default_terms_and_conditions;
						
					}
					
				}
				
				/* check if control_type is image */
				elseif( $val['properties']['control_type'] == 'image' ){
					
					$imgsrc = '';
					$imgid = $mode == 'edit' ? $option_set_info[$option_row][$key] : 0;
					
					$imgsrcarr = wp_get_attachment_image_src( $imgid , 'medium');
					if( $imgsrcarr ) $imgsrc = $imgsrcarr[0];
					
					/* push to image array */
					array_push( $optionimg, $imgsrc );	
					
				}
				
			}
			
			/* construct new array for return as json */
			$option_set_arr = array(
								'option_details' => $optionsetdetails,
								'option_settings' => $optionsetproperties,
								'option_data' => $mode == 'edit' ? $option_set_info[$option_row] : '',
								'option_relation' => $optionrel,
								'option_default_data' => $data,
								'option_image' => $optionimg,
								'option_postinfo' => $postinfoarr,
								'option_pagetheme' => $optionpagetheme,
								'slider_items' => $slideritems,
								'slider_items_data' => $slideritemsdata
							);
			
			echo json_encode(  $option_set_arr );
	
	die();

?>