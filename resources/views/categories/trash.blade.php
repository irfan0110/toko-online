@extends('layouts.global')

@section('title')
    Trashed Category
@endsection 

@section('content')
<div class="col-md-12">
        <h3>Trashed Category</h3>
        <br>
        <div class="row">
            <div class="col-md-6">
                <form action="{{route('categories.index')}}">
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" value="{{Request::get('name')}}" placeholder="Filter by name">
                        <div class="input-group-append">
                            <input type="submit" value="Filter" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <a href="{{route('categories.index')}}" class="nav-link">Published</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('categories.trash')}}" class="nav-link active">Trash</a>
                    </li>
                </ul>
            </div>
        </div>
        <br>

        <table class="table table-bordered table-striped"> 
            <thead>
                <tr>
                    <th><b>Name</b></th>
                    <th><b>Slug</b></th>
                    <th><b>Image</b></th>
                    <th><b>Actions</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{$category->name}}</td>
                    <td>{{$category->slug}}</td>
                    <td>
                        @if($category->image)
                            <img src="{{asset('public/storage/'.$category->image)}}" width="70px">
                        @else 
                            No Image category
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('categories.restore', ['id' => $category->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-recycle" ></i> Restore</a>
                        <form action="{{ route('categories.delete-permanent',['id' => $category->id])}}" method="post" onsubmit="return confirm('Delete category permanently?')" class="d-inline">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        {{$categories->appends(Request::all())->links()}}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection