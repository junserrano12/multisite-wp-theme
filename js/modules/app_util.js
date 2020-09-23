
var app_util = (function(JQ){

	var settings;
	
	JQ(document).ready(function(){

		init();
	});

	function init()
	{	
		settings = { };
		bindUIEvents();

	}

	function bindUIEvents() { }

	function generateUniqueID()
	{
		var datE = new Date();
		var date = datE.getDate().toString();
		var time = datE.getTime().toString();

		var uid = date + time;
			uid = uid.substr(0,10);

		return uid;
	}

	return {

		'init' 						: init,
		'settings' 					: settings,
	 	'bindUIEvents' 				: bindUIEvents,
	 	'generateUniqueID' 			: generateUniqueID
	};


})(jQuery);






