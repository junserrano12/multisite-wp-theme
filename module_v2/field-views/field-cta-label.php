<?php
extract( $viewData );

$value = ( dwh_empty( $value ) ) ? $value : false;

/* initialize variables */
$cta_button             = '';
$cta_link               = '';
$cta_modify_cancel      = '';
$cta_calendar_arrival   = '';
$cta_calendar_departure = '';
$cta_promocode          = '';
$cta_select_option      = '';

if( !$value ) {
    $value = array( "cta_button"                => "",
                    "cta_link"                  => "",
                    "cta_modify_cancel"         => "",
                    "cta_calendar_arrival"      => "",
                    "cta_calendar_departure"    => "",
                    "cta_promocode"             => "",
                    "cta_select_option"         => ""
                );
}
/* override initialized variables */
extract( $value ); 

?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container-cta-label field-content-container<?php echo $accordioncontent; ?>">
        <div class="row">
            <div class="field-item col-half">
                <label for="<?php echo $id; ?>-cta-button">Primary Button</label>
                <input type="text" id="<?php echo $id; ?>-cta-button" placeholder="Check Availability and Prices" name="<?php echo $name; ?>[cta_button]" class="field-input placeholder-cta-label" value="<?php echo $cta_button; ?>">
                <p class="description">Label for main CTA button</p>
            </div>
            <div class="field-item col-half">
                <label for="<?php echo $id; ?>-cta-link">Redundant Text Link</label>
                <input type="text" id="<?php echo $id; ?>-cta-link"  placeholder="Check Availability and Prices" name="<?php echo $name; ?>[cta_link]" class="field-input placeholder-cta-label" value="<?php echo $cta_link; ?>">
                <p class="description">Label for text link below main content</p>
            </div>

            <div class="field-item col-half">
                <label for="<?php echo $id; ?>-cta-modify-cancel">Modify and Cancel Link</label>
                <input type="text" id="<?php echo $id; ?>-cta-modify-cancel"  placeholder="Modify or Cancel" name="<?php echo $name; ?>[cta_modify_cancel]" class="field-input placeholder-cta-label" value="<?php echo $cta_modify_cancel; ?>">
                <p class="description">Label for modify/cancel text link</p>
            </div>
            <div class="field-item col-half">
                <label for="<?php echo $id; ?>-cta-calendar-arrival">Calendar Label - Arrival</label>
                <input type="text" id="<?php echo $id; ?>-cta-calendar-arrival" placeholder="Check In" name="<?php echo $name; ?>[cta_calendar_arrival]" class="field-input placeholder-cta-label" value="<?php echo $cta_calendar_arrival; ?>">
                <p class="description">Label for calendar arrival</p>
            </div>

            <div class="field-item col-half">
                <label for="<?php echo $id; ?>-cta-calendar-departure">Calendar Label - Departure</label>
                <input type="text" id="<?php echo $id; ?>-cta-calendar-departure" placeholder="Check Out" name="<?php echo $name; ?>[cta_calendar_departure]" class="field-input placeholder-cta-label" value="<?php echo $cta_calendar_departure; ?>">
                <p class="description">Label for calendar departure</p>
            </div>
            <div class="field-item col-half">
                <label for="<?php echo $id; ?>-cta-promocode">Promocode Label</label>
                <input type="text" id="<?php echo $id; ?>-cta-promocode" placeholder="Promo Code" name="<?php echo $name; ?>[cta_promocode]" class="field-input placeholder-cta-label" value="<?php echo $cta_promocode; ?>">
                <p class="description">Label for promocode</p>
            </div>

            <div class="field-item col-half">
                <label for="<?php echo $id; ?>-cta-select-option">Default Option for Select</label>
                <input type="text" id="<?php echo $id; ?>-cta-select-option" placeholder="Choose a Property" name="<?php echo $name; ?>[cta_select_option]" class="field-input placeholder-cta-label" value="<?php echo $cta_select_option; ?>">
                <p class="description">Default option for Select tag of Corporate Hotels</p>
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