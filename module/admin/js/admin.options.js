var $ = jQuery.noConflict();

/* Set initial theme sidebar activation mode to FALSE */
var is_theme_template_activated = 0;
var attachment_current_insertion_el = '';

$(document).ready(function() {

	$('body').delegate('.button-upload', 'click', function( e ) {
		e.preventDefault();

		var id = $(this).attr('href');
		var send_attachment_bkp = wp.media.editor.send.attachment;
		wp.media.editor.send.attachment = function(props, attachment) {
			$(id+' .image-preview').attr('src', attachment.url);
			$(id+' .logo-image-preview').attr('src', attachment.url);
			$(id+' .favicon-image-preview').attr('src', attachment.url);
			$(id+' .image-src').val(attachment.url);
			$(id+' .image-id').val(attachment.id);
			wp.media.editor.send.attachment = send_attachment_bkp;
		}

		wp.media.editor.open();

	});


	$('body').delegate('.button-upload-media-item', 'click', function( e ) {
		e.preventDefault();

		var id = $(this).attr('href');
		var caretpos = $(id).prop('selectionStart');
		var textareacontent = $(id).val();
		var send_attachment_bkp = wp.media.editor.send.attachment;

		wp.media.editor.send.attachment = function(props, attachment) {
			$(id).val(textareacontent.substr(0, caretpos) + attachment.url + textareacontent.substr(caretpos));
			wp.media.editor.send.attachment = send_attachment_bkp;
		}

		wp.media.editor.open();
	});


	/* Checkbox */
	$('body').delegate('.checkbox', 'change', function( e ) {
		id = $(this).val();

		if( $(this).is(':checked') ){
			$(this).val(1).attr('checked', true);
			$(id).val(1);
		} else {
			$(this).val(0).attr('checked', false);
			$(id).val(0);
		}
	});

	/*tab for textarea content*/
	$('body').delegate('.textarea-editor', 'keydown', function(e) {

		var keyCode = e.keyCode || e.which;
		if (keyCode == 9) {
			e.preventDefault();
			var start = $(this).get(0).selectionStart;
			var end = $(this).get(0).selectionEnd;
			$(this).val($(this).val().substring(0, start) + "\t" + $(this).val().substring(end));
			$(this).get(0).selectionStart =	$(this).get(0).selectionEnd = start + 1;
		}
	});


	/*
	* Fire upload file
	*/
	generalSettingsObj.uploadfile();


	/* Display Widget containers that has active contents */
	$('.widgets-holder-wrap').each(function(){
		var widgetContent = $(this).find('.widget');
		if(!widgetContent.attr('id')==""){
			$(this).removeClass('closed');
		}
	});


	$('#form-admin-style-settings input[name="rd-template-name"]').click(function(){

		var theme_template_name = $(this).attr('theme_template_name');
		$("#template-name").val(theme_template_name);


	});

	/* End of Theme Template Activation */


	/* Datatable Object */
	$('.dwh-datatable').dataTable( { "aaSorting" : [] , "pageLength": 25 }  );

	/*
	* trigger page theme slider
	* activate flexslider
	*/
	$('#theme-slider')
		.flexslider({
			animation: "fade",
			prevText: "",
			nextText: "",
			animationLoop: "true",
			animationSpeed: 600,
			slideshowSpeed: 7000
		});

	/*
	* Tab Menu
	*/
	$(document).on( 'click', '.tab-menu a', function(e){
		e.preventDefault();

		_this = $( this );
		_tabMenu = _this.parents('.tab-menu');
		_tabMenu.find('li a').removeClass('active');

		/* only disable tabs within tab object */
		$.each( _tabMenu.find('li'), function( key ){
			_id = $(this).find('a').attr('href');
			$( _id ).removeClass('show');

		});

		_this.addClass('active');
		$( _this.attr('href') ).addClass('show');
	});

	/*
	* trigger launch
	*/
	$(document).on('click', '.btn-launch', function(evt){
		evt.preventDefault();

		/* launch option view */
		generalSettingsObj.launchOptionSetView( $(this) );

	});


	/*
	* trigger edit buttons on Hotel Information
	*/
	$(document).on('click', '.popup-edit .sub-hotel-info a', function(evt){
		evt.preventDefault();

		_popupfields = $('.popup-edit').find('.options-popupmodal-fields');

		var option_set = $(this).attr('option_set');
		_this = $('#generalcontent').find('a.btn-launch[option_set="'+ option_set +'"]');

		/* launch option view */
		generalSettingsObj.launchOptionSetView( _this );

		/* deactivate modal */
		generalSettingsObj.callOptionsModal( _popupfields.parents('.options-popupmodal'), 0);


	});

	/*
	* trigger close
	*/
	$(document).on('click', '.option-close', function(evt){
		evt.preventDefault();

		var _this = $(this);
		var _tabmenu = $('ul.tab-menu');

		option_set = _this.attr('option_set');

		/* set up prev tab menu */
		var _prevli = _tabmenu.find('li a[href="#'+ option_set +'"]').parent().prev().find('a').attr('href');

		/* remove on tab menu */
		_tabmenu.find('li a[href="#'+ option_set +'"]').parent().remove();

		/* enable previous tab menu */
		_tabmenu.find('li a[href="'+ _prevli +'"]').addClass('active');

		/* hide tab current container */
		$('#'+ option_set).removeClass('show');

		/* show prev container tab */
		$( _prevli ).addClass('show');

	});


	/*
	* trigger cancel on Hotel Contact
	*/
	$(document).on('click', '.btn-option-cancel', function(evt){
		evt.preventDefault();

		/* disable field wrapper */
		generalSettingsObj.callOptionsFieldsWrapper( $( this ) );

	});


	/* Add Options */
	$(document).on('click', '.btn-datatable-add', function(evt){
		evt.preventDefault();

		var _this = $(this);

		/* enable preloader */
		generalSettingsObj.callOptionsPreloader( 1 );

		var option_set = _this.attr('option_set');
		var thisdatatable = generalSettingsObj.thisDataTable( option_set );
		thisdatatable.dataTable();

		/* get datatable no. of rows */
		var option_row = thisdatatable.fnGetData().length;

		if( option_set == 'dwh_hotels' ){

			generalSettingsObj.dwhOptionEditRow( option_set , option_row, 'add', nonces.option_edit_item_hotel.naction, nonces.option_edit_item_hotel.nonce,

													function( response ) {

														_popupmodalarea = $('.popup-add').find('.options-popupmodal-area');
														_popupfields = $('.popup-add').find('.options-popupmodal-fields');
														_popupfields.empty();

														_tabwrapper = $('.popup-add').find('.tab-menu-wrapper');
														_tabwrapper.empty();

														/* update modal option set */
														_popupmodalarea.attr( 'option_set', option_set );
														/* h3 text */
														_popupmodalarea.find('h3').text('Hotel Information Settings');

														var _tabElement = Admin_Tabs.newTab('option-tab-modal' , response );
														var _tabMarkUp = '<div class="tab-menu-wrapper">'+ _tabElement +'</div>'

														/* add tab markup */
														_popupfields.append( _tabMarkUp );

														var _popupfieldsinside = '<div class="options-tabcontainer-fields"><div>';

														/* loop through option settings property */
														$.each( response.option_settings , function( key_field, val_field ){

															_tabContainer = $('#tab_'+ key_field );
															/* append new element to tab container */
															_tabContainer.append( _popupfieldsinside );
															_popupfields1 = _tabContainer.find('.options-tabcontainer-fields');


															if( key_field == 'dwh_hotels' ){

																if( val_field['settings'] ){

																	var _ctr = 0;
																	var _ctrimg = 0;
																	var _ctrrel = 0;
																	$.each( val_field['settings'], function( key, val ){

																		/* append */
																		_popupfields1
																			.append( generalSettingsObj.returnOptionFieldsMarkup( key, val.properties, '', key_field, option_row, response.option_relation[key_field], response.option_image[ _ctrimg ], response.option_pagetheme, '', response ) );

																		if( val.properties.control_type == 'image' ){
																			_ctrimg++;
																		}

																		_ctr++;

																	});

																	/* get main flag field object */
																	_mainflag = _popupfields1.find('select[name="main_flag"]');

																	/* if option row is greater than 0; hotel branches */
																	if( option_row > 0 ){

																		_mainflag.val( 0 ).parents('.control-wrapper').hide();
																	}
																	/* else main hotel */
																	else{
																		_mainflag.val( 1 ).parents('.control-wrapper').hide();
																	}

																}

															}

															if( key_field == 'dwh_hotel_address' ){

																if( val_field['settings'] ){

																	var _ctr = 0;
																	var _ctrimg = 0;
																	var _ctrrel = 0;

																	$.each( val_field['settings'], function( key, val ){

																		/* append */
																		_popupfields1
																			.append( generalSettingsObj.returnOptionFieldsMarkup( key, val.properties, '', key_field, option_row, response.option_relation[key_field], response.option_image[ _ctrimg ], response.option_pagetheme, response.option_data, response ) );

																		if( val.properties.control_type == 'image' ){
																			_ctrimg++;
																		}

																		_ctr++;

																	});

																	/* get hotel ID field object */
																	_popupfields1.find('input[name="dwh_hotels_id"]').val( option_row ).parents('.control-wrapper').hide();

																}

															}


															if( key_field == 'dwh_hotel_contact' ){

																var _tblHotelContactWrapper = '<div id="table_'+ key_field +'"></div>';
																var _tablemarkup = '';

																/* prepend new element to tab container */
																_tabContainer.prepend( _tblHotelContactWrapper );
																_popuptablewrapper = _tabContainer.find( '#table_'+ key_field );

																/* hide fields wrapper */
																_popuptablewrapper.find('.options-tabcontainer-fields' ).hide().empty();


																/* newTable( table_name , data, settings, rowdata ) */
																_tablemarkup = Admin_Tables.newTable('tbl_dwh_hotel_contact' , response, val_field['settings'], response.option_data[ key_field ] );

																/* append table */
																_popuptablewrapper.append( _tablemarkup );

																var thisdatatable = generalSettingsObj.thisDataTable( 'table_'+ key_field );

																/* add action column to thead */
																thisdatatable.find('thead > tr').append('<th>Action</th>');

																var tablectr = 0;
																/* add edit/delete to table rows */
																$.each( thisdatatable.find('tbody tr'), function( index ){

																	_this = $(this);
																	var _linktd = '<a href="#" class="btn-datatable-edit button-primary" option_title="Hotel Contact" option_set="'+ key_field +'" option_row="'+ _this.attr('option_row') +'">Edit</a> \
																					<a href="#" class="btn-datatable-delete button-primary" option_set="'+ key_field +'" option_row="'+ _this.attr('option_row') +'">Delete</a>';
																	/* append row td */
																	_this.append('<td>'+ _linktd + '</td>');

																});

																/* add Add Entry Button */
																_popuptablewrapper.append('<a option_set="'+ key_field +'" option_title="Hotel Contact" class="btn-datatable-add button-primary" href="#">Add Entry</a>');

																thisdatatable.dataTable();

															}

															/* append hidden field */
															_popupfields1.append('<input type="hidden" name="data-row-hidden" option_set="'+ key_field +'" value="'+ option_row +'">');


														});

														/* hide Hotel Address and Hotel Info */
														_popupfields.find('.tab-menu-wrapper ul.tab-menu').hide();

														/* activate modal */
														generalSettingsObj.callOptionsModal( _popupfields.parents('.options-popupmodal'), 1);

														/* activate tab switching update */
														generalSettingsObj.activateTabSwitchingMarkupUpdate( _popupmodalarea );

														/* disable preloader */
														generalSettingsObj.callOptionsPreloader( );



													}
												);

		}

		else if( option_set == 'dwh_hotel_contact' ){

			var thisdatatable = generalSettingsObj.thisDataTable( 'table_'+ option_set );
			thisdatatable.dataTable();

			/* get datatable no. of rows */
			option_row = thisdatatable.fnGetData().length;

			generalSettingsObj.dwhOptionEditRow( option_set , option_row, 'add', nonces.option_edit_item.naction, nonces.option_edit_item.nonce,

													function(response) {

														_popupmodalarea = $('.popup-edit').find('.options-popupmodal-area');
														_tabwrapper = $('.popup-edit').find('.tab-menu-wrapper');

														_tabContainer = _tabwrapper.find( '#tab_'+ option_set );
														_tableContainer = _tabContainer.find( '#table_'+ option_set );
														_popupfields1 = _tabContainer.find( '.options-tabcontainer-fields' );
														_popupfields1.empty();

														var _ctr = 0;
														var _ctrimg = 0;
														var _ctrrel = 0;
														$.each( response.option_settings, function( key, val ){

															/* append */
															_popupfields1
																.append( generalSettingsObj.returnOptionFieldsMarkup( key, val.properties, response.option_data[key], option_set, option_row, response.option_relation[ key ], response.option_image[ _ctrimg ], '', response.option_data, response ) );

															if( val.properties.control_type == 'image' ){
																_ctrimg++;
															}

															if( val.properties.control_type == 'relation' ){

																_ctrrel++;
															}

															_ctr++;

														});

														var _linkbuttons = '<a href="#" class="btn-option-cancel button-secondary">Cancel</a>\
																			<a href="#" class="btn-datatable-table-processadd button-primary" option_set="'+ option_set +'" option_row="'+ option_row +'">Add</a>';

														/* prepare buttons */
														_popupfields1.append( _linkbuttons );

														/* add hotel id value and hide */
														var _hotelIdValue = _tabContainer.find('input[name="data-row-hidden"]').val();
														_popupfields1.find('input[name="dwh_hotels_id"]').val( _hotelIdValue ).attr( 'option_row', _hotelIdValue );
														_popupfields1.find('input[name="dwh_hotels_id"]').parents('.control-wrapper').hide();

														/* show fields wrapper */
														generalSettingsObj.callOptionsFieldsWrapper( _popupfields1.find( 'a.btn-datatable-table-processadd' ), 1 );

														/* disable preloader */
														generalSettingsObj.callOptionsPreloader( );


													}
												);

		}


		/* here goes the standard for Add */
		else{
			generalSettingsObj.dwhOptionEditRow( option_set , option_row, 'add', nonces.option_edit_item.naction, nonces.option_edit_item.nonce,

													function(response) {

														_popupmodalarea = $('.popup-add').find('.options-popupmodal-area');
														_popupfields = $('.popup-add').find('.options-popupmodal-fields');
														_popupfields.empty();

														/* update modal option set */
														_popupmodalarea.attr( 'option_set', option_set );
														/* update h3 */
														_popupfields.prev().text( 'Add '+ _this.attr('option_title') );

														var _ctr = 0;
														var _ctrrel = 0;
														/* loop through option settings property */
														$.each( response.option_settings , function( key, val ){

															/* append */
															_popupfields
																.append( generalSettingsObj.returnOptionFieldsMarkup( key, val.properties, '', option_set, option_row, response.option_relation[ _ctrrel ], '', '', response ) );


															if( val.properties.control_type == 'relation' ){
																_ctrrel++;
															}

															_ctr++;
														});

														_popupfields.append('<input type="hidden" name="data-row-hidden" option_set="'+ option_set +'" value="'+ option_row +'">');

														if(option_set == 'dwh_ibe_url'){
															_popupfields.append('<a href="#" class="get-ibe-url button-primary">Get URL</a>');

															$('.btn-datatable-processadd').hide();
														}else{
															$('.btn-datatable-processadd').show();
														}

														/* disable preloader */
														generalSettingsObj.callOptionsPreloader( );


														/* Append Option Set - custom views */
														generalSettingsObj.loadOptionSetView( option_set , _popupfields, response );

														/* activate modal */
														generalSettingsObj.callOptionsModal( _popupfields.parents('.options-popupmodal'), 1);


													}
												);

		}


		loadCodeMirror();

	});


	/* Add Options Hotel Contact */
	$(document).on('click', '.btn-datatable-table-processadd', function( evt ){
		evt.preventDefault();

		var _thisButton = $(this);
		var option_values = new Array();
		var tablerow_values = new Array();
		var option_field_name = "";

		var option_row = _thisButton.attr('option_row');
		var option_set = _thisButton.attr('option_set');

		_tabOptionContainer = $( '#tab_'+  _thisButton.attr('option_set') );
		_popupfields = _tabOptionContainer.find('.options-tabcontainer-fields');

		var _requirectr = 0

		_popupfields.find('.option-field')
			.each(function(){
				var _this = $(this);

				/* if empty */
				if( !$.trim( _this.val() ) && _this.hasClass('required') ){

					_this.css( {'border-color': 'red'} );
					_requirectr++;

				}

				/* if not empty */
				else{

					option_field_name = _this.attr('name');
					option_values.push({ 'field_name' : option_field_name , 'value' : _this.val() });

					/* restore border color */
					_this.css( {'border-color': '#ddd'} );
				}

			});


		/* ajax call when cleared */
		if( ! _requirectr ){

			/* add preloader */
			_thisButton.hide().after('<div style="display:inline-block; margin-left:15px; margin-top: 6px">saving...</div>');

			generalSettingsObj.dwhOptionAddRow( option_set , option_row , option_values,

													function(response) {

														/* if success is 1 means good */
														if( parseInt( response.success ) ){

															thisdatatable = generalSettingsObj.thisDataTable( 'table_'+ option_set );
															var _datatablethead = thisdatatable.find('thead > tr');
															var _datatabletd_count = _datatablethead.find('th').length;

															var _ctr = 0;
															var _value = '';

															$.each( response.option_settings, function( key, val ){

																/* if textarea */
																if( val['properties']['control_type'] == 'textarea' ){

																	_value = val['properties']['field_title'] +' content...';
																}

																/* if not, assign value */
																else{

																	_value = response.option_data[key];

																}

																/* filter dwh_hotels_id */
																if( key != 'dwh_hotels_id' ){

																	/* filter should be based on rendered table data */
																	if( _ctr < _datatabletd_count - 1  ){

																		/* push value to array */
																		tablerow_values.push( _value );
																		_ctr++;

																	}

																}

															});

															/* include edit button to new row */
															tablerow_values[ _datatabletd_count - 1 ] = '<a href="#" class="btn-datatable-edit button-primary" option_title="Hotel Contact" option_set="'+ option_set +'" option_row="'+ response.insert_id +'">Edit</a> \
																									   <a href="#" class="btn-datatable-delete button-primary" option_set="'+ option_set +'" option_row="'+ response.insert_id +'">Delete</a>';

															/* fire new datatable row */
															thisdatatable.dataTable().fnAddData( [
																tablerow_values
															] );

															/* disable field wrapper */
															generalSettingsObj.callOptionsFieldsWrapper( _thisButton );

														}

														/* if success is 0 means errors found */
														else{

															_popupfields.find('.error').remove();

															$.each( response.option_error, function( key, val ){

																/* append errors */
																_popupfields.append( '<div class="error"> Please provide valid '+ val['field_title'] +'</div>' );

															});

														}

														/* hide preloader */
														_thisButton.fadeIn().next().remove();

													});

		}

		/* if empty require fields */
		else{

			/* add error message */
			generalSettingsObj.callMessageNotification( 0, _thisButton, 'Fill in require fields.' );

		}

	});
	$(document).on('click', '.ibe-url-autosync-add-button', function(){
		// $('div[option_set="dwh_ibe_url_switch"] .btn-datatable-processadd').html('Set Auto Sync');
	});
	/* resetting IBE URL autosync */
	$(document).on('click','.reset-autosync-schedule',function(){
		$('.reset-cron-schedule').show();
		generalSettingsObj.clearIBEURLAutoSync( function( response ){

			var parsed = jQuery.parseJSON(JSON.stringify(response));

			var clearThis = setInterval(function(){
				$('.reset-cron-schedule').html(parsed.msg);
				clearInterval(clearThis);
			},1500)

		});
	});
	/* generating IBE URL */
	$(document).on('click', '.get-ibe-url', function( evt ){

		var modal_option_set = _popupmodalarea.attr( 'option_set' );
		$('.btn-datatable-processadd').hide();	//hide it for default
		$('.btn-datatable-update').hide(); 	//hide it for default
		 $('div[option_set="dwh_ibe_url"] .btn-datatable-processadd').html('Set URL');

		if( modal_option_set == 'dwh_ibe_url' ){

			$('.notify-updated').remove();
			$('.popup-event-notification').show();
			//remove the current result if exist
			if($('p').hasClass('ibe_id_url_result')){
				$('p.ibe_id_url_result').remove();
			}

			var ibe_domain_token    = $('input').hasClass('ibe_domain_token') ? $('.ibe_domain_token').val() : '';

			console.log('Retrieving token from IBE');
			$('.event-message').html('Retrieving token from IBE...');


			//retrieve assigned token from IBE
			generalSettingsObj.dwhIBEGetToken( ibe_domain_token, function( response ){

				if( response.success ){

					var assigned_token = response.data.token;
					var ibe_hotel_id_arr = $('input').hasClass('ibe_property_id') ? $('.ibe_property_id').val() : '';//value is

					console.log('Assigned token : '+ assigned_token);
					console.log('IDs : '+ ibe_hotel_id_arr);
					console.log('Encrypting token with Hotel ID');
					$('.event-message').html('Encrypting token with Hotel ID...');


						$('.event-message').html('Retrieving assigned URL...');


						var ibe_domain = $('input').hasClass('ibe_domain') ? $('.ibe_domain').val() : '';

						//retrieve desktop and mobile IBE url
						//generalSettingsObj.dwhIBEGenerateUrl( _obj.token, ibe_hotel_id, ibe_domain, function( response ){
						generalSettingsObj.dwhIBEGenerateUrl( ibe_hotel_id_arr, assigned_token, ibe_domain, function( response ){

							var parsed = jQuery.parseJSON(JSON.stringify(response));
							var html = '';
							var urlDomain = '';
							var ibeDomain = '';
							var defaultURL = 'http://reservations.directwithhotels.com';
							var myObject = (parsed);
								for (var key in myObject) {
								   if (myObject.hasOwnProperty(key)) {

									   ibeDomain = myObject[key].data.ibe_desktop_subdomain;
									   ibeDomain = (ibeDomain == 'https://' || ibeDomain == '') ? defaultURL : ibeDomain;

									   html += '<p class="ibe_id_url_result"><span style="display:inline-block; width:150px; font-weight:bold;">'+key+'</span> '+ibeDomain+'</p>';
									   $('input[name="ibe_desktop_url"]').val(JSON.stringify(response));
									}
								 }
							$('.ibe_domain_token').before(html);
							$('.btn-datatable-update').show();
							$('.popup-event-notification').hide();
							$('.btn-datatable-processadd').show();

						});

					//});

				 }else{
					console.log(' Unable to get assigned token from IBE');
				 }

			});
		}

		return false;
	});
	/* Add Options Process */
	$(document).on('click', '.btn-datatable-processadd', function( evt ){
		evt.preventDefault();

		var _thisButton = $(this);
		var option_values = new Array();
		var tablerow_values = new Array();
		var option_field_name = "";
		var parent_option_set = $(this).parent().attr('option_set');

		_popupmodalarea = $('.popup-add').find('.options-popupmodal-area');
		_popupfields = $('.popup-add').find('.options-popupmodal-fields');

		var option_row = '';
		var option_set = '';
		var modal_option_set = _popupmodalarea.attr( 'option_set' );

		/* detect variable */
		var _requirectr = 0;
		if( modal_option_set == 'dwh_cta_language' ){
			$('#dwh_cta_language .dataTables_info').html('Showing 1 to 1 of 1 entries');
		}
		if( modal_option_set == 'dwh_hotels' ){/* special case for dwh_hotels */

			_tabOptionContainer = $( '#tab_'+  _thisButton.attr('option_set') );
			_popupfields = _tabOptionContainer.find('.options-tabcontainer-fields');

			_thisDataRow = _tabOptionContainer.find('input[name="data-row-hidden"]');
			option_row = _thisDataRow.val();
			option_set = _thisDataRow.attr('option_set');

			_popupfields.find('.option-field')
				.each(function(){
					var _this = $(this);

					/* if empty */
					if( !$.trim( _this.val() ) && _this.hasClass('required') ){

						_this.css( {'border-color': 'red'} );
						_requirectr++;

					}

					/* if not empty */
					else{

						option_field_name = _this.attr('name');
						option_values.push({ 'field_name' : option_field_name , 'value' : _this.val() });

						/* restore border color */
						_this.css( {'border-color': '#ddd'} );
					}

				});


			/* ajax call when cleared */
			if( ! _requirectr ){

				generalSettingsObj.dwhOptionAddRow( option_set , option_row , option_values,

														function(response) {

															/* if success is 1 means good */
															if( parseInt( response.success ) ){

																thisdatatable = generalSettingsObj.thisDataTable( option_set );
																var _datatablethead = thisdatatable.find('thead > tr');
																var _datatabletd_count = _datatablethead.find('th').length;

																var _ctr = 0;
																var _value = '';

																$.each( response.option_settings, function( key, val ){

																	/* if textarea */
																	if( val['properties']['control_type'] == 'textarea' ){

																		_value = val['properties']['field_title'] +' content...';
																	}

																	/* else */
																	else{

																		_value = response.option_data[key];

																		/* Set boolean to Yes or No */
																		var boolToText = ['corpsite_flag','main_flag','noindexnofollow'];

																		if( _value in boolToText )
																		{
																			_value = _value == '1' ? 'Yes' : 'No';
																		}
																	}


																	/* filter should be based on rendered table data */
																	if( _ctr < _datatabletd_count - 1  ){

																		/* push value to array */
																		tablerow_values.push( _value );
																		_ctr++;

																	}

																});

																/* if hotel */
																if( option_set == 'dwh_hotels' ){

																	/* include edit button to new row */
																	tablerow_values[ _datatabletd_count - 1 ] = '<a href="#options-colorbox-inline" class="btn-datatable-edit colorbox-inline button-primary" option_set="'+ option_set +'" option_row="'+ response.insert_id +'">Edit</a> \
																										   <a href="#" class="btn-datatable-delete button-primary" option_set="'+ option_set +'" option_row="'+ response.insert_id +'">Delete</a>';

																}

																/* fire new datatable row */
																thisdatatable.dataTable().fnAddData( [
																	tablerow_values
																] );

																/* disable modal */
																generalSettingsObj.callOptionsModal( _popupfields.parents('.options-popupmodal') );

															}

															/* if success is 0 means errors found */
															else{

																_popupfields.find('.error').remove();

																$.each( response.option_error, function( key, val ){

																	/* append errors */
																	_popupfields.append( '<div class="error"> Please provide valid '+ val['field_title'] +'</div>' );

																});

															}

														});

			}

			/* if empty require fields */
			else{

				/* add error message */
				generalSettingsObj.callMessageNotification( 0, _thisButton, 'Fill in require fields.' );

			}

		}

		/* here goes the standard for add process */
		else{

			_thisDataRow = $(this).prev().find('input[name="data-row-hidden"]');
			option_row = _thisDataRow.val();
			option_set = _thisDataRow.attr('option_set');


			_popupfields.find('.option-field')
				.each(function(){
					var _this = $(this);

					/* if empty */
					if( !$.trim( _this.val() ) && _this.hasClass('required') ){

						_this.css( {'border-color': 'red'} );
						_requirectr++;

					}

					/* if not empty */
					else{

						option_field_name = _this.attr('name');
						option_values.push({ 'field_name' : option_field_name , 'value' : _this.val() });

						/* restore border color */
						_this.css( {'border-color': '#ddd'} );
					}

				});


			/* ajax call when cleared */
			if( ! _requirectr ){

				generalSettingsObj.dwhOptionAddRow( option_set , option_row , option_values,

														function(response) {

															/* if success is 1 means good */
															if( parseInt( response.success ) ){

																thisdatatable = generalSettingsObj.thisDataTable( option_set );
																var _datatablethead = thisdatatable.find('thead > tr');
																var _datatabletd_count = _datatablethead.find('th').length;

																var _ctr = 0;
																var _value = '';

																var setting_is_enabled = true;

																$.each( response.option_settings, function( key, val ){

																	/* if textarea */
																	if( val['properties']['control_type'] == 'textarea' || val['properties']['control_type'] == 'tag' ){

																		_value = val['properties']['field_title'] +' content...';
																	}

																	/* else */
																	else{

																		_value = response.option_data[key];

																		/* Set boolean to Yes or No */
																		var boolToText = ['corpsite_flag','main_flag','noindexnofollow'];

																		if( _value in boolToText )
																		{
																			_value = _value == '1' ? 'Yes' : 'No';
																		}
																	}


																	/* check blocklisted users */
																	if( val.properties.block_list ){

																		$.each( val.properties.block_list , function( key , role ){

																			if( user_info.role == role )
																			{
																				setting_is_enabled = false;
																			}

																		});
																	}
																	else{
																		setting_is_enabled = true;
																	}

																	/* hide blocklisted fields */
																	if( setting_is_enabled  === true ){

																		/* filter should be based on rendered table data */
																		if( _ctr < _datatabletd_count - 1  ){
																			if(parent_option_set == 'dwh_sitemap'){
																				/*//hide the add button for this option after successfully adding 1 entry
																				//only 1 entry is allowed*/
																				$('.sitemap-xml-add-button').hide();
																			}
																			if(parent_option_set == 'dwh_site_robots'){
																				/*//hide the add button for this option after successfully adding 1 entry
																				//only 1 entry is allowed*/
																				$('.robots-txt-add-button').hide();
																			}

																			if(parent_option_set == 'dwh_ibe_url_switch'){
																				/*//hide the add button for this option after successfully adding 1 entry
																				//only 1 entry is allowed*/
																				$('.ibe-url-autosync-add-button').hide();
																			}
																			if(parent_option_set == 'dwh_cta_language'){
																				/*//hide the add button for this option after successfully adding 1 entry
																				//only 1 entry is allowed*/
																				$('.cta-lang-add-button').hide();
																			}
																			if(parent_option_set == 'dwh_ibe_url'){
																				/*//hide the add button for this option after successfully adding 1 entry
																				//only 1 entry is allowed*/
																				$('.generate-ibe-url-button').hide();

																				var parsed = jQuery.parseJSON(_value);
																				var html = '';
																				var defaultURL = 'http://reservations.directwithhotels.com';
																				var myObject = (parsed);

																				for (var _index in myObject) {
																				   if (myObject.hasOwnProperty(_index)) {

																					   ibeDomain = myObject[_index].data.ibe_desktop_subdomain;
																					   ibeDomain = (ibeDomain == 'https://' || ibeDomain == '') ? defaultURL : ibeDomain;

																					   html += '<p class="ibe_id_url_result"><span style="display:inline-block; width:150px; font-weight:bold;">'+_index+'</span> '+ibeDomain+'</p>';
																					}
																				 }

																				 _value = html;
																			}

																			/* push value to array */
																			tablerow_values.push( _value );
																			_ctr++;

																		}

																	}

																});

																/* include edit button to new row */
																tablerow_values[ _datatabletd_count - 1 ] = '<a href="#options-colorbox-inline" class="btn-datatable-edit colorbox-inline button-primary" option_title="'+ response.option_details.title +'" option_set="'+ option_set +'" option_row="'+ option_row +'">Edit</a> \
																										   <a href="#" class="btn-datatable-delete button-primary" option_set="'+ option_set +'" option_row="'+ option_row +'">Delete</a>';

																/* fire new datatable row */
																thisdatatable.dataTable().fnAddData( [
																	tablerow_values
																]);

																/* disable modal */
																generalSettingsObj.callOptionsModal( _popupfields.parents('.options-popupmodal') );

															}

															/* if success is 0 means errors found */
															else{

																_popupfields.find('.error').remove();

																$.each( response.option_error, function( key, val ){

																	/* append errors */
																	_popupfields.append( '<div class="error"> Please provide valid '+ val['field_title'] +'</div>' );

																});

															}

														});

			}

			/* if empty require fields */
			else{

				/* add error message */
				generalSettingsObj.callMessageNotification( 0, _thisButton, 'Fill in require fields.' );

			}

		}



   	});


	/* Edit Option */
	$(document).on('click', '.btn-datatable-edit', function(evt){
		evt.preventDefault();

		/* enable preloader */
		generalSettingsObj.callOptionsPreloader( 1 );

		var _this = $(this);
		var option_set = _this.attr('option_set');
		var option_row = _this.attr('option_row');

		/* special case for dwh_hotels */
		if( option_set == 'dwh_hotels' ){

			generalSettingsObj.dwhOptionEditRow( option_set , option_row, 'edit', nonces.option_edit_item_hotel.naction, nonces.option_edit_item_hotel.nonce,

													function( response ) {

														_popupmodalarea = $('.popup-edit').find('.options-popupmodal-area');
														_popupfields = $('.popup-edit').find('.options-popupmodal-fields');
														_popupfields.empty();

														_tabwrapper = $('.popup-edit').find('.tab-menu-wrapper');
														_tabwrapper.empty();

														/* update modal option set */
														_popupmodalarea.attr( 'option_set', option_set );
														/* h3 text */
														_popupmodalarea.find('h3').text('Hotel Information Settings');

														var _tabElement = Admin_Tabs.newTab('option-tab-modal' , response );
														var _tabMarkUp = '<div class="tab-menu-wrapper">'+ _tabElement +'</div>'

														/* add tab markup */
														_popupfields.append( _tabMarkUp );

														var _popupfieldsinside = '<div class="options-tabcontainer-fields"><div>';

														/* loop through option settings property */
														$.each( response.option_settings , function( key_field, val_field ){

															_tabContainer = $('#tab_'+ key_field );
															/* append new element to tab container */
															_tabContainer.append( _popupfieldsinside );
															_popupfields1 = _tabContainer.find('.options-tabcontainer-fields');


															if( key_field == 'dwh_hotels' ){

																if( val_field['settings'] ){

																	var _ctr = 0;
																	var _ctrimg = 0;
																	var _ctrrel = 0;
																	$.each( val_field['settings'], function( key, val ){

																		/* append */
																		_popupfields1
																			.append( generalSettingsObj.returnOptionFieldsMarkup( key, val.properties, response.option_data[key_field][0][key], key_field, option_row, response.option_relation[key_field], response.option_image[ _ctrimg ], response.option_pagetheme, response.option_data, response ) );

																		if( val.properties.control_type == 'image' ){
																			_ctrimg++;
																		}

																		_ctr++;

																	});

																	/* hide main flag field object */
																	_popupfields1.find('select[name="main_flag"]').parents('.control-wrapper').hide();

																}

															}

															if( key_field == 'dwh_hotel_address' ){

																if( val_field['settings'] ){

																	var _ctr = 0;
																	var _ctrimg = 0;
																	var _ctrrel = 0;

																	$.each( val_field['settings'], function( key, val ){

																		/* append */
																		_popupfields1
																			.append( generalSettingsObj.returnOptionFieldsMarkup( key, val.properties, response.option_data[key_field][0][key], key_field, option_row, response.option_relation[key_field], response.option_image[ _ctrimg ], response.option_pagetheme, response.option_data, response ) );

																		if( val.properties.control_type == 'image' ){
																			_ctrimg++;
																		}

																		_ctr++;

																	});

																	/* hotel id index */
																	_popupfields1.find('input[name="dwh_hotels_id"]').val( option_row ).parents('.control-wrapper').hide();

																}

															}

															if( key_field == 'dwh_hotel_contact' ){

																var _tblHotelContactWrapper = '<div id="table_'+ key_field +'"></div>';
																var _tablemarkup = '';

																/* prepend new element to tab container */
																_tabContainer.prepend( _tblHotelContactWrapper );
																_popuptablewrapper = _tabContainer.find( '#table_'+ key_field );

																/* hide fields wrapper */
																_popuptablewrapper.find('.options-tabcontainer-fields' ).hide().empty();


																/* newTable( table_name , data, settings, rowdata ) */
																_tablemarkup = Admin_Tables.newTable('tbl_dwh_hotel_contact' , response, val_field['settings'], response.option_data[ key_field ] );

																/* append table */
																_popuptablewrapper.append( _tablemarkup );

																var thisdatatable = generalSettingsObj.thisDataTable( 'table_'+ key_field );

																/* add action column to thead */
																thisdatatable.find('thead > tr').append('<th>Action</th>');

																var tablectr = 0;
																/* add edit/delete to table rows */
																$.each( thisdatatable.find('tbody tr'), function( index ){

																	_this = $(this);
																	var _linktd = '<a href="#" class="btn-datatable-edit button-primary" option_title="Hotel Contact" option_set="'+ key_field +'" option_row="'+ _this.attr('option_row') +'">Edit</a> \
																					<a href="#" class="btn-datatable-delete button-primary" option_set="'+ key_field +'" option_row="'+ _this.attr('option_row') +'">Delete</a>';
																	/* append row td */
																	_this.append('<td>'+ _linktd + '</td>');

																});

																/* add Add Entry Button */
																_popuptablewrapper.append('<a option_set="'+ key_field +'" option_title="Hotel Contact" class="btn-datatable-add button-primary" href="#">Add Entry</a>');

																thisdatatable.dataTable();

															}

															/* append hidden field */
															_tabContainer.append('<input type="hidden" name="data-row-hidden" option_set="'+ key_field +'" value="'+ option_row +'">');


														});


														/* activate modal */
														generalSettingsObj.callOptionsModal( _popupfields.parents('.options-popupmodal'), 1);

														/* activate tab switching update */
														generalSettingsObj.activateTabSwitchingMarkupUpdate( _popupmodalarea );

														/* disable preloader */
														generalSettingsObj.callOptionsPreloader( );



													}
												);

		}

		/* special case for dwh_hotel_contact */
		else if( option_set == 'dwh_hotel_contact' ){

			generalSettingsObj.dwhOptionEditRow( option_set , option_row, 'edit', nonces.option_edit_item.naction, nonces.option_edit_item.nonce,

													function( response ) {

														_popupmodalarea = $('.popup-edit').find('.options-popupmodal-area');
														_tabwrapper = $('.popup-edit').find('.tab-menu-wrapper');

														_tabContainer = _tabwrapper.find( '#tab_'+ option_set );
														_tableContainer = _tabContainer.find( '#table_'+ option_set );
														_popupfields1 = _tabContainer.find( '.options-tabcontainer-fields' );
														_popupfields1.empty();

														var _ctr = 0;
														var _ctrimg = 0;
														var _ctrrel = 0;
														$.each( response.option_settings, function( key, val ){

															/* append */
															_popupfields1
																.append( generalSettingsObj.returnOptionFieldsMarkup( key, val.properties, response.option_data[key], option_set, option_row, response.option_relation[ key ], response.option_image[ _ctrimg ], '', response.option_data, response ) );

															if( val.properties.control_type == 'image' ){
																_ctrimg++;
															}

															if( val.properties.control_type == 'relation' ){

																_ctrrel++;
															}

															_ctr++;

														});

														var _linkbuttons = '<a href="#" class="btn-option-cancel button-secondary">Cancel</a>\
																			<a href="#" class="btn-datatable-update button-primary" option_set="'+ option_set +'" option_row="'+ option_row +'">Update</a>';

														/* prepare buttons */
														_popupfields1.append( _linkbuttons );

														/* hide hotel id index */
														_popupfields1.find('input[name="dwh_hotels_id"]').parents('.control-wrapper').hide();

														/* show fields wrapper */
														generalSettingsObj.callOptionsFieldsWrapper( _popupfields1.find( 'a.btn-datatable-update' ), 1 );

														/* disable preloader */
														generalSettingsObj.callOptionsPreloader( );

													}
												);
		}

		/* here goes the standard for edit */
		else{

			generalSettingsObj.dwhOptionEditRow( option_set , option_row, 'edit', nonces.option_edit_item.naction, nonces.option_edit_item.nonce,

													function( response ) {

														_popupmodalarea = $('.popup-edit').find('.options-popupmodal-area');
														_popupfields = $('.popup-edit').find('.options-popupmodal-fields');
														_popupfields.empty();

														/* update modal option set */
														_popupmodalarea.attr( 'option_set', option_set );
														/* update h3 */
														_popupfields.prev().text( 'Edit '+ _this.attr('option_title') );

														var _ctr = 0;
														var _ctrimg = 0;
														var _ctrrel = 0;
														var _hotelbranchvalue = '';
														var _append_to = [];

														switch( option_set )
														{

															case 'dwh_api_facebook_tab' :

																var fb_app_id = response.option_data['app_id'];
																var fb_redirect_uri = response.option_data['redirect_uri'];
																var fb_url_el_display = "none";

																if( fb_app_id && fb_app_id )
																{
																	fb_url_el_display = "block";
																}

																var fb_url_redirect = 'https://www.facebook.com/dialog/pagetab?app_id='+fb_app_id+'&redirect_uri='+fb_redirect_uri
																var _append_to_item = '<label id="lbl-fb-url-redirect" style"display:'+fb_url_el_display+'"> Copy paste Facebook tab URL Redirect : </label><b>' + '<span id="fb-url-redirect">' + fb_url_redirect + '<span></b>';
																_append_to.push(_append_to_item);

																break;

															case 'dwh_api_google_map':

																generalSettingsObj.activateGoogleMap( _popupfields, response );

																break;

														}

														var setting_is_enabled = true;

														/* Check if setting is restricted */
														/* loop through option settings property */
														$.each( response.option_settings , function( key, val ){

															/* Check for option sets that are block listed */
															if( val.properties.block_list )
															{
																$.each( val.properties.block_list , function( key , role ){


																	if( user_info.role.toLowerCase() == role.toLowerCase() )
																	{

																		setting_is_enabled = false;
																	}

																});
															}
															else{
																setting_is_enabled = true;
															}


															if( setting_is_enabled  === true )
															{

																/* append */
																_popupfields
																	.append( generalSettingsObj.returnOptionFieldsMarkup( key, val.properties, response.option_data[key], option_set, option_row, response.option_relation[ _ctrrel ], response.option_image[ _ctrimg ], response.option_pagetheme, response.option_data, response ) );


																if( val.properties.control_type == 'image' ){
																	_ctrimg++;
																}

																if( val.properties.control_type == 'relation' ){

																	_ctrrel++;
																}

																_ctr++;
															}


														});


														_popupfields.append( _append_to );
														_popupfields.append('<input type="hidden" name="data-row-hidden" option_set="'+ option_set +'" value="'+ option_row +'">');


														/* add reactivate sidebar checkbox */
														if( option_set == 'dwh_sites' ){

															if( user_info.role != 'editor' )
															{
																var _append_to_item = '<div class="control-wrapper full-width">\
																							<label> Check to reactivate widget sidebars ? <input class="option-field" type="checkbox" value="0" name="chk-reactivate-template-sidebars"></label>\
																							<p class="description">Check if you want to reset widgets based on site theme default configuration.</p>\
																					   </div>\
																					   <div class="control-wrapper full-width">\
																							<label> Check to reset menu? <input class="option-field" type="checkbox" value="0" name="chk-reset-menu"></label>\
																							<p class="description">Check if you want to reset menu based on site theme default configuration.</p>\
																					   </div>';
																_popupfields.find('.control-wrapper').eq(0).after( _append_to_item );
															}

														}




														/* Load custom option set views */
														generalSettingsObj.loadOptionSetView( option_set , _popupfields, response );



														switch( option_set )
														{

															case 'dwh_fonts_internal' :

																	/* show fonts */
																	showSelectFont( response.option_data['font_name'], _popupfields );

															case 'dwh_sites':

																	/* show site themes */
																	showSelectThemes( response.option_data['site_theme'], _popupfields );

																	if( !setting_is_enabled )
																	{
																		/* Hide site Theme */
																		jQuery('[name="site_theme"]').hide();
																		jQuery('[name="chk-reactivate-template-sidebars"]').parent().parent().hide();
																	}

																break;

															case 'dwh_pages':

																	/* show page themes */
																	showSelecPageThemes( response.option_data['page_theme'], _popupfields  );

																break;


															case 'dwh_cta':

																	/* show cta set */
																	showSelecCTAset( response.option_data['cta_set'], _popupfields  );
																	var cur_cta_set = response.option_data['cta_set'];

																	if( response.option_default_data.widget_settings[cur_cta_set] )
																	{
																		var def_cta_settings = response.option_default_data.widget_settings[cur_cta_set].settings;
																		/* console.log( def_cta_settings ); */

																		/* enable/disable promocode */
																		enablePromoCode( def_cta_settings );

																		if( response.option_data['cta_title'] == '') {
																			$('input[name="cta_title"]').val( def_cta_settings.cta_title );
																		}

																		if( response.option_data['cta_label'] == '') {
																			$('input[name="cta_label"]').val( def_cta_settings.cta_label );
																		}


																		/* Set default cta field valuess */
																		if( response.option_data.bpg_tip == '' ) {
																			$('[name="bpg_tip"]').val( response.option_default_data.widget_settings.cta_bpg_tip );

																		}

																		if( response.option_data.bpg_inclusion == '' ) {
																			$('[name="bpg_inclusion"]').val( response.option_default_data.widget_settings.cta_bpg_inclusion );
																		}
																		if( response.option_data.cta_modify_cancel_link == '' ) {
																			$('[name="cta_modify_cancel_link"]').val( response.option_default_data.widget_settings.cta_modify_cancel_link );
																		}
																		if( response.option_data.cta_modify_cancel_text == '' ) {
																			$('[name="cta_modify_cancel_text"]').val(response.option_default_data.widget_settings.cta_modify_cancel_text );
																		}
																	}
																	else{
																		_popupfields.find("#cta-set-list .info").first().show();
																	}


																break;

																case 'dwh_promo_link_navigation':

																		/* load chosen */
																		loadChosen();

																break;

																case 'dwh_slider':

																		var _slidermarkup = '';

																		_slidermarkup = Slider_Item.newSlider( response.slider_items, response.slider_items_data );
																		_popupfields.append( _slidermarkup );

																		/* selectors */
																		var _accordionWrapper = jQuery(document).find( '.form-header-slider' );

																		/* initialize accordion */
																		_sliderObj.init( _accordionWrapper );

																break;

														}

														if(option_set == 'dwh_ibe_url'){
															_popupfields.append('<a href="#" class="get-ibe-url button-primary">Get URL</a>');

															$('.btn-datatable-update').hide();
														}else{
															$('.btn-datatable-update').show();
														}



														/* disable preloader */
														generalSettingsObj.callOptionsPreloader( );

														/* activate modal */
														generalSettingsObj.callOptionsModal( _popupfields.parents('.options-popupmodal'), 1);

														/* Slide to top most container of the option modal content */
														jQuery('html,body').find(".options-popupmodal-fields").animate({scrollTop: 0 }, 500 );
														jQuery('html,body').find("select[name='page_type']").parent().css('display','none');
														jQuery('html,body').find("select[name='page_theme']").parent().css('display','none');
														/* Code Mirror */
														loadCodeMirror();

													}
												);

		}


	});


	/* Update option */
	$(document).on('click', '.btn-datatable-update', function( evt ){

		evt.preventDefault();

		var _thisButton = $(this);
		var option_values = new Array();
		var option_field_name = "";

		_popupmodalarea = $('.popup-edit').find('.options-popupmodal-area');
		_popupfields = $('.popup-edit').find('.options-popupmodal-fields');

		var option_row = '';
		var option_set = '';
		var modal_option_set = _popupmodalarea.attr( 'option_set' );

		/* detect variable */
		var _requirectr = 0;

		/* special case for dwh_hotels */
		if( modal_option_set == 'dwh_hotels' ){

			_tabOptionContainer = $( '#tab_'+  _thisButton.attr('option_set') );
			_popupfields = _tabOptionContainer.find('.options-tabcontainer-fields');

			/* get option set first */
			option_set_value = _thisButton.attr('option_set');


			/* if Hotel Contact */
			if( option_set_value == 'dwh_hotel_contact' ){

				option_set = _thisButton.attr('option_set');
				option_row = _thisButton.attr('option_row');

				_popupfields.find('.option-field')
					.each(function(){
						var _this = $(this);

						/* if empty */
						if( !$.trim( _this.val() ) && _this.hasClass('required') ){

							_this.css( {'border-color': 'red'} );
							_requirectr++;

						}

						/* if not empty */
						else{

							option_field_name = $(this).attr('name');
							option_values.push({ 'field_name' : option_field_name , 'value' : _this.val() });

							/* restore border color */
							_this.css( {'border-color': '#ddd'} );
						}

					});


					/* ajax call when cleared */
					if( ! _requirectr ){

						/* process update */
						generalSettingsObj.dwhOptionUpdateRow( option_set , option_row , option_values,

														function(response) {

															/* if success is 1 means good */
															if( parseInt( response.success ) ){

																thisdatatable = generalSettingsObj.thisDataTable( 'table_'+ option_set );

																var _btndatatableedit = thisdatatable.find('a.btn-datatable-edit[option_row="'+ option_row +'"]');
																var _datatabletr = _btndatatableedit.parents('tr');
																var _datatabletd_count = _datatabletr.find('td').length;

																var _ctr = 0;
																var _value = '';

																$.each( response.option_settings, function( key, val ){

																	/* if textarea */
																	if( val['properties']['control_type'] == 'textarea' ){

																		_value = val['properties']['field_title'] +' content...';
																	}

																	/* if not, assign value */
																	else{
																		_value = response.option_data[key];
																	}

																	/* filter dwh_hotels_id */
																	if( key != 'dwh_hotels_id' ){

																		/* filter should be based on rendered table data */
																		if( _ctr < _datatabletd_count - 1  ){

																			/* update datatable text */
																			_datatabletr.find('td').eq( _ctr ).text( _value );
																			_ctr++;

																		}
																	}

																});


																/*
																* since theres no refresh datatable function available
																* restore table to its original state; Object.fnDestroy()
																* and fire datatable again; selector.DataTable()
																* seems the only way for now
																*/
																thisdatatable.dataTable().fnDestroy();
																thisdatatable.dataTable();


																/* disable field wrapper */
																generalSettingsObj.callOptionsFieldsWrapper( _thisButton );

															}

															/* if success is 0 means errors found */
															else{

																_popupfields.find('.error').remove();

																$.each( response.option_error, function( key, val ){

																	/* append errors */
																	_popupfields.append( '<div class="error"> Please provide valid '+ val['field_title'] +'</div>' );

																});

															}

														}

													);

					}

					/* if empty require fields */
					else{

						/* add error message */
						generalSettingsObj.callMessageNotification( 0, _thisButton, 'Fill in require fields.' );

					}

			}


			/* else if Hotel Info and Hotel Address */
			else{

				_thisDataRow = _tabOptionContainer.find('input[name="data-row-hidden"]');
				option_row = _thisDataRow.val();
				option_set = _thisDataRow.attr('option_set');

				_popupfields.find('.option-field')
					.each(function(){
						var _this = $(this);

						/* if empty */
						if( !$.trim( _this.val() ) && _this.hasClass('required') ){

							_this.css( {'border-color': 'red'} );
							_requirectr++;

						}

						/* if not empty */
						else{

							option_field_name = $(this).attr('name');
							option_values.push({ 'field_name' : option_field_name , 'value' : _this.val() });

							/* restore border color */
							_this.css( {'border-color': '#ddd'} );
						}

					});


					/* ajax call when cleared */
					if( ! _requirectr ){

						/* process update */
						generalSettingsObj.dwhOptionUpdateRow( option_set , option_row , option_values,

														function(response) {

															/* update option callback */
															generalSettingsObj.dwhOptionUpdateRowCallback( response, option_set, option_row, _popupfields, _thisButton );

														}

													);

					}

					/* if empty require fields */
					else{

						/* add error message */
						generalSettingsObj.callMessageNotification( 0, _thisButton, 'Fill in require fields.' );

					}

			}

		}


		/* special case for dwh_slider */
		else if( modal_option_set == 'dwh_slider' ){

				_thisDataRow = $(this).prev().find('input[name="data-row-hidden"]');
				option_row = _thisDataRow.val();
				option_set = _thisDataRow.attr('option_set');
				//var option_values_arr = new Array();

				_popupfields.find('.option-field')
					.each(function(){
						var _this = $(this);

						/* if empty */
						if( !$.trim( _this.val() ) && _this.hasClass('required') ){

							_this.css( {'border-color': 'red'} );
							_requirectr++;

						}

						/* if not empty */
						else{

							option_field_name = $(this).attr('name');
							option_values.push({ 'field_name' : option_field_name , 'value' : _this.val() });

							/* restore border color */
							_this.css( {'border-color': '#ddd'} );
						}

					});


					/* ajax call when cleared */
					if( ! _requirectr ){

						var item_values = [];
						_sliderWrapper = $('.form-header-slider');
						_sliderGroupWrapper = _sliderWrapper.find('.slider-group');

						_sliderGroupWrapper.each( function( key, val ){

							_thisGroup = $(this);
							_sliderItemWrapper = _thisGroup.find('.slider-item-wrapper');
							_sliderItem = _sliderItemWrapper.find('input[name^="slider-item-"], textarea[name^="slider-item-"]');

								item_values[ key ] = [];

								_sliderItem.each( function(){
									_this = $(this);
									field_name  = _this.attr('name');
									field_value = _this.val();

									item_values[ key ].push({ 'field_name' : field_name , 'value' : field_value });
								});

						});

						option_values['slider_item'] = item_values;

						/* process update */
						generalSettingsObj.dwhOptionUpdateRow( option_set , option_row , option_values,

														function(response) {

															/* update option callback */
															generalSettingsObj.dwhOptionUpdateRowCallback( response, option_set, option_row, _popupfields, _thisButton );

														}

													);

					}

					/* if empty require fields */
					else{

						/* add error message */
						generalSettingsObj.callMessageNotification( 0, _thisButton, 'Fill in require fields.' );

					}

		}

		/* here goes the standard for update */
		else{

			_thisDataRow = $(this).prev().find('input[name="data-row-hidden"]');
			option_row = _thisDataRow.val();
			option_set = _thisDataRow.attr('option_set');

			/* Facebook tab vars */
			var fb_app_id = "";
			var fb_redirect_uri = "";


			_popupfields.find('.option-field')
				.each(function(){
					var _this = $(this);

					/* if empty */
					if( !$.trim( _this.val() ) && _this.hasClass('required') ){

						_this.css( {'border-color': 'red'} );
						_requirectr++;

					}

					/* if not empty */
					else{

						option_field_name = $(this).attr('name');



						/* Update facebook tab url value */
						if( option_field_name == 'app_id' ) { fb_app_id = _this.val(); }
						if( option_field_name == 'redirect_uri' ) {  fb_redirect_uri = _this.val();}

						if( !fb_app_id == '' && !fb_redirect_uri == '' )
						{
							$("#lbl-fb-url-redirect").css('display','block');
							var fb_url_redirect = 'https://www.facebook.com/dialog/pagetab?app_id='+fb_app_id+'&redirect_uri='+fb_redirect_uri;
							$("#fb-url-redirect").html( fb_url_redirect );
						}
						/* Update facebook tab url value */
						option_values.push({ 'field_name' : option_field_name , 'value' : _this.val() });

						/* restore border color */
						_this.css( {'border-color': '#ddd'} );
					}

				});


			/* ajax call when cleared */
			if( ! _requirectr ){

				var reactivate_sidebar = _popupfields.find('input[name=chk-reactivate-template-sidebars]');
				var reset_menu = _popupfields.find('input[name=chk-reset-menu]');
				var cur_site_theme_name = _popupfields.find('select[name="site_theme"]').val();

				console.log('Current Settings:\nSelected Theme: '+ site_info.theme_name +'\nSite Theme : '+ site_info.theme_name );

				/* Check if re-activate sidebar is checked */
				if( reactivate_sidebar.is(':checked') || reset_menu.is(':checked') ){

					/*
					* detect if current theme is equal to site theme selected
					* show prompt; re-activate sidebar
					*/
					if( cur_site_theme_name == site_info.theme_name ){

						var confirm_msg = '';
						if( reactivate_sidebar.is(':checked') && reset_menu.is(':checked') ){
							confirm_msg = '"Reactivate widget sidebars" and "Reset menu" has been checked. Are you sure you want to proceed?';
						}
						else if( reactivate_sidebar.is(':checked') ){
							confirm_msg = 'This will set the widget sidebars to the default. To disable reactivation uncheck "Reactivate sidebars to default".';
						}
						else if( reset_menu.is(':checked') ){
							confirm_msg = '"Reset menu" has been checked. Are you sure you want to proceed?';
						}

						var conf_theme_reactivate = confirm( confirm_msg );

						/* show prompt */
						if( conf_theme_reactivate ){

							/* process update */
							generalSettingsObj.dwhOptionUpdateRow( option_set , option_row , option_values,

															function(response) {
																/* update option callback */
																generalSettingsObj.dwhOptionUpdateRowCallback( response, option_set, option_row, _popupfields, _thisButton );
															}

														);
							console.log( 'with prompt.' );
							return true;
						}

						else{
							is_theme_template_activated = 0;
							return false;
						}

					}

					/*
					* if current theme is not equal to site theme selected
					* no prompt, activate sidebar
					*/
					else{


						/* process update */
						generalSettingsObj.dwhOptionUpdateRow( option_set , option_row , option_values,

														function(response) {
															/* update option callback */
															generalSettingsObj.dwhOptionUpdateRowCallback( response, option_set, option_row, _popupfields, _thisButton );

														}

													);

						console.log( 'without prompt.' );
					}

				}

				/* Check if re-activate sidebar is not checked */
				else{

					/* process update */
					generalSettingsObj.dwhOptionUpdateRow( option_set , option_row , option_values,

													function(response) {

														/* update option callback */
														generalSettingsObj.dwhOptionUpdateRowCallback( response, option_set, option_row, _popupfields, _thisButton );

													}

												);
					/* Redirect to load resources needed for the new theme selection */
					if( cur_site_theme_name != site_info.theme_name ){

					}

					console.log( 'no prompts at all.' );
				}

			}

			/* if empty require fields */
			else{

				/* add error message */
				generalSettingsObj.callMessageNotification( 0, _thisButton, 'Fill in require fields.' );

			}

		}


   	});

	/* Delete option item */
	$(document).on('click', '.btn-datatable-delete', function(evt){
		evt.preventDefault();

		var _this = $(this);
		var option_set = _this.attr('option_set');
		var option_row = _this.attr('option_row');
		var conf = confirm('Delete item?');
		if( conf )
		{
			generalSettingsObj.dwhOptionDeleteRow( option_set, option_row , function( response ){
				/*
				* dwh_site_robots and sitemap-xml-add add button is visible if no data has been added yet
				* it is hidden when 1 data already added.
				* once the data has been deleted, display the add button again
				*/
				if(option_set == 'dwh_site_robots'){
					$('.robots-txt-add-button').show();
				}
				if(option_set == 'dwh_sitemap'){
					$('.sitemap-xml-add-button').show();
				}
				if(option_set == 'dwh_ibe_url_switch'){
					$('.ibe-url-autosync-add-button').show();
					$('#dwh_ibe_url_switch .dataTables_info').html('Showing 0 to 0 of 0 entries');
				}
				if(option_set == 'dwh_cta_language'){
					$('.cta-lang-add-button').show();
					$('#dwh_cta_language .dataTables_info').html('Showing 0 to 0 of 0 entries');
				}
				if(option_set == 'dwh_ibe_url'){
					$('.generate-ibe-url-button').show();
					$('#dwh_ibe_url .dataTables_info').html('Showing 0 to 0 of 0 entries');
				}
			});

			_this.parent().closest('tr').fadeOut();

		}

	});


	/* modify checkbox value */
	$(document).on('click', 'input[name="chk-reactivate-template-sidebars"], input[name="chk-reset-menu"]', function(){

		var _this = $(this);

		if( _this.is(':checked') ){

			_this.val(1);
		}
		else{
			_this.val(0);
		}

	});


	/* page type select change */
	$(document).on('change', '.option-field[name="page_type"]', function(){

		_this = jQuery(this);
		_pageTheme = _this.parents('.options-popupmodal-fields').find('.option-field[name="page_theme"]');

		var _val = _this.val();

		/* if not empty */
		if( _val ){

			generalSettingsObj.callOptionsPreloader( 1 );

			/* hide page theme */
			_pageTheme.parents('.control-wrapper').fadeOut().find('#page-themes-list .info').hide();


			generalSettingsObj.dwhOptionGetOptionSetData( '', _val, 'page_theme',

												function( response ){

													/* empty Page theme option */
													_pageTheme.empty();

													var _optionStr = '';
													_optionStr += '<option value="">Select Page Theme</option>';

													$.each( response.option_data[1], function( key, val ){

														if( _val == val.category ){

															_optionStr += '<option value="'+ key +'">'+ val.name +'</option> ';
														}

													});

													/* append to page theme */
													_pageTheme.append( _optionStr ).parents('.control-wrapper').fadeIn();

													/* disable preloader */
													generalSettingsObj.callOptionsPreloader( 0 );

												}

											);

		}


	});


	/* add image */
	$(document).on('click', 'a.option-change-image', function( evt ){
		evt.preventDefault();
		var _this = jQuery(this);

		/* call wp media popup */
		generalSettingsObj.wpUploadMediaPopup( _this, 'imageid' );
	});

	/* add media */
	$(document).on('click', 'a.option-uploaded-media-item', function( evt ){
		evt.preventDefault();
		var _this = jQuery(this);

		text_editor_id = _this.next().attr('id');

		/* call wp media popup */
		generalSettingsObj.wpUploadMediaPopup( _this, 'imageurl' );
	});

	/* add XML */
	$(document).on('click', '.button-import-xml', function( evt ){
		_thisButton = jQuery(this);

		generalSettingsObj.wpUploadMediaPopup( _thisButton, 'xml' );
	});

	/*tab for textarea content*/
	$(document).on('keydown', '.options-popupmodal-fields textarea', function(e) {
		var keyCode = e.keyCode || e.which;

		if (keyCode == 9) {
			e.preventDefault();

			_this = $(this);
			var start = _this.get(0).selectionStart;
			var end = _this.get(0).selectionEnd;
			_this.val(_this.val().substring(0, start) + "\t" + _this.val().substring(end));
			_this.get(0).selectionStart =	_this.get(0).selectionEnd = start + 1;
		}
	});


	/* close when close is click */
	$('.options-popupmodal-area > a.close').click(function( evt ){
		evt.preventDefault();

		var _this = $(this);

		generalSettingsObj.callOptionsModal( _this.parents('.options-popupmodal') );

	});


	/*
	* Migrate Options
	*/
	$(document).on('submit', '#form-migrate', function( esubmit){
		esubmit.preventDefault();

		_formthis = $(this);
		_sitetheme_from = $('select[name="migrate_ver_from"]').val();
		_sitetheme_to = $('select[name="migrate_ver_to"]').val();

		var migrate_ver = '';

		/* detect variable */
		var _requirectr = 0;

		_formthis.find('.option-field')
			.each(function(){
				_this = $(this);

				/* if empty */
				if( !$.trim( _this.val() ) && _this.hasClass('required') ){

					_this.css( {'border-color': 'red'} );
					_requirectr++;

				}

				/* if not empty */
				else{

					migrate_ver_from = _sitetheme_from;
					migrate_ver_to = _sitetheme_to;
					/* restore border color */
					_this.css( {'border-color': '#ddd'} );
				}

			});


		/* ajax call when cleared */
		if( ! _requirectr ){

			var conf_migrate = confirm('Please spend your next second to think. Are you sure you want to migrate data?');

				if(conf_migrate){

					/* enable preloader */
					generalSettingsObj.callOptionsPreloader( 1 );

					/* remove previous success message */
					_formthis.parent().find('.success-msg').remove();

					generalSettingsObj.dwhOptionMigrateUpdate( migrate_ver_from , migrate_ver_to ,

															function(response) {

																/* if success is 1 means good */
																if( parseInt( response.success ) ){

																	/* add success message */
																	_formthis.after('<div class="updated success-msg" style="display:inline-block;"><p class="description" style="margin:0;">'+ response.msg +'</p></div>');

																}

																/* disable preloader */
																generalSettingsObj.callOptionsPreloader( );

															});

					return true;

				}

				else{

					return false;
				}

		}

	});


	/* migration from select change */
	var migrate_ver_to_arr_text = new Array();
	var migrate_ver_to_arr_value = new Array();
	_migrate_ver_to = $('select[name="migrate_ver_to"]');

	_migrate_ver_to.find('option').each(function( index ){

			_this = $( this );

			if( _this.val() ){
				migrate_ver_to_arr_text.push( _this.text() );
				migrate_ver_to_arr_value.push( _this.val() );
			}

	});

	/* migrate from onchange event */
	$('select[name="migrate_ver_from"]').change(function(){
		_this = $( this );

		_migrate_ver_to.val('');
		_migrate_ver_to.find('option').remove();

		if( _this.val() == 'aw' ){

			for( var i = 0; i < migrate_ver_to_arr_text.length; i++ ){
				var tempstr = migrate_ver_to_arr_value[i];
				var str = tempstr.substr( 0, 2 );

				if( str.toLowerCase() == 'aw' ){
					_migrate_ver_to.append('<option value="'+ migrate_ver_to_arr_value[i] +'">'+ migrate_ver_to_arr_text[i] +'</option>');
				}
			}

		}
		else if( _this.val() == 'nw' ){

			for( var i = 0; i < migrate_ver_to_arr_text.length; i++ ){
				var tempstr = migrate_ver_to_arr_value[i];
				var str = tempstr.substr( 0, 2 );

				if( str.toLowerCase() == 'nw' ){
					_migrate_ver_to.append('<option value="'+ migrate_ver_to_arr_value[i] +'">'+ migrate_ver_to_arr_text[i] +'</option>');
				}
			}
		}
		else{

			for( var i = 0; i < migrate_ver_to_arr_text.length; i++ ){

				_migrate_ver_to.append('<option value="'+ migrate_ver_to_arr_value[i] +'">'+ migrate_ver_to_arr_text[i] +'</option>');
			}
		}



	});


	/*
	* Export Options
	*/
	$(document).on('submit', '#form-export', function( esubmit ){

		esubmit.preventDefault();

		_formthis = $(this);
		_formButton = _formthis.find('input[type="submit"]');

		var conf_export = confirm('Export DWH Site options?');

		if( conf_export )
		{
			generalSettingsObj.dwhOptionGetXML( function( response ) {

				$("#textrea_export").val(response.xml);

				$.generateFile({
					filename	: 'dwh_site_options.xml',
					content		: $("#textrea_export").val(),
					script		: admin_paths.option_export + '/module/export.php'
				});

				$("#textrea_export").val("");

				generalSettingsObj.callMessageNotification( 1, _formButton , 'Site options exported');

			});


		}


	});

	/* Site fonts display */
	function showSelectFont( font_name, _popupfields )
	{
		_popupfields.find("#site-fonts-list div").hide();
		_popupfields.find('#' + font_name ).fadeIn();
	}

	/* Site Themes display */
	function showSelectThemes( theme_name , _popupfields )
	{
		_popupfields.find("#site-themes-list .info").hide();
		$('[id="'+theme_name+'"]').fadeIn();
	}

	/* Page themes display */
	function showSelecPageThemes( theme_name , _popupfields )
	{
		_popupfields.find("#page-themes-list .info").hide();
		$('[id="'+theme_name+'"]').fadeIn();
	}

	/* CTA Set display */
	function showSelecCTAset( cta_set , _popupfields )
	{
		_popupfields.find("#cta-set-list .info").hide();
		$('[id="'+cta_set+'"]').fadeIn();
	}

	function enablePromoCode( def_cta_settings ){

		if( typeof( def_cta_settings.cta_promo_code ) !== 'undefined' ){
			$('select[name="cta_promo_code"]').removeAttr('disabled');
		}
		else{
			$('select[name="cta_promo_code"]').attr('disabled', 'disabled');
		}

	}


	customFieldSliderEnable( $('select[name="page_theme"]').val() );

	/* Post custom slider fields - enable or disable */
	function customFieldSliderEnable( theme_name )
	{
		generalSettingsObj.dwhPageThemeConfig( theme_name , function( response ){

			if( response ){

				if( response.success == true )
				{
					if( response.data.page_theme_config.sliders.enable_flag == true )
					{
						$(".meta-box-slider").after('');
						$(".meta-box-slider").show();
					}
					else
					{
						$(".meta-box-slider").hide();
						$(".meta-box-slider").after();
						$(".meta-box-slider").after('Settings Disabled');
					}
				}

			}


		});

	}

	/* Leave page prompt */
	function leavePagePrompt()
	{
		/* Leave page prompt*/
		window.addEventListener("beforeunload", function (e) {
		    var confirmationMessage = 'It looks like you have been editing something.';
		    confirmationMessage += 'If you leave before saving, your changes will be lost.';

		    (e || window.event).returnValue = confirmationMessage; //Gecko + IE
		    return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
		});

	}


	/* cta set selection */
	$('select[name="cta_set"]').live('change',function(){
		var cta_set = $(this).val();
		_popupfields = $(this).parents('.options-popupmodal-fields');
		showSelecCTAset( cta_set, _popupfields );

		/* Set default title and label */
		var def_cta_settings = widget_settings.cta_settings[cta_set]['settings'];
		$("input[name='cta_title']").val( def_cta_settings.cta_title );
		$("input[name='cta_label']").val( def_cta_settings.cta_label );

		/* enable/disable promocode */
		enablePromoCode( def_cta_settings );

	});

	/* site fonts selection */
	$('select[name="font_name"]').live('change',function(){
		var font_name = $(this).val();
		_popupfields = $(this).parents('.options-popupmodal-fields');
		showSelectFont( font_name, _popupfields );
	});


	/* site fonts selection */
	$('select[name="site_theme"]').live('change',function(){
		var theme_name = $(this).val();
		_popupfields = $(this).parents('.options-popupmodal-fields');
		showSelectThemes( theme_name, _popupfields );
	});

	/* Post ( edit mode ) / Page settings - Custom field - CTA Display Flag  */
	$("#chk_h1_display_flag").change(function(){
		var checked = $(this).is(':checked');
		var check_val = checked == true ? '1' : '0';
		$("input[name='h1_display_flag']").val(check_val);
	});


	/* Post ( edit mode ) / Page settings - Custom field - CTA Display Flag  */
	$("#chk_cta_display_flag").change(function(){
		var checked = $(this).is(':checked');
		var check_val = checked == true ? '1' : '0';
		$("input[name='cta_display_flag']").val(check_val);
	});

	/* Post ( edit mode ) / Page settings - Custom field - CTA Display Flag  */
	$("#chk_address_field_display_flag").click(function(){
		var checked = $(this).is(':checked');
		var check_val = checked == true ? '1' : '0';
		$("input[name='address_field']").val(check_val);
	});

	/* Page themes selection */
	$('select[name="page_theme"]').live('change',function(){
		var theme_name = $(this).val();
		_popupfields = $(this).parents('.options-popupmodal-fields');
		showSelecPageThemes( theme_name, _popupfields );
		customFieldSliderEnable( theme_name );
	});


	/* Theme Designer */

	/* hide 2nd level if tabmenu is only 1 */
	var tablevel2 = $('ul.tab-menu-level2 li').length;

	$('.tab-container-level1').each( function(){

		_this = $(this);
		_tabmenu2 = _this.find('ul.tab-menu-level2 li');

		if( _tabmenu2.length == 1 ){
			_tabmenu2.hide();
		}

	});

	/* Load colorpicker */
	loadColorPicker();

	/* Theme Designer Save */
	$('a.btn-theme-designer-save').click(function(evt){
		evt.preventDefault();

		var _thisButton = $(this);
		var option_values = new Array();
		var option_field_name = "";

		var _design_type = $("select[name='theme-designer-types']").val();
		var _design_set = $("select[name='theme-designer-sets']").val();
		var _option_set = _thisButton.attr('data-name');
		var _option_row = _thisButton.attr('data-row');
		var _mode = _thisButton.attr('data-mode');

		/* detect variable */
		var _requirectr = 0;

		_fieldswrapper = $('#customtab-'+ _option_set );

		_fieldswrapper.find('.option-field')
				.each(function(){
					var _this = $(this);

					/* if empty */
					if( !$.trim( _this.val() ) && _this.hasClass('required') ){

						_this.css( {'border-color': 'red'} );
						_requirectr++;

					}

					/* if not empty */
					else{

						option_field_name = $(this).attr('name');
						option_values.push({ 'field_name' : option_field_name , 'value' : _this.val() });

						/* restore border color */
						_this.css( {'border-color': '#ddd'} );
					}

				});

		/* ajax call when cleared */
		if( ! _requirectr ){

			/* add preloader */
			_thisButton.hide().after('<div class="theme-success-msg" style="display:inline-block; margin-left:10px; margin-top: 6px">saving...</div>');

			generalSettingsObj.dwhThemeDesignerSave( _mode, _design_type , _design_set , _option_set, _option_row, nonces.option_theme_designer_save.naction, nonces.option_theme_designer_save.nonce, option_values,

														function( response ){

															/* if success is 1 means good */
															if( parseInt( response.success ) ){

																/* update button option_row and mode */
																_thisButton.attr( 'data-row', response.insert_id );
																_thisButton.attr( 'data-mode', 'edit' );

																/* add success message */
																generalSettingsObj.callMessageNotification( 1, _thisButton, 'Changes has been saved.' );

															}

															/* if success is 0 means errors found */
															else{

																/* add error message */
																generalSettingsObj.callMessageNotification( 0, _thisButton, response.msg );

															}


															hideColorPickers();

															/* Update theme designer css content */
															if( typeof(response.theme_designer_css) != 'undefined' )
															{
																if( response.theme_designer_css!='' )
																{
																	el_editor_theme_designer.setValue( response.theme_designer_css );
																}
															}

															/* disable preloader */
															_thisButton.parent().find('.theme-success-msg').remove();
															_thisButton.fadeIn();

														}

													);

		}

		/* if empty require fields */
		else{

			/* add error message */
			generalSettingsObj.callMessageNotification( 0, _thisButton, 'Fill in require fields.' );

		}

	});

	/* Page themes selection post type add and edit mode */
	showPostTypethemePreview( $('#post-type-theme').val() );
	function showPostTypethemePreview( page_theme )
	{
		$("#post-type-theme-list .info").hide();
		$("#post-type-theme-list #"+page_theme).show();
	}
	$('#post-type-theme').live('change',function(){
		var page_theme = $(this).val();
		showPostTypethemePreview( page_theme );
	});


	/* Option Set Reset Settings */
	$(document).on('click','#btn-reset-site-settings-individual',function(){
		_thisButton = $(this);

		var option_values = new Array();
		var option_field_name = "";

		_resetWrapper = _thisButton.parents('.reset-option-fields');
		_resetfields = _resetWrapper.find('input[type="checkbox"]');

		var _requirectr = 0;

		_resetfields
			.each(function(){
				var _this = $(this);
				var checked = _this.is(":checked");

				if( checked ){
					option_field_name = _this.attr('name');
					option_values.push({ 'field_name' : option_field_name , 'field_value' : checked });
					_requirectr++;

				}

			});

		if( _requirectr ){

			var conf = confirm("Please tell me you are serious about this. \nIf you hit 'OK', will clear \"all the selected\" option sets and will load their respective default settings. \nAgain, there's no turning back. Are you sure?");

			if( conf )
			{
				generalSettingsObj.dwhLoadDefaultOptions( 'sets', option_values, function(response){
					generalSettingsObj.callMessageNotification( 1, _thisButton , 'Default options loaded');
				});
			}
		}
		else{
			generalSettingsObj.callMessageNotification( 0, _thisButton , 'No option set selected');
		}


	});

	/* Bulk Reset site settings */
	$(document).on('click','#btn-reset-site-settings',function(){
		_thisButton = $(this);

		var conf = confirm("Seriously!? You are about to lose \"ALL\" data that you saved recently and will be replace with defaults.\nDo you still want to continue?");

		if( conf )
		{
			generalSettingsObj.dwhLoadDefaultOptions( 'bulk', '', function(response){
				generalSettingsObj.callMessageNotification( 1, _thisButton , 'Default options loaded');
			});

		}
	});


	/* Theme Designer Reset */
	$(document).on('click', '.btn-reset-this-design-set', function(evt){
		evt.preventDefault();
		_thisButton = $(this);

		var conf = confirm("Are you sure you want to reset this option set?");

		if( conf )
		{
			/* enable preloader */
			generalSettingsObj.callOptionsPreloader( 1 );

			var _design_set = _thisButton.attr('design-set');
			var option_values = {};

			option_values = { design_set : _design_set };

			/* mode, naction, nonce_sec, data, callback */
			generalSettingsObj.dwhThemeDesignerReset( 'designset', nonces.option_theme_designer_reset.naction, nonces.option_theme_designer_reset.nonce, option_values,

													function(response){
														if( response.success ){

															$('.option-field').val('').removeAttr('style');
															$('.btn-theme-designer-save').attr({ 'data-row': 0, 'data-mode': 'add' });
															el_editor_theme_designer.setValue( '' );

															generalSettingsObj.callMessageNotification( 1, _thisButton , 'Design set resetted.');
														}

														/* disable preloader */
														generalSettingsObj.callOptionsPreloader();

													}
			);

		}
	});

	/* Enable or disable theme designer render */
	$("input[type='checkbox']").change(function(){

		var name = $(this).attr('name');
		var checked = $(this).is(":checked");

		switch( name )
		{
			case 'designer_enable_flag':

				var design_set  = $("select[name='theme-designer-sets']").val();
				generalSettingsObj.dwhThemeDesignerEnable( design_set , checked );

				break;

			case 'enable_permalink_flush_rewrite':

				generalSettingsObj.dwhEnableFlushRewrite( checked , function( response ){
					if( response.success )
					{
						alert('enabled');
					}
				});

				break;
		}
	});





	/* Load theme design types - design sets */
	$("select[name='theme-designer-types']").change( function(){

		var design_type = $(this).val();
		var el_designer_sets = $("select[name=theme-designer-sets]");
		var cur_design_set = "";

		if( design_type ){

			el_designer_sets.find('option').remove();

			switch( design_type )
			{
				case 'site':

						generalSettingsObj.dwhgetThemesSite( function( response ){

							if( response ){

								$.each( response, function( key, val ){
									cur_design_set = key;
									return false;
								});

								redirectDesignerSet( design_type , cur_design_set );
							}

						});

					break;

				case 'page':

						generalSettingsObj.dwhgetThemesPage( function( response ){

							$.each( response , function( key , val ){

								el_designer_sets.append('<option value="'+key+'">'+val.name+'</option>');

								if( val.default_flag == true )
								{
									cur_design_set = key;
								}

							});

							redirectDesignerSet( design_type , cur_design_set );

						});

					break;
			}



		}

	});

	function redirectDesignerSet( design_type , cur_design_set )
	{
		window.location.href = site_info.base_url + '/wp-admin/admin.php?page=dwh-theme-designer&design_type='+design_type+'&design_set='+cur_design_set;
	}
	/* Load theme designer set views */
	$("#btn-load-designer-set").click( function(){

		var design_type = $("select[name='theme-designer-types']").val();
		var design_set  = $("select[name='theme-designer-sets']").val();

		redirectDesignerSet( design_type , design_set );

	});

	/* Reset or clear theme designer option field */
	$(document).on('click','.btn-reset-designer-field', function(){
		var colorpicker_el = $(this).parent().parent().find('.colorpicker');
		colorpicker_el.val('');
		colorpicker_el.css('background-color','#eee');
		colorpicker_el.iris('hide')
	});


/* Prettify code */
prettyPrint();

/* Inititalize code mirror */
loadCodeMirror();

$(document).on('click','.btn-view-source-codemirror',function(){
	$("#modal-docu").removeClass('hide');
	editor_theme_doc.setValue('');
	editor_theme_doc.setValue( $(this).next().html() );
});



});

