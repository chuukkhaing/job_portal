<?php

namespace App\Models\Seeker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\State;
use App\Models\Seeker\Seeker;
use App\Models\Admin\FunctionalArea;

class JobAlert extends Model
{
    use HasFactory;

    protected $guarded = [];

    function State()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function FunctionalArea()
    {
        return $this->belongsTo(FunctionalArea::class, 'functional_area_id', 'id');
    }

    public function Seeker()
    {
        return $this->belongsTo(Seeker::class, 'seeker_id', 'id');
    }
}
