
function googleTranslateElementInit()
{	

	require(['gtranslate'],function(){

	
		 try {
		  		if( google_analytics_info.ga_code )
				{
					new google.translate.TranslateElement({
						pageLanguage: 'en',
						layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
						gaTrack: true,
						gaId: google_analytics_info.ga_code
					  }, 'google_translate_element');
				}else{
					new google.translate.TranslateElement({
						pageLanguage: 'en',
						layout: google.translate.TranslateElement.InlineLayout.SIMPLE
						}, 'google_translate_element');
				}
		  } 
			catch(error) {
				if (error.name === 'SyntaxError') {
		  			
				}
				else {
					
				}
			}

	   
	}, function (err) {
       console.log( 'Google Translate not loaded' );
    });

}

googleTranslateElementInit();
