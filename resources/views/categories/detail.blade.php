@extends('layouts.global')
@section('title')
    Detail Categories
@endsection

@section('content')
    <div class="col-md-8">
        <h3>Detail Categories</h3>
        <div class="card">
            <div class="card-body">
                <label for="name"><b>Category Name</b></label><br>
                {{$category->name}}
                <br><br>

                <label for="slug"><b>Category Slug</b></label><br>
                {{$category->slug}}
                <br><br>

                <label for="image"><b>Category Image</b></label><br>
                @if($category->image)
                    <img src="{{asset('public/storage/'.$category->image)}}" width="120px">
                @endif
            </div>
        </div>
    </div>
@endsection