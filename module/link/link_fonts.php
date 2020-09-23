<?php 
global $DWH_Options;
$site_fonts = $DWH_Options->get_dwh_site_option_set('dwh_fonts_external');

if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $protocol = 'https://';
}else {
  $protocol = 'http://';
}

?>
<?php if( $site_fonts ) : ?>
	<?php foreach( $site_fonts as $key => $value ):?>
		<?php if( isset( $value['tag'] ) ) :?>
		<?php $tag = $value['tag'];?>
		<?php endif;?>
		<?php 
			if($protocol == 'https://'){
				echo str_replace('http://',$protocol, $tag);
			}else{
				echo $tag;
			}
		?>
	<?php endforeach;?>
<?php endif;?>