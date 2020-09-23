<?php
extract( $viewData );

$value = isset( $value ) ? $value : (array)$default_value;

extract( $value );

$label      = ( $hotel_name ) ? $hotel_name : $label;
$languages  = array(
                    "English"   => "en",
                    "Arabic"    => "ar",
                    "Japanese"  => "ja",
                    "Korean"    => "ko",
                    "Spanish"   => "es",
                    "Thai"      => "th",
                    "Bahasa"    => "id",
                    "Chinese"   => "zh",
                    );
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
                <label class="field-label">Hotel ID</label>
                <input type="text" id="<?php echo $id; ?>-hotel-id" class="field-input hotel-id" name="<?php echo $name; ?>[hotel_id]" value="<?php echo esc_html( $hotel_id ); ?>" placeholder="3092"/>
            </div>
            <div class="field-item">
                <label class="field-label">Hotel Name</label>
                <input type="text" id="<?php echo $id; ?>-hotel-name" class="field-input hotel-name placeholder-title" name="<?php echo $name; ?>[hotel_name]" value="<?php echo esc_html( $hotel_name ); ?>" placeholder="Zeus Palace Hotel"/>
            </div>
            <div class="field-item">
                <label class="field-label">Hotel Location</label>
                <input type="text" id="<?php echo $id; ?>-hotel-location" class="field-input hotel-location" name="<?php echo $name; ?>[hotel_location]" value="<?php echo esc_html( $hotel_location ); ?>" placeholder="Santorini, Greece"/>
            </div>
            <div class="field-item">
                <label class="field-label">Hotel Language</label>
                <select type="text" id="<?php echo $id; ?>-hotel-language" class="field-input hotel-language" name="<?php echo $name; ?>[hotel_language]">
                    <?php foreach( $languages as $key => $value ) { ?>
                    <?php $selected  = ( $value === $hotel_language ) ? ' selected' : null; ?>
                    <option value="<?php echo $value; ?>"<?php echo $selected; ?>><?php echo $key; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="field-item">
                <label class="field-label">IBE Subdomain</label>
                <input type="text" id="<?php echo $id; ?>-hotel-subdomain" class="field-input field-hotel-sync-subdomain readonly-toggle" name="<?php echo $name; ?>[hotel_subdomain]" value="<?php echo esc_html( $hotel_subdomain ); ?>" placeholder="https://reservation.directwithhotels.com" readonly/>
            </div>
        </div>

        <?php if ( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>