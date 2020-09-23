var JQ = jQuery.noConflict();
var timer;
var settings = {
	'window'              : JQ(window),
	'head'                : JQ('head'),
	'body_html'           : JQ('body,html'),
	'body'                : JQ('body'),
    'wrapper'             : JQ('#wrapper'),
	'header'              : JQ('#header'),
	'main'                : JQ('#main'),
	'footer'              : JQ('#footer'),
	'colorbox'            : JQ('.colorbox'),
	'colorbox_inline'     : JQ('.colorbox-inline'),
	'colorbox_inline_img' : JQ('.colorbox-inline-img'),
    'scroll_to'           : JQ('.scroll-to'),

};

function googleTranslateElementInit(){

	window_width = settings.window.width();
	// google_translate_layout = window_width <= 1024 ? google.translate.TranslateElement.InlineLayout.horizontal : google.translate.TranslateElement.InlineLayout.SIMPLE;
    google_translate_layout  = google.translate.TranslateElement.InlineLayout.SIMPLE;
    google_included_language = 'en,es,ko,ja,it,de,fr,zh-CN';

    if ( ga_code.gaid ) {

        new google.translate.TranslateElement({
            pageLanguage: 'en',
            layout: google_translate_layout,
            includedLanguages: google_included_language,
            gaTrack: true,
            gaId: ga_code.gaid
        }, 'google_translate_element');

    } else {

        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: google_included_language,
            layout: google_translate_layout
        }, 'google_translate_element');
    }

}

function DWH_loadScript(){
	if ( typeof script_objects !== "undefined" ) {
		JQ.each(script_objects.objects, function(key,val){
		});
	}
}

function DWH_loadStyle(){
	if ( typeof style_objects !== "undefined" ) {
		JQ.each(style_objects.objects, function(key,val) {
			_links = JQ('#'+val+'-css');
			_links.attr( 'href', _links.data('href') );
		});
	}
}

function DWH_myCookie( name ) {
    this.name = name;

    this.createCookie = function( value, days ) {
            this.value = value;
            this.days = days;
            if ( this.days ) {
                var date = new Date();
                date.setTime( date.getTime() + ( this.days*24*60*60*1000 ) );
                var expires = "; expires="+date.toGMTString();
            } else {
                var expires = "";
            }

            document.cookie = this.name+"="+this.value+expires+"; path=/";
        };

    this.readCookie = function() {
            var nameEQ = this.name + "=";
            var ca = document.cookie.split( ';' );
            for( var i=0; i < ca.length;i++ ) {
                var c = ca[i];
                while ( c.charAt(0) == ' ' ) c = c.substring(1,c.length);
                    if ( c.indexOf( nameEQ ) == 0 ) return c.substring( nameEQ.length,c.length );
            }

            return null;
        };

    this.deleteCookie = function(){
        this.createCookie( "", -1 );
    };
}

function DWH_colorBox(){
    settings.colorbox.colorbox({ maxWidth : '80%' });
    settings.colorbox_inline.colorbox({ inline : true, maxWidth : '80%' });
    settings.colorbox_inline_img.colorbox({ inline : true });
}

function DWH_scrolledWindow(){
    settings.window.scroll(function() {
        _this     = JQ(this);
        _position = ( JQ('#main-banner-container').height() !== null ) ? JQ('#main-banner-container').height() / 1.5 : 250;

        if ( _this.scrollTop() > _position ) {
            settings.wrapper.addClass('wrapper-scrolled');
        } else {
            settings.wrapper.removeClass('wrapper-scrolled');
        }
    });
}

function DWH_scrollTo(){

    settings.scroll_to.click(function(e){
        _this     = JQ(this);
        _speed    = _this.data('speed');
        _target   = _this.data('tag');

        _position = ( JQ( _target ) === undefined ) ? 0 : JQ(_target).offset().top;

        settings.body_html.stop().animate({scrollTop : _position}, _speed);

        e.preventDefault();
    });
}

function DWH_toggleMainMenuIcon(){
    settings.body.on('click', '#main-menu-icon', function(e){
        JQ('#main-menu').toggleClass('show-layer');
        JQ(this).toggleClass('cross');

        settings.wrapper.toggleClass('wrapper-freeze');

        e.preventDefault();
    });
    settings.body.on('click', '#rmenu', function(e){
        JQ('#menu-primary-menu').toggleClass('visible-layer');

        e.preventDefault();
    });

}

function DWH_splashPage(){
    /*Splash*/
    if( !device.detect.phone ){

        /* cookie object initialization */
        var _splashCookie = new DWH_myCookie('splash_home');
        var _cookieVal = _splashCookie.readCookie();
        var _splashContainer = JQ('#splash-container');
        var _splashClose = JQ('.close-splash');

        /*console.log(_splashContainer.hasClass('show-only-once'));*/
        if ( _splashContainer.hasClass( 'show-only-once' ) ) {
            if ( !_cookieVal ) {
                /* console.log(_cookieVal); */
                JQ.colorbox( { inline:true, width:"auto", href:"#splash-container" } );
                _splashCookie.createCookie( 'splash_home', 0 );
            }
        } else {
            if ( _splashContainer.length ) {
                JQ.colorbox( { inline:true, width:"auto", href:"#splash-container" } );
                _splashCookie.deleteCookie();
            }
        }

        /* close splash */
        _splashClose.click( function(e) {
            e.preventDefault();
            _splashClose.colorbox.close();
        } );
    }
}

function DWH_onSelectChange(){
    settings.body.on('change', '.dwh-select-wrapper .select-list', function(e){
        e.preventDefault();
        _this               = JQ(this);
        _selectcontentid    = _this.val();
        _selectparentid     = '#'+_this.parentsUntil('.dwh-select-wrapper').parent().attr('id');
        JQ(_selectparentid+' .select-content-container').children('.item-content').hide();
        JQ(_selectcontentid).show();
    });
}

function DWH_onDropDownClick(){
    settings.body.on('click', '.dwh-dropdown-wrapper .dropdown-selected', function(e){
        e.preventDefault();
        _this               = JQ(this);
        _this.parent().next().toggleClass('hide');
    });

    settings.body.on('click', '.dwh-dropdown-wrapper .dropdown-link', function(e){
        e.preventDefault();
        _this               = JQ(this);
        _dropdowncontentid  = _this.attr('href');
        _dropdownparentid   = '#'+_this.parentsUntil('.dwh-dropdown-wrapper').parent().attr('id');

        JQ(_dropdownparentid+' .dropdown-selected-container .dropdown-selected').html(_this.html());
        JQ(_dropdownparentid+' .dropdown-title-container').toggleClass('hide');

        JQ(_dropdownparentid+' .dropdown-title-container .item-title').removeClass('item-active');
        JQ(_dropdownparentid+' .dropdown-content-container .item-content').hide().removeClass('item-active');

        JQ(_dropdowncontentid).show().addClass('item-active');
        _this.parent().addClass('item-active');

    });
}

