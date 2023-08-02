@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Manage User</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">User Create</h6>
            <div class="col">
                <a href="{{ route('users.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('users.update',$user->id) }}" method="post">
                @csrf 
                @method('PUT')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="">
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Enter Confirm Password" value="">
                </div>
                <div class="form-group">
                    <label for="role_id">Choose Role Name <span class="text-danger">*</span></label>
                    <select name="roles" id="role_id" class="select_2 form-control" required>
                        <option value=""></option>
                        @foreach($roles as $role)
                        <option value="{{ $role }}" @if($role == $userRole) selected @endif>{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                    <input type="radio" name="is_active" id="active" class="" value="1" @if($user->is_active == 1) checked required @endif> <label for="active"> Active</label><br>
                    <input type="radio" name="is_active" id="in_active" class="" value="0" @if($user->is_active == 0) checked required @endif> <label for="in_active"> In Active</label>
                </div>
                <button class="btn btn-primary btn-icon-split btn-sm" type="submit">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Save</span>
                </button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
@push('script')
<script>
    
</script>
@endpush