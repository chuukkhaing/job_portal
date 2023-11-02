<div class="row mb-3 education_label @if($educations->count() == 0) d-none @endif">
    <h6 class="resume-header">Education</h6>
    @foreach($educations as $education)
    <div class="row py-2 edu-resume-{{ $education->id }}">
        <div class="col-4 exp-date-range">
            <span class="edu-from-{{ $education->id }}">{{ $education->from }}</span> - <span class="edu-to-{{ $education->id }}">@if($education->is_current == 1) Present @else {{ $education->to }} @endif</span>
        </div>
        <div class="col-8 text-uppercase" style="border-left: 2px solid #0563C1;">
            <span class="edu-degree-{{ $education->id }} text-break exp-job-title">{{ $education->degree }} </span> | <span class="edu-school-{{ $education->id }} text-break exp-company">{{ $education->school }}</span> | <span class="edu-location-{{ $education->id }} text-break exp-company">{{ $education->location }}</span>
        </div>
    </div>
    @endforeach
</div>