function DWH_onAccordionClick(){
    settings.body.on('click', '.dwh-accordion-wrapper .accordion-link', function(e){
        e.preventDefault();
        _this                   = JQ(this);
        _accordioncontentid     = _this.attr('href');
        _accordionparentid      = '#'+_this.parentsUntil('.dwh-accordion-wrapper').parent().attr('id');
        _accordioneffect        = _this.parentsUntil('.dwh-accordion-wrapper').parent().data('effect');
        _accordiontoggle        = _this.parentsUntil('.dwh-accordion-wrapper').parent().data('toggle');
        _accordioncontent       = JQ(_accordioncontentid);

        if(_accordiontoggle == 'all') {

            if ( _accordioneffect == 'slide' ) {

                if ( _accordioncontent.css('display') == 'block' ) {

                    _accordioncontent.stop().slideUp().removeClass('item-active');
                    _this.parent.removeClass('item-active');

                } else {

                    JQ(_accordionparentid+' .accordion-item').children('.item-title').removeClass('item-active');
                    JQ(_accordionparentid+' .accordion-item').children('.item-content').stop().slideUp().removeClass('item-active');
                    _accordioncontent.stop().slideDown().addClass('item-active');

                    _this.parent().addClass('item-active');
                }

            } else if ( _accordioneffect == 'fade' ) {

                if ( _accordioncontent.css('display') == 'block' ) {
                    _accordioncontent.stop().fadeOut().removeClass('item-active');
                    _this.parent.removeClass('item-active');
                } else {
                    JQ(_accordionparentid+' .accordion-item').children('.item-title').removeClass('item-active');
                    JQ(_accordionparentid+' .accordion-item').children('.item-content').stop().fadeOut().removeClass('item-active');
                    _accordioncontent.stop().fadeIn().addClass('item-active');
                    _this.parent().addClass('item-active');
                }

            } else {

                if ( _accordioncontent.css('display') == 'block' ) {

                    _accordioncontent.stop().hide().removeClass('item-active');
                    _this.parent.removeClass('item-active');
                } else {
                    JQ(_accordionparentid+' .accordion-item').children('.item-title').removeClass('item-active');
                    JQ(_accordionparentid+' .accordion-item').children('.item-content').stop().hide().removeClass('item-active');
                    _accordioncontent.stop().show().addClass('item-active');
                    _this.parent().addClass('item-active');
                }

            }

        } else {

            if(_accordioneffect == 'slide'){

                _accordioncontent.slideToggle().toggleClass('item-active');

            } else if(_accordioneffect == 'fade') {

                _accordioncontent.fadeToggle().toggleClass('item-active');

            } else {

                if ( _accordioncontent.css('display' == 'block' ) ) {
                    _accordioncontent.show().addClass('item-active');
                } else {
                    _accordioncontent.hide().removeClass('item-active');
                }
            }

            _this.parent().toggleClass('item-active');

        }
    });
}

function DWH_onTabClick(){
    settings.body.on('click', '.dwh-tab-wrapper .tab-link', function(e){
        e.preventDefault();
        _this           = JQ(this);

        _tabcontentid   = _this.attr('href');
        _tabparentid    = '#'+_this.parentsUntil('.dwh-tab-wrapper').parent().attr('id');

        JQ(_tabparentid+' .tab-title-container .item-title').removeClass('item-active');
        JQ(_tabparentid+' .tab-content-container .item-content').hide().removeClass('item-active');
        JQ(_tabcontentid).show().addClass('item-active');
        _this.parent().addClass('item-active');
    });
}

/* SLIDER FUNCTIONS */
function loadSlider(){

	JQ.each(slider_objects.objects, function(key,val){
		if( val.slider == 'flexslider' ) {
			loadFlexSlider(val);
		} else if( val.slider == 'nivoslider' ){
			loadNivoSlider(val);
		}
	});
}

function returnThumbnailSize( _size ){

	if ( _size == 'small-thumbnail-image' ) {
		return 40;
	} else if ( _size == 'medium-thumbnail-image' ) {
		return 150;
	} else if ( _size == 'large-thumbnail-image' ) {
		return 200;
	} else {
		return 0;
	}
}

function loadFlexSlider(_slider){

	if ( !JQ(_slider.selector).hasClass('flexslider_disable') ){

		if ( _slider.type == 'thumbnail' ) {

			JQ( '#thumbnail-'+_slider.id ).flexslider({
				animation     : "slide",
				controlNav    : false,
				directionNav  : _slider.directionnav,
				animationLoop : false,
				slideshow     : false,
				itemWidth     : returnThumbnailSize( _slider.thumbnailsize ),
				itemMargin    : 5,
				prevText      : "",
				nextText      : "",
				asNavFor      : _slider.selector
			});

			JQ( _slider.selector ).flexslider({
		        animation			: _slider.animation,
		        easing				: _slider.easing,
		        direction			: _slider.direction,
		        startAt				: _slider.startat,
		        slideshowSpeed		: _slider.slideshowspeed,
		        animationSpeed		: _slider.animationspeed,
		        initDelay			: _slider.initdelay,
		        prevText			: _slider.prevtext,
		        nextText			: _slider.nexttext,
		        randomize			: _slider.randomize,
		        animationLoop		: _slider.animationloop,
		        useCSS				: _slider.usecss,
		        touch				: _slider.touch,
		        keyboard			: _slider.keyboard,
		        slideshow			: _slider.slideshow,
		        reverse				: _slider.reverse,
		        smoothHeight		: _slider.smoothheight,
		        vide				: _slider.vide,
		        controlNav			: false,
		        directionNav		: _slider.directionnav,
		        pausePlay			: _slider.pauseplay,
		        sync				: '#thumbnail-'+_slider.id,
		        start				: function(slider){
								        	slider.parent().removeClass('loading');
								        },
				after 				: function(slider){
											DWH_colorBox();
										}
			});

		} else {

			JQ( _slider.selector ).flexslider({
		        animation			: _slider.animation,
		        easing				: _slider.easing,
		        direction			: _slider.direction,
		        startAt				: _slider.startat,
		        slideshowSpeed		: _slider.slideshowspeed,
		        animationSpeed		: _slider.animationspeed,
		        initDelay			: _slider.initdelay,
		        prevText			: _slider.prevtext,
		        nextText			: _slider.nexttext,
		        randomize			: _slider.randomize,
		        animationLoop		: _slider.animationloop,
		        useCSS				: _slider.usecss,
		        touch				: _slider.touch,
		        keyboard			: _slider.keyboard,
		        slideshow			: _slider.slideshow,
		        reverse				: _slider.reverse,
		        smoothHeight		: _slider.smoothheight,
		        vide				: _slider.vide,
		        controlNav			: _slider.controlnav,
		        directionNav		: _slider.directionnav,
		        pausePlay			: _slider.pauseplay,
		        start				: function(slider){
								        	slider.parent().removeClass('loading');
								        },
				after 				: function(slider){
											DWH_colorBox();
										}
			});
		}
	}
}

function loadNivoSlider(_slider){

	JQ( _slider.selector ).nivoSlider({
			effect           : _slider.effect,
			slices           : _slider.slices,
			boxCols          : _slider.boxcols,
			boxRows          : _slider.boxrows,
			animSpeed        : _slider.animspeed,
			pauseTime        : _slider.pausetime,
			startSlide       : _slider.startslide,
			directionNav     : _slider.directionnav,
			controlNav       : _slider.controlnav,
			controlNavThumbs : _slider.controlnavthumbs,
			pauseOnHover     : _slider.pauseonhover,
			manualAdvance    : _slider.manualadvance,
			prevText         : _slider.prevtext,
			nextText         : _slider.nexttext,
			randomStart      : _slider.randomstart,
			afterChange		 : function(slider){
									DWH_colorBox();
								}

	});
}

/* CTA FUNCTIONS */
function validatepromocode() {
    _promocode = JQ('.cta-promocode');
    _pattern = /^[A-Z0-9]+$/i;
    _countsplchr = 0;

    JQ(document).on( 'keyup', _promocode, function(){
        _value = _promocode.val();

        if ( _value != '' && !_pattern.test(_value) ) {
            _promocode.css('border', '1px solid red');
            _countsplchr++;
        } else {
            _promocode.css('border', '1px solid #ccc');
            _countsplchr = 0;
        }

        if( _countsplchr === 1) {
            _promocode.after('<span id="promocode_validation_notification" style="position:absolute; z-index: 100; bottom: -18px; left: 0; display: block; padding: 3px 0; font-size: 0.8em; color: red; background: #fcfcfc; text-align:center; width: 100%;">Invalid Code</span>');
        } else if ( _countsplchr === 0 ) {
            JQ('#promocode_validation_notification').remove();
        }

    });
}

