<?php 
global $DWH_Options;
$dwh_api_google_webmaster_tool = $DWH_Options->get_dwh_site_option_set('dwh_api_google_webmaster_tool');
?>
<?php if( $dwh_api_google_webmaster_tool ):?>
<?php foreach ($dwh_api_google_webmaster_tool as $key => $value ):?>
<!-- Google Site Verification -->
<?php if(isset( $value['site_verification_tag'] ) && $value['site_verification_tag']!=''):?>
<?php echo $value['site_verification_tag'];?>
<?php endif;?>
<?php endforeach;?>
<?php endif;?>