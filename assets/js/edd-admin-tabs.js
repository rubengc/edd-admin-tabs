jQuery(document).ready(function ($) {
    function edd_admin_tabs_toggle() {
        $('.edd-admin-tabs-nav-tab').each(function() {
            var selector = $(this).attr('data-selector');

            if($(this).hasClass('nav-tab-active')) {
                $(selector).css({position: 'relative', opacity: 1, width: 'auto', left: 0});
            } else {
                // A hack to maintain current user postbox visibility option to :visible (display none is considered as :hidden but not opacity 0)
                $(selector).css({position: 'absolute', opacity: 0, width: 0, left: '-3000px'});
            }
        });

    }

    edd_admin_tabs_toggle();

    $('.edd-admin-tabs-nav-tab').click(function(e) {
        e.preventDefault();

        if( ! $(this).hasClass('nav-tab-active') ) {
            $('.edd-admin-tabs-nav-tab.nav-tab-active').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');

            edd_admin_tabs_toggle();
        }
    });
});