<?php
/* THIRD PARTY */
if ( !function_exists( 'dwh_facebook' ) )
{
    function dwh_facebook( $parameter, $type, $return = false )
    {
        global $DWH_wponetheme_facebook;
        $DWH_wponetheme_facebook->counter = $DWH_wponetheme_facebook->counter + 1;

        wp_enqueue_script( 'dwh-facebook-defer' );

        $output = null;
        $url = isset( $parameter['url'] ) && dwh_empty( $parameter['url'] ) ? $parameter['url'] : $_SERVER['HTTP_HOST'];

        switch ( $type ) {
            case 'fblike':

                $showface    = isset( $parameter['showface'] ) && dwh_empty( $parameter['showface'] ) ? $parameter['showface'] : false;
                $share       = isset( $parameter['share'] ) && dwh_empty( $parameter['share'] ) ? $parameter['share'] : true;
                $colorscheme = isset( $parameter['colorscheme'] ) && dwh_empty( $parameter['colorscheme'] ) ? $parameter['colorscheme'] : 'light';
                $id          = isset( $parameter['id'] ) && dwh_empty( $parameter['id'] ) ? $parameter['id'] : 'fb-like-container-'.$DWH_wponetheme_facebook->counter;
                $layout      = isset( $parameter['layout'] ) && dwh_empty( $parameter['layout'] ) ? $parameter['layout'] : 'standard';

                $output .= '<div id="'.$id.'">'."\n";
                $output .= '    <div class="fb-like" data-href="'.$url.'" data-layout="'.$layout.'" data-action="like" data-show-faces="'.$showface.'" data-share="'.$share.'" data-colorshceme="'.$colorscheme.'"></div>'."\n";
                $output .= '</div>'."\n";
                break;

            case 'fbshare':

                $id     = isset( $parameter['id'] ) && dwh_empty( $parameter['id'] ) ? $parameter['id'] : 'fb-share-container-'.$DWH_wponetheme_facebook->counter;
                $layout = isset( $parameter['layout'] ) && dwh_empty( $parameter['layout'] ) ? $parameter['layout'] : 'button_count';

                $output .= '<div id="'.$id.'">'."\n";
                $output .= '    <div class="fb-share-button" data-href="'.$url.'" data-layout="'.$layout.'"></div>'."\n";
                $output .= '</div>'."\n";
                break;
        }

        if( $return ) return $output;
        echo $output;
    }
}

if ( !function_exists( 'dwh_google_maps' ) )
{
    function dwh_google_maps( $parameter, $return = false )
    {
        global $DWH_wponetheme_maps;
        $DWH_wponetheme_maps->counter = $DWH_wponetheme_maps->counter + 1;

        wp_enqueue_script( 'dwh-google-maps-defer' );

        $output         = null;
        $latitude       = isset( $parameter['latitude'] ) ? $parameter['latitude'] : null;
        $longitude      = isset( $parameter['longitude'] ) ? $parameter['longitude'] : null;
        $zoom           = isset( $parameter['zoom'] ) ? $parameter['zoom'] : 16;
        $iframe         = isset( $parameter['iframe'] ) ? $parameter['iframe'] : null;
        $height         = isset( $parameter['height'] ) ? $parameter['height'] : '420px';
        $width          = isset( $parameter['width'] ) ? $parameter['width'] : '100%';
        $id             = isset( $parameter['id'] ) ? $parameter['id'] : 'map-canvas-'.$DWH_wponetheme_maps->counter;

        if ( dwh_empty( $latitude ) && dwh_empty( $longitude ) ) {
            $output = '<div id="'.$id.'" style="width: '.$width.'; height: '.$height.'" data-lat="'.$latitude.'" data-lng="'.$longitude.'" data-zoom="'.$zoom.'"></div>';
        }

        if ( $return ) return $output;
        echo $output;
    }
}

if ( !function_exists( 'dwh_google_translate' ) )
{
    function dwh_google_translate( $return = false )
    {
        global $DWH_wponetheme_google_translate;

        $DWH_wponetheme_google_translate->counter = $DWH_wponetheme_google_translate->counter + 1;
        $args = $DWH_wponetheme_google_translate->util_object;
        $output  = '';

        add_action('wp_footer', function(){
            wp_enqueue_script( 'dwh-google-translate-defer' );
        });

        if ( $DWH_wponetheme_google_translate->counter > 1 ) {
            $output .= '<!--Google Translate Already Added-->';
        } else {
            $output .= '<div id="google-translate-container">'."\n";
            $output .= '    <div id="google_translate_element" class="translate"></div>'."\n";
            $output .= '</div>'."\n";
        }

        if ( $return ) return $output;
        echo $output;

    }
}