function activateDateRangePicker(){

    JQ('.cta-arrival-date').on('click', function(){
        _datepicker = JQ(this).parentsUntil('.cta-calendar-wrapper').parent().siblings('.cta-date-range-picker');

        _updateDepartureDate = false;
        _updateArrivalDate = true;
        if ( _datepicker.datepicker('widget').is(':visible') ) {
            _datepicker.datepicker('hide');
        } else {
            _datepicker.datepicker('show');
        }
    });

    JQ('.cta-departure-date').on('click', function(){
        _datepicker = JQ(this).parentsUntil('.cta-calendar-wrapper').parent().siblings('.cta-date-range-picker');
        _updateDepartureDate = true;
        _updateArrivalDate = false;
        if ( _datepicker.datepicker('widget').is(':visible') ) {
            _datepicker.datepicker('hide');
        } else {
            _datepicker.datepicker('show');
        }
    });

    JQ('.cta-date-range-picker').each(function(){
        _this = JQ(this);
        _this.datepicker({
            constrainInput: true,
            changeMonth: true,
            changeYear: true,
            showTime:false,
            showHour: false,
            showMinute: false,
            showSecond: false,
            yearRange: "0:+1",
            minDate: 0,
            numberOfMonths: [2,1],
            beforeShowDay: function(date) {
                _arrival        = _this.parent().find('.cta-arrival-date');
                _departure      = _this.parent().find('.cta-departure-date');

                var arrivalDate = JQ.datepicker.parseDate(JQ.datepicker._defaults.dateFormat, JQ.datepicker.formatDate('mm/dd/yy', new Date(_arrival.val()) ));
                var departureDate = JQ.datepicker.parseDate(JQ.datepicker._defaults.dateFormat, JQ.datepicker.formatDate('mm/dd/yy', new Date(_departure.val()) ));
                var isHighlight = arrivalDate && ((date.getTime() == arrivalDate.getTime()) || (departureDate && date >= arrivalDate && date <= departureDate));
                return [true, isHighlight ? "dp-highlight" : ""];
            },
            onSelect: function(dateText, inst) {
                _arrival        = _this.parent().find('.cta-arrival-date');
                _departure      = _this.parent().find('.cta-departure-date');

                var arrivalDate     = JQ.datepicker.parseDate(JQ.datepicker._defaults.dateFormat, JQ.datepicker.formatDate('mm/dd/yy', new Date(_arrival.val()) ));
                var departureDate   = JQ.datepicker.parseDate(JQ.datepicker._defaults.dateFormat, JQ.datepicker.formatDate('mm/dd/yy', new Date(_departure.val()) ));
                var selectedDate    = JQ.datepicker.parseDate(JQ.datepicker._defaults.dateFormat, dateText);
                var nextday         = selectedDate.getTime() + 86400000;

                if ( _updateArrivalDate ) {

                    if ( selectedDate >= departureDate ) {

                        _updateDepartureDate = true;
                        _updateArrivalDate = false;

                        _arrival.attr('value', JQ.datepicker.formatDate('dd M yy', new Date( selectedDate ) ));
                        _departure.attr('value', JQ.datepicker.formatDate('dd M yy', new Date( nextday ) ));

                    } else if ( selectedDate >= arrivalDate ) {

                        _updateDepartureDate = true;
                        _updateArrivalDate = false;

                        _arrival.attr('value', JQ.datepicker.formatDate('dd M yy', new Date( selectedDate ) ));
                        _departure.attr('value', JQ.datepicker.formatDate('dd M yy', new Date( nextday ) ));

                    } else {

                        _updateDepartureDate = false;
                        _updateArrivalDate = true;

                        _arrival.attr('value', JQ.datepicker.formatDate('dd M yy', new Date( selectedDate ) ));

                    }

                    _this.data('datepicker').inline = true;
                    _this.datepicker();

                } else if ( _updateDepartureDate ) {

                    if ( departureDate < arrivalDate || selectedDate <= arrivalDate ) {

                        _updateDepartureDate = true;
                        _updateArrivalDate = false;

                        _arrival.attr('value', JQ.datepicker.formatDate('dd M yy', new Date( selectedDate ) ));
                        _departure.attr('value', JQ.datepicker.formatDate('dd M yy', new Date( nextday ) ));

                        _this.data('datepicker').inline = true;
                        _this.datepicker();

                    } else {

                        _updateDepartureDate = false;
                        _updateArrivalDate = true;

                        _departure.attr('value', JQ.datepicker.formatDate('dd M yy', new Date( selectedDate ) ));

                        _this.data('datepicker').inline = true;
                        _this.datepicker('hide');

                    }

                } else {

                    if ( selectedDate > arrivalDate ) {
                        _updateDepartureDate = true;
                        _updateArrivalDate = false;

                        _arrival.attr('value', JQ.datepicker.formatDate('dd M yy', new Date( selectedDate ) ));
                        _departure.attr('value', JQ.datepicker.formatDate('dd M yy', new Date( nextday ) ));

                    } else {

                        _updateDepartureDate = false;
                        _updateArrivalDate = true;

                    }

                    _this.data('datepicker').inline = true;
                    _this.datepicker();

                }

                updateUrlLink();
            },
            onClose: function() {
                _this.data('datepicker').inline = false;
            }
        });
    });
}

