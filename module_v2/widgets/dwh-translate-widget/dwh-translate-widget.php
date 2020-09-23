<?php
if ( !class_exists( 'dwh_translate_widget' ) )
{
    class dwh_translate_widget extends WP_Widget
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
            dwh_google_translate();
        }

        public function form( $instance )
        {

        }

        public function update( $new_instance, $old_instance )
        {

        }
    }
}