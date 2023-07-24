<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Skill;

class JobPostSkill extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id', 'id');
    }
}
