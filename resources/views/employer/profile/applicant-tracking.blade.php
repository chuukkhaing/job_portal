<div class="container" id="edit-profile-header">
    <div class="px-5 m-0 pb-0 pt-5">
        <div class="table-responsive" id="applicant-tracking-section">
            <table class="table border-0" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Job Title</th>
                        <th># Apps</th>
                        <th>Posted Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobApplicants as $key => $jobApplicant)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td><a href="{{ route('jobpost-detail', $jobApplicant->slug) }}">{{ $jobApplicant->job_title }}</a></td>
                        <td>
                            @if($jobApplicant->JobApply->count() > 0)
                            <a href="#" onclick="getCVList({{$jobApplicant->id}})">{{ $jobApplicant->JobApply->count() }} CVs</a>
                            @else 
                            {{ $jobApplicant->JobApply->count() }} CVs
                            @endif
                        </td>
                        <td>{{ date('d-m-Y', strtotime($jobApplicant->created_at)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-none" id="cv-list-section">
            <div class="row">
                <div class="col-3">
                    <h5 class="text-dark">Applicant Inbox</h5>
                    <div class="my-4">
                        <ul class="cv-item p-0">
                            <li class="cv-status active">
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Application Received ( <span id="receive-cv-length">0</span> )</span>
                            </li>
                            <li class="cv-status">
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Viewed Application ( 0 )</span>
                            </li>
                            <li class="cv-status">
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Shorted Listed ( 0 )</span>
                            </li>
                            <li class="cv-status">
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Interview ( 0 )</span>
                            </li>
                            <li class="cv-status">
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Hire ( 0 )</span>
                            </li>
                            <li class="cv-status">
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Not Suitable ( 0 )</span>
                            </li>
                        </ul>
                    </div>
                    <div class="my-4">
                        <div class="table-responsive">
                            <table class="table border-0 applicant-receive-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Seeker Name</th>
                                        <th class="text-end">Applied Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-9" style="background: white">
                    <h5 class="text-dark d-inline-block">Profile Overview</h5>
                    <div class="d-inline-block float-end">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-download"></i>
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item download_seeker_cv" href="" download>Download Seeker's CV</a></li>
                                <li><a class="dropdown-item download_ic_cv" href="#">Download IC Format CV</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-primary btn-sm precious-btn">Back</button>
                    </div>
                    
                    <div class="mt-4">
                        <div class="mb-4">
                            <h5 class="job-title" id="receive-job-title"></h5>
                            <hr>
                        </div>
                        <div class="mb-4">
                            <embed src="" id="seeker-org-attach" type="" width="100%" height="600px" />
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>   
   
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> 
<script>
    function getCVList(id) {
        $(".employer-single-tab").removeClass('active');
        $("#applicant-tracking-tab").addClass('active');
        $("#applicant-tracking-section").addClass('d-none');
        $("#cv-list-section").removeClass('d-none');
        getRelatedApplicantList(id);
    }
    $(".precious-btn").click(function() {
        $(".employer-single-tab").removeClass('active');
        $("#applicant-tracking-tab").addClass('active');
        $("#applicant-tracking-section").removeClass('d-none');
        $("#cv-list-section").addClass('d-none');
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function getRelatedApplicantList(id)
    {
        $.ajax({
            type: 'GET',
            url: 'get-jobpost/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                $("#receive-cv-length").text(response.jobApply.length);
                $("#receive-job-title").text(response.jobPost.job_title);
                $(".applicant-receive-table-tr").empty();
                
                if(response.jobApply.length > 0) {
                    $('.dataTables_empty').addClass('d-none');
                    $(response.jobApply).each(function(index,value) {
                    var active = '';
                    if(value.seeker_id == response.seeker.id) {
                        active = 'active'
                    }
                    $(".applicant-receive-table").append('<tr class="applicant-receive-table-tr" onClick="getRelatedApplicantInfo('+value.seeker_id+','+value.job_post_id+')"><td class="'+active+'">'+value.seeker_first_name+' '+value.seeker_last_name+'</td><td class="text-end">'+moment(value.seeker_applied_date).format("DD/MM/YYYY")+'</td></tr>');
                    $(".download_seeker_cv").attr('href',document.location.origin+'/storage/seeker/cv/'+response.seeker_attach.name);
                    $(".download_ic_cv").attr('href', document.location.origin+'/employer/download-ic-cv/'+response.seeker.id);
                    $("#seeker-org-attach").attr('src','')
                    $("#seeker-org-attach").attr('src', document.location.origin+'/storage/seeker/cv/'+response.seeker_attach.name+'#toolbar=0&navpanes=0&scrollbar=0&page=1');
                })
                }else {
                    $('.dataTables_empty').removeClass('d-none')
                }
            }
        })
    }

    function getRelatedApplicantInfo(id, jobPostId)
    {
        $.ajax({
            type: 'GET',
            url: 'get-jobpost-info/'+id+'/'+jobPostId,
        }).done(function(response){
            if(response.status == 'success') {
                $("#receive-cv-length").text(response.jobApply.length);
                $("#receive-job-title").text(response.jobPost.job_title);
                $(".applicant-receive-table-tr").empty();
                if(response.jobApply.length > 0) {
                    $('.dataTables_empty').addClass('d-none');
                    $(response.jobApply).each(function(index,value) {
                    var active = '';
                    if(value.seeker_id == response.seeker.id) {
                        active = 'active'
                    }
                    $(".applicant-receive-table").append('<tr class="applicant-receive-table-tr" onClick="getRelatedApplicantInfo('+value.seeker_id+','+value.job_post_id+')"><td class="'+active+'">'+value.seeker_first_name+' '+value.seeker_last_name+'</td><td class="text-end">'+moment(value.seeker_applied_date).format("DD/MM/YYYY")+'</td></tr>');
                    $(".download_seeker_cv").attr('href',document.location.origin+'/storage/seeker/cv/'+response.seeker_attach.name);
                    $(".download_ic_cv").attr('href', document.location.origin+'/employer/download-ic-cv/'+response.seeker.id);
                    $("#seeker-org-attach").attr('src','')
                    $("#seeker-org-attach").attr('src', document.location.origin+'/storage/seeker/cv/'+response.seeker_attach.name+'#toolbar=0&navpanes=0&scrollbar=0&page=1');
                    
                })
                }else {
                    $('.dataTables_empty').removeClass('d-none')
                }
            }
        })
    }
</script>
@endpush