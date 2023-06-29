(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });


    // Date and time picker
    $('.date').datetimepicker({
        format: 'L'
    });
    $('.time').datetimepicker({
        format: 'LT'
    });
    $('#date_of_birth').datepicker({
        uiLibrary: 'bootstrap5'
    });

    $('#year').datepicker({
        uiLibrary: 'bootstrap5',
        minViewMode: 2,
         format: 'yyyy'
    });

    $(".select_2").select2({
        placeholder: "Choose...",
        allowClear: true
    });
    
})(jQuery);

