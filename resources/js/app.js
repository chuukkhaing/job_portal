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
});