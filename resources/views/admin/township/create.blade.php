@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Locations</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">City Create</h6>
            <div class="col">
                <a href="{{ route('city.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('city.store') }}" method="post">
                @csrf 
                <div class="form-group">
                    <label for="state_id">Choose State or Region <span class="text-danger">*</span></label>
                    <select name="state_id" id="state_id" class="select_2 form-control" required>
                        <option value=""></option>
                        @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }} @if(isset($state->name)) ({{ $state->name }} ) @endif</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="state">City Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="state" placeholder="Enter city name" required value="{{ old('name') }}">
                </div>
                
                <div class="form-group">
                    <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                    <input type="radio" name="is_active" id="active" class="" value="1" checked required> <label for="active"> Active</label><br>
                    <input type="radio" name="is_active" id="in_active" class="" value="0"> <label for="in_active"> In Active</label>
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