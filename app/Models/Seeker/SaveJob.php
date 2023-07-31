<?php

namespace App\Models\Seeker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employer\JobPost;

class SaveJob extends Model
{
    use HasFactory;

    protected $guarded = [];

    function JobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id', 'id');
    }
}
