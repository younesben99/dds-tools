jQuery(document).ready(function($) {
    // Toggle mobile menu when the burger menu icon is clicked
    $('.burger-menu-toggle').on('click', function() {
        $('.dds-main-nav').addClass('open');
        $('body').addClass('no-scroll');
    });

    // Close the mobile menu when the close icon or a menu item is clicked
    $('.close-menu, .navigation-menu a').on('click', function() {
        $('.dds-main-nav').removeClass('open');
        $('body').removeClass('no-scroll');
    });

    // Close the mobile menu when clicking outside the menu
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.dds-main-nav, .burger-menu-toggle').length) {
            $('.dds-main-nav').removeClass('open');
            $('body').removeClass('no-scroll');
        }
    });
});
