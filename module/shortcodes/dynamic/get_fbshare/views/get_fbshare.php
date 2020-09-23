<?php
	extract( $data );
	$share_url = isset($atts['url']) ? $atts['url'] : $_SERVER['HTTP_HOST'] ;	
	$layout = isset($atts['layout']) ? $atts['layout'] : 'link' ;	
?>
<div class="fb-share-button" data-href="<?php echo $share_url;?>" data-layout="<?php echo $layout;?>"></div>