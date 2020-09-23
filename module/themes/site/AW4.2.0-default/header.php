<?php global $DWH_Theme; ?>
<header id="header">
	<div id="header-container" class="content">
		<?php if ( is_active_sidebar( 'header-container-content' ) ) { dynamic_sidebar( 'header-container-content' ); } ?>
	</div>
</header>

<section id="main">
	<div id="main-container" class="content">
		<?php if ( is_active_sidebar( 'main-container-top' ) ) { dynamic_sidebar( 'main-container-top' ); } ?>

		<?php get_sidebar(); ?>

		<div id="primary">
			<div id="primary-header">
				<?php if ( is_active_sidebar( 'primary-header-content' ) ) { dynamic_sidebar( 'primary-header-content' ); } ?>								
			</div>
			<div id="slider-container">
				<div class="slider-content">
					<?php if ( is_active_sidebar( 'slider-container-content' ) ) { dynamic_sidebar( 'slider-container-content' ); } ?>
				</div>
			</div>
			<div id="primary-main">

				