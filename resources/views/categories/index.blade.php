@extends("layouts.global")

@section("title")
    Category List
@endsection

@section("content")
    <div class="col-md-12">
        <h3>Category List</h3>
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        <br>
        <div class="row">
            <div class="col-md-6">
                <a href="{{route('categories.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create Category</a>
            </div>
            <div class="col-md-4">
                <form action="{{route('categories.index')}}">
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" value="{{Request::get('name')}}" placeholder="Filter by name">
                        <div class="input-group-append">
                            <input type="submit" value="Filter" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <a href="{{route('categories.index')}}" class="nav-link active">Published</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('categories.trash')}}" class="nav-link">Trash</a>
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
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection