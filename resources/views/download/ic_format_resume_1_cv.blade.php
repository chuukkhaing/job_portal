<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Download|Generate Cv</title>

    <!-- Customized Bootstrap Stylesheet -->
    
    
    <!-- Template Stylesheet -->
    
    <style>
        @page {
            margin: 65px 20px 50px 20px;
        }

        @font-face {
            font-family: 'Agency FB';
            src: url({{ public_path('/fonts/agencyfb_reg.ttf') }});
            font-weight: 400;
        }

        @font-face {
            font-family: 'Gill Sans';
            src: url({{ public_path('/fonts/Gill Sans Medium.otf') }});
            font-weight: 400;
        }
        
        body {
            border: 2px solid #0563c1;
            border-radius: 20px;
            padding-top: 65px
        }

        .page-header {
            position: fixed;
            top: -65px;
            width: 100%;
            margin: auto;
            
        }

        .page-footer {
            position: fixed;
            bottom: -50px;
            width: 100%;
            
        }

        .footer-text {
            text-align: center;
        }

        .logo {
            width: 150px;
            float: right;
        }

        strong {
            font-weight: bold
        }

        .exp_job_title {
            text-transform: uppercase;
            font-family: 'Agency FB', sans-serif;
            color: #0563C1;
            font-size: 1.5rem;
        }

        .exp_company {
            text-transform: uppercase;
            font-family: 'Agency FB', sans-serif;
            color: #0563C1;
            font-size: 1.5rem;
            font-weight: 400
        }

        .page {
            position: relative;
            counter-increment: page;
            padding: 0px 30px;
            top: -50px;
        }

        .name {
            text-transform: uppercase;
            font-family: 'Agency FB', sans-serif;
            color: #0563C1;
            font-size: 3.5rem;
            padding: 0;
            margin: 0
        }

        .resume-title {
            text-transform: uppercase;
            font-family: 'Agency FB', sans-serif;
            color: #0563C1;
            font-size: 2rem;
            font-weight: 400;
            margin: 0
        }

        .info {
            font-family: 'Gill Sans', sans-serif;
            color: #0563C1;
            font-size: 1rem;
        }

        .skill_name {
            font-family: 'Gill Sans', sans-serif;
        }

        .exp-date {
            text-transform: uppercase;
            font-family: 'Agency FB', sans-serif;
            color: #0563C1;
            font-size: 1rem;
            font-weight: 400
        }

        .page-counter {
            font-weight: 600;
        }

        .page-counter:after {
            content: " - (" counter(page) ")";
        }

        .sub_table td {
            padding: 3px;
        }
        
        .sub_table {
            margin: 0;
        }

        h2, h3 {
            margin: 0;
            padding: 0
        }

        .ref_name {
            font-family: 'Gill Sans', sans-serif;
            color: #0563C1;
            display: inline-block;
            font-size: 1.5rem;
            font-weight: 400
        }

        .ref_position {
            font-family: 'Gill Sans', sans-serif;
            color: #0563C1;
            display: inline-block;
            font-size: 1.2rem;
            font-weight: 400
        }

        .ref_info {
            font-family: 'Gill Sans', sans-serif;
            font-size: 1rem;
            font-weight: 400
        }

        table {
            border-collapse: collapse;
			width: 100%;
			margin-top: 30px;
			page-break-inside: auto;
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
    <div class="page">
        <div>
            <div class="" style="display: inline-block; width: 20%; vertical-align: top; padding: 0; margin: 0;">
                @if($seeker->image)
                <img class="" src="{{ getS3File('seeker/profile/'.$seeker->id ,$seeker->image) }}" alt="profile_pic" width="150px" height="150px">
                @else
                <img src="https://placehold.jp/200x200.png" alt="Profile Image" class="" width="150px" height="150px">
                @endif
            </div>
            <div class="main_table_inner" style="width: 70%; display: inline-block; padding: 0 30px; margin: 0; vertical-align: top;">
                @if(isset($seeker->first_name ) && isset($seeker->last_name))
                <h1 class="name">{{ $seeker->first_name }} {{ $seeker->last_name }}</h1>
                @endif
                <table class="sub_table">
                    @if(isset($seeker->address_detail))
                    <tr>
                        <td style="vertical-align: top">
                            <img src="{{ public_path('img/pdf/home.png') }}" alt="" width= "23">
                        </td>
                        <td>
                            <span class="info">{{ $seeker->address_detail }}</span>
                        </td>
                    </tr>
                    @endif
                    @if(isset($seeker->phone))
                    <tr>
                        <td style="vertical-align: top">
                            <img src="{{ public_path('img/pdf/phone.png') }}" alt="" width= "23">
                        </td>
                        <td>
                            <span class="info">{{ $seeker->phone }}</span>
                        </td>
                    </tr>
                    @endif
                    @if(isset($seeker->email))
                    <tr>
                        <td style="vertical-align: top">
                            <img src="{{ public_path('img/pdf/email.png') }}" alt="" width= "23">
                        </td>
                        <td>
                            <span class="info">{{ $seeker->email }}</span>
                        </td>
                    </tr>
                    @endif
                </table>
                @if(isset($seeker->summary))
                <p style="padding: 0; margin: 0">{!! $seeker->summary !!}</p>
                @endif
            </div>
        </div>

        <!-- Experience  -->
        <h4 class="resume-title" style="padding: 0; margin: 0">Experiences</h4>
        @if($seeker->SeekerExperience->count() > 0)
            @foreach($seeker->SeekerExperience as $experience)
                @if($experience->is_experience == 0)
                    <p>No Experience</p>
                @else
                <div class="main_table">
                    <div>
                        <div style="vertical-align: top; width: 20%; display: inline-block;">
                            @if(isset($experience->start_date))
                            <h3 class="exp-date" style="padding-top: 8px">{{ date('M Y', strtotime($experience->start_date)) }} - 
                            @if($experience->is_current_job == 1)
                            Present
                            @else
                            {{ date('M Y', strtotime($experience->end_date)) }}
                            @endif
                            </h3>
                            @endif
                        </div>
                        <div style="vertical-align: top; width: 5%; display: inline-block; padding-top: 13px;">
                            <img src="{{ public_path('img/pdf/circle.png') }}" alt="" width= "13">
                        </div>
                        <div  style="vertical-align: top; width: 65%; display: inline-block; margin-top: -35px; margin-left: 28%">
                            <h2>@if(isset($experience->job_title))<span class="exp_job_title">{{ $experience->job_title }}</span> <span class="exp_company"><span style="color: #000"> | @endif @if(isset($experience->company)) </span> {{ $experience->company }}</span> @endif</h2>
                            @if(isset($experience->job_responsibility))
                            {!! $experience->job_responsibility !!}
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        @else
        <p>-</p>
        @endif

        <!-- Education  -->
        <h4 class="resume-title" style="">Education</h4>
        @if($seeker->SeekerEducation->count() > 0)
            @foreach($seeker->SeekerEducation as $education)
                
                <table class="" style="line-height: 25px">
                    <tr style="">
                        <td style="vertical-align: top; width: 20%; ">
                            @if(isset($education->from))
                            <h3 class="exp-date" style="">{{ date('M Y', strtotime($education->from)) }} - 
                            @if($education->is_current == 1)
                            Present
                            @else
                            {{ date('M Y', strtotime($education->to)) }}
                            @endif
                            @endif
                            </h3>
                        </td>
                        <td style="vertical-align: top; width: 5%; padding-top: 13px">
                            <img src="{{ public_path('img/pdf/circle.png') }}" alt="" width= "13">
                        </td>
                        <td style=" width: 65%;  padding-top: 8px">
                            <h2>
                                @if(isset($education->degree) && isset($education->major_subject))
                                <span class="exp_job_title"> 
                                    @if(isset($education->degree)) {{ $education->degree }} IN @endif @if(isset($education->major_subject)) {{ $education->major_subject }} @endif
                                <span style="color: #000; font-weight: 400">|</span></span> 
                                @endif 
                                <span class="exp_company">
                                @if(isset($education->school)) {{ $education->school }}<span style="color: #000"> |</span>@endif 
                                @if(isset($education->location)) {{ $education->location }} @endif
                                </span>
                            </h2>
                        </td>
                    </tr>
                </table>
                
            @endforeach
        @else
        <p>-</p>
        @endif

        <!-- Skill  -->
        <h4 class="resume-title" style="">Skills</h4>
        @if($seeker->SeekerSkill->count() > 0)
            <div style="padding: 30px 0;">
            @foreach($seeker->SeekerSkill as $skill)
            @if(isset($skill->Skill))
            <div class="col" style="width: 45%; display: inline-block;">
                <img src="{{ public_path('img/pdf/circle.png') }}" alt="" width= "13" style=" width: 5%; display: inline-block">
                <span class="" style="display: inline-block; padding: 15px 0 0 0;">{{ $skill->Skill->name }}</span>
            </div>
            @endif
            @endforeach
            </div>
        @else
        <p>-</p>
        @endif
        
        <!-- Language -->
        <h4 class="resume-title" style="">Languages</h4>
        @if($seeker->SeekerLanguage->count() > 0)
            
            <div class="main_table" style="padding: 20px 0">
                @foreach($seeker->SeekerLanguage as $language)
                @if(isset($language->name) && isset($language->level))
                <div class="col">
                    <div style=" width: 5%; display: inline-block">
                        <img src="{{ public_path('img/pdf/circle.png') }}" alt="" width= "13">
                    </div>
                    <div class="" style=" width: 25%; display: inline-block;">{{ $language->name ?? '-' }}</div>
                    <div style=" width: 5%; display: inline-block">-</div>
                    <div class="" style=" width: 25%; display: inline-block;">{{ $language->level ?? '-' }}</div>
                </div>
                @endif
                @endforeach
            </div>
            
        @else
        <p>-</p>
        @endif

        <!-- Reference -->
        <h4 class="resume-title" style="">References</h4>
        @if($seeker->SeekerReference->count() > 0)
            @foreach($seeker->SeekerReference as $reference)
            <table class="" style="padding: 15px 0">
                <tr>
                    <td style="vertical-align: top; width: 20%">
                        <img src="{{ public_path('img/pdf/circle.png') }}" alt="" width= "13" style="padding-top: 13px">
                    </td>
                    <td>
                        @if(isset($reference->name) && isset($reference->position))
                        @if(isset($reference->name))
                        <h2 class="ref_name">{{ $reference->name }}</h2>
                        @endif
                        @if(isset($reference->position))
                        <h3 class="ref_position"><span style="color: #000; font-weight: 400">|</span> {{ $reference->position }}</h3>
                        @endif
                        @endif
                    </td>
                </tr>
                @if(isset($reference->company))
                <tr>
                    <td></td>
                    <td class="ref_info">@if(isset($reference->company))
                        <span>{{ $reference->company }}</span>
                        @endif
                    </td>
                </tr>
                @endif
                @if(isset($reference->contact))
                <tr>
                    <td></td>
                    <td class="ref_info">@if(isset($reference->contact))
                        <span>{{ $reference->contact }}</span>
                        @endif
                    </td>
                </tr>
                @endif
            </table>
            @endforeach
        @else
        <p>-</p>
        @endif
    </div>
</body>
</html>