/* LEGACY SHORTCODES */
if ( !function_exists( 'dwh_gallery' ) )
{
    function dwh_gallery( $parameter, $type, $return = false )
    {
        global $DWH_wponetheme_grid;
        $DWH_wponetheme_grid->counter = $DWH_wponetheme_grid->counter + 1;

        $ids                    = isset( $parameter['ids'] ) && dwh_empty( $parameter['ids'] ) ? $parameter['ids'] : null;
        $containername          = isset( $parameter['name'] ) && dwh_empty( $parameter['name'] ) ? $parameter['name'] : 'gallery-grid-container-'.$DWH_wponetheme_grid->counter;
        $displaytitle           = isset( $parameter['caption'] ) && dwh_empty( $parameter['caption'] ) ? $parameter['caption'] : 'false';
        $titleonbottom          = isset( $parameter['title'] ) && dwh_empty( $parameter['title'] ) ? $parameter['title'] : 'false';
        $titleontop             = isset( $parameter['titleontop'] ) && dwh_empty( $parameter['titleontop'] ) ? $parameter['titleontop'] : 'false';
        $textalign              = isset( $parameter['textalign'] ) && dwh_empty( $parameter['textalign'] ) ? $parameter['textalign'] : 'center';
        $rel                    = isset( $parameter['rel'] ) && dwh_empty( $parameter['rel'] ) ? $parameter['rel'] : 'group';
        $colorbox               = isset( $parameter['colorbox'] ) && dwh_empty( $parameter['colorbox'] ) ? $parameter['colorbox'] : 'colorbox';
        $imagesize              = isset( $parameter['imagesize'] ) && dwh_empty( $parameter['imagesize'] ) ? $parameter['imagesize'] : 'medium';
        $displaycolorboxtitle   = isset( $parameter['displaycolorboxtitle'] ) && dwh_empty( $parameter['displaycolorboxtitle'] ) ? $parameter['displaycolorboxtitle'] : 'false';
        $columns                = isset( $parameter['columns'] ) && dwh_empty( $parameter['columns'] ) ? $parameter['columns'] : 4;
        $column                 = 12 / $columns;
        $ctr                    = 0;
        $output                 = '';
        $cbtitle                = null;

        switch ( $type ) {
            case 'grid':

                if( dwh_empty( $ids ) ) {
                    $imageids   = explode(',', $ids);

                    $output .= '<div id="'.$containername.'" class="gallery-grid-container">'."\n";
                    $output .= '    <div class="row-fluid">'."\n";

                    foreach ( $imageids as $key => $imageid ) {
                        $ctr = $key + 1;

                        $attachment = get_post( $imageid );

                        if ( $attachment ) {

                            $id             = $imageid;
                            $imagemodal     = wp_get_attachment_image_src( $imageid , array( 800, 800 ) );
                            $img_modal_src  = wp_get_attachment_image_url( $imageid, 'large' );
                            $img_src        = wp_get_attachment_image_url( $imageid, $imagesize );
                            $img_srcset     = wp_get_attachment_image_srcset( $imageid, 'full' );
                            $caption        = dwh_empty( $attachment->post_excerpt ) ? $attachment->post_excerpt : $attachment->post_content;
                            $description    = dwh_empty( $attachment->post_content ) ? $attachment->post_content : null;
                            $titletext      = dwh_empty( get_post_meta( $imageid, 'attachment_image_title', true ) ) ? get_post_meta( $imageid, 'attachment_image_title', true) : str_replace( array('-', '_'), ' ', get_the_title( $imageid ) );
                            $alttext        = dwh_empty( get_post_meta( $imageid, 'attachment_image_alt', true ) ) ? get_post_meta( $imageid, 'attachment_image_alt', true) : str_replace( array('-', '_'), ' ', get_the_title( $imageid ) );
                            $customlink     = dwh_empty( get_post_meta( $imageid, 'attachment_image_link', true ) ) ? get_post_meta( $imageid, 'attachment_image_link', true) : null;
                            $customclass    = dwh_empty( get_post_meta( $imageid, 'attachment_image_class', true ) ) ? get_post_meta( $imageid, 'attachment_image_class', true ) : null;
                            $expire         = dwh_empty( get_post_meta( $imageid, 'dwh_image_expire_date', true ) ) ? get_post_meta( $imageid, 'dwh_image_expire_date', true) : null;
                            $imagelink      = dwh_empty( $customlink ) ? $customlink : $img_modal_src;

                            $title          = str_replace( array('-', '_'), ' ', get_the_title( $imageid ) );
                            $isfirst        = ( $key < 1) ? 'active' : null;
                            $cbtitle        = ( $displaycolorboxtitle != 'false' ) ? ' title="'.$title.'"' : null;
                            $expire         = dwh_empty( $expire ) ? ' data-expiry="'.$expire.'"' : null;

                            $img        = '<img src="'.$img_src.'" srcset="'.esc_attr( $img_srcset ).'" alt="'.esc_attr( $alttext ).'" title="'.esc_attr( $titletext ).'" sizes="(max-width: '.esc_attr( $imagemodal[1] ).'px) 100vw, '.esc_attr( $imagemodal[1] ).'px" width="'.esc_attr( $imagemodal[1] ).'"/>';
                            $imgmodal   = '<img src="'.$img_modal_src.'" srcset="'.esc_attr( $img_srcset ).'" alt="'.esc_attr( $alttext ).'" title="'.esc_attr( $titletext ).'" sizes="(max-width: '.esc_attr( $imagemodal[1] ).'px) 100vw, '.esc_attr( $imagemodal[1] ).'px" width="'.esc_attr( $imagemodal[1] ).'"/>';


                            $output .= '<div id="grid-item-'.$imageid.'-'.$key.'" class="span'.$column.'"'.$expire.'>'."\n";

                            if ( $titleontop != 'false' ) {
                                $output .= '    <p class="align-'.$textalign.'">'.$title.'</p>';
                            }

                            $output .= '    <div class="image-container">'."\n";

                            switch ( $colorbox ) {
                                case 'colorbox-inline-img':
                                case 'colorbox-inline':
                                    $output .= '<a class="'.$colorbox.'" rel="'.$rel.'" href="#box-'.$imageid.'-'.$key.'"'.$cbtitle.'>'."\n";
                                    $output .= $img."\n";
                                    $output .= '</a>'."\n";

                                    $output .= '<div class="hide">'."\n";
                                    $output .= '      <div id="box-'.$imageid.'-'.$key.'">'."\n";
                                    if ( dwh_empty( $customlink ) ) {
                                        $output .= '        <a href="'.$customlink.'" class="'.$customclass.'">'."\n";
                                        $output .= $imgmodal."\n";
                                        $output .= '        </a>'."\n";
                                    } else {
                                        $output .= $imgmodal."\n";
                                    }
                                    $output .= '    </div>'."\n";
                                    $output .= '</div>'."\n";
                                    break;
                                case 'colorbox':
                                    $customclass .= ( dwh_empty( $customlink ) ) ? null : ' '.$colorbox;
                                    $output .= '<a class="'.$customclass.'"  href="'.$imagelink.'"'.$cbtitle.'>'."\n";
                                    $output .= $img."\n";
                                    $output .= '</a>'."\n";
                                    break;
                                default:
                                    $output .= $img."\n";
                                    break;
                            }

                            $output .= '    </div>'."\n";

                            if ( ( $displaytitle != 'false' || $titleonbottom != 'false' ) && ( $titleontop == 'false' ) ) {
                                $output .= '    <p class="align-'.$textalign.'">'.$title.'</p>';
                                $output .= '    <div class="caption">'.$caption.'</div>';
                            }

                            $output .= '</div>';
                            if ( ( $ctr % $columns ) === 0 ) {
                                if ( $imageid == end( $imageids ) ) {
                                    $output .= '</div>'."\n";
                                    $output .= '<div class="row-fluid">'."\n";
                                }
                            }
                        }
                    }

                    $output .= '    </div>'."\n";
                    $output .= '</div>'."\n";
                }

                break;
            case 'teaser':

                break;
        }


        if ( $return ) return $output;
        echo $output;
    }
}

