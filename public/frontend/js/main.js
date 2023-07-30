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

    $(".select_2").select2({
        placeholder: "Choose...",
        allowClear: true
    });

    $("#industry_id").select2({
        placeholder: 'Select Industry',
        allowClear: true
    });

    $('.summernote').summernote({
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
        ],
        height: 200
    });

    $('#dataTable').dataTable({
        ordering: false
    });
    
})(jQuery);

