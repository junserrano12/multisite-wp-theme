<?php 
global $DWH_Options;
$dwh_api_google_publisher = $DWH_Options->get_dwh_site_option_set('dwh_api_google_publisher');
?>
<?php if( $dwh_api_google_publisher ):?>
<?php foreach ($dwh_api_google_publisher as $key => $value):?>
<?php if( $value['publisher']!='' ):?>
<!-- Google Publisher -->
<link rel="publisher" href="<?php echo $value['publisher'];?>"/>
<?php endif;?>
<?php endforeach;?>
<?php endif;?>