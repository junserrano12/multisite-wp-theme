
var Admin_restrictions = (function(JQ){

	JQ(document).ready(function(){
		
		/* Remove wp editor tabs */
		if( typeof wp_default_editor !== 'undefined' ){
			JQ( wp_default_editor.remove_selector ).remove();
		}

	});

})(jQuery);

