<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Package;
use App\Models\Admin\Industry;
use App\Models\Admin\OwnershipType;
use App\Models\Employer\EmployerAddress;
use App\Models\Employer\EmployerTestimonial;
use App\Models\Employer\EmployerMedia;
use App\Models\Employer\JobPost;
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

    public function EmployerAddress()
    {
        return $this->hasMany(EmployerAddress::class, 'employer_id', 'id');
    }

    public function EmployerTestimonial()
    {
        return $this->hasMany(EmployerTestimonial::class, 'employer_id', 'id');
    }

    public function EmployerMedia()
    {
        return $this->hasMany(EmployerMedia::class, 'employer_id', 'id');
    }

    public function JobPost()
    {
        return $this->hasMany(JobPost::class, 'employer_id', 'id');
    }
}
