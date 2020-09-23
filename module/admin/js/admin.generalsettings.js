/* declare general settings object */
var generalSettingsObj = {};

/* declare option  */
var option_set = "";	
var option_row = "";
var option_set_view = "";
var thisdatatable = "";

/*
* DWH Option Edit Row
* @param option_set	
* @param option_row
* @param callback: ajax success callback function
* @param response: param for callback, return object data after ajax response
*/
generalSettingsObj.dwhOptionEditRow = function( option_set , option_row, mode, naction, nonce_sec, callback ){
											
											jQuery.ajax({

												 type : "post",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 
															action: naction, 
															nonce_sec : nonce_sec,
															option_set	 : option_set,
															option_row	 : option_row,
															mode 		 : mode 
														},
												 success: callback 

											}); 
												
										};

										
/*
* DWH Option Add Row
* @param option_set	
* @param option_row
* @param option_values
* @param callback: ajax success callback function
* @param response: param for callback, return object data after ajax response
* 
*/
generalSettingsObj.dwhOptionAddRow = function( option_set , option_row , option_values, callback ){
												
												jQuery.ajax({
													 type : "post",
													 dataType : "json",
													 url : admin_ajax_url,
													 data : { 
																action: nonces.option_add_item.naction,
																nonce_sec : nonces.option_add_item.nonce,
																option_set	 	: option_set,
																option_row	 	: option_row,  
																option_values	: option_values
															},
													 success: callback

												}); 
												
											};									

				
/*
* DWH Option Update Row
* @param option_set	
* @param option_row
* @param option_values
* @param callback: ajax success callback function
* @param response: param for callback, return object data after ajax response
* 
*/
generalSettingsObj.dwhOptionUpdateRow = function( option_set , option_row, option_values, callback ){
												
												var _data = {};
												_data.action = nonces.option_update_item.naction;
												_data.nonce_sec = nonces.option_update_item.nonce;
												_data.option_set = option_set;
												_data.option_row = option_row;
												_data.option_values = option_values;
												
												if( option_values['slider_item'] ){
													_data.slider_item = option_values['slider_item'];
												}
												
												jQuery.ajax({
													 type : "post",
													 dataType : "json",
													 url : admin_ajax_url,
													 data : _data,
													 success: callback

												}); 
												
											};
											

/*
* DWH Option Update Callback
* @param arguments
* 
*/
generalSettingsObj.dwhOptionUpdateRowCallback = function(){

											response = arguments[0];		
											option_set = arguments[1];		
											option_row = arguments[2];		
											_popupfields = arguments[3];
											_thisButton = arguments[4];
											
											
											/* if success is 1 means good */
											if( parseInt( response.success ) ){
												
												thisdatatable = generalSettingsObj.thisDataTable( option_set );
												
												var _btndatatableedit = thisdatatable.find('a.btn-datatable-edit[option_row="'+ option_row +'"]');
												var _datatabletr = _btndatatableedit.parents('tr');
												var _datatabletd_count = _datatabletr.find('td').length;
												
												var _ctr = 0;
												var _value = '';
												
												var setting_is_enabled = true;
												
												$.each( response.option_settings, function( key, val ){
													
													/* if textarea */
													if( val['properties']['control_type'] == 'textarea' ){
														
														_value = val['properties']['field_title'] +' content...';
													}
													
													/* slider data */
													else if( key == 'slider-data' ){
														_value = 'Slider Item Object ';
													}
													
													/* else */
													else{
														
														_value = response.option_data[key];

														/* Set boolean to Yes or No */
														var boolToText = ['corpsite_flag','main_flag','noindexnofollow'];

														if( _value in boolToText )
														{	
															if(key != 'ibe_url_switch_interval'){
																_value = _value == '1' ? 'Yes': 'No';
															}
															
														}
														
													}
													
													/* Check if Option set is enabled based on blocklisted users */
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
													
													

													if( setting_is_enabled  === true ){
														
														/* filter should be based on rendered table data */
														if( _ctr < _datatabletd_count - 1  ){
															
															if(key == 'ibe_desktop_url'){
																
																var parsed = jQuery.parseJSON(_value);
																var html = '';
																var myObject = (parsed);
																var defaultURL = 'http://reservations.directwithhotels.com';
																
																for (var _index in myObject) {
																   if (myObject.hasOwnProperty(_index)) {
																	   
																	   ibeDomain = myObject[_index].data.ibe_desktop_subdomain;
																	   ibeDomain = (ibeDomain == 'https://' || ibeDomain == '') ? defaultURL : ibeDomain;
																	   
																	   html += '<p class="ibe_id_url_result"><span style="display:inline-block; width:150px; font-weight:bold;">'+_index+'</span> '+ibeDomain+'</p>';
																	}
																 }
																_value = html;
																_datatabletr.find('td').eq(_ctr).html( _value );
																_ctr++;
															}else{
																/* update datatable text */
																_datatabletr.find('td').eq(_ctr).text( _value );
																_ctr++;
															}
															
														}
													
													}

													
												});
												
												
												/* 
												* if site settings and selected theme equal to site theme
												*/
												if( response.option_data.site_theme && _popupfields.find('select[name="site_theme"]').val() == site_info.theme_name ){
													
													/* add success message */
													generalSettingsObj.callMessageNotification( 1, _thisButton, 'Changes has been saved.' );
												
												}
												
												/* else if site settings and selected theme not equal to site theme	*/
												else if( response.option_data.site_theme && _popupfields.find('select[name="site_theme"]').val() != site_info.theme_name ){
													
													/* add success message */
													generalSettingsObj.callMessageNotification( 1, _thisButton, 'Changes has been saved! Your page will reload in a moment to reflect the changes.' );
													
													/* reload the page in 3000ms */
													var autoReloadSettings = setTimeout(function(){ 
																location.reload(); },
																3000
														);
													
												}
												
												/* else if other settings */
												else{
													
													/* add success message */
													generalSettingsObj.callMessageNotification( 1, _thisButton, 'Changes has been saved.' );
												}

												
												switch( option_set)
												{	
													/* if Google Map */
													case 'dwh_api_google_map':
															generalSettingsObj.activateGoogleMap( _popupfields, response );
														break;
														
													case 'dwh_sites':
															
															/* if corpsite is 1 */
															if( parseInt( response.option_data.corpsite_flag ) ){
																$('#dwh_hotels').find('a.btn-datatable-add').removeClass('hide');
															}
															
															/* if corpsite is 0 */
															else{
																$('#dwh_hotels').find('a.btn-datatable-add').addClass('hide');
															}
															
														break;
												}


												/* 
												* since theres no refresh datatable function available
												* restore table to its original state; Object.fnDestroy()
												* and fire datatable again; selector.DataTable()
												* seems the only way for now
												*/
												thisdatatable.dataTable().fnDestroy();
												thisdatatable.dataTable();
												
												/* sidebar */
												is_theme_template_activated = parseInt( response.sidebar_data ) == 1 ? 1 : 0;
												
												/* assign new site theme */
												site_info.theme_name = response.option_data.site_theme;
												
												console.log( 'Updated Settings:\nSelected Site Theme : '+ _popupfields.find('select[name="site_theme"]').val() +'\nSite Theme : '+ site_info.theme_name +'\nis_theme_template_activated : '+ is_theme_template_activated );
												
											}
											
											/* if success is 0 means errors found */
											else{
											
												_popupfields.find('.error').remove();
											
												$.each( response.option_error, function( key, val ){
													
													/* append errors */
													_popupfields.append( '<div class="error"> Please provide valid '+ val['field_title'] +'</div>' );
													
												});
												
											}
											
										
										};
											
											
