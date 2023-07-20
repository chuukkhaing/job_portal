<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Download|Generate Cv</title>
    <style>
        h5 {
            text-decoration: underline;
            color: #0355D0;
            font-weight: 600 !important;
            font-size: 20px;
            margin: 10px 0;
        }
        .float-end {
            float: right;
        }
        .pdf-title {
            font-weight: 600 !important;
            font-size: 18px;
            margin: 0;
            padding: 0
        }
        .container {
            width: 80%;
            margin: auto;
        }
        .row {
            width: 100%;
            
        }
        .col {
            display: inline-block;
            width: 48%;
            margin: 0;
            padding: 0;
        }
        @page {
            margin: 150px 5mm 65px 5mm;
        }
        
        .page-header {
            position: fixed;
            top: -100px;
            width: 90%;
            margin: auto;
            height: 50px;
        }

        .page-footer {
            position: fixed;
            bottom: -50px;
            width: 100%;
            height: 50px;
        }

        .footer-text {
            text-align: center;
        }

        .logo {
            width: 150px;
            float: right;
        }

        .page {
            page-break-after: always;
            position: relative;
            counter-increment: page
        }

        .page-counter {
            font-weight: 600;
        }

        .page-counter:after {
            content: " - (" counter(page) ")";
        }
        
        p {
            font-size: 14px
        }

        hr {
            width: 50%;
            margin-left: 0;
        }
        .col-2 {
            display: inline-block;
            width: 8%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <!--Company Logo-->
        <div class="logo">
            <img class="" src="{{ public_path('/img/logo/ic-logo.png') }}" alt="IC Logo" width="150">
        </div>
    </div>

    <div class="page-footer">
        <p class="footer-text">© infinitycareers.com.mm</p>
    </div>
    <div class="container">
        <div class="mt-4">
            <div class="mb-4">
                
                <div class="row">
                    {{--<div class="col">
                        <p class="app_receive_name">@if($seeker->gender == 'Female') Ms.@else Mr.@endif {{ $seeker->first_name ?? '-' }} {{ $seeker->last_name ?? '-' }}</p>
                        <p id="app_receive_address">@if($seeker->country == 'Myanmar') {{ $seeker->Township->name ?? '' }}, {{ $seeker->State->name ?? '' }}, {{ $seeker->country }}@else Country - {{ $seeker->country }} @endif</p>
                        <p id="app_receive_phone">{{ $seeker->phone ?? '-' }}</p>
                        <p id="app_receive_email">{{ $seeker->email ?? '-' }}</p>
                    </div>--}}
                    <div class="col">
                        @if($seeker->image)
                        <img src="{{ public_path('storage/seeker/profile/'.($seeker->id).'/'.$seeker->image) }}" class="app_receive_pic" alt="profile_pic" width="130px" height="130px">
                        @else
                        <img class="app_receive_pic" src="{{ public_path('img/undraw_profile_1.svg') }}" alt="profile_pic" width="130px" height="130px">
                        @endif
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <h5 class="text-decoration-underline">Personal Information</h5>
                
                {{--<div class="row my-3">
                    <div class="col">
                        <span>Name</span>
                        <span class="float-end">:</span>
                    </div>
                    <div class="col">
                        <span class="app_receive_name">@if($seeker->gender == 'Female') Ms.@else Mr.@endif {{ $seeker->first_name ?? '-' }} {{ $seeker->last_name ?? '-' }}</span>
                    </div>
                </div>--}}
                <div class="row my-3">
                    <div class="col">
                        <span>Date Of Birth</span>
                        <span class="float-end">:</span>
                    </div>
                    <div class="col">
                        <span class="app_receive_dob">@if($seeker->date_of_birth) {{ date('d-m-Y', strtotime($seeker->date_of_birth)) }} @else - @endif</span>
                    </div>
                </div>
                {{--<div class="row my-3">
                    <div class="col">
                        <span>NRC Number/ID</span>
                        <span class="float-end">:</span>
                    </div>
                    <div class="col">
                        <span class="app_receive_nrc">@if($seeker->nationality == 'Myanmar') {{ $seeker->nrc }} @else {{ $seeker->id_card }} @endif</span>
                    </div>
                </div>--}}
                <div class="row my-3">
                    <div class="col">
                        <span>Nationality</span>
                        <span class="float-end">:</span>
                    </div>
                    <div class="col">
                        <span class="app_receive_nationality">{{ $seeker->nationality ?? '-' }}</span>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col">
                        <span>Gender</span>
                        <span class="float-end">:</span>
                    </div>
                    <div class="col">
                        <span class="app_receive_gender">{{ $seeker->gender ?? '-' }}</span>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col">
                        <span>Marital Status</span>
                        <span class="float-end">:</span>
                    </div>
                    <div class="col">
                        <span class="app_receive_marital_status">{{ $seeker->marital_status ?? '-' }}</span>
                    </div>
                </div>
                {{--<div class="row my-3">
                    <div class="col">
                        <span>Address Detail</span>
                        <span class="float-end">:</span>
                    </div>
                    <div class="col">
                        <span id="app_receive_address_detail">{{ $seeker->address_detail ?? '-' }}</span>
                    </div>
                </div>--}}
                <div class="row my-3">
                    <div class="col">
                        <span style="font-weight: bold">Notice Period</span>
                        <span style="font-weight: bold" class="float-end">:</span>
                    </div>
                    <div class="col">
                        <span style="font-weight: bold" class="app_receive_notice_period">@if($seeker->is_immediate_available == 1) Immediate Available @else - @endif</span>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col">
                        <span style="font-weight: bold">Expected Salary</span>
                        <span style="font-weight: bold" class="float-end">:</span>
                    </div>
                    <div class="col">
                        <span style="font-weight: bold" class="app_receive_expected_salary">{{ number_format($seeker->preferred_salary) ?? '-' }} MMK</span>
                    </div>
                </div>
            </div>
            @if($seeker->summary)
            <div class="mb-4">
                <h5 class="text-decoration-underline">Career Description</h5>
                <ul><li>{!! rtrim(str_replace(".",".</li><li>","$seeker->summary"), '</li><li>') !!}</li></ul>
            </div>
            @endif
            @if($seeker->SeekerEducation->count() > 0)
            <div class="mb-4">
                <h5 class="text-decoration-underline">Education</h5>
                <div class="app_receive_education">
                    @foreach($seeker->SeekerEducation as $edu)
                    <p class="pdf-title">{{ $edu->location }}</p>
                    <p><span class="pdf-title">{{ $edu->degree }} </span> - {{ $edu->major_subject }}</p>
                    <p>{{ $edu->from }} to {{ $edu->to }}</p>
                    <hr>
                    @endforeach
                </div>
            </div>
            @endif
            @if($seeker->SeekerExperience->count() > 0)
            <div class="mb-4">
                <h5 class="text-decoration-underline">Career History</h5>
                <div class="app_receive_experience">
                    @foreach($seeker->SeekerExperience as $exp)
                    @if($exp->is_experience == 0)
                    No Experience
                    @else
                        <p style="font-weight: bold">{{ $exp->job_title }}</p>
                        <p>{{ $exp->Industry->name }}</p>
                        <p>{{ date('Y M', strtotime($exp->start_date)) }} to @if($exp->is_current_job == 1) Present @else {{ date('Y M', strtotime($exp->end_date)) }} @endif</p>
                        <p style="font-weight: bold">{{ $exp->company }}</p>
                        <p>{{ $exp->MainFunctinalArea->name }} - {{ $exp->SubFunctinalArea->name }}</p>
                        <p>{{ $exp->country }}</p>
                        @if($exp->job_responsibility)
                        <div>
                            <h4>Job Responsibility</h4>
                            <ul><li>{!! rtrim(str_replace(".",".</li><li>","$exp->job_responsibility"), '</li><li>') !!}</li></ul>
                        </div>
                        @endif
                        <hr>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
            @if($seeker->SeekerSkill->count() > 0)
            <div class="mb-4">
                <h5 class="text-decoration-underline">Skill</h5>
                <div class="app_receive_skill">
                    @foreach($skill_main_functional_areas as $skill_function)
                    <p class="pdf-title">{{ $skill_function->main_functional_area_name }}</p>
                    <ul>
                        @foreach($seeker->SeekerSkill as $skill)
                            @if($skill->main_functional_area_id == $skill_function->main_functional_area_id)
                            <li>{{ $skill->Skill->name }}</li>
                            @endif
                        @endforeach
                    </ul>
                    @endforeach
                </div>
            </div>
            @endif
            @if($seeker->SeekerLanguage->count() > 0)
            <div class="mb-4">
                <h5 class="text-decoration-underline">Language</h5>
                <div class="app_receive_lang">
                    @foreach($seeker->SeekerLanguage as $lang)
                    <div class="row">
                        <div class="col-2">
                            <p class="pdf-title">{{ $lang->name }}</p>
                        </div>
                        <div class="col-2">
                            <span>{{ $lang->level }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @if($seeker->SeekerReference->count() > 0)
            <div class="mb-4">
                <h5 class="text-decoration-underline">Reference</h5>
                <div class="app_receive_ref">
                    @foreach($seeker->SeekerReference as $ref)
                    <p class="pdf-title">{{ $ref->name }}</p>
                    <p>{{ $ref->position }}</p>
                    <p>{{ $ref->company }}</p>
                    <p>{{ $ref->contact }}</p>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>