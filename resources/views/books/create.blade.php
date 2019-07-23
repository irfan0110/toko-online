@extends('layouts.global')

@section('title')
    Create Books
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h3>Create Books</h3><br>
            <form action="{{ route('books.store')}}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
                @csrf

                <label for="title">Book Title</label>
                <input type="text" name="title" class="form-control {{ $errors->first('title') ? 'is-invalid' : ''}}" placeholder="Book title"><br>

                <label for="cover">Book Cover</label>
                <input type="file" name="cover" class="form-control {{$errors->first('cover') ? 'is-invalid' : ''}}"><br>

                <label for="description">Description</label>
                <textarea name="description" class="form-control {{$errors->first('description') ? 'is-invalid' :''}}" placeholder="Give description about this book"></textarea><br>
                
                <label for="category">Book Category</label>
                <select name="categories[]" multiple id="categories" class="form-control"></select><br><br>

                <label for="stock">Stock</label>
                <input type="number" name="stock" class="form-control {{$errors->first('stock') ? 'is-invalid' : ''}}" min=0 value=0><br>

                <label for="author">Author</label>
                <input type="text" name="author" class="form-control {{ $errors->first('author') ? 'is-invalid' : ''}}" placeholder="Book Author"><br>

                <label for="publisher">Publisher</label>
                <input type="text" name="publisher" class="form-control {{$errors->first('publisher') ? 'is-invalid' : ''}}" placeholder="Book Publisher">

                <label for="price">Price</label>
                <input type="number" name="price" class="form-control {{$errors->first('price') ? 'is-invalid' : ''}}" placeholder="Book Price" min=0><br>

                <button class="btn btn-primary btn-sm" name="save_action" value="PUBLISH">Publish</button>
                <button class="btn btn-secondary btn-sm" name="save_action" value="DRAFt">Save As Draft</button>
                <br>
            </form>
            <br>
        </div>
    </div>
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
    </script>
@endsection