/*
* DWH Option Update Row
* @param option_set	
* @param option_row
* @param option_values
* @param callback: ajax success callback function
* @param response: param for callback, return object data after ajax response
* 
*/
generalSettingsObj.dwhOptionDeleteRow = function( option_set , option_row, callback ){
												
												jQuery.ajax({
													 type : "post",
													 dataType : "json",
													 url : admin_ajax_url,
													 data : { 
																action: nonces.option_delete_item.naction,
																nonce_sec : nonces.option_delete_item.nonce,
																option_set	 	: option_set,
																option_row	 	: option_row
															},
													 success: callback

												}); 
												
											};

/*
* DWH Option Get Option Set Data
* @param option_set	
* @param option_row
* @param mode
* @param callback: ajax success callback function
* @param response: param for callback, return object data after ajax response
* 
*/
generalSettingsObj.dwhOptionGetOptionSetData = function( option_set, option_row, mode, callback ){
												
												jQuery.ajax({

													 type : "post",
													 dataType : "json",
													 url : admin_ajax_url,
													 data : { 
																action       : nonces.option_get_option_set_data.naction, 
																nonce_sec    : nonces.option_get_option_set_data.nonce,
																option_set	 : option_set,
																option_row	 : option_row,
																mode         : mode
															},
													 success: callback 
													 
												});
												
											}

/* 
* Enable/Disable Options Modal
* @param _mode: accepts 1 or 0 value
* 1 means show modal
* 0 means hide modal
* defaul is 0
*/
generalSettingsObj.callOptionsModal = function( _this, _mode ){
										
											_mode = _mode || 0;
											
											if( _mode ){
												
												_this.parent().removeClass('hide');
											}
											else{
												_this.parent().addClass('hide');
												_this.find('.options-popupmodal-fields').empty();
												_this.find('a[class^="btn-datatable"]').show();
											}
											
											
											/* resize popupmodal fields area */
											var modalHeight = $(window).innerHeight();
											var modalFieldsHeight = ( modalHeight / 2 ) + ( modalHeight / 4 );
											
											_this.parent().find('.options-popupmodal-fields').css('max-height', modalFieldsHeight);
											
											/* handle resize */
											$( window ).resize(function() {
												
												/* handle resize */
												modalHeight = $(window).innerHeight();
												modalFieldsHeight = ( modalHeight / 2 ) + ( modalHeight / 4 );
												
												_this.parent().find('.options-popupmodal-fields').css('max-height', modalFieldsHeight);
											});
										};

/* 
* Enable Preloader
* @param _mode: accepts 1 or 0 value
* 1 means show modal
* 0 means hide modal
* defaul is 0
*/							
generalSettingsObj.callOptionsPreloader = function( _mode ){
										
												_mode = _mode || 0;
												
												if( _mode ){
													
													$('.options-preloader').parent().removeClass('hide');
												}
												else{
												
													$('.options-preloader').parent().addClass('hide');
												}
												
												
											};
									
									
									
/* 
* Enable/Disable Container Wrapper
* @param _mode: accepts 1 or 0 value
* 1 means show modal
* 0 means hide modal
* defaul is 0
*/
generalSettingsObj.callOptionsFieldsWrapper = function( _this, _mode ){
										
											_mode = _mode || 0;
											
											if( _mode ){
												
												_this.parents('.options-tabcontainer-fields').prev().hide();
												_this.parents('.options-tabcontainer-fields').fadeIn();
											}
											
											else{
											
												_this.parents('.options-tabcontainer-fields').hide();
												_this.parents('.options-tabcontainer-fields').prev().fadeIn();
											}
											
										};		

										
/* 
* Show Notification Message
* @param _mode: accepts 1 or 0 value
* 1 means show modal
* 0 means hide modal
* defaul is 0
* @param _thisButton: Add or Updated Button Object
* @param _message: The message you want to be displayed
*/							
generalSettingsObj.callMessageNotification = function( _mode, _thisButton, _message ){
												
												_mode = _mode || 0;
												
												/* if success message */
												if( _mode ){
												
													_thisButton.after('<div class="updated success-msg" style="display:inline-block; margin-left:15px;"><p class="description" style="margin:0;">'+ _message +'</p></div>');
													
													var autoRemoveMessageSuccess = setTimeout(function(){ 
																					_notifMsg = _thisButton.parent().find('.success-msg');
																					_notifMsg.fadeOut('slow', function(){ _notifMsg.remove(); });
																					},
																					3000
																				);
													}
												
												/* if error message */
												else{
												
													_thisButton.after('<div class="error error-msg" style="display:inline-block; margin-left:15px;"><p class="description" style="margin:0;">'+ _message +'</p></div>');
													
													var autoRemoveMessageError = setTimeout(function(){ 
																					_notifMsg = _thisButton.parent().find('.error-msg');
																					_notifMsg.fadeOut('slow', function(){ _notifMsg.remove(); });
																					},
																					3000
																				); 
												
												}

												
											};
									


