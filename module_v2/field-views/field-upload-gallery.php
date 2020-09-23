<?php
extract( $viewData );

$imageids         = ( dwh_empty( $value ) ) ? $value : false;
$imageid_list     = ( dwh_empty( $value ) ) ? explode(',', $imageids) : array();
$image_size       = 'medium_thumbnail';
$control = ( $imageids ) ? 'edit' : 'upload';
?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if ( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container<?php echo $accordioncontent; ?>">
        <div class="preview-gallery-container">
            <?php
            foreach ( $imageid_list as $imageid ) {
                $image   = ( $imageid ) ? wp_get_attachment_image_src( $imageid, $image_size ) : false;
                $src     = ( $imageid ) ? wp_get_attachment_image_url( $imageid, $image_size ) : false;
                $srcset  = ( $imageid ) ? wp_get_attachment_image_srcset( $imageid, $image_size ) : false;
                if ( $src ) { ?>
                    <img class="preview-gallery-image inline-block" src="<?php echo $src; ?>" srcset="<?php echo $srcset; ?>" sizes="(max-width:<?php echo $image[1]; ?>px) 100vw, <?php echo $image[1]; ?>px" width="<?php echo $image[1]; ?>">
                <?php }
            }
            ?>
        </div>
        <div class="attr-container">
            <input type="hidden" class="image-ids" name="<?php echo $name; ?>" value="<?php echo $imageids; ?>"/>
        </div>
        <div class="controller-container">
            <a href="#?" data-id="<?php echo $id; ?>" class="image-controller-link controller-upload-gallery"><?php echo ucfirst( $control ); ?> gallery</a>
            <?php if ( $imageids ) { ?>
            <a href="#?" data-id="<?php echo $id; ?>" class="image-controller-link controller-remove-gallery">Remove gallery</a>
            <?php } ?>
        </div>
        <?php if ( $description ) { ?>
        <p class="description"><?php echo $description; ?></p>
        <?php } ?>
        <?php if ( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>