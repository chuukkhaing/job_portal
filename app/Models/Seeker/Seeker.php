<?php

namespace App\Models\Seeker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Seeker\SeekerPercentage;

class Seeker extends Authenticatable
{
    use Notifiable;

    protected $guard = 'seeker';
    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function SeekerPercentage()
    {
        return $this->hasMany(SeekerPercentage::class, 'seeker_id', 'id');
    }
}
