;(function($) {
    $.fn.Thumbelina = function(settings) {
        var $container = this,     
            $list = $('ul',this),   
            moveDir = 0,           
            pos = 0,               
            destPos = 0,           
            listDimension = 0,     
            idle = 0,
            outerFunc,
            orientData; 
        $list.addClass('thumbelina').wrap('<div style="position:absolute;overflow:hidden;width:100%;height:100%;">');       
        settings = $.extend({}, $.fn.Thumbelina.defaults, settings);
        if(settings.orientation === 'vertical') 
            orientData = {outerSizeFunc:  'outerHeight', cssAttr: 'top', display: 'block'};
        else
            orientData = {outerSizeFunc:  'outerWidth', cssAttr: 'left', display: 'inline-block'};
        $('li',$list).css({display: orientData.display});
        var bindButEvents = function($elem,dir) {
            $elem.bind('mousedown mouseup touchend touchstart',function(evt) {
                if (evt.type==='mouseup' || evt.type==='touchend') moveDir = 0;
                else moveDir = dir;
                return false;
            });
        };
        bindButEvents(settings.$bwdBut,1);
        bindButEvents(settings.$fwdBut,-1);
        outerFunc = orientData.outerSizeFunc;
        var animate = function() {
            var minPos;
            if (!moveDir && pos === destPos && listDimension === $container[outerFunc]() ) {  
                idle++;
                if (idle>100) return;
            }else {                 
                listDimension = $container[outerFunc]();
                idle = 0;
            }
            destPos += settings.maxSpeed * moveDir;
            minPos = listDimension - $list[outerFunc]();
            if (minPos > 0) minPos = 0;           
            if (destPos < minPos) destPos = minPos;            
            if (destPos>0) destPos = 0;
            if (destPos === minPos) settings.$fwdBut.addClass('disabled');
            else settings.$fwdBut.removeClass('disabled');
            if (destPos === 0) settings.$bwdBut.addClass('disabled');
            else settings.$bwdBut.removeClass('disabled');
            pos += (destPos - pos) / settings.easing;
            if (Math.abs(destPos-pos)<0.001) pos = destPos;            
            $list.css(orientData.cssAttr, Math.floor(pos));
        };        
        setInterval(function(){
            animate();
        },1000/60);
    };    
    $.fn.Thumbelina.defaults = {
        orientation:    "horizontal", 
        easing:         30,            
        maxSpeed:       50,             
        $bwdBut:   null,               
        $fwdBut:    null              
    };    
})(jQuery);