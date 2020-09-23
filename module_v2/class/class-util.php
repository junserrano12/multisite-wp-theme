<?php
if ( !class_exists( 'DWH_wponetheme_util' ) )
{
    class DWH_wponetheme_util
    {
        public $util_object;
        public $counter;
        public $ctr;

        private $content;
        private $shortcode;

        public function __construct()
        {
            $this->util_object     = array();
            $this->counter         = 0;
            $this->ctr             = 0;
            $this->content         = '';
            $this->shortcode       = '';
        }

        public function register_scripts( $config )
        {
            foreach ( $config as $script ) {

                $handle         = isset( $script->handle ) ? $script->handle : false;
                $src            = isset( $script->src ) ? $script->src : false;
                $deps           = isset( $script->deps ) ? $script->deps : array();
                $ver            = isset( $script->ver ) ? $script->ver : false;
                $in_footer      = isset( $script->in_footer ) ? $script->in_footer : false;
                $has_comment    = isset( $script->has_comment ) ? $script->has_comment : false;

                if( $src ) {
                    wp_register_script( $handle, $src, $deps, $ver, $in_footer );
                }
            }
        }

        public function register_styles( $config )
        {
            foreach ( $config as $style ) {

                $handle         = isset( $style->handle ) ? $style->handle : false;
                $src            = isset( $style->src ) ? $style->src : false;
                $deps           = isset( $style->deps ) ? $style->deps : array();
                $ver            = isset( $style->ver ) ? $style->ver : false;
                $media          = isset( $style->media ) ? $style->media : 'all';
                $in_child       = isset( $style->in_child ) ? $style->in_child : false;

                wp_register_style( $handle, $src, $deps, $ver, $media );
            }
        }

        public function get_shortcode_atts( $shortcode, $content )
        {
            $atts                = array();
            $pattern             = get_shortcode_regex();

            if ( has_shortcode( $content, $shortcode ) ) {

                if ( preg_match_all( '/'. $pattern .'/s', $content, $matches ) ) {
                    foreach ( $matches[2] as $key => $match ) {

                        if ( $match === $shortcode ) {
                            $atts[$key] = shortcode_parse_atts( $matches[3][$key] );
                        }
                    }
                }
            }

            return $atts;
        }

        public function load_shortcode_content( $content, $is_responsive_image = true )
        {
            if ( !is_array( $content ) ) {

                if( !has_shortcode( $content, 'contact-form-7' ) ) {
                    dwh_remove_js_css_cf7();
                }

                if ( $is_responsive_image ) {
                    $content = wp_make_content_images_responsive( $content );
                }

                $pattern = get_shortcode_regex();
                if ( preg_match_all( '/'. $pattern .'/s', $content, $matches ) ) {
                    foreach ( $matches as $key => $match ) {
                        foreach ( $match as $m ) {
                            $content = str_replace( $m, do_shortcode( $m ), $content );
                        }
                    }
                }

            }

            return $content;
        }

        public function render( $filePath, $viewData = null, $return = false )
        {

            ( $viewData ) ? extract( $viewData ) : null;

            ob_start();
            include ( $filePath );
            $template = ob_get_contents();
            ob_end_clean();

            if ( $return ) return $template;

            echo $template;
        }

        public function localize_object( $objectid, $array )
        {
            $jsonobject = array();
            $jsonobject = array( $objectid => $array );
            $jsonobject = json_encode( $jsonobject );

            add_action( 'admin_footer', function() use( $jsonobject ) {
                ?><script type='text/javascript'>
                /* <![CDATA[ */
                <?php echo $jsonobject; ?>
                /* ]]> */
                </script><?php
            } );
        }

        public function get_field_list( $field_items, $field )
        {
            $fields = array();

            if ( dwh_empty( $field_items ) && is_array( $field_items ) ) {

                $output = null;

                foreach ( $field_items as $ctr => $field_item ) {

                    $fields[$ctr]['id']             = isset( $field->id ) ? $field->id.'-'.$ctr : false;
                    $fields[$ctr]['name']           = isset( $field->name ) ?  $field->name.'['.$ctr.']' : $field->id.'['.$ctr.']';
                    $fields[$ctr]['field_id']       = isset( $field->field_id ) ? $field->field_id : null;
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
                    $fields[$ctr]['resetitem']      = isset( $field->resetitem ) ? $field->resetitem : false;
                    $fields[$ctr]['attribute']      = isset( $field->attribute ) ? $field->attribute : null;
                    $fields[$ctr]['data']           = isset( $field->data ) ? $field->data : null;
                    $fields[$ctr]['options']        = isset( $field->options ) ? $field->options : null;
                    $fields[$ctr]                   = (object)$fields[$ctr];

                    $output .= $this->get_field_type( array( 'field' => $fields[$ctr], 'value' => $field_item ) );
                }

                return $output;

            } else {

                $label  = isset( $field->label ) ? $field->label : 'Item';
                return '<div class="box-container empty-box-container initial-blank-item">Add '.$label.'</div>';
            }
        }

        public function get_field_type( $param = array() )
        {
            $data                       = array();
            $field                      = isset( $param['field'] ) || dwh_empty( $param['field'] ) ? $param['field'] : false;
            $defaultclass               = isset( $field->repeater ) && ( $field->repeater ) ? 'draggableitem droppablecontainer item container-content-item ' : 'container-content-item ';

            $data['id']                 = isset( $field->id ) ? $field->id : false;
            $data['name']               = isset( $field->name ) ? $field->name : $field->id;
            $data['field_id']           = isset( $field->field_id ) ? $field->field_id : null;
            $data['label']              = isset( $field->label ) ? $field->label : null;
            $data['altlabel']           = isset( $field->altlabel ) ? $field->altlabel : null;
            $data['class']              = isset( $field->class ) ? $defaultclass.$field->class : $defaultclass;
            $data['description']        = isset( $field->description ) ? $field->description : null;
            $data['default_value']      = isset( $field->default_value ) ? $field->default_value : null;
            $data['value']              = isset( $param['value'] ) || dwh_empty( $param['value'] ) ? $param['value'] : null;
            $data['rows']               = isset( $field->rows ) ? $field->rows : 5;
            $data['inputclass']         = isset( $field->inputclass ) ? ' '.$field->inputclass : null;
            $data['callback']           = isset( $field->callback ) ? $field->callback : false;
            $data['type']               = isset( $field->type ) ? $field->type : null;
            $data['repeater']           = isset( $field->repeater ) ? $field->repeater : false;
            $data['accordion']          = isset( $field->accordion ) ? $field->accordion : false;
            $data['mediabutton']        = isset( $field->mediabutton ) ? $field->mediabutton : true;
            $data['itemlistclass']      = isset( $field->itemlistclass ) ? $field->itemlistclass : null;
            $data['removeitem']         = isset( $field->removeitem ) ? $field->removeitem : false;
            $data['resetitem']          = isset( $field->resetitem ) ? $field->resetitem : false;
            $data['attribute']          = isset( $field->attribute ) ? $field->attribute : null;
            $data['data']               = isset( $field->data ) ? $field->data : null;
            $data['options']            = isset( $field->options ) ? $field->options : null;

            $data['field']              = $field;
            $data['accordioncontent']   = $data['accordion'] ? ' accordion-content' : null;
            $data['accordiontitle']     = $data['accordion'] ? ' accordion-title' : null;

            if ( $field ) {

                $type       = $data['type'];
                $filePath   = dwh_get_main_directory().'/module_v2/field-views/field-'.$type.'.php';
                $viewData   = $data;

                $output = $this->render( $filePath, $viewData, true );

                return $output;
            }
        }
    }
}