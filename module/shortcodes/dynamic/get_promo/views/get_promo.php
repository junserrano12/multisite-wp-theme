<?php 
global $post;
global $DWH_Data;

?>
<div id="promo-accordion-list" class="accordion-container">
	<ul class="list-accordion" id="promocentric-aw">
	
		<?php $setPromo = get_dwh_option( 'dwh_promo_link_navigation' );
		$promoID = '';
		$template = '';
		foreach($setPromo as $key => $value){
			foreach($value as $key => $value){
				if($key == 'promo_post_ids'){
					$promoID = $value;
				}
			}
		}
		
		$promoID    = explode(',',$promoID);
		
		$var        = shortcode_atts(array('template'=>''),$atts);
		$template   = (esc_attr($var['template']) != '' ) ? esc_attr($var['template']) : 'template_1';
		
		$temp       = preg_replace('/\s+/', '_',$template); //ensure to replace space into underscore
		$imageID    = ''; //use this id to retrieve the image used in the promo
		$promoImage = ''; //the actual image used in the promo, retrieved using the $imagesID variable
		$promoStart = '';
		$promoEnd   = '';	
		
		$args      = array('post_type' => 'promocentric', 'post__in' => $promoID, 'orderby' => 'post__in' ); //$promoID is an array
		  
		$my_query  = new WP_Query($args);
		$promo     = Array();
		$uploadDir = wp_upload_dir();
		$imgDir    = $uploadDir['baseurl']; 
		
		if( $my_query->have_posts() ) {
			$varShortcode = '';
			$promo['date-today'] = strtotime(date('d-M-Y'));
			$date_today = strtotime(date('d-M-Y'));
			$theSlug = the_slug();
                        $notExpired = Array();
                        
				while ($my_query->have_posts()) : $my_query->the_post();
					$theID                = get_the_ID();
					$promo_detail         = get_promo_group_detail($theID,'promo_group');
					$totalSubPromo        = count($promo_detail['promo-name']);
					$promo_period_end     = $promo_detail['promo-period-end'][0];                                        
					$promo_period_end_t  = strtotime($promo_period_end);
                                        $promo_img_detail     = get_promo_group_img_detail($promo['promo-imgID']);
					$promo['promo-image'] = $imgDir.'/'.$promo_img_detail;
					$promo_end            = strtotime($promo['promo-end']);	
                                        
                                        for($i = 0; $i<$totalSubPromo; $i++){ //loop through the available promo to get unexpired promo
                                            $isNotExpired = strtotime($promo_detail['promo-period-end'][$i]);
                                            
                                            if($isNotExpired >= $date_today){
					
                                        
					//if($promo_period_end_t >= $date_today || $promo_period_end == ''){
					?>
					
					<li class="accordion-item">
						<div class="accordion-caption">
							<a href="" class=""><h2><?php the_title(); ?></h2><span class="fa"></span></a>
						</div>
						<div id="" class="accordion-content">
						   	<div class="row-fluid">
						   		<div class="span12">
									<div class="promo-image-holder">
										<?php 
											if(has_post_thumbnail()){ 
												echo '<img src="'.wp_get_attachment_url(get_post_thumbnail_id($theID)).'" />';
											}
										?>
									</div>
								   	<?php the_content(); ?>
					   			<!--Sub-promos starts here Here-->
								   <div class="sub-promo-list">
										<?php if($totalSubPromo > 0){ ?>
											<?php for($i = 0; $i < $totalSubPromo; $i++){ ?>	
												<?php 
													$endPeriod = strtotime($promo_detail['promo-period-end'][$i]); 
													$cta_display = $promo_detail['promo-cta-display'][$i]; 
													
													//do not display if promo expired
													if($endPeriod >= $promo['date-today']){												
													
												?>
												<div class="sub-promo-details">
													<div id="cta-container-<?php echo $i?>" class="cta-container">
														<div class="cta" cta-item-id="<?php echo $i?>">
														<?php
															$data['dir'] 	= array('module/cta/promo');
															$data['view'] 	= 'cta_promocentric';
															$data['cta_display'] = $cta_display;
															$data['ctr'] 	= $i;
															$data['promo_group'] 	= $promo_detail;
															$data['promo_page']   = 'list';
															$data['show'] = 'show';
															
															$DWH_Data->get_cta( $data );
														?>
														<!--<?php echo remainingDays($promo_detail['promo-period-end'][$i]); ?>-->
														</div>											
													</div>
													<div class="sub-promo-title">
														<h1>
															<strong><?php echo $promo_detail['promo-name'][$i]; ?></strong>
														</h1>
													</div>
													<div class="sub-promo-description">
														<?php echo $promo_detail['promo-desc'][$i]; ?>
													</div>
													<div class="promo-period">
														<?php
															echo 'Stay from ', '<strong>'.$promo_detail['promo-stay-start'][$i],'</strong>', ' to ', '<strong>'.$promo_detail['promo-period-end'][$i],'</strong>' ; 
														?>
													</div>
													<form action="<?php echo get_the_permalink(); ?>" method="POST" style="text-align:right;">
														<input type="hidden" name="key" value="<?php echo $i; ?>" />
														<input type="hidden" name="page" value="<?php echo $theSlug; ?>" />
														<input type="hidden" name="imgid" value="<?php echo $promo_detail['promo-image'][$i]; ?>" />
														<input type="hidden" name="promo" value="<?php echo the_title(); ?>" />
														<input type="submit" name="submit" value="View Details &raquo;" class="btn-ViewDetails" />
													</form>
												</div>
										<?php } } } ?>
								   </div>
								</div> <!-- span end-->
						  	</div> <!-- row fluid -->
						</div> <!-- accordion content -->
					</li>
					
					<?php 
                                           // } 
                                         }
                                        }
                                        endwhile; ?>
				</ul>
			</div>
				<?php return $varShortcode;
		}
		wp_reset_query();  // Restore global post data stomped by the_post().
	

?>
				
