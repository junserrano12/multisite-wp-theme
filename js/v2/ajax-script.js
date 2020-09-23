var JQQ = jQuery.noConflict();

function dwh_do_ajax( ajaxobj, callback, _data = "", _url = ajaxurl, _dataType = "", _type = "post" ) {
   JQQ.ajax({
         type : _type,
         dataType : _dataType,
         url : _url,
         data : {
                    action: ajaxobj.action,
                    security : ajaxobj.security,
                    data: {
                            'config_data': ajaxobj.data,
                            'custom_data': _data
                          }
                },
         success: callback,
         fail: function(e){
            console.log('error');
         }

    });
}

function dwh_do_ajax_upload( ajaxobj, callback, _data = "", _url = ajaxurl, _dataType = "", _type = "post" ) {

   JQQ.ajax({
		type : _type,
		url : _url,
		data : _data,
		contentType: false,
		processData: false,
        success: callback,
        error: function(req, status, error){
			console.log(error);
        }

    });
}

function dwh_do_post( action, data, callback ) {
    JQQ.post(
        action,
        data,
        callback
    );
}

function dwh_fail_callback(){
    console.log('failed');
}