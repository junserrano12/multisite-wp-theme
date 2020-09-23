<?php
extract( $viewData );
$value = ( dwh_empty( $value ) ) ? $value : false;
if( !$value ) {
    $value  = array(
                    "slider_key"   => "",
                    "slider_value" => ""
                );
}

extract( $value );

?>
<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container-slider-data field-content-container<?php echo $accordioncontent; ?>">
        <div class="row">
            <div class="field-item col-half">
                <label for="<?php echo $id; ?>-slider-key">Slider Attribute Key:</label>
                <input type="text" id="<?php echo $id; ?>-slider-key" name="<?php echo $name; ?>[slider_key]" class="field-input slider-attribute-field-input-slider-key" value="<?php echo $slider_key; ?>">
                <p class="description">set attribute key</p>
            </div>
            <div class="field-item col-half">
                <label for="<?php echo $id; ?>-slider-value">Slider Attribute Value:</label>
                <input type="text" id="<?php echo $id; ?>-slider-value" name="<?php echo $name; ?>[slider_value]" class="field-input" value="<?php echo $slider_value; ?>">
                <p class="description">set attribute value</p>
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