/*
* Return option field element
* @param key: option key
* @param field: field Object
* @param value: option data value
* @param option_set: option set
* @param option_row: option row
* return form elements with values
*/
generalSettingsObj.returnOptionFieldsMarkup = function( key, field, value, option_set, option_row, option_rel, option_img, option_pagetheme, option_data, response ){
											

											var _htmldata = '';
											var _fieldclass =  field.class || 'full-width';
											var _html_cta_sets = '';
											
											_htmldata += '<div class="control-wrapper '+ _fieldclass +'">';
											
											/* setup require fields */
											var _required = '';

											/*check for undefined values */
											if( typeof(value) === 'undefined' )
											{
												value = '';
											}								
											
											if( field.required ){
												_required = ' required';
											}
											
											/* 
											* do switching for types 
											*/
											switch( field.control_type ){

												case 'text':
														
														var isHidden = '';
													 														
														if( key == 'ibe_desktop_url'){
															if(value != ''){
																value = JSON.parse(value);
															}
															isHidden = 'hide';
														}
														
														_htmldata += '<label><span class="title">'+ field.field_title +'</span>';
														_htmldata += '<input class="'+isHidden+' option-field'+ _required +'" type="text" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'" value="'+ value +'">';
														_htmldata += '<p class="description">'+ field.field_description +'</p>';
														_htmldata += '</label>';
															
																												
														if( key == 'ibe_desktop_url'){
															
															if(value != ''){
																//var parsed = jQuery.parseJSON(value);
																var parsed = value;
																console.log(value);
																console.log(value.toString().replace(/"/g, '\\"'));
																var myObject = (parsed);
																var defaultURL = 'http://reservations.directwithhotels.com';
																
																for (var key in myObject) {
																   if (myObject.hasOwnProperty(key)) {
																	   
																	   ibeDomain = myObject[key].data.ibe_desktop_subdomain;
																	   ibeDomain = (ibeDomain == 'https://' || ibeDomain == '') ? defaultURL : ibeDomain;
									   
																	   _htmldata += '<p class="ibe_id_url_result"><span style="display:inline-block; width:150px; font-weight:bold;">'+key+'</span> '+ibeDomain+'</p>';
																	}
																 }
																 
																 $('.ibe_domain_token').before(_htmldata);
															}
															
															//value is an array of IDs in a string format	
															_htmldata += '<input type="hidden" class="ibe_property_id" value="'+ field.field_hid_arr +'">'; 
															//_htmldata += '<input type="input" class="ibe_property_id" value="'+ field.field_hid +'">'; 
															// _htmldata += '<input type="hidden" class="ibe_token" value="'+ field.field_token +'">';
															_htmldata += '<input type="hidden" class="ibe_domain" value="'+ field.field_domain +'">';
															_htmldata += '<input type="hidden" class="ibe_domain_token" value="'+ field.field_issue_token +'">';
														} 

													break;
												
												case 'select':
												
														var _selected = '';
														var _selected2 = '';
														
														_htmldata += '<label><span class="title">'+ field.field_title;
														_htmldata += '<select class="option-field'+ _required +'" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'">';
														

														/* Custom */
														switch( option_set )
														{

															case 'dwh_cta':
																		
																		if( key == 'cta_set' ){
																			
																			/* Append CTA Sets */
																			Admin_Widgets.getDefaultSettings( 'widget_cta' , function( data ){

																				if( data.success == true )
																				{	
																					widget_settings['cta_settings'] = data.data.widget_settings;

																					$.each( data.data.widget_settings , function( key, val) {
																						var is_selected = value == key ? 'selected' : '';
																						
																						_html_cta_sets += '<option value="'+ key +'" '+is_selected+'>'+val.name+'</option>';
																					});
																				}
																				$("select[name='cta_set']").append( _html_cta_sets );
																			});
																		
																		}
																		
																		else if( key == 'cta_promo_code' ){
																		
																			_selected = value == 1 ? ' selected="selected"' : '';
																			_selected2 = value == 0 ? ' selected="selected"' : '';
																			
																			_htmldata += '<option value="1"'+ _selected +'> Yes </option>';
																			_htmldata += '<option value="0"'+ _selected2 +'> No </option>';
																			
																			_htmldata += '</select></span>';
																			_htmldata += '<p class="description">'+ field.field_description +'</p>';
																			_htmldata += '</label>';
																		}
																	
																break;

															default:


																	if( key == 'category' ){
															
																		_selected = value == 'social_media' ? 'selected="selected"' : '';
																		_htmldata += '<option value="social_media"'+ _selected +'> Social Media </option>';
																	}
																	
																	else if( key == 'assign_to' ){
																		
																		_selected = value == 'hotel_main' ? ' selected="selected"' : '';
																		_selected2 = value == 'hotel_branch' ? ' selected="selected"' : '';
																		
																		_htmldata += '<option value="hotel_main"'+ _selected +'> Hotel Main </option>';
																		_htmldata += '<option value="hotel_branch"'+ _selected2 +'> Hotel Branch </option>';
																	}
																	else{
																		
																		_selected = value == 1 ? ' selected="selected"' : '';
																		_selected2 = value == 0 ? ' selected="selected"' : '';
																		
																		_htmldata += '<option value="1"'+ _selected +'> Yes </option>';
																		_htmldata += '<option value="0"'+ _selected2 +'> No </option>';
																	}
																	

																	_htmldata += '</select></span>';
																	_htmldata += '<p class="description">'+ field.field_description +'</p>';
																	_htmldata += '</label>';

																break;


														}

													break;
													
												case 'textarea':
														
														_htmldata += '<label><span class="title">'+ field.field_title +'</span>';
														_htmldata += '<a class="option-uploaded-media-item button-secondary" href="#">Upload/Add Media</a>';
														_htmldata += '<textarea id="'+key+'" class="CodeMirror cm-s-twilight option-field'+ _required +'" row="8" col="4" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'">'+ value +'</textarea>';
														_htmldata += '<p class="description">'+ field.field_description +'</p>';
														_htmldata += '</label>';
														
													break;
												
												case 'tag':
														
														_htmldata += '<label><span class="title">'+ field.field_title +'</span>';
														_htmldata += '<textarea class="option-field'+ _required +'" row="2" col="4" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'">'+ value +'</textarea>';
														_htmldata += '<p class="description">'+ field.field_description +'</p>';
														_htmldata += '</label>';
														
													break;
												
												case 'email':
														_htmldata += '<label><span class="title">'+ field.field_title +'</span>';
														_htmldata += '<input class="option-field'+ _required +'" type="email" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'" value="'+ value +'">';
														_htmldata += '<p class="description">'+ field.field_description +'</p>';
														_htmldata += '</label>';
														
													break;
													
												case 'url':
														_htmldata += '<label><span class="title">'+ field.field_title +'</span>';
														_htmldata += '<input class="option-field'+ _required +'" type="url" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'" value="'+ value +'">';
														_htmldata += '<p class="description">'+ field.field_description +'</p>';
														_htmldata += '</label>';
														
													break;
												
												case 'radio':
														
														var _checked = value == 1 ? ' checked="checked"' : '';
														var _checked2 =  value == 0 ? ' checked="checked"' : '';
														
														_htmldata += field.field_title +' ';
														
														
														if( key == 'assign_to' ){
															
															_checked = value == 'hotel_main' ? ' selected="selected"' : '';
															_checked = value == 'hotel_branch' ? ' selected="selected"' : '';

															_htmldata += '<label><input type="radio" id="'+ key +'_1" class="option-field'+ _required +'" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'" value="hotel_main"'+ _checked +'> Hotel Main </label>';
															_htmldata += '<label><input type="radio" id="'+ key +'_2" class="option-field'+ _required +'" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'" value="hotel_branch"'+ _checked2 +'> Hotel Branch </label>';
														}
														
														else{
															
															_htmldata += '<label><input type="radio" id="'+ key +'_1" class="option-field'+ _required +'" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'" value="1"'+ _checked +'> Yes </label>';
															_htmldata += '<label><input type="radio" id="'+ key +'_2" class="option-field'+ _required +'" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'" value="0"'+ _checked2 +'> No </label>';
														
														}
														
														
														_htmldata += '<p class="description">'+ field.field_description +'</p>';
														
													break;
												
												case 'checkbox':
														if( key == 'cscript_display_to' ){
															value = '';
															if(response != undefined ){
																if('cscript_display_to' in response.option_data){
																	value = response.option_data['cscript_display_to'];
																}
															}																		
															checkBoxOptions = field.option_value;
															chkPageOptions  =  checkBoxOptions.split(',');
															var ptitle = [];
															if(value != '' && value != undefined){//convert it to array
																ptitle = value.toLowerCase().split(',');
															}else{
																value = 'All Pages';
															}
															_htmldata += '<label><span class="title">'+ field.field_title+'</span></label>';
															
															for(x in chkPageOptions){ 
																if(chkPageOptions[x] != '' && chkPageOptions[x] != 'Sitemap'){
																	_checked = jQuery.inArray(chkPageOptions[x].toLowerCase(), ptitle) != -1 ? 'checked="checked"' : ''; 
																		_htmldata += '<input class="displayed-in" type="checkbox" value="'+chkPageOptions[x]+'" '+_checked+' />'+chkPageOptions[x] +' &nbsp;';
																}																
															}											
															
															_htmldata += '<p class="description">'+ field.field_description +'</p>';
															_htmldata += '<input style="display:none;" class="display-script-in option-field'+ _required +'" type="checkbox" checked="checked" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'" value="'+value+'">';
														}
									
													break;
												
												case 'relation':
														
														if( option_set != 'dwh_hotels' || option_set != 'dwh_hotel_address' || option_set != 'dwh_hotel_contact' ){
															
															_htmldata += '<label><span class="title">'+ field.field_title;
															_htmldata += '<select class="option-field its-me-select relation'+ _required +'" option_rel="" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'">';
															_htmldata += '<option value="">Select '+ field.field_title +'</option>';
																
																/* loop all relation fields except page theme */
																$.each( option_rel, function( key1, val1 ){
																	var _selected = '';
																	
																	/* hack for special relation option settings */
																	if( key == 'site_theme' || key == 'font_name' ){
																		
																		if( $.type(val1) === 'object' ){																			
																			_selected = value == key1 ? 'selected="selected"' : ''; 
																			_htmldata += '<option value="'+ key1 +'"'+ _selected +'> '+ val1.name +' </option>';
																		}
																		
																	}
																	
																	else if( key == 'page_type' ){
																	
																		_selected = value == val1 ? 'selected="selected"' : ''; 
																		_htmldata += '<option value="'+ val1 +'"'+ _selected +'> '+ val1 +' </option>';
																		
																	}
																	
																	else if( key == 'slider-name' ){
																	
																		value = response.option_data['slider-name'];
																	
																		_selected = value == val1 ? 'selected="selected"' : ''; 
																		_htmldata += '<option value="'+ val1 +'"'+ _selected +'> '+ val1 +' </option>';
																		
																	}
																	
																	else if( key == 'slider-mode' ){
																	
																		value = response.option_data['slider-mode'];
																		final_value = val1.value;
																	
																		_selected = value == final_value ? 'selected="selected"' : ''; 
																		_htmldata += '<option value="'+ final_value +'"'+ _selected +'> '+ val1.name +' </option>';
																		
																	}
																	
																	else if( key == 'slider-type' ){
																	
																		value = response.option_data['slider-type'];
																		final_value = val1.value;
																	
																		_selected = value == final_value ? 'selected="selected"' : ''; 
																		_htmldata += '<option value="'+ final_value +'"'+ _selected +'> '+ val1.name +' </option>';
																		
																	}
																	
																});

																if( key == 'cta_language'){
																	value = '';
																	if(response != undefined){
																		value = response.option_data['cta_language'];
																	}																		
																	
																	var iso_lang = {'ab':'Abkhazian', 'aa':'Afar', 'af':'Afrikaans', 'ak':'Akan', 'sq':'Albanian', 'am':'Amharic', 'ar':'Arabic', 'an':'Aragonese', 'hy':'Armenian', 'as':'Assamese', 'av':'Avaric', 'ae':'Avestan', 'ay':'Aymara', 'az':'Azerbaijani', 'bm':'Bambara', 'ba':'Bashkir', 'eu':'Basque', 'be':'Belarusian', 'bn':'Bengali', 'bh':'Bihari languages', 'bi':'Bislama', 'bs':'Bosnian', 'br':'Breton', 'bg':'Bulgarian', 'my':'Burmese', 'ca':'Catalan, Valencian', 'km':'Central Khmer', 'ch':'Chamorro', 'ce':'Chechen', 'ny':'Chichewa, Chewa, Nyanja', 'zh':'Chinese', 'cu':'Church Slavonic, Old Bulgarian, Old Church Slavonic', 'cv':'Chuvash', 'kw':'Cornish', 'co':'Corsican', 'cr':'Cree', 'hr':'Croatian', 'cs':'Czech', 'da':'Danish', 'dv':'Divehi, Dhivehi, Maldivian', 'nl':'Dutch, Flemish', 'dz':'Dzongkha', 'en':'English', 'eo':'Esperanto', 'et':'Estonian', 'ee':'Ewe', 'fo':'Faroese', 'fj':'Fijian', 'fi':'Finnish', 'fr':'French', 'ff':'Fulah', 'gd':'Gaelic, Scottish Gaelic', 'gl':'Galician', 'lg':'Ganda', 'ka':'Georgian', 'de':'German', 'ki':'Gikuyu, Kikuyu', 'el':'Greek (Modern)', 'kl':'Greenlandic, Kalaallisut', 'gn':'Guarani', 'gu':'Gujarati', 'ht':'Haitian, Haitian Creole', 'ha':'Hausa', 'he':'Hebrew', 'hz':'Herero', 'hi':'Hindi', 'ho':'Hiri Motu', 'hu':'Hungarian', 'is':'Icelandic', 'io':'Ido', 'ig':'Igbo', 'id':'Indonesian', 'ia':'Interlingua (International Auxiliary Language Association)', 'ie':'Interlingue', 'iu':'Inuktitut', 'ik':'Inupiaq', 'ga':'Irish', 'it':'Italian', 'ja':'Japanese', 'jv':'Javanese', 'kn':'Kannada', 'kr':'Kanuri', 'ks':'Kashmiri', 'kk':'Kazakh', 'rw':'Kinyarwanda', 'kv':'Komi', 'kg':'Kongo', 'ko':'Korean', 'kj':'Kwanyama, Kuanyama', 'ku':'Kurdish', 'ky':'Kyrgyz', 'lo':'Lao', 'la':'Latin', 'lv':'Latvian', 'lb':'Letzeburgesch, Luxembourgish', 'li':'Limburgish, Limburgan, Limburger', 'ln':'Lingala', 'lt':'Lithuanian', 'lu':'Luba-Katanga', 'mk':'Macedonian', 'mg':'Malagasy', 'ms':'Malay', 'ml':'Malayalam', 'mt':'Maltese', 'gv':'Manx', 'mi':'Maori', 'mr':'Marathi', 'mh':'Marshallese', 'ro':'Moldovan, Moldavian, Romanian', 'mn':'Mongolian', 'na':'Nauru', 'nv':'Navajo, Navaho', 'nd':'Northern Ndebele', 'ng':'Ndonga', 'ne':'Nepali', 'se':'Northern Sami', 'no':'Norwegian', 'nb':'Norwegian Bokmål', 'nn':'Norwegian Nynorsk', 'ii':'Nuosu, Sichuan Yi', 'oc':'Occitan (post 1500)', 'oj':'Ojibwa', 'or':'Oriya', 'om':'Oromo', 'os':'Ossetian, Ossetic', 'pi':'Pali', 'pa':'Panjabi, Punjabi', 'ps':'Pashto, Pushto', 'fa':'Persian', 'pl':'Polish', 'pt':'Portuguese', 'qu':'Quechua', 'rm':'Romansh', 'rn':'Rundi', 'ru':'Russian', 'sm':'Samoan', 'sg':'Sango', 'sa':'Sanskrit', 'sc':'Sardinian', 'sr':'Serbian', 'sn':'Shona', 'sd':'Sindhi', 'si':'Sinhala, Sinhalese', 'sk':'Slovak', 'sl':'Slovenian', 'so':'Somali', 'st':'Sotho, Southern', 'nr':'South Ndebele', 'es':'Spanish, Castilian', 'su':'Sundanese', 'sw':'Swahili', 'ss':'Swati', 'sv':'Swedish', 'tl':'Tagalog', 'ty':'Tahitian', 'tg':'Tajik', 'ta':'Tamil', 'tt':'Tatar', 'te':'Telugu', 'th':'Thai', 'bo':'Tibetan', 'ti':'Tigrinya', 'to':'Tonga (Tonga Islands)', 'ts':'Tsonga', 'tn':'Tswana', 'tr':'Turkish', 'tk':'Turkmen', 'tw':'Twi', 'ug':'Uighur, Uyghur', 'uk':'Ukrainian', 'ur':'Urdu', 'uz':'Uzbek', 've':'Venda', 'vi':'Vietnamese', 'vo':'Volap_k', 'wa':'Walloon', 'cy':'Welsh', 'fy':'Western Frisian', 'wo':'Wolof', 'xh':'Xhosa', 'yi':'Yiddish', 'yo':'Yoruba', 'za':'Zhuang, Chuang', 'zu':'Zulu'};	
																	
																	for(x in iso_lang){
																		_selected = (value == x) ? 'selected="selected"' : ''; 
																		_htmldata += '<option class="testing" value="'+x+'" '+ _selected +'>'+iso_lang[x]+' ('+x+')</option>';
																	}	
																}
																if( key == 'ibe_url_switch_option'){
																	value = '';
																	if(response != undefined){
																		value = response.option_data['ibe_url_switch_option'];
																	}																		
																	
																	var switch_option = {'hr':'hour', 'min':'minute'};
																	
																	for(x in switch_option){
																		_selected = (value == x) ? 'selected="selected"' : ''; 
																		_htmldata += '<option class="testing" value="'+x+'" '+ _selected +'>'+switch_option[x]+' ('+x+')</option>';
																	}	
																}
																if( key == 'ibe_url_switch_interval'){
																	value = '';
																	if(response != undefined){
																		value = response.option_data['ibe_url_switch_interval'];
																	}
																	
																	var time_schedule = {'24':'Once A Day', '0.01':'Every 36sec (for testing only)','1':'Every 1 Hour', '2':'Every 2 Hours', '3':'Every 3 Hours', '4':'Every 4 Hours', '6':'Every 6 Hours', '8':'Every 8 Hours', '12':'2 Times A Day'};	
																	
																	for(x in time_schedule){
																		_selected = (value == x) ? 'selected="selected"' : ''; 
																		_htmldata += '<option class="testing" value="'+x+'" '+ _selected +'>'+time_schedule[x]+'</option>';
																	}
																		
																}
																
																if( key == 'cscript_location'){
																	value = '';
																	if(response != undefined){
																		value = response.option_data['cscript_location'];
																	}																		
																	
																	var sc_location = {'inside head tag':'header','below opening body tag':'body','above closing body tag':'footer'};	
																	
																	for(x in sc_location){
																		_selected = (value == x) ? 'selected="selected"' : ''; 
																		_htmldata += '<option class="testing" value="'+x+'" '+ _selected +'>'+sc_location[x]+' ('+x+')</option>';
																	}	
																}
																
																if( key == 'robots_action'){
																	value = '';
																	if(response != undefined){
																		value = response.option_data['robots_action'];
																	}
																	
																	var sc_location = ['Append','Replace'];
																	
																	for(x in sc_location){
																		_selected = (value == sc_location[x]) ? 'selected="selected"' : ''; 
																		_htmldata += '<option value="'+sc_location[x]+'" '+ _selected +'>'+sc_location[x]+'</option>';
																	}	
																}

																/* if page theme */
																if( key == 'page_theme' && option_pagetheme ){
																
																	$.each( option_pagetheme[0], function( key1, val1 ){
																	
																		if( option_data.page_type == val1.category ){
																			
																			_selected = value == key1 ? 'selected="selected"' : ''; 
																			_htmldata += '<option value="'+ key1 +'"'+ _selected +'> '+ val1.name +' </option>';
																			
																		}
																		
																	});
																
																}

															_htmldata += '</select></span>';
															_htmldata += '<p class="description">'+ field.field_description +'</p>';
															_htmldata += '</label>';
															
															if( key == 'ibe_url_switch_interval'){
																_htmldata += '<a href="#" class="button-primary reset-autosync-schedule">Reset Schedule</a><span class="reset-cron-schedule" style="margin-left:10px;display:none;">Please wait...</span>';
																	
															}
															
														}
														
														
													break;
			
												case 'image':
													
														_htmldata += '<label><span class="title">'+ field.field_title +'</span>';
														_htmldata += '<input class="option-field'+ _required +'" type="text" readonly="readonly" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'" value="'+ value +'">';
														_htmldata += '</label>';
														_htmldata += '<div class="option-image-holder">';
														
															var _imgsrc = site_info.template_directory_uri + images.gallery_image_noimg_150by150;
															
															if( value ){
																
																_imgsrc = option_img;
															}	
															
															_htmldata += '<img src="'+ _imgsrc +'" alt="" width="100px" height="100px">';
															
														_htmldata += '</div>';
														_htmldata += '<a class="option-change-image button-primary" href="#">Add Image</a>';
														_htmldata += '<p class="description">'+ field.field_description +'</p>';
													
													break;
													
												case 'hidden':
														
														switch( key ){
															
															case 'promo_post_ids':
																
																var _selected = '';
																var _selected2 = '';
																if( value ) var postids = value.split(',');
																
																_htmldata += '<label><span class="title">'+ field.field_title +'</span>';
																_htmldata += '<input class="option-field'+ _required +'" type="text" readonly="readonly" option_row="'+ option_row +'" option_set="'+ option_set +'" name="'+ key +'" value="'+ value +'">';
																_htmldata += '<select data-placeholder="Select Pages" class="chosen-select" option_row="'+ option_row +'" option_set="'+ option_set +'" field_name="'+ key +'" multiple>';
																_htmldata += '<option value=""></option>';
																	
																	if( response.option_postinfo['category'] && response.option_postinfo['posts'] ){
																	
																		$.each( response.option_postinfo['category'], function( cat_key, cat_val ){
																			
																			_htmldata += '<optgroup label="'+ cat_val +'">';
																				
																					$.each( response.option_postinfo['posts'], function( key, val ){
																						if( val.post_type == cat_val ){
																							if( Array.isArray( postids ) ){
																								$.each( postids, function( key1, val1 ){
																									if( val.ID == val1 ){
																										_selected = 'selected="selected"';
																										return false;
																									}else{
																										_selected = '';
																									}
																								});
																							}
																							
																							_htmldata += '<option value="'+ val.ID +'"'+ _selected +'> '+ val.post_title +' </option>';
																						}
																					});
																				
																			_htmldata += '</optgroup>';
																		});
																		
																		
																	}
																
																_htmldata += '</select>';
																_htmldata += '<p class="description">'+ field.field_description +'</p>';
																_htmldata += '</label>';
																
															break;
															
															default: 
															break;
														}
														
													break;
													
												default: 
													break;
												
											}
											
											_htmldata += '</div>';
											
											return _htmldata;

										};				


/*
* handles wp media library popup
* @param _this: click object
*/
generalSettingsObj.wpUploadMediaPopup = function( _this, _mode ){
											var _custom_uploader;
									 
											/* If the uploader object has already been created, reopen the dialog */
											if (_custom_uploader) {
												_custom_uploader.open();
												return;
											}
									 
											/* Extend the wp.media object */
											_custom_uploader = wp.media.frames.file_frame = wp.media({
												title: 'Choose Image',
												button: {
													text: 'Choose Image'
												},
												multiple: false
											});
									 
											/* When a file is selected, grab the ID and set it as the text field's value */
											_custom_uploader.on('select', function(){
													
																	attachment = _custom_uploader.state().get('selection').first().toJSON();
																	
																	/* imageid */
																	if( _mode == 'imageid' ){
																		
																		_this
																		.prev()
																		.find('img')
																		.attr('src', attachment.url)
																		.parent()
																		.prev()
																		.find('input')
																		.val(attachment.id);
																		
																	}
																	
																	/* imageurl */
																	else if( _mode == 'imageurl' ){
																		
																		_textarea = _this.next();
																		
																		if( _textarea.hasClass('CodeMirror') ){
																			var textareacontent = text_editors[text_editor_id].getValue();
																			var cursor_range = text_editors[text_editor_id].getCursor();
																			
																			/* insert url to exact position where the cursor currently seated */
																			text_editors[text_editor_id].replaceRange( attachment.url, cursor_range );
																			
																			/* Codemirror textarea */
																			/* text_editors[text_editor_id].setValue(''); 
																			text_editors[text_editor_id].replaceSelection( txtVal );  */
																		}
																		else{
																			var textareacontent = _textarea.val();
																			var caretpos = _textarea.prop('selectionStart');
																			
																			var txtVal = textareacontent.substr(0, caretpos) + attachment.url + textareacontent.substr(caretpos);

																			/* Basic textarea */
																			_textarea.val( txtVal );
																		}

																	}

																	/* Import Site Options callback - xml */
																	else if( _mode == 'xml' ){

																		var conf = confirm('Import Site Option?');

																		if( conf )
																		{
																			/* enable preloader */
																			generalSettingsObj.callOptionsPreloader( 1 );

																			generalSettingsObj.dwhImportSiteOptions( attachment.id , function(){
																				
																				/* disable preloader */
																				generalSettingsObj.callOptionsPreloader();
																				
																				generalSettingsObj.callMessageNotification( 1, _this , 'Site options imported');
																			});
																		}
																	
																	}
																	
																
																													
																});
										
											/* Open the uploader dialog */
											_custom_uploader.open();
										};
										
										
/* 
* Return dataTable selector for tabs
* @param option_set: options set
*/
generalSettingsObj.thisDataTable = function( option_set ){
										
										return $('#'+ option_set +' table.dwh-datatable');
										
									};

/*
* Migrate Options
* @param option_data
* @param callback: ajax success callback function
* @param response: param for callback, return object data after ajax response
*/
generalSettingsObj.dwhOptionMigrateUpdate = function( migrate_ver_from , migrate_ver_to , callback ){
											
											jQuery.ajax({

												 type : "post",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 
															action: nonces.option_migrate_update.naction, 
															nonce_sec : nonces.option_migrate_update.nonce,
															migrate_ver_from: migrate_ver_from,
															migrate_ver_to: migrate_ver_to
														},
												 success: callback
												 
											}); 

										};
										

/*
* DWH Option Export
* @param callback: ajax success callback function
* @param response: param for callback, return object data after ajax response
*/
generalSettingsObj.dwhOptionGetXML = function( callback ){
											

											jQuery.ajax({

												 type : "POST",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 
															action: nonces.option_getxml.naction, 
															nonce_sec : nonces.option_getxml.nonce
														},
												 success: callback 

											}); 
												
										};

