<div id="page-index" <?php post_class(); ?>>
	<?php dwh_content_header_hook(); ?>	
	<div class="entry-content">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>	
	<?php dwh_content_footer_hook(); ?>
</div>