if ( !function_exists( 'dwh_gallery_teaser' ) )
{
    function dwh_gallery_teaser( $parameter, $layout, $return = false )
    {

        global $DWH_wponetheme_teaser;
        $output = '';

        $ids                  = isset( $parameter['ids'] ) ? $parameter['ids'] : null;
        $spandiv              = isset($parameter['columns']) ? $parameter['columns'] : 3;
        $columns              = 12 / $spandiv;
        $readmore             = isset($parameter['readmore']) ? $parameter['readmore']: 'Read More';
        $imagesize            = isset($parameter['imagesize']) ? $parameter['imagesize'] : 'medium';
        $teaserlink           = isset($parameter['teaserlink']) ? $parameter['teaserlink'] : 'Read More';
        $teaserlinktext       = isset($parameter['teaserlinktext']) ? $parameter['teaserlinktext'] : $teaserlink;
        $titleontop           = isset($parameter['titleontop']) ? $parameter['titleontop'] : 'false';
        $rel                  = isset($parameter['rel']) ? $parameter['rel'] : 'group';
        $colorbox             = isset($parameter['colorbox']) ? $parameter['colorbox'] : 'colorbox';
        $displaycolorboxtitle = isset($parameter['displaycolorboxtitle']) ? $parameter['displaycolorboxtitle'] : 'false';

        switch ( $layout ) {

            case 'teaser' :
                if( $ids != null ) {
                    $imageids   = explode(',', $ids);

                    $output .= '<div id="teaser-container">';
                    $output .= '    <div class="row-fluid">';

                    foreach( $imageids as $key => $imageid ):

                        $ctr = $key+1;
                        $attachment = get_post($imageid);

                        if( $attachment ){

                            $customlink = get_post_meta( $imageid, 'attachment_image_link', true );
                            $customclass = get_post_meta( $imageid, 'attachment_image_class', true );
                            $titletext = get_post_meta( $imageid, 'attachment_image_title', true );
                            $alttext = get_post_meta( $imageid, 'attachment_image_alt', true );
                            $offset = get_post_meta( $imageid, 'attachment_offset', true );
                            $offset = $offset != '' ? ' offset'. $offset : '';

                            $ctr = $key + 1;
                            $imagelink = dwh_get_value( $customlink, wp_get_attachment_image_src( $imageid, array(800, 800) )[0] );

                            $cboxtitle = '';
                            if( strtolower($displaycolorboxtitle) != 'false' ){

                                $cboxtitle = 'title ="'. $attachment->post_title .'"';
                            }

                            $output .= '<div class="span'. $columns . $offset.'">';


                            if( strtolower($titleontop) != 'false' ) :

                            $output .= '    <p class="sub-title"> '.$attachment->post_title.' </p>';

                            endif;

                            $output .= '    <div class="teaser-box">';
                            $output .= '        <div class="image-container">';

                                            if( $colorbox === 'colorbox-inline' ) :

                                    $output .= '<a class="the-colorbox-inline '. $colorbox.'" rel="'.$rel.'" href="#box-'. $imageid.'"  '.$cboxtitle.'>';
                                    $output .= '    <img src="'.wp_get_attachment_image_src( $imageid, $imagesize )[0].'" alt="'.$alttext.'" title="'. $titletext.'"/>';
                                    $output .= '</a>';
                                    $output .= '    <div class="hide">';
                                    $output .= '        <div id="box-'.$imageid.'">';

                                                    if( $customlink ):

                                    $output .= '            <a href="'. $customlink.'" class="'.$customclass.'">';
                                    $output .= '                <img src="'.wp_get_attachment_image_src($imageid, array(800, 800))[0].'" alt="'.$alttext.'" title="'. $titletext.'" />';
                                    $output .= '            </a>';
                                                    else:

                                    $output .= '            <img src="'.wp_get_attachment_image_src($imageid, array(800, 800))[0].' " alt="'.$alttext.'" title="'. $titletext.'" />';

                                                    endif;


                                    $output .= '        </div>';
                                    $output .= '    </div>';


                                            elseif( $colorbox === 'colorbox') :

                                                $link = $customlink == '' ? $colorbox : ' ' .$customclass;
                                    $output .= '<a class="the-colorbox '.$link.'" rel="'.$rel.'" href="'.$imagelink.'" '. $cboxtitle.'>';
                                    $output .= '    <img src="'.wp_get_attachment_image_src($imageid, $imagesize )[0].'" alt="'.$alttext.'" title="'.$titletext.'"/>';
                                    $output .= '</a>';

                                            else :

                                                    $link = $customlink != '' ? $customclass : '';
                                    $output .= '<a class="default '.$colorbox.' '.$link.'" rel="'.$rel .'-'. $imageid.'" href="'.$imagelink.'" '.$cboxtitle.'>';
                                    $output .= '    <img src="'.wp_get_attachment_image_src($imageid, $imagesize)[0].'" alt="'.$alttext.'" title="'.$titletext.'"/>';
                                    $output .= '</a>';

                                            endif;


                            $output .= '        </div>';
                            $output .= '        <div class="teaser-details">';


                                    if( strtolower($titleontop) == 'false' ):

                            $output .= '    <p class="sub-title"> '.$attachment->post_title.' </p>';

                                    endif;

                                    if($attachment->post_excerpt != null):

                            $output .=     wpautop( $attachment->post_excerpt );

                                    endif;

                                    if( strtolower($teaserlink) != 'false' ) :
                                        if( $customlink !="" ):

                                $output .= '    <a class="teaserlink link '.$customclass.'" href="'.$customlink.'">'.$teaserlinktext.' </a>';

                                        endif;
                                    endif;

                            $output .= '        </div>';
                            $output .= '    </div>';

                            $output .= '    <div class="teaser-content">';
                            $output .=      wpautop( $attachment->post_content );

                                if( strtolower($readmore) != 'false' ) :

                                    if( $customlink != "" ):

                                $output .= '    <a class="readmore link '.$customclass.'" href="'.$customlink.'"> '.$readmore.' </a>    ';

                                    endif;
                                endif;

                            $output .= '    </div>';

                            $output .= '</div>';


                            if( ( $ctr % $spandiv ) === 0 ) :

                                if( $ctr !== count($imageids) ) :

                            $output .= ' </div>';
                            $output .= '<div class="row-fluid"> ';

                                endif;
                            endif;

                        }
                    endforeach;

                    $output .= '    </div>';
                    $output .= '</div>';

                }else{
                    $output .= '<p style="color:red">Gallery teaser error: No image ID found</p>';
                }
            break;


        } /* END SWITCH */

        if($return) return $output;

        echo $output;
    }
}

