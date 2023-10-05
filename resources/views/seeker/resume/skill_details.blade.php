<div class="row resume-section mb-3 skill_label @if($skills->count() == 0) d-none @endif">
    <h6 class="text-white resume-header py-2">Skill</h6>
    
    <div class="row py-2" id="skill_body">
        @foreach($skills as $skill)
        <div class="col-6 py-2 fw-bold skill-resume-{{ $skill->id }} skill-skill_id-{{$skill->id}}">
            <i class="fa-solid fa-bookmark fa-rotate-by me-2" style="--fa-rotate-angle: 90deg; color: #0355D0"></i>
            <span class="">{{ $skill->Skill->name }}</span>
        </div>
        @endforeach
    </div>
</div>

