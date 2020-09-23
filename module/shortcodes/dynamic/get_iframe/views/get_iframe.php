<?php

	extract($data);
	
	if( $atts ):
	
		$classname = isset($atts['name']) ? $atts['name'] : 'iframe-container';
		$src	= isset($atts['src']) ? $atts['src'] : '';
		$style	= isset($atts['style']) ? $atts['style'] : '';
		$param 	= isset($atts['param']) ? $atts['param'] : '';
?>
			<iframe <?php echo $param; ?> src="<?php echo $src;?>" style="<?php echo $style;?>" class="iframe-content <?php echo $classname; ?>"></iframe>

<?php 
	endif;
?>
