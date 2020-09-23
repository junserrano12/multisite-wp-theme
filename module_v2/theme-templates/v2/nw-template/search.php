<div id="page-search" <?php post_class(); ?>>
	<?php dwh_content_header_hook(); ?>
	<div class="entry-content">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'basetheme' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
	<?php dwh_content_footer_hook(); ?>
</div>