if ( !function_exists( 'dwh_accordion' ) )
{
    function dwh_accordion( $parameter, $layout, $content = null, $return = false )
    {
        global $DWH_wponetheme_accordion;
        $DWH_wponetheme_accordion->counter = $DWH_wponetheme_accordion->counter + 1;

        wp_enqueue_script('dwh-legacy');

        $output = '';
        $ids            = isset( $parameter['ids'] ) && dwh_empty( $parameter['ids'] ) ? $parameter['ids'] : null;
        $containername  = isset( $parameter['name'] ) && dwh_empty( $parameter['name'] ) ? $parameter['name'] : 'accordion-container';
        $ctabuttonlink  = isset( $parameter['ctabuttonlink'] ) && dwh_empty( $parameter['ctabuttonlink'] ) ? $parameter['ctabuttonlink'] : 'Check availability and price';
        $class          = isset( $parameter['class'] ) && dwh_empty( $parameter['class'] ) ? $parameter['class'] : 'button ctapackage';
        $spanimageclass = isset( $parameter['spanimageclass'] ) && dwh_empty( $parameter['spanimageclass'] ) ? $parameter['spanimageclass'] : 3;
        $ctabutton      = isset( $parameter['ctabuttonlink'] ) && dwh_empty( $parameter['ctabutton'] ) ? $parameter['ctabutton'] : false;
        $showfirst      = isset( $parameter['showfirst'] ) && dwh_empty( $parameter['showfirst'] ) ? $parameter['showfirst'] : true;
        $rel            = isset( $parameter['rel'] ) && dwh_empty( $parameter['rel'] ) ? $parameter['rel'] : 'group';
        $colorbox       = isset( $parameter['colorbox'] ) && dwh_empty( $parameter['colorbox'] ) ? $parameter['colorbox'] : 'colorbox';
        $isocolorbox    = isset( $parameter['iscolorbox'] ) && dwh_empty( $parameter['iscolorbox'] ) ? $parameter['iscolorbox'] : true;
        $imagesize      = isset( $parameter['imagesize'] ) && dwh_empty( $parameter['imagesize'] ) ? $parameter['imagesize'] : 'medium';
        $id             = isset( $parameter['id'] ) && dwh_empty( $parameter['id'] ) ? $parameter['id'] : 'accordion-container-'.$DWH_wponetheme_accordion->counter;;
        $title          = isset( $parameter['title'] ) && dwh_empty( $parameter['title'] ) ? $parameter['title'] : '';

        switch ( $layout ) {
            case 'accordions':
                $output .= '<div id="accordion-container" class="accordion-container">'."\n";
                $output .= '    <ul class="list-accordion">'."\n".dwh_modify_the_content( $content )."\n".'</ul>'."\n";
                $output .= '</div>'."\n";
                break;
            case 'accordion':

                $output .= '<li class="accordion-item">'."\n";
                $output .= '    <div class="accordion-caption">'."\n";
                $output .= '        <a href="#?">'.$title.'</a>'."\n";
                $output .= '    </div>'."\n";
                $output .= '    <div class="accordion-content">'."\n".dwh_modify_the_content( $content )."\n".'</div>'."\n";
                $output .= '</li>'."\n";
                break;
            case 'gallery':

                $spandetailclass    = 12 - $spanimageclass;
                $showfirstclass     = ( !$showfirst ) ? ' showfirst' : '';

                if( dwh_empty( $ids ) ) {
                    $imageids   = explode(',', $ids);

                    $output .= '<div id="'.$containername.'">'."\n";
                    $output .= '    <ul class="list-accordion'.$showfirstclass.'">'."\n";

                    foreach ( $imageids as $key => $imageid ) {

                        $attachment = get_post( $imageid );

                        if ( $attachment ) {

                            $imagemodal     = wp_get_attachment_image_src( $imageid , array( 800, 800 ) );
                            $img_modal_src  = wp_get_attachment_image_url( $imageid, 'large' );
                            $img_src        = wp_get_attachment_image_url( $imageid, $imagesize );
                            $img_srcset     = wp_get_attachment_image_srcset( $imageid, 'full' );
                            $caption        = dwh_empty( $attachment->post_excerpt ) ? $attachment->post_excerpt : $attachment->post_content;
                            $description    = dwh_empty( $attachment->post_content ) ? $attachment->post_content : null;
                            $titletext      = dwh_empty( get_post_meta( $imageid, 'attachment_image_title', true ) ) ? get_post_meta( $imageid, 'attachment_image_title', true) : str_replace( array('-', '_'), ' ', get_the_title( $imageid ) );
                            $alttext        = dwh_empty( get_post_meta( $imageid, 'attachment_image_alt', true ) ) ? get_post_meta( $imageid, 'attachment_image_alt', true) : str_replace( array('-', '_'), ' ', get_the_title( $imageid ) );
                            $customlink     = dwh_empty( get_post_meta( $imageid, 'attachment_image_link', true ) ) ? get_post_meta( $imageid, 'attachment_image_link', true) : null;
                            $customclass    = dwh_empty( get_post_meta( $imageid, 'attachment_image_class', true ) ) ? get_post_meta( $imageid, 'attachment_image_class', true ) : null;
                            $expire         = dwh_empty( get_post_meta( $imageid, 'dwh_image_expire_date', true ) ) ? get_post_meta( $imageid, 'dwh_image_expire_date', true) : null;
                            $imagelink      = dwh_empty( $customlink ) ? $customlink : $img_modal_src;

                            $title          = str_replace( array('-', '_'), ' ', get_the_title( $imageid ) );
                            $isfirst        = ( $key < 1) ? 'active' : null;

                            $img        = '<img src="'.$img_src.'" srcset="'.esc_attr( $img_srcset ).'" alt="'.esc_attr( $alttext ).'" title="'.esc_attr( $titletext ).'" sizes="(max-width: '.esc_attr( $imagemodal[1] ).'px) 100vw, '.esc_attr( $imagemodal[1] ).'px" width="'.esc_attr( $imagemodal[1] ).'"/>';
                            $imgmodal   = '<img src="'.$img_modal_src.'" srcset="'.esc_attr( $img_srcset ).'" alt="'.esc_attr( $alttext ).'" title="'.esc_attr( $titletext ).'" sizes="(max-width: '.esc_attr( $imagemodal[1] ).'px) 100vw, '.esc_attr( $imagemodal[1] ).'px" width="'.esc_attr( $imagemodal[1] ).'"/>';

                            $output .= '<li class="accordion-item">'."\n";
                            $output .= '    <div class="accordion-caption" data-expiry="'.$expire.'">'."\n";
                            $output .= '        <a href="#accordion-content-'.$key.'" class="'.$isfirst.'">'.$title.'</a>'."\n";
                            $output .= '    </div>'."\n";
                            $output .= '    <div id="accordion-content-'.$key.'" class="accordion-content" data-expiry="'.$expire.'">'."\n";
                            $output .= '        <div class="row-fluid">'."\n";
                            $output .= '            <div class="span'.$spanimageclass.'">'."\n";
                            $output .= '                <div class="image-container">'."\n";
                            switch ( $colorbox ) {
                                case 'colorbox-inline':
                                    $output .= '<a class="'.$colorbox.'" rel="'.$rel.'" href="#box-'.$imageid.'-'.$key.'" title="'.$title.'">'."\n";
                                    $output .= $img."\n";
                                    $output .= '</a>'."\n";

                                    $output .= '<div class="hide">'."\n";
                                    $output .= '      <div id="box-'.$imageid.'-'.$key.'">'."\n";
                                    if ( dwh_empty( $customlink ) ) {
                                        $output .= '        <a href="'.$customlink.'" class="'.$customclass.'">'."\n";
                                        $output .= $imgmodal."\n";
                                        $output .= '        </a>'."\n";
                                    } else {
                                        $output .= $imgmodal."\n";
                                    }
                                    $output .= '    </div>'."\n";
                                    $output .= '</div>'."\n";

                                    break;

                                case 'colorbox':

                                    $customclass .= ( dwh_empty( $customlink ) ) ? null : ' '.$colorbox;
                                    $output .= '<a class="'.$customclass.'"  href="'.$imagelink.'" title="'.$title.'">'."\n";
                                    $output .= $img."\n";
                                    $output .= '</a>'."\n";

                                    break;
                                default:

                                    $output .= $img."\n";

                                    break;
                            }
                            $output .= '                </div>'."\n";
                            $output .= '            </div>'."\n";
                            $output .= '            <div class="span'.$spandetailclass.'">'."\n";
                            $output .= '                <p class="sub-title">'.$title.'</p>'."\n";
                            $output .= dwh_modify_the_content( $description );
                            if ( $ctabutton !== 'false' ) {
                                $ctalink = dwh_empty( $customlink ) ? $customlink : dwh_cta_link('ctalink');
                                $output .= '<a href="'.$ctalink.'" class="'.$class.' '.$customclass.'">'.$ctabuttonlink.'</a>'."\n";
                            }
                            $output .= '            </div>'."\n";
                            $output .= '        </div>'."\n";
                            $output .= '    </div>'."\n";
                            $output .= '</li>'."\n";
                        }
                    }

                    $output .= '    </ul>'."\n";
                    $output .= '</div>'."\n";
                }

                break;
        }


        if ( $return ) return $output;
        echo $output;
    }
}

