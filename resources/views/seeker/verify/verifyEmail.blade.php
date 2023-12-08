<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-image : url({{public_path('/img/background/email_bg.png')}}); background-position: center; background-repeat: no-repeat; background-size: contain;">
    
    <div class="container" style="width: 100%; margin: auto;">
        <div class="row justify-content-center">
            <div class="col-md-8 verify-email m-auto" style="text-align: center; padding: 80px 0;">
                <div class="card">
                    <div class="card-header">
                        <div>
                            
                        </div>
                        <h2 style="font-weight: 900; color: #0355D0">ACTIVATE</h2>
                        <h4>Your Infinity Careers Account</h4>
                    </div>
                    <div class="card-body">
                        <p style="color: #0355D0; font-weight: 600;">Hi {{ $seeker->email }},</p>
                        <p style="color: #0355D0; font-weight: 600;">Welcome to Infinity Careers - Where Opportunities Await!</p>
                        <p style="color: #0355D0; font-weight: 600;">To start your job search journey, simply click <br> the button below to activate your account:</p>

                        <div style="text-align: center;">
                            
                        </div>
                        
                        <div style="margin: 20px 0;">
                            <a href="{{ route('seeker-verify',$seeker->email_verification_token) }}" style="text-decoration: none; padding: 10px 50px; background: #0355D0; color: #FFD200; border-radius: 50px; box-shadow: 5px 5px 10px 0px rgba(0,0,0,0.2); font-weight: bold;">Activate</a>
                        </div>
                        <p style="color: #0355D0; font-weight: 600;">With Infinity Careers, you'll discover exciting job opportunities and resources <br> to boost your career. We're here to help you succeed.</p>
                        <p style="color: #0355D0; font-weight: 600;">If you have any questions, our support team is ready to assist you.</p>
                    </div>
                    <div>
                        <p style="color: #0355D0; font-weight: 600;">Thanks for choosing us!</p>
                    </div>
                    <div class="card-footer" style="position: absolute; left: 45%;">
                        
                        <p style="color: #fff; font-weight: 600;">Best Regards,</p>
                        <p style="color: #fff; font-weight: 600;">The Infinity Careers Team</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>