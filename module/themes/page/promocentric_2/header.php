<?php 
$data['dir'] = array( 'module/themes','page');
$data['view'] = 'header';
load_view( $data );
?>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<header id="header">
			<div id="header-container" class="content">
				<?php if ( is_active_sidebar( 'header-container-content' ) ) { dynamic_sidebar( 'header-container-content' ); } ?>
			</div>
		</header>
		
		<section id="main">
			<div id="main-container" class="content">
				<?php if ( is_active_sidebar( 'main-container-top' ) ) { dynamic_sidebar( 'main-container-top' ); } ?>

				<div id="sidebar">
					<div id="sidebar-container">
						<?php the_widget('widget_logo');?>
						<?php echo do_shortcode('[get_map height="250"]');?>
					</div>
				</div>

				<div id="primary">
					<div id="primary-header">
						<?php if ( is_active_sidebar( 'primary-header-content' ) ) { dynamic_sidebar( 'primary-header-content' ); } ?>
					</div>
					<div id="primary-main">
						