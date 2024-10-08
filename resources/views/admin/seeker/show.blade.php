@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Seekers</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Seeker Infomation</h6>
            
            <div class="col">
                <a href="{{ route('seeker.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <div class="row card-body">
            <div class="col-7 m-auto">
                <div class="mb-4">
                    
                    <div class="row resume-section mb-3">
                        <h5 class="text-white resume-header py-2"><span>Personal details</span></h5>
                        <table>
                            <tr>
                                <td class="col-9">
                                    <table class="row personal-info">
                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold name_label @if($seeker->first_name && $seeker->last_name) @else d-none @endif">
                                                Name
                                            </td>
                                            <td class="col-6 margin-left py-2 name_label @if($seeker->first_name && $seeker->last_name) @else d-none @endif">
                                                <sapn class="first_name">{{ $seeker->first_name }}</sapn> <span class="last_name">{{ $seeker->last_name }}</span>
                                            </td>
                                        </tr>
                                        
                                        <tr class="row py-0">
                                            @if($seeker->email)
                                            <td class="col-6 py-2 fw-bold">
                                                Email Address
                                            </td>
                                            <td class="col-6 py-2 margin-left">
                                                {{ $seeker->email }}
                                            </td>
                                            @endif
                                        </tr>
                                        
                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold phone_label @if($seeker->phone) @else d-none @endif">
                                                Phone
                                            </td>
                                            <td class="col-6 py-2 margin-left phone_label @if($seeker->phone) @else d-none @endif">
                                                <span class="phone">{{ $seeker->phone }}</span>
                                            </td>
                                        </tr>
                                        
                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold address_detail_label @if($seeker->address_detail) @else d-none @endif">
                                                Address Detail
                                            </td>
                                            <td class="col-6 py-2 margin-left address_detail_label @if($seeker->address_detail) @else d-none @endif">
                                                <span class="address_detail">{{ $seeker->address_detail }}</span>
                                            </td>
                                        </tr>

                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold date_of_birth_label @if($seeker->date_of_birth) @else d-none @endif">
                                                Date Of Birth
                                            </td>
                                            <td class="col-6 py-2 margin-left date_of_birth_label @if($seeker->date_of_birth) @else d-none @endif">
                                                <span class="date_of_birth">{{ $seeker->date_of_birth }}</span>
                                            </td>
                                        </tr>

                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold gender_label @if($seeker->gender) @else d-none @endif">
                                                Gender
                                            </td>
                                            <td class="col-6 py-2 margin-left gender_label @if($seeker->gender) @else d-none @endif">
                                                <span class="gender">{{ $seeker->gender }}</span>
                                            </td>
                                        </tr>

                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold nationality_label @if($seeker->nationality) @else d-none @endif">
                                                Nationality
                                            </td>
                                            <td class="col-6 py-2 margin-left nationality_label @if($seeker->nationality) @else d-none @endif">
                                                <span class="nationality">{{ $seeker->nationality }}</span>
                                            </td>
                                        </tr>

                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold nrc_label @if($seeker->nrc) @else d-none @endif">
                                                NRC
                                            </td>
                                            <td class="col-6 py-2 margin-left nrc_label @if($seeker->nrc) @else d-none @endif">
                                                <span class="nrc">{{ $seeker->nrc }}</span>
                                            </td>
                                        </tr>

                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold id_card_label @if($seeker->id_card) @else d-none @endif">
                                                ID Card
                                            </td>
                                            <td class="col-6 py-2 margin-left id_card_label @if($seeker->id_card) @else d-none @endif">
                                                <span class="id_card">{{ $seeker->id_card }}</span>
                                            </td>
                                        </tr>

                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold country_label @if($seeker->country) @else d-none @endif">
                                                Country
                                            </td>
                                            <td class="col-6 py-2 margin-left country_label @if($seeker->country) @else d-none @endif">
                                                <span class="country">{{ $seeker->country }}</span>
                                            </td>
                                        </tr>

                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold state_label @if($seeker->State) @else d-none @endif">
                                                State
                                            </td>
                                            <td class="col-6 py-2 margin-left state_label @if($seeker->State) @else d-none @endif">
                                                <span class="state">{{ $seeker->State->name ?? '' }}</span>
                                            </td>
                                        </tr>

                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold township_label @if($seeker->Township) @else d-none @endif">
                                                Township
                                            </td>
                                            <td class="col-6 py-2 margin-left township_label @if($seeker->Township) @else d-none @endif">
                                                <span class="township">{{ $seeker->Township->name ?? '' }}</span>
                                            </td>
                                        </tr>

                                        <tr class="row py-0">
                                            <td class="col-6 py-2 fw-bold marital_status_label @if($seeker->marital_status) @else d-none @endif">
                                                Marital Status 
                                            </td>
                                            <td class="col-6 py-2 margin-left marital_status_label @if($seeker->marital_status) @else d-none @endif">
                                                <span class="marital_status">{{ $seeker->marital_status }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="col text-end profile-img-preview @if($seeker->image) @else d-none @endif" style="vertical-align: top">
                                    @if($seeker->image)
                                    <img class="app_receive_pic resume_profile_img img-thumbnail border-0" src="{{ getS3File('seeker/profile/'.$seeker->id ,$seeker->image) }}" alt="profile_pic" width="130px" height="130px">
                                    @else
                                    <img src="https://placehold.jp/200x200.png" alt="Profile Image" class="img-thumbnail border-0 resume_profile_img" width="130px" height="130px">
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="row resume-section mb-3 summary_label @if($seeker->summary) @else d-none @endif">
                        <h5 class="text-white resume-header py-2"><span>Profile Summary</span></h5>
                        <div class="col py-2" style="padding: 0 20px">
                            <span class="summary">{!! $seeker->summary !!}</span>
                        </div>
                    </div>
                    <div class="row resume-section mb-3 experience_label @if($seeker->SeekerExperience->count() == 0) d-none @endif">
                        <h5 class="text-white resume-header py-2"><span>Career History</span></h5>
                        <div class="py-2">
                            <table class="w-100">
                                @foreach($seeker->SeekerExperience as $experience)
                                
                                <tr class="row py-2 exp-resume-{{ $experience->id }}">
                                    @if($experience->is_experience == 0)
                                    <td>No Experience</td>
                                    @else
                                    <td class="col-4 fw-bold" style="vertical-align: top">
                                        <span class="exp-start_date-{{$experience->id}}">{{ date('M Y', strtotime($experience->start_date)) }}</span> - 
                                        @if($experience->is_current_job == 1)
                                        <span class="exp-end_date-{{$experience->id}}">Present</span>
                                        @else
                                        <span class="exp-end_date-{{$experience->id}}">{{ date('M Y', strtotime($experience->end_date)) }}</span>
                                        @endif
                                    </td>
                                    <td class="col-8">
                                        <span class="exp-job_title-{{$experience->id}} fw-bold">{{ $experience->job_title }}</span><br>
                                        <span class="exp-company-{{$experience->id}} text-blue">{{ $experience->company }}</span><br>
                                        <span class="exp-job-responsibility-{{$experience->id}}">{!! $experience->job_responsibility !!}</span>
                                    </td>
                                    @endif
                                </tr>

                                @endforeach
                            </table>
                        </div>
                        
                    </div>
                    <div class="row resume-section mb-3 education_label @if($seeker->SeekerEducation->count() == 0) d-none @endif">
                        <h5 class="text-white resume-header py-2"><span>Education</span></h5>
                        <div class="py-2">
                            <table class="w-100">
                                @foreach($seeker->SeekerEducation as $education)
                                <tr class="row py-2 edu-resume-{{ $education->id }}">
                                    <td class="col-4 fw-bold" style="vertical-align: top">
                                        <span class="edu-from-{{ $education->id }}">{{ $education->from }}</span> - <span class="edu-to-{{ $education->id }}">{{ $education->to }}</span>
                                    </td>
                                    <td class="col-8">
                                        <span class="edu-degree-{{ $education->id }} fw-bold">{{ $education->degree }} (<span class="edu-major_subject-{{ $education->id }}">{{ $education->major_subject }}</span>)</span><br>
                                        <span class="edu-location-{{ $education->id }} text-blue">{{ $education->location }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="row resume-section mb-3 skill_label @if($seeker->SeekerSkill->count() == 0) d-none @endif">
                        <h5 class="text-white resume-header py-2"><span>Skill</span></h5>
                        
                        <div class="row py-2" id="skill_body" style="padding: 0 20px; max-width: 850px;">
                            @foreach($seeker->SeekerSkill as $skill)
                            <div class="col-6 py-2 fw-bold skill-resume-{{ $skill->id }} skill-skill_id-{{$skill->id}}" style="display: inline-block;width: 400px">
                                <img src="{{ asset('img/icon/bookmark.png') }}" alt="" width="16px">
                                <span class="" style="vertical-align: top">{{ $skill->Skill->name }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row resume-section mb-3 language_label @if($seeker->SeekerLanguage->count() == 0) d-none @endif">
                        <h5 class="text-white resume-header py-2"><span>Languages</span></h5>
                        <div class="py-2">
                            <table class="w-75">
                                @foreach($seeker->SeekerLanguage as $language)
                                <tr class="language-resume-{{ $language->id }}">
                                    <td class="col-6 fw-bold">
                                        <span class="language-name-{{$language->id}}">{{ $language->name }}</span>
                                    </td>
                                    <td class="col-6">
                                        <span class="language-level-{{$language->id}}">{{ $language->level }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        
                    </div>
                    <div class="row resume-section mb-3 reference_label @if($seeker->SeekerReference->count() == 0) d-none @endif">
                        <h5 class="text-white resume-header py-2"><span>Reference</span></h5>
                        @foreach($seeker->SeekerReference as $reference)
                        <div class="row py-2 reference-resume-{{ $reference->id }}" style="padding: 0 20px">
                            <p class="reference-name-{{$reference->id}} fw-bold">{{ $reference->name }}</p>
                            <p class="reference-position-{{$reference->id}}">{{ $reference->position }}</p>
                            <p class="reference-company-{{$reference->id}} text-blue">{{ $reference->company }}</p>
                            <p class="reference-contact-{{$reference->id}}">{{ $reference->contact }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection