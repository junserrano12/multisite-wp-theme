<?php
extract( $viewData );
extract( $value );

$street1 = dwh_empty( $street1 ) && isset ( $street1 ) ? $street1 : '';
$street2 = dwh_empty( $street2 ) && isset ( $street2 ) ? $street2 : '';
$city    = dwh_empty( $city ) && isset ( $city ) ? $city : '';
$state   = dwh_empty( $state ) && isset ( $state ) ? $state : '';
$country = dwh_empty( $country ) && isset ( $country ) ? $country : '';
$zipcode = dwh_empty( $zipcode ) && isset ( $zipcode ) ? $zipcode : '';

?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if ( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container<?php echo $accordioncontent; ?>">
        <div class="row">
            <div class="field-item">
                <label class="field-label">Street 1</label>
                <input type="text" class="field-input" name="<?php echo $name; ?>[street1]" value="<?php echo esc_html( $street1 ); ?>" placeholder="Street 1"/>
            </div>
            <div class="field-item">
                <label class="field-label">Street 2</label>
                <input type="text" class="field-input" name="<?php echo $name; ?>[street2]" value="<?php echo esc_html( $street2 ); ?>" placeholder="Street 2"/>
            </div>
            <div class="field-item col-half">
                <label class="field-label">City/Town</label>
                <input type="text" class="field-input" name="<?php echo $name; ?>[city]" value="<?php echo esc_html( $city ); ?>" placeholder="City"/>
            </div>
            <div class="field-item col-half">
                <label class="field-label">State</label>
                <input type="text" class="field-input" name="<?php echo $name; ?>[state]" value="<?php echo esc_html( $state ); ?>" placeholder="State"/>
            </div>
            <div class="field-item col-half">
                <label class="field-label">Country</label>
                <input type="text" class="field-input" name="<?php echo $name; ?>[country]" value="<?php echo esc_html( $country ); ?>" placeholder="Country"/>
            </div>
            <div class="field-item col-half">
                <label class="field-label">Zip Code / Postal Code</label>
                <input type="text" class="field-input" name="<?php echo $name; ?>[zipcode]" value="<?php echo esc_html( $zipcode ); ?>" placeholder="0000"/>
            </div>
        </div>
        <?php if ( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>