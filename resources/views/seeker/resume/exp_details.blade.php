<div class="row resume-section mb-3 experience_label @if($experiences->count() == 0) d-none @endif">
    <h6 class="text-white resume-header py-2">Career History</h6>
    @foreach($experiences as $experience)
    
    <div class="row py-2 exp-resume-{{ $experience->id }}">
        @if($experience->is_experience == 0)
        <p>No Experience</p>
        @else
        <div class="col-4 fw-bold">
            <span class="exp-start_date-{{$experience->id}}">{{ date('M Y', strtotime($experience->start_date)) }}</span> - 
            @if($experience->is_current_job == 1)
            <span class="exp-end_date-{{$experience->id}}">Present</span>
            @else
            <span class="exp-end_date-{{$experience->id}}">{{ date('M Y', strtotime($experience->end_date)) }}</span>
            @endif
        </div>
        <div class="col-8">
            <span class="exp-job_title-{{$experience->id}} fw-bold">{{ $experience->job_title }}</span><br>
            <span class="exp-company-{{$experience->id}} text-blue">{{ $experience->company }}</span><br>
            <span class="exp-job-responsibility-{{$experience->id}}">{!! $experience->job_responsibility !!}</span>
        </div>
        @endif
    </div>

    @endforeach
</div>

