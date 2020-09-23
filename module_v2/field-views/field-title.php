<?php
extract( $viewData );
$label = ( $value ) ? $value : $label;
?>
<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container tab-repeater-title-container">
        <a href="<?php echo '#'.$id; ?>" class="field-title title"><?php echo $label; ?></a>
    </div>
</div>