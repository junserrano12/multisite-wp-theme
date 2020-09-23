<?php
require_once(get_template_directory().'/module/core/class.admin.php');
$DWH_Admin = new DWH_Admin();  
?>

<div id="style-settings" class="wrap">
	<h2> Page Style Settings</h2>
	<form method="post" action="options.php" id="form-admin-style-settings">

		<ul class="tab-menu">
			<li><a href="#pages" class="active">Theme Templates</a></li>
		
		</ul>
		<div id="pages" class="tab-container show">			
		
			Page Type

			<select>
				<?php foreach ( $GLOBALS['THEME_POST_TYPES']['posttype'] as $key => $value ) :?> 
					<option> <?php _dump( $value );?> </option>
				<?php endforeach;?>
			</select>

		</div>			
		</div>				
				
		<?php submit_button(); ?>
	</form>
</div>