<?php
global $DWH_wponetheme_util;

$main_options   = $viewData['main_options'];
$sub_options    = $viewData['sub_options'];

$get_options    = get_option( $sub_options->option_name );
$containers     = $sub_options->containers;
$option_value   = array();

if ( $containers ) {

    echo '<div class="tab-title-container">';
    foreach ( $containers as $container_key => $container ) {
        $id             = isset( $container->id ) ? $container->id : false;
        $container_id   = isset( $container->id ) ? $container->id : $sub_options->option_id.'-container-'.$container_key;
        $title          = isset( $container->title ) ? $container->title : 'Tab '.$container_id;
        $display        = isset( $container->display ) ? $container->display : true;
        $isactive       = ( $container_key == 0 ) ? ' active' : null;
        if ( $id && $display ) {
            echo '<a href="#'.$id.'" class="title'.$isactive.'">'.$title.'</a>';
        }
    }
    echo '</div>';

    echo '<div class="tab-content-container">';
    foreach ( $containers as $container_key => $container ) {
        $id             = isset( $container->id ) ? $container->id : false;
        $container_id   = isset( $container->id ) ? $container->id : $sub_options->option_id.'-container-'.$container_key;
        $title          = isset( $container->title ) ? $container->title : null;
        $description    = isset( $container->description ) ? $container->description : null;
        $defaultclass   = isset( $container->box ) && $container->box ? 'box-container bordered-box-container theme-option-box-container tab-content' : 'box-container theme-option-box-container tab-content';
        $class          = isset( $container->class ) ? $defaultclass.' '.$container->class : $defaultclass;
        $isactive       = ( $container_key == 0 ) ? ' active' : null;

        if ( $id ) {
            echo '<div id="'.$id.'" class="'.$class.$isactive.'">';
            echo '  <div class="container-content">';
            if ( $description )
            echo '      <div class="description">'.$description.'</div>';

            foreach ( $container->fields as $key => $field ) {

                if ( $field->type && $field->id ) {
                    $action[$container_id][$key]                       = $sub_options->option_name.'_'.str_replace( '-', '_', $field->id ).'_action';
                    $current_value[$container_id][$key]                = dwh_empty( get_option( $sub_options->option_name ) ) ? get_option( $sub_options->option_name ) : null;
                    $option_value[$field->id]                          = isset( $current_value[$container_id][$key][$field->id] ) ? $current_value[$container_id][$key][$field->id] : null;

                    $new_field[$container_id][$key]['id']              = $sub_options->option_id.'-'.$field->id;
                    $new_field[$container_id][$key]['name']            = $sub_options->option_name.'['.$field->id.']';

                    $new_field[$container_id][$key]['field_id']        = isset( $field->id ) ? $field->id : null;
                    $new_field[$container_id][$key]['label']           = isset( $field->label ) ? $field->label : null;
                    $new_field[$container_id][$key]['altlabel']        = isset( $field->altlabel ) ? $field->altlabel : null;
                    $new_field[$container_id][$key]['class']           = isset( $field->class ) ? $field->class : null;
                    $new_field[$container_id][$key]['description']     = isset( $field->description ) ? $field->description : null;
                    $new_field[$container_id][$key]['default_value']   = isset( $field->default_value ) ? $field->default_value : null;
                    $new_field[$container_id][$key]['value']           = isset( $field->value ) ? $field->value : null;
                    $new_field[$container_id][$key]['rows']            = isset( $field->rows ) ? $field->rows : null;
                    $new_field[$container_id][$key]['inputclass']      = isset( $field->inputclass ) ? $field->inputclass : null;
                    $new_field[$container_id][$key]['callback']        = isset( $field->callback ) ? $field->callback : null;
                    $new_field[$container_id][$key]['type']            = isset( $field->type ) ? $field->type : null;
                    $new_field[$container_id][$key]['repeater']        = isset( $field->repeater ) ? $field->repeater : null;
                    $new_field[$container_id][$key]['accordion']       = isset( $field->accordion ) ? $field->accordion : null;
                    $new_field[$container_id][$key]['mediabutton']     = isset( $field->mediabutton ) ? $field->mediabutton : null;
                    $new_field[$container_id][$key]['itemlistclass']   = isset( $field->itemlistclass ) ? $field->itemlistclass : null;
                    $new_field[$container_id][$key]['removeitem']      = isset( $field->removeitem ) ? $field->removeitem : false;
                    $new_field[$container_id][$key]['resetitem']       = isset( $field->resetitem ) ? $field->resetitem : false;
                    $new_field[$container_id][$key]['attribute']       = isset( $field->attribute ) ? $field->attribute : null;
                    $new_field[$container_id][$key]['data']            = isset( $field->data ) ? $field->data : null;
                    $new_field[$container_id][$key]['options']         = isset( $field->options ) ? $field->options : null;

                    $new_field[$container_id][$key]                    = (object)$new_field[$container_id][$key];

                    $repeater                                          = isset( $field->repeater ) && ( $field->type != 'wp-textarea' ) ? $field->repeater : false;
                    $itemlistclass                                     = isset( $field->itemlistclass ) ? ' '.$field->itemlistclass : null;

                    if( $repeater ) {

                        $fullwidth = ( $option_value[$field->id] === null ) ? ' full-width' : null;
                        echo '<div id="'.$sub_options->option_id.'-'.$field->id.'" class="container-content-item list-item-container'.$itemlistclass.'">';
                        echo '  <input type="hidden" name="form-action" value="'.$action[$container_id][$key].'">';
                        echo '  <input type="hidden" name="field" value=\''.json_encode( $new_field[$container_id][$key] ).'\'>';
                        echo '  <a class="add-item button-add button">Add '.$field->label.'</a>';
                        echo '  <img src="'.admin_url("/images/wpspin_light.gif").'" class="item-loading" style="display:none;" >';
                        echo '  <div class="clear"></div>';
                        echo '  <div class="item-lists'.$fullwidth.'">';
                        echo $DWH_wponetheme_util->get_field_list( $option_value[$field->id], $new_field[$container_id][$key] );
                        echo '  </div>';
                        echo '  <div class="item-display"></div>';
                        echo '</div>';
                    } else {
                        echo $DWH_wponetheme_util->get_field_type( array( 'field' => $new_field[$container_id][$key], 'value' => $option_value[$field->id] ) );
                    }
                }
            }
            echo '  </div>';
            echo '</div>';
        }
    }
    echo '</div>';

    if ( !$get_options ) {
        update_option( $sub_options->option_name, $option_value );
    }
}