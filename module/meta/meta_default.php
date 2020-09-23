<?php global $post;?>

<!-- Defaults -->
<title><?php wp_title( '|', true, 'right' ); ?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<?php if(is_page() || is_single()) { ?>
<meta name="keywords" content="<?php echo get_post_meta( $post->ID, 'meta_keywords', true ); ?> ">
<meta name="description" content="<?php echo get_post_meta( $post->ID, 'meta_description', true ); ?> ">
<?php } ?>
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