/* 
* Load a custom option set view
* @param option_set - name of the option set 
* @param _popupfields - append to object
*/							
generalSettingsObj.loadOptionSetView = function( _option_set , _popupfields, response ){
												
			if(_option_set == 'dwh_site_robots' || _option_set == 'dwh_sitemap' ){
				$('.option-uploaded-media-item').hide(); //hid the uploade media button
			}									

												var setting_is_enabled = true; 

												$.each( response.option_settings , function( key , val ){

													if( val.properties.block_list ) {	
														setting_is_enabled = generalSettingsObj.isSettingEnabled( val.properties.block_list , user_info );
													}
													else
													{
														setting_is_enabled = true;
													}
												});
													

												switch( _option_set )
												{
														case 'dwh_fonts_internal':
															
															if( response.option_relation[0] ){
																
																option_set_view = '';
																option_set_view += '<div id="site-fonts-list">';
																
																$.each( response.option_relation[0], function( key, val ){
																	
																	if( $.type(val) === 'object' ){
																		option_set_view += '<div id="'+ key +'">\
																								<p class="screenshot">\
																									CSS font name: <h1>'+ val.name +'</h1>\
																									Description: '+ val.description +'\
																								</p>\
																								<img src="'+ val.screenshot +'" alt=""> \
																								<br>\
																							</div>';
																	}																		
																		
																
																});
																
																option_set_view += '</div>';
																
																_popupfields.append( option_set_view );
																_popupfields.find('#site-fonts-list').show();
																
															}
															
															break;


														case 'dwh_sites':
															
															if( response.option_relation[0] ){
																
																var setting_is_enabled = true;

																$.each( response.option_settings , function( key , val ){

																   if( key == 'site_theme' )
																   {

																   		if( val.properties.block_list )
																   		{
															   				$.each( val.properties.block_list , function( key , role ){

															   					if( user_info.role == role )
															   					{
															   						setting_is_enabled = false;
															   					}

															   				});
																   		}

																   }

																});


																if( setting_is_enabled == true )
																{

																	option_set_view = '';
																	option_set_view += '<div id="site-themes-list" class="theme-preview">';
																	
																	$.each( response.option_relation[0], function( key, val ){
																	
																		option_set_view += '<div id="'+ key +'" class="info">\
																								<div class="screenshot">\
																									<img src="'+ val.screenshot +'" alt="">\
																								</div>\
																								<div class="description">\
																									<h3>'+ val.name +'</h3>\
																									<p>'+ val.category + '</p>\
																									<div>'+ val.description +'</div>\
																								</div>\
																							</div>';
																	
																	});
																	
																	option_set_view += '</div>';
																	
																	_popupfields.find(".control-wrapper").eq(0).find('label .description').before( option_set_view );
																	_popupfields.find('#site-themes-list').show();

																}

															
															}

															break;

														case 'dwh_pages':
														
															if( response.option_pagetheme[0] ){
																
																option_set_view = '';
																option_set_view += '<div id="page-themes-list" class="theme-preview">';
																
																$.each( response.option_pagetheme[0], function( key, val ){
																
																	option_set_view += '<div id="'+ key +'" class="info">\
																							<div class="screenshot">\
																								<img src="'+ val.screenshot +'" alt="">\
																							</div>\
																							<div class="description">\
																								<h3>'+ val.name +'</h3>\
																								<div>'+ val.description +'</div>\
																							</div>\
																						</div>';
																
																});
																
																option_set_view += '</div>';
																
																_popupfields.find(".control-wrapper").eq(1).find('label .description').before( option_set_view );
																_popupfields.find('#page-themes-list').show();
															
															}

															break;

														case 'dwh_cta':
														
															if( response.option_default_data.widget_settings ){
																
																var widget_cta_settings = response.option_default_data.widget_settings;

																option_set_view = '';
																option_set_view += '<div id="cta-set-list" class="theme-preview">';
																
																$.each( widget_cta_settings , function( key, val ){
																
																	option_set_view += '<div id="'+ key +'" class="info">\
																							<div class="screenshot">\
																								<img src="'+ val.screenshot +'" alt="">\
																							</div>\
																							<div class="description">\
																								<div>'+ val.description +'</div>\
																							</div>\
																						</div>';
																
																});
																
																option_set_view += '</div>';
																_popupfields.find(".control-wrapper").eq(0).find('label').after( option_set_view );
									
																_popupfields.find('#cta-set-list').show();
																
															
															}

															break;

														case  'dwh_promo_marker':
															
															var promo_marker_id = app_util.generateUniqueID();
																promo_marker_id = promo_marker_id.toUpperCase();
															
															if( response.option_data ){
																promo_marker_id = response.option_data.promo_marker_id;
															}
															
															var el_promo_marker_id = $("input[name='promo_marker_id']");

															/* Auto generate and set promo marker id */
															el_promo_marker_id.val( promo_marker_id );
															el_promo_marker_id.attr("disabled", true );
														
														break;
	

														
												}
												
											};
											
