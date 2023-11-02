<div class="row reference_label @if($references->count() == 0) d-none @endif">
    <h6 class="resume-header">Reference</h6>
    @foreach($references as $reference)
    <div class="row py-2 reference-resume-{{ $reference->id }}">
        <span class="reference-name-{{$reference->id}} fw-bold">{{ $reference->name }}</span>
        <span class="reference-position-{{$reference->id}}">{{ $reference->position }}</span>
        <span class="reference-company-{{$reference->id}} text-blue">{{ $reference->company }}</span>
        <span class="reference-contact-{{$reference->id}}">{{ $reference->contact }}</span>
    </div>
    @endforeach
</div>