if ( !function_exists( 'dwh_tabs' ) )
{
    function dwh_tabs( $parameter, $layout, $content = null, $return = false )
    {
        global $DWH_wponetheme_tabs;
        $html = $DWH_wponetheme_tabs->load_shortcode_content( $content );

        wp_enqueue_script( 'dwh-legacy' );

        $output = '';

        switch ( $layout ) {
            case 'tabs' :

                $DWH_wponetheme_tabs->counter = $DWH_wponetheme_tabs->counter + 1;
                $DWH_wponetheme_tabs->ctr = 0;

                $tabatts = dwh_get_shortcode_atts( $content, array('dwh_tab') );
                $tabtitles = dwh_get_shortcode_atts_value( $tabatts, 'title' );

                $id = isset( $parameter['name'] ) && dwh_empty( $parameter['name'] ) ? $parameter['name'].$DWH_wponetheme_tabs->counter : 'tab-container-'.$DWH_wponetheme_tabs->counter;

                $output .= '<div id="'.$id.'" class="tabs tab-container-shortcode">';
                $output .= '    <ul class="tab-menu">';
                foreach( $tabtitles as $key => $tabtitle ) {
                    $active = ( $key < 1 ) ? 'active' : null;
                    $output .= '        <li><a href="#tab-container-id-'.$key.'" class="'.$active.'">'.$tabtitle.'</a></li>';
                }
                $output .= '    </ul>';
                $output .= dwh_modify_the_content( $html );
                $output .= '</div>';

                break;

            case 'tab' :

                $show = ( $DWH_wponetheme_tabs->ctr < 1 ) ? 'show ' : null;
                $title = isset( $parameter['title'] ) && dwh_empty( $parameter['title'] ) ? $parameter['title'] : '';

                $output .= '<div id="tab-container-id-'.$DWH_wponetheme_tabs->ctr.'" class="'.$show.'tab tab-container" data-title="'.$title.'">';
                $output .=  dwh_modify_the_content( $html );
                $output .= '</div>';

                $DWH_wponetheme_tabs->ctr++;

                break;

            case 'gallery' :
                $DWH_wponetheme_tabs->counter = $DWH_wponetheme_tabs->counter + 1;

                 $id = isset( $parameter['name'] ) && dwh_empty( $parameter['name'] ) ? $parameter['name'].$DWH_wponetheme_tabs->counter : 'tab-container-'.$DWH_wponetheme_tabs->counter;
                $ids = isset( $parameter['ids'] ) && dwh_empty( $parameter['ids'] ) ? $parameter['ids'] : null;
                $colorbox = isset( $parameter['colorbox'] ) && dwh_empty( $parameter['colorbox'] ) ? $parameter['colorbox'] : 'colorbox';
                $imagesize = isset( $parameter['imagesize'] ) && dwh_empty( $parameter['imagesize'] ) ? $parameter['imagesize'] : 'medium';
                $displaycolorboxtitle = isset( $parameter['displaycolorboxtitle'] ) && dwh_empty( $parameter['displaycolorboxtitle'] ) ? $parameter['displaycolorboxtitle'] : 'false';

                if ( dwh_empty( $ids ) ) {

                    $imageids = explode( ',', $ids );

                    $output .= '<div id="'.$id.'" class="tabs gallery-container">';
                    $output .= '    <ul class="tab-menu">';

                    foreach ( $imageids as $key => $imageid ) {

                        $attachment = get_post( $imageid );

                        if ( $attachment ) {

                            $title          = str_replace( array('-', '_'), ' ', get_the_title( $imageid ) );
                            $isfirst        = ( $key < 1) ? 'active' : null;

                            $output .= '        <li>'."\n";
                            $output .= '            <a href="#tabmenucontainer'.$imageid.'-'.$key.'" class="'.$isfirst.'">'.$title.'</a>'."\n";
                            $output .= '        </li>'."\n";

                        }

                    }

                    $output .= '    </ul>'."\n";

                    foreach ( $imageids as $key => $imageid ) {

                        $attachment = get_post( $imageid );

                        if ( $attachment ) {

                            $imagemodal     = wp_get_attachment_image_src( $imageid , array( 800, 800 ) );
                            $img_modal_src  = wp_get_attachment_image_url( $imageid, 'large' );
                            $img_src        = wp_get_attachment_image_url( $imageid, $imagesize );
                            $img_srcset     = wp_get_attachment_image_srcset( $imageid, 'full' );
                            $caption        = dwh_empty( $attachment->post_excerpt ) ? $attachment->post_excerpt : $attachment->post_content;
                            $description    = dwh_empty( $attachment->post_content ) ? $attachment->post_content : null;
                            $titletext      = dwh_empty( get_post_meta( $imageid, 'attachment_image_title', true ) ) ? get_post_meta( $imageid, 'attachment_image_title', true) : str_replace( array('-', '_'), ' ', get_the_title( $imageid ) );
                            $alttext        = dwh_empty( get_post_meta( $imageid, 'attachment_image_alt', true ) ) ? get_post_meta( $imageid, 'attachment_image_alt', true) : str_replace( array('-', '_'), ' ', get_the_title( $imageid ) );
                            $customlink     = dwh_empty( get_post_meta( $imageid, 'attachment_image_link', true ) ) ? get_post_meta( $imageid, 'attachment_image_link', true) : null;
                            $customclass    = dwh_empty( get_post_meta( $imageid, 'attachment_image_class', true ) ) ? get_post_meta( $imageid, 'attachment_image_class', true ) : null;
                            $expire         = dwh_empty( get_post_meta( $imageid, 'dwh_image_expire_date', true ) ) ? get_post_meta( $imageid, 'dwh_image_expire_date', true) : null;
                            $imagelink      = dwh_empty( $customlink ) ? $customlink : $img_modal_src;
                            $title          = str_replace( array('-', '_'), ' ', get_the_title( $imageid ) );
                            $isfirst        = ( $key < 1) ? 'show' : null;
                            $cbtitle        = ( $displaycolorboxtitle != 'false' ) ? ' title="'.$title.'"' : null;

                            $img            = '<img src="'.$img_src.'" srcset="'.esc_attr( $img_srcset ).'" alt="'.esc_attr( $alttext ).'" title="'.esc_attr( $titletext ).'" sizes="(max-width: '.esc_attr( $imagemodal[1] ).'px) 100vw, '.esc_attr( $imagemodal[1] ).'px" width="'.esc_attr( $imagemodal[1] ).'"/>';
                            $imgmodal       = '<img src="'.$img_modal_src.'" srcset="'.esc_attr( $img_srcset ).'" alt="'.esc_attr( $alttext ).'" title="'.esc_attr( $titletext ).'" sizes="(max-width: '.esc_attr( $imagemodal[1] ).'px) 100vw, '.esc_attr( $imagemodal[1] ).'px" width="'.esc_attr( $imagemodal[1] ).'"/>';

                            $output .= '<div id="tabmenucontainer'.$imageid.'-'.$key.'" class="tab-container '.$isfirst.'">'."\n";
                            $output .= '    <div class="tab-content">'."\n";
                            $output .= '        <div class="row-fluid">'."\n";
                            $output .= '            <div class="span4">'."\n";
                            $output .= '                <div class="image-container">'."\n";

                            switch ( $colorbox ) {
                                case 'colorbox-inline':
                                    $output .= '            <a class="'.$colorbox.'" href="#box-'.$imageid.'-'.$key.'"  '.$cboxtitle.'>'."\n";
                                    $output .= $img;
                                    $output .= '            </a>'."\n";

                                    $output .= '<div class="hide">'."\n";
                                    $output .= '      <div id="box-'.$imageid.'-'.$key.'">'."\n";
                                    if ( dwh_empty( $customlink ) ) {
                                        $output .= '        <a href="'.$customlink.'" class="'.$customclass.'">'."\n";
                                        $output .= $imgmodal."\n";
                                        $output .= '        </a>'."\n";
                                    } else {
                                        $output .= $imgmodal."\n";
                                    }
                                    $output .= '    </div>'."\n";
                                    $output .= '</div>'."\n";
                                    break;

                                case 'colorbox':

                                    $customclass .= ( dwh_empty( $customlink ) ) ? null : ' '.$colorbox;
                                    $output .= '<a class="'.$customclass.'"  href="'.$imagelink.'" title="'.$title.'">'."\n";
                                    $output .= $img."\n";
                                    $output .= '</a>'."\n";
                                    break;

                                default:

                                    $output .= $img."\n";
                                    break;

                            }

                            $output .= '                </div>'."\n";
                            $output .= '            </div>'."\n";
                            $output .= '            <div class="span8">'."\n";
                            $output .= '                <p class="sub-title">'.$title.'</p>'."\n";
                            $output .= '                <div>'.$description.'</div>'."\n";
                            $output .= '            </div>'."\n";
                            $output .= '        </div>'."\n";
                            $output .= '    </div>'."\n";
                            $output .= '</div>'."\n";
                        }

                    }


                    $output .= '</div>'."\n";
                }

                break;
        }

        if ( $return ) return $output;

        echo $output;
    }
}

