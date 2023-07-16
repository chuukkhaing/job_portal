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
                        
                        <td>
                            @if($jobApplicant->JobApply->count() > 0)
                            <a href="#" onclick="getCVList({{$jobApplicant->id}})">{{ $jobApplicant->JobApply->count() }} CVs</a>
                            @else 
                            {{ $jobApplicant->JobApply->count() }} CVs
                            @endif
                        </td>
                        
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
                                <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Application Receive ( <span id="receive-cv-length">0</span> )</span>
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
                        <div class="mb-4">
                            <h5 class="job-title" id="receive-job-title"></h5>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <p class="app_receive_name"> </p>
                                    <p id="app_receive_address">-</p>
                                    <p id="app_receive_phone">-</p>
                                    <p id="app_receive_email"></p>
                                </div>
                                <div class="col text-end">
                                    <img class="app_receive_pic" src="{{ asset('img/undraw_profile_1.svg') }}" alt="profile_pic" width="160px" height="160px">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h5>Personal Information</h5>
                            <hr>
                            <div class="row my-3">
                                <div class="col">
                                    <span>Name</span>
                                    <span class="float-end">:</span>
                                </div>
                                <div class="col">
                                    <span class="app_receive_name"></span>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <span>Date Of Birth</span>
                                    <span class="float-end">:</span>
                                </div>
                                <div class="col">
                                    <span class="app_receive_dob">-</span>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <span>NRC Number/ID</span>
                                    <span class="float-end">:</span>
                                </div>
                                <div class="col">
                                    <span class="app_receive_nrc">-</span>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <span>Nationality</span>
                                    <span class="float-end">:</span>
                                </div>
                                <div class="col">
                                    <span class="app_receive_nationality">-</span>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <span>Gender</span>
                                    <span class="float-end">:</span>
                                </div>
                                <div class="col">
                                    <span class="app_receive_gender">-</span>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <span>Marital Status</span>
                                    <span class="float-end">:</span>
                                </div>
                                <div class="col">
                                    <span class="app_receive_marital_status">-</span>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <span>Expected Salary</span>
                                    <span class="float-end">:</span>
                                </div>
                                <div class="col">
                                    <span class="app_receive_expected_salary">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h5>Career Description</h5>
                            <hr>
                            <p class="app_receive_career_des">-</p>
                        </div>
                        <div class="mb-4">
                            <h5>Education</h5>
                            <hr>
                            <div class="app_receive_education"></div>
                        </div>
                        <div class="mb-4">
                            <h5>Career History</h5>
                            <hr>
                            <div class="app_receive_experience"></div>
                        </div>
                        <div class="mb-4">
                            <h5>Skill</h5>
                            <hr>
                            <div class="app_receive_skill"></div>
                        </div>
                        <div class="mb-4">
                            <h5>Language</h5>
                            <hr>
                            <div class="app_receive_lang"></div><hr>
                        </div>
                        <div class="mb-4">
                            <h5>Reference</h5>
                            <hr>
                            <div class="app_receive_ref"></div>
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
                $(response.jobApply).each(function(index,value) {
                    var active = '';
                    if(value.seeker_id == response.seeker.id) {
                        active = 'active'
                    }
                    $(".applicant-receive-table").append('<tr><td class="'+active+'">'+response.seeker.first_name+' '+response.seeker.last_name+'</td><td class="text-end">'+moment(value.applied_date).format("DD/MM/YYYY")+'</td></tr>');
                    if(response.seeker.gender == 'Female') {
                        $(".app_receive_name").text('Ms.'+response.seeker.first_name+' '+response.seeker.last_name);
                    }else {
                        $(".app_receive_name").text('Mr.'+response.seeker.first_name+' '+response.seeker.last_name);
                    }
                    $('.app_receive_pic').attr('src',document.location.origin+'/storage/seeker/profile/'+response.seeker.id+'/'+response.seeker.image);
                    if(response.seeker.address_detail) {
                        $("#app_receive_address").text(response.seeker.address_detail);
                    }
                    if(response.seeker.phone) {
                        $("#app_receive_phone").text(response.seeker.phone);
                    }
                    
                    $("#app_receive_email").text(response.seeker.email);
                    $(".app_receive_dob").text(moment(response.seeker.date_of_birth).format("DD/MM/YYYY"));
                    if(response.seeker.nrc) {
                        $(".app_receive_nrc").text(response.seeker.nrc);
                    }else {
                        $(".app_receive_nrc").text(response.seeker.id_card);
                    }
                    $(".app_receive_nationality").text(response.seeker.nationality);
                    $(".app_receive_gender").text(response.seeker.gender);
                    $(".app_receive_marital_status").text(response.seeker.marital_status);
                    $(".app_receive_expected_salary").text((Number(response.seeker.preferred_salary)).toLocaleString()+' MMK');
                    if(response.seeker.summary) {
                        $(".app_receive_career_des").text(response.seeker.summary)
                    }
                    if(response.educations) {
                        $(response.educations).each(function(edu_index, edu_value){
                            $('.app_receive_education').append('<div class="my-3"><p><h4>'+edu_value.location+'</h4></p><p><h4 class="d-inline-block">'+edu_value.degree+'</h4> - '+edu_value.major_subject+'</p><p>'+edu_value.from+' to '+edu_value.to+'</p></div><hr>')
                        })
                    }
                    if(response.experiences) {
                        $(response.experiences).each(function(exp_index, exp_value) {
                            if(exp_value.is_experience == 0) {
                                $('.app_receive_experience').append('<div class="my-3">No Experience</div>')
                            }else {
                                $('.app_receive_experience').append('<div class="my-3"><p>'+exp_value.job_title+'<span class="bg-yellow"> (Position Title)</span></p><p>'+exp_value.company+'<span class="bg-yellow"> (Company)</span></p><p>'+exp_value.industry_name+'<span class="bg-yellow"> (Industry)</span></p><p>'+exp_value.main_functional_area_name+' - '+exp_value.sub_functional_area_name+'<span class="bg-yellow"> (Job Function)</span></p><p>'+exp_value.country+'<span class="bg-yellow"> (Country)</span></p></div><hr>')
                            }
                        })
                    }
                    if(response.skill_main_functional_areas) {
                        $(response.skill_main_functional_areas).each(function(skill_function_index, skill_function_value) {
                            $(".app_receive_skill").append('<h4>'+skill_function_value.main_functional_area_name+'</h4><ul id="skill_'+skill_function_value.main_functional_area_id+'"></ul><hr>')
                            $(response.skills).each(function(skill_index, skill_value) {
                                if(skill_function_value.main_functional_area_id == skill_value.main_functional_area_id) {
                                    $('#skill_'+skill_value.main_functional_area_id).append('<li>'+skill_value.skill_name+'</li>')
                                }
                            })
                        })
                    }
                    if(response.languages) {
                        $(response.languages).each(function(lang_index, lang_value){
                            $('.app_receive_lang').append('<div class="my-3 row"><div class="col-2"><h4>'+lang_value.name+'</h4></div><div class="col-2"><span>'+lang_value.level+'</span></div> </div>')
                        })
                    }
                    if(response.references) {
                        $(response.references).each(function(ref_index, ref_value){
                            $('.app_receive_ref').append('<div class="my-3"><h4>'+ref_value.name+'</h4><p>'+ref_value.position+'</p><p>'+ref_value.company+'</p><p>'+ref_value.contact+'</p> </div><hr>')
                        })
                    }
                })
            }
        })
    }
</script>
@endpush