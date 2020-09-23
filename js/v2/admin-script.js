var JQQ = jQuery.noConflict();

var upload_frame;
var gallery_frame;
var cm_editors = [];

var FontAwesomeConfig = { searchPseudoElements: true };

var settings = {
	'window' 			: 	JQQ(window),
	'body_html' 		: 	JQQ('body, html'),
	'body' 				: 	JQQ('body'),
	'notification' 		: 	JQQ('.theme-option-notification'),
	'wpeditor' 			: 	JQQ('.dwh_wpeditor'),
	'cmeditor'			: 	JQQ('.dwh-cm-textarea'),
	'wpwidgetwrapper' 	: 	JQQ('.widgets-holder-wrap'),
    'accordion_bar'     :   JQQ('.accordion-title'),
    'wpcontent'         :   JQQ('#wpcontent')
};

/*
Events
*/

function toggleReadOnly(){
    settings.body.delegate('.readonly-toggle', 'dblclick', function(e) {
        _this = JQQ(this);
        if( _this.attr('readonly') ){
            _this.removeAttr('readonly');
        } else {
            _this.attr('readonly', 'true');
        }
    });
}

function dragdropitem(){
    _dragitem   = '';

    JQQ('.draggableitem').draggable({
        revert: true,
        zIndex: 100,
        drag: function(event, ui){
            _thiselement = JQQ(this);
            _dragitem = _thiselement;
            JQQ('.item').css({'height':'auto', 'width': '100%'});
        }
    });

    JQQ('.droppablecontainer').droppable({
        accept: '.draggableitem',
        drop: function(event, ui){
            _thiselement        = JQQ(this);
            _draggablecontent   = _dragitem.contents();
            _droppablecontent   = _thiselement.contents();
            _thiselement.html( _draggablecontent );
            _dragitem.html( _droppablecontent );
            JQQ('.item').css({'height':'auto', 'width': '100%'});
        }

    });
}

function openWidgetWrapper(){
	settings.wpwidgetwrapper.each(function(){
		_this = JQQ(this);
		if( _this.has('.widget').length > 0 ){
			_this.removeClass('closed');
		}
	});
}

function addCodeMirror(){

    settings.body_html.find('.dwh-cm-textarea').each(function(i, elem){
        JQQ(this).attr('data-cmindex', i);
        _linewrap = JQQ(this).hasClass('linewrap') ? true : false;

        cm_editors[i] = CodeMirror.fromTextArea(elem, {
            mode: 'text/css',
            lineNumbers: true,
            lineWrapping: _linewrap,
            matchBrackets: true
        });

        cm_editors[i].on('blur', function(){
            cm_editors[i].save();
        });

    });
}

function uploadImageToTextarea(){
	settings.body.delegate('.media-upload-button', 'click', function(e) {
		var id 					= JQQ(this).attr('href');
        /*textarea*/
		var caretpos 			= JQQ(id).prop('selectionStart');
		var textareacontent 	= JQQ(id).val();
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var clone 				= wp.media.gallery.shortcode;

        if ( JQQ(id).hasClass('dwh-cm-textarea') ) {
            /*code mirror*/
            var cmindex             = JQQ(id).data('cmindex');
            var textareacontent     = cm_editors[cmindex].getValue();
            var cursor_range        = cm_editors[cmindex].getCursor();
        }

		wp.media.editor.send.attachment = function(props, attachment) {
			image = attachment.sizes[props.size];

            if ( JQQ(id).hasClass('dwh-cm-textarea-src') ) {
                content  = image.url;
            } else {
                content  = '<div class="image-container">\n\t<img src="'+image.url+'" alt="'+attachment.title+'" width="'+image.width+'" height="'+image.height+'" class="align'+props.align+' size-'+props.size+' wp-image-'+attachment.id+'"/>\n</div>\n';
            }

            if ( JQQ(id).hasClass('dwh-cm-textarea') ) {
                cm_editors[cmindex].replaceRange( content, cursor_range );
            } else {
                JQQ(id).val(textareacontent.substr(0, caretpos) + content + textareacontent.substr(caretpos));
            }
            wp.media.editor.send.attachment = send_attachment_bkp;
		}

		wp.media.editor.open();
		e.preventDefault();
	});
}

