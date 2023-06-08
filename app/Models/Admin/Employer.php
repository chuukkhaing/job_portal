<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Package;

class Employer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Package()
    {
        return $this->belongsTo(Package::class);
    }
}
