function tabClick(){
    jQuery(document).on('click', '.tab-menu a', function(e){
        e.preventDefault();

        _this = jQuery(this);
        _tabParent = _this.parent().parent()
        _wrapperContainer = _this.parents('.tab-menu').parent();

        /* remove class active to all tab li */
        _tabParent.find('li a').removeClass('active');

        /* add class active to current tab li */
        _this.addClass('active');

        /* remove class show to all tab containers */
        _wrapperContainer.find('.tab-container').removeClass('show');

        /* add class show to active tab container */
        _wrapperContainer.find( _this.attr('href') ).addClass('show');

    });
}

function accordionClick(){
    /*ACCORDION*/
    jQuery('.accordion-content').hide();

    /* Open first accordion */
    // jQuery('.list-accordion').find('.accordion-caption:first').find('a').addClass('active');
    // jQuery('.list-accordion').find('.accordion-content:first').show();

    _accordionWrapper = jQuery('.list-accordion');
    _accordionWrapper.find('.accordion-caption a').removeClass('active');

    jQuery.each( _accordionWrapper, function(){

        var _this = jQuery(this);

        if( _this.hasClass('showfirst') ){

            _this.find('.accordion-caption:first').find('a').addClass('active');
            _this.find('.accordion-content:first').show();
        }
    });

    jQuery(document).on('click', '.accordion-caption a', function(evt){
        evt.preventDefault();

        _this = jQuery(this);
        _container = _this.parents('.accordion-item').find('.accordion-content');

        _this.toggleClass('active');
        _container.stop().slideToggle('fast');

    });
}

jQuery(document).ready(function(){

    settings.window.on( 'load', function() {
        tabClick();
        accordionClick();
    });

});