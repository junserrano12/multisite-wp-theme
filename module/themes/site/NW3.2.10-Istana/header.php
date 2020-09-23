<?php global $DWH_Theme; ?>

<header id="header">
	<div id="menu-primary-top">
		<div class="content">
			<?php if ( is_active_sidebar( 'menu-primary-top' ) ) { dynamic_sidebar( 'menu-primary-top' ); } ?>
		</div>
	</div>
	<div id="header-container">
		<div class="content">
			<div id="header-main">
				<?php if ( is_active_sidebar( 'header-main-content' ) ) { dynamic_sidebar( 'header-main-content' ); } ?>
			</div>
		</div>
	</div>
	<div id="menu-primary-bottom">
		<div class="content">
			<?php if ( is_active_sidebar( 'menu-primary-bottom' ) ) { dynamic_sidebar( 'menu-primary-bottom' ); } ?>
		</div>
	</div>
</header>

<div id="slider-container" class="hidden-xs">
	<?php if ( is_active_sidebar( 'slider-container-top' ) ) { dynamic_sidebar( 'slider-container-top' ); } ?>
	<div class="slider-content">
		<?php if ( is_active_sidebar( 'slider-container-content' ) ) { dynamic_sidebar( 'slider-container-content' ); } ?>
	</div>
	<?php if ( is_active_sidebar( 'slider-container-bottom' ) ) { dynamic_sidebar( 'slider-container-bottom' ); } ?>
</div>	

<section id="main">
	<div id="main-container">
		<?php if ( is_active_sidebar( 'main-container-top' ) ) { dynamic_sidebar( 'main-container-top' ); } ?>
		<div class="content">
			<?php if ( is_active_sidebar( 'main-container-content' ) ) { dynamic_sidebar( 'main-container-content' ); } ?>
			<div id="primary">
				<div id="primary-main">