function toggleSlideController(){

	settings.body.delegate('.slider-controller', 'click', function(e){
		JQQ(this).next().slideToggle();
	});
}

function uploadImage(){

	settings.body.delegate('.controller-upload-image', 'click', function(e){

		_thisElement 			= JQQ(this);
		_thisElementFrameId 	= _thisElement.data('id');
		_thisElementParentId 	= JQQ('#'+_thisElementFrameId+'-container');

		if( upload_frame ) {
			upload_frame.open();
			return
		}

		upload_frame = wp.media({
			title 		: 'Select or Upload Media',
			button		: {
							text 	: 'Use this media'
					  	  },
			multiple  	: false
		});

		upload_frame.on( 'select', function() {
			var attachment = upload_frame.state().get('selection').first().toJSON();

			_thisElementParentId.find('.preview-container').html( '<img class="preview-image" src="'+attachment.url+'" style="max-width:'+attachment.width+';"/>' );
			_thisElementParentId.find('.attr-container').find('.image-id').val( attachment.id );
			_thisElementParentId.find('.controller-container').find('.image-controller-link').addClass('controller-remove-image').removeClass('controller-upload-image').html('Remove image');
            _thisElement.removeClass('button-upload');
            _thisElement.addClass('button-remove');

		});

        upload_frame.on('close', function() {
            _thisElement.addClass('button-upload');
        });

		upload_frame.open();

		e.preventDefault();
	});
}

function uploadGallery(){

	settings.body.delegate('.controller-upload-gallery', 'click', function(e){
		_thisElement 			= JQQ(this);
		_thisElementParentId 	= JQQ('#'+_thisElement.data('id'));
		_thisElementFrameId 	= _thisElement.data('id');
		_thisElementImages 		= _thisElementParentId.find('.attr-container').find('.image-ids').val();
		_thisElementState 		= _thisElementImages ? 'gallery-edit' : 'gallery-library';

		if( gallery_frame ) {
			gallery_frame.open();
			return
		}

		gallery_frame = wp.media.frames.gallery_frame = wp.media({
			title 		: 'Upload Gallery',
			frame 		: 'post',
			toolbar		: 'main-gallery',
			state 		: _thisElementState,
			library 	: {
							type 	: 'image'
						  },
			multiple 	: true
		});

		gallery_frame.on( 'open', function() {

			if ( !_thisElementImages )
				return

	       	var image_ids	= _thisElementImages.split( ',' );
	       	var library 	= gallery_frame.state().get( 'library' );

	       	image_ids.forEach( function( id ) {
	       		attachment = wp.media.attachment( id );
	            attachment.fetch();
	            library.add( attachment ? [ attachment ] : [] );
	       	} );
		});

		gallery_frame.on( 'update', function() {
			_thisElementParentId.find('.preview-gallery-container').empty();

			var library 	= gallery_frame.state().get('library');
			var image_ids 	= [];

			library.map( function( image ) {
				image 		= image.toJSON();
				image_ids.push(image.id);
				image_url 	= (image.sizes.medium_thumbnail == 'undefined') ? image.sizes.thumbnail.url : image.sizes.medium_thumbnail.url;
				_thisElementParentId.find('.preview-gallery-container').append( '<img class="preview-gallery-image inline-block" src="'+image_url+'"/>' );
			});

			_thisElementParentId.find('.attr-container').find('.image-ids').val( image_ids );

		});

		gallery_frame.open();

		e.preventDefault();
	});
}

function removeGallery(){
	settings.body.delegate('.controller-remove-gallery', 'click', function(e){
		_thisElement 			= JQQ(this);
		_thisElementParentId 	= JQQ('#'+_thisElement.data('id'));

		_thisElementParentId.find('.preview-gallery-container').empty();
		_thisElementParentId.find('.attr-container').find('.image-ids').val('');
		_thisElementParentId.find('.controller-container').find('.controller-upload-gallery').html('Upload Gallery');
		_thisElement.hide();

		e.preventDefault();
	});
}

