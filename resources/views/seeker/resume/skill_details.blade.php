<div class="row skill_label @if($skills->count() == 0) d-none @endif">
    <h6 class="resume-header">Skill</h6>
    
    <div class="row py-2" id="skill_body">
        @foreach($skills as $skill)
        <div class="row col-6 py-2 skill-list skill-resume-{{ $skill->id }} skill-skill_id-{{$skill->id}}">
            <div class="col-1"><i class="fa-regular fa-circle" style="color: #0563C1"></i></div>
            <div class="col"><span class="">{{ $skill->Skill->name }}</span></div>
        </div>
        @endforeach
    </div>
</div>

