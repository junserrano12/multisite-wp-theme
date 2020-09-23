<?php

/* Get item  */
check_ajax_referer( 'widget_default_field_settings', 'nonce_sec' );
	
if( $_POST )
{	
	global $DWH_Options;

	$widget_name = $_POST['widget_name'];

	switch ( $widget_name ) {

		case 'widget_cta':
			

					/* Get default settings */
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
											$data['widget_settings'] = $cta_config_default;
											echo json_encode( array( 'success' => true , 'data' => $data ) );
										}
									
									}
								}
								
							}
						}
					}


			break;

	}


	

	
	
}
		

die();

?>