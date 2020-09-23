<?php
global $DWH_Options;
global $DWH_Admin;
global $post;

/* Get site info */
$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);

/* Get hotel info */
$hotel_info = $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0);

/* Set site theme */
$site_theme = "";
if( $site_info ) $site_theme = $site_info->site_theme;

/* Get user role restrictions */
$user_role_restrictions = $DWH_Admin->get_user_role_restrictions();
if( $user_role_restrictions ) $user_role_restrictions = $user_role_restrictions;

?> 
<script>

	var site_info 										= [];
	var hotel_info 										= [];
	var user_info 										= [];
	var post_info 										= <?php echo json_encode( $post );?>;
	var images 											= [];
	var nonces 											= [];
	var admin_paths 									= [];
	var widget_settings 								= [];
	var admin_ajax_url 									= '<?php echo admin_url("admin-ajax.php"); ?>';
	var modified_flag 									= false;
	var text_editors 									= [];
	var editor_theme_doc 								= "";
	var el_editor_theme_designer						= "";
	var text_editor_id 									= "";


	/* Set site info */
	site_info['base_url'] 								= "<?php echo site_url(); ?>";
	site_info['theme_name']								= "<?php echo $site_theme;?>";
	site_info['template_directory_uri']					= "<?php echo get_template_directory_uri();?>";

	/* user info */
	user_info['role'] 									= "<?php echo ucfirst( DWH_USER_ROLE );?>";
	user_info['restrictions'] 							= '<?php echo json_encode( $user_role_restrictions );?>';

	/* Set image values */
	images['gallery_image_shortcode']  					= "/images/default-gallery-150x150.jpg";
	images['gallery_image_noimg_150by150']  			= "/images/default-noimage-150x150.jpg";
	images['gallery_image_noimg']  						= "/images/default-noimage.png";
	
	images['logo']  									= "/images/logo.png";
	images['favicon']  									= "/images/favicon.ico";
	images['noimage']  									= "/images/default-noimage.png";

	/* Set nonce values */
	nonces['theme_activate_sidebars']					= { 'naction' : 'theme_activate_sidebars' , 'nonce' : '<?php echo wp_create_nonce("theme_activate_sidebars");?>' };		
	nonces['option_edit_item']							= { 'naction' : 'option_edit_item' , 'nonce' : '<?php echo wp_create_nonce("option_edit_item");?>' };		
	nonces['option_edit_item_hotel']					= { 'naction' : 'option_edit_item_hotel' , 'nonce' : '<?php echo wp_create_nonce("option_edit_item_hotel");?>' };		
	nonces['option_add_item']							= { 'naction' : 'option_add_item' , 'nonce' : '<?php echo wp_create_nonce("option_add_item");?>' };		
	nonces['option_update_item']						= { 'naction' : 'option_update_item' , 'nonce' : '<?php echo wp_create_nonce("option_update_item");?>' };		
	nonces['option_delete_item']						= { 'naction' : 'option_delete_item' , 'nonce' : '<?php echo wp_create_nonce("option_delete_item");?>' };		
	nonces['option_get_option_set_data']				= { 'naction' : 'option_get_option_set_data' , 'nonce' : '<?php echo wp_create_nonce("option_get_option_set_data");?>' };		
	nonces['option_migrate_update']						= { 'naction' : 'option_migrate_update' , 'nonce' : '<?php echo wp_create_nonce("option_migrate_update");?>' };		
	nonces['option_getxml']								= { 'naction' : 'option_getxml' , 'nonce' : '<?php echo wp_create_nonce("option_getxml");?>' };	
	nonces['option_export']								= { 'naction' : 'option_export' , 'nonce' : '<?php echo wp_create_nonce("option_export");?>' };	
	nonces['option_import']								= { 'naction' : 'option_import' , 'nonce' : '<?php echo wp_create_nonce("option_import");?>' };	
	nonces['widget_default_field_settings']				= { 'naction' : 'widget_default_field_settings' , 'nonce' : '<?php echo wp_create_nonce("widget_default_field_settings");?>' };
	nonces['option_load_defaults']						= { 'naction' : 'option_load_defaults' , 'nonce' : '<?php echo wp_create_nonce("option_load_defaults");?>' };
	nonces['option_theme_designer_save']				= { 'naction' : 'option_theme_designer_save' , 'nonce' : '<?php echo wp_create_nonce("option_theme_designer_save");?>' };
	nonces['option_theme_designer_enable']				= { 'naction' : 'option_theme_designer_enable' , 'nonce' : '<?php echo wp_create_nonce("option_theme_designer_enable");?>' };
	nonces['option_theme_designer_reset']				= { 'naction' : 'option_theme_designer_reset' , 'nonce' : '<?php echo wp_create_nonce("option_theme_designer_reset");?>' };
	nonces['option_get_page_theme_config']				= { 'naction' : 'option_get_page_theme_config' , 'nonce' : '<?php echo wp_create_nonce("option_get_page_theme_config");?>' };
	nonces['option_get_themes_page']					= { 'naction' : 'option_get_themes_page' , 'nonce' : '<?php echo wp_create_nonce("option_get_themes_page");?>' };
	nonces['option_get_themes_site']					= { 'naction' : 'option_get_themes_site' , 'nonce' : '<?php echo wp_create_nonce("option_get_themes_site");?>' };
	nonces['option_permalink_enable_flush_rewrite']		= { 'naction' : 'option_permalink_enable_flush_rewrite' , 'nonce' : '<?php echo wp_create_nonce("option_permalink_enable_flush_rewrite");?>' };
	nonces['option_ibe_url']			        		= { 'naction' : 'option_ibe_url' , 'nonce' : '<?php echo wp_create_nonce("option_ibe_url");?>' };
	nonces['option_ibe_token']			        		= { 'naction' : 'option_ibe_token' , 'nonce' : '<?php echo wp_create_nonce("option_ibe_token");?>' };
	nonces['option_ibe_url_reset_schedule']			    = { 'naction' : 'option_ibe_url_reset_schedule' , 'nonce' : '<?php echo wp_create_nonce("option_ibe_url_reset_schedule");?>' };
	
	/* Set admin paths */
	admin_paths['option_export'] 						= '<?php echo get_template_directory_uri();?>'


</script>

