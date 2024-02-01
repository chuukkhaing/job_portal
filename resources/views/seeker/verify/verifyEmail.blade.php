<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation</title>
    <style>
        .verify-template{
            width: 700px
        }
        .middle-image {
            height: 150px
        }
        .activate-title {
            padding-top: 275px;
        }
        @media (max-width: 425px) {
            .verify-template{
                width: 450px;
                font-size: 8px;
            }
            .middle-image {
                height: 100px
            }
            .activate-title {
                padding-top: 250px;
            }
        }
    </style>
</head>
    <body>
        <div style="margin: auto;" class="verify-template">
            <table style="background-image: url({{ asset('/img/background/EMAIL_ACTIVATE_Recovered.jpg') }}); background-position: center; background-repeat: no-repeat; background-size: cover; ">
                <tbody style="text-align: center;">
                    <tr class="activate-title">
                        <h2 style="font-weight: 900; color: #0355D0">ACTIVATE</h2>
                        <h4>Your Infinity Careers Account</h4>
                    </tr>
                    <tr>
                        <p style="color: #0355D0; font-weight: 600;">Hi {{ $seeker->email }},</p>
                        <p style="color: #0355D0; font-weight: 600;">Welcome to Infinity Careers - Where Opportunities Await!</p>
                        <p style="color: #0355D0; font-weight: 600;">To start your job search journey, simply click <br> the button below to activate your account:</p>
                    </tr>
                    <tr style="margin: 20px 0;">
                        <tr style="background-image: url({{ asset('/img/background/a.png') }}); background-size: contain; background-repeat: no-repeat; background-position: center;" class="middle-image">
                        </tr>
                    </tr>
                    <tr style="margin: 20px 0;">
                        <a href="{{ route('seeker-verify',$seeker->email_verification_token) }}" style="text-decoration: none; padding: 10px 50px; background: #0355D0; color: #FFD200; border-radius: 50px; box-shadow: 5px 5px 10px 0px rgba(0,0,0,0.2); font-weight: bold;">Activate</a>
                    </tr>
                    <tr style="margin: 20px 0;">
                        <p style="color: #0355D0; font-weight: 600;">With Infinity Careers, you'll discover exciting job opportunities and resources <br> to boost your career. We're here to help you succeed.</p>
                        <p style="color: #0355D0; font-weight: 600;">If you have any questions, our support team is ready to assist you.</p>
                    </tr>
                    
                    <tr style="margin: 20px 0;">
                        <p style="color: #fff; font-weight: 600;">Thanks for choosing us!</p>
                        <a href="https://www.facebook.com/infinitycareersmyanmar2021"><img src="{{ asset('/img/icon/facebook.png') }}" alt="" style="width: 25px;"></a>
                        <a href="https://invite.viber.com/?g2=AQBfOlaPXsJ6208t76pHaWT%2FqlOO%2BD4G6B9nQbRfU2UrK1C4KRstKkWJGBTjsffm"><img src="{{ asset('/img/icon/viber.png') }}" alt="" style="width: 25px;"></a>
                        <a href="https://t.me/+I1qnIWndCSZjNjY1"><img src="{{ asset('/img/icon/telegram.png') }}" alt="" style="width: 25px;"></a>
                        <a href="https://www.linkedin.com/company/infinitycareersmyanmar/"><img src="{{ asset('/img/icon/icon_Linkedin.png') }}" alt="" style="width: 25px;"></a>
                        <p style="color: #fff; font-weight: 600;">Best Regards,</p>
                        <p style="color: #fff; font-weight: 600;">The Infinity Careers Team</p>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>