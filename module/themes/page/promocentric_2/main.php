<?php 
global $post;
global $DWH_Data;
extract($data);

/* Hotel Information */
$hotel_name		 	= $hotel_info->hotel_name;
$hotel_location		= $hotel_info->hotel_location;
$promo_group_info 	= $page_fields['promo_group'];

?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-list">
		<div id="list-container">
			<ul class="list-slider">
			<?php 
				if( $promo_group_info ) :
					$promocount = count($promo_group_info['promo-name']);
					for($i = 0; $i < $promocount; $i++) :
						$promoimage 		= isset( $promo_group_info['promo-image'][$i] ) ? $promo_group_info['promo-image'][$i] : get_template_directory_uri().'/images/banner.jpg';
					?>	
				 	<li>
						<div class="row-item">							
							<div class="row-top">								
								<?php 
									$imgids = explode(',', $promo_group_info['promo-image'][$i] );
									$imgcount = count( $imgids );									
									if( $imgids AND $imgids[0] ) :
								?>
										<!-- Slider -->
										<div id="slider-container">
											<div class="slider-content">
												<div class="flexslider slider-default">
													<ul class="slides">
														<?php foreach( $imgids as $imagesrcid) :
															$image_attributes = wp_get_attachment_image_src( $imagesrcid, 'full' );	
															$imagesrc = $image_attributes[0];
															$image_title = $hotel_name.' in '.$hotel_location;
															$attachment = get_post( $imagesrcid );
														?>
														<li>
															<div class="slider-image-container">
																<img src="<?php echo makeAbsoluteToRelative($imagesrc);?>" class="slider-image" title="<?php echo $image_title;?>" alt="<?php echo $image_title;?>" draggable="false">
															</div>
															<div class="image-caption"><?php echo $attachment->post_excerpt; ?></div>
															<div class="image-content"><?php echo $attachment->post_content; ?></div>
														</li>
														<?php endforeach; ?>
													</ul>
												</div>
											</div>
										</div>
										<!-- Slider -->
								<?php else : ?>
										<div class="image-container">
											<img alt="" title="" class="header-image" src="<?php echo get_template_directory_uri(); ?>/images/banner-620x420.jpg">
										</div>
								<?php endif; ?>
							</div>
							
							<div class="row-bottom">
								<div class="promo-details-container">
									<h2><?php echo $promo_group_info['promo-name'][$i];?></h2>
									<div class="promo-caption"><?php echo $promo_group_info['promo-label'][$i];?></div>
								<div class="promo-content"><?php echo $promo_group_info['promo-desc'][$i]; ?></div>
								</div>

								<div id="cta-container-<?php echo $i?>" class="cta-container">
									<div class="cta" cta-item-id="<?php echo $i?>">
									<?php
										$data['dir'] 	= array('module/cta/promo');
										$data['view'] 	= 'cta_promocentric';
										$data['ctr'] 	= $i;
										$DWH_Data->get_cta( $data );
									?>
									</div>												
								</div>

							</div>
						</div>
					</li>
				<?php endfor;?>
			<?php endif;?>
			</ul>
		</div>
	</div>
	<header class="entry-header">
		<?php get_template_part('content', 'header');?>
		<div class="tagline">
			<?php echo $page_fields['tagline']; ?>
		</div>							
	</header>

	<div class="entry-content">
		<?php if ( have_posts() ) : ?>				
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'basetheme' ) ); ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
		
	<footer class="entry-footer">
		<?php get_template_part('content', 'footer'); ?>
		<?php edit_post_link( 'edit', '<span class="edit-link">', '</span>' ); ?>
	</footer>
</div>
