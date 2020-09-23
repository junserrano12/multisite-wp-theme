<?php
/*REMOVE CONTACT FORM 7 ASSETS IF NO SHORTCODE FOUND*/
if ( !function_exists( 'dwh_remove_js_css_cf7' ) )
{
    function dwh_remove_js_css_cf7()
    {
        global $post;
        if( is_a( $post, 'WP_Post' ) && !has_shortcode( $post->post_content, 'contact-form-7' ) ) {
            add_filter( 'wpcf7_load_js', '__return_false' );
            add_filter( 'wpcf7_load_css', '__return_false' );
        }
    }
}

/* THEME TEMPLATE SECTION*/
if ( !function_exists( 'dwh_get_theme_layout' ) )
{
    function dwh_get_theme_layout()
    {
        $theme_template = dwh_get_data( 'theme-layout', 'onetheme_customizer_options' );
        $theme_layout   = isset( $theme_template['theme_name'] ) ? $theme_template['theme_name'] : '';

        return $theme_layout;
    }

}

if ( !function_exists( 'dwh_get_theme_template' ) )
{
    function dwh_get_theme_template( $theme_layout = false )
    {

        $theme_layout = ( !$theme_layout ) ? dwh_get_theme_layout() : $theme_layout;

        switch ( $theme_layout ) {

            case 'AW4.2.0-default':
            case 'NW3.2.1-default':
            case 'NW3.2.2-microtel':
            case 'NW3.2.3-shotel':
            case 'NW3.2.4-palace':
            case 'NW3.2.5-garden':
            case 'NW3.2.6-luxent':
            case 'NW3.2.7-elan':
            case 'NW3.2.8-princesa':
            case 'NW3.2.9-midas':
                $is_template = 'v1';
                break;
            default:
                $is_template = 'v2';
                break;
        }

        return $is_template;
    }
}

/*FONT UPLOAD SUPPORT FUNCTIONS*/
if ( !function_exists( 'dwh_delete_font_directory' ) )
{
    function dwh_delete_font_directory( $folder )
    {
        if ( is_dir( $folder ) && count( glob( "$folder/*" ) ) == 0 ) {
            rmdir($folder);
        }
    }
}
if ( !function_exists( 'dwh_upload_font_dir_is_empty' ) )
{
    function dwh_upload_font_dir_is_empty($directory){
		if(count(glob("$directory/*")) === 0){ /*its empty*/
			return true;
		}else{
			return false;
		}
	}
}

/*OB START SUPPORT FUNCTION*/
if ( !function_exists( 'dwh_modify_html' ) )
{
	function dwh_modify_html( $input )
	{
		$input = dwh_add_tracker( $input );
		$input = dwh_define_constant_term( $input );
		$input = dwh_remove_expired_element( $input );
        // $input = dwh_cdn_url( $input );
        // $input = dwh_switch_ibe_url( $input );
        // $input = dwh_is_ssl_url( $input );
        // $input = dwh_minify_html( $input );

		return $input;
	}
}

if ( !function_exists( 'dwh_cdn_url' ) )
{
    function dwh_cdn_url( $input ) {

        $cdnurl = ( defined('DWH_CDN_URL') && dwh_empty( DWH_CDN_URL ) ) ? DWH_CDN_URL : false;

        if ( $cdnurl ) {
            $pattern = array(
                            '/\b(http|https)(\:\/\/)([a-zA-Z0-9\.\-]*)(\/wp-content\/uploads\/)\b/',
                            '/\b(http|https)(\:\/\/)([a-zA-Z0-9\.\-]*)(\/wp-content\/themes\/)\b/'
                        );

            $replace = array(
                            '$1$2'.$cdnurl.'$4',
                            '$1$2$3$4'
                        );

            $input = preg_replace( $pattern, $replace, $input );

        }

        return $input;
    }
}

if ( !function_exists( 'dwh_minify_html' ) )
{
    function dwh_minify_html( $input )
    {
         $pattern = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        $input = preg_replace( $pattern, $replace, $input );

        return $input;
    }
}

