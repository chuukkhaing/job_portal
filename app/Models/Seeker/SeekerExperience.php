<?php

namespace App\Models\seeker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;

class SeekerExperience extends Model
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

    public function Industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'id');
    }
}
