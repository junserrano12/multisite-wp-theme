var $width = jQuery(window).width();
var ua = window.navigator.userAgent;
var device = {
                'detect' : {
                                'isie'    : ua.indexOf("NET "),
                                'phone'   : ($width < 768) ? true : false
                           }
             }

var calendar_settings,
    dwh_calendar = function( jQuery ){

    var ui_settings;
    var hotel_id = hotel_info.hotel_id;

    jQuery(document).ready(function(){

        require(['jquery_ui_core','jquery_ui_datepicker'],function(){
            init();
        });

    });

    function init()
    {
        ui_settings = {
                        'booking'      : jQuery('#booking'),
                        'ctabutton'    : jQuery('.ctabutton'),
                        'arrival'      : jQuery('input[name=arrival]'),
                        'departure'    : jQuery('input[name=departure]'),
                        'promocode'    : jQuery('input[name=promo_code]'),
                        'hotelselect'  : jQuery('#select-hotel'),
                        'moclink'      : jQuery('.ctamodify'),
                        'hotelid'      : jQuery('input[name=hotelid]')
                      }

        bindUIEvents();
    }

    function bindUIEvents()
    {
        _date = new Date();

        activateDatepicker();
        setDateNow(_date);
        enterPromoCode();
        selectHotel();
        clickCtaButton();
        validatepromocode();
    }

    function validatepromocode()
    {
        _pattern = /^[A-Z0-9]+$/i;
        _countsplchr = 0;

        jQuery(document).on( 'keyup', 'input[name=promo_code]', function(){
            _value = ui_settings.promocode.val();

            if ( _value != '' && !_pattern.test(_value) ) {
                ui_settings.promocode.css('border', '1px solid red');
                _countsplchr++;
            } else {
                ui_settings.promocode.css('border', '1px solid #ccc');
                _countsplchr = 0;
            }

            if( _countsplchr === 1) {
                ui_settings.promocode.after('<span id="promocode_validation_notification" style="position:absolute; z-index: 100; bottom: -18px; left: 0; display: block; padding: 3px 0; font-size: 0.8em; color: red; background: #fcfcfc; text-align:center; width: 100%;">Invalid Code</span>');
                ui_settings.ctabutton.addClass('invalid');
            } else if ( _countsplchr === 0 ) {
                jQuery('#promocode_validation_notification').remove();
                ui_settings.ctabutton.removeClass('invalid');
            }

        });
    }

    function clickCtaButton()
    {
        jQuery('body').on('click', '.ctabutton', function(e){
            if ( site_info.is_corpsite > 0 ) {
                if ( ui_settings.hotelselect.val() == 'select' ) {
                    e.preventDefault();
                    alert('Please Select a Property')
                }
            }

            if ( ui_settings.ctabutton.hasClass('invalid') ) {
                e.preventDefault();
                alert('Invalid Promocode');
            }


        });

    }

    function setDateNow(date)
    {
        _nextday   = date.getTime() + (1000*60*60*24);
        _mindate   = new Date(_nextday);

        ui_settings.arrival.datepicker("setDate", jQuery.datepicker.formatDate('dd M yy', new Date(date)));
        ui_settings.arrival.datepicker("hide");

        ui_settings.departure.datepicker("option", 'minDate', _mindate);
        ui_settings.departure.datepicker("setDate", jQuery.datepicker.formatDate('dd M yy', new Date(_nextday)));

        updateUrlLink();
    }

    function activateDatepicker()
    {
        ui_settings.arrival.datepicker({
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

        ui_settings.departure.datepicker({
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
    }

    function updateDepartureDate()
    {
        // _date = ( device.detect.phone ) ? new Date( ui_settings.departure.val() ) : ui_settings.departure.datepicker('getDate');
        // if ( device.detect.phone ) {
        //     ui_settings.departure.val( jQuery.datepicker.formatDate('yy-mm-dd', new Date(_date)) );
        // } else {
        //     ui_settings.departure.datepicker('setDate', jQuery.datepicker.formatDate('dd M yy', new Date(_date)));
        //     ui_settings.departure.datepicker('hide');
        // }

        _date = ui_settings.departure.datepicker('getDate');
        ui_settings.departure.datepicker('setDate', jQuery.datepicker.formatDate('dd M yy', new Date(_date)));
        ui_settings.departure.datepicker('hide');

        updateUrlLink();
    }

    function updateArrivalDate()
    {
        // _date           = ( device.detect.phone ) ? new Date( ui_settings.arrival.val() ) : ui_settings.arrival.datepicker('getDate');
        // _nextday        = _date.getTime() + 86400000;
        // _mindate        = new Date(_nextday);

        // if ( device.detect.phone ) {

        //     ui_settings.arrival.val( jQuery.datepicker.formatDate('yy-mm-dd', new Date(_date)) );
        //     ui_settings.departure.attr( 'min', jQuery.datepicker.formatDate('yy-mm-dd', new Date(_nextday)) );
        //     ui_settings.departure.val( jQuery.datepicker.formatDate('yy-mm-dd', new Date(_nextday)) );

        // } else {

        //     ui_settings.arrival.datepicker('setDate', jQuery.datepicker.formatDate('dd M yy', new Date(_date)));
        //     ui_settings.arrival.datepicker('hide');

        //     ui_settings.departure.datepicker('option', 'minDate', _mindate);
        //     ui_settings.departure.datepicker('setDate', jQuery.datepicker.formatDate('dd M yy', new Date(_nextday)));
        // }

        _date           = ui_settings.arrival.datepicker('getDate');
        _nextday        = _date.getTime() + 86400000;
        _mindate        = new Date(_nextday);

        ui_settings.arrival.datepicker('setDate', jQuery.datepicker.formatDate('dd M yy', new Date(_date)));
        ui_settings.arrival.datepicker('hide');

        ui_settings.departure.datepicker('option', 'minDate', _mindate);
        ui_settings.departure.datepicker('setDate', jQuery.datepicker.formatDate('dd M yy', new Date(_nextday)));
        updateUrlLink();
    }

    function updateUrlLink()
    {

        // https://reservations.directwithhotels.com/reservation/showRooms/[hotel-id]/[check-in-date]/[checkout-out-date]/en/0/0/0/0
        // https://reservations.directwithhotels.com/reservation/showRoomsPromo/[hotel-id]/[promocode]/[check-in-date]/[checkout-out-date]
        // https://reservations.directwithhotels.com/reservation/modifyCancelPage/[hotel-id]/[language-code]
        // https://reservations.directwithhotels.com/reservation/selectDates/[hotel-id]/

        // arrivalDate         = jQuery.datepicker.parseDate(jQuery.datepicker._defaults.dateFormat, jQuery.datepicker.formatDate('mm/dd/yy', new Date(ui_settings.arrival.val())));
        // departureDate       = jQuery.datepicker.parseDate(jQuery.datepicker._defaults.dateFormat, jQuery.datepicker.formatDate('mm/dd/yy', new Date(ui_settings.departure.val())));

        // arrivaldate         = ( device.detect.phone ) ? new Date( ui_settings.arrival.val() ) : arrivalDate;
        // departuredate       = ( device.detect.phone ) ? new Date( ui_settings.departure.val() ) : departureDate;

        arrivaldate         = jQuery.datepicker.parseDate(jQuery.datepicker._defaults.dateFormat, jQuery.datepicker.formatDate('mm/dd/yy', new Date(ui_settings.arrival.val())));
        departuredate       = jQuery.datepicker.parseDate(jQuery.datepicker._defaults.dateFormat, jQuery.datepicker.formatDate('mm/dd/yy', new Date(ui_settings.departure.val())));

        if ( site_info.is_corpsite > 0 ) {
            hotelid     = ui_settings.hotelselect.val();
        } else {
            hotelid = hotel_info.hotel_id;
        }

        if( ui_settings.arrival.length > 0 && ui_settings.departure.length > 0 ){

            if( ui_settings.promocode.val() != '' && ui_settings.promocode.length > 0 ){
                booking_url  = cta_link_config.nw.promocode.base_url;
                booking_url += hotelid+'/';
                booking_url += ui_settings.promocode.val()+'/';
            } else {
                booking_url  = cta_link_config.nw.calendar.base_url;
                booking_url += hotelid+'/';
            }

            booking_url += jQuery.datepicker.formatDate( 'yy-mm-dd', new Date( arrivaldate ) )+ '/';
            booking_url += jQuery.datepicker.formatDate( 'yy-mm-dd', new Date( departuredate ) ) + '/';
        } else {
            booking_url  = ui_settings.hotelid.val();
            booking_url += hotelid;
        }

        if( ui_settings.promocode.val() != '' && ui_settings.promocode.length > 0 ){
            booking_url += cta_link_config.nw.promocode.param1;
            booking_url += cta_link_config.nw.promocode.param2;
            booking_url += cta_link_config.nw.promocode.param3;
        } else {
            if( ui_settings.arrival.length > 0 && ui_settings.departure.length > 0 ){
                booking_url += cta_link_config.nw.calendar.param1;
                booking_url += cta_link_config.nw.calendar.param2;
            }
        }

        moclink_url = cta_link_config.nw.moclink.base_url+hotelid+'/'+cta_link_config.nw.moclink.param1;

        ui_settings.moclink.attr('href', moclink_url);
        ui_settings.ctabutton.attr('href', booking_url);
    }

    function enterPromoCode()
    {
        jQuery('body').on('keyup', 'input[name=promo_code]', function(){
            updateUrlLink();
        });
    }

    function selectHotel()
    {
        jQuery('body').on('change', '#select-hotel', function(){
            updateUrlLink();
        });
    }

    return {

        'init'                      : init,
        'ui_settings'               : ui_settings,
        'calendar_settings'         : calendar_settings,
        'bindUIEvents'              : bindUIEvents

    };

}( jQuery );