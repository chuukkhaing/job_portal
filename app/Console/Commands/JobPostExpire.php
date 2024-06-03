<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employer\JobPost;
use App\Mail\JobPostExpireMail;

class JobPostExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job_posts:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire the job posts.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expire_jobposts = JobPost::whereDate('expired_at','<',date('Y-m-d', strtotime(now().'+7 day')))->where('status','!=','Expire')->get();
        foreach($expire_jobposts as $jobpost) {
            \Mail::to($jobpost->Employer->mail)->send(new JobPostExpireMail($jobpost));
            $this->info($jobpost->status);
        }
    }
}
