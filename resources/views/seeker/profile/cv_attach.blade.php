<div class="px-5 m-0 pb-0 pt-5">
    <h5>CV Upload</h5>
    <div class="my-2 row table-responsive">
        <table id="cv-table" class="table-bordered @if($cvs->count() == 0) d-none @endif table">
            
            <tbody>
                @foreach($cvs as $cv)
                <tr class="cv-tr-{{ $cv->id }}">
                    <td class="cv-name-{{$cv->id}}"><a target="_blank" href="{{ asset('storage/seeker/cv/'.$cv->name) }}">{{ $cv->name }}</a></td>
                    <td>
                        <a id="deleteCV({{ $cv->id }})" class="deleteCV btn border-0 text-danger" value="{{ $cv->id }}"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="my-2 row">
        <button type="button" class="btn profile-save-btn m-2 col-6" data-bs-toggle="modal" data-bs-target="#cvModal">
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
                        <div class="form-group mt-1 col-12 col-md-6">
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
    
</div>
@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var seeker_id = {{ Auth::guard("seeker")->user()->id }};
    $("#save-cv").click(function() {
        
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
                    $("#cv-table").append('<tr class="cv-tr-'+response.attach.id+'"><td class="cv-name-'+response.attach.id+'"><a target="_blank" href="'+document.location.origin+'/storage/seeker/cv/'+response.attach.name+'">'+response.attach.name+'</a></td><td><a onclick="deleteCV('+response.attach.id+')" class="btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>')
                    MSalert.principal({
                        icon:'success',
                        title:'',
                        description:response.msg,
                    })
                    $("#cv_attach").val('');
                }
            })
        }
    })

    $('.deleteCV').on('click', function (e) {
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
                    url: 'seekerAttach/destory/'+id,
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

        event.preventDefault();
        return false;
    });
</script>
@endpush