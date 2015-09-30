var frontpageSlider = (function() {

    var $slider,
        $content,
        $prevTrigger,
        $nextTrigger,
        $triggers,
        sliderWidth,
        sliderHeight,
        totalWidth,
        $slides,
        slidesNumber,
        $current,
        $prev,
        $next,
        nextWidth;

    function init() {

        $slider         = $('.projects-slider');
        $content        = $('.project-slide__content');
        $prevTrigger    = $('.vertical-title.prev');
        $nextTrigger    = $('.vertical-title.next');
        $triggers       = $nextTrigger.add($prevTrigger);
        sliderWidth     = $slider.width();
        sliderHeight    = $slider.height();
        totalWidth      = 0;
        $slides         = $slider.children();
        slidesNumber    = $slides.length;
        $current        = $slides.eq(0);
        nextWidth       = $nextTrigger.width() - 100;

        var minSlides = 5,
            offset;

        // assure minimum number of slides
        if (slidesNumber < 2) {
            $slider.css({
                opacity: 1,
                margin: 0
            });
            animateContentIn();
            return;
        }

        if (slidesNumber < 3) {
            $slider.css({
                marginLeft: 0
            });
            sliderWidth = $slider.width();
            $prevTrigger.hide();
        }

        if (slidesNumber < minSlides) {
            $slides.clone().appendTo($slider);
            $slides = $slider.children();
        }

        $slides.not($current).width(nextWidth);

        $slider.imagesLoaded(function() {

            $slides.each(function(i, obj) {
                var $slide = $(obj);

                if (i != 0) {
                    totalWidth += nextWidth;
                    $slide.css('left', sliderWidth + (i - 1) * nextWidth);
                } else {
                    totalWidth += sliderWidth;
                }

                scaleImage($slide.find('img'));
            });

            TweenMax.to($slider, .3, {opacity: 1});

            // balance slides to left and right
            offset = parseInt(($slides.length - 1) / 2, 10);
            $slides.slice(-offset).prependTo($slider).each(function(i, obj) {
                $(obj).css('left', '-=' + totalWidth);
            });

            $slides = $slider.children();

            $prev = $current.prev();
            $next = $current.next();

            createBullets();
            setZindex();
            bindEvents();
            animateContentIn();
        });
    }

    function onResize() {

        var newWidth    = $slider.width(),
            $nextSlides = $current.nextAll(),
            difference   = newWidth - sliderWidth;

        sliderHeight    = $slider.height();
        totalWidth      = totalWidth + difference;
        sliderWidth     = newWidth;

        $current.width(sliderWidth);

        $nextSlides.each(function(i, obj) {
            $(obj).css('left', '+=' + difference);
        });
    }

    function scaleImage($img) {
        var imageWidth      = $img.width(),
            imageHeight     = $img.height(),
            scaleX          = sliderWidth / imageWidth,
            scaleY          = sliderHeight / imageHeight,
            scale           = Math.max(scaleX, scaleY);

        $img.width(scale * imageWidth);
        $img.height(scale * imageHeight);
    }

    function createBullets() {
        var $container = $('.projects-slider__bullets');

        for (var i = 0; i < slidesNumber; i++) {
            $container.append('<div class="rsBullet"><span></span></div>');
        }

        $container.children().first().addClass('rsNavSelected');
    }

    function slider_keys_controls_callback (e) {

        switch(e.which) {

            case 37:
                if ( $('.slider--show_next' ).length > 0 || $current.prev('div').length <= 0 ) return;
                onPrevClick();
                e.preventDefault();
                break; // left

            case 39:
                if ( $current.next('div').length <= 0 ) return;
                onNextClick();
                e.preventDefault();
                break; // right

            default:
                return;
        }
    }

    function bindEvents() {
        if (nextWidth > 70 && !$('html').is('.is--ie9, .is--ie-le10')) {
            $nextTrigger.on('mouseenter', onNextEnter);
            $nextTrigger.on('mouseleave', onNextLeave);
        }
        $nextTrigger.on('click', onNextClick);

        if (nextWidth > 70 && !$('html').is('.is--ie9, .is--ie-le10')) {
            $prevTrigger.on('mouseenter', onPrevEnter);
            $prevTrigger.on('mouseleave', onPrevLeave);
        }
        $prevTrigger.on('click', onPrevClick);

        $(document).on('keydown', slider_keys_controls_callback );

    }

    function onNextEnter() {
        TweenMax.to($next.find('.project-slide__image'), .4, {opacity: 1, ease: Quint.easeOut});
        TweenMax.to($next.add($content), .4, {x: -60, ease: Back.easeOut}, '-=.4');
        TweenMax.to($next, .4, {width: 160, ease: Back.easeOut}, '-=.4');
        TweenMax.to($nextTrigger, .4, {x: -30, ease: Back.easeOut}, '-=.4');
    }

    function onPrevEnter() {
        TweenMax.to($prev.find('.project-slide__image'), .4, {opacity: 1, ease: Quint.easeOut});
        TweenMax.to($content, .4, {x: 60, ease: Back.easeOut});
        TweenMax.to($prev, .4, {width: 160, ease: Back.easeOut});
        TweenMax.to($prevTrigger, .4, {x: 30, ease: Back.easeOut});
    }

    function onNextLeave() {
        TweenMax.to($next.find('.project-slide__image'), .4, {opacity: 0.6, ease: Quint.easeOut});
        TweenMax.to($next.add($content), .4, {x: 0, ease: Quint.easeOut});
        TweenMax.to($next, .4, {width: nextWidth, ease: Quint.easeOut});
        TweenMax.to($('.vertical-title.next'), .4, {x: 0, ease: Quint.easeOut});
    }

    function onPrevLeave() {
        TweenMax.to($prev.find('.project-slide__image'), .4, {opacity: 0.6, ease: Quint.easeOut});
        TweenMax.to($prev.add($content), .4, {x: 0, ease: Quint.easeOut});
        TweenMax.to($prev, .4, {width: nextWidth, ease: Quint.easeOut});
        TweenMax.to($('.vertical-title.prev'), .4, {x: 0, ease: Quint.easeOut});
    }

    function onNextClick() {
        $(document).off('keydown', slider_keys_controls_callback );

        var timeline = getNextTimeline();

        $prev       = $current;
        $current    = $next;
        $next       = $next.next();

        $nextTrigger.off('click', onNextClick);
        animateContentTo($current);
        timeline.play();

        updateBullets(1);
    }

    function onNextComplete() {
        $slides.first().appendTo($slider).css('left', '+=' + totalWidth);
        $slides = $slider.children();
        setZindex();
        $nextTrigger.on('click', onNextClick);
        $(document).on('keydown', slider_keys_controls_callback );
    }

    function getNextTimeline() {
        var timeline = new TimelineMax({ paused: true, onComplete: onNextComplete });
        timeline.to($next.next().find('.project-slide__image'), 0, {opacity: 1, ease: Power1.easeOut});
        timeline.to($slider, .7, {x: '-=' + nextWidth, ease: Quint.easeOut});
        timeline.to($current, .7, {width: nextWidth, ease: Quint.easeOut}, '-=.7');
        timeline.to($next, .7, {width: sliderWidth, left: '-=' + (sliderWidth - nextWidth), x: 0, ease: Quint.easeOut}, '-=.7');
        if (nextWidth > 70 && !$('html').is('.is--ie9, .is--ie-le10')) {
            timeline.to($next.next(), .4, {width: 160, x: -60, ease: Quint.easeOut}, '-=.7');
        } else {
            timeline.to($next.find('.project-slide__image'), .4, {opacity: 1, ease: Power1.easeOut}, '-=.4');
            timeline.to($next.next().find('.project-slide__image'), .4, {opacity: 0.6, ease: Power1.easeOut}, '-=.4');
        }
        timeline.to($current.find('.project-slide__image'), .4, {opacity: 0.6, ease: Power1.easeOut}, '-=.4');
        return timeline;
    }

    function onPrevClick() {
        $(document).off('keydown', slider_keys_controls_callback );

        var timeline = getPrevTimeline();

        $next       = $current;
        $current    = $prev;
        $prev       = $prev.prev();

        $prevTrigger.off('click', onPrevClick);
        animateContentTo($current);
        timeline.play();

        updateBullets(-1);
    }

    function onPrevComplete() {
        $slides.last().prependTo($slider).css('left', '-=' + totalWidth);
        $slides = $slider.children();
        setZindex();
        $prevTrigger.on('click', onPrevClick);
        $(document).on('keydown', slider_keys_controls_callback );
    }

    function getPrevTimeline() {
        var timeline = new TimelineMax({ paused: true, onComplete: onPrevComplete });
        timeline.to($prev.prev().find('.project-slide__image'), 0, {opacity: 1, ease: Quint.easeOut});
        timeline.to($slider, .7, {x: '+=' + nextWidth, ease: Quint.easeOut});
        timeline.to($current, .7, {width: nextWidth, left: '+=' + (sliderWidth - nextWidth), ease: Quint.easeOut}, '-=.7');
        timeline.to($prev, .7, {width: sliderWidth, x: 0, ease: Quint.easeOut}, '-=.7');
        if (!$('html').is('.is--ie9, .is--ie-le10')) {
            timeline.to($prev.prev(), .4, {width: 160, ease: Quint.easeOut}, '-=.7');
        }
        timeline.to($current.find('.project-slide__image'), .4, {opacity: 0.6, ease: Quint.easeOut}, '-=.4');
        return timeline;
    }

    function updateBullets(offset) {
        var $selectedBullet = $('.rsNavSelected'),
            count = $selectedBullet.index();

        $selectedBullet.removeClass('rsNavSelected');

        if (count + offset == slidesNumber) {
            $('.rsBullet').eq(0).addClass('rsNavSelected');
        } else if (count + offset == -1) {
            $('.rsBullet').eq(slidesNumber - 1).addClass('rsNavSelected');
        } else {
            $('.rsBullet').eq(count + offset).addClass('rsNavSelected');
        }
    }

    function animateContentIn() {

        $content.find('.project-slide__title h1').text($current.data('title'));
        $content.find('.portfolio_types').html($current.data('types'));
        $content.find('a').attr('href', $current.data('link')).attr('title', $current.data('link-title'));

        $current.find('.project-slide__image').css('opacity', 1);
        TweenMax.fromTo($content.find('.project-slide__title h1'), .7, {y: '-100%'}, {y: '0%', delay: .5, ease: Expo.easeInOut});
        TweenMax.fromTo($content.find('.js-title-mask'), .7, {y: '100%'}, {y: '0%', delay: .5, ease: Expo.easeInOut});
        TweenMax.fromTo($content.find('.portfolio_types'), .3, {opacity: 0}, {opacity: 1, delay: .9, ease: Quint.easeIn});
        TweenMax.fromTo($content.find('.project-slide__text'), .4, {x: -10, opacity: 0}, {x: 0, opacity: 1, delay: 1, ease: Quint.easeOut});
        // TweenMax.to($('.site-content__mask'), .6, {scaleX: 0, ease: Expo.easeInOut});
    }

    function animateContentTo($slide) {
        var $clone      = $content.clone(),
            $nextTitle  = $('.vertical-title.next span'),
            $nextClone  = $nextTitle.clone().text($slide.next().data('title')),
            $prevTitle  = $('.vertical-title.prev span'),
            $prevClone  = $prevTitle.clone().text($slide.prev().data('title')),
            timeline    = new TimelineMax({ paused: true, onComplete: function() {
                $prevTitle.remove();
                $nextTitle.remove();
                $content.remove();
                $content = $clone;
                $content.djax('.djax-updatable', [], djax.transition);
            }});

        $clone.find('.project-slide__title h1').text($slide.data('title'));
        $clone.find('.portfolio_types').html($slide.data('types'));
        $clone.find('a').attr('href', $slide.data('link')).attr('title', $slide.data('link-title'));

        // les types
        var $fadeOut = $content.find('.portfolio_types').add($nextTitle).add($prevTitle),
            $fadeIn  = $clone.find('.portfolio_types').add($nextClone).add($prevClone);

        timeline.fromTo($fadeOut, .3, {opacity: 1}, {opacity: 0, ease: Quint.easeIn});
        timeline.fromTo($fadeIn, .3, {opacity: 0}, {opacity: 1, ease: Quint.easeIn}, '-=0.2');

        // le title
        timeline.fromTo($content.find('.project-slide__title h1'), .3, {opacity: 1}, {opacity: 0, ease: Quint.easeOut}, '-=0.3');
        timeline.fromTo($clone.find('.project-slide__title h1'), .5, {y: '-100%'}, {y: '0%', ease: Expo.easeOut}, '-=0.2');
        timeline.fromTo($clone.find('.js-title-mask'), .5, {y: '100%'}, {y: '0%', ease: Expo.easeOut}, '-=0.5');

        $content.find('.project-slide__text').css('opacity', 0);
        $nextClone.insertAfter($nextTitle);
        $prevClone.insertAfter($prevTitle);
        $clone.insertAfter($content);
        timeline.play();

    }

    function setZindex() {
        $current.css('z-index', '');
        $prev.css('z-index', 10).prev().css('z-index', 20);
        $next.css('z-index', 10).next().css('z-index', 20);
    }

    return {
        init: init,
        onResize: onResize
    }

})();