if ( !function_exists( 'dwh_is_ssl_url' ) )
{
    function dwh_is_ssl_url( $input )
    {
        if ( is_ssl() || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
            $pattern = array(
                            '/\b(http:\/\/)([a-zA-Z0-9\.\-]*\/wp-content\/)\b/',
                            '/\b(http:\/\/)([a-zA-Z0-9\.\-]*\/wp-content\/uploads\/)\b/',
                            '/\b(http:\/\/)([a-zA-Z0-9\.\-]*\/wp-content\/plugins\/)\b/',
                            '/\b(http:\/\/)([a-zA-Z0-9\.\-]*\/wp-content\/themes\/)\b/'
                        );

            $replace = array(
                            'https://$2',
                            'https://$2',
                            'https://$2',
                            'https://$2'
                        );

            $input = preg_replace( $pattern, $replace, $input );
        }

        return $input;
    }
}

if ( !function_exists( 'dwh_switch_ibe_url' ) )
{
    function dwh_switch_ibe_url( $input )
    {
        $hoteltype = dwh_get_data( 'hotel-type', 'dwh_hotel_option' );
        $hotel     = ( $hoteltype === 'single' ) ? dwh_get_data( 'hotel-single', 'dwh_hotel_option' ) : dwh_get_data( 'hotel-group', 'dwh_hotel_option' );

        if ( $hoteltype === 'single') {
            $hotelsubdomain = dwh_empty( $hotel['hotel_subdomain'] ) ? $hotel['hotel_subdomain'] : '$1$2';

            $pattern = array(
                            '/\b(http:\/\/|https:\/\/)(reservations.directwithhotels.com)\b/'
                        );
            $replace = array(
                            $hotelsubdomain
                        );

            $input = preg_replace( $pattern, $replace, $input );
        } else {

            foreach ($hotel as $key => $value) {
                $pattern[$key] = '/\b(http:\/\/reservations.directwithhotels.com|https:\/\/reservations.directwithhotels.com)(\/\w*\/\w*\/'.$value['hotel_id'].'\/)\b/';
                $replace[$key] = dwh_empty( $value['hotel_subdomain'] ) ? $value['hotel_subdomain'].'$2' : '$1$2';
            }

            $input = preg_replace($pattern, $replace, $input);
        }

        return $input;
    }
}

if ( !function_exists( 'dwh_remove_expired_element' ) )
{
	function dwh_remove_expired_element( $input )
	{
		preg_match_all( '/(data-expiry)(=\")([\d-]*)(\")/', $input, $matches );

        foreach ( $matches[0] as $key => $match ) {
			if ( dwh_is_expired( $matches[3][$key] ) ) {
                $re = '%<div\b[^>]*?\bdata-expiry\s*+=\s*+([\'"]?+)\b'.$matches[3][$key].'\b(?(1)\1)[^>]*+>((?:[^<]++|<(?!/?div\b|!--)|<!--.*?-->|<div\b[^>]*+>(?2)</div\s*>)*+)</div\s*>%isx';
				$input = preg_replace( $re, '', $input );
			}
		}

        return $input;
	}
}

if ( !function_exists( 'dwh_define_constant_term' ) )
{
	function dwh_define_constant_term( $input )
	{
        $hotel = dwh_get_data( 'hotel-single', 'onetheme_hotel_options', array('default' => false) );

        if ( $hotel ) {
            $hotelid        = $hotel['hotel_id'];
            $hotelname      = $hotel['hotel_name'];
            $hotellocation  = $hotel['hotel_location'];

            $pattern = array(
                            '/\b(HOTELNAME|HOTEL\sNAME)\b/',
                            '/\b(HOTELLOCATION|HOTEL\sLOCATION)\b/',
                            '/\b(HOTELID|HOTEL\sID)\b/'
                        );
            $replace = array(
                            $hotelname,
                            $hotellocation,
                            $hotelid
                        );


            $input = preg_replace( $pattern, $replace, $input );
        }

        return $input;
	}
}