/* 
* Launch Option Set View
* @param _this - Required. jQuery Object 
*/							
generalSettingsObj.launchOptionSetView = function( _this ){
									
												var _tabmenu = $('ul.tab-menu');
												
												option_set = _this.attr('option_set');
												option_title = _this.parent().attr('option_title');
												
												/* remove all active class to tab menu */
												_tabmenu.find('li a').removeClass('active');
												
												/* check if tab menu is created */
												if( !_tabmenu.find('li a[href="#'+ option_set +'"]').length ){
													
													_tabmenu.append('<li><a href="#'+ option_set +'" class="active">Edit '+ option_title +'</a></li>');
													
												}
												
												else{
													
													_tabmenu.find('li a[href="#'+ option_set +'"]').addClass('active');
												}
												
												/* remove all show class on tab container  */
												$('.tab-container').removeClass('show');
												
												/* add show class to tab container */
												$('#'+ option_set).addClass('show');
												
											};
											
/* 
* Activate Google Map
* @param _popupfields - Required. jQuery Object 
* @param _response - Required. response json data
*/							
generalSettingsObj.activateGoogleMap = function( _popupfields, response ){
											
											/* if response data not empty */
											if( response.option_data ){
												
												/* only include map if lat and lng is not empty */
												if( response.option_data['map_latitude'] && response.option_data['map_longitude'] ){
													
													var _append_to_item = '<div class="control-wrapper full-width"><div id="map-canvas" style="width:96%; height:180px;"></div></div>';
													
													/* check if element is there */
													if( _popupfields.find('#map-canvas').length ){
														
														_mapWrapper = _popupfields.find('#map-canvas').parent();
														_mapWrapper.fadeOut( 400, function(){
															_mapWrapper.remove();
															
															_popupfields.prepend( _append_to_item );
															
															/* activate map trigger */
															var _gmap = new Initgooglemap( response.option_data['map_latitude'], response.option_data['map_longitude'], '' );
															_gmap.loadDynamicGoogleMap( response.option_data['map_zoom'] );
															
														});
														
													}
													
													else{
														_popupfields.prepend( _append_to_item );
														
														/* activate map trigger */
														var _gmap = new Initgooglemap( response.option_data['map_latitude'], response.option_data['map_longitude'], '' );
														_gmap.loadDynamicGoogleMap( response.option_data['map_zoom'] );
														
													}

												}
												
											}
												
										};
										
