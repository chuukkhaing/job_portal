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
            margin: 65px 50px 50px 0;
        }

        @font-face {
            font-family: 'Merriweather';
            src: url({{ public_path('/fonts/Merriweather-Regular.ttf') }});
            font-weight: 400;
        }

        @font-face {
            font-family: 'Merriweather Bold';
            src: url({{ public_path('/fonts/Merriweather UltraBold.ttf') }});
            font-weight: bold;
        }

        @font-face {
            font-family: 'Open Sans';
            src: url({{ public_path('/fonts/static/OpenSans_SemiCondensed-Light.ttf') }});
            font-weight: bold;
        }

        @font-face {
            font-family: 'Open Sans Regular';
            src: url({{ public_path('/fonts/static/OpenSans-Regular.ttf') }});
            font-weight: 400;
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
            padding-right: 20px;
        }

        strong {
            font-weight: bold
        }

        body {
            
        }

        .page {
            position: relative;
            counter-increment: page;
            margin: 0;
            padding: 0;
        }

        .column_one {
            float: left;
            width: 40%;
            background-color: rgb(0, 99, 180);
            padding-top: 100px;
            min-height: 88%;
        }

        .column_two {
            float: left;
            width: 56%;
            padding-top: 80px;
            padding-left: 30px;
            background-color: #fff;
            min-height: 88%;
        }

        .row {
            background-color: rgb(0, 99, 180);
            max-height: 100%
        }

        /* Clear floats after the columns */
        
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .name {
            font-family: 'Merriweather';
            text-transform: uppercase;
            font-size: 3rem;
            padding: 0;
            margin: 0;
            font-weight: 400;
        }

        .resume-title {
            font-family: 'Merriweather';
            text-transform: uppercase;
            font-size: 2rem;
            font-weight: 400;
            padding: 0;
            margin: 0;
        }

        .edu_bullet li {
            list-style: none;
        }

        .edu_bullet {
            padding-left: 0;
            margin-left: 0;
        }

        .school_name {
            font-family: 'Open Sans';
            font-size: 1.3rem;
        }

        .degree {
            font-family: 'Open Sans Regular';
            font-size: 1.2rem;
            padding-left: 38px
        }
        .column_one_inner {
            margin-left: 60px;
            margin-right: 20px;
            color: #fff;
        }
        .contact {
            font-family: 'Merriweather Bold';
            font-size: 0.9rem;
            margin-top: 50px
        }

        .contact_info {
            font-size: 0.7rem;
            font-family: 'Merriweather Bold';
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
        <div class="row">
            <div class="column_one" style="">
                <div class="column_one_inner">
                    @if($seeker->image)
                    <img style="border: 1px solid #808080; padding: 5px" src="{{ getS3File('seeker/profile/'.$seeker->id ,$seeker->image) }}" alt="profile_pic" width="130px" height="130px">
                    @else
                    <img src="https://placehold.jp/200x200.png" alt="Profile Image" style="border: 1px solid #808080; padding: 5px" width="130px" height="130px">
                    @endif

                    <!-- Contact Info  -->
                    <h1 class="contact">CONTACT</h1>
                    <table class="contact_info">
                        @if(isset($seeker->address_detail))
                        <tr>
                            <td style="vertical-align: top">
                                <img src="{{ public_path('img/pdf/home_black.png') }}" alt="" width= "18">
                            </td>
                            <td>
                                <span>{{ $seeker->address_detail }}</span>
                            </td>
                        </tr>
                        @endif
                        @if(isset($seeker->phone))
                        <tr>
                            <td style="vertical-align: top">
                                <img src="{{ public_path('img/pdf/phone_black.png') }}" alt="" width= "18">
                            </td>
                            <td>
                                <span>{{ $seeker->phone }}</span>
                            </td>
                        </tr>
                        @endif
                        @if(isset($seeker->email))
                        <tr>
                            <td style="vertical-align: top">
                                <img src="{{ public_path('img/pdf/email_black.png') }}" alt="" width= "18">
                            </td>
                            <td>
                                <span style="word-wrap: break-word;">{{ $seeker->email }}</span>
                            </td>
                        </tr>
                        @endif
                    </table>

                    <!-- Skill  -->
                    <h1 class="contact">SKILLS</h1>
                    @if($seeker->SeekerSkill->count() > 0)
                        @foreach($seeker->SeekerSkill as $skill)
                        <table>
                        @if(isset($skill->Skill))
                        <tr>
                            <td style="vertical-align: top">
                                <img src="{{ public_path('img/pdf/check-mark.png') }}" alt="" width= "13" style="padding-top: 5px">
                            </td>
                            <td>
                                <span class="contact_info">{{ $skill->Skill->name }}</span>
                            </td>
                        </tr>
                        @endif
                        </table>
                        @endforeach
                    @else
                    <p>-</p>
                    @endif

                    <!-- LANGUAGE  -->
                    <h1 class="contact">LANGUAGES</h1>
                    @if($seeker->SeekerLanguage->count() > 0)
            
                        <table>
                            @foreach($seeker->SeekerLanguage as $language)
                            @if(isset($language->name) && isset($language->level))
                            <tr>
                                <td>
                                    <span class="contact_info">{{ $language->name ?? '-' }}</span>
                                </td>
                                <td>
                                    -
                                </td>
                                <td>
                                    <span class="contact_info">{{ $language->level ?? '-' }}</span>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </table>
                        
                    @else
                    <p>-</p>
                    @endif
                </div>
            </div>
            <div class="column_two">
                @if(isset($seeker->first_name ) && isset($seeker->last_name))
                <h1 class="name">{{ $seeker->first_name }} {{ $seeker->last_name }}</h1>
                @endif
                <hr style="height: 1px; border: none; color: #000; background-color: #000">
                @if(isset($seeker->summary))
                <div style="margin-bottom: 40px">
                {!! $seeker->summary !!}
                </div>
                @endif
                <hr style="height: 1px; border: none; color: #000; background-color: #000;">
                <!-- Education  -->
                <h4 class="resume-title">Education</h4>
                @if($seeker->SeekerEducation->count() > 0)
                    @foreach($seeker->SeekerEducation as $education)
                    <ul class="edu_bullet">
                    @if(isset($education->school) && isset($education->from))
                        <li class="school_name">
                            <img src="{{ public_path('/img/pdf/more.png') }}" alt="" style="width: 13px; padding: 0 10px">
                            @if(isset($education->school))
                            {{ $education->school }}
                            @endif
                            @if(isset($education->from))
                            ( {{ date('M Y', strtotime($education->from)) }} - 
                            @if($education->is_current == 1)
                            Present
                            @else
                            {{ date('M Y', strtotime($education->to)) }}
                            @endif
                            )
                            @endif
                        
                        </li>
                    @endif
                    @if(isset($education->degree) && isset($education->major_subject))
                        <li class="degree"> 
                            @if(isset($education->degree)) 
                            {{ $education->degree }} IN 
                            @endif 
                            @if(isset($education->major_subject)) 
                            {{ $education->major_subject }} 
                            @endif
                        </li> 
                    @endif 
                    @if(isset($education->location))
                        <li class="school_name" style="padding-left: 38px">
                        {{ $education->location }}
                        </li>
                    @endif
                    </ul>
                    @endforeach
                @else
                <p>-</p>
                @endif
                <hr style="height: 1px; border: none; color: #000; background-color: #000;">

                <!-- Career History  -->
                <h4 class="resume-title">Career History</h4>
                <div style="margin-bottom: 40px">
                    @if($seeker->SeekerExperience->count() > 0)
                        @foreach($seeker->SeekerExperience as $experience)
                            @if(isset($experience->start_date))
                            <p class="school_name">
                                {{ date('M Y', strtotime($experience->start_date)) }} - 
                                @if($experience->is_current_job == 1)
                                Present
                                @else
                                {{ date('M Y', strtotime($experience->end_date)) }}
                                @endif
                            </p>
                            @endif
                            @if(isset($experience->job_title) && isset($experience->company))
                            <p class="degree" style="padding-left: 0px; padding-bottom: 20px">
                            @if(isset($experience->job_title))
                            {{ $experience->job_title }} <br>
                            @endif
                            @if(isset($experience->company))
                            {{ $experience->company }}
                            @endif
                            </p>
                            @endif
                            @if(isset($experience->job_responsibility))
                            {!! $experience->job_responsibility !!}
                            @endif
                        @endforeach
                    @else
                    <p>-</p>
                    @endif
                </div>
                <hr style="height: 1px; border: none; color: #000; background-color: #000;">

                <!-- References  -->
                <h4 class="resume-title">References</h4>
                <div style="margin-bottom: 40px">
                    @if($seeker->SeekerReference->count() > 0)
                        @foreach($seeker->SeekerReference as $reference)
                        <ul class="edu_bullet">
                        @if(isset($reference->name) && isset($reference->position))
                            <li class="degree" style="padding-left: 0px">
                                <img src="{{ public_path('/img/pdf/send.png') }}" alt="" style="width: 13px; padding: 0 10px">
                                @if(isset($reference->name))
                                {{ $reference->name }} &nbsp; &nbsp; 
                                @endif
                                @if(isset($reference->position))
                                &nbsp; &nbsp; {{ $reference->position }}
                                @endif
                                
                            </li>
                        @endif
                        @if(isset($reference->contact))
                            <li class="degree"> 
                                @if(isset($reference->contact)) 
                                {{ $reference->contact }} 
                                @endif 
                            </li> 
                        @endif 
                        @if(isset($reference->company))
                            <li class="degree"> 
                                @if(isset($reference->company)) 
                                {{ $reference->company }} 
                                @endif 
                            </li> 
                        @endif 
                        </ul> 
                        @endforeach
                    @else
                    <p>-</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>