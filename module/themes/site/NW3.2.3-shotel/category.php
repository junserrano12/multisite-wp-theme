<div id="page-category" <?php post_class(); ?>>
	<header class="entry-header">
		<?php get_template_part('content', 'header'); ?>
		<?php if ( category_description() ) : // Show an optional category description ?>
		<div class="archive-meta"><?php echo category_description(); ?></div>
		<?php endif; ?>
	</header>
		
	<div class="entry-content">
		<?php if ( have_posts() ) : ?>				
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
			<?php basetheme_content_nav( 'nav-below' ); ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	</div><!-- .entry-content -->
		
	<footer class="entry-footer">
		<?php get_template_part('content', 'footer'); ?>
	</footer>
	
</div><!-- #content -->	