/* 
* Hotel Information Tab switching markup update
* @param _this - Required. jQuery Object 
*/							
generalSettingsObj.activateTabSwitchingMarkupUpdate = function( _popupmodalarea ){
											
											/* initially update markup when first load */
											_popupmodalarea.find('.tab-menu-wrapper ul.tab-menu li').each(function(){
												
												/* if has class active */
												if( $(this).find('a').hasClass('active') ){
												
													var _thishref = $(this).find('a').attr( 'href' );
													var option_set = $( _thishref ).find('input[name="data-row-hidden"]').attr('option_set');
													
													/* update option set to button */
													_popupmodalarea.find('a[class^="btn-datatable"]').attr( 'option_set', option_set );
													
												}
												
											});
											
											
											/* When switching to tabs */
											$(document).on('click', '.tab-menu-wrapper ul.tab-menu a', function(){
												
												var _thishref = ''
												var option_set = '';
												
												_this = $( this );
												_thishref = _this.attr('href');
												option_set = $( _thishref ).find('input[name="data-row-hidden"]').attr('option_set');
												
												_popupmodalarea.find('a[class^="btn-datatable"]').attr( 'option_set', option_set );
												_popupmodalarea.find('.error, .success-msg').remove();
												
												/* if href is hotel contact */
												if( _thishref == '#tab_dwh_hotel_contact' ){
													$( _thishref ).parents('.options-popupmodal-fields').next().hide();
												}
												/* show if not */
												else{
													$( _thishref ).parents('.options-popupmodal-fields').next().show();
												}
												
											});
											
										};
										
