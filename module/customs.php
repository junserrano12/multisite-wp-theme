<?php

/* add hooks */
if ( !function_exists('dwh_body_hook') )
{
    function dwh_body_hook()
    {
        do_action('dwh_body_hook');
    }
}

if ( !function_exists('dwh_header_hook') )
{
    function dwh_header_hook()
    {
        do_action('dwh_header_hook');
    }

}

if ( !function_exists('dwh_footer_hook') )
{
    function dwh_footer_hook()
    {
        do_action('dwh_footer_hook');
    }
}

if ( !function_exists('dwh_content_header_hook') )
{
    function dwh_content_header_hook()
    {
        do_action('dwh_content_header_hook');
    }
}

if ( !function_exists('dwh_content_hook') )
{
    function dwh_content_hook()
    {
        do_action('dwh_content_hook');
    }
}

if ( !function_exists('dwh_content_footer_hook') )
{
    function dwh_content_footer_hook()
    {
        do_action('dwh_content_footer_hook');
    }
}


/* load page */
if ( !function_exists('dwh_load_theme_section') )
{
    function dwh_load_theme_section( $page )
    {
        global $DWH_Options;
        $site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0 );
        $template_path = DWH_SITE_THEME_DIR.'/site/' . $site_info->site_theme .'/'.$page;

        if ( file_exists( $template_path ) ) {
            include($template_path);
        }
    }
}

/* head contents */
if ( !function_exists('dwh_head') )
{
    function dwh_head()
    {
        global $DWH_Theme;
        global $site_info;
        global $site_theme;

        /*Include site header Meta data*/
        $DWH_Theme->header_meta_data();
        /*Include site header links*/
        $DWH_Theme->header_links();
        /*Include site global dynamic scripts*/
        $DWH_Theme->header_site_dynamic_scripts();
        /* Load Global theme fonts */
        $DWH_Theme->header_site_fonts();
        /* Load Global theme css */
        $DWH_Theme->header_site_styles();
        /*Include global scripts*/
        $DWH_Theme->header_site_scripts();
        /* Site main css  */
        $DWH_Theme->header_site_theme_add_style( $site_info , 'style-main' );
        /* Site theme designer css*/
        $DWH_Theme->add_dynamic_css( 'site-theme-designer' , 'site_theme_designer', array( 'theme' => $site_theme ) );
        /* Settings - Theme CSS */
        $DWH_Theme->add_dynamic_css( 'site-settings' , 'settings_site_css', array( 'style_type' => 'site_css' ) );
        /* Site media query css  */
        $DWH_Theme->header_site_theme_add_style( $site_info , 'style-mediaquery' );
        /* Settings - Theme Mediaquery*/
        $DWH_Theme->add_dynamic_css( 'site-settings-mediaquery' , 'settings_site_mediaquery_css', array( 'style_type' => 'site_mediaquery' ) );
        /* Load site theme scripts */
        $DWH_Theme->header_site_theme_add_scripts( $site_info );
    }
}

/*remove contact form 7 script and css*/
if ( !function_exists('dwh_remove_js_css_cf7') )
{
    function dwh_remove_js_css_cf7()
    {
        add_filter( 'wpcf7_load_js', '__return_false' );
        add_filter( 'wpcf7_load_css', '__return_false' );
    }
}

/*minify dynamic css*/
if ( !function_exists('_minify_dynamic_css') )
{
    function _minify_dynamic_css($content)
    {
        /*Remove comments*/
        $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
        /*remove new line*/
        $content = preg_replace('/\r\n|\r|\n/', '', $content);
        /*remove large white space*/
        $content = preg_replace('/\s+/', ' ', $content);
        /*Remove space after colons*/
        $content = str_replace(': ', ':', $content);
        return $content;
    }
}

/*Process custom content to do shortcode*/
if ( !function_exists('_process_custom_content') )
{
    function _process_custom_content( $content )
    {

        if(!has_shortcode( $content, 'contact-form-7'))
        {
            dwh_remove_js_css_cf7();
        }

        $pattern = get_shortcode_regex();
        if ( preg_match_all( '/'. $pattern .'/s', $content, $matches ) ) {
            foreach($matches as $key=>$match){
                foreach($match as $m){
                    $content = str_replace($m, do_shortcode($m), $content);
                }
            }
        }
        echo $content;
    }
}

