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
            <br>
            <div class="row">
                <div class="col-md-6">
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
                        <td></td>
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