function removeImage(){
	settings.body.delegate('.controller-remove-image', 'click', function(e){
		_thisElement 			= JQQ(this);
		_thisElementParentId 	= JQQ('#'+_thisElement.data('id')+'-container');

		_thisElementParentId.find('.preview-container').html('<div class="preview-image blank-image"></div>');
		_thisElementParentId.find('.attr-container').find('.image-id').val('');
		_thisElementParentId.find('.controller-container').find('.image-controller-link').addClass('controller-upload-image').removeClass('controller-remove-image').html('Upload image');
        _thisElement.removeClass('button-remove');
        _thisElement.addClass('button-upload');

		e.preventDefault();
	});
}

function windowScrolled(){
    settings.window.scroll(function() {
        _this     = JQQ(this);
        _position = ( JQQ('.theme-option-title-container').height() !== null ) ? JQQ('.theme-option-title-container').height() : 150;

        if ( _this.scrollTop() > _position ) {
            JQQ('.dwh-button-save').addClass('button-scrolled');
        } else {
            JQQ('.dwh-button-save').removeClass('button-scrolled');
        }
    });
}

function accordionClick(){
    settings.body.delegate('.accordion-title', 'click', function(){
        _this = JQQ(this);
        _this.next().slideToggle();
    });
}

function textToLabelOnKeyUp(){

    settings.body.delegate('.placeholder-title', 'keyup', function(e){
        _text = JQQ(this).val();
        JQQ(this).parentsUntil('.field-content-container').parent().prev().find('.field-title').text(_text);
    })
}

function tabClick(){

    settings.body.delegate('.tab-title-container .title', 'click', function(e){
        e.preventDefault();
        _this = JQQ(this);
        _id   = _this.attr('href');

        _this.parent().find('.title').removeClass('active');
        _this.parent().next().find('.tab-content').removeClass('active');

        _this.addClass('active');
        JQQ(_id).addClass('active');

        onLoadItems();
    });
}

function refreshCodeEditor(){
    JQQ('.CodeMirror').each(function(i, el){
        el.CodeMirror.refresh();
    });
}

function removeFieldItem(){
    settings.body.delegate('.remove-item', 'click', function(e) {
        e.preventDefault();

        _this = JQQ( this );

        _list_item_container = _this.parentsUntil('.list-item-container').parent();


        if ( _list_item_container.hasClass('list-item-container-simple') ) {

            if ( _list_item_container.find('.item-lists-simple .item').length < 2 ) {

                _list_item_container.find('.item-lists-simple').html('<div class="box-container empty-box-container initial-blank-item">'+_list_item_container.find('.add-item-simple').text()+'</div>');

            } else {

                _this.parentsUntil('.item').parent().remove();

            }

        } else {

            _prev = _this.parentsUntil('.item-display').parent().prev();
            _this.parentsUntil('.item-display').parent().empty();
            JQQ( _this.attr('href') ).remove();

            if ( _prev.find('.item').length < 1 ) {
                _prev.addClass('full-width').html('<div class="box-container empty-box-container initial-blank-item">'+_prev.parent().find('.add-item').text()+'</div>');
            } else {
                _prev.find('.item:first-child .field-title-container').addClass('active');
                _prev.next().html( _prev.find('.item').first().get(0).outerHTML.replace(/\sid=/g, " data-id=") );

            }
        }

    });
}

function onChangeFieldContent(){
    settings.body.delegate('.field-input', 'keyup', function(e) {
        _this = JQQ(this);
        _fieldid = _this.data('id');
        _fieldvalue = _this.val();
        _fieldselector = JQQ('#'+_fieldid);

        if ( _fieldselector.is('input[type="text"]') ) {
            _fieldselector.attr('value', _fieldvalue);
        }

        if ( _fieldselector.is('textarea') ) {
            _fieldselector.html(_fieldvalue);
        }

    });


    settings.body.delegate('.field-input', 'click', function(e) {

        _this = JQQ(this);
        _fieldid = _this.data('id');
        _fieldselector = JQQ('#'+_fieldid);

        _this.on('change', function(){
            if ( _fieldselector.is('select') ) {
                _selectvalue = _this.val();
                _fieldselector.find('option').removeAttr('selected');
                _fieldselector.find('option[value='+_selectvalue+']').attr('selected', true);
            }
        });

    });
}

