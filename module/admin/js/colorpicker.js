function loadColorPicker()
{
	/* trigger colour picker */
	$('.colorpicker').iris({
		hide: false,
		palettes: ['', '#FF6600', '#008000', '#0000FF', '#FF9900', '#FFCC00'],
		change: function( event, ui){
		$( event.target ).css('background-color', ui.color.toString() );
		if(ui.color.toString() == ''){
			$( event.target ).val('transparent');
			}
		}
	});

	/* hide colorpicker */
	hideColorPickers();

	/* show colorpicker on focus */
	$('.colorpicker').click(function(){
		$(this).iris('toggle');
	});
}


function hideColorPickers()
{

	$('.colorpicker').iris('hide');
}