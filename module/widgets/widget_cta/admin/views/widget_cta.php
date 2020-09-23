<?php 
extract($data);
global $DWH_Widget;
global $DWH_Options;
global $DWH_Theme;

$data['dir'] = array('module/cta/nw');

$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);

if( $site_info )
{
	$site_theme_name  = strtolower( $site_info->site_theme );
}

$site_theme_category = "";
$cta_theme_config = include( get_template_directory() . '/module/widgets/widget_cta/config.fields.default.php');

$cta_sets = array();
$site_theme_config = $DWH_Theme->get_site_theme_config();

if( $site_theme_config )
{	
	$site_theme_category = strtolower($site_theme_config['details']['category']);
	$site_theme_category = $site_theme_config['details']['category'];
}

?>

<?php foreach( $form_fields as $key => $field ):?>
	<?php 
		$field_html = $DWH_Widget->get_form_field_element( $key , $field['properties'] );
		echo $field_html;
	?>
<?php endforeach;?>

<p>
	<i> You can set a custom title and CTA button label. Modify or cancel link is available in all CTA types. </i>
</p>

<div id="cta_set_desc">
<?php foreach ($cta_theme_config[$site_theme_category] as $key => $value):?>
	<div class="text" style="display:none" id="<?php echo $key;?>"> <h5> <?php echo $value['description'];?> </h5>  </div>
<?php endforeach;?>
</div>



