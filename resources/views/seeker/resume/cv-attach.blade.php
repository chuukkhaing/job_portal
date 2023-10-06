<div class="my-2 row table-responsive">
    <table id="cv-table" class="table-bordered @if($cvs->count() == 0) d-none @endif table">
        
        <tbody>
            @foreach($cvs as $cv)
            <tr class="cv-tr-{{ $cv->id }}">
                <td class="cv-name-{{$cv->id}}"><a target="_blank" href="{{ asset('storage/seeker/cv/'.$cv->name) }}">{{ $cv->name }}</a></td>
                <td>
                    <a id="deleteCV-{{ $cv->id }}" class="deleteCV btn border-0 text-danger" value="{{ $cv->id }}"><i class="fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="my-2">
    <button type="button" class="btn btn-sm profile-save-btn m-2" data-bs-toggle="modal" data-bs-target="#cvModal">
        <i class="fa-solid fa-plus"></i> Upload CV
    </button>
</div>
<div class="modal fade" id="cvModal" tabindex="-1" aria-labelledby="cvModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cvModalLabel">Upload CV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12 col-md-6 my-0">
                        <input type="checkbox" name="is_ic_cv" id="is_ic_cv" class="seeker_input">
                        <label for="is_ic_cv" class="seeker_label">Do you want to use IC Resume?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mt-1 col-12 col-md-6 org_cv">
                        <label for="cv_attach" class="seeker_label my-2">Upload CV <span class="text-danger">*</span></label>
                        <input type="file" name="cv_attach" id="cv_attach" class="form_control seeker_input" >
                        <span class="text-danger" id="cv_attach-error"></span>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                <span class="btn profile-save-btn" id="save-cv">Save changes</span>
            </div>
            
        </div>
    </div>
</div>
<div class="row my-4">
    <div class="col-12 text-end">
        <button type="button" class="btn btn-sm profile-save-btn pre-career-history">Previous</button>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $('.pre-career-history').click(function() {
            $("#nav-cv-build-tab").removeClass('active');
            $("#nav-career-choice-tab").addClass('active');
            $("#nav-cv-attach-tab").removeClass('active');
            $("#nav-cv-build").removeClass('show active');
            $("#nav-career-choice").addClass('show active');
            $("#nav-cv-attach").removeClass('show active');
        })

    })
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#is_ic_cv').change(function() {
        if($(this).is(":checked")){ 
            $(this).val(1);
            $(".org_cv").addClass('d-none');
        }else {
            $(this).val(0);
            $(".org_cv").removeClass('d-none');
        }
    })

    var seeker_id = {{ Auth::guard("seeker")->user()->id }};
    $("#save-cv").click(function() {
        var is_ic_cv = $("#is_ic_cv").val();
        if(is_ic_cv == 1) {
            $('.btn-close').click();
            $.ajax({
                type: 'POST',
                data: {
                    'is_ic_cv' : is_ic_cv,
                    'seeker_id' : seeker_id
                },
                url: '{{ route("seekerAttach.store") }}',
            }).done(function(response){
                if(response.status == 'success') {
                    $("#cv-table").removeClass('d-none');
                    $("#cv-table").append('<tr class="cv-tr-'+response.attach.id+'"><td class="cv-name-'+response.attach.id+'"><a target="_blank" href="'+document.location.origin+'/storage/seeker/cv/'+response.attach.name+'">'+response.attach.name+'</a></td><td><a id="deleteCV-'+response.attach.id+'" class="deleteCV btn border-0 text-danger" value="'+response.attach.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                    MSalert.principal({
                        icon:'success',
                        title:'',
                        description:response.msg,
                    })
                    $("#cv_attach").val('');
                }
            })
        }else {
            var fd = new FormData();
            var cv_attach = $('#cv_attach')[0].files[0];
            fd.append('cv_attach', cv_attach);
            fd.append('seeker_id', seeker_id);
            if(cv_attach == undefined) {
                $("#cv_attach-error").html('CV need to upload.');
            }else {
                $("#cv_attach-error").html('');
            }
            
            if(cv_attach != undefined)
            {
                $('.btn-close').click();
                $.ajax({
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    url: '{{ route("seekerAttach.store") }}',
                }).done(function(response){
                    if(response.status == 'success') {
                        $("#cv-table").removeClass('d-none');
                        $("#cv-table").append('<tr class="cv-tr-'+response.attach.id+'"><td class="cv-name-'+response.attach.id+'"><a target="_blank" href="'+document.location.origin+'/storage/seeker/cv/'+response.attach.name+'">'+response.attach.name+'</a></td><td><a id="deleteCV-'+response.attach.id+'" class="deleteCV btn border-0 text-danger" value="'+response.attach.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                        MSalert.principal({
                            icon:'success',
                            title:'',
                            description:response.msg,
                        })
                        $("#cv_attach").val('');
                    }
                })
            }
        }
    })

    $(document).on('click', '.deleteCV', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    data: {
                        "seeker_id": seeker_id
                    },
                    url: '/seeker/seekerAttach/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".cv-tr-"+id).empty();
                        if(response.seeker_cvs_count == 0) {
                            $("#cv-table").addClass('d-none');
                        }

                        MSalert.principal({
                            icon:'success',
                            title:'',
                            description:response.msg,
                        })
                    }
                })
            }            
        })
    });
</script>
@endpush