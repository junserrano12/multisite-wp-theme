
    var paths;
    var theme_js_root_dir    = site_info.cdn_path + "js/v1/";
    var theme_js_modules_dir = site_info.cdn_path + "js/modules/";
    var theme_js_library_dir = site_info.cdn_path + "js/lib/";
	var cbust                = cbuster.cache_bust;

    require.config({
        paths: {
            'jquery_ui_core'            : theme_js_library_dir + 'jquery.ui.core.min' + cbust,
            'jquery_ui_datepicker'      : theme_js_library_dir + 'jquery.ui.datepicker.min' + cbust,
            'jquery_colorbox'       	: theme_js_library_dir + 'jquery.colorbox-min' + cbust,
            'jquery_flexslider'     	: theme_js_library_dir + 'jquery.flexslider-min' + cbust,
            'jquery_bgcenterimage'     	: theme_js_library_dir + 'jquery.blImageCenter-min' + cbust,
            'jquery_slimscroll'         : theme_js_library_dir + 'jquery.slimscroll.min' + cbust,
            'cookie_obj'   		    	: theme_js_modules_dir + 'cookie.min' + cbust,
            'google_map'                : theme_js_modules_dir + 'google.map.min' + cbust,
            'gtranslate'                : '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit',
            'gmaps'                     : '//maps.google.com/maps/api/js?v=3'
            /*'gmaps'                   : '//maps.google.com/maps/api/js?key=AIzaSyBvzDeGG7F-cEUYLNhpTFbYnfrXj-H6qRk',*/

        }
    });

    /* Path collections */
    paths =  {
            /* Support for sync scripts */
            'async'                         : theme_js_root_dir + 'async.min' + cbust,
            /* Slider */
            'slider'                        : path_slider.slider,
            /* ua tracker */
            'ua_promo_tracker'              : theme_js_modules_dir + 'ua.tracker.min' + cbust,
            /* App utility */
            'app_util'                      : theme_js_modules_dir + 'app_util.min' + cbust,
            /* Theme accordion widget */
            'api_facebook_like'             : theme_js_modules_dir + 'fb.like.min' + cbust,
            /* Calendar script */
            'calendar'                      : theme_js_modules_dir + 'calendar.min' + cbust,
            /* Support for sync scripts */
            'dwh_packages'                  : theme_js_modules_dir + 'packages.min' + cbust,
            /* Theme accordion widget */
            'widget_accordion'              : theme_js_modules_dir + 'widget.accordion.min' + cbust,
            /* Widget GA Translate */
            'widget_translate'              : theme_js_modules_dir + 'widget.translate.min' + cbust,
            /* Widget Splash Screen */
            'widget_splashscreen'           : theme_js_modules_dir + 'widget.splashscreen.min' + cbust,
            /* Widget Splash Screen */
            'widget_scrolltocontent'        : theme_js_modules_dir + 'widget.scrolltocontent.min' + cbust,
            /* Widget Scroll To Content*/
            'widget_map'                    : theme_js_modules_dir + 'widget.map.min' + cbust,
            /* Theme tab widget */
            'widget_tab'                    : theme_js_modules_dir + 'widget.tab.min' + cbust,
            /* UI global */
            'ui_global'                     : theme_js_modules_dir + 'ui.global.min' + cbust,
            /* UI colorbox */
            'ui_colorbox'                   : theme_js_modules_dir + 'ui.colorbox.min' + cbust,
            /* UI slim scroll */
            'ui_slimscroll'                 : theme_js_modules_dir + 'ui.slimscroll.min' + cbust,
            /* promocode validator */
            'validate_promocode'            : theme_js_modules_dir + 'validate.promocode.min' + cbust
           };

    /* Require resource configuration */
    requirejs.config({

        baseUrl : site_info.cdn_url,
        paths   : paths,
        waitSeconds: 200,
        shim : {
            'ui_colorbox' : {

                    deps: ['jquery_colorbox']

                },
            'ui_slimscroll' : {

                    deps: ['jquery_slimscroll']

                },
            'calendar' : {

                    deps: ['jquery_ui_core','jquery_ui_datepicker']

                },
            'dwh_packages' : {

                    deps: ['jquery_ui_core','jquery_ui_datepicker']

                },
            'widget_translate' : {

                    deps: ['gtranslate']

                },
            'widget_map' : {

                    deps: ['google_map']

                },
            'widget_splashscreen' : {

              	   deps: ['cookie_obj','jquery_colorbox']

            	}
            }
    });

    jQuery.each(paths,function( key, val){
        require([key]);
    });