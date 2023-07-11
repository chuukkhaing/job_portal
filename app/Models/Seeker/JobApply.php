<?php

namespace App\Models\Seeker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Employer;
use App\Models\Seeker\Seeker;
use App\Models\Employer\JobPost;

class JobApply extends Model
{
    use HasFactory;

    protected $guarded = [];

    function Employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }

    function Seeker()
    {
        return $this->belongsTo(Seeker::class, 'seeker_id', 'id');
    }

    function JobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id', 'id');
    }
}
