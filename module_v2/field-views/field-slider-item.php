<?php
extract( $viewData );

$value = ( dwh_empty( $value ) ) ? $value : false;

if ( !$value ) {
    $value      = array(
                        'slider_output_type'     => 'slider',
                        'slider_id'              => null,
                        'slider_expire'          => '',
                        'slider_title'           => '',
                        'slider_alt'             => '',
                        'slider_caption'         => '',
                        'slider_class'           => '',
                        'slider_overlay_content' => '',
                        'slider_link'            => '',
                        'slider_inline_content'  => '',
                        'slider_rel'             => '',
                        'slider_colorbox'        => 'none',
                        'slider_iframe_src'      => '',
                        'slider_latitude'        => '',
                        'slider_longitude'       => '',
                        'slider_height'          => '420px',
                        'slider_width'           => '100%',
                        'slider_zoom'            => '16'
                    );
}

$slidercolorbox   = array(
                        'none' => 'None',
                        'colorbox' => 'Modal Image',
                        'colorbox-inline' => 'Modal with Inline Content'
                    );


$slideroutputtype   = array(
                        'slider' => 'Slider',
                        'map' => 'Map',
                        'iframe' => 'Iframe'
                    );

extract( $value );

$imageid = ( isset( $slider_id ) ) ? $slider_id : false;
$image   = ( $imageid ) ? wp_get_attachment_image_src( $imageid, 'thumbnail-full' ) : false;
$src     = ( $imageid ) ? wp_get_attachment_image_url( $imageid, 'thumbnail-full' ) : false;
$srcset  = ( $imageid ) ? wp_get_attachment_image_srcset( $imageid, 'thumbnail-full' ) : false;
$control = ( $imageid ) ? 'remove' : 'upload';

$slider_alt = isset( $slider_alt ) && dwh_empty( $slider_alt ) ? $slider_alt : $slider_title;

/* change value of lad data */
switch ( $slider_colorbox ) {
    case 'popup':
        $slider_colorbox = 'colorbox';
        break;
    case 'popupwithcontent':
        $slider_colorbox = 'colorbox-inline';
    default:
        $slider_colorbox = $slider_colorbox;
        break;
}

