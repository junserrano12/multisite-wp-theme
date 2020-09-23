<?php

global $DWH_Options;
global $DWH_Widget;
global $DWH_Admin;
global $DWH_Customization;

/* Get Design url parameters */
$design_type = isset( $_GET['design_type'] ) ? $_GET['design_type'] : '';
$design_set  = isset( $_GET['design_set'] ) ? $_GET['design_set'] : '';
$design_set_config = array();
$design_type_config = array();
$dir_name      = "";
$design_config_sets = array();

/* Assign design set directory name */
if( $design_type && $design_set )
{
     $dir_name = $design_set;
     $design_config_sets  = $DWH_Customization->get_design_config_sets( $design_type );
}
else
{	
	/* Get design config sets */
	if( $design_type )
	{
	    $design_config_sets  = $DWH_Customization->get_design_config_sets( $design_type );
	}
	else
	{
	    /* Get site info for the default theme designer design set */
	    $site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);
	    $dir_name = $site_info->site_theme;
	    $design_type = "site";
	    $design_config_sets  = $DWH_Customization->get_design_config_sets( $design_type );
	}

}

/* Define root config sites allowed to be loaded */
$design_config_types = array( 'site' , 'page' );

/* Load design type data  */
$design_set_config = $DWH_Customization->get_design_config( $design_type , $dir_name );
$theme_design_data = get_dwh_option( 'dwh_theme_designer_'.$dir_name );
$enable_flag_value      = $theme_design_data['settings']['enable_flag']  == false ? 0 : 1;
$is_theme_designer_enabled_option = $theme_design_data['settings']['enable_flag']  == false ? '' : 'checked';

?>

    <div class="wrap">

        <div id="theme-designer">
            <h2> Theme Customization</h2>

            <div class="control-wrapper">

                <label>
                    <span> Select Design set to load : </span>
                    <select name="theme-designer-types">
                        <?php foreach ($design_config_types as $key => $value):?>
                        <option value='<?php echo $value;?>' <?php echo $value == $design_type ? 'selected' : '';?>> <?php echo $value;?> </option>
                        <?php endforeach;?>
                    </select>
                    
                    <select name="theme-designer-sets">
                        <?php foreach ($design_config_sets as $key => $value):?>
                        <?php
                            if( $design_type == 'site') { $design_type_config = $DWH_Admin->get_site_theme_config( $value ); }
                            if( $design_type == 'page') { $design_type_config = $DWH_Admin->get_page_theme_config( $value ); }

                            $design_type_name = isset( $design_type_config['details']['name'] ) ? $design_type_config['details']['name'] : '';
                            $designer_is_enabled = isset( $design_type_config['designer']['enable_flag'] ) && $design_type_config['designer']['enable_flag'] == true ? true : false;
                        ?>
                        <option value='<?php echo $value;?>' <?php echo $value == $dir_name ? 'selected' : '';?>> <?php echo $design_type_name;?> </option>
                       
                        <?php endforeach;?>
                            }
                    </select>

                    <input class="button-primary" type="button" id="btn-load-designer-set" value="Load">
                </label>

            </div>

            <?php
                if( !$design_set_config ){
            ?>
                    <div id="message3" class="error below-h2"><p>Design set customization not available </p></div>

            <?php
                }

                else{
            ?>

                    <?php if( DWH_USER_ROLE != 'editor' ):?>
                    <div class="control-wrapper">
                        <label>
                            <span>Enable Theme Designer rendering</span>
                            <input value="<?php echo $enable_flag_value;?>"type="checkbox" name="designer_enable_flag" <?php echo $is_theme_designer_enabled_option;?>>
                        </label>
                    </div>
                    <?php endif;?>

                    <?php
                        /* disable theme designer if flag is 0 and role is editor */
                        $display_editor = "display:block";
                        $display_notif = "display:none";

                        if( !$enable_flag_value && DWH_USER_ROLE == 'editor' ){
                            $display_editor = "display:none";
                            $display_notif = "display:block";
                        }

                    ?>
                            <!-- Theme designer -->
                            <div style="<?php echo $display_editor; ?>">

                                <?php
                                    /* if design_set_config is not empty */
                                    if( $design_set_config ){

                                        $tabmenuarr = array();
                                        foreach( $design_set_config as $key => $val ){
                                            array_push( $tabmenuarr, $val['details']['category'] );
                                        }
                                        $tabmenuarr = array_unique( $tabmenuarr );
                                ?>

                                        <!-- tab menu -->
                                        <ul class="tab-menu tab-vertical tab-menu-level1">
                                            <?php
                                                $ctr = 0;
                                                foreach( $tabmenuarr as $tab => $tabvalue ){
                                            ?>
                                                    <li>
                                                        <a class="<?php echo $ctr < 1 ? 'active' : ''; ?>" href="#custom-<?php echo $tabvalue; ?>"><?php echo ucfirst( $tabvalue ); ?></a>
                                                    </li>
                                            <?php
                                                    $ctr++;
                                                }
                                            ?>
                                        </ul>
                                        <!-- end tab menu -->

                                        <!-- tab container -->
                                        <?php
                                            $ctr = 0;
                                            foreach( $tabmenuarr as $tab => $tabcontainer ){
                                        ?>
                                                <!-- tab-container-level1 -->
                                                <div id="custom-<?php echo $tabcontainer; ?>" class="tab-container tab-container-vertical tab-container-level1 <?php echo $ctr < 1 ? 'show' : ''; ?>">

                                                    <!-- 2nd level tab menu -->
                                                    <ul class="tab-menu tab-menu-level2">
                                                        <?php
                                                            /* create 2nd level tab menu */
                                                            $ctr = 0;
                                                            foreach( $design_set_config as $key => $val ){
                                                                if( $tabcontainer == $val['details']['category'] ){
                                                        ?>
                                                                    <li>
                                                                        <a class="<?php echo $ctr < 1 ? 'active' : ''; ?>" href="#customtab-<?php echo sanitize_title_with_dashes( $val['details']['title'] ); ?>"><?php echo $val['details']['title']; ?></a>
                                                                    </li>
                                                        <?php
                                                                    $ctr++;
                                                                }
                                                            }
                                                        ?>
                                                    </ul>

                                                    <!-- 2nd level tab container -->
                                                    <?php
                                                        /* create 2nd level tab container */
                                                        $ctr = 0;
                                                        foreach( $design_set_config as $key => $val ) {

                                                            if( $tabcontainer == $val['details']['category'] ) {
                                                    ?>
                                                                <!-- tab-container-level2 -->
                                                                <div id="customtab-<?php echo sanitize_title_with_dashes( $val['details']['title'] ); ?>" class="tab-container tab-container-level2 <?php echo $ctr < 1 ? 'show' : ''; ?>">
                                                                    <h3><?php echo $val['details']['description'] ?></h3>
                                                                    <?php
                                                                        $mode = 'add';
                                                                        $option_row = 0;

                                                                        foreach( $val['sections'] as $sec_key => $sec_val ){

                                                                            $selector = $sec_val['selector'];
                                                                            $attributes = $sec_val['attributes'];

                                                                            foreach( $attributes as $key1 => $val1 ){

                                                                                /* if with option data */
                                                                                if( $theme_design_data['design_styles'] ){

                                                                                    /* loop option value; assign to field value */
                                                                                    foreach( $theme_design_data['design_styles'] as $key_data => $val_data ){

                                                                                        /* if with value */
                                                                                        if( $selector == $val_data['selector'] ){

                                                                                            $mode = 'edit';
                                                                                            $option_row = $key_data;

                                                                                            /* dynamically add option value */
                                                                                            if( array_key_exists( 'attributes', $val_data )){
                                                                                                if( array_key_exists( $key1, $val_data['attributes'] ) ){
                                                                                                    $attributes[ $key1 ]['properties']['field_value'] = $val_data['attributes'][ $key1 ];
                                                                                                }
                                                                                            }

                                                                                        }
                                                                                    }
                                                                                }

                                                                                $field_properties = $attributes[ $key1 ]['properties'];
                                                                                echo $DWH_Widget->get_form_field_element( $selector, $field_properties  );

                                                                            }
                                                                        }
                                                                    ?>

                                                                    <a href="#" class="btn-theme-designer-save button-primary" data-name="<?php echo sanitize_title_with_dashes( $val['details']['title'] ); ?>" data-category="<?php echo $val['details']['category']; ?>" data-mode="<?php echo $mode; ?>" data-row="<?php echo $option_row; ?>">Save</a>

                                                                </div> <!-- end .tab-container-level2 -->

                                                    <?php
                                                                $ctr++;
                                                            }
                                                        }
                                                    ?>
                                                </div><!-- end .tab-container-level1 -->
                                        <?php
                                                $ctr++;
                                            }
                                        ?>
                                        <!-- end tab container -->

                                <?php
                                    }
                                ?>
                            </div>

                            <!-- Notification Message -->
                            <div style="<?php echo $display_notif; ?>" class="error below-h2">
                                <p>Permission Denied: Needs authorization to access theme designer. Please contact system administrator.</p>
                            </div>

            <?php } ?>

        </div><!-- end #theme-designer -->

        <?php if( DWH_USER_ROLE != 'editor' ):?>
        <?php $is_display_editor = true;?>
        <?php else:?>
        <?php $is_display_editor = false;?>
        <?php endif;?>

        <div class="theme-designer-viewer-container" style="display: <?php echo $is_display_editor == true ? 'block' : 'none';?>">

            <div class="control-wrapper">
                <label>
                    <a href="#" class="btn-reset-this-design-set button-primary" design-set="dwh_theme_designer_<?php echo $dir_name; ?>">Reset this design set</a>
                    <p class="description">This will reset currently loaded design set</p>
                </label>
            </div>

            <div id="theme-designer-output">
                <h3>Theme Designer Custom CSS</h3>
                <textarea class="cm-s-default" readonly id="CodeMirror-theme-designer" name="code" style="width:97%; min-height:250px;"><?php echo $DWH_Customization->render( 'css' , $design_type , $dir_name , 'admin' ); ?></textarea>
                <p class="description">For Designer Use Only - Reference Custom Style</p>
            </div>
        </div>

        <!-- preloader modal -->
        <div class="hide">
            <div class="options-preloader">Processing reset...</div>
            <div class="options-mask"></div>
        </div>
        <!-- end preloader modal -->

    </div><!-- end .wrap -->

<script>
/* leavePagePrompt(); */
</script>