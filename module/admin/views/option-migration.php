<?php 
global $DWH_Options;
global $DWH_Admin;
$options_list = $DWH_Options->get_migration_list();
$site_themes = $DWH_Admin->get_site_themes();

$flush_rewrite_info = get_dwh_option('dwh_option_permalink_flush');
if( !empty( $flush_rewrite_info ) )
{		
	$flush_rewrite_enabled = $flush_rewrite_info['enable_flag']  == false ? '' : 'checked';
}

?>

<div class="wrap">

<!-- Migrate Site Options -->
<h3> <span class="dashicons dashicons-admin-site"></span> Migrate Site options </h3>
	<form method="post" action="options.php" id="form-migrate">
		
		<div class="control-wrapper" with="400px">
			<label>From</label>
				<select name="migrate_ver_from"class="option-field relation required">
					<option value="">Select</option>
					<?php if(!empty( $options_list )):?>
						<?php foreach ($options_list as $key => $option_item):?>
							<option value="<?php echo $option_item;?>"> <?php echo $option_item;?> </option>
						<?php endforeach;?>
					<?php endif;?>
				</select>
			<label>To</label>
				<select name="migrate_ver_to"class="option-field relation required">
					<option value="">Select</option>
					<?php if(!empty( $site_themes )):?>
						<?php foreach ($site_themes as $key => $site_theme):?>
							<option value="<?php echo $key;?>"> <?php echo $site_theme['name'];?> </option>
						<?php endforeach;?>
					<?php endif;?>
				</select>
				<span> Theme to activate once data is migrated </span>
				<p>
				Go to <a target="_blank" href="<?php echo get_admin_url().'admin.php?page=dwh-theme-docu';?>"> <b> Theme Guide </b> </a> for more details about the themes
				</p>
		</div>
		<?php submit_button('Migrate'); ?>

	</form>
	
	<!-- Export Site Options -->
	<div>
		<h3> <span class="dashicons dashicons-arrow-down-alt"></span> Export Site Options </h3>

		<form method="post" action="options.php" id="form-export">
			
			<div class="control-wrapper">
				<label> Export
				<p class="description"> This will output an xml file that can also be imported </p>
				</label>
			</div>
			<textarea style="display:none" id="textrea_export"></textarea>
			<?php submit_button('Export'); ?>

		</form>
	</div>

	<!-- Import Site Options -->
	<div>
		<h3> <span class="dashicons dashicons-migrate"></span> Import Site Options </h3>

		<form method="post" action="options.php" id="form-import">

			<div class="control-wrapper">
				<label>  Import
					<p class="description"> XML file to synch site options with </p>
					<input type="button" name="" class="button-primary button-import-xml" value="Import">
				</label>
			</div>

		</form>
	</div>

	<!-- Individual Reset Site Options -->
	<h3> <span class="dashicons dashicons-admin-site"></span> Individual Reset Site Settings </h3>		
	
	<div class="box reset-option-fields">
		<h4>Check option set to reset below</h4>
		<?php
			$optionsetarr = $DWH_Options->get_option_set_list();
			
			foreach( $optionsetarr as $key => $val ){
		?>
				<div class="control-wrapper full-width">
					<label>
						<input type="checkbox" value="" name="<?php echo $key; ?>" class="option-field">
						<span class="dashicons <?php echo $val['icon']; ?>"></span>
						<span class="title"><?php echo $val['title']; ?></span>
						<p class="description"><?php echo $val['description']; ?></p>
					</label>
				</div>
		<?php
			}
		?>
		<input type="button" name="btn-reset-site-settings-individual" id="btn-reset-site-settings-individual" class="button button-primary" value="Reset Option Set">
	
	</div>

	<!-- Reset Site Options -->
	<h3> <span class="dashicons dashicons-admin-site"></span> Bulk Reset Site Settings </h3>		
	<div class="control-wrapper" with="400px">
		<label> Resets all Site Settings </label>
	</div>
	<input type="button" name="btn-reset-site-settings" id="btn-reset-site-settings" class="button button-primary" value="Reset">
	
	
	<!-- preloader modal -->
	<div class="hide">
		<div class="options-preloader">Processing migration...</div>
		<div class="options-mask"></div>
	</div>
	<!-- end preloader modal -->

</div>