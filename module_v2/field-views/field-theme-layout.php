<?php
extract( $viewData );
extract( $value );

$config_templates_v1 = dwh_get_config( 'config.theme.templatesv1', 'json', array( 'module_v2', 'theme-templates', 'config' ) );
$config_templates_v2 = dwh_get_config( 'config.theme.templatesv2', 'json', array( 'module_v2', 'theme-templates', 'config' ) );
$header_layout_args = array('path' => 'get_template_directory()/module_v2/theme-templates/dwh_get_theme_template()/blank-template/template/', 'file' => 'header', 'extension' => 'tpl' );
$footer_layout_args = array('path' => 'get_template_directory()/module_v2/theme-templates/dwh_get_theme_template()/blank-template/template/', 'file' => 'footer', 'extension' => 'tpl' );

$theme_name    = isset( $theme_name ) && dwh_empty( $theme_name ) ? $theme_name : 'blank-template';
$header_layout = isset( $header_layout ) && dwh_empty( $header_layout ) ? $header_layout : '';
$footer_layout = isset( $footer_layout ) && dwh_empty( $footer_layout ) ? $footer_layout : '';
?>

<div id="<?php echo $id; ?>-container" class="<?php echo $class; ?>">
    <div class="field-title-container<?php echo $accordiontitle; ?>">
        <?php if ( $label ) { ?>
        <label for="<?php echo $id; ?>" class="field-title"><?php echo $label; ?></label>
        <?php } ?>
    </div>
    <div class="field-content-container<?php echo $accordioncontent; ?>">
        <div class="row">
            <div class="field-item col-narrow">
                <select id="<?php echo $id; ?>-theme-name" class="field-input theme-template-select" name="<?php echo $name; ?>[theme_name]">
                    <?php foreach( $config_templates_v1 as $template_v1 ) { ?>
                    <?php $selected  = ( $template_v1->id === $theme_name ) ? ' selected' : 'hidden style="display:none"'; ?>
                    <option class="template_v1" style="display: none;" value="<?php echo $template_v1->id; ?>"<?php echo $selected; ?>><?php echo $template_v1->name; ?></option>
                    <?php } ?>

                    <?php foreach( $config_templates_v2 as $template_v2 ) { ?>
                    <?php $selected  = ( $template_v2->id === $theme_name ) ? ' selected' : null; ?>
                    <option value="<?php echo $template_v2->id; ?>"<?php echo $selected; ?>><?php echo $template_v2->name; ?></option>
                    <?php } ?>
                </select>
                <input id="<?php echo $id; ?>-controller" type="checkbox" class="field-input theme-template-controller"/><label for="<?php echo $id; ?>-controller" class="field-title theme-themplate-cb-label"><span>Show All Templates</span></label>
            </div>
        </div>
        <div class="row">
            <div class="field-item">
                <label for="header-layout" class="field-item-label">Header Layout</label>
                <a class="button button-upload button-secondary media-upload-button" href="#<?php echo $id; ?>-header-layout">Upload and Insert Media</a>
                <textarea row="10" id="<?php echo $id; ?>-header-layout" name="<?php echo $name; ?>[header_layout]" class="field-input dwh-cm-textarea"><?php echo esc_html( $header_layout ); ?></textarea>
                <p class="description">Add Header Template Layout</p>
                <a href="#<?php echo $id; ?>-header-layout" class="reset-item link" data-id="<?php echo $id; ?>-header-layout" data-label="Header Layout">Reset Header Layout</a>
                <input type="hidden" class="<?php echo $id; ?>-header-layout-data" data-path="get_template_directory()/module_v2/theme-templates/dwh_get_theme_template()/dwh_get_theme_layout()/template/" data-file="header" data-extension="tpl" />
            </div>
            <div class="field-item">
                <label for="<?php echo $id; ?>-footer-layout" class="field-item-label">Footer Layout</label>
                <a class="button button-upload button-secondary media-upload-button" href="#<?php echo $id; ?>-footer-layout">Upload and Insert Media</a>
                <textarea row="10" id="<?php echo $id; ?>-footer-layout" name="<?php echo $name; ?>[footer_layout]" class="field-input dwh-cm-textarea"><?php echo esc_html( $footer_layout ); ?></textarea>
                <p class="description">Add Footer Template Layout</p>
                <a href="#<?php echo $id; ?>-footer-layout" class="reset-item link" data-id="<?php echo $id; ?>-footer-layout" data-label="Footer Layout">Reset Footer Layout</a>
                <input type="hidden" class="<?php echo $id; ?>-footer-layout-data" data-path="get_template_directory()/module_v2/theme-templates/dwh_get_theme_template()/dwh_get_theme_layout()/template/" data-file="footer" data-extension="tpl" />
            </div>
        </div>


        <?php if ( $removeitem ) { ?>
        <a href="#<?php echo $id; ?>-container" class="remove-item button button-remove">Delete</a>
        <?php } ?>
    </div>
</div>