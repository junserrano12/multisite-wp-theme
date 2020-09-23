<?php
/*remove_filter( 'the_content', 'wpautop' );*/
add_filter( 'wp_title', 'header_basetheme_wp_title', 10, 2 );
add_filter( 'image_size_names_choose', 'initialize_basetheme_display_custom_image_size', 11, 1 );
add_filter( 'the_content', 'initialize_basetheme_filter_ptags_on_images' );
add_filter( 'the_generator', 'initialize_basetheme_rss_version' );
add_filter( 'wp_head', 'header_basetheme_remove_recent_comments_style', 1 );
add_filter( 'wp_head', 'header_basetheme_remove_wp_widget_recent_comments_style', 1 );
add_filter( 'gallery_style', 'content_basetheme_gallery_style' );
add_filter( 'excerpt_more', 'initialize_basetheme_excerpt_more' );
add_filter( 'get_search_form', 'header_basetheme_wpsearch' );
add_filter( 'upload_mimes', 'initialize_basetheme_custom_upload_mimes' );
add_filter( 'image_send_to_editor', 'initialize_basetheme_wrap_image', 10, 8 );
add_filter( 'script_loader_tag', 'dwh_add_require_config_attribute', 10, 2 );
/*add_filter( 'script_loader_tag', 'dwh_add_async_defer_attribute', 10, 3 );*/
add_filter( 'robots_txt', 'dwh_custom_robots' );

function dwh_custom_robots( $robots )
{
	global $DWH_Options;
	global $robots_code;

	$added  = "Disallow: /wp-includes/\n";
	$added .= "Disallow: /wp-content/themes/wp_one_theme/fonts/*\n";
	$added .= "Disallow: /hello-world/\n";
	$added .= "Disallow: /dwh-sitemap-99/\n";

	$robots_code  = $DWH_Options->get_option_set_data( 'dwh_site_robots' );
	$robots_text = '';
	if(count($robots_code) > 0 && is_array($robots_code)){
		foreach($robots_code as $key=>$value){
			$robots_text   = $value['robots_txt'];
			$robots_action = $value['robots_action'];
		}
	}

	if($robots_text != '' && $robots_action == 'Append'){
		$robots .= $added;
		$robots .= $robots_text ."\n";
	}else if($robots_text != '' && $robots_action == 'Replace'){
		$robots = $robots_text;
	}else{
		$robots .= $added;
	}

    return $robots;
}


/*set jquery and jquery migrate async*/
function dwh_add_async_defer_attribute($tag, $handle, $src){
	$async_scripts = array(
					);
	$defer_scripts = array(
						'jquery-migrate',
						'gtranslate',
						'gmaps'
					);

	if(in_array($handle, $defer_scripts)){
		return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
	} else if(in_array($handle, $async_scripts)){
		return '<script src="' . $src . '" async="async" type="text/javascript"></script>' . "\n";
	}
	return $tag;
}

/* add data-main in require loader */
function dwh_add_require_config_attribute($tag, $handle){
	if('require' !== $handle ){
		return $tag;
	} else{
		return str_replace(' src', ' data-main="'.get_template_directory_uri().'/js/v1/config.min.js" src', $tag);
	}
}

/* add custom media fields filter */
add_filter("attachment_fields_to_edit", function( $form_fields, $post ){

	$custom_fields = include( get_template_directory().'/module/attachments/media/config.fields.php' );

	foreach( $custom_fields as $key => $value ){

		$form_fields[ $key ] = $value;

	}

	return $form_fields;

}, 10 , 2 );


/* save custom media fields filter */
add_filter("attachment_fields_to_save", function( $post, $attachment ){

	$custom_fields = include( get_template_directory().'/module/attachments/media/config.fields.php' );

	foreach( $custom_fields as $key => $value ){

		if( isset( $attachment[ $key ] ) ){

			update_post_meta( $post['ID'], $key, $attachment[ $key ] );

		}

	}

	return $post;

}, 10 , 2 );


/*GET Page Title*/
function header_basetheme_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged, $post;

	/* Add the blog name */
	$title .= get_bloginfo( 'name', 'display' );

	/* Add the blog description for the home/front page. */
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	/* Add a page number if necessary: */
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
	}

	/* If page has meta page title */
	if ( ( is_page() || is_single() ) && ( get_post_meta($post->ID, 'page_title_field', true) != null || get_post_meta($post->ID, 'page_title_field', true) !='' ) ) {
		$title = get_post_meta($post->ID, 'page_title_field', true);
	}

	return $title;
}

/*REMOVE p Tags in around images */
function initialize_basetheme_filter_ptags_on_images($content){

 	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


/*REMOVE RSS VERSION*/
function initialize_basetheme_rss_version() {

		return '';

}

function header_basetheme_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

/*REMOVE COMMENT STYLE*/
function header_basetheme_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}


/*REMOVE GALLERY STYLE*/
function content_basetheme_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

/*EDIT READ MORE ON EXCERPT*/
function initialize_basetheme_excerpt_more($more) {

	global $post;
	return '...  <a href="'. get_permalink($post->ID) . '" title="Read '.get_the_title($post->ID).'">Read more &raquo;</a>';
}

/*CUSTOMIZE SEARCHBAR*/
function header_basetheme_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('Search for:', 'bonestheme') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','bonestheme').'" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </form>';
    return $form;
}

/*ADD ADDITIONAL UPLOAD FILETYPE*/

function initialize_basetheme_custom_upload_mimes($existing_mimes) {
	$existing_mimes['ico'] = 'image/x-icon';
	$existing_mimes['pdf'] = 'application/pdf';
	$existing_mimes['css'] = 'text/css';
	$existing_mimes['zip'] = 'application/zip';
 	$existing_mimes['gz'] = 'application/x-gzip';
 	$existing_mimes['xml'] = 'application/xml';
 	$existing_mimes['svg'] = 'image/svg+xml';
	return $existing_mimes;

}

/*WRAP IMAGES IN DIV*/
function initialize_basetheme_wrap_image($html){
	if(is_admin()){
		return '<div class="image-container">'.$html.'</div>';
  	}
}

/*DISPLAY CUSTOM IMAGE SIZE ON MENU*/
function initialize_basetheme_display_custom_image_size( $sizes ) {


	$new_sizes = array();
	$added_sizes = get_intermediate_image_sizes();

	foreach( $added_sizes as $key => $value) {
		$new_sizes[$value] = $value;
	}

	$new_sizes = array_merge( $new_sizes, $sizes );

	return $new_sizes;

}


/*=========================================*/
/*unused filter function*/
/*=========================================*/

/*
add_filter('script_loader_tag', 'dwh_add_defer_attribute', 10, 2);
add_filter('pre_option_upload_url_path', 'dwh_relative_upload_url');
add_filter('the_content','dwh_content_replace_absolute_to_cdn');
*/

/*replace path to cdn in the content part only*/
function dwh_content_replace_absolute_to_cdn($content)
{
	return $content;
}

/*insert path of images in content as relative*/
function dwh_relative_upload_url() {
    return '/wp-content/uploads';
}

/* add defer in script*/
function dwh_add_defer_attribute($tag, $handle){
	if( 'googletranslate' === $handle || 'googlemap' === $handle || 'widgetgoogletranslate' === $handle|| 'widgetgooglemap' === $handle || 'facebookapi' === $handle){
		return str_replace(' src', ' defer src', $tag);
	} else {
		return $tag;
	}
}