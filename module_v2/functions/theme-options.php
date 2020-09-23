<?php
if ( !function_exists( 'dwh_wponetheme_add_theme_option_menu' ) )
{
    function dwh_wponetheme_add_theme_option_menu()
    {
        global $DWH_wponetheme_config;
        global $DWH_wponetheme_util;

        $theme_options_config = dwh_get_config( 'config.theme.options', 'json' );

        if ( $theme_options_config ) {

            foreach ( $theme_options_config as $theme_options ) {

                $menu_slug                  = $theme_options->menu_slug;
                $theme_options_directory    = dwh_get_main_directory().'/module_v2/theme-options';

                switch ( $theme_options->option_type ) {
                    case 'sub-theme-option':

                        $parent_slug        = str_replace( '_', '-', $theme_options->option_group );
                        $option_config      = dwh_get_config( 'config.'.str_replace( '-', '.', $menu_slug ), 'json', array( 'module_v2', 'theme-options', $parent_slug, $menu_slug, 'config' ) );
                        $option_file        = "$theme_options_directory/$parent_slug/$menu_slug/$menu_slug.php";

                        break;

                    default:

                        $option_file        = "$theme_options_directory/$menu_slug/$menu_slug.php";

                        break;
                }

                if ( file_exists( $option_file ) ) {
                    include( $option_file );
                }
            }

            foreach ( $theme_options_config as $theme_options ) {

                $page_title                 = isset( $theme_options->page_title ) ? $theme_options->page_title : null;
                $menu_title                 = isset( $theme_options->menu_title ) ? $theme_options->menu_title : null;
                $capability                 = isset( $theme_options->capability ) ? $theme_options->capability : null;
                $menu_slug                  = isset( $theme_options->menu_slug ) ? $theme_options->menu_slug : null;
                $callable                   = isset( $theme_options->callable ) ? $theme_options->callable : null;
                $icon                       = isset( $theme_options->icon ) ? $theme_options->icon : null;
                $position                   = isset( $theme_options->position ) ? $theme_options->position : null;

                $hide_submenu               = isset( $theme_options->config_options->hide_submenu ) ? $theme_options->config_options->hide_submenu : false;
                $global_option              = isset( $theme_options->config_options->global_option ) ? $theme_options->config_options->global_option : false;

                $theme_options_directory    = dwh_get_main_directory().'/module_v2/theme-options';
                $parent_slug                = ( $theme_options->option_type === 'sub-theme-option') ? str_replace( '_', '-', $theme_options->option_group ) : false;

                add_action('admin_init', function () use ( $theme_options, $menu_slug ) {
                    $option_group  = $theme_options->option_group;
                    $option_name   = str_replace('-', '_', $menu_slug);
                    register_setting( $option_group.'_'.$option_name, $option_name );
                } );

                if ( $global_option ) {

                    $option_config = dwh_get_config( 'config.'.str_replace( '-', '.', $menu_slug ), 'json', array( 'module_v2', 'theme-options', $parent_slug, $menu_slug, 'config' ) );
                    $option_config = array_shift( $option_config );

                    $option_config->option_name = str_replace('-', '_', $menu_slug);
                    $option_config->option_id   = $menu_slug;

                    if ( is_main_site() ) {
                        add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, function() use ( $callable, $theme_options, $option_config ) {
                            call_user_func_array( $callable, array( 'theme_options' => $theme_options, 'sub_theme_options' => $option_config ) );
                        } );
                    }

                } else if ( $parent_slug ) {

                    $option_config = dwh_get_config( 'config.'.str_replace( '-', '.', $menu_slug ), 'json', array( 'module_v2', 'theme-options', $parent_slug, $menu_slug, 'config' ) );
                    $option_config = array_shift( $option_config );

                    $option_config->option_name = str_replace('-', '_', $menu_slug);
                    $option_config->option_id   = $menu_slug;

                    add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, function() use ( $callable, $theme_options, $option_config ) {
                        call_user_func_array( $callable, array( 'theme_options' => $theme_options, 'sub_theme_options' => $option_config ) );
                    } );

                } else {

                    $option_config = dwh_get_config( 'config.'.str_replace( '-', '.', $menu_slug ), 'json', array( 'module_v2', 'theme-options', $menu_slug, 'config' ) );
                    $option_config = array_shift( $option_config );

                    if ( isset( $option_config->option_name ) ) {
                        $option_config->option_name = str_replace('-', '_', $menu_slug);
                        $option_config->option_id   = $menu_slug;
                    }

                    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, function() use ( $callable, $theme_options, $option_config ) {
                        call_user_func_array( $callable, array( 'theme_options' => $theme_options, 'sub_theme_options' => $option_config ) );
                    }, $icon, $position );
                }

                if ( $hide_submenu ) {
                    add_action( 'admin_menu', function() use ( $parent_slug, $menu_slug ){
                        if ( $parent_slug ) {
                            remove_submenu_page( $parent_slug, $menu_slug);
                        } else {
                            remove_submenu_page( $menu_slug, $menu_slug);
                        }
                    }, 999 );
                }
            }
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_add_theme_option_menu_ajax' ) )
{
    function dwh_wponetheme_add_theme_option_menu_ajax()
    {
        global $DWH_wponetheme_config;
        global $DWH_wponetheme_util;

        $theme_options_config = dwh_get_config( 'config.theme.options', 'json' );

        if ( $theme_options_config ) {

            foreach ( $theme_options_config as $theme_options ) {

                $menu_slug   = isset( $theme_options->menu_slug ) ? $theme_options->menu_slug : null;
                $parent_slug = ( $theme_options->option_type === 'sub-theme-option') ? str_replace( '_', '-', $theme_options->option_group ) : false;

                if ( $parent_slug ) {
                    $option_config = dwh_get_config( 'config.'.str_replace( '-', '.', $menu_slug ), 'json', array( 'module_v2', 'theme-options', $parent_slug, $menu_slug, 'config' ) );
                    $option_config = array_shift( $option_config );
                    $option_name   = isset( $option_config->option_name ) ? $option_config->option_name : str_replace( '-', '_', $menu_slug );
                    $option_id     = isset( $option_config->option_id ) ? $option_config->option_id : $menu_slug;

                    foreach ( $option_config->containers as $container ) {
                        dwh_do_fields_ajax( $container->fields, $option_name );
                    }
                }
            }
        }
    }
}

