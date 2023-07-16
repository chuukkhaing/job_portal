<div class="container" id="edit-profile-header">
    <div class="px-5 m-0 pb-0 pt-5">
        <div class="table-responsive" id="applicant-tracking-section">
            <table class="table border-0" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Job Title</th>
                        
                        <th># Apps</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobApplicants as $key => $jobApplicant)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td><a href="{{ route('jobpost-detail', $jobApplicant->slug) }}">{{ $jobApplicant->job_title }}</a></td>
                        
                        <td><a href="#" onclick="getCVList({{$jobApplicant->id}})">{{ $jobApplicant->JobApply->count() }} CVs</a></td>
                        
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
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Application Receive ( <span id="receive-cv-length"></span> )</span>
                            </li>
                            <li class="cv-status">
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Viewed Application ( 150 )</span>
                            </li>
                            <li class="cv-status">
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Shorted Listed ( 150 )</span>
                            </li>
                            <li class="cv-status">
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Interview ( 150 )</span>
                            </li>
                            <li class="cv-status">
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Hire ( 150 )</span>
                            </li>
                            <li class="cv-status">
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Not Suitable ( 150 )</span>
                            </li>
                        </ul>
                    </div>
                    <div class="my-4">
                        <div class="table-responsive">
                            <table class="table border-0 applicant-receive-table">
                                <thead>
                                    <tr>
                                        <th>Candidate Name</th>
                                        <th>Applied Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-9" style="background: white">
                    <h5 class="text-dark">Profile Overview</h5>
                    <div class="mt-4">
                        <h6 class="job-title" id="receive-job-title"></h6>
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
                $(response.jobApply).each(function(index,value) {
                    var active = '';
                    if(index == 0) {
                        active = 'active'
                    }
                    $(".applicant-receive-table").append('<tr><td class="'+active+'">'+value.first_name+' '+value.last_name+'</td><td class="text-end">'+moment(value.applied_date).format("DD/MM/YYYY")+'</td></tr>')
                })
            }
        })
    }
</script>
@endpush