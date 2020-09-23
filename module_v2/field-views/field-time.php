<?php extract( $viewData ); ?>
<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if ( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container<?php $accordioncontent; ?>">
        <input id="<?php echo $id; ?>" name="<?php echo $name; ?>" type="time" class="field-input<?php echo $inputclass; ?>" value="<?php echo esc_html( $value ); ?>" />
        <?php if ( $description ) { ?>
        <p class="description"><?php echo $description; ?></p>
        <?php } ?>
        <?php if ( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>