@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Seeker Attribute</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Skill Edit</h6>
            <div class="col">
                <a href="{{ route('skill.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('skill.update', $skill->id) }}" method="post">
                @csrf 
                @method('PUT')
                <div class="form-group">
                    <label for="name">Skill Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter skill name" required value="{{ $skill->name }}">
                </div>
                <div class="form-group">
                    <label for="main_functional_area_id">Choose Main Functional Area <span class="text-danger">*</span></label>
                    <select name="main_functional_area_id" id="main_functional_area_id" class="select_2 form-control" required>
                        <option value=""></option>
                        @foreach($functional_areas as $functional_area)
                        <option value="{{ $functional_area->id }}" @if($functional_area->id == $skill->main_functional_area_id) selected @endif>{{ $functional_area->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                    <input type="radio" name="is_active" id="active" class="" value="1" @if($skill->is_active == 1) checked required @endif> <label for="active"> Active</label><br>
                    <input type="radio" name="is_active" id="in_active" class="" value="0" @if($skill->is_active == 0) checked required @endif> <label for="in_active"> In Active</label>
                </div>
                <button class="btn btn-primary btn-icon-split btn-sm" type="submit">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Update</span>
                </button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection