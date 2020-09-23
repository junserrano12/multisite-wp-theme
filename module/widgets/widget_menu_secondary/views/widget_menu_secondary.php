<?php
global $DWH_Options;
global $DWH_Theme;
global $DWH_Data;
?>

<nav id="secondary-menu">
	<?php 
	   
		$currentmenu = get_the_ID();
		$menuitems = return_wp_clean_menu_items(wp_get_nav_menu_items( 'Secondary Menu'));
		if($menuitems){
			echo (isset($data['instance']['title']) && $data['instance']['title'] != '') ? '<h2>'.$data['instance']['title'].'</h2>' : '';
	?>	
			<ul class="menu" id="menu-secondary-menu">
		
				<?php
					foreach($menuitems as $menu):
						$activemenu = $menu['menu']->object_id == $currentmenu ? ' current-menu-item' : '';
						$liclass = return_wp_menu_attr( $menu['menu'], 'li') . $activemenu;
						$linkattr = trim( return_wp_menu_attr( $menu['menu'], 'link') );

						$hotel_info = $DWH_Options->get_dwh_site_option_field('dwh_hotels',0);
						$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);
						
						$site_theme_config = $DWH_Theme->get_site_theme_config();
						$link_url_config = $DWH_Data->get_cta_config();
						$site_theme_category = strtolower($site_theme_config['details']['category']);
						$link_url_config = $link_url_config[$site_theme_category]['button'];
						$data['hotel_info'] = $hotel_info;
						$data['link_url_config'] = $link_url_config;
						$link_url = $link_url_config['base_url'].$hotel_info->hotel_id . '/';
						if(isset($link_url_config['param1'])) $link_url .= $link_url_config['param1'];
				?>

					<?php if( $menu['menu']->classes[0] == 'ctareservation' ):?>
						
						<?php

							switch ( $site_theme_category ) {
								
									case 'nw':
												
											$ga_track_event_click = $DWH_Data->get_ga_track_event( $site_theme_category,'default','text-link-footer', true , $data );
											$ga_track_event_link_push = $DWH_Data->get_ga_track_event( $site_theme_category,'link','text-link-footer', true , $data );

										break;

									case 'aw':
												
											$ga_track_event_click = $DWH_Data->get_ga_track_event( $site_theme_category,'default','cta-link', true , $data );
											$ga_track_event_link_push = $DWH_Data->get_ga_track_event( $site_theme_category,'link','cta-link', true , $data );

										break;

								}
								
								/* if universal analytics */
								$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
								$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
								$ga_onclick_event = $gtm_flag == 0 ? 'onclick="'. $ga_track_event_click . $ga_track_event_link_push .'"' : '';
							
								if( DWH_SSL == true ){
									$link_url = $DWH_Theme->http_to_https( $link_url );
								}
						?>


						<li class="<?php echo $liclass; ?>" id="menu-item-<?php echo esc_attr($menu['menu']->ID); ?>">
							<a class="reservationfooterlink" <?php echo $ga_onclick_event; ?> href='<?php echo $link_url;?>'><?php echo esc_attr($menu['menu']->title); ?></a>
						</li>
								
					<?php 
						else:
						
							if( DWH_SSL == true ){
								$linkattr = $DWH_Theme->http_to_https( $linkattr );
							}
					?>

							<li class="<?php echo $liclass; ?>" id="menu-item-<?php echo esc_attr($menu['menu']->ID); ?>">
								<a <?php echo $linkattr; ?>><?php echo esc_attr($menu['menu']->title); ?></a>
							</li>		

					<?php endif;?>

				<?php 
					endforeach;
				?>
		
			</ul>
	<?php
		}
	?>	
</nav>
