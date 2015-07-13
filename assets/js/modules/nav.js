var Nav = (function() {

    var isOpen;

    function init() {
        isOpen = false;
        bindEvents();
    }

    function bindEvents() {
        $('.js-nav-toggle').on('click', function() {
            if (isOpen) {
                close();
            } else {
                open();
            }
        });
    }

    function open() {
        $body.addClass('navigation--is-visible');
        isOpen = true;
    }

    function close() {
        $body.removeClass('navigation--is-visible');
        isOpen = false;
    }

    return {
        init: init,
        open: open,
        close: close
    }
})();