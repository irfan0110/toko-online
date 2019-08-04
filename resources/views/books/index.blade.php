@extends('layouts.global')
@section('title')
    Books List
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Books List</h3>
            @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('books.index')}}">
                        <div class="input-group">
                            <input type="text" name="keyword" value="{{Request::get('keyword')}}" class="form-control" placeholder="Filter by title and author">
                            <div class="input-group-append">
                                <input type="submit" value="filter" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <ul class="nav nav-pills card-header-pills">
                        <li class="nav-item">
                            <a href="{{ route('books.index')}}" class="nav-link {{Request::get('status') == null && Request::path() == 'books' ? 'active' : ''}}">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('books.index',['status' => 'publish'])}}" class="nav-link {{Request::get('status') == 'publish' ? 'active' : '' }}">Publish</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('books.index', ['status' => 'draft'])}}" class="nav-link {{Request::get('status') == 'draft' ? 'active' : ''}}">Draft</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('books.trash')}}" class="nav-link {{Request::path() == 'books/trash' ? 'active' : ''}}">Trash</a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-3">
            <div class="row mb-3">
                <div class="col-md-12 text-right">
                    <a href="{{ route('books.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create Books</a>                    
                </div>
            </div>
            <br>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><b>Cover</b></th>
                        <th><b>Title</b></th>
                        <th><b>Author</b></th>
                        <th><b>Status</b></th>
                        <th><b>Categories</b></th>
                        <th><b>Stock</b></th>
                        <th><b>Price</b></th>
                        <th><b>Actions</b></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>
                            @if($book->cover)
                                <img src="{{asset('public/storage/'. $book->cover)}}" width="120px">
                            @endif
                        </td>
                        <td>{{$book->title}}</td>
                        <td>{{$book->author}}</td>
                        <td>
                            @if($book->status == 'DRAFT')
                                <span class="badge badge-danger">{{$book->status}}</span>
                            @else 
                                <span class="badge badge-success">{{$book->status}}</span>
                            @endif
                        </td>
                        <td>
                            <ul class="pl-3">
                                @foreach($book->categories as $category)
                                    <li>{{$category->name}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{$book->stock}}</td>
                        <td>@currency($book->price)</td>
                        <td>
                            <a href="{{ route('books.edit', ['id' => $book->id])}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <form action="{{ route('books.destroy', ['id' => $book->id])}}" method="post" class="d-inline" onsubmit="return confirm('Move to trash?')">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
                @endforeach
                <tfoot>
                    <tr>
                        <td colspan="10">
                            {{$books->appends(Request::all())->links()}}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection