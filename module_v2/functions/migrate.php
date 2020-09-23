<?php

if ( !function_exists( 'dwh_wponetheme_migrate_fonts' ) )
{
    function dwh_wponetheme_migrate_fonts()
    {
        if( !get_option( 'onetheme_fonts_migrated' ) ) {

            dwh_wponetheme_font_migration_upload();
        }

    }
}

if ( !function_exists( 'dwh_wponetheme_migrate' ) )
{
    function dwh_wponetheme_migrate()
    {
        $migrateconfig = dwh_get_config( 'config.migrate', 'json' );
        $pageids = get_all_page_ids();
        $migrateddata = array();

        foreach ( $migrateconfig as $option_name => $option_fields ) {
            foreach ( $option_fields as $field_id => $field_data ) {
                if ( $field_data->repeater ) {

					if( !is_array( $field_data->field_option ) ) {

						$items = get_option( $field_data->field_option );

						foreach ( $items as $ctr => $item ) {

							if ( $field_data->sub_fields ) {

								foreach ( $field_data->sub_fields as $field_key => $field ) {

                                    $callback  = isset( $field->callback ) ? $field->callback : 'dwh_switch_value';
                                    $parameter = isset( $field->parameter ) ? $field->parameter : array();
									$migrateddata[$option_name][$field_id][$ctr][$field_key] = dwh_get_v1_data( $field->field_id, $field->field_option, $ctr, $callback, $parameter );

								}

							} else {

                                $callback  = isset( $field_data->callback ) ? $field_data->callback : 'dwh_switch_value';
                                $parameter = isset( $field_data->parameter ) ? $field_data->parameter : array();
								$migrateddata[$option_name][$field_id][$ctr] = dwh_get_v1_data( $field_data->field_id, $field_data->field_option, $ctr, $callback, $parameter );

							}

						}
					} else {

						$temp = array();

						$count_sub_fields = count( $field_data->sub_fields );

                        for( $x = 0; $x < $count_sub_fields; $x++ ) {

							$items = get_option( $field_data->field_option[$x] );

							foreach ( $field_data->sub_fields[$x] as $field_key => $f ) {

								for( $item = 0; $item < count( $items ); $item++ ) {

									$callback = isset( $field->callback ) ? $field->callback : 'dwh_switch_value';
									$temp[$f->field_option][$item][$field_key] = dwh_get_v1_data( $f->field_id, $f->field_option, $item, $callback, $parameter );

								}

							}

						}

						if( count( $temp ) > 0 ) {

                        	$var = array();

							foreach( $temp as $key => $arr ) {

								foreach( $arr as $key => $value ) {
									$var[] = $value;
								}
							}

							$migrateddata[$option_name][$field_id] = $var;
						}
					}

                } else {

                    if ( $field_data->sub_fields ) {
                        foreach ( $field_data->sub_fields as $field_key => $field ) {
                            $callback  = isset( $field->callback ) ? $field->callback : 'dwh_switch_value';
                            $parameter = isset( $field->parameter ) ? $field->parameter : array();
                            $migrateddata[$option_name][$field_id][$field_key] = dwh_get_v1_data( $field->field_id, $field->field_option, 0, $callback, $parameter );
                        }
                    } else {
                        $callback  = isset( $field_data->callback ) ? $field_data->callback : 'dwh_switch_value';
                        $parameter = isset( $field_data->parameter ) ? $field_data->parameter : array();
                        $migrateddata[$option_name][$field_id] = dwh_get_v1_data( $field_data->field_id, $field_data->field_option, 0, $callback, $parameter );
                    }

                }
            }

            $migrateddata_has_value = get_option( $option_name );

            if ( $migrateddata_has_value == null ) {

                update_option( $option_name, $migrateddata[$option_name] );

			}
        }

        /*migrate post meta slider only*/
        foreach ( $pageids as $pageid ) {
            $sliderfield   = get_post_meta( $pageid, 'slider' );

            $sliderdata    = array();
            $slideritems   = array();

            $sliderfield   = array_shift( $sliderfield );
            $sliderfield   = isset( $sliderfield[0] ) ? $sliderfield[0] : null;

            $type          = '';
            $thumbnailsize = '';

            if ( dwh_empty( $sliderfield ) ) {
                foreach ( $sliderfield as $key => $data ) {

                    switch ( $key ) {
                        case 'slider-name':
                            $slider = $data[0];
                            $sliderdata['slider'] = $slider;
                            break;
                        case 'slider-mode':
                            $mode = ( $data[0] == 'page' ) ? 'page' : 'global';
                            $sliderdata['view'] = $mode;
                            break;
                        case 'slider-type':

                            switch ( $data[0] ) {
                                case 'Default Slider':
                                    $type = 'default';
                                    break;
                                case 'Bullet Slider':
                                    $type = 'bullet';
                                    break;
                                case 'Thumbnail Large':
                                    $thumbnailsize = 'large-thumbnail-image';
                                    $type = 'thumbnail';
                                    break;
                                case 'Thumbnail Medium':
                                    $thumbnailsize = 'medium-thumbnail-image';
                                    $type = 'thumbnail';
                                    break;
                                case 'Thumbnail Small':
                                    $thumbnailsize = 'small-thumbnail-image';
                                    $type = 'thumbnail';
                                    break;
                            }

                            $sliderdata['mode'] = $type;
                            $sliderdata['type'] = $type;
                            $sliderdata['thumbnailsize'] = $thumbnailsize;

                            break;
                        default:
                            $search = array(
                                                'slider-item-type',
                                                'slider-item-id',
                                                'slider-item-expire',
                                                'slider-item-title',
                                                'slider-item-caption',
                                                'slider-item-class',
                                                'slider-item-overlaycontent',
                                                'slider-item-url',
                                                'slider-item-description',
                                                'slider-item-rel',
                                                'slider-item-popup',
                                                'slider-item-iframe'

                                            );

                            $replace = array(
                                                'slider_output_type',
                                                'slider_id',
                                                'slider_expire',
                                                'slider_title',
                                                'slider_caption',
                                                'slider_class',
                                                'slider_overlay_content',
                                                'slider_link',
                                                'slider_inline_content',
                                                'slider_rel',
                                                'slider_colorbox',
                                                'slider_iframe_src'
                                            );

                            foreach ( $data as $ctr => $value ) {
                                $newkey = str_replace( $search, $replace, $key );
                                $slideritems[$ctr][$newkey] = $value;
                            }
                            break;
                    }

                }
            }

            if ( ! add_post_meta( $pageid, 'slider-data', $sliderdata, true ) ) {
                update_post_meta( $pageid, 'slider-data', $sliderdata );
            }

            if ( ! add_post_meta( $pageid, 'slider-item', $slideritems, true ) ) {
                update_post_meta( $pageid, 'slider-item', $slideritems );
            }
        }

	}
}

if ( !function_exists( 'dwh_get_v1_data' ) )
{
    function dwh_get_v1_data( $field_id, $option_name, $key, $callback = "dwh_switch_value", $parameter = array() )
    {

        $value = ( $option_name !== '' || $option_name !== null ) ? get_option( $option_name ) : false;

        if ( $value ) {

            $fieldvalue = isset( $value[$key][$field_id] ) ? $value[$key][$field_id] : null;

            if ( function_exists( $callback ) ) {

                $fieldvalue = call_user_func_array( $callback, array( $fieldvalue, $field_id, $key, $parameter ) );

            }

            return $fieldvalue;
		}


    }
}

if ( !function_exists( 'dwh_switch_value' ) )
{
    function dwh_switch_value( $fieldvalue, $fieldid, $key )
    {

        switch ( $fieldid ) {
            case 'ibe_desktop_url':

                    $hotels    = get_option('dwh_hotels');
                    $hotelid   = $hotels[$key]['hotel_id'];

                    $ibe       = get_option('dwh_ibe_url');
                    $iberesult = json_decode( $ibe[0]['ibe_desktop_url'] );
                    $value     = isset( $iberesult->$hotelid ) ? $iberesult->$hotelid->data->ibe_desktop_subdomain : null;

                break;

            case 'corpsite_flag':

                switch ( $fieldvalue ) {
                    case 1:
                        $value = 'corpsite';
                        break;
                    default:
                        $value = 'single';
                        break;
                }

                break;

            case 'cscript_display_to':

                $postids = explode( ',', $fieldvalue );
                $ids = array();
                foreach ( $postids as $key => $value ) {
                    if ( $value === 'All Pages' ) {
                        $ids[$key] = null;
                    } else {
                        $page = get_page_by_title( $value );
                        $ids[$key] = $page->ID;
                    }
                }

                $value = $ids;

                break;

			case 'cta_set':

			   $value = dwh_cta_layout( $fieldvalue );

               break;

			case 'internal_font_type':

			   $value = 'internal';

               break;

			case 'external_font_type':

			   $value = 'external';

               break;

            default:

                $value = $fieldvalue;
                break;
        }

        return $value;
    }
}

