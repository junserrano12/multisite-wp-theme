<?php 
/*
Display Hotel Branches
*/
extract($data);
?>
<div class="control-wrapper cta-calendar-container">
	<div class="calendar-select">
		<select id="select-hotel" class="text_reserve">
			<option value="select"><?php echo 'Choose a Property'; ?></option>
			<?php foreach ($hotel_branches as $key => $hotel_branch_info):?>
				<?php if( !empty( $hotel_branch_info) ):?>
				<option value="<?php echo trim($hotel_branch_info['hotel_id'], "\r");?>"> <?php echo trim($hotel_branch_info['hotel_name'], "\r");?></option>
				<?php endif;?>
			<?php endforeach;?>
		</select>
	</div>
</div>