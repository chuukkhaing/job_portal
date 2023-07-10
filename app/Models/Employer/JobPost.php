<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Employer;

class JobPost extends Model
{
    use HasFactory;
    protected $guarded = [];

    function Employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }
}
