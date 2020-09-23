var cta_settings,
	dwh_packages = (function(JQ){
	
	JQ(document).ready(function(){
		
		require(['jquery_ui_core','jquery_ui_datepicker'],function(){
		
			init();
			
		});
	
	});
	
	function init()
	{
		cta_settings = {

						'cta_ismobile'				 : 	is_mobile,
						'cta_item_container'  		  : JQ('.cta'),
						'cta_container'				  : 'cta-container-',
						'el_cta_button_container' 	  : '.control-wrapper',
						'cta_items'					  : {},						
						'cta_links' 				  : {'promo_calendar' : 'http://reservations.directwithhotels.com/reservation/showRooms/' },
						'el_cta_hotel_id'			  : 'input[name="hotelid"]',
						'el_cta_promo_id'			  : 'input[name="promoid"]',
						'el_cta_start_date'			  : 'input[name="startdate"]',
						'el_cta_end_date'			  : 'input[name="enddate"]',
						'el_cta_arrival_date_input'	  : 'input[name="arrival"]',
						'el_cta_departure_date_input' : 'input[name="departure"]'
					   };

		bindUIEvents();

	}
	
	function bindUIEvents()
	{
		
		cta_settings.cta_item_container.each(function(){
		
			_this = JQ(this);
			
			var cta_obj = {};
			cta_obj.cta_item_id     		=  	_this.attr('cta-item-id');
			cta_obj.cta_hotel_id			= 	_this.find(cta_settings.el_cta_hotel_id).val();
			cta_obj.cta_promo_id 			=	_this.find(cta_settings.el_cta_promo_id).val();
			cta_obj.cta_start_date 			= 	_this.find(cta_settings.el_cta_start_date).val();
			cta_obj.cta_end_date 			= 	_this.find(cta_settings.el_cta_end_date).val();

			cta_obj.cta_next_date_base	 	= 	new Date( cta_obj.cta_start_date.replace(/\-/g,'/') );
			cta_obj.cta_next_date			=	JQ.datepicker.formatDate('yy-mm-dd', new Date( cta_obj.cta_next_date_base.setDate( cta_obj.cta_next_date_base.getDate() + 1 )));
			
			/* Get CTA Item */
			var cta_item = { 
							hotel_id 			: cta_obj.cta_hotel_id, 
							promo_id 			: cta_obj.cta_promo_id, 
							start_date 			: cta_obj.cta_start_date, 
							end_date 			: cta_obj.cta_end_date
						};
			
			/* Store CTA Items */
			cta_settings.cta_items[ cta_obj.cta_item_id ] = cta_item;
			
			/* ========== GA Onclick Events =========== */
			var cta_onclick_strs 		= [];
			var cta_onclick_str  		= _this.find( cta_settings.el_cta_button_container );
			
			if( cta_onclick_str )
			{
				cta_onclick_strs[ cta_obj.cta_item_id ] 	= 	cta_onclick_str.find('.ctapromobutton').attr('onclick');
				
				if( typeof( cta_onclick_strs[ cta_obj.cta_item_id ] ) != 'undefined' )
				{
					cta_onclick_strs[ cta_obj.cta_item_id ]	= 	cta_onclick_strs[ cta_obj.cta_item_id ].replace( cta_obj.cta_start_date , 'onclick_date_str' );
					cta_onclick_strs[ cta_obj.cta_item_id ]	= 	cta_onclick_strs[ cta_obj.cta_item_id ].replace( cta_obj.cta_next_date , 'onclick_nextdate_str' );
				}
			}
			/* ========== GA Onclick Events =========== */
			
			/* Date Object */
			var date_obj = {
							mindate  : new Date( cta_obj.cta_start_date.replace(/\-/g,'/') ),
							maxdate  : new Date( cta_obj.cta_end_date.replace(/\-/g,'/') ),
							mydate 	 : new Date( cta_obj.cta_start_date.replace(/\-/g,'/') ),
							nextdate : new Date( cta_obj.cta_next_date.replace(/\-/g,'/') )
						};
			
			
			/* activate date picker */
			activateDatePicker( _this, date_obj, cta_obj, cta_onclick_strs );

		});

	}
	
	/* Activate datepicker */
	function activateDatePicker( _this, date_obj, cta_obj, cta_onclick_strs ){
		
		/* arrival date */
		_this.find( cta_settings.el_cta_arrival_date_input ).datepicker({
			
			dateFormat: "dd M yy",
			showOn: "both",
			buttonImageOnly: false,
			buttonText: '',		
			onSelect: function(date){
						
							var next_date = JQ(this).datepicker('getDate');
							var nextday = next_date.getTime() + (1000*60*60*24);
							var mindate = new Date(nextday);
							
							_this.find( cta_settings.el_cta_departure_date_input )
								.datepicker('option', 'minDate', mindate )
								.datepicker("setDate", jQuery.datepicker.formatDate('dd M yy', new Date(nextday)));
							
							/* dynamically update cta element */
							updateCtaElement( _this, cta_obj, cta_onclick_strs );
					},	
			constrainInput: true,
			changeMonth: true,	
			changeYear: true,		
			showTime:false,
			showHour: false,
			showMinute: false,
			showSecond: false,
			minDate: date_obj.mindate,
			maxDate: date_obj.maxdate
		});
		
		/* departure date */
		_this.find( cta_settings.el_cta_departure_date_input ).datepicker({
			
			dateFormat: "dd M yy",
			showOn: "both",
			buttonImageOnly: false,
			buttonText: '',		
			onSelect: function( date ) {
			
							/* dynamically update cta element */
							updateCtaElement( _this, cta_obj, cta_onclick_strs );
					},	
			constrainInput: true,
			changeMonth: true,	
			changeYear: true,		
			showTime:false,
			showHour: false,
			showMinute: false,
			showSecond: false,
			minDate: date_obj.nextdate,
			maxDate: date_obj.maxdate,
			defaultDate: +1
		});
		
	}
	
	function updateCtaElement( _this, cta_obj, cta_onclick_strs ){
	
		var _ctabutton = JQ('[cta-button-id="'+ cta_obj.cta_item_id +'"]');

		arrival = _this.find( cta_settings.el_cta_arrival_date_input );
		departure = _this.find( cta_settings.el_cta_departure_date_input );
		
		var arrival_date = arrival.datepicker('getDate');
		var departure_date = departure.datepicker('getDate');
		var format_date = 'yy-mm-dd';
		
		var cta_date = {
					arrival_date : JQ.datepicker.formatDate( format_date, new Date( arrival_date )),
					departure_date : JQ.datepicker.formatDate( format_date, new Date( departure_date ))
				}
		
		/* attach cta url */
		var booking_url = returnBookingUrl( cta_date, cta_obj );
		attachBookingUrl( _ctabutton, booking_url, 'href' );
		
		/* attach tracking event */
		if( cta_date && cta_onclick_strs )
		{
			
			/* only attach onclick event if its universal analytics */
			if( google_analytics_info.gtm_flag == 0 || google_analytics_info.gtm_flag == '' ){
			
				var _onclick_event = '';
				_onclick_event = update_onclick_event( 'onclick_date_str', cta_date.arrival_date, cta_onclick_strs[ cta_obj.cta_item_id ] );
				_onclick_event = update_onclick_event( 'onclick_nextdate_str', cta_date.departure_date, _onclick_event );
				
				attachTrackingEvent( _ctabutton, _onclick_event, 'onclick' );
			}
			
		}
	}
	
	/* Attach cta url */
	function attachBookingUrl( _ctabutton, booking_url, attribute ){
		
		_ctabutton.attr( attribute, booking_url );
	}
	
	/* Attach cta tracking */
	function attachTrackingEvent( element, value, attribute ){
	
		element.attr( attribute, value );
	}
	
	/* booking url constructor */
	function returnBookingUrl( cta_date, cta_obj ){
			
		var booking_url = cta_link_config['promo'].calendar.base_url;
		
		booking_url = booking_url + cta_settings.cta_items[ cta_obj.cta_item_id ].hotel_id +'/'+ cta_date.arrival_date +'/'+ cta_date.departure_date +'/';
		booking_url += cta_link_config[ 'promo' ].calendar.param1 +'/';
		booking_url += cta_settings.cta_items[ cta_obj.cta_item_id ].promo_id +'/';
		booking_url += cta_link_config[ 'promo' ].calendar.param2 +'/';
		
		return booking_url; 
	}
	

	function update_onclick_event( _replace, _val, _onclick_event  )
	{	
		var output = "";
		if( _onclick_event != '' ){
			output = _onclick_event.replace( _replace , _val );
		}

		return output;
	}
	
	
	return {
		'init' 						: init,
		'cta_settings' 				: cta_settings,
	 	'bindUIEvents' 				: bindUIEvents,
	 	'update_onclick_event' 		: update_onclick_event
	};


})(jQuery);
