<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Job Application for {{ $jobApply->JobPost->job_title }}</title>
    <style>
        .verify-template{
            width: 700px;
            
        }
        
        .table {
            width: 100%;
            background-image: url("{{ asset('img/background/new_jobs_Recovered.jpg') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 200px 50px;
        }
        @media (max-width: 425px) {
            .verify-template{
                width: 600px;
                font-size: 10px;
            }
            
        }
    </style>
</head>
    <body>
        <div style="margin: auto;" class="verify-template">
            <table class="table">
                <tbody>
                    
                    <tr>
                        <p style="color: #0355D0; font-weight: 600;">Dear {{ $jobApply->JobPost->recruiter_name ?? '' }},</p>
                        <p style="color: #0355D0; font-weight: 600;">We inform you that a new job application has been submitted for the following position through Infinity Careers.</p>
                        <p style="color: #0355D0; font-weight: 600;">
                            Applicant Name : {{ $jobApply->Seeker->first_name }} {{ $jobApply->Seeker->last_name }}
                            <br>
                            Job Title : {{ $jobApply->JobPost->job_title }}
                            <br>
                            Application Date: {{ date('d-m-Y', strtotime($jobApply->created_at)) }}
                        </p>
                    </tr>
                    
                    
                    <tr style="margin: 20px 0;">
                        <p style="color: #0355D0; font-weight: 600;">We recommend reviewing the candidate's application at your earliest convenience.</p>
                        <p style="color: #0355D0; font-weight: 600;">Thank you for your attention to this matter. We appreciate your dedication to finding the best talent for {{ $jobApply->Employer->name }}.</p>
                    </tr>
                
                </tbody>
            </table>
        </div>
    </body>
</html>