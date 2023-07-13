<div class="container" id="edit-profile-header">
    <div class="px-5 m-0 pb-0 pt-5">
        <div class="table-responsive">
            <table class="table border-0" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Job Name</th>
                        <th>Views</th>
                        <th># Apps</th>
                        <th>CV Views</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobApplicants as $key => $jobApplicant)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $jobApplicant->job_title }}</td>
                        <td></td>
                        <td>{{ $jobApplicant->JobApply->count() }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>