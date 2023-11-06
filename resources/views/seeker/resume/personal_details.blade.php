<div class="row">
    <div class="col pt-3 profile-img-preview @if(Auth::guard('seeker')->user()->image) @else d-none @endif">
        @if(Auth::guard('seeker')->user()->image)
        <img class="app_receive_pic resume_profile_img img-thumbnail border-0" src="{{ getS3File('seeker/profile/'.Auth::guard('seeker')->user()->id ,Auth::guard('seeker')->user()->image) }}" alt="profile_pic" width="130px" height="130px">
        @else
        <img src="https://placehold.jp/200x200.png" alt="Profile Image" class="img-thumbnail border-0 resume_profile_img" width="130px" height="130px">
        @endif
    </div>
    <div class="col-9 row">
        <div class="name_label @if(Auth::guard('seeker')->user()->first_name || Auth::guard('seeker')->user()->last_name) @else d-none @endif">
            <sapn class="first_name">{{ Auth::guard('seeker')->user()->first_name }}</sapn> <span class="last_name">{{ Auth::guard('seeker')->user()->last_name }}</span>
        </div>
        <div class="row address_detail_label @if(Auth::guard('seeker')->user()->address_detail) @else d-none @endif">
            <div class="col-1"><i class="fa-solid fa-house"></i></div>
            <div class="col"><span class="address_detail">{{ Auth::guard('seeker')->user()->address_detail }}</span></div>
        </div>
        <div class="row phone_label @if(Auth::guard('seeker')->user()->phone) @else d-none @endif">
            <div class="col-1"><i class="fa-solid fa-mobile-screen"></i> </div>
            <div class="col"><span class="phone">{{ Auth::guard('seeker')->user()->phone }}</span></div>
        </div>
        <div class="row email_label">
            @if(Auth::guard('seeker')->user()->email)
            <div class="col-1"><i class="fa-regular fa-envelope"></i></div>
            <div class="col">{{ Auth::guard('seeker')->user()->email }}</div>
            
            @endif
        </div>
        <div class=" summary_label @if(Auth::guard('seeker')->user()->summary) @else d-none @endif">       
            <span class="summary">{!! Auth::guard('seeker')->user()->summary !!}</span>
        </div>
        {{--<div class="row py-0">
            <div class="col-6 fw-bold date_of_birth_label @if(Auth::guard('seeker')->user()->date_of_birth) @else d-none @endif">
                Date Of Birth
            </div>
            <div class="col-6 date_of_birth_label @if(Auth::guard('seeker')->user()->date_of_birth) @else d-none @endif">
                <span class="date_of_birth">{{ Auth::guard('seeker')->user()->date_of_birth }}</span>
            </div>
        </div>

        <div class="row py-0">
            <div class="col-6 fw-bold gender_label @if(Auth::guard('seeker')->user()->gender) @else d-none @endif">
                Gender
            </div>
            <div class="col-6 gender_label @if(Auth::guard('seeker')->user()->gender) @else d-none @endif">
                <span class="gender">{{ Auth::guard('seeker')->user()->gender }}</span>
            </div>
        </div>

        <div class="row py-0">
            <div class="col-6 fw-bold nationality_label @if(Auth::guard('seeker')->user()->nationality) @else d-none @endif">
                Nationality
            </div>
            <div class="col-6 nationality_label @if(Auth::guard('seeker')->user()->nationality) @else d-none @endif">
                <span class="nationality">{{ Auth::guard('seeker')->user()->nationality }}</span>
            </div>
        </div>

        <div class="row py-0">
            <div class="col-6 fw-bold nrc_label @if(Auth::guard('seeker')->user()->nrc) @else d-none @endif">
                NRC
            </div>
            <div class="col-6 nrc_label @if(Auth::guard('seeker')->user()->nrc) @else d-none @endif">
                <span class="nrc">{{ Auth::guard('seeker')->user()->nrc }}</span>
            </div>
        </div>

        <div class="row py-0">
            <div class="col-6 fw-bold id_card_label @if(Auth::guard('seeker')->user()->id_card) @else d-none @endif">
                ID Card
            </div>
            <div class="col-6 id_card_label @if(Auth::guard('seeker')->user()->id_card) @else d-none @endif">
                <span class="id_card">{{ Auth::guard('seeker')->user()->id_card }}</span>
            </div>
        </div>

        <div class="row py-0">
            <div class="col-6 fw-bold country_label @if(Auth::guard('seeker')->user()->country) @else d-none @endif">
                Country
            </div>
            <div class="col-6 country_label @if(Auth::guard('seeker')->user()->country) @else d-none @endif">
                <span class="country">{{ Auth::guard('seeker')->user()->country }}</span>
            </div>
        </div>

        <div class="row py-0">
            <div class="col-6 fw-bold state_label @if(Auth::guard('seeker')->user()->state) @else d-none @endif">
                State
            </div>
            <div class="col-6 state_label @if(Auth::guard('seeker')->user()->state) @else d-none @endif">
                <span class="state">{{ Auth::guard('seeker')->user()->state }}</span>
            </div>
        </div>

        <div class="row py-0">
            <div class="col-6 fw-bold township_label @if(Auth::guard('seeker')->user()->township) @else d-none @endif">
                Township
            </div>
            <div class="col-6 township_label @if(Auth::guard('seeker')->user()->township) @else d-none @endif">
                <span class="township">{{ Auth::guard('seeker')->user()->township }}</span>
            </div>
        </div>

        <div class="row py-0">
            <div class="col-6 fw-bold marital_status_label @if(Auth::guard('seeker')->user()->marital_status) @else d-none @endif">
                Marital Status 
            </div>
            <div class="col-6 marital_status_label @if(Auth::guard('seeker')->user()->marital_status) @else d-none @endif">
                <span class="marital_status">{{ Auth::guard('seeker')->user()->marital_status }}</span>
            </div>
        </div>--}}
    </div>
    
</div>