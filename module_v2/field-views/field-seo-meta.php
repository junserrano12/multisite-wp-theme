<?php
extract( $viewData );

$value = ( dwh_empty( $value ) ) ? $value : false;

if( !$value ) {
    $value = array(
                    "title"        => "",
                    "keyword"      => "",
                    "mdescription" => ""
                );
}

extract( $value );
?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container-seo-meta field-content-container<?php echo $accordioncontent; ?>">
        <div class="row">
            <div class="field-item">
                <label for="<?php echo $id; ?>-title">Meta Title</label>
                <input type="text" id="<?php echo $id; ?>-title" placeholder="Insert Meta Title" name="<?php echo $name; ?>[title]" class="field-input<?php echo $marginbottom; ?>" value="<?php echo $title; ?>">
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-keyword">Meta Keyword</label>
                <input type="text" id="<?php echo $id; ?>-keyword" placeholder="Insert Meta Keywords" name="<?php echo $name; ?>[keyword]" class="field-input<?php echo $marginbottom; ?>" value="<?php echo $keyword; ?>">
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-mdescription">Meta Description</label>
                <textarea id="<?php echo $id; ?>-mdescription" placeholder="Insert Meta Description" name="<?php echo $name; ?>[mdescription]" class="field-input<?php echo $marginbottom; ?>"><?php echo esc_html( $mdescription ); ?></textarea>
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