@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    @include('employer.profile.employer-sub-header')
    <div class="container-fluid mt-1 py-5" id="edit-profile-header">
        
        <div class="table-responsive">
            <table class="table table-hover table-borderless table-sm dataTable" width="100%" >
                <thead>
                    <tr>
                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">No.</th>
                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Employer</th>
                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Name</th>
                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Phone</th>
                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Point Package</th>
                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Status</th>
                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Ordered Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($orders as $key => $order)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><a href="{{ route('employers.edit', $order->Employer->id) }}" class="text-decoration-none text-black">{{ $order->Employer->name }}</a>@if($order->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</td>
                            <td>{{ $order->name }}</td>
                            <td><a href="tel:+{{ $order->phone }}" class="text-decoration-none text-black">{{ $order->phone }}</a></td>
                            <td>{{ $order->PointPackage->point }} Points - {{ $order->PointPackage->price }} MMK</td>
                            <td>
                                @if($order->status == 'Pending')
                                <span class="badge text-dark bg-warning">{{ $order->status }}</span>
                                @elseif($order->status == 'Approved')
                                <span class="badge text-light bg-success">{{ $order->status }}</span>
                                @elseif($order->status == 'Reject')
                                <span class="badge text-light bg-danger">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td class="text-black">{{ date('d M, Y', strtotime($order->created_at)) }}</td>
                        </tr>
                        @endforeach
                    </tr>
                    
                    
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