if ( !function_exists( 'dwh_remove_extra_line' ) )
{
    function dwh_remove_extra_line( $fieldvalue ){

        $fieldvalue   = str_replace( array("\r\n", "\r"), "\n", $fieldvalue );
        $fieldvalue   = preg_replace( "/\n\n+/", "\n\n", $fieldvalue );

        $strings  = preg_split( "/\n\s*\n/", $fieldvalue, -1, PREG_SPLIT_NO_EMPTY );

        $fieldvalue   = '';

        foreach ( $strings as $str ) {
            $fieldvalue .= trim( $str, "\n" ) . "\n";
        }

        return $fieldvalue;
    }
}

if ( !function_exists( 'dwh_convert_to_bool' ) )
{
    function dwh_convert_to_bool( $fieldvalue )
    {
        $fieldvalue = ( $fieldvalue != null || $fieldvalue != '' ) ? true : false;

        return $fieldvalue;
    }
}

if ( !function_exists( 'dwh_get_atf_value_from_file' ) )
{
    function dwh_get_atf_value_from_file()
    {
        global $blog_id;

        $sites        = get_option( 'dwh_sites', $blog_id );
        $themelayout  = isset($sites[0]['site_theme']) ? $sites[0]['site_theme'] : null;
        $file         = get_template_directory().'/module_v2/theme-templates/v1/'.$themelayout.'/sass/style-above-the-fold.scss';

        if ( file_exists( $file ) ) {
            $file_content = file_get_contents( $file );
            return $file_content;
        }

    }
}

if ( !function_exists( 'dwh_get_value_from_file' ) )
{
    function dwh_get_value_from_file( $fieldvalue, $fieldid, $key, $parameter )
    {
        global $blog_id;

        $filename    = isset( $parameter->filename ) ? $parameter->filename : false;
        $type        = isset( $parameter->type ) ? $parameter->type : false;
        $ext         = isset( $parameter->ext ) ? $parameter->ext : false;
        $sites       = get_option( 'dwh_sites', $blog_id );
        $themelayout = isset($sites[0]['site_theme']) ? $sites[0]['site_theme'] : null;

        if ( $filename && $type && $ext ) {

            $file = get_template_directory().'/module_v2/theme-templates/v1/'.$themelayout.'/'.$type.'/'.$filename.'.'.$ext;

            if ( file_exists( $file ) ) {
                $file_content = file_get_contents( $file );
                return $file_content;
            }

        }

    }
}

/* function not callback */
if ( !function_exists( 'dwh_cta_layout' ) )
{
    function dwh_cta_layout( $ctalayout )
    {
        global $blog_id;

        $cta          = get_option('dwh_cta',$blog_id);
        $sites        = get_option( 'dwh_sites',$blog_id );
        $ctapromocode = isset($cta[0]['cta_promo_code']) ? $cta[0]['cta_promo_code'] : 0;
        $bpginclusion = isset($cta[0]['bpg_inclusion']) ? $cta[0]['bpg_inclusion'] : '';
        $themelayout  = isset($sites[0]['site_theme']) ? $sites[0]['site_theme'] : null;
        $themelayout  = ( 'AW4.2.0-default' === $themelayout ) ? 'AW' : 'NW';
        $corp_site    = dwh_get_data( 'corpsite_flag', 'dwh_sites' );

        $output  = '<div id="cta-container" class="cta-container">'."\n";
        $output .= '    <div class="cta-content">'."\n";

        if ( $themelayout == 'AW' ) {
            switch ( $ctalayout ) {
                case 'set_a':

                    $output .= '        [cta_button]'."\n";
                    $output .= '        [cta_bpg_title]'."\n";
                    $output .= '        <div class="control-wrapper cta-inclusions-container">'."\n";
                    $output .=              $bpginclusion."\n";
                    $output .= '        </div>'."\n";

                    if ( $corp_site != 1 ){
                        $output .= '        <div class="control-wrapper cta-moc-container">'."\n";
                        $output .= '            <p>[cta_modify_cancel] your reservation</p>'."\n";
                        $output .= '        </div>'."\n";
                    }

                    break ;

                case 'set_b':

                    $output .= '        <div class="control-wrapper cta-title-container">'."\n";
                    $output .= '            <h3>Easy Booking at Low Rates</h3>'."\n";
                    $output .= '        </div>'."\n";
                    $output .= '        [cta_button]'."\n";

                    if ( $corp_site != 1 ) {
                        $output .= '        <div class="control-wrapper cta-moc-container">'."\n";
                        $output .= '            <p>[cta_modify_cancel] your reservation</p>'."\n";
                        $output .= '        </div>'."\n";
                    }

                    $output .= '        <div class="control-wrapper cta-inclusions-container">'."\n";
                    $output .=              $bpginclusion."\n";
                    $output .= '        </div>'."\n";

                    break ;

                case 'set_c':

                    $output .= '        [cta_bpg_title]'."\n";
                    $output .= '        [cta_select_properties]'."\n";
                    $output .= '        [cta_calendar]'."\n";
                    $output .=          $ctapromocode != 0 ? '[cta_promocode]'."\n" : '';
                    $output .= '        [cta_button]'."\n";

                    if ( $corp_site != 1 ) {
                        $output .= '        <div class="control-wrapper cta-moc-container">'."\n";
                        $output .= '            <p>[cta_modify_cancel] your reservation</p>'."\n";
                        $output .= '        </div>'."\n";
                    }

                    break ;

                default : /*set d*/

                    $output .= '        <div class="control-wrapper cta-title-container">'."\n";
                    $output .= '            <h3>Easy Booking at Low Rates</h3>'."\n";
                    $output .= '        </div>'."\n";
                    $output .= '        [cta_select_properties]'."\n";
                    $output .= '        [cta_calendar]'."\n";
                    $output .=          $ctapromocode != 0 ? '[cta_promocode]'."\n" : '';
                    $output .= '        [cta_button]'."\n";

                    if ( $corp_site != 1 ) {
                        $output .= '        <div class="control-wrapper cta-moc-container">'."\n";
                        $output .= '            <p>[cta_modify_cancel] your reservation</p>'."\n";
                        $output .= '        </div>'."\n";
                    }

                    break;
            }

        } else {
            switch ( $ctalayout ) {
                case 'set_a':

                    $output .= '        [cta_bpg_title]'."\n";
                    $output .= '        [cta_select_properties]'."\n";
                    $output .= '        [cta_button]'."\n";

                    if ( $corp_site != 1 ){
                        $output .= '        <div class="control-wrapper cta-moc-container">'."\n";
                        $output .= '            <p>[cta_modify_cancel] your reservation</p>'."\n";
                        $output .= '        </div>'."\n";
                    }

                    break ;

                case 'set_b':

                    $output .= '        [cta_bpg_title]'."\n";
                    $output .= '        [cta_select_properties]'."\n";
                    $output .= '        [cta_calendar]'."\n";
                    $output .=          $ctapromocode != 0 ? '[cta_promocode]'."\n" : '';
                    $output .= '        [cta_button]'."\n";

                    if ( $corp_site != 1 ){
                        $output .= '        <div class="control-wrapper cta-moc-container">'."\n";
                        $output .= '            <p>[cta_modify_cancel] your reservation</p>'."\n";
                        $output .= '        </div>'."\n";
                    }

                    break ;

                case 'set_c':

                    $output .= '        <div class="control-wrapper cta-title-container">'."\n";
                    $output .= '            <h3>Easy Booking at Low Rates</h3>'."\n";
                    $output .= '        </div>'."\n";
                    $output .= '        [cta_select_properties]'."\n";
                    $output .= '        [cta_button]'."\n";

                    if ( $corp_site != 1 ) {
                        $output .= '        <div class="control-wrapper cta-moc-container">'."\n";
                        $output .= '            <p>[cta_modify_cancel] your reservation</p>'."\n";
                        $output .= '        </div>'."\n";
                    }

                    break ;

                default : /*set d*/

                    $output .= '        <div class="control-wrapper cta-title-container">'."\n";
                    $output .= '            <h3>Easy Booking at Low Rates</h3>'."\n";
                    $output .= '        </div>'."\n";
                    $output .= '        [cta_select_properties]'."\n";
                    $output .= '        [cta_calendar]'."\n";
                    $output .=          $ctapromocode != 0 ? '[cta_promocode]'."\n" : '';
                    $output .= '        [cta_button]'."\n";

                    if ( $corp_site != 1 ) {
                        $output .= '        <div class="control-wrapper cta-moc-container">'."\n";
                        $output .= '            <p>[cta_modify_cancel] your reservation</p>'."\n";
                        $output .= '        </div>'."\n";
                    }

                    break;
            }
        }

        $output .= '    </div>'."\n";
        $output .= '</div>'."\n";

        return $output;
    }
}