?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container-slider-item field-content-container<?php echo $accordioncontent; ?>">

        <div class="row">
            <div class="field-item">
                <label for="<?php echo $id; ?>-slider-output-type">Slider Output Type</label>
                <select id="<?php echo $id; ?>-slider-output-type" name="<?php echo $name; ?>[slider_output_type]" class="field-input slider-output-type-select" data-container-id="<?php echo $id; ?>">
                <?php foreach( $slideroutputtype as $slider_type_key => $slider_type_value ) { ?>
                <?php $selected  = ( $slider_type_key === $slider_output_type ) ? ' selected' : null; ?>
                <option value="<?php echo $slider_type_key; ?>"<?php echo $selected; ?>><?php echo $slider_type_value; ?></option>
                <?php } ?>
                </select>
                <p class="description">Select Output Type</p>
            </div>
        </div>

        <div class="row slider-output-type-<?php echo $id; ?>-hide slider-slider-output-type-<?php echo $id; ?>-selected" style="display:<?php echo ( $slider_output_type == 'slider' ) ? 'block' : 'none'; ?>;">

            <div class="field-item">
                <div class="preview-container">
                    <?php if( $src ) { ?>
                    <img class="preview-image" src="<?php echo $src; ?>" srcset="<?php echo $srcset; ?>" sizes="(max-width:<?php echo $image[1]; ?>px) 100vw, <?php echo $image[1]; ?>px" width="<?php echo $image[1]; ?>">
                    <?php } else { ?>
                    <div class="preview-image blank-image"></div>
                    <?php } ?>
                </div>
                <div class="attr-container">
                    <input type="hidden" class="image-id" name="<?php echo $name; ?>[slider_id]" value="<?php echo $slider_id; ?>"/>
                </div>
                <div class="controller-container">
                    <a href="#?" data-id="<?php echo $id; ?>" class="button button-<?php echo $control; ?> image-controller-link controller-<?php echo $control; ?>-image"><?php echo ucfirst( $control ); ?> image</a>
                </div>
            </div>

            <!-- control colorbox fields r2S-->
            <div class="field-item">
                <label for="<?php echo $id; ?>-slider-colorbox">Modal Option:</label>
                <select id="<?php echo $id; ?>-slider-colorbox" name="<?php echo $name; ?>[slider_colorbox]" class="field-input slider-colorbox-select" data-container-id="<?php echo $id; ?>">
                <?php foreach( $slidercolorbox as $slider_colorbox_key => $slider_colorbox_value ) { ?>
                <?php $selected  = ( $slider_colorbox_key === $slider_colorbox ) ? ' selected' : null; ?>
                <option value="<?php echo $slider_colorbox_key; ?>"<?php echo $selected; ?>><?php echo $slider_colorbox_value; ?></option>
                <?php } ?>
                </select>
                <p class="description">Select Output Type</p>
            </div>

            <!-- r1a r2a -->
            <div class="field-item slider-colorbox-<?php echo $id; ?>-hide colorbox-slider-colorbox-<?php echo $id; ?>-selected colorbox-inline-slider-colorbox-<?php echo $id; ?>-selected" style="display:<?php echo ( $slider_colorbox == 'colorbox' || $slider_colorbox == 'colorbox-inline' ) ? 'block' : 'none'; ?>;">
                <label for="<?php echo $id; ?>-slider-rel">Rel (group):</label>
                <input type="text" id="<?php echo $id; ?>-slider-rel" name="<?php echo $name; ?>[slider_rel]" class="field-input" value="<?php echo $slider_rel; ?>">
                <p class="description">This will group images with same rel value</p>
            </div>

            <!-- r1a r2b -->
            <div class="field-item slider-colorbox-<?php echo $id; ?>-hide colorbox-inline-slider-colorbox-<?php echo $id; ?>-selected" style="display:<?php echo ( $slider_colorbox == 'colorbox-inline' ) ? 'block' : 'none'; ?>;">
                <label for="<?php echo $id; ?>-slider-inline-content">Inline Modal Content:</label>
                <textarea id="<?php echo $id; ?>-slider-inline-content" name="<?php echo $name; ?>[slider_inline_content]" rows="5" class="field-input"><?php echo esc_html( $slider_inline_content ); ?></textarea>
                <p class="description">Content For Inline Modal Content</p>
            </div>

            <div class="field-item">
                <label for="<?php echo $id; ?>-slider-link">Custom Url:</label>
                <input type="text" id="<?php echo $id; ?>-slider-link" name="<?php echo $name; ?>[slider_link]" class="field-input" value="<?php echo $slider_link; ?>">
                <p class="description">Image will have anchor tag with custom link</p>
            </div>

            <div class="field-item">
                <label for="<?php echo $id; ?>-sldier-expire">Expiration:</label>
                <input type="date" id="<?php echo $id; ?>-slider-expire" name="<?php echo $name; ?>[slider_expire]" class="field-input" value="<?php echo $slider_expire; ?>">
                <p class="description">Set Expiration to hide Slider Image from that day onward</p>
            </div>

            <div class="field-item">
                <label for="<?php echo $id; ?>-slider-class">Class:</label>
                <input type="text" id="<?php echo $id; ?>-slider-class" name="<?php echo $name; ?>[slider_class]" class="field-input" value="<?php echo $slider_class; ?>">
                <p class="description">Add Class attribute to image</p>
            </div>

            <div class="field-item">
                <label for="<?php echo $id; ?>-slider-title">Title Tag:</label>
                <input type="text" id="<?php echo $id; ?>-slider-title" name="<?php echo $name; ?>[slider_title]" class="field-input" value="<?php echo $slider_title; ?>">
                <p class="description">Modify Title Tag of Image</p>
            </div>

            <div class="field-item">
                <label for="<?php echo $id; ?>-slider-alt">Alt Tag:</label>
                <input type="text" id="<?php echo $id; ?>-slider-alt" name="<?php echo $name; ?>[slider_alt]" class="field-input" value="<?php echo $slider_alt; ?>">
                <p class="description">Modify Alt Tag of Image</p>
            </div>

            <div class="field-item">
                <label for="<?php echo $id; ?>-slider-caption">Image Caption:</label>
                <textarea id="<?php echo $id; ?>-slider-caption" name="<?php echo $name; ?>[slider_caption]" rows="2" class="field-input"><?php echo esc_html( $slider_caption ); ?></textarea>
                <p class="description">Image Caption Placed after Slider Item (short text content)</p>
            </div>

            <div class="field-item">
                <label for="<?php echo $id; ?>-slider-overlay-content">Overlay Content:</label>
                <textarea id="<?php echo $id; ?>-slider-overlay-content" name="<?php echo $name; ?>[slider_overlay_content]" rows="5" class="field-input"><?php echo esc_html( $slider_overlay_content ); ?></textarea>
                <p class="description">Overlay Content output after Image Caption (can use shortcodes and html code)</p>
            </div>
        </div>

        <div class="row slider-output-type-<?php echo $id; ?>-hide map-slider-output-type-<?php echo $id; ?>-selected" style="display:<?php echo ( $slider_output_type == 'map' ) ? 'block' : 'none'; ?>;">
            <div class="field-item">
                <label for="<?php echo $id; ?>-latitude">Latitude:</label>
                <input type="text" id="<?php echo $id; ?>-slider-latitude" name="<?php echo $name; ?>[slider_latitude]" class="field-input" value="<?php echo $slider_latitude; ?>">
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-longitude">Longitude:</label>
                <input type="text" id="<?php echo $id; ?>-slider-longitude" name="<?php echo $name; ?>[slider_longitude]" class="field-input" value="<?php echo $slider_longitude; ?>">
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-zoom">Zoom:</label>
                <input type="text" id="<?php echo $id; ?>-slider-zoom" name="<?php echo $name; ?>[slider_zoom]" class="field-input" value="<?php echo $slider_zoom; ?>">
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-width">width:</label>
                <input type="text" id="<?php echo $id; ?>-slider-width" name="<?php echo $name; ?>[slider_width]" class="field-input" value="<?php echo $slider_width; ?>">
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-height">height:</label>
                <input type="text" id="<?php echo $id; ?>-slider-height" name="<?php echo $name; ?>[slider_height]" class="field-input" value="<?php echo $slider_height; ?>">
            </div>
        </div>

        <div class="row slider-output-type-<?php echo $id; ?>-hide iframe-slider-output-type-<?php echo $id; ?>-selected" style="display:<?php echo ( $slider_output_type == 'iframe' ) ? 'block' : 'none'; ?>;">
            <div class="field-item">
                <label for="<?php echo $id; ?>-slider-iframe-src">iframe Embed:</label>
                <textarea id="<?php echo $id; ?>-slider-iframe-src" name="<?php echo $name; ?>[slider_iframe_src]" rows="2" class="field-input"><?php echo esc_html( $slider_iframe_src ); ?></textarea>
                <p class="description">Add Iframe Tag Here (Not Recommended)</p>
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