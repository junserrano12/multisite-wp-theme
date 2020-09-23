<?php global $DWH_Theme; ?>

<header id="header">
	<div id="header-container">
		<?php if ( is_active_sidebar( 'header-container-top' ) ) { dynamic_sidebar( 'header-container-top' ); } ?>
		<div class="content">
			<?php if ( is_active_sidebar( 'header-container-content' ) ) { dynamic_sidebar( 'header-container-content' ); } ?>
		</div>
		<?php if ( is_active_sidebar( 'header-container-bottom' ) ) { dynamic_sidebar( 'header-container-bottom' ); } ?>
	</div>
</header>

<div id="slider-container">
	<div id="slider-header">
		<div class="content">
			<?php if ( is_active_sidebar( 'slider-container-top' ) ) { dynamic_sidebar( 'slider-container-top' ); } ?>
		</div>
	</div>
	<div id="slider-main">
		<div class="slider-content">
			<?php if ( is_active_sidebar( 'slider-container-content' ) ) { dynamic_sidebar( 'slider-container-content' ); } ?>
		</div>
	</div>
	<div id="slider-footer">
		<div class="content">
			<?php if ( is_active_sidebar( 'slider-container-bottom' ) ) { dynamic_sidebar( 'slider-container-bottom' ); } ?>
		</div>
	</div>
</div>	

<section id="main">
	<div id="main-container">
		<?php if ( is_active_sidebar( 'main-container-top' ) ) { dynamic_sidebar( 'main-container-top' ); } ?>
		<div class="content">
			<?php if ( is_active_sidebar( 'main-container-content' ) ) { dynamic_sidebar( 'main-container-content' ); } ?>
			<div id="primary">
				<div id="primary-main">