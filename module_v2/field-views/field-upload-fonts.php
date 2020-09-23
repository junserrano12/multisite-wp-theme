<?php
extract( $viewData );
$value = isset( $value ) ? $value : $default_value;
add_thickbox();
?>
<div class="button-container margin-bottom">
    <a href="#TB_inline?width=600&inlineId=upload-font-container" class="thickbox button">Upload Web Font</a>
</div>

<div id="upload-font-container" style="display:none;">

    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>

    <div class="field-content-container-upload-fonts field-content-container<?php echo $accordioncontent; ?>">

        <div class="row">

            <div class="field-item">
                <label for="<?php echo $id; ?>-font-title" >Font Title</label>
                <input type="text" id="<?php echo $id; ?>-font-title" class="font-title field-input<?php echo $inputclass; ?>" name="" value="" />
            </div>

            <div class="field-item">
				<?php
					/* retrieve the current hotel id/s */
					$hotel_id = dwh_hotel_id();
					$hotel_id = is_array($hotel_id) && count($hotel_id) > 0 ? implode(',',$hotel_id) : '';
				?>
                <label for="<?php echo $id; ?>-hotel-ids" >Hotel IDs (seperated by comma, leave empty if font is to be used by all hotel website)</label>
                <input type="text" id="<?php echo $id; ?>-hotel-ids" class="hotel-ids field-input<?php echo $inputclass; ?>" name="" value="<?php echo $hotel_id; ?>" />
            </div>

            <div class="field-item">
                <input type="file" class="files-data form-control field-input<?php echo $inputclass; ?>" multiple />
                <input type="hidden" name="security-nonce" class="security-nonce" value="<?php echo wp_create_nonce('dwh-upload-fonts'); ?>" />
            </div>

            <div class="controller-container">
                <a href="#?" data-id="<?php echo $id; ?>" class="button button-upload font-upload-controller">Upload Font Files</a>
            </div>
        </div>

        <?php if( $description ) { ?>
        <p class="description"><?php echo $description; ?></p>
        <?php } ?>
        <?php if( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>

</div>
