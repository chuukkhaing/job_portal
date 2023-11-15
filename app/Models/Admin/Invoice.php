<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\PointOrder;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    function PointOrder() {
        return $this->belongsTo(PointOrder::class, 'point_order_id', 'id');
    }
}
