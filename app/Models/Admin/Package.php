<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\PackageWithPackageItem;

class Package extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function PackageWithPackageItem()
    {
        return $this->hasMany(PackageWithPackageItem::class);
    }
}
