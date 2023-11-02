<div class="row mb-3 reference_label @if($references->count() == 0) d-none @endif">
    <h6 class="resume-header">Reference</h6>
    @foreach($references as $reference)
    <div class="py-2 reference-resume-{{ $reference->id }}">
        <div class="row">
            <div class="col-1">
            <i class="py-2 fa-regular fa-circle" style="color: #0563C1"></i>
            </div>
            <div class="col">
            <span class="reference-name-{{$reference->id}} ref-header text-uppercase">{{ $reference->name }}</span> | <span class="text-uppercase ref-sub-header reference-position-{{$reference->id}}">{{ $reference->position }}</span> <br>
            <span class="reference-company-{{$reference->id}} ref-text text-uppercase">{{ $reference->company }}</span> <br>
            <span class="reference-contact-{{$reference->id}} ref-text">{{ $reference->contact }}</span>
            </div>
        </div>

    </div>
    @endforeach
</div>