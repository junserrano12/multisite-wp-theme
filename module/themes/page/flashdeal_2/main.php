<?php 
global $post;
global $DWH_Data;
?>
<section id="main">
	<div id="main-container">
		<div id="primary">
			<div id="primary-main">
				<?php if ( have_posts() ) : ?>				
					<?php while ( have_posts() ) : the_post(); ?>
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<?php get_template_part('content', 'header'); ?>
							</header>
							<div class="entry-content">
								<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'basetheme' ) ); ?>
							</div>
					</div>
					<?php endwhile; ?>
				<?php endif; ?>

			</div> <!-- /primary-main -->
		</div><!--- Primary Container -->

		<div id="cta-container-<?php echo $post->ID; ?>" class="cta-container">
			<div class="cta" cta-item-id="<?php echo $post->ID; ?>" >
				<?php
				$data['dir'] 	= array('module/cta/promo');
				$data['view'] 	= 'cta_flashdeal';
				$DWH_Data->get_cta( $data );
				?>
			</div>    
		</div>

	</div> <!-- /main-container -->
</section> <!-- /main -->	