if ( !function_exists( 'dwh_add_image_alt_title' ) )
{
	function dwh_add_image_alt_title( $input )
	{
		// $regex 					= '/(\<img)((?:(?!\>).)*)(\>)/';
		// $hotelnameandlocation	= dwh_get_data('hotel-name', 'dwh_hotel_option').' in '.dwh_get_data('hotel-location', 'dwh_hotel_option');
		// $input 					= preg_replace( $regex, array(''), $input );
		// $input 					=
		// return
		// $input  = preg_replace(pattern, replacement, subject)
	}
}

if ( !function_exists( 'dwh_add_tracker' ) )
{
	function dwh_add_tracker( $input )
	{
        $google_tag_manager_controller = dwh_empty( dwh_get_data( 'google-tag-manager-controller', 'onetheme_site_options' ) ) ? dwh_get_data( 'google-tag-manager-controller', 'onetheme_site_options' ) : false;
        $universal_analytics_id_1      = dwh_empty( dwh_get_data( 'google-universal-analytics', 'onetheme_site_options' ) ) ? dwh_get_data( 'google-universal-analytics', 'onetheme_site_options' ) : false;
        $legacy_analytics_id_1         = dwh_empty( dwh_get_data( 'google-legacy-analytics', 'onetheme_site_options' ) ) ? dwh_get_data( 'google-legacy-analytics', 'onetheme_site_options' ) : false;

        if ( ( $universal_analytics_id_1 || $legacy_analytics_id_1 ) && !$google_tag_manager_controller ) {
            $trackersconfig         = dwh_get_config( 'config.trackers', 'json' );
            $trackersthemeoptions   = dwh_get_data( 'event-tracker', 'onetheme_site_options' );

            $pattern                = array();
            $replacement            = array();

            $trackersconfig         = ( isset( $trackersthemeoptions ) ) ? array_merge($trackersconfig, $trackersthemeoptions) : $trackersconfig;
            foreach ( $trackersconfig as $key => $tracker ) {
                $tracker            = is_array( $tracker) ? (object)$tracker : $tracker;

                $element            = ( isset( $tracker->element ) && ( $tracker->element !== '' ) ) ? $tracker->element : 'a';
                $attribute          = ( isset( $tracker->attribute ) && ( $tracker->attribute !== '' ) ) ? $tracker->attribute : 'class';
                $selector           = ( isset( $tracker->selector ) && ( $tracker->selector !== '' ) ) ? $tracker->selector : false;
                $gacode             = 'onclick="ga(\''.$tracker->command.'\', \''.$tracker->hitType.'\', \''.$tracker->eventCategory.'\', \''.$tracker->eventAction.'\', \''.$tracker->eventLabel.'\');"';

                if( $selector ) {
                    if ( $element == 'a' ) {
                        $pattern[$key]      = '/(\<a.*)('.$attribute.'=(\"|.*\s)\b'.$selector.'(?![\-|\_|a-zA-Z])\b.*\".*\<\/a\>)/';
                        $replacement[$key]  = '$1'.$gacode.' $2';
                    } else {
                        $pattern[$key]      = '/(\<'.$element.'.*)('.$attribute.'=(\"|.*\s)\b'.$selector.'(?![\-|\_|a-zA-Z])\b.*\"\>.*\<a.*)(href.*\<\/'.$element.'\>)/';
                        $replacement[$key]  = '$1$2$3'.$gacode.' $4';
                    }
                }
            }

            $input = preg_replace( $pattern, $replacement, $input );
        }

        return $input;
	}
}