/* CONVERTED WIDGETS */
if ( !function_exists( 'dwh_address' ) )
{
    function dwh_address( $type = 'inline', $return = false )
    {

        $address = dwh_empty( dwh_get_data('address','onetheme_hotel_options') ) ? dwh_get_data('address','onetheme_hotel_options') : false;
        $sep     = ( $type === 'inline' ) ? ' ' : '<br />';

        $content = '<div class="address-container">';
        if ( $address ) {
            $content .= dwh_empty( $address['street1'] ) && isset( $address['street1'] ) ? $address['street1'].$sep : null;
            $content .= dwh_empty( $address['street2'] ) && isset( $address['street2'] ) ? $address['street2'].$sep : null;
            $content .= dwh_empty( $address['state'] ) && isset( $address['state'] ) ? $address['state'].$sep : null;
            $content .= dwh_empty( $address['country'] ) && isset( $address['country'] ) ? $address['country'].$sep : null;
            $content .= dwh_empty( $address['zipcode'] ) && isset( $address['zipcode'] ) ? $address['zipcode'] : null;
        }
        $content .= "</div>";

        if ( $return ) {
            return $content;
        } else {
            echo $content;
        }
    }
}

if ( !function_exists( 'dwh_copyright' ) )
{
    function dwh_copyright( $content, $return = false )
    {
        $content = dwh_empty( $content ) ? '<div class="copyright">'.$content.'</div>' : '<div class="copyright">&copy; Copyright '.date('Y').'. All Rights Reserved. Powered by DirectWithHotels</div>';

        if ( $return ) return $content;
        echo $content;
    }
}

