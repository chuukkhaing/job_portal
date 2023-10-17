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
        allowClear: true,
    });

    $(".resume_select_2").select2({
        placeholder: "Choose...",
        allowClear: true,
    });

    $("#industry_id").select2({
        placeholder: 'Select Industry',
        allowClear: true
    });

    $('.summernote').summernote({
        toolbar: [
            ['font', ['bold', 'italic', 'underline']],
            ['para', ['ul', 'ol', 'paragraph']]
        ],
        height: 200
    });

    $('.dataTable').dataTable({
        ordering: false,
        dom: '<frtp>',
        pageLength: 15
    });

    $('#dataTable').dataTable({
        ordering: false
    });
    
    $('input[type=number]').on('mousewheel', function(e) {
        $(e.target).blur();
    });

    $('form').submit(function(){
        $(this).find(':submit').attr( 'disabled','disabled' );
        //the rest of your code
       setTimeout(() => {
           $(this).find(':submit').attr( 'disabled',false );
       }, 2000)
    });

    $("#seeker-toggle-mobile").click(function() {
        if($(this).attr('aria-expanded') == 'true') {
            $(".seeker-profile-mobile").addClass('d-none');
        }else {
            $(".seeker-profile-mobile").removeClass('d-none')
        }
    })
})(jQuery);

