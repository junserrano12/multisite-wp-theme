(function() {
	var config_details = button_set_layout;
	
    tinymce.PluginManager.add( config_details.id, function( editor, url ) {
       
	    editor.addButton( config_details.id , {
            title: config_details.title,
			text: config_details.text,
            icon: config_details.icon != '' ? config_details.icon : false,
			onclick: function(){
				
				editor.windowManager.open( {
					title: config_details.title,
					body: config_details.body,
					onsubmit: function( e ) {
						editor.insertContent( e.data.layout );
					}
				});
				
			}
			
        });

    });
	
})();