<?php

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