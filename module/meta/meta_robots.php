<?php
global $post;
global $DWH_Options;

if( $post ){

	$postid = isset($post->ID) ? $post->ID : null;
	$dwh_meta = $DWH_Options->get_dwh_site_option_set('dwh_meta');
	$page_meta = get_post_meta( $post->ID, 'meta_robots', true );
?>

	<?php if( $page_meta ): ?>
			<!-- Robots -->
			<meta name="robots" content="<?php echo $page_meta; ?>">
	<?php else: ?>
		<?php if( $dwh_meta ) :?>
			<?php foreach ($dwh_meta as $key => $value):?>
				<?php if( isset( $value['noindexnofollow'] ) && $value['noindexnofollow'] == 1): /* If general settings meta robot no index no follow*/ ?>
						<!-- Robots -->
						<meta name="robots" content="noindex, nofollow">
				<?php endif;?>
			<?php endforeach;?>
		<?php endif;?>
	<?php endif; ?>

<?php } ?>

<?php if ( is_archive() ): /* if page is archive */ ?> 
<!-- Robots -->
<meta name="robots" content="noindex, nofollow">
<?php endif;?>
