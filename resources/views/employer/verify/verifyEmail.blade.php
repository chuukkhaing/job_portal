<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation</title>
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
            <table style="background-image: url({{ asset('/img/background/EMAIL_ACTIVATE_Recovered.jpg') }}); background-position: center; background-repeat: no-repeat; background-size: cover;" class="table">
                <tbody style="text-align: center;">
                    <tr>
                        <td>
                            <div class="activate-title">
                                <h2 style="font-weight: 900; color: #0355D0">ACTIVATE</h2>
                                <h4>Your Infinity Careers Account</h4>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="color: #0355D0; font-weight: 600;">Dear {{ $employer->name }},</p>
                            <p style="color: #0355D0; font-weight: 600;">Welcome to Infinity Careers - Your Gateway to Top Talent!</p>
                            <p style="color: #0355D0; font-weight: 600;">We're delighted to have you join our platform as an employer. To start connecting with top-tier talent <br> and unlocking the full potential of your account, all you need to do is activate it.</p>
                            <p style="color: #0355D0; font-weight: 600;">Click the button below to activate your employer account:</p>
                        </td>
                    </tr>
                    <tr style="margin: 20px 0;">
                        <td>
                            <div style="background-image: url({{ asset('/img/background/a.png') }}); background-size: contain; background-repeat: no-repeat; background-position: center;" class="middle-image">
                            </div>
                        </td>
                    </tr>
                    <tr style="margin: 20px 0;">
                        <td>
                            <a href="{{ route('employer-verify',$employer->email_verification_token) }}" style="text-decoration: none; padding: 10px 50px; background: #0355D0; color: #FFD200; border-radius: 50px; box-shadow: 5px 5px 10px 0px rgba(0,0,0,0.2); font-weight: bold;">Activate</a>
                        </td>
                    </tr>
                    <tr style="margin: 20px 0;">
                        <td>
                            <p style="color: #0355D0; font-weight: 600;">At Infinity Careers, we're committed to helping your business thrive by connecting you with exceptional talent. <br> Whether you're a small startup or a large corporation, we have the tools and resources to meet your recruitment needs.</p>
                            <p style="color: #0355D0; font-weight: 600;">Should you have any questions or require assistance, our dedicated support team is here to assist you. <br> Feel free to reach out to us at <a style="text-decoration: none" href="mailto:support@infinitycareers.com.mm">support@infinitycareers.com.mm</a>.</p>
                        </td>
                    </tr>
                    
                    <tr style="margin: 20px 0;">
                        <td>
                            <p style="color: #fff; font-weight: 600; padding-top: 50px">Thank you for choosing Infinity Careers. We're excited to support your hiring endeavors!</p>
                            <a href="https://www.facebook.com/infinitycareersmyanmar2021"><img src="{{ asset('/img/icon/facebook.png') }}" alt="" style="width: 25px;"></a>
                            <a href="https://invite.viber.com/?g2=AQBfOlaPXsJ6208t76pHaWT%2FqlOO%2BD4G6B9nQbRfU2UrK1C4KRstKkWJGBTjsffm"><img src="{{ asset('/img/icon/viber.png') }}" alt="" style="width: 25px;"></a>
                            <a href="https://t.me/+I1qnIWndCSZjNjY1"><img src="{{ asset('/img/icon/telegram.png') }}" alt="" style="width: 25px;"></a>
                            <a href="https://www.linkedin.com/company/infinitycareersmyanmar/"><img src="{{ asset('/img/icon/icon_Linkedin.png') }}" alt="" style="width: 25px;"></a>
                            <p style="color: #fff; font-weight: 600;">Best Regards,</p>
                            <p style="color: #fff; font-weight: 600;">The Infinity Careers Team</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>