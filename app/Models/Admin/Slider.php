<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Employer;

class Slider extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }
}
