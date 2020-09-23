var Slider_Item = (function( jQ ){

jQ(document).ready(function(){
	init();
});
	

function init()
{
	bindUIEvents();
}

function bindUIEvents()
{
}

function newSlider( settings, data, mode )
{	
	
	mode = mode || 'dwh_slider';
	
	var el_slider = '<div class="box">\
							<h4> Slider Items </h4>\
							<div class="form-header-slider">';
							
							if( Object.keys(data).length )
							{
								var slider_count = data['slider-item-type'].length;
								for( var i = 0; i < slider_count; i++ ){
									el_slider += addItem( settings, data, i );
									
								}
							}	
			
	el_slider += '  </div>\
					<br clear="all">\
					<a class="create-new-slider-row button-primary" data-mode="'+ mode +'" href="#">Add Slider Item</a>\
				</div>';
	
	return el_slider;

	

	
}

function addItem( settings, data, ctr )
{
	if( settings  )
	{
		
		var slider_title = "Slider Item";
		
		if( data ){
			slider_title = data['slider-item-title'][ ctr ] != "" ? data['slider-item-title'][ ctr ] : slider_title;
		}
		
		/* slider settings */
		var el_slider = '<div class="accordion-wrapper slider-group">\
							<a class="remove-slider-item" href="#">Remove</a>\
							<h4 class="accordion-head">\
								<span class="slider-item-title">'+ slider_title +'</span>\
							</h4>\
							<div class="accordion-content slider-item-wrapper">';
								
								if( settings ){
									
									/* setup slider type */
									el_slider += getItemType( settings, data, ctr );
									
									/* setup slider Fields */
									el_slider += getItemFields( settings, data, ctr );
								
								}

		el_slider += '	</div>\
					</div>';
		
		return el_slider;

	}

}


function getItemType( settings, field_value, ctr, mode ){
	
	mode = mode || 'category';
	
	if( settings ){
		
		var slider_item = {};
		var itemtype_obj = {};
		var fieldvalue = '';
		
		itemtype_obj.item_type = 'slider-item-type'; 	
			
		var el_slider = '<div class="radio-wrapper">';
						
							if( mode == 'category' ){
								
								jQ.each( settings , function( key , val ){
									
									var checked = '';
									
									if( field_value ){
										checked = field_value[ itemtype_obj.item_type ][ ctr ] == val.details.category ? 'checked="checked"' : '';
									}
									else if( val.details.category == 'slider' ){
										checked = 'checked="checked"';
									}
									
									itemtype_obj.checked = checked;
									itemtype_obj.name = 'item-type'+ ctr;
									itemtype_obj.value = val.details.category;
									itemtype_obj.title = val.details.title;
									itemtype_obj.description = val.details.description;
									itemtype_obj.withclass = 'with-radio';
									
									el_slider += getItemTypeMarkup( itemtype_obj );
									
									if( val.details.category == 'slider' ){
										slider_item = val.settings;
									}
									
								});
								
								/* load hidden field */
								if( slider_item ){
									
									fieldvalue = 'slider';
									
									if( field_value ){
										fieldvalue = field_value[ itemtype_obj.item_type ][ ctr ];
									}

									el_slider += getFieldType( slider_item[ itemtype_obj.item_type ], itemtype_obj.item_type, fieldvalue, ctr );
								
								}
								
							}
							
							else{
								
								var field_key = arguments[4];
								var slider_settings = arguments[5];
								
								if( settings.selections ){
									
									jQ.each( settings.selections , function( key , val ){
										
										var checked = '';
										
										if( field_value ){
											checked = field_value[ field_key ][ ctr ] == val['field_value'] ? 'checked="checked"' : '';
										}
										else if( slider_settings.details.category == 'slider' ){
											checked = 'checked="checked"';
										}
									
										itemtype_obj.checked = checked;
										itemtype_obj.name = val['field_name'] + ctr;
										itemtype_obj.value = val['field_value'];
										itemtype_obj.title = val['field_title'];
										itemtype_obj.description = val['field_description'];
										itemtype_obj.withclass = val['class'];
										
										el_slider += getItemTypeMarkup( itemtype_obj );
										
									});
									
									/* load hidden field */
									if( settings.properties ){
										
											if( field_value ){
												fieldvalue = field_value[ field_key ][ ctr ];
											}
									
											el_slider += getFieldType( settings, field_key, fieldvalue, ctr );
								
										}

								}

							}
							
		el_slider += '</div>';

		return el_slider;
	
	}
	
}


function getItemTypeMarkup( settings ){
	
	if( settings ){
		
		var el_slider = '<div class="control-wrapper '+ settings.withclass +'">\
							<label>\
								<input type="radio" name="'+ settings.name +'" value="'+ settings.value +'" '+ settings.checked +'/> '+ settings.title +'\
								<p class="description">'+ settings.description +'</p>\
							</label>\
						</div>';
	
		return el_slider;
	
	}
	
}



function getItemFields( settings, field_value, ctr ){
	
	if( settings ){
		
		var mode = '';
		var el_slider = '';
		
		jQ.each( settings , function( key , val ){
			
			var category = val.details.category;
			var display_mode = 'style="display:none"';
			
			switch( category ){
				case 'slider':
						mode = ' slider-wrap';
						display_mode = 'style="display:block"';
					break;
				case 'map': 
						mode = ' map-wrap';
					break;
				case 'iframe':
						mode = ' iframe-wrap';
					break;
			}
			
			
			if( field_value ){
				if( field_value['slider-item-type'][ctr] == category ){
					display_mode = 'style="display:block"';
				}
			}
			
			
			
			el_slider += '<div class="slide-fields-wrapper'+ mode +'" '+ display_mode +'>';
				
				if( val.settings ){
					var fieldvalue = '';
					
					jQ.each( val.settings, function( key1, val1 ){
						
						if( key1 != 'slider-item-type' ){
							
							if( key1 == 'slider-item-popup' ){
								el_slider += getItemType( val1, field_value, ctr, 'custom', key1, val );
								
							}
							else{
								
								if( field_value ){
									fieldvalue = field_value[key1][ctr];
								}
							
								el_slider += getFieldType( val1, key1, fieldvalue, ctr, field_value );
								
							}
							
						}
						
						
					});
					
				}
			
			el_slider += '</div>';
			
			
		});

		return el_slider;
	
	}
	
}


function getFieldType( field_settings, field_name, field_value, ctr, data ){
	
	var control_type = field_settings.properties.control_type;
	var el_slider = '';
	var field_class = '';
	
	if( field_settings.properties['class'] ){
		field_class = 'class="'+ field_settings.properties['class'] +'"';
	}
	
	switch( control_type ){
		
		case 'text':
				
				el_slider += '<div class="control-wrapper">\
									<label>'+ field_settings.properties.field_title +'\
										<input type="text" name="'+ field_name +'[]" '+ field_class +' value="'+ field_value +'" />\
										<p class="description">'+ field_settings.properties.field_description +'</p>\
									</label>\
								</div>';
				
			break;
			
		case 'textarea':
				
				var field_class1 = '';
				if( field_settings.properties['class'] ){
					field_class1 = field_settings.properties['class'];
				}
				
				field_class = 'class="button-secondary button-add-uploaded-media-item '+ field_class1 +'"';

				el_slider = '<div class="control-wrapper">\
									<label>'+ field_settings.properties.field_title +'\
										<a href="#image_desc_editor_'+ ctr +'" '+ field_class +'>Add/Upload Media</a>\
										<textarea row="8" col="4" id="image_desc_editor_'+ ctr +'" name="'+ field_name +'[]">'+ field_value +'</textarea>\
										<p class="description">'+ field_settings.properties.field_description +'</p>\
									</label>\
								</div>';
				
			break;
			
		case 'tag':

				el_slider = '<div class="control-wrapper">\
									<label>'+ field_settings.properties.field_title +'\
										<textarea row="4" col="4" name="'+ field_name +'[]">'+ field_value +'</textarea>\
										<p class="description">'+ field_settings.properties.field_description +'</p>\
									</label>\
								</div>';
				
			break;
		
		case 'image':
				
				var imgsrc = site_info.template_directory_uri + images.gallery_image_noimg_150by150;
				if( data['slider-item-imagesrc'] ){
					imgsrc = data['slider-item-imagesrc'][ ctr ];
				}
				
				el_slider += '<div class="control-wrapper">\
									<label>'+ field_settings.properties.field_title +'\
										<input type="text" name="'+ field_name +'[]" '+ field_class +' value="'+ field_value +'" />\
									</label>\
									<div class="slider-image-holder">\
										<img src="'+ imgsrc +'" alt="" width="100px" height="100px" />\
									</div>\
									<a class="add-slider-item-image button-primary" href="#">Add Image</a>\
								</div><br>';
								
			break;
		
		case 'hidden':
				
				el_slider += '<br clear="all">\
							  <input type="hidden" name="'+ field_name +'[]" '+ field_class +' value="'+ field_value +'"/>';
			break;
			
		default: break;
	}
	
	return el_slider;

}


return {

		'init' 						: init,
	 	'bindUIEvents' 				: bindUIEvents,
	 	'newSlider'					: newSlider,
		'addItem'					: addItem,
		'getItemType'				: getItemType,
		'getItemFields'				: getItemFields,
		'getFieldType'				: getFieldType
		};


})( jQuery );