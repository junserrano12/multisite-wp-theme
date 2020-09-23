var Promocode_validation = (function(JQ){

    var ui_settings;

    JQ(document).ready(function(){
		init();
    });

    function init()
    {

        ui_settings = {
                        'el_promocode' : JQ("#promo_code")
                      };


        bindUIEvents();

    }

    function bindUIEvents()
    {

        _pattern = /^[A-Z0-9]+$/i;
        _countsplchr = 0;

		JQ(document).on('keyup',ui_settings.el_promocode,function(){
            _value = ui_settings.el_promocode.val();

			if ( _value != '' && !_pattern.test(_value) ) {
                ui_settings.el_promocode.css('border', '1px solid red');
                _countsplchr++;
            } else {
                ui_settings.el_promocode.css('border', '1px solid #ccc');
                _countsplchr = 0;
            }

            if( _countsplchr === 1) {
                ui_settings.el_promocode.after('<span id="promocode_validation_notification" style="position:absolute; z-index: 100; bottom: -18px; left: 0; display: block; padding: 3px 0; font-size: 0.8em; color: red; background: #fcfcfc; text-align:center; width: 100%;">Invalid Code</span>');
            } else if ( _countsplchr === 0 ) {
                JQ('#promocode_validation_notification').remove();
            }

		});

    }

    return {
        'init'                      : init,
        'ui_settings'               : ui_settings,
        'bindUIEvents'              : bindUIEvents
    };


})(jQuery);