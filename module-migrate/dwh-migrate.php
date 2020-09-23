<?php
/*=========================================================*/
/* ADD ACTION
/*=========================================================*/
add_action( 'after_switch_theme', 'dwh_wponetheme_load_default_theme_module' );

add_action( 'admin_init', 'dwh_wponetheme_register_migrate_settings' );
add_action( 'admin_menu', 'dwh_wponetheme_register_migrate_options_page' );
add_action( 'admin_enqueue_scripts', 'dwh_wponetheme_migrate_admin_style' );
add_action( 'admin_footer', 'dwh_wponetheme_migrate_admin_script' );
add_action( 'wp_ajax_dwh_wponetheme_delete_migrate_option', 'dwh_wponetheme_delete_migrate_option' );

/*=========================================================*/
/* THEME SWITCH
/*=========================================================*/
function dwh_wponetheme_load_default_theme_module()
{
    $option = get_option( 'onetheme_migrate_options' );

    if ( $option !== false ) {

        if ( $option['delete_migrate_options'] == '1' ) {
            dwh_delete_options();
            wp_redirect( admin_url('admin.php?page=dwh-settings') );
        } else {
            wp_redirect( admin_url('admin.php?page=onetheme-hotel-options') );
        }

    } else {

        dwh_update_is_migrated();
        wp_redirect( admin_url('admin.php?page=onetheme-hotel-options') );

    }


}

/*=========================================================*/
/* REGISTER OPTION PAGE
/*=========================================================*/

function dwh_wponetheme_migrate_admin_style()
{
    $screen = get_current_screen();
    if ( $screen->base === 'settings_page_migrate-settings' ) {
        wp_register_style( 'migration_settings_style', get_template_directory_uri() . '/module-migrate/css/style.css', false, '1.0.0' );
        wp_enqueue_style( 'migration_settings_style' );
    }
}

function dwh_wponetheme_migrate_admin_script()
{
    $screen = get_current_screen();
    if ( $screen->base === 'settings_page_migrate-settings' ) {
    ?>
    <script type="text/javascript">
    jQuery('.dwh-default-checkbox').click( function(){
        _this = jQuery(this);
        if ( _this.is(':checked') ) {
            _this.prev().val('1');
            _this.attr('checked', true );
        } else {
            _this.prev().val('0');
            _this.attr('checked', false );
        }
    });

    jQuery( document ).on( 'click', '.delete_migrate_options', function(){

        jQuery.ajax({
                 url : ajaxurl,
                 type : 'post',
                 data : {
                            action: 'dwh_wponetheme_delete_migrate_option'
                        },
                 success: function( response ) {
                    // console.log( response );
                    alert('DWH MIGRATE OPTIONS DELETED')
                    window.location.replace( response );

                 },
                 fail: function( e ){
                    console.log('error');
                 }

            });
    });

    </script>
    <?php }
}

function dwh_wponetheme_delete_migrate_option()
{

    dwh_delete_options();

    echo admin_url('options-general.php?page=migrate-settings');

    wp_die();
}

function dwh_wponetheme_register_migrate_settings()
{
    register_setting( 'dwh_wponetheme_option_group', 'onetheme_migrate_options' );
}

function dwh_wponetheme_register_migrate_options_page()
{
    add_options_page( 'Migration Settings', 'Migrate Options', 'manage_options', 'migrate-settings', 'dwh_wponetheme_migrate_option_page' );

    if ( is_migrated() && !is_migrated( 'is_migrated' ) ) {
        add_action( 'updated_option', 'dwh_wponetheme_migrate' );
        dwh_update_is_migrated();
    }
}

function dwh_wponetheme_migrate_option_page()
{
?>
    <div class="wrap" id="dwh-migrate-option">
        <h2>Migrate Theme Options</h2>
        <form method="post" action="options.php">
        <?php
            settings_fields( 'dwh_wponetheme_option_group' );
            $value = get_option( 'onetheme_migrate_options' );

            if ( !$value ) {
                $value = array(
                                'is_migrated'            => '0',
                                'migrate_to_v2'          => '0',
                                'delete_migrate_options' => '0'
                              );
            }

            extract( $value );

            $is_checked_migrate_to_v2 = ( $migrate_to_v2 === '1' ) ? ' checked' : null;
            $is_checked_delete_migrated = ( $delete_migrate_options === '1' ) ? ' checked' : null;
        ?>

            <div class="field-option hide">
                <input type="hidden" id="onetheme_is_migrated" name="onetheme_migrate_options[is_migrated]" value="<?php echo $is_migrated; ?>" />
            </div>

            <div class="field-option hide">
                <p class="field-title">Delete Migrate Options on Theme Switch</p>
                <input type="hidden" id="onetheme_delete_migrate_options" name="onetheme_migrate_options[delete_migrate_options]" value="<?php echo $delete_migrate_options; ?>" />
                <input type="checkbox" id="onetheme_delete_is_migrated_cb" class="dwh-default-checkbox" <?php echo $is_checked_delete_migrated; ?>/>
                <label for="onetheme_delete_is_migrated_cb" class="option_migrate_setting_label">Set</label>
            </div>

            <div class="clearfix">
                <div class="field-option">
                    <p class="field-title">Migrate Onetheme To Version 2</p>
                    <input type="hidden" id="onetheme_migrate_to_v2" name="onetheme_migrate_options[migrate_to_v2]" value="<?php echo $migrate_to_v2; ?>" />
                    <input type="checkbox" id="onetheme_migrate_to_v2_cb" class="dwh-default-checkbox" <?php echo $is_checked_migrate_to_v2; ?>/>
                    <label for="onetheme_migrate_to_v2_cb" class="option_migrate_setting_label">Set</label>
                </div>

                <div class="field-option">
                    <p class="field-title">Delete Migrate Options</p>
                    <a class="button button-delete delete_migrate_options">DELETE</a>
                </div>
            </div>

            <?php  submit_button(); ?>
        </form>
    </div>
<?php
}

/*=========================================================*/
/* LOAD FUNCTIONS
/*=========================================================*/

function is_migrated( $key = 'migrate_to_v2' ) {
    $option = get_option( 'onetheme_migrate_options' );
    $is_migrated = ( $option[$key] === '1' ) ? true : false;

    return $is_migrated;
}

function dwh_update_is_migrated( $is_migrated = '1', $migrate_to_v2 = '1', $delete_migrate_options = '0' )
{
    $option = get_option( 'onetheme_migrate_options' );
    $new_value = array(
                'is_migrated'            => '1',
                'migrate_to_v2'          => '1',
                'delete_migrate_options' => '0'
            );

    update_option( 'onetheme_migrate_options', $new_value );
}

function dwh_delete_options()
{
    global $blog_id;

    delete_option('onetheme_migrate_options', $blog_id);
    delete_option('onetheme_customizer_options', $blog_id);
    delete_option('onetheme_site_options', $blog_id);
    delete_option('onetheme_hotel_options', $blog_id);
    // delete_option('onetheme_fonts_migrated', $blog_id);

}