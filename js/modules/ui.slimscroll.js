jQuery(document).ready(function(){	

	/*prevent trigger on pixelr resize*/
	/*	
	var timer;
	jQuery(window).bind('resize', function(){
	   timer && clearTimeout(timer);
	   timer = setTimeout(onResize, 100);
	});
	function onResize(){ 
		
	}
	*/

	loadSlimScroll();

});

function loadSlimScroll(){
	_scrollContainer = jQuery('.scroll-container');
	_scrollContainerNext = jQuery('#'+_scrollContainer.parents('#main-container').next().attr('id'));
	
	_scrollContainerHeight = _scrollContainer.height();
	_scrollContainerNextHeight = _scrollContainerNext.outerHeight();
	_scrollContainerParentHeight = _scrollContainer.parents('#main').height();
	_scrollContainerContentSize = ( _scrollContainerParentHeight - _scrollContainerNextHeight ) * .9;

	if ( jQuery(window).width() < 1024 ) {
		_scrollContainer.slimScroll({height:'auto', railVisible: false, alwaysVisible: false});
	} else {
		if(_scrollContainerHeight > _scrollContainerParentHeight){
			_scrollContainer.css({'height':_scrollContainerParentHeight});
			_scrollContainer.slimScroll({height: _scrollContainerContentSize, railVisible: false, alwaysVisible: true});
		}else{
			_scrollContainer.slimScroll({height:_scrollContainerContentSize, railVisible: false, alwaysVisible: false});
		}
	}

}