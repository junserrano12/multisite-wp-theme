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
        <div class="field-radio-select">
        <?php
        if ( is_array( $field->value ) ) {

            $options    = isset( $field->value ) ? $field->value : null;
            $value      = !is_array( $value ) ? $value : $options[0][0];

            if ( dwh_empty( $options ) ) {

                foreach ( $options as $ctr => $option ) {
                    $rbivalue          = isset( $option[0] ) ? $option[0] : null;
                    $rbilabel          = isset( $option[1] ) ? $option[1] : null;
                    $rbidescription    = isset( $option[2] ) ? $option[2] : null;
                    $selected          = ( $value === $rbivalue ) ? ' checked' : null;
                    ?>
                    <div class="field-radio-item">
                        <input id="<?php echo $id.'-'.$ctr; ?>" name="<?php echo $name; ?>" class="field-input<?php echo $inputclass; ?>" type="radio" value="<?php echo $rbivalue; ?>"<?php echo $selected; ?>>
                        <label for="<?php echo $id.'-'.$ctr; ?>"><?php echo $rbilabel; ?></label>
                        <p class="radio-item-description description"><?php echo $rbidescription; ?></p>
                    </div>
                    <?php
                }

            }

        } else {
            /* ADVANCE */
            if( function_exists( $field->value ) ) {
                call_user_func( $field->value );
            }
        }
        ?>
        </div>
        <?php if ( $description ) { ?>
        <p class="description"><?php echo $description; ?></p>
        <?php } ?>
        <?php if ( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>