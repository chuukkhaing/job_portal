<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Employer;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Admin\Industry;
use App\Models\Seeker\JobApply;

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
}