/* 
* To activate theme sidebar
*/							
generalSettingsObj.activateThemeTemplate = function( activateThemeTemplate , callback ){
												
												jQuery.ajax({

													 type : "post",
													 dataType : "json",
													 url : admin_ajax_url,
													 data : {
													 			action: nonces.theme_activate_sidebars.naction,
																nonce_sec : nonces.theme_activate_sidebars.nonce
													 		},
													 success: callback 

												});

												
											};
											
/*
* From old version. 
* Don't know if still usefull. Will remove this eventually
*/
generalSettingsObj.uploadfile = function(){

									$('body').delegate('.upload-media-button', 'click', function( e ) {
										e.preventDefault();
										
										var id = $(this).attr('href');
										var send_attachment_bkp = wp.media.editor.send.attachment;
										var clone = wp.media.gallery.shortcode;

										wp.media.editor.send.attachment = function(props, attachment) {
											$(id+'-id').val(attachment.id);
											$(id+'-item').html('<img src="'+attachment.url+'" />');
											wp.media.editor.send.attachment = send_attachment_bkp;
										}
										
										wp.media.gallery.shortcode = function(attachments) {
											images = attachments.pluck('id');
											$(id+'-gallery').val(images);
											$(id+'-item').html('<img src="'+site_info.template_directory_uri + images.gallery_image_shortcode + '" />');				
											wp.media.gallery.shortcode = clone;
											var shortcode = new Object();
											shortcode.string = function() {return ''};
											return shortcode;
										}

										wp.media.editor.open();
									});
								
								};
					

/* 
* Checks if the option or field is restricted per user role
*/							
generalSettingsObj.isSettingEnabled = function( _block_list , user_info ){
										
												$.each( _block_list , function( key , role ){

													if( user_info.role == role ){
														return false;
													}
													else{
														return 	true;
													}

												});

											};
											
											
/*
* DWH Customization
* @param mode: add / edit mode
* @param option_set: name of section you want to change
* @param option_row: option data index value
* @param naction: ajax action
* @param nonce_sec: ajax nonce
* @param option_value: form value pass on post data
* @param callback: ajax success callback function
*/
generalSettingsObj.dwhThemeDesignerSave = function( mode, design_type, design_set ,option_set, option_row, naction, nonce_sec, option_value, callback ){
											
											jQuery.ajax({

												 type : "post",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 
															action       : naction, 
															nonce_sec    : nonce_sec,
															option_value : option_value,
															design_type  : design_type,
															design_set   : design_set,
															option_set   : option_set,
															option_row   : option_row,
															mode 		 : mode 
														},
												 success: callback 

											}); 
												
										};
										
