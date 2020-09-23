/* Chosen */
function loadChosen()
{ 

   jQuery('.chosen-select')
		.chosen({
			width: "100%"
		})
		.change(function(){
			var _this = jQuery(this);
			var _fieldval = jQuery.trim(_this.val());
			var _selector =  _this.attr('field_name');
			
			jQuery( 'input[name="'+ _selector +'"]' ).val(_fieldval);
			/* console.log('Field value: '+ _fieldval); */
		});
	
}



