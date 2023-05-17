<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\State;

class Township extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function State()
    {
        return $this->belongsTo(State::class);
    }
}
