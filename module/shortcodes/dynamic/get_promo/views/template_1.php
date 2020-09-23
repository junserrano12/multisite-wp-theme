<?php 
global $post;
global $DWH_Data;
//extract($data);
?>
				<div class="well promoStyle">
				   <div>
					   	<h2><?php the_title(); ?></h2>
						<div class="image-holder">
							<?php 
								if(has_post_thumbnail()){
									the_post_thumbnail('medium');
								}else{
									echo '<img alt="" title="" class="header-image" src="'.get_template_directory_uri().'/images/banner-620x420.jpg">';
								}
							?>
						</div>
					   	<?php the_content(); ?>
				   </div>
				   <!--Sub-promos starts here Here-->
					   <div class="sub-promo-list">
							<?php if($totalSubPromo > 0){ ?>
								<?php for($i = 0; $i < 1; $i++){ ?>	
										<?php 
											$endPeriod = strtotime($promo_detail['promo-period-end'][$i]); 
											if($endPeriod >= $promo['date-today']){
										?>
										   <div class="sub-promo-details">
											   <div class="sub-promo-title">
												   <h1 class="ribbon">
													   <strong class="ribbon-content"><?php echo $promo_detail['promo-name'][$i]; ?></strong>
													</h1>
													<a class="btn btn--o-blue" href="<?php echo get_the_permalink(); ?>?key=<?php echo $i; ?>&amp;page=<?php echo $theSlug; ?>&amp;imgid=<?php echo $promo_detail['promo-image'][$i]; ?>&amp;promo=<?php echo the_title(); ?>" style="color:red;">
														View Details &raquo;
													</a>
											   </div>
											   <div class="sub-promo-description">
												   <?php echo $promo_detail['promo-desc'][$i]; ?>
												   <?php echo ' image id '.$promo_detail['promo-image'][$i]; ?>
											   </div>
										   </div>
							<?php } } } ?>
					   </div>
				</div>
