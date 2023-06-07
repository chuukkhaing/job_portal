require('./bootstrap');
import Swal from 'sweetalert2';

$(document).ready(function(){
    $('.delete-confirm').click(function(event) {
        var form =  $(this).closest("form");
        event.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to delete?',
            text: "If you delete this, it will be gone.",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            dangerMode: true,
        })
        .then((result) => {
            if (result.isConfirmed)  {
                form.submit();
            }
        });
    });

    $('#dataTable').dataTable();

    $(".select_2").select2({
        placeholder: "Choose..."
    });

    $('.icp').on('click', function () {
        $('.icp-dd').iconpicker();
    });
    $('.icp').on('iconpickerSelected', function (e) {
        $('#icon').val(e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue));
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });

    $('.summernote').summernote({
        height: 200
    });
});