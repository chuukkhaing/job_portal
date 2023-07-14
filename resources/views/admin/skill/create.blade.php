@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Seeker Attribute</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Skill Create</h6>
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
            <form action="{{ route('skill.store') }}" method="post" enctype="multipart/form-data">
                @csrf 
                <div class="form-group">
                    <label for="main_functional_area_id">Choose Main Functional Area <span class="text-danger">*</span></label>
                    <select name="main_functional_area_id" id="main_functional_area_id" class="select_2 form-control" required>
                        <option value=""></option>
                        @foreach($functional_areas as $functional_area)
                        <option value="{{ $functional_area->id }}">{{ $functional_area->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="skill_excel">Import Skill Excel</label><br>
                    <a href="{{url('/assets/sample/skill_simple_data_import_format.xlsx')}}" class="btn btn-info btn-sm mb-2"> <i class="fas fa-download"></i> Download Simple Excel Template </a>
                    <input type="file" name="skill_excel" id="skill_excel" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
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