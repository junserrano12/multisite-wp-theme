<?php
global $DWH_Options;
global $DWH_Theme;
global $DWH_Data;
?>
<div id="main-menu-container">
	<nav id="main-menu">
	<a id="rmenu" class="hide-layer" href="#?">
	<span>Menu</span>
	<div class="rmenu">
		<span class="line"></span>
		<span class="line"></span>
		<span class="line"></span>
	</div>
	</a>
	<?php 
	
		$currentmenu = get_the_ID();
		$menuitems = return_wp_clean_menu_items(wp_get_nav_menu_items( 'Primary Menu'));
		
		if($menuitems){

	?>	
			<ul id="menu-primary-menu" class="menu visible-layer">
		
				<?php foreach($menuitems as $menu):?>
				<?php
						$activemenu = $menu['menu']->object_id == $currentmenu ? ' current-menu-item' : '';
						$liclass = return_wp_menu_attr( $menu['menu'], 'li') . $activemenu;
						$liclass .= isset($menu['sub-menu']) ? ' menu-item-has-children' : '';
						$linkattr = return_wp_menu_attr( $menu['menu'], 'link');
				?>
			
						<li class="<?php echo $liclass; ?>" id="menu-item-<?php echo esc_attr($menu['menu']->ID); ?>">

							<?php if( $menu['menu']->classes[0] == 'ctareservation' ):?>
							<?php

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

								$ga_track_event_click = $DWH_Data->get_ga_track_event( $site_theme_category,'default','reservation-menu', true , $data );
								$ga_track_event_link_push = $DWH_Data->get_ga_track_event( $site_theme_category,'link','reservation-menu', true , $data );

								/* if universal analytics */
								$google_analytics_info 	= $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
								$gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
								$ga_onclick_event = $gtm_flag == 0 ? 'onclick="'. $ga_track_event_click . $ga_track_event_link_push .'"' : '';
								
							?>
									<a class="reservationheaderlink" <?php echo $ga_onclick_event; ?> href='<?php echo $link_url;?>'><?php echo esc_attr($menu['menu']->title); ?></a>

							<?php 
								else:
								
									if( DWH_SSL == true ){
										$linkattr = $DWH_Theme->http_to_https( $linkattr );
									}
							?>

										<a <?php echo $linkattr; ?>><?php echo esc_attr($menu['menu']->title); ?></a>

							<?php endif;?>
						
							
							<?php if(isset($menu['sub-menu'])):?>
						
								<ul class="sub-menu">
							
									<?php foreach($menu['sub-menu'] as $submenu):?>
										<?php 
											$activesubmenu = $submenu->object_id == $currentmenu ? ' current-menu-item' : '';
											$liclass = return_wp_menu_attr( $submenu, 'li') . $activesubmenu;
											$linkattr = return_wp_menu_attr( $submenu, 'link');
											
											if( DWH_SSL == true ){
												$linkattr = $DWH_Theme->http_to_https( $linkattr );
											}
										?>
										
										<li class="<?php echo $liclass; ?>" id="menu-item-<?php echo esc_attr($submenu->ID); ?>">
											<a <?php echo $linkattr; ?>><?php echo esc_attr($submenu->title); ?></a>
										</li>

									<?php endforeach; ?>
						
								</ul>

							<?php endif;?>
							
						</li>
				<?php endforeach;?>
				
				<?php
					/* AW Promo Rendering */
					$data['dir'] = array('module','collections/views','frontend','menu');
					$data['view'] = 'promo_menu';
					load_view( $data );
				?>
				
				
			</ul>
	<?php
		}
	?>

	</nav>
	
</div>