/* Theme Option Ajax */
if ( !function_exists( 'dwh_do_fields_ajax' ) )
{
    function dwh_do_fields_ajax( $config_fields, $action_name_prefix = '' )
    {
        $action_prefix = dwh_empty( $action_name_prefix ) ? $action_name_prefix.'_' : '';

        foreach( $config_fields as $field ) {

            $field_id = isset( $field->id ) ? $field->id : false;
            if ( $field_id ) {
                $action = $action_prefix.str_replace( '-', '_', $field_id ).'_action';

                add_action('wp_ajax_'.$action, function() {
                    global $DWH_wponetheme_util;

                    $ctr     = $_POST['ctr'];
                    $field   = (object)$_POST['field'];

                    $fields[$ctr]['id']             = $field->id.'-'.$ctr;
                    $fields[$ctr]['name']           = isset( $field->name ) ?  $field->name.'['.$ctr.']' : $field->id.'['.$ctr.']';
                    $fields[$ctr]['label']          = isset( $field->label ) ? $field->label : null;
                    $fields[$ctr]['altlabel']       = isset( $field->altlabel ) ? $field->altlabel : null;
                    $fields[$ctr]['class']          = isset( $field->class ) ? $field->class : null;
                    $fields[$ctr]['description']    = isset( $field->description ) ? $field->description : null;
                    $fields[$ctr]['default_value']  = isset( $field->default_value ) ? $field->default_value : null;
                    $fields[$ctr]['value']          = isset( $field->value ) ? $field->value : null;
                    $fields[$ctr]['rows']           = isset( $field->rows ) ? $field->rows : 5;
                    $fields[$ctr]['inputclass']     = isset( $field->inputclass ) ? $field->inputclass : null;
                    $fields[$ctr]['callback']       = isset( $field->callcback ) ? $field->callback : false;
                    $fields[$ctr]['type']           = isset( $field->type ) ? $field->type : false;
                    $fields[$ctr]['repeater']       = isset( $field->repeater ) ? $field->repeater : false;
                    $fields[$ctr]['accordion']      = isset( $field->accordion ) ? $field->accordion : false;
                    $fields[$ctr]['mediabutton']    = isset( $field->mediabutton ) ? $field->mediabutton : false;
                    $fields[$ctr]['itemlistclass']  = isset( $field->itemlistclass ) ? $field->itemlistclass : null;
                    $fields[$ctr]['removeitem']     = true;
                    $fields[$ctr]['resetitem']      = isset( $field->resetitem ) ? $field->resetitem : null;
                    $fields[$ctr]['attribute']      = isset( $field->attribute ) ? $field->attribute : null;
                    $fields[$ctr]['data']           = isset( $field->data ) ? $field->data : null;
                    $fields[$ctr]['options']        = isset( $field->options ) ? $field->options : null;
                    $fields[$ctr]                   = (object)$fields[$ctr];
                    $output                         = $DWH_wponetheme_util->get_field_type( array( 'field' => $fields[$ctr], 'value' => $field->value ) );

                    wp_send_json( $output );

                    die();
                } );
            }
        }
    }
}