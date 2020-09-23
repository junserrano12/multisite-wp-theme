<?php
global $wpdb;
extract( $viewData );

$value = isset( $value ) ? $value : $default_value;

if ( !$value ) {
    $value = array(
                    "type" => "internal",
                    "internal_name" => "",
                    "external_name" => "",
                    "external_tag"  => ""
                );
}

$config_fonts  = dwh_get_config( 'config.fonts', 'json', array( 'fonts_v2', 'config' ) );

$font_types    = array(
                    'internal' => "Internal Font",
                    'external' => "External Font"
                );

extract( $value );


$internalFont = $wpdb->get_results("SELECT font_id, font_title, hotel_ids FROM dwh_fonts WHERE type = 'internal'");
$internalFontArr = array();
$hotel_type = dwh_get_data( 'type', 'onetheme_hotel_options' );
$site_hid_array = array();
if($hotel_type == 'single'){
	$hid = dwh_get_data( 'hotel-single', 'onetheme_hotel_options' );
	$site_hid_array[] = $hid['hotel_id'];
}else{
	$hid = dwh_get_data( 'hotel-group', 'onetheme_hotel_options' );
	for($a=0; $a<=count($hid); $a++){
		$site_hid_array[] = $hid[$a]['hotel_id'];
	}
}
if(is_array($internalFont) && count($internalFont) > 0){
	foreach( $internalFont as $i ){
		$font_tile = $i->font_title;
		$hotel_ids = $i->hotel_ids;
		$font      = preg_replace("/\s+/", "-", $font_tile);
		$font_directory = ABSPATH.'wp-content/uploads/fonts';
		$directory   = $font_directory.'/'.$font;

		$hotel_ids_arr = ($hotel_ids == NULL || $hotel_ids == '') ? array() : explode(',',$hotel_ids);

		if(is_dir($directory)){ /* check if exists in the font upload directory */
			if(count($hotel_ids_arr) == 0 || count(array_intersect($hotel_ids_arr, $site_hid_array)) != 0){
				$internalFontArr[$font] = $font_tile;
			}
		}
	}
}
$selected_fonts  = get_option( 'onetheme_customizer_options');
$selected_fonts  = $selected_fonts['fonts'];


?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if ( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container-fonts field-content-container<?php echo $accordioncontent; ?>">
        <div class="row">
            <div class="field-item">
                <label for="<?php echo $id; ?>-type">Type of Font</label>
                <select id="<?php echo $id; ?>-type" name="<?php echo $name; ?>[type]" class="field-input font-select" data-container-id="<?php echo $id; ?>">
                    <?php foreach ( $font_types as $key => $val ) { ?>
                    <?php $selected  = ( $key === $type ) ? ' selected' : null; ?>
                    <option value="<?php echo $key; ?>"<?php echo $selected; ?>><?php echo $val; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row font-<?php echo $id; ?>-hide internal-font-<?php echo $id; ?>-selected font-internal-container" style="display:<?php echo ( $type == 'internal' ) ? 'block' : 'none'; ?>">
            <div class="field-item">
                <label for="<?php echo $id; ?>-internal-name">Internal Font Name</label>
                <select id="<?php echo $id; ?>-internal-name" class="field-input" name="<?php echo $name; ?>[internal_name]">
			     	<?php
					if ( count( $internalFontArr ) > 0 ) {
						foreach ( $internalFontArr as $folder => $fontTitle ) {
							$selectedIndex = preg_replace( "/[^0-9]/", "", $id );
							$selectedValue = $selected_fonts[$selectedIndex]['internal_name'];
							$selected      = $selectedValue == $folder ? 'selected' : '';
							echo '<option value="'.$folder.'" '.$selected.'>'.$fontTitle.'</option>';
						}
					}
					?>
                </select>
            </div>
        </div>

        <div class="row font-<?php echo $id; ?>-hide external-font-<?php echo $id; ?>-selected" style="display:<?php echo ( $type == 'external' ) ? 'block' : 'none'; ?>">
            <div class="field-item">
                <label for="<?php echo $id; ?>-external-name">External Font Name</label>
                <input type="text" id="<?php echo $id; ?>-external-name" name="<?php echo $name; ?>[external_name]" class="field-input" value="<?php echo $external_name; ?>">
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-external-tag">External Font Tag</label>
                <input type="text" id="<?php echo $id; ?>-external-tag" name="<?php echo $name; ?>[external_tag]" class="field-input" value="<?php echo esc_html( $external_tag ); ?>">
            </div>
        </div>

        <?php if ( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>
