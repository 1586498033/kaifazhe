$(document).ready(function() {
    $('.js-tabs').each(function(index, item) {
        var $block = $(item);
        $block.find('.tit > .item').on('click', function(e) {
            if (!$(this).hasClass('on')) {
                var $currentTit = $block.find('.tit > .on');
                var $currentDesc = $block.find('.desc > .on');
                var $clickTit = $(this);
                var $clickDesc = $($block.find('.desc > .item')[$clickTit.index()]);

                $currentTit.removeClass('on');
                $clickTit.addClass('on');
                if ($block.hasClass('js-anim')) {
                    $currentDesc.fadeOut('fast', function() {
                        $(this).removeClass('on');
                        $clickDesc.fadeIn('fast', function() {
                            $(this).addClass('on');
                        });
                    });
                } else {
                    $currentDesc.removeClass('on');
                    $clickDesc.addClass('on');
                }
            }
        });
    });

    $('.form-select').on('click', function(e) {
        e.stopPropagation();
        var $this = $(this);
        var $tit = $this.find('.tit');
        var $options = $this.find('.options');
        var $optionItem = $options.find('li:first');
        var $window = $(window);
        var down = ($tit.offset().top - $window.scrollTop() + $tit.height() + $options.height() <= $window.height());

        if (down) {
            $options.css({
                'top': $tit.outerHeight() + 'px',
                'bottom': 'auto',
                'min-width': $tit.innerWidth() + 'px',
                'height': $options.height()
            });
        } else {
            $options.css({
                'top': 'auto',
                'bottom': $tit.outerHeight() + 'px',
                'min-width': $tit.innerWidth() + 'px',
                'height': $options.height()
            });
        }
        $options.slideToggle('fast').parents('.form-select').siblings('.form-select').find('.options').slideUp('fast');
    });
    
    $('body').on('click', function(e) {
        $('.form-select .options').slideUp();
    });

    //点击选中再取消
	/*$('.collect').click(function(event) {
        
        //$(this).toggleClass('on');
		
    });*/
});