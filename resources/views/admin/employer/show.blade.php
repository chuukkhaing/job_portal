@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Employers</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Employer Detail</h6>
            <div class="col">
                <a href="{{ route('employer.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <div class="table-responsice">
                <table class="table table-bordered">
                    <tr>
                        <td width="200px">Logo</td>
                        <td><img src="{{ asset('/storage/employer_logo'.'/'.$employer->logo) }}" alt="{{ $employer->name }}" class="img-fluid" width="200px"></td>
                    </tr>
                    
                    <tr>
                        <td width="200px">Name</td>
                        <td><strong>{{ $employer->name }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Email</td>
                        <td><strong>{{ $employer->email }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">CEO</td>
                        <td><strong>{{ $employer->ceo }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Industry</td>
                        <td><strong>{{ $employer->Industry->name }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Ownership Type</td>
                        <td><strong>{{ $employer->OwnershipType->name }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Type of Employer</td>
                        <td><strong>{{ $employer->type_of_employer }}</strong></td>
                    </tr>
                    
                    <tr>
                        <td width="200px">Package</td>
                        <td>
                            <strong>{{ $employer->Package->name ?? '-' }}</strong><br>
                            @if($employer->package_id)
                            <small>Package Start Date - <span class="text-success"> {{ date('d-m-Y', strtotime($employer->package_start_date)) }}</small> </span><br>
                            <small>Package Expired Date - <span class="text-danger"> {{ date('d-m-Y', strtotime($employer->package_end_date)) }}</small> </span>
                            @endif
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="200px">Description</td>
                        <td><strong>{!! $employer->description ?? '-' !!}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Address</td>
                        <td><strong>{{ $employer->address ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Number of Offices</td>
                        <td><strong>{{ $employer->no_of_offices ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Number of Employees</td>
                        <td><strong>{{ $employer->no_of_employees ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Website</td>
                        <td><strong>{{ $employer->website ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Established In</td>
                        <td><strong>{{ $employer->established_in ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Fax</td>
                        <td><strong>{{ $employer->fax ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Phone</td>
                        <td><strong>{{ $employer->Phone ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Facebook</td>
                        <td><strong>{{ $employer->facebook ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Twitter</td>
                        <td><strong>{{ $employer->twitter ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">LinkedIn</td>
                        <td><strong>{{ $employer->linkedin ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Instagram</td>
                        <td><strong>{{ $employer->instagram ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Youtube</td>
                        <td><strong>{{ $employer->youtube ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">State</td>
                        <td><strong>{{ $employer->State->name ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Township</td>
                        <td><strong>{{ $employer->Township->name ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Contact Person Name</td>
                        <td><strong>{{ $employer->contact_person_name ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Contact Person Phone</td>
                        <td><strong>{{ $employer->contact_person_phone ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Contact Person Email</td>
                        <td><strong>{{ $employer->contact_person_email ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Google Map</td>
                        <td><strong>{!! $employer->map ?? '-' !!}</strong></td>
                    </tr>
                    <tr>
                        <td width="200px">Status</td>
                        <td>@if($employer->is_active == 1)<span class="badge text-light bg-success">Active</span>@else <span class="badge text-light bg-danger">In-Active</span> @endif </td>
                    </tr>
                </table>
            </div>
            
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection