<div class="row mb-3 experience_label @if($experiences->count() == 0) d-none @endif">
    <h6 class="resume-header">Experience</h6>
    @foreach($experiences as $experience)
    
    <div class="row py-2 exp-resume-{{ $experience->id }}">
        @if($experience->is_experience == 0)
        <p>No Experience</p>
        @else
        <div class="col-4 exp-date-range">
            <span class="exp-start_date-{{$experience->id}}">{{ date('M Y', strtotime($experience->start_date)) }}</span> - 
            @if($experience->is_current_job == 1)
            <span class="exp-end_date-{{$experience->id}}">Present</span>
            @else
            <span class="exp-end_date-{{$experience->id}}">{{ date('M Y', strtotime($experience->end_date)) }}</span>
            @endif
        </div>
        <div class="col-8" style="border-left: 2px solid #0563C1;">
            <span class="exp-job_title-{{$experience->id}} text-uppercase text-break exp-job-title">{{ $experience->job_title }}</span> | 
            <span class="exp-company-{{$experience->id}} text-uppercase text-break exp-company">{{ $experience->company }}</span><br>
            <span class="exp-job-responsibility-{{$experience->id}} job-responsibility">{!! $experience->job_responsibility !!}</span>
        </div>
        @endif
    </div>

    @endforeach
</div>

