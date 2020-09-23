<?php
if ( !function_exists( 'dwh_wponetheme_load_default_actions' ) )
{
    function dwh_wponetheme_load_default_actions()
    {
        /* add tracker */
        add_action( 'wp', 'dwh_wponetheme_ob_start' );
        /* redirect 404 to home page */
        add_action( 'wp', 'dwh_wponetheme_404_redirect' );
        /* unload contact form 7 scripts ans styles */
        add_action( 'wp', 'dwh_wponetheme_remove_contact_form_7_assets' );

        /* remove header links */
        add_action( 'init', 'dwh_wponetheme_remove_actions' );
        /* add theme support */
        add_action( 'init', 'dwh_wponetheme_add_theme_support');
        /*disable new relic*/
        add_action( 'init', 'dwh_wponetheme_disable_newrelic' );
        /* add custom image sizes */
        add_action( 'init', 'dwh_wponetheme_image_sizes' );
        /* set content width */
        add_action( 'init', 'dwh_wponetheme_content_width' );
        /* insert in hooks */
        add_action( 'init', 'dwh_wponetheme_insert_placeholder_in_hooks' );
        /* add google account */
        add_action( 'init', 'dwh_wponetheme_insert_google_account' );

        /* add Admin Menu */
        add_action( 'init', 'dwh_wponetheme_register_theme_options' );
        /* add custom fields */
        add_action( 'init', 'dwh_wponetheme_register_custom_fields' );
        /* register nav menu */
        add_action( 'init', 'dwh_wponetheme_register_menus' );
        /* register post types */
        add_action( 'init', 'dwh_wponetheme_register_post_types' );
        /* register taxononmies */
        add_action( 'init', 'dwh_wponetheme_register_taxonomies' );
        /* add media custom field */
        add_action( 'init', 'dwh_wponetheme_register_media_custom_field' );
        /* Load Content Hook Section*/
        add_action( 'init', 'dwh_wponetheme_load_hook_content' );
        /* add fonts */
        add_action( 'init', 'dwh_wponetheme_add_fonts' );

        /* add shortcodes */
        add_action( 'widgets_init', 'dwh_wponetheme_add_shortcodes' );
        /* register sidebar hooks */
        add_action( 'widgets_init', 'dwh_wponetheme_register_sidebars' );
        /* register Widgets */
        add_action( 'widgets_init', 'dwh_wponetheme_register_widgets' );
        /* unregister widgets */
        add_action( 'widgets_init', 'dwh_wponetheme_unregister_widgets' );

        /* add meta head */
        add_action( 'dwh_head', 'dwh_wponetheme_add_meta_head' );
        /* add meta tags */
        add_action( 'wp_head', 'dwh_wponetheme_add_meta_tags', 1 );
        /* localize detect mobile */
        add_action( 'wp_head', 'dwh_wponetheme_localize_detect_device' );
        /* add above the fold inline style */
        add_action( 'wp_head', 'dwh_wponetheme_add_above_the_fold_style', 2 );
        /* Load Body Hook Section */
		add_action( 'dwh_body_hook', 'dwh_wponetheme_facebook_root' );
        /* load ajax url */
        add_action( 'wp_footer', 'dwh_wponetheme_localize_ajax_url' );
        /* add edit link */
        add_action( 'wp_footer', 'dwh_wponetheme_edit_link' );
        /* add edit link */
        add_action( 'dwh_footer_hook', 'dwh_wponetheme_scroll_to_top' );

        /* upload font files */
        add_action( 'do_feed_sitemap', 'dwh_wponetheme_generate_sitemap', 10, 1 );

        /* load ajax url */
        add_action( 'admin_init', 'dwh_wponetheme_ajax_callback' );
        /* add editor style */
        add_action( 'admin_init', 'dwh_wponetheme_admin_editor_support' );
    }
}

if ( !function_exists( 'dwh_wponetheme_scroll_to_top' ) )
{
    function dwh_wponetheme_scroll_to_top()
    {
        if( dwh_get_theme_template() == 'v1' ) {

            dwh_scroll_to( array('caption' => 'Back To Top', 'type' => 'default' ) );

        }
    }
}

