<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Download|Generate Cv</title>

    <!-- Customized Bootstrap Stylesheet -->
    
    
    <!-- Template Stylesheet -->
    
    <style>
        @page {
            margin: 65px 20px 50px 20px;
        }

        @font-face {
            font-family: 'Agency FB';
            src: url("{{ asset('fonts/agencyfb_reg.ttf') }}");
        }
        
        .page-header {
            position: fixed;
            top: -65px;
            width: 100%;
            margin: auto;
            
        }

        .page-footer {
            position: fixed;
            bottom: -50px;
            width: 100%;
            
        }

        .footer-text {
            text-align: center;
        }

        .logo {
            width: 150px;
            float: right;
        }

        .page {
            page-break-after: always;
            position: relative;
            counter-increment: page;
            border: 2px solid #0563c1;
            border-radius: 20px;
            padding: 30px;
        }

        .page table {

        }

        .name {
            text-transform: uppercase;
            font-family: 'Agency FB', sans-serif;
            color: #0563C1;
            font-size: 1.5rem;
        }

        .page-counter {
            font-weight: 600;
        }

        .page-counter:after {
            content: " - (" counter(page) ")";
        }
        .d-none {
            display: none;
        }
        
    </style>
</head>
<body>
    <div class="page-header">
        <!--Company Logo-->
        <div class="logo">
            <img class="" src="{{ public_path('/img/logo/ic-logo.png') }}" alt="IC Logo" width="150">
        </div>
    </div>

    <div class="page-footer">
        <p class="footer-text">© infinitycareers.com.mm</p>
    </div>
    <div class="page">
        <table>
            <tr>
                <td class="" style="vertical-align: top">
                    @if($seeker->image)
                    <img class="app_receive_pic resume_profile_img img-thumbnail border-0" src="{{ getS3File('seeker/profile/'.$seeker->id ,$seeker->image) }}" alt="profile_pic" width="150px" height="150px">
                    @else
                    <img src="https://placehold.jp/200x200.png" alt="Profile Image" class="img-thumbnail border-0 resume_profile_img" width="150px" height="150px">
                    @endif
                </td>
                <td class="">
                    <sapn class="name">{{ $seeker->first_name }} {{ $seeker->last_name }} {{ asset('fonts/agencyfb_reg.ttf') }} </sapn>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>