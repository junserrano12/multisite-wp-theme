<?php
	/* 
	* when $data['customfields'] is being extracted,
	* ff. main array holder below
	* $slider_settings - holds the slider settings config
	* $slider_items - holds the slider item config
	* $slider_data - holds the slider data
	*/
	extract( $data['customfields'] );
	extract( $slider_settings );
?>

<div class="box">
	
	<h4> <?php echo $field_data['details']['name']; ?> </h4>
	<?php
		if( $field_settings['details']['description'] ){
	?>
			<p class="description"><?php echo $field_data['details']['description']; ?></p>
	<?php	
		}
	?>
	<input type="hidden" name="slider-data-type" value="<?php echo $field_data['details']['data-type'];  ?>">
	
	
	<?php
		if( $field_settings['settings'] ){
		
			foreach( $field_settings['settings'] as $key => $val ){
				
				$properties = $val['properties'];
	?>
		
				<div class="control-wrapper">
					<label for="slider-mode"><?php echo $properties['field_title']; ?></label> 
					<select id="slider-mode" name="<?php echo $key; ?>[]">
						
						<?php
							if( isset( $field_data[ $key ] ) ){
								foreach( $field_data[ $key ] as $key1 => $val1 ){
									
									$selected = $slider_data[ $key ][0] == $val1['value'] ? 'selected="selected"' : '';
						?>
									<option value="<?php echo $val1['value']; ?>" <?php echo $selected; ?>><?php echo $val1['name']; ?></option>
						<?php
								}
							}
						?>
						
					</select>
					<p class="description"><?php echo $properties['field_description']; ?></p>
				</div>
				<br>
	
	<?php
			}
		}
	?>
	
</div>