/*MEDIA IMAGES SUPPORT FUNCTION*/
if ( !function_exists( 'dwh_image_wrapper' ) )
{
    function dwh_image_wrapper( $html, $id, $size = 'modal_image', $is_shortcode = false, $atts = array(), $data = array() )
    {
        $attachment             = get_post( $id );
        $image_colorbox         = dwh_empty( get_post_meta( $id, 'dwh_image_colorbox', true ) ) ? get_post_meta( $id, 'dwh_image_colorbox', true ) : 'none';
        $image_custom_link      = dwh_empty( get_post_meta( $id, 'dwh_image_custom_link', true ) ) ? get_post_meta( $id, 'dwh_image_custom_link', true ) : null;
        $image_expiry_date      = dwh_empty( get_post_meta( $id, 'dwh_image_expire_date', true ) ) ? get_post_meta( $id, 'dwh_image_expire_date', true ) : false;
        $image                  = wp_get_attachment_image_src( $id, $size );
        $image_src              = wp_get_attachment_image_url( $id, $size );
        $image_srcset           = wp_get_attachment_image_srcset( $id, 'full' );
        $image_description      = dwh_empty( $attachment->post_content ) ? $attachment->post_content : 'Insert Content';
        $image_data_expire      = ( $image_expiry_date ) ? ' data-expiry="'.$image_expiry_date.'"' : null;

        $image_container_class  = isset( $data['image-contianer-class'] ) ? $data['image-contianer-class'] : 'image-container';

        switch ( $image_colorbox ) {
            case 'none':
                if ( isset( $image_custom_link ) ) {
                    $html = '<div class="'.$image_container_class.'"'.$image_data_expire.'><a href="'.esc_url( $image_custom_link ).'">'.$html.'</a></div>';
                } else {
                    $html = '<div class="'.$image_container_class.'"'.$image_data_expire.'>'.$html.'</div>';
                }
                break;
            case 'inline';
                $html  = '<div class="'.$image_container_class.'"'.$image_data_expire.'><a href="#colorbox-container-'.$id.'" class="colorbox-inline">'.$html.'</a></div>';
                if ( !$is_shortcode ) {
                    if ( isset( $image_custom_link ) ) {
                        $html .= "\n".'[dwh_modal_content id="'.$id.'"]'."\n".'<a href="'.$image_custom_link.'" ><img src="'.$image_src.'" srcset="'.$image_srcset.'" sizes="(max-width: '.$image[1].'px) 100vw, '.$image[1].'px" width="'.$image[1].'"/></a>'."\n".'[/dwh_modal_content]';
                    } else {
                        $html .= "\n".'[dwh_modal_content id="'.$id.'"]'."\n".$image_description."\n".'[/dwh_modal_content]';
                    }
                }
                break;
            default:
                $html = '<div class="'.$image_container_class.'"'.$image_data_expire.'><a href="'.esc_url( $image_src ).'" class="colorbox">'.$html.'</a></div>';
                break;
        }

        return $html;
    }
}

if ( !function_exists( 'dwh_is_expired' ) )
{
    function dwh_is_expired( $date )
    {
        $expired = false;

        if ( $date ) {
            $format     = 'Y-m-d';
            $today      = date( $format, time() );
            $expire     = date( $format, strtotime( $date ) );
            $expired    = ( $today > $expire );
        }

        return $expired;
    }
}

