<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Employer;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Admin\Industry;
use App\Models\Admin\FunctionalArea;
use App\Models\Seeker\JobApply;
use App\Models\Employer\JobPostSkill;
use App\Models\Employer\JobPostQuestion;

class JobPost extends Model
{
    use HasFactory;
    protected $guarded = [];

    function Employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }
    function State()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
    function Township()
    {
        return $this->belongsTo(Township::class, 'township_id', 'id');
    }
    function Industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'id');
    }
    function JobApply()
    {
        return $this->hasMany(JobApply::class, 'job_post_id', 'id');
    }
    function JobPostSkill()
    {
        return $this->hasMany(JobPostSkill::class, 'job_post_id', 'id');
    }
    function JobPostQuestion()
    {
        return $this->hasMany(JobPostQuestion::class, 'job_post_id', 'id');
    }
    public function MainFunctinalArea()
    {
        return $this->belongsTo(FunctionalArea::class, 'main_functional_area_id', 'id');
    }
}
