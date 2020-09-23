	<?php
		global $DWH_Admin;
		wp_nonce_field( 'load_custom_fields_view_specific', 'load_custom_fields_view_specific_nonce' );
	?>

	<div class="box">
		<h4>Copy Custom Fields</h4>
		<div class="control-wrapper">
			<label for="title_field">H1</label>
			<input type="text" id="title_field" name="title_field" value="<?php echo esc_attr( $data['customfields']['title_field'] ); ?>" style="width:100%" />
			<p class="description">Alternative H1</p>	
		</div>
		<div class="control-wrapper">
			<?php 
				$checked = $data['customfields']['address_field'] ? 'checked="checked"' : '';
			?>
			<input type="checkbox" id="chk_address_field_display_flag" class="checkbox" name="chk_address_field_display_flag" value="<?php echo esc_attr($data['customfields']['address_field']); ?>" <?php echo $checked; ?>/>
			<input type="hidden" id="address_field_display_flag" name="address_field" value="<?php echo esc_attr( $data['customfields']['address_field'] ); ?>">
			<label for="chk_address_field_display_flag">Address</label>
			<p class="description">Display After H1 Address</p>	
		</div>
	</div>

	<?php if( !$DWH_Admin->is_restricted( DWH_USER_ROLE , 'metaboxes' , 'fieldsets' , 'seo' , 'lookup' ) ): ?>
	<div class="box">
		<h4>SEO Custom Fields</h4>	
		<div class="control-wrapper">
			<label for="page_title_field">Meta Title</label>
			<input type="text" id="page_title_field" name="page_title_field" value="<?php echo esc_attr( $data['customfields']['page_title_field'] ); ?>" style="width:100%" />
			<p class="description">Display Meta title</p>	  
		</div>
		<div class="control-wrapper">
			<label for="meta_keywords">Meta Keywords</label>
			<input type="text" id="meta_keywords" name="meta_keywords" value="<?php echo esc_attr( $data['customfields']['meta_keywords'] ); ?>" style="width:100%" />
			<p class="description">Display Meta keywords</p>  
		</div>
		<div class="control-wrapper">
			<label for="meta_description">Meta Description</label>
			<input type="text" id="meta_description" name="meta_description" value="<?php echo esc_attr( $data['customfields']['meta_description'] ); ?>" style="width:100%" />  
			<p class="description">Display Meta Description</p>	
		</div>
		<div class="control-wrapper">
			<label for="meta_robots">Meta Robots</label>
			<input type="text" id="meta_robots" name="meta_robots" value="<?php echo esc_attr( $data['customfields']['meta_robots'] ); ?>" style="width:100%" />  
			<p class="description">Page specific meta robots (e.g. noindex,follow)</p>	
		</div>
	</div> 
	<?php endif; ?>

	<?php if( !$DWH_Admin->is_restricted( DWH_USER_ROLE , 'metaboxes' , 'fieldsets' , 'cta' , 'lookup' ) ): ?>
	<div class="box">
		<h4>Page Custom Fields</h4>	
		<div class="control-wrapper">
			<?php $h1checked = $data['customfields']['h1_display_flag'] ? 'checked="checked"' : '';	?>
			<input type="checkbox" id="chk_h1_display_flag" class="checkbox" value="<?php echo esc_attr($data['customfields']['h1_display_flag']); ?>" <?php echo $h1checked; ?>/>
			<input type="hidden" id="h1_display_flag" name="h1_display_flag" value="<?php echo esc_attr($data['customfields']['h1_display_flag']); ?>">
			<label for="chk_h1_display_flag">Hide H1 Title</label>
		</div>
		<div class="control-wrapper">
			<?php $ctachecked = $data['customfields']['cta_display_flag'] ? 'checked="checked"' : ''; ?>
			<input type="checkbox" id="chk_cta_display_flag" class="checkbox" value="<?php echo esc_attr($data['customfields']['cta_display_flag']); ?>" <?php echo $ctachecked; ?>/>
			<input type="hidden" id="cta_display_flag" name="cta_display_flag" value="<?php echo esc_attr( $data['customfields']['cta_display_flag'] ); ?>">
			<label for="chk_cta_display_flag">Hide CTA Link Footer</label>
		</div>
	</div> 
	<?php endif; ?>

	<?php
		/* Display Page theme list */
		$data['dir'] = array('module','collections/views','settings','page_themes_list');
		$data['view'] = 'page_themes_list';
		load_view( $data );
	?>