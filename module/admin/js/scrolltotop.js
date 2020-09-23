
/*Back to top*/	
$('body').append('<a href="#?" id="toTop" style="display:none;"></a>');

/* Toggle go to top link on window scroll */	
$(window).scroll(function() {

	if ($(this).scrollTop() > 250) {
		$('#toTop').fadeIn(300);
	} else {
		$('#toTop').fadeOut(300);
	}	
});

/* click toTop */
$('#toTop').click(function(e){
	e.preventDefault();
	
	scrollposition = 0;
	scrollposition = scrollposition;
	$('html,body').animate({scrollTop: scrollposition}, 'slow');
	
});