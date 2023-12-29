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
            src: url({{ storage_path('fonts/agencyfb_reg.ttf') }});
            font-weight: 400;
        }

        @font-face {
            font-family: 'Gill Sans';
            src: url({{ storage_path('fonts/Gill Sans Medium.otf') }});
            font-weight: 400;
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
        }

        .main_table td{
            padding: 30px
        }

        .name {
            text-transform: uppercase;
            font-family: 'Agency FB', sans-serif;
            color: #0563C1;
            font-size: 4rem;
        }

        .info {
            font-family: 'Gill Sans', sans-serif;
            color: #0563C1;
            font-size: 1rem;
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

        .sub_table td {
            padding: 3px
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
        <table class="main_table">
            <tr>
                <td class="" style="vertical-align: top">
                    @if($seeker->image)
                    <img class="app_receive_pic resume_profile_img img-thumbnail border-0" src="{{ getS3File('seeker/profile/'.$seeker->id ,$seeker->image) }}" alt="profile_pic" width="150px" height="150px">
                    @else
                    <img src="https://placehold.jp/200x200.png" alt="Profile Image" class="img-thumbnail border-0 resume_profile_img" width="150px" height="150px">
                    @endif
                </td>
                <td>
                    <span class="name">{{ $seeker->first_name }} {{ $seeker->last_name }}</span>
                    <table class="sub_table">
                        @if(isset($seeker->address_detail))
                        <tr>
                            <td>
                                <img src="{{ storage_path('img/home.png') }}" alt="" width= "23">
                            </td>
                            <td>
                                <span class="info">{{ $seeker->address_detail }}</span>
                            </td>
                        </tr>
                        @endif
                        @if(isset($seeker->phone))
                        <tr>
                            <td>
                                <img src="{{ storage_path('img/phone.png') }}" alt="" width= "23">
                            </td>
                            <td>
                                <span class="info">{{ $seeker->phone }}</span>
                            </td>
                        </tr>
                        @endif
                        @if(isset($seeker->email))
                        <tr>
                            <td>
                                <img src="{{ storage_path('img/email.png') }}" alt="" width= "23">
                            </td>
                            <td>
                                <span class="info">{{ $seeker->email }}</span>
                            </td>
                        </tr>
                        @endif
                    </table>
                    {{ $seeker->summary }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>