if ( !function_exists( 'dwh_iframe' ) )
{
    function dwh_iframe( $atts, $return = false )
    {
        global $DWH_wponetheme_iframe;
        $DWH_wponetheme_iframe->counter = $DWH_wponetheme_iframe->counter + 1;

        $class  = isset( $atts['class'] ) && dwh_empty( $atts['class'] ) ? ' iframe-container '.$atts['class'] : ' iframe-container';
        $src    = isset( $atts['src'] ) && dwh_empty( $atts['src'] ) ? $atts['src'] : null;
        $style  = isset( $atts['style'] ) && dwh_empty( $atts['style'] ) ? $atts['style'] : null;
        $param  = isset( $atts['param'] ) && dwh_empty( $atts['param'] ) ? $atts['param'] : null;
        $id     = isset( $atts['name'] ) && dwh_empty( $atts['name'] ) ? $atts['name'] : 'iframe-container-'.$DWH_wponetheme_iframe->counter;

        $type   = isset( $atts['type'] ) && dwh_empty( $atts['type'] ) ? $atts['type'] : 'src';

        switch ( $type ) {
            case 'html':
                $html = $src;
                break;
            case 'src':
            default:
                $html = '<iframe id="'.$id.'" src="'.$src.'" style="'.$style.'" class="iframe-content'.$class.'"'.$param.'></iframe>';
                break;
        }

        if( $return ) return $html;
        echo $html;
    }
}

if ( !function_exists( 'dwh_widget' ) )
{
    function dwh_widget( $atts )
    {
        $widget_name = isset( $atts['name'] ) ? $atts['name'] : null;
        $widget_instance = isset( $atts['instance'] ) ? $atts['instance'] : array();
        $widget_args = isset( $atts['args'] ) ? $atts['args'] : array();

        if ( dwh_empty( $widget_name ) ) {

            if ( is_active_widget( false, false, $widget_name, true ) ) {

                the_widget( $widget_name, $widget_instance, $widget_args );

            } else {

                echo '<!-- widget '.$atts['name'].' not registered -->';

            }

        }
    }
}

if ( !function_exists( 'dwh_logo' ) )
{
    function dwh_logo( $attr = 'default', $return = false ) {
        $custom_logo_id = dwh_get_data( 'logo', 'onetheme_customizer_options' );

        $output       = '';
        $image        = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        $image_srcset = wp_get_attachment_image_srcset( $custom_logo_id  , 'full' );
        $image_title  = dwh_empty( get_post_meta( $custom_logo_id, '_wp_attachment_image_title', true ) ) ? get_post_meta( $custom_logo_id, '_wp_attachment_image_title', true) : get_the_title( $custom_logo_id );
        $image_alt    = dwh_empty( get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true ) ) ? get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true) : get_the_title( $custom_logo_id );
        $image_class  = isset( $parameter['class'] ) ? $parameter['class'] : null;
        $image_url    = ( is_ssl() ) ? str_replace( 'http://', 'https://', $image[0] ) : $image[0];
        $image_width  = $image[1];
        $image_height = $image[2];
        $attr         = dwh_empty( $image ) ? $attr : 'noid';

        switch ( $attr ) {
            case 'noid':
                $output = bloginfo('title');
                break;
            case 'id':
                $output = $custom_logo_id;
                break;
            case 'default':
                // $output  = '<div id="logo-container">'."\n";
                // $output .= '    <a href="'.home_url().'" class="logo" rel="home">'."\n";
                // $output .= '        <img src="'.$image_url.'" width="'.$image_width.'" title="'.$image_title.'" alt="'.$image_alt.'">'."\n";
                // $output .= '    </a>'."\n";
                // $output .= '</div>'."\n";
                $output  = '<div id="logo-container">'."\n";
                $output .= '    <a href="'.home_url().'" class="logo" rel="home">'."\n";
                $output .= '        <img src="'.$image_url.'" alt="'.$image_alt.'" title="'.$image_title.'" srcset="'.$image_srcset.'" width="'.$image_width.'" sizes="( max-width: '.$image_width.'px ) 100vw, '.$image_width.'px"/>'."\n";
                $output .= '    </a>'."\n";
                $output .= '</div>'."\n";
                break;
            case 'src':
                $output = $image_url;
                break;
            case 'width':
                $output = $image_width;
                break;
            case 'height':
                $output = $image_height;
                break;
            case 'image':
                $output = '<img src="'.$image_url.'" title="'.$image_title.'" alt="'.$image_alt.'">';
                break;
            default:
                if ( function_exists( 'the_custom_logo' ) ) {
                    the_custom_logo();
                }
                break;
        }

        if ( $return ) return $output;
        else echo $output;

    }
}

if ( !function_exists( 'dwh_main_banner' ) )
{
    function dwh_main_banner( $args = array() ) {

        $hideslider = dwh_get_data( 'slider_display_flag' );
        $slideritem = dwh_empty( dwh_get_data( 'slider-item' ) ) ? dwh_get_data( 'slider-item' ) : false;
        $sliderdata = dwh_empty( dwh_get_data( 'slider-data' ) ) ? dwh_get_data( 'slider-data' ) : false;
        $sliderattr = dwh_empty( dwh_get_data( 'slider-attribute' ) ) ? dwh_get_data( 'slider-attribute' ) : false;

        if ( !$hideslider ) {

            if ( $sliderdata && $slideritem ) {

                $sliderdata['datasrc'] = 'slider-item';
                $sliderdata['controlnavthumbs'] = ( $sliderdata['type'] == 'thumbnail' ) ? true : false;
                $sliderdata['controlnav'] = ( $sliderdata['type'] == 'default' ) ? false : true;
                $sliderdata['id'] = ( isset( $args['id'] ) && dwh_empty( $args['id'] ) ) ? $args['id'] : 'main-banner';

                if ( $sliderattr ) {
                    foreach ( $sliderattr as $value ) {
                        $key = $value['slider_key'];
                        $val = $value['slider_value'];
                        $sliderdata[$key] = $val;
                    }
                }

                if ( $args ) {
                    foreach( $args as $args_key => $args_value ) {
                        $sliderdata[$args_key] = $args_value;
                    }
                }

                dwh_slider( $sliderdata );

            } else {

                echo '<div id="main-banner-container">'."\n";
                dwh_default_banner();
                echo '</div>'."\n";

            }
        }

    }
}

