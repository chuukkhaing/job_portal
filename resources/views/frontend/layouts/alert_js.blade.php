@push('scripts')
<script>
    $(document).ready(function() {
        var show_success_modal = "{{ session()->pull('success') }}";
        if(show_success_modal != '') {
            MSalert.principal({
                icon:'success',
                title:'Success',
                description: show_success_modal,
            })
        }

        var show_error_modal = "{{ session()->pull('error') }}";
        if(show_error_modal != '') {
            MSalert.principal({
                icon:'error',
                title:'Error',
                description: show_error_modal,
            })
        }

        var show_info_modal = "{{ session()->pull('info') }}";
        if(show_info_modal != '') {
            MSalert.principal({
                icon:'info',
                title:'Info',
                description: show_info_modal,
            })
        }

        var show_warning_modal = "{{ session()->pull('warning') }}";
        if(show_warning_modal != '') {
            MSalert.principal({
                icon:'warning',
                title:'Warning',
                description: show_warning_modal,
            })
        }
    })
</script>
@endpush