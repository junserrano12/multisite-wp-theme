<!-- Canonical -->
<?php
    global $post;
    $canonical_url = ( $post ) ? get_the_permalink() : site_url() ;
    if( DWH_SSL == true ) $canonical_url = $this->http_to_https( $canonical_url );
?>
<link rel="canonical" href="<?php echo $canonical_url; ?>" >