/*PLUGIN SUPPORT FUNCTION*/
if ( !function_exists( 'dwh_get_plugin_data' ) )
{
	function dwh_get_plugin_data( $data )
	{
		if ( defined( 'DWH_PLUGIN_PATH' ) ) {
			if ( ! function_exists( 'get_plugins' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			$plugin_folder = get_plugins( '/' . plugin_basename( DWH_PLUGIN_PATH ) );
			$plugin_file = basename( ( DWH_PLUGIN_PATH ) ).'.php';

			$result = isset( $plugin_folder[$plugin_file][$data] ) ? $plugin_folder[$plugin_file][$data] : false;
		} else {
			$result = false;
		}

		return $result;
	}
}

/*SHORTCODE SUPPORT FUNCTIONS*/
if ( !function_exists( 'dwh_get_shortcode_config_style_handles' ) )
{
	function dwh_get_shortcode_config_style_handles()
	{
		$handles = array();

        $shortcode_path = dwh_get_main_directory().'/module_v2/shortcodes/';
        $shortcodes     = dwh_get_config( 'config.shortcodes', 'json' );

        foreach ( $shortcodes as $shortcode ) {

            $shortcode_id = isset( $shortcode->id ) ? $shortcode->id : false;
            if ( $shortcode_id ) {
                $config_style_file = $shortcode_path.$shortcode_id.'/config/config.styles.json';

                if ( file_exists( $config_style_file ) ) {

                    $dirs           = array( 'module_v2', 'shortcodes', $shortcode_id, 'config' );
                    $style_config   = dwh_get_config( 'config.styles', 'json', $dirs );

                    foreach ( $style_config as $style ) {
                        $handle = isset( $style->handle ) ? $style->handle : false;
                        if ( $handle ) {
                            array_push( $handles, $style->handle );
                        }
                    }
                }
            }
        }
		return $handles;
	}
}

/*CODE SNIPPET SUPPORT*/
if ( !function_exists( 'dwh_show_snippet' ) )
{
    function dwh_show_snippet( $postids ) {
        global $post;

        if ( isset( $postids ) ) {
            if ( isset( $post->ID ) ) {
                return ( in_array( $post->ID, $postids ) ) ? true : false;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}

/*SUBDOMIAIN SYNC*/
if ( !function_exists( 'dwh_custom_cron' ) )
{
	function dwh_custom_cron( $url, $data, $datatype = null, $return = false )
	{
        $postfields         = isset( $data['postfields'] ) ? $data['postfields'] : "";
        $returntransfer     = isset( $data['returntransfer'] ) ? $data['returntransfer'] : true;
        $encoding           = isset( $data['encoding'] ) ? $data['encoding'] : "";
        $maxredirs          = isset( $data['maxredirs'] ) ? $data['maxredirs'] : 10;
        $timeout            = isset( $data['timeout'] ) ? $data['timeout'] : 30;
        $header             = isset( $data['header'] ) ? $data['header'] : false;
        $httpversion        = isset( $data['httpversion'] ) ? $data['httpversion'] : CURL_HTTP_VERSION_1_1;
        $customrequest      = isset( $data['customrequest'] ) ? $data['customrequest'] : "POST";
        $httpheader         = isset( $data['httpheader'] ) ? $data['httpheader'] : array( "cache-control: no-cache", "content-type: application/x-www-form-urlencoded" );

		$curl = curl_init();

   		curl_setopt_array($curl, array(
                                        CURLOPT_URL             => $url,
                                        CURLOPT_RETURNTRANSFER  => $returntransfer,
                                        CURLOPT_ENCODING        => $encoding,
                                        CURLOPT_MAXREDIRS       => $maxredirs,
                                        CURLOPT_TIMEOUT         => $timeout,
                                        CURLOPT_HEADER          => $header,
                                        CURLOPT_HTTP_VERSION    => $httpversion,
                                        CURLOPT_CUSTOMREQUEST   => $customrequest,
                            			CURLOPT_POSTFIELDS      => $postfields,
                                        CURLOPT_HTTPHEADER      => $httpheader
                                    ));

        $response   = curl_exec($curl);
        $err        = curl_error($curl);

        curl_close($curl);

        $response = ( $datatype !== 'json' ) ? json_encode( $response ) : $response;
        $response = ( $err ) ? $err : $response;

        if ( $return ) return $response;
        echo $response;
	}
}

/* get main nav menu */
if ( !function_exists( 'dwh_get_wp_nav_menu' ) )
{
    function dwh_get_wp_nav_menu( $args )
    {

        ob_start();
        wp_nav_menu( $args );
        return ob_get_clean();
    }
}

/* shortcode tools default shortcode_atts() cannot list multiple shortcode atts in an array */
if ( !function_exists( 'dwh_get_shortcode_atts' ) )
{
    function dwh_get_shortcode_atts( $content, $regex = array() )
    {
        $string     = preg_replace( '/(&#8221;|&#8222;|&#8243;|&#8244;)/', '"', $content );
        $pattern    = get_shortcode_regex( $regex );
        preg_match_all( '/'.$pattern.'/', $string, $listatts );
        return $listatts[3];
    }
}

if ( !function_exists( 'dwh_get_shortocode_content' ) )
{
    function dwh_get_shortcode_content( $content, $regex = array() )
    {
        $pattern    = get_shortcode_regex( $regex );
        preg_match_all( '/'.$pattern.'/', $content, $listcontent );
        return $listcontent[5];
    }
}

if ( !function_exists( 'dwh_get_shortcode_atts_value' ) )
{
    function dwh_get_shortcode_atts_value( $list, $atts )
    {
        $atts_value = array();
        foreach( $list as $key => $value ) {
            preg_match_all( '/('.$atts.'=)(\"|)(\d+|true|false|.*?)(\2)/', $value, $matches );
            $atts_value[$key] = array_shift( $matches[3] );
        }

        return $atts_value;
    }
}


/* track the given parameters of the shortcode "dwh_call_function" */
if ( !function_exists( 'dwh_rebuild_parameter' ) )
{
    function dwh_rebuild_shortcode_parameter( $function_name, $param )
    {
        $data = array();

        switch( $function_name )
        {
            case 'dwh_default_banner':

                foreach($param as $key=>$value){
                    if( $key == 'class'){
                        $data[] = array($key =>$value);
                    }else{
                        $data[] = $value;
                    }
                }

            break;

            case 'dwh_link_to':

                $data = array($param);

            break;

            case 'dwh_cta_link':

                $type  = isset($param['type']) && dwh_empty($param['type']) ? $param['type'] : 'default';
                $label = isset($param['label']) && dwh_empty($param['label']) ? $param['label'] : 'back';

                $param = array( 'type' => $type, 'label' => $label );/* arrange the array keys and value into correct order */
                $data  = $param;

            break;

            case 'dwh_post_thumbnail':

                $postid = isset($param['postid']) && dwh_empty($param['postid']) ? $param['postid'] : null;
                $size = isset($param['size']) && dwh_empty($param['size']) ? $param['size'] : 'full';

                $param = array( 'postid' => $postid, 'size' => $size );/* arrange the array keys and value into correct order */
                $data = $param;

            break;

            case 'dwh_pagination':

                $pages = isset($param['pages']) && dwh_empty($param['pages']) ? $param['pages'] : '';
                $range = isset($param['range']) && dwh_empty($param['range']) ? $param['range'] : 2;

                $param = array( 'pages' => $pages, 'range' => $range );/* arrange the array keys and value into correct order */
                $data = $param;

            break;

        } /* end switch */

        return $data;
    }
}

/* Field Views */
if ( !function_exists( 'dwh_get_file_content' ) )
{
    function dwh_get_file_content( $parameters, $return = false )
    {

        $filename  = isset( $parameters->file ) && dwh_empty( $parameters->file ) ? $parameters->file : false;
        $filepath  = isset( $parameters->path ) && dwh_empty( $parameters->path ) ? $parameters->path : false;
        $extension = isset( $parameters->extension ) && dwh_empty( $parameters->extension ) ? $parameters->extension : false;

        if ( $filename && $filepath && $extension ) {
            $search   = array(
                            'get_template_directory()',
                            'dwh_get_theme_template()',
                            'dwh_get_theme_layout()'
                        );

            $replace  = array(
                            get_template_directory(),
                            dwh_get_theme_template(),
                            dwh_get_theme_layout()
                        );

            $filepath = str_replace( $search, $replace, $filepath );


            $file = $filepath.$filename.'.'.$extension;

            if ( file_exists( $file ) ) {
                $file_content = file_get_contents( $file );
                if ( $return ) return $file_content;
                echo $file_content;
            }
        }
    }
}