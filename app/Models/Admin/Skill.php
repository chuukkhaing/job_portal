<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\FunctionalArea;

class Skill extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function MainFunctionalArea()
    {
        return $this->belongsTo(FunctionalArea::class, 'main_functional_area_id', 'id');
    }

    public function SubFunctionalArea()
    {
        return $this->belongsTo(FunctionalArea::class, 'sub_functional_area_id', 'id');
    }
}
