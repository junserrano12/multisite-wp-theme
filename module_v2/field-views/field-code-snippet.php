<?php
extract( $viewData );

$value = ( dwh_empty( $value ) ) ? $value : false;

if( !$value ) {
    $value = array( "title"     => "",
                    "content"   => "",
                    "location"  => "head",
                    "postids"   => ""
                );
}

extract( $value );
$postids    = isset( $postids ) ? $postids : array();
$label      = ( $title ) ? $title : $label;
?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container-code-snippet field-content-container<?php echo $accordioncontent; ?>">
        <div class="row">
            <div class="field-item">
                <label for="<?php echo $id; ?>-title">Title</label>
                <input type="text" id="<?php echo $id; ?>-title" name="<?php echo $name; ?>[title]" class="code-snippet-title-list field-input placeholder-title<?php echo $marginbottom; ?>" value="<?php echo $title; ?>">
                <p class="description">Give the code snippet a name so it can be easily identified</p>
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-location">Position</label><br>
                <select name="<?php echo $name; ?>[location]" class="field-input code-snippet-location" id="<?php echo $id; ?>-location">
                    <option value="head"<?php echo ( $location === 'head') ? ' selected' : null; ?>>header, before head closing tag</option>
                    <option value="body"<?php echo ( $location === 'body') ? ' selected' : null; ?>>body, after body opening tag</option>
                    <option value="footer"<?php echo ( $location === 'footer') ? ' selected' : null; ?>>footer, before body closing tag</option>
                </select>
                <p class="description">Select where to place the code snippet</p>
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-content">Code</label>
                <textarea id="<?php echo $id; ?>-content" name="<?php echo $name; ?>[content]" rows="5" class="code-snippet-content field-input"><?php echo esc_html( $content ); ?></textarea>
                <p class="description">Enter the code snippet</p>
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-selected-page">Target Pages</label>
                <p class="description">Select specific pages where to code snippet should be included. To include it on all pages, leave all blank.</p>
                <ul class="code-snippet-checkbox-container box">
                    <?php
                        $args = array( 'posts_per_page' => -1, 'offset' => 0, 'category' => '', 'category_name' => '', 'orderby' => 'date', 'order' => 'ASC', 'include' => '', 'exclude' => '', 'meta_key' => '', 'meta_value' => '', 'post_type' => get_post_types(), 'post_mime_type' => '', 'post_parent' => '', 'author' => '', 'author_name' => '', 'post_status' => 'publish', 'suppress_filters' => true );
                        $posts_array = get_posts( $args );
                        foreach( $posts_array as $key => $post ) {
                            if ( $post->post_type !== "nav_menu_item" && $post->post_type !== "customize_changeset" && $post->post_type !== "custom_css" && $post->post_type !== "revision" && $post->post_type !== "attachment" ) {
                                $postid = $post->ID;
                                $altlabel = ( strlen( $post->post_title ) > 18 ) ? '<span class="altlabel">'.$post->post_title.'</span>' : null;
                                $checked = isset( $postids[$postid] ) || in_array( $postid, $postids ) ? 'checked ' : null;
                                $checkbox_value = isset( $postids[$postid] ) ? $postids[$postid] : null;
                                echo '<li><input '.$checked.' type="checkbox" data-id-checkbox="'.$postid.'" id="'.$id.'-'.$postid.'" class="code-snippet-checkbox field-input" name="'.$name.'[postids]['.$postid.']" value="'.$checkbox_value.'"><label>'.dwh_limit_string($post->post_title, 18).$altlabel.'</label></li>';
                            }
                        }
                    ?>
                </ul>
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