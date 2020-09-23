<?php
include( get_template_directory().'/module_v2/functions/tools.php' );
include( get_template_directory().'/module_v2/functions/fonts.php' );

include( get_template_directory().'/module_v2/class/class-update.php' );
include( get_template_directory().'/module_v2/class/class-config.php' );
include( get_template_directory().'/module_v2/class/class-init.php' );
include( get_template_directory().'/module_v2/class/class-util.php' );
include( get_template_directory().'/module_v2/class/custom/class-nav-walker.php' );
include( get_template_directory().'/module_v2/class/custom/scss.inc.php' );

/* SCSS */
$scss = new scssc();
$scss->setImportPaths( get_template_directory().'/sass' );

/* THEME UPDATER*/
$DWH_wponetheme_data = wp_get_theme( 'wp_one_theme' );
if ( $DWH_wponetheme_data->exists() ) {
    $version                = $DWH_wponetheme_data->get( 'Version' );
    $name                   = $DWH_wponetheme_data->get( 'Name' );
    $DWH_wponetheme_updater = new DWH_wponetheme_updater( 'wp_one_theme', $version );
}

/* THEME */
$DWH_wponetheme_config           = new DWH_wponetheme_config();
$DWH_wponetheme_util             = new DWH_wponetheme_util();

$DWH_wponetheme_scripts          = new DWH_wponetheme_util();
$DWH_wponetheme_styles           = new DWH_wponetheme_util();

$DWH_wponetheme_slider           = new DWH_wponetheme_util();
$DWH_wponetheme_cta              = new DWH_wponetheme_util();
$DWH_wponetheme_maps             = new DWH_wponetheme_util();
$DWH_wponetheme_google_translate = new DWH_wponetheme_util();
$DWH_wponetheme_accordion        = new DWH_wponetheme_util();
$DWH_wponetheme_grid             = new DWH_wponetheme_util();
$DWH_wponetheme_iframe           = new DWH_wponetheme_util();
$DWH_wponetheme_facebook         = new DWH_wponetheme_util();
$DWH_wponetheme_tabs             = new DWH_wponetheme_util();
$DWH_wponetheme_slider           = new DWH_wponetheme_util();
$DWH_wponetheme_list             = new DWH_wponetheme_util();
$DWH_wponetheme_collection       = new DWH_wponetheme_util();

$DWH_wponetheme_init             = new DWH_wponetheme_init();