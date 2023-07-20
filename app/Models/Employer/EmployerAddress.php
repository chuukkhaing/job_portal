<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\State;
use App\Models\Admin\Township;

class EmployerAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    function State()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    function Township()
    {
        return $this->belongsTo(Township::class, 'township_id', 'id');
    }
}
