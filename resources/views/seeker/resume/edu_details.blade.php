<div class="row resume-section mb-3 education_label @if($educations->count() == 0) d-none @endif">
    <h6 class="text-white resume-header py-2">Education</h6>
    @foreach($educations as $education)
    <div class="row py-2 edu-resume-{{ $education->id }}">
        <div class="col-4 fw-bold">
            <span class="edu-from-{{ $education->id }}">{{ $education->from }}</span> - <span class="edu-to-{{ $education->id }}">@if($education->is_current == 1) Present @else {{ $education->to }} @endif</span>
        </div>
        <div class="col-8">
            <span class="edu-degree-{{ $education->id }} fw-bold">{{ $education->degree }} (<span class="edu-major_subject-{{ $education->id }}">{{ $education->major_subject }}</span>)</span><br>
            <span class="edu-location-{{ $education->id }} text-blue">{{ $education->location }}</span>
        </div>
    </div>
    @endforeach
</div>

