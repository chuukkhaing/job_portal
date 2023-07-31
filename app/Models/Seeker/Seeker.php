<?php

namespace App\Models\Seeker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Seeker\SeekerPercentage;
use App\Models\Seeker\SeekerEducation;
use App\Models\Seeker\SeekerExperience;
use App\Models\Seeker\SeekerSkill;
use App\Models\Seeker\SeekerLanguage;
use App\Models\Seeker\SeekerReference;
use App\Models\Seeker\JobApply;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Seeker\SaveJob;

class Seeker extends Authenticatable
{
    use Notifiable;

    protected $guard = 'seeker';
    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function SeekerPercentage()
    {
        return $this->hasMany(SeekerPercentage::class, 'seeker_id', 'id');
    }

    function JobApply()
    {
        return $this->hasMany(JobApply::class, 'seeker_id', 'id');
    }

    function SeekerEducation()
    {
        return $this->hasMany(SeekerEducation::class, 'seeker_id', 'id');
    }

    function SeekerExperience()
    {
        return $this->hasMany(SeekerExperience::class, 'seeker_id', 'id');
    }

    function SeekerSkill()
    {
        return $this->hasMany(SeekerSkill::class, 'seeker_id', 'id');
    }

    function SeekerLanguage()
    {
        return $this->hasMany(SeekerLanguage::class, 'seeker_id', 'id');
    }

    function SeekerReference()
    {
        return $this->hasMany(SeekerReference::class, 'seeker_id', 'id');
    }

    function State()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    function Township()
    {
        return $this->belongsTo(Township::class, 'township_id', 'id');
    }

    function SaveJob()
    {
        return $this->hasMany(SaveJob::class, 'seeker_id', 'id');
    }
}