/*
* DWH Reset Theme Designer Set
* @param callback: ajax success callback function
*/
generalSettingsObj.dwhThemeDesignerReset = function( mode, naction, nonce_sec, data, callback ){
											
											var data_val = data || '';
											
											jQuery.ajax({

												 type : "post",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 
															action       : naction, 
															nonce_sec    : nonce_sec,
															data 	     : data_val,
															mode 		 : mode 
														},
												 success: callback 

											}); 
												
										};

/*
* DWH Load Options default
* @param callback: ajax success callback function
*/
generalSettingsObj.dwhLoadDefaultOptions = function( type, data, callback ){
											
											var data_val = data || '';
											
											jQuery.ajax({

												 type : "post",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 
												 			action: nonces.option_load_defaults.naction,
															nonce_sec : nonces.option_load_defaults.nonce,
															type: type,
															data: data_val
														},	
												 success: callback 

											}); 
												
										};
/*
* DWH Enable theme designer render flag
* @param callback: ajax success callback function
*/
generalSettingsObj.dwhThemeDesignerEnable = function( design_set , enable_flag , callback ){
											
											jQuery.ajax({

												 type : "post",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 
												 			action: nonces.option_theme_designer_enable.naction,
															nonce_sec : nonces.option_theme_designer_enable.nonce,
															designer_enable_flag : enable_flag ,
															design_set : design_set
														},	
												 success: callback 

											}); 
												
										};

/*
* DWH get page theme configuration
* @param callback: ajax success callback function
*/
generalSettingsObj.dwhPageThemeConfig = function( page_theme , callback ){
											
											jQuery.ajax({

												 type : "post",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 
												 			action: nonces.option_get_page_theme_config.naction,
															nonce_sec : nonces.option_get_page_theme_config.nonce,
															page_theme : page_theme
														},	
												 success: callback 

											}); 
												
										};
/*
* DWH Import Site Options
* @param callback: ajax success callback function
*/
generalSettingsObj.dwhImportSiteOptions = function( attachment_id , callback ){
											
											if( attachment_id ){

												jQuery.ajax({

													 type : "post",
													 dataType : "json",
													 url : admin_ajax_url,
													 data : { 
													 			action: nonces.option_import.naction,
																nonce_sec : nonces.option_import.nonce,
																attachment_id : attachment_id
															},	
													 success: callback

												}); 

											}

										};
/*
* Gets all site themes
* @param callback: ajax success callback function
*/
generalSettingsObj.dwhgetThemesSite = function( callback ){
											
											
												jQuery.ajax({

													 type : "post",
													 dataType : "json",
													 url : admin_ajax_url,
													 data : { 
													 			action	  	: nonces.option_get_themes_site.naction,
																nonce_sec 	: nonces.option_get_themes_site.nonce
															},	
													 success: callback

												}); 

										};


/*
* Gets all page themes
* @param callback: ajax success callback function
*/
generalSettingsObj.dwhgetThemesPage = function( callback ){
											
											
												jQuery.ajax({

													 type : "post",
													 dataType : "json",
													 url : admin_ajax_url,
													 data : { 
													 			action	  	: nonces.option_get_themes_page.naction,
																nonce_sec 	: nonces.option_get_themes_page.nonce
															},	
													 success: callback

												}); 

										};

/*
* DWH Enable Flush rewrite
* @param callback: ajax success callback function
*/
generalSettingsObj.dwhEnableFlushRewrite = function( enable_flag , callback ){
											
											jQuery.ajax({

												 type : "post",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 
												 			action: nonces.option_permalink_enable_flush_rewrite.naction,
															nonce_sec : nonces.option_permalink_enable_flush_rewrite.nonce
														},	
												 success: callback 

											}); 
												
										};

/*
* IBE generate URL for mobile and desktop
* @param callback: ajax success callback function
*/
//generalSettingsObj.dwhIBEGenerateUrl = function(ibe_token, ibe_hotel_id, ibe_domain, callback ){
generalSettingsObj.dwhIBEGenerateUrl = function(ibe_hotel_id_arr, assigned_token, ibe_domain, callback ){
	
											jQuery.ajax({

												 type : "post",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 
															//property_id: ibe_hotel_id,
															property_ids: ibe_hotel_id_arr,
															//token: ibe_token,
															token: assigned_token,
															domain: ibe_domain,
												 			action: nonces.option_ibe_url.naction,
															nonce_sec : nonces.option_ibe_url.nonce
														},	
												 success: callback

											}); 
												
										};


/*
* IBE generate Token for mobile and desktop
* @param callback: ajax success callback function
*/
generalSettingsObj.dwhIBEGetToken = function(ibe_domain_token, callback ){
	
											jQuery.ajax({

												 type : "post",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 
															domain: ibe_domain_token,
												 			action: nonces.option_ibe_token.naction,
															nonce_sec : nonces.option_ibe_token.nonce
														},	
												 success: callback

											}); 
												
										};
/*
* IBE generate URL autosync reset
* @param callback: ajax success callback function
*/
generalSettingsObj.clearIBEURLAutoSync = function( callback ){
	
											jQuery.ajax({

												 type : "post",
												 dataType : "json",
												 url : admin_ajax_url,
												 data : { 	
												 			action: nonces.option_ibe_url_reset_schedule.naction,
															nonce_sec : nonces.option_ibe_url_reset_schedule.nonce
														},	
												 success: callback

											}); 
												
										};

jQuery(document).on('change','select',function(){
	jQuery(this).each(function(){
		var attrName = jQuery(this).attr('name');
		var eto     = jQuery(this);
		var UAVal,tagMVal;
		
		$('.errMsg').remove();
		$('.infoMsg').remove();
		
		if(eto.val() == 1){
			if(attrName == 'tag_manager_flag'){
				
				UAVal = jQuery("select[name='universal_analytics']").val();
				
				if(UAVal == 1){
					$(this).val(0);
					$(this).after(' <i style="color:red;" class="errMsg">You have to set the Universal Analytics to "No" before you proceed</i>');
				}else{
					jQuery("select[name='universal_analytics']").attr('disabled','disabled');
					eto.removeAttr('disabled');
				}
				
			}
			if(attrName == 'universal_analytics'){
				tagMVal = jQuery("select[name='tag_manager_flag']").val();
				if(tagMVal == 1){
					$(this).val(0);
					$(this).after(' <i style="color:red;" class="errMsg">You have to set the Google Tage Manager to "No" before you proceed</i>');					
				}else{
					jQuery("select[name='tag_manager_flag']").attr('disabled','disabled');
					eto.removeAttr('disabled');
					$(this).after(' <i style="color:green;" class="infoMsg">Ensure to fill-out "Universal Analytics 1" and or "Universal Analytics 2" fields to make this work.</i>');	
				}
			}				
		}else{
			if(attrName == 'tag_manager_flag'){
				jQuery("select[name='universal_analytics']").removeAttr('disabled');
				
			}
			
			if(attrName == 'universal_analytics'){
				jQuery("select[name='tag_manager_flag']").removeAttr('disabled');
			}
		}
	});
})
