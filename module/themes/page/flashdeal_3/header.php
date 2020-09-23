<?php 
$data['dir'] = array( 'module/themes','page');
$data['view'] = 'header';
load_view( $data );
?>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<header id="header">
			<div id="header-container">
				<?php the_widget('widget_logo');?>
			</div>
		</header>

		<div id="slider-container" class="fullflexslider fullscreen-slider">
			<?php the_widget('widget_slider'); ?>
		</div>