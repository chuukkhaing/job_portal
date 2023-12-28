<?php

namespace App\Models\Seeker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employer\JobPostQuestion;

class SeekerJobPostAnswer extends Model
{
    use HasFactory;

    protected $guarded = [];

    function JobPostQuestion()
    {
        return $this->belongsTo(JobPostQuestion::class, 'job_post_question_id', 'id');
    }
}
