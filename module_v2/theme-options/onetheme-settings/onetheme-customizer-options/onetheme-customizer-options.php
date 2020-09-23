<?php
if ( !function_exists( 'onetheme_customizer_options_do_page' ) ) {
    function onetheme_customizer_options_do_page( $main_options = array(), $sub_options = array() )
    {
        global $DWH_wponetheme_util;

        $filePath = get_template_directory().'/module_v2/theme-options/views/view-theme-options-form-tabs.php';
        $viewData = array( 'main_options' => $main_options, 'sub_options' => $sub_options );

        echo '<div class="theme-option-wrapper wrap">';
        echo '  <form id="'.$main_options->menu_slug.'-form" method="post" action="options.php" class="ajaxform">';
        settings_fields( $main_options->option_group.'_'.$sub_options->option_name );
        echo '  <div class="theme-option-title-container">';
        echo '      <h1 class="theme-option-title">'.$main_options->menu_title.'</h1>';
        echo '      <a class="button-save button dwh-button-save" onclick="jQuery(this).submit();">Save</a>';
        echo '  </div>';
        echo $DWH_wponetheme_util->render( $filePath, $viewData, false );
        echo '  <div class="theme-option-submit-button-container">';
        // echo '      <a class="button-save button" onclick="jQuery(this).submit();">Save</a>';
        echo '      <div class="theme-option-notification"></div>';
        echo '  </div>';
        echo '  </form>';
        echo '</div>';

    }
}