function activateDatePicker(){

    JQ('.cta-arrival-date').each(function(){
        _this = JQ(this);
        _this.datepicker({
            dateFormat: "dd M yy",
            showOn: "both",
            buttonImageOnly: false,
            buttonText: '',
            constrainInput: true,
            changeMonth: true,
            changeYear: true,
            showTime:false,
            showHour: false,
            showMinute: false,
            showSecond: false,
            yearRange: "0:+1",
            minDate: 0,
            onSelect: updateArrivalDate,
            onClose: function(dateText, inst){
                if ( device.detect.isie ){
                    this.fixFocusIE = true;
                    this.focus();
                }
            },
            beforeShow: function(input, inst){
                if ( device.detect.isie ) {
                    var result = !this.fixFocusIE;
                    this.fixFocusIE = false;
                    return result;
                }
            }
        });

        _this.datepicker('setDate', '0');
    });

    JQ('.cta-departure-date').each(function(){
        _this = JQ(this);
        _this.datepicker({
            dateFormat: "dd M yy",
            showOn: "both",
            buttonImageOnly: false,
            buttonText: '',
            constrainInput: true,
            changeMonth: true,
            changeYear: true,
            showTime:false,
            showHour: false,
            showMinute: false,
            showSecond: false,
            yearRange: "0:+1",
            defaultDate: +1,
            minDate: 0,
            onSelect: updateDepartureDate,
            onClose: function(dateText, inst){
                if ( device.detect.isie ){
                    this.fixFocusIE = true;
                    this.focus();
                }
            },
            beforeShow: function(input, inst){
                if ( device.detect.isie ) {
                    var result = !this.fixFocusIE;
                    this.fixFocusIE = false;
                    return result;
                }
            }
        });

        _this.datepicker('setDate', '1');
    });
}

function updateDepartureDate(){
    _departure      = JQ('.cta-departure-date');
    _date           = _departure.datepicker('getDate');

    _departure.datepicker('setDate', JQ.datepicker.formatDate('dd M yy', new Date(_date)));
    _departure.datepicker('hide');

    updateUrlLink();
}

function updateArrivalDate(){
    _arrival        = JQ('.cta-arrival-date');
    _departure      = JQ('.cta-departure-date');
    _date           = _arrival.datepicker('getDate');
    _nextday        = _date.getTime() + 86400000;
    _mindate        = new Date(_nextday);

    _arrival.datepicker('setDate', JQ.datepicker.formatDate('dd M yy', new Date(_date)));
    _arrival.datepicker('hide');

    _departure.datepicker('option', 'minDate', _mindate);
    _departure.datepicker('setDate', JQ.datepicker.formatDate('dd M yy', new Date(_nextday)));

    updateUrlLink();
}