function onLoadFieldContent(){

    _itemlists = JQQ('.item-lists');

    _itemlists.each(function(){
        _this = JQQ(this);
        if ( ! _this.hasClass('item-lists-simple') ) {
            if ( _this.find('.item').length > 0 ) {
                _this.find('.item:first-child .field-title-container').addClass('active');
                _this.next().html( _this.find('.item').first().get(0).outerHTML.replace(/\sid=/g, " data-id=") );
            }
        }
    });
}

function updateDisplayFieldContent(){

    settings.body.delegate('.item-lists .field-title-container', 'click', function(e) {
        _this = JQQ(this);
        _item_list_container = _this.parentsUntil('.item-lists').parent();
        _item_container = _this.parent();
        e.preventDefault();

        if ( _item_list_container.hasClass('item-lists-simple') ) {

            _this.toggleClass('active');
            _item_container.find('.field-content-container').stop().slideToggle();

        } else {

            _item_list_container.find('.item').each(function(){
                _thisitem = JQQ(this);
                _thisitem.find('.field-title-container').removeClass('active');
            });

            _this.addClass('active');

            _item_list_container.next().html( _this.parent().get(0).outerHTML.replace(/\sid=/g, " data-id=") );

            JQQ('.CodeMirror').each(function(i, el){
                el.CodeMirror.refresh();
            });
        }

    });
}

/*
Field Action
*/

function themeLayoutChecboxOnChange() {
    settings.body.delegate('.theme-template-controller', 'click', function() {
        _this = JQQ(this);
        if ( _this.is(':checked')) {
            _this.val('1');
            _this.attr('checked', true);
            _this.prev().find('.template_v1').removeAttr('hidden').show();
        } else  {
            _this.val('0');
            _this.attr('checked', false );
            _this.prev().find('.template_v1').attr('hidden', true).hide();
        }
    });
}

function codeSnippetCheckboxOnChange(){

    settings.body.delegate('.code-snippet-checkbox', 'click', function(){
        _this = JQQ(this);
        _fieldid = JQQ('#'+_this.data('id'));

        _this.on('change', function(){
            if ( _this.is(':checked') ) {
                _this.val( _this.data('id-checkbox') ).attr('checked', true);
                _fieldid.val( _this.data('id-checkbox') ).attr('checked', true);
            } else {
                _this.val('').attr('checked', false);
                _fieldid.val('').attr('checked', false);
            }
        });

    });
}

function codesnippetautocompletetitle(){
    var codesnippettitlelist = [
                        "API",
                        "Canonical",
                        "Code Snippet",
                        "Custom Script",
                        "Custom Meta Tags",
                        "Google",
                        "Google Analytics",
                        "Google Publisher",
                        "Google Site Verification",
                        "Facebook",
                        "HTML",
                        "Robots",
                        "Schema"
                    ];

    JQQ('.code-snippet-title-list').autocomplete({
        source: codesnippettitlelist,
        minLength: 0
    }).focus(function(){
        JQQ(this).autocomplete("search");
    });
}

function sliderattributeautocompletekey( attributelist ){

    if ( attributelist == 'nivoslider' ) {
        attrlist = ["effect", "slices", "boxcols", "boxrows", "animspeed", "pausetime", "startslide", "directionnav", "controlnav", "controlnavthumbs", "pauseonhover", "manualadvance", "prevtext", "nexttext", "randomstart"];
    } else {
        attrlist = ["animation", "easing", "direction", "slideshowspeed", "animationspeed", "startat", "initdelay", "prevtext", "nexttext", "randomize", "animationloop", "usecss", "touch", "keyboard", "reverse", "smoothheight", "vide", "controlnav", "directionnav", "pauseplay"];
    }

    JQQ('.slider-attribute-field-input-slider-key').autocomplete({
        source: attrlist,
        minLength: 0
    }).focus(function(){
        JQQ(this).autocomplete("search");
    });
}

