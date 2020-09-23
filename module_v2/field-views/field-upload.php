<?php
extract( $viewData );
$imageid = ( dwh_empty( $value ) ) ? $value : false;
$image   = ( $imageid ) ? wp_get_attachment_image_src( $imageid, 'thumbnail-full' ) : false;
$src     = ( $imageid ) ? wp_get_attachment_image_url( $imageid, 'thumbnail-full' ) : false;
$srcset  = ( $imageid ) ? wp_get_attachment_image_srcset( $imageid, 'thumbnail-full' ) : false;
$control = ( $imageid ) ? 'remove' : 'upload';
?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container<?php echo $accordioncontent; ?>">

        <div class="preview-container">
            <?php if( $src ) { ?>
            <img class="preview-image" src="<?php echo $src; ?>" srcset="<?php echo $srcset; ?>" sizes="(max-width:<?php echo $image[1]; ?>px) 100vw, <?php echo $image[1]; ?>px" width="<?php echo $image[1]; ?>">
            <?php } else { ?>
            <div class="preview-image blank-image"></div>
            <?php } ?>
        </div>
        <div class="attr-container">
            <input type="hidden" class="image-id" name="<?php echo $name; ?>" value="<?php echo $imageid; ?>"/>
        </div>
        <div class="controller-container">
            <a href="#?" data-id="<?php echo $id; ?>" class="button button-<?php echo $control; ?> image-controller-link controller-<?php echo $control; ?>-image"><?php echo ucfirst( $control ); ?> image</a>
        </div>

        <?php if( $description ) { ?>
        <p class="description"><?php echo $description; ?></p>
        <?php } ?>
        <?php if( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>