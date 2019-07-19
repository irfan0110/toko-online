@extends('layouts.global')

@section('title')
    Edit Category
@endsection

@section('content')
    <div class="col-md-8">
        <h3>Edit Category</h3>
        <form action="{{route('categories.update', ['id' => $categories->id])}}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
            @csrf
            <input type="hidden" value="PUT" name="_method">

            <label for="name">Category Name</label>
            <input type="text" name="name" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}" value="{{ old('name') ? old('name') : $categories->name}}" id="name">
            <div class="invalid-feedback">
                {{$errors->first('name')}}
            </div>

            <label for="slug">Category Slug</label>
            <input type="text" name="slug" class="form-control {{$errors->first('slug') ? 'is-invalid' : ''}}" value="{{ old('slug') ? old('slug') : $categories->slug}}" id="slug">
            <div class="invalid-feedback">
                {{$errors->first('slug')}}
            </div>

            <label for="image">Category Image</label><br>
            @if($categories->image)
                <span>Current Image</span><br>
                <img src="{{ asset('public/storage/'. $categories->image) }}" width="120px"><br><br>
            @endif
            
            <input type="file" name="image" id="image" class="form-control">
            <small class="text-muted">Keep it blank if you don't want to change image</small><br>

            <input type="submit" class="btn btn-primary btn-sm float-right" value="Save">
            <br>
        </form>
    </div>
@endsection