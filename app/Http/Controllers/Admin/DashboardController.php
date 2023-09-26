<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Seeker\Seeker;
use App\Models\Employer\JobPost;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{
    public function index()
    {
        $employers  = Employer::whereNull('deleted_at')->whereIsActive(1)->whereNull('employer_id')->count();
        $seekers    = Seeker::whereNull('deleted_at')->whereIsActive(1)->count();
        $jobposts   = JobPost::whereIsActive(1)->whereStatus('Online')->count();
        $jobpostpending = JobPost::whereStatus('Pending')->count();
        $chart1_options = [
            'chart_title' => 'Seekers by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Seeker\Seeker',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'chart_color' => '28, 200, 138'
        ];

        $chart2_options = [
            'chart_title' => 'Employers by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Admin\Employer',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'line',
            'chart_color' => '78, 115, 223'
        ];
        $chart1 = new LaravelChart($chart1_options);
        $chart2 = new LaravelChart($chart2_options);
        return view ('admin.dashboard', compact('employers', 'seekers', 'jobposts', 'jobpostpending', 'chart1', 'chart2'));
    }
}
