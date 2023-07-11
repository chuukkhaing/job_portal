<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employer\JobPost;

class Industry extends Model
{
    use HasFactory;

    protected $guarded = [];

    function JobPost()
    {
        return $this->hasMany(JobPost::class, 'industry_id', 'id');
    }
}
