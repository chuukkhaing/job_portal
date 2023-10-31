<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Employer;
use App\Models\Admin\PointPackage;

class PointOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }

    public function PointPackage()
    {
        return $this->belongsTo(PointPackage::class, 'point_package_id', 'id');
    }
}
