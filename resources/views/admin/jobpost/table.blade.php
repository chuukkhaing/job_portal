@if(isset($data))
<table class="table table-bordered" id="" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>No.</th>
            <th>Job Title</th>
            <th>Employer Name</th>
            <th>Industry</th>
            <th>Main Functional Area</th>
            <th>Activation</th>
            <th>Job Post Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($data->count() > 0)
        @foreach($data as $key => $row)
        <tr>
            <td>{{ $key +1 }}</td>
            <td>{{ $row->job_title }}</td>
            <td>
            @if(isset($row->Employer->MainEmployer)) 
                <a href="{{ route('employers.edit', $row->Employer->employer_id) }}" class="text-decoration-none text-black">{{ $row->Employer->MainEmployer->name }}</a>
                @if($row->Employer->MainEmployer->is_verified == 1) 
                    <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i>
                @endif
            @elseif(isset($row->Employer)) 
                <a href="{{ route('employers.edit', $row->Employer->id) }}" class="text-decoration-none text-black">{{ $row->Employer->name }}</a>
                @if($row->Employer->is_verified == 1)
                    <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i>
                @endif
            @endif
            </td>
            <td>{{ $row->Industry ? $row->Industry->name : '' }}</td>
            <td>{{ $row->MainFunctionalArea ? $row->MainFunctionalArea->name : '' }}</td>
            <td>{!! $row->is_active == 1 ? '<span class="badge text-light bg-success">Active</span>' : '<span class="badge text-light bg-danger">In-Active</span>' !!}</td>
            <td>
            @if($row->status == 'Pending') 
                <span class="badge text-light bg-secondary">{{ $row->status }}</span>
            @elseif($row->status == 'Online')
                <span class="badge text-light bg-success">{{ $row->status }}</span>
            @elseif($row->status == 'Reject')
                <span class="badge text-dark bg-warning">{{ $row->status }}</span>
            @elseif($row->status == 'Expire')
                <span class="badge text-light bg-danger">{{ $row->status }}</span>
            @elseif($row->status == 'Draft')
                <span class="badge text-light bg-dark">{{ $row->status }}</span>
            @endif
            </td>
            <td><a href="{{ route('job-posts.edit', $row->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="8" class="text-center">There is no items to show.</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="d-flex justify-content-end">
    {!! $data->appends(request()->all())->links('pagination::bootstrap-4') !!}
</div>
@endif