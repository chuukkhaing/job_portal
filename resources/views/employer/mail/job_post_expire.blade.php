<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Job ({{ $job_post->job_title }}) will expire in next 7 Days</title>
    <style>
        .verify-template{
            width: 700px;
            
        }
        
        .table {
            width: 100%;
            background-image: url("{{ asset('/img/background/job_post_expire.jpg') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 150px 50px;
            color: #0067DC;
        }
        a {
            text-decoration: none;
            color: #0067DC;
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
                        <td>Your Job Post, ({{ $job_post->job_title }}), will Expiring Soon on <a href="https://www.inifinitycareers.com.mm">InfinityCareers.com.mm</a></td>
                    </tr>        
                    
                    
                    <tr>
                        <td style="padding: 100px 0px 0px 0px;">Dear {{ $job_post->MainEmployer ? $job_post->MainEmployer->name : $job_post->Employer->name }},</td>
                    </tr>
                    <tr>
                        <td style="padding: 0px 0px 100px 0px;">This is a friendly info that your job posting will expire after one week.</td>
                    </tr>
                    <tr>
                        <td>Job Title:{{ $job_post->job_title }}</td>
                    </tr>
                    <tr>
                        <td>Posted Date:{{ date('d-M-Y', strtotime($job_post->approved_at)) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0px 0px 100px 0px;">Expiration Date:{{ date('d-M-Y', strtotime($job_post->expired_at)) }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">To view or manage your job posting, please click the link</td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 0px 60px 0px; text-align: center;"><a href="{{ env('MAIN_DOMAIN').'/account/employer/manage-job' }}" style="font-weight: bold;
                            background: #0067DC;
                            color: #fff;
                            padding: 10px 15px;
                            border-radius: 25px;">CLICK HERE</a></td>
                    </tr>
                    <tr>
                        <td style="padding: 0px 0px 60px 0px;"><strong>All job listing is set to automatically expire 60 days after it was posted. If you have any questions or need assistance, feel free  to conact us.</strong></td>
                    </tr>
                    <tr>
                        <td>Best regards,</td>
                    </tr>
                    <tr>
                        <td>The Infinity Careers Support Team</td>
                    </tr>
                    <tr>
                        <td><a href="http://inifinitycareers.com.mm">inifinitycareers.com.mm</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>