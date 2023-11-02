<div class="row mb-3 language_label @if($languages->count() == 0) d-none @endif">
    <h6 class="resume-header">Languages</h6>
    @foreach($languages as $language)
    <div class="row skill-list language-resume-{{ $language->id }}">
        <div class="col-1"><i class="fa-regular fa-circle" style="color: #0563C1"></i></div>
        <div class="col-5">
            <span class="language-name-{{$language->id}}">{{ $language->name }}</span>
        </div>
        <div class="col-6">
            <span class="language-level-{{$language->id}}"> - {{ $language->level }}</span>
        </div>
    </div>
    @endforeach
</div>
