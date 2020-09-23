<?php global $DWH_Theme; ?>

<header id="header">
	<div id="header-container">
		<?php if ( is_active_sidebar( 'header-container-content' ) ) { dynamic_sidebar( 'header-container-content' ); } ?>
	</div>
</header>

<div id="slider-container" class="fullflexslider fullscreen-slider">
	<?php if ( is_active_sidebar( 'slider-container-content' ) ) { dynamic_sidebar( 'slider-container-content' ); } ?>
</div>	

<section id="main">
	<div id="main-container-top">
		<?php if ( is_active_sidebar( 'main-container-top' ) ) { dynamic_sidebar( 'main-container-top' ); } ?>
	</div>
	<div id="main-container">
		<div class="content">
			<div id="primary">
				<div id="primary-main" class="scroll-container">