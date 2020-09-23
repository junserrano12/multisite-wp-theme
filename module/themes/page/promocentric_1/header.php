<?php 
$data['dir'] = array( 'module/themes','page');
$data['view'] = 'header';
load_view( $data );
?>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<header id="header">
			<div class="content">
				<?php the_widget('widget_logo');?>
			</div>
		</header>	