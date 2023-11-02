<div class="row language_label @if($languages->count() == 0) d-none @endif">
    <h6 class="resume-header">Languages</h6>
    @foreach($languages as $language)
    <div class="row py-2 skill-list language-resume-{{ $language->id }}">
        <div class="col-6">
            <span class="language-name-{{$language->id}}">{{ $language->name }}</span>
        </div>
        <div class="col-6">
            <span class="language-level-{{$language->id}}">{{ $language->level }}</span>
        </div>
    </div>
    @endforeach
</div>
