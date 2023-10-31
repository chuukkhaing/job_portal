@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    @include('employer.profile.employer-sub-header')
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
                                <button class="delete-confirm btn btn-sm text-black" type="submit" id="confirmation-{{ $member->id }}" value="{{ $member->id }}"><i class="fas fa-trash"></i></button>
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
    
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.delete-confirm', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'Warning',
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
                            title:'Success',
                            description:response.msg,
                        });
                    }
                })
            }            
        })
    });
</script>
@endpush