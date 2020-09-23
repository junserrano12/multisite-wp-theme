<?php /*template name: Custom Page*/ ?>
<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="ie ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
    <?php dwh_head(); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php dwh_body_hook(); ?>
    <?php if ( is_active_sidebar( 'body-top' ) ) { dynamic_sidebar( 'body-top' ); } ?>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php the_content( __( 'Continue reading', 'basetheme' ) ); ?>
        <?php endwhile; ?>
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'body-bottom' ) ) { dynamic_sidebar( 'body-bottom' ); } ?>
    <?php wp_footer(); ?>
  </body>
</html>