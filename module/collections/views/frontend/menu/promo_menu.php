<?php
global $DWH_Options, $DWH_Theme;
$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);
$theme_info = $DWH_Theme->get_site_theme_config();

if( $theme_info ){

	if( $theme_info['details']['category'] == 'AW' ){
	
		$promo_nav_info = $DWH_Options->get_dwh_site_option_field( 'dwh_promo_link_navigation',0);
		
		if( $promo_nav_info ){
			
			if( $promo_nav_info->promo_post_ids ){
				$promo_nav_arr = explode( ',', $promo_nav_info->promo_post_ids );
				
				$promo_pages_array = [];
				
				/* $promo_nav_arr = array( 441, 20,  ); */
				$promo_pages_query = new WP_Query( array( 'post_type' => array('flashdeal', 'promocentric'), 'post__in' => $promo_nav_arr ) );
				$datenow = date('d-M-Y');
				
				foreach( $promo_pages_query->posts as $key => $val ){
					$promo_type = $val->post_type;
					
					switch($promo_type){
							case 'flashdeal':
								$promo_end_date = get_post_meta( $val->ID, 'promo_end_date', true );
								if( strtotime( $datenow ) <= strtotime( $promo_end_date ) ){
									array_push( $promo_pages_array, $val );
								}
						break;
							case 'promocentric':
								$promo_group = get_post_meta( $val->ID, 'promo_group', true );
								if( $promo_group ){
									$promo_count = count( $promo_group['promo-name'] );
									$promo_ctr = 0;
										
									for($i = 0; $i < $promo_count; $i++){
										if( strtotime( $datenow ) <= strtotime( $promo_group['promo-period-end'][$i] ) ){
											$promo_ctr++;
										}
									}
									
									if( $promo_ctr ){
										array_push( $promo_pages_array, $val );
									}
								}
								
						break;
					}
				}
				
				$promo_total = count( $promo_pages_array );
				
				/* multiple */
				if( $promo_total > 1 ){
				?>
					<li class="menu-item menu-item-has-children">
						<a><?php echo $promo_nav_info->promo_label_multiple != '' ? $promo_nav_info->promo_label_multiple : esc_attr( 'Promo' ); ?></a>
						
						<ul class="sub-menu">
				<?php
							foreach( $promo_pages_array as $key => $val ){
								$menuid = 'menu-item-'. esc_attr($val->ID);
								$menuclass = 'menu-item menu-item-type-custom menu-item-object-custom '. $menuid;
								$menuclass .= $val->ID == get_the_ID() ? ' current-menu-item' : '';
								
								$linkattr = 'href="'. site_url() .'/'. $val->post_type .'/'. $val->post_name .'"';
								
								if( DWH_SSL == true ){
									$linkattr = $DWH_Theme->http_to_https( $linkattr );
								}
				?>
								
								<li class="<?php echo $menuclass; ?>" id="<?php echo $menuid; ?>">
									<a <?php echo $linkattr; ?>><?php echo esc_attr( $val->post_title ); ?></a>
								</li>
								
				<?php
							}
				?>	
						</ul>
					</li>
				<?php
				}
				
				/* single */
				else{
					foreach( $promo_pages_array as $key => $val ){
						$menuid = 'menu-item-'. esc_attr($val->ID);
						$menuclass = 'menu-item menu-item-type-custom menu-item-object-custom '. $menuid;
						$menuclass .= $val->ID == get_the_ID() ? ' current-menu-item' : '';
						
						$linkattr = 'href="'. site_url() .'/'. $val->post_type .'/'. $val->post_name .'"';
						
						if( DWH_SSL == true ){
							$linkattr = $DWH_Theme->http_to_https( $linkattr );
						}
				?>
						<li class="<?php echo $menuclass; ?>" id="<?php echo $menuid; ?>">
							<a <?php echo $linkattr; ?>><?php echo $promo_nav_info->promo_label_single != '' ? $promo_nav_info->promo_label_single : esc_attr( 'Promo' ); ?></a>
						</li>
				<?php
					}
				}
			}
			
		}
		
	}
	
}
	
	
?>