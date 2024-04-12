@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Your Perfect Opportunities Awaits!') }}</div>

                <div class="card-body">
                    <p>Dear {{ $job_alert->Seeker->first_name }} {{ $job_alert->Seeker->last_name}},</p>
                    <p>Exciting news – we've found the jobs that matches your preferences!</p>
                    <p>At <a href="https://infinitycareers.com.mm">InfinityCareers.com.mm</a>, we're dedicated to helping you discover the perfect career opportunities, and we believe these jobs could be.</p>
                    <div style="width: 700px; margin: 20px 10px">
                        <a style="text-decoration: none" href="{{ route('jobpost-detail', $jobPost->slug) }}">
                            <h3 style="margin: 0;">{{ $jobPost->job_title }}</h3>
                            <div style="width: 80%; position: relative; display: inline-block; vertical-align: top;">
                                <p>{!! \Illuminate\Support\Str::words(strip_tags($jobPost->job_requirement), 25, $end = '...') !!}</p>
                            </div>
                            <div style="width: 15%; text-align: right; display: inline-block">
                                
                                @php 
                                $s3 = Illuminate\Support\Facades\Storage::disk('s3');
                                $client = $s3->getDriver()->getAdapter()->getClient();
                                $expiry = "+10 minutes";
                                if(isset($jobApply->Employer->employer_id)) {
                                    $command = $client->getCommand('GetObject', [
                                        'Bucket' => env('AWS_BUCKET'),
                                        'Key'    => 'employer_logo/' . $jobPost->Employer->MainEmployer->logo
                                    ]);
                                }else {
                                    $command = $client->getCommand('GetObject', [
                                        'Bucket' => env('AWS_BUCKET'),
                                        'Key'    => 'employer_logo/' . $jobPost->Employer->logo
                                    ]);
                                }

                                $request = $client->createPresignedRequest($command, $expiry);
                                $url =  (string) $request->getUri();
                                @endphp
                                
                                <img src="{{ $url }}" alt="Profile Image" style="width: 75px;">
                                
                            </div>
                            <a href="{{ route('jobpost-detail', $jobPost->slug) }}" style="text-decoration: none; padding: 10px 50px; background: #0355D0; color: #FFD200; border-radius: 50px; box-shadow: 5px 5px 10px 0px rgba(0,0,0,0.2); font-weight: bold;">View</a>
                        </a>
                        <hr style="margin: 20px 0;">
                    </div>
                </div>
                <div class="card-footer">
                    <p>Thanks for choosing us!</p>
                    <p>Best Regards,</p>
                    <p>The Infinity Careers Team</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
