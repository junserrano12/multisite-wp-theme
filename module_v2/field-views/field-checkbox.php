<?php
extract( $viewData );
$value   = isset( $value ) ? (int)$value : false;
$checked = ( $value ) ? ' checked' : '';
?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if ( $altlabel ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $altlabel; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container checkbox-field-container<?php echo $accordioncontent; ?>">
        <input id="<?php echo $id; ?>" name="<?php echo $name; ?>" type="hidden" value="<?php echo $value; ?>"/>
        <input id="<?php echo $id; ?>-controller" type="checkbox" class="field-input<?php echo $inputclass; ?>" onchange="_this = jQuery( this ); if( _this.is(':checked') ) { _this.attr('checked', true); _this.prev().val('1') } else { _this.prev().val('0'); _this.attr('checked', false ); }"<?php echo $checked; ?>/>
        <?php if ( $label ) { ?>
        <label for="<?php echo $id; ?>-controller" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
        <?php if ( strpos( $inputclass, 'checkbox-switch' ) ) { ?>
        <p class="label"><?php echo $label; ?></p>
		<?php } ?>
        <?php if ( $description ) { ?>
        <p class="description"><?php echo $description; ?></p>
        <?php } ?>
        <?php if ( $removeitem ) { ?>
            <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>