jQuery(document).ready(function(){
	var iniValue = 'All Pages';
	jQuery(document).on('change','.displayed-in',function(){
		
		iniValue = '';
		count = 0;
		jQuery('.displayed-in').each(function(){
			if($(this).is(':checked')){
				count++;
				iniValue += jQuery(this).val() + ',';
			}
		});
		if(count > 0){
			iniValue = iniValue.substr(0, iniValue.length - 1); //remove last comma
		}else{
			iniValue = 'All Pages';
		}
		
		jQuery('.display-script-in').val(iniValue);
	});
});