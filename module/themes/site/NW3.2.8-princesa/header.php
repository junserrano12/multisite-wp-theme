<?php global $DWH_Theme; ?>

<header id="header">
	<div id="header-container">
		<?php if ( is_active_sidebar( 'header-container-content' ) ) { dynamic_sidebar( 'header-container-content' ); } ?>
	</div>
</header>

<div id="slider-container">
	<?php if ( is_active_sidebar( 'slider-container-top' ) ) { dynamic_sidebar( 'slider-container-top' ); } ?>
	<div class="slider-content">
		<?php if ( is_active_sidebar( 'slider-container-content' ) ) { dynamic_sidebar( 'slider-container-content' ); } ?>
	</div>
	<?php if ( is_active_sidebar( 'slider-container-bottom' ) ) { dynamic_sidebar( 'slider-container-bottom' ); } ?>
</div>	

<section id="main">
	<?php if ( is_active_sidebar( 'main-container-top' ) ) { dynamic_sidebar( 'main-container-top' ); } ?>
	<div id="main-container">
		<div class="content">
			<div id="primary">
				<div id="primary-main">