function hotelOptionSelect(){
    _addresscontainer   = JQQ('.tab-title-container a[href="#onetheme-hotel-option-container-1"]');
    _selecthoteloption  = JQQ('input:radio[name="onetheme_hotel_options[type]"]');
    _singlehotel        = JQQ('.hotel-single');
    _corpsitehotel      = JQQ('.hotel-group');

    _selecthoteloption.change(function(){
        _this = JQQ(this);
        _selecthoteloption.prop('checked', false);
        _this.prop('checked', true);

        if( _this.val() == "corpsite" ){
            _singlehotel.addClass('hide');
            _corpsitehotel.removeClass('hide');
            _addresscontainer.hide();
        } else {
            _corpsitehotel.addClass('hide');
            _singlehotel.removeClass('hide');
            _addresscontainer.show();
        }
    });

    if( _selecthoteloption.filter(':checked').val() == "corpsite" ){
        _singlehotel.addClass('hide');
        _corpsitehotel.removeClass('hide');
        _addresscontainer.hide();
    } else {
        _corpsitehotel.addClass('hide');
        _singlehotel.removeClass('hide');
        _addresscontainer.show();
    }
}

function selectActiveContainer( _selector ){

    settings.body.delegate('.'+_selector+'-select' ,'change', function(e) {
        _this = JQQ(this);
        _selectvalue = _this.val();
        _selectclass = _selectvalue.split('.').join('-');
        _dataid = _this.data('container-id');

        _containerid = JQQ('#'+_dataid);
        _containerid.find('.'+_selector+'-container').removeClass('active');
        _containerid.find('.'+_selectclass+'-container').addClass('active').css('height', 'auto');

        onLoadItems();
    });
}

function selectActiveFieldItem( _selector ){

    settings.body.delegate('.'+_selector+'-select' ,'change', function(e) {
        _this = JQQ(this);
        _selectvalue = _this.val();
        _containerid = _this.data('container-id');
        JQQ('.'+_selector+'-'+_containerid+'-hide').hide();
        JQQ('.'+_selectvalue+'-'+_selector+'-'+_containerid+'-selected').show();

        if ( _selector == 'slider-type' ) {
            sliderattributeautocompletekey( _this.val() );
        }

    });
}

/*
AJAX
*/
function addFieldItemSimple(){

    settings.body.delegate('.add-item-simple' ,'click', function(e) {
        _this           = JQQ(this);
        _fieldcontainer = _this.parent().find('.item-lists-simple');
        _formaction     = _this.parent().find('input[name="form-action"]').val();
        _field          = _this.parent().find('input[name="field"]').val();
        _items          = _this.parent().find('.item');
        _itemlength     = _items.length;

        _this.next().show();
        _this.attr('disabled', true);

        var data = {
                    action      : _formaction,
                    ctr         : _itemlength,
                    field       : jQuery.parseJSON( _field )
                };

        JQQ.post(
            ajaxurl,
            data,
            function(output){
                _fieldcontainer.append(output);
                JQQ('.item-loading').hide();
                JQQ('.add-item-simple').attr('disabled', false);
                JQQ('.initial-blank-item').remove();
                onLoadItems();
            }
        );

        e.preventDefault();
    });
}

function addFieldItem(){

    settings.body.delegate('.add-item' ,'click', function(e) {
        _this                   = JQQ(this);
        _fielditemcontainer     = _this.parent().find('.item-lists');
        _fielditemdisplay       = _this.parent().find('.item-display');
        _formaction             = _this.parent().find('input[name="form-action"]').val();
        _field                  = _this.parent().find('input[name="field"]').val();
        _items                  = _this.parent().find('.item');
        _fieldtitlecontainer    = _this.parent().find('.item .field-title-container');
        _itemlength             = ( _items.length < 1 ) ? 1 : _items.length;

        _this.next().show();
        _this.attr('disabled', true);

        var data = {
                    action      : _formaction,
                    ctr         : _itemlength,
                    field       : jQuery.parseJSON( _field )
                };

        JQQ.post(
            ajaxurl,
            data,
            function(output){

                _fielditemdisplay.html('');
                _fielditemcontainer.append(output);
                _fieldtitlecontainer.removeClass('active');
                _fielditemdisplay.append(output.replace(/\sid=/g, " data-id="));
                _fielditemcontainer.find('.item:last-child .field-title-container').addClass('active');
                _fielditemcontainer.removeClass('full-width');
                _fielditemcontainer.find('.initial-blank-item').remove();

                JQQ('.item-loading').hide();
                JQQ('.add-item').attr('disabled', false);

                onLoadItems();
            }
        );

        e.preventDefault();
    });
}

