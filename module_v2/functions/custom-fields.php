<?php
/* add custom content for dynamic shortcode */
if ( !function_exists( 'dwh_wponetheme_add_page_custom_content_box' ) )
{
    function dwh_wponetheme_add_page_custom_content_box( $screens )
    {

        add_action('add_meta_boxes', function() use( $screens ){

            /* loop through each post type */
            foreach( $screens as $screen ){

                add_meta_box('custom_content_section_id', 'Custom Content Field', function() use( $screen ) {

                    global $post;

                    if ( has_shortcode( $post->post_content, 'get_custom_content' ) ) {

                        echo '<div class="box">';

                            $pattern = get_shortcode_regex();
                            if ( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) ) {

                                foreach( $matches[2] as $key => $match ){

                                    if( $match === 'get_custom_content' ){

                                        $ccfields = explode(' ', $matches[3][$key] );

                                        foreach( $ccfields as $ccfield ){
                                            $ccf = explode('=', $ccfield);

                                            if( $ccf[0] === 'key' ){

                                                if( $ccf[0] === 'key' ){

                                                    $ccfkey = str_replace( array("\"", "\'", "&quot;"), "", $ccf[1]);
                                                    $ccfvalue = get_post_meta( $post->ID, $ccfkey, true);

                                                    echo '  <div class="control-wrapper" style="margin-bottom:1em;">';
                                                    echo '      <label for="'. $ccfkey .'">key: '. $ccfkey .'</label>';
                                                    echo '      <textarea id="'. $ccfkey .'" name="'. $ccfkey .'" style="width:100%" rows="5">'. esc_html($ccfvalue) .'</textarea>';
                                                    echo '  </div>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                        echo '</div>';
                    }

                    else {
                        echo '<div class="box">';
                        echo '<p>Add Shortcode to Content: <i>avoid using same key</i></p>';
                        echo '<p class="medium"><strong>[get_custom_content key="<span style="color:red">$variable</span>"]</strong></p>';
                        echo '</div>';
                    }

                }, $screen );

            }

        });
    }
}

if ( !function_exists( 'dwh_wponetheme_custom_box' ) )
{
    /**
     * description: add fields for custom field box
     * use: class.util to load input types
     *
     **/
    function dwh_wponetheme_custom_box( $post, $callback_args )
    {
        global $DWH_wponetheme_util;

        $custom_fields = $callback_args['args'][0];

        wp_nonce_field( $callback_args["id"], $callback_args["id"].'_nonce' );

        if ( $custom_fields ) {

            $containers = $custom_fields->containers;

            if ( $containers ) {
                foreach ( $containers as $container_key => $container ) {
                    $id             = isset( $container->id ) ? $container->id : false;
                    $title          = isset( $container->title ) ? $container->title : null;
                    $description    = isset( $container->description ) ? $container->description : null;
                    $defaultclass   = isset( $container->box ) && $container->box ? 'box-container bordered-box-container custom-fields-box-container' : 'box-container custom-fields-box-container';
                    $class          = isset( $container->class ) ? $defaultclass.' '.$container->class : $defaultclass;

                    if ( $id ) {
                        echo '<div id="'.$id.'" class="'.$class.'">';

                        if ( $title ) {
                        echo '    <div class="container-header">';
                        echo '        <h3 class="title">'.$title.'</h3>';
                        if ( $description )
                        echo '        <p class="description">'.$description.'</p>';
                        echo '    </div>';
                        }

                        echo '    <div class="container-content">';

                        foreach ( $container->fields as $key => $field ) {

                            if ( $field->id && $field->type ) {

                                $post_id                = isset( $post->ID ) ? $post->ID : null;
                                $single                 = isset( $field->single ) ? $field->single : true;

                                $field_id               = isset( $field->id ) ? $field->id : null;
                                $field_name             = isset( $field->name ) ? $field->name : $field->id;
                                $field_label            = isset( $field->label ) ? $field->label : null;
                                $field_altlabel         = isset( $field->altlabel ) ? $field->altlabel : null;
                                $field_class            = isset( $field->class ) ? $field->class : null;
                                $field_description      = isset( $field->description ) ? $field->description : null;
                                $default_value          = isset( $field->default ) ? $field->default : null;
                                $field_value            = isset( $field->value ) ? $field->value : null;
                                $field_rows             = isset( $field->rows ) ? $field->rows : null;
                                $field_inputclass       = isset( $field->inputclass ) ? $field->inputclass : null;
                                $field_callback         = isset( $field->callback ) ? $field->callback : null;
                                $field_type             = isset( $field->type ) ? $field->type : null;
                                $field_repeater         = isset( $field->repeater ) ? $field->repeater : null;
                                $field_accordion        = isset( $field->accordion ) ? $field->accordion : null;
                                $field_mediabutton      = isset( $field->mediabutton ) ? $field->mediabutton : null;
                                $field_itemlistclass    = isset( $field->itemlistclass ) ? $field->itemlistclass : null;
                                $field_removeitem       = isset( $field->removeitem ) ? $field->removeitem : false;
                                $field_resetitem        = isset( $field->resetitem ) ? $field->resetitem : false;
                                $field_attribute        = isset( $field->attribute ) ? $field->attribute : null;
                                $field_data             = isset( $field->data ) ? $field->data : null;
                                $field_options          = isset( $field->options ) ? $field->options : null;

                                $repeater               = isset( $field->repeater ) && ( $field->type != 'wp-textarea' ) ? $field->repeater : false;
                                $itemlistclass          = isset( $field->itemlistclass ) ? ' '.$field_itemlistclass : null;

                                $action                 = str_replace( '-', '_', $field_id ).'_action';
                                $current_value          = dwh_empty( get_post_meta( $post_id, $field_name, $single ) ) ? get_post_meta( $post_id, $field_name, $single ) : null;

                                /*register post meta*/
                                add_post_meta( $post_id, $field_name, $current_value, $single );

                                if( $repeater ) {

                                    echo '<div id="'.$field_id.'" class="container-content-item list-item-container list-item-container-simple'.$field_itemlistclass.'">';
                                    echo '    <input type="hidden" name="form-action" value="'.$action.'">';
                                    echo '    <input type="hidden" name="field" value=\''.json_encode( $field ).'\'>';
                                    echo '    <div class="item-lists item-lists-simple">';
                                    echo $DWH_wponetheme_util->get_field_list( $current_value, $field );
                                    echo '    </div>';
                                    echo '    <a class="add-item-simple button-add button">Add '.$field_label.'</a>';
                                    echo '    <img src="'.admin_url("/images/wpspin_light.gif").'" class="item-loading" style="display:none;" >';
                                    echo '</div>';

                                } else {

                                    echo $DWH_wponetheme_util->get_field_type( array( 'field' => $field, 'value' => $current_value ) );
                                }
                            }
                        }

                        echo '    </div>';
                        echo '</div>';
                    }
                }
            }
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_add_custom_box' ) )
{

    /**
    * Description: add metabox to specific page, post and page template
    * Use: config.custom.fields.json
    *
    **/
    function dwh_wponetheme_add_custom_box( $config_custom_fields )
    {
        global $post;

        if ( $config_custom_fields ) {
            foreach ( $config_custom_fields as $key => $custom_fields ) {

                $id             = isset( $custom_fields->id ) ? $custom_fields->id : '';
                $title          = isset( $custom_fields->title ) ? $custom_fields->title : '';
                $callback       = isset( $custom_fields->callback ) ? $custom_fields->callback : 'dwh_wponetheme_custom_box';
                $screens        = isset( $custom_fields->screens ) ? $custom_fields->screens : get_post_types();
                $context        = isset( $custom_fields->context ) ? $custom_fields->context : 'advanced';
                $priority       = isset( $custom_fields->priority ) ? $custom_fields->priority : 'default';
                $callback_args  = isset( $custom_fields->callback_args ) ? $custom_fields->callback_args : null;
                $templates      = isset( $custom_fields->templates ) ? $custom_fields->templates : array('all');

                foreach ( $templates as $template ) {
                    $page_template_file     = ( $post ) ? get_post_meta( $post->ID, '_wp_page_template', TRUE ) : false;
                    $page_templates         = get_page_templates();
                    $page_for_posts_id      = get_option( 'page_for_posts' );
                    $page_for_front_id      = get_option( 'page_on_front' );

                    switch ( $template ) {
                        case 'all':
                            foreach ( $screens as $screen ) {
                                add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
                            }
                            break;
                        case 'is_front_page':
                            if ( $page_for_front_id == $post->ID ) {
                                add_meta_box( $id, $title, $callback, array('page'), $context, $priority, $callback_args );
                            }
                            break;
                        case 'is_blog':
                            if ( $page_for_posts_id == $post->ID ) {
                                add_meta_box( $id, $title, $callback, array('page'), $context, $priority, $callback_args );
                            }
                            break;
                        case 'is_page':
                            add_meta_box( $id, $title, $callback, array('page'), $context, $priority, $callback_args );
                            break;
                        case 'is_default_page':
                            if ( $page_for_front_id !== $post->ID && $page_for_posts_id !== $post->ID && !in_array( $page_template_file, $page_templates ) ) {
                                add_meta_box( $id, $title, $callback, array('page'), $context, $priority, $callback_args );
                            }
                            break;
                        case 'is_single':
                            foreach ( $screens as $screen ) {
                                add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
                            }
                            break;
                        default:
                            if ( $template.'.php' === strtolower( $page_template_file ) ) {
                                foreach( $screens as $screen ) {
                                    add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
                                }
                            }
                            break;
                    }
                }
            }
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_save_custom_box' ) )
{
    /**
     * Description: save post meta data
     * scan json file then load config file to selected screen
     *
     **/
    function dwh_wponetheme_save_custom_box( $post_id, $config_custom_fields )
    {
        $dwh_meta_box_fields     = array();
        $dwh_meta_box_ids        = array();

        if ( $config_custom_fields ) {

            foreach ( $config_custom_fields as $custom_fields ) {

                $custom_fields_id    = isset( $custom_fields->id ) ? $custom_fields->id : false;
                $callback_args       = isset( $custom_fields->callback_args ) ? $custom_fields->callback_args : null;

                if ( isset( $_POST[$custom_fields_id.'_nonce'] ) ) {
                    $dwh_meta_box_ids[]    =  $custom_fields_id;

                    foreach ( $callback_args[0]->containers as $key => $container ) {

                        foreach ( $container->fields as $ctr => $field ) {

                            $field_id        = isset( $field->id ) ? $field->id : null;
                            $field_default   = isset( $field->default ) ? $field->default : null;
                            $field_value     = isset( $_POST[$field_id] ) ? $_POST[$field_id] : $field_default;

                            $dwh_meta_box_fields[$custom_fields_id][$key][$ctr]['field_id']        = $field_id;
                            $dwh_meta_box_fields[$custom_fields_id][$key][$ctr]['field_value']     = $field_value;
                        }
                    }
                }
            }
        }


        foreach( $dwh_meta_box_ids as $key => $dwh_meta_box_id ) {

            if ( ! isset( $_POST[$dwh_meta_box_id.'_nonce'] ) )
            return $post_id;

            $nonce = $_POST[$dwh_meta_box_id.'_nonce'];

            if ( ! wp_verify_nonce( $nonce, $dwh_meta_box_id ) )
                return $post_id;

            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
                return $post_id;

            if ( 'page' == $_POST['post_type'] ) {
                if ( ! current_user_can( 'edit_page', $post_id ) )
                    return $post_id;
            } else {
                if ( ! current_user_can( 'edit_post', $post_id ) )
                    return $post_id;
            }

            foreach( $dwh_meta_box_fields as $field_container ) {
                foreach( $field_container as $fields ) {
                    foreach( $fields as $field_item ) {
                        update_post_meta( $post_id, $field_item['field_id'], $field_item['field_value'] );
                    }
                }
            }
        }

        /* check post_content with custom content shortcode */
        if ( isset( $_POST['post_content'] ) ) {
            if ( has_shortcode( $_POST['post_content'], 'get_custom_content' ) ) {

                $pattern = get_shortcode_regex();

                if ( preg_match_all( '/'. $pattern .'/s', $_POST['post_content'], $matches ) ) {

                    foreach( $matches[2] as $key => $match ){

                        if( $match === 'get_custom_content' ){

                            $ccfields = explode('key=\"', trim($matches[3][$key]) );

                            $ccfkey = explode( '\"', $ccfields[1] );

                            /* create meta key using shortcode tag param key */
                            update_post_meta( $post_id, $ccfkey[0], $_POST[$ccfkey[0]] );

                        }
                    }
                }
            }
        }

    }
}

if ( !function_exists( 'dwh_wponetheme_do_custom_box_ajax' ) )
{
    function dwh_wponetheme_do_custom_box_ajax( $config_custom_fields )
    {
        $dwh_meta_box_fields = array();

        if ( $config_custom_fields ) {
            foreach ( $config_custom_fields as $custom_fields_key => $custom_fields_value ) {

                $callback_args = isset( $custom_fields_value->callback_args ) ? $custom_fields_value->callback_args : array();

                foreach ( $callback_args[0]->containers as $container ) {

                    foreach ( $container->fields as $ctr => $field ) {
                        $is_repeater = isset( $field->repeater ) ? $field->repeater : false;
                        if ( $is_repeater )
                        $dwh_meta_box_fields[$custom_fields_key][$ctr]['field_id'] = $field->id;
                    }
                }

            }
        }

        foreach ( $dwh_meta_box_fields as $meta_box_field ) {
            foreach ( $meta_box_field as $field ) {
                $action = str_replace( '-', '_', $field['field_id'] ).'_action';

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
                    $fields[$ctr]['rows']           = isset( $field->rows ) ? $field->rows : null;
                    $fields[$ctr]['inputclass']     = isset( $field->inputclass ) ? $field->inputclass : null;
                    $fields[$ctr]['callback']       = isset( $field->callcback ) ? $field->callback : null;
                    $fields[$ctr]['type']           = isset( $field->type ) ? $field->type : null;
                    $fields[$ctr]['repeater']       = isset( $field->repeater ) ? $field->repeater : null;
                    $fields[$ctr]['accordion']      = isset( $field->accordion ) ? $field->accordion : null;
                    $fields[$ctr]['mediabutton']    = isset( $field->mediabutton ) ? $field->mediabutton : null;
                    $fields[$ctr]['itemlistclass']  = isset( $field->itemlistclass ) ? $field->itemlistclass : null;
                    $fields[$ctr]['removeitem']     = true;
                    $fields[$ctr]['resetitem']      = isset( $field->resetitem ) ? $field->resetitem : false;
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


/**
 * SAMPLE CALLBACK FOR CUSTOM FUNCTIONS FOR CUSTOM FIELDS
 * CAN BE PLACED INSIDE FUNCTIONS.PHP
 **/
if ( !function_exists( 'dwh_wponetheme_custom_box_for_custom_post_meta_with_same_id' ) )
{
    /**
     * description: add fields for custom field box
     * use: class.util to load input types
     *
     **/
    function dwh_wponetheme_custom_box_for_custom_post_meta_with_same_id( $post, $callback_args )
    {
        global $DWH_wponetheme_util;
        $custom_fields = $callback_args['args'][0];

        wp_nonce_field( $callback_args["id"], $callback_args["id"].'_nonce' );

        if ( $custom_fields ) {

            $containers = $custom_fields->containers;

            if ( $containers ) {
                foreach ( $containers as $container ) {
                    $id             = isset( $container->id ) ? $container->id : false;
                    $title          = isset( $container->title ) ? $container->title : '';
                    $description    = isset( $container->description ) ? $container->description : '';
                    $repeater       = isset( $container->repeater ) ? $container->repeater : false;
                    $defaultclass   = ( $repeater ) ? 'box-container' : 'box-container-no-border';
                    $class          = isset( $container->class ) ? $defaultclass.' '.$container->class : $defaultclass;

                    if ( $id ) {
                        echo '<div id="'.$id.'" class="'.$class.'">';
                        echo '    <div class="container-header">';
                        echo '        <h3 class="title">'.$title.'</h3>';
                        echo '        <p class="description">'.$description.'</p>';
                        echo '    </div>';
                        echo '    <div class="container-content">';

                        foreach ( $container->fields as $key => $field ) {
                            $post_id            = isset( $post->ID ) ? $post->ID : null;
                            $single             = isset( $field->single ) ? $field->single : true;

                            $field_callback     = ( isset( $field->callback ) ) ? $field->callback : false;
                            $field_id           = ( isset( $field->id ) ) ? $field->id : false;
                            $field_name         = ( isset( $field->name ) ) ? $field->name : $field->id;
                            $field_type         = ( isset( $field->type ) ) ? $field->type : null;
                            $field_label        = ( isset( $field->label ) ) ? $field->label : null;
                            $field_description  = ( isset( $field->description ) ) ? $field->description : null;
                            $field_class        = ( isset( $field->class ) ) ? $field->class : 'col-full';
                            $field_rows         = ( isset( $field->rows ) ) ? $field->rows : 5;
                            $field_duplicate    = ( isset( $field->duplicate ) ) ? $field->duplicate : array();
                            $field_value        = get_post_meta( $post_id, $field_id, $single );

                            if ( !$single ) {
                                echo '<a href="#?">Add New</a>';

                                foreach( $field_duplicate as $key => $field_item ) {

                                    $field_repeater = array();
                                    $field_repeater['id']               = $field_id.'-'.$key;
                                    $field_repeater['name']             = $field_id.'['.$key.']';
                                    $field_repeater['label']            = $field_label;
                                    $field_repeater['type']             = $field_type;
                                    $field_repeater['class']            = $field_class;
                                    $field_repeater['description']      = $field_description;
                                    $field_repeater['value']            = isset( $field_value[$key] ) ? $field_value[$key] : $field_item->value ;

                                    $field_repeater                     = (object)$field_repeater;

                                    if( !isset($field_value[$key]) ) {
                                        add_post_meta( $post_id, $field_id, $field_repeater->value, $single );
                                    }
                                    echo $DWH_wponetheme_util->get_field_type( array( 'field' => $field_repeater, 'value' => $field_repeater->value ) );
                                }

                            } else {

                                $single_field_value = dwh_empty( $field_value ) ? $field_value : $field->value;
                                add_post_meta( $post_id, $field_id, $single_field_value, $single );
                                echo $DWH_wponetheme_util->get_field_type( array( 'field' => $field, 'value' => $single_field_value ) );
                            }


                        }

                        echo '    </div>';
                        echo '</div>';
                    }
                }
            }
        }
    }
}

if ( !function_exists( 'dwh_wponetheme_sample_callback_select_function' ) )
{
    /**
     * description: custom function for config.custom.fields.json
     * from: config.custom.fields.json - callbackargs->field->value
     *
     **/
    function dwh_wponetheme_sample_callback_select_function()
    {
        $page_templates = get_page_templates();
        $option         = '';
        foreach ( $page_templates as $template ) {
            $option .= '<option value="'.$template.'">'.$template.'</option>';
        }

        return $option;
    }
}

if ( !function_exists( 'dwh_wponetheme_sample_callback_function' ) )
{
    /**
     * description: callback for custom field type
     * from: config.custom.fields.json - callbackargs->field->callback
     * To crate custom field type use $id for attribute name to save data <label>$label</label><input type="text" name="$id" value"$value">
     *
     **/
    function dwh_wponetheme_sample_callback_function( $args )
    {
        return "id: ".$args["id"]."<br>"."label: ".$args["label"];
    }

}
