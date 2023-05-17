<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Township;

class State extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Township()
    {
        return $this->hasMany(Township::class);
    }
}
