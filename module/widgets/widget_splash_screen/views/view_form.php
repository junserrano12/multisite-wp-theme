<?php
extract($data);
extract($instance);
?>
<label for="<?php echo $field_ids['title']['id']; ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $field_ids['title']['id']; ?>" name="<?php echo $field_ids['title']['name']; ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

<label for="<?php echo $field_ids['content']['id']; ?>"><?php _e( 'Content:' ); ?></label> 
<textarea class="textarea-editor widefat" rows="5" id="<?php echo $field_ids['content']['id']; ?>" name="<?php echo $field_ids['content']['name']; ?>"><?php echo $content; ?></textarea>
<a href="#<?php echo $field_ids['content']['id']; ?>" class="button button-upload-media-item">Add/Upload Media</a>
<br><br>
<div>
	<label for="<?php echo $field_ids['disable']['id']; ?>"><?php _e( 'Disable?' ); ?>
		<input class="widefat widget-splash-checkbox" type="checkbox" id="<?php echo $field_ids['disable']['id']; ?>" name="<?php echo $field_ids['disable']['name']; ?>" value="<?php echo esc_attr( $disable ); ?>" 
		<?php
			if($disable == 'yes') echo 'checked="checked"';
		?>
		>
	</label> 
</div>
<div>
	<label for="<?php echo $field_ids['show_only_once']['id']; ?>"><?php _e( 'Show only once?' ); ?>
		<input class="widefat widget-splash-checkbox" type="checkbox" id="<?php echo $field_ids['show_only_once']['id']; ?>" name="<?php echo $field_ids['show_only_once']['name']; ?>" value="<?php echo esc_attr( $show_only_once ); ?>" 
		<?php
			if($show_only_once == 'yes') echo 'checked="checked"';
		?>
		>
	</label> 
</div>
<div>
	<label for="<?php echo $field_ids['show_inner_pages']['id']; ?>"><?php _e( 'Show on inner pages?' ); ?>
		<input class="widefat widget-splash-checkbox" type="checkbox" id="<?php echo $field_ids['show_inner_pages']['id']; ?>" name="<?php echo $field_ids['show_inner_pages']['name']; ?>" value="<?php echo esc_attr( $show_inner_pages ); ?>" 
		<?php
			if($show_inner_pages == 'yes') echo 'checked="checked"';
		?>
		>
	</label> 
</div>
<br>
<script>
	jQuery(document).ready(function(){
		var _this = jQuery('.widget-splash-checkbox');
		_this.click(function(){
			if(_this.is(':checked')){
				_this.attr('value', 'yes');
			}
			else{
				_this.attr('value', 'no');
			}
		});	
		
	});
</script>