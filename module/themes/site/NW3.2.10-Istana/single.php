<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php while ( have_posts() ) : the_post(); ?>
		<header class="entry-header">
			<h1 class="entry-title">	<?php echo get_the_title(); ?></h1>
		</header>

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'basetheme' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'basetheme' ), 'after' => '</div>' ) ); ?>
		</div>

		<footer class="entry-footer">
			<?php get_template_part('content', 'footer'); ?>
			<?php edit_post_link( 'edit', '<span class="edit-link">', '</span>' ); ?>
		</footer>
	<?php endwhile; // end of the loop. ?>
</div>