<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>
        <div style="width: 100%;">
            <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-image: url({{ asset('img/background/email_reset_bg.png') }}); background-position: center; background-repeat: no-repeat; background-size: contain;">
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <h4>Reset Your Infinity Careers</h4>
                        <h2 style="font-weight: 900; color: #0355D0">Password</h2>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="color: #0355D0; font-weight: 600; margin-left: 600px;">Hi {{ $first_name }} {{ $last_name }},</p>
                        <p style="color: #0355D0; font-weight: 600; margin-left: 400px;">Forgot your password? No worries! We're here to help you get back on track with your <br> Infinity Careers account.</p>
                        <p style="color: #0355D0; font-weight: 600; margin-left: 400px;">To reset your password, simply click the link below:</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <img src="{{ asset('img/background/reset_lock.png') }}" alt="" style="width: 300px;">
                        <br>
                        <a href="{{ $reseturl }}" style="text-decoration: none; padding: 10px 50px; background: #0355D0; color: #FFF; border-radius: 50px; box-shadow: 5px 5px 10px 0px rgba(0,0,0,0.2); font-weight: bold;">Reset Password</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="color: #0355D0; font-weight: 600; margin-left: 400px;">If you run into any issues or need further assistance, don't hesitate to reach out to our <br> support team at <a href="mailto:support@infinitycareers.com.mm" style="text-decoration: none">support@infinitycareers.com.mm</a>.</p>
                        <p style="color: #0355D0; font-weight: 600; margin-left: 400px;">We're here to make your job search journey as smooth as possible.</p>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <p style="color: #0355D0; font-weight: 600; margin-left: 600px;">Best Regards,</p>
                        <p style="color: #0355D0; font-weight: 600; margin-left: 600px;">The Infinity Careers Team</p>
                    </td>
                </tr>
            </table>
        </div>

    </body>
</html>