if ( !function_exists( 'dwh_main_menu' ) )
{
    function dwh_main_menu( $return = false )
    {
        $output = '';

        if ( dwh_get_theme_template() === 'v1' ) {

            $args =  array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'menu-primary-menu',
                            'menu_class'     => 'menu visible-layer',
                            'container'      => 'ul',
                            'walker'         => new DWH_wponetheme_nav_walker()
                        );

            $output .= '<div id="main-menu-container">'."\n";
            $output .= '    <nav id="main-menu">'."\n";
            $output .= '        <a id="rmenu" class="hide-layer" href="#?">'."\n";
            $output .= '            <span>Menu</span>'."\n";
            $output .= '            <div class="rmenu">'."\n";
            $output .= '                <span class="line"></span>'."\n";
            $output .= '                <span class="line"></span>'."\n";
            $output .= '                <span class="line"></span>'."\n";
            $output .= '            </div>'."\n";
            $output .= '        </a>'."\n";
            $output .= dwh_get_wp_nav_menu( $args );
            $output .= '    </nav>'."\n";
            $output .= '</div>'."\n";

        } else {

            $args =  array(
                            'theme_location'  => 'primary',
                            'container_id'    => 'main-menu',
                            'container_class' => 'show-layer',
                            'container'       => 'div',
                            'walker'          => new DWH_wponetheme_nav_walker()
                        );

            $output .= '<div id="main-menu-container">'."\n";
            $output .= '    <a id="main-menu-icon" class="hide-layer" href="#?"><span class="line"></span></a>'."\n";
            $output .= dwh_get_wp_nav_menu( $args );
            $output .= '</div>'."\n";
        }

        if ( $return ) return $output;
        echo $output;
    }
}

if ( !function_exists( 'dwh_scroll_to' ) )
{
    function dwh_scroll_to( $parameter, $return = false )
    {
        global $DWH_wponetheme_util;

        $caption        = isset( $parameter['caption'] ) && dwh_empty( $parameter['caption'] ) ? $parameter['caption'] : '<span>Back To Top</span>';

        $displayinfront = isset( $parameter['displayinfront'] ) && dwh_empty( $parameter['displayinfront'] ) ? $parameter['displayinfront'] : false;
        $displayinfront = isset( $parameter['frontpageonly'] ) && dwh_empty( $parameter['frontpageonly'] ) ? $parameter['frontpageonly'] : false;

        $tag            = isset( $parameter['tag'] ) && dwh_empty( $parameter['tag'] ) ? $parameter['tag'] : 'body';
        $type           = isset( $parameter['type'] ) && dwh_empty( $parameter['type'] ) ? $parameter['type'] : 'default';
        $speed          = isset( $parameter['speed'] ) && dwh_empty( $parameter['speed'] ) ? $parameter['speed'] : 'slow';
        $href           = isset( $parameter['href'] ) && dwh_empty( $parameter['href'] ) ? $parameter['href'] : '#?';
        $id             = isset( $parameter['id'] ) && dwh_empty( $parameter['id'] ) ? ' id="'.$parameter['id'].'"' : null;
        $class          = isset( $parameter['class'] ) && dwh_empty( $parameter['class'] ) ? ' '.$parameter['class'] : null;


        $output  = '';

        switch ( $type ) {
            case 'bounce':
                $caption = isset( $parameter['caption'] ) && dwh_empty( $parameter['caption'] ) ? $parameter['caption'] : 'Discover';
                $output .= '<div class="bounce-container">'."\n";
                $output .= '    <div class="bounce">'."\n";
                $output .= '        <a href="#main" class="bounce-arrow scroll-to" data-speed="'.$speed.'"></a>'."\n";
                $output .= '        <a class="bounce-caption">'.$caption.'</a>'."\n";
                $output .= '    </div>'."\n";
                $output .= '</div>'."\n";
                break;
            default:
                $output .= '<div'.$id.' class="scroll-to-container'.$class.'">'."\n";
                $output .= '   <a href="'.$href.'" class="scroll-to" data-tag="'.$tag.'" data-speed="'.$speed.'">'.$caption.'</a>'."\n";
                $output .= '</div>'."\n";
                break;
        }


        if ( $displayinfront ) {
            if ( is_front_page() ) {
                if ( $return ) return $output;
                echo $output;
            }
        } else {
            if ( $return ) return $output;
            echo $output;
        }
    }
}

if ( !function_exists( 'dwh_splash_content' ) )
{
    function dwh_splash_content( $parameter, $return = false )
    {
        global $DWH_wponetheme_util;

        $title       = isset( $parameter['title'] ) ? $parameter['title'] : null;
        $content     = isset( $parameter['content'] ) ? $parameter['content'] : null;
        $disable     = isset( $parameter['disable'] ) ? $parameter['disable'] : null;
        $class       = isset( $parameter['show_inner_pages'] ) ? 'show-inner-pages ' : null;
        $class      .= isset( $parameter['show_only_once'] ) ? 'show-only-once' : 'show-always';

        $output = '';
        if ( !$disable ) {
            $output .='<div class="hide">'."\n";
            $output .='    <div id="splash-container" class="'.$class.'">'."\n";
            $output .='        <div class="splash-content">'."\n";
            $output .='            <h2 class="align-center title">'.$title.'</h2>'."\n";
            $output .= dwh_empty( $content ) ? $DWH_wponetheme_util->load_shortcode_content( $content ) : null;
            $output .='        </div>'."\n";
            $output .='    </div>'."\n";
            $output .='</div>'."\n";

        }

        if ( $return ) return $output;
        echo $output;

    }
}

/* SLIDER / CTA / COLLECTION */