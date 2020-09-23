<?php
extract( $viewData );
$value = ( dwh_empty( $value ) ) ? $value : false;
if( !$value ) {
    $value          = array(
                        "slider"                 => "flexslider",
                        "mode"                   => "page",
                        "type"                   => "default",
                        "thumbnailsize"          => 'small-thumbnail-image'
                    );
}

$sliders            = array(
                        'flexslider'             => 'Flex Slider',
                        'nivoslider'             => 'Nivo Slider'
                    );

$slider_view        = array(
                        'page'                   => 'Page',
                        'global'                 => 'Global'
                    );

$slider_type        = array(
                        'default'                => 'none',
                        'bullet'                 => 'Bullet',
                        'thumbnail'              => 'Thumbnail'
                    );

$thumbnail_size     = array(
                        'large-thumbnail-image'  => 'Large (300 x Auto)',
                        'medium-thumbnail-image' => 'medium (150 x Auto)',
                        'small-thumbnail-image'  => 'small (40 x 40) crop'
                    );

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
            <div class="field-item">
                <label for="<?php echo $id; ?>-slider">Slider</label>
                <select id="<?php echo $id; ?>-slider" name="<?php echo $name; ?>[slider]" class="field-input slider-data-field-input-slider" >
                <?php foreach( $sliders as $slider_key => $slider_value ) { ?>
                <?php $selected  = ( $slider_key === $slider ) ? ' selected' : null; ?>
                <option value="<?php echo $slider_key; ?>"<?php echo $selected; ?>><?php echo $slider_value; ?></option>
                <?php } ?>
                </select>
                <p class="description">Select Slider</p>
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-type">Slider Mode</label>
                <select id="<?php echo $id; ?>-type" name="<?php echo $name; ?>[type]" class="field-input slider-type-select" data-container-id="<?php echo $id; ?>" >
                <?php foreach( $slider_type as $slider_type_key => $slider_type_value ) { ?>
                <?php $selected  = ( $slider_type_key === $type ) ? ' selected' : null; ?>
                <option value="<?php echo $slider_type_key; ?>"<?php echo $selected; ?>><?php echo $slider_type_value; ?></option>
                <?php } ?>
                </select>
                <p class="description">Select Slider Mode</p>
            </div>
            <div class="field-item slider-type-<?php echo $id; ?>-hide thumbnail-slider-type-<?php echo $id; ?>-selected" style="display:<?php echo ( $type == 'thumbnail' ) ? 'block' : 'none'; ?>">
                <label for="<?php echo $id; ?>-thumbnail">Slider Thumbnail</label>
                <select id="<?php echo $id; ?>-thumbnail" name="<?php echo $name; ?>[thumbnailsize]" class="field-input" >
                <?php foreach( $thumbnail_size as $slider_thumb_key => $slider_thumb_value ) { ?>
                <?php $selected  = ( $slider_thumb_key === $thumbnailsize ) ? ' selected' : null; ?>
                <option value="<?php echo $slider_thumb_key; ?>"<?php echo $selected; ?>><?php echo $slider_thumb_value; ?></option>
                <?php } ?>
                </select>
                <p class="description">Select Thumbnail Size</p>
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