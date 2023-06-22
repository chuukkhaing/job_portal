<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $seeker->name }}</p>
            <p>Your account has been created, please activate your account by clicking this link</p>
            <p>
                <a href="{{ route('seeker-verify',$seeker->email_verification_token) }}">
                {{ route('seeker-verify',$seeker->email_verification_token) }}
                </a>
            </p>
        <p>Thanks</p>
    </body>
</html> 