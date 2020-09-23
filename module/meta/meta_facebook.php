<?php 
global $DWH_Options;
$hotel_info = $DWH_Options->get_dwh_site_option_field('dwh_hotels',0);
?>
<?php if( $hotel_info ) :?>
<!-- facebook -->
<meta property="og:title" content="<?php echo $hotel_info->hotel_name;?>" />
<meta property="og:type" content="hotel" /><!--do not change the property-->
<?php if(is_page() || is_single()){ ?>
<meta property="og:description" content="<?php echo get_post_meta( $post->ID, 'meta_description', true ); ?>" /><!--do not change the property-->
<?php } else { ?>
<meta property="og:description" content="<?php bloginfo('description'); ?>" /><!--do not change the property-->
<?php } ?>
<meta property="og:url" content="<?php echo $hotel_info->hotel_domain;?>" />
<meta property="og:site_name" content="<?php echo $hotel_info->hotel_name;?>" />
<meta property="fb:admins" content="1076987014" /><!--do not change the property-->
<?php endif;?>