<?php
extract( $viewData );
$value = isset( $value ) ? $value : $default_value;
?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if ( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container<?php echo $accordioncontent; ?>">
        <select id="<?php echo $id; ?>" name="<?php echo $name; ?>" class="field-input<?php echo $inputclass; ?>">
            <?php
            if ( is_array( $options ) ) {
                foreach ( $options as $option ) {
                    $selected  = ( $value === $option[0] ) ? ' selected' : null;
                    ?><option value="<?php echo $option[0]; ?>"<?php echo $selected; ?>><?php echo $option[1]; ?></option><?php
                }
            } else {
                /* ADVANCE */
                if( function_exists( $value ) ) {
                    call_user_func( $value );
                }
            }
            ?>
        </select>
        <?php if ( $description ) { ?>
        <p class="description"><?php echo $description; ?></p>
        <?php } ?>
        <?php if ( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>