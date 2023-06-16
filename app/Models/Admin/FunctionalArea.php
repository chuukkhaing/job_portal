<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunctionalArea extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function MainFunctinalArea()
    {
        return $this->belongsTo(self::class, 'functional_area_id');
    }
}
