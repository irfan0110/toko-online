@extends('layouts.global')
@section('title')
    Edit Book
@endsection

@section('content')
    <div class="col-md-8">
        <h3>Edit Book</h3>
        <form action="{{ route('books.update', ['id' => $book->id])}}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
            @csrf
            <input type="hidden" name="_method" value="PUT">

            <label for="title">Book Title</label>
            <input type="text" name="title" class="form-control {{$errors->first('title') ? 'is-invalid' : ''}}" id="title" value="{{old('title') ? old('title') : $book->title}}">
            <div class="invalid-feedback">
                {{$errors->first('title')}}
            </div>
            <br>

            <label for="cover">Book Cover</label><br>
            <small class="text-muted">Current Cover</small><br>
            @if($book->cover)
                <img src="{{asset('public/storage/'.$book->cover)}}" width="96px;">
            @endif
            <input type="file" name="cover" id="cover" class="form-control">
            <small class="text-muted">Keep it blank if you don't want to change cover</small>
            <br>

            <label for="slug">Slug</label>
            <input type="text" name="slug" class="form-control {{$errors->first('slug') ? 'is-invalid' : ''}}" id="slug" value="{{old('slug') ? old('slug') : $book->slug}}">
            <div class="invalid-feedback">
                {{$errors->first('slug')}}
            </div>
            <br>

            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control {{ $errors->first('description') ? 'is-invalid' : ''}}">{{ old('description') ? old('description') : $book->description}}</textarea>
            <div class="invalid-feedback">
                {{$errors->first('description')}}
            </div>
            <br>

            <label for="categories">Categories</label>
            <select name="categories[]" multiple id="categories" class="form-control"></select><br><br>

            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control {{$errors->first('stock') ? 'is-invalid' :''}}" min=0 value="{{ old('stock') ? old('stock') : $book->stock}}">
            <div class="invalid-feedback">
                {{$errors->first('stock')}}
            </div>
            <br>

            <label for="author">Author</label>
            <input type="text" name="author" id="author" class="form-control {{$errors->first('author')}}" value="{{ old('author') ? old('author') : $book->author}}">
            <div class="invalid-feedback">
                {{$errors->first('author')}}
            </div>
            <br>

            <label for="publisher">Publisher</label>
            <input type="text" name="publisher" id="publisher" class="form-control {{$errors->first('publisher')}}" value="{{ old('publisher') ? old('publisher') : $book->publisher}}">
            <div class="invalid-feedback">
                {{$errors->first('publisher')}}
            </div>
            <br>

            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control {{$errors->first('price')}}" min=0 value="{{ old('price') ? old('price') : $book->price}}">
            <div class="invalid-feedback">
                {{$errors->first('price')}}
            </div>
            <br>
            
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option {{$book->status == 'PUBLISH' ? 'selected' : ''}} value="PUBLISH">PUBLISH</option>
                <option {{$book->status == 'DRAFT' ? 'selected' : ''}} value="DRAFT">DRAFT</option>
            </select>
            <br>

            <button class="btn btn-primary btn-sm float-right" value="PUBLISH">Update</button>
            <br>
        </form>
    </div>
    <br>
@endsection

@section('footer-scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $('#categories').select2({
            ajax : {
                url : '{{ route('ajaxCategory.search')}}',
                processResults: function(data){
                    return {
                        results: data.map(function(item){return {id: item.id, text: item.name}})
                    }
                }
            }
        });

        var categories = {!! $book->categories !!}

        categories.forEach(function(category){
            var option = new Option(category.name, category.id, true, true);
            $('#categories').append(option).trigger('change');
        });
    </script>
@endsection