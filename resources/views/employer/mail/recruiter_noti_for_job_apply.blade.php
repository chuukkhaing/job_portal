<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="mail_header">
        <h3>New Job Application for {{ $jobApply->JobPost->job_title }}</h3>
    </div>
    <div class="mail_body">
        <p>Dear {{ $jobApply->JobPost->recruiter_name ?? '' }},</p>
        <br>
        <p>We inform you that a new job application has been submitted for the following position through Infinity Careers.</p>
        <br>
        <p>
            Applicant Name : {{ $jobApply->Seeker->first_name }} {{ $jobApply->Seeker->last_name }}
            <br>
            Job Title : {{ $jobApply->JobPost->job_title }}
            <br>
            Application Date: {{ date('d-m-Y', strtotime($jobApply->created_at)) }}
        </p>
        <br>
        <p>
            We recommend reviewing the candidate's application at your earliest convenience.
        </p>
        <br>
        <p>
        Thank you for your attention to this matter. We appreciate your dedication to finding the best talent for {{ $jobApply->Employer->name }}.
        </p>
    </div>
</body>
</html>