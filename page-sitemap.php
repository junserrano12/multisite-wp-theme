<?php /*Template Name: Sitemap Template*/ ?>
<?php get_header(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php get_template_part('content', 'header');?>
		</header>
		<div class="entry-content">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'basetheme' ) ); ?>
					<div id="sitemap-container" class="row-fluid">
						<div class="span12">
							<ul class="sitemap-list">
								<?php wp_list_pages( array( 'sort_column' => 'post_date', 'exclude' => get_the_ID() ) ); ?>
							</ul>
						</div>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>

		</div>

		<footer class="entry-footer">
			<?php get_template_part('content', 'footer'); ?>
			<?php edit_post_link( 'edit', '<span class="edit-link">', '</span>' ); ?>
		</footer>
	</div>
<?php get_footer(); ?>