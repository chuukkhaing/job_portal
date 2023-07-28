<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;
use App\Models\Seeker\JobApply;
use App\Models\Admin\PackageItem;

class PointRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }

    public function JobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id', 'id');
    }

    public function JobApply()
    {
        return $this->belongsTo(JobApply::class, 'job_apply_id', 'id');
    }

    public function PackageItem()
    {
        return $this->belongsTo(PackageItem::class, 'package_item_id', 'id');
    }
}