function enterPromoCode(){
    settings.body.on('keyup', '.cta-promocode', function(){
        updateUrlLink();
    });
}

function selectProperty(){
    settings.body.on('change', '.cta-select-property', function(){
        updateUrlLink();
    });
}

function updateUrlLink(){
    _arrival            = JQ('.cta-arrival-date');
    _departure          = JQ('.cta-departure-date');
    ctabutton           = JQ('.cta-button');
    modifycancel        = JQ('.cta-modify-cancel-link');
    promocode           = JQ('.cta-promocode');
    hotelgroup          = JQ('.cta-select-property');

    arrivaldate         = JQ.datepicker.parseDate(JQ.datepicker._defaults.dateFormat, JQ.datepicker.formatDate('mm/dd/yy', new Date(_arrival.val())));
    departuredate       = JQ.datepicker.parseDate(JQ.datepicker._defaults.dateFormat, JQ.datepicker.formatDate('mm/dd/yy', new Date(_departure.val())));

    url                 = theme_option_objects.objects.url;
    hotelid             = theme_option_objects.objects.hotelsingle.hotel_id;
    booking_url         = theme_option_objects.objects.base_url;

    if( hotelgroup.length > 0 && theme_option_objects.objects.ibe_urls !== 'undefined') {
        hotelid         = hotelgroup.val();
        ibe_url         = theme_option_objects.objects.ibe_urls;

        moclink_url     = ibe_url[hotelid]+url.moc+hotelid+'/';
        booking_url     = ibe_url[hotelid];

        modifycancel.attr('href', moclink_url);
    }

    if( hotelgroup.length > 0 && theme_option_objects.objects.hotel_languages !== 'undefined') {
        hotelid         = hotelgroup.val();
        hotel_languages = theme_option_objects.objects.hotel_languages;
        hotellanguage   = hotel_languages[hotelid];
    } else {
        hotellanguage   = theme_option_objects.objects.hotelsingle.hotel_language;
    }


    if( _arrival.length > 0 && _departure.length > 0 ){

        if ( promocode.val() !== '' && promocode.length > 0 ) {
            booking_url     += url.promocode;
        } else {
            booking_url     += url.calendar;
        }

        booking_url         += hotelid+'/';

        if ( promocode.val() !== '' && promocode.length > 0 ) {
            booking_url     += promocode.val()+'/';
        }

        booking_url         += JQ.datepicker.formatDate( 'yy-mm-dd', new Date( arrivaldate ) )+ '/';
        booking_url         += JQ.datepicker.formatDate( 'yy-mm-dd', new Date( departuredate ) ) + '/';
    } else {
        booking_url         += hotelid+'/';
    }

    if ( hotellanguage !== 'en' ) {
        booking_url         += hotellanguage+'/';
    }

    booking_url             += url.param_1;

    ctabutton.attr('href', booking_url);
}

function clickLinks(){
    hotelgroup = JQ('.cta-select-property');

    settings.body.on('click', '.cta-button', function(e){
        if(hotelgroup.val() == 'select'){
            e.preventDefault();
            alert('select a hotel');
        }
    });

    settings.body.on('click', '.cta-modify-cancel-link', function(e){
        if(hotelgroup.val() == 'select'){
            e.preventDefault();
            alert('select a hotel');
        }
    });
}

JQ(document).ready(function(){

	DWH_loadStyle();

	/* CTA */
    validatepromocode();
    enterPromoCode();
    selectProperty();
    clickLinks();

    if ( theme_option_objects.objects.calendar_multiview ) {
        activateDateRangePicker();
    } else {
        activateDatePicker();
    }

    /* SLIDER */
	loadSlider();

    DWH_scrollTo();
    DWH_scrolledWindow();

	settings.window.on( 'load', function() {

        DWH_colorBox();
        DWH_toggleMainMenuIcon();
        DWH_splashPage();
        DWH_onSelectChange();
        DWH_onTabClick();
        DWH_onAccordionClick();
        DWH_onDropDownClick();

    });

});