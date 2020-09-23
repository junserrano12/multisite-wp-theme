<?php include( get_template_directory() . '/module/documentation/theme-doc.php');?>

<!-- Load Modal -->
<?php 
$data['dir'] = array('module/collections/views/settings/documentation');
$data['view'] = 'modal';
load_view( $data );
?>
