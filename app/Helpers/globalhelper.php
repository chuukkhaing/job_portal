<?php

use App\Models\Seeker\JobApply;

function getS3File($location, $file)
{
    $s3 = \Storage::disk('s3');
    $client = $s3->getDriver()->getAdapter()->getClient();
    $expiry = "+10 minutes";

    $command = $client->getCommand('GetObject', [
        'Bucket' => env('AWS_BUCKET'),
        'Key'    => $location . '/' . $file
    ]);

    $request = $client->createPresignedRequest($command, $expiry);
    $url =  (string) $request->getUri();
    
    return $url;
}

function getJobApplyCount($job_post_id)
{
    $job_apply_count = JobApply::whereJobPostId($job_post_id)->count();
    return $job_apply_count;
}