if ( !function_exists('replace_file_str_val') )
{
    function replace_file_str_val( $data )
    {

        $str_val = isset( $data['str_val'] ) ? $data['str_val'] : '';
        $str_rep = isset( $data['str_rep'] ) ? $data['str_rep'] : '';

        if( !$str_val == "")
        {

            if( isset($data['dir']) && isset($data['view']) )
            {
                $view_dir = "";
                $view_file = $data['view'];

                /* Loop through directory */
                foreach ($data['dir'] as $key => $value) {
                    if( $value!="" ) $view_dir = $view_dir . $value . '/';
                }

                /* Concatenate filename */
                $view_file = get_template_directory() . '/' . $view_dir . $view_file . '.php';

                /* get file contents */
                if( file_exists( $view_file ) )
                {
                    $str = file_get_contents( $view_file );
                    $str = str_replace( $str_rep , $str_val , $str );
                    return $str;
                }
            }


        }
    }
}

/* Loads a view file
@param (array) - mandatory for index(es) 'dir' and 'view'
*/
if ( !function_exists('load_view') )
{
    function load_view( $data )
    {

        if( isset($data['dir']) && isset($data['view']) )
        {
            $view_dir = "";
            $view_file = $data['view'];

            /* Loop through directory */
            foreach ($data['dir'] as $key => $value) {
                if( $value!="" ) $view_dir = $view_dir . $value . '/';
            }

            /* Concatenate filename */
            $view_file = get_template_directory() . '/' . $view_dir . $view_file . '.php';

            /* Include file */
            if( file_exists( $view_file ) )
            {
                include( $view_file );
            }


        }
    }
}

/* get default value */
if ( !function_exists('get_value') )
{
    function get_value($parameter, $defaultvalue)
    {
        if($parameter != '' || $parameter != null){
            return $parameter;
        } else {
            return $paramater = $defaultvalue;
        }
    }
}

