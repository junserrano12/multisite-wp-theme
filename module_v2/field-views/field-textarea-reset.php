<?php
extract( $viewData );
$value           = dwh_empty( $value ) ? $value : $default_value;
$data_attributes = '';

if ( isset( $data ) && dwh_empty( $data ) ) {
    foreach ( $data as $data_key => $data_value ) {
        $data_attributes .= ' data-'.$data_key.'="'.$data_value.'"';
    }

    if ( dwh_get_theme_template() === 'v2' || strpos( $id, 'above-the-fold-css' ) ) {
        $value = isset( $value ) && dwh_empty( $value ) ? $value : dwh_get_file_content( $data, true );
    }
}

?>
<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if ( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container<?php echo $accordioncontent; ?>">
        <?php if ( $mediabutton ) { ?>
        <a class="button button-upload button-secondary media-upload-button" href="#<?php echo $id; ?>">Upload and Insert Media</a>
        <?php } ?>
        <textarea rows="<?php echo $rows; ?>" id="<?php echo $id; ?>" name="<?php echo $name; ?>" class="field-input<?php echo $inputclass; ?>"><?php echo esc_html( $value ); ?></textarea>
        <?php if ( $description ) { ?>
        <p class="description"><?php echo $description; ?></p>
        <?php } ?>
        <?php if ( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
        <?php if ( $resetitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="reset-item link" data-id="<?php echo $id; ?>" data-label="<?php echo $label; ?>">Reset <?php echo $label; ?></a>
        <?php } ?>
        <?php if ( $data_attributes ) { ?>
        <input type="hidden" class="<?php echo $id; ?>-data"<?php echo $data_attributes; ?>/>
        <?php } ?>
    </div>
</div>