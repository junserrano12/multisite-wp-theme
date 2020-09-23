<?php
extract( $viewData );
$value = ( dwh_empty( $value ) ) ? $value : false;

if ( !$value ) {
    $value = array(
                    "attribute"     => "",
                    "element"       => "",
                    "selector"      => "",
                    "command"       => "",
                    "hitType"       => "",
                    "eventCategory" => "",
                    "eventAction"   => "",
                    "eventLabel"    => "",
                    "eventValue"    => ""
                );
}

extract( $value );

$label = ( $selector ) ? $selector : $label;

?>
<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if ( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container-tracker-parameter field-content-container<?php echo $accordioncontent; ?>">
        <label class="sub-field-title-container">Selector</label>
        <div class="row">
            <div class="field-item">
                <label for="<?php echo $id; ?>-selector" class="field-title">Class or ID name</label>
                <input id="<?php echo $id; ?>-selector" placeholder="e.g. promo-banner" name="<?php echo $name; ?>[selector]" type="text" class="placeholder-title field-input<?php echo $inputclass; ?>" value="<?php echo $selector; ?>" />
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-attribute" class="field-title">Attribute Type</label>
                <input id="<?php echo $id; ?>-attribute" placeholder="e.g. class or id" name="<?php echo $name; ?>[attribute]" type="text" class="field-input<?php echo $inputclass; ?>" value="<?php echo $attribute; ?>" />
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-element" class="field-title">Element Tag Type</label>
                <input id="<?php echo $id; ?>-element" placeholder="e.g. span, a, li, div etc..." name="<?php echo $name; ?>[element]" type="text" class="field-input<?php echo $inputclass; ?>" value="<?php echo $element; ?>" />
            </div>
        </div>

        <label class="sub-field-title-container">Google Analytics Parameter</label>
        <div class="row">
            <div class="field-item col-narrow">
                <label for="<?php echo $id; ?>-command" class="field-title">command</label>
                <input id="<?php echo $id; ?>-command" placeholder="e.g. send" name="<?php echo $name; ?>[command]" type="text" class="field-input<?php echo $inputclass; ?>" value="<?php echo $command; ?>" />
            </div>
            <div class="field-item col-narrow">
                <label for="<?php echo $id; ?>-hitType" class="field-title">hitType</label>
                <input id="<?php echo $id; ?>-hitType" placeholder="e.g. pageview" name="<?php echo $name; ?>[hitType]" type="text" class="field-input<?php echo $inputclass; ?>" value="<?php echo $hitType; ?>" />
            </div>
            <div class="field-item col-narrow">
                <label for="<?php echo $id; ?>-eventCategory" class="field-title">eventCategory</label>
                <input id="<?php echo $id; ?>-eventCategory" placeholder="e.g. banner" name="<?php echo $name; ?>[eventCategory]" type="text" class="field-input<?php echo $inputclass; ?>" value="<?php echo $eventCategory; ?>" />
            </div>
            <div class="field-item col-narrow">
                <label for="<?php echo $id; ?>-eventAction" class="field-title">eventAction</label>
                <input id="<?php echo $id; ?>-eventAction" placeholder="e.g. click" name="<?php echo $name; ?>[eventAction]" type="text" class="field-input<?php echo $inputclass; ?>" value="<?php echo $eventAction; ?>" />
            </div>
            <div class="field-item col-narrow">
                <label for="<?php echo $id; ?>-eventLabel" class="field-title">eventLabel</label>
                <input id="<?php echo $id; ?>-eventLabel" placeholder="e.g. summer promo" name="<?php echo $name; ?>[eventLabel]" type="text" class="field-input<?php echo $inputclass; ?>" value="<?php echo $eventLabel; ?>" />
            </div>
            <div class="field-item col-narrow">
                <label for="<?php echo $id; ?>-eventValue" class="field-title">eventValue</label>
                <input id="<?php echo $id; ?>-eventValue" placeholder="2" name="<?php echo $name; ?>[eventValue]" type="text" class="field-input<?php echo $inputclass; ?>" value="<?php echo $eventValue; ?>" />
            </div>
        </div>

        <?php if ( $description ) { ?>
        <p class="description"><?php echo $description; ?></p>
        <?php } ?>
        <?php if ( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>