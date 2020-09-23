jQuery(document).ready(function(){

	displayHiddenMenu();
	
});

function displayHiddenMenu(){
	jQuery('.menu-icon-menu a').click(function(e){
		e.preventDefault();	
		_this = jQuery(this).parent();
		_this.nextAll().toggle();
	}); 
}