if ( !function_exists( 'dwh_wponetheme_edit_link' ) )
{
    function dwh_wponetheme_edit_link()
    {
        global $post;
        if ( current_user_can( 'manage_options' ) ) {
            if ( have_posts() ) {
                $postid = ( is_home() ) ? get_option( 'page_for_posts' ) : $post->ID;
                edit_post_link( 'Edit Page', '<span class="edit-link">', '</span>', $postid );
            } else {
                echo '<span class="edit-link"><a href="'.get_admin_url().'">'.__( 'Edit Theme', 'wponetheme' ).'</a></span>';
            }
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_add_above_the_fold_style' ) )
{
    function dwh_wponetheme_add_above_the_fold_style()
    {
        global $scss;

        if ( is_page_template('page-custom.php') ) {
            $inline_style = dwh_empty( dwh_get_data( 'above-the-fold-css' ) ) ? dwh_get_data( 'above-the-fold-css' ) : false;
        } else {
            $inline_style = dwh_empty( dwh_get_data( 'above-the-fold-css', 'onetheme_customizer_options' ) ) ? dwh_get_data( 'above-the-fold-css', 'onetheme_customizer_options' ) : false;
        }

        if ( $inline_style ) {

            try {

                $style = $scss->compile( $inline_style );
                $style = dwh_css_compresion( $style );
                echo '<style type="text/css">'."\n".$style."\n".'</style>'."\n";

            } catch ( Exception $e ) {

                echo '<!--'.$e->getMessage().'-->'."\n";

            }

        }
    }
}

if ( !function_exists( 'dwh_wponetheme_load_hook_content' ) )
{
    function dwh_wponetheme_load_hook_content()
    {
        add_action( 'dwh_header_hook', 'dwh_template_header' );
        add_action( 'dwh_footer_hook', 'dwh_template_footer' );
        add_action( 'dwh_content_hook', 'dwh_template_content' );
        add_action( 'dwh_content_header_hook', 'dwh_template_content_header' );
        add_action( 'dwh_content_footer_hook', 'dwh_template_content_footer' );
    }
}

if ( !function_exists( 'dwh_wponetheme_facebook_root' ) )
{
    function dwh_wponetheme_facebook_root()
    {
        /* add fb-root div*/
        echo '<div id="fb-root"></div>'."\n";
    }
}

if ( !function_exists( 'dwh_wponetheme_add_fonts' ) )
{
    function dwh_wponetheme_add_fonts()
    {
        /* add internal font style */
        add_action( 'wp_enqueue_scripts', function() {
            $internal_fonts = dwh_get_internal_fonts_style();
            dwh_enqueue_fontstyle( $internal_fonts, 'internal' );
        } );

        /* add external font style */
        add_action( 'wp_enqueue_scripts', function() {
            $external_fonts = dwh_get_external_fonts_style();
            dwh_enqueue_fontstyle( $external_fonts, 'external' );

        });

    }
}

if ( !function_exists( 'dwh_wponetheme_register_media_custom_field' ) )
{
    function dwh_wponetheme_register_media_custom_field()
    {
        add_filter( 'attachment_fields_to_edit', function( $form_fields, $post ) {

            $mediacustomfieldconfig = dwh_get_config( 'config.media.custom.fields', 'json' );

            if ( $mediacustomfieldconfig ) {

                foreach ( $mediacustomfieldconfig as $key => $mediacustomfield ) {
                    $field_value = get_post_meta( $post->ID, $mediacustomfield->field_name, true );
                    $field_type  = $mediacustomfield->input;

                    switch ( $field_type ) {
                        case 'date':
                            $form_fields[$mediacustomfield->field_name] = array(
                                "label" => __( $mediacustomfield->label, "wponetheme" ),
                                "input" => "html",
                                "html"  => "<input type=\"date\" name=\"attachments[".$post->ID."][".$mediacustomfield->field_name."]\" id=\"attachments-".$post->ID."-".$mediacustomfield->field_name."\" value=\"".$field_value."\">",
                                "helps" => __( $mediacustomfield->helps, "wponetheme")
                            );
                            break;

                        case 'select':
                            $optionlist = '';
                            foreach ( $mediacustomfield->value as $key => $value ) {
                                $selected    = ( $field_value === $value[0] ) ? ' selected' : null;
                                $optionlist .= "<option value=\"".$value[0]."\"".$selected.">".$value[1]."</option>";
                            }

                            $form_fields[$mediacustomfield->field_name] = array(
                                "label" => __( $mediacustomfield->label, "wponetheme" ),
                                "input" => "html",
                                "html"  => "<select class=\"col-full\" name=\"attachments[".$post->ID."][".$mediacustomfield->field_name."]\" id=\"attachments-".$post->ID."-".$mediacustomfield->field_name."\">".$optionlist."</select>",
                                "helps" => __( $mediacustomfield->helps, "wponetheme")
                            );

                            break;

                        default:
                            $form_fields[$mediacustomfield->field_name] = array(
                                "label" => __( $mediacustomfield->label, "wponetheme" ),
                                "input" => $mediacustomfield->input,
                                "value" => $field_value,
                                "helps" => __( $mediacustomfield->helps, "wponetheme")
                            );
                            break;
                    }

                }

                return $form_fields;

            }
        }, 10, 2 );

        add_action( 'edit_attachment', function ( $attachment_id ) {

            $mediacustomfieldconfig = dwh_get_config( 'config.media.custom.fields', 'json' );

            $custom_attachment = $_REQUEST['attachments'][$attachment_id];

            if ( $mediacustomfieldconfig ) {

                foreach ( $mediacustomfieldconfig as $mediacustomfield ) {
                    $field_value = isset( $custom_attachment[$mediacustomfield->field_name] ) ? $custom_attachment[$mediacustomfield->field_name] : null;
                    update_post_meta( $attachment_id, $mediacustomfield->field_name, $field_value );
                }
            }
        } );
    }
}

if ( !function_exists( 'dwh_wponetheme_register_taxonomies' ) )
{
    function dwh_wponetheme_register_taxonomies()
    {
        $config_taxonomies = dwh_get_config('config.taxonomies', 'json');

        foreach ( $config_taxonomies as $key => $taxonomy ) {

            $post_types                 = isset( $taxonomy->post_types ) ? $taxonomy->post_types : array("");

            $singular                   = isset( $taxonomy->singular ) ? ucwords( $taxonomy->singular ) : 'Genre';
            $suffix                     = ( substr( $singular, -1 ) === 's' ) ? 'es' : 's';
            $plural                     = isset( $taxonomy->plural ) ? ucwords( $taxonomy->plural ) : $singular.$suffix;
            $slug                       = strtolower( str_replace(' ', '-', $singular ) );
            $label                      = strtolower( str_replace(' ', '_', $singular ) );

            $search_items               = isset( $taxonomy->search_items ) ? $taxonomy->search_items : 'Search '.$plural;
            $all_items                  = isset( $taxonomy->all_items ) ? $taxonomy->all_items : 'All '.$plural;
            $parent_item                = isset( $taxonomy->parent_item ) ? $taxonomy->parent_item : 'Parent '.$singular;
            $parent_item_colon          = isset( $taxonomy->parent_item_colon ) ? $taxonomy->parent_item_colon : 'Parent '.$singular.':';
            $edit_item                  = isset( $taxonomy->edit_item ) ? $taxonomy->edit_item : 'Edit '.$singular;
            $update_item                = isset( $taxonomy->update_item ) ? $taxonomy->update_item : 'Update '.$singular;
            $add_new_item               = isset( $taxonomy->add_new_item ) ? $taxonomy->add_new_item : 'Add New '.$singular;
            $new_item_name              = isset( $taxonomy->new_item_name ) ? $taxonomy->new_item_name : 'New '.$singular.' Name';
            $menu_name                  = isset( $taxonomy->menu_name ) ? $taxonomy->menu_name : $plural;

            $hierarchical               = isset( $taxonomy->hierarchical ) ? $taxonomy->hierarchical : true;
            $show_ui                    = isset( $taxonomy->show_ui ) ? $taxonomy->show_ui : true;
            $show_admin_column          = isset( $taxonomy->show_admin_column ) ? $taxonomy->show_admin_column : true;
            $query_var                  = isset( $taxonomy->query_var ) ? $taxonomy->query_var : true;
            $rewrite                    = isset( $taxonomy->rewrite ) ? $taxonomy->rewrite : array( 'slug' => $slug );

            if( $hierarchical ) {
                $labels = array(
                    'name'                       => _x( $plural, 'taxonomy general name', 'wponetheme' ),
                    'singular_name'              => _x( $singular, 'taxonomy singular name', 'wponetheme' ),
                    'search_items'               => __( $search_items, 'wponetheme' ),
                    'all_items'                  => __( $all_items, 'wponetheme' ),
                    'parent_item'                => __( $parent_item, 'wponetheme' ),
                    'parent_item_colon'          => __( $parent_item_colon, 'wponetheme' ),
                    'edit_item'                  => __( $edit_item, 'wponetheme' ),
                    'update_item'                => __( $update_item, 'wponetheme' ),
                    'add_new_item'               => __( $add_new_item, 'wponetheme' ),
                    'new_item_name'              => __( $new_item_name, 'wponetheme' ),
                    'menu_name'                  => __( $menu_name, 'wponetheme' ),
                );

                $args = array(
                    'hierarchical'               => $hierarchical,
                    'labels'                     => $labels,
                    'show_ui'                    => $show_ui,
                    'show_admin_column'          => $show_admin_column,
                    'query_var'                  => $query_var,
                    'rewrite'                    => $rewrite,
                );
            } else {
                $popular_items              = isset( $taxonomy->popular_items ) ? $taxonomy->popular_items : 'Popular '.$plural;
                $separate_items_with_commas = isset( $taxonomy->separate_items_with_commas ) ? $taxonomy->separate_items_with_commas : 'Separate '.strtolower( $plural ).' with commas';
                $add_or_remove_items        = isset( $taxonomy->add_or_remove_items ) ? $taxonomy->add_or_remove_items : 'Add or remove '.strtolower( $plural );
                $choose_from_most_used      = isset( $taxonomy->choose_from_most_used ) ? $taxonomy->choose_from_most_used : 'Choose from the most used '.strtolower( $plural );
                $not_found                  = isset( $taxonomy->not_found ) ? $taxonomy->not_found : 'No '.strtolower( $plural ).' found.';

                $labels = array(

                    'name'                       => _x( $plural, 'taxonomy general name', 'wponetheme' ),
                    'singular_name'              => _x( $singular, 'taxonomy singular name', 'wponetheme' ),
                    'search_items'               => __( $search_items, 'wponetheme' ),
                    'all_items'                  => __( $all_items, 'wponetheme' ),
                    'popular_items'              => __( $popular_items, 'textdomain' ),
                    'parent_item'                => null,
                    'parent_item_colon'          => null,
                    'edit_item'                  => __( $edit_item, 'wponetheme' ),
                    'update_item'                => __( $update_item, 'wponetheme' ),
                    'add_new_item'               => __( $add_new_item, 'wponetheme' ),
                    'new_item_name'              => __( $new_item_name, 'wponetheme' ),
                    'separate_items_with_commas' => __( $separate_items_with_commas, 'textdomain' ),
                    'add_or_remove_items'        => __( $add_or_remove_items, 'textdomain' ),
                    'choose_from_most_used'      => __( $choose_from_most_used, 'textdomain' ),
                    'not_found'                  => __( $not_found, 'textdomain' ),
                    'menu_name'                  => __( $menu_name, 'wponetheme' ),
                );

                $args = array(
                    'hierarchical'               => $hierarchical,
                    'labels'                     => $labels,
                    'show_ui'                    => $show_ui,
                    'show_admin_column'          => $show_admin_column,
                    'update_count_callback'      => '_update_post_term_count',
                    'query_var'                  => $query_var,
                    'rewrite'                    => $rewrite,
                );
            }

            register_taxonomy( $slug, $post_types, $args );
        }

    }
}

if ( !function_exists( 'dwh_wponetheme_register_post_types' ) )
{
    function dwh_wponetheme_register_post_types()
    {
        $config_post_types = dwh_get_config('config.post.types', 'json');

        foreach ( $config_post_types as $key => $post_type ) {

            $singular                   = isset( $post_type->singular ) ? ucwords( $post_type->singular ) : 'Item';
            $suffix                     = ( substr( $singular, -1 ) === 's' ) ? 'es' : 's';
            $plural                     = isset( $post_type->plural ) ? ucwords( $post_type->plural ) : $singular.$suffix;
            $slug                       = strtolower( str_replace(' ', '-', $singular ) );
            $label                      = strtolower( str_replace(' ', '_', $singular ) );

            $menu_name                  = isset( $post_type->menu_name ) ? $post_type->menu_name : $plural;
            $name_admin_bar             = isset( $post_type->name_admin_bar ) ? $post_type->name_admin_bar : $singular;
            $add_new                    = isset( $post_type->add_new ) ? $post_type->add_new : 'Add New';
            $add_new_item               = isset( $post_type->add_new_item ) ? $post_type->add_new_item : 'Add New '.$singular;
            $new_item                   = isset( $post_type->new_item ) ? $post_type->new_item : 'New '.$singular;
            $edit_item                  = isset( $post_type->edit_item ) ? $post_type->edit_item : 'Edit '.$singular;
            $view_item                  = isset( $post_type->view_item ) ? $post_type->view_item : 'View '.$singular;
            $all_items                  = isset( $post_type->all_items ) ? $post_type->all_items : 'All '.$plural;
            $search_items               = isset( $post_type->search_items ) ? $post_type->search_items : 'Search '.$plural;
            $parent_item_colon          = isset( $post_type->parent_item_colon ) ? $post_type->parent_item_colon : 'Parent '.$plural.':';
            $not_found                  = isset( $post_type->not_found ) ? $post_type->not_found : 'No '.strtolower( $plural ).' found';
            $not_found_in_trash         = isset( $post_type->not_found_in_trash ) ? $post_type->not_found_in_trash : 'No '.strtolower( $plural ).' found in Trash';
            $featured_image             = isset( $post_type->featured_image ) ? $post_type->featured_image : $singular.' Featured Image';
            $set_featured_image         = isset( $post_type->set_featured_image ) ? $post_type->set_featured_image : 'Set featured image';
            $remove_featured_image      = isset( $post_type->remove_featured_image ) ? $post_type->remove_featured_image : 'Remove featured image';
            $use_featured_image         = isset( $post_type->use_featured_image ) ? $post_type->use_featured_image : 'Use as featured image';
            $archives                   = isset( $post_type->archives ) ? $post_type->archives : $singular.' archives';
            $insert_into_item           = isset( $post_type->insert_into_item ) ? $post_type->insert_into_item : 'Insert into '.strtolower( $singular );
            $uploaded_to_this_item      = isset( $post_type->uploaded_to_this_item ) ? $post_type->uploaded_to_this_item : 'Uploaded to this '.strtolower( $singular );
            $filter_items_list          = isset( $post_type->filter_items_list ) ? $post_type->filter_items_list : 'Filter '.strtolower( $plural ).'list';
            $items_list_navigation      = isset( $post_type->items_list_navigation ) ? $post_type->items_list_navigation : $plural.' list navigation';
            $items_list                 = isset( $post_type->items_list ) ? $post_type->items_list : $plural.' list';
            $taxonomies                 = isset( $post_type->taxonomies ) ? $post_type->taxonomies : array('');
            $description                = isset( $post_type->description ) ? $post_type->description : $plural.' Post Type';
            $public                     = isset( $post_type->public ) ? $post_type->public : true;
            $publicly_queryable         = isset( $post_type->publicly_queryable ) ? $post_type->publicly_queryable : true;
            $show_ui                    = isset( $post_type->show_ui ) ? $post_type->show_ui : true;
            $show_in_menu               = isset( $post_type->show_in_menu ) ? $post_type->show_in_menu : true;
            $show_in_nav_menus          = isset( $post_type->show_in_nav_menus ) ? $post_type->show_in_nav_menus : true;
            $show_in_admin_bar          = isset( $post_type->show_in_admin_bar ) ? $post_type->show_in_admin_bar : true;
            $query_var                  = isset( $post_type->query_var ) ? $post_type->query_var : true;
            $capability_type            = isset( $post_type->capability_type ) ? $post_type->capability_type : 'post';
            $has_archive                = isset( $post_type->has_archive ) ? $post_type->has_archive : true;
            $hierarchical               = isset( $post_type->hierarchical ) ? $post_type->hierarchical : false;
            $menu_position              = isset( $post_type->menu_position ) ? $post_type->menu_position : 5;
            $can_export                 = isset( $post_type->can_export ) ? $post_type->can_export  : true;
            $exclude_from_search        = isset( $post_type->exclude_from_search ) ? $post_type->exclude_from_search : false;
            $menu_icon                  = isset( $post_type->menu_icon ) ? $post_type->menu_icon : 'dashicons-admin-post';
            $rewrite                    = isset( $post_type->rewrite ) ? $post_type->rewrite : array( 'slug' => $slug );
            $supports                   = isset( $post_type->supports ) ? $post_type->supports : array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' );

            $labels = array(
                'name'                  => _x( $plural, 'Post type general name', 'wponetheme' ),
                'singular_name'         => _x( $singular, 'Post type singular name', 'wponetheme' ),
                'menu_name'             => _x( $menu_name, 'Admin Menu text', 'wponetheme' ),
                'name_admin_bar'        => _x( $name_admin_bar, 'Add New on Toolbar', 'wponetheme' ),
                'add_new'               => __( $add_new, 'wponetheme' ),
                'add_new_item'          => __( $add_new_item, 'wponetheme' ),
                'new_item'              => __( $new_item, 'wponetheme' ),
                'edit_item'             => __( $edit_item, 'wponetheme' ),
                'view_item'             => __( $view_item, 'wponetheme' ),
                'all_items'             => __( $all_items, 'wponetheme' ),
                'search_items'          => __( $search_items, 'wponetheme' ),
                'parent_item_colon'     => __( $parent_item_colon, 'wponetheme' ),
                'not_found'             => __( $not_found, 'wponetheme' ),
                'not_found_in_trash'    => __( $not_found_in_trash, 'wponetheme' ),
                'featured_image'        => _x( $featured_image, 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'wponetheme' ),
                'set_featured_image'    => _x( $set_featured_image, 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'wponetheme' ),
                'remove_featured_image' => _x( $remove_featured_image, 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'wponetheme' ),
                'use_featured_image'    => _x( $use_featured_image, 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'wponetheme' ),
                'archives'              => _x( $archives, 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'wponetheme' ),
                'insert_into_item'      => _x( $insert_into_item, 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'wponetheme' ),
                'uploaded_to_this_item' => _x( $uploaded_to_this_item, 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'wponetheme' ),
                'filter_items_list'     => _x( $filter_items_list, 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'wponetheme' ),
                'items_list_navigation' => _x( $items_list_navigation, 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'wponetheme' ),
                'items_list'            => _x( $items_list, 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'wponetheme' ),
            );

            $args = array(
                'label'                 => __( $label, 'wponetheme' ),
                'labels'                => $labels,
                'description'           => __( $description, 'wponetheme' ),
                'public'                => $public,
                'publicly_queryable'    => $publicly_queryable,
                'show_ui'               => $show_ui,
                'show_in_menu'          => $show_in_menu,
                'show_in_nav_menus'     => $show_in_nav_menus,
                'show_in_admin_bar'     => $show_in_admin_bar,
                'query_var'             => $query_var,
                'capability_type'       => $capability_type,
                'has_archive'           => $has_archive,
                'hierarchical'          => $hierarchical,
                'menu_position'         => $menu_position,
                'can_export'            => $can_export,
                'exclude_from_search'   => $exclude_from_search,
                'menu_icon'             => $menu_icon,
                'rewrite'               => $rewrite,
                'supports'              => $supports,
                'taxonomies'            => $taxonomies,
            );

            register_post_type( $slug, $args );
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_ob_start' ) )
{
    function dwh_wponetheme_ob_start()
    {
        ob_start( 'dwh_modify_html' );
    }
}

if ( !function_exists( 'dwh_wponetheme_insert_google_account' ) )
{
    function dwh_wponetheme_insert_google_account()
    {
        add_action( 'wp_head', function() {

            global $DWH_wponetheme_google_translate;

            $google_tag_manager_controller = dwh_empty( dwh_get_data( 'google-tag-manager-controller', 'onetheme_site_options' ) ) ? dwh_get_data( 'google-tag-manager-controller', 'onetheme_site_options' ) : false;
            $universal_analytics_id_1 = dwh_empty( dwh_get_data( 'google-universal-analytics', 'onetheme_site_options' ) ) ? dwh_get_data( 'google-universal-analytics', 'onetheme_site_options' ) : false;
            $universal_analytics_id_2 = dwh_empty( dwh_get_data( 'google-universal-analytics-2', 'onetheme_site_options' ) ) ? dwh_get_data( 'google-universal-analytics-2', 'onetheme_site_options' ) : false;
            $legacy_analytics_id_1 = dwh_empty( dwh_get_data( 'google-legacy-analytics', 'onetheme_site_options' ) ) ? dwh_get_data( 'google-legacy-analytics', 'onetheme_site_options' ) : false;
            $legacy_analytics_id_2 = dwh_empty( dwh_get_data( 'google-legacy-analytics-2', 'onetheme_site_options' ) ) ? dwh_get_data( 'google-legacy-analytics-2', 'onetheme_site_options' ) : false;
            $site_url = str_replace( array( 'http://', 'https://' ) , '', $_SERVER['HTTP_HOST'] );

            $output  ='';

            if ( !$google_tag_manager_controller ) {

                $ga_code = ( $universal_analytics_id_1 ) ? $universal_analytics_id_1 : $legacy_analytics_id_1;
                $DWH_wponetheme_google_translate->util_object = array( 'gacode' => $ga_code );
                wp_localize_script( 'global', 'ga_code', array( 'gaid' => $ga_code ) );

                // $output .= '<script type="text/javascript">'."\n";
                // $output .= '/* <![CDATA[ */'."\n";
                // $output .= 'var ga_code = {"gaid":"'.$ga_code.'"};'."\n";
                // $output .= '/* ]]> */'."\n";
                // $output .= '</script>'."\n";

                if ( $universal_analytics_id_1 ) {

                    $output .= '<!-- Universal Analytics Code -->'."\n";
                    $output .= '<script>'."\n";
                    $output .= '(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
                    $output .= '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
                    $output .= 'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
                    $output .= '})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');'."\n";
                    $output .= 'ga(\'create\', \''.$universal_analytics_id_1.'\', \'auto\');'."\n";
                    $output .= ( $universal_analytics_id_2 ) ? 'ga(\'create\', \''.$universal_analytics_id_2.'\', \'auto\', \'hoteltracker\');'."\n" : null;
                    $output .= 'ga(\'send\', \'pageview\');'."\n";
                    $output .= ( $universal_analytics_id_2 ) ? 'ga(\'hoteltracker.send\', \'pageview\')'."\n" : null;
                    $output .= '</script>'."\n";
                    $output .= '<!-- End Universal Analytics Code -->'."\n";

                } else if ( $legacy_analytics_id_1 ) {

                    $output .= '<!-- Google Analytics -->'."\n";
                    $output .= '<script>'."\n";
                    $output .= 'var _gaq = _gaq || [];'."\n";
                    $output .= '_gaq.push([\'_setAccount\', \''.$legacy_analytics_id_1.'\']);'."\n";
                    $output .= '_gaq.push([\'_setDomainName\', \''.$site_url.'\']);'."\n";
                    $output .= '_gaq.push([\'_setAllowLinker\', true]);'."\n";
                    $output .= '_gaq.push([\'_trackPageview\']);'."\n";
                    $output .= ( $legacy_analytics_id_2 ) ? '_gaq.push([\'b._setAccount\', \''.$legacy_analytics_id_2.'\'], [\'b._trackPageview\']);'."\n" : null;
                    $output .= '(function() {'."\n";
                    $output .= 'var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;'."\n";
                    $output .= 'ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';'."\n";
                    $output .= 'var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);'."\n";
                    $output .= '})();'."\n";
                    $output .= '</script>'."\n";
                    $output .= '<!-- End Google Analytics -->'."\n";

                }

                echo $output;
            } else {
                wp_localize_script( 'global', 'ga_code', array( 'gaid' => false ) );
            }

        }, 99 );

        add_action( 'dwh_body_hook', function() {

            $google_tag_manager_controller = dwh_empty( dwh_get_data( 'google-tag-manager-controller', 'onetheme_site_options' ) ) ? dwh_get_data( 'google-tag-manager-controller', 'onetheme_site_options' ) : false;
            $google_tag_manager_id         = dwh_get_data( 'google-tag-manager', 'onetheme_site_options' );
            $output  = '';

            if ( dwh_empty( $google_tag_manager_id ) && $google_tag_manager_controller ) {
                $output .= '<!-- Google Tag Manager -->'."\n";
                $output .= '<noscript><iframe src="//www.googletagmanager.com/ns.html?id='.$google_tag_manager_id.'"'."\n";
                $output .= 'height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>'."\n";
                $output .= '<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':'."\n";
                $output .= 'new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],'."\n";
                $output .= 'j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src='."\n";
                $output .= '\'//www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);'."\n";
                $output .= '})(window,document,\'script\',\'dataLayer\',\''.$google_tag_manager_id.'\');</script>'."\n";
                $output .= '<!-- End Google Tag Manager -->'."\n";
            }

            echo $output;

        } );

        add_action( 'wp_footer', function() {

            $google_conversion_id = dwh_get_data( 'google-remarketing', 'onetheme_site_options' );
            $output  = '';

            if ( dwh_empty( $google_conversion_id ) ) {

                $output .= '<!-- Google Code for Remarketing Tag -->'."\n";
                $output .= '<script type="text/javascript">'."\n";
                $output .= '    /* <![CDATA[ */'."\n";
                $output .= '    var google_conversion_id = '.$google_conversion_id.';'."\n";
                $output .= '    var google_custom_params = window.google_tag_params;'."\n";
                $output .= '    var google_remarketing_only = true;'."\n";
                $output .= '    /* ]]> */'."\n";
                $output .= '</script>'."\n";
                $output .= '<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>'."\n";
                $output .= '<noscript>'."\n";
                $output .= '<div style="display:inline;">'."\n";
                $output .= '<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/'.$google_conversion_id.'/?value=0&amp;guid=ON&amp;script=0"/>'."\n";
                $output .= '</div>'."\n";
                $output .= '</noscript>'."\n";
                $output .= '<!-- Google Code for Remarketing Tag -->'."\n";
            }

            echo $output;

        }, 99 );
    }
}

if ( !function_exists( 'dwh_wponetheme_insert_placeholder_in_hooks' ) )
{
    function dwh_wponetheme_insert_placeholder_in_hooks()
    {

        $code_snippets = dwh_empty( dwh_get_data( 'code-snippet', 'onetheme_site_options' ) ) ? dwh_get_data( 'code-snippet', 'onetheme_site_options' ) : null;

        if ( $code_snippets ) {
            foreach( $code_snippets as $snippet ) {
                switch( $snippet['location'] ) {
                    case 'head':
                        add_action( 'wp_head', function() use ( $snippet ){
                            $postids = isset( $snippet['postids' ] ) ? $snippet['postids' ] : null;
                            echo ( dwh_show_snippet( $postids ) ) ? $snippet['content']."\n" : null;
                        }, 99 );
                        break;
                    case 'body':
                        add_action( 'dwh_body_hook', function() use ( $snippet ){
                            $postids = isset( $snippet['postids' ] ) ? $snippet['postids' ] : null;
                            echo ( dwh_show_snippet( $postids ) ) ? $snippet['content']."\n" : null;
                        }, 99 );
                        break;
                    case 'footer':
                        add_action( 'wp_footer', function() use ( $snippet ){
                            $postids = isset( $snippet['postids' ] ) ? $snippet['postids' ] : null;
                            echo ( dwh_show_snippet( $postids ) ) ? $snippet['content']."\n" : null;
                        }, 99 );
                        break;
                }
            }
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_content_width' ) )
{
    function dwh_wponetheme_content_width()
    {
        if ( ! isset( $content_width ) )
        $content_width = 960;
    }
}

if ( !function_exists( 'dwh_wponetheme_image_sizes' ) )
{
    function dwh_wponetheme_image_sizes()
    {
        $config_image_sizes = dwh_get_config( 'config.image.sizes', 'json' );

        if ( $config_image_sizes ) {
            foreach( $config_image_sizes as $image_size ) {
                if ( is_array( $image_size ) ) {
                    $image_size = (object) $image_size;
                }

                $label      = isset( $image_size->label ) ? $image_size->label : false;
                $width      = isset( $image_size->width ) ? $image_size->width : 0;
                $height     = isset( $image_size->height ) ? $image_size->height : 0;
                $crop       = isset( $image_size->crop ) ? $image_size->crop : false;

                if ( $label ) {
                    add_image_size( $label, $width, $height, $crop );
                }
            }
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_generate_sitemap' ) )
{
    function dwh_wponetheme_generate_sitemap()
    {
        $sitemapcontroller = dwh_empty( dwh_get_data( 'sitemaps-controller', 'onetheme_site_options' ) ) ? dwh_get_data( 'sitemaps-controller', 'onetheme_site_options' ) : false;
        $sitemapcontent    = dwh_empty( dwh_get_data( 'sitemaps', 'onetheme_site_options' ) ) ? dwh_get_data( 'sitemaps', 'onetheme_site_options' ) : false;

        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );

        echo '<?xml version="1.0" encoding="'.get_option( 'blog_charset' ).'"?'.'>'."\n";
        echo '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        if ( $sitemapcontent && $sitemapcontroller ) {

            echo $sitemapcontent;

        } else {

            query_posts( array( 'post_type' => array( 'page' ), 'post_status' => 'publish', 'orderby' => 'date', 'posts_per_page' => -1, 'order' => 'ASC' ) );

            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    echo '  <url>'."\n";
                    echo '      <loc>'.get_the_permalink().'</loc>'."\n";
                    echo '      <lastmod>'.mysql2date( 'Y-m-d\TH:i:s+00:00', get_post_modified_time('Y-m-d H:i:s', true), false ).'</lastmod>'."\n";
                    echo '      <changefreq>weekly</changefreq>'."\n";
                    echo '      <priority>0.6</priority>'."\n";
                    echo '  </url>'."\n";
                }
            }
        }

        echo '</urlset>'."\n";
    }
}

if ( !function_exists( 'dwh_wponetheme_add_meta_tags' ) )
{
    function dwh_wponetheme_add_meta_tags()
    {
        global $wpdb;
        $blogid = get_current_blog_id();
        $prefix = $wpdb->base_prefix;

        $description        = dwh_empty( dwh_get_data( 'meta_description' ) ) ? dwh_get_data( 'meta_description' ) : get_bloginfo( 'description' );
        $mapdomain          = $wpdb->get_row( 'SELECT domain FROM '.$prefix.'_domain_mapping WHERE blog_id = '.$blogid );
        $url                = dwh_empty( $mapdomain ) ? $mapdomain : str_replace( array( 'http://', 'https://' ), '', site_url() );

        $hoteltype          = dwh_get_data( 'type', 'onetheme_hotel_options' );
        $hoteloption        = dwh_get_data( 'hotel-single', 'onetheme_hotel_options' );
        $hotelname          = ( $hoteltype === 'single' ) ? $hoteloption['hotel_name'] : get_bloginfo( 'name' );

        $globaltitle        = dwh_empty( dwh_get_data( 'meta-title', 'onetheme_site_options' ) ) ? dwh_get_data( 'meta-title', 'onetheme_site_options' ) : get_bloginfo( 'name' );
        $globaldescription  = dwh_empty( dwh_get_data( 'meta-description', 'onetheme_site_options' ) ) ? dwh_get_data( 'meta-description', 'onetheme_site_options' ) : get_bloginfo( 'description' );
        $globalkeywords     = dwh_empty( dwh_get_data( 'meta-keyword', 'onetheme_site_options' ) ) ? dwh_get_data( 'meta-keyword', 'onetheme_site_options' ) : '';

        $metakeywords       = dwh_empty( dwh_get_data( 'meta_keywords' ) ) ? dwh_get_data( 'meta_keywords' ) : $globalkeywords;
        $metadescrption     = dwh_empty( dwh_get_data( 'meta_description' ) ) ? dwh_get_data( 'meta_description' ) : $globaldescription;
        $webmaster_tool     = dwh_empty( dwh_get_data( 'google-webmaster-tool', 'onetheme_site_options' ) ) ? dwh_get_data( 'google-webmaster-tool', 'onetheme_site_options' ) : false;

        $faviconid          = dwh_empty( dwh_get_data( 'favicon', 'onetheme_customizer_options' ) ) ? dwh_get_data( 'favicon', 'onetheme_customizer_options' ) : false;
        $favicionurlthumb   = wp_get_attachment_image_src( $faviconid, 'small-thumbnail-image' , true );
        $favicionurlmedium  = wp_get_attachment_image_src( $faviconid, 'large-thumbnail-image' , true );

        $output  = '';

        $output .= "\t".'<meta name="keywords" content="'.$metakeywords.'">'."\n";
        $output .= "\t".'<meta name="description" content="'.$metadescrption.'">'."\n";

        $output .= "\t".'<meta property="og:title" content="'.$hotelname.'" />'."\n";
        $output .= "\t".'<meta property="og:type" content="hotel" />'."\n";
        $output .= "\t".'<meta property="og:description" content="'.$description.'" />'."\n";
        $output .= "\t".'<meta property="og:url" content="'.$url.'" />'."\n";
        $output .= "\t".'<meta property="og:site_name" content="'.$hotelname.'" />'."\n";
        $output .= "\t".'<meta property="fb:admins" content="1076987014" />'."\n";

        $output .= ( $webmaster_tool ) ? "\t".$webmaster_tool."\n" : null;

        $output .= "\t".'<link rel="profile" href="http://gmpg.org/xfn/11" />'."\n";
        $output .= "\t".'<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'."\n";

        if ( $faviconid ) {
        $output .= "\t".'<link rel="icon" href="'.$favicionurlthumb[0].'" sizes="32x32" />'."\n";
        $output .= "\t".'<link rel="icon" href="'.$favicionurlmedium[0].'" sizes="192x192" />'."\n";
        $output .= "\t".'<link rel="apple-touch-icon-precomposed" href="'.$favicionurlthumb[0].'" />'."\n";
        $output .= "\t".'<meta name="msapplication-TileImage" content="'.$favicionurlthumb[0].'" />'."\n";
        }

        echo $output;
    }
}

if ( !function_exists( 'dwh_wponetheme_add_meta_head' ) )
{
    function dwh_wponetheme_add_meta_head()
    {

        $output  = '<meta charset="UTF-8" />'."\n";
        $output .= "\t".'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">'."\n";
        $output .= "\t".'<meta name="HandheldFriendly" content="True">'."\n";
        $output .= "\t".'<meta name="MobileOptimized" content="320">'."\n";
        $output .= "\t".'<meta name="viewport" content="width=device-width, initial-scale=1.0">'."\n";

        echo $output;
    }
}

if ( !function_exists( 'dwh_wponetheme_register_menus' ) )
{
    function dwh_wponetheme_register_menus() {

        $locations = array(
            'primary' => __('Primary Menu', 'wponetheme' ),
            'secondary' => __('Secondary Menu', 'wponetheme')
        );

        register_nav_menus( $locations );
    }
}

if ( !function_exists( 'dwh_wponetheme_unregister_widgets' ) )
{
    function dwh_wponetheme_unregister_widgets()
    {
        $wpwidgetsconfig = dwh_get_config( 'config.wp.widgets', 'json' );
        foreach ( $wpwidgetsconfig as $wpwidget ) {
            $unregister = isset( $wpwidget->unregister ) ? $wpwidget->unregister : false;
            if ( $unregister ) {
                unregister_widget( $wpwidget->id );
            } else {
                register_widget( $wpwidget->id );
            }
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_register_sidebars' ) )
{
    function dwh_wponetheme_register_sidebars()
    {
        $config_sidebars = dwh_get_config( 'config.widget.sidebars', 'json' );

        if ( $config_sidebars ) {
            foreach( $config_sidebars as $sidebar ){
                if ( is_array( $sidebar ) ) {
                    $sidebar = (object) $sidebar;
                }

                $id             = isset( $sidebar->id ) ? $sidebar->id : null;
                $name           = isset( $sidebar->name ) ? $sidebar->name : null;
                $description    = isset( $sidebar->description ) ? $sidebar->description : '';
                $before_widget  = '<div id="%1$s" class="widget %2$s">';
                $after_widget   = '</div>';
                $before_title   = '<h2 class="widgettitle">';
                $after_title    = '</h2>';

                register_sidebar( array(
                    'id'            => $id,
                    'name'          => $name,
                    'description'   => $description,
                    'before_widget' => $before_widget,
                    'after_widget'  => $after_widget,
                    'before_title'  => $before_title,
                    'after_title'   => $after_title
                ) );
            }
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_register_theme_options' ) )
{
    function dwh_wponetheme_register_theme_options()
    {
        add_action( 'admin_menu', 'dwh_wponetheme_add_theme_option_menu' );
        add_action( 'admin_init', 'dwh_wponetheme_add_theme_option_menu_ajax' );
    }
}

if ( !function_exists( 'dwh_wponetheme_register_custom_fields' ) )
{
    function dwh_wponetheme_register_custom_fields()
    {
        global $DWH_wponetheme_util;
        $customfieldconfig = dwh_get_config( 'config.custom.fields', 'json' );

        /* call add metabox for custom content shortcode */
        dwh_wponetheme_add_page_custom_content_box( array( 'page' ) );

        /* add custom field */
        add_action( 'add_meta_boxes', function() use ( $DWH_wponetheme_util, $customfieldconfig ) {
            dwh_wponetheme_add_custom_box( $customfieldconfig );
        } );

        /* save custom field */
        add_action( 'save_post', function( $post_id ) use ( $DWH_wponetheme_util, $customfieldconfig ) {
            dwh_wponetheme_save_custom_box( $post_id, $customfieldconfig );
        } );

        dwh_wponetheme_do_custom_box_ajax( $customfieldconfig );
    }
}

if ( !function_exists( 'dwh_wponetheme_add_shortcodes' ) )
{
    function dwh_wponetheme_add_shortcodes()
    {
        $shortcodes = dwh_get_config( 'config.shortcodes', 'json' );

        if ( $shortcodes ) {
            foreach ( $shortcodes as $shortcode ) {
                $shortcode_id = isset( $shortcode->id ) ? $shortcode->id : false;

                if ( $shortcode_id ) {

                    $shortcode_function = isset( $shortcode->function ) ? $shortcode->function : str_replace( '-', '_', $shortcode->function);
                    $shortcode_name     = isset( $shortcode->name ) ? $shortcode->name : str_replace( array( '-', '_shortcode' ), array( '_', ''), $shortcode_id );
                    $shortcode_file     = dwh_get_main_directory().'/module_v2/shortcodes/'.$shortcode_id.'/'.$shortcode_id.'.php';

                    if ( file_exists( $shortcode_file ) ) {
                        include( $shortcode_file );
                        add_shortcode( $shortcode_name, $shortcode_function );
                    }
                }
            }
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_register_widgets' ) )
{
    function dwh_wponetheme_register_widgets()
    {
        global $DWH_wponetheme_config;
        $widgets = $DWH_wponetheme_config->get_directory_list( dwh_get_main_directory().'/module_v2/widgets/' );

        if ( $widgets ) {
            foreach ( $widgets as $widget ) {
                $widget_name = str_replace( '-', '_', strtolower( $widget ) );
                $widget_file = dwh_get_main_directory().'/module_v2/widgets/'.$widget.'/'.$widget.'.php';
                if ( file_exists( $widget_file ) ) {
                    include( $widget_file );
                    $classes = get_declared_classes();

                    foreach ( $classes as $class ) {
                        if ( $widget_name === strtolower( $class ) ) {
                            register_widget( $widget_name );
                        }
                    }

                }
            }
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_localize_detect_device' ) )
{
    function dwh_wponetheme_localize_detect_device()
    {
        $mobile_objects = array( 'detect' => dwh_detect_device() );
        wp_localize_script( 'global', 'device', $mobile_objects );
    }
}

if ( !function_exists( 'dwh_wponetheme_ajax_callback' ) )
{
    function dwh_wponetheme_ajax_callback()
    {

        $ajaxconfig = dwh_get_config( 'config.ajax', 'json' );
        $nonce = array();
        if ( $ajaxconfig ) {

            foreach ( $ajaxconfig as $key => $ajax ) {


                $file = dwh_get_main_directory().'/module_v2/ajax-callback/'.$ajax->action.'.php';
                $ajaxvar    = str_replace('-', '_', $ajax->action);
                if ( isset( $ajax->action ) ) {

                    $file    = dwh_get_main_directory().'/module_v2/ajax-callback/'.$ajax->action.'.php';
                    $nopriv  = isset( $ajax->nopriv ) ? $ajax->nopriv : false;
                    $ajaxvar = str_replace('-', '_', $ajax->action);

                    $nonce[$ajaxvar]['action']      = $ajax->action;
                    $nonce[$ajaxvar]['security']    = wp_create_nonce( $ajax->action );
                    $nonce[$ajaxvar]['data']        = isset( $ajax->data ) ? $ajax->data : null;

                    if ( file_exists( $file ) ) {

                        if ( $nopriv ) {
							//echo 'test wp ajax no private ---- > '.$ajax->action;

                            add_action( 'wp_ajax_'.$ajax->action, function() use( $file ){
                                include( $file );
                            });

                            add_action( 'wp_ajax_nopriv_'.$ajax->action, function() use( $file ){
                                include( $file );
                            });

                        } else {

                            add_action( 'wp_ajax_'.$ajax->action, function() use( $file ){
                                include( $file );
                            });

                        }

                    }
                }
            }

            add_action( 'admin_footer', function() use ( $nonce ){
                wp_localize_script( 'dwh-ajax', 'dwh_ajax_obj', $nonce );
            });
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_localize_ajax_url' ) )
{
    function dwh_wponetheme_localize_ajax_url()
    {
        wp_localize_script( 'global', 'DwhAjax', array( 'ajaxurl' => admin_url('admin-ajax.php'), 'security' => wp_create_nonce('dwhajaxnoncestring') ) );
    }
}

if ( !function_exists( 'dwh_wponetheme_remove_actions' ) )
{
    function dwh_wponetheme_remove_actions()
    {
        remove_action( 'wp_head', 'feed_links_extra', 3 );
        remove_action( 'wp_head', 'feed_links', 2 );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'index_rel_link' );
        remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
        remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
        // remove_action( 'wp_head', 'rel_canonical' );
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_head', 'rest_output_link_wp_head' );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
        remove_action( 'wp_head', 'wp_oembed_add_host_js' );

        remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
    }
}

if ( !function_exists( 'dwh_wponetheme_add_theme_support' ) )
{
    function dwh_wponetheme_add_theme_support()
    {
        /* add post type support */
        add_post_type_support( 'page', 'excerpt' );

        /* add theme support */
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'customize-selective-refresh-widgets' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
        add_theme_support( 'title-tag' );
        add_theme_support( 'custom-logo' );
        add_theme_support( 'custom-header' );
        // add_theme_support( 'custom-logo', array( 'height' => 100, 'width' => 400, 'flex-width' => true ) );
        // add_theme_support( 'post-formats', array( 'aside', 'gallery', 'qoute' ) );
        // add_theme_support( 'custom-header-uploads' );
        // add_theme_support( 'custom-background' );
    }
}

if ( !function_exists( 'dwh_wponetheme_404_redirect' ) )
{
    function dwh_wponetheme_404_redirect()
    {
        if ( is_404() ) {
            header("Refresh: 3; url='".home_url()."'");
        }
    }
}

if ( ! function_exists('dwh_wponetheme_disable_newrelic') )
{
    function dwh_wponetheme_disable_newrelic()
    {
        if ( extension_loaded( 'newrelic' ) ) {
            newrelic_disable_autorum( true );
        }
    }
}

if ( !function_exists('dwh_wponetheme_admin_editor_support') )
{
    function dwh_wponetheme_admin_editor_support()
    {
        add_theme_support( 'editor_style' );
        add_editor_style( get_template_directory_uri() .'/module/admin/css/bootstrap.min.css' );
        add_editor_style( get_template_directory_uri() . '/module/admin/css/editor-style.css' );
    }
}

if ( !function_exists('dwh_wponetheme_remove_contact_form_7_assets') )
{
    function dwh_wponetheme_remove_contact_form_7_assets()
    {
        global $post;
        if ( is_a( $post, 'WP_Post' ) && !has_shortcode( $post->post_content, 'contact-form-7' ) ) {
            dwh_remove_js_css_cf7();
        }
    }
}

/****************************************************************/
/****************************************************************/
/****************************************************************/

