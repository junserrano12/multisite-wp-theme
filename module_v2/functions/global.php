<?php

if ( !function_exists( 'dwh_default_banner' ) )
{
    function dwh_default_banner( $parameter = array(), $return = false )
    {
        $default_banner_id     = dwh_get_data( 'banner', 'onetheme_customizer_options' );
        $default_banner        = wp_get_attachment_image_src( $default_banner_id  , 'full' );
        $default_banner_srcset = wp_get_attachment_image_srcset( $default_banner_id  , 'full' );
        $default_banner_title  = dwh_empty( get_post_meta( $default_banner_id, '_wp_attachment_image_title', true ) ) ? get_post_meta( $default_banner_id, '_wp_attachment_image_title', true) : get_the_title( $default_banner_id );
        $default_banner_alt    = dwh_empty( get_post_meta( $default_banner_id, '_wp_attachment_image_alt', true ) ) ? get_post_meta( $default_banner_id, '_wp_attachment_image_alt', true) : get_the_title( $default_banner_id );
        $default_banner_class  = isset( $parameter['class'] ) ? ' ' .$parameter['class'] : null;

        if ( $default_banner_id ) {
            $default_banner_src    = $default_banner[0];
            $default_banner_width  = $default_banner[1];
            $default_banner_height = $default_banner[2];

            $output  = '<div class="image-container'.$default_banner_class.'">'."\n";
            $output .= '    <img src="'.$default_banner_src.'" srcset="'.$default_banner_srcset.'" width="'.$default_banner_width.'" sizes="(max-width: '.$default_banner_width.'px) 100vw, '.$default_banner_width.'px" title="'.$default_banner_title.'" alt="'.$default_banner_alt.'">'."\n";
            $output .= '</div>'."\n";

            if ( $return ) return $output;
            echo $output;
        }
    }
}

if ( !function_exists( 'dwh_link_to' ) )
{
    function dwh_link_to( $param = array(), $return = false )
    {
        $url    = isset( $param['url'] ) ? $param['url'] : home_url();
        $label  = isset( $param['label'] ) ? $param['label'] : "Back to home";
        $class  = isset( $param['class'] ) ? "back-link ".$param['class'] : "back-link";
        $before = isset( $param['before'] ) ? $param['before'] : null;
        $after  = isset( $param['after'] ) ? $param['after'] : null;

        $output = $before.'<a class="'.$class.'" href="'.$url.'">'.$label.'</a>'.$after."\n";

        if ( $return ) return $output;
        echo $output;
    }
}

if ( !function_exists( 'dwh_cta_link' ) )
{
	function dwh_cta_link( $type = 'default' , $label = 'back', $return = false )
	{

		if ( shortcode_exists( 'dwh_cta' ) ) {
			$ctaconfig 	= dwh_cta_config();
            $output     = '';

            if ( $ctaconfig->type === 'single' ) {
                $ctalink    = $ctaconfig->base_url.$ctaconfig->url->default.$ctaconfig->hotelsingle['hotel_id'].'/';
                $moclink    = $ctaconfig->base_url.$ctaconfig->url->moc.$ctaconfig->hotelsingle['hotel_id'].'/';

                switch ( $type ) {
                    case 'ctalink':
                        return $ctalink;
                        break;
                    case 'moclink':
                        return $moclink;
                        break;
                    default:
                        $label = ( dwh_empty( $ctaconfig->link ) ) ? $ctaconfig->link : $label;
                        $output = '<a href="'.$ctalink.'" class="cta-link link">'.$label.'</a>';
                        break;
                }
            }

		} else {

			$output = '<a href="'.home_url().'" class="cta-link link">'.$label.'</a>';

		}

        if ( $return ) return $output;
        echo $output;
	}
}

