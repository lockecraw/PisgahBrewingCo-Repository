/* Created by Martin Hintzmann 2008 martin [a] hintzmann.dk
 * MIT (http://www.opensource.org/licenses/mit-license.php) licensed.
 *
 * Version: 0.1
 *
 * Requires:
 *   jQuery 1.2+
 */
(function($) {
	$.fn.boxShadow = function(xOffset, yOffset, blurRadius, shadowColor) {
		if (!$.browser.msie) return;
		return this.each(function(){
			if($(this).css("position")!="absolute"){
			$(this).css({
				position:	"relative",
				zoom: 		1,
				zIndex:		"2"
			});
			
			} else {
				$(this).css({
					zoom: 		1,
					zIndex:		"2"
				});			
			}
			startPosition=$(this).position();
			
			if($(this).parent().css("position")!="absolute"){
			$(this).parent().css({
					position:	"relative"
			});
			}
			var div=document.createElement("div");
			$(this).parent().append(div);

			var _top, _left, _width, _height;
			if (blurRadius != 0) {
				$(div).css("filter", "progid:DXImageTransform.Microsoft.Blur(pixelRadius="+(blurRadius)+", enabled='true')");
				_top = 		startPosition.top+yOffset-blurRadius-1;
				_left =		startPosition.left+xOffset-blurRadius-1;
				_width =		$(this).outerWidth()+1;
				_height =	$(this).outerHeight()+1;
			} else {
				_top = 		startPosition.top+yOffset;
				_left =		startPosition.left+xOffset;
				_width = 	$(this).outerWidth();
				_height = 	$(this).outerHeight();
			}
		
			$(div).css({
				top: 			_top,
				left:			_left,
				width:		_width,
				height:		_height,
				background:	shadowColor,
				position:	"absolute",
				zIndex:		1
			});
			
	  });
	};
})(jQuery);