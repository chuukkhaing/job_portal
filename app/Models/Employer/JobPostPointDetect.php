<?php

namespace App\Models\Employer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employer\JobPost;
use App\Models\Admin\PointOrder;

class JobPostPointDetect extends Model
{
    use HasFactory;

    protected $guarded = [];

    function JobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id', 'id');
    }

    function PointOrder()
    {
        return $this->belongsTo(PointOrder::class, 'point_order_id', 'id');
    }
}
