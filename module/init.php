<?php
/* Load Theme Framework functions */
define('DWH_SITE_THEME_DIR', get_template_directory().'/module/themes/');
define('DWH_SITE_THEME_URI', get_template_directory_uri().'/module/themes/');
define('DWH_SITE_WIDGETS_DIR', get_template_directory().'/module/widgets/');
define('DWH_SITE_WIDGETS_URI', get_template_directory_uri().'/module/widgets/');
define('DWH_SITE_SHORTCODES_DIR', get_template_directory().'/module/shortcodes/');
define('DWH_SITE_SHORTCODES_URI', get_template_directory_uri().'/module/shortcodes/');

/*include files*/
include(get_template_directory().'/module/customs.php');
include(get_template_directory().'/module/options.php');

include(get_template_directory().'/module/util.php');
include(get_template_directory().'/module/theme.php');
include(get_template_directory().'/module/admin.php');
include(get_template_directory().'/module/data.php');

include(get_template_directory().'/module/actions.php');
include(get_template_directory().'/module/filters.php');
include(get_template_directory().'/module/ajax.php');

include(get_template_directory().'/module/widget.php');
include(get_template_directory().'/module/shortcode.php');
include(get_template_directory().'/module/sidebar.php');
include(get_template_directory().'/module/post-types.php');
include(get_template_directory().'/module/customfields.php');
include(get_template_directory().'/module/slider.php');
include(get_template_directory().'/module/customization.php');
include(get_template_directory().'/module/wpeditor-buttons.php');

include(get_template_directory().'/module/update.php');
include(get_template_directory().'/module/ibeurl-fetch-schedule.php');