function saveThemeOption() {
    settings.body.delegate('.ajaxform', 'submit', function(e){
        e.preventDefault();

        _thisElement    = JQQ(this);
        _formaction     = _thisElement.attr("action");
        _formdata       = _thisElement.serializeArray();
        settings.wpcontent.addClass('disable-content');
        settings.notification.show().html('<p class="result-saved">Saving...</p>');

        dwh_do_post( _formaction, _formdata, function( response ){
            settings.notification.show().html('<p class="result-saved">Option Saved</p>').delay(500).fadeOut(1500, function(){
                JQQ(this).empty();
            });
            settings.wpcontent.removeClass('disable-content');
        });
    });
}

function uploadfontfiles() {
    settings.body.delegate('.font-upload-controller', 'click', function(e) {
        e.preventDefault();
        _thisElement = JQQ(this);

        var fontTitle    = JQQ('.font-title').val();
        var fontHIDs     = JQQ('.hotel-ids').val();
        var security     = JQQ('.security-nonce').val();
        var files_data   = JQQ('.files-data');
        var count        = 0;

        var data = new FormData();
        data.append('title',fontTitle);
        data.append('hotels',fontHIDs);
        data.append('security-nonce',security);
        data.append('action', dwh_ajax_obj.dwh_upload_fonts.action);

        JQQ.each(files_data, function(i, obj) {
            JQQ.each(obj.files,function(j,file){
                count++;
                data.append('files[' + j + ']', file);
                data.append('counter',count);
            })
        });

        settings.wpcontent.addClass('disable-content');
        settings.notification.show().html('<p class="result-saved">Uploading Font Files</p>');

        if ( dwh_ajax_obj.dwh_upload_fonts ) {

            dwh_do_ajax_upload( dwh_ajax_obj.dwh_upload_fonts, function( response_dwh_upload_fonts ){
                var response = JQQ.parseJSON(response_dwh_upload_fonts);

                settings.notification.html('<div class="result-saved">'+response.message+'</div>').delay(500).fadeOut(3500, function(){
                    JQQ(this).empty();

                });



                if(response.class_err == ''){
                    fontFolder = fontTitle.replace(/ /g,'-');
                    JQQ('.font-internal-container select').append('<option value="'+fontFolder+'">'+fontTitle+'</option>');
                }

                settings.wpcontent.removeClass('disable-content');

            }, data, ajaxurl, "json");

        } else {
            settings.notification.show().html('<p class="font-upload-error-msg">WP action not found</p>');
        }

    });
}