if ( !function_exists( 'dwh_post_thumbnail' ) )
{
	function dwh_post_thumbnail( $postid = null, $size = 'full' )
	{
		if ( $postid ) {
            if ( has_post_thumbnail( $postid) ) {
    			echo get_the_post_thumbnail( $postid, $size );
            } else {
                dwh_default_banner();
            }
		} else {
		    if ( has_post_thumbnail($postid) ) {
				the_post_thumbnail( $size );
			} else {
                dwh_default_banner();
            }
		}
	}
}

if ( !function_exists( 'dwh_to_top' ) )
{
	function dwh_to_top( $label = 'To Top', $return = false )
	{
		$output = '<a href="#?" class="to-top scroll-to-top" style="display:none;">'.$label.'</a>';

        if ( $return ) $output;
        echo $output;
	}
}

if ( !function_exists( 'dwh_get_sidebar' ) )
{
    function dwh_get_sidebar( $sidebar = 'default' )
    {
        switch ( $sidebar ) {
            case 'default':

                get_sidebar();
                break;

            default:

                if ( is_active_sidebar($sidebar ) ) {
                    dynamic_sidebar( $sidebar );
                }

                break;
        }
    }
}

if ( !function_exists( 'dwh_link_pages' ) )
{
	/**
	 * description: add navition to seperated content of page or post
	 * usage: <!--nextpage-->
	 * insert in page or post to display page navigation
	 *
	 **/
	function dwh_link_pages()
	{
		$defaults = array(
			'before'           => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'wponetheme' ) . '</span>',
			'after'            => '</div>',
			'link_before'      => '<span>',
			'link_after'       => '</span>',
			'next_or_number'   => 'number',
			'separator'        => ' ',
			'nextpagelink'     => __( 'Next page', 'wponetheme' ),
			'previouspagelink' => __( 'Previous page', 'wponetheme' ),
			'pagelink'         => '%',
			'echo'             => 1
		);

	    wp_link_pages( $defaults );
	}
}

if ( !function_exists( 'dwh_pagination' ) )
{
	function dwh_pagination( $pages = '', $range = 2 )
	{

		/*
			global $post;
			global $wp_query;

		    if ( $wp_query->max_num_pages > 1 ) : ?>
		        <nav id="navigation-<?php echo $post->ID; ?>" class="navigation" role="navigation">
		            <h3 class="assistive-text"><?php _e( 'Post navigation', 'wponetheme' ); ?></h3>
		            <div class="nav-previous"><?php next_posts_link( _e( '<span class="meta-nav">&larr;</span> Older posts', 'wponetheme' ) ); ?></div>
		            <div class="nav-next"><?php previous_posts_link( _e( 'Newer posts <span class="meta-nav">&rarr;</span>', 'wponetheme' ) ); ?></div>
		        </nav>
		    <?php endif;
		*/

	 	global $paged;
		global $wp_query;

	    $showitems = ($range * 2)+1;

		if (empty($paged)) $paged = 1;

		if ($pages == '')
		{
			$pages = $wp_query->max_num_pages;
			if (!$pages)
			{
				$pages = 1;
			}
		}

		if (1 != $pages)
		{
			echo "<div class='pagination'>";
			if ($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
			if ($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

			for ($i=1; $i <= $pages; $i++)
			{
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				{
					echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
				}
			}

			if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
			echo "</div>\n";
		}
	}
}

if ( !function_exists( 'dwh_post_navigation' ) )
{

	function dwh_post_navigation()
	{
		if ( is_attachment() ) {

			the_post_navigation( array(
				'prev_text' => _x( '<span class="meta-nav">Published in</span> <span class="nav-post-title">%title</span>', 'Parent post link', 'wponetheme' ),
			) );

		} else {

			the_post_navigation( array(
				'next_text' =>
					'<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'wponetheme' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Next post:', 'wponetheme' ) . '</span> ' .
					'<span class="meta-post-title">%title</span>',
				'prev_text' =>
					'<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'wponetheme' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Previous post:', 'wponetheme' ) . '</span> ' .
					'<span class="meta-post-title">%title</span>',
			) );
		}
	}
}