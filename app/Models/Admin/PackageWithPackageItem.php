<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\PackageItem;

class PackageWithPackageItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function PackageItem()
    {
        return $this->belongsTo(PackageItem::class, 'package_item_id', 'id');
    }
}
