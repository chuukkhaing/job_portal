<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Infinity Careers</title>
    <style>
        .verify-template{
            width: 800px
        }
        .middle-image {
            height: 150px
        }
        .activate-title {
            padding-top: 300px;
        }
        .table {
            width: 100%;
        }
        @media (max-width: 425px) {
            .verify-template{
                
                font-size: 10px;
            }
            .middle-image {
                height: 100px
            }
            .activate-title {
                padding-top: 300px;
            }
        }
    </style>
</head>
    <body>
        <div style="margin: auto;" class="verify-template">
            <table style="background-image: url({{ asset('/img/background/Reset_Password_Recovered.jpg') }}); background-position: center; background-repeat: no-repeat; background-size: cover;" class="table">
                <tbody style="text-align: center;">
                    <tr>
                        <td>
                            <div class="activate-title">
                                <h4>Reset Your Infinity Careers</h4>
                                <h2 style="font-weight: 900; color: #0355D0">Password</h2>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="color: #0355D0; font-weight: 600; margin-left: 600px;">Hi {{ $user_name }},</p>
                            <p style="color: #0355D0; font-weight: 600; margin-left: 400px;">Forgot your password? No worries! We're here to help you get back on track with your <br> Infinity Careers account.</p>
                            <p style="color: #0355D0; font-weight: 600; margin-left: 400px;">To reset your password, simply click the link below:</p>
                        </td>
                    </tr>
                    
                    <tr style="margin: 20px 0;">
                        <td>
                            <a href="{{ $reseturl }}" style="text-decoration: none; padding: 10px 50px; background: #0355D0; color: #FFF; border-radius: 50px; box-shadow: 5px 5px 10px 0px rgba(0,0,0,0.2); font-weight: bold;">Reset Password</a>
                        </td>
                    </tr>
                    <tr style="margin: 20px 0;">
                        <td>
                            <p style="color: #0355D0; font-weight: 600; margin-left: 400px;">If you run into any issues or need further assistance, don't hesitate to reach out to our <br> support team at <a href="mailto:support@infinitycareers.com.mm" style="text-decoration: none">support@infinitycareers.com.mm</a>.</p>
                            <p style="color: #0355D0; font-weight: 600; margin-left: 400px;">We're here to make your job search journey as smooth as possible.</p>
                        </td>
                    </tr>
                    
                    <tr style="margin: 20px 0;">
                        <td>
                            <p style="color: #0355D0; font-weight: 600; margin-left: 600px;">Best Regards,</p>
                            <p style="color: #0355D0; font-weight: 600; margin-left: 600px;">The Infinity Careers Team</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>