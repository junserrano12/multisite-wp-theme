var JQ = jQuery.noConflict();
var timer;
var settings = {
    'window'                            :   JQ(window),
    'head'                              :   JQ('head'),
    'body_html'                         :   JQ('body, html'),
    'body'                              :   JQ('body'),
    'main_css'                          :   JQ('#main-css'),
    'header'                            :   JQ('#header'),
    'main'                              :   JQ('#main'),
    'fooder'                            :   JQ('#footer'),
    'image_container'                   :   JQ('.image-container, .gallery-icon'),
    'align_middle'                      :   JQ('.align-middle'),
    'scroll_to_top'                     :   JQ('.scroll-to-top'),
    'to_top'                            :   JQ('.to-top'),
    'menu_icon'                         :   JQ('#main-menu-icon'),
    'menu_content'                      :   JQ('#main-menu-content'),
    'colorbox'                          :   JQ('.colorbox'),
    'colorbox_inline'                   :   JQ('.colorbox-inline'),
    'promo_code'                        :   JQ('.cta-promocode')
};

var reload_desktop  = ( settings.window.width() > 1023 ) ? true : false;
var reload_tablet   = ( settings.window.width() < 1024 ) ? true : false;
var reload_mobile   = ( settings.window.width() < 768 ) ? true : false;

/*loaded*/

/*optional*/

function reloadpageonresize(){

    if ( settings.window.width() < 768 ) {
        reload_tablet = false;
        reload_desktop = false;
        if(!reload_mobile){
            reload_mobile = true;
            location.reload();
        }
    } else if ( settings.window.width() < 1024 ) {
        reload_mobile = false;
        reload_desktop = false;
        if(!reload_tablet){
            reload_tablet = true;
            location.reload();
        }
    } else {
        reload_mobile = false;
        reload_tablet = false;
        if(!reload_desktop){
            reload_desktop = true;
            location.reload();
        }
    }
}

function alignToMiddle(_top, _display, _position) {
    _top = ( typeof _top === "undefined" || _top === null ) ? 'margin-top' : _top;
    _display = ( typeof _display === "undefined" || _display === null ) ? 'inline-block' : _display;
    _position = ( typeof _position === "undefined" || _position === null ) ? 'relative' : _position;

    settings.main_css.load(function(){
        settings.align_middle.each(function(){
            var _css            = {}

            _thiselement        = JQ(this);

            _top                = ( typeof _thiselement.data('top') !== "undefined" ) ? _thiselement.data('top') : _top;
            _display            = ( typeof _thiselement.data('display') !== "undefined" ) ? _thiselement.data('display') : _display;
            _position           = ( typeof _thiselement.data('position') !== "undefined" ) ? _thiselement.data('position') : _position;
            _parent             = ( typeof _thiselement.data('parent') !== "undefined" ) ? _thiselement.data('parent') : false;

            _parentheight       = ( _parent ) ? _thiselement.parentsUntil(_parent).parent().height() : _thiselement.parent().height();
            _thiselementheight  = _thiselement.height();

            _alignmiddlepos     = (_parentheight - _thiselementheight) / 2;
            _alignmiddlepos     = (_alignmiddlepos < 0 ) ? 0 : _alignmiddlepos;

            _css[_top]          = _alignmiddlepos + 'px';
            _css['display']     = _display;
            _css['position']    = _position;

            _thiselement.css(_css);
        });
    });
}

function setGroupMaxHeight(_selector) {
    settings.main_css.load(function(){
        _thiselement    = JQ(this);
        _elementsHeight = JQ(_selector).map(function(){
            return _thiselement.height();
        }).get();
        _maxElemenHeight = Math.max.apply(null, _elementsHeight);
        JQ(_selector).height(_maxElemenHeight);
    });
}

function imageMaxWidth(){
    /*add max width for images*/
    settings.image_container.each(function(){
        _thiselement    = JQ(this);
        _image          = _thiselement.find('img');
        _imagewidth     = _image.attr('width');
        if( settings.window.width() < _imagewidth || _thiselement.hasClass('force-max-width') ){
            _image.css({
                'max-width' : _imagewidth+'px'
            });
        }
    });
}

function scrollToTop(_speed, _position){
    _speed      = (_speed === undefined) ? 'slow' : _speed;
    _position   = (_position === undefined) ? 0 : _position;
    settings.scroll_to_top.click(function(e){
        settings.body_html.animate({scrollTop : _position}, _speed);
        e.preventDefault();
    });
}

function loadToTop(_top){
    _top = (_top === undefined) ? 300 : _top;
    if(settings.window.scrollTop() > _top){
        settings.to_top.fadeIn(_top);
    }else{
        settings.to_top.fadeOut(_top);
    }
}

function resetMenuElements(_width){
    _width = (_width === undefined) ? 768 : _width;
    if(settings.window.width() <= _width ){
        settings.menu_content.addClass('show-layer');
        settings.menu_icon.removeClass('cross');
    }
}

function getMenuState(_width){
    _width = (_width === undefined) ? 768 : _width;
    if(settings.window.width() >= _width){
        settings.menu_content.addClass('show-layer');
    } else {
        settings.menu_content.addClass('show-layer');
        settings.menu_icon.removeClass('cross');
    }
}

function toggleMenu(_animation, _speed){
    _speed = (_speed === undefined) ? 150 : _speed;
    /*toggle mobile menu*/
    settings.menu_icon.click(function(e){
        _thiselement = JQ(this);
        _thiselement.toggleClass('cross');
        if(_animation === undefined){
            settings.menu_content.toggleClass('show-layer');
        } else if(_animation === 'fade') {
            settings.menu_content.fadeToggle(_speed).toggleClass('show-layer');
        } else if(_animation === 'slide') {
            settings.menu_content.slideToggle(_speed).toggleClass('show-layer');
        }
        e.preventDefault();
    });
}