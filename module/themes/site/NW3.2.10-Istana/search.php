<div id="page-search" <?php post_class(); ?>>
	<header class="entry-header">
		<?php get_template_part('content', 'header');?>
	</header>
	
	<?php if ( have_posts() ) : ?>
	<div class="entry-content">
		<?php basetheme_content_nav( 'nav-above' ); ?>
		
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>

		<?php basetheme_content_nav( 'nav-below' ); ?>
	</div>

	<?php else : ?>
	<div class="entry-content">
		<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'basetheme' ); ?></p>
		<?php get_search_form(); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	
	<footer class="entry-footer">
		<?php get_template_part('content', 'footer'); ?>
	</footer>
</div>