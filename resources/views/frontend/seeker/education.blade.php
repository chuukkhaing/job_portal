<div class="p-5 pb-0">
    <h5>Education</h5>
    <div class="my-2 row">
        <table id="edu-table"></table>
    </div>
    <div class="my-2 row">
        <button type="button" class="btn profile-save-btn m-2 col-6" data-bs-toggle="modal" data-bs-target="#educationModal">
            <i class="fa-solid fa-plus"></i> Add Education
        </button>
    </div>
    <div class="modal fade" id="educationModal" tabindex="-1" aria-labelledby="educationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="educationModalLabel">Add Education Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="degree" class="seeker_label my-2">Degree <span class="text-danger">*</span></label><br>
                            <select name="degree" id="degree" class="form-control seeker_input">
                                <option value="">Choose...</option>
                                @foreach(config('seekerdegree') as $degree)
                                <option value="{{ $degree }}" >{{ $degree }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="major_subject" class="seeker_label my-2">Major Subject/Area of Study <span class="text-danger">*</span></label>
                            <input type="text" name="major_subject" id="major_subject" class="form-control seeker_input" placeholder="Major Subject" value="">
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="location" class="seeker_label my-2">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" id="location" class="form-control seeker_input" placeholder="Location" value="">
                        </div>
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="year" class="seeker_label my-2">Year <span class="text-danger">*</span></label>
                            <input type="text" name="year" id="year" class="form-control seeker_input" value="" placeholder="Year">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn profile-save-btn" id="save-edu">Save changes</button>
                </div>
                
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
    $(document).ready(function() {
        $("#save-edu").click(function() {
            $("#edu-form").submit(function() {
                var degree = $("#degree").val();
                console.log(degree)
            })
            
        })
    })
</script>
@endsection