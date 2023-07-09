<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Package;
use App\Models\Admin\Industry;
use App\Models\Admin\OwnershipType;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'employer';
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

    public function Package()
    {
        return $this->belongsTo(Package::class);
    }

    public function Industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function OwnershipType()
    {
        return $this->belongsTo(OwnershipType::class);
    }

    public function State()
    {
        return $this->belongsTo(State::class);
    }

    public function Township()
    {
        return $this->belongsTo(Township::class);
    }
}
