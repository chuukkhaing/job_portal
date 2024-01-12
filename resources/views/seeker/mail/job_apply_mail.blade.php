<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="mail_header">
        <h3>Application for {{ $jobApply->JobPost->job_title }} have been Submitted</h3>
    </div>
    <div class="mail_body">
        <p>Dear {{ $jobApply->Seeker->first_name ?? '' }} {{ $jobApply->Seeker->last_name ?? '' }},</p>
        <p>Your application for the {{ $jobApply->JobPost->job_title }} position with @if(isset($jobApply->Employer->employer_id)) {{ $jobApply->Employer->MainEmployer->name }} @else {{ $jobApply->Employer->name }} @endif has been submitted. We appreciate your interest.</p>
        <p>
        we encourage you to keep your profile up-to-date on InfinityCareers.com.mm. A well-maintained profile increases your visibility to potential employers and enhances your job search experience.
        </p>
        <p>
        If you're passionate about roles like [Job Title], explore similar opportunities on our platform. Your next career move could be just a click away.
        </p>

        @foreach($recommended_jobs as $job_post)
        <div style="width: 700px; margin: 20px 10px">
            <a style="text-decoration: none" href="{{ route('jobpost-detail', $job_post->slug) }}')">
                <h3 style="margin: 0;">{{ $job_post->job_title }}</h3>
                <div style="width: 80%; position: relative; display: inline-block; vertical-align: top;">
                    <p>{!! \Illuminate\Support\Str::words(strip_tags($job_post->job_requirement), 25, $end = '...') !!}</p>
                </div>
                <div style="width: 15%; text-align: right; display: inline-block">
                    @if(isset($jobApply->Employer->employer_id))
                    <img src="{{ getS3File('employer_logo',$job_post->Employer->MainEmployer->logo) }}" alt="Profile Image" style="width: 75px;">
                    @else
                    <img src="{{ getS3File('employer_logo',$job_post->Employer->logo) }}" alt="Profile Image" style="width: 75px;">
                    @endif
                </div>
                <a href="{{ route('jobpost-detail', $job_post->slug) }}" style="text-decoration: none; padding: 10px 50px; background: #0355D0; color: #FFD200; border-radius: 50px; box-shadow: 5px 5px 10px 0px rgba(0,0,0,0.2); font-weight: bold;">View</a>
            </a>
            <hr style="margin: 20px 0;">
        </div>
        
        @endforeach
    </div>
</body>
</html>