<?php

	global $DWH_Options;

	/* Get fb tab api info */
	$facebook_api_info = $DWH_Options->get_dwh_site_option_field( 'dwh_api_facebook_tab',0);
	$app_id = isset(  $facebook_api_info->app_id ) ?  $facebook_api_info->app_id : '';

	?>
	
	<?php if( $app_id!='' ) :?>

		<script type="text/javascript">// <![CDATA[
		    window.fbAsyncInit = function() {
		        FB.init({
		            appId : '<?php echo $app_id;?>',
		            status : true,
		            cookie : true,
		            xfbml : true
		        });

		       	resizeWrapper();
		    };

		    (function() {
		        var e = document.createElement('script');
		        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		        e.async = true;
		        document.getElementById('fb-root').appendChild(e);
		    }());

		    function resizeWrapper(){ 
		    	if( window.self === window.top ){ 
			    	/*not in a frame */
		    	}else{ 
			    	/*in a frame */
			    	FB.Canvas.setAutoGrow(true); 
		    		var wrapper_height = jQuery('body').outerHeight(true); 
		    		FB.Canvas.setSize( {height: wrapper_height} ); 

		    		jQuery('.ctalink, .ctamodify, .ctabutton').attr('target', '_blank');
		    	} 
			}
	
		// ]]></script>
	
	<?php endif;?>