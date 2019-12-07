
$(document).ready(function($) {
	
	// 手机导航
	$('.menuBtn').append('<b></b><b></b><b></b>');
	$('.menuBtn').click(function(event) {
		$(this).toggleClass('open');
		var _winw = $(window).width();
		var _winh = $(window).height();
		if( $(this).hasClass('open') ){
			$('body').addClass('open');
			if( _winw<=959 ){
				$('.nav,.nav .con').stop().slideDown();
			}
		}else{
			$('body').removeClass('open');
			if( _winw<=959 ){
				$('.nav,.nav .con').stop().slideUp();
			}
		}
	});

	// 导航
	function myNav(){
		var _winw = $(window).width();
		if( _winw>959 ){
			$('.nav li').each(function() {
				if( $(this).find('dl').length ){
					var par=$(this).parents(".nav")
					var L=par.offset().left;
					var nav_w=par.width();
					var L1=$(this).offset().left;
					$(this).find('.con').css({
						width:nav_w,
						left:-(L1-L)
					});
				}
			});
			$('.nav').show();
			$('.nav li').bind('mouseenter',function() {
				$(this).find('.con').stop().slideDown();
				if( $(this).find('.con').length ){
					$(this).addClass('ok');
				}
			});
			$('.nav li').bind('mouseleave',function() {
				$(this).removeClass('ok');
				$(this).find('.con').stop().slideUp();
			});
			$('body,.menuBtn').removeClass('open');
		}else{
			$('.nav').hide();
			$(".nav .con").hide();
			$('.nav li').unbind('mouseenter mouseleave');
			$('.nav .v1').click(function(){
				$(".nav .con").show();
				if( $(this).siblings('.con').length ){
					$(this).siblings('.con').addClass('slideRight');
					$(".menuback").stop().fadeIn();
					$(".menuBtn").stop().hide();
					return false;
				}
			});
			$(".menuback").click(function() {
				$(".nav .con").removeClass('slideRight');
				$(this).stop().fadeOut();
				$(".menuBtn").stop().show();
			});
		}
		$('.nav li').each(function() {
			if( $(this).find('.con').length ){
				$(this).addClass('has');
			}
		});
	}
	myNav();
	$(window).resize(function(event) {
		myNav();
	});
	//返回顶部
	$(".toTop").click(function() {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
	});
	$(window).scroll(function(){
        var _top = $(window).scrollTop();
        if( _top<100 ){
            $('.toTop').stop().fadeOut();
        }else{
            $('.toTop').stop().fadeIn();
        }
    });
});