@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    <div class="row employer-dashboard-header m-0">
        <div class="col-2 p-3">
            <a href="{{ route('employer-profile.index') }}">
            @if($employer->logo)
            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Company Logo" class="employer-header-logo shadow-lg">
            @else
            <img src="{{ asset('img/icon/company.png') }}" alt="Company Logo" class="employer-header-logo shadow-lg">
            @endif
            </a>
        </div>
        <div class="col-10 p-3">
            <div class="mb-4">
                <h4 class="fw-bold d-inline-block">Upgrade Your Package</h4>
                <div class="float-end">
                    {{--<a href="http://" class="btn btn-outline-primary">Add-on Features</a>--}}
                    <a data-bs-toggle="modal" data-bs-target="#cardModal" class="btn profile-save-btn text-light">Package Details</a>
                </div>
            </div>
            <p>Our packing pricing design allows you to choose the right package that best fits your business needs. We offer a variety of options, each with different features, points, and pricing. Simply select the package that works best for you, and our team will take care of the rest.</p>
            <div class="row">
                <div class="col-4 p-1">
                    <div class="economy p-3" @if($employer->Package && $employer->Package->name == "Economy Package") style="border: 1px solid #0565FF" @endif>
                        Economy
                        @if($employer->Package && $employer->Package->name == "Economy Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
                <div class="col-4 p-1">
                    <div class="standard p-3" @if($employer->Package && $employer->Package->name == "Standard Package") style="border: 1px solid #C72C91" @endif>
                        Standard
                        @if($employer->Package && $employer->Package->name == "Standard Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
                <div class="col-4 p-1">
                    <div class="premium p-3" @if($employer->Package && $employer->Package->name == "Premium Package") style="border: 1px solid #F58220" @endif>
                        Premium
                        @if($employer->Package && $employer->Package->name == "Premium Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="px-xl-5 px-lg-3 px-0 ">
        <ul class="nav nav-tabs d-flex justify-content-between p-2 my-1" id="employerTab">
            @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','dashboard')->count() > 0))
            <li class="nav-item">
                <a href="{{ route('employer-profile.index') }}" class="employer-single-tab ">Dashboard</a>
            </li>
            @endif
            @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','profile')->count() > 0))
            <li class="nav-item">
                <a href="{{ route('employer-profile.edit', $employer->id) }}" class="employer-single-tab active">Profile</a>
            </li>
            @endif
            
            @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','manage_job')->count() > 0))
            <li class="nav-item">
                <a href="{{ route('manageJob') }}" class="employer-single-tab" >Manage Job</a>
            </li>
            @endif
            @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','application_tracking')->count() > 0))
            @foreach($packageItems as $packageItem)
            @if($packageItem->name == 'Application Management')
            <li class="nav-item">
                <a href="{{ route('applicantTracking') }}" class="employer-single-tab" >Applicant Tracking</a>
            </li>
            @endif
            @endforeach
            @endif
        </ul>
    </div>
    <hr style="border-bottom: 5px solid gray;">
    <div class="container-fluid mt-1 py-5" id="edit-profile-header">
        @foreach($packageItems as $packageItem)
        @if($packageItem->name == 'Up to 10 User Accounts' || $packageItem->name == 'Up to 5 User Accounts')
        <div class="row mb-4">
            <div class="col">
                <a href="{{ route('member-user.create') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add New</span>
                </a>
            </div>
        </div>
        @endif
        @endforeach
        <div class="table-responsive">
            <table class="table table-hover " id="dataTable">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Access</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $employer->email }}</td>
                        <td>@if($employer->is_active == 1)<span class="badge text-light bg-success">Active</span>@else <span class="badge text-light bg-danger">In-Active</span> @endif</td>
                        <td>{{ $employer->employer_id ? 'Member' : 'Admin' }}</td>
                        <td>
                            <a href="{{ route('member-user.edit', $employer->id) }}" class="text-black"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    @foreach($packageItems as $packageItem)
                    @if($packageItem->name == 'Up to 10 User Accounts' || $packageItem->name == 'Up to 5 User Accounts')
                    @foreach($members as $member)
                    <tr class="member-tr-{{ $member->id }}">
                        <td>{{ $member->email }}</td>
                        <td>@if($member->is_active == 1)<span class="badge text-light bg-success">Active</span>@else <span class="badge text-light bg-danger">In-Active</span> @endif</td>
                        <td>{{ $member->employer_id ? 'Member' : 'Admin' }}</td>
                        <td>@if($member->employer_id) 
                                <a href="{{ route('member-user.edit', $member->id) }}" class="text-black"><i class="fas fa-edit"></i></a>
                                <button class="delete-confirm text-black" type="submit" id="confirmation-{{ $member->id }}" value="{{ $member->id }}"><i class="fas fa-trash"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('css')
    <style>
        .modal-dialog {
            max-width: 80%;
        }
    </style>
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
        var show_success_modal = "{{ session()->pull('success') }}";
        if(show_success_modal != '') {
            MSalert.principal({
                icon:'success',
                title:'',
                description: show_success_modal,
            })
        }

        var show_error_modal = "{{ session()->pull('error') }}";
        if(show_error_modal != '') {
            MSalert.principal({
                icon:'error',
                title:'',
                description: show_error_modal,
            })
        }
    })
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.delete-confirm', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'DELETE',
                    data: {
                        "id": id
                    },
                    url: "member-user/"+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".member-tr-"+id).empty();
                        MSalert.principal({
                            icon:'success',
                            title:'',
                            description:response.msg,
                        });
                    }
                })
            }            
        })
    });
</script>
@endpush