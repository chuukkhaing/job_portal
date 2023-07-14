<div class="container" id="edit-profile-header">
    <div class="px-5 m-0 pb-0 pt-5">
        <div class="table-responsive">
            <table class="table border-0" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Job Title</th>
                        
                        <th># Apps</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobApplicants as $key => $jobApplicant)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td><a href="{{ route('jobpost-detail', $jobApplicant->slug) }}">{{ $jobApplicant->job_title }}</a></td>
                        
                        <td><a href="">{{ $jobApplicant->JobApply->count() }} CVs</a></td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
    
</script>
@endpush