/* add custom content for dynamic shortcode */
if ( !function_exists('add_page_inner_custom_content_box') )
{
    function add_page_inner_custom_content_box( $screens )
    {

        add_action('add_meta_boxes', function() use( $screens ){

            /* loop through each post type */
            foreach( $screens as $screen ){

                add_meta_box('custom_content_section_id', 'Custom Content Field', function() use($screen) {

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

/*taxonomy navigation*/
if ( !function_exists('basetheme_content_nav') )
{
    function basetheme_content_nav( $html_id )
    {
        global $wp_query;
        $html_id = esc_attr( $html_id );
        if ( $wp_query->max_num_pages > 1 ) : ?>
            <nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
                <h3 class="assistive-text"><?php _e( 'Post navigation', 'basetheme' ); ?></h3>
                <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'basetheme' ) ); ?></div>
                <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'basetheme' ) ); ?></div>
            </nav>
        <?php endif;
    }
}

/* function to return properly structured menu object */
if ( !function_exists('return_wp_clean_menu_items') )
{
    function return_wp_clean_menu_items($menuargs)
    {
        $menuarr = array();
        $submenuargs = $menuargs;

        if($menuargs){
            $ctr = 0;

            foreach($menuargs as $menu):

                if($menu->menu_item_parent == 0){
                    $menuarr[$ctr]['menu'] = $menu;
                    $ctr1 = 0;

                    foreach($menuargs as $submenu):

                        if($submenu->menu_item_parent == $menu->ID){
                            $menuarr[$ctr]['sub-menu'][$ctr1] = $submenu;
                            $ctr1++;
                        }

                    endforeach;

                    $ctr++;
                }

            endforeach;
        }

        return $menuarr;
    }
}

/* return clean menu li class and link attr*/
if ( !function_exists('return_wp_menu_attr') )
{
    function return_wp_menu_attr($args, $mode = 'li')
    {

        if($mode == 'li'){
            $liclass = 'menu-item';
            $liclass .= !empty( $args->type ) ? ' menu-item-type-'. esc_attr($args->type) : '';
            $liclass .= !empty( $args->object ) ? ' menu-item-object-'. esc_attr($args->object) : '';
            $liclass .= !empty( $args->ID ) ? ' menu-item-'. esc_attr($args->ID) : '';

            if(isset($args->classes)){
                foreach($args->classes as $key => $val){
                    $liclass .= ' '.$val;
                }

            }

            return $liclass;
        }

        elseif($mode == 'link'){

            $linkattr  = !empty( $args->attr_title ) ? ' title="'  . esc_attr( $args->attr_title) .'"' : '';
            $linkattr .= !empty( $args->target ) ? ' target="' . esc_attr( $args->target) .'"' : '';
            $linkattr .= !empty( $args->xfn ) ? ' rel="'    . esc_attr( $args->xfn) .'"' : '';

            if($args->classes[0] === 'ctareservation'){

                if( !empty( $args->url ) )
                {
                    $linkattr .= esc_attr( $args->url );

                }
                else
                {
                    $linkattr .= esc_attr( $args->url );

                }

            } else {
                $linkattr .= ! empty( $args->url ) ? ' href="' . esc_attr( $args->url ) .'"' : '';
            }

             return $linkattr;
        }

        return '';
    }
}

/*
* return nl2br
*/
if ( !function_exists('return_nl2br2') )
{
    function return_nl2br2( $string )
    {
        $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
        return $string;
    }
}

/*
* return br2nl
*/
if ( !function_exists('return_br2nl2') )
{
    function return_br2nl2( $string )
    {
        $string = str_replace(array("<br />"), "\r\n", $string);
        return $string;
    }
}

/*print object*/
if ( !function_exists('_dump') )
{
    function _dump($arr)
    {

        echo '<pre>'. print_r($arr, true) .'</pre>';
    }
}

if ( !function_exists('get_module_config') )
{
    function get_module_config( $module , $config_name )
    {
        if( $module && $config_name )
        {
            $module_config_path = "";
            $config_name = $config_name . '.php';

            if(is_array( $module ))
            {
                foreach ($module as $key => $value) {
                    $module_config_path .= $value . '/';
                }
            }

            $config_file = get_template_directory() . '/module/'.$module_config_path . $config_name;

            if( file_exists( $config_file ))
            {
                return include( $config_file );
            }
        }
    }
}

/**
 * Returns the translated role of the current user. If that user has
 * no role for the current blog, it returns false.
 *
 * @return string The name of the current role
 **/
if ( !function_exists('get_current_user_role') )
{
    function get_current_user_role()
    {
        global $wp_roles;
        $current_user = wp_get_current_user();
        $roles = $current_user->roles;
        $role = array_shift($roles);
        return isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
    }
}

/**
 * Searches an array recursively
 * @needle - value to search
 * @haystack - array to search to
 * @return (bool)
 **/
if ( !function_exists('recursive_array_search') )
{
    function recursive_array_search( $needle , $haystack )
    {
        foreach($haystack as $key=>$value) {
            $current_key=$key;
            if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
                return true;
            }
        }
        return false;
    }
}

/**
 * Check if array keys contains a number
 * @haystack - array to evaluate
 * @return (bool)
 **/
if ( !function_exists('is_numeric_array') )
{
    function is_numeric_array($array)
    {
       foreach ($array as $a=>$b) {
          if (!is_int($a)) {
             return false;
          }
       }
       return true;
    }
}

if ( !function_exists('getRewriteRules') )
{
    function getRewriteRules()
    {
        global $wp_rewrite;
        return $wp_rewrite->rewrite_rules();
    }
}

/**
 * function to check if the current page is a post edit page
 * @param  string  $new_edit what page to check for accepts new - new post page ,edit - edit post page, null for either
 * @return boolean
 */
if ( !function_exists('current_post_page') )
{
    function current_post_page($new_edit = null)
    {
        global $pagenow;
        //make sure we are on the backend
        if (!is_admin()) return false;

        if ($new_edit == "edit"){
            return in_array( $pagenow, array( 'post.php',  ) );
        } elseif ($new_edit == "new") {
            //check for new post page
            return in_array( $pagenow, array( 'post-new.php' ) );
        } else {
            //check for either new or edit
            return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
        }
    }
}

/*hybrid get_option function*/
if ( !function_exists('get_dwh_option') )
{
    function get_dwh_option( $option_set )
    {

        if( $option_set ){

           $option_value = get_option( $option_set );

           if( $option_value ){
                   return $option_value;
           }
           else{

               global $wpdb;
               $table_option = $wpdb->prefix .'options';
               $myrows = $wpdb->get_results( "SELECT option_value FROM $table_option where option_name = '$option_set'", ARRAY_A );
               if( $myrows ) return unserialize( $myrows[0]['option_value'] );

           }
       }
    }
}

/*for custom shortcodes*/
if ( !function_exists('makeAbsoluteToRelative') )
{
    function makeAbsoluteToRelative($absUrl)
    {
        /*
        $find = 'wp-content';
        $location = strpos($absUrl,$find);
        $relativeURL = substr($absUrl,$location - 1);
        return $relativeURL;
        */
        return $absUrl;
    }
}

/*remove http and https in urls*/
/*updated remove relative url*/
if ( !function_exists('fix_links') )
{
    function fix_links($input)
    {
        global $DWH_Options;
        global $DWH_Theme;

        if( $DWH_Theme->cdn_enable() ) {
            $site_info  = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0 );
            $site_cdn   = isset( $site_info->site_theme ) ? $site_info->cdn_flag : 0;
            if($site_cdn){
                return dwh_convert_path_to_relative($input);
            }else{
                return dwh_convert_path_to_cdn($input);
            }
        } else {
            return dwh_convert_path_to_relative($input);
        }
    }
}

if ( !function_exists('dwh_convert_path_to_relative') )
{
    function dwh_convert_path_to_relative($input)
    {
        global $DWH_Theme;
        $pattern        = $DWH_Theme->cdn_pattern();
        $replacement    = $DWH_Theme->relative_paths();
        $input          = preg_replace($pattern, $replacement, $input);
        return $input;
    }
}

if ( !function_exists('dwh_convert_path_to_cdn') )
{
    function dwh_convert_path_to_cdn($input)
    {
        global $DWH_Theme;
        $pattern          = $DWH_Theme->cdn_pattern();
        $replacement     = $DWH_Theme->cdn_paths();
        $input             = preg_replace($pattern, $replacement, $input);
        return $input;
    }
}

if ( !function_exists('page_title_list') )
{
    function page_title_list()
    {
        $page_title = '';
        $pages = get_pages();
        foreach ($pages as $page_data) {
            if($page_data->post_title != ''){
                $title = trim($page_data->post_title);
                $page_title .= $title.',';
            }
        }
        return $page_title;
    }
}

if ( !function_exists('ibe_retiever_url') )
{
    function ibe_retiever_url()
    {

        global $DWH_Options;
        $ibe_url     = $DWH_Options->get_option_set_data( 'dwh_ibe_url' ); //json format from db
        $arr         = (array)json_decode($ibe_url[0]['ibe_desktop_url']);
        $hotel_info  = $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0);
        $hid_arr_str = $hotel_info->hotel_id;
        $default     = 'http://reservations.directwithhotels.com';

        $idUrl = array();

        if($arr != ''){
            foreach($arr as $key=>$value){
                $dataArr = (array)$value;
                $isSuccess = isset( $dataArr['success'] ) ? $dataArr['success'] : 0;
                foreach($dataArr as $result=>$ibeurl){
                    $ibeurl = (array)$ibeurl;
                    $domain = isset($ibeurl['ibe_desktop_subdomain']) ? $ibeurl['ibe_desktop_subdomain'] : $default;
                    $idUrl[$key] = $isSuccess == 1 ? $domain : $default;
                }
            }
        }

        if(count($idUrl) > 0){
            $ibeLink = isset( $idUrl[$hid_arr_str] ) ? $idUrl[$hid_arr_str] : null;
            $desktopCTALink = ($ibeLink == 'https://' || $ibeLink == '' || $ibeLink == null) ? $default : $idUrl[$hid_arr_str];
        }else{
            $desktopCTALink = $default;
        }

        return $desktopCTALink;
    }
}