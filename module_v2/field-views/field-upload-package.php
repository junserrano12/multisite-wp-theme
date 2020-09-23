<?php
extract( $viewData );
$value = ( dwh_empty( $value ) ) ? $value : false;

if ( !$value ) {
    $value = array( "image_id" => "",
                    "image_link" => "",
                    "image_caption" => ""
                );
}

extract( $value );

$image   = ( $image_id ) ? wp_get_attachment_image_src( $image_id, 'thumbnail-full' ) : false;
$src     = ( $image_id ) ? wp_get_attachment_image_url( $image_id, 'thumbnail-full' ) : false;
$srcset  = ( $image_id ) ? wp_get_attachment_image_srcset( $image_id, 'thumbnail-full' ) : false;
$control = ( $image_id ) ? 'remove' : 'upload';

?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if ( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container<?php echo $accordioncontent; ?>">
        <div class="preview-container">
            <?php if ( $src ) { ?>
            <img class="preview-image" src="<?php echo $src; ?>" srcset="<?php echo $srcset; ?>" sizes="(max-width:<?php echo $image[1]; ?>px) 100vw, <?php echo $image[1]; ?>px" width="<?php echo $image[1]; ?>">
            <?php } ?>
        </div>
        <div class="attr-container">
            <input type="hidden" class="image-id" name="<?php echo $name; ?>[image_id]" value="<?php echo $image_id; ?>"/>
            <input type="text" class="image-link field-input<?php echo $marginbottom; ?>" name="<?php echo $name; ?>[image_link]" value="<?php echo $image_link; ?>"/>
            <input type="text" class="image-caption field-input<?php echo $marginbottom; ?>" name="<?php echo $name; ?>[image_caption]" value="<?php echo $image_caption; ?>"/>
        </div>

        <div class="controller-container">
            <a href="#?" data-id="<?php echo $id; ?>" class="image-controller-link controller-<?php echo $control; ?>-image">'.ucfirst( $control ); ?> image</a>
        </div>
        <?php if ( $description ) { ?>
        <p class="description"><?php echo $description; ?></p>
        <?php } ?>
        <?php if ( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>