function selectThemeLayout(){

    settings.body.delegate('.theme-template-select', 'change', function(e) {
        _this = JQQ(this);
        _themelayout = _this.val();
        _headerlayouttextarea    = JQQ('#onetheme-customizer-options-theme-layout-header-layout');
        _footerlayouttextarea    = JQQ('#onetheme-customizer-options-theme-layout-footer-layout');
        _abovethefoldcsstextarea = JQQ('#onetheme-customizer-options-above-the-fold-css');
        _maincsstextarea         = JQQ('#onetheme-customizer-options-main-css');
        _mediaquerycsstextarea   = JQQ('#onetheme-customizer-options-media-query-css');

        settings.wpcontent.addClass('disable-content');
        settings.notification.show().html('<p class="result-saved">Change Theme Layout and Css</p>');

        _data = {
                    'layout'    : _themelayout,
                    'tags'      : [
                                    {
                                        "handle"    : "header",
                                        "type"      : "template",
                                        "file"      : "header",
                                        "extension" : "tpl"
                                    },
                                    {
                                        "handle"    : "footer",
                                        "type"      : "template",
                                        "file"      : "footer",
                                        "extension" : "tpl"
                                    },
                                    {
                                        "handle"    : "above_the_fold_css",
                                        "type"      : "sass",
                                        "file"      : "style-above-the-fold",
                                        "extension" : "scss"
                                    },
                                    {
                                        "handle"    : "main_css",
                                        "type"      : "sass",
                                        "file"      : "style-main",
                                        "extension" : "scss"
                                    },
                                    {
                                        "handle"    : "meidaquery_css",
                                        "type"      : "sass",
                                        "file"      : "style-mediaquery",
                                        "extension" : "scss"
                                    }
                                  ]
                };

        if ( dwh_ajax_obj.dwh_update_theme_layout_css_fields ) {
            dwh_do_ajax(dwh_ajax_obj.dwh_update_theme_layout_css_fields, function( response_dwh_update_theme_layout_css_fields ){

                _selectionbox = confirm("Are you sure you want to change layout?");
                if ( _selectionbox == true ) {
                    var _contents = jQuery.parseJSON( response_dwh_update_theme_layout_css_fields );

                    _headerlayouttextarea.val( _contents.header );
                    _footerlayouttextarea.val( _contents.footer );
                    _abovethefoldcsstextarea.val( _contents.above_the_fold_css );
                    _maincsstextarea.val( _contents.main_css );
                    _mediaquerycsstextarea.val( _contents.meidaquery_css );

                    _headerlayoutcmindex    = _headerlayouttextarea.data('cmindex');
                    _footerlayoutcmindex    = _footerlayouttextarea.data('cmindex');
                    _abovethefoldcsscmindex = _abovethefoldcsstextarea.data('cmindex');
                    _maincsscmindex         = _maincsstextarea.data('cmindex');
                    _mediaquerycsscmindex   = _mediaquerycsstextarea.data('cmindex');

                    cm_editors[_headerlayoutcmindex].setValue( _contents.header );
                    cm_editors[_footerlayoutcmindex].setValue( _contents.footer );
                    cm_editors[_abovethefoldcsscmindex].setValue( _contents.above_the_fold_css );
                    cm_editors[_maincsscmindex].setValue( _contents.main_css );
                    cm_editors[_mediaquerycsscmindex].setValue( _contents.meidaquery_css );

                    settings.notification.show().html('<p class="result-saved">Updated</p>').delay(500).fadeOut(1500, function(){
                        JQQ(this).empty();
                        settings.wpcontent.removeClass('disable-content');
                    });

                } else {

                    /*CANCEL*/
                    settings.notification.show().html('<p class="result-saved">Cancel</p>').delay(500).fadeOut(1500, function(){
                        JQQ(this).empty();
                        settings.wpcontent.removeClass('disable-content');
                    });

                }
            }, _data, ajaxurl);
        }

        onLoadItems();
    });
}


function resetTextareaDefaultContent() {

    settings.body.delegate('.reset-item', 'click', function(e){
        e.preventDefault();
        _thisElement  = JQQ(this);
        _themelayout  = JQQ('.theme-template-select').val();
        _dataid       = _thisElement.data('id');
        _label        = _thisElement.data('label');
        _textarea     = JQQ('#'+_dataid);
        _formelement  = _textarea.parentsUntil('.ajaxform').parent();
        _data = {
                    'file'      : JQQ('.'+_dataid+'-data').data('file'),
                    'path'      : JQQ('.'+_dataid+'-data').data('path'),
                    'extension' : JQQ('.'+_dataid+'-data').data('extension'),
                    'layout'    : _themelayout
                };

        settings.wpcontent.addClass('disable-content');
        settings.notification.show().html('<p class="result-saved">Reset '+_label+' Content</p>');

        if ( dwh_ajax_obj.dwh_reset_textarea_default_content ) {
            dwh_do_ajax(dwh_ajax_obj.dwh_reset_textarea_default_content, function( response_dwh_reset_textarea_default_content ){

                _selectionbox = confirm("Are you sure you want to reset "+_label+"?");
                if ( _selectionbox == true ) {

                    /*APPEND TO CONTENT*/
                    // caretpos = textarea.prop('selectionStart');
                    // textareacontent = textarea.val();
                    // _textarea.val(textareacontent.substr(0, caretpos) + response_dwh_reset_textarea_default_content + textareacontent.substr(caretpos));

                    _textarea.val( response_dwh_reset_textarea_default_content );

                    if ( _textarea.hasClass('dwh-cm-textarea') ) {
                        cmindex = _textarea.data('cmindex');
                        cursor_range = cm_editors[cmindex].getCursor();
                        /*APPEND TO CONTENT*/
                        // cm_editors[cmindex].replaceRange( response_dwh_reset_textarea_default_content, cursor_range );
                        cm_editors[cmindex].setValue( response_dwh_reset_textarea_default_content );
                    }

                    /* add option to save updated textarea */
                    // _ajaxform = JQQ('#'+_formelement.attr('id') );
                    // _ajaxform.submit();

                    /* Update Notification */
                    settings.notification.show().html('<p class="result-saved">Content Updated</p>').delay(500).fadeOut(1500, function(){
                        JQQ(this).empty();
                        settings.wpcontent.removeClass('disable-content');
                    });

                } else {

                    /*CANCEL*/
                    settings.notification.show().html('<p class="result-saved">Cancel</p>').delay(500).fadeOut(1500, function(){
                        JQQ(this).empty();
                        settings.wpcontent.removeClass('disable-content');
                    });

                }
            }, _data, ajaxurl);
        }
    });
}

