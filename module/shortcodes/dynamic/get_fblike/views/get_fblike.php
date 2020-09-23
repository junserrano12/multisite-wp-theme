<?php

	extract( $data );
	$url =  isset($atts['url']) ? $atts['url'] : $_SERVER['HTTP_HOST'];
	$fb_layout =  isset($atts['layout']) ? $atts['layout'] : 'standard';
	$fb_share =  isset($atts['share']) ? $atts['share'] : true;
	$fblikecolorshceme = isset($atts['colorscheme']) ? $atts['colorscheme'] : 'light';

?>
<!-- FB root Cointainer -->
<div id="fb-root"></div>
<!-- FB like Cointainer -->
<div id="fb-like-container">
	<div class="fb-like" data-href="<?php echo $url; ?>" data-layout="<?php echo $fb_layout; ?>" data-action="like" data-show-faces="false" data-share="<?php echo $fb_share;?>" data-colorshceme="<?php echo $fblikecolorshceme; ?>"></div>
</div>
