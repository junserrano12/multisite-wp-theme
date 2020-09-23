<?php
if ( !class_exists( 'dwh_scroll_widget' ) )
{
    class dwh_scroll_widget extends WP_Widget
    {
        public $containers;

        public function __construct()
        {
            $config                 = dwh_get_config( 'config.widget', 'json', array( 'module_v2', 'widgets', basename(__DIR__), 'config' ) );

            $widget_id              = isset( $config->id ) ? $config->id : false;
            $widget_name            = isset( $config->name ) ? $config->name : "";
            $widget_description     = isset( $config->description ) ? $config->description : "";
            $widget_height          = isset( $config->height ) ? $config->height : 200;
            $widget_width           = isset( $config->width ) ? $config->width : 250;

            $widget_options         = array( 'description' => __( $widget_description, 'wponetheme' ) );
            $control_options        = array( 'height' => $widget_height, 'width' => $widget_width );

            parent::__construct( $widget_id, $widget_name, $widget_options, $control_options );
        }

        public function widget( $args, $instance )
        {
            array_push( $instance, array('type' => 'bounce' ) );

            dwh_scroll_to( $instance );
        }

        public function form( $instance )
        {
            global $DWH_wponetheme_util;
            $config = dwh_get_config( 'config.widget.fields', 'json', array( 'module_v2', 'widgets', basename( __DIR__ ) , 'config' ) );

            if( $config ) {
                foreach ( $config as $container ) {
                    $id             = isset( $container->id ) ? $container->id : false;
                    $title          = isset( $container->title ) ? $container->title : null;
                    $description    = isset( $container->description ) ? $container->description : null;
                    $defaultclass   = isset( $container->box ) ? 'box-container bordered-box-container widget-fields-box-container' : 'box-container widget-fields-box-container';
                    $class          = isset( $container->class ) ? $defaultclass.' '.$container->class : $defaultclass;

                    if ( $id ) {
                        echo '<div id="'.$id.'" class="'.$class.'">';

                        if ( dwh_empty( $title ) ) {
                        echo '  <div class="container-header">';
                        echo '      <h3 class="title">'.$title.'</h3>';
                        echo '      <p class="description">'.$description.'</p>';
                        echo '  </div>';
                        }
                        echo '  <div class="container-content">';

                        foreach ( $container->fields as $field ) {

                            if ( $field->id && $field->type ) {

                                $new_field  = array(
                                                "id"              => isset( $field->id ) ? $this->get_field_id( $field->id ) : null,
                                                "name"            => isset( $field->id ) ? $this->get_field_name( $field->id ) : null,
                                                "label"           => isset( $field->label ) ? $field->label : null,
                                                "altlabel"        => isset( $field->altlabel ) ? $field->altlabel : null,
                                                "class"           => isset( $field->class ) ? $field->class : null,
                                                "description"     => isset( $field->description ) ? $field->description : null,
                                                "default_value"   => isset( $field->default_value ) ? $field->default_value : null,
                                                "value"           => isset( $instance[$field->id] ) ? $instance[$field->id] : null,
                                                "rows"            => isset( $field->rows ) ? $field->rows : 5,
                                                "inputclass"      => isset( $field->inputclass ) ? $field->inputclass : null,
                                                "callback"        => isset( $field->callback ) ? $field->callback : false,
                                                "type"            => isset( $field->type ) ? $field->type : false,
                                                "repeater"        => isset( $field->repeater ) ? $field->repeater : false,
                                                "accordion"       => isset( $field->accordion ) ? $field->accordion : false,
                                                "mediabutton"     => isset( $field->mediabutton ) ? $field->mediabutton : false,
                                                "itemlistclass"   => isset( $field->itemlistclass ) ? $field->itemlistclass : null,
                                                "removeitem"      => isset( $field->removeitem ) ? $field->removeitem : null,
                                                "attribute"       => isset( $field->attribute ) ? $field->attribute : null,
                                                "data"            => isset( $field->data ) ? $field->data : null,
                                                "options"         => isset( $field->options ) ? $field->options : null,
                                            );

                                $new_field      = (object)$new_field;

                                $repeater       = isset( $field->repeater ) && ( $field->type != 'wp-textarea' ) ? $field->repeater : false;
                                $itemlistclass  = isset( $field->itemlistclass ) ? ' '.$field->itemlistclass : null;

                                $current_value  = isset( $instance[$field->id] ) ? $instance[$field->id] : null;

                                echo $DWH_wponetheme_util->get_field_type( array( 'field' => $new_field, 'value' => $current_value ) );
                            }
                        }
                        echo '  </div>';
                        echo '</div>';
                    }
                }
            }
        }

        public function update( $new_instance, $old_instance )
        {
            $config = dwh_get_config( 'config.widget.fields', 'json', array( 'module_v2', 'widgets', basename( __DIR__ ) , 'config' ) );

            $intance = array();

            if( $config ) {
                foreach ( $config as $container ) {
                    foreach ( $container->fields as $field ) {
                        $instance[$field->id] = !empty( $new_instance[$field->id] ) ? $new_instance[$field->id] : $field->value;
                    }
                }
            }

            return $instance;
        }
    }
}