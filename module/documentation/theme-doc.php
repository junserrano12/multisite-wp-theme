<div class="wrap">

	<h2> Theme Guide </h2>
	<form method="post" action="o">

		<ul class="tab-menu">

			<li><a href="#sitethemes" class="active">  Site themes </a></li>
			<li><a href="#pagethemes">  Page themes </a></li>
			<li><a href="#shortcodes"> Shortcodes </a></li>
			<li><a href="#widgets"> Widgets </a></li>
			<li><a href="#fonts"> Fonts </a></li>

		</ul>
		
		<?php  include( get_template_directory().'/module/documentation/doc_site_themes.php' );?>
		<?php  include( get_template_directory().'/module/documentation/doc_page_themes.php' );?>
		<?php  include( get_template_directory().'/module/documentation/doc_shortcodes.php' );?>
		<?php  include( get_template_directory().'/module/documentation/doc_widgets.php' );?>
		<?php  include( get_template_directory().'/module/documentation/doc_site_fonts.php' );?>

		<?php submit_button(); ?>

	</form>

</div>