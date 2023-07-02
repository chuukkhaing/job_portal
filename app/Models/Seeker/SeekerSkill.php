<?php

namespace App\Models\Seeker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Skill;

class SeekerSkill extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function MainFunctinalArea()
    {
        return $this->belongsTo(FunctionalArea::class, 'main_functional_area_id', 'id');
    }

    public function Skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id', 'id');
    }
}
