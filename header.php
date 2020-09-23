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

	<div id="wrapper">
		<?php dwh_header_hook(); ?>