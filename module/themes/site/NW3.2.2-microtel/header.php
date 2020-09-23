<?php global $DWH_Theme; ?>

<div id="section" class="content">
	<header id="header">
		<?php if ( is_active_sidebar( 'header-container-top' ) ) { dynamic_sidebar( 'header-container-top' ); } ?>				
		<div id="header-container">
			<?php if ( is_active_sidebar( 'header-container-content' ) ) { dynamic_sidebar( 'header-container-content' ); } ?>				
		</div>
		<?php if ( is_active_sidebar( 'header-container-bottom' ) ) { dynamic_sidebar( 'header-container-bottom' ); } ?>				
	</header>

	<section id="main">
		<div id="sidebar-container">
			<?php get_sidebar(); ?>
		</div>

		<div id="main-container">
			<?php if ( is_active_sidebar( 'main-container-top' ) ) { dynamic_sidebar( 'main-container-top' ); } ?>
			<div id="primary">
				<div id="primary-main">