/*
ONLOAD ITEMS
*/
function onLoadItems() {
    settings.notification.hide();
    dragdropitem();
    sliderattributeautocompletekey( JQQ('.slider-data-field-input-slider').val() );
    codesnippetautocompletetitle();
    refreshCodeEditor();
}


function fontUpload() {
    JQQ(document).on('click', '.upload-form .btn-upload-font', function(e){

        e.preventDefault;
        var fd = new FormData();
        var files_data = JQQ('.upload-form .files-data'); // The <input type="file" /> field
        var fontTitle  = JQQ('.font-title').val();
        var fontHIDs   = JQQ('.hotel-ids').val();
        var count      = 0;
        // Loop through each data and create an array file[] containing our files data.
        JQQ.each(JQQ(files_data), function(i, obj) {
            JQQ.each(obj.files,function(j,file){
                count++;
                fd.append('files[' + j + ']', file);
                fd.append('counter',count);
            })
        });

        // our AJAX identifier
        fd.append('action', 'cvf_upload_files');
        fd.append('title', fontTitle);
        fd.append('hotels', fontHIDs);

        // Remove this code if you do not want to associate your uploads to the current page.
        //fd.append('post_id', <?php echo JQQpost->ID; ?>);

        JQQ.ajax({
            type: 'POST',
            url: DwhAjax.ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                JQQ('.upload-response').html(response); // Append Server Response
            }
        });
    });
}

function fontUpload() {
    JQQ(document).on('click', '.upload-form .btn-upload-font', function(e){

        e.preventDefault;
        var fd = new FormData();
        var files_data = JQQ('.upload-form .files-data'); // The <input type="file" /> field
        var fontTitle  = JQQ('.font-title').val();
        var fontHIDs   = JQQ('.hotel-ids').val();
        var count      = 0;
        // Loop through each data and create an array file[] containing our files data.
        JQQ.each(JQQ(files_data), function(i, obj) {
            JQQ.each(obj.files,function(j,file){
                count++;
                fd.append('files[' + j + ']', file);
                fd.append('counter',count);
            })
        });

        // our AJAX identifier
        fd.append('action', 'cvf_upload_files');
        fd.append('title', fontTitle);
        fd.append('hotels', fontHIDs);

        // Remove this code if you do not want to associate your uploads to the current page.
        //fd.append('post_id', <?php echo JQpost->ID; ?>);

        JQQ.ajax({
            type: 'POST',
            url: DwhAjax.ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                JQQ('.upload-response').html(response); // Append Server Response
            }
        });
    });
}

JQQ(document).ready(function(){
    onLoadItems();
    onLoadFieldContent();
    toggleSlideController();
    uploadImage();
    removeImage();
    addFieldItem();
    addFieldItemSimple();

    removeFieldItem();
    uploadGallery();
    removeGallery();
    uploadImageToTextarea();
    addCodeMirror();
    openWidgetWrapper();
    accordionClick();
    textToLabelOnKeyUp();
    tabClick();
    saveThemeOption();
    toggleReadOnly();
    updateDisplayFieldContent();
    onChangeFieldContent();
    codeSnippetCheckboxOnChange();
    themeLayoutChecboxOnChange();
    resetTextareaDefaultContent();
    selectThemeLayout();

    // selectActiveContainer('theme-template');

    selectActiveFieldItem('font');
    selectActiveFieldItem('slider-output-type');
    selectActiveFieldItem('slider-colorbox');
    selectActiveFieldItem('slider-type')

    hotelOptionSelect();
    uploadfontfiles();
    windowScrolled();

    fontUpload();
});