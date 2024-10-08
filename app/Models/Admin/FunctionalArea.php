<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunctionalArea extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function MainFunctionalArea()
    {
        return $this->belongsTo(self::class, 'functional_area_id');
    }

    public function SubFunctionalArea()
    {
        return $this->hasMany(self::class, 'functional_area_id');
    }
}
